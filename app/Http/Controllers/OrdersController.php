<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\TrelloController;
use App\Models\Comment;
use App\Models\DesignGroup;
use App\Models\Order;
use App\Models\Setting;
use App\Models\TempUser;
use App\Models\TrelloCard;
use App\Models\TrelloList;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{
    protected $label_ids = [
        'external' => '5ac3b3a17566aef831377381',
        'internal' => '5ac3b38b88b3d5713fc4a8ee',
        'badge' => '58979ad58990c65a08ddae82',
        'shirt' => '58979add7feac84ca924de04',
        'jumper' => '58979add7feac84ca924de04'
    ];

    protected $allowed_extensions = [
        'jpg','jpeg','png','gif','svg'
    ];

    protected $order_types = [
        'badge' => 1,
        'shirt' => 2,
        'jumper' => 3
    ];

    public function create(Request $request)
    {
        return view('orders.new');
    }

    public function trelloCardDescription($name,$email,$time_limit,$count,$size,$font,$comment,$image)
    {
        return "
# Adatok

*Rendelésből kinyert:*

 - **Rendelő:** $name - $email
 - **Határidő:** $time_limit
 - **Darabszám:** $count
 - **Fullextrás betűtípus:** $font
 - **Megjegyzés:** $comment
 - **Kép:** $image

*Kitöltendő:*

 - **Öltésszám:** 
 - **Ár:** $count x {Darabár} = ...HUF
 - **Terv fájl helye:** 
 - **Felhasznált cérnák azonosítói:** 
 - **Felhasznált PTP neve:** 

---

# Leírás

$size cm oldalhosszúság

---

# Aktuális információk
";
    }

    public function trello(Order $order)
    {
        $curl = curl_init();

        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');
        $list = env('TRELLO_LIST');

        $labels = "";
        if($order->type==1){
            $labels .= $this->label_ids['badge'].',';
        }else{
            $labels .= $this->label_ids['shirt'].',';
        }

        if($order->internal==true){
            $labels .= $this->label_ids['internal'];
        }else{
            $labels .= $this->label_ids['external'];
        }

        $font = $order->font==null ? 'nincs' : $order->font;
        $comment = $order->comment == null ? 'nincs' : $order->comment;

        $image = route('orders.getImage', ['order' => $order]);

        $data = [
            'name' => $order->title,
            'desc' => $this->trelloCardDescription($order->user->name,$order->user->email,$order->time_limit,$order->count,$order->size,$font,$comment,$image),
            'pos' => 'top',
            'idList' => $list,
            'idLabels' => $labels
        ];

        $data = json_encode($data);

        $url = "https://api.trello.com/1/cards?key=$key&token=$token";

        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );

        $output = json_decode(curl_exec($curl));

        $this->trelloChecklist($output->id);

        curl_close($curl);

        return $output;
    }

    public function save(Request $request)
    {
        if(!$request->file('image') && !$request->input('existing')){
            return redirect()->back();
        }

        if(!$request->file('font') && !$request->input('existing')){
            return redirect()->back();
        }

        if(!$request->input('size') && !$request->input('existing')){
            return redirect()->back();
        }

        if(!$request->input('existing')){
            $file = $request->file('image');
            $extension = strtolower($file->getClientOriginalExtension());
            $size = $file->getSize()/1024/1024;

            $font = $request->file('font');
            $font_extension = strtolower($font->getClientOriginalExtension());
            $font_size = $font->getSize()/1024/1024;

            if($font_size>10 || $font_extension!="ttf"){
                return redirect()->back();
            }

            $new_font_name = 'fonts/uploads/' . time().$font->getClientOriginalName().'.'.$font_extension;
            Storage::disk()->put($new_font_name, File::get($font));


            if($size>10){
                return redirect()->back();
            }

            if(!in_array($extension,$this->allowed_extensions)){
                return redirect()->back();
            }

            $new_name = 'images/uploads/' . time().$request->input('name').'.'.$extension;

            Storage::disk()->put($new_name, File::get($file));

            $size = $request->input('size');
        }


        $title = $request->input('title');
        $count = $request->input('count');
        $time_limit = date("Y-m-d",strtotime($request->input('time_limit')));
        $type = $request->input('type');
        if(isset($new_font_name)){
            $font = $new_font_name;
        }else{
            $font = null;
        }
        if(!isset($size)){
            $size = null;
        }
        if(!isset($new_name)){
            $new_name = null;
        }

        $comment = $request->input('comment');

        $order = new Order();
        $order->title = $title;
        $order->count = $count;
        $order->status = 'arrived';
        $order->time_limit = $time_limit=="" ? null : $time_limit;
        if(array_key_exists($type, $this->order_types)){
            $order->type = $this->order_types[$type];
        }else{
            $order->type = 1;
        }
        if($request->input('public_albums')!=null){
            $order->public_albums=true;
        }else{
            $order->public_albums=false;
        }
        $order->original = $request->input('existing')==null;
        $order->internal = false;
        $order->size = $size;
        $order->font = $font=="" ? null : $font;
        $order->comment = $comment=="" ? null : $comment;
        $order->image = $new_name;
        $order->user_id = Auth::id();
        $order->save();

        EmailController::orderReceivedClient($order);

        EmailController::orderReceivedInternal($order);

        return redirect()->route('user.orders');
    }

    public function unapproved()
    {
        if(Auth::user()->role_id<2)
        {
            abort(403);
        }

        $orders = Order::where('approved_by',null)->get();

        return view('orders.unapproved',[
            'orders' => $orders
        ]);
    }

    public function email(Request $request, Order $order)
    {
        $message = $request->input('message');

        if($message!=''){
            EmailController::orderQuestion($order, $message);
        }
        return redirect()->back();
    }

    public function unarchive(Order $order)
    {
        if(Auth::user()->role_id<4){
            abort(401);
        }

        $order->archived = 0;
        $order->save();

        return redirect()->back();
    }

    public function help(Order $order)
    {
        $order->help = !$order->help;
        $order->save();

        return redirect()->back();
    }

    public function done(Order $order)
    {
        $order->status = "finished";
        $order->save();

        return redirect()->back();
    }

    public function edit(Order $order, Request $request)
    {
        $size = $request->input('size');
        $count = $request->input('count');
        $status = $request->input('status');

        $dst = $order->getDST();

        if($status){
            if(($dst!=null && $dst->colors->count()!=0 && $dst->background!=null && $order->assignedUsers->contains(Auth::user())) || Auth::user()->role_id>4){
                $order->status = $status;
            }
        }

        if($order->original && !$size){
            abort(400);
        }
        if(!$count){
            abort(400);
        }

        $order->size = $size;
        $order->count = $count;

        $order->save();

        return redirect()->back();
    }

    public function approve(Order $order, $internal)
    {
        if(Auth::user()->role_id<2)
        {
            abort(403);
        }

        $order->internal = $internal;
        $order->save();

        EmailController::orderApprovedClient($order);
        EmailController::orderApprovedInternal($order, Auth::user());


        $card = $this->trello($order);

        $trello_card = new TrelloCard();
        $trello_card->trello_id = $card->id;
        $trello_card->desc = $card->desc;
        $trello_card->name = $card->name;
        $trello_card->idLabels = implode(',',$card->idLabels);
        $trello_card->list_id = 1;
        $trello_card->save();

        $order->trello_card = $trello_card->id;
        $order->approved_by = Auth::id();
        $order->status = 'approved';
        $order->save();


        return redirect()->back();
    }

    public function getImage(Order $order)
    {
        $path = $order->image;
        return response()->file(storage_path("app/" . $path));
    }

    public function trelloChecklist($card)
    {
        $curl = curl_init();

        $key = env('TRELLO_ID');
        $token = env('TRELLO_KEY');

        $data = [
            'idCard' => $card,
            'name' => 'Teendők',
            'pos' => 'bottom',
            'idChecklistSource' => '5da4934464eda41a074e64f5'
        ];


        $url = "https://api.trello.com/1/checklists?idCard=$card&key=$key&token=$token";

        curl_setopt($curl, CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST,true);
        curl_setopt($curl, CURLOPT_POSTFIELDS,$data);

        $output = json_decode(curl_exec($curl));
    }

    public function updateTrello()
    {
        $lists = TrelloList::all()->where('id','<','5');

        foreach($lists as $list)
        {
            TrelloController::updateCards($list);
        }

        $cards = TrelloCard::all();

        foreach($cards as $card){
            $card->order->updateStatus();
        }

        return redirect()->back();
    }

    public function active()
    {
        $cards = TrelloCard::all()
//            ->where('status','NOT LIKE','%fizetve%')
//            ->where('status','NOT LIKE','%Fizetve%')
            ->where('list_id','<','5')
            ->sortByDesc('id')
            ->all();

        $orders = Order::where('archived',false)->get()->sortByDesc('id');

        return view('orders.active', ['orders' => $orders]);
    }

    public function setUser(Request $request, Order $order)
    {
        if($order->user!=null || $order->tempUser != null){
            abort(403);
        }

        $email = $request->input('email');
        $name = $request->input('name');

        if(User::where('email',$email)->get()->count()!=0){
            $order->user_id = User::where('email',$email)->first()->id;
            $order->save();
        }else{
            $temp_user = new TempUser();
            $temp_user->name = $name;
            $temp_user->email = $email;
            $temp_user->save();

            $order->temp_user_id = $temp_user->id;
            $order->save();
        }

        return redirect()->back();

    }

    public function archive(Order $order)
    {
        $order->archived = true;
        $order->save();

        return redirect()->back();
    }

    public function delete(Request $request, Order $order)
    {
        if(Auth::user()->role_id<2)
        {
            abort(403);
        }

        $reason = $request->input('reason');
        if($reason==null){
            $reason = $request->input('reason_'.$order->id);
        }


        EmailController::orderDeletedClient($order, $reason);

        $order->delete();

        return redirect()->back();
    }

    public function fake()
    {
        return view('orders.fake');
    }
    public function saveFake(Request $request)
    {
        $image = $request->file('image');
        $font = $request->file('font');
        $existing = $request->input('existing');
        $size = $request->input('size');

        if($image==null && $existing == null){
            abort(400);
        }

        if($size==null && $existing == null){
            abort(400);
        }

        if($existing==null){
            $file = $request->file('image');
            $extension = strtolower($file->extension());
            $size = $file->getSize()/1024/1024;

            if($size>10){
                return redirect()->back();
            }

            if(!in_array($extension,$this->allowed_extensions)){
                return redirect()->back();
            }

            $new_name = 'images/uploads/' . time().$request->input('name').'.'.$file->extension();

            Storage::disk()->put($new_name, File::get($file));

            if($font){
                $font = $request->file('font');
                $font_extension = strtolower($font->getClientOriginalExtension());
                $font_size = $font->getSize()/1024/1024;

                if($font_size>10 || $font_extension!="ttf"){
                    return redirect()->back();
                }

                $new_font_name = 'fonts/uploads/' . time().$font->getClientOriginalName().'.'.$font_extension;
                Storage::disk()->put($new_font_name, File::get($font));
            }else{
                $new_font_name = null;
            }
        }else{
            $new_font_name = null;
            $new_name = null;
            $size = null;
        }


        if($request->input('user_id')){
            $user = User::find($request->input('user_id'));
            $temp_user = null;
        }elseif(User::where('email',$request->input('email'))->get()->count()<0){
            $user = User::where('email',$request->input('email'))->first()->id;
            $temp_user = null;
        }else{
            $user = null;
            $temp_user = new TempUser();
            $temp_user->email = $request->input('email');
            $temp_user->name = $request->input('name');
            $temp_user->save();

            $temp_user = $temp_user->id;
        }

        if($user!=null){
            $user = $user->id;
        }

        if($temp_user!=null){
            $temp_user = $temp_user->id;
        }

        $title = $request->input('title');
        $count = $request->input('count');
        $time_limit = date("Y-m-d",strtotime($request->input('time_limit')));
        $type = $request->input('order_type');
        $size = $request->input('size');
        $font = $new_font_name;
        $internal = $request->input('internal')=='internal';
        $comment = $request->input('comment');
        $order = new Order();
        $order->title = $title;
        $order->count = $count;
        $order->time_limit = $time_limit=="" ? null : $time_limit;
        if(array_key_exists($type, $this->order_types)){
            $order->type = $this->order_types[$type];
        }else{
            $order->type = 1;
        }
        $order->size = $size;
        $order->font = $font=="" ? null : $font;
        $order->internal = $internal;
        $order->comment = $comment=="" ? null : $comment;
        $order->image = $new_name;
        $order->user_id = $user;
        $order->status = 'approved';
        $order->temp_user_id = $temp_user;
        $order->approved_by = Auth::user()->id;
        $order->save();


        return redirect()->route('members.unassigned');
    }

    public function albums(Order $order)
    {
        $albums = $order->albums;

        $role = Auth::check() ? Auth::user()->role_id : 1;

        return view('orders.albums', [
            'role' => $role,
            'albums' => $albums,
            'order' => $order
        ]);
    }

    public function assign(Order $order)
    {
        if($order->assignedUsers->find(Auth::user()->id)!=null){
            $order->assignedUsers()->detach(Auth::user());
        }else{
            $order->assignedUsers()->save(Auth::user());
        }

        return redirect()->back();
    }

    public function order(Order $order)
    {
        if($order->tempUser!=null && $order->user==null){
            $user = User::all()->where('email',$order->tempUser->email)->first();

            if($user!=null){
                $order->user_id = $user->id;
                $order->temp_user_id = null;
                $order->save();
            }
        }

        $design = $order->design;

        if($design!=null){
            $dst = $design->designs;
            $out = null;
            foreach($dst as $des){
                if($des->extension()=='dst'){
                    $out = $des;
                }
            }
        }else{
            $out = null;
        }

        $order_types = [
            1 => 'Folt',
            2 => 'Pólóra hímzendő',
            3 => 'Pulcsira hímzendő'
        ];

        Carbon::setLocale('hu');

        $setting = Setting::all()->where('name','orders_group')->first()->setting;

        $groups = DesignGroup::all()->find($setting)->children;

        return view('orders.order',[
            'order' => $order,
            'order_types' => $order_types,
            'dst' => $out,
            'design_groups' => $groups
        ]);
    }

    public function getFont(Order $order)
    {
        $path = 'app/fonts/uploads/'.$order->font;
        return response()->download(storage_path($path));
    }

    public function comment(Request $request, Order $order)
    {
        $text = $request->input('comment');
        if(!$text){
            abort(400);
        }

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->order_id = $order->id;
        $comment->comment = $text;
        $comment->save();

        return redirect()->back();
    }

    public function joint(Order $order)
    {
        if(!Auth::check()){
            abort(403);
        }

        if(Auth::user()->role_id<5){
            abort(401);
        }

        $order->joint = !$order->joint;
        $order->save();

        return redirect()->back();
    }
}

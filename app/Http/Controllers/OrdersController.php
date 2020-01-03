<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\TrelloController;
use App\Models\Comment;
use App\Models\DesignGroup;
use App\Models\Email;
use App\Models\Gallery\Album;
use App\Models\Order\Group;
use App\Models\Order\Image;
use App\Models\Order\Order;
use App\Models\Setting;
use App\Models\TempUser;
use App\Models\TrelloCard;
use App\Models\TrelloList;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Str;

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

    public function save(Request $request, Group $group)
    {
        set_time_limit(300);
        $order = new Order();
        $order->title = $request->input('title');
        $order->count = $request->input('count');
        $order->order_group_id = $group->id;
        $order->size = $request->input('size');
        $order->existing_design = $request->input('existing')!=null;
        $order->comment = $request->input('comment');
        $order->type = $this->order_types[$request->input('type')];
        $order->save();

        $font = $request->file('font');


        if($font!=null && strtolower($font->getClientOriginalExtension())!="ttf"){
            $font = null;
        }


        if($font!=null){
            $new_name = $font->getClientOriginalName() . "." . time() . ".ttf";

            File::put(storage_path('app/fonts/') . $new_name, $font);
            $order->font = $new_name;
            $order->save();
        }
        if($request->input('existing')==null){
            $images = $request->file('image');
            foreach($images as $file){

                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize()/1024/1024;

                if($size>3){
                    continue;
                }

                if(!in_array($ext,$this->allowed_extensions)){
                    continue;
                }

                $image = new Image();
                $image->image = static::thumbnail($file);
                $image->order_id = $order->id;
                $image->save();
            }
        }

        return redirect()->route('orders.finished', ['group' => $group]);

    }

    public function finished(Group $group)
    {

        Carbon::setLocale('hu');

        $order_types = [
            '1' => 'Folt',
            '3' => 'Pulcsira hímzendő',
            '2' => 'Pólóra hímzendő'
        ];

        return view('orders.final', ['group' => $group, 'order_types' => $order_types]);
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

    public function unarchive(Group $order)
    {
        if(Auth::user()->role_id<4){
            abort(401);
        }

        $order->archived = 0;
        $order->save();

        return redirect()->back();
    }

    public function help(Group $order)
    {
        $order->help = !$order->help;
        $order->save();

        return redirect()->back();
    }

    public function deleteGroup(Group $group)
    {
        foreach($group->orders as $order){
            foreach($order->images as $image){
                File::delete(public_path('storage/images/real/').$image->image);
                File::delete(public_path('storage/images/thumbnails/').$image->image);
            }
        }

        $group->delete();

        return redirect()->route('index');
    }

    public function done(Order $order)
    {
        $order->status = 5;
        $order->save();

        return redirect()->back();
    }

    public function approve(Group $order, $internal)
    {
        if(Auth::user()->role_id<2)
        {
            abort(403);
        }

        $order->internal = $internal;
        $order->save();

        EmailController::orderApproved($order);

        $order->approved_by = Auth::id();
        $order->status = 1;
        $order->save();


        return redirect()->back();
    }

    public function getImage(Image $image)
    {
        $path = $image->image;
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

    public function archive(Group $order)
    {
        $order->archived = true;
        $order->save();

        foreach($order->assignedUsers as $user){
            EmailController::orderArchived($order, $user);
        }

        return redirect()->back();
    }

    public function delete(Request $request, Group $order)
    {
        if(Auth::user()->role_id<2)
        {
            abort(403);
        }

        $reason = $request->input('reason');
        if($reason==null){
            $reason = $request->input('reason_'.$order->id);
        }

        if($order->user!=null){
            $user = $order->user;
        }elseif($order->tempUser!=null){
            $user = $order->tempUser;
        }else{
            $user = null;
        }

        if($user!=null){
            $email = new Email();
            $email->automated = 1;
            $email->to = $user->email;
            $email->from = "himzobot@gmail.com";
            $email->message = "Rendelés törölve lett";
            $email->subject = "Rendelés törölve";
            $email->save();
        }

//        EmailController::orderDeletedClient($order, $reason);

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

    public function assign(Group $group)
    {
        if($group->assignedUsers->find(Auth::user()->id)!=null){
            $group->assignedUsers()->detach(Auth::user());
        }else{
            $group->assignedUsers()->save(Auth::user());
        }

        return redirect()->back();
    }

    public function order(Group $group, Order $order)
    {

        $dst = $order->getDST();
        $order_types = [
            1 => 'Folt',
            2 => 'Pólóra hímzendő',
            3 => 'Pulcsira hímzendő'
        ];

        $statuses = [
            0 => 'Beérkezett',
            1 => 'Tervezve',
            2 => 'Próbahímzés kész',
            3 => 'Hímezve',
            4 => 'Fizetve',
            5 => 'Átadva'
        ];

        if($dst==null){
            $allowed = array_slice($statuses,0,1);
        }elseif($dst!=null && $dst->colors->count()==0){
            $allowed = array_slice($statuses,0,2);
        }elseif($dst!=null && $dst->colors->count()!=0 && $order->testAlbum==null){
            $allowed = array_slice($statuses, 0, 2);
        }else{
            $allowed = $statuses;
        }

        return view('orders.order', [
            'group' => $group,
            'order' => $order,
            'dst' => $dst,
            'order_types' => $order_types,
            'statuses' => $statuses,
            'allowed_statuses' => $allowed
        ]);
    }

    public function changeETA(Request $request, Group $group)
    {
        $group->eta = $request->input('eta');
        $group->save();

        return redirect()->back();
    }

    public function editStatus(Request $request, Order $order)
    {
        $order->status = $request->input('status');
        $order->save();

        return redirect()->back();
    }

    public function group(Group $group)
    {
        if($group->tempUser!=null && $group->user==null){
            $user = User::all()->where('email',$group->tempUser->email)->first();

            if($user!=null){
                $group->user_id = $user->id;
                $group->temp_user_id = null;
                $group->save();
            }
        }

        $order_types = [
            1 => 'Folt',
            2 => 'Pólóra hímzendő',
            3 => 'Pulcsira hímzendő'
        ];

        $max_status = 6;
        if($group->orders()->count() == 0){
            $group->delete();
            return redirect()->back();
        }
        foreach($group->orders as $order)
        {
            if($order->status<$max_status)
            {
                $max_status = $order->status;
            }
        }

        $status_parse = [
            0 => 0,
            1 => 2,
            2 => 2,
            3 => 4,
            4 => 5
        ];

        $statuses = [
            0 => 'Elfogadásra vár',
            1 => 'Elfogadva',
            2 => 'Tervezve',
            3 => 'Hímezve',
            4 => 'Fizetve',
            5 => 'Kész'
        ];

        $statuses = array_slice($statuses,0,min($status_parse[$max_status]+1,5));

        Carbon::setLocale('hu');

        $setting = Setting::all()->where('name','orders_group')->first()->setting;

        $groups = DesignGroup::all()->find($setting)->children;

        return view('orders.group',[
            'order_types' => $order_types,
            'design_groups' => $groups,
            'group' => $group,
            'statuses' => $statuses
        ]);
    }

    public function getFont(Order $order)
    {
        $path = 'app/fonts/uploads/'.$order->font;
        return response()->download(storage_path($path));
    }

    public function comment(Request $request, Group $group)
    {
        $text = $request->input('comment');
        if(!$text){
            abort(400);
        }

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->order_group_id = $group->id;
        $comment->comment = $text;
        $comment->save();

        return redirect()->back();
    }

    public function joint(Group $group)
    {
        if(!Auth::check()){
            abort(403);
        }

        if(Auth::user()->role_id<5){
            abort(401);
        }

        $group->joint_project = !$group->joint_project;
        $group->save();

        return redirect()->back();
    }

    public function step2(Request $request, Group $group = null)
    {
        set_time_limit(300);
        if($request->input('form_type')=='first'){
            $title = $request->input('title');
            $time_limit = $request->input('time_limit');
            $comment = $request->input('comment');
            $public_albums = $request->input('public_albums');

            if($request->input('email')){
                $existing_user = User::where('email',$request->input('email'))->first();
                if($existing_user==null){
                    $user = new TempUser();
                    $user->name = $request->input('name');
                    $user->email = $request->input('email');
                    $user->save();
                }
            }else{
                $existing_user = null;
                $user = null;
            }

            $group = new Group();
            $group->title = $title;
            $group->time_limit = $time_limit;
            $group->comment = $comment;
            $group->public_albums = $public_albums!=null;
            if($existing_user!=null){
                $group->user_id = $existing_user->id;
            }elseif($user!=null){
                $group->temp_user_id = $user->id;
            }else{
                $group->user_id = Auth::id();
            }
            $group->save();
        }else{
            $order = new Order();
            $order->title = $request->input('title');
            $order->count = $request->input('count');
            $order->order_group_id = $group->id;
            $order->size = $request->input('size');
            $order->existing_design = $request->input('existing')!=null;
            $order->comment = $request->input('comment');
            $order->type = $this->order_types[$request->input('type')];
            $order->save();

            if($request->input('existing')==null){
                $images = $request->file('image');
                foreach($images as $file){

                    $ext = $file->getClientOriginalExtension();
                    $size = $file->getSize()/1024/1024;

                    if($size>3){
                        continue;
                    }

                    if(!in_array($ext,$this->allowed_extensions)){
                        continue;
                    }

                    $image = new Image();
                    $image->image = static::thumbnail($file);
                    $image->order_id = $order->id;
                    $image->save();
                }
            }

        }

        return redirect()->route('orders.new.step2', ['group' => $group]);
    }

    public function deleteStep2(Order $order)
    {
        foreach($order->images as $image)
        {
            File::delete([public_path('/storage/images/thumbnails/'). $image->image, public_path('/storage/images/real/'). $image->image]);
        }

        $order->delete();

        return redirect()->back();
    }

    private static function thumbnail(UploadedFile $file)
    {
        $image_name = time() . '.' . Str::random(5) . '.jpg';

        $destination_path = public_path('storage/images/thumbnails');
        $img = \Intervention\Image\Facades\Image::make($file->path());
        $img->resize(150,150, function($constraint){
            $constraint->aspectRatio();
        })->encode('jpg',90)->save($destination_path.'/'.$image_name);

        $destination_path = public_path('storage/images/real');
        $img = \Intervention\Image\Facades\Image::make($file->path());
        $img->resize(500,500, function($constraint){
            $constraint->aspectRatio();
        })->encode('jpg',90)->save($destination_path.'/'.$image_name);

        return $image_name;
    }

    public function newStep2(Group $group)
    {
        return view('orders.new_step_2', [
            'group' => $group
        ]);
    }

    public function existing(Order $order)
    {
        $order->existing_design = !$order->existing_design;
        $order->original = !$order->existing_design;
        $order->save();

        return redirect()->back();
    }

    public function changeStatus(Request $request, Group $group)
    {
        $max_status = 6;
        foreach($group->orders as $order)
        {
            if($order->status<$max_status)
            {
                $max_status = $order->status;
            }
        }

        $max_status += 2;

        if($request->status>$max_status){
            abort(419);
        }

        $group->status = $request->input('status');
        $group->save();

        return redirect()->back();
    }

    public function testImage(Request $request, Order $order)
    {

        if($order->getDST()==null || $order->getDST()->colors->count()==0){
            abort(401);
        }

        if($request->file('image')){
            $image = $request->file('image');

            $extension = strtolower($image->getClientOriginalExtension());
            $size = $image->getSize()/1024/1024;

            if(!in_array($extension,$this->allowed_extensions)){
                abort(400);
            }
            if($size>3){
                return redirect()->back();
            }

            $name = time().Str::random(2).'.'.$image->getClientOriginalExtension();

            $destination_path = public_path('/storage/images/thumbnails');
            $thumbnail = \Intervention\Image\Facades\Image::make($image->path());
            $thumbnail->resize(200,200,function($constraint){
                $constraint->aspectRatio();
            })->save($destination_path.'/'. $name);
            $destination_path = public_path('/storage/images/real');
            $img = \Intervention\Image\Facades\Image::make($image->path());
            $img->resize(1000,1000,function($constraint){
                $constraint->aspectRatio();
            })->save($destination_path.'/'.$name);

            $gallery = Setting::where('name','orders_gallery')->first()->setting;

            $album = new Album();
            $album->gallery_id = $gallery;
            $album->name = $order->title . " - Próbahímzés";
            $album->role_id = 2;
            $album->save();

            $image = new \App\Models\Gallery\Image();
            $image->album_id = $album->id;
            $image->image = $name;
            $image->title = $order->title . " - Próbahímzés";
            $image->description = "Próbahímzés";
            $image->user_id = Auth::id();
            $image->save();

            $order->test_album_id = $album->id;
            $order->status=2;
            $order->save();

        }

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DesignGroup;
use App\Models\Email;
use App\Models\Order\Group;
use App\Models\Order\Image;
use App\Models\Order\Order;
use App\Models\Setting;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderGroupController extends Controller
{
    protected $allowed_extensions = [
        'jpg','jpeg','png','gif','svg'
    ];

    protected $order_types = [
        'badge' => 1,
        'shirt' => 2,
        'jumper' => 3
    ];

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

    public function archive(Group $group)
    {
        $group->archived = true;
        $group->save();

        foreach($group->assignedUsers as $user){
            EmailController::orderarchived($group, $user);
        }

        return redirect()->back();
    }

    public function unarchive(Group $group)
    {
        if(Auth::user()->role_id<4){
            abort(401);
        }

        $group->archived = 0;
        $group->save();

        return redirect()->back();
    }

    public function done(Group $group)
    {
        $group->status = 5;
        $group->save();

        return redirect()->back();
    }

    public function help(Group $group)
    {
        $group->help = !$group->help;
        $group->save();

        return redirect()->back();
    }

    public function ETA(Request $request, Group $group)
    {
        $group->eta = $request->input('eta');
        $group->save();

        return redirect()->back();
    }

    public function spam(Group $group)
    {
        if($group->status<2) {
            $group->report_spam = 1;
            $group->reported_by = Auth::id();
            $group->save();
        }

        return redirect()->back();
    }

    public function notSpam(Group $group)
    {
        $group->report_spam = 0;
        $group->reported_by = null;
        $group->save();

        return redirect()->back();
    }

    public function deleteSpam(Group $group)
    {
        if(Auth::user()->role_id>4) {
            $group->delete();
        }

        return redirect()->route('members.index');
    }

    public function delete(Request $request, Group $group)
    {
        if(Auth::user()->role_id<2)
        {
            abort(403);
        }

        $reason = $request->input('reason');
        if($reason==null){
            $reason = $request->input('reason_'.$group->id);
        }

        if($group->user!=null){
            $user = $group->user;
        }elseif($group->tempUser!=null){
            $user = $group->tempUser;
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
            $email->to_name = $user->name;
            $email->from_name = "Pulcsi és Foltmékör";
            $email->save();
        }

//        EmailController::orderDeletedClient($group, $reason);

        $group->delete();

        return redirect()->back();
    }

    public function add(Group $group, Request $request)
    {
        $title = $request->input('title');
        $existing = $request->input('existing');
        $count = $request->input('count');
        $size = $request->input('size');
        $type = $request->input('type');
        $comment = $request->input('comment');

        if(!$title || !$count || !$type) {
            abort(400);
        }

        $order = new Order();
        $order->title = $title;
        $order->existing_design = $existing ? true : false;
        $order->count = $count;
        $order->size = $size;
        $order->type = $this->order_types[$type];
        $order->comment = $comment;
        $order->order_group_id = $group->id;
        $order->status = 0;
        $order->save();

        $group->status = 1;
        $group->save();

        if($request->input('existing')==null){
            $images = $request->file('image');
            if($images == null) {
                abort(400);
            }
            foreach($images as $file) {

                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize() / 1024 / 1024;

                if ($size > 3) {
                    continue;
                }

                if (!in_array($ext, $this->allowed_extensions)) {
                    continue;
                }

                $image = new Image();
                $image->image = NewOrderController::thumbnail($file);
                $image->order_id = $order->id;
                $image->save();
            }
        }

        return redirect()->back();
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

    public function assign(Group $group)
    {
        if($group->assignedUsers->find(Auth::user()->id)!=null){
            $group->assignedUsers()->detach(Auth::user());
        }else{
            $group->assignedUsers()->save(Auth::user());
        }

        return redirect()->back();
    }

    public function status(Request $request, Group $group)
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

        if($request->input('status')>$max_status){
            abort(418);
        }

        $group->status = $request->input('status');
        $group->save();

        return redirect()->back();
    }

    public function approve(Group $group, $internal)
    {
        if(Auth::user()->role_id<2)
        {
            abort(403);
        }

        $group->internal = $internal;
        $group->save();

        EmailController::orderApproved($group);

        $group->approved_by = Auth::id();
        $group->status = 1;
        $group->save();


        return redirect()->back();
    }

    public function view(Group $group)
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


        if(Auth::user()->role_id<=4) {
            $statuses = array_slice($statuses,0,min($status_parse[$max_status]+1,5));
        }

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
}

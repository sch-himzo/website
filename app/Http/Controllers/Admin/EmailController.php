<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Email;
use DB;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index()
    {
        return view('admin.emails.index');
    }

    public function unsent()
    {
        $emails = Email::where('sent_at',null)->where('send',1)->paginate(5);

        return view('admin.emails.unsent', [
            'emails' => $emails
        ]);
    }

    public function sent()
    {
        $emails = DB::table('emails')->orderBy('id','desc')->where('sent_at','!=',null)->paginate(5);

        return view('admin.emails.sent', [
            'emails' => $emails
        ]);
    }

    public function delete(Email $email)
    {
        $email->delete();

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::all();

        return view('faq.index', [
            'faqs' => $faqs
        ]);
    }

    public function create(Request $request)
    {
        $question = $request->input('question');
        $answer = $request->input('answer');

        if(in_array('',[$question,$answer])){
            abort(400);
        }

        $faq = new FAQ();
        $faq->question = $question;
        $faq->answer = $answer;
        $faq->save();

        return redirect()->back();
    }

    public function edit(Request $request, FAQ $faq)
    {
        $question = $request->input('question_'.$faq->id);
        $answer = $request->input('answer_'.$faq->id);

        if(in_array('',[$question,$answer])){
            abort(400);
        }

        $faq->question = $question;
        $faq->answer = $answer;
        $faq->save();

        return redirect()->back();
    }

    public function delete(FAQ $faq)
    {
        $faq->delete();

        return redirect()->back();
    }
}

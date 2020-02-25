<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = DB::table('news')->orderByDesc('created_at')->paginate(5);

        Carbon::setLocale('hu');

        return view('admin.news.index', [
            'news' => $news
        ]);
    }

    public function create()
    {
        return view('admin.news.new');
    }

    public function save(Request $request)
    {
        $content = $request->input('content');
        $title = $request->input('title');
        $role = $request->input('role');

        $news = new News();

        $news->content = $content;
        $news->title = $title;
        $news->role_id = $role==0 ? 1 : 2;
        $news->user_id = Auth::id();
        $news->save();

        return redirect()->route('admin.news.index');
    }

    public function push(Request $request, News $news)
    {
        $content = $request->input('content');
        $title = $request->input('title');
        $role = $request->input('role');

        $news->content = $content;
        $news->title = $title;
        $news->role_id = $role==0 ? 1 : 2;
        $news->save();

        return redirect()->route('admin.news.index');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', ['news' => $news]);
    }

    public function delete(News $news)
    {
        $news->delete();

        return redirect()->back();
    }
}

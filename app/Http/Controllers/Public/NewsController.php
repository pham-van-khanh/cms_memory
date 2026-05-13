<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Post;

class NewsController extends Controller
{
    public function index()
    {
        $posts = Post::published()->ofType('news')->ordered()->paginate(config('cms.per_page.public'));
        return view('public.news.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $post = Post::published()->ofType('news')->where('slug',$slug)->firstOrFail();
        $post->incrementViews();
        return view('public.news.show', compact('post'));
    }
}


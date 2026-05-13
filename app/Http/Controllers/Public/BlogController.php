<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Post, Category};

class BlogController extends Controller
{
    public function index()
    {
        $posts      = Post::published()->ofType('blog')->ordered()->with(['category','author'])->paginate(config('cms.per_page.public'));
        $categories = Category::forType('blog')->withCount('posts')->orderBy('name')->get();
        return view('public.blog.index', compact('posts','categories'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();
        $posts    = Post::published()->ofType('blog')->where('category_id',$category->id)
                        ->ordered()->with('author')->paginate(config('cms.per_page.public'));
        $categories = Category::forType('blog')->withCount('posts')->orderBy('name')->get();
        return view('public.blog.index', compact('posts','category','categories'));
    }

    public function show(string $slug)
    {
        $post    = Post::published()->ofType('blog')->where('slug',$slug)->with(['category','author'])->firstOrFail();
        $related = Post::published()->ofType('blog')->where('category_id',$post->category_id)->where('id','!=',$post->id)->limit(3)->get();
        $post->incrementViews();
        return view('public.blog.show', compact('post','related'));
    }
}


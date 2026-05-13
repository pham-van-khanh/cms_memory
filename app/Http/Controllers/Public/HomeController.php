<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\{Memory, Post};

class HomeController extends Controller
{
    public function index()
    {
        $memories = Memory::published()->ordered()->with('category')->limit(6)->get();
        $blogs    = Post::published()->ofType('blog')->ordered()->with('category')->limit(3)->get();
        $news     = Post::published()->ofType('news')->ordered()->limit(5)->get();
        return view('public.home', compact('memories','blogs','news'));
    }
}


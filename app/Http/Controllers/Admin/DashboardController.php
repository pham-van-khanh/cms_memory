<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Memory, Post, Category};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'memories'   => Memory::count(),
            'blog'       => Post::ofType('blog')->count(),
            'news'       => Post::ofType('news')->count(),
            'categories' => Category::count(),
            'published'  => Memory::published()->count() + Post::published()->count(),
            'draft'      => Memory::where('published',false)->count() + Post::where('published',false)->count(),
        ];
        $recentMemories = Memory::latest()->limit(5)->get();
        $recentPosts    = Post::latest()->limit(5)->with('author')->get();
        return view('admin.dashboard', compact('stats','recentMemories','recentPosts'));
    }
}


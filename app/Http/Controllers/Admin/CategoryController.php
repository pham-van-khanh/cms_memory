<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount(['memories','posts'])->orderBy('sort_order')->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }
    public function create()  { return view('admin.categories.create'); }
    public function edit(Category $category) { return view('admin.categories.edit', compact('category')); }

    public function store(Request $request)
    {
        Category::create($request->validate([
            'name'        => 'required|string|max:120',
            'slug'        => 'nullable|unique:categories,slug',
            'description' => 'nullable|string',
            'color'       => 'nullable|regex:/^#[0-9a-fA-F]{6}$/',
            'type'        => 'required|in:general,memory,blog,news',
            'sort_order'  => 'integer',
        ]));
        return redirect()->route('admin.categories.index')->with('success','✅ Đã tạo!');
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate([
            'name'        => 'required|string|max:120',
            'description' => 'nullable|string',
            'color'       => 'nullable|regex:/^#[0-9a-fA-F]{6}$/',
            'type'        => 'required|in:general,memory,blog,news',
            'sort_order'  => 'integer',
        ]));
        return back()->with('success','✅ Đã lưu!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success','🗑️ Đã xoá.');
    }
}


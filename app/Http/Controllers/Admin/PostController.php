<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Post, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    protected string $type        = 'blog';
    protected string $routePrefix = 'admin.blog';
    protected string $viewPrefix  = 'admin.blog';

    public function index()
    {
        $posts = Post::ofType($this->type)->with(['category','author'])->ordered()->paginate(config('cms.per_page.admin'));
        return view("{$this->viewPrefix}.index", compact('posts'));
    }

    public function create()
    {
        $categories = Category::forType($this->type)->orderBy('name')->get();
        return view("{$this->viewPrefix}.create", compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['type']    = $this->type;
        $data['user_id'] = auth()->id();
        $data['tags']    = $this->parseTags($request->tags);
        if ($data['published']) $data['published_at'] = now();
        if ($request->hasFile('cover_image'))
            $data['cover_image'] = $request->file('cover_image')->store("posts/{$this->type}",'public');
        $post = Post::create($data);
        return redirect()->route("{$this->routePrefix}.edit", $post)->with('success','✅ Đã tạo!');
    }

    public function edit(Post $post)
    {
        $categories = Category::forType($this->type)->orderBy('name')->get();
        return view("{$this->viewPrefix}.edit", compact('post','categories'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);
        $data['tags'] = $this->parseTags($request->tags);
        if ($data['published'] && !$post->published_at) $data['published_at'] = now();
        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($post->cover_image ?? '');
            $data['cover_image'] = $request->file('cover_image')->store("posts/{$this->type}",'public');
        }
        $post->update($data);
        return back()->with('success','✅ Đã lưu!');
    }

    public function destroy(Post $post)
    {
        Storage::disk('public')->delete($post->cover_image ?? '');
        $post->delete();
        return redirect()->route("{$this->routePrefix}.index")->with('success','🗑️ Đã xoá.');
    }

    public function togglePublish(Post $post)
    {
        $post->update(['published'=>!$post->published,'published_at'=>!$post->published ? now() : $post->published_at]);
        return back()->with('success', $post->published ? '✅ Publish.' : '⏸ Draft.');
    }

    protected function validated(Request $request, ?Post $post = null): array
    {
        $slug = 'nullable|unique:posts,slug'.($post ? ",{$post->id}" : '');
        return $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => $slug,
            'category_id' => 'nullable|exists:categories,id',
            'excerpt'     => 'nullable|string|max:500',
            'content'     => 'nullable|string',
            'cover_image' => 'nullable|image|max:'.config('cms.max_image_kb'),
            'tags'        => 'nullable|string',
            'published'   => 'boolean',
        ]);
    }

    protected function parseTags(?string $tags): array
    {
        if (!$tags) return [];
        return array_values(array_filter(array_map('trim', explode(',', $tags))));
    }
}


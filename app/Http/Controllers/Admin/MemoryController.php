<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Memory, Category};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Hash, Storage};

class MemoryController extends Controller
{
    public function index()
    {
        $memories = Memory::with('category')->withCount(['images','sections'])->ordered()
                          ->paginate(config('cms.per_page.admin'));
        return view('admin.memories.index', compact('memories'));
    }

    public function create()
    {
        $categories = Category::forType('memory')->orderBy('name')->get();
        $themes     = config('cms.memory_themes');
        return view('admin.memories.create', compact('categories','themes'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $this->handleFiles($data, $request);
        if (!empty($data['password'])) $data['password'] = Hash::make($data['password']);
        $memory = Memory::create($data);
        return redirect()->route('admin.memories.edit', $memory)->with('success','✅ Đã tạo kỷ niệm!');
    }

    public function edit(Memory $memory)
    {
        $memory->load(['sections','galleryImages','category']);
        $categories   = Category::forType('memory')->orderBy('name')->get();
        $themes       = config('cms.memory_themes');
        $sectionTypes = ['story'=>'Story Block','timeline'=>'Timeline Item','quote'=>'Quote','video'=>'Video'];
        return view('admin.memories.edit', compact('memory','categories','themes','sectionTypes'));
    }

    public function update(Request $request, Memory $memory)
    {
        $data = $this->validated($request, $memory);
        $this->handleFiles($data, $request, $memory);
        if (!empty($data['password'])) $data['password'] = Hash::make($data['password']);
        else unset($data['password']);
        $memory->update($data);
        return back()->with('success','✅ Đã lưu!');
    }

    public function destroy(Memory $memory)
    {
        collect([$memory->hero_image, $memory->background_music])->filter()->each(fn($p)=>Storage::disk('public')->delete($p));
        $memory->images->each(fn($i)=>Storage::disk('public')->delete($i->path));
        $memory->sections->each(fn($s)=>$s->image && Storage::disk('public')->delete($s->image));
        $memory->delete();
        return redirect()->route('admin.memories.index')->with('success','🗑️ Đã xoá.');
    }

    public function togglePublish(Memory $memory)
    {
        $memory->update(['published'=>!$memory->published]);
        return back()->with('success', $memory->published ? '✅ Đã publish.' : '⏸ Draft.');
    }

    private function validated(Request $request, ?Memory $memory = null): array
    {
        $slug = 'nullable|unique:memories,slug'.($memory ? ",{$memory->id}" : '');
        return $request->validate([
            'title'                => 'required|string|max:255',
            'slug'                 => $slug,
            'category_id'          => 'nullable|exists:categories,id',
            'description'          => 'nullable|string',
            'location'             => 'nullable|string|max:255',
            'memory_date'          => 'nullable|date',
            'opening_quote'        => 'nullable|string',
            'opening_quote_author' => 'nullable|string|max:120',
            'template'             => 'required|in:classic,scrapbook,film,minimal',
            'color_accent'         => 'nullable|regex:/^#[0-9a-fA-F]{6}$/',
            'password'             => 'nullable|string|min:4',
            'published'            => 'boolean',
            'sort_order'           => 'integer|min:0',
            'hero_image'           => 'nullable|image|max:'.config('cms.max_image_kb'),
            'background_music'     => 'nullable|mimes:mp3,ogg,wav,aac|max:'.config('cms.max_music_kb'),
        ]);
    }

    private function handleFiles(array &$data, Request $request, ?Memory $m = null): void
    {
        if ($request->hasFile('hero_image')) {
            Storage::disk('public')->delete($m?->hero_image ?? '');
            $data['hero_image'] = $request->file('hero_image')->store('memories/heroes','public');
        }
        if ($request->hasFile('background_music')) {
            Storage::disk('public')->delete($m?->background_music ?? '');
            $data['background_music'] = $request->file('background_music')->store('memories/music','public');
        }
    }
}


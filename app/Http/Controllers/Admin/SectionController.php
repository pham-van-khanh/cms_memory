<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Memory, MemorySection};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    private function rules(): array
    {
        return [
            'type'             => 'required|in:story,timeline,quote,video',
            'label'            => 'nullable|string|max:120',
            'heading'          => 'nullable|string|max:255',
            'content'          => 'nullable|string',
            'image'            => 'nullable|image|max:'.config('cms.max_image_kb'),
            'image_tag'        => 'nullable|string|max:80',
            'handwritten_note' => 'nullable|string|max:255',
            'image_right'      => 'boolean',
            'time_label'       => 'nullable|string|max:60',
            'video_url'        => 'nullable|url',
            'quote_author'     => 'nullable|string|max:120',
        ];
    }

    public function store(Request $request, Memory $memory)
    {
        $data = $request->validate($this->rules());
        $data['sort_order'] = ($memory->sections()->max('sort_order') ?? -1) + 1;
        if ($request->hasFile('image'))
            $data['image'] = $request->file('image')->store("memories/{$memory->id}/sections",'public');
        $memory->sections()->create($data);
        return back()->with('success','✅ Đã thêm section.');
    }

    public function update(Request $request, MemorySection $section)
    {
        $data = $request->validate($this->rules());
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($section->image ?? '');
            $data['image'] = $request->file('image')->store("memories/{$section->memory_id}/sections",'public');
        }
        $section->update($data);
        return back()->with('success','✅ Đã cập nhật section.');
    }

    public function destroy(MemorySection $section)
    {
        Storage::disk('public')->delete($section->image ?? '');
        $section->delete();
        return back()->with('success','🗑️ Đã xoá section.');
    }

    public function sort(Request $request, Memory $memory)
    {
        $request->validate(['order'=>'required|array']);
        foreach ($request->order as $i => $id)
            $memory->sections()->where('id',$id)->update(['sort_order'=>$i]);
        return response()->json(['success'=>true]);
    }
}


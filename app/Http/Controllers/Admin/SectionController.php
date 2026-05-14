<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Memory, MemorySection};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    private const MAX_BATCH_SECTIONS = 50;

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
        if ($request->has('sections')) {
            return $this->storeBatch($request, $memory);
        }

        $data = $request->validate($this->rules());
        $data['sort_order'] = ($memory->sections()->max('sort_order') ?? -1) + 1;
        if ($request->hasFile('image'))
            $data['image'] = $request->file('image')->store("memories/{$memory->id}/sections",'public');
        $memory->sections()->create($data);
        return back()->with('success','✅ Đã thêm section.');
    }

    private function storeBatch(Request $request, Memory $memory)
    {
        $validated = $request->validate([
            'sections' => 'required|array|min:1|max:'.self::MAX_BATCH_SECTIONS,
            'sections.*.type' => 'required|in:story,timeline,quote,video',
            'sections.*.label' => 'nullable|string|max:120',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.image' => 'nullable|image|max:'.config('cms.max_image_kb'),
            'sections.*.image_tag' => 'nullable|string|max:80',
            'sections.*.handwritten_note' => 'nullable|string|max:255',
            'sections.*.image_right' => 'nullable|boolean',
            'sections.*.time_label' => 'nullable|string|max:60',
            'sections.*.video_url' => 'nullable|url',
            'sections.*.quote_author' => 'nullable|string|max:120',
        ]);

        $startSort = ($memory->sections()->max('sort_order') ?? -1) + 1;
        foreach ($validated['sections'] as $index => $sectionData) {
            $imageKey = "sections.$index.image";
            if ($request->hasFile($imageKey)) {
                $sectionData['image'] = $request->file($imageKey)->store("memories/{$memory->id}/sections", 'public');
            }

            $sectionData['sort_order'] = $startSort + $index;
            $sectionData['image_right'] = (bool) ($sectionData['image_right'] ?? false);
            $memory->sections()->create($sectionData);
        }

        return back()->with('success', '✅ Đã thêm nhiều section thành công.');
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

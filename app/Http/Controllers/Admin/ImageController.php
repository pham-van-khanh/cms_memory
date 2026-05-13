<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Memory, MemoryImage};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function store(Request $request, Memory $memory)
    {
        $request->validate(['images.*'=>'required|image|max:'.config('cms.max_image_kb')]);
        $next = $memory->galleryImages()->max('sort_order') ?? -1;
        $uploaded = [];
        foreach ($request->file('images',[]) as $file) {
            $path = $file->store("memories/{$memory->id}/gallery",'public');
            $img  = $memory->images()->create(['path'=>$path,'type'=>'gallery','sort_order'=>++$next]);
            $uploaded[] = ['id'=>$img->id,'url'=>$img->url];
        }
        return $request->expectsJson()
            ? response()->json(['success'=>true,'images'=>$uploaded])
            : back()->with('success','✅ Đã upload '.count($uploaded).' ảnh.');
    }

    public function destroy(MemoryImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
        return request()->expectsJson()
            ? response()->json(['success'=>true])
            : back()->with('success','🗑️ Đã xoá ảnh.');
    }
}


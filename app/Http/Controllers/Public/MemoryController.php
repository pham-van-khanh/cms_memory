<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Memory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemoryController extends Controller
{
    public function show(string $slug)
    {
        $memory = Memory::where('slug',$slug)->published()
            ->with(['sections','galleryImages','category'])->firstOrFail();

        if ($memory->isProtected() && !session("memory_unlocked_{$memory->id}"))
            return redirect()->route('memory.unlock', $slug);

        $memory->incrementViews();
        return view($memory->getTemplateView(), compact('memory'));
    }

    public function showUnlock(string $slug)
    {
        $memory = Memory::where('slug',$slug)->published()->firstOrFail();
        if (!$memory->isProtected() || session("memory_unlocked_{$memory->id}"))
            return redirect()->route('memory.show', $slug);

        return view('public.memory-password', compact('memory'));
    }

    public function unlock(Request $request, string $slug)
    {
        $memory = Memory::where('slug',$slug)->published()->firstOrFail();
        $request->validate(['password'=>'required|string']);

        if (Hash::check($request->password, $memory->password)) {
            session(["memory_unlocked_{$memory->id}"=>true]);
            return redirect()->route('memory.show', $slug);
        }

        return back()->withErrors(['password'=>'Mật khẩu không đúng, thử lại nhé ♡']);
    }
}


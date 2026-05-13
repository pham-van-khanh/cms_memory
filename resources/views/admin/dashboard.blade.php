@extends('layouts.admin')

@section('page-title','Dashboard')

@section('content')
  <div class="space-y-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      @foreach($stats as $label => $value)
        <div class="bg-white rounded-2xl border border-stone-200 p-5 shadow-sm">
          <div class="text-xs tracking-widest uppercase text-stone-500">{{ $label }}</div>
          <div class="mt-3 text-3xl font-display text-stone-900">{{ $value }}</div>
        </div>
      @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
      <div class="bg-white rounded-2xl border border-stone-200 p-5">
        <div class="flex items-center justify-between">
          <h2 class="font-display text-xl text-stone-900">Recent Memories</h2>
        </div>
        <div class="mt-4 overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="text-left text-xs tracking-widest uppercase text-stone-500">
                <th class="py-2 px-2">Title</th>
                <th class="py-2 px-2">Template</th>
                <th class="py-2 px-2">Status</th>
                <th class="py-2 px-2">Views</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentMemories as $m)
                <tr class="border-t border-stone-100">
                  <td class="py-3 px-2">
                    <a href="{{ route('admin.memories.edit',$m) }}" class="text-rose-500 hover:underline">{{ $m->title }}</a>
                  </td>
                  <td class="py-3 px-2">{{ ucfirst($m->template) }}</td>
                  <td class="py-3 px-2">
                    @if($m->published)
                      <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs">Published</span>
                    @else
                      <span class="px-2 py-1 rounded-full bg-stone-50 text-stone-700 border border-stone-200 text-xs">Draft</span>
                    @endif
                  </td>
                  <td class="py-3 px-2">{{ $m->views }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="bg-white rounded-2xl border border-stone-200 p-5">
        <div class="flex items-center justify-between">
          <h2 class="font-display text-xl text-stone-900">Recent Posts</h2>
        </div>
        <div class="mt-4 overflow-x-auto">
          <table class="min-w-full text-sm">
            <thead>
              <tr class="text-left text-xs tracking-widest uppercase text-stone-500">
                <th class="py-2 px-2">Title</th>
                <th class="py-2 px-2">Type</th>
                <th class="py-2 px-2">Status</th>
                <th class="py-2 px-2">Views</th>
              </tr>
            </thead>
            <tbody>
              @foreach($recentPosts as $p)
                <tr class="border-t border-stone-100">
                  <td class="py-3 px-2">
                    @if($p->type === 'blog')
                      <a href="{{ route('admin.blog.edit',$p) }}" class="text-rose-500 hover:underline">{{ $p->title }}</a>
                    @else
                      <a href="{{ route('admin.news.edit',$p) }}" class="text-rose-500 hover:underline">{{ $p->title }}</a>
                    @endif
                  </td>
                  <td class="py-3 px-2">{{ ucfirst($p->type) }}</td>
                  <td class="py-3 px-2">
                    @if($p->published)
                      <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs">Published</span>
                    @else
                      <span class="px-2 py-1 rounded-full bg-stone-50 text-stone-700 border border-stone-200 text-xs">Draft</span>
                    @endif
                  </td>
                  <td class="py-3 px-2">{{ $p->views }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection


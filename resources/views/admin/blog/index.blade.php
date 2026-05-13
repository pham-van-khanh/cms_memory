@extends('layouts.admin')

@section('page-title','Blog')

@section('content')
  <div class="space-y-5">
    <div class="flex flex-wrap items-end justify-between gap-4">
      <div>
        <h2 class="font-display text-2xl text-stone-900">Blog</h2>
        <p class="text-sm text-stone-600 mt-1">Manage blog posts with categories, tags, and publication state.</p>
      </div>
      <a href="{{ route('admin.blog.create') }}"
         class="no-underline inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-xs tracking-widest uppercase transition">
        + New Blog Post
      </a>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 p-4">
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead>
            <tr class="text-left text-xs tracking-widest uppercase text-stone-500">
              <th class="py-2 px-2">Cover</th>
              <th class="py-2 px-2">Title</th>
              <th class="py-2 px-2">Category</th>
              <th class="py-2 px-2">Tags</th>
              <th class="py-2 px-2">Views</th>
              <th class="py-2 px-2">Status</th>
              <th class="py-2 px-2 text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($posts as $p)
              <tr class="border-t border-stone-100">
                <td class="py-3 px-2">
                  <img src="{{ $p->cover_url }}" alt="{{ $p->title }}" class="h-12 w-12 object-cover rounded-xl border border-stone-200">
                </td>
                <td class="py-3 px-2 font-medium text-stone-900">
                  <a href="{{ route('admin.blog.edit',$p) }}" class="text-rose-500 hover:underline">{{ $p->title }}</a>
                </td>
                <td class="py-3 px-2">{{ $p->category?->name ?? '-' }}</td>
                <td class="py-3 px-2">
                  @if(!empty($p->tags))
                    <div class="line-clamp-2 max-w-[14rem]">
                      {{ is_array($p->tags) ? implode(', ', $p->tags) : $p->tags }}
                    </div>
                  @else
                    -
                  @endif
                </td>
                <td class="py-3 px-2">{{ $p->views }}</td>
                <td class="py-3 px-2">
                  <form method="POST" action="{{ route('admin.blog.publish',$p) }}">
                    @csrf
                    @method('PATCH')
                    <button class="px-3 py-1 rounded-full text-xs border transition
                                   {{ $p->published ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-stone-50 text-stone-700 border-stone-200' }}">
                      {{ $p->published ? 'Published' : 'Draft' }}
                    </button>
                  </form>
                </td>
                <td class="py-3 px-2 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.blog.edit',$p) }}" class="text-xs px-3 py-1 rounded-xl border border-stone-200 hover:bg-stone-50 transition text-stone-700">
                      Edit
                    </a>
                    <form method="POST" action="{{ route('admin.blog.destroy',$p) }}" onsubmit="return confirm('Delete this post?')">
                      @csrf
                      @method('DELETE')
                      <button class="text-xs px-3 py-1 rounded-xl border border-red-200 text-red-700 hover:bg-red-50 transition">
                        Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $posts->withQueryString()->links() }}
      </div>
    </div>
  </div>
@endsection


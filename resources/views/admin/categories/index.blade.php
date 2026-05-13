@extends('layouts.admin')

@section('page-title','Categories')

@section('content')
  <div class="space-y-5">
    <div class="flex flex-wrap items-end justify-between gap-4">
      <div>
        <h2 class="font-display text-2xl text-stone-900">Categories</h2>
        <p class="text-sm text-stone-600 mt-1">Shared taxonomy for Memories, Blog, and News.</p>
      </div>
      <a href="{{ route('admin.categories.create') }}"
         class="no-underline inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-xs tracking-widest uppercase transition">
        + New Category
      </a>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 p-4 overflow-x-auto">
      <table class="min-w-full text-sm">
        <thead>
          <tr class="text-left text-xs tracking-widest uppercase text-stone-500">
            <th class="py-2 px-2">Color</th>
            <th class="py-2 px-2">Name</th>
            <th class="py-2 px-2">Slug</th>
            <th class="py-2 px-2">Type</th>
            <th class="py-2 px-2">Memories</th>
            <th class="py-2 px-2">Posts</th>
            <th class="py-2 px-2">Sort</th>
            <th class="py-2 px-2 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $c)
            <tr class="border-t border-stone-100">
              <td class="py-3 px-2">
                <span class="inline-block w-4 h-4 rounded-full border border-stone-200" style="background: {{ $c->color }}"></span>
              </td>
              <td class="py-3 px-2">
                <a href="{{ route('admin.categories.edit',$c) }}" class="text-rose-500 hover:underline">{{ $c->name }}</a>
              </td>
              <td class="py-3 px-2 text-stone-600">{{ $c->slug }}</td>
              <td class="py-3 px-2">
                @php
                  $type = $c->type;
                  $badge = match($type){
                    'memory' => 'bg-rose-50 border-rose-200 text-rose-700',
                    'blog' => 'bg-blue-50 border-blue-200 text-blue-700',
                    'news' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                    default => 'bg-stone-50 border-stone-200 text-stone-700',
                  };
                @endphp
                <span class="px-3 py-1 rounded-full border text-xs {{ $badge }}">
                  {{ ucfirst($type) }}
                </span>
              </td>
              <td class="py-3 px-2">
                <span class="px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-xs text-stone-700">{{ $c->memories_count ?? 0 }}</span>
              </td>
              <td class="py-3 px-2">
                <span class="px-3 py-1 rounded-full bg-stone-50 border border-stone-200 text-xs text-stone-700">{{ $c->posts_count ?? 0 }}</span>
              </td>
              <td class="py-3 px-2 text-stone-600">{{ $c->sort_order }}</td>
              <td class="py-3 px-2 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('admin.categories.edit',$c) }}" class="text-xs px-3 py-1 rounded-xl border border-stone-200 hover:bg-stone-50 transition text-stone-700">
                    Edit
                  </a>
                  <form method="POST" action="{{ route('admin.categories.destroy',$c) }}" onsubmit="return confirm('Delete this category?')">
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
      <div class="mt-4">
        {{ $categories->links() }}
      </div>
    </div>
  </div>
@endsection


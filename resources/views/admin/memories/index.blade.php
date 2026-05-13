@extends('layouts.admin')

@section('page-title','Memories')

@section('content')
  <div class="space-y-5">
    <div class="flex flex-wrap items-center justify-between gap-4">
      <div>
        <h2 class="font-display text-2xl text-stone-900">Memories</h2>
        <p class="text-sm text-stone-600 mt-1">Search, publish, and manage memory stories.</p>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('admin.memories.create') }}"
           class="no-underline inline-flex items-center gap-2 bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-xs tracking-widest uppercase transition">
          + New Memory
        </a>
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-stone-200 p-4">
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="relative w-full sm:w-96">
          <input id="memory-search"
                 type="text"
                 class="w-full rounded-xl border border-stone-200 bg-white px-4 py-2 text-sm"
                 placeholder="Search by title...">
        </div>
      </div>

      <div class="mt-4 overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead>
            <tr class="text-left text-xs tracking-widest uppercase text-stone-500">
              <th class="py-2 px-2">Title</th>
              <th class="py-2 px-2">Template</th>
              <th class="py-2 px-2">Category</th>
              <th class="py-2 px-2">Media</th>
              <th class="py-2 px-2">Sections</th>
              <th class="py-2 px-2">Published</th>
              <th class="py-2 px-2">Views</th>
              <th class="py-2 px-2 text-right">Actions</th>
            </tr>
          </thead>
          <tbody id="memory-tbody">
            @foreach($memories as $m)
              <tr class="border-t border-stone-100 memory-row" data-title="{{ strtolower($m->title) }}">
                <td class="py-3 px-2">
                  <a href="{{ route('admin.memories.edit',$m) }}" class="text-rose-500 hover:underline">
                    {{ $m->title }}
                  </a>
                </td>
                <td class="py-3 px-2">
                  @php
                    $t = strtolower($m->template);
                    $badge = match($t){
                      'classic' => 'bg-rose-50 border-rose-200 text-rose-700',
                      'scrapbook' => 'bg-amber-50 border-amber-200 text-amber-700',
                      'film' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                      default => 'bg-stone-50 border-stone-200 text-stone-700',
                    };
                  @endphp
                  <span class="px-3 py-1 rounded-full border text-xs {{ $badge }} border">
                    {{ ucfirst($m->template) }}
                  </span>
                </td>
                <td class="py-3 px-2">{{ $m->category?->name ?? '-' }}</td>
                <td class="py-3 px-2">{{ $m->images_count ?? 0 }}</td>
                <td class="py-3 px-2">{{ $m->sections_count ?? 0 }}</td>
                <td class="py-3 px-2">
                  <form method="POST" action="{{ route('admin.memories.publish',$m) }}">
                    @csrf
                    @method('PATCH')
                    <button class="px-3 py-1 rounded-full text-xs border transition
                                   {{ $m->published ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-stone-50 text-stone-700 border-stone-200' }}">
                      {{ $m->published ? 'Published' : 'Draft' }}
                    </button>
                  </form>
                </td>
                <td class="py-3 px-2">{{ $m->views }}</td>
                <td class="py-3 px-2 text-right">
                  <div class="flex items-center justify-end gap-2">
                    <a href="{{ route('admin.memories.edit',$m) }}" class="text-xs px-3 py-1 rounded-xl border border-stone-200 hover:bg-stone-50 transition text-stone-700">
                      Edit
                    </a>
                    <form method="POST" action="{{ route('admin.memories.destroy',$m) }}" onsubmit="return confirm('Delete this memory?')">
                      @csrf
                      @method('DELETE')
                      <button class="text-xs px-3 py-1 rounded-xl border border-red-200 hover:bg-red-50 transition text-red-700">
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
        {{ $memories->withQueryString()->links() }}
      </div>
    </div>
  </div>

  <script>
    (function(){
      const input = document.getElementById('memory-search');
      const rows = document.querySelectorAll('.memory-row');
      if(!input) return;
      input.addEventListener('input', ()=>{
        const q = (input.value || '').toLowerCase().trim();
        rows.forEach(row=>{
          const t = row.getAttribute('data-title') || '';
          row.style.display = t.includes(q) ? '' : 'none';
        });
      });
    })();
  </script>
@endsection


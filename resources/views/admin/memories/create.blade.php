@extends('layouts.admin')

@section('page-title','Create Memory')

@section('content')
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <h2 class="font-display text-2xl text-stone-900">Create Memory</h2>
      <p class="text-sm text-stone-600 mt-1">Fill in the story details, media, and theme.</p>

      <form class="mt-6 space-y-7" method="POST" action="{{ route('admin.memories.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- Basic info --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Basic Info</div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Title</label>
              <input type="text" name="title" value="{{ old('title') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
            </div>
            <div>
              <label class="text-sm text-stone-700">Slug</label>
              <input type="text" name="slug" value="{{ old('slug') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" placeholder="auto">
            </div>
          </div>

          <div>
            <label class="text-sm text-stone-700">Description</label>
            <input type="text" name="description" value="{{ old('description') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Location</label>
              <input type="text" name="location" value="{{ old('location') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
            <div>
              <label class="text-sm text-stone-700">Memory date</label>
              <input type="date" name="memory_date" value="{{ old('memory_date') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
          </div>

          <div>
            <label class="text-sm text-stone-700">Category</label>
            <select name="category_id" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
              <option value="">(none)</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Theme picker --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Theme Picker</div>

          <input type="hidden" name="template" value="{{ old('template','classic') }}" id="template-hidden">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($themes as $key => $label)
              @php $selected = old('template', $key === 'classic' ? 'classic' : '') === $key; @endphp
              <button type="button"
                      data-template="{{ $key }}"
                      class="theme-card text-left rounded-2xl border border-stone-200 p-4 hover:shadow transition {{ $selected ? 'ring-2 ring-rose-300 bg-rose-50/60' : 'bg-white' }}">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <div class="text-sm font-medium text-stone-900">{{ $label }}</div>
                    <div class="text-xs tracking-widest uppercase text-stone-500 mt-1">Preview</div>
                  </div>
                  <span class="text-2xl">{{ $key === 'classic' ? '♡' : ($key==='scrapbook' ? '✿' : ($key==='film' ? '●' : '◻')) }}</span>
                </div>
                <div class="mt-4 h-28 rounded-xl overflow-hidden border border-stone-200 bg-stone-50 flex items-center justify-center text-xs text-stone-500">
                  Theme: {{ ucfirst($key) }}
                </div>
                <div class="mt-3 flex items-center gap-2 text-xs text-stone-600">
                  <span class="w-2 h-2 rounded-full" style="background: {{ $key === 'classic' ? '#c9847a' : ($key==='scrapbook' ? '#c97a9e' : ($key==='film' ? '#d9c27a' : '#a0a0a0')) }};"></span>
                  Choose
                </div>
              </button>
            @endforeach
          </div>

          <div class="text-xs text-stone-500">
            Selected template: <span id="template-selected">{{ ucfirst(old('template','classic')) }}</span>
          </div>
        </div>

        {{-- Media --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Media & Quote</div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Hero Image</label>
              <input type="file" name="hero_image" accept="image/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
            </div>
            <div>
              <label class="text-sm text-stone-700">Background Music (mp3/ogg/wav/aac)</label>
              <input type="file" name="background_music" accept="audio/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
            </div>
          </div>

          <div>
            <label class="text-sm text-stone-700">Opening quote</label>
            <textarea name="opening_quote" rows="3" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">{{ old('opening_quote') }}</textarea>
          </div>
          <div>
            <label class="text-sm text-stone-700">Opening quote author</label>
            <input type="text" name="opening_quote_author" value="{{ old('opening_quote_author') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" maxlength="120">
          </div>
        </div>

        {{-- Privacy & publish --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Privacy & Publish</div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            <div>
              <label class="text-sm text-stone-700">Accent color (hex)</label>
              <input type="text" name="color_accent" value="{{ old('color_accent','#c9847a') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" placeholder="#c9847a">
            </div>
            <div>
              <label class="text-sm text-stone-700">Password (optional)</label>
              <input type="password" name="password" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" placeholder="min 4 chars">
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center gap-3">
              <input type="hidden" name="published" value="0">
              <input type="checkbox" name="published" value="1" id="published" class="h-4 w-4">
              <label for="published" class="text-sm text-stone-700">Published</label>
            </div>
            <div>
              <label class="text-sm text-stone-700">Sort order</label>
              <input type="number" name="sort_order" value="{{ old('sort_order',0) }}" min="0" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <button class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl text-xs tracking-widest uppercase transition">
            Create
          </button>
          <a href="{{ route('admin.memories.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition no-underline">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </div>

  <script>
    (function(){
      const hidden = document.getElementById('template-hidden');
      const selected = document.getElementById('template-selected');
      document.querySelectorAll('.theme-card').forEach(card=>{
        card.addEventListener('click', ()=>{
          const t = card.getAttribute('data-template');
          hidden.value = t;
          if(selected) selected.textContent = t.charAt(0).toUpperCase()+t.slice(1);
          document.querySelectorAll('.theme-card').forEach(c=>{
            c.classList.remove('ring-2','ring-rose-300','bg-rose-50/60');
            c.classList.add('bg-white');
          });
          card.classList.add('ring-2','ring-rose-300','bg-rose-50/60');
          card.classList.remove('bg-white');
        });
      });
    })();
  </script>
@endsection


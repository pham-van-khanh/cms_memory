@extends('layouts.admin')

@section('page-title','Edit Memory')

@section('content')
  <div class="max-w-5xl mx-auto space-y-6">
    {{-- Update memory --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <div class="flex items-start justify-between gap-4">
        <div>
          <h2 class="font-display text-2xl text-stone-900">Edit Memory</h2>
          <p class="text-sm text-stone-600 mt-1">Update info, media, theme and publish state.</p>
        </div>
        <div class="text-xs tracking-widest uppercase text-stone-500">
          ID: {{ $memory->id }}
        </div>
      </div>

      <form class="mt-6 space-y-7" method="POST" action="{{ route('admin.memories.update',$memory) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Basic info --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Basic Info</div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Title</label>
              <input type="text" name="title" value="{{ old('title',$memory->title) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
            </div>
            <div>
              <label class="text-sm text-stone-700">Slug</label>
              <input type="text" name="slug" value="{{ old('slug',$memory->slug) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
          </div>

          <div>
            <label class="text-sm text-stone-700">Description</label>
            <input type="text" name="description" value="{{ old('description',$memory->description) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Location</label>
              <input type="text" name="location" value="{{ old('location',$memory->location) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
            <div>
              <label class="text-sm text-stone-700">Memory date</label>
              <input type="date" name="memory_date" value="{{ old('memory_date',$memory->memory_date?->format('Y-m-d')) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
          </div>

          <div>
            <label class="text-sm text-stone-700">Category</label>
            <select name="category_id" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
              <option value="">(none)</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ (old('category_id',$memory->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
              @endforeach
            </select>
          </div>
        </div>

        {{-- Theme picker --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Theme Picker</div>

          <input type="hidden" name="template" value="{{ old('template',$memory->template) }}" id="template-hidden">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($themes as $key => $label)
              @php $selected = old('template',$memory->template) === $key; @endphp
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
              </button>
            @endforeach
          </div>

          <div class="text-xs text-stone-500">
            Selected template: <span id="template-selected">{{ ucfirst(old('template',$memory->template)) }}</span>
          </div>
        </div>

        {{-- Media --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Media & Quote</div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Hero Image</label>
              <input type="file" name="hero_image" accept="image/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
              @if($memory->hero_image)
                <div class="mt-3">
                  <img src="{{ $memory->hero_image_url }}" class="h-20 w-20 object-cover rounded-xl border border-stone-200" alt="Hero preview">
                </div>
              @endif
            </div>
            <div>
              <label class="text-sm text-stone-700">Background Music</label>
              <input type="file" name="background_music" accept="audio/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
              @if($memory->background_music)
                <div class="mt-3 text-xs text-stone-500">Current audio attached.</div>
              @endif
            </div>
          </div>

          <div>
            <label class="text-sm text-stone-700">Opening quote</label>
            <textarea name="opening_quote" rows="3" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">{{ old('opening_quote',$memory->opening_quote) }}</textarea>
          </div>
          <div>
            <label class="text-sm text-stone-700">Opening quote author</label>
            <input type="text" name="opening_quote_author" value="{{ old('opening_quote_author',$memory->opening_quote_author) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" maxlength="120">
          </div>
        </div>

        {{-- Privacy & publish --}}
        <div class="space-y-3">
          <div class="text-xs tracking-widest uppercase text-stone-500">Privacy & Publish</div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start">
            <div>
              <label class="text-sm text-stone-700">Accent color (hex)</label>
              <input type="text" name="color_accent" value="{{ old('color_accent',$memory->color_accent ?? '#c9847a') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" placeholder="#c9847a">
            </div>
            <div>
              <label class="text-sm text-stone-700">Password (leave blank to keep)</label>
              <input type="password" name="password" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" placeholder="min 4 chars">
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center gap-3">
              <input type="hidden" name="published" value="0">
              <input type="checkbox" name="published" value="1" id="published" class="h-4 w-4" {{ $memory->published ? 'checked' : '' }}>
              <label for="published" class="text-sm text-stone-700">Published</label>
            </div>
            <div>
              <label class="text-sm text-stone-700">Sort order</label>
              <input type="number" name="sort_order" value="{{ old('sort_order',$memory->sort_order) }}" min="0" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <button class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl text-xs tracking-widest uppercase transition">
            Save
          </button>
          <a href="{{ route('admin.memories.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition no-underline">
            Back
          </a>
        </div>
      </form>
    </div>

    {{-- Gallery uploader --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <div class="flex items-end justify-between gap-6">
        <div>
          <h3 class="font-display text-xl text-stone-900">Gallery Upload</h3>
          <p class="text-sm text-stone-600 mt-1">Add photos for the public gallery. Stored on `public` disk.</p>
        </div>
      </div>

      <form class="mt-5" method="POST" action="{{ route('admin.memories.images.store',$memory) }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple accept="image/*" class="w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
        <button class="mt-3 bg-stone-900 hover:bg-stone-800 text-white px-4 py-2 rounded-xl text-xs tracking-widest uppercase transition">
          Upload
        </button>
      </form>

      <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach($memory->galleryImages as $img)
          <div class="rounded-2xl border border-stone-200 overflow-hidden bg-stone-50">
            <img src="{{ $img->url }}" alt="{{ $img->caption ?? 'Gallery image' }}" class="w-full h-28 object-cover">
            <div class="p-3 flex items-center justify-between gap-3">
              <div class="text-xs text-stone-600 line-clamp-1" title="{{ $img->caption ?? '' }}">{{ $img->caption ?? 'Photo' }}</div>
              <form method="POST" action="{{ route('admin.images.destroy',$img) }}" onsubmit="return confirm('Delete this image?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-xs px-2 py-1 rounded-xl border border-red-200 text-red-700 hover:bg-red-50 transition">
                  Delete
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Sections manager --}}
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
          <h3 class="font-display text-xl text-stone-900">Sections Manager</h3>
          <p class="text-sm text-stone-600 mt-1">Add/edit/delete and reorder story blocks.</p>
        </div>
        <button type="button" id="sections-save"
                class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-xs tracking-widest uppercase transition">
          Save order
        </button>
      </div>

      <div id="sections-sort-container" class="mt-6 space-y-5">
        @foreach($memory->sections as $s)
          <div class="border border-stone-200 rounded-2xl p-4 bg-stone-50 section-item" data-section-id="{{ $s->id }}">
            <div class="flex items-start justify-between gap-4">
              <div>
                <div class="text-xs tracking-widest uppercase text-stone-500">{{ ucfirst($s->type) }}</div>
                <div class="mt-1 font-medium text-stone-900">
                  {{ $s->heading ?? $s->label ?? 'Untitled section' }}
                </div>
              </div>
              <div class="flex items-center gap-2">
                <button type="button" class="section-move-up text-xs px-3 py-1 rounded-xl border border-stone-200 hover:bg-white transition">↑</button>
                <button type="button" class="section-move-down text-xs px-3 py-1 rounded-xl border border-stone-200 hover:bg-white transition">↓</button>
                <form method="POST" action="{{ route('admin.sections.destroy',$s) }}" onsubmit="return confirm('Delete this section?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-xs px-3 py-1 rounded-xl border border-red-200 text-red-700 hover:bg-red-50 transition">
                    Delete
                  </button>
                </form>
              </div>
            </div>

            <details class="mt-4">
              <summary class="cursor-pointer text-sm text-stone-600 hover:text-rose-500 transition">Edit section</summary>
              <div class="mt-4">
                <form class="space-y-4" method="POST" action="{{ route('admin.sections.update',$s) }}" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label class="text-sm text-stone-700">Type</label>
                      <select name="type" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
                        @foreach(['story'=>'Story Block','timeline'=>'Timeline Item','quote'=>'Quote','video'=>'Video'] as $k=>$label)
                          <option value="{{ $k }}" {{ $s->type === $k ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div>
                      <label class="text-sm text-stone-700">Label</label>
                      <input type="text" name="label" value="{{ old('label',$s->label) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
                    </div>
                  </div>

                  <div>
                    <label class="text-sm text-stone-700">Heading (supports HTML <em>)</label>
                    <input type="text" name="heading" value="{{ old('heading',$s->heading) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
                  </div>

                  <div>
                    <label class="text-sm text-stone-700">Content (HTML)</label>
                    <textarea name="content" rows="4" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">{{ old('content',$s->content) }}</textarea>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label class="text-sm text-stone-700">Image (optional)</label>
                      <input type="file" name="image" accept="image/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
                      @if($s->image)
                        <div class="mt-3">
                          <img src="{{ $s->image_url }}" alt="Section image" class="h-20 w-20 object-cover rounded-xl border border-stone-200">
                        </div>
                      @endif
                    </div>
                    <div>
                      <label class="text-sm text-stone-700">Image tag / overlay</label>
                      <input type="text" name="image_tag" value="{{ old('image_tag',$s->image_tag) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
                      <div class="mt-3 flex items-center gap-3">
                        <input type="hidden" name="image_right" value="0">
                        <input type="checkbox" name="image_right" value="1" class="h-4 w-4" {{ $s->image_right ? 'checked' : '' }}>
                        <label class="text-sm text-stone-700">Image right</label>
                      </div>
                    </div>
                  </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                      <label class="text-sm text-stone-700">Handwritten note</label>
                      <input type="text" name="handwritten_note" value="{{ old('handwritten_note',$s->handwritten_note) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
                    </div>
                    <div>
                      <label class="text-sm text-stone-700">Time label (timeline)</label>
                      <input type="text" name="time_label" value="{{ old('time_label',$s->time_label) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
                      <label class="text-sm text-stone-700 mt-3 block">Video URL (video)</label>
                      <input type="url" name="video_url" value="{{ old('video_url',$s->video_url) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
                      <label class="text-sm text-stone-700 mt-3 block">Quote author (quote)</label>
                      <input type="text" name="quote_author" value="{{ old('quote_author',$s->quote_author) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
                    </div>
                  </div>

                  <div class="flex items-center gap-3">
                    <button class="bg-stone-900 hover:bg-stone-800 text-white px-4 py-2 rounded-xl text-xs tracking-widest uppercase transition">
                      Save changes
                    </button>
                  </div>
                </form>
              </div>
            </details>
          </div>
        @endforeach
      </div>

      <div class="mt-8 border-t border-stone-200 pt-6">
        <h4 class="font-display text-lg text-stone-900">Add new section</h4>

        <form class="mt-4 space-y-4" method="POST" action="{{ route('admin.memories.sections.store',$memory) }}" enctype="multipart/form-data">
          @csrf

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Type</label>
              <select name="type" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
                @foreach($sectionTypes as $k=>$label)
                  <option value="{{ $k }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="text-sm text-stone-700">Label</label>
              <input type="text" name="label" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
          </div>

          <div>
            <label class="text-sm text-stone-700">Heading (supports HTML <em>)</label>
            <input type="text" name="heading" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
          </div>

          <div>
            <label class="text-sm text-stone-700">Content (HTML)</label>
            <textarea name="content" rows="4" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm"></textarea>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Image (optional)</label>
              <input type="file" name="image" accept="image/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
            </div>
            <div>
              <label class="text-sm text-stone-700">Image tag / overlay</label>
              <input type="text" name="image_tag" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
              <div class="mt-3 flex items-center gap-3">
                <input type="hidden" name="image_right" value="0">
                <input type="checkbox" name="image_right" value="1" class="h-4 w-4">
                <label class="text-sm text-stone-700">Image right</label>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="text-sm text-stone-700">Handwritten note</label>
              <input type="text" name="handwritten_note" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
            <div>
              <label class="text-sm text-stone-700">Time label (timeline)</label>
              <input type="text" name="time_label" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
              <label class="text-sm text-stone-700 mt-3 block">Video URL (video)</label>
              <input type="url" name="video_url" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
              <label class="text-sm text-stone-700 mt-3 block">Quote author (quote)</label>
              <input type="text" name="quote_author" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            </div>
          </div>

          <div class="flex items-center gap-3">
            <button class="bg-rose-500 hover:bg-rose-600 text-white px-4 py-2 rounded-xl text-xs tracking-widest uppercase transition">
              Add section
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- Theme picker behavior --}}
  <script>
    (function(){
      const hidden = document.getElementById('template-hidden');
      const selected = document.getElementById('template-selected');
      if(!hidden) return;
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

  {{-- Reorder sections behavior --}}
  <script>
    (function(){
      const container = document.getElementById('sections-sort-container');
      if(!container) return;
      function swap(a,b){
        const aNext = a.nextElementSibling;
        const bNext = b.nextElementSibling;
        if(aNext === b){
          b.parentNode.insertBefore(b, a);
        } else if(bNext === a){
          a.parentNode.insertBefore(a, b);
        } else {
          const aParent = a.parentNode;
          const aClone = a.cloneNode(true);
          const bClone = b.cloneNode(true);
          aParent.replaceChild(bClone, a);
          aParent.replaceChild(aClone, bClone);
          // Cloning path is unreliable; avoid swaps outside adjacent.
        }
      }

      container.querySelectorAll('.section-move-up').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const item = btn.closest('.section-item');
          const prev = item.previousElementSibling;
          if(prev) prev.parentNode.insertBefore(item, prev);
        });
      });
      container.querySelectorAll('.section-move-down').forEach(btn=>{
        btn.addEventListener('click', ()=>{
          const item = btn.closest('.section-item');
          const next = item.nextElementSibling;
          if(next) next.parentNode.insertBefore(next, item);
        });
      });

      const saveBtn = document.getElementById('sections-save');
      if(!saveBtn) return;
      saveBtn.addEventListener('click', async ()=>{
        const order = Array.from(container.querySelectorAll('.section-item'))
          .map(el => el.getAttribute('data-section-id'))
          .filter(Boolean);

        const csrf = @json(csrf_token());
        const res = await fetch("{{ route('admin.memories.sections.sort',$memory) }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
          },
          body: JSON.stringify({order})
        });
        if(!res.ok){
          alert('Failed to save order.');
        }else{
          alert('Order saved.');
          location.reload();
        }
      });
    })();
  </script>
@endsection


@extends('layouts.app')

@section('content')
<div class="pt-24 bg-[#eef7ea] text-stone-800">
  <section class="max-w-6xl mx-auto px-6 py-12">
    <div class="rounded-[2rem] bg-white border border-emerald-100 p-8 md:p-12 shadow-sm">
      <p class="text-xs tracking-[0.25em] uppercase text-emerald-700">Garden Theme</p>
      <h1 class="mt-3 font-display text-4xl md:text-5xl">{{ $memory->title }}</h1>
      <div class="mt-6 grid md:grid-cols-5 gap-8 items-center">
        <img src="{{ $memory->hero_image_url }}" alt="{{ $memory->title }}" class="md:col-span-3 w-full h-80 object-cover rounded-3xl border border-emerald-100">
        <div class="md:col-span-2 space-y-3 text-sm">
          @if($memory->memory_date)<p><b>Date:</b> {{ $memory->memory_date->format('d M Y') }}</p>@endif
          @if($memory->location)<p><b>Location:</b> {{ $memory->location }}</p>@endif
          @if($memory->opening_quote)<blockquote class="italic text-emerald-800 border-l-4 border-emerald-300 pl-4">"{{ $memory->opening_quote }}"</blockquote>@endif
        </div>
      </div>
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-6 pb-10">
    @include('partials.lightbox', ['id'=>'garden-lb'])
    @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>($memory->color_accent ?: '#4d7c0f'), 'playerId'=>'garden-music'])
    <h2 class="font-script text-3xl text-emerald-900">Bloom Gallery</h2>
    <div class="mt-6 columns-2 md:columns-4 gap-4 [column-fill:_balance]">
      @foreach($memory->galleryImages as $img)
      <button type="button" class="mb-4 w-full overflow-hidden rounded-2xl border border-emerald-100 bg-white" data-lightbox-src="{{ $img->url }}" data-lightbox-caption="{{ $img->caption ?? $img->handwritten_caption ?? '' }}">
        <img src="{{ $img->url }}" class="w-full h-auto object-cover" alt="{{ $img->caption ?? 'Memory image' }}">
      </button>
      @endforeach
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-6 pb-20 space-y-6">
    @foreach($memory->sections as $s)
      <article class="rounded-3xl bg-white border border-emerald-100 p-7">
        @if($s->label)<p class="text-xs uppercase tracking-widest text-emerald-700">{{ $s->label }}</p>@endif
        @if($s->heading)<h3 class="mt-2 font-display text-3xl">{!! $s->heading !!}</h3>@endif
        @if($s->type==='video' && $s->video_url)
          <div class="mt-4 aspect-video rounded-2xl overflow-hidden"><iframe src="{{ $s->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe></div>
        @elseif($s->image)
          <img src="{{ $s->image_url }}" class="mt-4 rounded-2xl w-full max-h-96 object-cover" alt="{{ $s->image_tag ?? 'section image' }}">
        @endif
        @if($s->content)<div class="mt-4 prose prose-emerald max-w-none">{!! $s->content !!}</div>@endif
      </article>
    @endforeach
  </section>
</div>
@endsection
  <div class="pt-24 bg-[#f4f8f2]">
    {{-- Dried flower decorations (SVG) --}}
    <div aria-hidden="true" class="pointer-events-none absolute left-[-2rem] top-[8rem] w-40 opacity-50">
      <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M100 20c25 35 25 75 0 110-25-35-25-75 0-110Z" fill="#c97a9e" fill-opacity=".35"/>
        <path d="M60 45c40 15 60 45 60 90-45-5-75-35-60-90Z" fill="#c9847a" fill-opacity=".25"/>
        <path d="M140 45c-40 15-60 45-60 90 45-5 75-35 60-90Z" fill="#7a9ec9" fill-opacity=".18"/>
        <circle cx="100" cy="120" r="10" fill="#7ac97a" fill-opacity=".35"/>
      </svg>
    </div>

    <section class="relative max-w-7xl mx-auto px-8 py-14 md:py-18 overflow-hidden">
      {{-- Opening collage --}}
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
        <div class="relative">
          {{-- Tape strips --}}
          <div class="absolute -top-6 left-12 w-32 h-6 bg-emerald-200/70 rotate-[-18deg] rounded-md blur-[0.2px]"></div>
          <div class="absolute -right-10 top-6 w-28 h-6 bg-emerald-200/60 rotate-[12deg] rounded-md"></div>

          {{-- Polaroid hero --}}
          <div class="relative bg-white rounded-3xl shadow-2xl border border-stone-200 p-3 rotate-[-2deg]">
            <div class="bg-white/80 rounded-2xl overflow-hidden">
              <img src="{{ $memory->hero_image_url }}" alt="{{ $memory->title }}" class="w-full h-80 object-cover">
            </div>
            <div class="mt-3 text-center">
              <div class="font-hand text-stone-600 text-lg leading-tight">
                {{ $memory->category?->name ?? 'Memory' }}
              </div>
              <div class="text-xs tracking-widest uppercase text-stone-500 mt-1">
                {{ $memory->memory_date ? $memory->memory_date->format('d M Y') : '—' }}
              </div>
            </div>
          </div>

          {{-- Second polaroid (accent card) --}}
          <div class="absolute -bottom-8 -right-6 bg-white rounded-3xl shadow-lg border border-stone-200 p-3 rotate-[3deg]">
            <div class="w-40 h-40 bg-stone-100 overflow-hidden rounded-2xl">
              <img src="{{ $memory->galleryImages->first()?->url }}"
                   alt="Gallery preview"
                   class="w-full h-full object-cover">
            </div>
            <div class="mt-2 text-center">
              <div class="font-hand text-stone-600 text-base">
                {{ $memory->opening_quote_author ?? 'Someone special' }}
              </div>
            </div>
          </div>
        </div>

        <div class="relative">
          <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-stone-300 bg-white/60 backdrop-blur">
            <span class="text-emerald-600 text-lg">♡</span>
            <span class="text-xs tracking-widest uppercase text-stone-600">Garden Theme</span>
          </div>

          <h1 class="mt-6 font-display text-4xl md:text-5xl text-stone-900 leading-tight">
            {{ $memory->title }}
          </h1>

          @if(!empty($memory->opening_quote))
            <div class="mt-6 bg-white/65 border border-stone-200 rounded-3xl p-7 relative">
              {{-- Sticky paper effect --}}
              <div class="absolute -top-3 left-8 w-16 h-6 bg-emerald-200/60 rotate-[-10deg] rounded-md"></div>
              <p class="font-hand text-stone-700 text-2xl leading-relaxed">
                "{{ $memory->opening_quote }}"
              </p>
              @if(!empty($memory->opening_quote_author))
                <div class="mt-4 text-xs tracking-widest uppercase text-stone-500">
                  {{ $memory->opening_quote_author }}
                </div>
              @endif
            </div>
          @endif

          @if(!empty($memory->description))
            <p class="mt-5 text-stone-700 leading-relaxed">
              {{ $memory->description }}
            </p>
          @endif

          @if(!empty($memory->location))
            <div class="mt-5 inline-flex items-center gap-3 px-4 py-2 rounded-full border border-stone-300 bg-white/60">
              <span class="text-stone-600 text-sm">{{ $memory->location }}</span>
              <span class="inline-block w-2 h-2 rounded-full" style="background: {{ ($memory->color_accent ?: '#4d7c0f') }}"></span>
            </div>
          @endif
        </div>
      </div>
    </section>

    {{-- Gallery --}}
    <section class="max-w-7xl mx-auto px-8 pb-14">
      @include('partials.lightbox', ['id'=>'garden-lb'])
      @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>($memory->color_accent ?: '#4d7c0f'), 'playerId'=>'garden-music'])

      <div class="flex items-end justify-between gap-6">
        <div>
          <h2 class="font-script text-3xl text-stone-900">Polaroids</h2>
          <p class="text-xs tracking-widest uppercase text-stone-600 mt-1">Tap to remember</p>
        </div>
      </div>

      <div class="mt-8 grid grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($memory->galleryImages as $idx => $img)
          <button type="button"
                  class="relative bg-white rounded-3xl shadow-xl border border-stone-200 p-3
                         hover:-translate-y-1 transition duration-300
                         {{ $idx % 2 === 0 ? 'rotate-[-2deg]' : 'rotate-[2deg]' }}"
                  data-lightbox-src="{{ $img->url }}"
                  data-lightbox-caption="{{ $img->caption ?? $img->handwritten_caption ?? '' }}">
            <div class="w-full h-40 rounded-2xl overflow-hidden bg-stone-100">
              <img src="{{ $img->url }}" alt="{{ $img->caption ?? 'Memory image' }}" class="w-full h-full object-cover">
            </div>
            <div class="mt-2 text-center">
              <div class="font-hand text-stone-700 text-lg leading-tight line-clamp-1">
                {{ $img->caption ?? $img->handwritten_caption ?? ' ' }}
              </div>
            </div>
          </button>
        @endforeach
      </div>
    </section>

    {{-- Sections --}}
    <section class="max-w-7xl mx-auto px-8 pb-20">
      <div class="space-y-8">
        @foreach($memory->sections as $i => $s)
          @if($s->type === 'story')
            <div class="relative bg-white/65 border border-stone-200 rounded-3xl p-8 shadow-sm">
              <div class="absolute -top-4 left-8 w-24 h-8 bg-emerald-200/70 rotate-[-12deg] rounded-md"></div>
              <div class="flex flex-col md:flex-row gap-8 items-center">
                @if($s->image)
                  <div class="{{ $s->image_right ? 'md:order-last' : '' }} w-full md:w-1/2">
                    <div class="rounded-3xl bg-white border border-stone-200 p-2"
                         style="transform: rotate({{ $s->image_right ? '2deg' : '-2deg' }});">
                      <img src="{{ $s->image_url }}" alt="{{ $s->label ?? 'Story image' }}" class="w-full h-72 object-cover rounded-2xl">
                      @if($s->image_tag)
                        <div class="mt-3 text-center font-hand text-stone-700 text-lg">{{ $s->image_tag }}</div>
                      @endif
                    </div>
                  </div>
                @endif
                <div class="flex-1">
                  @if($s->label)
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-stone-200 bg-white/70">
                      <span class="inline-block w-2 h-2 rounded-full" style="background: {{ ($memory->color_accent ?: '#4d7c0f') }}"></span>
                      <span class="text-xs tracking-widest uppercase text-stone-600">{{ $s->label }}</span>
                    </div>
                  @endif
                  @if($s->heading)
                    <h3 class="mt-4 font-display text-3xl text-stone-900">{!! $s->heading !!}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-4 prose prose-stone max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-stone-600 text-lg">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'timeline')
            <div class="relative bg-white/55 border border-stone-200 rounded-3xl p-8 overflow-hidden">
              <div class="absolute -left-6 top-10 w-12 h-12 rounded-full bg-emerald-200/40"></div>
              <div class="flex gap-8">
                <div class="min-w-[7rem] text-right">
                  @if($s->time_label)
                    <div class="text-xs tracking-widest uppercase text-stone-600">{{ $s->time_label }}</div>
                  @endif
                  <div class="mt-4 w-10 h-10 rounded-full border border-stone-200 bg-white flex items-center justify-center text-emerald-600">♡</div>
                </div>
                <div class="flex-1">
                  @if($s->heading)
                    <div class="font-display text-2xl text-stone-900">{{ $s->heading }}</div>
                  @endif
                  @if($s->content)
                    <div class="mt-3 prose prose-stone max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-stone-600 text-lg">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'quote')
            <div class="bg-white/65 border border-stone-200 rounded-3xl p-10 text-center relative">
              <div class="absolute -top-3 right-10 w-28 h-7 bg-emerald-200/70 rotate-[8deg] rounded-md"></div>
              @if($s->heading)
                <h3 class="font-display text-3xl text-stone-900">{!! $s->heading !!}</h3>
              @endif
              @if($s->content)
                <p class="mt-6 font-hand text-stone-700 text-3xl leading-relaxed">“{!! $s->content !!}”</p>
              @endif
              @if($s->quote_author)
                <div class="mt-5 text-xs tracking-widest uppercase text-stone-500">— {{ $s->quote_author }}</div>
              @endif
              @if($s->handwritten_note)
                <p class="mt-4 font-hand italic text-stone-600 text-lg">{{ $s->handwritten_note }}</p>
              @endif
            </div>
          @elseif($s->type === 'video')
            <div class="bg-white/65 border border-stone-200 rounded-3xl p-8">
              @if($s->heading)
                <h3 class="font-display text-3xl text-stone-900">{{ $s->heading }}</h3>
              @endif
              @if($s->video_url)
                <div class="mt-6 aspect-video bg-stone-900 rounded-2xl overflow-hidden">
                  <iframe src="{{ $s->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>
              @endif
              @if($s->content)
                <div class="mt-4 prose prose-stone max-w-none">{!! $s->content !!}</div>
              @endif
            </div>
          @endif
        @endforeach
      </div>
    </section>
  </div>
@endsection


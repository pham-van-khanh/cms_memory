@extends('layouts.app')

@section('content')
  <div class="pt-24 bg-[#0e0c0b] text-stone-100">
    {{-- Film sprockets --}}
    <div class="w-full overflow-hidden">
      <div class="h-12 bg-[#0e0c0b] flex items-center justify-center gap-2 border-b border-yellow-500/10">
        @for($i=0;$i<20;$i++)
          <div class="w-4 h-4 rounded-full border border-yellow-500/25 bg-[#0e0c0b]"></div>
        @endfor
      </div>
      <div class="h-12 bg-[#0e0c0b] flex items-center justify-center gap-2 border-t border-yellow-500/10">
        @for($i=0;$i<20;$i++)
          <div class="w-4 h-4 rounded-full border border-yellow-500/25 bg-[#0e0c0b]"></div>
        @endfor
      </div>
    </div>

    <section class="relative overflow-hidden">
      <div class="absolute inset-0">
        <img src="{{ $memory->hero_image_url }}"
             alt="{{ $memory->title }}"
             class="w-full h-full object-cover opacity-80 grayscale saturate-0">
      </div>
      <div class="absolute inset-0 bg-gradient-to-t from-[#0e0c0b] via-[#0e0c0b]/60 to-transparent"></div>

      <div class="relative max-w-7xl mx-auto px-8 py-14 md:py-20">
        <div class="max-w-3xl">
          <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-yellow-500/15 bg-yellow-500/5">
            <span class="text-yellow-400 text-lg">{{ $memory->category?->icon ?? '♡' }}</span>
            <span class="text-xs tracking-widest uppercase text-stone-200/80">{{ $memory->category?->name ?? 'Memories' }}</span>
          </div>

          <h1 class="mt-6 font-display text-4xl md:text-6xl leading-[1.05] text-stone-100">
            {{ $memory->title }}
          </h1>

          @if(!empty($memory->opening_quote))
            <div class="mt-6 rounded-2xl border border-yellow-500/20 bg-yellow-500/5 p-6">
              <p class="text-stone-100/90 text-lg md:text-xl italic">
                "{{ $memory->opening_quote }}"
              </p>
              @if(!empty($memory->opening_quote_author))
                <p class="mt-3 text-xs tracking-widest uppercase text-stone-100/70">— {{ $memory->opening_quote_author }}</p>
              @endif
            </div>
          @endif

          <div class="mt-7 flex flex-wrap items-center gap-3">
            <span class="text-xs tracking-widest uppercase text-stone-100/70 bg-white/5 border border-white/10 px-4 py-2 rounded-full">
              Template: {{ ucfirst($memory->template) }}
            </span>
            @if($memory->memory_date)
              <span class="text-xs tracking-widest uppercase text-stone-100/70 bg-white/5 border border-white/10 px-4 py-2 rounded-full">
                {{ $memory->memory_date->format('d M Y') }}
              </span>
            @endif
            @if($memory->location)
              <span class="text-xs tracking-widest uppercase text-stone-100/70 bg-white/5 border border-white/10 px-4 py-2 rounded-full">
                {{ $memory->location }}
              </span>
            @endif
          </div>

          <div class="mt-8 text-xs tracking-widest uppercase text-yellow-300/80">
            Accent: <span style="color: {{ $memory->getAccentColor() }}">{{ $memory->getAccentColor() }}</span>
          </div>
        </div>
      </div>
    </section>

    {{-- Gallery --}}
    <section class="max-w-7xl mx-auto px-8 py-12">
      @include('partials.lightbox', ['id'=>'nostalgia-lb'])
      @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>$memory->getAccentColor(), 'playerId'=>'nostalgia-music'])

      <h2 class="font-script text-3xl text-yellow-300">Gallery</h2>
      <p class="mt-2 text-xs tracking-widest uppercase text-stone-200/60">Desaturated memories · click to open</p>

      <div class="mt-8 grid grid-cols-2 md:grid-cols-3 gap-5">
        @foreach($memory->galleryImages as $img)
          <button type="button"
                  class="relative bg-white/5 border border-white/10 rounded-2xl overflow-hidden shadow-sm hover:-translate-y-0.5 transition"
                  data-lightbox-src="{{ $img->url }}"
                  data-lightbox-caption="{{ $img->caption ?? $img->handwritten_caption ?? '' }}">
            <div class="h-40 md:h-44 bg-stone-900">
              <img src="{{ $img->url }}" alt="{{ $img->caption ?? 'Memory image' }}"
                   class="w-full h-full object-cover grayscale saturate-0">
            </div>
            @if($img->caption || $img->handwritten_caption)
              <div class="p-3 text-xs text-stone-200/70">
                {{ $img->caption ?? $img->handwritten_caption }}
              </div>
            @endif
          </button>
        @endforeach
      </div>
    </section>

    {{-- Sections --}}
    <section class="max-w-7xl mx-auto px-8 pb-20">
      <div class="space-y-10">
        @foreach($memory->sections as $i => $s)
          @if($s->type === 'story')
            <div class="rounded-3xl border border-yellow-500/15 bg-white/5 p-8">
              <div class="{{ $s->image_right ? 'md:flex-row-reverse' : 'md:flex-row' }} flex flex-col md:flex gap-8 items-center">
                @if($s->image)
                  <div class="w-full md:w-1/2">
                    <img src="{{ $s->image_url }}" alt="{{ $s->label ?? 'Story image' }}" class="w-full max-h-96 object-cover rounded-2xl grayscale saturate-0">
                  </div>
                @endif
                <div class="flex-1">
                  @if($s->label)
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-yellow-500/15 bg-white/5">
                      <span class="inline-block w-2 h-2 rounded-full" style="background: {{ $memory->getAccentColor() }}"></span>
                      <span class="text-xs tracking-widest uppercase text-stone-200/70">{{ $s->label }}</span>
                    </div>
                  @endif
                  @if($s->heading)
                    <h3 class="mt-4 font-display text-3xl text-stone-100 leading-tight">{!! $s->heading !!}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-4 prose prose-invert max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-stone-200/80 text-sm">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'timeline')
            <div class="rounded-3xl border border-yellow-500/15 bg-white/5 p-8">
              <div class="flex gap-8 items-start">
                <div class="min-w-[9rem] text-right">
                  @if($s->time_label)
                    <div class="text-xs tracking-widest uppercase text-stone-200/60">{{ $s->time_label }}</div>
                  @endif
                  <div class="mt-3 w-10 h-10 rounded-full border border-yellow-500/25 bg-yellow-500/10 flex items-center justify-center text-yellow-300">♡</div>
                </div>
                <div class="flex-1">
                  @if($s->heading)
                    <h3 class="font-display text-2xl text-stone-100">{!! $s->heading !!}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-3 prose prose-invert max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->image)
                    <div class="mt-6">
                      <img src="{{ $s->image_url }}" alt="{{ $s->image_tag ?? 'Timeline image' }}" class="w-full max-h-96 object-cover rounded-2xl grayscale saturate-0">
                    </div>
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-stone-200/80 text-sm">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'quote')
            <div class="rounded-3xl border border-yellow-500/20 bg-yellow-500/5 p-10 text-center">
              <div class="mx-auto max-w-3xl">
                @if($s->heading)
                  <h3 class="font-display text-3xl text-stone-100">{!! $s->heading !!}</h3>
                @endif
                @if($s->content)
                  <blockquote class="mt-6 text-stone-100 text-xl md:text-2xl leading-relaxed">{!! $s->content !!}</blockquote>
                @endif
                @if($s->quote_author)
                  <div class="mt-6 text-xs tracking-widest uppercase text-yellow-300/80">— {{ $s->quote_author }}</div>
                @endif
                @if($s->handwritten_note)
                  <p class="mt-4 font-hand italic text-stone-200/80 text-sm">{{ $s->handwritten_note }}</p>
                @endif
              </div>
            </div>
          @elseif($s->type === 'video')
            <div class="rounded-3xl border border-yellow-500/15 bg-white/5 p-8">
              @if($s->heading)
                <h3 class="font-display text-3xl text-stone-100">{!! $s->heading !!}</h3>
              @endif
              @if($s->video_url)
                <div class="mt-6 aspect-video bg-stone-900 rounded-2xl overflow-hidden">
                  <iframe src="{{ $s->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>
              @endif
              @if($s->content)
                <div class="mt-4 prose prose-invert max-w-none">{!! $s->content !!}</div>
              @endif
            </div>
          @endif
        @endforeach
      </div>
    </section>
  </div>
@endsection


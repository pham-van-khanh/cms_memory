@extends('layouts.app')

@section('content')
  <div class="pt-24">
    {{-- HERO (parallax-ish) --}}
    <section class="relative overflow-hidden bg-rose-50">
      <div class="absolute inset-0">
        <img id="classic-hero-img"
             src="{{ $memory->hero_image_url }}"
             alt="{{ $memory->title }}"
             class="w-full h-full object-cover filter saturate-110 opacity-90">
      </div>
      <div class="absolute inset-0 bg-gradient-to-t from-stone-900/70 via-stone-900/20 to-transparent"></div>
      <div class="relative max-w-7xl mx-auto px-8 py-14 md:py-20">
        <div class="max-w-3xl">
          <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-white/20 bg-white/10 backdrop-blur">
            <span class="text-rose-300 text-lg">{{ $memory->category?->icon ?? '♡' }}</span>
            <span class="text-xs tracking-widest uppercase text-white/80">{{ $memory->category?->name ?? 'Memories' }}</span>
          </div>

          <h1 class="mt-6 font-display text-4xl md:text-6xl leading-[1.05] text-white">
            {{ $memory->title }}
          </h1>

          @if(!empty($memory->opening_quote))
            <div class="mt-6 rounded-2xl border border-white/15 bg-white/10 backdrop-blur px-6 py-5">
              <p class="text-white/90 text-lg md:text-xl italic">
                "{{ $memory->opening_quote }}"
              </p>
              @if(!empty($memory->opening_quote_author))
                <p class="mt-3 text-xs tracking-widest uppercase text-white/70">— {{ $memory->opening_quote_author }}</p>
              @endif
            </div>
          @endif

          <div class="mt-7 flex flex-wrap items-center gap-3">
            <span class="text-xs tracking-widest uppercase text-white/80 bg-white/10 border border-white/15 px-4 py-2 rounded-full">
              Template: {{ ucfirst($memory->template) }}
            </span>
            @if($memory->memory_date)
              <span class="text-xs tracking-widest uppercase text-white/80 bg-white/10 border border-white/15 px-4 py-2 rounded-full">
                {{ \Carbon\Carbon::parse($memory->memory_date)->format('d M Y') }}
              </span>
            @endif
            @if($memory->location)
              <span class="text-xs tracking-widest uppercase text-white/80 bg-white/10 border border-white/15 px-4 py-2 rounded-full">
                {{ $memory->location }}
              </span>
            @endif
          </div>
        </div>
      </div>

      {{-- Torn paper edge --}}
      <div class="relative -mb-1">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-20">
          <path d="M0,10 C120,40 240,0 360,20 C480,40 600,5 720,18 C840,32 960,0 1080,20 C1200,40 1320,5 1440,12 L1440,60 L0,60 Z"
                fill="white" />
        </svg>
      </div>
    </section>

    {{-- Gallery --}}
    <section class="max-w-7xl mx-auto px-8 py-12 relative">
      @include('partials.lightbox', ['id'=>'classic-lb'])
      @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>$memory->getAccentColor(), 'playerId'=>'classic-music'])

      <div class="flex items-end justify-between gap-6">
        <div>
          <h2 class="font-script text-3xl text-stone-900">Gallery</h2>
          <p class="text-xs tracking-widest uppercase text-stone-500 mt-1">Click photos to open</p>
        </div>
        <div class="text-xs text-stone-500">
          Accent: <span class="font-medium" style="color: {{ $memory->getAccentColor() }}">{{ $memory->getAccentColor() }}</span>
        </div>
      </div>

      <div class="mt-8">
        <div class="swiper memory-swiper classic-swiper">
          <div class="swiper-wrapper">
            @foreach($memory->galleryImages as $img)
              <div class="swiper-slide">
                <button type="button"
                        class="relative bg-white rounded-2xl shadow-lg border border-stone-200 px-4 py-4
                               hover:-translate-y-1 transition duration-300
                               {{ $loop->odd ? 'rotate-[-1.5deg]' : 'rotate-[1.5deg]' }}"
                        data-lightbox-src="{{ $img->url }}"
                        data-lightbox-caption="{{ $img->caption ?? $img->handwritten_caption ?? '' }}">
                  <img src="{{ $img->url }}" alt="{{ $img->caption ?? 'Memory image' }}"
                       class="w-44 h-44 sm:w-48 sm:h-48 object-cover rounded-xl">
                  <div class="mt-3 text-center text-xs text-stone-600 line-clamp-1">
                    {{ $img->caption ?? $img->handwritten_caption ?? '' }}
                  </div>
                </button>
              </div>
            @endforeach
          </div>
          <div class="swiper-pagination mt-4"></div>
        </div>
      </div>
    </section>

    {{-- Sections --}}
    <section class="max-w-7xl mx-auto px-8 pb-20">
      <div class="space-y-10">
        @foreach($memory->sections as $i => $s)
          @if($s->type === 'story')
            <div class="{{ $i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse' }} flex flex-col md:flex items-center gap-8 rounded-3xl border border-stone-200 bg-white/80 backdrop-blur p-8">
              @if($s->image)
                <div class="flex-1">
                  <img src="{{ $s->image_url }}" alt="{{ $s->label ?? 'Story image' }}"
                       class="w-full max-h-96 object-cover rounded-2xl shadow-lg
                              {{ $i % 2 === 0 ? 'md:rotate-[1deg]' : 'md:rotate-[-1deg]' }}">
                </div>
              @endif
              <div class="flex-1">
                @if($s->label)
                  <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-stone-200 bg-white/60">
                    <span class="inline-block w-2 h-2 rounded-full" style="background: {{ $memory->getAccentColor() }}"></span>
                    <span class="text-xs tracking-widest uppercase text-stone-600">{{ $s->label }}</span>
                  </div>
                @endif
                @if($s->heading)
                  <h3 class="mt-4 font-display text-3xl text-stone-900 leading-tight">
                    {!! $s->heading !!}
                  </h3>
                @endif
                @if($s->content)
                  <div class="mt-4 prose prose-stone max-w-none">
                    {!! $s->content !!}
                  </div>
                @endif
                @if($s->handwritten_note)
                  <p class="mt-4 font-hand italic text-stone-600 text-sm">
                    {{ $s->handwritten_note }}
                  </p>
                @endif
              </div>
            </div>
          @elseif($s->type === 'timeline')
            <div class="rounded-3xl border border-stone-200 bg-white/80 backdrop-blur p-8">
              <div class="flex items-start gap-8">
                <div class="min-w-[9rem]">
                  @if($s->time_label)
                    <div class="text-xs tracking-widest uppercase text-stone-500">{{ $s->time_label }}</div>
                  @endif
                  <div class="mt-3 w-10 h-10 rounded-full border border-stone-200 bg-white flex items-center justify-center text-rose-400 font-bold">
                    ♡
                  </div>
                </div>
                <div class="flex-1">
                  @if($s->heading)
                    <h3 class="font-display text-2xl text-stone-900">{{ $s->heading }}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-3 prose prose-stone max-w-none">
                      {!! $s->content !!}
                    </div>
                  @endif
                  @if($s->image)
                    <div class="mt-6">
                      <img src="{{ $s->image_url }}" alt="{{ $s->image_tag ?? 'Timeline image' }}" class="w-full max-h-96 object-cover rounded-2xl shadow">
                    </div>
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-stone-600 text-sm">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'quote')
            <div class="rounded-3xl border border-stone-200 bg-gradient-to-b from-white/80 to-white/50 p-10 text-center">
              <div class="mx-auto max-w-3xl">
                @if($s->heading)
                  <h3 class="font-display text-3xl text-stone-900">{!! $s->heading !!}</h3>
                @endif
                @if($s->content)
                  <blockquote class="mt-6 text-stone-700 text-xl md:text-2xl leading-relaxed">
                    {!! $s->content !!}
                  </blockquote>
                @endif
                @if($s->quote_author)
                  <div class="mt-6 text-xs tracking-widest uppercase text-stone-500">— {{ $s->quote_author }}</div>
                @endif
                @if($s->handwritten_note)
                  <p class="mt-4 font-hand italic text-stone-600 text-sm">{{ $s->handwritten_note }}</p>
                @endif
              </div>
            </div>
          @elseif($s->type === 'video')
            <div class="rounded-3xl border border-stone-200 bg-white/80 backdrop-blur p-8">
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

  {{-- Swiper init + hero parallax --}}
  <script>
    (function(){
      const hero = document.getElementById('classic-hero-img');
      if(hero){
        window.addEventListener('scroll', function(){
          const y = window.scrollY || 0;
          hero.style.transform = 'translateY(' + (y * 0.08) + 'px) scale(1.02)';
        });
      }

      function initSwiper(){
        if(!window.Swiper) return;
        new Swiper('.classic-swiper', {
          slidesPerView: 1,
          spaceBetween: 16,
          loop: true,
          pagination: { el: '.swiper-pagination', clickable: true },
          breakpoints: {
            640: { slidesPerView: 2 },
            1024:{ slidesPerView: 3 },
          }
        });
      }

      if(document.readyState === 'complete') initSwiper();
      else window.addEventListener('load', initSwiper);
    })();
  </script>
@endsection


@extends('layouts.app')

@section('content')
<div class="pt-24 bg-[#0b0b0b] text-amber-100">
  <section class="relative border-y border-amber-700/30">
    <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_center,rgba(245,158,11,.4),transparent_60%)]"></div>
    <div class="relative max-w-6xl mx-auto px-8 py-14">
      <p class="text-xs uppercase tracking-[0.3em] text-amber-400">Nostalgia Theme</p>
      <h1 class="mt-3 font-display text-5xl">{{ $memory->title }}</h1>
      @if($memory->opening_quote)<p class="mt-4 italic text-amber-200/90">"{{ $memory->opening_quote }}"</p>@endif
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-8 py-10">
    @include('partials.lightbox', ['id'=>'nostalgia-lb'])
    @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>'#f59e0b', 'playerId'=>'nostalgia-music'])
    <div class="grid md:grid-cols-12 gap-6">
      <img src="{{ $memory->hero_image_url }}" alt="{{ $memory->title }}" class="md:col-span-8 w-full h-[28rem] object-cover sepia rounded-2xl">
      <div class="md:col-span-4 rounded-2xl border border-amber-700/30 p-5 bg-amber-900/10 text-sm space-y-2">
        @if($memory->memory_date)<p>{{ $memory->memory_date->format('d M Y') }}</p>@endif
        @if($memory->location)<p>{{ $memory->location }}</p>@endif
        <p>Scene archive</p>
      </div>
    </div>

    <h2 class="mt-10 text-2xl font-semibold">Contact Sheet</h2>
    <div class="mt-4 grid grid-cols-3 md:grid-cols-6 gap-3">
      @foreach($memory->galleryImages as $img)
      <button type="button" class="border border-amber-700/40 p-1 bg-black" data-lightbox-src="{{ $img->url }}" data-lightbox-caption="{{ $img->caption ?? '' }}">
        <img src="{{ $img->url }}" class="w-full h-24 object-cover sepia" alt="{{ $img->caption ?? 'Memory image' }}">
      </button>
      @endforeach
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-8 pb-20">
    <div class="relative pl-8 border-l border-amber-700/30 space-y-10">
      @foreach($memory->sections as $s)
      <article class="relative">
        <span class="absolute -left-[2.05rem] top-2 w-4 h-4 rounded-full bg-amber-500"></span>
        @if($s->time_label)<p class="text-xs uppercase tracking-widest text-amber-400">{{ $s->time_label }}</p>@endif
        @if($s->heading)<h3 class="mt-1 text-2xl font-display">{!! $s->heading !!}</h3>@endif
        @if($s->content)<div class="mt-3 prose prose-invert max-w-none">{!! $s->content !!}</div>@endif
      </article>
      @endforeach
    </div>
  </section>
</div>
@endsection

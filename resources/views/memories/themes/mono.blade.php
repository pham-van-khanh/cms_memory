@extends('layouts.app')

@section('content')
<div class="pt-24 bg-white text-black">
  <section class="max-w-7xl mx-auto px-8 py-12 border-b-4 border-black">
    <p class="text-xs uppercase tracking-[0.3em]">Mono Theme</p>
    <h1 class="mt-4 text-5xl md:text-7xl font-black leading-[0.95]">{{ $memory->title }}</h1>
    <div class="mt-8 grid md:grid-cols-3 gap-8">
      <img src="{{ $memory->hero_image_url }}" alt="{{ $memory->title }}" class="md:col-span-2 w-full h-[28rem] object-cover grayscale">
      <div class="text-sm space-y-3">
        <p>Template: {{ ucfirst($memory->template) }}</p>
        @if($memory->memory_date)<p>{{ $memory->memory_date->format('d M Y') }}</p>@endif
        @if($memory->location)<p>{{ $memory->location }}</p>@endif
        @if($memory->opening_quote)<p class="italic border-l-4 border-black pl-3">{{ $memory->opening_quote }}</p>@endif
      </div>
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-8 py-10">
    @include('partials.lightbox', ['id'=>'mono-lb'])
    @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>'#111111', 'playerId'=>'mono-music'])
    <h2 class="text-2xl font-bold uppercase tracking-wide">Gallery</h2>
    <div class="mt-6 grid grid-cols-2 md:grid-cols-6 gap-2">
      @foreach($memory->galleryImages as $img)
      <button type="button" class="border border-black overflow-hidden" data-lightbox-src="{{ $img->url }}" data-lightbox-caption="{{ $img->caption ?? '' }}">
        <img src="{{ $img->url }}" class="w-full h-36 object-cover grayscale hover:grayscale-0 transition" alt="{{ $img->caption ?? 'Memory image' }}">
      </button>
      @endforeach
    </div>
  </section>

  <section class="max-w-7xl mx-auto px-8 pb-20 space-y-0">
    @foreach($memory->sections as $s)
      <article class="py-10 border-t border-black">
        @if($s->heading)<h3 class="text-3xl font-bold uppercase">{!! $s->heading !!}</h3>@endif
        @if($s->type==='video' && $s->video_url)
          <div class="mt-4 aspect-video border border-black"><iframe src="{{ $s->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe></div>
        @elseif($s->image)
          <img src="{{ $s->image_url }}" class="mt-4 w-full max-h-96 object-cover grayscale" alt="{{ $s->image_tag ?? 'section image' }}">
        @endif
        @if($s->content)<div class="mt-4 prose max-w-none">{!! $s->content !!}</div>@endif
      </article>
    @endforeach
  </section>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="pt-24 bg-[#120f14] text-rose-50">
  <section class="relative min-h-[70vh] flex items-end">
    <img src="{{ $memory->hero_image_url }}" alt="{{ $memory->title }}" class="absolute inset-0 w-full h-full object-cover opacity-55">
    <div class="absolute inset-0 bg-gradient-to-t from-[#120f14] via-[#120f14]/55 to-transparent"></div>
    <div class="relative max-w-6xl mx-auto w-full px-8 py-16">
      <p class="text-xs uppercase tracking-[0.35em] text-rose-200/80">Save The Date</p>
      <h1 class="mt-3 font-display text-5xl md:text-7xl leading-[0.95]">{{ $memory->title }}</h1>
      @if($memory->memory_date)
        <p class="mt-4 text-lg tracking-[0.15em] uppercase text-rose-200">{{ $memory->memory_date->format('d . m . Y') }}</p>
      @endif
      @if($memory->opening_quote)
        <p class="mt-6 max-w-2xl italic text-rose-100/90">"{{ $memory->opening_quote }}"</p>
      @endif
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-8 py-10">
    @include('partials.lightbox', ['id'=>'cinelove39-lb'])
    @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>'#f43f5e', 'playerId'=>'cinelove39-music'])

    <div class="grid md:grid-cols-3 gap-6">
      <div class="rounded-3xl border border-rose-300/25 bg-white/5 p-6">
        <p class="text-xs uppercase tracking-widest text-rose-200/70">Location</p>
        <p class="mt-2 text-xl">{{ $memory->location ?? 'Our lovely place' }}</p>
      </div>
      <div class="rounded-3xl border border-rose-300/25 bg-white/5 p-6">
        <p class="text-xs uppercase tracking-widest text-rose-200/70">Category</p>
        <p class="mt-2 text-xl">{{ $memory->category?->name ?? 'Love Story' }}</p>
      </div>
      <div class="rounded-3xl border border-rose-300/25 bg-white/5 p-6">
        <p class="text-xs uppercase tracking-widest text-rose-200/70">Template</p>
        <p class="mt-2 text-xl">Cinelove 39</p>
      </div>
    </div>

    <h2 class="mt-10 font-display text-3xl">Highlights</h2>
    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
      @foreach($memory->galleryImages as $img)
        <button type="button" class="group rounded-2xl overflow-hidden border border-rose-200/20" data-lightbox-src="{{ $img->url }}" data-lightbox-caption="{{ $img->caption ?? '' }}">
          <img src="{{ $img->url }}" alt="{{ $img->caption ?? 'image' }}" class="w-full h-40 object-cover group-hover:scale-105 transition duration-300">
        </button>
      @endforeach
    </div>
  </section>

  <section class="max-w-6xl mx-auto px-8 pb-20">
    <div class="space-y-8">
      @foreach($memory->sections as $i => $s)
        <article class="rounded-3xl border border-rose-300/20 bg-white/[0.04] p-7">
          @if($s->label)<p class="text-xs uppercase tracking-[0.2em] text-rose-200/70">{{ $s->label }}</p>@endif
          @if($s->heading)<h3 class="mt-2 font-display text-3xl">{!! $s->heading !!}</h3>@endif
          <div class="mt-5 grid {{ $i % 2 ? 'md:grid-cols-5' : 'md:grid-cols-5' }} gap-6 items-center">
            @if($s->image)
              <img src="{{ $s->image_url }}" alt="{{ $s->image_tag ?? 'section image' }}" class="{{ $i % 2 ? 'md:order-2 md:col-span-2' : 'md:col-span-2' }} rounded-2xl w-full h-64 object-cover">
            @endif
            <div class="{{ $s->image ? ($i % 2 ? 'md:order-1 md:col-span-3' : 'md:col-span-3') : 'md:col-span-5' }}">
              @if($s->content)<div class="prose prose-invert max-w-none">{!! $s->content !!}</div>@endif
              @if($s->video_url)
                <div class="mt-4 aspect-video rounded-2xl overflow-hidden border border-rose-300/20">
                  <iframe src="{{ $s->video_url }}" class="w-full h-full" frameborder="0" allowfullscreen></iframe>
                </div>
              @endif
            </div>
          </div>
        </article>
      @endforeach
    </div>
  </section>
</div>
@endsection

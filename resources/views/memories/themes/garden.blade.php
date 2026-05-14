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

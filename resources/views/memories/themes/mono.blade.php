@extends('layouts.app')

@section('content')
  <div class="pt-24 bg-white text-black">
    <section class="max-w-7xl mx-auto px-8 py-14">
      {{-- Hero fade into content --}}
      <div class="relative rounded-3xl border border-black/20 bg-white overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-stone-50 via-stone-50/70 to-transparent"></div>

        <div class="relative grid grid-cols-5 gap-0 items-stretch">
          <div class="col-span-3">
            <div class="h-full min-h-[26rem] md:min-h-[34rem]">
              <img src="{{ $memory->hero_image_url }}" alt="{{ $memory->title }}"
                   class="w-full h-full object-cover opacity-95">
            </div>
          </div>
          <div class="col-span-2 p-10 flex flex-col justify-center">
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-black/20 bg-white">
              <span class="text-black text-lg">{{ $memory->category?->icon ?? '♡' }}</span>
              <span class="text-xs tracking-widest uppercase text-neutral-500">{{ $memory->category?->name ?? 'Memories' }}</span>
            </div>

            <h1 class="mt-6 font-display text-4xl leading-tight">{{ $memory->title }}</h1>

            @if(!empty($memory->opening_quote))
              <p class="mt-4 text-neutral-800 italic text-lg leading-relaxed">
                "{{ $memory->opening_quote }}"
              </p>
            @endif

            <div class="mt-6 space-y-2 text-sm text-neutral-700">
              @if($memory->memory_date)
                <div>{{ $memory->memory_date->format('d M Y') }}</div>
              @endif
              @if($memory->location)
                <div>{{ $memory->location }}</div>
              @endif
              <div class="pt-3 border-t border-black/20">
                Template: <span class="font-medium" style="color: {{ $memory->getAccentColor() }}">{{ ucfirst($memory->template) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- Monochrome Gallery --}}
    <section class="max-w-7xl mx-auto px-8 pb-12">
      @include('partials.lightbox', ['id'=>'mono-lb'])
      @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>$memory->getAccentColor(), 'playerId'=>'mono-music'])

      <h2 class="font-script text-3xl text-black">Monochrome Gallery</h2>
      <p class="mt-2 text-xs tracking-widest uppercase text-neutral-500">Clean, calm, and click to open</p>

      <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($memory->galleryImages as $img)
          <button type="button"
                  class="rounded-2xl overflow-hidden border border-black/20 bg-white hover:shadow transition"
                  data-lightbox-src="{{ $img->url }}"
                  data-lightbox-caption="{{ $img->caption ?? $img->handwritten_caption ?? '' }}">
            <img src="{{ $img->url }}" alt="{{ $img->caption ?? 'Memory image' }}" class="w-full h-40 object-cover">
            @if($img->caption || $img->handwritten_caption)
              <div class="px-3 py-2 text-xs text-neutral-700 line-clamp-1">
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
            <div class="rounded-3xl border border-black/20 bg-white p-8">
              <div class="{{ $s->image_right ? 'md:flex-row-reverse' : 'md:flex-row' }} flex flex-col md:flex gap-8 items-center">
                @if($s->image)
                  <div class="w-full md:w-1/2">
                    <img src="{{ $s->image_url }}" alt="{{ $s->label ?? 'Story image' }}" class="w-full max-h-96 object-cover rounded-2xl">
                    @if($s->image_tag)
                      <div class="mt-3 text-center text-xs tracking-widest uppercase text-neutral-500">{{ $s->image_tag }}</div>
                    @endif
                  </div>
                @endif
                <div class="flex-1">
                  @if($s->label)
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-black/20 bg-white">
                      <span class="inline-block w-2 h-2 rounded-full" style="background: {{ $memory->getAccentColor() }}"></span>
                      <span class="text-xs tracking-widest uppercase text-neutral-500">{{ $s->label }}</span>
                    </div>
                  @endif
                  @if($s->heading)
                    <h3 class="mt-4 font-display text-3xl text-black leading-tight">{!! $s->heading !!}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-4 prose prose-stone max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-neutral-700 text-sm">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'timeline')
            <div class="rounded-3xl border border-black/20 bg-white p-8">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <div>
                  @if($s->time_label)
                    <div class="text-xs tracking-widest uppercase text-neutral-500">{{ $s->time_label }}</div>
                  @endif
                  <div class="mt-3 w-10 h-10 rounded-full bg-neutral-100 flex items-center justify-center text-black">♡</div>
                </div>
                <div class="md:col-span-2">
                  @if($s->heading)
                    <h3 class="font-display text-2xl text-black">{!! $s->heading !!}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-3 prose prose-stone max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->image)
                    <img src="{{ $s->image_url }}" alt="{{ $s->image_tag ?? 'Timeline image' }}" class="mt-6 w-full max-h-96 object-cover rounded-2xl">
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-neutral-700 text-sm">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'quote')
            <div class="rounded-3xl border border-black/20 bg-white p-10 text-center">
              <div class="mx-auto max-w-3xl">
                @if($s->heading)
                  <h3 class="font-display text-3xl text-black">{!! $s->heading !!}</h3>
                @endif
                @if($s->content)
                  <blockquote class="mt-6 text-neutral-800 text-xl md:text-2xl leading-relaxed italic">
                    {!! $s->content !!}
                  </blockquote>
                @endif
                @if($s->quote_author)
                  <div class="mt-6 text-xs tracking-widest uppercase text-neutral-500">— {{ $s->quote_author }}</div>
                @endif
              </div>
            </div>
          @elseif($s->type === 'video')
            <div class="rounded-3xl border border-black/20 bg-white p-8">
              @if($s->heading)
                <h3 class="font-display text-3xl text-black">{{ $s->heading }}</h3>
              @endif
              @if($s->video_url)
                <div class="mt-6 aspect-video bg-neutral-100 rounded-2xl overflow-hidden">
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


@extends('layouts.app')

@section('content')
  <div class="pt-24 bg-gradient-to-b from-[#0f1020] via-[#241d3a] to-[#161a2d] text-slate-100">
    <section class="max-w-7xl mx-auto px-8 py-14">
      {{-- Hero fade into content --}}
      <div class="relative rounded-3xl border border-white/20 bg-white/10 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-t from-stone-50 via-stone-50/70 to-transparent"></div>

        <div class="relative grid grid-cols-5 gap-0 items-stretch">
          <div class="col-span-3">
            <div class="h-full min-h-[26rem] md:min-h-[34rem]">
              <img src="{{ $memory->hero_image_url }}" alt="{{ $memory->title }}"
                   class="w-full h-full object-cover opacity-95">
            </div>
          </div>
          <div class="col-span-2 p-10 flex flex-col justify-center">
            <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-white/20 bg-white/10">
              <span class="text-rose-400 text-lg">{{ $memory->category?->icon ?? '♡' }}</span>
              <span class="text-xs tracking-widest uppercase text-slate-400">{{ $memory->category?->name ?? 'Memories' }}</span>
            </div>

            <h1 class="mt-6 font-display text-4xl leading-tight">{{ $memory->title }}</h1>

            @if(!empty($memory->opening_quote))
              <p class="mt-4 text-slate-200 italic text-lg leading-relaxed">
                "{{ $memory->opening_quote }}"
              </p>
            @endif

            <div class="mt-6 space-y-2 text-sm text-slate-300">
              @if($memory->memory_date)
                <div>{{ $memory->memory_date->format('d M Y') }}</div>
              @endif
              @if($memory->location)
                <div>{{ $memory->location }}</div>
              @endif
              <div class="pt-3 border-t border-white/20">
                Template: <span class="font-medium" style="color: {{ $memory->getAccentColor() }}">{{ ucfirst($memory->template) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    {{-- Stardust Gallery --}}
    <section class="max-w-7xl mx-auto px-8 pb-12">
      @include('partials.lightbox', ['id'=>'aurora-lb'])
      @include('partials.music-player', ['musicUrl'=>$memory->music_url, 'accentColor'=>$memory->getAccentColor(), 'playerId'=>'aurora-music'])

      <h2 class="font-script text-3xl text-slate-100">Stardust Gallery</h2>
      <p class="mt-2 text-xs tracking-widest uppercase text-slate-400">Dreamy gradient memories</p>

      <div class="mt-8 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($memory->galleryImages as $img)
          <button type="button"
                  class="rounded-2xl overflow-hidden border border-white/20 bg-white/10 hover:shadow transition"
                  data-lightbox-src="{{ $img->url }}"
                  data-lightbox-caption="{{ $img->caption ?? $img->handwritten_caption ?? '' }}">
            <img src="{{ $img->url }}" alt="{{ $img->caption ?? 'Memory image' }}" class="w-full h-40 object-cover">
            @if($img->caption || $img->handwritten_caption)
              <div class="px-3 py-2 text-xs text-slate-300 line-clamp-1">
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
            <div class="rounded-3xl border border-white/20 bg-white/10 p-8">
              <div class="{{ $s->image_right ? 'md:flex-row-reverse' : 'md:flex-row' }} flex flex-col md:flex gap-8 items-center">
                @if($s->image)
                  <div class="w-full md:w-1/2">
                    <img src="{{ $s->image_url }}" alt="{{ $s->label ?? 'Story image' }}" class="w-full max-h-96 object-cover rounded-2xl">
                    @if($s->image_tag)
                      <div class="mt-3 text-center text-xs tracking-widest uppercase text-slate-400">{{ $s->image_tag }}</div>
                    @endif
                  </div>
                @endif
                <div class="flex-1">
                  @if($s->label)
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/20 bg-white/5">
                      <span class="inline-block w-2 h-2 rounded-full" style="background: {{ $memory->getAccentColor() }}"></span>
                      <span class="text-xs tracking-widest uppercase text-slate-400">{{ $s->label }}</span>
                    </div>
                  @endif
                  @if($s->heading)
                    <h3 class="mt-4 font-display text-3xl text-slate-100 leading-tight">{!! $s->heading !!}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-4 prose prose-stone max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-slate-300 text-sm">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'timeline')
            <div class="rounded-3xl border border-white/20 bg-white/10 p-8">
              <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                <div>
                  @if($s->time_label)
                    <div class="text-xs tracking-widest uppercase text-slate-400">{{ $s->time_label }}</div>
                  @endif
                  <div class="mt-3 w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-rose-400">♡</div>
                </div>
                <div class="md:col-span-2">
                  @if($s->heading)
                    <h3 class="font-display text-2xl text-slate-100">{!! $s->heading !!}</h3>
                  @endif
                  @if($s->content)
                    <div class="mt-3 prose prose-stone max-w-none">{!! $s->content !!}</div>
                  @endif
                  @if($s->image)
                    <img src="{{ $s->image_url }}" alt="{{ $s->image_tag ?? 'Timeline image' }}" class="mt-6 w-full max-h-96 object-cover rounded-2xl">
                  @endif
                  @if($s->handwritten_note)
                    <p class="mt-4 font-hand italic text-slate-300 text-sm">{{ $s->handwritten_note }}</p>
                  @endif
                </div>
              </div>
            </div>
          @elseif($s->type === 'quote')
            <div class="rounded-3xl border border-white/20 bg-white/5 p-10 text-center">
              <div class="mx-auto max-w-3xl">
                @if($s->heading)
                  <h3 class="font-display text-3xl text-slate-100">{!! $s->heading !!}</h3>
                @endif
                @if($s->content)
                  <blockquote class="mt-6 text-slate-200 text-xl md:text-2xl leading-relaxed italic">
                    {!! $s->content !!}
                  </blockquote>
                @endif
                @if($s->quote_author)
                  <div class="mt-6 text-xs tracking-widest uppercase text-slate-400">— {{ $s->quote_author }}</div>
                @endif
              </div>
            </div>
          @elseif($s->type === 'video')
            <div class="rounded-3xl border border-white/20 bg-white/10 p-8">
              @if($s->heading)
                <h3 class="font-display text-3xl text-slate-100">{{ $s->heading }}</h3>
              @endif
              @if($s->video_url)
                <div class="mt-6 aspect-video bg-white/10 rounded-2xl overflow-hidden">
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


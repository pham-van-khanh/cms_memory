@extends('layouts.app')

@section('content')
  <div class="pt-24">
    {{-- Hero --}}
    <div class="relative">
      <div class="h-[28rem] md:h-[34rem] overflow-hidden bg-stone-900">
        <img src="{{ $post->cover_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover opacity-80">
      </div>
      <div class="absolute inset-0 bg-gradient-to-t from-stone-900 via-stone-900/60 to-transparent"></div>
      <div class="absolute inset-x-0 bottom-0 p-8 max-w-7xl mx-auto">
        <div class="max-w-3xl">
          <div class="flex items-center gap-3">
            <span class="text-xs tracking-widest uppercase text-white/80 bg-white/10 border border-white/15 px-3 py-2 rounded-full">
              {{ $post->category?->name ?? 'General' }}
            </span>
            <span class="text-xs text-white/80">{{ $post->views }} views</span>
          </div>
          <h1 class="mt-4 font-display text-4xl md:text-5xl text-white leading-tight">
            {{ $post->title }}
          </h1>
          @if($post->excerpt)
            <p class="mt-3 text-white/85 text-base leading-relaxed">
              {{ $post->excerpt }}
            </p>
          @endif
          <div class="mt-4 text-sm text-white/80">
            By {{ $post->author?->name ?? 'Unknown' }}
          </div>
        </div>
      </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-8 py-12">
      @if(!empty($post->tags))
        <div class="flex flex-wrap gap-2 mb-6">
          @foreach($post->tags as $tag)
            <span class="text-xs px-3 py-1 rounded-full bg-stone-900 text-stone-50/90">
              {{ $tag }}
            </span>
          @endforeach
        </div>
      @endif

      <article class="prose prose-stone max-w-none text-stone-700">
        {!! $post->content !!}
      </article>

      {{-- Related --}}
      @if($related->count())
        <div class="mt-14">
          <h2 class="font-script text-3xl text-stone-900">Related</h2>
          <div class="mt-7 grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($related as $r)
              <a href="{{ route('blog.show',$r->slug) }}"
                 class="no-underline rounded-2xl border border-stone-200 bg-white/70 overflow-hidden hover:shadow transition">
                <div class="h-28 bg-stone-100">
                  <img src="{{ $r->cover_url }}" alt="{{ $r->title }}" class="w-full h-full object-cover">
                </div>
                <div class="p-5">
                  <div class="text-xs tracking-widest uppercase text-stone-500">
                    {{ $r->category?->name ?? 'General' }}
                  </div>
                  <div class="mt-2 text-stone-900 font-display font-medium">
                    {{ $r->title }}
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection


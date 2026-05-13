@extends('layouts.app')

@section('content')
  <div class="pt-24">
    {{-- Hero --}}
    <section class="relative overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-br from-rose-50 via-stone-50 to-emerald-50"></div>
      <div class="absolute -top-24 -right-24 w-80 h-80 rounded-full bg-rose-200/40 blur-3xl"></div>
      <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-emerald-200/30 blur-3xl"></div>

      <div class="relative max-w-7xl mx-auto px-8 py-16">
        <div class="max-w-2xl">
          <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-stone-200 bg-white/70 backdrop-blur">
            <span class="text-rose-400 text-lg">♡</span>
            <span class="text-xs tracking-widest uppercase text-stone-500">Romantic scrapbook CMS</span>
          </div>
          <h2 class="mt-6 font-display text-4xl md:text-6xl leading-[1.05] text-stone-900 animate-hero-zoom">
            Memories, told softly.
          </h2>
          <p class="mt-5 text-stone-600 text-sm md:text-base leading-relaxed">
            Read, browse, and open personal stories in a warm, emotional landing-page style.
          </p>

          <div class="mt-8 flex flex-wrap items-center gap-3">
            <a href="{{ route('blog.index') }}" class="px-5 py-3 rounded-full bg-rose-400 text-white text-xs tracking-widest uppercase hover:brightness-110 transition no-underline">
              Explore Blog
            </a>
            <a href="{{ route('news.index') }}" class="px-5 py-3 rounded-full border border-stone-200 bg-white/70 text-stone-700 text-xs tracking-widest uppercase hover:bg-white transition no-underline">
              Latest News
            </a>
          </div>
        </div>
      </div>
    </section>

    {{-- Memories grid (6 cards) --}}
    <section class="max-w-7xl mx-auto px-8 py-12">
      <div class="flex items-end justify-between gap-6">
        <div>
          <h3 class="font-script text-3xl text-rose-400">Memories</h3>
          <p class="text-xs tracking-widest uppercase text-stone-500 mt-1">A gallery of personal stories</p>
        </div>
        <a href="{{ route('blog.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition">Browse more</a>
      </div>

      <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($memories as $m)
          <a href="{{ route('memory.show', $m->slug) }}"
             class="group relative rounded-2xl overflow-hidden border border-stone-200 bg-white hover:shadow-lg transition no-underline">
            <div class="h-44 sm:h-48 w-full bg-stone-100 overflow-hidden">
              <img src="{{ $m->hero_image_url }}" alt="{{ $m->title }}"
                   class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>
            <div class="p-5">
              <div class="flex items-center justify-between gap-4">
                <span class="inline-flex items-center gap-2 text-xs tracking-widest uppercase text-stone-500">
                  <span class="inline-block w-2 h-2 rounded-full" style="background: {{ $m->getAccentColor() }}"></span>
                  {{ $m->category?->name ?? 'General' }}
                </span>
                <span class="text-xs px-3 py-1 rounded-full border border-stone-200 text-stone-600 bg-white/70">
                  {{ ucfirst($m->template) }}
                </span>
              </div>
              <h4 class="mt-3 font-display text-lg text-stone-900 leading-snug">
                {{ $m->title }}
              </h4>
              @if(!empty($m->memory_date))
                <p class="mt-2 text-xs text-stone-500">
                  {{ \Carbon\Carbon::parse($m->memory_date)->format('d M Y') }}
                </p>
              @endif
            </div>
            <div class="absolute inset-x-0 bottom-0 h-1.5 bg-gradient-to-r from-rose-400/80 via-rose-300/50 to-emerald-300/40 opacity-0 group-hover:opacity-100 transition"></div>
          </a>
        @endforeach
      </div>
    </section>

    {{-- Blog strip (3 cards) --}}
    <section class="max-w-7xl mx-auto px-8 pb-12">
      <div class="flex items-end justify-between gap-6">
        <div>
          <h3 class="font-script text-3xl text-stone-900">Blog</h3>
          <p class="text-xs tracking-widest uppercase text-stone-500 mt-1">Rich stories with categories & tags</p>
        </div>
      </div>

      <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($blogs as $p)
          <a href="{{ route('blog.show',$p->slug) }}"
             class="no-underline group rounded-2xl border border-stone-200 bg-white overflow-hidden hover:shadow-lg transition">
            <div class="h-36 bg-stone-100">
              <img src="{{ $p->cover_url }}" alt="{{ $p->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>
            <div class="p-5">
              <div class="flex items-center justify-between gap-4">
                <span class="text-xs tracking-widest uppercase text-stone-500">{{ $p->category?->name }}</span>
                <span class="text-xs text-stone-500">{{ $p->views }} views</span>
              </div>
              <h4 class="mt-3 font-display text-lg text-stone-900 group-hover:text-rose-500 transition">{{ $p->title }}</h4>
              @if($p->excerpt)
                <p class="mt-2 text-sm text-stone-600 line-clamp-2">{{ $p->excerpt }}</p>
              @endif
            </div>
          </a>
        @endforeach
      </div>
    </section>

    {{-- News list (5 items) --}}
    <section class="max-w-7xl mx-auto px-8 pb-20">
      <div class="flex items-end justify-between gap-6">
        <div>
          <h3 class="font-script text-3xl text-rose-400">News</h3>
          <p class="text-xs tracking-widest uppercase text-stone-500 mt-1">Short announcements & updates</p>
        </div>
        <a href="{{ route('news.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition">View all</a>
      </div>

      <div class="mt-8 divide-y divide-stone-200 rounded-2xl border border-stone-200 bg-white/70 backdrop-blur">
        @foreach($news as $n)
          <a href="{{ route('news.show',$n->slug) }}" class="block p-5 hover:bg-white/90 transition no-underline">
            <div class="flex items-start justify-between gap-4">
              <div>
                <div class="text-xs tracking-widest uppercase text-stone-500">
                  {{ \Carbon\Carbon::parse($n->published_at ?? $n->created_at)->format('d M Y') }}
                </div>
                <div class="mt-2 font-display text-lg text-stone-900 group-hover:text-rose-500">
                  {{ $n->title }}
                </div>
                @if($n->excerpt)
                  <div class="mt-2 text-sm text-stone-600 line-clamp-2">{{ $n->excerpt }}</div>
                @else
                  <div class="mt-2 text-sm text-stone-600 line-clamp-2">
                    {{ \Illuminate\Support\Str::limit(strip_tags($n->content ?? ''), 140) }}
                  </div>
                @endif
              </div>
              <div class="text-xs text-stone-500 whitespace-nowrap">
                {{ $n->views }} views
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </section>
  </div>
@endsection


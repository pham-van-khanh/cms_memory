@extends('layouts.app')

@section('content')
  <div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-8">
      <div class="flex items-end justify-between gap-6">
        <div>
          <h1 class="font-script text-4xl text-stone-900">Blog</h1>
          <p class="mt-2 text-sm text-stone-600">Stories with rich text, categories, and tags.</p>
        </div>
        <div class="text-xs tracking-widest uppercase text-stone-500">
          {{ $posts->total() }} posts
        </div>
      </div>

      {{-- Category filter pills --}}
      <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('blog.index') }}"
           class="px-4 py-2 rounded-full border transition text-xs tracking-widest uppercase
                  {{ !isset($category) ? 'bg-rose-400 text-white border-rose-400' : 'bg-white/70 border-stone-200 text-stone-600 hover:bg-white' }}">
          All
        </a>
        @foreach($categories as $c)
          <a href="{{ route('blog.category', $c->slug) }}"
             class="px-4 py-2 rounded-full border transition text-xs tracking-widest uppercase
                    {{ isset($category) && $category->slug === $c->slug ? 'text-white border-rose-400' : 'bg-white/70 border-stone-200 text-stone-600 hover:bg-white' }}"
             style="{{ isset($category) && $category->slug === $c->slug ? "background: {$c->color};" : '' }}">
            {{ $c->name }}
          </a>
        @endforeach
      </div>

      {{-- Blog grid --}}
      <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($posts as $p)
          <a href="{{ route('blog.show',$p->slug) }}"
             class="no-underline group rounded-2xl border border-stone-200 bg-white/70 overflow-hidden hover:shadow-lg transition">
            <div class="h-44 bg-stone-100 overflow-hidden">
              <img src="{{ $p->cover_url }}" alt="{{ $p->title }}"
                   class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
            </div>
            <div class="p-6">
              <div class="flex items-center justify-between gap-4">
                <span class="text-xs tracking-widest uppercase text-stone-500">
                  {{ $p->category?->name ?? 'General' }}
                </span>
                <span class="text-xs text-stone-500">{{ $p->views }} views</span>
              </div>
              <h3 class="mt-3 font-display text-2xl text-stone-900 group-hover:text-rose-500 transition">
                {{ $p->title }}
              </h3>
              @if($p->excerpt)
                <p class="mt-2 text-sm text-stone-600 line-clamp-2">
                  {{ $p->excerpt }}
                </p>
              @endif
              @if(!empty($p->tags))
                <div class="mt-4 flex flex-wrap gap-2">
                  @foreach($p->tags as $tag)
                    <span class="text-[11px] px-3 py-1 rounded-full bg-stone-900 text-stone-50/90">
                      {{ $tag }}
                    </span>
                  @endforeach
                </div>
              @endif
              <div class="mt-4 text-xs tracking-widest uppercase text-stone-500">
                By {{ $p->author?->name ?? 'Unknown' }}
              </div>
            </div>
          </a>
        @endforeach
      </div>

      {{-- Pagination --}}
      <div class="mt-10">
        {{ $posts->withQueryString()->links() }}
      </div>
    </div>
  </div>
@endsection


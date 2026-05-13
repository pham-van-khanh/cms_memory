@extends('layouts.app')

@section('content')
  <div class="pt-24 pb-16">
    <div class="max-w-7xl mx-auto px-8">
      <div class="flex items-end justify-between gap-6">
        <div>
          <h1 class="font-script text-4xl text-rose-400">News</h1>
          <p class="mt-2 text-sm text-stone-600">Short announcements & updates.</p>
        </div>
        <div class="text-xs tracking-widest uppercase text-stone-500">{{ $posts->total() }} items</div>
      </div>

      <div class="mt-10 rounded-3xl border border-stone-200 bg-white/70 backdrop-blur p-6">
        <div class="space-y-6">
          @foreach($posts as $p)
            @php
              $dt = $p->published_at ?? $p->created_at;
              $dateLabel = $dt ? $dt->format('d M Y') : '';
              $snippet = \Illuminate\Support\Str::limit(strip_tags($p->content ?? ''), 180);
            @endphp
            <a href="{{ route('news.show',$p->slug) }}" class="block no-underline group">
              <div class="flex gap-6 items-start">
                <div class="min-w-[8.5rem]">
                  <div class="text-xs tracking-widest uppercase text-stone-500">{{ $dateLabel }}</div>
                  <div class="mt-2 w-10 h-10 rounded-full border border-stone-200 bg-stone-50 flex items-center justify-center text-rose-400">
                    ♡
                  </div>
                </div>
                <div class="flex-1">
                  <div class="font-display text-xl text-stone-900 group-hover:text-rose-500 transition">
                    {{ $p->title }}
                  </div>
                  <div class="mt-2 text-sm text-stone-600 leading-relaxed line-clamp-3">
                    {{ $snippet }}
                  </div>
                </div>
              </div>
              <div class="mt-5 border-b border-stone-200"></div>
            </a>
          @endforeach
        </div>
      </div>

      <div class="mt-10">
        {{ $posts->withQueryString()->links() }}
      </div>
    </div>
  </div>
@endsection


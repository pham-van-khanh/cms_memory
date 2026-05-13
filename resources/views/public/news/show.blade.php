@extends('layouts.app')

@section('content')
  <div class="pt-24 pb-16">
    <div class="max-w-3xl mx-auto px-8">
      <div class="text-center">
        <div class="inline-flex items-center gap-3 px-4 py-2 rounded-full border border-stone-200 bg-white/70 backdrop-blur">
          <span class="text-rose-400">📰</span>
          <span class="text-xs tracking-widest uppercase text-stone-500">
            {{ ($post->published_at ?? $post->created_at)->format('d M Y') }}
          </span>
        </div>

        <h1 class="mt-6 font-display text-4xl text-stone-900 leading-tight">
          {{ $post->title }}
        </h1>
      </div>

      <div class="mt-10 rounded-3xl border border-stone-200 bg-white/70 backdrop-blur p-8">
        <article class="prose prose-stone max-w-none text-stone-700">
          {!! $post->content !!}
        </article>
      </div>
    </div>
  </div>
@endsection


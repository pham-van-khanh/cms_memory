@extends('layouts.admin')

@section('page-title','Edit News')

@section('content')
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <h2 class="font-display text-2xl text-stone-900">Edit News</h2>
      <p class="text-sm text-stone-600 mt-1">Update title and content.</p>

      <form class="mt-6 space-y-5" method="POST" action="{{ route('admin.news.update',$post) }}">
        @csrf
        @method('PUT')

        <div>
          <label class="text-sm text-stone-700">Title</label>
          <input type="text" name="title" value="{{ old('title',$post->title) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
        </div>

        <div>
          <label class="text-sm text-stone-700">Content</label>
          <textarea name="content" rows="10" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">{{ old('content',$post->content) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
          <input type="hidden" name="published" value="0">
          <input type="checkbox" name="published" value="1" id="published" class="h-4 w-4" {{ $post->published ? 'checked' : '' }}>
          <label for="published" class="text-sm text-stone-700">Published</label>
        </div>

        <div class="flex items-center gap-3">
          <button class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl text-xs tracking-widest uppercase transition">
            Save
          </button>
          <a href="{{ route('admin.news.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition no-underline">
            Back
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection


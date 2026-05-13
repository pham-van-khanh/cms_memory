@extends('layouts.admin')

@section('page-title','Create Blog Post')

@section('content')
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <h2 class="font-display text-2xl text-stone-900">Create Blog Post</h2>
      <p class="text-sm text-stone-600 mt-1">Write a new blog post with category, excerpt, and rich content.</p>

      <form class="mt-6 space-y-5" method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
          <label class="text-sm text-stone-700">Title</label>
          <input type="text" name="title" value="{{ old('title') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
        </div>
        <div>
          <label class="text-sm text-stone-700">Slug</label>
          <input type="text" name="slug" value="{{ old('slug') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
        </div>

        <div>
          <label class="text-sm text-stone-700">Category</label>
          <select name="category_id" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            <option value="">(none)</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="text-sm text-stone-700">Excerpt</label>
          <input type="text" name="excerpt" value="{{ old('excerpt') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" maxlength="500">
        </div>

        <div>
          <label class="text-sm text-stone-700">Content</label>
          <textarea name="content" rows="8" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">{{ old('content') }}</textarea>
        </div>

        <div>
          <label class="text-sm text-stone-700">Cover image</label>
          <input type="file" name="cover_image" accept="image/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
        </div>

        <div>
          <label class="text-sm text-stone-700">Tags (comma separated)</label>
          <input type="text" name="tags" value="{{ old('tags') }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" placeholder="tag1, tag2">
        </div>

        <div class="flex items-center gap-3">
          <input type="hidden" name="published" value="0">
          <input type="checkbox" name="published" value="1" id="published" class="h-4 w-4">
          <label for="published" class="text-sm text-stone-700">Published</label>
        </div>

        <div class="flex items-center gap-3">
          <button class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl text-xs tracking-widest uppercase transition">
            Create
          </button>
          <a href="{{ route('admin.blog.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition no-underline">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection


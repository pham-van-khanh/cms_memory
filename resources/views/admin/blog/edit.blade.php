@extends('layouts.admin')

@section('page-title','Edit Blog Post')

@section('content')
  <div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <h2 class="font-display text-2xl text-stone-900">Edit Blog Post</h2>
      <p class="text-sm text-stone-600 mt-1">Update content and publication state.</p>

      <form class="mt-6 space-y-5" method="POST" action="{{ route('admin.blog.update',$post) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
          <label class="text-sm text-stone-700">Title</label>
          <input type="text" name="title" value="{{ old('title',$post->title) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
        </div>
        <div>
          <label class="text-sm text-stone-700">Slug</label>
          <input type="text" name="slug" value="{{ old('slug',$post->slug) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
        </div>

        <div>
          <label class="text-sm text-stone-700">Category</label>
          <select name="category_id" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
            <option value="">(none)</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ (old('category_id',$post->category_id) == $c->id) ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="text-sm text-stone-700">Excerpt</label>
          <input type="text" name="excerpt" value="{{ old('excerpt',$post->excerpt) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" maxlength="500">
        </div>

        <div>
          <label class="text-sm text-stone-700">Content</label>
          <textarea name="content" rows="8" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">{{ old('content',$post->content) }}</textarea>
        </div>

        <div>
          <label class="text-sm text-stone-700">Cover image</label>
          <input type="file" name="cover_image" accept="image/*" class="mt-2 w-full rounded-xl border border-stone-200 px-3 py-2 text-sm">
          @if($post->cover_image)
            <div class="mt-3">
              <img src="{{ $post->cover_url }}" alt="Cover preview" class="h-24 w-24 object-cover rounded-xl border border-stone-200">
            </div>
          @endif
        </div>

        <div>
          <label class="text-sm text-stone-700">Tags (comma separated)</label>
          @php $tagsStr = is_array($post->tags) ? implode(', ', $post->tags) : ($post->tags ?? ''); @endphp
          <input type="text" name="tags" value="{{ old('tags',$tagsStr) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" placeholder="tag1, tag2">
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
          <a href="{{ route('admin.blog.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition no-underline">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection


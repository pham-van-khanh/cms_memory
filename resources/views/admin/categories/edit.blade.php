@extends('layouts.admin')

@section('page-title','Edit Category')

@section('content')
  <div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-stone-200 p-6 shadow-sm">
      <h2 class="font-display text-2xl text-stone-900">Edit Category</h2>
      <p class="text-sm text-stone-600 mt-1">Update shared taxonomy fields.</p>

      <form class="mt-6 space-y-5" method="POST" action="{{ route('admin.categories.update',$category) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="text-sm text-stone-700">Name</label>
            <input type="text" name="name" value="{{ old('name',$category->name) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm" required>
          </div>
          <div>
            <label class="text-sm text-stone-700">Slug</label>
            <input type="text" name="slug" value="{{ old('slug',$category->slug) }}" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
          </div>
        </div>

        <div>
          <label class="text-sm text-stone-700">Description</label>
          <textarea name="description" rows="3" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">{{ old('description',$category->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label class="text-sm text-stone-700">Color</label>
            <input type="color" name="color" value="{{ old('color',$category->color) }}" class="mt-2 h-10 w-full rounded-xl border border-stone-200 px-2 py-1 bg-white">
            <div class="mt-2 text-xs text-stone-500">{{ old('color',$category->color) }}</div>
          </div>
          <div class="md:col-span-2">
            <div class="text-sm text-stone-700 mb-2">Type</div>
            <div class="flex flex-wrap gap-3">
              @foreach(['general','memory','blog','news'] as $t)
                <label class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border border-stone-200 bg-stone-50 cursor-pointer">
                  <input type="radio" name="type" value="{{ $t }}" {{ old('type',$category->type) === $t ? 'checked' : '' }}>
                  <span class="text-sm text-stone-700">{{ ucfirst($t) }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>

        <div>
          <label class="text-sm text-stone-700">Sort order</label>
          <input type="number" name="sort_order" value="{{ old('sort_order',$category->sort_order) }}" min="0" class="mt-2 w-full rounded-xl border border-stone-200 px-4 py-2 text-sm">
        </div>

        <div class="flex items-center gap-3">
          <button class="bg-rose-500 hover:bg-rose-600 text-white px-5 py-2 rounded-xl text-xs tracking-widest uppercase transition">
            Save
          </button>
          <a href="{{ route('admin.categories.index') }}" class="text-xs tracking-widest uppercase text-stone-600 hover:text-rose-500 transition no-underline">
            Back
          </a>
        </div>
      </form>
    </div>
  </div>
@endsection


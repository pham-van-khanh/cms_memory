@extends('layouts.app')

@section('content')
  <div class="pt-24 min-h-[60vh] flex items-center justify-center px-6 pb-16">
    <div class="relative">
      {{-- Polaroid frame --}}
      <div class="bg-white rounded-2xl shadow-2xl border border-stone-200 p-6 transform rotate-[-2deg]">
        <div class="flex items-center gap-3">
          <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
          <p class="text-xs tracking-widest uppercase text-stone-500">Protected Memory</p>
        </div>

        <h1 class="mt-4 font-display text-3xl text-stone-900">{{ $memory->title }}</h1>
        <p class="mt-2 text-sm text-stone-600 leading-relaxed">
          Enter the password to open this story.
        </p>

        @if($errors->any())
          <div class="mt-5 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
            <ul class="list-disc list-inside space-y-1">
              @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form class="mt-6" method="POST" action="{{ route('memory.unlock.post', $memory->slug) }}">
          @csrf
          <label class="block text-xs tracking-widest uppercase text-stone-500 mb-2" for="password">Password</label>
          <input id="password"
                 name="password"
                 type="password"
                 class="w-full rounded-xl border border-stone-200 bg-white px-4 py-3 text-stone-800 focus:outline-none focus:ring-2 focus:ring-rose-200"
                 placeholder="••••">
          <div class="mt-5 flex items-center gap-3">
            <button class="px-6 py-3 rounded-full bg-rose-400 text-white text-xs tracking-widest uppercase hover:brightness-110 transition no-underline">
              Unlock
            </button>
            <a href="{{ route('home') }}" class="text-xs tracking-widest uppercase text-stone-500 hover:text-rose-500 transition no-underline">
              Back
            </a>
          </div>
        </form>
      </div>

      {{-- Small shadow --}}
      <div class="absolute -bottom-2 left-6 w-[92%] h-6 bg-black/10 blur-xl rounded-full -z-10"></div>
    </div>
  </div>
@endsection


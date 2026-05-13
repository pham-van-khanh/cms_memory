<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin · @yield('title','CMS')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500&family=Pinyon+Script&display=swap" rel="stylesheet">
  @stack('styles')
</head>
<body class="bg-stone-100 font-sans min-h-screen">
<div class="flex min-h-screen">

  {{-- SIDEBAR: dark (#1e1b18), logo top, nav links, "view site" bottom --}}
  <aside class="w-56 bg-[#1e1b18] text-stone-400 flex flex-col flex-shrink-0 fixed h-full">
    <div class="px-6 py-5 border-b border-stone-700/50">
      <a href="{{ route('admin.dashboard') }}" class="font-script text-2xl text-rose-400 block">Our CMS</a>
    </div>
    <nav class="flex-1 py-3 overflow-y-auto">
      @foreach([
        ['route'=>'admin.dashboard',       'icon'=>'📊','label'=>'Dashboard'],
        ['route'=>'admin.memories.index',  'icon'=>'♡', 'label'=>'Memories'],
        ['route'=>'admin.blog.index',      'icon'=>'✍', 'label'=>'Blog'],
        ['route'=>'admin.news.index',      'icon'=>'📰','label'=>'News'],
        ['route'=>'admin.categories.index','icon'=>'🏷','label'=>'Categories'],
      ] as $item)
      <a href="{{ route($item['route']) }}"
         class="flex items-center gap-3 px-5 py-2.5 text-sm transition-colors
                {{ request()->routeIs($item['route'].'*') ? 'bg-stone-700/50 text-white border-l-2 border-rose-400 pl-[18px]' : 'hover:bg-stone-800 hover:text-white' }}">
        <span>{{ $item['icon'] }}</span> {{ $item['label'] }}
      </a>
      @endforeach
    </nav>
    <div class="px-5 py-4 border-t border-stone-700/50 text-xs">
      <a href="{{ route('home') }}" target="_blank" class="hover:text-white transition-colors">← Xem trang web</a>
    </div>
  </aside>

  {{-- CONTENT AREA --}}
  <div class="flex-1 flex flex-col ml-56">
    <header class="bg-white border-b border-stone-200 px-8 py-4 flex items-center justify-between sticky top-0 z-10">
      <h1 class="text-base font-medium text-stone-700">@yield('page-title','Dashboard')</h1>
      <div class="flex items-center gap-4 text-sm text-stone-500">
        <span class="font-medium text-stone-700">{{ auth()->user()->name }}</span>
        <form action="{{ route('logout') }}" method="POST" class="inline">
          @csrf <button class="hover:text-rose-500 transition-colors text-xs">Đăng xuất</button>
        </form>
      </div>
    </header>
    <main class="flex-1 p-8">
      @if(session('success'))
      <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-lg px-4 py-3 text-sm flex items-center gap-2">
        {{ session('success') }}
      </div>
      @endif
      @if($errors->any())
      <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 text-sm">
        <ul class="list-disc list-inside space-y-1">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
      @endif
      @yield('content')
    </main>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js" defer></script>
@stack('scripts')
</body>
</html>


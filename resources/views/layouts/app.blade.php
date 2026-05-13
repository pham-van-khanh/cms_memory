<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','Our CMS') · ♡</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;1,300;1,400&family=Caveat:wght@400;600&family=DM+Sans:wght@300;400;500&family=Pinyon+Script&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
  @stack('styles')
</head>
<body class="font-sans font-light antialiased">
  {{-- NAV: transparent → solid on scroll, Alpine.js x-data --}}
  <nav x-data="{s:false}" x-init="window.addEventListener('scroll',()=>s=scrollY>60)"
       :class="s?'bg-white/90 backdrop-blur-md shadow-sm border-b border-stone-100':''"
       class="fixed inset-x-0 top-0 z-50 transition-all duration-300 px-8 py-4 flex items-center justify-between">
    <a href="/" class="font-script text-3xl text-rose-400 no-underline">Our Memories</a>
    <div class="hidden md:flex items-center gap-8 text-xs tracking-widest uppercase text-stone-500">
      <a href="/" class="hover:text-rose-400 transition-colors">Memories</a>
      <a href="{{ route('blog.index') }}" class="hover:text-rose-400 transition-colors">Blog</a>
      <a href="{{ route('news.index') }}" class="hover:text-rose-400 transition-colors">News</a>
    </div>
  </nav>

  <main>@yield('content')</main>

  <footer class="bg-stone-900 text-stone-500 text-center py-12">
    <span class="font-script text-3xl text-rose-400 block mb-2">Our Memories</span>
    <p class="text-xs tracking-widest uppercase">Made with love · {{ date('Y') }}</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3/dist/cdn.min.js" defer></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init({duration:800,easing:'ease-out-cubic',once:true,offset:50});</script>
  @stack('scripts')
</body>
</html>

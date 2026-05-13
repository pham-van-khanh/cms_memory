@php
    $id = $id ?? 'lb';
@endphp

<div id="lightbox-{{ $id }}"
     class="fixed inset-0 z-[1000] hidden items-center justify-center">
  <div class="absolute inset-0 bg-black/80"></div>
  <div class="relative z-[1001] max-w-[94vw] max-h-[92vh] flex flex-col items-center">
    <img id="lightbox-img-{{ $id }}"
         class="max-w-[94vw] max-h-[82vh] object-contain rounded-lg shadow-2xl bg-black"
         alt="Lightbox image">
    <div id="lightbox-caption-{{ $id }}" class="mt-3 text-stone-100/90 text-xs tracking-wide"></div>
  </div>
</div>

<script>
  (function(){
    const lb = document.getElementById('lightbox-{{ $id }}');
    if(!lb) return;
    const img = document.getElementById('lightbox-img-{{ $id }}');
    const caption = document.getElementById('lightbox-caption-{{ $id }}');

    function open(src, cap){
      img.src = src;
      caption.textContent = cap || '';
      lb.classList.remove('hidden');
      lb.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function close(){
      lb.classList.add('hidden');
      lb.classList.remove('flex');
      document.body.style.overflow = '';
      if(img) img.src = '';
    }

    document.querySelectorAll('[data-lightbox-src]').forEach(el=>{
      el.addEventListener('click', (e)=>{
        e.preventDefault();
        open(el.getAttribute('data-lightbox-src'), el.getAttribute('data-lightbox-caption'));
      });
    });

    lb.addEventListener('click', (e)=>{
      if(e.target === lb || e.target.classList.contains('bg-black/80')) close();
    });

    window.addEventListener('keydown', (e)=>{
      if(e.key === 'Escape' && !lb.classList.contains('hidden')) close();
    });
  })();
</script>


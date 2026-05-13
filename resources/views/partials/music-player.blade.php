@php
    $playerId = $playerId ?? 'music';
    $musicUrl = $musicUrl ?? null;
    $accentColor = $accentColor ?? '#c9847a';
@endphp

@if(!empty($musicUrl))
  <audio id="music-audio-{{ $playerId }}" src="{{ $musicUrl }}" preload="none"></audio>

  <div class="fixed bottom-6 right-6 z-[900]">
    <button type="button"
            id="music-toggle-{{ $playerId }}"
            style="background-color: {{ $accentColor }}; opacity: .92;"
            class="inline-flex items-center gap-2 rounded-full px-4 py-3 shadow-lg border border-white/20
                   text-stone-50 hover:brightness-110 transition">
      <span id="music-icon-{{ $playerId }}">▶</span>
      <span class="text-xs tracking-widest uppercase">Music</span>
    </button>
  </div>

  <script>
    (function(){
      const btn = document.getElementById('music-toggle-{{ $playerId }}');
      const audio = document.getElementById('music-audio-{{ $playerId }}');
      const icon = document.getElementById('music-icon-{{ $playerId }}');
      if(!btn || !audio || !icon) return;

      function setPlaying(playing){
        icon.textContent = playing ? '⏸' : '▶';
      }

      btn.addEventListener('click', async ()=>{
        try{
          if(audio.paused){
            await audio.play();
          } else {
            audio.pause();
          }
        }catch(e){}
      });

      audio.addEventListener('play', ()=>setPlaying(true));
      audio.addEventListener('pause', ()=>setPlaying(false));
    })();
  </script>
@endif


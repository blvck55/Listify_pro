{{-- FILE: resources/views/tasks/history.blade.php --}}
<x-app-layout pageTitle="Task History">

  {{-- Header with SVG illustration --}}
  <div class="lf-fade-up" style="background:linear-gradient(135deg,#6366F1,#8B5CF6);
              border-radius:var(--r-xl);padding:2rem 2.25rem;margin-bottom:2rem;
              position:relative;overflow:hidden;box-shadow:var(--shadow-md)">

    <div style="position:absolute;top:-30px;right:-30px;width:180px;height:180px;
                border-radius:50%;background:rgba(255,255,255,.06);pointer-events:none"></div>

    {{-- Timeline SVG --}}
    <div style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);opacity:.22;pointer-events:none">
      <svg width="100" height="90" viewBox="0 0 100 90" fill="none" xmlns="http://www.w3.org/2000/svg">
        <line x1="22" y1="10" x2="22" y2="80" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
        <circle cx="22" cy="20" r="7" fill="white"/>
        <path d="M18 20l3 3 6-6" stroke="#6366F1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <rect x="36" y="15" width="50" height="10" rx="5" fill="white" opacity=".6"/>
        <circle cx="22" cy="45" r="7" fill="white" opacity=".7"/>
        <rect x="36" y="40" width="38" height="10" rx="5" fill="white" opacity=".4"/>
        <circle cx="22" cy="70" r="7" fill="white" opacity=".5"/>
        <rect x="36" y="65" width="44" height="10" rx="5" fill="white" opacity=".3"/>
      </svg>
    </div>

    <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem">
      <div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                    color:rgba(255,255,255,.7);margin-bottom:.35rem">
          <i class="fa-solid fa-clock-rotate-left" style="margin-right:5px"></i> Audit trail
        </div>
        <div style="font-family:var(--font-head);font-size:1.6rem;font-weight:800;
                    color:#fff;letter-spacing:-.03em">Task History</div>
        <div style="font-size:13px;color:rgba(255,255,255,.75);margin-top:.25rem">
          Every action on your tasks, in chronological order.
        </div>
      </div>
      <a href="{{ route('dashboard') }}" class="lf-btn lf-btn-sm"
         style="background:rgba(255,255,255,.15);color:#fff;border:1px solid rgba(255,255,255,.25);
                backdrop-filter:blur(8px)">
        <i class="fa-solid fa-arrow-left"></i> Dashboard
      </a>
    </div>
  </div>

  {{-- Livewire activity feed --}}
  <livewire:task-history-feed />

</x-app-layout>

{{-- FILE: resources/views/dashboard.blade.php --}}
<x-app-layout pageTitle="My Tasks">

  {{-- HERO HEADER --}}
  <div class="lf-fade-up" style="background:linear-gradient(135deg,var(--brand),#6366F1);
              border-radius:var(--r-xl);padding:2rem 2rem 2rem 2.25rem;
              margin-bottom:2rem;position:relative;overflow:hidden;box-shadow:var(--shadow-md)">

    {{-- Decorative circles --}}
    <div style="position:absolute;top:-30px;right:-30px;width:200px;height:200px;
                border-radius:50%;background:rgba(255,255,255,.06);pointer-events:none"></div>
    <div style="position:absolute;bottom:-20px;right:160px;width:100px;height:100px;
                border-radius:50%;background:rgba(255,255,255,.04);pointer-events:none"></div>

    {{-- Inline SVG illustration (right side) --}}
    <div style="position:absolute;right:2rem;top:50%;transform:translateY(-50%);opacity:.25;pointer-events:none">
      <svg width="120" height="100" viewBox="0 0 120 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="10" y="10" width="100" height="80" rx="10" fill="white"/>
        <rect x="20" y="25" width="50" height="7" rx="3.5" fill="white" opacity=".6"/>
        <rect x="20" y="40" width="65" height="7" rx="3.5" fill="white" opacity=".4"/>
        <rect x="20" y="55" width="40" height="7" rx="3.5" fill="white" opacity=".3"/>
        <circle cx="95" cy="72" r="14" fill="white" opacity=".15"/>
        <path d="M89 72l4 4 8-8" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <div style="position:relative;z-index:1;max-width:500px">
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                  color:rgba(255,255,255,.7);margin-bottom:.4rem">
        <i class="fa-solid fa-circle-check" style="margin-right:5px"></i>
        Welcome back
      </div>
      <div style="font-family:var(--font-head);font-size:1.6rem;font-weight:800;color:#fff;
                  letter-spacing:-.03em;margin-bottom:.35rem">
        {{ Auth::user()->name }}
      </div>
      <div style="font-size:13px;color:rgba(255,255,255,.75)">
        Here are your pending tasks for today. Stay focused!
      </div>
    </div>
  </div>

  {{-- INLINE TASK FORM --}}
  <livewire:task-form />

  {{-- LIVEWIRE: Live search + task grid --}}
  <livewire:task-search />

  {{-- BOTTOM ACTION PANELS --}}
  <div class="lf-grid-2" style="margin-top:2.5rem">

    <a href="{{ route('tasks.history') }}" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">History</div>
        <div class="lf-panel-action-title">View completed tasks</div>
        <div class="lf-panel-action-desc">Browse your full task history and audit trail.</div>
      </div>
      <div style="margin-top:1rem">
        <span class="lf-btn lf-btn-ghost lf-btn-sm">
          <i class="fa-solid fa-clock-rotate-left"></i> View history
        </span>
      </div>
      <i class="fa-solid fa-clock-rotate-left bg-icon"></i>
    </a>

    <div class="lf-panel-action" style="cursor:default">
      <div>
        <div class="lf-panel-action-label">Activity</div>
        <div class="lf-panel-action-title">Task activity feed</div>
        <div class="lf-panel-action-desc">Track every action on your tasks in real time.</div>
      </div>
      <div style="margin-top:1rem">
        <a href="{{ route('tasks.history') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
          <i class="fa-solid fa-list-ul"></i> View feed
        </a>
      </div>
      <i class="fa-solid fa-list-ul bg-icon"></i>
    </div>

  </div>

  {{-- CATEGORIES SECTION --}}
  <div style="margin-top:2.5rem">
    <details>
      <summary style="cursor:pointer;list-style:none;display:flex;align-items:center;gap:.5rem;
                      font-size:14px;font-weight:700;color:var(--text-primary);
                      padding:.75rem 0;border-top:1px solid var(--border)">
        <i class="fa-solid fa-chevron-right" style="font-size:11px;transition:transform .2s;color:var(--text-muted)"></i>
        <i class="fa-solid fa-tag" style="color:var(--brand);font-size:13px"></i>
        Manage Categories
      </summary>
      <div style="padding-top:1rem">
        <livewire:category-manager />
      </div>
    </details>
  </div>

  <script>
    document.querySelectorAll('details').forEach(d => {
      d.addEventListener('toggle', () => {
        const chevron = d.querySelector('summary .fa-chevron-right');
        if (chevron) chevron.style.transform = d.open ? 'rotate(90deg)' : '';
      });
    });
  </script>

</x-app-layout>

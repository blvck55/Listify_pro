{{-- FILE: resources/views/dashboard.blade.php --}}
<x-app-layout pageTitle="My Tasks">

  {{-- WELCOME --}}
  <div class="lf-welcome">
    <i class="fa-solid fa-circle-check"></i>
    Welcome back, <strong>{{ Auth::user()->name }}</strong>!
  </div>

  {{-- PAGE HEADER --}}
  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">My Tasks</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        Manage your pending tasks below
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
    // Rotate chevron when details open
    document.querySelectorAll('details').forEach(d => {
      d.addEventListener('toggle', () => {
        const chevron = d.querySelector('summary .fa-chevron-right');
        if (chevron) chevron.style.transform = d.open ? 'rotate(90deg)' : '';
      });
    });
  </script>

</x-app-layout>

{{--
  FILE: resources/views/layouts/app.blade.php
  Authenticated layout — professional navbar with:
  • DM Sans + Inter Google Fonts
  • Dark mode toggle (persists via localStorage)
  • Sticky nav: Logo | Tab nav (centre) | Bell + Profile + Theme (right)
  • Flash messages
  • Footer
--}}
<!doctype html>
<html lang="en" class="">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Listify — {{ $pageTitle ?? 'Dashboard' }}</title>

  {{-- Google Fonts: DM Sans (headings) + Inter (body) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

  {{-- Font Awesome 6 for icons --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles

  {{-- Apply dark mode BEFORE paint to avoid flash --}}
  <script>
    (function() {
      if (localStorage.getItem('lf-theme') === 'dark' ||
          (!localStorage.getItem('lf-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
</head>

<body style="background:var(--bg-page);color:var(--text-primary);font-family:var(--font-body);min-height:100vh;">

{{-- ═══════════════════════════════════════
     NAVBAR
════════════════════════════════════ --}}
<nav class="lf-nav">
  <div class="lf-wrap lf-nav-inner">

    {{-- LEFT: Logo --}}
    <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
       class="lf-logo">
      <div class="lf-logo-badge">L</div>
      <span class="lf-logo-text">Listify</span>
    </a>

    {{-- CENTRE: Tab navigation --}}
    <div class="lf-nav-tabs" style="position:absolute;left:50%;transform:translateX(-50%);">
      @if(Auth::user()->isAdmin())
        <a href="{{ route('admin.users') }}"
           class="lf-tab {{ request()->routeIs('admin.users') ? 'active' : '' }}">
          <i class="fa-solid fa-users fa-xs" style="margin-right:5px;opacity:.7"></i>Users
        </a>
        <a href="{{ route('admin.dashboard') }}"
           class="lf-tab {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-list-check fa-xs" style="margin-right:5px;opacity:.7"></i>Tasks
        </a>
        <a href="{{ route('admin.reports') }}"
           class="lf-tab {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
          <i class="fa-solid fa-chart-bar fa-xs" style="margin-right:5px;opacity:.7"></i>Reports
        </a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
          @csrf
          <button class="lf-tab">
            <i class="fa-solid fa-right-from-bracket fa-xs" style="margin-right:5px;opacity:.7"></i>Logout
          </button>
        </form>
      @else
        <a href="{{ route('dashboard') }}"
           class="lf-tab {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <i class="fa-solid fa-house fa-xs" style="margin-right:5px;opacity:.7"></i>Dashboard
        </a>
        <a href="{{ route('tasks.history') }}"
           class="lf-tab {{ request()->routeIs('tasks.history') ? 'active' : '' }}">
          <i class="fa-solid fa-clock-rotate-left fa-xs" style="margin-right:5px;opacity:.7"></i>History
        </a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
          @csrf
          <button class="lf-tab">
            <i class="fa-solid fa-right-from-bracket fa-xs" style="margin-right:5px;opacity:.7"></i>Logout
          </button>
        </form>
      @endif
    </div>

    {{-- RIGHT: Theme toggle + Bell + Profile --}}
    <div class="lf-nav-right">

      {{-- Dark mode toggle --}}
      <button class="lf-theme-toggle" id="themeToggle" title="Toggle dark mode">
        <i class="fa-solid fa-moon" id="themeIcon"></i>
      </button>

      {{-- Bell (notifications) — Livewire component --}}
      <livewire:notification-bell />

      {{-- Profile --}}
      <div style="position:relative">
        <button class="lf-icon-btn" onclick="toggleDropdown('profileDrop')" title="Account">
          <i class="fa-regular fa-circle-user"></i>
        </button>
        <div class="lf-dropdown" id="profileDrop">
          <div class="lf-dropdown-header">
            <div style="font-size:14px;font-weight:700;color:var(--text-primary)">{{ Auth::user()->name }}</div>
            <div style="font-size:12px;color:var(--text-muted)">{{ Auth::user()->email }}</div>
            <span class="lf-badge-{{ Auth::user()->isAdmin() ? 'blue' : 'gray' }} lf-badge" style="margin-top:6px">
              {{ Auth::user()->role }}
            </span>
          </div>
          @if(Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="lf-dropdown-item">
              <i class="fa-solid fa-gauge" style="font-size:14px"></i> Admin Panel
            </a>
          @else
            <a href="{{ route('dashboard') }}" class="lf-dropdown-item">
              <i class="fa-solid fa-house" style="font-size:14px"></i> Dashboard
            </a>
          @endif
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="lf-dropdown-item danger" style="border-top:1px solid var(--border);width:100%">
              <i class="fa-solid fa-right-from-bracket" style="font-size:14px"></i> Sign out
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</nav>

{{-- ═══════════════════════════════════════
     FLASH MESSAGES
════════════════════════════════════ --}}
@if(session('success') || session('error'))
  <div class="lf-wrap" style="margin-top:1rem">
    @if(session('success'))
      <div class="lf-alert lf-alert-success">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="lf-alert lf-alert-error">
        <i class="fa-solid fa-triangle-exclamation"></i>
        {{ session('error') }}
      </div>
    @endif
  </div>
@endif

{{-- ═══════════════════════════════════════
     PAGE CONTENT
════════════════════════════════════ --}}
<main class="lf-wrap" style="padding-top:2rem;padding-bottom:3rem">
  {{ $slot }}
</main>

{{-- ═══════════════════════════════════════
     FOOTER
════════════════════════════════════ --}}
<footer class="lf-footer">
  <div class="lf-wrap" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem">
    <div style="display:flex;align-items:center;gap:8px">
      <div class="lf-logo-badge" style="width:24px;height:24px;font-size:11px">L</div>
      <span style="font-size:12px;color:var(--text-muted);font-weight:600">Listify</span>
    </div>
    <div style="display:flex;gap:1.5rem">
      <a href="#">About</a>
      <a href="#">Contact</a>
      <a href="#">Terms</a>
    </div>
  </div>
</footer>

{{-- ═══════════════════════════════════════
     JS: Dark mode + Dropdowns
════════════════════════════════════ --}}
<script>
// Dark mode
const html = document.documentElement;
const btn  = document.getElementById('themeToggle');
const icon = document.getElementById('themeIcon');

function applyTheme(dark) {
  html.classList.toggle('dark', dark);
  icon.className = dark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
}
applyTheme(html.classList.contains('dark'));

btn.addEventListener('click', () => {
  const isDark = !html.classList.contains('dark');
  applyTheme(isDark);
  localStorage.setItem('lf-theme', isDark ? 'dark' : 'light');
});

// Dropdowns
function toggleDropdown(id) {
  const el = document.getElementById(id);
  const open = el.classList.contains('open');
  document.querySelectorAll('.lf-dropdown').forEach(d => d.classList.remove('open'));
  if (!open) el.classList.add('open');
}
document.addEventListener('click', e => {
  if (!e.target.closest('.lf-icon-btn') && !e.target.closest('.lf-dropdown')) {
    document.querySelectorAll('.lf-dropdown').forEach(d => d.classList.remove('open'));
  }
});
</script>

@livewireScripts
</body>
</html>

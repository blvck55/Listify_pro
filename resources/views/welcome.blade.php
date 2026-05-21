{{-- FILE: resources/views/welcome.blade.php --}}
<!doctype html>
<html lang="en" class="">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Listify — Manage Your Tasks</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script>(function(){if(localStorage.getItem('lf-theme')==='dark'||(!localStorage.getItem('lf-theme')&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark');}})();</script>
</head>
<body style="background:var(--bg-page);font-family:var(--font-body);min-height:100vh;">

{{-- NAV --}}
<nav class="lf-nav">
  <div class="lf-wrap lf-nav-inner">
    <div class="lf-logo">
      <div class="lf-logo-badge">L</div>
      <span class="lf-logo-text">Listify</span>
    </div>
    <div class="lf-nav-right">
      <button class="lf-theme-toggle" id="themeToggle">
        <i class="fa-solid fa-moon" id="themeIcon"></i>
      </button>
      <a href="{{ route('login') }}" class="lf-btn lf-btn-ghost lf-btn-sm">Sign in</a>
      <a href="{{ route('register') }}" class="lf-btn lf-btn-primary lf-btn-sm">Get started</a>
    </div>
  </div>
</nav>

{{-- HERO --}}
<div class="lf-wrap" style="padding-top:5rem;padding-bottom:4rem">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center">

    {{-- Left --}}
    <div>
      <div class="lf-badge lf-badge-blue" style="margin-bottom:1.25rem;display:inline-flex">
        <i class="fa-solid fa-bolt" style="margin-right:5px"></i> Task Management, Simplified
      </div>
      <h1 style="font-family:var(--font-head);font-size:3.2rem;font-weight:800;letter-spacing:-.04em;line-height:1.05;color:var(--text-primary);margin:0 0 1.25rem">
        Stay focused.<br>Ship faster.
      </h1>
      <p style="font-size:1.05rem;color:var(--text-secondary);line-height:1.7;margin:0 0 2rem;max-width:400px">
        Listify helps you create, manage, and track your tasks with a clean, professional interface. Built for individuals who value clarity.
      </p>
      <div style="display:flex;gap:.75rem;flex-wrap:wrap">
        <a href="{{ route('register') }}" class="lf-btn lf-btn-primary lf-btn-lg">
          Get started free <i class="fa-solid fa-arrow-right" style="margin-left:6px"></i>
        </a>
        <a href="{{ route('login') }}" class="lf-btn lf-btn-secondary lf-btn-lg">Sign in</a>
      </div>
    </div>

    {{-- Right: App preview card --}}
    <div>
      <div class="lf-card" style="padding:1.5rem;position:relative;overflow:hidden">
        {{-- Mini navbar preview --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;padding-bottom:1rem;border-bottom:1px solid var(--border)">
          <div style="display:flex;align-items:center;gap:8px">
            <div class="lf-logo-badge" style="width:26px;height:26px;font-size:12px">L</div>
            <span style="font-size:13px;font-weight:700;color:var(--text-primary)">Listify</span>
          </div>
          <div style="display:flex;gap:6px">
            <span style="font-size:11px;font-weight:600;color:var(--brand);background:var(--brand-light);padding:4px 10px;border-radius:6px">Dashboard</span>
            <span style="font-size:11px;font-weight:500;color:var(--text-secondary);padding:4px 10px">History</span>
          </div>
        </div>

        {{-- Welcome --}}
        <div class="lf-welcome" style="margin-bottom:1rem">
          <i class="fa-solid fa-circle-check"></i> Welcome back, Alex!
        </div>

        {{-- Task tiles --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:1rem">
          @foreach([
            ['Design review',      'high',   '2026-05-15', 'completed'],
            ['API integration',    'medium', '2026-05-18', ''],
            ['Write tests',        'low',    '2026-05-20', ''],
            ['Deploy to staging',  'high',   '2026-05-22', ''],
          ] as [$t, $p, $d, $s])
          <div class="lf-task-tile {{ $s === 'completed' ? 'completed' : '' }}" style="min-height:100px;padding:1rem">
            <div>
              <div class="lf-task-tile-label">Task</div>
              <div class="lf-task-tile-title" style="font-size:.85rem">{{ $t }}</div>
            </div>
            <div style="display:flex;align-items:center;justify-content:space-between">
              <span class="lf-pill lf-pill-{{ $p }}">{{ $p }}</span>
              <span class="lf-task-tile-date">{{ $d }}</span>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>
</div>

{{-- FEATURES --}}
<div style="background:var(--bg-card);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:3.5rem 0">
  <div class="lf-wrap">
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2rem">
      @foreach([
        ['fa-list-check',        'Task CRUD',          'Create, edit, complete, and delete tasks with a clean interface.'],
        ['fa-clock-rotate-left', 'Task History',        'Full audit trail of every completed or modified task.'],
        ['fa-gauge',             'Admin Dashboard',     'Monitor all users and tasks. Role-based access control.'],
      ] as [$icon, $title, $desc])
      <div style="display:flex;flex-direction:column;gap:.75rem">
        <div style="width:44px;height:44px;background:var(--brand-light);border-radius:10px;display:flex;align-items:center;justify-content:center">
          <i class="fa-solid {{ $icon }}" style="color:var(--brand);font-size:18px"></i>
        </div>
        <div>
          <div style="font-family:var(--font-head);font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:.35rem">{{ $title }}</div>
          <div style="font-size:13px;color:var(--text-secondary);line-height:1.6">{{ $desc }}</div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>

{{-- FOOTER --}}
<footer class="lf-footer">
  <div class="lf-wrap" style="display:flex;align-items:center;justify-content:space-between">
    <span style="font-size:12px;color:var(--text-muted)">© 2026 Listify. All rights reserved.</span>
    <div style="display:flex;gap:1.5rem">
      <a href="#" style="font-size:12px;color:var(--text-muted);text-decoration:none">About</a>
      <a href="#" style="font-size:12px;color:var(--text-muted);text-decoration:none">Contact</a>
      <a href="#" style="font-size:12px;color:var(--text-muted);text-decoration:none">Terms</a>
    </div>
  </div>
</footer>

<script>
const html=document.documentElement,btn=document.getElementById('themeToggle'),icon=document.getElementById('themeIcon');
function applyTheme(d){html.classList.toggle('dark',d);icon.className=d?'fa-solid fa-sun':'fa-solid fa-moon';}
applyTheme(html.classList.contains('dark'));
btn.addEventListener('click',()=>{const d=!html.classList.contains('dark');applyTheme(d);localStorage.setItem('lf-theme',d?'dark':'light');});
</script>
</body>
</html>

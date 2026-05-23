{{-- FILE: resources/views/layouts/guest.blade.php --}}
<!doctype html>
<html lang="en" class="">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Listify</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
  <script>
    (function(){
      if(localStorage.getItem('lf-theme')==='dark'||
        (!localStorage.getItem('lf-theme')&&window.matchMedia('(prefers-color-scheme: dark)').matches)){
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
  <style>
    body{background:var(--bg-page);font-family:var(--font-body);min-height:100vh;}
  </style>
</head>
<body>

{{-- TOP BAR --}}
<div style="position:fixed;top:0;left:0;right:0;z-index:50;
            background:var(--bg-nav);border-bottom:1px solid var(--border);
            height:56px;display:flex;align-items:center;padding:0 1.5rem;
            justify-content:space-between">
  <a href="{{ route('welcome') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none">
    <img src="{{ asset('images/logo.svg') }}" alt="Listify logo" style="width:30px;height:30px;display:block" />
    <span class="lf-logo-text">Listify</span>
  </a>
  <button class="lf-theme-toggle" id="themeToggle" title="Toggle dark mode">
    <i class="fa-solid fa-moon" id="themeIcon"></i>
  </button>
</div>

<main style="min-height:100vh;display:flex;align-items:center;justify-content:center;padding:5rem 1rem 2rem">
  <div style="width:100%;max-width:440px">
    {{ $slot }}
  </div>
</main>

<script>
const html=document.documentElement,btn=document.getElementById('themeToggle'),icon=document.getElementById('themeIcon');
function applyTheme(d){html.classList.toggle('dark',d);icon.className=d?'fa-solid fa-sun':'fa-solid fa-moon';}
applyTheme(html.classList.contains('dark'));
btn.addEventListener('click',()=>{const d=!html.classList.contains('dark');applyTheme(d);localStorage.setItem('lf-theme',d?'dark':'light');});
</script>

@livewireScripts
</body>
</html>

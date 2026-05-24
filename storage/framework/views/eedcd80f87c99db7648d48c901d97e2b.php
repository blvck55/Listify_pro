<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Listify — Task management without the noise</title>
  <meta name="description" content="Listify brings clarity to your workday. Create, prioritize, and track tasks from a secure, distraction-free interface.">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

  
  <script>
    (function(){
      var t = localStorage.getItem('lf-theme');
      if(t==='dark'||(!t&&window.matchMedia('(prefers-color-scheme:dark)').matches))
        document.documentElement.classList.add('dark');
    })();
  </script>

  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; }

    /* ── Page-scoped colour tokens ────────────────────────── */
    :root {
      --wp-bg:     #070B14;
      --wp-card:   #0F172A;
      --wp-deep:   #0D1526;
      --wp-border: #1E293B;
      --wp-line:   #334155;
      --wp-faint:  #475569;
      --wp-dim:    #64748B;
      --wp-muted:  #94A3B8;
      --wp-soft:   #CBD5E1;
      --wp-text:   #F8FAFC;
    }
    html:not(.dark) {
      --wp-bg:     #FFFFFF;
      --wp-card:   #F8FAFC;
      --wp-deep:   #F1F5F9;
      --wp-border: #E2E8F0;
      --wp-line:   #CBD5E1;
      --wp-faint:  #94A3B8;
      --wp-dim:    #64748B;
      --wp-muted:  #475569;
      --wp-soft:   #334155;
      --wp-text:   #0F172A;
    }

    /* ── Entry animations ─────────────────────────────────── */
    @keyframes au {
      from { opacity:0; transform:translateY(16px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .au    { animation: au .65s cubic-bezier(.22,1,.36,1) both; }
    .au.d1 { animation-delay:.05s; }
    .au.d2 { animation-delay:.15s; }
    .au.d3 { animation-delay:.28s; }
    .au.d4 { animation-delay:.42s; }
    .au.d5 { animation-delay:.56s; }

    /* ── Scroll-reveal ────────────────────────────────────── */
    @keyframes rv {
      from { opacity:0; transform:translateY(18px); }
      to   { opacity:1; transform:translateY(0); }
    }
    .reveal { opacity:0; }
    .reveal.on { animation: rv .6s cubic-bezier(.22,1,.36,1) both; }

    /* ── Gradient headline word ───────────────────────────── */
    .grad {
      background: linear-gradient(120deg,#3B82F6 0%,#818CF8 60%,#A78BFA 100%);
      -webkit-background-clip:text;
      -webkit-text-fill-color:transparent;
      background-clip:text;
    }

    /* ── Hero background ──────────────────────────────────── */
    .hero-radial {
      background:
        radial-gradient(ellipse 70% 50% at 50% -5%,rgba(59,130,246,.1) 0%,transparent 65%);
    }
    .grid-overlay {
      background-image:
        linear-gradient(rgba(30,41,59,.14) 1px,transparent 1px),
        linear-gradient(90deg,rgba(30,41,59,.14) 1px,transparent 1px);
      background-size:64px 64px;
    }
    html:not(.dark) .grid-overlay {
      background-image:
        linear-gradient(rgba(0,0,0,.05) 1px,transparent 1px),
        linear-gradient(90deg,rgba(0,0,0,.05) 1px,transparent 1px);
    }

    /* ── Feature cards ────────────────────────────────────── */
    .feat-card {
      background:var(--wp-card);
      border:1px solid var(--wp-border);
      border-radius:14px;
      padding:1.5rem;
      transition:border-color .2s,background .2s;
    }
    .feat-card:hover { border-color:var(--wp-line); background:var(--wp-deep); }

    /* ── Theme toggle button ──────────────────────────────── */
    .theme-btn {
      width:32px; height:32px;
      border-radius:8px;
      border:1px solid var(--wp-border);
      background:var(--wp-card);
      color:var(--wp-muted);
      display:flex; align-items:center; justify-content:center;
      cursor:pointer;
      transition:border-color .2s,color .2s;
      font-size:13px;
    }
    .theme-btn:hover { border-color:var(--wp-line); color:var(--wp-text); }
  </style>
</head>

<body style="background:var(--wp-bg);color:var(--wp-text);overflow-x:hidden">


<header style="position:fixed;top:0;inset-inline:0;z-index:50;
               border-bottom:1px solid var(--wp-border);
               background:color-mix(in srgb,var(--wp-bg) 80%,transparent);
               backdrop-filter:blur(20px);-webkit-backdrop-filter:blur(20px)">
  <div class="max-w-6xl mx-auto px-6 h-14 flex items-center justify-between gap-6">

    
    <a href="<?php echo e(route('welcome')); ?>" class="flex items-center gap-2.5 flex-shrink-0"
       style="text-decoration:none">
      <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Listify" class="w-7 h-7 block" />
      <span class="text-sm font-bold tracking-tight" style="color:var(--wp-text)">Listify</span>
    </a>

    
    <nav class="hidden md:flex items-center gap-7">
      <a href="#features"  class="text-sm transition-colors" style="color:var(--wp-dim)">Features</a>
      <a href="#analytics" class="text-sm transition-colors" style="color:var(--wp-dim)">Analytics</a>
    </nav>

    
    <div class="flex items-center gap-3">

      
      <button class="theme-btn" id="themeToggle" title="Toggle dark / light mode">
        <i class="fa-solid fa-moon" id="themeIcon"></i>
      </button>

      
      <a href="<?php echo e(route('login')); ?>"
         class="text-sm px-3 py-1.5 transition-colors"
         style="color:var(--wp-dim)">
        Sign in
      </a>
      <a href="<?php echo e(route('register')); ?>"
         class="text-sm font-semibold px-4 py-1.5 rounded-lg transition-colors shadow-sm"
         style="background:#3B82F6;color:#fff">
        Get started
      </a>

    </div>
  </div>
</header>



<section class="hero-radial grid-overlay min-h-screen flex items-center pt-14">
  <div class="max-w-6xl mx-auto px-6 py-20 w-full">
    <div class="max-w-2xl">

      
      <div>

        
        <div class="au d1 inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                    text-xs font-medium mb-8"
             style="border:1px solid var(--wp-border);background:var(--wp-card);
                    color:var(--wp-muted)">
          <span class="w-1.5 h-1.5 rounded-full bg-[#22C55E] inline-block"></span>
          Designed by blvck · Free to start
        </div>

        
        <h1 class="au d2 font-extrabold tracking-[-0.04em] leading-[1.06] mb-5"
            style="font-size:clamp(2.4rem,5vw,4rem);color:var(--wp-text)">
          Task management<br>
          <span class="grad">without the noise.</span>
        </h1>

        
        <p class="au d3 text-lg leading-relaxed max-w-[420px] mb-8"
           style="color:var(--wp-muted)">
          Listify brings clarity to your workday. Create, prioritize, and complete tasks
          from one clean, focused interface — built for people who ship.
        </p>

        
        <div class="au d4 flex items-center gap-3 mb-10 flex-wrap">
          <a href="<?php echo e(route('register')); ?>"
             class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                    font-semibold text-sm transition-all duration-200"
             style="background:#3B82F6;color:#fff;
                    box-shadow:0 8px 24px rgba(59,130,246,.25)">
            Get started free
            <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
          <a href="<?php echo e(route('login')); ?>"
             class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                    font-medium text-sm transition-all duration-200"
             style="border:1px solid var(--wp-border);background:var(--wp-card);
                    color:var(--wp-text)">
            Sign in
          </a>
        </div>

        
        <div class="au d5 flex items-center gap-6 flex-wrap">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            ['fa-shield-halved','2FA + OAuth'],
            ['fa-lock',         'Rate limited'],
            ['fa-bolt',         'No credit card'],
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon, $text]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="flex items-center gap-1.5 text-xs" style="color:var(--wp-faint)">
            <i class="fa-solid <?php echo e($icon); ?> text-[10px]" style="color:#3B82F6"></i>
            <span><?php echo e($text); ?></span>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

      </div>

    </div>
  </div>
</section>



<div style="border-top:1px solid var(--wp-border);border-bottom:1px solid var(--wp-border);
            background:var(--wp-card)">
  <div class="max-w-6xl mx-auto px-6 py-8">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
        ['10 k+',  'Tasks created'],
        ['99.9 %', 'Uptime SLA'],
        ['500 +',  'Active users'],
        ['2FA',    'Security built-in'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$num, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="reveal">
        <div class="text-xl font-extrabold tracking-tight mb-1"
             style="color:var(--wp-text)"><?php echo e($num); ?></div>
        <div class="text-xs" style="color:var(--wp-faint)"><?php echo e($label); ?></div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</div>



<section id="features" class="py-24">
  <div class="max-w-6xl mx-auto px-6">

    <div class="max-w-xl mb-14 reveal">
      <p class="text-xs font-semibold uppercase tracking-widest mb-3"
         style="color:#3B82F6">Features</p>
      <h2 class="text-3xl lg:text-4xl font-extrabold tracking-[-0.03em] leading-tight mb-4"
          style="color:var(--wp-text)">
        Everything you need.<br>Nothing you don't.
      </h2>
      <p class="leading-relaxed" style="color:var(--wp-dim)">
        Built around how real people manage work — no bloat, no learning curve.
        Just the tools that help you stay on track.
      </p>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
        ['fa-list-check',        '#3B82F6', 'Task Management',
         'Create, edit, prioritize, and complete tasks from a clean, distraction-free interface.'],
        ['fa-clock-rotate-left', '#8B5CF6', 'Audit Trail',
         'Complete history of every task change. Nothing gets lost, everything is traceable.'],
        ['fa-gauge',             '#22C55E', 'Analytics Dashboard',
         'Visual productivity insights — completion rates, priority charts, overdue tracking.'],
        ['fa-tag',               '#F59E0B', 'Categories',
         'Colour-coded categories to organize work by project, context, or urgency.'],
        ['fa-bell',              '#EF4444', 'Notifications',
         'Real-time in-app notifications keep you informed on task updates and reminders.'],
        ['fa-code',              '#14B8A6', 'REST API',
         'Full authenticated API with pagination. Integrate Listify into any tool or workflow.'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon, $color, $title, $desc]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="feat-card reveal">
        <div class="w-9 h-9 rounded-lg flex items-center justify-center mb-4"
             style="background:<?php echo e($color); ?>1A">
          <i class="fa-solid <?php echo e($icon); ?> text-xs" style="color:<?php echo e($color); ?>"></i>
        </div>
        <h3 class="text-sm font-semibold mb-2" style="color:var(--wp-text)"><?php echo e($title); ?></h3>
        <p class="text-sm leading-relaxed" style="color:var(--wp-faint)"><?php echo e($desc); ?></p>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

  </div>
</section>



<section id="analytics" class="py-24" style="border-top:1px solid var(--wp-border)">
  <div class="max-w-6xl mx-auto px-6">
    <div class="grid lg:grid-cols-2 gap-16 items-center">

      
      <div class="reveal">
        <p class="text-xs font-semibold uppercase tracking-widest mb-3"
           style="color:#3B82F6">Analytics</p>
        <h2 class="text-3xl lg:text-4xl font-extrabold tracking-[-0.03em] leading-tight mb-5"
            style="color:var(--wp-text)">
          See your productivity<br>at a glance.
        </h2>
        <p class="leading-relaxed mb-8" style="color:var(--wp-dim)">
          Listify's built-in analytics give you instant clarity on how your week is going —
          completion rates, overdue tasks, and priority distributions all in one view.
        </p>
        <ul class="space-y-3">
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
            'Task completion rate over time',
            'Priority breakdown — high / medium / low',
            'Overdue task count and alerts',
            'Category-based filtering and insights',
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="flex items-center gap-3 text-sm" style="color:var(--wp-muted)">
            <div class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:#3B82F6"></div>
            <?php echo e($item); ?>

          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
      </div>

      
      <div class="reveal">
        <div class="rounded-xl overflow-hidden"
             style="border:1px solid var(--wp-border);background:var(--wp-card)">

          <div class="px-5 py-4 flex items-center justify-between"
               style="border-bottom:1px solid var(--wp-border)">
            <span class="text-sm font-semibold" style="color:var(--wp-text)">Analytics</span>
            <span class="text-xs px-2.5 py-1 rounded-md"
                  style="color:var(--wp-faint);background:var(--wp-border)">This week</span>
          </div>

          <div class="grid grid-cols-3" style="border-bottom:1px solid var(--wp-border)">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [['23','Completed','#22C55E'],['8','Pending','#F59E0B'],['3','Overdue','#EF4444']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$n,$l,$c]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="px-4 py-4 text-center"
                 style="<?php echo e(!$loop->last ? 'border-right:1px solid var(--wp-border)' : ''); ?>">
              <div class="text-xl font-extrabold tracking-tight mb-0.5"
                   style="color:<?php echo e($c); ?>"><?php echo e($n); ?></div>
              <div class="text-[10px]" style="color:var(--wp-faint)"><?php echo e($l); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>

          <div class="p-5">
            <p class="text-[9px] font-semibold uppercase tracking-widest mb-4"
               style="color:var(--wp-line)">Daily completions — last 7 days</p>
            <div class="flex items-end gap-2" style="height:56px">
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [['Mon',3],['Tue',5],['Wed',4],['Thu',7],['Fri',6],['Sat',8],['Sun',5]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$day,$val]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="flex-1 flex flex-col items-center gap-1">
                <div class="w-full rounded-t" style="height:<?php echo e(($val/8)*100); ?>%;
                     background:<?php echo e($val>=7 ? '#3B82F6' : 'var(--wp-border)'); ?>;min-height:4px">
                </div>
                <span class="text-[8px]" style="color:var(--wp-line)"><?php echo e($day); ?></span>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
          </div>

          <div class="px-5 pb-5 space-y-2.5">
            <p class="text-[9px] font-semibold uppercase tracking-widest mb-3"
               style="color:var(--wp-line)">Priority split</p>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [['High','30%','#EF4444'],['Medium','50%','#F59E0B'],['Low','20%','#22C55E']]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$l,$p,$c]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center gap-3">
              <span class="text-[10px] w-12 flex-shrink-0" style="color:var(--wp-faint)"><?php echo e($l); ?></span>
              <div class="flex-1 h-1.5 rounded-full" style="background:var(--wp-border)">
                <div class="h-full rounded-full" style="width:<?php echo e($p); ?>;background:<?php echo e($c); ?>"></div>
              </div>
              <span class="text-[10px] w-7 text-right" style="color:var(--wp-line)"><?php echo e($p); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>



<section class="py-24" style="border-top:1px solid var(--wp-border)">
  <div class="max-w-6xl mx-auto px-6">
    <div class="reveal rounded-2xl p-12 lg:p-16 text-center relative overflow-hidden"
         style="border:1px solid var(--wp-border);background:var(--wp-card)">

      <div class="absolute inset-0 pointer-events-none"
           style="background:radial-gradient(ellipse 60% 40% at 50% -10%,
                  rgba(59,130,246,.07),transparent)"></div>

      <div class="relative">
        <p class="text-xs font-semibold uppercase tracking-widest mb-4"
           style="color:#3B82F6">Start free today</p>
        <h2 class="text-4xl lg:text-5xl font-extrabold tracking-[-0.04em] leading-tight mb-5"
            style="color:var(--wp-text)">
          Your task list is waiting.
        </h2>
        <p class="max-w-md mx-auto leading-relaxed mb-8" style="color:var(--wp-dim)">
          Join developers and teams already using Listify to work with more clarity,
          less noise, and more focus every day.
        </p>
        <div class="flex items-center justify-center gap-3 flex-wrap">
          <a href="<?php echo e(route('register')); ?>"
             class="inline-flex items-center gap-2 px-6 py-3 rounded-lg
                    font-semibold text-sm transition-all duration-200"
             style="background:#3B82F6;color:#fff;
                    box-shadow:0 8px 24px rgba(59,130,246,.25)">
            Create free account
            <i class="fa-solid fa-arrow-right text-xs"></i>
          </a>
          <a href="<?php echo e(route('login')); ?>"
             class="inline-flex items-center gap-2 px-6 py-3 rounded-lg
                    font-medium text-sm transition-all duration-200"
             style="border:1px solid var(--wp-border);color:var(--wp-muted)">
            Sign in
          </a>
        </div>
      </div>

    </div>
  </div>
</section>



<footer class="py-8" style="border-top:1px solid var(--wp-border)">
  <div class="max-w-6xl mx-auto px-6
              flex flex-col sm:flex-row items-center justify-between gap-4">

    <div class="flex items-center gap-2.5">
      <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Listify" class="w-5 h-5 block" />
      <span class="text-xs font-semibold" style="color:var(--wp-faint)">Listify</span>
      <span style="color:var(--wp-border)">·</span>
      <span class="text-xs" style="color:var(--wp-line)">© 2026. All rights reserved.</span>
      <span style="color:var(--wp-border)">·</span>
      <span class="text-xs" style="color:var(--wp-faint)">Designed by <strong>blvck</strong></span>
    </div>

    <div class="flex items-center gap-6">
      <a href="<?php echo e(route('about.show')); ?>"
         class="text-xs transition-colors" style="color:var(--wp-line)">About</a>
      <a href="<?php echo e(route('contact.show')); ?>"
         class="text-xs transition-colors" style="color:var(--wp-line)">Contact</a>
      <a href="<?php echo e(route('terms.show')); ?>"
         class="text-xs transition-colors" style="color:var(--wp-line)">Terms</a>
    </div>

  </div>
</footer>



<script>
// ── Dark / light toggle ──────────────────────────────────
const html = document.documentElement;
const btn  = document.getElementById('themeToggle');
const icon = document.getElementById('themeIcon');

function applyTheme(dark) {
  html.classList.toggle('dark', dark);
  icon.className = dark ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
}

// Sync icon with current state on load
applyTheme(html.classList.contains('dark'));

btn.addEventListener('click', () => {
  const isDark = !html.classList.contains('dark');
  applyTheme(isDark);
  localStorage.setItem('lf-theme', isDark ? 'dark' : 'light');
});

// ── Scroll-reveal ────────────────────────────────────────
const io = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (!entry.isIntersecting) return;
    const el   = entry.target;
    const sibs = Array.from(el.parentElement?.children ?? []);
    const idx  = sibs.filter(s => s.classList.contains('reveal')).indexOf(el);
    el.style.animationDelay = (idx * 70) + 'ms';
    el.classList.add('on');
    io.unobserve(el);
  });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(el => io.observe(el));
</script>

</body>
</html>
<?php /**PATH C:\Users\saran\listify\resources\views/welcome.blade.php ENDPATH**/ ?>
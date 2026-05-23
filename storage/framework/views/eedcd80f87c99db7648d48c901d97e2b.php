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
  <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  <script>(function(){if(localStorage.getItem('lf-theme')==='dark'||(!localStorage.getItem('lf-theme')&&window.matchMedia('(prefers-color-scheme: dark)').matches)){document.documentElement.classList.add('dark');}})();</script>

  <style>
    /* Welcome-page-specific styles */
    .hero-dot-grid {
      background-image: radial-gradient(var(--border) 1px, transparent 1px);
      background-size: 28px 28px;
    }
    .gradient-text {
      background: linear-gradient(135deg, var(--brand), #6366F1, #8B5CF6);
      background-size: 200% 200%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      animation: lf-gradient 4s ease infinite;
    }
    .floating-badge {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--r-xl);
      padding: 8px 14px;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-primary);
      box-shadow: var(--shadow-md);
      display: inline-flex;
      align-items: center;
      gap: 7px;
      white-space: nowrap;
    }
    .hero-glow {
      position: absolute;
      border-radius: 50%;
      filter: blur(60px);
      pointer-events: none;
    }
    .feature-card {
      background: var(--bg-card);
      border: 1px solid var(--border);
      border-radius: var(--r-lg);
      padding: 1.75rem;
      transition: border-color .2s, box-shadow .2s, transform .2s;
    }
    .feature-card:hover {
      border-color: var(--brand);
      box-shadow: var(--shadow-md);
      transform: translateY(-3px);
    }
    .stat-item {
      text-align: center;
      padding: 1.25rem;
    }
    .stat-item-num {
      font-family: var(--font-head);
      font-size: 2rem;
      font-weight: 800;
      color: var(--brand);
      letter-spacing: -0.04em;
    }
    .stat-item-label {
      font-size: 12px;
      color: var(--text-secondary);
      margin-top: 2px;
    }
    .step-circle {
      width: 40px; height: 40px;
      background: var(--brand);
      border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #fff;
      font-family: var(--font-head);
      font-size: 16px;
      font-weight: 800;
      flex-shrink: 0;
    }
  </style>
</head>
<body style="background:var(--bg-page);font-family:var(--font-body);min-height:100vh;overflow-x:hidden;">


<nav class="lf-nav">
  <div class="lf-wrap lf-nav-inner">
    <a href="<?php echo e(route('welcome')); ?>" class="lf-logo" style="display:flex;align-items:center;gap:10px;text-decoration:none">
      <img src="<?php echo e(asset('images/logo.svg')); ?>" alt="Listify logo" style="width:32px;height:32px;display:block" />
      <span class="lf-logo-text">Listify</span>
    </a>
    <div class="lf-nav-right">
      <button class="lf-theme-toggle" id="themeToggle">
        <i class="fa-solid fa-moon" id="themeIcon"></i>
      </button>
      <a href="<?php echo e(route('login')); ?>"    class="lf-btn lf-btn-ghost lf-btn-sm lf-fade-in lf-d3">Sign in</a>
      <a href="<?php echo e(route('register')); ?>" class="lf-btn lf-btn-primary lf-btn-sm lf-fade-in lf-d4">Get started</a>
    </div>
  </div>
</nav>


<section class="hero-dot-grid" style="position:relative;overflow:hidden;padding:5rem 0 4rem">

  
  <div class="hero-glow" style="width:500px;height:500px;background:rgba(37,99,235,.08);top:-100px;right:-100px"></div>
  <div class="hero-glow" style="width:300px;height:300px;background:rgba(99,102,241,.07);bottom:-60px;left:-60px"></div>

  <div class="lf-wrap">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center">

      
      <div>
        <div class="lf-badge lf-badge-blue lf-fade-down" style="margin-bottom:1.5rem;display:inline-flex;gap:6px">
          <i class="fa-solid fa-bolt"></i> Task Management, Simplified
        </div>

        <h1 class="lf-fade-up lf-d1" style="font-family:var(--font-head);font-size:3.4rem;font-weight:800;
                    letter-spacing:-.04em;line-height:1.05;color:var(--text-primary);margin:0 0 1.25rem">
          Stay focused.<br>
          <span class="gradient-text">Ship faster.</span>
        </h1>

        <p class="lf-fade-up lf-d2" style="font-size:1.05rem;color:var(--text-secondary);line-height:1.75;
                    margin:0 0 2rem;max-width:420px">
          Listify helps you create, organise, and track your tasks with a clean, professional interface built for people who value clarity.
        </p>

        <div class="lf-fade-up lf-d3" style="display:flex;gap:.75rem;flex-wrap:wrap;margin-bottom:2rem">
          <a href="<?php echo e(route('register')); ?>" class="lf-btn lf-btn-primary lf-btn-lg" style="gap:8px">
            Get started free <i class="fa-solid fa-arrow-right"></i>
          </a>
          <a href="<?php echo e(route('login')); ?>" class="lf-btn lf-btn-secondary lf-btn-lg">Sign in</a>
        </div>

        
        <div class="lf-fade-up lf-d4" style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap">
          <div style="display:flex;align-items:center;gap:.4rem">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['#3B82F6','#22C55E','#F59E0B','#EF4444','#8B5CF6']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="width:28px;height:28px;border-radius:50%;background:<?php echo e($c); ?>;
                        border:2px solid var(--bg-page);margin-left:-8px;first:margin-left:0;
                        display:flex;align-items:center;justify-content:center;font-size:10px;color:#fff;font-weight:700">
              <?php echo e(chr(rand(65,90))); ?>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
          <div style="font-size:13px;color:var(--text-secondary)">
            <strong style="color:var(--text-primary)">500+</strong> tasks completed this week
          </div>
          <div style="display:flex;gap:2px">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i=0;$i<5;$i++): ?>
            <i class="fa-solid fa-star" style="font-size:11px;color:#F59E0B"></i>
            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>
        </div>
      </div>

      
      <div style="position:relative">

        
        <div class="floating-badge lf-float lf-d2"
             style="position:absolute;top:-18px;right:-10px;z-index:10">
          <i class="fa-solid fa-circle-check" style="color:#22C55E;font-size:14px"></i>
          Task completed!
        </div>

        
        <div class="floating-badge lf-float-r lf-d4"
             style="position:absolute;top:40%;left:-30px;z-index:10">
          <span style="width:8px;height:8px;border-radius:50%;background:#EF4444;flex-shrink:0"></span>
          High priority
        </div>

        
        <div class="floating-badge lf-float-sm"
             style="position:absolute;bottom:-14px;right:20px;z-index:10;animation-delay:.6s">
          <i class="fa-solid fa-fire" style="color:#F97316;font-size:13px"></i>
          3-day streak!
        </div>

        
        <div class="lf-card lf-fade-up lf-d2" style="padding:1.5rem;position:relative;overflow:hidden;box-shadow:var(--shadow-lg)">

          
          <div style="position:absolute;top:0;left:0;right:0;height:3px;
                      background:linear-gradient(90deg,var(--brand),#6366F1,#8B5CF6)"></div>

          
          <div style="display:flex;align-items:center;justify-content:space-between;
                      margin-bottom:1.25rem;padding-bottom:1rem;border-bottom:1px solid var(--border)">
            <div style="display:flex;align-items:center;gap:8px">
              <div class="lf-logo-badge" style="width:26px;height:26px;font-size:12px">L</div>
              <span style="font-size:13px;font-weight:700;color:var(--text-primary)">Listify</span>
            </div>
            <div style="display:flex;gap:6px">
              <span style="font-size:11px;font-weight:600;color:var(--brand);background:var(--brand-light);
                           padding:4px 10px;border-radius:6px">Dashboard</span>
              <span style="font-size:11px;font-weight:500;color:var(--text-secondary);padding:4px 10px">History</span>
            </div>
          </div>

          
          <div class="lf-welcome" style="margin-bottom:1rem;font-size:12px">
            <i class="fa-solid fa-circle-check"></i> Welcome back, <strong>Alex</strong>!
          </div>

          
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:.65rem">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
              ['Design review',     'high',   'completed'],
              ['API integration',   'medium', ''],
              ['Write unit tests',  'low',    ''],
              ['Deploy to staging', 'high',   ''],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$t, $p, $s]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="lf-task-tile <?php echo e($s === 'completed' ? 'completed' : ''); ?>"
                 style="min-height:88px;padding:.9rem">
              <div>
                <div class="lf-task-tile-label">Task</div>
                <div class="lf-task-tile-title" style="font-size:.8rem;margin-top:4px"><?php echo e($t); ?></div>
              </div>
              <div style="display:flex;align-items:center;justify-content:space-between;margin-top:8px">
                <span class="lf-pill lf-pill-<?php echo e($p); ?>" style="font-size:9px"><?php echo e($p); ?></span>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($s === 'completed'): ?>
                  <i class="fa-solid fa-circle-check" style="font-size:12px;opacity:.6"></i>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </div>

          
          <div style="margin-top:1rem">
            <div style="display:flex;justify-content:space-between;font-size:10px;
                        color:var(--text-muted);margin-bottom:5px">
              <span>Weekly progress</span><span>75%</span>
            </div>
            <div class="lf-progress-track">
              <div class="lf-progress-fill" style="width:75%;background:linear-gradient(90deg,var(--brand),#6366F1)"></div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>


<div style="background:var(--bg-card);border-top:1px solid var(--border);border-bottom:1px solid var(--border);padding:1.5rem 0">
  <div class="lf-wrap">
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
        ['10k+', 'Tasks created'],
        ['98%',  'Uptime'],
        ['500+', 'Active users'],
        ['4.9★', 'Avg rating'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$num, $label]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="stat-item lf-reveal">
        <div class="stat-item-num"><?php echo e($num); ?></div>
        <div class="stat-item-label"><?php echo e($label); ?></div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</div>


<section style="padding:5rem 0">
  <div class="lf-wrap">

    <div style="text-align:center;margin-bottom:3rem" class="lf-reveal">
      <div class="lf-badge lf-badge-blue" style="display:inline-flex;margin-bottom:1rem">
        <i class="fa-solid fa-sparkles" style="margin-right:5px"></i> Everything you need
      </div>
      <h2 style="font-family:var(--font-head);font-size:2.2rem;font-weight:800;
                 letter-spacing:-.03em;margin:0 0 .75rem">
        Built for real productivity
      </h2>
      <p style="font-size:1rem;color:var(--text-secondary);max-width:480px;margin:0 auto">
        Every feature is designed around how real people manage work — not how productivity gurus think they should.
      </p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1.25rem">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
        ['fa-list-check',        '#3B82F6', 'Task CRUD',         'Create, edit, complete, and delete tasks with a clean, distraction-free interface.'],
        ['fa-clock-rotate-left', '#8B5CF6', 'Full History',       'Complete audit trail of every completed or modified task so nothing gets lost.'],
        ['fa-gauge',             '#22C55E', 'Admin Dashboard',    'Monitor all users and tasks with role-based access control and live analytics.'],
        ['fa-tag',               '#F59E0B', 'Categories',         'Organise tasks by colour-coded categories. Filter and focus on what matters most.'],
        ['fa-bell',              '#EF4444', 'Notifications',      'Stay informed with real-time in-app notifications for task events and updates.'],
        ['fa-code',              '#14B8A6', 'REST API',           'Full Sanctum-authenticated API — integrate Listify with any tool or workflow.'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$icon, $color, $title, $desc]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="feature-card lf-reveal" style="--reveal-delay:<?php echo e($loop->index * 80); ?>ms">
        <div style="width:46px;height:46px;background:<?php echo e($color); ?>1A;border-radius:12px;
                    display:flex;align-items:center;justify-content:center;margin-bottom:1rem">
          <i class="fa-solid <?php echo e($icon); ?>" style="color:<?php echo e($color); ?>;font-size:18px"></i>
        </div>
        <div style="font-family:var(--font-head);font-size:1rem;font-weight:700;
                    color:var(--text-primary);margin-bottom:.5rem"><?php echo e($title); ?></div>
        <div style="font-size:13px;color:var(--text-secondary);line-height:1.65"><?php echo e($desc); ?></div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</section>


<section style="background:var(--bg-card);border-top:1px solid var(--border);
                border-bottom:1px solid var(--border);padding:5rem 0">
  <div class="lf-wrap">

    <div style="text-align:center;margin-bottom:3rem" class="lf-reveal">
      <h2 style="font-family:var(--font-head);font-size:2rem;font-weight:800;letter-spacing:-.03em;margin:0 0 .5rem">
        Get productive in 3 steps
      </h2>
      <p style="font-size:1rem;color:var(--text-secondary)">No setup. No learning curve. Just tasks.</p>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:2.5rem">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = [
        ['1', 'fa-user-plus',       'Create an account', 'Sign up free in under 30 seconds — no credit card required.'],
        ['2', 'fa-plus-circle',     'Add your tasks',    'Tap "Add Task", fill in the details, set a priority, and save.'],
        ['3', 'fa-circle-check',    'Track & complete',  'Search, filter by priority, mark tasks done, and review your history.'],
      ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$n, $icon, $title, $desc]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="lf-reveal" style="text-align:center">
        <div style="display:flex;align-items:center;justify-content:center;margin-bottom:1.25rem">
          <div class="step-circle"><?php echo e($n); ?></div>
        </div>
        <div style="width:52px;height:52px;background:var(--brand-light);border-radius:14px;
                    display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
          <i class="fa-solid <?php echo e($icon); ?>" style="color:var(--brand);font-size:20px"></i>
        </div>
        <div style="font-family:var(--font-head);font-size:1.05rem;font-weight:700;
                    color:var(--text-primary);margin-bottom:.4rem"><?php echo e($title); ?></div>
        <div style="font-size:13px;color:var(--text-secondary);line-height:1.65;max-width:240px;margin:0 auto"><?php echo e($desc); ?></div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  </div>
</section>


<section style="padding:5rem 0">
  <div class="lf-wrap">
    <div class="lf-reveal" style="background:linear-gradient(135deg,var(--brand),#6366F1);
                border-radius:var(--r-xl);padding:3.5rem 3rem;text-align:center;
                position:relative;overflow:hidden;box-shadow:var(--shadow-lg)">

      
      <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;
                  border-radius:50%;background:rgba(255,255,255,.06)"></div>
      <div style="position:absolute;bottom:-30px;left:-30px;width:150px;height:150px;
                  border-radius:50%;background:rgba(255,255,255,.04)"></div>

      <div style="position:relative;z-index:1">
        <div style="font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.12em;
                    color:rgba(255,255,255,.7);margin-bottom:.75rem">
          Start today — it's free
        </div>
        <h2 style="font-family:var(--font-head);font-size:2.5rem;font-weight:800;
                   letter-spacing:-.04em;color:#fff;margin:0 0 1rem;line-height:1.1">
          Your task list is waiting.
        </h2>
        <p style="font-size:1rem;color:rgba(255,255,255,.8);margin:0 0 2rem;max-width:420px;
                  margin-left:auto;margin-right:auto;line-height:1.7">
          Join hundreds of people who already use Listify to stay on top of their work every day.
        </p>
        <a href="<?php echo e(route('register')); ?>" class="lf-btn lf-btn-lg"
           style="background:#fff;color:var(--brand);font-weight:700;box-shadow:0 4px 14px rgba(0,0,0,.2)">
          Create free account <i class="fa-solid fa-arrow-right" style="margin-left:6px"></i>
        </a>
      </div>
    </div>
  </div>
</section>


<footer class="lf-footer">
  <div class="lf-wrap" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem">
    <div style="display:flex;align-items:center;gap:8px">
      <div class="lf-logo-badge" style="width:24px;height:24px;font-size:11px">L</div>
      <span style="font-size:12px;color:var(--text-muted);font-weight:600">Listify</span>
      <span style="font-size:12px;color:var(--text-muted)">© 2026. All rights reserved.</span>
    </div>
    <div style="display:flex;gap:1.5rem">
      <a href="<?php echo e(route('about.show')); ?>">About</a>
      <a href="<?php echo e(route('contact.show')); ?>">Contact</a>
      <a href="<?php echo e(route('terms.show')); ?>">Terms</a>
    </div>
  </div>
</footer>

<script>
// Dark mode
const html=document.documentElement,btn=document.getElementById('themeToggle'),icon=document.getElementById('themeIcon');
function applyTheme(d){html.classList.toggle('dark',d);icon.className=d?'fa-solid fa-sun':'fa-solid fa-moon';}
applyTheme(html.classList.contains('dark'));
btn.addEventListener('click',()=>{const d=!html.classList.contains('dark');applyTheme(d);localStorage.setItem('lf-theme',d?'dark':'light');});

// Scroll-reveal animation with stagger from data attribute
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      const delay = e.target.style.getPropertyValue('--reveal-delay') || '0ms';
      setTimeout(() => e.target.classList.add('lf-revealed'), parseInt(delay) || 0);
      observer.unobserve(e.target);
    }
  });
}, { threshold: 0.12 });

document.querySelectorAll('.lf-reveal').forEach(el => observer.observe(el));
</script>
</body>
</html>
<?php /**PATH C:\Users\saran\listify\resources\views/welcome.blade.php ENDPATH**/ ?>
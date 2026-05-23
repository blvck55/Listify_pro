
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'My Tasks']); ?>

  
  <div class="lf-fade-up" style="background:linear-gradient(135deg,var(--brand),#6366F1);
              border-radius:var(--r-xl);padding:2rem 2rem 2rem 2.25rem;
              margin-bottom:2rem;position:relative;overflow:hidden;box-shadow:var(--shadow-md)">

    
    <div style="position:absolute;top:-30px;right:-30px;width:200px;height:200px;
                border-radius:50%;background:rgba(255,255,255,.06);pointer-events:none"></div>
    <div style="position:absolute;bottom:-20px;right:160px;width:100px;height:100px;
                border-radius:50%;background:rgba(255,255,255,.04);pointer-events:none"></div>

    
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
        <?php echo e(Auth::user()->name); ?>

      </div>
      <div style="font-size:13px;color:rgba(255,255,255,.75)">
        Here are your pending tasks for today. Stay focused!
      </div>
    </div>
  </div>

  
  <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('task-form', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1330257166-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

  
  <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('task-search', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1330257166-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

  
  <div class="lf-grid-2" style="margin-top:2.5rem">

    <a href="<?php echo e(route('tasks.history')); ?>" class="lf-panel-action">
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
        <a href="<?php echo e(route('tasks.history')); ?>" class="lf-btn lf-btn-ghost lf-btn-sm">
          <i class="fa-solid fa-list-ul"></i> View feed
        </a>
      </div>
      <i class="fa-solid fa-list-ul bg-icon"></i>
    </div>

  </div>

  
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
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('category-manager', []);

$__key = null;

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1330257166-2', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key);

echo $__html;

unset($__html);
unset($__key);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
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

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\saran\listify\resources\views/dashboard.blade.php ENDPATH**/ ?>
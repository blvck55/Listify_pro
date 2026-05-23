
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'Admin Dashboard']); ?>

  
  <div class="lf-fade-up" style="background:linear-gradient(135deg,#0F172A,#1E293B);
              border-radius:var(--r-xl);padding:2rem 2.25rem;margin-bottom:2rem;
              position:relative;overflow:hidden;box-shadow:var(--shadow-lg)">
    <div style="position:absolute;top:-40px;right:-40px;width:220px;height:220px;
                border-radius:50%;background:rgba(37,99,235,.12);pointer-events:none"></div>

    
    <div style="position:absolute;right:2.5rem;top:50%;transform:translateY(-50%);opacity:.18;pointer-events:none">
      <svg width="110" height="90" viewBox="0 0 110 90" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="5" y="8" width="100" height="74" rx="8" fill="white"/>
        <rect x="5" y="8" width="100" height="20" rx="8" fill="white" opacity=".3"/>
        <rect x="5" y="24" width="100" height="4" fill="white" opacity=".3"/>
        <rect x="14" y="38" width="35" height="6" rx="3" fill="white" opacity=".4"/>
        <rect x="14" y="50" width="55" height="6" rx="3" fill="white" opacity=".3"/>
        <rect x="14" y="62" width="42" height="6" rx="3" fill="white" opacity=".2"/>
        <circle cx="88" cy="52" r="14" fill="white" opacity=".15"/>
        <path d="M83 52l3.5 3.5L94 48" stroke="#1E293B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <div style="position:relative;z-index:1">
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                  color:rgba(255,255,255,.5);margin-bottom:.35rem">
        <i class="fa-solid fa-shield-halved" style="margin-right:5px;color:#3B82F6"></i> Admin Panel
      </div>
      <div style="font-family:var(--font-head);font-size:1.5rem;font-weight:800;
                  color:#fff;letter-spacing:-.03em">
        Welcome, <?php echo e(Auth::user()->name); ?>

      </div>
      <div style="font-size:13px;color:rgba(255,255,255,.55);margin-top:.25rem">
        System overview — <?php echo e(now()->format('l, F j Y')); ?>

      </div>
    </div>
  </div>

  
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:2rem">
    <div class="lf-stat lf-scale-in lf-d1">
      <div class="lf-stat-label">Total Users</div>
      <div class="lf-stat-value lf-count" data-target="<?php echo e($totalUsers); ?>"><?php echo e($totalUsers); ?></div>
      <div class="lf-stat-sub"><i class="fa-solid fa-arrow-trend-up"></i> +<?php echo e($todayUsers); ?> today</div>
    </div>
    <div class="lf-stat lf-scale-in lf-d2">
      <div class="lf-stat-label">Total Tasks</div>
      <div class="lf-stat-value lf-count" data-target="<?php echo e($totalTasks); ?>"><?php echo e($totalTasks); ?></div>
      <div class="lf-stat-sub"><i class="fa-solid fa-arrow-trend-up"></i> +<?php echo e($todayTasks); ?> today</div>
    </div>
    <div class="lf-stat lf-scale-in lf-d3">
      <div class="lf-stat-label">Completion Rate</div>
      <div class="lf-stat-value lf-count" data-target="<?php echo e($completionRate); ?>" data-suffix="%"><?php echo e($completionRate); ?>%</div>
      <div class="lf-stat-sub"><?php echo e($completedCount); ?>/<?php echo e($totalTasks); ?> completed</div>
    </div>
  </div>

  
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem">
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Admins
      </div>
      <div style="font-size:2rem;font-weight:700;color:var(--brand);margin:0.5rem 0"><?php echo e($totalAdmins); ?></div>
      <div style="font-size:11px;color:var(--text-secondary)"><?php echo e($totalAdmins > 1 ? 'accounts' : 'account'); ?></div>
    </div>
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Pending
      </div>
      <div style="font-size:2rem;font-weight:700;color:#F59E0B;margin:0.5rem 0"><?php echo e($pendingCount); ?></div>
      <div style="font-size:11px;color:var(--text-secondary)">tasks</div>
    </div>
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Completed
      </div>
      <div style="font-size:2rem;font-weight:700;color:#22C55E;margin:0.5rem 0"><?php echo e($completedCount); ?></div>
      <div style="font-size:11px;color:var(--text-secondary)">tasks</div>
    </div>
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Avg Tasks/User
      </div>
      <div style="font-size:2rem;font-weight:700;color:var(--brand);margin:0.5rem 0">
        <?php echo e($totalUsers > 0 ? round($totalTasks / $totalUsers, 1) : 0); ?>

      </div>
      <div style="font-size:11px;color:var(--text-secondary)">per user</div>
    </div>
  </div>

  
  <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:2rem">

    
    <div>
      <div class="lf-section-header">
        <div class="lf-section-title">Recent Task Activity</div>
        <a href="<?php echo e(route('admin.tasks')); ?>" class="lf-btn lf-btn-ghost lf-btn-sm">View all</a>
      </div>

      <div class="lf-table-wrap">
        <table class="lf-table">
          <thead>
            <tr>
              <th>User</th>
              <th>Task</th>
              <th>Status</th>
              <th>Priority</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <tr>
                <td style="font-size:12px">
                  <div style="display:flex;align-items:center;gap:6px">
                    <div style="width:24px;height:24px;border-radius:50%;background:var(--brand-light);
                                display:flex;align-items:center;justify-content:center;
                                font-size:10px;font-weight:700;color:var(--brand)">
                      <?php echo e(strtoupper(substr($task->user->name, 0, 1))); ?>

                    </div>
                    <?php echo e($task->user->name); ?>

                  </div>
                </td>
                <td style="font-size:12px;max-width:150px;overflow:hidden;text-overflow:ellipsis"><?php echo e($task->title); ?></td>
                <td>
                  <span class="lf-badge <?php echo e($task->status==='completed' ? 'lf-badge-green' : 'lf-badge-yellow'); ?>" style="font-size:10px">
                    <?php echo e($task->status); ?>

                  </span>
                </td>
                <td>
                  <?php $pc = match($task->priority){ 'high'=>'lf-badge-red','medium'=>'lf-badge-yellow',default=>'lf-badge-green' }; ?>
                  <span class="lf-badge <?php echo e($pc); ?>" style="font-size:10px"><?php echo e($task->priority); ?></span>
                </td>
                <td>
                  <form action="<?php echo e(route('admin.tasks.destroy', $task)); ?>" method="POST" onsubmit="return confirm('Delete?')" style="display:inline">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="lf-action-btn danger" style="font-size:11px" title="Delete">
                      <i class="fa-regular fa-trash-can"></i>
                    </button>
                  </form>
                </td>
              </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <tr><td colspan="5" style="text-align:center;padding:1.5rem;color:var(--text-secondary);font-size:12px">
                No tasks yet
              </td></tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    
    <div>
      <div class="lf-section-header">
        <div class="lf-section-title">Recent Users</div>
        <a href="<?php echo e(route('admin.users')); ?>" class="lf-btn lf-btn-ghost lf-btn-sm">View all</a>
      </div>

      <div style="display:flex;flex-direction:column;gap:0.75rem">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="lf-card lf-card-p" style="padding:0.75rem 1rem;display:flex;align-items:center;justify-content:space-between">
            <div style="display:flex;align-items:center;gap:0.75rem">
              <div style="width:32px;height:32px;border-radius:50%;background:var(--brand-light);
                          display:flex;align-items:center;justify-content:center;
                          font-size:11px;font-weight:700;color:var(--brand)">
                <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

              </div>
              <div>
                <div style="font-size:12px;font-weight:600"><?php echo e($user->name); ?></div>
                <div style="font-size:10px;color:var(--text-secondary)"><?php echo e($user->email); ?></div>
              </div>
            </div>
            <span class="lf-badge <?php echo e($user->role === 'admin' ? 'lf-badge-red' : 'lf-badge-green'); ?>" style="font-size:9px">
              <?php echo e($user->role); ?>

            </span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div style="text-align:center;padding:2rem;color:var(--text-secondary);font-size:12px">
            No users yet
          </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

  </div>

  
  <div class="lf-grid-4" style="margin-bottom:2rem">
    <a href="<?php echo e(route('admin.users')); ?>" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">Manage</div>
        <div class="lf-panel-action-title">Users</div>
      </div>
      <i class="fa-solid fa-users"></i>
    </a>
    <a href="<?php echo e(route('admin.tasks')); ?>" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">View</div>
        <div class="lf-panel-action-title">Tasks</div>
      </div>
      <i class="fa-solid fa-list-check"></i>
    </a>
    <a href="<?php echo e(route('admin.reports')); ?>" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">View</div>
        <div class="lf-panel-action-title">Reports</div>
      </div>
      <i class="fa-solid fa-chart-bar"></i>
    </a>
    <a href="<?php echo e(route('admin.analytics')); ?>" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">View</div>
        <div class="lf-panel-action-title">Analytics</div>
      </div>
      <i class="fa-solid fa-chart-line"></i>
    </a>
  </div>

  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentActivities->count() > 0): ?>
    <div class="lf-section-header">
      <div class="lf-section-title">Recent Admin Actions</div>
      <a href="<?php echo e(route('admin.activity')); ?>" class="lf-btn lf-btn-ghost lf-btn-sm">View all</a>
    </div>

    <div class="lf-card lf-card-p">
      <div style="display:flex;flex-direction:column;gap:0.75rem">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div style="display:flex;align-items:flex-start;gap:0.75rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
            <div style="width:32px;height:32px;min-width:32px;border-radius:50%;background:var(--brand-light);
                        display:flex;align-items:center;justify-content:center;margin-top:0.25rem">
              <i class="fa-solid fa-user" style="font-size:0.75rem;color:var(--brand)"></i>
            </div>
            <div style="flex:1;min-width:0">
              <div style="font-size:12px">
                <span style="font-weight:600"><?php echo e($activity->user->name); ?></span>
                <span style="color:var(--text-secondary)"><?php echo e($activity->description); ?></span>
              </div>
              <div style="font-size:10px;color:var(--text-muted);margin-top:0.25rem">
                <?php echo e($activity->created_at->diffForHumans()); ?>

              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  
  <script>
    document.querySelectorAll('.lf-count').forEach(el => {
      const target = parseInt(el.dataset.target, 10);
      const suffix = el.dataset.suffix || '';
      if (isNaN(target) || target === 0) return;
      const duration = 900;
      const start = performance.now();
      function step(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(eased * target) + suffix;
        if (progress < 1) requestAnimationFrame(step);
      }
      el.textContent = '0' + suffix;
      requestAnimationFrame(step);
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
<?php /**PATH C:\Users\saran\listify\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>
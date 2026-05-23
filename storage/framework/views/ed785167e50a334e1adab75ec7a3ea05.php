
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['pageTitle' => 'System Reports']); ?>

  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">System Reports</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        Overview of system usage and task distribution
      </div>
    </div>
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    <div class="lf-stat">
      <div class="lf-stat-label">Total Users</div>
      <div class="lf-stat-value"><?php echo e($stats['total_users']); ?></div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Total Tasks</div>
      <div class="lf-stat-value"><?php echo e($stats['total_tasks']); ?></div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Completion Rate</div>
      <div class="lf-stat-value"><?php echo e($stats['completion_rate']); ?>%</div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Avg Tasks/User</div>
      <div class="lf-stat-value">
        <?php echo e($stats['total_users'] > 0 ? round($stats['total_tasks'] / $stats['total_users'], 1) : 0); ?>

      </div>
    </div>
  </div>

  
  <div class="lf-grid-2" style="margin-bottom:1.5rem">

    
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                  text-transform:uppercase;letter-spacing:.07em;
                  margin-bottom:1.25rem;padding-bottom:.75rem;
                  border-bottom:1px solid var(--border)">
        Task Status Distribution
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats['status_dist']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php $pct = $stats['total_tasks'] > 0 ? round($row['count']/$stats['total_tasks']*100) : 0; ?>
          <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
              <span style="font-size:13px;font-weight:600;color:var(--text-primary);text-transform:capitalize">
                <?php echo e($row['status']); ?>

              </span>
              <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:12px;color:var(--text-muted)"><?php echo e($pct); ?>%</span>
                <span style="font-size:13px;font-weight:700;color:var(--brand)"><?php echo e($row['count']); ?></span>
              </div>
            </div>
            <div class="lf-progress-track">
              <div class="lf-progress-fill" style="width:<?php echo e($pct); ?>%;background:var(--brand)"></div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

    
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                  text-transform:uppercase;letter-spacing:.07em;
                  margin-bottom:1.25rem;padding-bottom:.75rem;
                  border-bottom:1px solid var(--border)">
        Priority Distribution
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats['priority_dist']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php
            $pct = $stats['total_tasks'] > 0 ? round($row['count']/$stats['total_tasks']*100) : 0;
            $bar = match(strtolower($row['priority'])) {
              'high'   => '#EF4444',
              'medium' => '#F59E0B',
              default  => '#22C55E',
            };
            $badge = match(strtolower($row['priority'])) {
              'high'   => 'lf-badge-red',
              'medium' => 'lf-badge-yellow',
              default  => 'lf-badge-green',
            };
          ?>
          <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
              <span class="lf-badge <?php echo e($badge); ?>"><?php echo e($row['priority']); ?></span>
              <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:12px;color:var(--text-muted)"><?php echo e($pct); ?>%</span>
                <span style="font-size:13px;font-weight:700;color:var(--text-primary)"><?php echo e($row['count']); ?></span>
              </div>
            </div>
            <div class="lf-progress-track">
              <div class="lf-progress-fill" style="width:<?php echo e($pct); ?>%;background:<?php echo e($bar); ?>"></div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>

  </div>

  
  <div class="lf-card lf-card-p" style="margin-bottom:1.5rem">
    <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                text-transform:uppercase;letter-spacing:.07em;
                margin-bottom:1.25rem;padding-bottom:.75rem;
                border-bottom:1px solid var(--border)">
      User Roles
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
      <div style="text-align:center;padding:1.5rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
        <div style="font-family:var(--font-head);font-size:3rem;font-weight:800;color:var(--brand);letter-spacing:-.04em">
          <?php echo e($stats['user_count']); ?>

        </div>
        <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-top:4px">
          Users
        </div>
      </div>
      <div style="text-align:center;padding:1.5rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
        <div style="font-family:var(--font-head);font-size:3rem;font-weight:800;color:var(--brand);letter-spacing:-.04em">
          <?php echo e($stats['admin_count']); ?>

        </div>
        <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-top:4px">
          Admins
        </div>
      </div>
    </div>
  </div>

  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($stats['top_users']) && $stats['top_users']->count() > 0): ?>
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                  text-transform:uppercase;letter-spacing:.07em;
                  margin-bottom:1.25rem;padding-bottom:.75rem;
                  border-bottom:1px solid var(--border)">
        Top Users by Task Count
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $stats['top_users']->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div style="display:flex;align-items:center;gap:1rem">
            <div style="width:32px;height:32px;border-radius:50%;background:var(--brand-light);
                        display:flex;align-items:center;justify-content:center;
                        font-size:12px;font-weight:700;color:var(--brand);flex-shrink:0">
              #<?php echo e($index + 1); ?>

            </div>
            <div style="flex:1;min-width:0">
              <div style="font-size:12px;font-weight:600"><?php echo e($user->name); ?></div>
              <div style="font-size:10px;color:var(--text-secondary)"><?php echo e($user->email); ?></div>
            </div>
            <div style="text-align:right">
              <div style="font-size:13px;font-weight:700;color:var(--brand)"><?php echo e($user->tasks_count); ?></div>
              <div style="font-size:10px;color:var(--text-secondary)"><?php echo e($user->tasks_count === 1 ? 'task' : 'tasks'); ?></div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

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
<?php /**PATH C:\Users\saran\listify\resources\views/admin/reports.blade.php ENDPATH**/ ?>
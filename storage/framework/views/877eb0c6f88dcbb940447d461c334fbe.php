<div>
  
  <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.5rem">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['all' => 'All', 'created' => 'Created', 'updated' => 'Updated', 'completed' => 'Completed', 'deleted' => 'Deleted']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <button wire:click="$set('filter', '<?php echo e($val); ?>')"
              class="lf-btn lf-btn-sm <?php echo e($filter === $val ? 'lf-btn-primary' : 'lf-btn-ghost'); ?>">
        <?php echo e($label); ?>

      </button>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </div>

  
  <div class="lf-table-wrap">
    <table class="lf-table">
      <thead>
        <tr>
          <th>Action</th>
          <th>Task Name</th>
          <th>Old Status</th>
          <th>New Status</th>
          <th>Date &amp; Time</th>
        </tr>
      </thead>
      <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php
            $badgeClass = match($entry->action) {
              'created'   => 'lf-badge-green',
              'updated'   => 'lf-badge-blue',
              'completed' => 'lf-badge-green',
              'deleted'   => 'lf-badge-red',
              default     => 'lf-badge-gray',
            };
          ?>
          <tr>
            <td>
              <span class="lf-badge <?php echo e($badgeClass); ?>"><?php echo e($entry->action); ?></span>
            </td>
            <td>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entry->task): ?>
                <div style="font-weight:600;font-size:13px;color:var(--text-primary)">
                  <?php echo e($entry->task->title); ?>

                </div>
              <?php else: ?>
                <span style="font-size:12px;color:var(--text-muted);font-style:italic">Deleted task</span>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </td>
            <td>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entry->old_status): ?>
                <span class="lf-badge lf-badge-gray"><?php echo e($entry->old_status); ?></span>
              <?php else: ?>
                <span style="color:var(--text-muted);font-size:12px">—</span>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </td>
            <td>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($entry->new_status): ?>
                <span class="lf-badge <?php echo e($entry->new_status === 'completed' ? 'lf-badge-green' : 'lf-badge-gray'); ?>">
                  <?php echo e($entry->new_status); ?>

                </span>
              <?php else: ?>
                <span style="color:var(--text-muted);font-size:12px">—</span>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </td>
            <td style="font-size:12px;color:var(--text-secondary)">
              <?php echo e($entry->changed_at->format('M d, Y H:i')); ?>

            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5">
              <div class="lf-empty lf-scale-in">
                <svg width="90" height="90" viewBox="0 0 90 90" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     style="margin:0 auto 1.25rem;display:block;color:var(--text-muted);opacity:.4;
                            animation:lf-float 4s ease-in-out infinite">
                  <circle cx="45" cy="45" r="32" stroke="currentColor" stroke-width="2.5" fill="none" opacity=".3"/>
                  <circle cx="45" cy="45" r="26" fill="currentColor" opacity=".06"/>
                  <path d="M45 27v18l11 7" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round" opacity=".5"/>
                  <circle cx="45" cy="45" r="3" fill="currentColor" opacity=".6"/>
                  <line x1="45" y1="10" x2="45" y2="14" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                  <line x1="45" y1="76" x2="45" y2="80" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                  <line x1="10" y1="45" x2="14" y2="45" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                  <line x1="76" y1="45" x2="80" y2="45" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                </svg>
                <div class="lf-empty-title">No activity yet</div>
                <div class="lf-empty-desc">
                  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filter !== 'all'): ?>
                    No "<?php echo e($filter); ?>" events recorded. Try a different filter.
                  <?php else: ?>
                    Your task activity will appear here as you work.
                  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
              </div>
            </td>
          </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php /**PATH C:\Users\saran\listify\resources\views/livewire/task-history-feed.blade.php ENDPATH**/ ?>
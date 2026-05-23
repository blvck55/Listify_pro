<div style="position:relative">

  
  <button wire:click="$toggle('open')"
          class="lf-icon-btn"
          title="Notifications">
    <i class="fa-regular fa-bell"></i>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
      <span class="lf-badge"><?php echo e($unreadCount); ?></span>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
  </button>

  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($open): ?>
    <div class="lf-dropdown open"
         style="width:320px;right:0;top:calc(100% + 8px)">

      
      <div class="lf-dropdown-header" style="display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.07em">
          Notifications
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
          <button wire:click="markAllRead"
                  style="font-size:11px;color:var(--brand);font-weight:600;background:none;border:none;cursor:pointer;padding:0">
            Mark all read
          </button>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div wire:click="markRead(<?php echo e($notif->id); ?>)"
             class="lf-dropdown-item"
             style="cursor:pointer;<?php echo e(!$notif->is_read ? 'background:var(--brand-light)' : ''); ?>">

          <?php
            $icon = match($notif->type) {
              'success' => 'fa-solid fa-circle-check',
              'warning' => 'fa-solid fa-triangle-exclamation',
              default   => 'fa-solid fa-circle-info',
            };
            $iconColor = match($notif->type) {
              'success' => 'var(--success)',
              'warning' => 'var(--warning)',
              default   => 'var(--brand)',
            };
          ?>

          <i class="<?php echo e($icon); ?>" style="font-size:14px;color:<?php echo e($iconColor); ?>;flex-shrink:0"></i>
          <div style="min-width:0">
            <div style="font-size:13px;color:var(--text-primary);line-height:1.4">
              <?php echo e($notif->message); ?>

            </div>
            <div style="font-size:11px;color:var(--text-muted);margin-top:2px">
              <?php echo e($notif->created_at->diffForHumans()); ?>

            </div>
          </div>
          <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$notif->is_read): ?>
            <div style="width:7px;height:7px;border-radius:50%;background:var(--brand);flex-shrink:0;margin-left:auto"></div>
          <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div style="padding:1.5rem;text-align:center;font-size:13px;color:var(--text-muted)">
          <i class="fa-regular fa-bell-slash" style="font-size:22px;margin-bottom:.5rem;display:block;opacity:.4"></i>
          No notifications
        </div>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php /**PATH C:\Users\saran\listify\resources\views/livewire/notification-bell.blade.php ENDPATH**/ ?>
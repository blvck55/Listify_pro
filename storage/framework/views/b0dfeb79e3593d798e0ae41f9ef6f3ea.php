<div>
  
  <div class="lf-search-wrap" style="max-width:340px;margin-bottom:1.25rem">
    <i class="fa-solid fa-magnifying-glass lf-search-icon"></i>
    <input type="text"
           wire:model.live="search"
           placeholder="Search users…"
           class="lf-input lf-search"
           style="height:38px;padding-top:0;padding-bottom:0">
  </div>

  <div class="lf-table-wrap">
    <table class="lf-table">
      <thead>
        <tr>
          <th style="cursor:pointer" wire:click="sortBy('id')">
            ID
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'id'): ?>
              <i class="fa-solid fa-sort-<?php echo e($sortDir === 'asc' ? 'up' : 'down'); ?>" style="font-size:10px;margin-left:4px"></i>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </th>
          <th style="cursor:pointer" wire:click="sortBy('name')">
            Name
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'name'): ?>
              <i class="fa-solid fa-sort-<?php echo e($sortDir === 'asc' ? 'up' : 'down'); ?>" style="font-size:10px;margin-left:4px"></i>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </th>
          <th style="cursor:pointer" wire:click="sortBy('email')">
            Email
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'email'): ?>
              <i class="fa-solid fa-sort-<?php echo e($sortDir === 'asc' ? 'up' : 'down'); ?>" style="font-size:10px;margin-left:4px"></i>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </th>
          <th>Role</th>
          <th style="cursor:pointer" wire:click="sortBy('tasks_count')">
            Tasks
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'tasks_count'): ?>
              <i class="fa-solid fa-sort-<?php echo e($sortDir === 'asc' ? 'up' : 'down'); ?>" style="font-size:10px;margin-left:4px"></i>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </th>
          <th style="cursor:pointer" wire:click="sortBy('created_at')">
            Joined
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'created_at'): ?>
              <i class="fa-solid fa-sort-<?php echo e($sortDir === 'asc' ? 'up' : 'down'); ?>" style="font-size:10px;margin-left:4px"></i>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
          </th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td style="font-size:12px;color:var(--text-muted)">#<?php echo e($user->id); ?></td>
            <td>
              <div style="display:flex;align-items:center;gap:8px">
                <div style="width:32px;height:32px;border-radius:50%;
                            background:var(--brand-light);
                            display:flex;align-items:center;justify-content:center;
                            font-size:11px;font-weight:700;color:var(--brand);flex-shrink:0">
                  <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

                </div>
                <div>
                  <div style="font-weight:600;font-size:13px;color:var(--text-primary)">
                    <?php echo e($user->name); ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->id === auth()->id()): ?>
                      <span style="font-size:10px;color:var(--text-muted);font-weight:500;margin-left:4px">(you)</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                  </div>
                </div>
              </div>
            </td>
            <td style="font-size:13px;color:var(--text-secondary)"><?php echo e($user->email); ?></td>
            <td>
              <span class="lf-badge <?php echo e($user->role === 'admin' ? 'lf-badge-blue' : 'lf-badge-gray'); ?>">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->role === 'admin'): ?>
                  <i class="fa-solid fa-shield-halved" style="margin-right:4px;font-size:10px"></i>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php echo e($user->role); ?>

              </span>
            </td>
            <td style="font-size:13px;font-weight:600;color:var(--text-primary)">
              <?php echo e($user->tasks_count); ?>

            </td>
            <td style="font-size:12px;color:var(--text-secondary)">
              <?php echo e($user->created_at->format('M d, Y')); ?>

            </td>
            <td>
              <div style="display:flex;align-items:center;gap:4px">
                <button wire:click="toggleRole(<?php echo e($user->id); ?>)"
                        class="lf-action-btn"
                        title="<?php echo e($user->role === 'admin' ? 'Demote to user' : 'Promote to admin'); ?>"
                        style="color:var(--warning)">
                  <i class="fa-solid fa-key"></i>
                </button>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($user->id !== auth()->id()): ?>
                  <button wire:click="deleteUser(<?php echo e($user->id); ?>)"
                          onclick="return confirm('Delete <?php echo e(addslashes($user->name)); ?>? This will also delete all their tasks.')"
                          class="lf-action-btn danger"
                          title="Delete user">
                    <i class="fa-regular fa-trash-can"></i>
                  </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="7">
              <div class="lf-empty">
                <div class="lf-empty-icon"><i class="fa-regular fa-user"></i></div>
                <div class="lf-empty-title">No users found</div>
                <div class="lf-empty-desc">Try adjusting your search term.</div>
              </div>
            </td>
          </tr>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </tbody>
    </table>
  </div>

  
  <div style="margin-top:1rem">
    <?php echo e($users->links()); ?>

  </div>
</div>
<?php /**PATH C:\Users\saran\listify\resources\views/livewire/admin-user-table.blade.php ENDPATH**/ ?>
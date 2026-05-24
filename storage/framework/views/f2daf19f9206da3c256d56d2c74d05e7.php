
<div>

  
  <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div class="lf-search-wrap" style="flex:1;min-width:220px;max-width:340px">
      <i class="fa-solid fa-magnifying-glass lf-search-icon"></i>
      <input
        type="text"
        wire:model.live="search"
        placeholder="Search tasks…"
        class="lf-input lf-search"
        style="height:38px;padding-top:0;padding-bottom:0"
      >
    </div>
    <div style="display:flex;gap:.5rem;flex-wrap:wrap">
      <button wire:click="$set('filter','all')"
              class="lf-btn lf-btn-sm <?php echo e($filter==='all' ? 'lf-btn-primary' : 'lf-btn-ghost'); ?>">All</button>
      <button wire:click="$set('filter','high')"
              class="lf-btn lf-btn-sm <?php echo e($filter==='high' ? 'lf-btn-primary' : 'lf-btn-ghost'); ?>">High</button>
      <button wire:click="$set('filter','medium')"
              class="lf-btn lf-btn-sm <?php echo e($filter==='medium' ? 'lf-btn-primary' : 'lf-btn-ghost'); ?>">Medium</button>
      <button wire:click="$set('filter','low')"
              class="lf-btn lf-btn-sm <?php echo e($filter==='low' ? 'lf-btn-primary' : 'lf-btn-ghost'); ?>">Low</button>
    </div>
    <div wire:loading style="font-size:12px;color:var(--text-muted)">
      <i class="fa-solid fa-spinner fa-spin"></i> Loading…
    </div>
  </div>

  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tasks->isNotEmpty()): ?>
    <div style="font-size:12px;color:var(--text-muted);margin-bottom:1rem;font-weight:500">
      <?php echo e($tasks->count()); ?> <?php echo e(Str::plural('task', $tasks->count())); ?>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tasks->isEmpty()): ?>
    <div class="lf-card lf-empty lf-scale-in">

      
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $filter !== 'all'): ?>
        
        <svg width="100" height="100" viewBox="0 0 100 100" fill="none"
             xmlns="http://www.w3.org/2000/svg"
             style="margin:0 auto 1.25rem;display:block;color:var(--text-muted);opacity:.5">
          <circle cx="42" cy="42" r="26" stroke="currentColor" stroke-width="3" fill="none"/>
          <path d="M61 61l16 16" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
          <path d="M34 42h16M42 34v16" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" opacity=".4"/>
        </svg>
      <?php else: ?>
        
        <svg width="110" height="110" viewBox="0 0 110 110" fill="none"
             xmlns="http://www.w3.org/2000/svg"
             style="margin:0 auto 1.25rem;display:block;color:var(--text-muted);opacity:.45;
                    animation:lf-float 4s ease-in-out infinite">
          <rect x="18" y="14" width="74" height="86" rx="10" fill="currentColor" opacity=".08"/>
          <rect x="22" y="18" width="66" height="78" rx="8" stroke="currentColor" stroke-width="2" fill="none" opacity=".25"/>
          <rect x="38" y="8" width="34" height="16" rx="8" fill="currentColor" opacity=".15"/>
          <rect x="46" y="12" width="18" height="8" rx="4" fill="currentColor" opacity=".3"/>
          <rect x="30" y="44" width="50" height="6" rx="3" fill="currentColor" opacity=".15"/>
          <rect x="30" y="58" width="38" height="6" rx="3" fill="currentColor" opacity=".10"/>
          <rect x="30" y="72" width="44" height="6" rx="3" fill="currentColor" opacity=".08"/>
          <circle cx="55" cy="95" r="0" fill="currentColor" opacity=".1"/>
        </svg>
      <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

      <div class="lf-empty-title">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?> No tasks matching "<?php echo e($search); ?>"
        <?php elseif($filter !== 'all'): ?> No <?php echo e($filter); ?> priority tasks
        <?php else: ?> No pending tasks yet
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
      <div class="lf-empty-desc">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $filter !== 'all'): ?> Try adjusting your search or filter.
        <?php else: ?> Click <strong>Add Task</strong> above to create your first task.
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="lf-grid-3">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div>
          
          <div class="lf-task-tile <?php echo e($task->status === 'completed' ? 'completed' : ''); ?>">

            
            <div style="display:flex;align-items:center;justify-content:space-between">
              <div class="lf-task-tile-label">TITLE</div>
              <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($task->status === 'completed'): ?>
                <i class="fa-solid fa-circle-check" style="opacity:.4;font-size:18px"></i>
              <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="lf-task-tile-title <?php echo e($task->status === 'completed' ? 'line-through opacity-60' : ''); ?>"
                 style="margin:6px 0">
              <?php echo e($task->title); ?>

            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($task->subtitle): ?>
              <div class="lf-task-tile-sub"><?php echo e($task->subtitle); ?></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:12px">
              <div class="lf-task-tile-date">
                <i class="fa-regular fa-calendar" style="margin-right:4px;opacity:.6"></i>
                <?php echo e($task->due_date ? $task->due_date->format('M d, Y') : 'No due date'); ?>

              </div>
              <span class="lf-pill lf-pill-<?php echo e($task->priority); ?>">
                <?php echo e($task->priority); ?>

              </span>
            </div>

          </div>

          
          <div class="lf-action-row" style="justify-content:center;margin-top:8px">

            
            <form action="<?php echo e(route('tasks.complete', $task)); ?>" method="POST">
              <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
              <button type="submit"
                      title="<?php echo e($task->status === 'completed' ? 'Mark pending' : 'Mark complete'); ?>"
                      class="lf-action-btn success">
                <i class="fa-<?php echo e($task->status === 'completed' ? 'solid' : 'regular'); ?> fa-circle-check"></i>
              </button>
            </form>

            
            <a href="<?php echo e(route('tasks.edit', $task)); ?>"
               title="Edit task" class="lf-action-btn">
              <i class="fa-regular fa-pen-to-square"></i>
            </a>

            
            <button type="button"
                    title="Delete task" class="lf-action-btn danger"
                    onclick="openDeleteModal(<?php echo e($task->id); ?>, '<?php echo e(addslashes($task->title)); ?>')">
              <i class="fa-regular fa-trash-can"></i>
            </button>

          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  
  <div class="lf-modal-backdrop" id="deleteModal" onclick="if(event.target===this)closeDeleteModal()">
    <div class="lf-modal">
      <div style="width:44px;height:44px;background:var(--error-bg);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem">
        <i class="fa-regular fa-trash-can" style="color:var(--error);font-size:18px"></i>
      </div>
      <div class="lf-modal-title">Delete task?</div>
      <p style="font-size:14px;color:var(--text-secondary);margin:.5rem 0 1.5rem">
        Are you sure you want to delete <strong id="deleteTitle"></strong>? This action cannot be undone.
      </p>
      <form id="deleteForm" method="POST" style="display:flex;gap:.75rem;justify-content:flex-end">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button type="button" class="lf-btn lf-btn-secondary" onclick="closeDeleteModal()">Cancel</button>
        <button type="submit" class="lf-btn lf-btn-danger">Delete task</button>
      </form>
    </div>
  </div>

  <script>
    function openDeleteModal(id, title) {
      document.getElementById('deleteTitle').textContent = title;
      document.getElementById('deleteForm').action = '/tasks/' + id;
      document.getElementById('deleteModal').classList.add('open');
    }
    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('open');
    }
  </script>

</div>
<?php /**PATH C:\Users\saran\listify\resources\views/livewire/task-search.blade.php ENDPATH**/ ?>
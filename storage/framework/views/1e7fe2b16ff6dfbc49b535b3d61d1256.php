<div>
  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isNotEmpty()): ?>
    <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem">
      <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="display:inline-flex;align-items:center;gap:6px;
                    background:var(--bg-card);border:1px solid var(--border);
                    border-radius:var(--r-xl);padding:5px 10px 5px 8px;font-size:13px">
          <div style="width:10px;height:10px;border-radius:50%;background:<?php echo e($cat->colour); ?>;flex-shrink:0"></div>
          <span style="font-weight:600;color:var(--text-primary)"><?php echo e($cat->name); ?></span>
          <span style="color:var(--text-muted);font-size:11px">(<?php echo e($cat->tasks_count); ?>)</span>
          <button wire:click="delete(<?php echo e($cat->id); ?>)"
                  wire:confirm="Delete category '<?php echo e(addslashes($cat->name)); ?>'? This cannot be undone."
                  style="background:none;border:none;cursor:pointer;color:var(--text-muted);
                         padding:0;margin-left:2px;line-height:1;font-size:12px"
                  title="Delete category">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

  
  <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showForm): ?>
    <button wire:click="$set('showForm', true)"
            class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-plus"></i> Add category
    </button>
  <?php else: ?>
    <div style="display:flex;align-items:flex-end;gap:.75rem;flex-wrap:wrap;
                background:var(--bg-card);border:1px solid var(--border);
                border-radius:var(--r-md);padding:1rem;margin-top:.5rem">

      <div class="lf-form-group" style="flex:1;min-width:160px;margin-bottom:0">
        <label class="lf-label">Category Name</label>
        <input type="text" wire:model.live="name"
               class="lf-input" placeholder="e.g. Work"
               style="height:38px">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="lf-field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      <div class="lf-form-group" style="margin-bottom:0">
        <label class="lf-label">Colour</label>
        <input type="color" wire:model.live="colour"
               style="height:38px;width:48px;padding:2px;border:1px solid var(--border);
                      border-radius:var(--r-sm);cursor:pointer;background:var(--bg-input)">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['colour'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="lf-field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
      </div>

      <div style="display:flex;gap:.5rem;margin-bottom:0">
        <button wire:click="save" class="lf-btn lf-btn-primary lf-btn-sm">
          Save
        </button>
        <button wire:click="$set('showForm', false)" class="lf-btn lf-btn-secondary lf-btn-sm">
          Cancel
        </button>
      </div>

    </div>
  <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\saran\listify\resources\views/livewire/category-manager.blade.php ENDPATH**/ ?>
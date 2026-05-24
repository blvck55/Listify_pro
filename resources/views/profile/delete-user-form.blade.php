<div>
  <div class="lf-card lf-card-p lf-fade-up" style="border-color:rgba(239,68,68,.3)">

    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
      <div style="width:34px;height:34px;border-radius:var(--r-md);
                  background:linear-gradient(135deg,#EF4444,#DC2626);
                  display:flex;align-items:center;justify-content:center">
        <i class="fa-solid fa-trash-can" style="color:#fff;font-size:14px"></i>
      </div>
      <div>
        <div style="font-size:15px;font-weight:700;color:var(--text-primary)">Delete Account</div>
        <div style="font-size:12px;color:var(--text-secondary)">Permanently delete your account and all associated data.</div>
      </div>
    </div>

    <div style="border-top:1px solid var(--border);margin-bottom:1.25rem"></div>

    <p style="font-size:13px;color:var(--text-secondary);margin-bottom:1.25rem">
      Once your account is deleted, all of its resources and data will be permanently deleted.
      Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <button class="lf-btn lf-btn-danger" wire:click="confirmUserDeletion" wire:loading.attr="disabled">
      <i class="fa-solid fa-trash-can"></i> Delete Account
    </button>

  </div>

  {{-- Confirmation Modal --}}
  <div x-data="{ show: @entangle('confirmingUserDeletion') }"
       x-show="show"
       x-on:keydown.escape.window="show = false"
       style="display:none;position:fixed;inset:0;z-index:50;overflow-y:auto;padding:1.5rem 1rem">

    <div x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-on:click="show = false"
         style="position:fixed;inset:0;background:rgba(0,0,0,.55)"></div>

    <div x-show="show"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         style="position:relative;max-width:480px;margin:3rem auto;z-index:1">
      <div class="lf-card lf-card-p" style="border-color:rgba(239,68,68,.3)">
        <div style="font-size:16px;font-weight:700;color:var(--text-primary);margin-bottom:.4rem">
          Delete Account
        </div>
        <div style="font-size:13px;color:var(--text-secondary);margin-bottom:1.25rem">
          Are you sure you want to delete your account? Once deleted, all of your resources and data
          will be permanently removed. Please enter your password to confirm.
        </div>
        <div class="lf-form-group" style="margin-bottom:1.25rem"
             x-data="{}"
             x-on:confirming-delete-user.window="setTimeout(() => $refs.deletePwd.focus(), 250)">
          <label class="lf-label">Password</label>
          <input type="password" class="lf-input" placeholder="Enter your password"
                 x-ref="deletePwd"
                 wire:model="password"
                 wire:keydown.enter="deleteUser"
                 autocomplete="current-password">
          @error('password')
            <div class="lf-field-error">{{ $message }}</div>
          @enderror
        </div>
        <div style="display:flex;justify-content:flex-end;gap:.75rem">
          <button class="lf-btn lf-btn-ghost" wire:click="$set('confirmingUserDeletion', false)" wire:loading.attr="disabled">
            Cancel
          </button>
          <button class="lf-btn lf-btn-danger" wire:click="deleteUser" wire:loading.attr="disabled">
            <i class="fa-solid fa-trash-can"></i> Delete Account
          </button>
        </div>
      </div>
    </div>

  </div>

</div>

<div>
  <div class="lf-card lf-card-p lf-fade-up">

    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
      <div style="width:34px;height:34px;border-radius:var(--r-md);
                  background:linear-gradient(135deg,#10B981,#059669);
                  display:flex;align-items:center;justify-content:center">
        <i class="fa-solid fa-lock" style="color:#fff;font-size:14px"></i>
      </div>
      <div>
        <div style="font-size:15px;font-weight:700;color:var(--text-primary)">Update Password</div>
        <div style="font-size:12px;color:var(--text-secondary)">Use a long, random password to stay secure.</div>
      </div>
    </div>

    <div style="border-top:1px solid var(--border);margin-bottom:1.25rem"></div>

    <form wire:submit="updatePassword" style="max-width:400px">

      <div class="lf-form-group" style="margin-bottom:.75rem">
        <label class="lf-label" for="current_password">Current Password</label>
        <input id="current_password" type="password" class="lf-input"
               wire:model="state.current_password" autocomplete="current-password">
        @error('current_password')
          <div class="lf-field-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="lf-form-group" style="margin-bottom:.75rem">
        <label class="lf-label" for="password">New Password</label>
        <input id="password" type="password" class="lf-input"
               wire:model="state.password" autocomplete="new-password">
        @error('password')
          <div class="lf-field-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="lf-form-group" style="margin-bottom:1.25rem">
        <label class="lf-label" for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" class="lf-input"
               wire:model="state.password_confirmation" autocomplete="new-password">
        @error('password_confirmation')
          <div class="lf-field-error">{{ $message }}</div>
        @enderror
      </div>

      <div style="display:flex;align-items:center;gap:1rem">
        <button type="submit" class="lf-btn lf-btn-primary" wire:loading.attr="disabled">
          <i class="fa-solid fa-floppy-disk"></i> Save Password
        </button>
        <span x-data="{ show: false }"
              x-on:saved.window="show=true;setTimeout(()=>show=false,2500)"
              x-show="show"
              x-transition
              style="display:none;font-size:13px;color:var(--success);font-weight:600">
          <i class="fa-solid fa-circle-check"></i> Saved.
        </span>
      </div>

    </form>

  </div>
</div>

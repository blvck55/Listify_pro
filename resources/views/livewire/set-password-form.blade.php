<div>
  <div class="lf-card lf-card-p lf-fade-up">

    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
      <div style="width:34px;height:34px;border-radius:var(--r-md);
                  background:linear-gradient(135deg,#6366F1,#8B5CF6);
                  display:flex;align-items:center;justify-content:center">
        <i class="fa-brands fa-google" style="color:#fff;font-size:14px"></i>
      </div>
      <div>
        <div style="font-size:15px;font-weight:700;color:var(--text-primary)">Set a Password</div>
        <div style="font-size:12px;color:var(--text-secondary)">Your account uses Google Sign-In. Set a password to enable 2FA and other security features.</div>
      </div>
    </div>

    <div style="border-top:1px solid var(--border);margin-bottom:1.25rem"></div>

    <div style="display:flex;align-items:flex-start;gap:.75rem;padding:.75rem 1rem;
                background:rgba(99,102,241,.08);border:1px solid rgba(99,102,241,.25);
                border-radius:var(--r-md);margin-bottom:1.25rem">
      <i class="fa-solid fa-circle-info" style="color:#6366F1;margin-top:2px;flex-shrink:0"></i>
      <div style="font-size:13px;color:var(--text-secondary)">
        You signed in with Google, so your account currently has no password you can use.
        Set one here to unlock two-factor authentication and password-protected actions.
      </div>
    </div>

    <form wire:submit="save" style="max-width:400px">

      <div class="lf-form-group" style="margin-bottom:.75rem">
        <label class="lf-label" for="set-password">New Password</label>
        <input id="set-password" type="password" class="lf-input"
               wire:model="password" autocomplete="new-password"
               placeholder="At least 8 characters">
        @error('password')
          <div class="lf-field-error">{{ $message }}</div>
        @enderror
      </div>

      <div class="lf-form-group" style="margin-bottom:1.25rem">
        <label class="lf-label" for="set-password-confirm">Confirm Password</label>
        <input id="set-password-confirm" type="password" class="lf-input"
               wire:model="password_confirmation" autocomplete="new-password">
        @error('password_confirmation')
          <div class="lf-field-error">{{ $message }}</div>
        @enderror
      </div>

      <div style="display:flex;align-items:center;gap:1rem">
        <button type="submit" class="lf-btn lf-btn-primary" wire:loading.attr="disabled">
          <i class="fa-solid fa-key"></i> Set Password
        </button>
        <span x-data="{ show: false }"
              x-on:passwordSet.window="show=true;setTimeout(()=>show=false,3000)"
              x-show="show"
              x-transition
              style="display:none;font-size:13px;color:var(--success);font-weight:600">
          <i class="fa-solid fa-circle-check"></i> Password set! You can now enable 2FA.
        </span>
      </div>

    </form>

  </div>
</div>

<div>
  <div class="lf-card lf-card-p lf-fade-up">

    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
      <div style="width:34px;height:34px;border-radius:var(--r-md);
                  background:linear-gradient(135deg,#F59E0B,#D97706);
                  display:flex;align-items:center;justify-content:center">
        <i class="fa-solid fa-desktop" style="color:#fff;font-size:14px"></i>
      </div>
      <div>
        <div style="font-size:15px;font-weight:700;color:var(--text-primary)">Browser Sessions</div>
        <div style="font-size:12px;color:var(--text-secondary)">Manage and log out your active sessions on other devices.</div>
      </div>
    </div>

    <div style="border-top:1px solid var(--border);margin-bottom:1.25rem"></div>

    <p style="font-size:13px;color:var(--text-secondary);margin-bottom:1.25rem">
      If necessary, you may log out of all of your other browser sessions across all of your devices.
      If you feel your account has been compromised, you should also update your password.
    </p>

    @if (count($this->sessions) > 0)
      <div style="margin-bottom:1.25rem;display:flex;flex-direction:column;gap:.6rem">
        @foreach ($this->sessions as $session)
          <div style="display:flex;align-items:center;gap:.75rem;padding:.75rem;
                      background:var(--bg-card-hover);border:1px solid var(--border);
                      border-radius:var(--r-md)">
            <div style="color:var(--text-secondary);font-size:1.1rem;flex-shrink:0;width:20px;text-align:center">
              @if ($session->agent->isDesktop())
                <i class="fa-solid fa-desktop"></i>
              @else
                <i class="fa-solid fa-mobile-screen"></i>
              @endif
            </div>
            <div>
              <div style="font-size:13px;font-weight:600;color:var(--text-primary)">
                {{ $session->agent->platform() ?: 'Unknown' }} &mdash; {{ $session->agent->browser() ?: 'Unknown' }}
              </div>
              <div style="font-size:11px;color:var(--text-muted);margin-top:2px">
                {{ $session->ip_address }}
                @if ($session->is_current_device)
                  &middot; <span style="color:var(--success);font-weight:600">This device</span>
                @else
                  &middot; Last active {{ $session->last_active }}
                @endif
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <div style="display:flex;align-items:center;gap:1rem">
      <button class="lf-btn lf-btn-secondary" wire:click="confirmLogout" wire:loading.attr="disabled">
        <i class="fa-solid fa-right-from-bracket"></i> Log Out Other Sessions
      </button>
      <span x-data="{ show: false }"
            x-on:loggedOut.window="show=true;setTimeout(()=>show=false,2500)"
            x-show="show"
            x-transition
            style="display:none;font-size:13px;color:var(--success);font-weight:600">
        <i class="fa-solid fa-circle-check"></i> Done.
      </span>
    </div>

  </div>

  {{-- Confirmation Modal --}}
  <div x-data="{ show: @entangle('confirmingLogout') }"
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
      <div class="lf-card lf-card-p">
        <div style="font-size:16px;font-weight:700;color:var(--text-primary);margin-bottom:.4rem">
          Log Out Other Browser Sessions
        </div>
        <div style="font-size:13px;color:var(--text-secondary);margin-bottom:1.25rem">
          Please enter your password to confirm you would like to log out of your other browser sessions.
        </div>
        <div class="lf-form-group" style="margin-bottom:1.25rem"
             x-data="{}"
             x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.sessionPwd.focus(), 250)">
          <label class="lf-label">Password</label>
          <input type="password" class="lf-input" placeholder="Enter your password"
                 x-ref="sessionPwd"
                 wire:model="password"
                 wire:keydown.enter="logoutOtherBrowserSessions"
                 autocomplete="current-password">
          @error('password')
            <div class="lf-field-error">{{ $message }}</div>
          @enderror
        </div>
        <div style="display:flex;justify-content:flex-end;gap:.75rem">
          <button class="lf-btn lf-btn-ghost" wire:click="$set('confirmingLogout', false)" wire:loading.attr="disabled">
            Cancel
          </button>
          <button class="lf-btn lf-btn-primary" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
            <i class="fa-solid fa-right-from-bracket"></i> Log Out
          </button>
        </div>
      </div>
    </div>

  </div>

</div>

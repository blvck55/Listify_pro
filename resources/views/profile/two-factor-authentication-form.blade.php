<div>
  <div class="lf-card lf-card-p lf-fade-up">

    {{-- Section header --}}
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;margin-bottom:1.25rem">
      <div>
        <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.35rem">
          <div style="width:34px;height:34px;border-radius:var(--r-md);
                      background:linear-gradient(135deg,#6366F1,#8B5CF6);
                      display:flex;align-items:center;justify-content:center">
            <i class="fa-solid fa-mobile-screen-button" style="color:#fff;font-size:14px"></i>
          </div>
          <div style="font-size:15px;font-weight:700;color:var(--text-primary)">
            Two-Factor Authentication
          </div>
        </div>
        <div style="font-size:13px;color:var(--text-secondary);max-width:520px">
          Add an extra layer of security. When enabled, you'll be prompted for a verification code
          from your authenticator app each time you sign in.
        </div>
      </div>

      {{-- Status badge --}}
      <div style="flex-shrink:0;margin-top:.25rem">
        @if ($this->enabled)
          <span class="lf-badge lf-badge-green" style="font-size:11px;padding:4px 10px">
            <i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Enabled
          </span>
        @else
          <span class="lf-badge lf-badge-gray" style="font-size:11px;padding:4px 10px">
            <i class="fa-solid fa-circle-xmark" style="margin-right:4px"></i>Disabled
          </span>
        @endif
      </div>
    </div>

    {{-- Divider --}}
    <div style="border-top:1px solid var(--border);margin-bottom:1.25rem"></div>

    {{-- State: 2FA not yet enabled --}}
    @if (! $this->enabled)
      <div style="display:flex;align-items:center;gap:1rem;padding:1rem;
                  background:var(--warning-bg);border:1px solid #FCD34D;
                  border-radius:var(--r-md);margin-bottom:1.25rem">
        <i class="fa-solid fa-triangle-exclamation" style="color:var(--warning);font-size:1.1rem;flex-shrink:0"></i>
        <div style="font-size:13px;color:var(--text-secondary)">
          Two-factor authentication is <strong style="color:var(--text-primary)">not enabled</strong>.
          Enable it to better protect your account.
        </div>
      </div>
    @endif

    {{-- State: confirming (scan QR + enter code) --}}
    @if ($this->enabled && $showingQrCode)
      <div style="margin-bottom:1.25rem">
        <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:.5rem">
          @if ($showingConfirmation)
              Scan the QR code below with your authenticator app (Google Authenticator, Authy, or any TOTP app), then enter the 6-digit code to confirm.
          @endif
        </div>

        {{-- QR Code --}}
        <div style="display:inline-block;padding:12px;background:#fff;border-radius:var(--r-md);
                    border:1px solid var(--border);margin-bottom:1rem">
          {!! $this->user->twoFactorQrCodeSvg() !!}
        </div>

        {{-- Setup key --}}
        <div style="font-size:12px;color:var(--text-secondary);margin-bottom:1rem">
          <span style="font-weight:600;color:var(--text-primary)">Manual setup key:</span>
          <code style="background:var(--bg-card-hover);padding:2px 8px;border-radius:4px;
                       font-size:12px;color:var(--text-primary);margin-left:6px">
            {{ decrypt($this->user->two_factor_secret) }}
          </code>
        </div>

        {{-- OTP confirmation input --}}
        @if ($showingConfirmation)
          <div class="lf-form-group" style="max-width:240px">
            <label class="lf-label" for="2fa-code">Verification Code</label>
            <input id="2fa-code" type="text" inputmode="numeric" autocomplete="one-time-code"
                   autofocus wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication"
                   class="lf-input" placeholder="000000">
            @error('code')
              <div class="lf-field-error">{{ $message }}</div>
            @enderror
          </div>
        @endif
      </div>
    @endif

    {{-- State: showing recovery codes --}}
    @if ($this->enabled && $showingRecoveryCodes)
      <div style="margin-bottom:1.25rem">
        <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:.5rem">
          <i class="fa-solid fa-key" style="color:var(--warning);margin-right:5px"></i>
          Recovery Codes
        </div>
        <div style="font-size:12px;color:var(--text-secondary);margin-bottom:.75rem">
          Store these recovery codes in a secure place. Each code can be used once to regain access
          if you lose your authenticator device.
        </div>
        <div style="background:var(--bg-card-hover);border:1px solid var(--border);
                    border-radius:var(--r-md);padding:.75rem 1rem;
                    display:grid;grid-template-columns:1fr 1fr;gap:.4rem">
          @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
            <code style="font-size:12px;color:var(--text-primary);font-family:monospace">{{ $code }}</code>
          @endforeach
        </div>
      </div>
    @endif

    {{-- ACTION BUTTONS --}}
    <div style="display:flex;flex-wrap:wrap;gap:.75rem;align-items:center">

      @if (! $this->enabled)
        {{-- Enable button --}}
        <x-confirms-password wire:then="enableTwoFactorAuthentication">
          <button type="button" class="lf-btn lf-btn-primary" wire:loading.attr="disabled">
            <i class="fa-solid fa-shield-halved"></i> Enable 2FA
          </button>
        </x-confirms-password>

      @else

        @if ($showingRecoveryCodes)
          <x-confirms-password wire:then="regenerateRecoveryCodes">
            <button type="button" class="lf-btn lf-btn-secondary" wire:loading.attr="disabled">
              <i class="fa-solid fa-rotate"></i> Regenerate Codes
            </button>
          </x-confirms-password>
        @elseif ($showingConfirmation)
          <x-confirms-password wire:then="confirmTwoFactorAuthentication">
            <button type="button" class="lf-btn lf-btn-primary" wire:loading.attr="disabled">
              <i class="fa-solid fa-check"></i> Confirm & Activate
            </button>
          </x-confirms-password>
        @else
          <x-confirms-password wire:then="showRecoveryCodes">
            <button type="button" class="lf-btn lf-btn-secondary" wire:loading.attr="disabled">
              <i class="fa-solid fa-key"></i> Show Recovery Codes
            </button>
          </x-confirms-password>
        @endif

        @if ($showingConfirmation)
          <x-confirms-password wire:then="disableTwoFactorAuthentication">
            <button type="button" class="lf-btn lf-btn-ghost" wire:loading.attr="disabled">
              Cancel
            </button>
          </x-confirms-password>
        @else
          <x-confirms-password wire:then="disableTwoFactorAuthentication">
            <button type="button" class="lf-btn lf-btn-danger" wire:loading.attr="disabled">
              <i class="fa-solid fa-shield-xmark"></i> Disable 2FA
            </button>
          </x-confirms-password>
        @endif

      @endif

    </div>

  </div>
</div>

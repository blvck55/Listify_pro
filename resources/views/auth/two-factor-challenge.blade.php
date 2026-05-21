<x-guest-layout>
  <div class="lf-card" style="padding:2.5rem 2rem;box-shadow:var(--shadow-lg)">
    <div style="text-align:center;margin-bottom:2rem">
      <div class="lf-logo-badge" style="width:48px;height:48px;font-size:20px;margin:0 auto 1rem">L</div>
      <h1 style="font-family:var(--font-head);font-size:1.6rem;font-weight:800;letter-spacing:-.03em;color:var(--text-primary);margin-bottom:.35rem">
        Two-factor authentication
      </h1>
      <p style="font-size:13px;color:var(--text-secondary)">
        Confirm your sign in by entering your authenticator code or recovery code.
      </p>
    </div>

    <div x-data="{ recovery: false }">
      <div style="margin-bottom:1rem;font-size:13px;color:var(--text-secondary);line-height:1.6;" x-show="! recovery">
        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
      </div>

      <div style="margin-bottom:1rem;font-size:13px;color:var(--text-secondary);line-height:1.6;" x-cloak x-show="recovery">
        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
      </div>

      <x-validation-errors class="mb-4" />

      <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div class="lf-form-group" x-show="! recovery">
          <label class="lf-label" for="code">{{ __('Code') }}</label>
          <input id="code" class="lf-input" type="text" inputmode="numeric" name="code" autofocus x-ref="code" autocomplete="one-time-code" />
        </div>

        <div class="lf-form-group" x-cloak x-show="recovery">
          <label class="lf-label" for="recovery_code">{{ __('Recovery Code') }}</label>
          <input id="recovery_code" class="lf-input" type="text" name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;margin-top:1.25rem;flex-wrap:wrap">
          <button type="button" class="lf-btn lf-btn-ghost lf-btn-sm" x-show="! recovery"
                  x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
            {{ __('Use a recovery code') }}
          </button>

          <button type="button" class="lf-btn lf-btn-ghost lf-btn-sm" x-cloak x-show="recovery"
                  x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
            {{ __('Use an authentication code') }}
          </button>

          <button type="submit" class="lf-btn lf-btn-primary" style="min-width:140px">
            {{ __('Log in') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</x-guest-layout>

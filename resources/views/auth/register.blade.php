{{-- FILE: resources/views/auth/register.blade.php --}}
<x-guest-layout>
  <div class="lf-card" style="padding:2.5rem 2rem;box-shadow:var(--shadow-lg)">

    <div style="text-align:center;margin-bottom:2rem">
      <div class="lf-logo-badge" style="width:48px;height:48px;font-size:20px;margin:0 auto 1rem">L</div>
      <h1 style="font-family:var(--font-head);font-size:1.6rem;font-weight:800;
                 letter-spacing:-.03em;color:var(--text-primary);margin-bottom:.35rem">
        Create your account
      </h1>
      <p style="font-size:13px;color:var(--text-secondary)">Start managing your tasks for free</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div style="display:flex;flex-direction:column;gap:1.1rem">

        <div class="lf-form-group">
          <label class="lf-label" for="name">Full name</label>
          <input id="name" name="name" type="text" value="{{ old('name') }}"
                 required autofocus autocomplete="name"
                 class="lf-input {{ $errors->has('name') ? 'lf-input-error' : '' }}"
                 placeholder="John Doe">
          @error('name')
            <div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
          @enderror
        </div>

        <div class="lf-form-group">
          <label class="lf-label" for="email">Email address</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}"
                 required autocomplete="username"
                 class="lf-input {{ $errors->has('email') ? 'lf-input-error' : '' }}"
                 placeholder="you@example.com">
          @error('email')
            <div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
          @enderror
        </div>

        <div class="lf-form-group">
          <label class="lf-label" for="password">Password</label>
          <input id="password" name="password" type="password" required
                 autocomplete="new-password"
                 class="lf-input {{ $errors->has('password') ? 'lf-input-error' : '' }}"
                 placeholder="Minimum 8 characters">
          @error('password')
            <div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
          @enderror
        </div>

        <div class="lf-form-group">
          <label class="lf-label" for="password_confirmation">Confirm password</label>
          <input id="password_confirmation" name="password_confirmation" type="password"
                 required autocomplete="new-password" class="lf-input"
                 placeholder="Re-enter your password">
        </div>

        @if(Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
          <div style="display:flex;align-items:flex-start;gap:8px">
            <input type="checkbox" id="terms" name="terms" required
                   style="width:15px;height:15px;margin-top:2px;accent-color:var(--brand);cursor:pointer">
            <label for="terms" style="font-size:12px;color:var(--text-secondary);line-height:1.5;cursor:pointer">
              I agree to the
              <a href="{{ route('terms.show') }}" target="_blank"
                 style="color:var(--brand);text-decoration:none;font-weight:500">Terms of Service</a>
              and
              <a href="{{ route('policy.show') }}" target="_blank"
                 style="color:var(--brand);text-decoration:none;font-weight:500">Privacy Policy</a>
            </label>
          </div>
        @endif

        <button type="submit" class="lf-btn lf-btn-primary"
                style="width:100%;padding:11px;font-size:14px;margin-top:.25rem">
          <i class="fa-solid fa-user-plus"></i> Create account
        </button>

      </div>
    </form>

    <div style="margin-top:1.25rem">
      <a href="{{ route('auth.google') }}" class="lf-btn lf-btn-outline"
         style="width:100%;padding:11px;font-size:14px;display:flex;align-items:center;
                justify-content:center;gap:8px;text-decoration:none">
        <svg width="18" height="18" viewBox="0 0 24 24">
          <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
          <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
          <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
          <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
        </svg>
        Continue with Google
      </a>
    </div>

    <div style="display:flex;align-items:center;gap:.75rem;margin:1.5rem 0">
      <div style="flex:1;height:1px;background:var(--border)"></div>
      <span style="font-size:12px;color:var(--text-muted);font-weight:500">or</span>
      <div style="flex:1;height:1px;background:var(--border)"></div>
    </div>

    <p style="text-align:center;font-size:13px;color:var(--text-secondary)">
      Already have an account?
      <a href="{{ route('login') }}" style="color:var(--brand);font-weight:600;text-decoration:none">Sign in</a>
    </p>

  </div>
</x-guest-layout>

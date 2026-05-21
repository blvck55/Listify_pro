{{-- FILE: resources/views/auth/forgot-password.blade.php --}}
<x-guest-layout>
  <div class="lf-card" style="padding:2.5rem 2rem;box-shadow:var(--shadow-lg)">

    <div style="text-align:center;margin-bottom:2rem">
      <div style="width:48px;height:48px;background:var(--brand-light);border-radius:var(--r-lg);
                  display:flex;align-items:center;justify-content:center;margin:0 auto 1rem">
        <i class="fa-solid fa-lock" style="color:var(--brand);font-size:20px"></i>
      </div>
      <h1 style="font-family:var(--font-head);font-size:1.5rem;font-weight:800;
                 letter-spacing:-.03em;color:var(--text-primary);margin-bottom:.35rem">
        Reset your password
      </h1>
      <p style="font-size:13px;color:var(--text-secondary);max-width:300px;margin:0 auto">
        Enter your email and we'll send you a reset link.
      </p>
    </div>

    @if(session('status'))
      <div class="lf-alert lf-alert-success" style="margin-bottom:1.25rem">
        <i class="fa-solid fa-circle-check"></i> {{ session('status') }}
      </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div style="display:flex;flex-direction:column;gap:1.1rem">
        <div class="lf-form-group">
          <label class="lf-label" for="email">Email address</label>
          <input id="email" name="email" type="email" value="{{ old('email') }}"
                 required autofocus
                 class="lf-input {{ $errors->has('email') ? 'lf-input-error' : '' }}"
                 placeholder="you@example.com">
          @error('email')
            <div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
          @enderror
        </div>
        <button type="submit" class="lf-btn lf-btn-primary" style="width:100%;padding:11px;font-size:14px">
          <i class="fa-solid fa-paper-plane"></i> Send reset link
        </button>
      </div>
    </form>

    <p style="text-align:center;font-size:13px;color:var(--text-secondary);margin-top:1.5rem">
      <a href="{{ route('login') }}" style="color:var(--brand);font-weight:600;text-decoration:none">
        <i class="fa-solid fa-arrow-left" style="font-size:11px"></i> Back to sign in
      </a>
    </p>
  </div>
</x-guest-layout>

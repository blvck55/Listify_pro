{{-- FILE: resources/views/auth/reset-password.blade.php --}}
<x-guest-layout>
  <div class="lf-card" style="padding:2.5rem 2rem;box-shadow:var(--shadow-lg)">

    <div style="text-align:center;margin-bottom:2rem">
      <img src="{{ asset('images/logo.svg') }}" alt="Listify" style="width:48px;height:48px;margin:0 auto 1rem;display:block" />
      <h1 style="font-family:var(--font-head);font-size:1.5rem;font-weight:800;
                 letter-spacing:-.03em;color:var(--text-primary);margin-bottom:.35rem">
        Set new password
      </h1>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $request->route('token') }}">
      <div style="display:flex;flex-direction:column;gap:1.1rem">

        <div class="lf-form-group">
          <label class="lf-label">Email address</label>
          <input name="email" type="email" value="{{ old('email', $request->email) }}"
                 required class="lf-input {{ $errors->has('email') ? 'lf-input-error' : '' }}">
          @error('email')<div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
        </div>

        <div class="lf-form-group">
          <label class="lf-label">New password</label>
          <input name="password" type="password" required
                 class="lf-input {{ $errors->has('password') ? 'lf-input-error' : '' }}"
                 placeholder="Minimum 8 characters">
          @error('password')<div class="lf-field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>@enderror
        </div>

        <div class="lf-form-group">
          <label class="lf-label">Confirm new password</label>
          <input name="password_confirmation" type="password" required class="lf-input" placeholder="Re-enter password">
        </div>

        <button type="submit" class="lf-btn lf-btn-primary" style="width:100%;padding:11px;font-size:14px">
          <i class="fa-solid fa-check"></i> Reset password
        </button>
      </div>
    </form>

  </div>
</x-guest-layout>

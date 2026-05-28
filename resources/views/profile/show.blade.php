{{-- FILE: resources/views/profile/show.blade.php --}}
<x-app-layout pageTitle="Profile">

  {{-- HERO HEADER --}}
  <div class="lf-fade-up" style="background:linear-gradient(135deg,#0F172A,#1E293B);
              border-radius:var(--r-xl);padding:2rem 2.25rem;margin-bottom:2rem;
              position:relative;overflow:hidden;box-shadow:var(--shadow-lg)">

    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;
                border-radius:50%;background:rgba(99,102,241,.12);pointer-events:none"></div>

    <div style="position:absolute;right:2.5rem;top:50%;transform:translateY(-50%);opacity:.18;pointer-events:none">
      <svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="45" cy="32" r="16" fill="white" opacity=".4"/>
        <path d="M15 78 C15 60 30 52 45 52 C60 52 75 60 75 78" fill="white" opacity=".3"/>
      </svg>
    </div>

    <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem">
      <div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                    color:rgba(255,255,255,.5);margin-bottom:.35rem">
          <i class="fa-solid fa-user-circle" style="margin-right:5px;color:#818CF8"></i> Account
        </div>
        <div style="font-family:var(--font-head);font-size:1.5rem;font-weight:800;
                    color:#fff;letter-spacing:-.03em">Profile Settings</div>
        <div style="font-size:13px;color:rgba(255,255,255,.55);margin-top:.25rem">
          Manage your profile, security, and authentication options.
        </div>
      </div>
      <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}"
         class="lf-btn lf-btn-sm"
         style="background:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.2);
                backdrop-filter:blur(8px)">
        <i class="fa-solid fa-arrow-left"></i> Back
      </a>
    </div>
  </div>

  {{-- PROFILE INFORMATION (name, email, photo) --}}
  <div style="margin-bottom:1.5rem">
    @livewire('profile.update-profile-information-form')
  </div>

  {{-- SET PASSWORD (Google OAuth users only) --}}
  @if (Auth::user()->google_id)
    <div style="margin-bottom:1.5rem">
      @livewire('set-password-form')
    </div>
  @endif

  {{-- UPDATE PASSWORD (email/password users only) --}}
  @if (!Auth::user()->google_id && Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    <div style="margin-bottom:1.5rem">
      @livewire('profile.update-password-form')
    </div>
  @endif

  {{-- TWO-FACTOR AUTHENTICATION --}}
  @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div style="margin-bottom:1.5rem">
      @livewire('profile.two-factor-authentication-form')
    </div>
  @endif

  {{-- BROWSER SESSIONS --}}
  <div style="margin-bottom:1.5rem">
    @livewire('profile.logout-other-browser-sessions-form')
  </div>

  {{-- DELETE ACCOUNT --}}
  @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
    <div style="margin-bottom:1.5rem">
      @livewire('profile.delete-user-form')
    </div>
  @endif

</x-app-layout>

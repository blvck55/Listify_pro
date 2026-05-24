{{-- FILE: resources/views/profile/show.blade.php --}}
<x-app-layout pageTitle="Settings">

  {{-- HERO HEADER --}}
  <div class="lf-fade-up" style="background:linear-gradient(135deg,#0F172A,#1E293B);
              border-radius:var(--r-xl);padding:2rem 2.25rem;margin-bottom:2rem;
              position:relative;overflow:hidden;box-shadow:var(--shadow-lg)">

    <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;
                border-radius:50%;background:rgba(99,102,241,.12);pointer-events:none"></div>

    {{-- Security SVG illustration --}}
    <div style="position:absolute;right:2.5rem;top:50%;transform:translateY(-50%);opacity:.18;pointer-events:none">
      <svg width="90" height="90" viewBox="0 0 90 90" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M45 8 L75 20 V45 C75 62 60 74 45 80 C30 74 15 62 15 45 V20 Z"
              fill="white" opacity=".25"/>
        <path d="M45 18 L68 28 V45 C68 58 57 68 45 73 C33 68 22 58 22 45 V28 Z"
              fill="white" opacity=".15"/>
        <circle cx="45" cy="40" r="8" fill="white" opacity=".5"/>
        <rect x="38" y="46" width="14" height="12" rx="2" fill="white" opacity=".5"/>
        <rect x="41" y="42" width="8" height="6" rx="4" fill="none" stroke="white" stroke-width="2" opacity=".6"/>
      </svg>
    </div>

    <div style="position:relative;z-index:1;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem">
      <div>
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                    color:rgba(255,255,255,.5);margin-bottom:.35rem">
          <i class="fa-solid fa-shield-halved" style="margin-right:5px;color:#818CF8"></i> Account
        </div>
        <div style="font-family:var(--font-head);font-size:1.5rem;font-weight:800;
                    color:#fff;letter-spacing:-.03em">Security Settings</div>
        <div style="font-size:13px;color:rgba(255,255,255,.55);margin-top:.25rem">
          Manage your account security and authentication options.
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

  {{-- SET PASSWORD (Google OAuth users only — they have no known password) --}}
  @if (Auth::user()->google_id)
    <div style="margin-bottom:1.5rem">
      @livewire('set-password-form')
    </div>
  @endif

  {{-- TWO-FACTOR AUTHENTICATION --}}
  @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
    <div style="margin-bottom:1.5rem">
      @livewire('profile.two-factor-authentication-form')
    </div>
  @endif

  {{-- UPDATE PASSWORD (email/password users only — OAuth users use Set Password above) --}}
  @if (!Auth::user()->google_id && Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
    <div style="margin-bottom:1.5rem">
      @livewire('profile.update-password-form')
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

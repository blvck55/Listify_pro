<div>
  <div class="lf-card lf-card-p lf-fade-up">

    <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:1rem">
      <div style="width:34px;height:34px;border-radius:var(--r-md);
                  background:linear-gradient(135deg,#6366F1,#4F46E5);
                  display:flex;align-items:center;justify-content:center">
        <i class="fa-solid fa-user" style="color:#fff;font-size:14px"></i>
      </div>
      <div>
        <div style="font-size:15px;font-weight:700;color:var(--text-primary)">Profile Information</div>
        <div style="font-size:12px;color:var(--text-secondary)">Update your name, email address, and profile photo.</div>
      </div>
    </div>

    <div style="border-top:1px solid var(--border);margin-bottom:1.25rem"></div>

    <form wire:submit="updateProfileInformation" style="max-width:480px">

      {{-- Profile Photo --}}
      @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div x-data="{ photoPreview: null }" style="margin-bottom:1.25rem">
          <input type="file" id="photo" class="hidden" wire:model.live="photo" x-ref="photo"
                 x-on:change="
                   const reader = new FileReader();
                   reader.onload = (e) => { photoPreview = e.target.result; };
                   reader.readAsDataURL($refs.photo.files[0]);
                 " />

          <label class="lf-label" style="margin-bottom:.5rem;display:block">Profile Photo</label>

          <div style="display:flex;align-items:center;gap:1rem">
            {{-- Current or preview photo --}}
            <div style="position:relative">
              <div x-show="!photoPreview" style="width:72px;height:72px;border-radius:50%;overflow:hidden;
                           border:3px solid var(--border);background:var(--bg-card)">
                <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
                     style="width:100%;height:100%;object-fit:cover">
              </div>
              <div x-show="photoPreview" style="display:none;width:72px;height:72px;border-radius:50%;
                           overflow:hidden;border:3px solid var(--accent-indigo);background:var(--bg-card)">
                <img x-bind:src="photoPreview" alt="Preview" style="width:100%;height:100%;object-fit:cover">
              </div>
            </div>

            <div style="display:flex;flex-direction:column;gap:.5rem">
              <button type="button" class="lf-btn lf-btn-sm lf-btn-secondary"
                      x-on:click.prevent="$refs.photo.click()">
                <i class="fa-solid fa-camera"></i> Change Photo
              </button>
              @if ($this->user->profile_photo_path)
                <button type="button" class="lf-btn lf-btn-sm" wire:click="deleteProfilePhoto"
                        style="background:transparent;border:1px solid var(--border);
                               color:var(--text-secondary);font-size:12px">
                  <i class="fa-solid fa-trash"></i> Remove
                </button>
              @endif
            </div>
          </div>

          @error('photo')
            <div class="lf-field-error" style="margin-top:.5rem">{{ $message }}</div>
          @enderror
        </div>
      @endif

      {{-- Name --}}
      <div class="lf-form-group" style="margin-bottom:.75rem">
        <label class="lf-label" for="name">Name</label>
        <input id="name" type="text" class="lf-input" wire:model="state.name"
               required autocomplete="name">
        @error('name')
          <div class="lf-field-error">{{ $message }}</div>
        @enderror
      </div>

      {{-- Email --}}
      <div class="lf-form-group" style="margin-bottom:1.25rem">
        <label class="lf-label" for="email">Email Address</label>
        <input id="email" type="email" class="lf-input" wire:model="state.email"
               required autocomplete="email">
        @error('email')
          <div class="lf-field-error">{{ $message }}</div>
        @enderror

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
          <p style="font-size:12px;color:var(--warning);margin-top:.4rem">
            Your email address is unverified.
            <button type="button" wire:click.prevent="sendEmailVerification"
                    style="background:none;border:none;cursor:pointer;color:var(--accent-indigo);
                           font-size:12px;text-decoration:underline;padding:0">
              Resend verification email.
            </button>
          </p>
          @if ($this->verificationLinkSent)
            <p style="font-size:12px;color:var(--success);margin-top:.25rem;font-weight:600">
              Verification link sent!
            </p>
          @endif
        @endif
      </div>

      <div style="display:flex;align-items:center;gap:1rem">
        <button type="submit" class="lf-btn lf-btn-primary" wire:loading.attr="disabled">
          <i class="fa-solid fa-floppy-disk"></i> Save Changes
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

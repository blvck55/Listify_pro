<div style="position:relative">

  {{-- Bell button --}}
  <button wire:click="$toggle('open')"
          class="lf-icon-btn"
          title="Notifications">
    <i class="fa-regular fa-bell"></i>
    @if($unreadCount > 0)
      <span class="lf-badge">{{ $unreadCount }}</span>
    @endif
  </button>

  {{-- Dropdown panel --}}
  @if($open)
    <div class="lf-dropdown open"
         style="width:320px;right:0;top:calc(100% + 8px)">

      {{-- Header --}}
      <div class="lf-dropdown-header" style="display:flex;align-items:center;justify-content:space-between">
        <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.07em">
          Notifications
        </div>
        @if($unreadCount > 0)
          <button wire:click="markAllRead"
                  style="font-size:11px;color:var(--brand);font-weight:600;background:none;border:none;cursor:pointer;padding:0">
            Mark all read
          </button>
        @endif
      </div>

      {{-- Notification list --}}
      @forelse($notifications as $notif)
        <div wire:click="markRead({{ $notif->id }})"
             class="lf-dropdown-item"
             style="cursor:pointer;{{ !$notif->is_read ? 'background:var(--brand-light)' : '' }}">

          @php
            $icon = match($notif->type) {
              'success' => 'fa-solid fa-circle-check',
              'warning' => 'fa-solid fa-triangle-exclamation',
              default   => 'fa-solid fa-circle-info',
            };
            $iconColor = match($notif->type) {
              'success' => 'var(--success)',
              'warning' => 'var(--warning)',
              default   => 'var(--brand)',
            };
          @endphp

          <i class="{{ $icon }}" style="font-size:14px;color:{{ $iconColor }};flex-shrink:0"></i>
          <div style="min-width:0">
            <div style="font-size:13px;color:var(--text-primary);line-height:1.4">
              {{ $notif->message }}
            </div>
            <div style="font-size:11px;color:var(--text-muted);margin-top:2px">
              {{ $notif->created_at->diffForHumans() }}
            </div>
          </div>
          @if(!$notif->is_read)
            <div style="width:7px;height:7px;border-radius:50%;background:var(--brand);flex-shrink:0;margin-left:auto"></div>
          @endif
        </div>
      @empty
        <div style="padding:1.5rem;text-align:center;font-size:13px;color:var(--text-muted)">
          <i class="fa-regular fa-bell-slash" style="font-size:22px;margin-bottom:.5rem;display:block;opacity:.4"></i>
          No notifications
        </div>
      @endforelse

    </div>
  @endif

</div>

{{-- FILE: resources/views/admin/settings.blade.php --}}
<x-app-layout pageTitle="Admin Settings">

  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">Admin Settings</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        Manage system configuration and preferences
      </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  @if(session('success'))
    <div class="lf-alert lf-alert-success" style="margin-bottom:1.5rem">
      <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif

  {{-- SETTINGS SECTIONS --}}
  <div style="display:grid;grid-template-columns:1fr 2fr;gap:2rem">

    {{-- SIDEBAR NAVIGATION --}}
    <div>
      <div class="lf-card lf-card-p">
        <div style="display:flex;flex-direction:column;gap:0.5rem">
          <a href="#system-settings" class="lf-panel-action" style="padding:0.75rem 1rem;border-radius:var(--r-md);background:var(--brand);color:white;text-decoration:none">
            <i class="fa-solid fa-sliders"></i> System Settings
          </a>
          <a href="#security-settings" class="lf-panel-action" style="padding:0.75rem 1rem;border-radius:var(--r-md);color:var(--text-primary);text-decoration:none">
            <i class="fa-solid fa-shield"></i> Security
          </a>
          <a href="#notification-settings" class="lf-panel-action" style="padding:0.75rem 1rem;border-radius:var(--r-md);color:var(--text-primary);text-decoration:none">
            <i class="fa-solid fa-bell"></i> Notifications
          </a>
          <a href="#maintenance" class="lf-panel-action" style="padding:0.75rem 1rem;border-radius:var(--r-md);color:var(--text-primary);text-decoration:none">
            <i class="fa-solid fa-tools"></i> Maintenance
          </a>
        </div>
      </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div style="display:flex;flex-direction:column;gap:1.5rem">

      {{-- SYSTEM SETTINGS --}}
      <div id="system-settings" class="lf-card lf-card-p">
        <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                    text-transform:uppercase;letter-spacing:.07em;
                    margin-bottom:1.25rem;padding-bottom:.75rem;
                    border-bottom:1px solid var(--border)">
          System Settings
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" style="display:flex;flex-direction:column;gap:1rem">
          @csrf

          <div>
            <label style="display:block;font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem">
              Application Name
            </label>
            <input type="text" class="form-control" value="Listify" disabled style="background:var(--bg-sidebar);border:1px solid var(--border);border-radius:var(--r-md);padding:0.75rem;font-size:12px">
            <div style="font-size:10px;color:var(--text-secondary);margin-top:0.25rem">Application wide name and branding</div>
          </div>

          <div>
            <label style="display:block;font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem">
              System Status
            </label>
            <div style="display:flex;gap:1rem;align-items:center">
              <span class="lf-badge lf-badge-green">
                <i class="fa-solid fa-circle" style="font-size:6px"></i> Operational
              </span>
              <span style="font-size:11px;color:var(--text-secondary)">All systems are running normally</span>
            </div>
          </div>

          <div>
            <label style="display:block;font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem">
              Database Status
            </label>
            <div style="display:flex;gap:1rem;align-items:center">
              <span class="lf-badge lf-badge-green">
                <i class="fa-solid fa-circle" style="font-size:6px"></i> Connected
              </span>
              <span style="font-size:11px;color:var(--text-secondary)">Database connection is healthy</span>
            </div>
          </div>
        </form>
      </div>

      {{-- SECURITY SETTINGS --}}
      <div id="security-settings" class="lf-card lf-card-p">
        <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                    text-transform:uppercase;letter-spacing:.07em;
                    margin-bottom:1.25rem;padding-bottom:.75rem;
                    border-bottom:1px solid var(--border)">
          Security & Access
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">
                Two-Factor Authentication
              </div>
              <div style="font-size:11px;color:var(--text-secondary)">
                Enforce 2FA for all admin accounts
              </div>
            </div>
            <label style="display:flex;align-items:center;cursor:pointer">
              <input type="checkbox" disabled checked style="width:20px;height:20px">
            </label>
          </div>

          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">
                Activity Logging
              </div>
              <div style="font-size:11px;color:var(--text-secondary)">
                Log all admin actions and access
              </div>
            </div>
            <label style="display:flex;align-items:center;cursor:pointer">
              <input type="checkbox" disabled checked style="width:20px;height:20px">
            </label>
          </div>

          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">
                IP Whitelisting
              </div>
              <div style="font-size:11px;color:var(--text-secondary)">
                Restrict admin access to specific IPs
              </div>
            </div>
            <label style="display:flex;align-items:center;cursor:pointer">
              <input type="checkbox" disabled style="width:20px;height:20px">
            </label>
          </div>
        </div>
      </div>

      {{-- NOTIFICATION SETTINGS --}}
      <div id="notification-settings" class="lf-card lf-card-p">
        <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                    text-transform:uppercase;letter-spacing:.07em;
                    margin-bottom:1.25rem;padding-bottom:.75rem;
                    border-bottom:1px solid var(--border)">
          Notification Preferences
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">
                User Registrations
              </div>
              <div style="font-size:11px;color:var(--text-secondary)">
                Notify on new user signups
              </div>
            </div>
            <label style="display:flex;align-items:center;cursor:pointer">
              <input type="checkbox" checked disabled style="width:20px;height:20px">
            </label>
          </div>

          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">
                System Alerts
              </div>
              <div style="font-size:11px;color:var(--text-secondary)">
                Receive system health alerts
              </div>
            </div>
            <label style="display:flex;align-items:center;cursor:pointer">
              <input type="checkbox" checked disabled style="width:20px;height:20px">
            </label>
          </div>

          <div style="display:flex;justify-content:space-between;align-items:flex-start;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div>
              <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.25rem">
                Daily Reports
              </div>
              <div style="font-size:11px;color:var(--text-secondary)">
                Send daily activity summary
              </div>
            </div>
            <label style="display:flex;align-items:center;cursor:pointer">
              <input type="checkbox" disabled style="width:20px;height:20px">
            </label>
          </div>
        </div>
      </div>

      {{-- MAINTENANCE --}}
      <div id="maintenance" class="lf-card lf-card-p">
        <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                    text-transform:uppercase;letter-spacing:.07em;
                    margin-bottom:1.25rem;padding-bottom:.75rem;
                    border-bottom:1px solid var(--border)">
          Maintenance
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem">
          <div style="padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem">
              Clear Cache
            </div>
            <div style="font-size:11px;color:var(--text-secondary);margin-bottom:0.75rem">
              Removes all cached data to refresh the system
            </div>
            <button type="button" class="lf-btn lf-btn-primary lf-btn-sm" disabled>
              <i class="fa-solid fa-trash"></i> Clear Cache
            </button>
          </div>

          <div style="padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem">
              Database Backup
            </div>
            <div style="font-size:11px;color:var(--text-secondary);margin-bottom:0.75rem">
              Create a manual backup of the database
            </div>
            <button type="button" class="lf-btn lf-btn-primary lf-btn-sm" disabled>
              <i class="fa-solid fa-download"></i> Create Backup
            </button>
          </div>

          <div style="padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div style="font-size:12px;font-weight:600;color:var(--text-primary);margin-bottom:0.5rem">
              System Logs
            </div>
            <div style="font-size:11px;color:var(--text-secondary);margin-bottom:0.75rem">
              View and export system error logs
            </div>
            <button type="button" class="lf-btn lf-btn-primary lf-btn-sm" disabled>
              <i class="fa-solid fa-file"></i> View Logs
            </button>
          </div>
        </div>
      </div>

    </div>

  </div>

</x-app-layout>

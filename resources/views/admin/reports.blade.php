{{-- FILE: resources/views/admin/reports.blade.php --}}
<x-app-layout pageTitle="System Reports">

  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">System Reports</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        Overview of system usage and task distribution
      </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  {{-- STAT TILES --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    <div class="lf-stat">
      <div class="lf-stat-label">Total Users</div>
      <div class="lf-stat-value">{{ $stats['total_users'] }}</div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Total Tasks</div>
      <div class="lf-stat-value">{{ $stats['total_tasks'] }}</div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Completion Rate</div>
      <div class="lf-stat-value">{{ $stats['completion_rate'] }}%</div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Avg Tasks/User</div>
      <div class="lf-stat-value">
        {{ $stats['total_users'] > 0 ? round($stats['total_tasks'] / $stats['total_users'], 1) : 0 }}
      </div>
    </div>
  </div>

  {{-- DISTRIBUTION CHARTS --}}
  <div class="lf-grid-2" style="margin-bottom:1.5rem">

    {{-- Task Status --}}
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                  text-transform:uppercase;letter-spacing:.07em;
                  margin-bottom:1.25rem;padding-bottom:.75rem;
                  border-bottom:1px solid var(--border)">
        Task Status Distribution
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem">
        @foreach($stats['status_dist'] as $row)
          @php $pct = $stats['total_tasks'] > 0 ? round($row['count']/$stats['total_tasks']*100) : 0; @endphp
          <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
              <span style="font-size:13px;font-weight:600;color:var(--text-primary);text-transform:capitalize">
                {{ $row['status'] }}
              </span>
              <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:12px;color:var(--text-muted)">{{ $pct }}%</span>
                <span style="font-size:13px;font-weight:700;color:var(--brand)">{{ $row['count'] }}</span>
              </div>
            </div>
            <div class="lf-progress-track">
              <div class="lf-progress-fill" style="width:{{ $pct }}%;background:var(--brand)"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Priority Distribution --}}
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                  text-transform:uppercase;letter-spacing:.07em;
                  margin-bottom:1.25rem;padding-bottom:.75rem;
                  border-bottom:1px solid var(--border)">
        Priority Distribution
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem">
        @foreach($stats['priority_dist'] as $row)
          @php
            $pct = $stats['total_tasks'] > 0 ? round($row['count']/$stats['total_tasks']*100) : 0;
            $bar = match(strtolower($row['priority'])) {
              'high'   => '#EF4444',
              'medium' => '#F59E0B',
              default  => '#22C55E',
            };
            $badge = match(strtolower($row['priority'])) {
              'high'   => 'lf-badge-red',
              'medium' => 'lf-badge-yellow',
              default  => 'lf-badge-green',
            };
          @endphp
          <div>
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
              <span class="lf-badge {{ $badge }}">{{ $row['priority'] }}</span>
              <div style="display:flex;align-items:center;gap:8px">
                <span style="font-size:12px;color:var(--text-muted)">{{ $pct }}%</span>
                <span style="font-size:13px;font-weight:700;color:var(--text-primary)">{{ $row['count'] }}</span>
              </div>
            </div>
            <div class="lf-progress-track">
              <div class="lf-progress-fill" style="width:{{ $pct }}%;background:{{ $bar }}"></div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

  </div>

  {{-- USER ROLES --}}
  <div class="lf-card lf-card-p" style="margin-bottom:1.5rem">
    <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                text-transform:uppercase;letter-spacing:.07em;
                margin-bottom:1.25rem;padding-bottom:.75rem;
                border-bottom:1px solid var(--border)">
      User Roles
    </div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
      <div style="text-align:center;padding:1.5rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
        <div style="font-family:var(--font-head);font-size:3rem;font-weight:800;color:var(--brand);letter-spacing:-.04em">
          {{ $stats['user_count'] }}
        </div>
        <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-top:4px">
          Users
        </div>
      </div>
      <div style="text-align:center;padding:1.5rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
        <div style="font-family:var(--font-head);font-size:3rem;font-weight:800;color:var(--brand);letter-spacing:-.04em">
          {{ $stats['admin_count'] }}
        </div>
        <div style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-top:4px">
          Admins
        </div>
      </div>
    </div>
  </div>

  {{-- TOP USERS --}}
  @if(isset($stats['top_users']) && $stats['top_users']->count() > 0)
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                  text-transform:uppercase;letter-spacing:.07em;
                  margin-bottom:1.25rem;padding-bottom:.75rem;
                  border-bottom:1px solid var(--border)">
        Top Users by Task Count
      </div>
      <div style="display:flex;flex-direction:column;gap:1rem">
        @foreach($stats['top_users']->take(5) as $index => $user)
          <div style="display:flex;align-items:center;gap:1rem">
            <div style="width:32px;height:32px;border-radius:50%;background:var(--brand-light);
                        display:flex;align-items:center;justify-content:center;
                        font-size:12px;font-weight:700;color:var(--brand);flex-shrink:0">
              #{{ $index + 1 }}
            </div>
            <div style="flex:1;min-width:0">
              <div style="font-size:12px;font-weight:600">{{ $user->name }}</div>
              <div style="font-size:10px;color:var(--text-secondary)">{{ $user->email }}</div>
            </div>
            <div style="text-align:right">
              <div style="font-size:13px;font-weight:700;color:var(--brand)">{{ $user->tasks_count }}</div>
              <div style="font-size:10px;color:var(--text-secondary)">{{ $user->tasks_count === 1 ? 'task' : 'tasks' }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

</x-app-layout>

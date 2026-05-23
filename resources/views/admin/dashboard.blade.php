{{-- FILE: resources/views/admin/dashboard.blade.php --}}
<x-app-layout pageTitle="Admin Dashboard">

  {{-- HERO HEADER --}}
  <div class="lf-fade-up" style="background:linear-gradient(135deg,#0F172A,#1E293B);
              border-radius:var(--r-xl);padding:2rem 2.25rem;margin-bottom:2rem;
              position:relative;overflow:hidden;box-shadow:var(--shadow-lg)">
    <div style="position:absolute;top:-40px;right:-40px;width:220px;height:220px;
                border-radius:50%;background:rgba(37,99,235,.12);pointer-events:none"></div>

    {{-- Admin SVG illustration --}}
    <div style="position:absolute;right:2.5rem;top:50%;transform:translateY(-50%);opacity:.18;pointer-events:none">
      <svg width="110" height="90" viewBox="0 0 110 90" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect x="5" y="8" width="100" height="74" rx="8" fill="white"/>
        <rect x="5" y="8" width="100" height="20" rx="8" fill="white" opacity=".3"/>
        <rect x="5" y="24" width="100" height="4" fill="white" opacity=".3"/>
        <rect x="14" y="38" width="35" height="6" rx="3" fill="white" opacity=".4"/>
        <rect x="14" y="50" width="55" height="6" rx="3" fill="white" opacity=".3"/>
        <rect x="14" y="62" width="42" height="6" rx="3" fill="white" opacity=".2"/>
        <circle cx="88" cy="52" r="14" fill="white" opacity=".15"/>
        <path d="M83 52l3.5 3.5L94 48" stroke="#1E293B" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>

    <div style="position:relative;z-index:1">
      <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.1em;
                  color:rgba(255,255,255,.5);margin-bottom:.35rem">
        <i class="fa-solid fa-shield-halved" style="margin-right:5px;color:#3B82F6"></i> Admin Panel
      </div>
      <div style="font-family:var(--font-head);font-size:1.5rem;font-weight:800;
                  color:#fff;letter-spacing:-.03em">
        Welcome, {{ Auth::user()->name }}
      </div>
      <div style="font-size:13px;color:rgba(255,255,255,.55);margin-top:.25rem">
        System overview — {{ now()->format('l, F j Y') }}
      </div>
    </div>
  </div>

  {{-- KEY METRICS (3 COLS) --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:2rem">
    <div class="lf-stat lf-scale-in lf-d1">
      <div class="lf-stat-label">Total Users</div>
      <div class="lf-stat-value lf-count" data-target="{{ $totalUsers }}">{{ $totalUsers }}</div>
      <div class="lf-stat-sub"><i class="fa-solid fa-arrow-trend-up"></i> +{{ $todayUsers }} today</div>
    </div>
    <div class="lf-stat lf-scale-in lf-d2">
      <div class="lf-stat-label">Total Tasks</div>
      <div class="lf-stat-value lf-count" data-target="{{ $totalTasks }}">{{ $totalTasks }}</div>
      <div class="lf-stat-sub"><i class="fa-solid fa-arrow-trend-up"></i> +{{ $todayTasks }} today</div>
    </div>
    <div class="lf-stat lf-scale-in lf-d3">
      <div class="lf-stat-label">Completion Rate</div>
      <div class="lf-stat-value lf-count" data-target="{{ $completionRate }}" data-suffix="%">{{ $completionRate }}%</div>
      <div class="lf-stat-sub">{{ $completedCount }}/{{ $totalTasks }} completed</div>
    </div>
  </div>

  {{-- SECONDARY STATS --}}
  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:2rem">
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Admins
      </div>
      <div style="font-size:2rem;font-weight:700;color:var(--brand);margin:0.5rem 0">{{ $totalAdmins }}</div>
      <div style="font-size:11px;color:var(--text-secondary)">{{ $totalAdmins > 1 ? 'accounts' : 'account' }}</div>
    </div>
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Pending
      </div>
      <div style="font-size:2rem;font-weight:700;color:#F59E0B;margin:0.5rem 0">{{ $pendingCount }}</div>
      <div style="font-size:11px;color:var(--text-secondary)">tasks</div>
    </div>
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Completed
      </div>
      <div style="font-size:2rem;font-weight:700;color:#22C55E;margin:0.5rem 0">{{ $completedCount }}</div>
      <div style="font-size:11px;color:var(--text-secondary)">tasks</div>
    </div>
    <div class="lf-card lf-card-p" style="text-align:center">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em">
        Avg Tasks/User
      </div>
      <div style="font-size:2rem;font-weight:700;color:var(--brand);margin:0.5rem 0">
        {{ $totalUsers > 0 ? round($totalTasks / $totalUsers, 1) : 0 }}
      </div>
      <div style="font-size:11px;color:var(--text-secondary)">per user</div>
    </div>
  </div>

  {{-- TWO COLUMN LAYOUT --}}
  <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;margin-bottom:2rem">

    {{-- RECENT TASKS --}}
    <div>
      <div class="lf-section-header">
        <div class="lf-section-title">Recent Task Activity</div>
        <a href="{{ route('admin.tasks') }}" class="lf-btn lf-btn-ghost lf-btn-sm">View all</a>
      </div>

      <div class="lf-table-wrap">
        <table class="lf-table">
          <thead>
            <tr>
              <th>User</th>
              <th>Task</th>
              <th>Status</th>
              <th>Priority</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($recentTasks as $task)
              <tr>
                <td style="font-size:12px">
                  <div style="display:flex;align-items:center;gap:6px">
                    <div style="width:24px;height:24px;border-radius:50%;background:var(--brand-light);
                                display:flex;align-items:center;justify-content:center;
                                font-size:10px;font-weight:700;color:var(--brand)">
                      {{ strtoupper(substr($task->user->name, 0, 1)) }}
                    </div>
                    {{ $task->user->name }}
                  </div>
                </td>
                <td style="font-size:12px;max-width:150px;overflow:hidden;text-overflow:ellipsis">{{ $task->title }}</td>
                <td>
                  <span class="lf-badge {{ $task->status==='completed' ? 'lf-badge-green' : 'lf-badge-yellow' }}" style="font-size:10px">
                    {{ $task->status }}
                  </span>
                </td>
                <td>
                  @php $pc = match($task->priority){ 'high'=>'lf-badge-red','medium'=>'lf-badge-yellow',default=>'lf-badge-green' }; @endphp
                  <span class="lf-badge {{ $pc }}" style="font-size:10px">{{ $task->priority }}</span>
                </td>
                <td>
                  <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete?')" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="lf-action-btn danger" style="font-size:11px" title="Delete">
                      <i class="fa-regular fa-trash-can"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="5" style="text-align:center;padding:1.5rem;color:var(--text-secondary);font-size:12px">
                No tasks yet
              </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- RECENT USERS & ACTIVITY --}}
    <div>
      <div class="lf-section-header">
        <div class="lf-section-title">Recent Users</div>
        <a href="{{ route('admin.users') }}" class="lf-btn lf-btn-ghost lf-btn-sm">View all</a>
      </div>

      <div style="display:flex;flex-direction:column;gap:0.75rem">
        @forelse($recentUsers as $user)
          <div class="lf-card lf-card-p" style="padding:0.75rem 1rem;display:flex;align-items:center;justify-content:space-between">
            <div style="display:flex;align-items:center;gap:0.75rem">
              <div style="width:32px;height:32px;border-radius:50%;background:var(--brand-light);
                          display:flex;align-items:center;justify-content:center;
                          font-size:11px;font-weight:700;color:var(--brand)">
                {{ strtoupper(substr($user->name, 0, 1)) }}
              </div>
              <div>
                <div style="font-size:12px;font-weight:600">{{ $user->name }}</div>
                <div style="font-size:10px;color:var(--text-secondary)">{{ $user->email }}</div>
              </div>
            </div>
            <span class="lf-badge {{ $user->role === 'admin' ? 'lf-badge-red' : 'lf-badge-green' }}" style="font-size:9px">
              {{ $user->role }}
            </span>
          </div>
        @empty
          <div style="text-align:center;padding:2rem;color:var(--text-secondary);font-size:12px">
            No users yet
          </div>
        @endforelse
      </div>
    </div>

  </div>

  {{-- QUICK LINKS --}}
  <div class="lf-grid-4" style="margin-bottom:2rem">
    <a href="{{ route('admin.users') }}" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">Manage</div>
        <div class="lf-panel-action-title">Users</div>
      </div>
      <i class="fa-solid fa-users"></i>
    </a>
    <a href="{{ route('admin.tasks') }}" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">View</div>
        <div class="lf-panel-action-title">Tasks</div>
      </div>
      <i class="fa-solid fa-list-check"></i>
    </a>
    <a href="{{ route('admin.reports') }}" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">View</div>
        <div class="lf-panel-action-title">Reports</div>
      </div>
      <i class="fa-solid fa-chart-bar"></i>
    </a>
    <a href="{{ route('admin.analytics') }}" class="lf-panel-action">
      <div>
        <div class="lf-panel-action-label">View</div>
        <div class="lf-panel-action-title">Analytics</div>
      </div>
      <i class="fa-solid fa-chart-line"></i>
    </a>
  </div>

  {{-- ADMIN ACTIVITY FEED --}}
  @if($recentActivities->count() > 0)
    <div class="lf-section-header">
      <div class="lf-section-title">Recent Admin Actions</div>
      <a href="{{ route('admin.activity') }}" class="lf-btn lf-btn-ghost lf-btn-sm">View all</a>
    </div>

    <div class="lf-card lf-card-p">
      <div style="display:flex;flex-direction:column;gap:0.75rem">
        @foreach($recentActivities as $activity)
          <div style="display:flex;align-items:flex-start;gap:0.75rem;padding-bottom:0.75rem;border-bottom:1px solid var(--border)">
            <div style="width:32px;height:32px;min-width:32px;border-radius:50%;background:var(--brand-light);
                        display:flex;align-items:center;justify-content:center;margin-top:0.25rem">
              <i class="fa-solid fa-user" style="font-size:0.75rem;color:var(--brand)"></i>
            </div>
            <div style="flex:1;min-width:0">
              <div style="font-size:12px">
                <span style="font-weight:600">{{ $activity->user->name }}</span>
                <span style="color:var(--text-secondary)">{{ $activity->description }}</span>
              </div>
              <div style="font-size:10px;color:var(--text-muted);margin-top:0.25rem">
                {{ $activity->created_at->diffForHumans() }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Count-up animation for stat values --}}
  <script>
    document.querySelectorAll('.lf-count').forEach(el => {
      const target = parseInt(el.dataset.target, 10);
      const suffix = el.dataset.suffix || '';
      if (isNaN(target) || target === 0) return;
      const duration = 900;
      const start = performance.now();
      function step(now) {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        el.textContent = Math.round(eased * target) + suffix;
        if (progress < 1) requestAnimationFrame(step);
      }
      el.textContent = '0' + suffix;
      requestAnimationFrame(step);
    });
  </script>

</x-app-layout>

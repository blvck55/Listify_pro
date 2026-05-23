{{-- FILE: resources/views/admin/analytics.blade.php --}}
<x-app-layout pageTitle="System Analytics">

  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">System Analytics</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        Real-time metrics, charts, and user insights
      </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;margin-bottom:1.5rem">
    <div class="lf-stat">
      <div class="lf-stat-label">Total Users</div>
      <div class="lf-stat-value" id="totalUsersValue">{{ $stats['total_users'] }}</div>
      <div class="lf-stat-sub">registered</div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Admins</div>
      <div class="lf-stat-value" id="totalAdminsValue">{{ $stats['total_admins'] }}</div>
      <div class="lf-stat-sub">{{ $stats['admin_percentage'] }}% of users</div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Total Tasks</div>
      <div class="lf-stat-value" id="totalTasksValue">{{ $stats['total_tasks'] }}</div>
      <div class="lf-stat-sub">across system</div>
    </div>
    <div class="lf-stat">
      <div class="lf-stat-label">Completion Rate</div>
      <div class="lf-stat-value" id="completionRateValue">{{ $stats['completion_rate'] }}%</div>
      <div class="lf-stat-sub" id="completionSummary">{{ $stats['total_completed'] }}/{{ $stats['total_tasks'] }}</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem">
    <div class="lf-card lf-card-p">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:0.75rem">
        Average Tasks Per User
      </div>
      <div class="lf-stat-value" id="avgTasksValue">{{ $stats['avg_tasks_per_user'] }}</div>
    </div>
    <div class="lf-card lf-card-p">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:0.75rem">
        Regular Users
      </div>
      <div class="lf-stat-value" id="regularUsersValue">{{ $stats['total_users'] - $stats['total_admins'] }}</div>
      <div style="font-size:10px;color:var(--text-secondary);margin-top:0.5rem">regular users</div>
    </div>
    <div class="lf-card lf-card-p">
      <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.08em;margin-bottom:0.75rem">
        Pending Tasks
      </div>
      <div class="lf-stat-value" id="pendingTasksValue">{{ $stats['total_tasks'] - $stats['total_completed'] }}</div>
      <div style="font-size:10px;color:var(--text-secondary);margin-top:0.5rem">need completion</div>
    </div>
  </div>

  <div style="display:grid;grid-template-columns:1.4fr 1fr;gap:1rem;margin-bottom:1.5rem">
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);text-transform:uppercase;letter-spacing:.07em;margin-bottom:1rem">
        Task Status Distribution
      </div>
      <canvas id="statusChart" height="240"></canvas>
    </div>
    <div class="lf-card lf-card-p">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);text-transform:uppercase;letter-spacing:.07em;margin-bottom:1rem">
        Priority Breakdown
      </div>
      <canvas id="priorityChart" height="240"></canvas>
    </div>
  </div>

  <div class="lf-card lf-card-p" style="margin-bottom:1.5rem">
    <div style="font-size:13px;font-weight:700;color:var(--text-primary);text-transform:uppercase;letter-spacing:.07em;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border)">
      Task Priority Analysis
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem">
      @foreach($priorityStats as $priority)
        @php
          $bar = match(strtolower($priority->priority)) {
            'high'   => '#EF4444',
            'medium' => '#F59E0B',
            default  => '#22C55E',
          };
          $completedRate = $priority->count > 0 ? round(($priority->completed / $priority->count) * 100, 1) : 0;
        @endphp
        <div>
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:0.75rem">
            <span style="font-size:12px;font-weight:600;text-transform:capitalize">{{ $priority->priority }}</span>
            <span style="font-size:12px;font-weight:700;color:var(--brand)">{{ $priority->count }}</span>
          </div>
          <div class="lf-progress-track" style="margin-bottom:0.5rem">
            <div class="lf-progress-fill" style="width:{{ $completedRate }}%;background:{{ $bar }}"></div>
          </div>
          <div style="font-size:10px;color:var(--text-secondary)">
            {{ $completedRate }}% completed ({{ $priority->completed }}/{{ $priority->count }})
          </div>
        </div>
      @endforeach
    </div>
  </div>

  @if($activeUsers->count() > 0)
    <div class="lf-card lf-card-p" style="margin-bottom:1.5rem">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);text-transform:uppercase;letter-spacing:.07em;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border)">
        Most Active Users (Last 30 Days)
      </div>

      <div style="display:flex;flex-direction:column;gap:1rem">
        @foreach($activeUsers as $index => $user)
          <div style="display:flex;align-items:center;gap:1rem">
            <div style="width:32px;height:32px;border-radius:50%;background:var(--brand-light);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;color:var(--brand);flex-shrink:0">
              #{{ $index + 1 }}
            </div>
            <div style="flex:1;min-width:0">
              <div style="font-size:12px;font-weight:600">{{ $user->name }}</div>
              <div style="font-size:10px;color:var(--text-secondary)">{{ $user->email }}</div>
            </div>
            <div style="text-align:right">
              <div style="font-size:13px;font-weight:700;color:var(--brand)">{{ $user->recent_tasks }}</div>
              <div style="font-size:10px;color:var(--text-secondary)">{{ $user->recent_tasks === 1 ? 'task' : 'tasks' }}</div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <div class="lf-card lf-card-p">
    <div style="font-size:13px;font-weight:700;color:var(--text-primary);text-transform:uppercase;letter-spacing:.07em;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:1px solid var(--border)">
      System Insights
    </div>

    <div style="display:flex;flex-direction:column;gap:1rem">
      <div style="display:flex;gap:1rem;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
        <i class="fa-solid fa-chart-line" style="color:var(--brand);font-size:1.5rem"></i>
        <div>
          <div style="font-size:12px;font-weight:600;margin-bottom:0.25rem">Task Efficiency</div>
          <div style="font-size:11px;color:var(--text-secondary)">
            {{ $stats['completion_rate'] }}% of all tasks are completed. Average user productivity is {{ $stats['avg_tasks_per_user'] }} tasks per person.
          </div>
        </div>
      </div>

      <div style="display:flex;gap:1rem;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
        <i class="fa-solid fa-users" style="color:var(--brand);font-size:1.5rem"></i>
        <div>
          <div style="font-size:12px;font-weight:600;margin-bottom:0.25rem">User Distribution</div>
          <div style="font-size:11px;color:var(--text-secondary)">
            You have {{ $stats['total_users'] - $stats['total_admins'] }} regular users and {{ $stats['total_admins'] }} admin(s) managing the system.
          </div>
        </div>
      </div>

      <div style="display:flex;gap:1rem;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
        <i class="fa-solid fa-tasks" style="color:var(--brand);font-size:1.5rem"></i>
        <div>
          <div style="font-size:12px;font-weight:600;margin-bottom:0.25rem">Workload Status</div>
          <div style="font-size:11px;color:var(--text-secondary)">
            {{ $stats['total_tasks'] - $stats['total_completed'] }} task(s) pending completion out of {{ $stats['total_tasks'] }} total.
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const analyticsDataUrl = @json(route('admin.analytics.data'));
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const priorityCtx = document.getElementById('priorityChart').getContext('2d');

    const statusChart = new Chart(statusCtx, {
      type: 'doughnut',
      data: {
        labels: ['Completed', 'Pending', 'Other'],
        datasets: [{
          label: 'Task Status',
          data: [{{ $stats['total_completed'] }}, {{ $stats['total_tasks'] - $stats['total_completed'] }}, 0],
          backgroundColor: ['#22C55E', '#F59E0B', '#6366F1'],
          borderWidth: 1,
        }],
      },
      options: {
        plugins: {
          legend: { position: 'bottom' },
        },
      },
    });

    const priorityLabels = @json($priorityStats->pluck('priority'));
    const priorityData = @json($priorityStats->pluck('count'));
    const priorityChart = new Chart(priorityCtx, {
      type: 'bar',
      data: {
        labels: priorityLabels,
        datasets: [{
          label: 'Tasks by Priority',
          data: priorityData,
          backgroundColor: ['#EF4444', '#F59E0B', '#22C55E'],
        }],
      },
      options: {
        scales: {
          y: { beginAtZero: true },
        },
        plugins: {
          legend: { display: false },
        },
      },
    });

    function updateMetrics(data) {
      document.getElementById('totalUsersValue').textContent = data.stats.total_users;
      document.getElementById('totalAdminsValue').textContent = data.stats.total_admins;
      document.getElementById('totalTasksValue').textContent = data.stats.total_tasks;
      document.getElementById('completionRateValue').textContent = data.stats.completion_rate + '%';
      document.getElementById('completionSummary').textContent = `${data.stats.total_completed}/${data.stats.total_tasks}`;
      document.getElementById('avgTasksValue').textContent = data.stats.avg_tasks_per_user;
      document.getElementById('regularUsersValue').textContent = data.stats.total_users - data.stats.total_admins;
      document.getElementById('pendingTasksValue').textContent = data.stats.total_tasks - data.stats.total_completed;

      const completed = data.statusStats.completed || 0;
      const pending = data.statusStats.pending || 0;
      const other = data.stats.total_tasks - completed - pending;
      statusChart.data.datasets[0].data = [completed, pending, other];
      statusChart.update();

      priorityChart.data.labels = data.priorityStats.map(item => item.priority);
      priorityChart.data.datasets[0].data = data.priorityStats.map(item => item.count);
      priorityChart.update();
    }

    async function refreshAnalytics() {
      try {
        const response = await fetch(analyticsDataUrl, { headers: { 'Accept': 'application/json' } });
        if (!response.ok) return;
        const data = await response.json();
        updateMetrics(data);
      } catch (error) {
        console.warn('Analytics refresh failed', error);
      }
    }

    setInterval(refreshAnalytics, 15000);
    refreshAnalytics();
  </script>

</x-app-layout>

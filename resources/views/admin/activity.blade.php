{{-- FILE: resources/views/admin/activity.blade.php --}}
<x-app-layout pageTitle="Activity Logs">

  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">Activity Logs</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        System audit trail and admin actions
      </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  {{-- ACTION SUMMARY --}}
  @if($actionCounts->count() > 0)
    <div class="lf-card lf-card-p" style="margin-bottom:1.5rem">
      <div style="font-size:13px;font-weight:700;color:var(--text-primary);
                  text-transform:uppercase;letter-spacing:.07em;
                  margin-bottom:1.25rem;padding-bottom:.75rem;
                  border-bottom:1px solid var(--border)">
        Recent Actions (Last 7 Days)
      </div>
      <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));gap:1rem">
        @foreach($actionCounts as $action)
          <div style="text-align:center;padding:1rem;background:var(--bg-sidebar);border-radius:var(--r-md)">
            <div style="font-size:1.75rem;font-weight:700;color:var(--brand)">{{ $action->count }}</div>
            <div style="font-size:11px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.06em;margin-top:0.5rem">
              {{ str_replace('_', ' ', $action->action) }}
            </div>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  {{-- ACTIVITY TABLE --}}
  <div class="lf-table-wrap">
    <table class="lf-table">
      <thead>
        <tr>
          <th>Admin</th>
          <th>Action</th>
          <th>Resource</th>
          <th>Time</th>
          <th>IP Address</th>
        </tr>
      </thead>
      <tbody>
        @forelse($activities as $activity)
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:8px">
                <div style="width:28px;height:28px;border-radius:50%;background:var(--brand-light);
                            display:flex;align-items:center;justify-content:center;
                            font-size:11px;font-weight:700;color:var(--brand)">
                  {{ strtoupper(substr($activity->user->name, 0, 1)) }}
                </div>
                <div>
                  <div style="font-size:12px;font-weight:600">{{ $activity->user->name }}</div>
                  <div style="font-size:10px;color:var(--text-secondary)">{{ $activity->user->email }}</div>
                </div>
              </div>
            </td>
            <td>
              <div>
                <div style="font-size:12px;font-weight:600;text-transform:capitalize">
                  {{ str_replace('_', ' ', $activity->action) }}
                </div>
                @if($activity->changes)
                  <div style="font-size:10px;color:var(--text-secondary);margin-top:2px">
                    @php
                      $changes = json_decode($activity->changes, true);
                      if (is_array($changes)) {
                        $changeStr = implode(', ', array_map(fn($k, $v) => "$k: " . (is_array($v) ? json_encode($v) : $v), array_keys($changes), $changes));
                        echo substr($changeStr, 0, 100) . (strlen($changeStr) > 100 ? '...' : '');
                      }
                    @endphp
                  </div>
                @endif
              </div>
            </td>
            <td>
              <div style="font-size:12px">
                @if($activity->model_type)
                  <span class="lf-badge lf-badge-blue" style="font-size:10px">{{ $activity->model_type }}</span>
                  @if($activity->model_id)
                    <span style="color:var(--text-secondary);margin-left:0.5rem">#{{ $activity->model_id }}</span>
                  @endif
                @else
                  <span style="color:var(--text-secondary)">System</span>
                @endif
              </div>
            </td>
            <td>
              <div style="font-size:12px">
                <div>{{ $activity->created_at->format('M d, Y') }}</div>
                <div style="font-size:10px;color:var(--text-secondary)">{{ $activity->created_at->format('H:i:s') }}</div>
              </div>
            </td>
            <td style="font-size:11px;color:var(--text-secondary);font-family:monospace">
              {{ $activity->ip_address ?? 'N/A' }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">
              <div style="text-align:center;padding:2rem;color:var(--text-secondary)">
                No activity logged yet
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- PAGINATION --}}
  @if($activities->hasPages())
    <div style="margin-top:1.5rem">
      {{ $activities->links() }}
    </div>
  @endif

</x-app-layout>

{{-- FILE: resources/views/admin/tasks.blade.php --}}
<x-app-layout pageTitle="All Tasks">

  <div class="lf-section-header" style="margin-bottom:1.5rem">
    <div>
      <div class="lf-page-title">All Tasks</div>
      <div style="font-size:13px;color:var(--text-secondary);margin-top:3px">
        System-wide task overview
      </div>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="lf-btn lf-btn-ghost lf-btn-sm">
      <i class="fa-solid fa-arrow-left"></i> Dashboard
    </a>
  </div>

  @if(session('success'))
    <div class="lf-alert lf-alert-success">
      <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
  @endif

  <div class="lf-table-wrap">
    <table class="lf-table">
      <thead>
        <tr>
          <th>User</th><th>Task</th><th>Priority</th><th>Status</th><th>Due Date</th><th>Action</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tasks as $task)
          <tr>
            <td style="font-size:13px;font-weight:500">{{ $task->user->name }}</td>
            <td>
              <div style="font-weight:600;font-size:13px">{{ $task->title }}</div>
              @if($task->subtitle)<div style="font-size:11px;color:var(--text-muted)">{{ $task->subtitle }}</div>@endif
            </td>
            <td>
              @php $pc=match($task->priority){'high'=>'lf-badge-red','medium'=>'lf-badge-yellow',default=>'lf-badge-green'}; @endphp
              <span class="lf-badge {{ $pc }}">{{ $task->priority }}</span>
            </td>
            <td>
              <span class="lf-badge {{ $task->status==='completed' ? 'lf-badge-green' : 'lf-badge-yellow' }}">
                {{ $task->status }}
              </span>
            </td>
            <td style="font-size:13px;color:var(--text-secondary)">
              {{ $task->due_date?->format('M d, Y') ?? '—' }}
            </td>
            <td>
              <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST"
                    onsubmit="return confirm('Delete this task?')">
                @csrf @method('DELETE')
                <button type="submit" class="lf-action-btn danger" title="Delete">
                  <i class="fa-regular fa-trash-can"></i>
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6">
            <div class="lf-empty" style="padding:3rem">
              <div class="lf-empty-icon"><i class="fa-solid fa-list-check"></i></div>
              <div class="lf-empty-title">No tasks yet</div>
            </div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

</x-app-layout>

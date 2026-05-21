<div>
  {{-- Filter buttons --}}
  <div style="display:flex;gap:.5rem;flex-wrap:wrap;margin-bottom:1.5rem">
    @foreach(['all' => 'All', 'created' => 'Created', 'updated' => 'Updated', 'completed' => 'Completed', 'deleted' => 'Deleted'] as $val => $label)
      <button wire:click="$set('filter', '{{ $val }}')"
              class="lf-btn lf-btn-sm {{ $filter === $val ? 'lf-btn-primary' : 'lf-btn-ghost' }}">
        {{ $label }}
      </button>
    @endforeach
  </div>

  {{-- Table --}}
  <div class="lf-table-wrap">
    <table class="lf-table">
      <thead>
        <tr>
          <th>Action</th>
          <th>Task Name</th>
          <th>Old Status</th>
          <th>New Status</th>
          <th>Date &amp; Time</th>
        </tr>
      </thead>
      <tbody>
        @forelse($history as $entry)
          @php
            $badgeClass = match($entry->action) {
              'created'   => 'lf-badge-green',
              'updated'   => 'lf-badge-blue',
              'completed' => 'lf-badge-green',
              'deleted'   => 'lf-badge-red',
              default     => 'lf-badge-gray',
            };
          @endphp
          <tr>
            <td>
              <span class="lf-badge {{ $badgeClass }}">{{ $entry->action }}</span>
            </td>
            <td>
              @if($entry->task)
                <div style="font-weight:600;font-size:13px;color:var(--text-primary)">
                  {{ $entry->task->title }}
                </div>
              @else
                <span style="font-size:12px;color:var(--text-muted);font-style:italic">Deleted task</span>
              @endif
            </td>
            <td>
              @if($entry->old_status)
                <span class="lf-badge lf-badge-gray">{{ $entry->old_status }}</span>
              @else
                <span style="color:var(--text-muted);font-size:12px">—</span>
              @endif
            </td>
            <td>
              @if($entry->new_status)
                <span class="lf-badge {{ $entry->new_status === 'completed' ? 'lf-badge-green' : 'lf-badge-gray' }}">
                  {{ $entry->new_status }}
                </span>
              @else
                <span style="color:var(--text-muted);font-size:12px">—</span>
              @endif
            </td>
            <td style="font-size:12px;color:var(--text-secondary)">
              {{ $entry->changed_at->format('M d, Y H:i') }}
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5">
              <div class="lf-empty">
                <div class="lf-empty-icon"><i class="fa-regular fa-clock"></i></div>
                <div class="lf-empty-title">No activity yet</div>
                <div class="lf-empty-desc">
                  @if($filter !== 'all')
                    No "{{ $filter }}" events recorded. Try a different filter.
                  @else
                    Your task activity will appear here.
                  @endif
                </div>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

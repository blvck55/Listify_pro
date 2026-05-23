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
              <div class="lf-empty lf-scale-in">
                <svg width="90" height="90" viewBox="0 0 90 90" fill="none"
                     xmlns="http://www.w3.org/2000/svg"
                     style="margin:0 auto 1.25rem;display:block;color:var(--text-muted);opacity:.4;
                            animation:lf-float 4s ease-in-out infinite">
                  <circle cx="45" cy="45" r="32" stroke="currentColor" stroke-width="2.5" fill="none" opacity=".3"/>
                  <circle cx="45" cy="45" r="26" fill="currentColor" opacity=".06"/>
                  <path d="M45 27v18l11 7" stroke="currentColor" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round" opacity=".5"/>
                  <circle cx="45" cy="45" r="3" fill="currentColor" opacity=".6"/>
                  <line x1="45" y1="10" x2="45" y2="14" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                  <line x1="45" y1="76" x2="45" y2="80" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                  <line x1="10" y1="45" x2="14" y2="45" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                  <line x1="76" y1="45" x2="80" y2="45" stroke="currentColor" stroke-width="2.5"
                        stroke-linecap="round" opacity=".3"/>
                </svg>
                <div class="lf-empty-title">No activity yet</div>
                <div class="lf-empty-desc">
                  @if($filter !== 'all')
                    No "{{ $filter }}" events recorded. Try a different filter.
                  @else
                    Your task activity will appear here as you work.
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

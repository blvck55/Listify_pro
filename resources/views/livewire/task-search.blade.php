{{-- FILE: resources/views/livewire/task-search.blade.php --}}
<div>

  {{-- SEARCH + FILTER BAR --}}
  <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1.5rem;flex-wrap:wrap">
    <div class="lf-search-wrap" style="flex:1;min-width:220px;max-width:340px">
      <i class="fa-solid fa-magnifying-glass lf-search-icon"></i>
      <input
        type="text"
        wire:model.live="search"
        placeholder="Search tasks…"
        class="lf-input lf-search"
        style="height:38px;padding-top:0;padding-bottom:0"
      >
    </div>
    <div style="display:flex;gap:.5rem;flex-wrap:wrap">
      <button wire:click="$set('filter','all')"
              class="lf-btn lf-btn-sm {{ $filter==='all' ? 'lf-btn-primary' : 'lf-btn-ghost' }}">All</button>
      <button wire:click="$set('filter','high')"
              class="lf-btn lf-btn-sm {{ $filter==='high' ? 'lf-btn-primary' : 'lf-btn-ghost' }}">High</button>
      <button wire:click="$set('filter','medium')"
              class="lf-btn lf-btn-sm {{ $filter==='medium' ? 'lf-btn-primary' : 'lf-btn-ghost' }}">Medium</button>
      <button wire:click="$set('filter','low')"
              class="lf-btn lf-btn-sm {{ $filter==='low' ? 'lf-btn-primary' : 'lf-btn-ghost' }}">Low</button>
    </div>
    <div wire:loading style="font-size:12px;color:var(--text-muted)">
      <i class="fa-solid fa-spinner fa-spin"></i> Loading…
    </div>
  </div>

  {{-- TASK COUNT --}}
  @if($tasks->isNotEmpty())
    <div style="font-size:12px;color:var(--text-muted);margin-bottom:1rem;font-weight:500">
      {{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }}
    </div>
  @endif

  {{-- TASK GRID --}}
  @if($tasks->isEmpty())
    <div class="lf-card lf-empty">
      <div class="lf-empty-icon"><i class="fa-regular fa-clipboard"></i></div>
      <div class="lf-empty-title">
        @if($search) No tasks matching "{{ $search }}"
        @elseif($filter !== 'all') No {{ $filter }} priority tasks
        @else No pending tasks
        @endif
      </div>
      <div class="lf-empty-desc">
        @if($search || $filter !== 'all') Try adjusting your search or filter.
        @else Click <strong>Add Task</strong> above to get started.
        @endif
      </div>
    </div>
  @else
    <div class="lf-grid-3">
      @foreach($tasks as $task)
        <div>
          {{-- BLUE TASK TILE --}}
          <div class="lf-task-tile {{ $task->status === 'completed' ? 'completed' : '' }}">

            {{-- Top row: label + complete watermark --}}
            <div style="display:flex;align-items:center;justify-content:space-between">
              <div class="lf-task-tile-label">TITLE</div>
              @if($task->status === 'completed')
                <i class="fa-solid fa-circle-check" style="opacity:.4;font-size:18px"></i>
              @endif
            </div>

            {{-- Task name --}}
            <div class="lf-task-tile-title {{ $task->status === 'completed' ? 'line-through opacity-60' : '' }}"
                 style="margin:6px 0">
              {{ $task->title }}
            </div>
            @if($task->subtitle)
              <div class="lf-task-tile-sub">{{ $task->subtitle }}</div>
            @endif

            {{-- Bottom: due date + priority --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:auto;padding-top:12px">
              <div class="lf-task-tile-date">
                <i class="fa-regular fa-calendar" style="margin-right:4px;opacity:.6"></i>
                {{ $task->due_date ? $task->due_date->format('M d, Y') : 'No due date' }}
              </div>
              <span class="lf-pill lf-pill-{{ $task->priority }}">
                {{ $task->priority }}
              </span>
            </div>

          </div>

          {{-- ACTION BUTTONS below tile --}}
          <div class="lf-action-row" style="justify-content:center;margin-top:8px">

            {{-- Mark complete/pending --}}
            <form action="{{ route('tasks.complete', $task) }}" method="POST">
              @csrf @method('PATCH')
              <button type="submit"
                      title="{{ $task->status === 'completed' ? 'Mark pending' : 'Mark complete' }}"
                      class="lf-action-btn success">
                <i class="fa-{{ $task->status === 'completed' ? 'solid' : 'regular' }} fa-circle-check"></i>
              </button>
            </form>

            {{-- Edit --}}
            <a href="{{ route('tasks.edit', $task) }}"
               title="Edit task" class="lf-action-btn">
              <i class="fa-regular fa-pen-to-square"></i>
            </a>

            {{-- Delete --}}
            <button type="button"
                    title="Delete task" class="lf-action-btn danger"
                    onclick="openDeleteModal({{ $task->id }}, '{{ addslashes($task->title) }}')">
              <i class="fa-regular fa-trash-can"></i>
            </button>

          </div>
        </div>
      @endforeach
    </div>
  @endif

  {{-- DELETE MODAL --}}
  <div class="lf-modal-backdrop" id="deleteModal" onclick="if(event.target===this)closeDeleteModal()">
    <div class="lf-modal">
      <div style="width:44px;height:44px;background:var(--error-bg);border-radius:10px;display:flex;align-items:center;justify-content:center;margin-bottom:1rem">
        <i class="fa-regular fa-trash-can" style="color:var(--error);font-size:18px"></i>
      </div>
      <div class="lf-modal-title">Delete task?</div>
      <p style="font-size:14px;color:var(--text-secondary);margin:.5rem 0 1.5rem">
        Are you sure you want to delete <strong id="deleteTitle"></strong>? This action cannot be undone.
      </p>
      <form id="deleteForm" method="POST" style="display:flex;gap:.75rem;justify-content:flex-end">
        @csrf @method('DELETE')
        <button type="button" class="lf-btn lf-btn-secondary" onclick="closeDeleteModal()">Cancel</button>
        <button type="submit" class="lf-btn lf-btn-danger">Delete task</button>
      </form>
    </div>
  </div>

  <script>
    function openDeleteModal(id, title) {
      document.getElementById('deleteTitle').textContent = title;
      document.getElementById('deleteForm').action = '/tasks/' + id;
      document.getElementById('deleteModal').classList.add('open');
    }
    function closeDeleteModal() {
      document.getElementById('deleteModal').classList.remove('open');
    }
  </script>

</div>

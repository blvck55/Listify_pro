<div style="display:grid;grid-template-columns:320px 1fr;gap:1.5rem;align-items:start" class="lf-group-grid">

  {{-- LEFT: Groups list --}}
  <div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem">
      <div style="font-size:14px;font-weight:700;color:var(--text-primary)">Groups</div>
      @if(!$showGroupForm)
        <button wire:click="openCreate" class="lf-btn lf-btn-primary lf-btn-sm">
          <i class="fa-solid fa-plus"></i> New
        </button>
      @endif
    </div>

    {{-- Create / Edit Form --}}
    @if($showGroupForm)
    <div class="lf-card lf-card-p" style="margin-bottom:1rem">
      <div style="font-size:13px;font-weight:700;margin-bottom:1rem">
        {{ $editingGroupId ? 'Edit Group' : 'New Group' }}
      </div>
      <div class="lf-form-group">
        <label class="lf-label">Name *</label>
        <input wire:model.live="name" type="text" class="lf-input" placeholder="Group name">
        @error('name') <div class="lf-field-error">{{ $message }}</div> @enderror
      </div>
      <div class="lf-form-group">
        <label class="lf-label">Description</label>
        <input wire:model.live="description" type="text" class="lf-input" placeholder="Optional">
      </div>
      <div class="lf-form-group">
        <label class="lf-label">Members</label>
        <div style="max-height:180px;overflow-y:auto;border:1px solid var(--border);border-radius:var(--r-md);padding:.5rem">
          @foreach($allUsers as $u)
          <label style="display:flex;align-items:center;gap:.5rem;padding:.3rem .5rem;cursor:pointer;border-radius:4px"
                 class="lf-hover-bg">
            <input type="checkbox" wire:model="selectedUserIds" value="{{ $u->id }}">
            <span style="font-size:13px">{{ $u->name }}</span>
            <span style="font-size:11px;color:var(--text-muted);margin-left:auto">{{ $u->email }}</span>
          </label>
          @endforeach
        </div>
      </div>
      <div style="display:flex;gap:.5rem;margin-top:.75rem">
        <button wire:click="saveGroup" class="lf-btn lf-btn-primary lf-btn-sm">Save</button>
        <button wire:click="cancelGroup" class="lf-btn lf-btn-secondary lf-btn-sm">Cancel</button>
      </div>
    </div>
    @endif

    {{-- Groups --}}
    @forelse($groups as $group)
    <div class="lf-card" style="padding:1rem;margin-bottom:.75rem;cursor:pointer;
                border:2px solid {{ $selectedGroupId === $group->id ? 'var(--brand)' : 'transparent' }}"
         wire:click="selectGroup({{ $group->id }})">
      <div style="display:flex;justify-content:space-between;align-items:start">
        <div>
          <div style="font-size:14px;font-weight:700;color:var(--text-primary)">{{ $group->name }}</div>
          @if($group->description)
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px">{{ $group->description }}</div>
          @endif
          <div style="font-size:12px;color:var(--text-muted);margin-top:4px">
            <i class="fa-solid fa-users" style="margin-right:3px"></i>{{ $group->users_count }} members
          </div>
        </div>
        <div style="display:flex;gap:.25rem">
          <button wire:click.stop="editGroup({{ $group->id }})" class="lf-icon-btn" title="Edit" style="font-size:12px">
            <i class="fa-solid fa-pen"></i>
          </button>
          <button wire:click.stop="deleteGroup({{ $group->id }})" class="lf-icon-btn" title="Delete"
                  style="font-size:12px;color:var(--error)" onclick="return confirm('Delete this group?')">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </div>
    </div>
    @empty
    <div style="text-align:center;padding:2rem;color:var(--text-muted);font-size:13px">
      No groups yet. Create one to get started.
    </div>
    @endforelse
  </div>

  {{-- RIGHT: Group detail --}}
  <div>
    @if($selectedGroup)
    <div class="lf-card lf-card-p">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem">
        <div>
          <div style="font-size:18px;font-weight:800;color:var(--text-primary)">{{ $selectedGroup->name }}</div>
          @if($selectedGroup->description)
            <div style="font-size:13px;color:var(--text-muted)">{{ $selectedGroup->description }}</div>
          @endif
        </div>
        @if(!$showTaskForm)
          <button wire:click="openTaskForm" class="lf-btn lf-btn-primary lf-btn-sm">
            <i class="fa-solid fa-plus"></i> Assign Task
          </button>
        @endif
      </div>

      {{-- Assign task form --}}
      @if($showTaskForm)
      <div style="background:var(--bg-surface);border-radius:var(--r-md);padding:1rem;margin-bottom:1.25rem;border:1px solid var(--border)">
        <div style="font-size:13px;font-weight:700;margin-bottom:.75rem">Assign Task to All Members</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem">
          <div class="lf-form-group" style="grid-column:1/-1">
            <label class="lf-label">Title *</label>
            <input wire:model.live="taskTitle" type="text" class="lf-input" placeholder="Task title">
            @error('taskTitle') <div class="lf-field-error">{{ $message }}</div> @enderror
          </div>
          <div class="lf-form-group" style="grid-column:1/-1">
            <label class="lf-label">Description</label>
            <textarea wire:model.live="taskDescription" class="lf-textarea" rows="2"></textarea>
          </div>
          <div class="lf-form-group">
            <label class="lf-label">Due Date</label>
            <input wire:model.live="taskDueDate" type="date" class="lf-input">
          </div>
          <div class="lf-form-group">
            <label class="lf-label">Priority</label>
            <select wire:model.live="taskPriority" class="lf-select">
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>
        </div>
        <div style="display:flex;gap:.5rem;margin-top:.75rem">
          <button wire:click="assignTask" class="lf-btn lf-btn-primary lf-btn-sm">
            <i class="fa-solid fa-paper-plane"></i> Assign to {{ $selectedGroup->users->count() }} members
          </button>
          <button wire:click="$set('showTaskForm',false)" class="lf-btn lf-btn-secondary lf-btn-sm">Cancel</button>
        </div>
      </div>
      @endif

      {{-- Members --}}
      <div style="font-size:13px;font-weight:700;margin-bottom:.75rem;color:var(--text-primary)">
        Members ({{ $selectedGroup->users->count() }})
      </div>
      @foreach($selectedGroup->users as $member)
      <div style="display:flex;align-items:center;gap:.75rem;padding:.6rem 0;border-bottom:1px solid var(--border)">
        <div style="width:32px;height:32px;border-radius:50%;background:var(--brand);display:flex;align-items:center;
                    justify-content:center;font-size:12px;font-weight:700;color:#fff;flex-shrink:0">
          {{ strtoupper(substr($member->name,0,1)) }}
        </div>
        <div style="flex:1;min-width:0">
          <div style="font-size:13px;font-weight:600;color:var(--text-primary)">{{ $member->name }}</div>
          <div style="font-size:11px;color:var(--text-muted)">{{ $member->email }}</div>
        </div>
        <div style="font-size:11px;color:var(--text-muted)">
          {{ $member->tasks->count() }} group task(s)
        </div>
        <button wire:click="removeUserFromGroup({{ $selectedGroup->id }},{{ $member->id }})"
                class="lf-icon-btn" title="Remove" style="font-size:11px;color:var(--error)">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      @endforeach
    </div>
    @else
    <div style="text-align:center;padding:4rem 1rem;color:var(--text-muted)">
      <i class="fa-solid fa-users" style="font-size:2.5rem;margin-bottom:1rem;display:block;opacity:.3"></i>
      <div style="font-size:14px">Select a group to view details</div>
    </div>
    @endif
  </div>

</div>

<style>
@media(max-width:768px){
  .lf-group-grid { grid-template-columns:1fr !important; }
}
</style>

<?php

namespace App\Livewire;

use App\Models\Group;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Livewire component: AdminGroupManager — manage groups and assign tasks.
 */
class AdminGroupManager extends Component
{
    public bool $showGroupForm = false;
    public bool $showTaskForm  = false;
    public ?int $editingGroupId = null;
    public ?int $selectedGroupId = null;

    // Group form fields
    public string $name = '';
    public string $description = '';
    public array $selectedUserIds = [];

    // Task assignment fields
    public string $taskTitle = '';
    public string $taskDescription = '';
    public string $taskDueDate = '';
    public string $taskPriority = 'medium';

    protected function rules(): array
    {
        return [
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string|max:500',
            'selectedUserIds' => 'array',
        ];
    }

    protected function taskRules(): array
    {
        return [
            'taskTitle'       => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'taskDueDate'     => 'nullable|date',
            'taskPriority'    => 'required|in:low,medium,high',
        ];
    }

    public function openCreate(): void
    {
        $this->reset(['editingGroupId', 'name', 'description', 'selectedUserIds']);
        $this->showGroupForm = true;
    }

    public function editGroup(int $id): void
    {
        $group = Group::with('users')->findOrFail($id);
        $this->editingGroupId  = $group->id;
        $this->name            = $group->name;
        $this->description     = $group->description ?? '';
        $this->selectedUserIds = $group->users->pluck('id')->toArray();
        $this->showGroupForm   = true;
    }

    public function saveGroup(): void
    {
        $this->validate();

        if ($this->editingGroupId) {
            $group = Group::findOrFail($this->editingGroupId);
            $group->update(['name' => $this->name, 'description' => $this->description]);
        } else {
            $group = Group::create([
                'created_by'  => Auth::id(),
                'name'        => $this->name,
                'description' => $this->description,
            ]);
        }

        $group->users()->sync($this->selectedUserIds);
        session()->flash('success', 'Group saved successfully.');
        $this->cancelGroup();
    }

    public function deleteGroup(int $id): void
    {
        Group::findOrFail($id)->delete();
        session()->flash('success', 'Group deleted.');
        if ($this->selectedGroupId === $id) {
            $this->selectedGroupId = null;
        }
    }

    public function selectGroup(int $id): void
    {
        $this->selectedGroupId = $id;
        $this->showTaskForm    = false;
    }

    public function openTaskForm(): void
    {
        $this->reset(['taskTitle', 'taskDescription', 'taskDueDate']);
        $this->taskPriority = 'medium';
        $this->showTaskForm = true;
    }

    public function assignTask(): void
    {
        $this->validate($this->taskRules());

        $group = Group::with('users')->findOrFail($this->selectedGroupId);

        foreach ($group->users as $user) {
            Task::create([
                'user_id'     => $user->id,
                'group_id'    => $group->id,
                'title'       => $this->taskTitle,
                'description' => $this->taskDescription ?: null,
                'due_date'    => $this->taskDueDate ?: null,
                'priority'    => $this->taskPriority,
                'status'      => 'pending',
            ]);
        }

        session()->flash('success', "Task assigned to all {$group->users->count()} members.");
        $this->showTaskForm = false;
        $this->reset(['taskTitle', 'taskDescription', 'taskDueDate']);
        $this->taskPriority = 'medium';
    }

    public function removeUserFromGroup(int $groupId, int $userId): void
    {
        Group::findOrFail($groupId)->users()->detach($userId);
    }

    public function cancelGroup(): void
    {
        $this->reset(['showGroupForm', 'editingGroupId', 'name', 'description', 'selectedUserIds']);
    }

    public function render()
    {
        try {
            $groups       = Group::with(['users', 'creator'])->withCount('users')->latest()->get();
            $allUsers     = User::where('role', 'user')->orderBy('name')->get();
            $selectedGroup = $this->selectedGroupId
                ? Group::with(['users.tasks' => fn ($q) => $q->where('group_id', $this->selectedGroupId)->latest()])
                       ->find($this->selectedGroupId)
                : null;
        } catch (\Exception $e) {
            $groups = collect();
            $allUsers = collect();
            $selectedGroup = null;
        }

        return view('livewire.admin-group-manager', compact('groups', 'allUsers', 'selectedGroup'));
    }
}

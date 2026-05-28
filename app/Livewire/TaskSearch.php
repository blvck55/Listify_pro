<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Livewire component: TaskSearch — filter and search pending tasks for a user.
 */
class TaskSearch extends Component
{
    public string $search = '';
    public string $filter = 'all'; // 'all' | 'low' | 'medium' | 'high'

    #[On('taskSaved')]
    public function refreshList(): void {}

    public function render()
    {
        $tasks = Auth::user()
            ->tasks()
            ->when($this->search, fn($q) =>
                $q->where(fn($inner) =>
                    $inner->where('title', 'like', '%' . $this->search . '%')
                          ->orWhere('subtitle', 'like', '%' . $this->search . '%')
                )
            )
            ->when($this->filter !== 'all', fn($q) =>
                $q->where('priority', $this->filter)
            )
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('livewire.task-search', compact('tasks'));
    }
}

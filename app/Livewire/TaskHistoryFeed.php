<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Livewire component: TaskHistoryFeed — shows a user's task change history.
 */
class TaskHistoryFeed extends Component
{
    public string $filter = 'all';

    public function getHistory()
    {
        return Auth::user()
            ->taskHistories()
            ->with('task')
            ->when($this->filter !== 'all', fn($q) =>
                $q->where('action', $this->filter)
            )
            ->latest('changed_at')
            ->get();
    }

    public function render()
    {
        return view('livewire.task-history-feed', [
            'history' => $this->getHistory(),
        ]);
    }
}

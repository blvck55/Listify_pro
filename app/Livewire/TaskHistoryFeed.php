<?php

namespace App\Livewire;

use Livewire\Component;

class TaskHistoryFeed extends Component
{
    public string $filter = 'all';

    public function getHistory()
    {
        return auth()->user()
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

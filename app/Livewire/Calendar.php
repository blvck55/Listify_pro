<?php

namespace App\Livewire;

use App\Models\Note;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Livewire component: Calendar — displays user tasks and notes by month.
 */
class Calendar extends Component
{
    public int $year;
    public int $month;
    public ?string $selectedDate = null;

    public function mount(): void
    {
        $this->year  = now()->year;
        $this->month = now()->month;
    }

    public function prevMonth(): void
    {
        $d = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year  = $d->year;
        $this->month = $d->month;
        $this->selectedDate = null;
    }

    public function nextMonth(): void
    {
        $d = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year  = $d->year;
        $this->month = $d->month;
        $this->selectedDate = null;
    }

    public function prevYear(): void
    {
        $this->year--;
        $this->selectedDate = null;
    }

    public function nextYear(): void
    {
        $this->year++;
        $this->selectedDate = null;
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $this->selectedDate === $date ? null : $date;
    }

    public function render()
    {
        $userId = Auth::id();
        $start  = Carbon::create($this->year, $this->month, 1)->startOfMonth();
        $end    = $start->copy()->endOfMonth();

        $tasks = Task::where('user_id', $userId)
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [$start, $end])
            ->get()
            ->groupBy(fn ($t) => $t->due_date->format('Y-m-d'));

        $notes = Note::where('user_id', $userId)
            ->whereNotNull('note_date')
            ->whereBetween('note_date', [$start, $end])
            ->get()
            ->groupBy(fn ($n) => $n->note_date->format('Y-m-d'));

        // Build calendar grid (pad to start on correct weekday)
        $firstDow  = $start->dayOfWeek; // 0=Sun
        $daysInMonth = $start->daysInMonth;

        $selectedTasks = $selectedNotes = collect();
        if ($this->selectedDate) {
            $selectedTasks = Task::where('user_id', $userId)
                ->whereDate('due_date', $this->selectedDate)
                ->with('category')
                ->get();
            $selectedNotes = Note::where('user_id', $userId)
                ->whereDate('note_date', $this->selectedDate)
                ->get();
        }

        return view('livewire.calendar', compact(
            'start', 'firstDow', 'daysInMonth', 'tasks', 'notes', 'selectedTasks', 'selectedNotes'
        ));
    }
}

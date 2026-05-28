<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

/**
 * Livewire component: TaskForm — create or edit tasks from the UI.
 */
class TaskForm extends Component
{
    public ?int $taskId = null;
    public string $title = '';
    public string $subtitle = '';
    public string $description = '';
    public string $due_date = '';
    public string $priority = 'medium';
    public ?int $category_id = null;
    public bool $showForm = false;

    public function mount(?int $taskId = null)
    {
        if ($taskId) {
            $task = \App\Models\Task::findOrFail($taskId);
            $this->taskId = $task->id;
            $this->title = $task->title;
            $this->subtitle = $task->subtitle ?? '';
            $this->description = $task->description ?? '';
            $this->due_date = $task->due_date?->format('Y-m-d') ?? '';
            $this->priority = $task->priority;
            $this->category_id = $task->category_id;
            $this->showForm = true;
        }
    }

    public function getCategories()
    {
        return \App\Models\Category::where('user_id', Auth::id())->get();
    }

    protected function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id'     => Auth::id(),
            'title'       => $this->title,
            'subtitle'    => $this->subtitle ?: null,
            'description' => $this->description ?: null,
            'due_date'    => $this->due_date ?: null,
            'priority'    => $this->priority,
            'category_id' => $this->category_id,
            'status'      => 'pending',
        ];

        if ($this->taskId) {
            $task = \App\Models\Task::findOrFail($this->taskId);
            if ($task->user_id !== Auth::id()) {
                abort(403);
            }
            $task->update($data);
            session()->flash('success', 'Task updated successfully!');
        } else {
            \App\Models\Task::create($data);
            session()->flash('success', 'Task created successfully!');
        }

        $this->reset(['title', 'subtitle', 'description', 'due_date', 'priority', 'category_id', 'taskId', 'showForm']);
        $this->dispatch('taskSaved');
    }

    public function cancel()
    {
        $this->reset(['title', 'subtitle', 'description', 'due_date', 'priority', 'category_id', 'taskId', 'showForm']);
    }

    public function render()
    {
        return view('livewire.task-form', [
            'categories' => $this->getCategories(),
        ]);
    }
}

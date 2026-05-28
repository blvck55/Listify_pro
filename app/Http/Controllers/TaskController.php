<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * TaskController handles task CRUD operations for the web UI.
 */
class TaskController extends Controller
{
    public function index()
    {
        // Redirect admins to admin dashboard
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        $tasks = Auth::user()
            ->tasks()
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('dashboard', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date|after_or_equal:today',
            'priority'    => 'required|in:low,medium,high',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        $task = Task::create($validated);

        TaskHistory::create([
            'task_id'    => $task->id,
            'user_id'    => Auth::id(),
            'action'     => 'created',
            'old_status' => null,
            'new_status' => 'pending',
            'changed_at' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Task created successfully!');
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
        ]);

        $oldStatus = $task->status;
        $task->update($validated);

        TaskHistory::create([
            'task_id'    => $task->id,
            'user_id'    => Auth::id(),
            'action'     => 'updated',
            'old_status' => $oldStatus,
            'new_status' => $task->status,
            'changed_at' => now(),
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Task updated successfully!');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);

        TaskHistory::create([
            'task_id'    => $task->id,
            'user_id'    => Auth::id(),
            'action'     => 'deleted',
            'old_status' => $task->status,
            'new_status' => null,
            'changed_at' => now(),
        ]);

        $task->delete();

        return redirect()
            ->route('dashboard')
            ->with('success', 'Task deleted.');
    }

    public function complete(Task $task)
    {
        $this->authorizeTask($task);

        $oldStatus = $task->status;
        $newStatus = $task->status === 'completed' ? 'pending' : 'completed';
        $task->update(['status' => $newStatus]);

        TaskHistory::create([
            'task_id'    => $task->id,
            'user_id'    => Auth::id(),
            'action'     => $newStatus === 'completed' ? 'completed' : 'pending',
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_at' => now(),
        ]);

        $msg = $newStatus === 'completed'
            ? 'Task marked as completed!'
            : 'Task moved back to pending.';

        return redirect()
            ->route('dashboard')
            ->with('success', $msg);
    }

    public function history()
    {
        $tasks = Auth::user()
            ->tasks()
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('tasks.history', compact('tasks'));
    }

    private function authorizeTask(Task $task): void
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to modify this task.');
        }
    }
}

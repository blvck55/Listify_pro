<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskApiController extends Controller
{
    public function index()
    {
        $tasks = Auth::user()->tasks()->latest()->get();
        return response()->json(['success' => true, 'count' => $tasks->count(), 'tasks' => $tasks]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'required|in:low,medium,high',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';
        $task = Task::create($validated);
        return response()->json(['success' => true, 'task' => $task], 201);
    }

    public function show(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }
        return response()->json(['success' => true, 'task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }
        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'sometimes|required|in:low,medium,high',
        ]);
        $task->update($validated);
        return response()->json(['success' => true, 'message' => 'Task updated.', 'task' => $task->fresh()]);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }
        $task->delete();
        return response()->json(['success' => true, 'message' => 'Task deleted.']);
    }

    public function complete(Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }
        $task->update(['status' => $task->status === 'completed' ? 'pending' : 'completed']);
        return response()->json(['success' => true, 'message' => 'Status updated.', 'task' => $task->fresh()]);
    }
}

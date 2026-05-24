<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class TaskApiController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $tasks = Auth::user()
            ->tasks()
            ->with('category')
            ->latest()
            ->paginate(15);

        return TaskResource::collection($tasks);
    }

    public function store(Request $request): JsonResponse
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
        $task->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully.',
            'task'    => new TaskResource($task),
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $this->authorize('view', $task);
        $task->load('category');

        return response()->json([
            'success' => true,
            'task'    => new TaskResource($task),
        ]);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date',
            'priority'    => 'sometimes|required|in:low,medium,high',
            'status'      => 'sometimes|required|in:pending,completed',
        ]);

        $task->update($validated);
        $task->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully.',
            'task'    => new TaskResource($task->fresh()),
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $this->authorize('delete', $task);
        $task->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully.',
        ]);
    }

    public function complete(Task $task): JsonResponse
    {
        $this->authorize('update', $task);

        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated.',
            'task'    => new TaskResource($task->fresh()->load('category')),
        ]);
    }
}

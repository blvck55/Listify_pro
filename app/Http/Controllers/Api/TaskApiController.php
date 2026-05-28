<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskApiController extends Controller
{
    /**
     * Return paginated tasks for the authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $tasks = Auth::user()
            ->tasks()
            ->with('category')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => TaskResource::collection($tasks)->resolve(),
            'meta' => [
                'total' => $tasks->total(),
                'per_page' => $tasks->perPage(),
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
            ],
        ]);
    }

    /**
     * Create a new task for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        // Ensure request is JSON
        if (!$request->isJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Request must be JSON.',
            ], 400);
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'location_address' => 'nullable|string|max:500',
            'due_date'         => 'nullable|date',
            'priority'         => 'required|in:low,medium,high',
            'category_id'      => 'nullable|exists:categories,id',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        $task = Task::create($validated);
        $task->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Task created successfully.',
            'data' => new TaskResource($task),
        ], 201);
    }

    /**
     * Return a single task if the user owns it.
     */
    public function show(Task $task): JsonResponse
    {
        $this->authorizeTask($task);
        $task->load('category');

        return response()->json([
            'success' => true,
            'data' => new TaskResource($task),
        ]);
    }

    /**
     * Update an existing task owned by the authenticated user.
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $this->authorizeTask($task);

        // Ensure request is JSON
        if (!$request->isJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Request must be JSON.',
            ], 400);
        }

        $validated = $request->validate([
            'title'            => 'sometimes|required|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'location_address' => 'nullable|string|max:500',
            'due_date'         => 'nullable|date',
            'priority'         => 'sometimes|required|in:low,medium,high',
            'status'           => 'sometimes|required|in:pending,completed',
        ]);

        $task->update($validated);
        $task->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully.',
            'data' => new TaskResource($task->fresh()),
        ]);
    }

    /**
     * Delete a task owned by the authenticated user.
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->authorizeTask($task);
        Task::destroy($task->id);

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully.',
        ]);
    }

    /**
     * Toggle the task status between pending and completed.
     */
    public function complete(Task $task): JsonResponse
    {
        $this->authorizeTask($task);

        $task->update([
            'status' => $task->status === 'completed' ? 'pending' : 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task status updated.',
            'data' => new TaskResource($task->fresh()->load('category')),
        ]);
    }

    /**
     * Ensure the task belongs to the authenticated user.
     */
    private function authorizeTask(Task $task): void
    {
        if ($task->user_id !== Auth::id()) {
            abort(403, 'You do not have permission to modify this task.');
        }
    }
}

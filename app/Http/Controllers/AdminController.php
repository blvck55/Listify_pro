<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * AdminController manages the admin panel and auditing features.
 */
class AdminController extends Controller
{
    /**
     * GET /admin/dashboard
     * Enhanced dashboard with analytics and activity logs
     */
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalTasks = Task::count();
        $completedCount = Task::where('status', 'completed')->count();
        $pendingCount = Task::where('status', 'pending')->count();

        // Today's stats
        $todayUsers = User::whereDate('created_at', today())->count();
        $todayTasks = Task::whereDate('created_at', today())->count();

        // Recent tasks with user
        $recentTasks = Task::with('user')->latest()->take(10)->get();

        // Recent admin activities
        $recentActivities = ActivityLog::with('user')
            ->adminActions()
            ->recent(10)
            ->get();

        // Task completion rate
        $completionRate = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100, 1) : 0;

        // Recent users
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalTasks' => $totalTasks,
            'completedCount' => $completedCount,
            'pendingCount' => $pendingCount,
            'todayUsers' => $todayUsers,
            'todayTasks' => $todayTasks,
            'recentTasks' => $recentTasks,
            'recentActivities' => $recentActivities,
            'completionRate' => $completionRate,
            'recentUsers' => $recentUsers,
        ]);
    }

    /**
     * GET /admin/users
     * All users with task count and status
     */
    public function users()
    {
        $users = User::withCount('tasks')
            ->withCount(['tasks as completed_tasks' => fn($q) => $q->where('status', 'completed')])
            ->latest()
            ->get();

        return view('admin.users', compact('users'));
    }

    /**
     * PATCH /admin/users/{user}/role
     * Toggle between user ↔ admin with activity logging
     */
    public function toggleRole(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot change your own role.');
        }

        $oldRole = $user->role;
        $newRole = $user->role === 'admin' ? 'user' : 'admin';

        $user->update(['role' => $newRole]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user_role_changed',
            'model_type' => 'User',
            'model_id' => $user->id,
            'changes' => ['role' => ['from' => $oldRole, 'to' => $newRole]],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.users')
            ->with('success', "Role updated for {$user->name}.");
    }

    /**
     * DELETE /admin/users/{user}
     * Delete a user with activity logging
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')
                ->with('error', 'You cannot delete your own account.');
        }

        $userName = $user->name;
        $userId = $user->id;

        $user->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'user_deleted',
            'model_type' => 'User',
            'model_id' => $userId,
            'changes' => ['deleted_user' => $userName],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.users')
            ->with('success', 'User deleted.');
    }

    /**
     * GET /admin/tasks
     * All tasks across all users
     */
    public function tasks()
    {
        $tasks = Task::with('user')->latest()->get();
        return view('admin.tasks', compact('tasks'));
    }

    /**
     * DELETE /admin/tasks/{task}
     * Admin removes any task with activity logging
     */
    public function destroyTask(Task $task)
    {
        $taskTitle = $task->title;
        $taskId = $task->id;

        $task->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'task_deleted',
            'model_type' => 'Task',
            'model_id' => $taskId,
            'changes' => ['deleted_task' => $taskTitle],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.tasks')
            ->with('success', 'Task removed.');
    }

    /**
     * GET /admin/reports
     * Enhanced analytics with detailed metrics and trends
     */
    public function reports()
    {
        $totalUsers = User::count();
        $totalTasks = Task::count();

        $statusDist = Task::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->orderBy('status')
            ->get()
            ->map(fn($r) => ['status' => $r->status, 'count' => $r->count])
            ->toArray();

        $priorityDist = Task::selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->get()
            ->map(fn($r) => ['priority' => $r->priority, 'count' => $r->count])
            ->toArray();

        $topUsers = User::withCount('tasks')
            ->orderByDesc('tasks_count')
            ->limit(10)
            ->get();

        $completedCount = Task::where('status', 'completed')->count();
        $completionRate = $totalTasks > 0 ? round(($completedCount / $totalTasks) * 100, 1) : 0;

        return view('admin.reports', [
            'stats' => [
                'total_users' => $totalUsers,
                'total_tasks' => $totalTasks,
                'status_dist' => $statusDist,
                'priority_dist' => $priorityDist,
                'user_count' => User::where('role', 'user')->count(),
                'admin_count' => User::where('role', 'admin')->count(),
                'completion_rate' => $completionRate,
                'top_users' => $topUsers,
                'total_notifications' => Notification::count(),
                'unread_notifications' => Notification::where('is_read', false)->count(),
            ],
        ]);
    }

    /**
     * GET /admin/activity
     * View activity logs and audit trail
     */
    public function activity()
    {
        $activities = ActivityLog::with('user')
            ->latest()
            ->paginate(50);

        $actionCounts = ActivityLog::selectRaw('action, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('action')
            ->orderByDesc('count')
            ->get();

        return view('admin.activity', [
            'activities' => $activities,
            'actionCounts' => $actionCounts,
        ]);
    }

    /**
     * GET /admin/analytics
     * Detailed analytics and system insights
     */
    public function analytics()
    {
        $totalUsers = User::count();
        $totalTasks = Task::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCompleted = Task::where('status', 'completed')->count();

        $completionRate = $totalTasks > 0 ? round(($totalCompleted / $totalTasks) * 100, 1) : 0;
        $adminPercentage = $totalUsers > 0 ? round(($totalAdmins / $totalUsers) * 100, 1) : 0;
        $avgTasksPerUser = $totalUsers > 0 ? round($totalTasks / $totalUsers, 1) : 0;

        $priorityStats = Task::selectRaw('priority, COUNT(*) as count, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            ->groupBy('priority')
            ->get();

        $activeUsers = User::withCount(['tasks as recent_tasks' => fn($q) => $q->where('created_at', '>=', now()->subDays(30))])
            ->having('recent_tasks', '>', 0)
            ->orderByDesc('recent_tasks')
            ->limit(10)
            ->get();

        return view('admin.analytics', [
            'stats' => [
                'total_users' => $totalUsers,
                'total_tasks' => $totalTasks,
                'total_admins' => $totalAdmins,
                'total_completed' => $totalCompleted,
                'completion_rate' => $completionRate,
                'admin_percentage' => $adminPercentage,
                'avg_tasks_per_user' => $avgTasksPerUser,
            ],
            'priorityStats' => $priorityStats,
            'activeUsers' => $activeUsers,
        ]);
    }

    /**
     * GET /admin/analytics/data
     * JSON endpoint for live analytics polling
     */
    public function analyticsData()
    {
        $stats = [
            'total_users' => User::count(),
            'total_tasks' => Task::count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_completed' => Task::where('status', 'completed')->count(),
            'completion_rate' => Task::count() > 0 ? round((Task::where('status', 'completed')->count() / Task::count()) * 100, 1) : 0,
            'avg_tasks_per_user' => User::count() > 0 ? round(Task::count() / User::count(), 1) : 0,
            'pending_tasks' => Task::where('status', 'pending')->count(),
        ];

        $priorityStats = Task::selectRaw('priority, COUNT(*) as count, SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
            ->groupBy('priority')
            ->get()
            ->map(fn($priority) => [
                'priority' => $priority->priority,
                'count' => $priority->count,
                'completed' => $priority->completed,
            ]);

        $statusStats = Task::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($status) => [ $status->status => $status->count ]);

        $topUsers = User::withCount(['tasks as recent_tasks' => fn($q) => $q->where('created_at', '>=', now()->subDays(30))])
            ->having('recent_tasks', '>', 0)
            ->orderByDesc('recent_tasks')
            ->limit(5)
            ->get()
            ->map(fn($user) => [
                'name' => $user->name,
                'email' => $user->email,
                'recent_tasks' => $user->recent_tasks,
            ]);

        return response()->json([
            'stats' => $stats,
            'priorityStats' => $priorityStats,
            'statusStats' => $statusStats,
            'topUsers' => $topUsers,
        ]);
    }

    /**
     * GET /admin/settings
     * Admin panel settings
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * POST /admin/settings
     * Update admin settings
     */
    public function updateSettings()
    {
        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsApiController extends Controller
{
    public function summary(Request $request): JsonResponse
    {
        $user  = Auth::user();
        $tasks = $user->tasks();

        $total     = (clone $tasks)->count();
        $completed = (clone $tasks)->where('status', 'completed')->count();
        $pending   = (clone $tasks)->where('status', 'pending')->count();
        $overdue   = (clone $tasks)
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now())
            ->count();

        $byPriority = (clone $tasks)
            ->selectRaw('priority, COUNT(*) as count')
            ->groupBy('priority')
            ->pluck('count', 'priority');

        $completionRate = $total > 0 ? round(($completed / $total) * 100, 1) : 0;

        return response()->json([
            'success' => true,
            'data'    => [
                'total'            => $total,
                'completed'        => $completed,
                'pending'          => $pending,
                'overdue'          => $overdue,
                'completion_rate'  => $completionRate,
                'by_priority'      => [
                    'high'   => (int) ($byPriority['high']   ?? 0),
                    'medium' => (int) ($byPriority['medium'] ?? 0),
                    'low'    => (int) ($byPriority['low']    ?? 0),
                ],
            ],
        ]);
    }
}

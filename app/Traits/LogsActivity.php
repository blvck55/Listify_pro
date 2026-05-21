<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Log an activity
     *
     * @param string $action
     * @param string|null $modelType
     * @param int|null $modelId
     * @param array|null $changes
     */
    public static function logActivity(
        string $action,
        ?string $modelType = null,
        ?int $modelId = null,
        ?array $changes = null
    ): void {
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'changes' => $changes,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    /**
     * Log creation
     */
    protected static function booted()
    {
        static::created(function ($model) {
            ActivityLog::logActivity(
                strtolower(class_basename($model)) . '_created',
                class_basename($model),
                $model->id,
                $model->toArray()
            );
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();
            unset($changes['updated_at']);

            if (!empty($changes)) {
                ActivityLog::logActivity(
                    strtolower(class_basename($model)) . '_updated',
                    class_basename($model),
                    $model->id,
                    $changes
                );
            }
        });

        static::deleted(function ($model) {
            ActivityLog::logActivity(
                strtolower(class_basename($model)) . '_deleted',
                class_basename($model),
                $model->id
            );
        });
    }
}

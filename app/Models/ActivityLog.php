<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * ActivityLog stores audit trail entries for user and admin actions.
 */
class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'changes',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'changes' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * The user who performed the action
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Get recent logs
     */
    public function scopeRecent($query, $limit = 50)
    {
        return $query->latest()->limit($limit);
    }

    /**
     * Scope: Get admin actions only
     */
    public function scopeAdminActions($query)
    {
        return $query->whereIn('action', [
            'user_role_changed',
            'user_deleted',
            'task_deleted',
            'admin_login',
        ]);
    }

    /**
     * Get a human-readable description of the activity
     */
    public function getDescriptionAttribute()
    {
        return match ($this->action) {
            'user_created' => "created a new user: {$this->model_id}",
            'user_updated' => "updated user: {$this->model_id}",
            'user_deleted' => "deleted user: {$this->model_id}",
            'user_role_changed' => "changed user role: {$this->model_id}",
            'admin_login' => "logged into admin panel",
            'task_created' => "created a new task: {$this->model_id}",
            'task_updated' => "updated task: {$this->model_id}",
            'task_deleted' => "deleted task: {$this->model_id}",
            'task_completed' => "completed task: {$this->model_id}",
            default => "{$this->action}",
        };
    }
}

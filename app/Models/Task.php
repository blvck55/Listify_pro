<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Task represents a single user task with priority and status.
 */
class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'group_id',
        'title',
        'subtitle',
        'description',
        'location_address',
        'due_date',
        'priority',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function taskHistories()
    {
        return $this->hasMany(TaskHistory::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}

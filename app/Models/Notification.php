<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Notification stores user notifications and read state.
 */
class Notification extends Model
{
    use HasFactory;
    protected $table = 'listify_notifications';

    protected $fillable = ['user_id', 'message', 'type', 'is_read'];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

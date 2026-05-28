<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Note stores quick notes tied to a user account.
 */
class Note extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'content', 'color', 'is_pinned', 'note_date'];

    protected $casts = [
        'is_pinned' => 'boolean',
        'note_date'  => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TodoItemUserAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        ''
    ];

    public function todoItem(): BelongsTo
    {
        return $this->belongsTo(TodoItem::class);
    }
}

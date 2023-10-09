<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'task',
    ];

    public function todoItem(): HasMany
    {
        return $this->hasMany(TodoItem::class);
    }
    public function todoItemUserAssignments(): HasMany
    {
        return $this->hasMany(TodoItem::class);
    }
}

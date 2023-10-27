<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'priority',
        'todo_list_id',
        'deadline'
    ];

    public function todoList(): BelongsTo
    {
        return $this->belongsTo(TodoList::class);
    }
    public function todoItemUser(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

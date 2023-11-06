<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class TodoItem extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'user_id',
        'priority',
        'todo_list_id',
        'deadline',
        'state'
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

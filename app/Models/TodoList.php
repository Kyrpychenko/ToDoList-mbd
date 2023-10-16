<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TodoList extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    public function todoItems(): HasMany
    {
        return $this->hasMany(TodoItem::class);
    }
    public function todoListUser(): HasMany
    {
        return $this->hasMany(TodoListUser::class);
    }
}

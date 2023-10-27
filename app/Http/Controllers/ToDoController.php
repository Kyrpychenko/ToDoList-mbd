<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     */ public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'priority' => 'required|in:1,2,3',
            'assignedTo' => 'array',
            'assignedTo*.' => 'integer|exists:users,id',
            'selectedList' => 'integer|exists:todo_lists,id',
            'deadline' => 'required|date',

        ]);
        $todoItem = TodoItem::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'deadline' => $validated['deadline'],
            'todo_list_id' => $validated['selectedList']
        ]);
        $todoItem->todoItemUser()->attach($validated['assignedTo']);
        return back();
    }

    public function syncUser(Request $request, TodoItem $todoItem)
    {
        $validated = $request->validate([
            'assignedTo' => 'array',
            'assignedTo*.' => 'integer|exists:users,id',
        ]);

        dd($todoItem);
        $todoItem->todoItemUser()->sync($validated['assignedTo']);

        return back();
    }
}

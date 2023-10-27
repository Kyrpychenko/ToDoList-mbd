<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;

class ToDoController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'owner' => 'required|sting',
            'priority' => 'required|in:1,2,3',
            'assignedTo' => 'array',
            'assignedTo*.' => 'integer|exists:users,id',
            'selectedList' => 'integer|exists:todo_lists,id',
            'deadline' => 'required|date',

        ]);
        $todoItem = TodoItem::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'owner' => $validated['owner'],
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
        $todoItem->todoItemUser()->sync($validated['assignedTo']);

        return back();
    }
    public function syncState(Request $request, TodoItem $todoItem)
    {
        $validated = $request->validate([
            'state' =>  'string',
        ]);
        $todoItem->update(['state' => $validated['state']]);
        // dd($todoItem);

        return back();
    }
}

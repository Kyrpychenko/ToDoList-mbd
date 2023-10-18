<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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
            'selectedList' => 'integer|exists:todo_lists,id'
        ]);
        $todoItem = TodoItem::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'todo_list_id' => $validated['selectedList']
        ]);
        $todoItem->todoItemUser()->attach($validated['assignedTo']);
        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\TodoListUser;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListController extends Controller
{
    public function index(Request $request)
    {
        $lists = TodoList::all();
        return inertia::render('Lists', compact('lists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'assignedTo' => 'array',
            'assignedTo*.' => 'integer|exists:users,id',
        ]);

        $todoList = TodoList::create([
            'name' => $validated['name']
        ]);
        $todoList->todoListUser()->sync($validated['assignedTo']);


        return back();
    }

    public function syncUser(Request $request, TodoList $todoList)
    {
        $validated = $request->validate([
            'assignedTo' => 'array',
            'assignedTo*.' => 'integer|exists:users,id',
        ]);

        // dd($validated);
        $todoList->todoListUser()->sync($validated['assignedTo']);

        return back();
    }
}

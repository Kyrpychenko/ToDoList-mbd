<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TodoList;
use App\Models\TodoItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListController extends Controller
{
    public function index(Request $request)
    {
        $lists = TodoList::with("todoItems", "todoItems.todoItemUser")->get();
        $users = User::with('todoLists')->get();
        $currentUser = $request->user();
        $currentLists = $currentUser->todoLists()->get()->map(
            function (TodoList $list) {
                return [
                    ...$list->toArray(),
                    'todo_items' =>
                    $list->todoItems()->get()->map(
                        function (TodoItem $todoItem) {
                            return [
                                ...$todoItem->toArray(),
                                'todo_item_user' => $todoItem->todoItemUser()->get()
                            ];
                        }
                    )
                ];
            }
        );
        if ($currentUser->role == 'admin') {
            $currentLists = $lists;
        }
        // dd($lists);
        return inertia::render('Lists', compact('currentUser', 'currentLists', 'users'));
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

    public function sync(Request $request, TodoList $todoList)
    {
        // dd("f");
        $validated = $request->validate([
            'assignedTo' => 'array',
            'assignedTo*.' => 'integer|exists:users,id',
            'name' => 'required|string'
        ]);
        $todoList->todoListUser()->sync($validated['assignedTo']);
        $todoList->update(['name' => $validated['name']]);

        return back();
    }
}

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
        // $listsUsers = TodoListUser::all();
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
        // dd($lists);
        return inertia::render('Lists', compact('currentUser', 'currentLists', 'users', 'lists'));
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

<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Models\TodoList;
use App\Models\TodoListUser;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
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
        return Inertia::render('Dashboard', compact('currentUser', 'currentLists', 'users', 'lists'));
    }
}

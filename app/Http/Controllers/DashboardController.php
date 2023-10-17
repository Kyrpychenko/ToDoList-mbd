<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $currentUser = $request->user();
        $currentLists = $currentUser->todoLists()->get()->map(
            function (TodoList $list) {
                return [
                    ...$list->toArray(),
                    'todos' =>
                    $list->todoItems()->get()->map(
                        function (TodoItem $todoItem) {
                            return [
                                ...$todoItem->toArray(),
                                'assignedTo' => $todoItem->todoItemUser()->get()
                            ];
                        }
                    )
                ];
            }
        );
        return Inertia::render('Dashboard', compact('currentUser', 'currentLists', 'users'));
    }
}

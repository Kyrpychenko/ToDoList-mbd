<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $currentUser = Auth::user();
        if ($currentUser) {
            $currentLists = $currentUser->todoLists()->get();
        }
        return Inertia::render('Dashboard', compact('users', 'currentUser', 'currentLists'));
    }
}

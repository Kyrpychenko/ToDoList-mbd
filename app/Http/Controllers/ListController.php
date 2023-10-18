<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
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
            'name' => 'required|string'
        ]);
        TodoList::create($validated);

        return back();
    }
}

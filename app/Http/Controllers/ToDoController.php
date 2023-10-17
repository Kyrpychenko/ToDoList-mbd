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
            'assignedTo*.' => 'integer|exists:users,id'
        ]);
        TodoItem::create($validated);
        return back();
    }
}

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
     */ public function index(): Response
    {
        return Inertia::render('todo/Index', [
            'todo' => TodoItem::with('user:id,name')->latest()->get(),
        ]);
    }
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // $request->user()->create($validated);

        return redirect(route('todo.index'));
    }
}

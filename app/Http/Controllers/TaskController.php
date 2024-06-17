<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Display a listing of the tasks
    public function index()
    {      $user = Auth::user();
        $tasks = Auth::user()->tasks;
        return view('tasks.index', compact('tasks','user'));
    }

    // Display tasks on the dashboard
    public function dashboard()
    {
        $user = Auth::user();
        $tasks = Auth::user()->tasks;
        return view('dashboard', compact('tasks','user'));
    }

    // Show the form for creating a new task
    public function create()
    {
        return view('tasks.create');
    }

    // Store a newly created task in storage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);

        Auth::user()->tasks()->create($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    // Show the form for editing the specified task
    public function edit(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        return view('tasks.edit', compact('task'));
    }

    // Update the specified task in storage
    public function update(Request $request, Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,completed',
        ]);

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    // Remove the specified task from storage
    public function destroy(Task $task)
    {
        if (Auth::id() !== $task->user_id) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    // Show the specified task
    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }
}

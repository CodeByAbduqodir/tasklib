<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->tasks;
        return view('dashboard', compact('tasks'));
    }

    public function adminIndex()
    {
        $tasks = Task::with('user')->get();
        return view('admin.dashboard', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'required_knowledge' => 'nullable|string',
            'resources' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'status' => 'required|in:in_progress,completed',
            'deadline' => 'nullable|date',
            'solution' => 'nullable|string',
            'progress' => 'nullable|numeric|min:0|max:100',
            'tags' => 'nullable|array',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'required_knowledge' => $request->required_knowledge,
            'resources' => $request->resources,
            'difficulty' => $request->difficulty,
            'status' => $request->status,
            'deadline' => $request->deadline,
            'solution' => $request->solution,
            'progress' => $request->progress ?? 0,
            'tags' => $request->tags,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        if (!auth()->user()->is_admin && $task->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'required_knowledge' => 'nullable|string',
            'resources' => 'nullable|string',
            'difficulty' => 'required|in:easy,medium,hard',
            'status' => 'required|in:in_progress,completed',
            'deadline' => 'nullable|date',
            'solution' => 'nullable|string',
            'progress' => 'nullable|numeric|min:0|max:100',
            'tags' => 'nullable|array',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'requirements' => $request->requirements,
            'required_knowledge' => $request->required_knowledge,
            'resources' => $request->resources,
            'difficulty' => $request->difficulty,
            'status' => $request->status,
            'deadline' => $request->deadline,
            'solution' => $request->solution,
            'progress' => $request->progress ?? 0,
            'tags' => $request->tags,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Task deleted successfully.');
    }
}

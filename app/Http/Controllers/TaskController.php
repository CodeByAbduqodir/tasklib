<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\TaskUser;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::whereNull('user_id')->with('user')->get();
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
            'user_id' => null, // Задача не привязана к конкретному пользователю
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load('currentUserProgress', 'user');
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


    public function start(Task $task)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to start a task.');
        }

        $progress = TaskUser::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => auth()->id()],
            ['status' => 'in_progress']
        );

        return redirect()->route('tasks.show', $task)->with('success', 'Task started successfully.');
    }

    public function publicIndex()
    {
        $tasks = Task::whereNull('user_id')->with('user')->get();
        return view('tasks.index', compact('tasks'));
    }

    public function finish(Request $request, Task $task)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to finish a task.');
        }

        $request->validate([
            'github_link' => 'required|url',
        ]);

        $progress = TaskUser::where('task_id', $task->id)
                            ->where('user_id', auth()->id())
                            ->first();

        if (!$progress) {
            return redirect()->route('tasks.show', $task)->with('error', 'You must start the task before finishing it.');
        }

        $progress->update([
            'status' => 'completed',
            'github_link' => $request->github_link,
        ]);

        $task->update(['status' => 'completed']);

        return redirect()->route('tasks.show', $task)->with('success', 'Task finished successfully.');
    }
}

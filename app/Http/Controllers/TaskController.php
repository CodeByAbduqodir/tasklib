<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskUser;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::whereNull('user_id')->with('user', 'currentUserProgress');

        if ($request->has('status') && in_array($request->status, ['available', 'in_progress', 'completed'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('difficulty') && in_array($request->difficulty, ['easy', 'medium', 'hard'])) {
            $query->where('difficulty', $request->difficulty);
        }

        $sortBy = $request->input('sort_by', 'title');
        $sortDirection = $request->input('sort_direction', 'asc');

        if ($sortBy === 'title') {
            $query->orderBy('title', $sortDirection);
        } elseif ($sortBy === 'difficulty') {
            $query->orderByRaw("FIELD(difficulty, 'easy', 'medium', 'hard') " . $sortDirection);
        } elseif ($sortBy === 'status') {
            $query->orderByRaw("FIELD(status, 'available', 'in_progress', 'completed') " . $sortDirection);
        } elseif ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        }

        $tasks = $query->paginate(10);

        $totalTasks = Task::whereNull('user_id')->count();
        $statusCounts = [
            'available' => Task::whereNull('user_id')->where('status', 'available')->count(),
            'in_progress' => Task::whereNull('user_id')->where('status', 'in_progress')->count(),
            'completed' => Task::whereNull('user_id')->where('status', 'completed')->count(),
        ];
        $difficultyCounts = [
            'easy' => Task::whereNull('user_id')->where('difficulty', 'easy')->count(),
            'medium' => Task::whereNull('user_id')->where('difficulty', 'medium')->count(),
            'hard' => Task::whereNull('user_id')->where('difficulty', 'hard')->count(),
        ];

        return view('dashboard', compact('tasks', 'totalTasks', 'statusCounts', 'difficultyCounts'));
    }

    public function adminIndex(Request $request)
    {
        $query = Task::with('user', 'currentUserProgress');

        if ($request->has('status') && in_array($request->status, ['available', 'in_progress', 'completed'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('difficulty') && in_array($request->difficulty, ['easy', 'medium', 'hard'])) {
            $query->where('difficulty', $request->difficulty);
        }

        $sortBy = $request->input('sort_by', 'title');
        $sortDirection = $request->input('sort_direction', 'asc');

        if ($sortBy === 'title') {
            $query->orderBy('title', $sortDirection);
        } elseif ($sortBy === 'difficulty') {
            $query->orderByRaw("FIELD(difficulty, 'easy', 'medium', 'hard') " . $sortDirection);
        } elseif ($sortBy === 'status') {
            $query->orderByRaw("FIELD(status, 'available', 'in_progress', 'completed') " . $sortDirection);
        } elseif ($sortBy === 'created_at') {
            $query->orderBy('created_at', $sortDirection);
        }

        $tasks = $query->paginate(10);

        $totalTasks = Task::count();
        $statusCounts = [
            'available' => Task::where('status', 'available')->count(),
            'in_progress' => Task::where('status', 'in_progress')->count(),
            'completed' => Task::where('status', 'completed')->count(),
        ];
        $difficultyCounts = [
            'easy' => Task::where('difficulty', 'easy')->count(),
            'medium' => Task::where('difficulty', 'medium')->count(),
            'hard' => Task::where('difficulty', 'hard')->count(),
        ];

        return view('admin.dashboard', compact('tasks', 'totalTasks', 'statusCounts', 'difficultyCounts'));
    }

    public function publicIndex(Request $request)
    {
        $query = Task::whereNull('user_id')->with('user');

        if ($request->has('status') && in_array($request->status, ['available', 'in_progress', 'completed'])) {
            $query->where('status', $request->status);
        }

        if ($request->has('difficulty') && in_array($request->difficulty, ['easy', 'medium', 'hard'])) {
            $query->where('difficulty', $request->difficulty);
        }

        $sortBy = $request->input('sort_by', 'title');
        $sortDirection = $request->input('sort_direction', 'asc');

        if ($sortBy === 'title') {
            $query->orderBy('title', $sortDirection);
        }

        $tasks = $query->paginate(10);

        return view('tasks.index', compact('tasks'));
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
            'status' => 'required|in:available,in_progress,completed',
            'deadline' => 'nullable|date',
            'solution' => 'nullable|string',
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
            'tags' => $request->tags,
            'user_id' => null,
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
        if ($task->status === 'available') {
            $task->update(['status' => 'in_progress']);
        }

        TaskUser::updateOrCreate(
            ['task_id' => $task->id, 'user_id' => auth()->id()],
            ['status' => 'in_progress']
        );

        return redirect()->route('tasks.show', $task)->with('success', 'Task started successfully.');
    }

    public function finish(Request $request, Task $task)
    {
        $request->validate([
            'github_link' => 'required|url',
        ]);

        $progress = TaskUser::where('task_id', $task->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $progress->update([
            'status' => 'completed',
            'github_link' => $request->github_link,
        ]);

        $allCompleted = TaskUser::where('task_id', $task->id)
            ->where('status', '!=', 'completed')
            ->doesntExist();

        if ($allCompleted) {
            $task->update(['status' => 'completed']);
        }

        return redirect()->route('tasks.show', $task)->with('success', 'Task completed successfully.');
    }
}
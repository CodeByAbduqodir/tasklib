<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Your Tasks</h1>

                    <form method="GET" action="{{ route('dashboard') }}" class="mb-4 flex space-x-4">
                        <div>
                            <label for="status" class="block text-gray-600 mb-1">Status</label>
                            <select name="status" id="status" class="p-2 border border-gray-300 rounded-lg">
                                <option value="">All</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div>
                            <label for="difficulty" class="block text-gray-600 mb-1">Difficulty</label>
                            <select name="difficulty" id="difficulty" class="p-2 border border-gray-300 rounded-lg">
                                <option value="">All</option>
                                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort_by" class="block text-gray-600 mb-1">Sort By</label>
                            <select name="sort_by" id="sort_by" class="p-2 border border-gray-300 rounded-lg">
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                                <option value="progress" {{ request('sort_by') == 'progress' ? 'selected' : '' }}>Progress</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort_direction" class="block text-gray-600 mb-1">Direction</label>
                            <select name="sort_direction" id="sort_direction" class="p-2 border border-gray-300 rounded-lg">
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                        <div class="self-end">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Apply</button>
                        </div>
                    </form>

                    @if($tasks->isEmpty())
                        <p>No tasks found.</p>
                    @else
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Title</th>
                                    <th class="border border-gray-300 px-4 py-2">Difficulty</th>
                                    <th class="border border-gray-300 px-4 py-2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2">Progress</th>
                                    <th class="border border-gray-300 px-4 py-2">User</th>
                                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td class="border border-gray-300 px-4 py-2">{{ $task->title }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $task->difficulty }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $task->status }}</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $task->progress }}%</td>
                                        <td class="border border-gray-300 px-4 py-2">{{ $task->user ? $task->user->email : 'Created by Admin' }}</td>
                                        <td class="border border-gray-300 px-4 py-2">
                                            <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:underline">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
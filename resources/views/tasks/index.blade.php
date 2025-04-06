<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Приветственное сообщение -->
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold mb-2">Welcome to TaskLib! 🚀</h1>
                        <p class="text-lg text-gray-600">
                            Explore a variety of tasks to improve your skills. 
                            @auth
                                Start working on a task now!
                            @else
                                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Log in</a> or 
                                <a href="{{ route('register') }}" class="text-blue-500 hover:underline">register</a> to get started!
                            @endauth
                        </p>
                    </div>

                    <form method="GET" action="{{ route('home') }}" class="mb-6 flex space-x-4">
                        <div>
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div>
                            <label for="difficulty" class="form-label">Difficulty</label>
                            <select name="difficulty" id="difficulty" class="form-select">
                                <option value="">All</option>
                                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select name="sort_by" id="sort_by" class="form-select">
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                            </select>
                        </div>
                        <div>
                            <label for="sort_direction" class="form-label">Direction</label>
                            <select name="sort_direction" id="sort_direction" class="form-select">
                                <option value="asc" {{ request('sort_direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                <option value="desc" {{ request('sort_direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            </select>
                        </div>
                        <div class="self-end">
                            <button type="submit" class="btn btn-primary">Apply</button>
                        </div>
                    </form>

                    @if($tasks->isEmpty())
                        <p>No tasks found.</p>
                    @else
                        <div class="table-container">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Difficulty</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr class="fade-in">
                                            <td>{{ $task->title }}</td>
                                            <td>{{ $task->difficulty }}</td>
                                            <td>{{ $task->status }}</td>
                                            <td>
                                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 pagination">
                            {{ $tasks->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6 fade-in">Dashboard - Your Tasks</h1>

                    <form method="GET" action="{{ route('dashboard') }}" class="mb-6 flex space-x-4">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">All</option>
                                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="difficulty" class="form-label">Difficulty</label>
                            <select name="difficulty" id="difficulty" class="form-select">
                                <option value="">All</option>
                                <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sort_by" class="form-label">Sort By</label>
                            <select name="sort_by" id="sort_by" class="form-select">
                                <option value="title" {{ request('sort_by') == 'title' ? 'selected' : '' }}>Title</option>
                            </select>
                        </div>
                        <div class="form-group">
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
                        <p class="fade-in">No tasks found.</p>
                    @else
                        <div class="table-container">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Difficulty</th>
                                        <th>Status</th>
                                        <th>Your Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr class="fade-in">
                                            <td>{{ $task->title }}</td>
                                            <td>
                                                <span class="difficulty-{{ $task->difficulty }}">
                                                    <i class="fas fa-star mr-1 {{ $task->difficulty == 'easy' ? 'text-green-500' : ($task->difficulty == 'medium' ? 'text-orange-500' : 'text-red-500') }}"></i>
                                                    {{ $task->difficulty }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-{{ $task->status }}">
                                                    <i class="fas fa-circle mr-1 {{ $task->status == 'available' ? 'text-green-500' : ($task->status == 'in_progress' ? 'text-yellow-500' : 'text-blue-500') }}"></i>
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-{{ $task->currentUserProgress->status ?? 'not_started' }}">
                                                    <i class="fas fa-circle mr-1 {{ ($task->currentUserProgress->status ?? 'not_started') == 'available' ? 'text-green-500' : (($task->currentUserProgress->status ?? 'not_started') == 'in_progress' ? 'text-yellow-500' : (($task->currentUserProgress->status ?? 'not_started') == 'completed' ? 'text-blue-500' : 'text-gray-500')) }}"></i>
                                                    {{ $task->currentUserProgress->status ?? 'Not Started' }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-500 hover:underline">View</a>
                                                @if($task->currentUserProgress && $task->currentUserProgress->status == 'in_progress')
                                                    <form action="{{ route('tasks.finish', $task) }}" method="POST" class="inline">
                                                        @csrf
                                                        <input type="text" name="github_link" placeholder="GitHub Link" class="form-input ml-2" required>
                                                        <button type="submit" class="btn btn-success ml-2">Finish</button>
                                                    </form>
                                                @elseif(!$task->currentUserProgress || $task->currentUserProgress->status == 'not_started')
                                                    <a href="{{ route('tasks.start', $task) }}" class="btn btn-success ml-2">Start</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 pagination fade-in">
                            {{ $tasks->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
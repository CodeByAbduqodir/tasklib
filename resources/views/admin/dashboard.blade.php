<x-app-layout>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Приветственное сообщение -->
                    <div class="mb-6 fade-in">
                        <h1 class="text-3xl font-bold mb-2">Admin Dashboard 🚀</h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            Manage all tasks and view platform statistics.
                        </p>
                    </div>

                    <!-- Сообщение об успехе -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg fade-in">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Карточки с аналитикой -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                        <!-- Карточка: Всего задач -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md fade-in">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-tasks mr-2 text-blue-600 dark:text-blue-400"></i>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Tasks</h3>
                            </div>
                            <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $totalTasks ?? 0 }}</p>
                        </div>

                        <!-- Карточка: Задачи по статусам -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md fade-in">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-chart-pie mr-2 text-blue-600 dark:text-blue-400"></i>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tasks by Status</h3>
                            </div>
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-400">
                                    Available: <span class="font-bold text-green-600 dark:text-green-400">{{ $statusCounts['available'] ?? 0 }}</span>
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    In Progress: <span class="font-bold text-yellow-600 dark:text-yellow-400">{{ $statusCounts['in_progress'] ?? 0 }}</span>
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Completed: <span class="font-bold text-blue-600 dark:text-blue-400">{{ $statusCounts['completed'] ?? 0 }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Карточка: Задачи по сложности -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow-md fade-in">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-star mr-2 text-blue-600 dark:text-blue-400"></i>
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Tasks by Difficulty</h3>
                            </div>
                            <div class="space-y-2">
                                <p class="text-gray-600 dark:text-gray-400">
                                    Easy: <span class="font-bold text-green-600 dark:text-green-400">{{ $difficultyCounts['easy'] ?? 0 }}</span>
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Medium: <span class="font-bold text-orange-600 dark:text-orange-400">{{ $difficultyCounts['medium'] ?? 0 }}</span>
                                </p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Hard: <span class="font-bold text-red-600 dark:text-red-400">{{ $difficultyCounts['hard'] ?? 0 }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Кнопка создания задачи -->
                    <div class="mb-6 fade-in">
                        <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                            {{ __('Create New Task') }}
                        </a>
                    </div>

                    <!-- Форма фильтрации -->
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-6 flex space-x-4">
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

                    <!-- Таблица задач -->
                    @if($tasks->isEmpty())
                        <p class="fade-in">No tasks found.</p>
                    @else
                        <div class="table-container">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Difficulty</th>
                                        <th>Status</th>
                                        <th>User</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr class="fade-in">
                                            <td>{{ $loop->iteration }}</td>
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
                                            <td>{{ $task->user ? $task->user->email : 'Created by Admin' }}</td>
                                            <td class="flex space-x-2">
                                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-primary btn-sm">View</a>
                                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-success btn-sm">Edit</a>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
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
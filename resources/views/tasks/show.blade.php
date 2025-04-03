<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">{{ $task->title }}</h1>
                    <p><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</p>
                    <p><strong>Difficulty:</strong> {{ $task->difficulty }}</p>
                    <p><strong>Status:</strong> {{ $task->status }}</p>
                    <p><strong>Progress:</strong> {{ $task->progress }}%</p>
                    <p><strong>Deadline:</strong> {{ $task->deadline ? $task->deadline->format('Y-m-d H:i') : 'N/A' }}</p>
                    <p><strong>Tags:</strong> {{ $task->tags ? implode(', ', $task->tags) : 'N/A' }}</p>
                    <p><strong>Created by:</strong> {{ $task->user ? $task->user->email : 'User not found' }}</p>

                    <!-- Кнопки и поле для обычных пользователей -->
                    @if(auth()->check() && !auth()->user()->is_admin)
                        @php
                            $progress = $task->currentUserProgress;
                        @endphp
                        @if($progress)
                            <p><strong>Your Status:</strong> {{ $progress->status }}</p>
                            @if($progress->github_link)
                                <p><strong>GitHub Link:</strong> <a href="{{ $progress->github_link }}" class="text-blue-500 hover:underline">{{ $progress->github_link }}</a></p>
                            @endif
                        @endif

                        @if(!$progress || $progress->status == 'not_started')
                            <form action="{{ route('tasks.start', $task) }}" method="POST" class="mt-4">
                                @csrf
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Start</button>
                            </form>
                        @elseif($progress->status == 'in_progress')
                            <form action="{{ route('tasks.finish', $task) }}" method="POST" class="mt-4">
                                @csrf
                                <div class="mb-4">
                                    <label for="github_link" class="block text-gray-600 mb-1">GitHub Link</label>
                                    <input type="url" name="github_link" id="github_link" class="w-full p-2 border border-gray-300 rounded-lg" required>
                                    @error('github_link')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Finish</button>
                            </form>
                        @endif
                    @endif

                    <!-- Кнопки для админов -->
                    @if(auth()->user() && auth()->user()->is_admin)
                        <div class="mt-4">
                            <a href="{{ route('tasks.edit', $task) }}" class="text-green-500 hover:underline">Edit</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline ml-2" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6 fade-in">{{ $task->title }}</h1>

                    <div class="task-details fade-in">
                        <p class="mb-2"><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Requirements:</strong> {{ $task->requirements ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Required Knowledge:</strong> {{ $task->required_knowledge ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Resources:</strong> {{ $task->resources ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Solution:</strong> {{ $task->solution ?? 'N/A' }}</p>
                        <p class="mb-2"><strong>Difficulty:</strong> <span class="difficulty-{{ $task->difficulty }}">{{ $task->difficulty }}</span></p>
                        <p class="mb-2"><strong>Status:</strong> <span class="status-{{ $task->status }}">{{ $task->status }}</span></p>
                        <p class="mb-2"><strong>Deadline:</strong> {{ $task->deadline ? $task->deadline->format('Y-m-d H:i') : 'N/A' }}</p>
                        <p class="mb-2"><strong>Tags:</strong>
                            @if($task->tags)
                                @foreach($task->tags as $tag)
                                    <span class="tag">{{ $tag }}</span>
                                @endforeach
                            @else
                                N/A
                            @endif
                        </p>
                        <p class="mb-2"><strong>Created by:</strong> {{ $task->user ? $task->user->email : 'Created by Admin' }}</p>
                    </div>

                    @if(auth()->check() && !auth()->user()->is_admin)
                        @php
                            $progress = $task->currentUserProgress;
                        @endphp
                        @if($progress)
                            <p class="mb-2 fade-in"><strong>Your Status:</strong> <span class="status-{{ $progress->status }}">{{ $progress->status }}</span></p>
                            @if($progress->github_link)
                                <p class="mb-2 fade-in"><strong>GitHub Link:</strong> <a href="{{ $progress->github_link }}" class="text-blue-500 hover:underline">{{ $progress->github_link }}</a></p>
                            @endif
                        @endif

                        @if(!$progress || $progress->status == 'not_started')
                            <form action="{{ route('tasks.start', $task) }}" method="POST" class="mt-4 fade-in">
                                @csrf
                                <button type="submit" class="btn btn-success">Start Task</button>
                            </form>
                        @elseif($progress->status == 'in_progress')
                            <form action="{{ route('tasks.finish', $task) }}" method="POST" class="mt-4 fade-in">
                                @csrf
                                <div class="mb-4">
                                    <label for="github_link" class="form-label">GitHub Link</label>
                                    <input type="url" name="github_link" id="github_link" class="form-input" required>
                                    @error('github_link')
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Finish Task</button>
                            </form>
                        @endif
                    @endif

                    @if(auth()->user() && auth()->user()->is_admin)
                        <div class="mt-4 flex space-x-4 fade-in">
                            <a href="{{ route('tasks.edit', $task) }}" class="btn btn-success">Edit Task</a>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Task</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
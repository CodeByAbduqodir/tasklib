<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">{{ $task->title }}</h1>
                    <p class="mb-2"><strong>Description:</strong> {{ $task->description ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Requirements:</strong> {{ $task->requirements ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Required Knowledge:</strong> {{ $task->required_knowledge ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Resources:</strong> {{ $task->resources ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Solution:</strong> {{ $task->solution ?? 'N/A' }}</p>
                    <p class="mb-2"><strong>Difficulty:</strong> {{ $task->difficulty }}</p>
                    <p class="mb-2"><strong>Status:</strong> {{ $task->status }}</p>
                    <p class="mb-2"><strong>Progress:</strong>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-blue-500 h-4 rounded-full" style="width: {{ $task->progress }}%"></div>
                        </div>
                        <span>{{ $task->progress }}%</span>
                    </p>
                    <p class="mb-2"><strong>Deadline:</strong> {{ $task->deadline ? $task->deadline->format('Y-m-d H:i') : 'N/A' }}</p>
                    <p class="mb-2"><strong>Tags:</strong>
                        @if($task->tags)
                            @foreach($task->tags as $tag)
                                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-semibold mr-2 px-2.5 py-0.5 rounded">{{ $tag }}</span>
                            @endforeach
                        @else
                            N/A
                        @endif
                    </p>
                    <p class="mb-2"><strong>Created by:</strong> {{ $task->user ? $task->user->email : 'Created by Admin' }}</p>

                    @if(auth()->check() && !auth()->user()->is_admin)
                        @php
                            $progress = $task->currentUserProgress;
                        @endphp
                        @if($progress)
                            <p class="mb-2"><strong>Your Status:</strong> {{ $progress->status }}</p>
                            @if($progress->github_link)
                                <p class="mb-2"><strong>GitHub Link:</strong> <a href="{{ $progress->github_link }}" class="text-blue-500 hover:underline">{{ $progress->github_link }}</a></p>
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
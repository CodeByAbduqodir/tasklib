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
                    <p><strong>Created by:</strong> {{ $task->user->email }}</p>
                    @if(auth()->user()->is_admin)
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
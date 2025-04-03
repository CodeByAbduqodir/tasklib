<x-guest-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Available Tasks</h1>
                    @if($tasks->isEmpty())
                        <p>No tasks available.</p>
                    @else
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">Title</th>
                                    <th class="border border-gray-300 px-4 py-2">Difficulty</th>
                                    <th class="border border-gray-300 px-4 py-2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2">Progress</th>
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
</x-guest-layout>
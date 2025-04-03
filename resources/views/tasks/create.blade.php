<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Create New Task</h1>
                    <form method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-600 mb-1">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full p-2 border border-gray-300 rounded-lg" required>
                            @error('title')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-600 mb-1">Description</label>
                            <textarea name="description" id="description" class="w-full p-2 border border-gray-300 rounded-lg">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="difficulty" class="block text-gray-600 mb-1">Difficulty</label>
                            <select name="difficulty" id="difficulty" class="w-full p-2 border border-gray-300 rounded-lg" required>
                                <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                            @error('difficulty')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="status" class="block text-gray-600 mb-1">Status</label>
                            <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-lg" required>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="progress" class="block text-gray-600 mb-1">Progress (%)</label>
                            <input type="number" name="progress" id="progress" value="{{ old('progress') }}" class="w-full p-2 border border-gray-300 rounded-lg" min="0" max="100">
                            @error('progress')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="deadline" class="block text-gray-600 mb-1">Deadline</label>
                            <input type="datetime-local" name="deadline" id="deadline" value="{{ old('deadline') }}" class="w-full p-2 border border-gray-300 rounded-lg">
                            @error('deadline')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
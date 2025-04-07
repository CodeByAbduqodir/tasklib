<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Edit Task: {{ $task->title }}</h1>

                    <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}" class="form-input" required>
                            @error('title')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Description</label>
                            <textarea name="description" id="description" class="form-input">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="difficulty" class="form-label">Difficulty</label>
                            <select name="difficulty" id="difficulty" class="form-select" required>
                                <option value="easy" {{ old('difficulty', $task->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ old('difficulty', $task->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ old('difficulty', $task->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                            @error('difficulty')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="available" {{ old('status', $task->status) == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                            @error('status')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deadline" class="form-label">Deadline</label>
                            <input type="datetime-local" name="deadline" id="deadline" value="{{ old('deadline', $task->deadline) }}" class="form-input">
                            @error('deadline')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="requirements" class="form-label">Requirements</label>
                            <textarea name="requirements" id="requirements" class="form-input">{{ old('requirements', $task->requirements) }}</textarea>
                            @error('requirements')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="required_knowledge" class="form-label">Required Knowledge</label>
                            <textarea name="required_knowledge" id="required_knowledge" class="form-input">{{ old('required_knowledge', $task->required_knowledge) }}</textarea>
                            @error('required_knowledge')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="resources" class="form-label">Resources</label>
                            <textarea name="resources" id="resources" class="form-input">{{ old('resources', $task->resources) }}</textarea>
                            @error('resources')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="solution" class="form-label">Solution</label>
                            <textarea name="solution" id="solution" class="form-input">{{ old('solution', $task->solution) }}</textarea>
                            @error('solution')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tags" class="form-label">Tags (comma-separated)</label>
                            <input type="text" name="tags" id="tags" value="{{ old('tags', implode(', ', $task->tags)) }}" class="form-input" placeholder="e.g., Laravel, PHP, Beginner">
                            @error('tags')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Update Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
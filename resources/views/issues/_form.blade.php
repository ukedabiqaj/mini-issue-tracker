<div class="space-y-5">
    <div>
        <label for="project_id" class="mb-1 block text-sm font-medium text-slate-700">Project</label>
        <select name="project_id" id="project_id" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('project_id') border-red-500 @enderror">
            <option value="">Select a project</option>
            @foreach ($projects as $project)
                <option value="{{ $project->id }}"
                    @selected(old('project_id', $issue->project_id ?? request('project_id')) == $project->id)>
                    {{ $project->name }}
                </option>
            @endforeach
        </select>
        @error('project_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="title" class="mb-1 block text-sm font-medium text-slate-700">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $issue->title ?? '') }}" required
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('title') border-red-500 @enderror">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
        <textarea name="description" id="description" rows="4"
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $issue->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="status" class="mb-1 block text-sm font-medium text-slate-700">Status</label>
            <select name="status" id="status" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('status') border-red-500 @enderror">
                @foreach (['open', 'in_progress', 'closed'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $issue->status ?? 'open') === $status)>
                        {{ str_replace('_', ' ', ucfirst($status)) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="priority" class="mb-1 block text-sm font-medium text-slate-700">Priority</label>
            <select name="priority" id="priority" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('priority') border-red-500 @enderror">
                @foreach (['low', 'medium', 'high'] as $priority)
                    <option value="{{ $priority }}" @selected(old('priority', $issue->priority ?? 'medium') === $priority)>
                        {{ ucfirst($priority) }}
                    </option>
                @endforeach
            </select>
            @error('priority')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="due_date" class="mb-1 block text-sm font-medium text-slate-700">Due date</label>
        <input type="date" name="due_date" id="due_date"
               value="{{ old('due_date', isset($issue) && $issue->due_date ? $issue->due_date->format('Y-m-d') : '') }}"
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('due_date') border-red-500 @enderror">
        @error('due_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

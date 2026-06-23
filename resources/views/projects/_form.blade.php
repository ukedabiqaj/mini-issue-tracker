<div class="space-y-5">
    <div>
        <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name', $project->name ?? '') }}" required
               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-1 block text-sm font-medium text-slate-700">Description</label>
        <textarea name="description" id="description" rows="4"
                  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $project->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="start_date" class="mb-1 block text-sm font-medium text-slate-700">Start date</label>
            <input type="date" name="start_date" id="start_date"
                   value="{{ old('start_date', isset($project) && $project->start_date ? $project->start_date->format('Y-m-d') : '') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('start_date') border-red-500 @enderror">
            @error('start_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="deadline" class="mb-1 block text-sm font-medium text-slate-700">Deadline</label>
            <input type="date" name="deadline" id="deadline"
                   value="{{ old('deadline', isset($project) && $project->deadline ? $project->deadline->format('Y-m-d') : '') }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('deadline') border-red-500 @enderror">
            @error('deadline')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

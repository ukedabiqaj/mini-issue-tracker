<form method="GET" action="{{ route('issues.index') }}" class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div>
            <label for="filter-status" class="mb-1 block text-xs font-medium uppercase tracking-wide text-slate-500">Status</label>
            <select name="status" id="filter-status"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <option value="">All statuses</option>
                @foreach (['open', 'in_progress', 'closed'] as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ str_replace('_', ' ', ucfirst($status)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filter-priority" class="mb-1 block text-xs font-medium uppercase tracking-wide text-slate-500">Priority</label>
            <select name="priority" id="filter-priority"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <option value="">All priorities</option>
                @foreach (['low', 'medium', 'high'] as $priority)
                    <option value="{{ $priority }}" @selected(request('priority') === $priority)>
                        {{ ucfirst($priority) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filter-tag" class="mb-1 block text-xs font-medium uppercase tracking-wide text-slate-500">Tag</label>
            <select name="tag" id="filter-tag"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                <option value="">All tags</option>
                @foreach ($tags as $tag)
                    <option value="{{ $tag->id }}" @selected((string) request('tag') === (string) $tag->id)>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit"
                    class="flex-1 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Filter
            </button>
            <a href="{{ route('issues.index') }}"
               class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Reset
            </a>
        </div>
    </div>
</form>

<div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm"
     id="issue-search"
     data-search-url="{{ route('issues.search') }}"
     data-issues-url="{{ url('/issues') }}">
    <label for="issue-search-input" class="mb-1 block text-xs font-medium uppercase tracking-wide text-slate-500">Search issues</label>
    <input type="search" id="issue-search-input" placeholder="Search by title or description..."
           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
    <div id="issue-search-results" class="mt-3 hidden space-y-2"></div>
    <p id="issue-search-empty" class="mt-2 hidden text-sm text-slate-500">No issues found.</p>
</div>

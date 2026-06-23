@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <a href="{{ route('projects.index') }}" class="text-sm text-slate-600 hover:text-indigo-600">&larr; All projects</a>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $project->name }}</h1>
            @if ($project->description)
                <p class="mt-2 max-w-3xl text-slate-600">{{ $project->description }}</p>
            @endif
            @if ($project->start_date || $project->deadline)
                <p class="mt-2 text-sm text-slate-500">
                    {{ $project->start_date?->format('M j, Y') ?? 'No start' }}
                    &mdash;
                    {{ $project->deadline?->format('M j, Y') ?? 'No deadline' }}
                </p>
            @endif
        </div>
        <div class="flex shrink-0 gap-2">
            @can('update', $project)
                <a href="{{ route('projects.edit', $project) }}"
                   class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Edit
                </a>
            @endcan
            @can('delete', $project)
                <form action="{{ route('projects.destroy', $project) }}" method="POST"
                      onsubmit="return confirm('Delete this project and all its issues?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                        Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <div class="mb-4 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Issues ({{ $project->issues->count() }})</h2>
        <a href="{{ route('issues.create', ['project_id' => $project->id]) }}"
           class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
            New Issue
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tags</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Due</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($project->issues as $issue)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('issues.show', $issue) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                {{ $issue->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4">@include('partials._badge', ['type' => 'status', 'value' => $issue->status])</td>
                        <td class="px-6 py-4">@include('partials._badge', ['type' => 'priority', 'value' => $issue->priority])</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach ($issue->tags as $tag)
                                    <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-medium text-white"
                                          style="background-color: {{ $tag->displayColor() }}">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $issue->due_date?->format('M j, Y') ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-sm text-slate-500">No issues in this project yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

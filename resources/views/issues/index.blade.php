@extends('layouts.app')

@section('title', 'Issues')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Issues</h1>
            <p class="mt-1 text-sm text-slate-600">Filter by status, priority, or tag.</p>
        </div>
        <a href="{{ route('issues.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
            New Issue
        </a>
    </div>

    @include('issues._filters')

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Project</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Tags</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Due</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($issues as $issue)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('issues.show', $issue) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                {{ $issue->title }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <a href="{{ route('projects.show', $issue->project) }}" class="hover:text-indigo-600">
                                {{ $issue->project->name }}
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
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-500">No issues match your filters.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials._pagination', ['paginator' => $issues])
@endsection

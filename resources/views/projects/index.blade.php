@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Projects</h1>
            <p class="mt-1 text-sm text-slate-600">Manage your team projects and their issues.</p>
        </div>
        <a href="{{ route('projects.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700">
            New Project
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Issues</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Timeline</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse ($projects as $project)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <a href="{{ route('projects.show', $project) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                                {{ $project->name }}
                            </a>
                            @if ($project->description)
                                <p class="mt-1 line-clamp-1 text-sm text-slate-500">{{ $project->description }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $project->issues_count }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            @if ($project->start_date || $project->deadline)
                                {{ $project->start_date?->format('M j, Y') ?? '—' }}
                                →
                                {{ $project->deadline?->format('M j, Y') ?? '—' }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('projects.edit', $project) }}" class="text-slate-600 hover:text-indigo-600">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-slate-500">
                            No projects yet.
                            <a href="{{ route('projects.create') }}" class="font-medium text-indigo-600 hover:text-indigo-800">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials._pagination', ['paginator' => $projects])
@endsection

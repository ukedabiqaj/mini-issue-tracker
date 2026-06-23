@extends('layouts.app')

@section('title', $issue->title)

@section('content')
    <div class="mb-6 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
        <div>
            <a href="{{ route('issues.index') }}" class="text-sm text-slate-600 hover:text-indigo-600">&larr; All issues</a>
            <h1 class="mt-2 text-2xl font-bold text-slate-900">{{ $issue->title }}</h1>
            <p class="mt-2 text-sm text-slate-600">
                Project:
                <a href="{{ route('projects.show', $issue->project) }}" class="font-medium text-indigo-600 hover:text-indigo-800">
                    {{ $issue->project->name }}
                </a>
            </p>
            @if ($issue->description)
                <p class="mt-4 max-w-3xl whitespace-pre-wrap text-slate-700">{{ $issue->description }}</p>
            @endif
            <div class="mt-4 flex flex-wrap items-center gap-2">
                @include('partials._badge', ['type' => 'status', 'value' => $issue->status])
                @include('partials._badge', ['type' => 'priority', 'value' => $issue->priority])
                @if ($issue->due_date)
                    <span class="text-sm text-slate-500">Due {{ $issue->due_date->format('M j, Y') }}</span>
                @endif
            </div>
        </div>
        <div class="flex shrink-0 gap-2">
            <a href="{{ route('issues.edit', $issue) }}"
               class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                Edit
            </a>
            <form action="{{ route('issues.destroy', $issue) }}" method="POST"
                  onsubmit="return confirm('Delete this issue?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <div class="grid gap-8 lg:grid-cols-3">
        <div class="lg:col-span-1">
            @include('issues.partials._tag_modal')
        </div>
        <div class="lg:col-span-2">
            @include('issues.partials._comment_section')
        </div>
    </div>
@endsection

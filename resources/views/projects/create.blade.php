@extends('layouts.app')

@section('title', 'New Project')

@section('content')
    <div class="mb-6">
        <a href="{{ route('projects.index') }}" class="text-sm text-slate-600 hover:text-indigo-600">&larr; Back to projects</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">New Project</h1>
    </div>

    <div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @include('partials._errors')

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            @include('projects._form')

            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Create Project
                </button>
                <a href="{{ route('projects.index') }}"
                   class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

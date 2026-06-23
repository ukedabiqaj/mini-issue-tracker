@extends('layouts.app')

@section('title', 'New Issue')

@section('content')
    <div class="mb-6">
        <a href="{{ route('issues.index') }}" class="text-sm text-slate-600 hover:text-indigo-600">&larr; Back to issues</a>
        <h1 class="mt-2 text-2xl font-bold text-slate-900">New Issue</h1>
    </div>

    <div class="max-w-2xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        @include('partials._errors')

        <form action="{{ route('issues.store') }}" method="POST">
            @csrf
            @include('issues._form')

            <div class="mt-6 flex gap-3">
                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Create Issue
                </button>
                <a href="{{ route('issues.index') }}"
                   class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Tags')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Tags</h1>
        <p class="mt-1 text-sm text-slate-600">Create tags and attach them to issues.</p>
    </div>

    <div class="mb-8 max-w-xl rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold text-slate-900">Create Tag</h2>
        @include('partials._errors')

        <form action="{{ route('tags.store') }}" method="POST" class="space-y-4">
            @csrf
            @include('tags._form')
            <button type="submit"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                Create Tag
            </button>
        </form>
    </div>

    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Color</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Issues</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($tags as $tag)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 font-medium text-slate-900">{{ $tag->name }}</td>
                        <td class="px-6 py-4">
                            @if ($tag->color)
                                <span class="inline-flex items-center gap-2 text-sm text-slate-600">
                                    <span class="h-4 w-4 rounded-full border border-slate-200" style="background-color: {{ $tag->displayColor() }}"></span>
                                    {{ $tag->color }}
                                </span>
                            @else
                                <span class="text-sm text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $tag->issues_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-sm text-slate-500">No tags yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials._pagination', ['paginator' => $tags])
@endsection

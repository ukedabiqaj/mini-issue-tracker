@if ($paginator->hasPages())
    <nav class="mt-6 flex items-center justify-between border-t border-slate-200 pt-4">
        <p class="text-sm text-slate-600">
            Showing
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-medium">{{ $paginator->total() }}</span>
            results
        </p>
        <div class="flex gap-1">
            @if ($paginator->onFirstPage())
                <span class="rounded-md border border-slate-200 px-3 py-1.5 text-sm text-slate-400">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">Previous</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50">Next</a>
            @else
                <span class="rounded-md border border-slate-200 px-3 py-1.5 text-sm text-slate-400">Next</span>
            @endif
        </div>
    </nav>
@endif

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3">
        <p class="mb-2 text-sm font-medium text-red-800">Please fix the following errors:</p>
        <ul class="list-inside list-disc space-y-1 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}" required
           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
    @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

<div>
    <label for="color" class="mb-1 block text-sm font-medium text-slate-700">Color (hex)</label>
    <input type="text" name="color" id="color" value="{{ old('color') }}" placeholder="#3b82f6"
           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('color') border-red-500 @enderror">
    @error('color')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>

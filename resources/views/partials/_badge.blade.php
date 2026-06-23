@php
    $classes = match ($type ?? '') {
        'status' => match ($value) {
            'open' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-amber-100 text-amber-800',
            'closed' => 'bg-green-100 text-green-800',
            default => 'bg-slate-100 text-slate-700',
        },
        'priority' => match ($value) {
            'low' => 'bg-slate-100 text-slate-700',
            'medium' => 'bg-amber-100 text-amber-800',
            'high' => 'bg-red-100 text-red-800',
            default => 'bg-slate-100 text-slate-700',
        },
        default => 'bg-slate-100 text-slate-700',
    };

    $label = match ($type ?? '') {
        'status' => str_replace('_', ' ', ucfirst($value)),
        'priority' => ucfirst($value),
        default => $value,
    };
@endphp

<span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium {{ $classes }}">
    {{ $label }}
</span>

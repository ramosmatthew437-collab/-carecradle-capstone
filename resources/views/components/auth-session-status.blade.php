@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'flex items-start gap-2.5 rounded-xl bg-emerald-50 border border-emerald-100 px-4 py-3 text-[13px] sm:text-sm font-medium text-emerald-700']) }} role="status">
        <svg class="h-4.5 w-4.5 flex-shrink-0 mt-0.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <circle cx="12" cy="12" r="9"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75l1.72 1.72a.75.75 0 001.06 0l4.72-4.72"/>
        </svg>
        <span>{{ $status }}</span>
    </div>
@endif
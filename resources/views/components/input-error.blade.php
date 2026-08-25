@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge([
        'class' => 'mt-1.5 space-y-1'
    ]) }}>
        @foreach ((array) $messages as $message)
            <li class="flex items-start gap-1.5 text-[12px] sm:text-[13px] font-medium text-rose-600">
                <svg class="h-3.5 w-3.5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01"/>
                </svg>
                <span>{{ $message }}</span>
            </li>
        @endforeach
    </ul>
@endif
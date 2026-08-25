@props(['size' => 'default'])

@php
$sizes = [
    'sm' => [
        'wrap' => 'h-7 w-7 rounded-lg',
        'icon' => 'h-4 w-4',
        'text' => 'text-lg',
    ],
    'default' => [
        'wrap' => 'h-9 w-9 rounded-xl',
        'icon' => 'h-5 w-5',
        'text' => 'text-2xl',
    ],
    'lg' => [
        'wrap' => 'h-12 w-12 rounded-2xl',
        'icon' => 'h-7 w-7',
        'text' => 'text-3xl sm:text-4xl',
    ],
];

$current = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="flex items-center gap-2.5">
    <div class="flex {{ $current['wrap'] }} items-center justify-center bg-gradient-to-br from-pink-500 to-pink-600 text-white shadow-sm shadow-pink-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="{{ $current['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.75a3.75 3.75 0 00-3.75 3.75v3.75A5.25 5.25 0 0012 21a5.25 5.25 0 003.75-9.75V7.5A3.75 3.75 0 0012 3.75Z"/>
        </svg>
    </div>
    <span class="{{ $current['text'] }} font-bold tracking-tight text-slate-900">
        Care<span class="text-pink-600">Cradle</span>
    </span>
</div>
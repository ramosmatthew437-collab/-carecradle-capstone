@props(['size' => 'default'])

@php
$sizes = [
    'sm' => [
        'wrap' => 'h-10 w-10',
        'text' => 'text-lg',
    ],
    'default' => [
        'wrap' => 'h-12 w-12',
        'text' => 'text-2xl',
    ],
    'lg' => [
        'wrap' => 'h-16 w-16',
        'text' => 'text-3xl sm:text-4xl',
    ],
];

$current = $sizes[$size] ?? $sizes['default'];
@endphp

<div class="flex items-center gap-2.5">
    <img src="{{ asset('images/carecradle-logo.png') }}"
         alt="CareCradle Logo"
         class="{{ $current['wrap'] }} shrink-0 object-contain">

    <span class="{{ $current['text'] }} font-bold tracking-tight text-slate-900 whitespace-nowrap">
        Care<span class="text-pink-600">Cradle</span>
    </span>
</div>

@props(['size' => 'default'])

@php
    $sizes = [
        'sm' => [
            'wrap' => 'h-10 w-10',
            'text' => 'text-lg',
            'gap' => 'gap-2',
        ],
        'default' => [
            'wrap' => 'h-12 w-12',
            'text' => 'text-2xl',
            'gap' => 'gap-2.5',
        ],
        'lg' => [
            'wrap' => 'h-16 w-16',
            'text' => 'text-3xl sm:text-4xl',
            'gap' => 'gap-3',
        ],
    ];

    $current = $sizes[$size] ?? $sizes['default'];
@endphp

<div {{ $attributes->merge(['class' => "inline-flex items-center {$current['gap']} min-w-0"]) }}>
    <img
        src="{{ asset('images/system.logo.png') }}"
        alt="CareCradle Logo"
        class="{{ $current['wrap'] }} shrink-0 object-contain"
        decoding="async"
    >

    <span class="{{ $current['text'] }} whitespace-nowrap font-bold tracking-tight text-slate-900">
        Care<span class="text-pink-600">Cradle</span>
    </span>
</div>
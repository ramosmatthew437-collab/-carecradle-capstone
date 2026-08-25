@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-pink-500 text-[13px] sm:text-sm font-semibold leading-5 text-slate-900 focus:outline-none focus:border-pink-600 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-[13px] sm:text-sm font-medium leading-5 text-slate-500 hover:text-slate-700 hover:border-slate-300 focus:outline-none focus:text-slate-700 focus:border-slate-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} aria-current="{{ ($active ?? false) ? 'page' : 'false' }}">
    {{ $slot }}
</a>
@props([
    'title',
    'description',
    'route' => '#',
    'color' => 'pink',
])

@php
$themes = [

    'pink' => [
        'icon' => 'bg-pink-100 text-pink-600',
        'hover' => 'hover:border-pink-200',
        'shadow' => 'hover:shadow-pink-100',
    ],

    'blue' => [
        'icon' => 'bg-blue-100 text-blue-600',
        'hover' => 'hover:border-blue-200',
        'shadow' => 'hover:shadow-blue-100',
    ],

    'green' => [
        'icon' => 'bg-green-100 text-green-600',
        'hover' => 'hover:border-green-200',
        'shadow' => 'hover:shadow-green-100',
    ],

    'yellow' => [
        'icon' => 'bg-yellow-100 text-yellow-600',
        'hover' => 'hover:border-yellow-200',
        'shadow' => 'hover:shadow-yellow-100',
    ],

    'purple' => [
        'icon' => 'bg-purple-100 text-purple-600',
        'hover' => 'hover:border-purple-200',
        'shadow' => 'hover:shadow-purple-100',
    ],

    'red' => [
        'icon' => 'bg-red-100 text-red-600',
        'hover' => 'hover:border-red-200',
        'shadow' => 'hover:shadow-red-100',
    ],

];

$current = $themes[$color] ?? $themes['pink'];
@endphp

<a href="{{ $route }}"
   class="group rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg {{ $current['hover'] }} {{ $current['shadow'] }}">

    <div class="flex items-start justify-between">

        <div class="flex h-14 w-14 items-center justify-center rounded-2xl {{ $current['icon'] }}">

            {{ $slot }}

        </div>

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 text-slate-400 transition duration-300 ease-in-out group-hover:translate-x-1 group-hover:text-pink-500"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 5l7 7-7 7"/>

        </svg>

    </div>

    <h3 class="mt-6 text-[16px] sm:text-lg font-bold text-slate-900">
        {{ $title }}
    </h3>

    <p class="mt-2 text-[13px] sm:text-sm leading-6 text-slate-500">
        {{ $description }}
    </p>

</a>
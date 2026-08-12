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
    ],

    'blue' => [
        'icon' => 'bg-blue-100 text-blue-600',
        'hover' => 'hover:border-blue-200',
    ],

    'green' => [
        'icon' => 'bg-green-100 text-green-600',
        'hover' => 'hover:border-green-200',
    ],

    'yellow' => [
        'icon' => 'bg-yellow-100 text-yellow-600',
        'hover' => 'hover:border-yellow-200',
    ],

    'purple' => [
        'icon' => 'bg-purple-100 text-purple-600',
        'hover' => 'hover:border-purple-200',
    ],

    'red' => [
        'icon' => 'bg-red-100 text-red-600',
        'hover' => 'hover:border-red-200',
    ],

];

$current = $themes[$color] ?? $themes['pink'];
@endphp

<a href="{{ $route }}"
   class="group rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-lg {{ $current['hover'] }}">

    <div class="flex items-start justify-between">

        <div class="flex h-14 w-14 items-center justify-center rounded-2xl {{ $current['icon'] }}">

            {{ $slot }}

        </div>

        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 text-gray-400 transition duration-300 group-hover:translate-x-1"
             fill="none"
             viewBox="0 0 24 24"
             stroke="currentColor"
             stroke-width="2">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M9 5l7 7-7 7"/>

        </svg>

    </div>

    <h3 class="mt-6 text-lg font-bold text-gray-900">
        {{ $title }}
    </h3>

    <p class="mt-2 text-sm leading-6 text-gray-500">
        {{ $description }}
    </p>

</a>
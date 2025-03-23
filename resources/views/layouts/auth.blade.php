@props([
    'title' => '',
    'description' => null,
    'color' => 'primary',
    'headerClass' => null,
    'headerAtts' => [],
])
@php
    $colors = [
        'primary' => 'text-primary',
        'secondary' => 'text-secondary',
        'red' => 'text-red',
        'blue' => 'text-blue',
        'green' => 'text-green',
        'yellow' => 'text-yellow',
        'pink' => 'text-pink',
        'purple' => 'text-purple',
        'indigo' => 'text-indigo',
        'gray' => 'text-gray',
        'orange' => 'text-orange',
        'teal' => 'text-teal',
        'cyan' => 'text-cyan',
        'lime' => 'text-lime',
        'amber' => 'text-amber',
        'emerald' => 'text-emerald',
        'fuchsia' => 'text-fuchsia',
        'rose' => 'text-rose',
        'sky' => 'text-sky',
        'slate' => 'text-slate',
        'zinc' => 'text-zinc',
        'neutral' => 'text-neutral',
        'ayoue' => 'text-stone',
    ];
    $coverColor = data_get($colors, $color, 'text-primary');
@endphp
<x-curve-layout :title="$title" :showTitle="false" :showDescription="false">
    <div class="bg-white/80 dark:bg-gray-700/80 w-80 md:w-96 mx-auto p-4 z-20 rounded-3xl shadow mb-5 -mt-40">
        <div class="text-center">
            <h5
                class="text-3xl font-semibold text-gradient from-primary to-pink dark:from-white dark:to-pink text-center">
                {{ $title }}</h5>
        </div>
        {{ $slot }}
    </div>
</x-curve-layout>

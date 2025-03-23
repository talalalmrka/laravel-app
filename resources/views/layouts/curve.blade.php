@props([
    'title' => '',
    'showTitle' => true,
    'subtitle' => null,
    'showSubtitle' => true,
    'description' => null,
    'color' => 'primary',
    'headerClass' => null,
    'headerAtts' => [],
])
@php
    $hasTitle = !empty($title) && $showTitle;
    $hasSubtitle = !empty($subtitle) && $showSubtitle;
    $hasAnyTitle = $hasTitle || $hasSubtitle;
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
        'stone' => 'text-stone',
    ];
    $coverColor = data_get($colors, $color, 'text-primary');

    $navbarColors = [
        'primary' => 'navbar-transparent-primary',
        'secondary' => 'navbar-transparent-secondary',
        'red' => 'navbar-transparent-red',
        'blue' => 'navbar-transparent-blue',
        'green' => 'navbar-transparent-green',
        'yellow' => 'navbar-transparent-yellow',
        'pink' => 'navbar-transparent-pink',
        'purple' => 'navbar-transparent-purple',
        'indigo' => 'navbar-transparent-indigo',
        'gray' => 'navbar-transparent-gray',
        'orange' => 'navbar-transparent-orange',
        'teal' => 'navbar-transparent-teal',
        'cyan' => 'navbar-transparent-cyan',
        'lime' => 'navbar-transparent-lime',
        'amber' => 'navbar-transparent-amber',
        'emerald' => 'navbar-transparent-emerald',
        'fuchsia' => 'navbar-transparent-fuchsia',
        'rose' => 'navbar-transparent-rose',
        'sky' => 'navbar-transparent-sky',
        'slate' => 'navbar-transparent-slate',
        'zinc' => 'navbar-transparent-zinc',
        'neutral' => 'navbar-transparent-neutral',
        'stone' => 'navbar-transparent-stone',
    ];
    $navbarColor = data_get($navbarColors, $color, 'navbar-transparent-primary');
@endphp
<x-app-layout :title="$title">
    @include('partials.header', [
        'class' => css_classes(['fixed top-0 start-0 end-0 z-40', $navbarColor => $navbarColor]),
    ])
    <main>
        <div class="relative h-80 {{ $coverColor }}">
            <svg id="svg" viewBox="0 0 1440 690" xmlns="http://www.w3.org/2000/svg"
                class="absolute inset-0 object-cover w-full -z-20 transition duration-300 ease-in-out delay-150">
                <path
                    d="M 0,700 L 0,262 C 172,262 344,262 518,290 C 692,318 868,374 1022,374 C 1176,374 1308,318 1440,262 L 1440,700 L 0,700 Z"
                    stroke="none" stroke-width="0" fill="currentColor" fill-opacity="1"
                    class="transition-all duration-300 ease-in-out delay-150 path-0" transform="rotate(-180 720 350)">
                </path>
            </svg>
            @if ($hasAnyTitle)
                <div class="absolute z-30 flex items-center inset-0 text-white">
                    <div class="container mx-auto px-4">
                        <div class="text-center">
                            @if ($showTitle)
                                <h1 class="text-4xl font-bold">{{ $title }}</h1>
                            @endif
                            @if ($showSubtitle)
                                <h2 class="text-xl">{{ $subtitle }}</h2>
                            @endif
                            <p class="text-lg">{{ $description }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="mt-[60px]">
            {{ $slot }}
        </div>
    </main>
    @include('partials.footer')
</x-app-layout>

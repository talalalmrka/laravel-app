@props([
    'title' => '',
    'showTitle' => true,
    'subtitle' => null,
    'showSubtitle' => true,
    'secondSubtitle' => null,
    'showSecondSubtitle' => true,
    'description' => null,
    'color' => 'primary',
    'image' => null,
    'headerClass' => null,
    'headerAtts' => [],
])
@php
$hasTitle = !empty($title) && $showTitle;
$hasSubtitle = !empty($subtitle) && $showSubtitle;
$hasSecondSubtitle = !empty($secondSubtitle) && $showSecondSubtitle;
$hasAnyTitle = $hasTitle || $hasSubtitle || $hasSecondSubtitle;
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
    <div class="min-h-screen">
        @include('partials.header', [
        'class' => css_classes(['fixed top-0 start-0 end-0 z-40', $navbarColor => $navbarColor]),
    ])
        <div class="h-96 relative overflow-hidden">
            <div class="absolute inset-0 {{ $coverColor }}/50 bg-gradient z-1"></div>
            @if ($image)
                <img class="absolute inset-0 w-full h-full object-cover opacity-90 z-2" src="{{ $image }}"></img>
            @endif
            <div class="absolute inset-0 z-3 flex items-center justify-center bg-black/50 text-white">
                <div class="text-center">
                    @if ($hasTitle)
                        <h1 class="text-3xl">{!! $title !!}</h1>
                    @endif
                    @if ($hasSubtitle)
                        <div class="text-lg">{!! $subtitle !!}</div>
                    @endif
                    @if ($hasSecondSubtitle)
                        <div class="text-sm">{!! $secondSubtitle !!}</div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
        @include('partials.footer')
    </div>
</x-app-layout>

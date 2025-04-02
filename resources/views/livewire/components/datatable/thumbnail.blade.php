@props([
    'image' => null,
    'title' => null,
    'subtitle' => null,
    'class' => null,
    'atts' => [],
])
<div {{ attributes($atts)->merge([
    'class' => css_classes(['flex-space-2', $class => $class]),
]) }}>
    @if ($image)
        <img class="w-6 h-6 rounded-full" src="{{ $image }}" alt="{{ $title ?? '' }}">
    @endif
    <div>
        @if ($title)
            <div class="break-words font-semibold text-gray-900 dark:text-white">
                {{ $title }}
            </div>
        @endif
        @if ($subtitle)
            <div class="text-xs font-normal text-gray-500 dark:text-gray-400">
                {{ $subtitle }}
            </div>
        @endif

    </div>
</div>

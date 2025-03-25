@props([
    'id' => uniqid('nav-link-'),
    'icon' => null,
    'label' => '',
    'href' => '#',
    'active' => false,
    'class' => null,
    'atts' => [],
])

<a
    {{ $attributes->merge(
        array_merge(
            [
                'id' => $id,
                'href' => $href,
                'class' => css_classes(['nav-link', 'active' => $active || request()->is($href)]),
            ],
            $atts,
        ),
    ) }}>
    @icon($icon)
    <span>{{ $label }}</span>
</a>

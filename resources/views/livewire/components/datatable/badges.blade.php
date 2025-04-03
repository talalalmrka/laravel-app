@props([
    'items' => [],
    'icon' => null,
    'color' => 'emerald',
    'outline' => true,
    'size' => 'sm',
])
@if ($items && !empty($items))
    <div class="inline-flex flex-wrap gap-2">
        @foreach ($items as $item)
            @component('livewire.components.datatable.badge', [
                'label' => $item,
                'icon' => $icon,
                'color' => $color,
                'outline' => $outline,
                'size' => $size,
            ])
            @endcomponent
        @endforeach
    </div>
@endif

@props([
    'id' => uniqid('input-'),
    'type' => 'tel',
    'name' => null,
    'icon' => null,
    'label' => null,
    'value' => null,
    'placeholder' => null,
    'autofocus' => false,
    'autocomplete' => null,
    'required' => false,
    'error' => null,
    'disabled' => false,
    'atts' => [],
    'startIcon' => null,
    'endIcon' => null,
    'startView' => null,
    'endView' => null,
    'info' => null,
    'container_class' => null,
    'container_atts' => [],
])
@php
    $model = $model ?? ($attributes->get('wire:model.live') ?? ($attributes->get('wire:model') ?? $id));
    $inputId = uniqid('tel-');
@endphp
<x-fgx::label :for="$id" :icon="$icon" :required="$required" :label="$label" />
<input data-picker {!! $attributes->merge(
    array_merge($atts, [
        'id' => $inputId,
        'type' => 'text',
        'value' => $value,
        'placeholder' => $placeholder,
        'autofocus' => $autofocus ? '' : null,
        'autocomplete' => $autocomplete,
        'required' => $required ? '' : null,
        'disabled' => $disabled ? '' : null,
        'aria-describedby' => $info ? "$id-help" : null,
        'class' => css_classes(['form-control', 'error' => $errors->has($id)]),
    ]),
) !!}>
<x-fgx::info :id="$id" :info="$info" />
<x-fgx::error :id="$id" />
@assets
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endassets

@script
    <script>
        new Pikaday({
            field: $wire.$el.querySelector('[data-picker]')
        });
    </script>
@endscript

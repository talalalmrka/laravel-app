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
<div x-data="telInput({ model: @js($model), error: @js($errors->has($id)) })">
    <div
        {{ attributes(
            array_merge(
                [
                    'class' => css_classes(['form-control-container', $container_class => $container_class]),
                ],
                $container_atts,
            ),
        ) }}>
        @if ($startIcon || $startView)
            <span class="start-icon">
                @if (!empty($startView))
                    {!! $startView !!}
                @endif
                @icon($startIcon)
            </span>
        @endif

        <input wire:replace {!! $attributes->merge(
            array_merge($atts, [
                'id' => $id,
                'x-bind' => 'input',
                'x-ref' => 'input',
                'type' => $type,
                'value' => $value,
                'placeholder' => $placeholder,
                'autofocus' => $autofocus ? '' : null,
                'autocomplete' => $autocomplete,
                'required' => $required ? '' : null,
                'disabled' => $disabled ? '' : null,
                'aria-describedby' => $info ? "$id-help" : null,
                'class' => css_classes([
                    'form-control',
                    'error' => $errors->has($id),
                    'has-start-icon' => !empty($startIcon) || !empty($startView),
                    'has-end-icon' => !empty($endIcon) || !empty($endView),
                    'password-toggle-inited' => $type === 'password',
                ]),
            ]),
        ) !!}>

        @if ($endIcon || $endView || $type == 'password')
            <span class="end-icon">
                @icon($endIcon)
                @if (!empty($endView))
                    {!! $endView !!}
                @endif
            </span>
        @endif
    </div>
    <input type="hidden" x-bind="hiddenInput" class="form-control" placeholder="hidden input" x-ref="hiddenInput">
</div>
<x-fgx::info :id="$id" :info="$info" />
<x-fgx::error :id="$id" />
@assets
    <script src="{{ asset('assets/lib/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/lib/intl-tel-input/build/css/intlTelInput.min.css') }}">
@endassets
@script
    <script>
        Alpine.data('telInput', (config) => ({
            listeners: [],
            fullNumber: null,
            input: {
                [':class']() {
                    return {
                        'error': config.error
                    };
                }
            },
            hiddenInput: {},
            initModel() {
                const modelLive = this.$refs.input.getAttribute('wire:model.live');
                const hasModelLive = typeof modelLive !== 'undefined';
                if (hasModelLive) {
                    this.$refs.input.removeAttribute('wire:model.live');
                    this.$refs.hiddenInput.setAttribute('wire:model.live', modelLive);
                } else {
                    const model = this.$refs.input.getAttribute('wire:model');
                    const hasModel = typeof model !== 'undefined';
                    if (hasModel) {
                        this.$refs.input.removeAttribute('wire:model');
                        if (!hasModelLive) {
                            this.$refs.hiddenInput.setAttribute('wire:model', modelLive);
                        }
                    }
                }
            },
            geoIpLookup: (success, failure) => {
                const country_code = localStorage.getItem('country_code', false);
                if (country_code) {
                    success(country_code);
                } else {
                    fetch("https://ipapi.co/json")
                        .then((res) => res.json())
                        .then((data) => {
                            localStorage.setItem('country_code', data.country_code);
                            success(data.country_code)
                        })
                        .catch(() => failure());
                }
            },
            updateNumber(iti) {
                if (iti) {
                    this.fullNumber = iti.getNumber();
                    $wire.{{ $model }} = this.fullNumber;
                }

            },
            initListeners(iti) {
                this.listeners.push(
                    this.$refs.input.addEventListener('input', () => this.updateNumber(iti)),
                    this.$refs.input.addEventListener('countryChange', () => this.updateNumber(iti)),
                );
            },
            init() {
                this.initModel();
                const iti = intlTelInput(this.$refs.input, {
                    loadUtils: () => import(
                        "{{ asset('assets/lib/intl-tel-input/build/js/utils.js') }}"),
                    initialCountry: "auto",
                    geoIpLookup: this.geoIpLookup,
                    nationalMode: true,
                    strictMode: true,
                    separateDialCode: false,
                });
                this.initListeners(iti);
            },
            destroy() {
                this.listeners.forEach((listener) => {
                    listener();
                });
            }
        }));
    </script>
@endscript

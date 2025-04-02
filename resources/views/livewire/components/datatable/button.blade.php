@props(['button'])
@if ($button->href)
    <a {{ $button->attributes->class('btn') }}>
        @if ($button->icon)
            <i {{ $button->labelAttributes->class('icon m-0 p-0')->class($button->icon) }}></i>
        @endif
        @if (!empty($button->getLabel()))
            <span {{ $button->labelAttributes }}>
                {!! $button->getLabel() !!}
            </span>
        @endif
        @if ($button->loading)
            <fgx:loader wire:loading wire:target="{{ $button->click }}" />
        @endif
    </a>
@else
    <button {{ $button->attributes->class('btn border-0') }}>
        @if ($button->icon)
            <i {{ $button->labelAttributes->class('icon m-0 p-0')->class($button->icon) }}></i>
        @endif
        @if (!empty($button->getLabel()))
            <span {{ $button->labelAttributes }}>
                {!! $button->getLabel() !!}
            </span>
        @endif
        @if ($button->loading)
            <fgx:loader wire:loading wire:target="{{ $button->click }}" />
        @endif
    </button>
@endif

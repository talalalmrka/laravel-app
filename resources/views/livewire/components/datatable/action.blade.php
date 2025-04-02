@props(['action'])
@if ($action->href)
    <a {{ $action->attributes }}>
        @if ($action->icon)
            <i {{ $action->labelAttributes->class('icon m-0 p-0')->class($action->icon) }}></i>
        @endif
        @if (!empty($action->getLabel()))
            <span {{ $action->labelAttributes }}>
                {!! $action->getLabel() !!}
            </span>
        @endif
        @if ($action->loading)
            <fgx:loader wire:loading wire:target="{{ $action->click }}" />
        @endif
    </a>
@else
    <button {{ $action->attributes }}>
        @if ($action->icon)
            <i {{ $action->labelAttributes->class('icon m-0 p-0')->class($action->icon) }}></i>
        @endif
        @if (!empty($action->getLabel()))
            <span {{ $action->labelAttributes }}>
                {!! $action->getLabel() !!}
            </span>
        @endif
        @if ($action->loading)
            <fgx:loader wire:loading wire:target="{{ $action->click }}" />
        @endif
    </button>
@endif

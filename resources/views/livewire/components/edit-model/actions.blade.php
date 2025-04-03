@props(['model'])
<x-slot name="actions">
    @if (route_has("dashboard.{$model->getTable()}"))
        <a wire:navigate href="{{ route("dashboard.{$model->getTable()}") }}" class="btn btn-blue btn-xs pill w-20">
            <i class="icon bi-list-ul"></i>
            <span>{{ __('All') }}</span>
        </a>
    @endif

    @if (method_exists($this, 'saved') && $this->saved() && route_has("dashboard.{$model->getTable()}.create"))
        <a wire:navigate href="{{ route("dashboard.{$model->getTable()}.create") }}"
            class="btn btn-emerald btn-xs pill w-20">
            <i class="icon fg-plus"></i>
            <span>{{ __('Create') }}</span>
        </a>
    @endif
</x-slot>

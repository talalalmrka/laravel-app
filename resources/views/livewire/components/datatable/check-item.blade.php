@props(['item'])
<fgx:checkbox wire:model.live="selected" value="{{ $item->id }}" />

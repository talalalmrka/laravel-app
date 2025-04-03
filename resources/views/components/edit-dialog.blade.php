@props([
    'model' => null,
    'title' => '',
])
<div x-data="{
    closeModal() {
        $wire.$toggle('show');
    }
}">
    @teleport('body')
        <div wire:show="show" x-transition.duration.500ms class="modal fade show">
            <form wire:submit="save">
                <div class="modal-dialog">
                    @if ($model)
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $title }}</h5>
                                <button type="button" class="btn-close" x-on:click="closeModal">
                                    <i class="icon bi-x-lg"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ $slot }}
                            </div>
                            <div class="modal-footer flex-space-2 justify-between">
                                <div class="grow flex-space-2">
                                    <fgx:switch id="closeAfterSave" wire:model.live="closeAfterSave"
                                        :label="__('Close after save')" />
                                    <fgx:status class="alert-soft xs bg-transparent border-0 grow" />
                                </div>
                                <div class="flex-space-2">
                                    <button type="button" class="btn btn-secondary sm"
                                        x-on:click="closeModal">{{ __('Close') }}</button>
                                    <button type="submit" class="btn btn-primary sm">
                                        <i class="icon bi-floppy"></i>
                                        <span wire:loading.remove wire:target="save">{{ __('Save') }}</span>
                                        <fgx:loader wire:loading wire:target="save" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div><!-- Modal Dialog -->
            </form>
        </div><!-- Modal -->
    @endteleport
    @teleport('body')
        <div class="modal-backdrop show" wire:show="show" x-on:click="closeModal"></div>
    @endteleport
</div>

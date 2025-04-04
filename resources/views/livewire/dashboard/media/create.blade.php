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
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Upload files') }}</h5>
                            <button type="button" class="btn-close" x-on:click="closeModal">
                                <i class="icon bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="col">
                                    <fgx:file id="files" wire:model.live="files" :label="__('files')" multiple
                                        :previews="$filesPreviews" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- Modal Dialog -->
            </form>
        </div><!-- Modal -->
    @endteleport
    @teleport('body')
        <div class="modal-backdrop show" wire:show="show" x-on:click="closeModal"></div>
    @endteleport
</div>

<form wire:submit="save">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-primary">{{ __('Images') }}</h5>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <x-file id="avatar" model="avatar" :label="__('Avatar')" accept="image/*" :previews="$avatarPreviews"
                        wire:key="avatar" />
                </div>
                <div class="col">
                    <x-file id="images" model="images" :label="__('Images')" accept="image/*" multiple :previews="$imagesPreviews"
                        wire:key="images" />
                </div>
                <div class="col">
                    <x-file id="files" model="files" :label="__('Files')" accept="image/*" multiple
                        wire:key="files" />
                </div>
            </div>
        </div>
        <div class="card-footer flex-space-1 justify-between">
            <button type="submit" class="btn btn-primary pill sm">
                <span wire:loading.remove wire:target="save">{{ __('save') }}</span>
                <fgx:loader wire:loading wire:target="save" />
            </button>
            <fgx:status class="alert-soft sm" />
        </div>
    </div>
</form>

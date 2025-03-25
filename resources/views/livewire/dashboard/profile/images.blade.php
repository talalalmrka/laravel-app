<form wire:submit="save">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-primary">{{ __('Images') }}</h5>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <fgx:label for="images" :label="__('Images')" />
                    <x-file id="images" model="images" multiple accept="image/*" :previews="$images_previews" />
                    <fgx:error id="images" />
                    @dump($images_previews)
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

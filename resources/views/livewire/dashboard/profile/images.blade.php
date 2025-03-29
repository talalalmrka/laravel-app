<form wire:submit="save">
    <fgx:card>
        <fgx:card-header class="text-primary" icon="bi-image-fill" :title="__('Images')" />
        <fgx:card-body>
            <div class="grid grid-cols-1 gap-4">
                <div class="col">
                    <x-file id="avatar" model="avatar" :label="__('Avatar')" accept="image/*" :previews="$avatarPreviews" />
                </div>
                <div class="col">
                    <x-file id="images" model="images" :label="__('Images')" accept="image/*" multiple
                        :previews="$imagesPreviews" />
                </div>
                <div class="col">
                    <x-file id="files" model="files" :label="__('Files')" multiple :previews="$filesPreviews" />
                </div>
            </div>
        </fgx:card-body>
        <fgx:card-submit-footer />
    </fgx:card>
</form>

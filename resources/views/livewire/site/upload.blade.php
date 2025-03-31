<div class="container my-10">
    <form wire:submit="save">
        <fgx:card>
            <fgx:card-header class="flex-space-2">
                <img src="{{ $user->getAvatarUrl('sm') }}" class="w-8 h-8 rounded-full border border-2 border-primary">
                <span>{{ $user->display_name }}</span>
            </fgx:card-header>
            <fgx:card-body>
                <div class="grid grid-cols-1 gap-4">
                    <div class="col">
                        <fgx:file wire:model="avatar" :label="__('Avatar')" accept="image/*"
                            :previews="$avatarPreviews" />
                    </div>
                    <div class="col">
                        <fgx:file wire:model="images" :label="__('Images')" accept="image/*" multiple
                            :previews="$imagesPreviews" />
                    </div>
                    <div class="col">
                        <fgx:file wire:model="files" :label="__('Files')" multiple :previews="$filesPreviews" />
                    </div>
                </div>
            </fgx:card-body>
            <fgx:card-submit-footer />
        </fgx:card>
    </form>
</div>

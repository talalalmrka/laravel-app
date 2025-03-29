<fgx:card class="h-full">
    <fgx:card-header class="text-primary" icon="bi-person-bounding-box" :title="__('Profile Image')" />
    <fgx:card-body>
        <div class="flex flex-col items-center justify-center">
            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                class="group relative w-32 h-32 rounded-full overflow-hidden">

                <div class="w-full h-full rounded-full overflow-hidden">
                    <img id="avatar" src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                        class="w-full h-full rounded-full object-cover">
                    <div x-show="!uploading"
                        class="hidden group-hover:flex absolute z-1 inset-0 items-center justify-center flex-wrap gap-2 bg-black/20 rounded-full">
                        <button type="button" wire:click="deleteAvatar"
                            class="w-6 h-6 text-xs text-white bg-red/70 hover:bg-red rounded-full flex items-center justify-center">
                            <i class="icon bi-trash-fill" wire:loading.remove wire:target="deleteAvatar"></i>
                            <x-loader wire:loading wire:target="deleteAvatar" />
                        </button>
                    </div>
                    <button type="button" x-on:click="$refs.fileInput.click()"
                        class="absolute z-2 bottom-0 start-0 end-0 text-xs h-6 text-white bg-primary/70 hover:bg-primary flex items-center justify-center">
                        @icon('bi-image')
                    </button>
                </div>
                <div x-cloak x-show="uploading"
                    class="progress absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 w-28">
                    <div class="progress-bar" :style="'width:' + progress + '%'" x-text="progress+'%'"></div>
                </div>
                <!-- File Input (Hidden) -->
                <input wire:model.live="avatar" id="avatar" x-ref="fileInput" type="file" class="hidden"
                    accept="image/*">
            </div>

            <fgx:error id="avatar" />
            <h3 class="text-2xl mt-4">{{ $user->name }}</h3>
            <p class="text-base font-light text-gray-500 dark:text-gray-400">
                {{ $user->email }}
            </p>
        </div>
        <fgx:status class="xs alert-soft" />
    </fgx:card-body>
</fgx:card>

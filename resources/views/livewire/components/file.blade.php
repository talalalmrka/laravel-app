<div x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress">
    <fgx:label id="{{ $collection }}" :label="$label" />
    <div class="form-drop-zone {{ $multiple ? 'multiple' : '' }}" x-cloak>
        <input x-ref="fileInput" type="file" wire:model.live="files" class="hidden" {{ $multiple ? 'multiple' : '' }} accept="{{ $accept }}">
        <div class="previews-grid">
            @if($previews->isEmpty())
                <div x-on:click="$refs.fileInput.click()" class="flex items-center justify-center w-full h-full cursor-pointer flex-coll">
                    <div class="flex flex-col items-center justify-center p-4">
                        @icon('bi-cloud-upload', 'w-8 h-8 mb-1 text-gray-500 dark:text-gray-400')
                        <div class="text-xs text-center text-gray-600 dark:text-gray-400">
                            {{ __('Click or darg here to upload') }}
                        </div>
                        <div class="mt-1 text-xxs text-center text-gray-600 dark:text-gray-400">
                        {{ __('Max size: :max MB • Allowed: :accept', ['max' => $maxSize, 'accept' => $accept]) }}
                        </div>
                    </div>
                </div>
            @endif
            @if ($previews && $previews->isNotEmpty())
                @foreach ($previews as $preview)
                    <div id="previews-item-{{ $preview->id }}" class="previews-item">
                        @if ($preview->type === 'image')
                            <img src="{{ $preview->url }}">
                        @else
                            <div class="flex items-center justify-center w-full h-full">
                                <div class="text-center">
                                    <i class="icon {{ $preview->icon }}"></i>
                                    <div class="text-xs mt-2">
                                        <div class="font-semibold">{{ $preview->name }}</div>
                                        <div class="mt-1">{{ $preview->mime_type }}</div>
                                        <div class="mt-1">{{ $preview->humanReadableSize }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @php
                            $deleteAction = "";
                            if($preview->model_type === 'Media'){
                                $deleteAction = "deleteMedia('{$preview->id}')";
                            }
                            if($preview->model_type === 'TemporaryUploadedFile'){
                                $deleteAction = "removeUpload('files','{$preview->name}')";
                            }
                        @endphp
                        <button type="button" class="previews-item-delete"
                            wire:click="{{ $deleteAction }}">
                            <i class="icon bi-trash-fill"></i>
                        </button>
                    </div>
                @endforeach
                @if($multiple)
                    <div x-on:click="$refs.fileInput.click()" class="previews-appender">
                        <div class="text-center">
                            <i class="icon bi-plus w-8 h-8 text-gray-500 dark:text-gray-400"></i>
                            <div class="mt-1 text-xs text-center text-gray-500 dark:text-gray-400">
                                {{ __('Click or drop to upload') }}
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div x-show="uploading" class="progress absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 w-full">
            <div class="progress-bar" x-text="progress+'%'" :style="'width:'+progress+'%'"></div>
        </div>
    </div>
    @dump($previews)
    <fgx:info id="{{ $collection }}" :info="$label" />
    <fgx:error id="{{ $collection }}" />
</div>

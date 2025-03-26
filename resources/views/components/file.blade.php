@props([
    'id' => uniqid('file-input-'),
    'icon' => null,
    'label' => null,
    'info' => null,
    'class' => null,
    'atts' => [],
    'multiple' => false,
    'container_class' => null,
    'container_atts' => [],
    'model' => 'files',
    'accept' => 'image/*,.pdf,.doc,.docx',
    'maxSize' => 5, // in MB
    'maxFiles' => 20,
    'previews' => null,
])
@php
    $multiple = $multiple || $attributes->has('multiple');
    if ($multiple) {
        $atts['multiple'] = '';
    }
    if(!$multiple && is_previews($previews)){
        //$previews = $previews->keepLast();
    }
    $mediaCount = is_previews($previews) ? $previews->count() : 0;
@endphp
<fgx:label :for="$id" :icon="$icon" :label="$label" />
<div x-data="fileUpload({
    model: '{{ $model }}',
    accept: '{{ $accept }}',
    maxSize: {{ $maxSize }},
    maxFiles: {{ $maxFiles }},
    multiple: @js($multiple),
    mediaCount: {{$mediaCount}},
})" id="form-drop-zone-{{ $model }}" class="form-drop-zone"
    :class="{ 'multiple': @js($multiple) }" x-cloak>
    <input
        {{ $attributes->merge(
            array_merge(
                [
                    'type' => 'file',
                    'id' => $id,
                    'accept' => $accept,
                    'x-ref' => 'fileInput',
                    'x-on:change' => 'handleFileSelect',
                    'class' => css_classes(['hidden', $class => $class]),
                ],
                $atts,
            ),
        ) }}>
    <!-- Previews -->
    <div class="previews-grid">
        <template x-if="!hasPreviews()">
            <div x-bind="dragZone" x-ref="dragZone"
                class="flex items-center justify-center w-full h-full cursor-pointer flex-coll">
                <div class="flex flex-col items-center justify-center p-4">
                    @icon('bi-cloud-upload', 'w-8 h-8 mb-1 text-gray-500 dark:text-gray-400')
                    <div class="text-xs text-center text-gray-600 dark:text-gray-400">
                        {{ __('Click or darg here to upload') }}
                    </div>
                    <div class="mt-1 text-xxs text-center text-gray-600 dark:text-gray-400">
                        {{ __('Max size: :max MB • Allowed: :accept', ['max' => $maxSize, 'accept' => $accept]) }}
                    </div>
                    <fgx:info :id="$id" :info="$info" />
                </div>
            </div>
        </template>
        @if($previews && $previews->isNotEmpty())
            @foreach ($previews as $preview)
                <div id="previews-item-{{ $preview->id }}" class="previews-item" :class="{'hidden': @js(!$multiple) && queue.length}">
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
                    <button type="button" class="previews-item-delete"
                        x-on:click="deletePreview(@js($preview))">
                        <i class="icon bi-trash-fill"></i>
                    </button>
                </div>
            @endforeach
        @endif
        <!-- Queue -->
        <template x-for="(file, index) in queue" :key="file.id">
            <div class="previews-item">
                <template x-if="file.preview">
                    <img :src="file.preview">
                </template>
                <template x-if="!file.preview">
                    <div class="flex items-center justify-center w-full h-full">
                        <div class="text-center">
                            <i class="icon bi-file"></i>
                            <div class="text-xs mt-2">
                                <div x-text="file.name" class="font-semibold"></div>
                                <div x-text="fileStatus(file)" class="mt-1"></div>
                                <div x-text="formatSize(file.size)" class="mt-1"></div>
                            </div>
                        </div>
                    </div>
                </template>
                <!-- Progress Bar -->
                <div class="progress absolute w-3/4 top-1/2 -translate-y-1/5 left-1/2 -translate-x-1/2"
                    x-show="file.progress > 0">
                    <div class="progress-bar" :style="'width: ' + file.progress + '%'"></div>
                </div>
                <div class="absolute inset-x-0 bottom-0 flex-space-2 justify-center p-1">
                    <template x-if="file.status === 'pending'">
                        <button type="button" class="btn btn-green xs" x-on:click="startUpload(file)">
                            <i class="icon bi-cloud-upload-fill"></i>
                        </button>
                    </template>

                    <template x-if="file.status === 'uploading'">
                        <button type="button" class="btn btn-yellow xs" x-on:click="pauseUpload(file)">
                            <i class="icon pause-fill"></i>
                        </button>
                    </template>

                    <template x-if="file.status === 'paused'">
                        <button type="button" class="btn btn-blue xs" x-on:click="resumeUpload(file)">
                            <i class="icon play-fill"></i>
                        </button>
                    </template>
                </div>
                <button type="button" class="previews-item-delete" x-on:click="cancelUpload(file)">
                    <i class="icon bi-trash-fill"></i>
                </button>
            </div>
        </template>
        <template x-if="showAppender()">
            <div x-bind="appender" class="previews-appender">
                <div class="text-center">
                    <i class="icon bi-plus w-8 h-8 text-gray-500 dark:text-gray-400"></i>
                    <div class="mt-1 text-xs text-center text-gray-500 dark:text-gray-400">
                        {{ __('Click or drop to upload') }}
                    </div>
                </div>
            </div>
        </template>
    </div>
    <template x-if="showEdit()">
        <button x-bind="editButton" type="button"
            class="flex items-center justify-center text-white bg-primary/70 hover:bg-primary text-xs w-8 h-8 rounded-full absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2">
            <i class="icon bi-pencil-square"></i>
        </button>
    </template>

</div>
<fgx:error :id="$id" />
@script
    <script>
        Alpine.data('fileUpload', (config) => ({
            multiple: config.multiple ?? false,
            queue: [],
            currentUpload: null,
            dragover: false,
            container: null,
            dragZone: {
                ['@dragover.prevent']() {
                    this.dragover = true;
                },
                ['@dragleave.prevent']() {
                    this.dragover = false;
                },
                ['@click']() {
                    this.$refs.fileInput.click();
                },
            },
            appender: {
                ['@click']() {
                    this.$refs.fileInput.click();
                },
            },
            editButton: {
                ['@click']() {
                    this.$refs.fileInput.click();
                },
            },
            handleMediaDeleted() {
                $wire.on('media-deleted', (event) => {
                    const id = event[0].id;
                    $wire.$refresh();
                    const element = document.querySelector(`#previews-item-${id}`);
                    if (element) {
                        console.log(element);
                        element.remove();
                    }
                    //console.log('media-deleted', id);
                    //this.media = this.media.filter(mediaItem => mediaItem.id !== id);
                });
            },
            handleFileSelect(e) {
                this.addFiles(Array.from(e.target.files));
                e.target.value = ''; // Reset input
            },

            handleDrop(e) {
                this.dragover = false;
                this.addFiles(Array.from(e.dataTransfer.files));
            },

            addFiles(files) {
                let i = 0;
                const remainingSlots = config.maxFiles - this.queue.length;
                const filesToAdd = files.slice(0, remainingSlots);

                filesToAdd.forEach(file => {
                    if (!this.validateFile(file)) return;

                    this.queue.push({
                        index: i,
                        id: Math.random().toString(36).substr(2, 9),
                        file,
                        name: file.name,
                        size: file.size,
                        preview: file.type.startsWith('image/') ? URL
                            .createObjectURL(file) : null,
                        progress: 0,
                        status: 'pending', // pending, uploading, paused, completed, error
                        error: null
                    });
                    i++;
                });
                this.processNext();
            },

            validateFile(file) {
                return true;
                if (file.size > config.maxSize * 1024 * 1024) {
                    alert(`File ${file.name} exceeds maximum size of ${config.maxSize}MB`);
                    return false;
                }

                const acceptedTypes = config.accept.split(',');
                if (!acceptedTypes.some(type => {
                        if (type.startsWith('.')) {
                            return file.name.toLowerCase().endsWith(type);
                        }
                        return file.type.match(type.replace('/*', '/.*'));
                    })) {
                    alert(`File ${file.name} is not an allowed type`);
                    return false;
                }

                return true;
            },

            async startUpload(file) {
                if (this.currentUpload) return;

                file.status = 'uploading';
                this.currentUpload = file;
                const t = this;
                try {
                    await $wire.upload(
                        this.multiple ? `${config.model}.${file.index}` : config.model,
                        file.file,
                        (uploadedFilename) => {
                            // Upload success
                            file.status = 'completed';
                            this.removeFromQueue(file);
                            this.currentUpload = null;
                            this.processNext();
                            //$wire.$refresh();
                        },
                        (error) => {
                            // Upload error
                            file.status = 'error';
                            file.error = error;
                            this.currentUpload = null;
                        },
                        (event) => {
                            // Progress update
                            file.progress = event.detail.progress;
                        },
                        () => {
                            // Cancel callback
                            file.status = 'cancelled';
                            this.currentUpload = null;
                        }
                    );
                } catch (error) {
                    file.status = 'error';
                    file.error = error.message;
                    this.currentUpload = null;
                }
            },

            pauseUpload(file) {
                if (file.status === 'uploading') {
                    file.status = 'paused';
                    $wire.cancelUpload(config.model);
                    this.currentUpload = null;
                }
            },

            resumeUpload(file) {
                if (file.status === 'paused') {
                    this.startUpload(file);
                }
            },

            cancelUpload(file) {
                if (file.status === 'uploading') {
                    $wire.cancelUpload(config.model);
                }
                this.removeFromQueue(file);
            },

            removeFromQueue(file) {
                this.queue = this.queue.filter(f => f.id !== file.id);
                if (file.preview) URL.revokeObjectURL(file.preview);
            },

            processNext() {
                const nextFile = this.queue.find(f => f.status === 'pending');
                if (nextFile) this.startUpload(nextFile);
            },

            formatSize(bytes) {
                if (bytes === 0) return '0 B';
                const k = 1024;
                const sizes = ['B', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            },

            fileStatus(file) {
                if (file.error) return `Error: ${file.error}`;
                if (file.status === 'uploading') return `Uploading... ${file.progress}%`;
                return file.status.charAt(0).toUpperCase() + file.status.slice(1);
            },
            deletePreview(item) {
                //console.log(item);
                switch (item.model_type) {
                    case 'Media':
                        $wire.$dispatch('delete-media', {
                            property: config.model,
                            id: item.id
                        });
                        $wire.$refresh();
                        break;
                    case 'TemporaryUploadedFile':
                        $wire.removeUpload(config.model, item.name, () => $wire.$refresh());
                        break;
                }

            },
            deleteTemporary(index, name) {
                $wire.removeUpload(config.model, name, () => this.temporaryFiles.splice(index, 1));
            },
            getPreviews() {
                const container = document.getElementById(`form-drop-zone-${config.model}`);
                //console.log(container);
                return container ? container.querySelectorAll('.previews-item') : [];
            },
            hasPreviews() {
                return parseInt(config.mediaCount) + this.queue.length > 0;
                //return this.getPreviews().length > 0;
            },
            showAppender() {
                return this.hasPreviews() && this.multiple;
            },
            showDragZone() {
                return !this.hasPreviews();
            },
            showEdit() {
                return this.hasPreviews() && !this.multiple;
            },
            init() {
                this.handleMediaDeleted();
                this.$nextTick(() => {

                });
            }
        }));
    </script>
@endscript

@props([
    'id' => uniqid('file-input-'),
    'icon' => null,
    'label' => null,
    'class' => null,
    'atts' => [],
    'multiple' => false,
    'container_class' => null,
    'container_atts' => [],
    'model' => 'files',
    'accept' => 'image/*,.pdf,.doc,.docx',
    'maxSize' => 5, // in MB
    'maxFiles' => 20,
    'previews' => [],
])
@php
    $multiple = $multiple || $attributes->has('multiple');
@endphp
<div x-data="fileUpload({
    model: '{{ $model }}',
    accept: '{{ $accept }}',
    maxSize: {{ $maxSize }},
    maxFiles: {{ $maxFiles }},
    previews: @js($previews ?? []),
})" x-cloak>
    @dump('previews', $previews)
    <div class="border-2 border-dashed rounded-lg p-6 mb-4 relative" @dragover.prevent="dragover = true"
        @dragleave.prevent="dragover = false" @drop.prevent="handleDrop($event)"
        :class="dragover ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">

        <input type="file" x-ref="fileInput" class="hidden" multiple x-on:change="handleFileSelect"
            accept="{{ $accept }}">

        <div class="text-center">
            <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                x-on:click="$refs.fileInput.click()">
                Select Files
            </button>
            <p class="mt-2 text-gray-600">
                or drag and drop files here
            </p>
            <p clcla="text-sm text-gray-500">
                Max size: {{ $maxSize }}MB • Allowed: {{ $accept }}
            </p>
        </div>
    </div>

    <!-- Upload Queue -->
    <div :class="{ 'flex items-center flex-wrap p-4 gap-4': @js($multiple), 'w-full h-full': @js(!$multiple) }"
        class="relative group/items">

        <!-- Media -->
        <template x-for="(preview, index) in previews" :key="preview.id">
            <div
                class="relative flex items-center justify-center shadow-xs hover:shadow-sm text-gray-500 dark:text-gray-400 bg-gray-100 hover:bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden {{ css_classes(['w-full h-full' => !$multiple, 'w-32 h-32' => $multiple]) }}">
                <template x-if="preview.type === 'image'">
                    <img :src="preview.url" class="max-w-full max-h-full;">
                </template>
                <template x-if="preview.type !== 'image'">
                    <div class="flex items-center justify-center w-full h-full">
                        <div class="text-center">
                            <i class="icon" :class="item.icon"></i>
                            <div class="text-xs mt-2">
                                <div x-text="preview.name" class="font-semibold"></div>
                                <div x-text="preview.mime_type" class="mt-1"></div>
                                <div x-text="preview.humanReadableSize" class="mt-1"></div>
                            </div>
                        </div>
                    </div>
                </template>
                <button type="button"
                    class="absolute top-0 end-0 mt-2 me-2 text-xs text-white bg-red/70 hover:bg-red-600 w-6 h-6 flex items-center justify-center rounded-full"
                    x-on:fileck="$dispatch('delete-media', {id: mediaItem.id})">
                    <i class="icon bi-trash-fill"></i>
                </button>
            </div>
        </template>

        <!-- Queue -->
        <template x-for="(file, index) in queue" :key="file.id">
            <div
                class="relative flex items-center justify-center shadow-xs hover:shadow-sm text-gray-500 dark:text-gray-400 bg-gray-100 hover:bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden {{ css_classes(['w-full h-full' => !$multiple, 'w-32 h-32' => $multiple]) }}">
                <template x-if="file.preview">
                    <img :src="file.preview" class="max-w-full max-h-full;">
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
                <button type="button"
                    class="absolute top-0 end-0 mt-2 me-2 text-xs text-white bg-red/70 hover:bg-red-600 w-6 h-6 flex items-center justify-center rounded-full"
                    x-on:click="cancelUpload(file)">
                    <i class="icon bi-trash-fill"></i>
                </button>
            </div>
        </template>
    </div>
</div>

@script
    <script>
        Alpine.data('fileUpload', (config) => ({
            queue: [],
            previews: config.previews ?? [],
            temporaryFiles: config.files ?? [],
            currentUpload: null,
            dragover: false,

            init() {
                // Initialize any necessary event listeners

                $nextTick(() => {
                    console.log('previews', this.previews);
                });
            },
            handleMediaDeleted() {
                $wire.on('media-deleted', (event) => {
                    const id = event.detail.id;
                    console.log('media-deleted', id);
                    this.media = this.media.filter(mediaItem => mediaItem.id !== id);
                });
            },
            get previewsCount() {
                return this.queue.length + this.media.length;
            },
            get hasPreviews() {
                return this.previewsCount > 0;
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
                console.log('queue', this.queue);
                if (this.queue.length) {
                    //this.processNext();
                }
            },

            validateFile(file) {
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
                        `${config.model}.${file.index}`,
                        file.file,
                        (uploadedFilename) => {
                            // Upload success
                            file.status = 'completed';
                            this.removeFromQueue(file);
                            this.currentUpload = null;
                            this.processNext();
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

            deleteTemporary(index, name) {
                $wire.removeUpload(config.model, name, () => this.temporaryFiles.splice(index, 1));
            }
        }));
    </script>
@endscript

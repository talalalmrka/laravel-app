@props([
    'model' => 'files',
    'accept' => 'image/*,.pdf,.doc,.docx',
    'maxSize' => 5, // in MB
    'maxFiles' => 10,
])

<div x-data="fileUpload({
    model: '{{ $model }}',
    accept: '{{ $accept }}',
    maxSize: {{ $maxSize }},
    maxFiles: {{ $maxFiles }}
})" x-cloak>
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
            <p class="text-sm text-gray-500">
                Max size: {{ $maxSize }}MB • Allowed: {{ $accept }}
            </p>
        </div>
    </div>

    <!-- Upload Queue -->
    <div class="space-y-4">
        <template x-for="(file, index) in queue" :key="file.id">
            <div class="border rounded-lg p-4">
                <!-- File Preview -->
                <div class="flex items-center gap-4 mb-2">
                    <template x-if="file.preview">
                        <img :src="file.preview" class="w-16 h-16 object-cover rounded">
                    </template>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <span x-text="file.name"></span>
                            <span x-text="formatSize(file.size)"></span>
                        </div>
                        <div class="text-sm text-gray-500" x-text="fileStatus(file)"></div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="h-2 bg-gray-200 rounded mb-2" x-show="file.progress > 0">
                    <div class="h-full bg-blue-500 rounded transition-all duration-300"
                        :style="'width: ' + file.progress + '%'"></div>
                </div>

                <!-- Controls -->
                <div class="flex gap-2 justify-end">
                    <template x-if="file.status === 'pending'">
                        <button type="button"
                            class="text-sm px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600"
                            x-on:click="startUpload(file)">
                            Start
                        </button>
                    </template>

                    <template x-if="file.status === 'uploading'">
                        <button type="button"
                            class="text-sm px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                            x-on:click="pauseUpload(file)">
                            Pause
                        </button>
                    </template>

                    <template x-if="file.status === 'paused'">
                        <button type="button"
                            class="text-sm px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600"
                            x-on:click="resumeUpload(file)">
                            Resume
                        </button>
                    </template>

                    <button type="button" class="text-sm px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
                        x-on:click="cancelUpload(file)">
                        Cancel
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>

@script
    <script>
      Alpine.data('fileUpload', (config) => ({
                queue: [],
                currentUpload: null,
                dragover: false,

                init() {
                    // Initialize any necessary event listeners
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
                    if(this.queue.length){
                      this.processNext();
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

                    try {
                        await $wire.uploadMultiple(
                            `${config.model}.${file.index}`,
                            [file.file],
                            (uploadedFiles) => {
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
                }
            }));
        document.addEventListener('alpine:init', () => {
            
        });
    </script>
@endscript

class Preview {
    constructor(id, name, url, type, mime_type, size, icon, model_type, file = null, progress = 0, status = 'pending') {
        this.id = id;
        this.name = name;
        this.url = url;
        this.type = type;
        this.mime_type = mime_type;
        this.size = size;
        this.icon = icon;
        this.model_type = model_type;
        this.file = file;
        this.progress = progress;
        this.status = status;
    }
    isImage() {
        return this.mime_type.startsWith('image/');
    }
    isVideo() {
        return this.mime_type.startsWith('video/');
    }
    isPreviewable() {
        return this.isImage() || this.isVideo();
    }
    isLocal() {
        return this.model_type === 'local';
    }
    isMedia() {
        return this.model_type === 'media';
    }
    isTemporary() {
        return this.model_type === 'temporary';
    }
    static make(data) {
        if (data instanceof File) {
            return this.fromFile(data);
        } else if (data instanceof Object) {
            return this.fromPreview(data);
        } else {
            return null;
        }
    }
    static fromFile(file) {
        const url = file.type.startsWith('image/') ? URL.createObjectURL(file) : null;
        return new Preview(
            Math.random().toString(36).substr(2, 9),
            file.name,
            url,
            file.type.split('/')[0],
            file.type,
            this.formatSize(file.size),
            this.mimeToIcon(file.type),
            "local",
            file,
        );
    }
    static fromPreview(preview) {

        return new Preview(
            preview.id,
            preview.name,
            preview.url,
            preview.type,
            preview.mime_type,
            preview.size,
            preview.icon,
            preview.model_type,
        );
    }

    static mimeToIcon(mime) {
        const type = mime.split('/')[0];
        const subtype = mime.split('/')[1];
        const icons = {
            'image': 'bi-file-image',
            'audio': 'bi-file-audio',
            'video': 'bi-file-video',
            'application': {
                'pdf': 'bi-file-pdf',
                'msword': 'bi-file-word',
                'vnd.openxmlformats-officedocument.wordprocessingml.document': 'bi-file-word',
                'vnd.ms-excel': 'bi-file-excel',
                'vnd.openxmlformats-officedocument.spreadsheetml.sheet': 'bi-file-excel',
                'vnd.ms-powerpoint': 'bi-file-powerpoint',
                'vnd.openxmlformats-officedocument.presentationml.presentation': 'bi-file-powerpoint',
                'zip': 'bi-file-archive',
                'x-rar-compressed': 'bi-file-archive',
                'x-7z-compressed': 'bi-file-archive',
                'x-tar': 'bi-file-archive',
                'json': 'bi-file-code',
                'javascript': 'bi-file-code',
                'x-javascript': 'bi-file-code',
                'x-httpd-php': 'bi-file-code',
                'x-sh': 'bi-file-code',
                'x-python': 'bi-file-code',
                'x-c': 'bi-file-code',
                'x-c++': 'bi-file-code',
                'x-java': 'bi-file-code',
                'default': 'bi-file'
            },
            'text': 'bi-file-alt',
            'default': 'bi-file'
        };

        if (icons[type]) {
            if (type === 'application' && typeof icons[type] === 'object') {
                return icons[type][subtype] || icons[type]['default'];
            }
            return icons[type];
        }

        return icons['default'];
    }
    static formatSize(bytes) {
        if (bytes === 0) return '0 B';
        const k = 1024;
        const sizes = ['B', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
}

window.Preview = Preview;


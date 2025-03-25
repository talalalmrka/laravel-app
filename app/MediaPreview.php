<?php
namespace App;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class MediaPreview
{
    public Media|TemporaryUploadedFile|UploadedFile $media;
    public $id;
    public $name;
    public $path;
    public $url;
    public $type;
    public $mime_type;
    public $extension;
    public $size;
    public $icon;
    public $model_type;
    public $humanReadableSize;
    protected $fillable = ['id', 'name', 'path', 'url', 'type', 'mime_type', 'extension', 'size', 'icon', 'model_type', 'humanReadableSize'];
    public function __construct(
        Media|TemporaryUploadedFile|UploadedFile $media,
        $data = [],
    ) {
        $this->media = $media;
        $this->bootAll($data);
    }
    public static function make(Media|TemporaryUploadedFile|UploadedFile $media, $data = [])
    {
        return new MediaPreview($media, $data);
    }
    public function bootAll($data = [])
    {
        foreach ($this->fillable as $property) {
            $method = 'get' . Str::studly($property);
            if (method_exists($this, $method)) {
                $v = $this->{$method}();
                $this->{$property} = $v;
            }
            if (isset($data[$property])) {
                $this->{$property} = $data[$property];
            }
        }
    }
    public function getId()
    {
        return match (true) {
            $this->media instanceof Media => $this->media->id,
            //$this->media instanceof TemporaryUploadedFile => $this->media->getClientOriginalName(),
            $this->media instanceof TemporaryUploadedFile => uniqid('tmp_'),
            $this->media instanceof UploadedFile => $this->media->getClientOriginalName(),
            default => null,
        };
    }
    public function getName()
    {
        return match (true) {
            $this->media instanceof Media => $this->media->name,
            $this->media instanceof TemporaryUploadedFile => $this->media->getFilename(),
            $this->media instanceof UploadedFile => $this->media->getClientOriginalName(),
            default => null,
        };
    }
    public function getUrl()
    {
        return match (true) {
            $this->media instanceof Media => $this->media->getUrl(),
            $this->media instanceof TemporaryUploadedFile => $this->media->isPreviewable() ? $this->media->temporaryUrl() : null,
            $this->media instanceof UploadedFile => null,
            default => null,
        };
    }
    public function getMimeType()
    {
        return match (true) {
            $this->media instanceof Media => $this->media->mime_type,
            $this->media instanceof TemporaryUploadedFile => $this->media->getMimeType(),
            $this->media instanceof UploadedFile => $this->media->getMimeType(),
            default => null,
        };
    }
    public function getType()
    {
        return self::mimeToType($this->getMimeType());
    }
    public function getPath()
    {
        return match (true) {
            $this->media instanceof Media => $this->media->getPath(),
            $this->media instanceof TemporaryUploadedFile => $this->media->getRealPath(),
            $this->media instanceof UploadedFile => $this->media->getRealPath(),
            default => null,
        };
    }
    public function getExtension()
    {
        return pathinfo($this->getPath(), PATHINFO_EXTENSION);
    }
    public function getSize()
    {
        return match (true) {
            $this->media instanceof Media => $this->media->size,
            $this->media instanceof TemporaryUploadedFile => $this->media->getSize(),
            $this->media instanceof UploadedFile => $this->media->getSize(),
            default => null,
        };
    }
    public function getModelType()
    {
        return match (true) {
            $this->media instanceof Media => 'Media',
            $this->media instanceof TemporaryUploadedFile => 'TemporaryUploadedFile',
            $this->media instanceof UploadedFile => 'UploadedFile',
            default => null,
        };
    }
    public static function mimeToType($mime)
    {
        if (Str::startsWith($mime, 'image/')) {
            return 'image';
        } elseif (Str::startsWith($mime, 'video/')) {
            return 'video';
        } elseif (Str::startsWith($mime, 'audio/')) {
            return 'audio';
        } elseif (Str::startsWith($mime, 'application/pdf')) {
            return 'pdf';
        } elseif (Str::startsWith($mime, 'application/msword')) {
            return 'doc';
        } elseif (Str::startsWith($mime, 'application/vnd.ms-excel')) {
            return 'xls';
        } elseif (Str::startsWith($mime, 'application/vnd.ms-powerpoint')) {
            return 'ppt';
        } elseif (Str::startsWith($mime, 'application/vnd.oasis.opendocument.text')) {
            return 'odt';
        } elseif (Str::startsWith($mime, 'application/vnd.oasis.opendocument.spreadsheet')) {
            return 'ods';
        } elseif (Str::startsWith($mime, 'application/vnd.oasis.opendocument.presentation')) {
            return 'odp';
        } elseif (Str::startsWith($mime, 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')) {
            return 'docx';
        } elseif (Str::startsWith($mime, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {
            return 'xlsx';
        } elseif (Str::startsWith($mime, 'application/vnd.openxmlformats-officedocument.presentationml.presentation')) {
            return 'pptx';
        } elseif (Str::startsWith($mime, 'application/zip')) {
            return 'zip';
        } elseif (Str::startsWith($mime, 'application/x-rar-compressed')) {
            return 'rar';
        } elseif (Str::startsWith($mime, 'application/x-7z-compressed')) {
            return '7z';
        } elseif (Str::startsWith($mime, 'application/x-tar')) {
            return 'tar';
        } elseif (Str::startsWith($mime, 'application/x-gzip')) {
            return 'gzip';
        } elseif (Str::startsWith($mime, 'application/x-bzip2')) {
            return 'bzip2';
        } elseif (Str::startsWith($mime, 'text/html')) {
            return 'html';
        } elseif (Str::startsWith($mime, 'text/css')) {
            return 'css';
        } elseif (Str::startsWith($mime, 'text/javascript')) {
            return 'js';
        } elseif (Str::startsWith($mime, 'application/json')) {
            return 'json';
        } elseif (Str::startsWith($mime, 'application/xml')) {
            return 'xml';
        } elseif (Str::startsWith($mime, 'application/x-httpd-php')) {
            return 'php';
        } elseif (Str::startsWith($mime, 'application/x-perl')) {
            return 'pl';
        } elseif (Str::startsWith($mime, 'application/x-python')) {
            return 'py';
        } elseif (Str::startsWith($mime, 'application/x-ruby')) {
            return 'rb';
        } elseif (Str::startsWith($mime, 'application/x-shellscript')) {
            return 'sh';
        } elseif (Str::startsWith($mime, 'text/plain')) {
            return 'txt';
        } elseif (Str::startsWith($mime, 'text/csv')) {
            return 'csv';
        } elseif (Str::startsWith($mime, 'text/tab-separated-values')) {
            return 'tsv';
        } elseif (Str::startsWith($mime, 'text/calendar')) {
            return 'ics';
        } elseif (Str::startsWith($mime, 'text/vcard')) {
            return 'vcf';
        } else {
            return 'file';
        }
    }

    // Additional helper methods
    public function getHumanReadableSize(): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->getSize();
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.2f", $bytes / (1024 ** $factor)) . $units[$factor];
    }
    public function isImage()
    {
        return in_array($this->mime_type, ['image/jpeg', 'image/png', 'image/jpg', 'image/webp', 'image/gif']);
    }
    public function isVideo()
    {
        return in_array($this->mime_type, ['video/mp4', 'video/quicktime', 'video/avi', 'video/mpeg', 'video/3gpp', 'video/3gpp2', 'video/ogg', 'video/webm']);
    }
    public function isAudio()
    {
        return in_array($this->mime_type, ['audio/mpeg', 'audio/ogg', 'audio/wav', 'audio/webm']);
    }
    public function isDocument()
    {
        return in_array($this->mime_type, ['application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint', 'application/vnd.oasis.opendocument.text', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.presentation', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.openxmlformats-officedocument.presentationml.presentation']);
    }
    public function isArchive()
    {
        return in_array($this->mime_type, ['application/zip', 'application/x-rar-compressed', 'application/x-7z-compressed', 'application/x-tar', 'application/x-gzip', 'application/x-bzip2']);
    }
    public function isCode()
    {
        return in_array($this->mime_type, ['text/html', 'text/css', 'text/javascript', 'application/json', 'application/xml', 'application/x-httpd-php', 'application/x-perl', 'application/x-python', 'application/x-ruby', 'application/x-shellscript']);
    }
    public function isSpreadsheet()
    {
        return in_array($this->mime_type, ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.oasis.opendocument.spreadsheet']);
    }
    public function isPresentation()
    {
        return in_array($this->mime_type, ['application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.oasis.opendocument.presentation']);
    }
    public function isPdf()
    {
        return $this->mime_type === 'application/pdf';
    }
    public function isText()
    {
        return in_array($this->mime_type, ['text/plain', 'text/csv', 'text/tab-separated-values', 'text/calendar', 'text/vcard']);
    }
    public function isFile()
    {
        return !$this->isImage() && !$this->isVideo() && !$this->isAudio() && !$this->isDocument() && !$this->isArchive() && !$this->isCode() && !$this->isSpreadsheet() && !$this->isPresentation() && !$this->isPdf() && !$this->isText();
    }
    public function getIcon()
    {
        $iconName = '';
        if ($this->isImage() == 'image') {
            $iconName = 'bi-image';
        } else if ($this->isAudio() == 'video') {
            $iconName = 'gmdi-video-camera-front-o';
        } else if ($this->isArchive()) {
            $iconName = 'bi-file-zip';
        } else if ($this->isSpreadsheet() == 'xls') {
            $iconName = 'bi-filetype-xls';
        } else if ($this->isPdf() == 'pdf') {
            $iconName = 'bi-file-pdf';
        } else {
            $iconName = "bi-filetype-$this->extension";
        }
        return $iconName;
    }
    public static function isTemporaryFiles($media)
    {
        return is_array($media) && collect($media)->every(fn($item) => $item instanceof TemporaryUploadedFile);
    }
    public static function isUploadedFiles($media)
    {
        return is_array($media) && collect($media)->every(fn($item) => $item instanceof UploadedFile);
    }
    public function toArray()
    {
        $data = [];
        foreach ($this->fillable as $property) {
            $data[$property] = $this->{$property};
        }
        return $data;
    }
}
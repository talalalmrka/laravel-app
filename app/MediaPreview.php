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
    protected $fillable = [
        "id",
        "name",
        "path",
        "url",
        "type",
        "mime_type",
        "extension",
        "size",
        "icon",
        "model_type",
        "humanReadableSize",
    ];
    public function __construct(
        $id,
        $name,
        $path,
        $url,
        $type,
        $mime_type,
        $extension,
        $size,
        $icon,
        $model_type,
        $humanReadableSize
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->path = $path;
        $this->url = $url;
        $this->type = $type;
        $this->mime_type = $mime_type;
        $this->extension = $extension;
        $this->size = $size;
        $this->icon = $icon;
        $this->model_type = $model_type;
        $this->humanReadableSize = $humanReadableSize;
    }
    public static function make(Media|TemporaryUploadedFile $media)
    {
        return match (true) {
            $media instanceof Media => self::fromMedia($media),
            $media instanceof TemporaryUploadedFile
                => self::fromTemporary($media),
            default => null,
        };
    }
    public static function fromMedia(Media $media)
    {
        return new self(
            $media->id,
            $media->name,
            $media->getPath(),
            $media->getUrl(),
            $media->type,
            $media->mime_type,
            $media->extension,
            $media->size,
            self::getIcon($media->mime_type),
            "Media",
            self::humanReadableSize($media->size)
        );
    }
    public static function fromTemporary(TemporaryUploadedFile $media)
    {
        return new self(
            random_int(1000000000, 9999999999),
            $media->getFilename(),
            $media->getRealPath(),
            $media->isPreviewable() ? $media->temporaryUrl() : null,
            self::mimeToType($media->getMimeType()),
            $media->getMimeType(),
            pathinfo($media->getRealPath(), PATHINFO_EXTENSION),
            $media->getSize(),
            self::getIcon($media->getMimeType()),
            "TemporaryUploadedFile",
            self::humanReadableSize($media->getSize())
        );
    }

    public static function mimeToType($mime)
    {
        if (Str::startsWith($mime, "image/")) {
            return "image";
        } elseif (Str::startsWith($mime, "video/")) {
            return "video";
        } elseif (Str::startsWith($mime, "audio/")) {
            return "audio";
        } elseif (Str::startsWith($mime, "application/pdf")) {
            return "pdf";
        } elseif (Str::startsWith($mime, "application/msword")) {
            return "doc";
        } elseif (Str::startsWith($mime, "application/vnd.ms-excel")) {
            return "xls";
        } elseif (Str::startsWith($mime, "application/vnd.ms-powerpoint")) {
            return "ppt";
        } elseif (
            Str::startsWith($mime, "application/vnd.oasis.opendocument.text")
        ) {
            return "odt";
        } elseif (
            Str::startsWith(
                $mime,
                "application/vnd.oasis.opendocument.spreadsheet"
            )
        ) {
            return "ods";
        } elseif (
            Str::startsWith(
                $mime,
                "application/vnd.oasis.opendocument.presentation"
            )
        ) {
            return "odp";
        } elseif (
            Str::startsWith(
                $mime,
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document"
            )
        ) {
            return "docx";
        } elseif (
            Str::startsWith(
                $mime,
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            )
        ) {
            return "xlsx";
        } elseif (
            Str::startsWith(
                $mime,
                "application/vnd.openxmlformats-officedocument.presentationml.presentation"
            )
        ) {
            return "pptx";
        } elseif (Str::startsWith($mime, "application/zip")) {
            return "zip";
        } elseif (Str::startsWith($mime, "application/x-rar-compressed")) {
            return "rar";
        } elseif (Str::startsWith($mime, "application/x-7z-compressed")) {
            return "7z";
        } elseif (Str::startsWith($mime, "application/x-tar")) {
            return "tar";
        } elseif (Str::startsWith($mime, "application/x-gzip")) {
            return "gzip";
        } elseif (Str::startsWith($mime, "application/x-bzip2")) {
            return "bzip2";
        } elseif (Str::startsWith($mime, "text/html")) {
            return "html";
        } elseif (Str::startsWith($mime, "text/css")) {
            return "css";
        } elseif (Str::startsWith($mime, "text/javascript")) {
            return "js";
        } elseif (Str::startsWith($mime, "application/json")) {
            return "json";
        } elseif (Str::startsWith($mime, "application/xml")) {
            return "xml";
        } elseif (Str::startsWith($mime, "application/x-httpd-php")) {
            return "php";
        } elseif (Str::startsWith($mime, "application/x-perl")) {
            return "pl";
        } elseif (Str::startsWith($mime, "application/x-python")) {
            return "py";
        } elseif (Str::startsWith($mime, "application/x-ruby")) {
            return "rb";
        } elseif (Str::startsWith($mime, "application/x-shellscript")) {
            return "sh";
        } elseif (Str::startsWith($mime, "text/plain")) {
            return "txt";
        } elseif (Str::startsWith($mime, "text/csv")) {
            return "csv";
        } elseif (Str::startsWith($mime, "text/tab-separated-values")) {
            return "tsv";
        } elseif (Str::startsWith($mime, "text/calendar")) {
            return "ics";
        } elseif (Str::startsWith($mime, "text/vcard")) {
            return "vcf";
        } else {
            return "file";
        }
    }

    // Additional helper methods
    public static function humanReadableSize($bytes): string
    {
        $units = ["B", "KB", "MB", "GB"];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.2f", $bytes / 1024 ** $factor) . $units[$factor];
    }
    public static function isImage($mime)
    {
        return in_array($mime, [
            "image/jpeg",
            "image/png",
            "image/jpg",
            "image/webp",
            "image/gif",
        ]);
    }
    public static function isVideo($mime)
    {
        return in_array($mime, [
            "video/mp4",
            "video/quicktime",
            "video/avi",
            "video/mpeg",
            "video/3gpp",
            "video/3gpp2",
            "video/ogg",
            "video/webm",
        ]);
    }
    public static function isAudio($mime)
    {
        return in_array($mime, [
            "audio/mpeg",
            "audio/ogg",
            "audio/wav",
            "audio/webm",
        ]);
    }
    public static function isDocument($mime)
    {
        return in_array($mime, [
            "application/pdf",
            "application/msword",
            "application/vnd.ms-excel",
            "application/vnd.ms-powerpoint",
            "application/vnd.oasis.opendocument.text",
            "application/vnd.oasis.opendocument.spreadsheet",
            "application/vnd.oasis.opendocument.presentation",
            "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.openxmlformats-officedocument.presentationml.presentation",
        ]);
    }
    public static function isArchive($mime)
    {
        return in_array($mime, [
            "application/zip",
            "application/x-rar-compressed",
            "application/x-7z-compressed",
            "application/x-tar",
            "application/x-gzip",
            "application/x-bzip2",
        ]);
    }
    public static function isSpreadsheet($mime)
    {
        return in_array($mime, [
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/vnd.oasis.opendocument.spreadsheet",
        ]);
    }

    public static function isPdf($mime)
    {
        return $mime === "application/pdf";
    }
    public static function getIcon($mime)
    {
        $iconName = "";
        if (self::isImage($mime)) {
            $iconName = "bi-image";
        } elseif (self::isVideo($mime)) {
            $iconName = "gmdi-video-camera-front-o";
        } elseif (self::isArchive($mime)) {
            $iconName = "bi-file-zip";
        } elseif (self::isSpreadsheet($mime)) {
            $iconName = "bi-filetype-xls";
        } elseif (self::isPdf($mime)) {
            $iconName = "bi-file-pdf";
        } else {
            $iconName = "bi-file";
        }
        return $iconName;
    }
    public static function isTemporaryFiles($media)
    {
        return is_array($media) &&
            collect($media)->every(
                fn($item) => $item instanceof TemporaryUploadedFile
            );
    }
    public static function isUploadedFiles($media)
    {
        return is_array($media) &&
            collect($media)->every(fn($item) => $item instanceof UploadedFile);
    }
    public function toArray()
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "path" => $this->path,
            "url" => $this->url,
            "type" => $this->type,
            "mime_type" => $this->mime_type,
            "extension" => $this->extension,
            "size" => $this->size,
            "icon" => $this->icon,
            "model_type" => $this->model_type,
            "humanReadableSize" => $this->humanReadableSize,
        ];
    }
}

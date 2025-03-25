<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class MediaPreviewCollection extends Collection
{
    public static function create(...$values)
    {
        $collection = new self(); // Use self() instead of class name
        return $collection->push(...$values);
    }

    /**
     * Override push to ensure items are converted to MediaPreview
     */
    public function push(...$values)
    {
        foreach ($values as $value) {
            if ($value instanceof MediaPreview) {
                parent::push($value);
            } elseif (
                $value instanceof Media ||
                $value instanceof TemporaryUploadedFile ||
                $value instanceof UploadedFile
            ) {
                parent::push(MediaPreview::make($value));
            } elseif (
                $value instanceof Collection ||
                $value instanceof MediaCollection ||
                MediaPreview::isTemporaryFiles($value) ||
                MediaPreview::isUploadedFiles($value)
            ) {
                foreach ($value as $item) {
                    parent::push(MediaPreview::make($item));
                }
            }
        }

        return $this;
    }

    /**
     * Override toArray to convert all items and the collection itself
     */
    public function toArray()
    {
        return $this->map(
            fn($item) => $item instanceof MediaPreview
                ? $item->toArray()
                : $item
        )->all();
    }
}

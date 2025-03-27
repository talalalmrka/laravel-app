<?php

namespace App\Traits;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasThumbnail
{
    public function getThumbnail()
    {
        return $this->getFirstMedia('thumbnail');
    }
    public function getThumbnailUrl($conversion = '')
    {
        return $this->getFirstMediaUrl('thumbnail', $conversion);
    }
    public function setThumbnail($file)
    {
        return $this->addMedia($file)->toMediaCollection('thumbnail');
    }
    public function deleteThumbnail()
    {
        return $this->clearMediaCollection('thumbnail');
    }

    public function registerThumbnail()
    {

        $collection_name = data_get($this, 'thumbnail_collection_name', 'thumbnail');
        if ($collection_name) {
            $collection = $this->addMediaCollection($collection_name);
            $mime_types = data_get($this, 'thumbnail_mime_type', [
                'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif'
            ]);
            if ($mime_types) {
                $collection->acceptsMimeTypes($mime_types);
            }
            $single = data_get($this, 'thumbnail_single', true);
            if ($single) {
                $collection->singleFile();
            }
            $fallback_url = data_get($this, "thumbnail_fallback_url");
            if ($fallback_url) {
                $collection->useFallbackUrl($fallback_url);
            }
            $fallback_path = data_get($this, "thumbnail_fallback_path");
            if ($fallback_path) {
                $collection->useFallbackPath($fallback_path);
            }
            $conversions = data_get($this, 'thumbnail_conversions', [
                'sm' => [
                    'width' => 400,
                    'height' => 255,
                ],
                'md' => [
                    'width' => 600,
                    'height' => 337.5,
                ],
                'lg' => [
                    'width' => 800,
                    'height' => 450,
                ],
            ]);
            $conversions_format = data_get($this, 'thumbnail_format', 'webp');
            $conversions_quality = data_get($this, 'thumbnail_quality', 100);
            $conversions_queued = data_get($this, 'thumbnail_queued', false);
            $conversions_responsive = data_get($this, 'thumbnail_responsive', false);
            if ($conversions) {
                $collection->registerMediaConversions(function (?Media $media = null) use ($collection_name, $conversions, $conversions_format, $conversions_quality, $conversions_responsive, $conversions_queued) {
                    foreach ($conversions as $key => $value) {
                        //create conversion
                        $conversion = $this->addMediaConversion($key);

                        //width
                        $width = data_get($value, 'width');
                        if ($width) {
                            $conversion->width($width);
                        }

                        //height
                        $height = data_get($value, 'height');
                        if ($height) {
                            $conversion->height($height);
                        }

                        //quality
                        $quality = data_get($value, 'quality', $conversions_quality);
                        if ($quality) {
                            $conversion->quality($quality);
                        }

                        //format
                        $format = data_get($value, "format", $conversions_format);
                        if ($format) {
                            $conversion->format($format);
                        }

                        //responsive
                        $responsive = data_get($value, "responsive", $conversions_responsive);
                        if ($responsive) {
                            $conversion->withResponsiveImages(true);
                        }

                        //queued
                        $queued = data_get($value, "queued", $conversions_queued);
                        if ($queued) {
                            $conversion->queued();
                        } else {
                            $conversion->nonQueued();
                        }
                    }
                });
            }
        }
    }
}

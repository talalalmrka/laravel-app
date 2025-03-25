<?php

use App\MediaPreview;
use App\MediaPreviewCollection;

if (!function_exists('media_preview')) {
    function media_preview($media)
    {
        return MediaPreview::make($media);
    }
}

if (!function_exists('media_previews')) {
    function media_previews(...$values)
    {
        return MediaPreviewCollection::create($values);
    }
}
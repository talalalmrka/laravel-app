<?php

use App\MediaPreview;
use App\MediaPreviews;

if (!function_exists('media_preview')) {
    function media_preview($media)
    {
        return MediaPreview::make($media);
    }
}

if (!function_exists('media_previews')) {
    function media_previews(...$values)
    {
        return MediaPreviews::create($values);
    }
}

if(!function_exists('is_previews')){
    function is_previews($data){
        return $data instanceof MediaPreviews;
    }
}
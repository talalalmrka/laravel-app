<?php

use App\MediaPreview;

if (!function_exists('temporary_file_to_array')) {
    function temporary_file_to_array($file)
    {
        return [
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientOriginalName(),
            'type' => mime_to_type($file->getClientMimeType()),
            'size' => $file->getSize(),
            'path' => $file->getRealPath(),
            'error' => $file->getError(),
        ];
    }
}

if (!function_exists('media_to_array')) {
    function media_to_array($media)
    {
        return MediaPreview::make($media)->toArray();
    }
}

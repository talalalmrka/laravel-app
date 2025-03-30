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

if (!function_exists('livewire_tmp_url')) {
    function livewire_tmp_url() {
        $disk = config('livewire.temporary_file_upload.disk');
        $directory = config('livewire.temporary_file_upload.directory') ?? 'livewire-tmp';
        $diskUrl = config("filesystems.disks.{$disk}.url");
        return "$diskUrl/$directory/";
    }
}

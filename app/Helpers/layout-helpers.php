<?php
use Illuminate\Support\Arr;
if (!function_exists('layout_options')) {
    function layout_options() {
        $layouts = config('layouts.layouts');
        return Arr::map($layouts, function($layout){
            return [
                'label' => __("layouts.$layout"),
                'value' => $layout,
            ];
        });
    }
}

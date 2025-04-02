<?php

if (!function_exists('guard_name_options')) {
    function guard_name_options()
    {
        $guards = config('auth.guards');
        $options = [];
        foreach ($guards as $key => $value) {
            $options[] = [
                'label' => ucfirst($key),
                'value' => $key,
            ];
        }
        return $options;
    }
}

if (!function_exists('guard_names')) {
    function guard_names()
    {
        return array_keys(config('auth.guards'));
    }
}
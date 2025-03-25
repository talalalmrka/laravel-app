<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\View\ComponentAttributeBag;
if (!function_exists('locale_options')) {
    function locale_options()
    {
        return [
            [
                'label' => 'English',
                'value' => 'en',
                'icon' => 'us',
            ],
            [
                'label' => 'العربية',
                'value' => 'ar',
                'icon' => 'sa',
            ],
        ];
    }
}

if (!function_exists('locales')) {
    function locales()
    {
        return Arr::map(locale_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}
if (!function_exists('current_locale')) {
    function current_locale()
    {
        //return str_replace('_', '-', app()->getLocale());
        return App::getLocale();
    }
}

if (!function_exists('is_rtl')) {
    function is_rtl()
    {
        $rtl_locales = [
            'ar',
        ];
        return in_array(current_locale(), $rtl_locales);
    }
}
if (!function_exists('locale_attributes')) {
    function locale_attributes()
    {
        return new ComponentAttributeBag([
            'lang' => current_locale(),
            'dir' => is_rtl() ? 'rtl' : null,
        ]);
    }
}

//$locale_attributes = locale_attributes();
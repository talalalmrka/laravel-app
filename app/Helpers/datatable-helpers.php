<?php

use App\Livewire\Components\Datatable\Buttons\Button;
use App\Livewire\Components\Datatable\Columns\Column;
use Illuminate\Support\Arr;

if (!function_exists('badge')) {
    function badge($data)
    {
        return view('livewire.components.datatable.badge', $data);
    }
}

if (!function_exists('thumbnail')) {
    function thumbnail($data)
    {
        return view('livewire.components.datatable.thumbnail', $data);
    }
}
if (!function_exists('per_page_options')) {
    function per_page_options()
    {
        $options = [];
        $i = 5;
        while ($i <= 50) {
            $options[] = [
                'label' => $i,
                'value' => $i,
            ];
            $i = $i + 5;
        }
        return $options;
    }
}

if (!function_exists('per_pages')) {
    function per_pages()
    {
        return Arr::map(per_page_options(), function ($option) {
            return data_get($option, 'value');
        });
    }
}

if (!function_exists('button')) {
    function button($click)
    {
        return Button::make($click);
    }
}

if (!function_exists('column')) {
    function column($name)
    {
        return Column::make($name);
    }
}

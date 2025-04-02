<?php

namespace App\Livewire\Components\Datatable\Columns;

class CheckboxColumn extends Column
{
    public static function make($name)
    {
        $column = new static();
        $column->name = $name;
        $column->customContent = "<input type=\"checkbox\" name=\"$name\[]\" value=\"\" wire:model.live=\"$name\"/>";
        return $column;
    }
}

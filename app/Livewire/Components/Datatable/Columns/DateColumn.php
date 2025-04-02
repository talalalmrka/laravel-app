<?php
namespace App\Livewire\Components\Datatable\Columns;

use Carbon\Carbon;

class DateColumn extends Column
{
    public $format = 'M d, Y';
    public $headClass = 'text-center';
    public $class = 'text-xs text-center';
    public $sortable = true;
    public $orderable = true;

    public static function make($name)
    {
        $column = new static();
        $column->name = $name;
        $column->customContent = function ($item) use ($column) {
            $date = data_get($item, $column->name);
            return Carbon::parse($date)->format($column->format);
        };
        return $column;
    }

    // Set a custom date format
    public function format($format)
    {
        $this->format = $format;
        return $this;
    }

    // Custom content for date columns
    /*public function content($content = null)
    {
        if ($content) {
            $this->customContent = $content;
        } else {
            $this->customContent = function ($item) {
                $date = data_get($item, $this->name);
                return Carbon::parse($date)->format($this->format);
            };
        }
        return $this;
    }*/
}

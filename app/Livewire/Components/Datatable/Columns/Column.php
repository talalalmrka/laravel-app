<?php
namespace App\Livewire\Components\Datatable\Columns;

class Column
{
    public $name;
    public $label;
    public $sortable = false;
    public $searchable = false;
    public $filterable = false;
    public $customContent = null;
    public $headClass = '';
    public $class = '';

    public static function make($name)
    {
        $column = new static();
        $column->name = $name;
        return $column;
    }

    public function label($label)
    {
        $this->label = $label;
        return $this;
    }

    public function sortable()
    {
        $this->sortable = true;
        return $this;
    }

    public function searchable()
    {
        $this->searchable = true;
        return $this;
    }

    public function filterable()
    {
        $this->filterable = true;
        return $this;
    }
    public function headClass($class)
    {
        $this->headClass = $class;
        return $this;
    }
    public function class($class)
    {
        $this->class = $class;
        return $this;
    }
    public function content($content)
    {
        $this->customContent = $content;
        return $this;
    }

    public function getLabel()
    {
        return $this->label ?? $this->name;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }
}

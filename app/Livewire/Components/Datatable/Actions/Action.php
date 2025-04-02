<?php

namespace App\Livewire\Components\Datatable\Actions;

use App\Livewire\Components\Datatable\Buttons\Button;
use Illuminate\View\ComponentAttributeBag;

class Action extends Button
{
    public $color = null;
    public static function make($click = null)
    {
        $action = new Action();
        $action->click($click);
        $action->color(null);
        return $action;
    }
    public function color($color)
    {
        $colors = [
            'primary' => 'text-primary',
            'secondary' => 'text-secondary',
            'green' => 'text-green',
            'blue' => 'text-blue',
            'red' => 'text-red',
            'yellow' => 'text-yellow',
        ];
        $this->color = $color;
        if (!empty($this->color)) {
            $buttonColor = data_get($colors, $this->color);
            $this->addClass($buttonColor);
        }
        return $this;
    }
    public function render()
    {
        return view('livewire.components.datatable.action', ['action' => $this]);
    }
}

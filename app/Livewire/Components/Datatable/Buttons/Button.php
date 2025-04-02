<?php

namespace App\Livewire\Components\Datatable\Buttons;

use Illuminate\View\ComponentAttributeBag;

class Button
{
    public $type = 'button';
    public $click = null;
    public $icon = null;
    public $label = null;
    public $color = 'primary';
    public $disabled = false;
    public $loading = true;
    public $href = null;
    public $target = null;
    public $customContent = null;
    public $class = null;
    public $atts = [];
    public ComponentAttributeBag $attributes;
    public ComponentAttributeBag $labelAttributes;

    public function __construct($type = 'button', $click = null, $icon = null, $label = null, $class = null, $atts = [], $color = null, $disabled = false, $loading = true, $href = null, $target = null, $customContent = null)
    {
        $this->attributes = new ComponentAttributeBag($atts);
        $this->labelAttributes = new ComponentAttributeBag();
        $this->type($type);
        $this->click($click);
        $this->icon($icon);
        $this->label($label);
        $this->class($class);
        $this->atts($atts);
        $this->color($color);
        $this->disabled($disabled);
        $this->loading($loading);
        $this->href($href);
        $this->target($target);
        $this->content($customContent);
    }
    public static function make($click = null)
    {
        $button = new static();
        $button->click($click);
        return $button;
    }
    public function click($click)
    {
        $this->click = $click;
        if (!empty($this->click)) {
            $this->attributes(['wire:click' => $this->click]);
            $this->labelAttributes(['wire:target' => $this->click]);
        }
        return $this;
    }
    public function type($type)
    {
        $this->type = $type;
        if (!empty($this->type)) {
            $this->attributes(['type' => $this->type]);
        }
        return $this;
    }
    public function icon($icon)
    {
        $this->icon = $icon;
        if (!empty($this->label) && !empty($this->icon)) {
            $this->addClass('flex-space-2');
        }
        return $this;
    }
    public function label($label)
    {
        $this->label = $label;
        return $this;
    }
    public function class($class)
    {
        $this->class = $class;
        if (!empty($this->class)) {
            $this->addClass($this->class);
        }
        return $this;
    }
    public function atts($atts)
    {
        $this->atts = $atts;
        if (!empty($this->atts)) {
            $this->attributes($this->atts);
        }
        return $this;
    }
    public function color($color)
    {
        $colors = [
            'primary' => 'btn-primary',
            'secondary' => 'btn-secondary',
            'green' => 'btn-green',
            'blue' => 'btn-blue',
            'red' => 'btn-red',
            'yellow' => 'btn-yellow',
        ];
        $this->color = $color;
        if (!empty($this->color)) {
            $buttonColor = data_get($colors, $this->color);
            $this->addClass($buttonColor);
        }
        return $this;
    }
    public function disabled($disabled)
    {
        $this->disabled = $disabled;
        if (!empty($this->disabled)) {
            $this->attributes(['disabled' => '']);
        }
        return $this;
    }
    public function loading($loading)
    {
        $this->loading = $loading;
        if ($this->loading) {
            $this->labelAttributes(['wire:loading.remove' => '']);
        }
        return $this;
    }
    public function content($content)
    {
        $this->customContent = $content;
        return $this;
    }

    public function href($href)
    {
        $this->href = $href;
        if (!empty($href)) {
            $this->attributes(['href' => $this->href]);
        }
        return $this;
    }
    public function target($target)
    {
        $this->target = $target;
        if (!empty($this->target)) {
            $this->attributes(['target' => $this->target]);
        }
        return $this;
    }
    public function getLabel()
    {
        return $this->customContent ?? $this->label;
    }
    public function attributes($atts)
    {
        $this->attributes->setAttributes(array_merge($this->attributes->getAttributes(), $atts));
        //$this->attributes = $this->attributes->merge($atts);
    }
    public function labelAttributes($atts)
    {
        //$this->labelAttributes = $this->labelAttributes->merge($atts);
        $this->labelAttributes->setAttributes(array_merge($this->labelAttributes->getAttributes(), $atts));
    }
    public function addClass($class)
    {
        $this->attributes = $this->attributes->class($class);
    }
    public function toArray()
    {
        return get_object_vars($this);
    }
    public function render()
    {
        return view('livewire.components.datatable.button', ['button' => $this]);
    }
}

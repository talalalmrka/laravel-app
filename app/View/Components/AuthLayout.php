<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthLayout extends CurveLayout
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.auth', [
            'title' => $this->title,
            'showTitle' => false,
            'description' => $this->description,
            'color' => $this->color,
            'headerClass' => $this->headerClass,
            'headerAtts' => $this->headerAtts,
        ]);
    }
}

<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardLayout extends AppLayout
{
    public $actions = [];
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.dashboard', [
            'title' => $this->title,
            'description' => $this->description,
            'actions' => $this->actions,
        ]);
    }
}

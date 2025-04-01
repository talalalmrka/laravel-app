<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CoverLayout extends AppLayout
{
    public $title = null;
    public $showTitle = true;
    public $subtitle = null;
    public $secondSubtitle = null;
    public $showSecondSubtitle = true;
    public $showSubtitle = true;
    public $description = null;
    public $color = 'primary';
    public $image = null;
    public $headerClass = null;
    public $headerAtts = [];
    public function __construct(
        $title = '',
        $showTitle = true,
        $subtitle = null,
        $showSubtitle = true,
        $secondSubtitle = null,
        $showSecondSubtitle = true,
        $description = null,
        $color = 'primary',
        $image = null,
        $headerClass = null,
        $headerAtts = [],
    ) {
        $this->title = $title;
        $this->showTitle = $showTitle;
        $this->subtitle = $subtitle;
        $this->showSubtitle = $showSubtitle;
        $this->secondSubtitle = $secondSubtitle;
        $this->showSecondSubtitle = $showSecondSubtitle;
        $this->description = $description;
        $this->color = $color;
        $this->image = $image;
        $this->headerClass = $headerClass;
        $this->headerAtts = $headerAtts;

    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.cover', [
            'title' => $this->title,
            'showTitle' => $this->showTitle,
            'subtitle' => $this->subtitle,
            'showSubtitle' => $this->showSubtitle,
            'secondSubtitle' => $this->secondSubtitle,
            'showSecondSubtitle' => $this->showSecondSubtitle,
            'description' => $this->description,
            'color' => $this->color,
            'image' => $this->image,
            'headerClass' => $this->headerClass,
            'headerAtts' => $this->headerAtts,
        ]);
    }
}

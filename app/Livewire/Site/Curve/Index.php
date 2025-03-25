<?php

namespace App\Livewire\Site\Curve;

use Livewire\Component;

class Index extends Component
{
    public $title;
    public $subtitle;
    public function mount()
    {
        $this->title = __('Title example');
        $this->subtitle = __('This is subtitle example');
    }
    public function render()
    {
        return view('livewire.site.curve.index')->layout('layouts.curve', [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }
}

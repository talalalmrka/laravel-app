<?php

namespace App\Livewire\Site\Home;

use Livewire\Component;

class Index extends Component
{
    public $title;
    public function mount()
    {
        $this->title = __('Home');
    }
    public function render()
    {
        return view('livewire.site.home.index')->layout('layouts.default', [
            'title' => $this->title,
        ]);
    }
}

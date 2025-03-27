<?php

namespace App\Livewire\Components;

use App\MediaPreviews;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class File extends Component
{
    public $label = null;
    public $model;
    public $collection;
    public $multiple = false;
    public $info = null;
    #[Modelable]
    public $files;
    /*public function mount(
        $label = null,
        $model,
        $collection,
        $multiple = false,
    ) {
        $this->label = $label;
        $this->model = $model;
    }*/
    public function render()
    {
        return view('livewire.components.file', [
            'previews' => MediaPreviews::make($this->model->getMedia($this->collection), $this->files),
        ]);
    }
}

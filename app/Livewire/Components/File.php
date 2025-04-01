<?php

namespace App\Livewire\Components;

use Fgx\Previews;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;

class File extends Component
{
    use WithFileUploads;
    public $label = null;
    public $model;
    public $collection;
    public $multiple = false;
    public $info = null;
    public $accept = "image/*,.pdf,.doc,.docx";
    public $maxSize = 5;
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
            'previews' => Previews::create($this->model->getMedia($this->collection), $this->files),
        ]);
    }
}

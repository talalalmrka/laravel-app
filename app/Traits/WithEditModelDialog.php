<?php

namespace App\Traits;

use Livewire\Attributes\On;

trait WithEditModelDialog
{
    use WithEditModel;
    public $show = false;
    public $closeAfterSave = true;

    public function mountWithEditModelDialog()
    {
        if (method_exists($this, 'beforeMountDialog')) {
            $this->beforeMountDialog();
        }
        $this->mountWithEditModel();
        if (method_exists($this, 'afterMountDialog')) {
            $this->afterMountDialog();
        }
    }
    public function open()
    {
        $this->show = true;
    }
    public function close()
    {
        $this->show = false;
        $this->{$this->model_type} = $this->model()->newInstance();
    }
    public function updatedShow($value)
    {
        if (!$value) {
            $this->{$this->model_type} = $this->model()->newInstance();
        }
    }
    #[On('edit')]
    public function onEdit(string $model_type, int|null $id = null)
    {
        if ($model_type === $this->model_type) {
            $model = $id ? $this->model()->findOrFail($id) : $this->model()->newInstance();
            $this->mount($model);
            $this->mountWithEditModelDialog();
            $this->open();
        }
    }
    #[On('saved')]
    public function onSaved(string $model_type, int|null $itemId = null)
    {
        if ($this->model_type === $model_type && $this->model()->id === $itemId) {
            if ($this->closeAfterSave) {
                $this->close();
            }
        }
    }
    public function render()
    {
        $plural_name = $this->pluralName();
        return view("livewire.dashboard.{$plural_name}.edit");
    }
}

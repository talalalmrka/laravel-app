<?php

namespace App\Traits;

use Livewire\Attributes\Computed;
use Livewire\Features\SupportFileUploads\WithFileUploads;

trait WithEditModel
{
    use WithFileUploads, HasMediaProperties;
    //protected $model_type;
    public $status_key = 'save';
    public function mountWithEditModel()
    {
        if (!$this->model()) {
            dd('Error', 'You must set the $model_type', 'add protected $model_type = (user, post, ...etc)');
        }
        if (method_exists($this, 'beforeMount')) {
            $this->beforeMount();
        }
        if (method_exists($this, 'beforeFill')) {
            $this->beforeFill();
        }
        $this->fillData();
        $this->fillMeta();
        //$this->fillMedia();
        if (method_exists($this, 'afterFill')) {
            $this->afterFill();
        }
        if (method_exists($this, 'afterMount')) {
            $this->afterMount();
        }
    }
    public function model()
    {
        return isset($this->model_type) ? $this->{$this->model_type} : null;
    }
    public function fillData()
    {
        if (method_exists($this, 'beforeFillData')) {
            $this->beforeFillData();
        }
        $this->fill($this->model()->only($this->fillable_data));
        if (method_exists($this, 'afterFillData')) {
            $this->afterFillData();
        }
    }
    public function fillMeta()
    {
        if (method_exists($this, 'beforeFillMeta')) {
            $this->beforeFillMeta();
        }
        if (method_exists($this->model(), 'getMetas')) {

            $this->fill($this->model()->getMetas($this->fillable_meta));
        }
        if (method_exists($this, 'afterFillMeta')) {
            $this->afterFillMeta();
        }
    }
    #[Computed]
    public function getPreviews($property)
    {
        return previews($this->model()->getMedia($property), $this->$property)->toArray();
    }
    public function fillMedia()
    {
        if (method_exists($this, 'beforefillMedia')) {
            $this->beforefillMedia();
        }
        foreach ($this->fillable_media as $property) {
            $previewsName = "previews" . ucfirst($property);
            $this->{$previewsName} = $this->getPreviews($property);
        }
        if (method_exists($this, 'afterfillMedia')) {
            $this->afterfillMedia();
        }
    }

    public function saveData()
    {
        if (method_exists($this, 'beforeSaveData')) {
            $this->beforeSaveData();
        }
        $this->model()->fill($this->only($this->fillable_data));
        $this->model()->save();
        if (method_exists($this, 'afterSaveData')) {
            $this->afterSaveData();
        }
    }
    public function saveMeta()
    {
        if (method_exists($this, 'beforeSaveMeta')) {
            $this->beforeSaveMeta();
        }
        if (method_exists($this->model(), 'saveMetas')) {
            $this->model()->saveMetas($this->only($this->fillable_meta));
        }
        if (method_exists($this, 'afterSaveMeta')) {
            $this->afterSaveMeta();
        }
    }
    public function saveMedia()
    {
        if (method_exists($this, 'beforeSaveMedia')) {
            $this->beforeSaveMedia();
        }
        if (method_exists($this->model(), 'addMedia')) {
            foreach ($this->fillable_media as $property) {
                $files = $this->pull($property);
                if (is_temporary_file($files)) {
                    $this->model()->addMedia($files)->toMediaCollection($property);
                } elseif (is_temporary_files($files)) {
                    foreach ($files as $file) {
                        $this->model()->addMedia($file)->toMediaCollection($property);
                    }
                }
            }
        }
        if (method_exists($this, 'afterSaveMedia')) {
            $this->afterSaveMedia();
        }
    }

    #[Computed]
    public function saved()
    {
        return !empty($this->model()?->id);
    }
    public function save()
    {
        if (method_exists($this, 'beforeSave')) {
            $this->beforeSave();
        }
        $this->validate();
        try {
            $this->saveData();
            $this->saveMeta();
            $this->saveMedia();
            if (method_exists($this, 'afterSave')) {
                $this->afterSave();
            }
            session()->flash($this->status_key, __('Saved'));
        } catch (\Exception $e) {
            $this->addError($this->status_key, $e->getMessage());
        }
    }
}

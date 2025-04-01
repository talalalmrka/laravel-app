<?php

namespace App\Livewire\Components;

use Livewire\Component;
use Livewire\Attributes\Locked;
use App\Traits\HasMediaProperties;
use App\Traits\WithToast;
use Livewire\Attributes\Computed;
use Livewire\WithFileUploads;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Post;
use App\Models\Meta;

abstract class EditModel extends Component
{
    use WithFileUploads, HasMediaProperties, WithToast;
    public $model;
    protected $fillable_data;
    protected $fillable_meta;
    protected $fillable_media;
    protected $status_key = 'status';
    public function mount($model)
    {
        if (method_exists($this, 'beforeMount')) {
            $this->beforeMount();
        }
        $this->model = $model;
        if (method_exists($this, 'beforeFill')) {
            $this->beforeFill();
        }
    }

    public function fillData()
    {
        if (method_exists($this, 'beforeFillData')) {
            $this->beforeFillData();
        }
        $this->fill($this->model->only($this->fillable_data));
        if (method_exists($this, 'afterFillData')) {
            $this->afterFillData();
        }
    }
    public function fillMeta()
    {
        if (method_exists($this, 'beforeFillMeta')) {
            $this->beforeFillMeta();
        }
        if (method_exists($this->model, 'getMetas')) {
            $this->fill($this->model->getMetas($this->fillable_meta));
        }
        if (method_exists($this, 'afterFillMeta')) {
            $this->afterFillMeta();
        }
    }
    public function getPreviews($property)
    {
        return previews($this->model->getMedia($property), $this->$property)->toArray();
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
        $this->model->fill($this->only($this->fillable_data));
        $this->model->save();
        if (method_exists($this, 'afterSaveData')) {
            $this->afterSaveData();
        }
    }
    public function saveMeta()
    {
        if (method_exists($this, 'beforeSaveMeta')) {
            $this->beforeSaveMeta();
        }
        if (method_exists($this->model, 'saveMetas')) {
            $this->user->saveMetas($this->only($this->fillable_meta));
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
        if (method_exists($this->model, 'addMedia')) {
            foreach ($this->fillable_media as $property) {
                $files = $this->pull($property);
                if (is_temporary_file($files)) {
                    $this->model->addMedia($files)->toMediaCollection($property);
                } elseif (is_temporary_files($files)) {
                    foreach ($files as $file) {
                        $this->model->addMedia($file)->toMediaCollection($property);
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
        return !empty($this->model?->id);
    }
    public function save()
    {
        $this->validate();
        try {
            $this->saveData();
            $this->saveMeta();
            $this->saveMedia();
            session()->flash($this->status_key, __('Saved'));
        } catch (\Exception $e) {
            $this->addError($this->status_key, $e->getMessage());
        }
    }
}

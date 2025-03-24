<?php

namespace App\Traits;
use Livewire\Attributes\On;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
/*
trait WithDeleteMedia
{
    use WithToast;
    public function deleteMedia($id)
    {
        try {
            $media = Media::find($id);
            if ($media) {
                $delete = $media->delete();
                if ($delete) {
                    $this->toastSuccess(__(':name deleted.', ['name' => $media->name]));
                } else {
                    $this->toastError(__('Failed to delete :name!', ['name' => $media->name]));
                }
            } else {
                $this->toastError(__('Media not found!'));
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }

    public function deletePreview($property, $index)
    {
        try {
            if (is_array($this->{$property})) {
                unset($this->{$property}[$index]);
            } else {
                $this->reset($property);
            }
            //$this->updated($property);
        } catch (\Exception $e) {
            $this->addError($property, $e->getMessage());
        }
    }
    #[On('delete-media')]
    public function onDeleteMedia($property, $index = 0)
    {
        $media = $this->{$property};

        if (is_media_item($media)) {
            $media->delete();
        } elseif (is_temporary_file($media)) {
            $media->delete();
        } elseif (is_temporary_files($media)) {
            $item = data_get($media, $index);
            $item->delete();
        } elseif (is_media_collection($media)) {
            $item = data_get($media, $index);
            $item->delete();
        }
        //dd($media);
        //dd($property, $index);
        $this->toastSuccess(__('Media deleted successfully prop: :prop, index: :index.', ['prop' => $property, 'index' => $index]));
        //dd($media->toArray());
        //$this->toast()
    }
}*/

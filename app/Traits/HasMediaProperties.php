<?php

namespace App\Traits;

use Fgx\MediaPreviews;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Renderless;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMediaProperties
{
    use WithToast;
    #[Computed]
    public function getPreviews($property, $model = null)
    {
        $arr = [];

        //$previews = new MediaPreviews;
        if ($model) {
            //$previews->push($model->getMedia($property));
            $medias = $model->getMedia($property);
            if ($medias && $medias->isNotEmpty()) {
                foreach ($medias as $media) {
                    $arr[] = preview($media)->toArray();
                }
            }
        }
        $files = $this->{$property};
        if (is_temporary_files($files)) {
            foreach ($files as $file) {
                $arr[] = preview($file)->toArray();
            }
        } elseif (is_temporary_file($files)) {
            $arr[] = preview($files)->toArray();
        }
        return $arr;
        //$previews->push($this->{$property});
        //return $previews;
    }
    #[On('delete-media')]
    public function onDeleteMedia($id)
    {
        //$this->authorize('edit_profile');
        try {
            $delete = Media::destroy($id);
            if ($delete) {
                $this->toastSuccess(__('Media deleted'));
                $this->dispatch('media-deleted', $id);
            } else {
                $this->toastError(__('Delete failed :id'));
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }
    /*public function getPreview($property, $index)
    {
        $previews = $this->getPreviews($property);
        return $previews->get($index);

    }
    #[On('delete-media')]
    public function onDeleteMedia(string $property, int $index)
    {
        try {
            $item = $this->getPreview($property, $index);
            $media = $item->media;
            $value = $this->{$property};
            if ($media instanceof TemporaryUploadedFile) {
                if (is_array($value)) {
                    $collection = collect($this->{$property});
                    $mediaIndex = $collection->search(fn($file) => $file->getClientOriginalName() === $item->id);
                    unset($this->{$property}[$mediaIndex]);
                    $media->delete();
                } else {
                    $this->reset($property);
                    $media->delete();
                }
            } elseif (is_media($media)) {
                $media->delete();
            } else {
                $this->toastError(__('Media not found!'));
            }
        } catch (Exception $e) {
            $this->toastError($e->getMessage());
        }
    }*/
}

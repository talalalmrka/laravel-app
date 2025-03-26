<?php
namespace App\Traits;

use Livewire\Attributes\Computed;
use App\MediaPreviews;
trait HasMediaProperties
{
    use WithToast;
    public function getPreviews($property, $model = null)
    {
        $previews = new MediaPreviews();
        if($model){
            $previews->push($model->getMedia($property));
        }
        $previews->push($this->{$property});
        return $previews;
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

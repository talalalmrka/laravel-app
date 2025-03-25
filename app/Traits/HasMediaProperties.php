<?php
namespace App\Traits;

use App\MediaPreviewCollection;
use Exception;
use App\MediaPreview;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
trait HasMediaProperties
{
    public function getPreviews($property, $model = null)
    {
        return MediaPreviewCollection::make(
            $model->getMedia($property),
            $this->{$property}
        );
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

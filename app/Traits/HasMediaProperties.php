<?php

namespace App\Traits;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMediaProperties
{
    use WithFileUploads, WithToast;
    #[On('delete-media')]
    public function onDeleteMedia($id)
    {
        try {
            $delete = Media::destroy($id);
            if ($delete) {
                $this->toastSuccess(__('Media deleted'));
                $this->dispatch('media-deleted', $id);
            } else {
                $this->toastError(__('Delete failed :id', ['id' => $id]));
            }
        } catch (\Exception $e) {
            $this->toastError($e->getMessage());
        }
    }
}

<?php

namespace App\Livewire\Dashboard\Profile;

use App\MediaPreviewCollection;
use App\Models\User;
use App\Traits\HasMediaProperties;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\On;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Livewire\WithFileUploads;
use App\Traits\WithToast;
use Livewire\Attributes\Renderless;

class Images extends Component
{
  use WithFileUploads, HasMediaProperties, WithToast;
  #[Locked]
  public User $user;
  #[Validate]
  public $images = [];
  #[Validate]
  public $avatar;
  #[Validate]
  public $files = [];
  public function mount(User $user)
  {
    $this->user = $user;
  }

  public function rules()
  {
    return [
      'images' => ['nullable', 'array'],
      'images.*' => ['nullable', 'image', 'max:4096'],
      'avatar' => ['nullable', 'image', 'max:4096'],
      'files' => ['nullable', 'array'],
      'files.*' => ['nullable', 'file', 'max:4096'],
      'avatar' => ['nullable', 'image', 'max:4096'],
    ];
  }

  public function saveAvatar() {
    try{
      $avatar = $this->pull('avatar');
      if($avatar){
        $this->user->addMedia($avatar)->toMediaCollection('avatar');
      }
    }catch(\Exception $e){
        $this->addError('avatar', $e->getMessage());
    }

  }
  public function saveImages() {
    try{
        $images = $this->pull('images');
        if($images){
            foreach ($images as $image) {
                $this->user->addMedia($image)->toMediaCollection('images');
            }
        }
    }catch(\Exception $e){
        $this->addError('images', $e->getMessage());
    }

  }
  public function saveFiles() {
    try{
        $files = $this->pull('files');
        if($files){
            foreach ($files as $file) {
                $this->user->addMedia($file)->toMediaCollection('files');
            }
        }
    }catch(\Exception $e){
        $this->addError('files', $e->getMessage());
    }

  }
  //#[Renderless]
  public function save()
  {
    $this->validate();
    $this->saveAvatar();
    $this->saveImages();
    $this->saveFiles();
    session()->flash('status', __('Saved'));
  }
  #[On('delete-media')]
  public function onDeleteMedia($id)
  {
    try {
      $this->user->deleteMedia($id);
      //$this->dispatch('media-deleted', ['id' => $id]);
      $this->dispatch('media-deleted', $id);
      $this->toastSuccess(__('Media deleted'));
    } catch (\Exception $e) {
      $this->toastError($e->getMessage());
    }
  }
  public function loadPreviews($property) {
    return $this->getPreviews($property, $this->user)->toArray();
  }
  public function render()
  {
    return view('livewire.dashboard.profile.images', [
      'imagesPreviews' => $this->getPreviews('images', $this->user),
      'avatarPreviews' => $this->getPreviews('avatar', $this->user),
      'filesPreviews' => $this->getPreviews('files', $this->user),
    ]);
  }
}

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
class Images extends Component
{
  use WithFileUploads, HasMediaProperties, WithToast;
  #[Locked]
  public User $user;
  #[Validate]
  public $images = [];
  #[Validate]
  public $avatar;
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
    ];
  }
  public function save()
  {
    $this->validate();
    $this->toastSuccess('save in progress');
    try {
      foreach ($this->images as $image) {
        $this->user->addMedia($image)->toMediaCollection('images');
      }
      $this->reset('images');
      if($this->avatar){
        $this->user->addMedia($this->pull('avatar'))->toMediaCollection('avatar');
      }
      session()->flash('status', __('Saved.'));
    } catch (\Exception $e) {
      $this->addError('status', $e->getMessage());
    }
  }
  #[On('delete-media')]
  public function onDeleteMedia($id)
  {
    try {
      $this->user->deleteMedia($id);
      $this->dispatch('media-deleted', ['id' => $id]);
      $this->toastSuccess(__('Media deleted'));
    } catch (\Exception $e) {
      $this->toastError($e->getMessage());
    }
  }
  public function render()
  {
    return view('livewire.dashboard.profile.images', [
      'imagesPreviews' => $this->getPreviews('images', $this->user),
      'avatarPreviews' => $this->getPreviews('avatar', $this->user),
    ]);
  }
}

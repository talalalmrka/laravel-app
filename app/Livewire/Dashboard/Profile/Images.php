<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use App\Traits\HasMediaProperties;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Livewire\WithFileUploads;

class Images extends Component
{
  use WithFileUploads, HasMediaProperties;
  #[Locked]
  public User $user;
  #[Validate]
  public $images = [];
  //public $previews;
  public function mount(User $user)
  {
    $this->user = $user;
  }

  public function rules()
  {
    return [
      'images' => ['required', 'array'],
      'images.*' => ['required', 'image', 'max:4096'],
    ];
  }
  public function save()
  {
    $this->validate();
    try {
      foreach ($this->images as $image) {
        $this->user->addMedia($image)->toMediaCollection('images');
      }
      session()->flash('status', __('Saved.'));
    } catch (\Exception $e) {
      $this->addError('status', $e->getMessage());
    }
  }
  public function previews($property)
  {
    return $this->getPreviews($property, $this->user);
  }

  public function deleteMedia(Media $media)
  {
    $delete = $media->delete();
  }
  public function render()
  {
    return view('livewire.dashboard.profile.images', [
      'images_previews' => $this->previews('images'),
    ]);
  }
}

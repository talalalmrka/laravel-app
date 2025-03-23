<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Livewire\WithFileUploads;

class Images extends Component
{
  use WithFileUploads;
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
        try{
          foreach ($this->images as $image){
            $this->user->addMedia($image)->toMediaCollection('images');
          }
          session()->flash('status', __('Saved.'));
        }catch(Exception $e){
          $this->addError('status', $e->getMessage());
        }
    }
    public function getPreviews(){
      return $this->user->getMedia('images')->map(function(Media $media){
        return [
          'id' => $media->id,
          'name' => $media->name,
          'type' => $media->type,
          'size' => $media->size,
          'url' => $media->original_url,
        ];
      })->toArray();
      //return $this->user->getMedia('images')->map->toArray(),
    }
    
    public function deleteMedia(Media $media){
      $delete = $media->delete();
    }
    public function render()
    {
        return view('livewire.dashboard.profile.images', [
          'previews' => $this->getPreviews(),
        ]);
    }
}

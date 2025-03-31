<?php

namespace App\Livewire\Site;

use App\Models\User;
use App\Traits\HasMediaProperties;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Traits\WithToast;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Upload extends Component
{
    use WithFileUploads, HasMediaProperties, WithToast;
    #[Locked]
    public User $user;
    #[Validate]
    public $avatar;
    #[Validate]
    public $images = [];
    #[Validate]
    public $files = [];
    public function mount()
    {
        $this->user = auth()->user();
    }

    public function rules()
    {
        return [
            'avatar' => ['nullable', 'image', 'max:4096'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'max:4096'],
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'file', 'max:100000'],
        ];
    }
    public function saveAvatar() {
        try {
            $avatar = $this->pull('avatar');
            if ($avatar) {
                $this->user->addMedia($avatar)->toMediaCollection('avatar');
            }
            session()->flash('avatar', __('Saved'));
        } catch (\Exception $e) {
            $this->addError('avatar', $e->getMessage());
        }
    }
    public function saveImages() {
        try {
            $images = $this->pull('images');
            if ($images) {
                foreach ($images as $image) {
                    $this->user->addMedia($image)->toMediaCollection('images');
                }
            }
            session()->flash('images', __('Saved'));
        } catch (\Exception $e) {
            $this->addError('images', $e->getMessage());
        }
    }
    public function saveFiles() {
        try {
            $files = $this->pull('files');
            if ($files) {
                foreach ($files as $file) {
                    $this->user->addMedia($file)->toMediaCollection('files');
                }
            }
            session()->flash('files', __('Saved'));
        } catch (\Exception $e) {
            $this->addError('files', $e->getMessage());
        }
    }
    public function save()
    {
        $this->validate();
        $this->saveAvatar();
        $this->saveImages();
        $this->saveFiles();
        session()->flash('status', __('Saved'));
    }

    public function loadPreviews($property)
    {
        return $this->getPreviews($property, $this->user)->toArray();
    }
    public function render()
    {
        return view('livewire.site.upload', [
            'avatarPreviews' => $this->getPreviews('avatar', $this->user),
            'imagesPreviews' => $this->getPreviews('images', $this->user),
            'filesPreviews' => $this->getPreviews('files', $this->user),
        ]);
    }
}

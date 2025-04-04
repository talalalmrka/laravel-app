<?php

namespace App\Livewire\Dashboard\Media;

use App\Models\User;
use App\Traits\HasMediaProperties;
use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Create extends Component
{
    use HasMediaProperties;
    public User $user;
    public $files = [];
    public $show = false;
    public function mount()
    {
        $this->authorize('manage_media');
        $this->user = auth()->user();
    }
    public function rules()
    {
        return [
            'files' => ['required', 'array'],
            'files.*' => ['required', 'file'],
        ];
    }
    public function updatedFiles()
    {
        $this->save();
    }
    public function save()
    {
        $this->authorize('manage_media');
        $this->validate();
        $files = $this->pull('files');
        if (!empty($files)) {
            foreach ($files as $file) {
                $this->user->addMedia($file)->toMediaCollection('files');
            }
            $this->show = false;
            $this->dispatch('saved', 'media');
        }
    }
    #[On('create-media')]
    public function onCreateMedia()
    {
        $this->show = true;
    }
    public function render()
    {
        return view('livewire.dashboard.media.create', [
            'filesPreviews' => previews($this->files),
        ]);
    }
}

<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Avatar extends Component
{
    use WithFileUploads;
    #[Locked]
    public User $user;
    #[Validate]
    public $avatar;
    public function rules()
    {
        return [
            'avatar' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
    public function updatedAvatar()
    {
        $this->validateOnly('avatar');
        if (!empty($this->avatar)) {
            $update = $this->user->addMedia($this->pull('avatar'))->toMediaCollection('avatar');
            if ($update) {
                session()->flash('status', __('Avatar updated.'));
            } else {
                $this->addError('status', __('Faild to update avatar!'));
            }
        }
    }
    public function deleteAvatar()
    {
        $delete = $this->user->clearMediaCollection('avatar');
        if ($delete) {
            session()->flash('status', __('Avatar deleted.'));
        } else {
            $this->addError('status', __('Faild to delete avatar!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.profile.avatar');
    }
}

<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class About extends Component
{
    #[Locked]
    public User $user;
    #[Validate]
    public $birth;
    #[Validate]
    public $about;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->fill($this->user->getMetas('birth', 'about'));
    }
    public function rules()
    {
        return [
            'birth' => ['nullable', 'date'],
            'about' => ['nullable', 'string', 'max:2048'],
        ];
    }
    public function save()
    {
        $this->validate();
        $save = $this->user->saveMetas($this->only('birth', 'about'));
        if ($save) {
            session()->flash('status', __('Saved.'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.profile.about');
    }
}

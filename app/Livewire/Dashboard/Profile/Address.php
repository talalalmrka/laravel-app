<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Address extends Component
{
    #[Locked]
    public User $user;
    #[Validate]
    public $street;
    #[Validate]
    public $city;
    #[Validate]
    public $state;
    #[Validate]
    public $zipcode;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->fill($this->user->getMetas('street', 'city', 'state', 'zipcode'));
    }
    public function rules()
    {
        return [
            'street' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:250'],
            'state' => ['nullable', 'string', 'max:250'],
            'zipcode' => ['nullable', 'string', 'max:250'],
        ];
    }
    public function save()
    {
        $this->validate();
        $save = $this->user->saveMetas($this->only(['street', 'city', 'state', 'zipcode']));
        if ($save) {
            session()->flash('status', __('Saved.'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.profile.address');
    }
}

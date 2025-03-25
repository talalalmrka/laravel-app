<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AccountDetails extends Component
{
    #[Locked]
    public User $user;
    #[Validate]
    public $name;
    #[Validate]
    public $email;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->fill($user->only(['name', 'email']));
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:250', Rule::unique('users', 'name')->ignore($this->user->id)],
            'email' => ['required', 'email', 'max:250', Rule::unique('users', 'email')->ignore($this->user->id)],
        ];
    }
    public function save()
    {
        $this->validate();
        $this->user->fill($this->only(['name', 'email']));
        $save = $this->user->save();
        if ($save) {
            session()->flash('status', __('Saved.'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.profile.account-details');
    }
}

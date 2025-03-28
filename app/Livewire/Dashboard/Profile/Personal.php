<?php

namespace App\Livewire\Dashboard\Profile;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
class Personal extends Component
{
    #[Locked]
    public User $user;
    #[Validate]
    public $first_name;
    #[Validate]
    public $last_name;
    #[Validate]
    public $display_name;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->fill($this->user->getMetas('first_name', 'last_name', 'display_name'));
    }
    public function rules()
    {
        return [
            'first_name' => ['nullable', 'string', 'max:250'],
            'last_name' => ['nullable', 'string', 'max:250'],
            'display_name' => ['nullable', 'string', 'max:250'],
        ];
    }
    public function save()
    {
        $this->validate();
        $save = $this->user->saveMetas($this->only(['first_name', 'last_name', 'display_name']));
        if ($save) {
            session()->flash('status', __('Saved.'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.profile.personal');
    }
}

<?php

namespace App\Livewire\Dashboard\Profile;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Milwad\LaravelValidate\Rules\ValidPhoneNumber;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class Admin extends Component
{
    #[Locked]
    public User $user;
    #[Validate]
    public $roles;
    public function mount(User $user)
    {
        $this->user = $user;
        $this->roles = $this->user->getRoleNames()->toArray();
    }
    public function role_options()
    {
        $roles = Role::where('guard_name', config('auth.defaults.guard', 'web'))->get();
        return $roles->map(function (Role $role) {
            return [
                'label' => $role->name,
                'value' => $role->name,
            ];
        })->toArray();
    }
    public function rules()
    {
        return [
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string', Rule::exists('roles', 'name')->where('guard_name', config('auth.defaults.guard', 'web'))],
        ];
    }
    public function save()
    {
        $this->authorize('manage users');
        $this->validate();
        $save = $this->user->syncRoles($this->roles);
        if ($save) {
            session()->flash('status', __('Saved.'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.profile.admin',[
            'options' => $this->role_options(),
        ]);
    }
}

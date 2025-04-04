<?php

namespace App\Livewire\Dashboard\Roles;

use App\Traits\WithEditModelDialog;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

class Edit extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'role';
    #[Locked]
    public Role $role;
    public $name = '';
    public $guard_name = 'web';
    public $permissions = [];
    protected $fillable_data = ['name', 'guard_name'];
    public function mount(Role $role)
    {
        $this->authorize('manage_roles');
        $this->role = $role;
    }
    public function afterFill()
    {
        $this->permissions = $this->role->getPermissionNames()->toArray();
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->where('guard_name', $this->guard_name)->ignore($this->role)],
            'guard_name' => ['required', 'string', Rule::in(array_keys(config('auth.guards')))],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['nullable', 'string', Rule::exists('permissions', 'name')->where('guard_name', $this->guard_name)],
        ];
    }
    public function afterSave()
    {
        $this->role->syncPermissions($this->permissions);
    }
}

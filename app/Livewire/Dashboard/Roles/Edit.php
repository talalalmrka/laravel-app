<?php

namespace App\Livewire\Dashboard\Roles;

use App\Traits\WithEditModel;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'role';
    public ?Role $role;
    public $name;
    public $guard_name;
    public $permissions;

    protected $fillable_data = ['name', 'guard_name'];
    public function mount(?Role $role)
    {
        $this->role = $role;
    }
    public function afterFill() {
        $this->permissions = $this->role->getPermissionNames()->toArray();
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->where('guard_name', $this->guard_name)->ignore($this->role)],
            'guard_name' => ['required', 'string', Rule::in(array_keys(config('auth.guards')))],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['nullable', 'string', Rule::exists('permissions', 'name')->where('guard_name', $this->guard_name)],
        ];
    }
    public function afterSave() {
        $this->role->syncPermissions($this->permissions);
        if ($this->role && url()->current() !== route('dashboard.roles.edit', $this->role)) {
            $this->redirect(route('dashboard.roles.edit', $this->role), true);
        }
    }
}

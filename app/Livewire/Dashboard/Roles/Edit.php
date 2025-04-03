<?php

namespace App\Livewire\Dashboard\Roles;

use App\Traits\WithEditModel;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'role';
    public Role $role;
    public $closeAfterSave = true;
    public $show = false;
    public $title = '';
    public $name = '';
    public $guard_name = 'web';
    public $permissions = [];

    protected $fillable_data = ['name', 'guard_name'];
    public function mount(Role $role)
    {
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
        if ($this->closeAfterSave) {
            $this->show = false;
        }
    }
    public function updatedShow($value)
    {
        if (!$value) {
            $this->reset();
        }
    }
    #[On('edit-role')]
    public function onEdit($id = null)
    {
        $item = $id ? Role::find($id) : new Role;
        $this->mount($item);
        $this->mountWithEditModel();
        $this->show = true;
    }
    public function render()
    {
        return view('livewire.dashboard.roles.edit-modal');
    }
}

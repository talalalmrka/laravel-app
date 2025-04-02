<?php

namespace App\Livewire\Dashboard\Permissions;

use App\Traits\WithEditModel;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'permission';
    public ?Permission $permission;
    public $name;
    public $guard_name;
    protected $fillable_data = ['name', 'guard_name'];
    public function mount(?Permission $permission)
    {
        $this->permission = $permission;
    }
    public function rules()
    {
        return [
            "name" => ["required", "string", "max:255", Rule::unique("permissions", "name")->where('guard_name', $this->guard_name)->ignore($this->permission)],
            "guard_name" => ["required", "string", Rule::in(array_keys(config("auth.guards")))],
        ];
    }
    public function afterSave()
    {
        if ($this->permission && url()->current() !== route('dashboard.permissions.edit', $this->permission)) {
            $this->redirect(route('dashboard.permissions.edit', $this->permission), true);
        }
    }

}

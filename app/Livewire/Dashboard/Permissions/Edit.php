<?php

namespace App\Livewire\Dashboard\Permissions;

use App\Traits\WithEditModelDialog;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;

class Edit extends Component
{
    use WithEditModelDialog;
    protected $model_type = 'permission';
    #[Locked]
    public Permission $permission;
    public $title = '';
    public $name = '';
    public $guard_name = 'web';

    protected $fillable_data = ['name', 'guard_name'];
    public function mount(Permission $permission)
    {
        $this->authorize('manage_permissions');
        $this->permission = $permission;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->where('guard_name', $this->guard_name)->ignore($this->permission)],
            'guard_name' => ['required', 'string', Rule::in(array_keys(config('auth.guards')))],
        ];
    }
}

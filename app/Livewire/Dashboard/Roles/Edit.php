<?php

namespace App\Livewire\Dashboard\Roles;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Edit extends Component
{
    public $title;
    public ?Role $role;
    #[Validate]
    public $name;
    #[Validate]
    public $guard_name;
    #[Validate]
    public $permissions;
    public function mount(?Role $role)
    {
        $this->title = $role->id ? __('Edit role :name', ['name' => $this->name]) : __('Create role');
        $this->role = $role;
        $this->fill($this->role->only(['name', 'guard_name']));
        $this->permissions = $this->role->getPermissionsIds()->toArray();
    }
    public function guard_name_options()
    {
        $options = [];
        foreach (config('auth.guards') as $key => $value) {
            $options[] = [
                'label' => $key,
                'value' => $key,
            ];
        }
        return $options;
    }
    public function permission_options()
    {
        $permissions = Permission::where('guard_name', $this->guard_name)->get();
        return $permissions->map(function (Permission $permission) {
            return [
                'label' => $permission->name,
                'value' => $permission->id,
            ];
        })->toArray();
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->role?->id)],
            'guard_name' => ['required', 'string', Rule::in(array_keys(config('auth.guards')))],
        ];
    }
    public function save()
    {
        $this->validate();
        $this->role->fill($this->only(['name', 'guard_name']));
        $save = $this->role->save();
        if ($save) {
            session()->flash('status', __('Role saved.'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.roles.edit', [
            'guard_name_options' => $this->guard_name_options(),
            'permission_options' => $this->permission_options(),
        ])->layout('layouts.dashboard', [
                    'title' => $this->title,
                ]);
    }
}

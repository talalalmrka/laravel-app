<?php

namespace App\Livewire\Dashboard\Permissions;

use App\Traits\WithEditModel;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class Edit extends Component
{
    use WithEditModel;
    protected $model_type = 'permission';
    public Permission $permission;
    public $closeAfterSave = true;
    public $show = false;
    public $title = '';
    public $name = '';
    public $guard_name = 'web';

    protected $fillable_data = ['name', 'guard_name'];
    public function mount(Permission $permission)
    {
        $this->permission = $permission;
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->where('guard_name', $this->guard_name)->ignore($this->permission)],
            'guard_name' => ['required', 'string', Rule::in(array_keys(config('auth.guards')))],
        ];
    }
    public function afterSave()
    {
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
    #[On('edit-permission')]
    public function onEdit($id = null)
    {
        $item = $id ? Permission::find($id) : new Permission();
        $this->mount($item);
        $this->mountWithEditModel();
        $this->show = true;
    }
    public function render()
    {
        return view('livewire.dashboard.permissions.edit');
    }
}

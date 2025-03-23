<?php

namespace App\Livewire\Dashboard\Roles;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class Index extends Component
{
    public $title;
    public $selected = [];
    public $action;
    public function mount()
    {
        $this->title = __('Roles');
    }
    public function roles()
    {
        return Role::paginate();
    }
    public function edit(Role $role)
    {
        $this->redirect(route('dashboard.roles.edit', $role), true);
    }
    public function delete(Role $role)
    {
        $delete = $role->delete();
        if ($delete) {
            session()->flash('status', __('Delete success.'));
        } else {
            $this->addError('status', __('Delete failed!'));
        }
    }
    public function doAction()
    {
        dd('action', $this->action, 'selected', $this->selected);
    }
    public function render()
    {
        return view('livewire.dashboard.roles.index', [
            'roles' => $this->roles(),
        ])->layout('layouts.dashboard', [
                    'title' => $this->title,
                ]);
    }
}

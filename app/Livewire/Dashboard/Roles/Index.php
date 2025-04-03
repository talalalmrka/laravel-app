<?php

namespace App\Livewire\Dashboard\Roles;

use App\Livewire\Components\Datatable\Datatable;
use App\Livewire\Components\Datatable\Columns\Column;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class Index extends Datatable
{
    //public Role $role;
    //public $showModal = false;
    public function builder()
    {
        return Role::query();
    }

    public function getColumns()
    {
        return [
            column('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('guard_name')
                ->label(__('Guard name'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center'),
            column('permissions')
                ->label(__('Permissions'))
                ->content(function (Role $role) {
                    return view('livewire.components.datatable.permissions', [
                        'role' => $role,
                    ]);
                }),
        ];
    }
    public function edit($id)
    {
        $this->dispatch('edit-role', $id);
    }
    public function create()
    {
        $this->dispatch('edit-role');
    }
    public function render()
    {
        return view('livewire.dashboard.roles.index')->layout('layouts.dashboard', [
            'title' => __('Roles'),
        ]);
    }
}

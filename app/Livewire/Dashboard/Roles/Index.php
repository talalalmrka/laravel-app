<?php

namespace App\Livewire\Dashboard\Roles;

use App\Livewire\Components\Datatable\Datatable;
use App\Livewire\Components\Datatable\Columns\Column;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class Index extends Datatable
{
    public function builder()
    {
        return Role::query();
    }

    public function getColumns()
    {
        return [
            Column::make('name')
                ->label(__('Name'))
                ->sortable()
                ->searchable()
                ->filterable(),
            Column::make('guard_name')
                ->label(__('Guard name'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->class('text-center'),
            Column::make('permissions')
                ->label(__('Permissions'))
                ->content(function (Role $role) {
                    return view('livewire.components.datatable.badges-cell', [
                        'items' => $role->getPermissionNames()->toArray(),
                    ]);
                }),
        ];
    }
    public function create()
    {
        $this->redirect(route('dashboard.roles.create'), true);
    }
    public function edit(Role $role)
    {
        $this->redirect(route('dashboard.roles.edit', $role), true);
    }
    public function delete(Role $role)
    {
        $role->delete();
        $this->toastSuccess(__('Role deleted'));
        //session()->flush('status', __('Role deleted'));
        //$this->redirect(route('dashboard.roles'), true);
    }
    public function render()
    {
        return view('livewire.dashboard.roles.index', [
            //'posts' => Post::where('type', 'post')->paginate(),
        ])->layout('layouts.dashboard', [
            'title' => __('Roles'),
        ]);
    }
}

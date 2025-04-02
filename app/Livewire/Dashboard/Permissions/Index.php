<?php

namespace App\Livewire\Dashboard\Permissions;

use App\Livewire\Components\Datatable\Datatable;
use App\Livewire\Components\Datatable\Columns\Column;
use Spatie\Permission\Models\Permission;


class Index extends Datatable
{
    public function builder()
    {
        return Permission::query();
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
        ];
    }
    public function create()
    {
        $this->redirect(route('dashboard.permissions.create'), true);
    }
    public function edit(Permission $permission)
    {
        $this->redirect(route('dashboard.permissions.edit', $permission), true);
    }
    public function delete(Permission $permission)
    {
        $permission->delete();
        $this->toastSuccess(__('Permission deleted'));
    }
    public function render()
    {
        return view('livewire.dashboard.permissions.index')->layout('layouts.dashboard', [
            'title' => __('Permissions'),
        ]);
    }
}

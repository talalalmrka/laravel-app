<?php

namespace App\Livewire\Dashboard\Permissions;

use App\Livewire\Components\Datatable\Datatable;
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
        ];
    }
    public function edit($id)
    {
        $this->dispatch('edit', 'permission', $id);
    }
    public function create()
    {
        $this->dispatch('edit', 'permission');
    }
    public function render()
    {
        return view('livewire.dashboard.permissions.index')->layout('layouts.dashboard', [
            'title' => __('Permissions'),
        ]);
    }
}

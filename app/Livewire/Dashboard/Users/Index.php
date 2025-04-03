<?php

namespace App\Livewire\Dashboard\Users;

use App\Livewire\Components\Datatable\Columns\Column;
use App\Livewire\Components\Datatable\Datatable;
use App\Models\User;

class Index extends Datatable
{
    public function builder()
    {
        return User::query();
    }
    public function getColumns()
    {
        return [
            column('id')
                ->label(__('Id'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('name')
                ->label(__('Name'))
                ->sortable()
                ->content(function (User $user) {
                    return thumbnail([
                        'title' => $user?->display_name,
                        'image' => $user?->getFirstMediaUrl('avatar'),
                    ]);
                }),
            column('email')
                ->label(__('Email'))
                ->sortable()
                ->searchable()
                ->filterable(),
            column('role')
                ->label(__('Role'))
                ->sortable()
                ->searchable()
                ->filterable()
                ->content(function (User $user) {
                    return view('livewire.components.datatable.roles', ['user' => $user]);
                }),
        ];
    }
    public function edit($id)
    {
        $this->redirect(route('dashboard.profile', $id), true);
    }

    public function render()
    {
        return view('livewire.dashboard.users.index')->layout('layouts.dashboard', [
            'title' => __('Users'),
        ]);
    }
}

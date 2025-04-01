<?php

use App\Livewire\Components\EditModel;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(EditModel::class)
        ->assertStatus(200);
});

<?php

namespace App\Livewire\Dashboard\Home;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Component;
class Index extends Component
{
    public $title;
    public function mount()
    {
        $this->title = __('Dashboard');
    }
    public function render()
    {
        return view('livewire.dashboard.home.index', [
            'usersCount' => User::all()->count(),
            'viewsToday' => '10.7 K',
            'viewsMonth' => '300.6 K',
            'viewsAll' => '2.4 M',
        ])->layout('layouts.dashboard', [
                    'title' => $this->title,
                ]);
    }
}

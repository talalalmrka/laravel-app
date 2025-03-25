<?php

namespace App\Livewire\Dashboard\Profile;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Component;
class Index extends Component
{
    #[Locked]
    public User $user;
    public $title;
    public function mount($user = null)
    {
        $this->user = $user ?? auth()->user();
        $this->title = __('Profile (:name)', ['name' => $this->user->name]);
    }
    public function render()
    {
        return view('livewire.dashboard.profile.index')->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}

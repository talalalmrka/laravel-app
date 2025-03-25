<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
  use WithPagination;
    public $title;
    public $selected = [];
    public $action;
    public function mount()
    {
        $this->title = __('Users');
    }
    public function users()
    {
        return User::paginate();
    }
    public function edit(User $user)
    {
        $this->redirect(route('dashboard.profile', $user), true);
    }
    public function delete(User $user)
    {
        $delete = $user->delete();
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
        return view('livewire.dashboard.users.index', [
            'users' => $this->users(),
        ])->layout('layouts.dashboard', [
                    'title' => $this->title,
                ]);
    }
}

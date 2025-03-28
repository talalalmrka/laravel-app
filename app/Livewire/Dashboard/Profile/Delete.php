<?php

namespace App\Livewire\Dashboard\Profile;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\ValidationException;
use App\Livewire\Actions\Logout;

class Delete extends Component
{
    #[Locked]
    public User $user;
    // #[Validate]
    // public string $password = "";
    #[Validate]
    public bool $confirm = false;
    public function mount(User $user)
    {
        $this->user = $user;
    }
    public function rules()
    {
        return [
            "confirm" => ["required", "accepted"],
        ];
    }
    function isLastAdmin()
    {
        $adminRole = Role::where("name", "admin")->first();

        if (!$adminRole) {
            return false; // No admin role exists
        }

        return $adminRole->users()->count() === 1 &&
            $this->user->hasRole("admin");
    }
    public function delete(Logout $logout)
    {
        $this->Validate();
        if ($this->isLastAdmin()) {
            throw ValidationException::withMessages([
                "status" => [__("You cannot remove the last admin.")],
            ]);
        }
        $deleteSelf = $this->user->id === auth()->user()->id;
        if ($deleteSelf) {
            tap(auth()->user(), $logout(...))->delete();
            $this->redirect("/", navigate: true);
        } else {
            $this->user->delete();
            $this->redirect(route("dashboard.users"), navigate: true);
        }
    }
    public function render()
    {
        return view("livewire.dashboard.profile.delete");
    }
}

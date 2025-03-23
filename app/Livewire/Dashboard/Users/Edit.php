<?php

namespace App\Livewire\Dashboard\Users;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Edit extends Component
{
    public $title;
    public ?User $user;
    #[Validate]
    public $name;
    #[Validate]
    public $email;
    public $password;
    public function mount(?User $user)
    {
        $this->title = $user->id ? __('Edit user :name', ['name' => $this->name]) : __('Create user');
        $this->user = $user;
        $this->fill($this->user->only(['name', 'email']));
    }
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore($this->user?->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user?->id)],
            'password' => [
                'nullable',
                Rule::requiredIf(fn() => empty($this->user->id)),
                'string',
                'max:255',
            ],
        ];
    }
    public function save()
    {
        $validated = $this->validate();
        $props = [
            'name',
            'email',
        ];
        if (empty($this->user->id)) {
            $props[] = 'password';
        }
        $this->user->fill($this->only($props));
        $save = $this->user->save();
        if ($save) {
            session()->flash('status', __('User saved.'));
        } else {
            $this->addError('status', __('Save failed!'));
        }
    }
    public function render()
    {
        return view('livewire.dashboard.users.edit')->layout('layouts.dashboard', [
            'title' => $this->title,
        ]);
    }
}

<?php

namespace App\Livewire\Dashboard\Home;

use Livewire\Component;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
class  Index extends Component
{
  use WithFileUploads;
  public User $user;
  public $name = "";
  public $email = "";
  public $images = [];
  public function moun(){
    $this->user = auth()->user();
    $this->fill($this->only(['name', 'email']));
  }
  
  public function rules(){
    return [
      'name' => ['required', 'string', 'max:255', Rule::unique('users', 'name')->ignore(this->user)],
      'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore(this->user)],
      
      ];
  }
    public function render()
    {
        return view('livewire.dashboard.home.index');
    }
}

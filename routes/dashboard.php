<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Home\Index as Dashboard;
use App\Livewire\Dashboard\Profile\Index as Profile;
Route::group(['prefix' => 'dashboard','middleware' => ['auth']], function (){
  Route::get('/', Dashboard::class)->name('dashboard');
  Route::get('/profile', Profile::class)->name('dashboard.profile');
});
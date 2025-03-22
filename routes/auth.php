<?php
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
Route::group(['middleware' => ['guest']], function () {
  Route::get('login', Login::class)->name('login');
  Route::get('register', Register::class)->name('register');
});
Route::group(['middleware' => ['auth']], function () {
  Route::get('logout', function () {
    Auth::guard('web')->logout();
    Session::invalidate();
    Session::regenerateToken();
    return redirect('/');
  })->name('logout');
});
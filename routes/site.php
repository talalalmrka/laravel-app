<?php
use App\Livewire\Site\Home\Index as Home;
use App\Livewire\Site\Curve\Index as Curve;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('curve', Curve::class)->name('curve');
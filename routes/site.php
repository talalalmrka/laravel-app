<?php
use App\Livewire\Site\Home\Index as Home;
use App\Livewire\Site\Curve\Index as Curve;
use App\Livewire\Site\Posts\Index as BlogPage;
use App\Livewire\Site\Posts\Item as PostPage;
use App\Livewire\Site\Upload;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('curve', Curve::class)->name('curve');
Route::get('blog', BlogPage::class)->name('blog');
Route::get('upload', Upload::class)->name('upload')->middleware(['auth']);
Route::get('{post:slug}', PostPage::class)->name('post');

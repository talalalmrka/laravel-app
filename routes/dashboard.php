<?php

use App\Livewire\Dashboard\Home\Index as DashboardHome;
use App\Livewire\Dashboard\Media\Index as ManageMedia;
use App\Livewire\Dashboard\Profile\Index as Profile;
use App\Livewire\Dashboard\Users\Edit as UsersEdit;
use App\Livewire\Dashboard\Roles\Index as Roles;
//use App\Livewire\Dashboard\Roles\Edit as EditRole;
use App\Livewire\Dashboard\Permissions\Index as Permissions;
//use App\Livewire\Dashboard\Permissions\Edit as EditPermission;
use App\Livewire\Dashboard\Posts\Index as Posts;
use App\Livewire\Dashboard\Posts\Edit as EditPost;

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Users\Index as UsersIndex;

Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'verified']], function () {
    //dashboard home
    Route::get('/', DashboardHome::class)->name('dashboard');

    //profile
    Route::get('profile/{user?}', Profile::class)->name('dashboard.profile')->middleware(['edit_profile']);

    //users
    Route::group(['prefix' => 'users', 'middleware' => ['can:manage_users']], function () {
        Route::get('/', UsersIndex::class)->name('dashboard.users');
        Route::get('edit/{user}', UsersEdit::class)->name('dashboard.users.edit');
        Route::get('create', UsersEdit::class)->name('dashboard.users.create');
    });

    //roles
    Route::group(['prefix' => 'roles', 'middleware' => ['can:manage_roles']], function () {
        Route::get('/', Roles::class)->name('dashboard.roles');
        //Route::get('edit/{role}', EditRole::class)->name('dashboard.roles.edit');
        //Route::get('create', EditRole::class)->name('dashboard.roles.create');
    });

    //permissions
    Route::group(['prefix' => 'permissions', 'middleware' => ['can:manage_permissions']], function () {
        Route::get('/', Permissions::class)->name('dashboard.permissions');
    });

    //posts
    Route::group(['prefix' => 'posts', 'middleware' => ['can:manage_posts']], function () {
        Route::get('/', Posts::class)->name('dashboard.posts');
        Route::get('edit/{post}', EditPost::class)->name('dashboard.posts.edit');
        Route::get('create', EditPost::class)->name('dashboard.posts.create');
    });

    //media
    Route::group(['prefix' => 'media', 'middleware' => ['can:manage_media']], function () {
        Route::get('/', ManageMedia::class)->name('dashboard.media');
    });
});

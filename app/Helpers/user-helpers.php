<?php

use App\Models\User;

if (!function_exists('select_user_options')) {
    function select_user_options()
    {
        $users = User::all();
        return $users->map(function ($user) {
            return [
                'value' => $user->id,
                'label' => $user->name,
            ];
        })->toArray();
    }
}
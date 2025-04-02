<?php
use Spatie\Permission\Models\Role;

if (!function_exists('role_options')) {
    function role_options($guard_name = 'web')
    {
        $roles = Role::where('guard_name', $guard_name)->get();
        return $roles->map(function (Role $role) {
            return [
                'value' => $role->name,
                'label' => $role->name,
            ];
        })->toArray();
    }
}

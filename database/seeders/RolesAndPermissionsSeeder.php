<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function permissions()
    {
        return [
            'web' => [
                'manage_users',
                'manage_roles',
                'manage_permissions',
                'manage_posts',
                'manage_pages',
                'manage_menus',
                'manage_media',
                'manage_settings',
            ],
        ];
    }
    public function roles()
    {
        return [
            'web' => [
                'admin' => 'all',
                'writer' => [
                    'manage_posts',
                    'manage_pages',
                    'manage_menus',
                    'manage_media',
                    'manage_settings',
                ],
                'editor' => [
                    'manage_posts',
                ],
                'member' => [],
            ],
        ];
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        foreach ($this->permissions() as $guard_name => $permissions) {
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => $guard_name,
                ]);
            }
        }
        foreach ($this->roles() as $guard_name => $roles) {
            foreach ($roles as $role_name => $permissions) {
                $role = Role::create([
                    'name' => $role_name,
                    'guard_name' => $guard_name,
                ]);
                if ($role) {
                    $permissions = $permissions === 'all' ? Permission::where('guard_name', $guard_name)->pluck('name')->toArray() : $permissions;
                    $role->syncPermissions($permissions);
                }
            }
        }
    }
}

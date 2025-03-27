<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function permissions() {
        return [
            'web' => [
                'manage users',
                'manage roles',
                'manage permissions',
                'manage posts',
                'manage settings',
            ],
        ];
    }
    public function roles() {
        return [
            'web' => [
                'admin' => 'all',
                'editor' => [
                    'manage posts',
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
        foreach($this->permissions() as $guard_name => $permissions){
            foreach ($permissions as $permission) {
                Permission::create([
                    'name' => $permission,
                    'guard_name' => $guard_name,
                ]);
            }

        }
        foreach($this->roles() as $guard_name => $roles){
            foreach ($roles as $role_name => $permissions) {
                $role = Role::create([
                    'name' => $role_name,
                    'guard_name' => $guard_name,
                ]);
                if($role){
                    $permissions = $permissions === 'all' ? Permission::where('guard_name', $guard_name)->pluck('name')->toArray() : $permissions;
                    $role->syncPermissions($permissions);
                }
            }

        }
    }
}

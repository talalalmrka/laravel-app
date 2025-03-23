<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $manage_users = Permission::create([
            'name' => 'manage users',
            'guard_name' => 'web',
        ]);
        $manage_roles = Permission::create([
            'name' => 'manage roles',
            'guard_name' => 'web',
        ]);
        $manage_permissions = Permission::create([
            'name' => 'manage permissions',
            'guard_name' => 'web',
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);
        $admin->syncPermissions([$manage_users, $manage_roles, $manage_permissions]);

        $moderator = Role::create([
            'name' => 'moderator',
            'guard_name' => 'web',
        ]);
        $moderator->syncPermissions([$manage_users]);

        $member = Role::create([
            'name' => 'member',
            'guard_name' => 'web',
        ]);

    }
}

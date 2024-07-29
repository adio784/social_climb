<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'view admins']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'fund user']);
        Permission::create(['name' => 'make admin']);
        Permission::create(['name' => 'remove admin']);
        Permission::create(['name' => 'enable and disable user']);
        Permission::create(['name' => 'change user password']);
        Permission::create(['name' => 'view histories']);
        Permission::create(['name' => 'view pricings']);
        Permission::create(['name' => 'data pricings']);
        Permission::create(['name' => 'airtime pricings']);
        Permission::create(['name' => 'bill pricings']);
        Permission::create(['name' => 'cable pricings']);
        Permission::create(['name' => 'socio pricings']);
        Permission::create(['name' => 'services']);
        Permission::create(['name' => 'notifications']);

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo(['view users', 'view histories', 'notifications', 'change user password']);

        $role3 = Role::create(['name' => 'super-admin']);
        $role3->givePermissionTo(Permission::all());
    }
}

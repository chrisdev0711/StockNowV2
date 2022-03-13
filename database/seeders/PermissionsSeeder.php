<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
      $email = env('USER_EMAIL');
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create default permissions
        Permission::create(['name' => 'list sites']);
        Permission::create(['name' => 'view sites']);
        Permission::create(['name' => 'create sites']);
        Permission::create(['name' => 'update sites']);
        Permission::create(['name' => 'delete sites']);

        Permission::create(['name' => 'list suppliers']);
        Permission::create(['name' => 'view suppliers']);
        Permission::create(['name' => 'create suppliers']);
        Permission::create(['name' => 'update suppliers']);
        Permission::create(['name' => 'delete suppliers']);

        Permission::create(['name' => 'list productcategories']);
        Permission::create(['name' => 'view productcategories']);
        Permission::create(['name' => 'create productcategories']);
        Permission::create(['name' => 'update productcategories']);
        Permission::create(['name' => 'delete productcategories']);

        Permission::create(['name' => 'list packtypes']);
        Permission::create(['name' => 'view packtypes']);
        Permission::create(['name' => 'create packtypes']);
        Permission::create(['name' => 'update packtypes']);
        Permission::create(['name' => 'delete packtypes']);

        Permission::create(['name' => 'list products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'update products']);
        Permission::create(['name' => 'delete products']);

        Permission::create(['name' => 'list historicalprices']);
        Permission::create(['name' => 'view historicalprices']);
        Permission::create(['name' => 'create historicalprices']);
        Permission::create(['name' => 'update historicalprices']);
        Permission::create(['name' => 'delete historicalprices']);

        Permission::create(['name' => 'list zones']);
        Permission::create(['name' => 'view zones']);
        Permission::create(['name' => 'create zones']);
        Permission::create(['name' => 'update zones']);
        Permission::create(['name' => 'delete zones']);

        Permission::create(['name' => 'list sellables']);
        Permission::create(['name' => 'view sellables']);
        Permission::create(['name' => 'create sellables']);
        Permission::create(['name' => 'update sellables']);
        Permission::create(['name' => 'delete sellables']);

        Permission::create(['name' => 'list ingredients']);
        Permission::create(['name' => 'view ingredients']);
        Permission::create(['name' => 'create ingredients']);
        Permission::create(['name' => 'update ingredients']);
        Permission::create(['name' => 'delete ingredients']);

        Permission::create(['name' => 'list sales']);
        Permission::create(['name' => 'view sales']);
        Permission::create(['name' => 'create sales']);
        Permission::create(['name' => 'update sales']);
        Permission::create(['name' => 'delete sales']);

        Permission::create(['name' => 'list orders']);
        Permission::create(['name' => 'view orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'update orders']);
        Permission::create(['name' => 'delete orders']);

        Permission::create(['name' => 'list order_items']);
        Permission::create(['name' => 'view order_items']);
        Permission::create(['name' => 'create order_items']);
        Permission::create(['name' => 'update order_items']);
        Permission::create(['name' => 'delete order_items']);

        // Create user role and assign existing permissions
        $currentPermissions = Permission::all();
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        $currentPermissions = Permission::all();
        $ownerRole = Role::create(['name' => 'owner']);
        $ownerRole->givePermissionTo($currentPermissions);

        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'super-admin']);
        $adminRole->givePermissionTo($allPermissions);

        $user = \App\Models\User::whereEmail("{$email}")->first();

        if ($user) {
            $user->assignRole($adminRole);
        }
    }
}

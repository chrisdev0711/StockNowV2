<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;


class StockTakesPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $userRole = Role::where(['name' => 'user'])->first();
        $ownerRole = Role::where(['name' => 'owner'])->first();
        $adminRole = Role::where(['name' => 'super-admin'])->first();

        $stock_takes_l = Permission::create(['name' => 'list stock_takes']);
        $stock_takes_v = Permission::create(['name' => 'view stock_takes']);
        $stock_takes_c = Permission::create(['name' => 'create stock_takes']);
        $stock_takes_u = Permission::create(['name' => 'update stock_takes']);
        $stock_takes_d = Permission::create(['name' => 'delete stock_takes']);

        $stock_counts_l = Permission::create(['name' => 'list stock_counts']);
        $stock_counts_v = Permission::create(['name' => 'view stock_counts']);
        $stock_counts_c = Permission::create(['name' => 'create stock_counts']);
        $stock_counts_u = Permission::create(['name' => 'update stock_counts']);
        $stock_counts_d = Permission::create(['name' => 'delete stock_counts']);

        $userRole->givePermissionTo($stock_takes_l);
        $userRole->givePermissionTo($stock_takes_v);
        $userRole->givePermissionTo($stock_takes_c);
        $userRole->givePermissionTo($stock_takes_u);
        $userRole->givePermissionTo($stock_takes_d);

        $userRole->givePermissionTo($stock_counts_l);
        $userRole->givePermissionTo($stock_counts_v);
        $userRole->givePermissionTo($stock_counts_c);
        $userRole->givePermissionTo($stock_counts_u);
        $userRole->givePermissionTo($stock_counts_d);

        $ownerRole->givePermissionTo($stock_takes_l);
        $ownerRole->givePermissionTo($stock_takes_v);
        $ownerRole->givePermissionTo($stock_takes_c);
        $ownerRole->givePermissionTo($stock_takes_u);
        $ownerRole->givePermissionTo($stock_takes_d);

        $ownerRole->givePermissionTo($stock_counts_l);
        $ownerRole->givePermissionTo($stock_counts_v);
        $ownerRole->givePermissionTo($stock_counts_c);
        $ownerRole->givePermissionTo($stock_counts_u);
        $ownerRole->givePermissionTo($stock_counts_d);

        $allPermissions = Permission::all();
        $adminRole->givePermissionTo($allPermissions);
    }
}

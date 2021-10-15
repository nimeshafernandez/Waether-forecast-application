<?php

use App\LedgerType;
use App\PaymentType;
use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        Permission::create(['name' => 'POS']);

        Permission::create(['name' => 'user_management_create']);
        Permission::create(['name' => 'user_management_view']);
        Permission::create(['name' => 'user_management_update']);
        Permission::create(['name' => 'user_management_delete']);

        Permission::create(['name' => 'product_management_create']);
        Permission::create(['name' => 'product_management_view']);
        Permission::create(['name' => 'product_management_update']);
        Permission::create(['name' => 'product_management_delete']);

        Permission::create(['name' => 'customer_management_create']);
        Permission::create(['name' => 'customer_management_view']);
        Permission::create(['name' => 'customer_management_update']);
        Permission::create(['name' => 'customer_management_delete']);

        Permission::create(['name' => 'supplier_management_create']);
        Permission::create(['name' => 'supplier_management_view']);
        Permission::create(['name' => 'supplier_management_update']);
        Permission::create(['name' => 'supplier_management_delete']);

        Permission::create(['name' => 'warehouse_management_create']);
        Permission::create(['name' => 'warehouse_management_view']);
        Permission::create(['name' => 'warehouse_management_update']);
        Permission::create(['name' => 'warehouse_management_delete']);

        
        //Create Super Admin Account & Super Admin Role
        $supermin_role = Role::create(['name' => 'Super Admin']);

        $supermin = User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => 'password'
        ]);
        $supermin->syncRoles($supermin_role);

        LedgerType::create([
            'type' => 'income'
        ]);

        LedgerType::create([
            'type' => 'expense'
        ]);

        PaymentType::create([
            'type' => 'cash'
        ]);

        PaymentType::create([
            'type' => 'card'
        ]);

        PaymentType::create([
            'type' => 'credit'
        ]);

        PaymentType::create([
            'type' => 'cheque'
        ]); 


    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Permissions
        Permission::create(['name' => 'approve requests']);
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'manage barang']);
        Permission::create(['name' => 'manage permintaan']);
        Permission::create(['name' => 'manage pengeluaran']);
        Permission::create(['name' => 'manage inventaris']);

        // Buat Role Manager dan berikan permission
        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->givePermissionTo([
            'approve requests',
            'view reports',
        ]);

        // Buat Role Admin
        // Role Admin secara default akan mendapatkan semua akses melalui Gate::before()
        // jadi kita tidak perlu assign permission secara spesifik di sini.
        $adminRole = Role::create(['name' => 'admin']);

    }
}

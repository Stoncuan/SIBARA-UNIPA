<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'superAdmin']);
        Role::create(['name' => 'user']);

        Permission::create(['name' => 'tambah user']);
        Permission::create(['name' => 'hapus user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'tambah barang']);
        Permission::create(['name' => 'hapus barang']);
        Permission::create(['name' => 'edit barang']);
        Permission::create(['name' => 'kembalikan barang user']);
        Permission::create(['name' => 'detail barang']);
        Permission::create(['name' => 'data user list']);

        $superAdmin->givePermissionTo([
            'tambah user',
            'hapus user',
            'edit user',
            'tambah barang',
            'hapus barang',
            'edit barang',
            'kembalikan barang user',
            'detail barang',
            'data user list',
        ]);
    }
}

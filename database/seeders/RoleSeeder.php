<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleManagement\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_name'   => 'Administrator',
            'description' => 'Role Administrator',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);

        Role::create([
            'role_name'   => 'Pelanggan',
            'description' => 'Role Pelanggan',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s')
        ]);
    }
}

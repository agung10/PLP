<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleManagement\{ Permission };

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Permission::create([
			'permission_name'   => 'Halaman index',
			'permission_action' => 'index',
			'description'       => 'Melihat data dalam tabel',
			'created_at'        => date('Y-m-d H:i:s'),
			'updated_at'        => date('Y-m-d H:i:s')
        ]);

        Permission::create([
			'permission_name'   => 'Halaman detail data',
			'permission_action' => 'show',
			'description'       => 'Melihat detail data',
			'created_at'        => date('Y-m-d H:i:s'),
			'updated_at'        => date('Y-m-d H:i:s')
        ]);

    	Permission::create([
			'permission_name'   => 'Halaman tambah data',
			'permission_action' => 'create',
			'description'       => 'Menampilkan form untuk tambah data',
			'created_at'        => date('Y-m-d H:i:s'),
			'updated_at'        => date('Y-m-d H:i:s')
        ]);

        Permission::create([
			'permission_name'   => 'Halaman edit data',
			'permission_action' => 'edit',
			'description'       => 'Menampilkan form untuk merubah data',
			'created_at'        => date('Y-m-d H:i:s'),
			'updated_at'        => date('Y-m-d H:i:s')
        ]);

        Permission::create([
			'permission_name'   => 'Simpan data',
			'permission_action' => 'store',
			'description'       => 'Aksi untuk menyimpan data',
			'created_at'        => date('Y-m-d H:i:s'),
			'updated_at'        => date('Y-m-d H:i:s')
        ]);

        Permission::create([
			'permission_name'   => 'Update data',
			'permission_action' => 'update',
			'description'       => 'Aksi untuk merubah data',
			'created_at'        => date('Y-m-d H:i:s'),
			'updated_at'        => date('Y-m-d H:i:s')
        ]);

        Permission::create([
			'permission_name'   => 'Delete data',
			'permission_action' => 'destroy',
			'description'       => 'Aksi untuk menghapus data',
			'created_at'        => date('Y-m-d H:i:s'),
			'updated_at'        => date('Y-m-d H:i:s')
        ]);
    }
}

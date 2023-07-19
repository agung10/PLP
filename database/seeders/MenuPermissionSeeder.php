<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleManagement\{ MenuPermission, Permission, RoleMenu };

class MenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$roleMenus   = RoleMenu::all();
        $permissions = Permission::all();

        foreach ($roleMenus as $roleMenu) {
            foreach ($permissions as $permission) {
                MenuPermission::create([
                    'role_menu_id'  => $roleMenu->role_menu_id,
                    'permission_id' => $permission->permission_id
                ]);
            }
        }

    }
}

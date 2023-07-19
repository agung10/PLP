<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleManagement\{ Menu, Role, RoleMenu };

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** ROLE ADMIN **/
        $roleAdmin = Role::where('role_name', 'Administrator')->first();
        $rolePelanggan = Role::where('role_name', 'Pelanggan')->first();
        $menus = Menu::all();

        foreach ($menus as $menu) {
            if ($menu->menu_id != 4 && $menu->menu_id != 5 && ($menu->menu_id != 13 && $menu->id_parent != 13)) {
                RoleMenu::create([
                    'role_id'    => $roleAdmin->role_id,
                    'menu_id'    => $menu->menu_id
                ]);
            }

            if (($menu->menu_id != 2 && $menu->id_parent != 2) && ($menu->menu_id != 7 && $menu->id_parent != 7)) {
                RoleMenu::create([
                    'role_id'    => $rolePelanggan->role_id,
                    'menu_id'    => $menu->menu_id
                ]);
            }
        }                
    }
}

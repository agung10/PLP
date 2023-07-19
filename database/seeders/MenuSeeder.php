<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleManagement\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        $now = date("Y-m-d H:i:s");

        // DASHBOARD
        $dashboard = Menu::create([
            "name"       => "Dashboard",
            "icon"       => "fa fa-gauge",
            "order"      => 1,
            "route"      => "dashboard",
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        /** START:ROLE MANANAGEMENT **/
        $roleManagement = Menu::create([
            "name"       => "Role Management",
            "icon"       => "fa fa-users-gear",
            "order"      => 2,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $role = Menu::create([
            "name"       => "Role",
            "route"      => "role",
            "id_parent"  => $roleManagement->menu_id,
            "order"      => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
            
        $roleMenu = Menu::create([
            "name"       => "Role Menu",
            "route"      => "role-menu",
            "id_parent"  => $roleManagement->menu_id,
            "order"      => 2,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $menuPermission = Menu::create([
            "name"       => "Menu Permission",
            "route"      => "menu-permission",
            "id_parent"  => $roleManagement->menu_id,
            "order"      => 3,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $user = Menu::create([
            "name"       => "User",
            "route"      => "user",
            "id_parent"  => $roleManagement->menu_id,
            "order"      => 4,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
        /** END:ROLE MANANAGEMENT **/

        /** START:ADMIN MANANAGEMENT **/
        $adminManagement = Menu::create([
            "name"       => "Admin Management",
            "icon"       => "fa fa-user-gear",
            "order"      => 3,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $tarif = Menu::create([
            "name"       => "Kelola Tarif Listrik",
            "route"      => "tarif-listrik",
            "id_parent"  => $adminManagement->menu_id,
            "order"      => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $pelanggan = Menu::create([
            "name"       => "Kelola Pelanggan",
            "route"      => "pelanggan",
            "id_parent"  => $adminManagement->menu_id,
            "order"      => 2,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $penggunaan = Menu::create([
            "name"       => "Kelola Penggunaan",
            "route"      => "penggunaan",
            "id_parent"  => $adminManagement->menu_id,
            "order"      => 3,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $tagihan = Menu::create([
            "name"       => "Kelola Tagihan",
            "route"      => "tagihan",
            "id_parent"  => $adminManagement->menu_id,
            "order"      => 4,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $pembayaran = Menu::create([
            "name"       => "Kelola Pembayaran",
            "route"      => "pembayaran",
            "id_parent"  => $adminManagement->menu_id,
            "order"      => 4,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
        /** END:ADMIN MANANAGEMENT **/

        /** START:PELANGGAN MANANAGEMENT **/
        $pelangganManagement = Menu::create([
            "name"       => "Pelanggan Management",
            "icon"       => "fa fa-user",
            "order"      => 4,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $pelangganP = Menu::create([
            "name"       => "Pelanggan",
            "route"      => "pelanggan-pelanggan",
            "id_parent"  => $pelangganManagement->menu_id,
            "order"      => 1,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $penggunaanP = Menu::create([
            "name"       => "Penggunaan",
            "route"      => "penggunaan-pelanggan",
            "id_parent"  => $pelangganManagement->menu_id,
            "order"      => 2,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $tagihanP = Menu::create([
            "name"       => "Tagihan",
            "route"      => "tagihan-pelanggan",
            "id_parent"  => $pelangganManagement->menu_id,
            "order"      => 3,
            "created_at" => $now,
            "updated_at" => $now,
        ]);

        $pembayaranP = Menu::create([
            "name"       => "Pembayaran",
            "route"      => "pembayaran-pelanggan",
            "id_parent"  => $pelangganManagement->menu_id,
            "order"      => 4,
            "created_at" => $now,
            "updated_at" => $now,
        ]);
        /** END:PELANGGAN MANANAGEMENT **/
    }
}
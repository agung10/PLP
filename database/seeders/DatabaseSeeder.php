<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            RoleSeeder::class,
            PermissionSeeder::class,
            RoleMenuSeeder::class,
            UserRoleSeeder::class,
            MenuPermissionSeeder::class,
            TarifListrikSeeder::class,
        ]);
    }
}

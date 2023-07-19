<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleManagement\{ User, Role, UserRole };

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();

        foreach($roles as $role) {
            UserRole::create([
                'user_id'    => User::first()->user_id,
                'role_id'    => $role->role_id
            ]);
        }
    }
}

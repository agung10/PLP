<?php

namespace App\Models\RoleManagement;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table      = 'role';
    protected $primaryKey = 'role_id';
    protected $guarded    = [];
    
    /**
     * Get menu record associated with the role.
     */
    public function menuPermissions()
    {
        return $this->hasManyThrough(
            MenuPermission::class,
            RoleMenu::class,
            'role_id', // Foreign key on user_role table...
            'role_menu_id', // Foreign key on role table...
            'role_id', // Local key on user table...
            'role_menu_id' // Local key on user_role table...
        );
    }

	/**
     * Get menu record associated with the role.
     */
    public function menu()
    {
        return $this->hasManyThrough(
        	Menu::class,
            RoleMenu::class,
            'role_id', // Foreign key on user_role table...
            'menu_id', // Foreign key on role table...
            'role_id', // Local key on user table...
            'menu_id' // Local key on user_role table...
        )
        ->where('menu.is_active', TRUE);
    }

}

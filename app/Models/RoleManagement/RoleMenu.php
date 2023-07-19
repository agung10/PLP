<?php

namespace App\Models\RoleManagement;

use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{

    protected $table      = 'role_menu';
    protected $primaryKey = 'role_menu_id';
    protected $guarded    = [];
    public $timestamps    = false;

    /**
     * Get menu record associated with the role.
     */
    public function menu($roleId)
    {
        return $this->hasMany(Menu::class, 'menu_id', 'menu_id');
    }

    public function permission()
    {
        return $this->hasManyThrough(
            Permission::class,
            MenuPermission::class,
            'role_menu_id',
            'permission_id',
            'role_menu_id',
            'permission_id'
        );
    }

    /**
     * Get permissions record associated with the role.
     */
    public function menuPermissions()
    {
        return $this->hasMany(MenuPermission::class, 'role_menu_id', 'role_menu_id');
    }
}

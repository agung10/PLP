<?php

namespace App\Models\RoleManagement;

use Illuminate\Database\Eloquent\Model;

class MenuPermission extends Model
{
	protected $table      = 'menu_permission';
	protected $primaryKey = 'menu_permission_id';
	protected $guarded    = [];
	public $timestamps    = false;
    
	public function datatableColumns()
	{
	    return [
	    		'menu_permission.menu_permission_id',
			    'menu_permission.nama',
			    'menu_permission.created_at',
			    'menu_permission.updated_at'
			];
	}

	public function datatableButtons()
	{
	    return ['show', 'edit', 'destroy'];
	}

	public function whereRoleMenu($roleId, $menuId) 
	{
		return $this->where(['role_id' => $roleId, 'menuId' => 'menuId'])->with('permission')->first();
	}

	public function permission()
    {
        return $this->hasOne(Permission::class, 'permission_id', 'permission_id');
    }

}

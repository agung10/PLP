<?php

namespace App\Models\RoleManagement;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
	protected $table      = 'user_role';
	protected $primaryKey = 'user_role_id';
	protected $guarded    = [];
	public $timestamps    = false;

	public function datatableColumns()
	{
	    return [
	    		'user_role.user_role_id',
			    'user_role.nama',
			    'user_role.created_at',
			    'user_role.updated_at'
			];
	}

	public function datatableButtons()
	{
	    return ['show', 'edit', 'destroy'];
	}

}

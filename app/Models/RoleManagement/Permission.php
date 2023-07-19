<?php

namespace App\Models\RoleManagement;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $table      = 'permission';
	protected $primaryKey = 'permission_id';
	protected $guarded    = [];
}

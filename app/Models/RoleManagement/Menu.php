<?php

namespace App\Models\RoleManagement;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'menu_id';
    protected $guarded    = [];

    // get menu parent collection
    public function parentMenu() {
    	return $this->where('menu_id', $this->id_parent)->first();
    }

    // status available for menu
    public function statusList() {
        return ['1' => 'Active', '0' => 'Inactive'];
    }

    // get status name of menu by array status list
    public function statusMenu() {
    	return $this->statusList()[$this->is_active];
    }

}

<?php

namespace App\Models;

use App\Models\RoleManagement\User;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
	protected $table      = 'pelanggan';
	protected $primaryKey = 'pelanggan_id';
	protected $guarded    = [];

	public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

	public function Tarif()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id', 'tarif_id');
    }
}

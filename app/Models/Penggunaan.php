<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Penggunaan extends Model
{
	protected $table      = 'penggunaan';
	protected $primaryKey = 'penggunaan_id';
	protected $guarded    = [];

	public function Pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }
}

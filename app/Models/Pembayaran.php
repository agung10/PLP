<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
	protected $table      = 'pembayaran';
	protected $primaryKey = 'pembayaran_id';
	protected $guarded    = [];

	public function Tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'tagihan_id', 'tagihan_id');
    }
}

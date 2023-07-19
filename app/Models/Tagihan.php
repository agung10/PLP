<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
	protected $table      = 'tagihan';
	protected $primaryKey = 'tagihan_id';
	protected $guarded    = [];

	public function Penggunaan()
    {
        return $this->belongsTo(Penggunaan::class, 'penggunaan_id', 'penggunaan_id');
    }
	
	public function Pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }

	public function Pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'tagihan_id', 'tagihan_id');
    }
}

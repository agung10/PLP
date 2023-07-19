<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
	protected $table      = 'tarif';
	protected $primaryKey = 'tarif_id';
	protected $guarded    = [];
}

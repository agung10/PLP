<?php

namespace Database\Seeders;

use App\Models\Tarif;
use Illuminate\Database\Seeder;

class TarifListrikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tarif::create([
            'daya'         => 450,
            'tarif_perkwh' => 415,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ]);
        Tarif::create([
            'daya'         => 900,
            'tarif_perkwh' => 605,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ]);
        Tarif::create([
            'daya'         => 1300,
            'tarif_perkwh' => 1444.70,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ]);
        Tarif::create([
            'daya'         => 3500,
            'tarif_perkwh' => 1699.53,
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ]);
    }
}

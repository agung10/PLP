<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Penggunaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $sumJmlhMeterB = Penggunaan::join('pelanggan', 'pelanggan.pelanggan_id', 'penggunaan.pelanggan_id')
                    ->select('tagihan.jmlh_meter')
                    ->join('tagihan', 'tagihan.penggunaan_id', 'penggunaan.penggunaan_id')
                    ->where('pelanggan.user_id', \Auth::user()->user_id)
                    ->whereMonth('penggunaan.waktu', date('m'))
                    ->sum('jmlh_meter');

        $sumJmlhMeterT = Penggunaan::join('pelanggan', 'pelanggan.pelanggan_id', 'penggunaan.pelanggan_id')
                    ->select('tagihan.jmlh_meter')
                    ->join('tagihan', 'tagihan.penggunaan_id', 'penggunaan.penggunaan_id')
                    ->where('pelanggan.user_id', \Auth::user()->user_id)
                    ->whereYear('penggunaan.waktu', date('Y'))
                    ->sum('jmlh_meter');

        return view ('dashboard.index', compact('sumJmlhMeterB', 'sumJmlhMeterT'));
    }
}

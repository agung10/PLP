<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Penggunaan;
use App\Models\Tagihan;

class PrintController extends Controller
{
    public function printPenggunaan($bulanOrTahun)
    {        
        if (\Auth::user()->user_id == 1) {
            if (date('m') == $bulanOrTahun) $penggunaan = Penggunaan::whereMonth('created_at', $bulanOrTahun)->get();
            elseif (date('Y') == $bulanOrTahun) $penggunaan = Penggunaan::whereYear('created_at', $bulanOrTahun)->get();
        } else {
            if (date('m') == $bulanOrTahun) $penggunaan = Penggunaan::join('pelanggan', 'pelanggan.pelanggan_id', 'penggunaan.pelanggan_id')->where('pelanggan.user_id', \Auth::user()->user_id)->whereMonth('penggunaan.created_at', $bulanOrTahun)->get();
            elseif (date('Y') == $bulanOrTahun) $penggunaan = Penggunaan::join('pelanggan', 'pelanggan.pelanggan_id', 'penggunaan.pelanggan_id')->where('pelanggan.user_id', \Auth::user()->user_id)->whereYear('penggunaan.created_at', $bulanOrTahun)->get();
        }

        return view('website.penggunaan.print', compact('penggunaan', 'bulanOrTahun'));
    }

    public function printTagihan($bulanOrTahun)
    {        
        if (\Auth::user()->user_id == 1) {
            if (date('m') == $bulanOrTahun) $tagihan = Tagihan::whereMonth('created_at', $bulanOrTahun)->get();
            elseif (date('Y') == $bulanOrTahun) $tagihan = Tagihan::whereYear('created_at', $bulanOrTahun)->get();
        } else {
            if (date('m') == $bulanOrTahun) $tagihan = Tagihan::join('pelanggan', 'pelanggan.pelanggan_id', 'tagihan.pelanggan_id')->where('pelanggan.user_id', \Auth::user()->user_id)->whereMonth('tagihan.created_at', $bulanOrTahun)->get();
            elseif (date('Y') == $bulanOrTahun) $tagihan = Tagihan::join('pelanggan', 'pelanggan.pelanggan_id', 'tagihan.pelanggan_id')->where('pelanggan.user_id', \Auth::user()->user_id)->whereYear('tagihan.created_at', $bulanOrTahun)->get();
        }
        return view('website.tagihan.print', compact('tagihan', 'bulanOrTahun'));
    }

    public function printPembayaran($bulanOrTahun)
    {        
        if (\Auth::user()->user_id == 1) {
            if (date('m') == $bulanOrTahun) $pembayaran = Pembayaran::whereMonth('created_at', $bulanOrTahun)->get();
            elseif (date('Y') == $bulanOrTahun) $pembayaran = Pembayaran::whereYear('created_at', $bulanOrTahun)->get();
        } else {
            if (date('m') == $bulanOrTahun) {
                $pembayaran = Pembayaran::join('tagihan', 'tagihan.tagihan_id', 'pembayaran.tagihan_id')
                            ->join('pelanggan', 'pelanggan.pelanggan_id', 'tagihan.pelanggan_id')
                            ->where('tagihan.status', '!=', 1)
                            ->where('pelanggan.user_id', \Auth::user()->user_id)
                            ->whereMonth('pembayaran.created_at', $bulanOrTahun)->get();
            }
            elseif (date('Y') == $bulanOrTahun) {
                $pembayaran = Pembayaran::join('tagihan', 'tagihan.tagihan_id', 'pembayaran.tagihan_id')
                            ->join('pelanggan', 'pelanggan.pelanggan_id', 'tagihan.pelanggan_id')
                            ->where('tagihan.status', '!=', 1)
                            ->where('pelanggan.user_id', \Auth::user()->user_id)
                            ->whereYear('pembayaran.created_at', $bulanOrTahun)->get();
            }
        }
        return view('website.pembayaran.print', compact('pembayaran', 'bulanOrTahun'));
    }
}

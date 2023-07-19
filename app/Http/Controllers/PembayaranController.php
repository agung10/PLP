<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PembayaranRequest;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Repositories\PembayaranRepository;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    protected $pembayaranRepo;
    
    public function __construct(PembayaranRepository $pembayaranRepo)
    {
        $this->pembayaranRepo = $pembayaranRepo;
    }
    
    public function index()
    {        
        $link = (\Auth::user()->user_id == 1) ? 'pembayaran.ajaxDatatable' : 'pembayaran-pelanggan.ajaxDatatable';
        return view('website.pembayaran.index', compact('link'));
    }

    public function create()
    {
        $dataPembayaran = Pembayaran::pluck('tagihan_id');
        $dataPelanggan = Pelanggan::join('tagihan', 'tagihan.pelanggan_id', 'pelanggan.pelanggan_id')->whereNotIn('tagihan.tagihan_id', $dataPembayaran)->get(); 

        $link = (\Auth::user()->user_id == 1) ? 'pembayaran.store' : 'pembayaran-pelanggan.store';                
        return view('website.pembayaran.create', compact('dataPelanggan', 'link'));
    }

    public function store(PembayaranRequest $request)
    {
        $request['tagihan_id']     = Tagihan::where('pelanggan_id', $request->pelanggan_id)->first()->tagihan_id;

        unset($request['pelanggan_id']);
        $store = $this->pembayaranRepo->store( $request->all() );

        $link = (\Auth::user()->user_id == 1) ? 'pembayaran.index' : 'pembayaran-pelanggan.index';                    
        return redirect()->route($link)->with(\Helper::alertStatus('store', $store));
    }

    public function show($tagihanId)
    {
        $data = $this->pembayaranRepo->show(\Crypt::decrypt($tagihanId));
        return view('website.pembayaran.show', compact('data'));
    }

    public function update(PembayaranRequest $request, $pembayaranId)
    {
        $data = Pembayaran::findOrFail(\Crypt::decrypt($pembayaranId));
        
        $updatePembayaran['tagihan_id']      = $data->tagihan_id;
        $updatePembayaran['tgl_pembayaran']  = date('Y-m-d');
        $updatePembayaran['biaya_admin']     = $data->biaya_admin;
        $updatePembayaran['total_bayar']     = $data->total_bayar;
        $updatePembayaran['pelanggan_bayar'] = $request->pelanggan_bayar;
        
        if ($updatePembayaran['pelanggan_bayar'] != $updatePembayaran['total_bayar']) return redirect()->back()->with('gagal-bayar', true);
        else $data->update($updatePembayaran);
        
        Tagihan::findOrFail($data->tagihan_id)->update(['status' => 2]);
        $update = true;
        return redirect()->route('pembayaran-pelanggan.index')->with(\Helper::alertStatus('update', $update));
    }

    public function ajaxDatatable(Request $request)
    {
        return $this->pembayaranRepo->pembayaranDatatable($request);
    }

    public function getDataPelanggan(Request $request)
    {
        $pelanggan   = Pelanggan::findOrFail($request->pelanggan_id)->first();
        $jmlh_meter  = Tagihan::where('pelanggan_id', $request->pelanggan_id)->first()->jmlh_meter;

        $total_biaya = $pelanggan->Tarif->tarif_perkwh * $jmlh_meter;
        return response()->json(['totalBiaya' => $total_biaya]);
    }
}

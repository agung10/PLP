<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagihanRequest;
use App\Models\Penggunaan;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Repositories\TagihanRepository;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    protected $tagihanRepo;
    
    public function __construct(TagihanRepository $tagihanRepo)
    {
        $this->tagihanRepo = $tagihanRepo;
    }
    
    public function index()
    {        
        $link = (\Auth::user()->user_id == 1) ? 'tagihan.ajaxDatatable' : 'tagihan-pelanggan.ajaxDatatable';
        return view('website.tagihan.index', compact('link'));
    }

    public function create()
    {
        $dataTagihan   = Tagihan::pluck('pelanggan_id');
        $dataPelanggan = Pelanggan::join('penggunaan', 'penggunaan.pelanggan_id', 'pelanggan.pelanggan_id')->whereNotIn('pelanggan.pelanggan_id', $dataTagihan)->get(); 
        return view('website.tagihan.create', compact('dataPelanggan'));
    }

    public function store(TagihanRequest $request)
    {
        $request['penggunaan_id'] = Penggunaan::where('pelanggan_id', $request->pelanggan_id)->first()->penggunaan_id;
        $request['status']        = 1; //Belum Dibayar
        $request['waktu_tagihan'] = date('Y-m-d', strtotime('+ 30 days'));

        $store = $this->tagihanRepo->store( $request->all() );
        return redirect()->route('tagihan.index')->with(\Helper::alertStatus('store', $store));
    }

    public function show($tagihanId)
    {
        $data = $this->tagihanRepo->show(\Crypt::decrypt($tagihanId));
        return view('website.tagihan.show', compact('data'));
    }

    public function edit($tagihanId)
    {
        $data          = $this->tagihanRepo->show(\Crypt::decrypt($tagihanId));
        $dataPelanggan = Pelanggan::all();

        return view('website.tagihan.edit', compact('data', 'dataPelanggan'));
    }

    public function update(TagihanRequest $request, $tagihanId)
    {
        $request['penggunaan_id'] = Penggunaan::where('pelanggan_id', $request->pelanggan_id)->first()->penggunaan_id;
        $request['waktu_tagihan'] = date('Y-m-d');
        $request['status']        = 1; //Belum Dibayar
        
        $update = $this->tagihanRepo->update( $request->all(), \Crypt::decrypt($tagihanId) );
        return redirect()->route('tagihan.index')->with(\Helper::alertStatus('update', $update));
    }

    public function destroy($tagihanId)
    {
        return $this->tagihanRepo->delete(\Crypt::decrypt($tagihanId));
    }

    public function ajaxDatatable(Request $request)
    {
        return $this->tagihanRepo->tagihanDatatable($request);
    }

    public function getDataPenggunaan(Request $request)
    {
        $penggunaan = Penggunaan::where('pelanggan_id', $request->pelanggan_id)->first();
        $jmlh_meter = $penggunaan->meter_akhir - $penggunaan->meter_awal;

        return response()->json(['jmlhMeter' => $jmlh_meter]);
    }

    public function pembayaranTagihan($pelangganId)
    {
        $dataPelanggan = Pelanggan::where('pelanggan_id', \Crypt::decrypt($pelangganId))->get(); 

        $link = (\Auth::user()->user_id == 1) ? 'pembayaran.store' : 'pembayaran-pelanggan.store';                
        return view('website.pembayaran.create', compact('dataPelanggan', 'link'));
    }

    public function pembayaranPelanggan($tagihanId)
    {
        $dataPembayaran = Pembayaran::where('tagihan_id', \Crypt::decrypt($tagihanId))->first(); 

        $link = (\Auth::user()->user_id == 1) ? 'pembayaran.update' : 'pembayaran-pelanggan.update';                
        return view('website.pembayaran.pelanggan-bayar', compact('dataPembayaran', 'link'));
    }
}

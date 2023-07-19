<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PenggunaanRequest;
use App\Models\{Penggunaan, Pelanggan};
use App\Repositories\{PenggunaanRepository, TagihanRepository};
use Illuminate\Http\Request;

class PenggunaanController extends Controller
{
    protected $penggunaanRepo, $tagihanRepo;
    
    public function __construct(PenggunaanRepository $penggunaanRepo, TagihanRepository $tagihanRepo)
    {
        $this->penggunaanRepo = $penggunaanRepo;
        $this->tagihanRepo    = $tagihanRepo;
    }
    
    public function index()
    {        
        $link = (\Auth::user()->user_id == 1) ? 'penggunaan.ajaxDatatable' : 'penggunaan-pelanggan.ajaxDatatable';
        return view('website.penggunaan.index', compact('link'));
    }

    public function create()
    {
        $dataPenggunaan = Penggunaan::pluck('pelanggan_id');
        if (\Auth::user()->user_id == 1) $dataPelanggan  = Pelanggan::whereNotIn('pelanggan_id', $dataPenggunaan)->get();
        else $dataPelanggan  = Pelanggan::where('user_id', \Auth::user()->user_id)->whereNotIn('pelanggan_id', $dataPenggunaan)->get();

        $link = (\Auth::user()->user_id == 1) ? 'penggunaan.store' : 'penggunaan-pelanggan.store';        
        return view('website.penggunaan.create', compact('dataPelanggan', 'link'));
    }

    public function store(PenggunaanRequest $request)
    {
        $request['waktu'] = date('Y-m-d', strtotime($request->waktu));

        $store = $this->penggunaanRepo->store( $request->all() );
        $this->tagihanRepo->createTagihan($request);

        $link = (\Auth::user()->user_id == 1) ? 'penggunaan.index' : 'penggunaan-pelanggan.index';        
        return redirect()->route($link)->with(\Helper::alertStatus('store', $store));
    }

    public function show($penggunaanId)
    {
        $data = $this->penggunaanRepo->show(\Crypt::decrypt($penggunaanId));
        return view('website.penggunaan.show', compact('data'));
    }

    public function edit($penggunaanId)
    {
        $data          = $this->penggunaanRepo->show(\Crypt::decrypt($penggunaanId));
        $dataPelanggan = Pelanggan::all();

        $link = (\Auth::user()->user_id == 1) ? 'penggunaan.update' : 'penggunaan-pelanggan.update';                        
        return view('website.penggunaan.edit', compact('data', 'dataPelanggan', 'link'));
    }

    public function update(PenggunaanRequest $request, $penggunaanId)
    {
        $request['waktu'] = date('Y-m-d', strtotime($request->waktu));
        $update = $this->penggunaanRepo->update( $request->all(), \Crypt::decrypt($penggunaanId) );

        $dataTagihan = $this->tagihanRepo->where('penggunaan_id', \Crypt::decrypt($penggunaanId))->first();
        $dataTagihan->update(['jmlh_meter' => $request->meter_akhir - $request->meter_awal]);

        $link = (\Auth::user()->user_id == 1) ? 'penggunaan.index' : 'penggunaan-pelanggan.index';                            
        return redirect()->route($link)->with(\Helper::alertStatus('update', $update));
    }

    public function destroy($penggunaanId)
    {
        return $this->penggunaanRepo->delete(\Crypt::decrypt($penggunaanId));
    }

    public function ajaxDatatable(Request $request)
    {
        return $this->penggunaanRepo->penggunaanDatatable($request);
    }
}

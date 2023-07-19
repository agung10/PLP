<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PelangganRequest;
use App\Models\RoleManagement\User;
use App\Models\Tarif;
use App\Repositories\PelangganRepository;

class PelangganController extends Controller
{
    protected $pelangganRepo;
    
    public function __construct(PelangganRepository $pelangganRepo)
    {
        $this->pelangganRepo = $pelangganRepo;
    }
    
    public function index()
    {        
        $link = (\Auth::user()->user_id == 1) ? 'pelanggan.ajaxDatatable' : 'pelanggan-pelanggan.ajaxDatatable';
        return view('website.pelanggan.index', compact('link'));
    }

    public function create()
    {
        $users     = User::where('user_id', '!=', 1)->pluck('nama_lengkap', 'user_id');
        $dataTarif = Tarif::all();

        $link = (\Auth::user()->user_id == 1) ? 'pelanggan.store' : 'pelanggan-pelanggan.store';
        return view('website.pelanggan.create', compact('users', 'dataTarif', 'link'));
    }

    public function store(PelangganRequest $request)
    {
        $request["kode_pelanggan"] = $this->pelangganRepo->kodePelanggan();
        if (\Auth::user()->user_id != 1) $request["user_id"] = \Auth::user()->user_id;
        else $request["user_id"] = $request->user_id;
        
        $store = $this->pelangganRepo->store( $request->all() );
        
        $link = (\Auth::user()->user_id == 1) ? 'pelanggan.index' : 'pelanggan-pelanggan.index';
        return redirect()->route($link)->with(\Helper::alertStatus('store', $store));
    }

    public function show($pelangganId)
    {
        $data = $this->pelangganRepo->show(\Crypt::decrypt($pelangganId));
        
        return view('website.pelanggan.show', compact('data'));
    }

    public function edit($pelangganId)
    {
        $data      = $this->pelangganRepo->show(\Crypt::decrypt($pelangganId));
        $users     = User::where('user_id', '!=', 1)->pluck('nama_lengkap', 'user_id');
        $dataTarif = Tarif::all();
        
        $link = (\Auth::user()->user_id == 1) ? 'pelanggan.update' : 'pelanggan-pelanggan.update';
        return view('website.pelanggan.edit', compact('data', 'users', 'dataTarif', 'link'));
    }

    public function update(PelangganRequest $request, $pelangganId)
    {
        $update = $this->pelangganRepo->update( $request->all(), \Crypt::decrypt($pelangganId) );
        
        $link = (\Auth::user()->user_id == 1) ? 'pelanggan.index' : 'pelanggan-pelanggan.index';
        return redirect()->route($link)->with(\Helper::alertStatus('update', $update));
    }

    public function destroy($pelangganId)
    {
        return $this->pelangganRepo->delete(\Crypt::decrypt($pelangganId));
    }

    public function ajaxDatatable()
    {
        return $this->pelangganRepo->pelangganDatatable();
    }
}

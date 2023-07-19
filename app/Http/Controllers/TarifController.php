<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TarifRequest;
use App\Repositories\TarifRepository;

class TarifController extends Controller
{
    protected $tarifRepo;
    
    public function __construct(TarifRepository $tarifRepo)
    {
        $this->tarifRepo = $tarifRepo;
    }
    
    public function index()
    {        
        return view('website.tarif.index');
    }

    public function create()
    {
        return view('website.tarif.create');
    }

    public function store(TarifRequest $request)
    {
        $store = $this->tarifRepo->store( $request->all() );
        return redirect()->route('tarif-listrik.index')->with(\Helper::alertStatus('store', $store));
    }

    public function show($tarifId)
    {
        $data = $this->tarifRepo->show(\Crypt::decrypt($tarifId));
        return view('website.tarif.show', compact('data'));
    }

    public function edit($tarifId)
    {
        $data = $this->tarifRepo->show(\Crypt::decrypt($tarifId));
        return view('website.tarif.edit', compact('data'));
    }

    public function update(TarifRequest $request, $tarifId)
    {
        $update = $this->tarifRepo->update( $request->all(), \Crypt::decrypt($tarifId) );
        return redirect()->route('tarif-listrik.index')->with(\Helper::alertStatus('update', $update));
    }

    public function destroy($tarifId)
    {
        return $this->tarifRepo->delete(\Crypt::decrypt($tarifId));
    }

    public function ajaxDatatable()
    {
        return $this->tarifRepo->tarifDatatable();
    }
}

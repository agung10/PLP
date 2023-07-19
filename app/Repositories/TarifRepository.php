<?php

namespace App\Repositories;

use App\Models\Tarif;
use App\Repositories\BaseRepository;

class TarifRepository extends BaseRepository
{
    public function __construct(Tarif $tarif)
    {
        $this->model = $tarif;
    }

    public function tarifDatatable()
    {
        $collection = $this->model->select('tarif_id', 'daya', 'tarif_perkwh', 'created_at')->orderBy('tarif_id', 'DESC');

        return \DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('created_at', function($collection) {
                return \Helper::tglIndo($collection->created_at); 
            })
            ->editColumn('tarif_perkwh', function($collection) {
                return \Helper::number_formats($collection->tarif_perkwh, 'view_currency'); 
            })
            ->addColumn('action', function($row) {
                return view('partials.buttons.datatable',[
                    'show'    => route('tarif-listrik.show', \Crypt::encrypt($row->tarif_id)),
                    'edit'    => route('tarif-listrik.edit', \Crypt::encrypt($row->tarif_id)),
                    'destroy' => route('tarif-listrik.destroy', \Crypt::encrypt($row->tarif_id))
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
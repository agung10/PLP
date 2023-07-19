<?php

namespace App\Repositories;

use App\Models\Penggunaan;
use App\Repositories\BaseRepository;

class PenggunaanRepository extends BaseRepository
{
    public function __construct(Penggunaan $penggunaan)
    {
        $this->model = $penggunaan;
    }

    public function penggunaanDatatable($request)
    {
        $date1 = $request->date1 ?? date('Y-m-d');
        $date2 = $request->date2 ?? date('Y-m-d');

        $collection = $this->model->select('penggunaan_id', 'pelanggan_id', 'waktu', 'meter_awal', 'meter_akhir')
                    ->when($date1 && $date2, function ($q) use ($date1, $date2) {
                        $q->whereDate('penggunaan.created_at', '>=' ,date('Y-m-d', strtotime($date1)));
                        $q->whereDate('penggunaan.created_at', '<=' ,date('Y-m-d', strtotime($date2)));
                    })
                    ->orderBy('penggunaan_id', 'DESC');

        return \DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('kode_pelanggan', function($collection) {
                return '<code>' . $collection->Pelanggan->no_kwh .' - '. $collection->Pelanggan->User->nama_lengkap . '</code>'; 
            })
            ->editColumn('waktu', function($collection) {
                return \Helper::tglIndo($collection->waktu); 
            })
            ->addColumn('action', function($row) {
                $penggunaan = (\Auth::user()->user_id == 1) ? 'penggunaan' : 'penggunaan-pelanggan';

                return view('partials.buttons.datatable',[
                    'show'    => route($penggunaan.'.show', \Crypt::encrypt($row->penggunaan_id)),
                    'edit'    => route($penggunaan.'.edit', \Crypt::encrypt($row->penggunaan_id)),
                    'destroy' => route($penggunaan.'.destroy', \Crypt::encrypt($row->penggunaan_id))
                ]);
            })
            ->rawColumns(['action', 'kode_pelanggan'])
            ->make(true);
    }

}
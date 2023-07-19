<?php

namespace App\Repositories;

use App\Models\Pelanggan;
use App\Repositories\BaseRepository;

class PelangganRepository extends BaseRepository
{
    public function __construct(Pelanggan $pelanggan)
    {
        $this->model = $pelanggan;
    }

    public function kodePelanggan()
    {
        $existing = Pelanggan::count();
        if ($existing < 1) {
            return date('Ymd') . '001';
        } else {
            $last_data = Pelanggan::orderBy('kode_pelanggan', 'desc')->first()->kode_pelanggan;
            $date      = substr($last_data, -11, -3);
            
            if (date('Ymd') == $date) {
                $_count    = substr($last_data, -3);
                $val_curr  = (int) $_count;
                $val_next  = $val_curr + 1;
                $len_next  = strlen($val_next);
                $repeat    = str_repeat('0', (strlen($_count) - $len_next));
                $count     = $repeat . $val_next;

                return $date . $count;
            } else {
                return date('Ymd') . '001';
            }
        }
    }

    public function pelangganDatatable()
    {
        $collection = $this->model->select('pelanggan_id', 'kode_pelanggan', 'user_id', 'no_kwh', 'tarif_id')->orderBy('pelanggan_id', 'DESC');

        return \DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('kode_pelanggan', function($collection) {
                return '<code>' . $collection->kode_pelanggan . '</code>'; 
            })
            ->editColumn('nama_lengkap', function($collection) {
                return $collection->User->nama_lengkap ?? '-'; 
            })
            ->editColumn('tarif', function($collection) {
                return $collection->Tarif->daya . 'VA / ' . \Helper::number_formats($collection->Tarif->tarif_perkwh, 'view_currency') ?? '-'; 
            })
            ->addColumn('action', function($row) {
                $pelanggan = (\Auth::user()->user_id == 1) ? 'pelanggan' : 'pelanggan-pelanggan';

                return view('partials.buttons.datatable',[
                    'show'    => route($pelanggan.'.show', \Crypt::encrypt($row->pelanggan_id)),
                    'edit'    => route($pelanggan.'.edit', \Crypt::encrypt($row->pelanggan_id)),
                    'destroy' => route($pelanggan.'.destroy', \Crypt::encrypt($row->pelanggan_id))
                ]);
            })
            ->rawColumns(['action', 'kode_pelanggan'])
            ->make(true);
    }

}
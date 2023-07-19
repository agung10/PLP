<?php

namespace App\Repositories;

use App\Models\Pembayaran;
use App\Repositories\BaseRepository;

class PembayaranRepository extends BaseRepository
{
    public function __construct(Pembayaran $pembayaran)
    {
        $this->model = $pembayaran;
    }

    public function pembayaranDatatable($request)
    {
        $date1 = $request->date1 ?? date('Y-m-d');
        $date2 = $request->date2 ?? date('Y-m-d');

        if (\Auth::user()->user_id == 1) {
            $collection = $this->model->select('pembayaran_id', 'tagihan_id', 'tgl_pembayaran', 'biaya_admin', 'total_bayar')
                        ->when($date1 && $date2, function ($q) use ($date1, $date2) {
                            $q->whereDate('pembayaran.created_at', '>=' ,date('Y-m-d', strtotime($date1)));
                            $q->whereDate('pembayaran.created_at', '<=' ,date('Y-m-d', strtotime($date2)));
                        })            
                        ->orderBy('pembayaran_id', 'DESC')->get();
        }
        else {
            $collection = $this->model->join('tagihan', 'tagihan.tagihan_id', 'pembayaran.tagihan_id')
                        ->select('pembayaran_id', 'pembayaran.tagihan_id', 'tgl_pembayaran', 'biaya_admin', 'total_bayar')
                        ->where('tagihan.status', '!=', 1)
                        ->when($date1 && $date2, function ($q) use ($date1, $date2) {
                            $q->whereDate('pembayaran.created_at', '>=' ,date('Y-m-d', strtotime($date1)));
                            $q->whereDate('pembayaran.created_at', '<=' ,date('Y-m-d', strtotime($date2)));
                        })            
                        ->orderBy('pembayaran_id', 'DESC');
        }

        return \DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('jmlh_meter', function($collection) {
                return $collection->Tagihan->jmlh_meter . ' / ' . \Helper::number_formats($collection->Tagihan->Pelanggan->Tarif->tarif_perkwh, 'view_currency'); 
            })
            ->editColumn('tgl_pembayaran', function($collection) {
                return \Helper::tglIndo($collection->tgl_pembayaran) ?? '-'; 
            })
            ->editColumn('biaya_admin', function($collection) {
                return \Helper::number_formats($collection->biaya_admin, 'view_currency'); 
            })
            ->editColumn('total_bayar', function($collection) {
                return \Helper::number_formats($collection->total_bayar, 'view_currency'); 
            })
            ->addColumn('action', function($row) {
                $pembayaran = (\Auth::user()->user_id == 1) ? 'pembayaran' : 'pembayaran-pelanggan';
                
                return view('partials.buttons.datatable',[
                    'show'    => route($pembayaran.'.show', \Crypt::encrypt($row->pembayaran_id)),
                ]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
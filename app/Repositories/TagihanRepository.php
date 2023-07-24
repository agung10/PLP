<?php

namespace App\Repositories;

use App\Models\{Tagihan, Penggunaan};
use App\Repositories\BaseRepository;

class TagihanRepository extends BaseRepository
{
    public function __construct(Tagihan $tagihan)
    {
        $this->model = $tagihan;
    }

    public function createTagihan($request) 
    {
        $penggunaan = Penggunaan::where('pelanggan_id', $request->pelanggan_id)->first();
        $data['penggunaan_id'] = $penggunaan->penggunaan_id;
        $data['pelanggan_id']  = $request->pelanggan_id;
        $data['status']        = 1; //Belum Dibayar
        $data['jmlh_meter']    = $penggunaan->meter_akhir - $penggunaan->meter_awal;
        $data['waktu_tagihan'] = date("Y-m-d", strtotime("+1 month", strtotime($request->waktu)));

        $this->store($data);
    }

    public function tagihanDatatable($request)
    {
        $date1 = $request->date1 ?? date('Y-m-d');
        $date2 = $request->date2 ?? date('Y-m-d');

        $collection = $this->model->select('tagihan_id', 'pelanggan_id', 'waktu_tagihan', 'jmlh_meter', 'status')
                    ->join('pelanggan', 'pelanggan.pelanggan_id', 'tagihan.pelanggan_id')
                    ->when((\Auth::user()->user_id != 1), function ($q) {
                        $q->where('pelanggan.user_id', \Auth::user()->user_id);
                    })
                    ->when($date1 && $date2, function ($q) use ($date1, $date2) {
                        // $q->whereDate('waktu_tagihan', '>=' ,date("Y-m-d", strtotime("+1 month", strtotime($date1))));
                        // $q->whereDate('waktu_tagihan', '<=' ,date("Y-m-d", strtotime("+1 month", strtotime($date2))));
                        $q->whereDate('tagihan.created_at', '>=' ,date("Y-m-d", strtotime($date1)));
                        $q->whereDate('tagihan.created_at', '<=' ,date("Y-m-d", strtotime($date2)));
                    })
                    ->orderBy('tagihan_id', 'DESC');

        return \DataTables::of($collection)
            ->addIndexColumn()
            ->editColumn('kode_pelanggan', function($collection) {
                return '<code>' . $collection->Pelanggan->no_kwh .' - '. $collection->Pelanggan->User->nama_lengkap . '</code>'; 
            })
            ->editColumn('waktu', function($collection) {
                return \Helper::tglIndo($collection->waktu_tagihan); 
            })
            ->editColumn('status', function($collection) {
                $status = '';
                if ($collection->status == 1) $status .= '<span class="badge badge-sm badge-danger">Belum Dibayar</span>';
                else $status .= '<span class="badge badge-sm badge-success">Sudah Dibayar</span>';

                return $status; 
            })
            ->addColumn('action', function($row) {
                $tagihan = (\Auth::user()->user_id == 1) ? 'tagihan' : 'tagihan-pelanggan';

                if (\Auth::user()->user_id == 1) {
                    if (!empty($row->Pembayaran)) {
                        return view('partials.buttons.datatable',[
                            'show'    => route($tagihan.'.show', \Crypt::encrypt($row->tagihan_id)),
                        ]);
                    } else {
                        return view('partials.buttons.datatable',[
                            'show'    => route($tagihan.'.show', \Crypt::encrypt($row->tagihan_id)),
                            'bayar'   => route('tagihan.pembayaranTagihan', \Crypt::encrypt($row->pelanggan_id)),
                        ]);
                    }
                } else {
                    if ($row->status == 1 && !empty($row->Pembayaran)) {
                        return view('partials.buttons.datatable',[
                            'show'  => route($tagihan.'.show', \Crypt::encrypt($row->tagihan_id)),
                            'bayar' => route('tagihan-pelanggan.pembayaranPelanggan', \Crypt::encrypt($row->tagihan_id)),
                        ]);
                    } else {
                        return view('partials.buttons.datatable',[
                            'show' => route($tagihan.'.show', \Crypt::encrypt($row->tagihan_id)),
                        ]);
                    }
                }
            })
            ->rawColumns(['action', 'kode_pelanggan', 'status'])
            ->make(true);
    }
}
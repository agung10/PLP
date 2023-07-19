<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<style>
    body { background-color: white; }
</style>

<div class="card mb-5 mb-xl-10">
    <div class="card-body p-0">
        <h3 class="mt-10 fs-1 fw-bold text-center">
            Riwayat Pembayaran 
            @if (date('m') == $bulanOrTahun) Bulan {{ date('F') }}
            @elseif (date('Y') == $bulanOrTahun) Tahun {{ date('Y') }}
            @endif
        </h3>
        
        <div class="row gx-3 gy-3">
            <div class="col-12">
                <div class="card card-dashed h-100 p-lg-3 p-5 border-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive table-data">
                                <table class="table align-middle table-row-dashed fs-6 gy-3" id="table-kehamilan">
                                    <thead class="border border-secondary border-1 bg-light-dark">
                                        <tr class="text-center text-gray-700 fw-bold fs-7 text-uppercase align-middle">
                                            <th class="min-w-50px">No</th>
                                            <th class="min-w-100px">Jumlah Meter / Tarif Per Kwh</th>
                                            <th class="min-w-100px">Tanggal Pembayaran</th>
                                            <th class="min-w-50px">Biaya Admin</th>
                                            <th class="min-w-100px">Total Bayar</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600 border border-secondary border-1">
                                        @if (count($pembayaran) > 0)
                                            @foreach ($pembayaran as $res) 
                                                <tr class="text-center">
                                                    <td class="px-2">{{ $loop->iteration }}</td>
                                                    <td>{{ $res->Tagihan->jmlh_meter . ' / ' . \Helper::number_formats($res->Tagihan->Pelanggan->Tarif->tarif_perkwh, 'view_currency') }}</td>
                                                    <td>{{ \Helper::tglIndo($res->tgl_pembayaran) }}</td>
                                                    <td>{{ \Helper::number_formats($res->biaya_admin, 'view_currency') }}</td>
                                                    <td class="px-2">{{ \Helper::number_formats($res->total_bayar, 'view_currency') }}</td>
                                                </tr>    
                                            @endforeach
                                        @else
                                            <tr class="text-center">
                                                <td colspan="5">Belum ada data</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.print();
    window.onafterprint = back;

    function back() {
        window.history.back();
    }
</script>
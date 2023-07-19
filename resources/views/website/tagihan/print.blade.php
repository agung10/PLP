<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
<style>
    body { background-color: white; }
</style>

<div class="card mb-5 mb-xl-10">
    <div class="card-body p-0">
        <h3 class="mt-10 fs-1 fw-bold text-center">
            Riwayat Tagihan 
            @if (date('m') == $bulanOrTahun) Bulan {{ date("F") }}
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
                                            <th class="min-w-100px">Pelanggan</th>
                                            <th class="min-w-100px">Waktu Tagihan</th>
                                            <th class="min-w-50px">Jumlah Meter</th>
                                            <th class="min-w-100px">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-bold text-gray-600 border border-secondary border-1">
                                        @if (count($tagihan) > 0)
                                            @foreach ($tagihan as $res) 
                                                <tr class="text-center">
                                                    <td class="px-2">{{ $loop->iteration }}</td>
                                                    <td>{{ $res->Pelanggan->no_kwh . ' - ' . $res->Pelanggan->User->nama_lengkap }}</td>
                                                    <td>{{ \Helper::tglIndo($res->waktu_tagihan) }}</td>
                                                    <td>{{ $res->jmlh_meter }}</td>
                                                    <td>
                                                        @if ($res->status == 1) Belum Dibayar
                                                        @else Sudah Dibayar
                                                        @endif
                                                    </td>
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
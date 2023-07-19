@extends('layouts.base')
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        <div class="d-flex justify-content-between mt-n3 mb-5">
			<div class="col-12">
				<div class="row">
					<div class="col-3 col-form-label text-end">
						<label>Rentang Tanggal:</label>
					</div>
					<div class="col-3">
						<input type="text" name="choose_date_1" class="form-control form-control-solid-bg text-center" placeholder="Pilih Tanggal">
					</div>
					<div class="col-1 col-form-label text-center">s/d</div>
					<div class="col-3">
						<input type="text" name="choose_date_2" class="form-control form-control-solid-bg text-center" placeholder="Pilih Tanggal">
					</div>
					<div class="col-2">
						<button type="button" id="reset" class="btn btn-light-info w-100">Reset</button>
					</div>
				</div>
			</div>
		</div>
        <hr>

        <div class="row">
            <div class="offset-lg-7 offset-6 col-lg-5 col-6">
                <a href="{{ route('laporan.printPembayaran', date('m')) }}" class="btn btn-light-primary border border-primary border-1 btn-sm">Print / bulan sekarang</a>
                <a href="{{ route('laporan.printPembayaran', date('Y')) }}" class="btn btn-light-info border border-info border-1 btn-sm">Print / tahun sekarang</a>
            </div>
        </div>
        {{-- @if (\Auth::user()->user_id == 1) @include('partials.buttons.add', ['text' => 'Tambah Pembayaran']) @endif --}}
        <table id="table" class="table table-row-bordered gy-5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jumlah Meter / Tarif Per Kwh</th>
                    <th>Tanggal Pembayaran</th>
                    <th>Biaya Admin</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script src="assets/plugins/dataTables/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/dataTables/js/dataTables.bootstrap5.min.js"></script>
<script>
$(function () {
    let today = new Date();
    var currentDate = today.getFullYear() + '-' + ('0' + (today.getMonth()+1)).slice(-2) + '-' + today.getDate();
    makeDataTable(currentDate, currentDate);

    $('input[name=choose_date_1], input[name=choose_date_2]').on('change', () => {
        const selectedDate = $('input[name=choose_date_1]').val();
        const selectedDate2 = $('input[name=choose_date_2]').val();

        $('#table').DataTable().destroy();
        makeDataTable(selectedDate, selectedDate2);
    })

    function makeDataTable(selectedDate, selectedDate2) {
        var t = $("#table").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route($link) }}',
                data: { date1: selectedDate, date2: selectedDate2 }
            },
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', class:'text-center', orderable:false, searchable:false, width:'10%'},
                {data: 'jmlh_meter', name: 'pembayaran.tagihan_id'},
                {data: 'tgl_pembayaran', name: 'pembayaran.tgl_pembayaran'},
                {data: 'biaya_admin', name: 'pembayaran.biaya_admin'},
                {data: 'total_bayar', name: 'pembayaran.total_bayar'},
                {data: 'action', orderable:false, searchable: false, className: 'text-center', width: "25%"},
            ],
            "drawCallback": function(settings) {},            
            pageLength: 10,
        });

        t.on('draw', function () {
            KTMenu.createInstances();
        });
    }

    $('#reset').click(function(){
        $('input[name=choose_date_1], input[name=choose_date_2]').val(today.getDate() + '-' + ('0' + (today.getMonth()+1)).slice(-2) + '-' + today.getFullYear()).trigger('change');

        $('#table').DataTable().destroy();
        makeDataTable(currentDate, currentDate);
    });

    $('input[name=choose_date_1], input[name=choose_date_2]').daterangepicker({
        singleDatePicker:true,
        showDropdowns: true,
        locale : {
            format : 'DD-MM-YYYY'
        }
    });
});
</script>
@include('partials.datatable-delete', ['text' => __('pembayaran'), 'table' => '#table'])
@endsection
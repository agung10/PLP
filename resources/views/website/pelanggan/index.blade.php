@extends('layouts.base')
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        @include('partials.buttons.add', ['text' => 'Tambah Pelanggan'])
        <table id="table" class="table table-row-bordered gy-5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Pelanggan</th>
                    <th>Nama Lengkap</th>
                    <th>No Kwh</th>
                    <th>Daya / Tarif per Kwh</th>
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
    var t = $("#table").DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route($link) }}',
        columns: [
            {data: 'DT_RowIndex', name:'DT_RowIndex', class:'text-center', orderable:false, searchable:false, width:'10%'},
            {data: 'kode_pelanggan', name: 'pelanggan.kode_pelanggan'},
            {data: 'nama_lengkap', name: 'pelanggan.user_id'},
            {data: 'no_kwh', name: 'pelanggan.no_kwh'},
            {data: 'tarif', name: 'pelanggan.tarif_id'},
            {data: 'action', orderable:false, searchable: false, className: 'text-center', width: "25%"},
        ],
        "drawCallback": function(settings) {},            
            pageLength: 10,
        });
    });
</script>
@include('partials.datatable-delete', ['text' => __('pelanggan'), 'table' => '#table'])
@endsection
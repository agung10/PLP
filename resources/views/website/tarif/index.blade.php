@extends('layouts.base')
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        @include('partials.buttons.add', ['text' => 'Tambah Tarif Listrik'])
        <table id="table" class="table table-row-bordered gy-5">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Daya (VA)</th>
                    <th>Tarif/Kwh</th>
                    <th>Tanggal dibuat</th>
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
        ajax: '{{ route('tarif-listrik.ajaxDatatable') }}',
        columns: [
            {data: 'DT_RowIndex', name:'DT_RowIndex', class:'text-center', orderable:false, searchable:false, width:'10%'},
            {data: 'daya', name: 'tarif.daya'},
            {data: 'tarif_perkwh', name: 'tarif.tarif_perkwh'},
            {data: 'created_at', name: 'tarif.created_at'},
            {data: 'action', orderable:false, searchable: false, className: 'text-center', width: "25%"},
        ],
        "drawCallback": function(settings) {},            
            pageLength: 10,
        });
    });
</script>
@include('partials.datatable-delete', ['text' => __('tarif listrik'), 'table' => '#table'])
@endsection
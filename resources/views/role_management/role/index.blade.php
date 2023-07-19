@extends('layouts.base') 
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        @include('partials.buttons.add', ['text' => 'Tambah Role'])
        <table id="table" class="table table-row-bordered gy-5">
            <thead>
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    <th>No</th>
                    <th>Role name</th>
                    <th>Description</th>
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
        ajax: '{{ route('role.ajaxDatatable') }}',
        columns: [
            { data: "rownum", searchable: false, width: "10%" },
            { data: "role_name", name: "role.role_name" },
            { data: "description", name: "role.description" },
            { data: "action", orderable: false, searchable: false, className: "text-center", width: "25%" },
        ],
        pageLength: 10,
    });
});
</script>
@include('partials.datatable-delete', ['text' => __('role'), 'table' => '#table'])
@endsection
@extends('layouts.base') 
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        @include('partials.buttons.add', ['text' => 'Tambah Permission'])
        <table id="table" class="table dataTable table-row-bordered table-hover gy-5">
         <thead>
            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
               <th>No</th>
               <th>Permission name</th>
               <th>Action</th>
               <th>Dibuat pada</th>
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
       var t = $('#table').DataTable({
         processing: true,
         serverSide: true,
         ajax: '{{ route('permission.ajaxDatatable') }}',
         columns: [
             {data: 'rownum', searchable: false, width: '10%' },
             {data: 'permission_name', name: 'permission.permission_name'},
             {data: 'permission_action', name: 'permission.permission_action'},
             {data: 'created_at', name: 'permission.created_at'},
             {data: 'action', orderable:false, searchable: false, className: 'text-center', width: "25%"},
         ],
         "drawCallback": function(settings) {
         //
             },            
             pageLength: 10,
             // stateSave: true,
         });
   });
   
</script>
@include('partials.datatable-delete', ['text' => __('permission'), 'table' => '#table'])
@endsection
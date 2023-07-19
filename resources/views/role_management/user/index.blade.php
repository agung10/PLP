@extends('layouts.base') 
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        @include('partials.buttons.add', ['text' => 'Tambah User'])
        <table id="table" class="table table-row-bordered gy-5">
           <thead>
              <tr>
                 <th>No</th>
                 <th>Username</th>
                 <th>Email</th>
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
         ajax: '{{ route('user.ajaxDatatable') }}',
         columns: [
             { data: "rownum", searchable: false, width: "10%" },
             {data: 'username', name: 'user.username'},
             {data: 'email', name: 'user.email'},
             {data: 'created_at', name: 'user.created_at'},
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
@include('partials.datatable-delete', ['text' => __('user'), 'table' => '#table'])
@endsection
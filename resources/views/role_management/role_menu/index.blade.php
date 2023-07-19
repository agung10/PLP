@extends('layouts.base') 
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        <table id="table" class="table dataTable table-row-bordered table-hover gy-5">
           <thead>
              <tr>
                 <th>No</th>
                 <th>Nama Role</th>
                 <th>Menu</th>
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
         ajax: '{{ route('role-menu.ajaxDatatable') }}',
         columns: [
             {data: 'rownum', searchable: false, width: '10%' },
             {data: 'role_name', name: 'role.role_name', width: '20%' },
             {data: 'menu', orderable:false, searchable: false},
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
@endsection
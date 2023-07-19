@extends('layouts.base') 
@section('content')
<link href="assets/plugins/dataTables/css/bootstrap5.min.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="card-body pt-9 pb-0">
        @include('partials.alert')
        @include('partials.buttons.add', ['text' => 'Tambah Menu'])
        <table id="table" class="table table-row-bordered gy-5">
           <thead>
              <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                 <th>No</th>
                 <th>Nama</th>
                 <th>Route</th>
                 <th>Parent</th>
                 <th>Status</th>
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
         ajax: '{{ route('menu.ajaxDatatable') }}',
         columns: [
             {data: 'rownum', searchable: false, width: '10%' },
             {data: 'name', name: 'menu.name'},
             {data: 'route', name: 'menu.route'},
             {data: 'parent', name: 'menu.id_parent'},
             {data: 'status', name: 'menu.is_active'},
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
@include('partials.datatable-delete', ['text' => __('menu'), 'table' => '#table', 'reload' => true])
@endsection
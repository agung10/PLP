{{-- SHOW BUTTON --}}
@if ( isset($show) && in_array("show", $availablePermission) )
	<a title="Show details" href="{{ $show }}" class="btn btn-light-primary btn-sm btn-show-datatable">
		<i class="fa fa-search"></i>
	</a>
@endif
{{-- EDIT BUTTON --}}
@if ( isset($edit) && in_array("edit", $availablePermission) )
    <a title="Edit details" href="{{ $edit }}" class="btn btn-light-primary btn-sm btn-edit-datatable">
     	<i class="fa fa-edit"></i>
    </a>
@endif
{{-- DESTROY BUTTON --}}
@if ( isset($destroy) && in_array("destroy", $availablePermission) )
    <a title="Delete" href="{{ $destroy }}" class="btn btn-light-primary btn-sm btn-delete-datatable">
    	<i class="fa fa-trash"></i>
    </a>
@endif

{{-- CUSTOM BUTTON --}}
@if ( isset($bayar) )
    <a title="Bayar Tagihan" href="{{ $bayar }}" class="btn btn-light-primary btn-sm btn-bayar-tagihan">
    	<i class="fa fa-money-bill-wave"></i>
    </a>
@endif
@if(in_array('create', $availablePermission))
	<a href="{{ isset($route) ? $route : \Request::url() . '/create' }}" class="btn btn-primary"> 
	<span class="fa fa-plus"></span>
		{{ isset($text) ? $text : 'Tambah Data' }} 
	</a>
@endif
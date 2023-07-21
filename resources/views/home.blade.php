@extends('layouts.base')

@section('content')
<div class="col-xxl-6">
	<div class="card card-flush h-md-100"> 
		<div class="card-body d-flex flex-column justify-content-between bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" style="background-position: 100% 50%; background-image:url('/metronic8/demo1/assets/media/stock/900x600/42.png')">     
			<div class="fs-2hx fw-bold text-gray-800 text-center">
				<span class="me-2">
					Selamat Datang, 
					<span class="position-relative d-inline-block text-danger">
						<a href="javascript:;" class="text-danger opacity-75-hover">{{ \Auth::user()->nama_lengkap }}</a>  
						<span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
					</span>                     
				</span>                    
			</div>
			<img class="mx-auto h-150px h-lg-200px" src="https://u7.uidownload.com/vector/118/456/vector-electricity-icon-pack-eps-svg.jpg" alt="">   
		</div>
	</div>    
</div>
@endsection

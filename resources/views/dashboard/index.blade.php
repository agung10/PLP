@extends('layouts.base')

@section('content')
	@if (\Auth::user()->user_id == 1)
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
	@else 
		<div class="card-spacer">
			<div class="row">
				<div class="col-md-4 mb-5">
                    <!--begin::Stats Widget 30-->
                    <div class="card card-custom bg-primary bg-hover-state-primary card-stretchmb-0">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center my-3">
                                <div class="d-flex flex-column text-center">
                                    <span class="text-white fw-bold fs-1">
                                        <span class="count-number-pbb text-white">{{ $sumJmlhMeterB }} meter</span>
                                    </span>
                                    <span class="text-white fw-bold fs-4">Penggunaan Listrik Bulan Ini</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 30-->
                </div>

				<div class="col-md-4 mb-5">
                    <!--begin::Stats Widget 30-->
                    <div class="card card-custom bg-info bg-hover-state-info card-stretchmb-0">
                        <!--begin::Body-->
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-center my-3">
                                <div class="d-flex flex-column text-center">
                                    <span class="text-white fw-bold fs-1">
                                        <span class="count-number-pbb text-white">{{ $sumJmlhMeterT }} meter</span>
                                    </span>
                                    <span class="text-white fw-bold fs-4">Penggunaan Listrik Tahun Ini</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Stats Widget 30-->
                </div>
			</div>
		</div>
	@endif
@endsection

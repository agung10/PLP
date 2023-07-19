@extends('layouts.base')

@section('content')
	@if (\Auth::user()->user_id == 1)
		<div class="img-responsive" style="background-image: url('https://assets.jenius.com/assets/2019/09/16100306/Tagihan_Listrik.png');height: 500px;background-size: cover;" />
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

@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Tagihan
            </h1>
            <div class="p-5">
              <form class="kt-form kt-form--fit kt-form--label-right">
                @csrf
                  <div class="row">                     
                    <div class="mb-5 col-lg-6">
                      <label class="form-label">Pelanggan</label>
                      <input type="text" class="form-control form-control-solid" value="{{ $data->Pelanggan->no_kwh . ' - ' . $data->Pelanggan->User->nama_lengkap }}" disabled>
                    </div>

                    @include('partials.form-input', [
                    'title' => __('Jumlah Meter'),
                    'type' => 'text',
                    'name' => 'jmlh_meter',
                    'placeholder' => true,
                    'value' => $data->jmlh_meter,
                    'multiColumn' => true,
                    'attribute' => ['disabled']
                    ])

                    @include('partials.form-input', [
                    'title' => __('Waktu Tagihan'),
                    'type' => 'text',
                    'name' => 'waktu_tagihan',
                    'placeholder' => true,
                    'value' => $data->waktu_tagihan,
                    'multiColumn' => true,
                    'attribute' => ['disabled']
                    ])

                    @include('partials.form-input', [
                    'title' => __('Status'),
                    'type' => 'text',
                    'name' => 'waktu_tagihan',
                    'placeholder' => true,
                    'value' => ($data->status == 1) ? 'Belum Dibayar' : 'Sudah Dibayar',
                    'multiColumn' => true,
                    'attribute' => ['disabled']
                    ])

                    @include('partials.form-input', [
                      'title'       => __('Dibuat pada'),
                      'name'        => 'created_at',
                      'type'        => 'text',
                      'value'       => Helper::tglIndo($data->created_at),
                      'attribute'   => ['disabled'],
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Diubah pada'),
                      'name'        => 'created_at',
                      'type'        => 'text',
                      'value'       => Helper::tglIndo($data->updated_at),
                      'attribute'   => ['disabled'],
                      'multiColumn' => true
                    ])
                  </div>
                  <div class="mt-10">
                    @include('partials.buttons.submit', ['noSubmit' => true])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
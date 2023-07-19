@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Pembayaran
            </h1>
            <div class="p-5">
              <form class="kt-form kt-form--fit kt-form--label-right">
                @csrf
                  <div class="row">                     
                    <div class="mb-5 col-lg-6">
                      <label class="form-label">Pelanggan</label>
                      <input type="text" class="form-control form-control-solid" value="{{ $data->Tagihan->Pelanggan->no_kwh . ' - ' . $data->Tagihan->Pelanggan->User->nama_lengkap }}" disabled>
                    </div>

                    @include('partials.form-input', [
                      'title' => __('Tanggal Pembayaran'),
                      'type' => 'text',
                      'name' => 'tgl_pembayaran',
                      'placeholder' => true,
                      'value' => !empty($data->tgl_pembayaran) ? \Helper::tglIndo($data->tgl_pembayaran) : '',
                      'multiColumn' => true,
                      'attribute' => ['disabled']
                      ])

                    @include('partials.form-input', [
                    'title' => __('Jumlah Meter'),
                    'type' => 'text',
                    'name' => 'jmlh_meter',
                    'placeholder' => true,
                    'value' => $data->Tagihan->jmlh_meter,
                    'multiColumn' => true,
                    'attribute' => ['disabled']
                    ])

                    @include('partials.form-input', [
                    'title' => __('Tarif per Kwh'),
                    'type' => 'text',
                    'name' => 'tarif_perkwh',
                    'placeholder' => true,
                    'value' => \Helper::number_formats($data->Tagihan->Pelanggan->Tarif->tarif_perkwh, 'view_currency'),
                    'multiColumn' => true,
                    'attribute' => ['disabled']
                    ])

                    @include('partials.form-input', [
                    'title' => __('Biaya Admin'),
                    'type' => 'text',
                    'name' => 'biaya_admin',
                    'placeholder' => true,
                    'value' => \Helper::number_formats($data->biaya_admin, 'view_currency'),
                    'multiColumn' => true,
                    'attribute' => ['disabled']
                    ])

                    @include('partials.form-input', [
                    'title' => __('Total Bayar'),
                    'type' => 'text',
                    'name' => 'total_bayar',
                    'placeholder' => true,
                    'value' => \Helper::number_formats($data->total_bayar, 'view_currency'),
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
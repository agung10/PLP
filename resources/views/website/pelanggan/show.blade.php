@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Pelanggan
            </h1>
            <div class="p-5">
              <form class="kt-form kt-form--fit kt-form--label-right">
                @csrf
                  <div class="row">                     
                    @include('partials.form-input', [
                      'title'       => __('Kode Pelanggan'),
                      'type'        => 'text',
                      'name'        => 'kode_pelanggan',
                      'attribute'   => ['disabled'],
                      'value'       => $data->kode_pelanggan,
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Nama Lengkap'),
                      'type'        => 'text',
                      'name'        => 'user_id',
                      'attribute'   => ['disabled'],
                      'value'       => $data->User->nama_lengkap ?? '-',
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('No Kwh'),
                      'type'        => 'text',
                      'name'        => 'no_kwh',
                      'attribute'   => ['disabled'],
                      'value'       => $data->no_kwh,
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Daya / Tarif per Kwh'),
                      'type'        => 'text',
                      'name'        => 'tarif_id',
                      'attribute'   => ['disabled'],
                      'value'       => $data->Tarif->daya .'VA / '. \Helper::number_formats($data->Tarif->tarif_perkwh, 'view_currency'),
                      'multiColumn' => true
                    ])
                    @include('partials.form-textarea', [
                      'title'       => __('Alamat'),
                      'type'        => 'text',
                      'name'        => 'alamat',
                      'attribute'   => ['disabled'],
                      'value'       => $data->alamat,
                      'gridClass'   => 'col-12'
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
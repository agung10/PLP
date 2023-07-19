@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Tarif Listrik
            </h1>
            <div class="p-5">
              <form class="kt-form kt-form--fit kt-form--label-right">
                @csrf
                  <div class="row">                     
                    @include('partials.form-input', [
                      'title'       => __('Daya (VA)'),
                      'type'        => 'text',
                      'name'        => 'daya',
                      'attribute'   => ['disabled'],
                      'value'       => $data->daya
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Tarif per Kwh'),
                      'type'        => 'text',
                      'name'        => 'tarif_perkwh',
                      'attribute'   => ['disabled'],
                      'value'       => \Helper::number_formats($data->tarif_perkwh, 'view_currency')
                    ])
                    
                    @include('partials.form-input', [
                      'title'       => __('Dibuat pada'),
                      'name'        => 'created_at',
                      'type'        => 'text',
                      'value'       => Helper::tglIndo($data->created_at),
                      'attribute'   => ['disabled'],
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Diubah pada'),
                      'name'        => 'created_at',
                      'type'        => 'text',
                      'value'       => Helper::tglIndo($data->updated_at),
                      'attribute'   => ['disabled'],
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
@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Ubah Penggunaan
      </h1>
      <div class="p-5">
        <form id="form-edit-penggunaan" action="{{ route($link, \Crypt::encrypt($data->penggunaan_id)) }}" method="post" enctype="multipart/form-data" class="form-cms">
          @csrf
          {{ method_field('PATCH') }}

          <div class="row">
            <div class="mb-5 col-lg-6">
              <label class="form-label">Pelanggan</label>
              <input type="text" class="form-control form-control-solid-bg" value="{{ $data->Pelanggan->no_kwh . ' / ' . $data->Pelanggan->User->nama_lengkap }}" disabled>
              <input type="hidden" name="pelanggan_id" value="{{ $data->pelanggan_id }}">
            </div>

            @include('partials.form-input', [
              'title' => __('Waktu'),
              'type' => 'text',
              'name' => 'waktu',
              'placeholder' => true,
              'value' => date('d-m-Y', strtotime($data->waktu)),
              'required' => true,
              'multiColumn' => true
              ])

              @include('partials.form-input', [
              'title' => __('Meter Awal'),
              'type' => 'text',
              'name' => 'meter_awal',
              'placeholder' => true,
              'value' => $data->meter_awal,
              'required' => true,
              'multiColumn' => true
              ])

              @include('partials.form-input', [
              'title' => __('Meter Akhir'),
              'type' => 'text',
              'name' => 'meter_akhir',
              'placeholder' => true,
              'value' => $data->meter_akhir,
              'required' => true,
              'multiColumn' => true
              ])
          </div>
          <div class="mt-10">
            @include('partials.buttons.submit')
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\PenggunaanRequest', '#form-edit-penggunaan') !!}

<script>
  $("input[name=meter_awal], input[name=meter_akhir]").keyup(function() {
      var $this = $(this);
      $this.val($this.val().replace(/[^\d.]/g, ''));        
  });

  $('input[name=waktu]').daterangepicker({
      singleDatePicker:true,
      showDropdowns: true,
      timePicker24Hour : true,
      locale : {
          format : 'DD-MM-YYYY'
      }
  });
</script>
@endsection
@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Tambah Penggunaan
      </h1>
      <div class="p-5">
        <form id="form-create-penggunaan" action="{{ route($link) }}" method="post" enctype="multipart/form-data" class="form-cms">
          @csrf

          <div class="kt-portlet__body">
            <div class="row">
              <div class="mb-5 col-lg-6">
                <label class="form-label">
                  <span style="color:red">*</span>
                  Pelanggan
                </label>

                <select name="pelanggan_id" class="form-control form-control-solid-bg" data-control="select2" data-placeholder="-- Pilih Pelanggan --">
                  <option></option>
                  @foreach ($dataPelanggan as $res)
                    <option value="{{ $res->pelanggan_id }}">{{ $res->no_kwh .' / '. $res->User->nama_lengkap }}</option>
                  @endforeach
                </select>
              </div>

              @include('partials.form-input', [
              'title' => __('Waktu'),
              'type' => 'text',
              'name' => 'waktu',
              'placeholder' => true,
              'required' => true,
              'multiColumn' => true
              ])

              @include('partials.form-input', [
              'title' => __('Meter Awal'),
              'type' => 'text',
              'name' => 'meter_awal',
              'placeholder' => true,
              'required' => true,
              'multiColumn' => true
              ])

              @include('partials.form-input', [
              'title' => __('Meter Akhir'),
              'type' => 'text',
              'name' => 'meter_akhir',
              'placeholder' => true,
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
{!! JsValidator::formRequest('App\Http\Requests\PenggunaanRequest', '#form-create-penggunaan') !!}

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
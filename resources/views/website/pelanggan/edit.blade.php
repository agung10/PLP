@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Ubah Pelanggan
      </h1>
      <div class="p-5">
        <form id="form-edit-pelanggan" action="{{ route($link, \Crypt::encrypt($data->pelanggan_id)) }}" method="post" enctype="multipart/form-data" class="form-cms">
          @csrf
          {{ method_field('PATCH') }}

          <div class="row">
            @if (\Auth::user()->user_id == 1)
              @include('partials.form-select', [
              'title' => __('Nama Lengkap'),
              'type' => 'text',
              'name' => 'user_id',
              'data' => $users,
              'selected' => $data->user_id,
              'required' => true,
              'gridClass' => 'col-12'
              ])
            @endif

            @include('partials.form-input', [
              'title' => __('No Kwh'),
              'type' => 'text',
              'name' => 'no_kwh',
              'required' => true,
              'value' => $data->no_kwh,
              'gridClass' => 'col-lg-6'
            ])
            <div class="mb-5 col-lg-6">
              <label class="form-label">
                <span style="color:red">*</span>
                Daya / Tarif per Kwh
              </label>

              <select name="tarif_id" class="form-control form-control-solid-bg" data-control="select2" data-placeholder="-- Pilih Tarif --">
                <option></option>
                @foreach ($dataTarif as $res)
                  <option value="{{ $res->tarif_id }}" {{ $res->tarif_id == $data->tarif_id ? 'selected' : '' }}>{{ $res->daya .'VA / '. \Helper::number_formats($res->tarif_perkwh, 'view_currency') }}</option>
                @endforeach
              </select>
            </div>
            @include('partials.form-textarea', [
              'title' => __('Alamat'),
              'name' => 'alamat',
              'required' => true,
              'value' => $data->alamat,
              'gridClass' => 'col-12'
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
{!! JsValidator::formRequest('App\Http\Requests\PelangganRequest', '#form-edit-pelanggan') !!}

<script>
  $("input[name=no_kwh]").keyup(function() {
      var $this = $(this);
      $this.val($this.val().replace(/[^\d.]/g, ''));        
  });
</script>
@endsection
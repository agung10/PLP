@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Tambah Pelanggan
      </h1>
      <div class="p-5">
        <form id="form-create-pelanggan" action="{{ route($link) }}" method="post"
          enctype="multipart/form-data" class="form-cms">
          @csrf

          <div class="kt-portlet__body">
            <div class="row">
              @if (\Auth::user()->user_id == 1)
                @include('partials.form-select', [
                'title' => __('Nama Lengkap'),
                'type' => 'text',
                'name' => 'user_id',
                'data' => $users,
                'required' => true,
                'gridClass' => 'col-12'
                ])
              @endif

              @include('partials.form-input', [
              'title' => __('No KWH'),
              'type' => 'text',
              'name' => 'no_kwh',
              'placeholder' => true,
              'required' => true,
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
                    <option value="{{ $res->tarif_id }}">{{ $res->daya .'VA / '. \Helper::number_formats($res->tarif_perkwh, 'view_currency') }}</option>
                  @endforeach
                </select>
              </div>

              @include('partials.form-textarea', [
              'title' => __('Alamat'),
              'name' => 'alamat',
              'placeholder' => true,
              'required' => true,
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
{!! JsValidator::formRequest('App\Http\Requests\PelangganRequest', '#form-create-pelanggan') !!}

<script>
  $("input[name=no_kwh]").keyup(function() {
      var $this = $(this);
      $this.val($this.val().replace(/[^\d.]/g, ''));        
  });
</script>
@endsection
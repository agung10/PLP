@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Tambah Tarif Listrik
      </h1>
      <div class="p-5">
        <form id="form-create-tarif" action="{{ route('tarif-listrik.store') }}" method="post" enctype="multipart/form-data" class="form-cms">
          @csrf

          <div class="kt-portlet__body">
            <div class="row">
              @include('partials.form-input', [
              'title' => __('Daya (VA)'),
              'type' => 'text',
              'name' => 'daya',
              'placeholder' => true,
              'required' => true,
              ])
              @include('partials.form-input', [
              'title' => __('Tarif per Kwh'),
              'type' => 'text',
              'name' => 'tarif_perkwh',
              'placeholder' => true,
              'required' => true,
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
{!! JsValidator::formRequest('App\Http\Requests\TarifRequest', '#form-create-tarif') !!}

<script>
  $("input[name=daya], input[name=tarif_perkwh]").keyup(function() {
      var $this = $(this);
      $this.val($this.val().replace(/[^\d.]/g, ''));        
  });
</script>
@endsection
@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Tambah Tagihan
      </h1>
      <div class="p-5">
        <form id="form-create-tagihan" action="{{ route('tagihan.store') }}" method="post" enctype="multipart/form-data" class="form-cms">
          @csrf

          <div class="kt-portlet__body">
            <div class="row">
              <div class="mb-5 col-lg-8">
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
              'title' => __('Jumlah Meter'),
              'type' => 'text',
              'name' => 'jmlh_meter',
              'placeholder' => true,
              'required' => true,
              'attribute' => ['readonly']
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
{!! JsValidator::formRequest('App\Http\Requests\TagihanRequest', '#form-create-tagihan') !!}

<script>
  $('body').on('change', 'select[name=pelanggan_id]', function() {
    let pelanggan_id = $(this).val();

    $.ajax({
      type: "GET",
      url: '{{ route("tagihan.getDataPenggunaan") }}',
      dataType: 'JSON',
      data: { pelanggan_id },
      success: function(response) {
        $('input[name=jmlh_meter]').val(response.jmlhMeter);
      },
    });
  });
</script>
@endsection
@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Pembayaran
      </h1>
      <div class="p-5">
        <form id="form-create-pembayaran" action="{{ route($link) }}" method="post" enctype="multipart/form-data" class="form-cms">
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
              'title' => __('Biaya Admin'),
              'type' => 'text',
              'name' => 'biaya_admin',
              'placeholder' => true,
              'required' => true,
              'attribute' => ['readonly']
              ])

              @include('partials.form-input', [
              'title' => __('Total Bayar'),
              'type' => 'text',
              'name' => 'total_bayar',
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
{!! JsValidator::formRequest('App\Http\Requests\PembayaranRequest', '#form-create-pembayaran') !!}

<script>
  $('body').on('change', 'select[name=pelanggan_id]', function() {
    let pelanggan_id = $(this).val();

    $.ajax({
      type: "GET",
      url: '{{ route("pembayaran.getDataPelanggan") }}',
      dataType: 'JSON',
      data: { pelanggan_id },
      success: function(response) {
        $('input[name=total_bayar]').val(response.totalBiaya);
        $('input[name=biaya_admin]').attr('readonly', false);

        $("input[name=biaya_admin]").keyup(function() {
            var $this = $(this);
            $this.val($this.val().replace(/[^\d.]/g, ''));        

            let biaya_admin = Number($('input[name=biaya_admin]').val());
            let total = response.totalBiaya + biaya_admin;
            
            $('input[name=total_bayar]').val(total);
        });
      },
    });
  });
</script>
@endsection
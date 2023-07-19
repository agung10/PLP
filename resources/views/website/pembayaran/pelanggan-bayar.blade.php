@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Pembayaran
      </h1>
      <div class="p-5">
        <form id="form-create-pembayaran-pelanggan" action="{{ route($link, \Crypt::encrypt($dataPembayaran->pembayaran_id)) }}" method="post" enctype="multipart/form-data" class="form-cms">
          @csrf
          {{ method_field('PATCH') }}

          <div class="kt-portlet__body">
            <div class="row">
              @include('partials.form-input', [
              'title' => __('Pelanggan'),
              'type' => 'text',
              'name' => 'pelanggan_id',
              'placeholder' => true,
              'required' => true,
              'attribute' => ['disabled'],
              'value'     => $dataPembayaran->Tagihan->Pelanggan->no_kwh . ' - ' . $dataPembayaran->Tagihan->Pelanggan->User->nama_lengkap
              ])

              @include('partials.form-input', [
              'title' => __('Biaya Admin'),
              'type' => 'text',
              'name' => 'biaya_admin',
              'placeholder' => true,
              'required' => true,
              'attribute' => ['disabled'],
              'value'     => $dataPembayaran->biaya_admin
              ])

              @include('partials.form-input', [
              'title' => __('Total Bayar'),
              'type' => 'text',
              'name' => 'total_bayar',
              'placeholder' => true,
              'required' => true,
              'attribute' => ['disabled'],
              'value'     => $dataPembayaran->total_bayar
              ])

              @include('partials.form-input', [
                'title' => __('Bayar'),
                'type' => 'text',
                'name' => 'pelanggan_bayar',
                'placeholder' => true,
                'required' => true,
              ])
              <span class="form-label text-danger mt-n3">Harus memasukkan nominal yang pas</span>
            </div>

            <div class="mt-10">
              @include('partials.buttons.submit')
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\PembayaranRequest', '#form-create-pembayaran-pelanggan') !!}

<script>
  $("input[name=pelanggan_bayar]").keyup(function() {
      var $this = $(this);
      $this.val($this.val().replace(/[^\d.]/g, ''));        

      // let biaya_admin = Number($('input[name=biaya_admin]').val());
      // let total = response.totalBiaya + biaya_admin;
      
      // $('input[name=total_bayar]').val(total);
  });
</script>

@if(Session::has('gagal-bayar'))
    <script>
        Swal.fire('Masukkan pembayaran sesuai dengan total bayar', '@lang("db.failed_saved")', 'error')
    </script>
@endif
@endsection
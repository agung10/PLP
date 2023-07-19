@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Tambah Role
            </h1>
            <div class="p-5">
                <form id="form-create-role" action="{{ route('role.store') }}" method="post" class="form-cms">
                    @csrf
                        @include('partials.form-input', [
                          'title'       => __('Nama Role'),
                          'type'        => 'text',
                          'name'        => 'role_name',
                          'required'    => true,
                          'placeholder' => true
                        ])
                        @include('partials.form-textarea', [
                          'title'       => __('Deskripsi'),
                          'name'        => 'description',
                          'placeholder' => '(Opsional)'
                        ])
                    <div class="mt-10">
                        @include('partials.buttons.submit')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\RoleManagement\RoleRequest', '#form-create-role') !!}
@endsection

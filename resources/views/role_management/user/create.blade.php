@extends('layouts.base')
@section('content')
<div class="card mb-5 mb-xxl-8">
  <div class="pb-10">
    <div class="card-body pt-9 pb-0">
      <h1 class="anchor fw-bold mb-5">
        Tambah User
      </h1>
      <div class="p-5">
        <form id="form-create-user" action="{{ route('user.store') }}" method="post" enctype="multipart/form-data"
          class="form-cms">
          @csrf
          <div class="kt-portlet__body">
            <div class="row">
              @include('partials.form-input', [
              'title' => __('Nama Lengkap'),
              'type' => 'text',
              'name' => 'nama_lengkap',
              'placeholder' => true,
              'required' => true,
              'multiColumn' => true
              ])
              @include('partials.form-input', [
              'title' => __('Username'),
              'type' => 'text',
              'name' => 'username',
              'placeholder' => true,
              'required' => true,
              'multiColumn' => true
              ])
              @include('partials.form-input', [
              'title' => __('Email'),
              'type' => 'email',
              'name' => 'email',
              'placeholder' => true,
              'required' => true,
              'multiColumn' => true
              ])
              @include('partials.form-select', [
              'title' => __('Role'),
              'name' => 'role',
              'data' => $roles,
              'required' => true,
              'multiColumn' => true
              ])
            </div>
            <div class="row">
              @include('partials.form-input', [
              'title' => __('Password'),
              'type' => 'password',
              'name' => 'password',
              'placeholder' => true,
              'required' => true,
              'multiColumn' => true,
              'attribute' => ['autocomplete']
              ])
              @include('partials.form-input', [
              'title' => __('Password Confirmation'),
              'type' => 'password',
              'name' => 'password_confirmation',
              'placeholder' => true,
              'required' => true,
              'multiColumn' => true,
              'attribute' => ['autocomplete']
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
{!! JsValidator::formRequest('App\Http\Requests\RoleManagement\UserRequest', '#form-create-user') !!}
@endsection
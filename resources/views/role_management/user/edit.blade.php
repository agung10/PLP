@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Ubah User
            </h1>
            <div class="p-5">
              <form id="form-edit-user" action="{{ route('user.update', $user->user_id) }}" method="post" enctype="multipart/form-data" class="form-cms">
                @csrf
                {{ method_field('PATCH') }}
                  <div class="row">                     
                    @include('partials.form-input', [
                      'title'       => __('Nama Lengkap'),
                      'type'        => 'text',
                      'name'        => 'nama_lengkap',
                      'required'    => true,
                      'multiColumn' => true,
                      'value'       => $user->nama_lengkap
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Username'),
                      'type'        => 'text',
                      'name'        => 'username',
                      'required'    => true,
                      'multiColumn' => true,
                      'value'       => $user->username
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Email'),
                      'type'        => 'email',
                      'name'        => 'email',
                      'required'    => true,
                      'multiColumn' => true,
                      'value'       => $user->email
                    ])
                    @include('partials.form-select', [
                      'title'       => __('Role'),
                      'name'        => 'role',
                      'data'        => $roles,
                      'required'    => true,
                      'multiColumn' => true,
                      'selected'    => $user->role->role_id
                    ])
                  </div>
                  <div class="row">
                    @include('partials.form-input', [
                      'title'       => __('Password'),
                      'type'        => 'password',
                      'name'        => 'password',
                      'multiColumn' => true,
                      'attribute' => ['autocomplete']
                    ])   
                    @include('partials.form-input', [
                      'title'       => __('Password Confirmation'),
                      'type'        => 'password',
                      'name'        => 'password_confirmation',
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
{!! JsValidator::formRequest('App\Http\Requests\RoleManagement\UserRequest', '#form-edit-user') !!}
@endsection
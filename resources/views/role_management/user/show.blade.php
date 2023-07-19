@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail User
            </h1>
            <div class="p-5">
              <form class="kt-form kt-form--fit kt-form--label-right">
                @csrf
                  <div class="row">                     
                    @include('partials.form-input', [
                      'title'       => __('Nama Lengkap'),
                      'type'        => 'text',
                      'name'        => 'nama_lengkap',
                      'attribute'   => ['disabled'],
                      'multiColumn' => true,
                      'value'       => $user->nama_lengkap
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Username'),
                      'type'        => 'text',
                      'name'        => 'username',
                      'attribute'   => ['disabled'],
                      'multiColumn' => true,
                      'value'       => $user->username
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Email'),
                      'type'        => 'text',
                      'name'        => 'email',
                      'attribute'   => ['disabled'],
                      'multiColumn' => true,
                      'value'       => $user->email
                    ]) 
                    @include('partials.form-input', [
                      'title'       => __('Role'),
                      'name'        => 'role',
                      'type'        => 'text',
                      'multiColumn' => true,
                      'value'       => $user->role->role_name,
                      'attribute'   => ['disabled'],
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Dibuat pada'),
                      'name'        => 'created_at',
                      'type'        => 'text',
                      'multiColumn' => true,
                      'value'       => Helper::tglIndo($user->created_at),
                      'attribute'   => ['disabled'],
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Diubah pada'),
                      'name'        => 'created_at',
                      'type'        => 'text',
                      'multiColumn' => true,
                      'value'       => Helper::tglIndo($user->updated_at),
                      'attribute'   => ['disabled'],
                    ])
                  </div>
                  <div class="mt-10">
                    @include('partials.buttons.submit', ['noSubmit' => true])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
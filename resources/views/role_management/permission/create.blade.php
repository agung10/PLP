@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Tambah Permission
            </h1>
            <div class="p-5">
              <form id="form-create-permission" action="{{ route('permission.store') }}" method="post" class="form-cms">
                @csrf
                  <div class="row">
                    @include('partials.form-input', [
                      'title'       => __('Permission Name'),
                      'type'        => 'text',
                      'name'        => 'permission_name',
                      'required'    => true,
                      'placeholder' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Permission Action'),
                      'type'        => 'text',
                      'name'        => 'permission_action',
                      'required'    => true,
                      'placeholder' => true
                    ])
                    @include('partials.form-textarea', [
                      'title'       => __('Description'),
                      'name'        => 'description',
                      'required'    => true,
                      'placeholder' => true
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
{!! JsValidator::formRequest('App\Http\Requests\RoleManagement\PermissionRequest', '#form-create-permission') !!}
@endsection
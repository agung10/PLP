@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Ubah Role
            </h1>
            <div class="p-5">
              <form id="form-update-role" action="{{ route('role.update', $role->role_id) }}" method="post" class="form-cms">
                @csrf
                {{ method_field('PATCH') }}
                  <div class="row">
                    @include('partials.form-input', [
                      'title'       => __('Role Name'),
                      'type'        => 'text',
                      'name'        => 'role_name',
                      'required'    => true,
                      'placeholder' => true,
                      'value'       => $role->role_name
                    ])
                    @include('partials.form-textarea', [
                      'title'       => __('Description'),
                      'name'        => 'description',
                      'placeholder' => true,
                      'value'       => $role->description
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
{!! JsValidator::formRequest('App\Http\Requests\RoleManagement\RoleRequest', '#form-update-role') !!}
@endsection

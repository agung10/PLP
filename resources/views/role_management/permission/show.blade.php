@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Permission
            </h1>
            <div class="p-5">
              <div class="row">
                @include('partials.form-input', [
                  'title'       => __('Permission Name'),
                  'type'        => 'text',
                  'name'        => 'permission_name',
                  'required'    => true,
                  'attribute'   => ['disabled'],
                  'value'       => $permission->permission_name
                ])
                @include('partials.form-input', [
                  'title'       => __('Permission Action'),
                  'type'        => 'text',
                  'name'        => 'permission_action',
                  'required'    => true,
                  'attribute'   => ['disabled'],
                  'value'       => $permission->permission_action
                ])
                @include('partials.form-textarea', [
                  'title'       => __('Description'),
                  'name'        => 'description',
                  'required'    => true,
                  'attribute'   => ['disabled'],
                  'value'       => $permission->description
                ])
                @include('partials.form-input', [
                  'title'       => __('Dibuat pada'),
                  'type'        => 'text',
                  'name'        => 'created_at',
                  'required'    => true,
                  'attribute'   => ['disabled'],
                  'value'       => Helper::tglIndo($permission->created_at)
                ])
                @include('partials.form-input', [
                  'title'       => __('Diubah pada'),
                  'type'        => 'text',
                  'name'        => 'updated_at',
                  'required'    => true,
                  'attribute'   => ['disabled'],
                  'value'       => Helper::tglIndo($permission->updated_at)
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

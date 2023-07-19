@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Role
            </h1>
            <div class="p-5">
                @include('partials.form-input', [
                  'title'       => __('Role Name'),
                  'type'        => 'text',
                  'name'        => 'role_name',
                  'attribute'   => ['disabled'],
                  'value'       => $role->role_name
                ])
                @include('partials.form-textarea', [
                  'title'       => __('Description'),
                  'name'        => 'description',
                  'attribute'   => ['disabled'],
                  'value'       => $role->description
                ])
                @include('partials.form-input', [
                  'title'       => __('Dibuat pada'),
                  'type'        => 'text',
                  'name'        => 'created_at',
                  'attribute'   => ['disabled'],
                  'value'       => Helper::tglIndo($role->created_at)
                ])
                @include('partials.form-input', [
                  'title'       => __('Diubah pada'),
                  'type'        => 'text',
                  'name'        => 'updated_at',
                  'attribute'   => ['disabled'],
                  'value'       => Helper::tglIndo($role->updated_at)
                ])
                <div class="mt-10">
                    @include('partials.buttons.submit', ['noSubmit' => true])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

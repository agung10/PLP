@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Tambah Menu
            </h1>
            <div class="p-5">
              <form id="form-create-menu" action="{{ route('menu.store') }}" method="post" class="form-cms">
                @csrf
                  <div class="row">
                    @include('partials.form-input', [
                      'title'       => __('Nama Menu'),
                      'type'        => 'text',
                      'name'        => 'name',
                      'required'    => true,
                      'placeholder' => true,
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Route'),
                      'type'        => 'text',
                      'name'        => 'route',
                      'placeholder' => true,
                      'multiColumn' => true
                    ])
                  </div>
                  <div class="row">
                    @include('partials.form-select', [
                      'title'       => __('Menu induk'),
                      'name'        => 'id_parent',
                      'data'        => $menuList,
                      'required'    => true,
                      'placeholder' => true,
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Icon'),
                      'type'        => 'text',
                      'name'        => 'icon',
                      'placeholder' => true,
                      'multiColumn' => true
                    ])  
                  </div>
                  <div class="row"> 
                    @include('partials.form-select', [
                      'title'       => __('Status'),
                      'name'        => 'is_active',
                      'data'        => $statusList,
                      'required'    => true,
                      'placeholder' => true,
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Urutan menu'),
                      'type'        => 'number',
                      'name'        => 'order',
                      'placeholder' => true,
                      'required'    => true,
                      'multiColumn' => true
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
{!! JsValidator::formRequest('App\Http\Requests\RoleManagement\MenuRequest', '#form-create-menu') !!}
@endsection
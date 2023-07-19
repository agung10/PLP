@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Ubah Menu
            </h1>
            <div class="p-5">
              <form id="form-update-menu" action="{{ route('menu.update', $menu->menu_id) }}" method="post" class="form-cms">
                @csrf
                {{ method_field('PATCH') }}
                  <div class="row">
                    @include('partials.form-input', [
                      'title'       => __('Nama Menu'),
                      'type'        => 'text',
                      'name'        => 'name',
                      'required'    => true,
                      'value'       => $menu->name,
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Route'),
                      'type'        => 'text',
                      'name'        => 'route',
                      'value'       => $menu->route,
                      'multiColumn' => true
                    ])
                  </div>
                  <div class="row">
                    @include('partials.form-select', [
                      'title'       => __('Menu induk'),
                      'name'        => 'id_parent',
                      'data'        => $menuList,
                      'required'    => true,
                      'selected'    => $menu->id_parent ?? '0', // jika null maka menu induknya root menu
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Icon'),
                      'type'        => 'text',
                      'name'        => 'icon',
                      'value'       => $menu->icon,
                      'multiColumn' => true
                    ])  
                  </div>
                  <div class="row"> 
                    @include('partials.form-select', [
                      'title'       => __('Status'),
                      'name'        => 'is_active',
                      'data'        => $statusList,
                      'required'    => true,
                      'selected'    => $menu->is_active,
                      'multiColumn' => true
                    ])
                    @include('partials.form-input', [
                      'title'       => __('Urutan menu'),
                      'type'        => 'number',
                      'name'        => 'order',
                      'value'       => $menu->order,
                      'required'    => true,
                      'multiColumn' => true
                    ])
                  </div>
                <div class="form-actions">
                  @include('partials.buttons.submit')
                </div>
              </form>
            </div>
        </div>
    </div>
</div>
{!! JsValidator::formRequest('App\Http\Requests\RoleManagement\MenuRequest', '#form-update-menu') !!}
@endsection
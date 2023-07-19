@extends('layouts.base') 
@section('content')
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Menu
            </h1>
            <div class="p-5">
                <div class="row">
                  @include('partials.form-input', [
                    'title'       => __('Nama Menu'),
                    'type'        => 'text',
                    'name'        => 'name',
                    'value'       => $menu->name,
                    'multiColumn' => true,
                    'attribute'   => ['disabled'],
                  ])
                  @include('partials.form-input', [
                    'title'       => __('Route'),
                    'type'        => 'text',
                    'name'        => 'route',
                    'value'       => $menu->route,
                    'multiColumn' => true,
                    'attribute'   => ['disabled'],
                  ])
                </div>
                <div class="row">
                  @include('partials.form-input', [
                    'title'       => __('Menu induk'),
                    'type'        => 'text',
                    'name'        => 'id_parent',
                    'value'       => ( $menu->parentMenu() ? $menu->parentMenu()->name : '-' ),
                    'multiColumn' => true,
                    'attribute'   => ['disabled'],
                  ])
                  @include('partials.form-input', [
                    'title'       => __('Icon'),
                    'type'        => 'text',
                    'name'        => 'icon',
                    'value'       => $menu->icon,
                    'multiColumn' => true,
                    'attribute'   => ['disabled'],
                  ])   
                </div>
                <div class="row">
                  @include('partials.form-input', [
                    'title'       => __('Status'),
                    'type'        => 'text',
                    'name'        => 'icon',
                    'value'       => $menu->statusMenu(),
                    'multiColumn' => true,
                    'attribute'   => ['disabled'],
                  ])
                  @include('partials.form-input', [
                    'title'       => __('Urutan menu'),
                    'type'        => 'number',
                    'name'        => 'order',
                    'value'       => $menu->order,
                    'multiColumn' => true,
                    'attribute'   => ['disabled'],
                  ])
                </div>
                <div class="row">
                  @include('partials.form-input', [
                    'title'       => __('Dibuat pada'),
                    'name'        => 'created_at',
                    'type'        => 'text',
                    'multiColumn' => true,
                    'value'       => Helper::tglIndo($menu->created_at),
                    'attribute'   => ['disabled'],
                  ])
                  @include('partials.form-input', [
                    'title'       => __('Diubah pada'),
                    'name'        => 'created_at',
                    'type'        => 'text',
                    'multiColumn' => true,
                    'value'       => Helper::tglIndo($menu->updated_at),
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

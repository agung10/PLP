@extends('layouts.base') 
@section('content')
<link href="assets/css/pages/rolemenu.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Role Menu
            </h1>
            <div class="p-5">
                <div class="row">
                    @include('partials.form-input', [
                      'title'       => __('Nama Role'),
                      'type'        => 'text',
                      'name'        => 'name',
                      'value'       => $role->role_name,
                      'multiColumn' => true,
                      'attribute'   => ['disabled'],
                    ])
                    <div class="col-md-12">
                        <div class="role-menu-title">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <th class="font-weight-bold"><span class="title">Menu Name</span></th>
                                </thead>
                            </table>
                        </div>

                        <div class="role-menu-content">
                            <table class="table table-hover table-row-gray-300 gy-7">
                                <tbody>
                                    @foreach($roleMenu as $parent)

                                      <tr>
                                          <td class="font-weight-bold">
                                                {!! count($parent['menu']) > 0 
                                                    ? '<i class="bi bi-folder2-open"></i>' 
                                                    : '<i class="bi bi-folder-symlink-fill"></i>' 
                                                !!}
                                                {{ $parent['name'] }}
                                          </td>
                                      </tr>

                                      @foreach($parent['menu'] as $child)

                                        <tr>
                                            <td>
                                              <span class="role-menu-child">
                                                &emsp;
                                                {!! count($child['menu']) > 0 
                                                    ? '<i class="bi bi-folder2-open"></i>' 
                                                    : '<i class="bi bi-folder-symlink-fill"></i>' 
                                                !!}
                                                {{ $child['name'] }}
                                              </span>
                                            </td>
                                        </tr>

                                        @foreach($child['menu'] as $grandchild)
                                          <tr>
                                              <td>
                                                <span class="role-menu-grandchild">
                                                  &emsp;&emsp;<i class="bi bi-folder-symlink-fill"></i>
                                                  {{ $grandchild['name'] }}
                                                </span>
                                              </td>
                                          </tr>
                                        @endforeach 
                                      @endforeach 
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-10">
                    @include('partials.buttons.submit', ['noSubmit' => true])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
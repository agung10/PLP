@extends('layouts.base') 
@section('content')
<link href="assets/css/pages/rolemenu.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Detail Menu Permission
            </h1>
            <div class="p-5">
              <form>
                <div class="kt-portlet__body">
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

                      <div class="role-menu-content">
                        <table class="table table-permission table-bordered">
                          <thead class="thead-light">
                            <th class="permission-menu-name"> 
                              <b>Menu Name</b>
                            </th>
                            @foreach($permissions as $permission)
                                <th class="permission-name"> 
                                  <b>{{ $permission->permission_name }}</b>
                                </th>
                              @endforeach
                          </thead>
                          <tbody>
                            {{-- list menu --}}
                            @foreach($menuPermission as $parent)
                              <tr>
                                <td class="font-weight-bold"> 
                                  <i class="fa fa-folder-open"></i> 
                                  {{ $parent['name'] }}
                                </td>
                                
                                {{-- if have any route then show permission available --}}
                                
                                @for ($i = 0; $i < count($permissions); $i++)
                                  @if($parent['route'])
                                    <td class="permission-checkbox">
                                      <!-- checked checkbox permission -->
                                       <label>
                                         <input 
                                          type="checkbox"
                                          disabled="" 
                                          {{ 
                                            in_array( $permissionIds[$i], $parent['permissions']) 
                                              ? 'checked="checked"'
                                              : ''  
                                          }}
                                        >
                                       </label>
                                     </td>
                                  @else
                                    <td class="permission-checkbox">
                                     </td>
                                  @endif
                                @endfor
                                

                              </tr>

                              @foreach($parent['menu'] as $child)
                                <tr>
                                  <td> 
                                    <span class="role-menu-child">{{ $child['name'] }}</span>
                                  </td>

                                  {{-- if have any route then show permission available --}}
                                  @for ($i = 0; $i < count($permissions); $i++)  
                                    @if($child['route'])
                                      <td class="permission-checkbox">
                                        <!-- checked checkbox permission -->
                                         <label>
                                           <input 
                                            type="checkbox"
                                            disabled="" 
                                            {{ 
                                              in_array( $permissionIds[$i], $child['permissions']) 
                                                ? 'checked="checked"'
                                                : ''  
                                            }}
                                           >
                                         </label>
                                       </td>
                                    @else
                                      <td class="permission-checkbox">
                                      </td>
                                    @endif
                                  @endfor
                                  

                                </tr>

                                @foreach($child['menu'] as $grandchild)
                                  <tr>
                                    <td>
                                      <span class="role-menu-grandchild">
                                        {{ $grandchild['name'] }}
                                      </span>
                                    </td>

                                    {{-- if have any route then show permission available --}}
                                      @for ($i = 0; $i < count($permissions); $i++)  
                                        @if($grandchild['route'])
                                          <td class="permission-checkbox">
                                            <!-- checked checkbox permission -->
                                             <label>
                                               <input 
                                                type="checkbox"
                                                disabled="" 
                                                {{ 
                                                  in_array( $permissionIds[$i], $grandchild['permissions']) 
                                                    ? 'checked="checked"'
                                                    : ''  
                                                }}
                                               >
                                             </label>
                                           </td>
                                        @else
                                          <td class="permission-checkbox">
                                          </td>
                                        @endif
                                      @endfor
                                    

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
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
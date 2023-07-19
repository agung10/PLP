@extends('layouts.base') 
@section('content')
<link href="assets/css/pages/rolemenu.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Ubah Menu Permission
            </h1>
            <div class="p-5">
              <form id="form-update-menu-permission" action="{{ route('menu-permission.update', $role->role_id) }}" method="post">
                @csrf
                {{ method_field('PATCH') }}
                  <div class="row">
                    @include('partials.form-input', [
                      'title'       => __('Role Name'),
                      'type'        => 'text',
                      'name'        => 'role_name',
                      'value'       => $role->role_name,
                      'multiColumn' => true,
                      'attribute'   => ['disabled'],
                    ])
                    
                    <div class="col-md-12">
                      <div class="permission-menu-content">
                        <table class="table table-permission table-bordered">
                          <thead class="thead-light">
                            <th class="permission-menu-name"> 
                              <b>Menu Name</b>
                            </th>
                            @foreach($permissions as $permission)
                                <th class="permission-name">
                                  <b>{{ $permission->permission_name }}</b>
                                  <br />
                                    <input 
                                      type="checkbox"
                                      data-type="parent"
                                      data-route="{{ $permission->permission_action }}"
                                      data-permission-id={{ $permission->permission_id }}
                                    >
                                </th>
                              @endforeach
                          </thead>
                          <tbody>
                            @if(count($menuPermission) == 0)
                              <tr>
                                <td class="text-center" colspan="{{ count($permissions) + 1 }}"> 
                                  <b>Role ini tidak mendapatkan akses menu</b>
                                </td>
                              </tr>
                            @else
                              {{-- list menu --}}
                              @foreach($menuPermission as $parent)
                                <tr>
                                  <td class="font-weight-bold"> 
                                    {!! count($parent['menu']) > 0 
                                        ? '<i class="bi bi-folder2-open"></i>' 
                                        : '<i class="bi bi-folder-fill"></i>' 
                                    !!}
                                    {{ $parent['name'] }}
                                  </td>
                                  
                                  {{-- if have any route then show permission available --}}
                                  
                                  @for ($i = 0; $i < count($permissions); $i++)
                                    @if($parent['route'])
                                      <td class="permission-checkbox">
                                        <!-- checked checkbox permission -->
                                         <label>
                                           <input 
                                            name="permissions"
                                            data-menu="{{ $parent['menu_id'] }}"
                                            data-permission-id="{{ $permissionIds[$i] }}"
                                            type="checkbox"
                                            data-route="{{ $permissions[$i]->permission_action }}"
                                            {{ 
                                              in_array( $permissionIds[$i], $parent['permissions']) 
                                                ? 'checked="checked"'
                                                : ''  
                                            }}
                                          >
                                         </label>
                                       </td>
                                    @else
                                      <td>
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
                                              name="permissions"
                                              data-menu="{{ $child['menu_id'] }}"
                                              data-permission-id="{{ $permissionIds[$i] }}"
                                              data-route="{{ $permissions[$i]->permission_action }}"
                                              type="checkbox"
                                              {{ 
                                                in_array( $permissionIds[$i], $child['permissions']) 
                                                  ? 'checked="checked"'
                                                  : ''  
                                              }}
                                             >
                                           </label>
                                         </td>
                                      @else
                                        <td>
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
                                                  name="permissions"
                                                  data-menu="{{ $grandchild['menu_id'] }}"
                                                  data-permission-id="{{ $permissionIds[$i] }}"
                                                  data-route="{{ $permissions[$i]->permission_action }}"
                                                  type="checkbox"
                                                  {{ 
                                                    in_array( $permissionIds[$i], $grandchild['permissions']) 
                                                      ? 'checked="checked"'
                                                      : ''  
                                                  }}
                                                 >
                                               </label>
                                             </td>
                                          @else
                                            <td>
                                            </td>
                                          @endif
                                        @endfor
                                      

                                    </tr>
                                  @endforeach
                                
                                @endforeach

                              @endforeach
                            @endif
                          </tbody>
                        </table>
                  </div>
                </div>
              </div>
              <div class="mt-10">
                        @include('partials.buttons.submit')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

// global variable that will be updated each checkbox clicked
let constructedMenuPermission = [];
constructMenuPermission()  // construct data menu permission

function constructMenuPermission() {
  let menuPermissions   = @json($menuPermission); // menu permission from controller

  for(let parent of menuPermissions) {
    pushPermission(parent)

    for(let child of parent.menu) {
      pushPermission(child)

      for(let grandchild of child.menu) {
        pushPermission(grandchild)
      }
    }
  }  
}

// push permission into variable constructedMenuPermission
function pushPermission(obj) {
  // only menu with exist route which can be updated
  if(obj.route) {
    let menuPermission = {
      'menu_id': obj.menu_id,
      'permissions': obj.permissions.map(String) // turn array integer into array string
    }

    constructedMenuPermission.push(menuPermission) 
  }
}

function removeFromArray(arr, item) {
  let index = arr.indexOf(item);
  
  if (index !== -1) arr.splice(index, 1);
}

/*** event on click ***/

// on click "select all permission" on menu permission
$('input[type=checkbox][data-type=parent]').on('click', function() {
  let permissionName = this.getAttribute('data-route')
  let permissionId   = this.getAttribute('data-permission-id')
  let checkboxBelow  = document.querySelectorAll('[data-route="'+ permissionName +'"]');
  let isChecked      = this.checked

  // update checkbox below
  for (let checkbox of checkboxBelow) {
    checkbox.checked = isChecked
  }

  // update constructedMenuPermission
  for(let menu of constructedMenuPermission) {
    const { permissions } = menu
    if(isChecked) {
      permissions.indexOf(permissionId) === -1 && permissions.push(permissionId) 
    }
    else {
      removeFromArray(permissions, permissionId)  
    }
  }
})

function notifyError() {
  Swal.fire('Error', '@lang("db.failed_saved")', 'error')
}

// on click "single permission" on menu permission
$('input[name=permissions]').on('click', function() {
  let isChecked    = this.checked
  let menuId       = this.getAttribute('data-menu')
  let permissionId = this.getAttribute('data-permission-id')

  // update constructedMenuPermission
  for(let menu of constructedMenuPermission) {
    const { menu_id, permissions } = menu
    if(menuId == menu_id){
      if(isChecked) {
        permissions.indexOf(permissionId) === -1 && permissions.push(permissionId) 
      }
      else {
        removeFromArray(permissions, permissionId)  
      }
    }
  }
})

$("#form-update-menu-permission").submit(async function(e){
  e.preventDefault()
  $('.btn-submit').button('loading')
  
  const url = this.getAttribute('action')
  const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    formData.append('menu_permission', JSON.stringify(constructedMenuPermission));

  const response = await fetch(url, {
      body: formData,
      method: 'POST',
    })
    .then(res => res.json())
    .catch(err => notifyError())
  
  if(response && response.status) {
    Swal.fire('Sukses', '@lang("db.saved")', 'success')
    window.location = "{{ route('menu-permission.index') }}"
  }
  else {
    notifyError()
  }
});

</script>
@endsection
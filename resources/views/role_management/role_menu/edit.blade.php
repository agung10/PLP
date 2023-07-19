@extends('layouts.base') 
@section('content')
<link href="assets/css/pages/rolemenu.css" rel="stylesheet" type="text/css" />
<div class="card mb-5 mb-xxl-8">
    <div class="pb-10">
        <div class="card-body pt-9 pb-0">
            <h1 class="anchor fw-bold mb-5">
                Ubah Role Menu
            </h1>
            <div class="p-5">
                <form id="form-update-role-menu" action="{{ route('role-menu.update', $role->role_id) }}" method="post" class="form-cms">
                    @csrf {{ method_field('PATCH') }}
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
                            <div class="role-menu-title">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <th class="font-weight-bold"><b>Menu Name</b></th>
                                    </thead>
                                </table>
                            </div>

                            <div class="role-menu-content">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach($roleMenu as $parent)

                                          <tr>
                                              <td class="font-weight-bold">
                                                  <label>
                                                      <input name="menu[]" type="checkbox" value="{{ $parent['menu_id'] }}" {{ $parent['active'] ? 'checked' : '' }}>
                                                      <i class="bi bi-folder2-open"></i>
                                                      {{ $parent['name'] }}
                                                  </label>
                                              </td>
                                          </tr>

                                          @foreach($parent['menu'] as $child)

                                            <tr>
                                                <td>
                                                    <label class="role-menu-child">
                                                        <input name="menu[]" type="checkbox" data-parent="{{ $parent['menu_id'] }}" value="{{ $child['menu_id'] }}" {{ $child['active'] ? 'checked' : '' }}>
                                                        {!! count($child['menu']) > 0 
                                                            ? '<i class="bi bi-folder2-open"></i>' 
                                                            : '' 
                                                        !!}
                                                        {{ $child['name'] }}
                                                    </label>
                                                </td>
                                            </tr>

                                            @foreach($child['menu'] as $grandchild)
                                              <tr>
                                                  <td>
                                                      <label class="role-menu-grandchild">
                                                          <input name="menu[]" type="checkbox" data-parent="{{ $child['menu_id'] }}" value="{{ $grandchild['menu_id'] }}" {{ $grandchild['active'] ? 'checked' : '' }}> {{ $grandchild['name']
                                                          }}
                                                      </label>
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
                        @include('partials.buttons.submit')
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

$('input[type=checkbox]').on('click', function() {
  let childs  = document.querySelectorAll('[data-parent="'+ this.value +'"]');
  let parents = document.querySelectorAll('[value="'+ this.getAttribute('data-parent') +'"]');

  // auto checked node child
  setCheckbox(childs, this.checked)

  if(this.checked) {
    // auto checked node parent if this checked
    for (let parent of parents) {
      parent.checked = this.checked
    }
  } else {
    // if this unchecked then check all sibling
    let siblings       = document.querySelectorAll('[data-parent="'+ this.getAttribute('data-parent') +'"]')
    let siblingChecked = false
    
    for (let sibling of siblings) {
      if(sibling.checked) siblingChecked = sibling.checked;
    }

    // if none checked then uncheck node parent
    if(!siblingChecked) {
      setCheckbox(parents, false)
    }

  }
    
})

// set checkbox until grandchild and grandprent if exists
function setCheckbox(elements, value) {
  for (let element of elements) {
    let childElements  = document.querySelectorAll('[data-parent="'+ element.getAttribute('value') +'"]')
    let parentElements = document.querySelectorAll('[value="'+ element.getAttribute('value') +'"]')

    for (let childElement of childElements) {
      childElement.checked = value
    }

    for (let parentElement of parentElements) {
      parentElement.checked = value
    }

    element.checked = value
  }
}

</script>
@endsection
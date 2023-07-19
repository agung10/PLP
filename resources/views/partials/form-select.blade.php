@php
    $width = isset($multiColumn) ? 'col-lg-6' : 'col-lg-8';
    $width = isset($gridClass) ? $gridClass : $width;
@endphp

<div class="mb-5 {{ $width }}">
    <label class="form-label">
        @if( isset($required) )
            <span style="color:red">*</span>
        @endif
        {{ $title }}
    </label>

    <select 
      name="{{ $name }}" 
      class="form-control 
          {{ (isset($attribute) && is_array($attribute)) && in_array('disabled', $attribute) 
              ? 'form-control-solid' 
              : 'form-control-solid-bg'
          }}"
        data-control="select2" 
        data-placeholder="-- Pilih {{ $title }} --"
      {{ (isset($attribute) ? is_array($attribute) : false) ? implode(' ',$attribute) : ''}}
      {{ isset($multiple) && $multiple === true ? 'multiple="multiple"' : '' }}
    >

      <option></option>
        @foreach($data as $key => $value)
            <option value="{{ $key }}" 
            @if(isset($selected) && !is_array($selected) && $selected== $key)
              selected
            @elseif(isset($selected) && is_array($selected) && in_array($key, $selected))
              selected
            @endif
            > 
              {!! $value !!} 
            </option>
        @endforeach
    </select>
</div>
<script>
  $("select[name='{{ $name }}']").on("select2:close", function (e) {  
      $(this).valid(); 
  });
</script>
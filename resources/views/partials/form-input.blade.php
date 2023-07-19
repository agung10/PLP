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

    <input  
        type="{{ isset($type) ? $type : 'text' }}" 
        class="form-control 
            {{ (isset($attribute) && is_array($attribute)) && in_array('disabled', $attribute) 
                ? 'form-control-solid' 
                : 'form-control-solid-bg'
            }}"
        name="{{ $name }}"
        value="{{ isset($value) ? $value : '' }}"
        spellcheck="false"

        @if( isset($placeholder) && $placeholder != '' )
            @if($placeholder === true)
                placeholder="Masukkan {{ $title }}"
            @else
                placeholder="{{ $placeholder }}"
            @endif
        @endif

        {{ (isset($attribute) ? is_array($attribute) : false) ? implode(' ',$attribute) : ''}}
    >

</div>

@if( isset($date) )
    <script>
        $('input[name={{ $name }}]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: "DD-MM-YYYY"
            },
            autoApply: true
        });
    </script>
@endif
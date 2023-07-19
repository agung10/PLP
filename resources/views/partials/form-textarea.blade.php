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

	<textarea 
		class="form-control {{ (isset($attribute) && is_array($attribute)) && in_array('disabled', $attribute) 
                ? 'form-control-solid' 
                : 'form-control-solid-bg'
            }}"
		name="{{ $name }}"
		rows="{{ isset($rows) ? $rows : '3' }}" 


		@if( isset($placeholder) )
            @if($placeholder === true)
                placeholder="Masukkan {{ $title }}"
            @else
                placeholder="{{ $placeholder }}"
            @endif
        @endif

        {{ (isset($attribute) ? is_array($attribute) : false) ? implode(' ',$attribute) : ''}}
	>{{ isset($value) ? $value : '' }}</textarea>
	@if($errors->has($name))
    	<span class="invalid-feedback" style="display: block">{{ $errors->first($name) }}</span>
    @endif
</div>

@if( isset($summernote) && $summernote === true)
	<link href="assets/plugins/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css"/>
	<script src="assets/plugins/summernote/summernote-lite.min.js"></script>
	<script src="assets/plugins/summernote/summernote-cleaner.js"></script>
	<style>
		.note-btn.active {
			background-color: #fff;
		}
		.table-bordered {
		    border: 1px solid #dee2e6;
		}
		.table {
		    width: 100%;
		    margin-bottom: 1rem;
		    color: #212529;
		}
		.table thead th {
		    vertical-align: bottom;
		    border-bottom: 2px solid #dee2e6;
		}
		.table-bordered thead td, .table-bordered thead th {
		    border-bottom-width: 2px;
		}
		.table-bordered td, .table-bordered th {
		    border: 1px solid #dee2e6;
		}
		.table td, .table th {
		    padding: 0.75rem;
		    vertical-align: top;
		    border-top: 1px solid #dee2e6;
		}
	</style>
	<script type="text/javascript">
	$(document).ready(function() {
		let insertToolbar = ['link', 'table'];

		@if( @isset($withImage) )
        	insertToolbar = ['link', 'table', 'picture']
        @endif

	  $('textarea[name={{ $name }}]').summernote({
	  	  toolbar: [
	        // [groupName, [list of button]]
	        ['style', ['bold', 'italic']],
	        ['para', ['ul', 'ol', 'paragraph']],
	        ['insert', insertToolbar],
        	['view', ['fullscreen', 'codeview', 'help']],
	      ],
	      height: '{{ isset($height) ? $height  : 300 }}', // set editor height
	      minHeight: null,             // set minimum height of editor
	      maxHeight: null,   
	      spellCheck: false,
	      disableDragAndDrop: true
	  });

	  $('.modal.note-modal').remove()

	  @if( (isset($attribute) && implode(' ',$attribute) == 'disabled') )
	    $('textarea[name={{ $name }}]').summernote('disable');
	  @endif

	});
	</script>
@endif
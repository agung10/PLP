@php
	$canStore  = Route::getCurrentRoute()->getActionMethod() === 'create' && in_array("store", $availablePermission);
	$canUpdate = Route::getCurrentRoute()->getActionMethod() === 'edit' && in_array("update", $availablePermission);
	
	$custom    = Route::getCurrentRoute()->getActionMethod() === 'pembayaranTagihan' || Route::getCurrentRoute()->getActionMethod() === 'pembayaranPelanggan';
@endphp
<div class="kt-form__actions">
    <div class="col-lg-6">
    	@if( !isset($noSubmit) )
    		{{-- check permission --}}
    		@if($canStore || $canUpdate || $custom)
	      		<button type="submit" class="btn btn-primary btn-submit">
                    <span class="indicator-label">
                    	{{( isset($dataRef) ? 'Replace' : ( isset($dataUbahMaster) ? 'Ubah' : 'Simpan' ) )}}
                    </span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Mohon Tunggu...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
	      		</button>
	      	@endif
	      &nbsp;
	    @endif
      <a href="#" class="btn btn-secondary btn-kembali">Kembali</a>
    </div>
</div>
<script>
	$(document).ready(function() { 

		@if( !isset($noSubmit) )
			// on click submit disable button submit and process
		    $('form.form-cms').on('submit', function() {
		        $(this).valid() && disableButton();
			});
	    @endif
	    // on click back button redirect to index menu page
	    $('a.btn-kembali').on('click', backToIndex);

	    function disableButton(){
	    	$('.btn-submit').attr('data-kt-indicator', 'on');
	    	$('.btn-submit').css('cursor', 'not-allowed');
		}

		function backToIndex(e){
			e.preventDefault();
			let redirect    = $('a.menu-active').attr('href');
			window.location = redirect;
		}

	}); 
</script>
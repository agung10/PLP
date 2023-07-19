$(document).ready(function() {
	/** START:: SWITCH ROLE **/
	$('body').on('click', '#switch-role', function(e){
		e.preventDefault()
		const id    = $(this).data('id')
		const url   = $('#container-switch-role').data('url');
		const token = $('meta[name=csrf-token]').attr('content');
		const data  = { role_id: id };

		$.ajax({
            headers:{'X-CSRF-TOKEN':token},
            url: url,
            type: 'POST',
            data: data,
            success: function(response) {
                const { status } = response;
                console.log(response)
                if(status)
                {
                	window.location.reload(true);
                }
                else
                {
                	swalError()
                }
            },
            error: () =>  swalError(err)
        });
	})
	/** END:: SWITCH ROLE **/

	function swalError(err = null) {
		console.log(err)
		Swal.fire({
            text: "Maaf, terjadi kesalahan teknis. Silahkan ulangi beberapa saat lagi!",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-danger",
            }
        });
	}

    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });
});

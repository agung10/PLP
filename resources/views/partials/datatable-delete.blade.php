<script>
    $(() => {
        let selector = 'a.btn-delete-datatable';
        @isset($selector)
            selector = '{{ $selector }}'
        @endisset

        $('body').on('click', selector, function(e) {
            let that = $(e.currentTarget);
            e.preventDefault()
            Swal.fire({
                title: 'Apakah anda yakin ingin menghapus data {{ $text }} ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "Ya, saya yakin!",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-dark'
                }

            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        headers: {
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: that.attr('href'),
                        type: 'DELETE'
                    })
                    .done(() => {
                        Swal.fire({
                            title: 'Data {{ $text}} berhasil dihapus',
                            icon: 'success',
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: 'btn btn-dark'
                            }
                        }).then((nextResult) => {
                          if (nextResult) {
                            @if(isset($reload))
                                window.location.reload(true);
                            @else
                                $('{{ $table }}').DataTable().ajax.reload();
                            @endif
                          }                        
                        })
                    })
                    .fail((err) => {
                        Swal.fire({
                            title: 'Terjadi kesalahan dalam menghubungi server, silahkan coba lagi...',
                            icon: 'warning',
                            customClass: {
                                confirmButton: "btn btn-primary",
                                cancelButton: 'btn btn-dark'
                            }
                        })
                    })
                }
            })
        })
    })
</script>
<script>
    jQuery(document).ready(function() {

        $("<?= $validator['selector']; ?>").each(function() {
            $(this).validate({
                errorElement: 'div',
                errorClass: 'invalid-feedback',
                errorPlacement: function(error, element) {
                    if ((element.prop('type') === 'select-one')) {
                        error.insertAfter(element.next());
                    }
                    else if( (element.prop('type') === 'select-multiple') ) {
                        element.next().find('.selection').append(error);
                    }
                    else {
                        error.insertAfter(element);
                    }
                },
                highlight: function (element) {
                    $el = $(element);
                    // select2 handler
                    if($el.attr('data-select2-id') !== typeof undefined && $el.next('.select2-container').length > 0)
                    {
                        $el.next().find('span.select2-selection--single').addClass('is-invalid').attr('style', 'border: 1px solid #f1416c !important');
                        $el.next().find('span.select2-selection--multiple').addClass('is-invalid').attr('style', 'border: 1px solid #f1416c !important');
                    }

                    // file input handler
                    else if ($el.prop('type') === 'file'){
                        let boxInput = $el.siblings('.file-preview')

                        $(boxInput).css({"border":"1px solid #f1416c"})
                    }

                    $el.removeClass('is-valid').addClass('is-invalid');
                },
                <?php if (isset($validator['ignore']) && is_string($validator['ignore'])): ?>
                    ignore: "<?= $validator['ignore']; ?>",
                <?php endif; ?>
                unhighlight: function (element) {
                    $el = $(element);

                    // select2 handler
                    if($el.attr('data-select2-id') !== typeof undefined && $el.next('.select2-container').length > 0)
                    {
                        $el.next().find('span.select2-selection--single').removeClass('is-invalid').addClass('is-valid').attr('style', 'border: 1px solid #50cd89 !important');
                        $el.next().find('span.select2-selection--multiple').removeClass('is-invalid').addClass('is-valid').attr('style', 'border: 1px solid #50cd89 !important');
                    }

                    // file input handler
                    else if ($el.prop('type') === 'file') {
                        let boxInput = $el.siblings('.file-preview')
                        $(boxInput).css({"border":"1px solid #50cd89"})
                    }

                    $el.removeClass('is-invalid').addClass('is-valid');
                },
                success: function (element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                focusInvalid: true,
                <?php if (Config::get('jsvalidation.focus_on_error')): ?>
                    invalidHandler: function (form, validator) {
                        if (!validator.numberOfInvalids())
                            return;
                        $('html, body').animate({
                            scrollTop: $(validator.errorList[0].element).offset().top
                        }, <?= Config::get('jsvalidation.duration_animate') ?>);
                    },
                <?php endif; ?>
                rules: <?= json_encode($validator['rules']); ?>
            });
        });
    });
</script>
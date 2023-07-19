<script src="{{ asset('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}">

<div class="mb-5 {{ isset($multiColumn) ? $multiColumn : 'col-lg-12' }}">
    <label class="form-label">
        @if( isset($required) )
            <span style="color:red">*</span>
        @endif
        {{ $title }}
    </label>
    
    @if( isset($disabled) )
        <br />
        @if( isset($value) && is_file( \Storage::url($value) ) )
            @if(isset($accept))
                <embed src="{{ asset('uploaded_files') . '/' . $value }}" frameborder="0" width="100%" height="500px">
            @else
                <img src="{{ asset('uploaded_files') . '/' . $value }}" class="rounded" style="width:200px"; />
            @endif
        @else
            <img src="{{ asset('uploaded_files/no-image.png') }}" class="rounded" style="width:200px"; />
        @endif
    
    @else

        <div class="kv-avatar-errors col-md-12" style="display:none"></div> 
        <div class="file-loading">
            <input name="{{ $name }}" type="file" class="form-control" accept="{{ isset($accept) ? $accept : '.png, .jpg, .jpeg' }}">
            
        </div>

        @if( isset($note) )
            <span id="allow" class="text-danger">{!! $note !!}</span>
        @else
            <span id="allow" class="text-danger">Allowed type:jpg, jpeg, png &emsp; Max Size:10MB</span>
        @endif
    @endif
</div>
<script>
@if( !isset($disabled) )
    
    var img = null

    @if( isset($value) && is_file( \Storage::url($value) ) )
        @if(isset($accept))
            img = `<div class="card-body d-flex justify-content-center text-center flex-column p-8">
                        <div class="text-gray-800 text-hover-primary d-flex flex-column">
                            <!--begin::Image-->
                            <div class="symbol symbol-60px mb-5">
                                <img src="assets/media/misc/file.png" class="theme-light-show" alt="">
                                <img src="assets/media/misc/file.png" class="theme-dark-show" alt="">
                            </div>
                            <div class="fs-5 fw-bold mb-2">{{ substr($value, strrpos($value, '/') + 1); }}</div>
                        </div>
                    </div>`;
        @else
            img = '<img class="mt-7" src="{{ asset('uploaded_files') . '/' . $value }}" alt="Your Avatar" style="width:400px;">'
        @endif
    @endif

    $("input[name={{ $name }}]").fileinput({
        showConsoleLogs: false,
        showUpload: false,
        showBrowse: false,
        fileActionSettings: {
          showZoom: false
        },
        showCancel: false,
        browseOnZoneClick: true,
        theme: 'fas',
        overwriteInitial: true,
        maxFileSize: 10000,
        showClose: false,
        showCaption: false,
        elErrorContainer: '.kv-avatar-errors',
        msgErrorClass: 'alert alert-block alert-danger',
        @if(isset($accept))
        
        @else
            allowedFileTypes: ['image'],   // allow only images
        @endif
        defaultPreviewContent: img
    });
@endif
</script>
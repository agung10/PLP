@php
	$widthProp  = isset($width) ? 'width:' . $width . ';' : '';
	$heightProp = isset($height) ? 'height:' . $height . ';' : '';
	$style = 'style=' . $widthProp . $heightProp;
@endphp

<a data-fslightbox="lightbox-basic" class="lightbox-basic symbol symbol-50px me-3" href="{{ $src }}">
	<img src="{{ $src }}" class="" alt="" {{ $style }}>
</div>

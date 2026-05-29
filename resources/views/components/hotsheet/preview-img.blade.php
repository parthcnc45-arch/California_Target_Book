
{{--
    Return with img or with default hotsheet img if no img is set
--}}

@if(!empty($img))
	@if($img[0] === '/')
	    @php($img = 'https://californiatargetbook.com' . $img)
	@endif
@endif
<?php
 $height = isset($height) ? $height : '200px';
?>

@if(!empty($img))
    <div class="preview-img loaded-img">
        <img src="{{ $img }}" class="img-fluid"  style="height: {{$height}};" />
    </div>
@else
    <div class="preview-img default-img">
        {{-- <div class="icon i-2 i-grey" style="height: {{$height}};"> @inline('/img/icons/logo.svg') </div> --}}
        <!-- {{--<img src="/images/ctb_logo_bw.png" width="48" />--}} -->
        {{-- <img src="{{ url('img/logo.svg') }}" height='200' alt="Logo" class="d-inline" /> --}}
        <img src="{{ url('img/logo.svg') }}" alt="Logo" height='175' class="d-inline" />
                            <h3 class="d-inline logo-txt"><span style="color: #D00B0B;">California</span> <span
                                    style="color: #174F7F;"> Target Book</span></h3>

    </div>
@endif

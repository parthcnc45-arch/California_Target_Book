
{{--
    Return with img or with default newsfeed img if no img is set
--}}

@if($img[0] === '/')
    @php($img = 'https://californiatargetbook.com' . $img)
@endif

@if(!empty($img))
    <div class="preview-img loaded-img">
        <img src="{{ $img }}" />
    </div>
@else
    <div class="preview-img default-img">
        <div class="icon i-2 i-grey"> @inline('/img/icons/news.svg') </div>
        {{--<img src="/images/ctb_logo_bw.png" width="48" />--}}
    </div>
@endif

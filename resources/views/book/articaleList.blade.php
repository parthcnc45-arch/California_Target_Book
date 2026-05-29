<?php

$user_id = Auth::user()->id;

?>

@foreach($other_articles as $articale)
    <div class="p-0">
      <a class="panel article-card favorite-main" data-user-id="{{$user_id}}" data-article-id="{{ $articale->id }}" data-post-id="{{ $articale->post_id }}" href="{{ route('book.hotsheet.article', ['article' => $articale->post_id ]) }}">
        <div class="ctb-blog-content">
          <div class="w-100">
            @include('components.hotsheet.preview-img', [ 'img' => $articale->preview_img ])
          </div>
          <div class="p-4">
            <h3 class="mt-0">
                {{ $articale->title }}
            </h3>


            <div class="d-flex justify-content-between">
                <p class="bg_whiteee">{{ $articale->posted_at() }}</p>
                <div id="loaderSm" class="text-center hidden">
                    <ctb-loader></ctb-loader>
                </div>
                <span class="favorite-toggle" onclick="event.preventDefault();">
                    @if ($articale->is_favorite)
                            <img width="25" src="{{ url('assets/imgs/fav.png') }}" alt="">
                        @else
                            Add To Fav?
                    @endif
                </span>
            </div>




          </div>
        </div>
      </a>
    </div>
@endforeach
<div class="my-3">
    {{ $other_articles->links() }}
</div>
@if (!count($other_articles))
    <h2>No data found</h2>
@endif

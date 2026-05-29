<div class="col-md-4">
    <div class="ctb-rabban headingDiv">
      <h5>Favorite Hot Sheets</h5>
    </div>
    <div class="ctb-fav d-flex flex-column">
        @foreach($favorite_article as $favorite)
            <div class="ctb-fav-box favorite-main" data-article-id="{{ $favorite->id }}" data-post-id="{{ $favorite->post_id }}">
                <h2><a href="/book/hotsheet/{{ $favorite->post_id }}" target="_blank" class="text-decoration-none text-black">{{ $favorite->title }}</a></h2>
                <div class="d-flex justify-content-between">
                    <span>{{ $favorite->posted_at() }}</span>
                    <div id="loaderSm" class="text-center hidden">
                        <ctb-loader></ctb-loader>
                    </div>
                    <span style="cursor: pointer;" class="favorite-toggle">
                        @if ($favorite->is_favorite)
                                <img width="25" src="{{ url('assets/imgs/fav.png') }}" alt="">
                            @else
                                <a type="button" class="text-decoration-none">Add To Fav</a>
                        @endif
                    </span>
                </div>
            </div>
        @endforeach

    </div>
</div>


<div class="container-fluid pt-lg">
    <section id="ctb-main-container-sec">
        <div class="ctb-main-container">
                <div class="row">
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div>
                                <div class="favorite-main">
                                    <h2>{{ $hotsheet->title }}</h2>
                                    <div class="d-flex justify-content-between">
                                        <span>{{ $hotsheet->posted_at() }}</span>
                                        <div id="loaderSm" class="text-center hidden">
                                            <ctb-loader></ctb-loader>
                                        </div>
                                        <span style="cursor: pointer;" class="favorite-toggle">
                                            @if ($hotsheet->favorite)
                                                    <img width="25" src="{{ url('assets/imgs/fav.png') }}" alt="">
                                                @else
                                                    <a type="button" class="text-decoration-none">Add To Fav</a>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                {!! $hotsheet->body !!}
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>
</div>


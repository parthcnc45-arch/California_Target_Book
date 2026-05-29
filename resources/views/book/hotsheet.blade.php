@extends('layouts.bookNew')

@section('title', "Hotsheet | California Target Book")
@section('bodyClasses', "hotsheet")

@section('content')
<?php $height = 'auto'; ?>
<ul class="hot-breadcumb d-flex">
    <li><a href="{{ route('book') }}" class="text-decoration-none">California Target Book</a></li>
    <li><a href="{{ route('book.hotsheet') }}" class="text-decoration-none">Hot Sheets</a></li>
    <li class="active">{{ $hotsheet->title }}</li>
</ul>
<div class="container-fluid pt-lg">
    <section id="ctb-main-container-sec">
        <div class="ctb-main-container">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ctb-rabban headingDiv d-flex justify-content-between">
                                <h5>Hot Sheets Details</h5>
                                <a href="{{ route('book.generatePDF', ['article' => $hotsheet->post_id]) }}" class="text-decoration-none" id="downloadPdfButton">Download PDF</a>
                                {{-- <form action="{{ route('book.generatePDF') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="article" value="{{ base64_encode(json_encode($hotsheet)) }}">
                                    <button type="submit" id="downloadPdfButton">Download PDF</button>
                                </form> --}}

                                <div>
                                    @if ($prev)
                                        <a href="{{ route('book.hotsheet.article', ['article' => $prev ]) }}" class="px-4 text-decoration-none">Prev</a>
                                    @endif
                                    @if ($next)
                                        <a href="{{ route('book.hotsheet.article', ['article' => $next ]) }}" class="text-decoration-none">Next</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div>
				<?php
					$user_id = Auth::user()->id;	
				?>

                                @if(Auth::check() && Auth::user()->isAdmin())
                                <a href="http://198.74.49.22/hs_editor.php?id={{$hotsheet->post_id}}"
                                        target="_blank"
                                        class="pull-right btn btn-primary mb-md">
                                    Admin Edit
                                </a>
                                @endif
                                <div class="favorite-main" data-user-id="{{$user_id}}" data-type-id="hotsheet" data-article-id="{{ $hotsheet->id }}" data-post-id="{{ $hotsheet->post_id }}">
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
                                {!! $hotsheet->text !!}
                            </div>
                        </div>
                    </div>
                </div>
                @include('book.recentHotsheets')

                {{-- <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ctb-rabban headingDiv">
                                <h5>Recent Hotsheets</h5>
                            </div>
                        </div>
                    </div>
                    @foreach($recommended_articles as $popular)
                        <div class="ctb-lastest-blog mb-3">
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    @include('components.hotsheet.preview-img', [ 'img' => $popular->preview_img ])
                                </div>
                                <div class="col-md-8">
                                    <div class="ctb-latest-blog-content">
                                        <h3>{{ $popular->title }}</h3>
                                        <p>{{ $popular->posted_at() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
    @include('book.hsFilterJs')
    <script>gtag('set', { 'book_category': 'hotsheets' });</script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection

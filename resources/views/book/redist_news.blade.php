@extends('layouts.book')

@section('title', "Redistricting News | California Target Book")
@section('bodyClasses', "hotsheet")

@section('content')
<div class="container-fluid pt-lg">
    <div class="col-lg-10 center-block fn">
        <div class="row">

            <div class="col-md-12">
                <h1 class="text-uppercase">Redistricting News</h1>
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <a href="http://198.74.49.22/news_editor.php"
                                target="_blank"
                                class="pull-right btn btn-primary mb-md">
                            Add Item
                        </a>
                        @endif

            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <a class="panel top-article" href="{{ route('book.redist_news_item.article', ['article' => $top_article->post_id ]) }}">
                            <div class="primary-content-block">
                                <div class="col-md-8 col-md-push-4 col-sm-12">
                                    @include('components.hotsheet.rn_preview-img', [ 'img' => $top_article->preview_img ])
                                </div>
                                <div class="overview col-md-4 col-md-pull-8 col-sm-12">
                                    <h5 class="text-red upper">{{ $top_article->posted_at() }}</h5>
                                    <h3>{{ $top_article->title }}</h3>
                                    <span class="read-link" >Read</span>
                                </div>

                            </div>
                        </a>
                    </div>

                </div>

                <div class="row secondary-content">
                    @foreach($secondary_articles as $hs)
                        <div class="col-md-4 secondary-content-block">
                            <a class="panel article-card" href="{{ route('book.redist_news_item.article', ['article' => $hs->post_id ]) }}">
                                <div class="article-card-head">
                                    @include('components.hotsheet.rn_preview-img', [ 'img' => $hs->preview_img ])
                                </div>
                                <div class="article-card-body">
                                    <h5 class="text-red upper">{{ $hs->posted_at() }}</h5>
                                    <h4>{{ $hs->title }}</h4>
                                    <span class="read-link">Read</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if (!empty($currentPoll))
                <div class="row">
                    <div class="col-md-12">
                        <div class="ctb-banner text-center">
                            <h5 class="upper">Target Book Insider Poll {{ $currentPoll->dateDisplay() }}</h5>
                            <h3>{{ $currentPoll->title }}</h3>
                            <p>
                                See what other Target Book Subscribers think on current issues.
                            </p>
                            <a href="{{ route('book.current-poll') }}" class="btn btn-primary">
                                Take The Poll
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row ternary-content">
                    <div class="col-md-12">
                        <ul class="row">
                            @foreach($other_articles as $hs)
                            <li class="col-sm-6">
                                <a class="panel article-teaser" href="{{ route('book.redist_news_item.article', ['article' => $hs->post_id ]) }}">
                                    <div class="preview-img">
                                        @include('components.hotsheet.rn_preview-img')
                                    </div>
                                    <div class="overview">
                                        <h5 class="text-red upper">{{ $hs->posted_at() }}</h5>
                                        <h4>{{ $hs->title }}</h4>
                                        {{--<span class="read-link">Read</span>--}}
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>

            <div class="col-md-4 col-lg-3 col-lg-offset-1">
		<!--
                <a href="{{ route('book.live_hub') }}" class="btn btn-primary btn-block mb-md">
                    View Live FPPC Filings
                    <i class="material-icons" style="vertical-align: top;">keyboard_arrow_right</i>
                </a>
		-->

                <div class="panel twitter-panel">
                    <div class="panel-heading">
                        <h4>Live Updates</h4>
                    </div>
                    <div class="panel-body">
                        <div class="twitter-list twitter_embed">
                            <a class="twitter-timeline" data-height="700" href="https://twitter.com/CTB_Redistrict">
                                Tweets from https://twitter.com/CTB_Redistrict
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
    <script>gtag('set', { 'book_category': 'hotsheets' });</script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection

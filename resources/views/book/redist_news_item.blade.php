@extends('layouts.book')

@section('title', "Newsfeed | California Target Book")
@section('bodyClasses', "hotsheet")

@section('content')
<div class="container-fluid pt-lg">
    <div class=" center-block fn">
        <div class="row">

            <div class="col-lg-7 col-lg-offset-1 col-md-8">
                <article class="panel">
                    <div>
                        @if(Auth::check() && Auth::user()->isAdmin())
                        <a href="http://198.74.49.22/news_editor.php?id={{$hotsheet->post_id}}"
                                target="_blank"
                                class="pull-right btn btn-primary mb-md">
                            Admin Edit
                        </a>
                        @endif

                        <h4 class="text-red upper pull-left">{{ $hotsheet->posted_at() }}</h4>
                        <h2 class="clear">{{ $hotsheet->title }}</h2>
                    </div>
                    <div>
                        {!! $hotsheet->body !!} 
			<a href='{{$hotsheet->post_url}}' target='_blank'>Read Full Article</a>
                    </div>
                </article>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-4">
                <div class="ternary-content">
                    <ul>
                        <li>
                            <h4>Other News Items</h4>
                        </li>
                        @foreach($recommended_articles as $hs)
                            <li class="">
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
                        <li>
                            <a class="btn btn-primary btn-block" href="{{ route('book.redist_news') }}">
                                <div class="icon i-1 i-transparent pull-left"> @inline('/img/icons/news.svg') </div>
                                Read All News Items
                            </a>
                        </li>
                    </ul>

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

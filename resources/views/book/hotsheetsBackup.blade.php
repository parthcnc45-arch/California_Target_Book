@extends('layouts.book')

@section('title', "Hotsheet | California Target Book")
@section('bodyClasses', "hotsheet")

@section('content')
<div class="container-fluid pt-lg">
    <div class="col-lg-10 center-block fn">
        <div class="row">

            <div class="col-md-12">
                <h1 class="text-uppercase">Hot Sheet</h1>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <a class="panel top-article" href="{{ route('book.hotsheet.article', ['article' => $top_article->post_id ]) }}">
                            <div class="primary-content-block">
                                <div class="col-md-8 col-md-push-4 col-sm-12">
                                    @include('components.hotsheet.preview-img', [ 'img' => $top_article->preview_img ])
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
                            <a class="panel article-card" href="{{ route('book.hotsheet.article', ['article' => $hs->post_id ]) }}">
                                <div class="article-card-head">
                                    @include('components.hotsheet.preview-img', [ 'img' => $hs->preview_img ])
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
                                <a class="panel article-teaser" href="{{ route('book.hotsheet.article', ['article' => $hs->post_id ]) }}">
                                    <div class="preview-img">
                                        @include('components.hotsheet.preview-img')
                                    </div>
                                    <div class="overview">
                                        <h5 class="text-red upper">{{ $hs->posted_at() }}</h5>
                                        <h4>{{ $hs->title }}</h4>
                                        <span class="read-link">Read</span>
                                 </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>

            <div class="col-md-4 col-lg-3 col-lg-offset-1">

		<a href="/book/dashboard" class="btn btn-success btn-block mb-mb">
			Election 2022 Dashboard
			<i class="material-icons" style="vertical-align: top;">keyboard_arrow_right</i>
		</a>

		<br>

                <a href="{{ route('book.live_hub') }}" class="btn btn-primary btn-block mb-md">
                    View Live FPPC Filings
                    <i class="material-icons" style="vertical-align: top;">keyboard_arrow_right</i>
                </a>

                <div class="panel twitter-panel">
                    <div class="panel-heading">
                        <h4>Live Updates</h4>
                    </div>
                    <div class="panel-body">
                        <div class="twitter-list twitter_embed">
                            <a class="twitter-timeline" data-height="700" href="https://twitter.com/rpyers/lists/ctb-tweets">
                                Tweets from https://twitter.com/rpyers/lists/ctb-tweets
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div> 
  <!-- Dashboard Menu Start -->

  <!-- Dashboard Breadcrumb Start-->
  {{-- <section id="ctb-breadcrumb">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="breadcrumb-content">
            <h6>
              <span class="breadcrumb-text-normal"
                >California Target Book</span
              >
              <span class="breadcrumb-text-normal active">Dashboard</span>
              <span class="breadcrumb-text-normal active">Hot Sheets</span>
            </h6>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Dashboard Breadcrumb End-->

  <!-- Dashboard Main Container Start -->
  <section id="ctb-main-container-sec">
    <div class="ctb-main-container">
      <div class="row">
        <div class="col-md-8">
          <div class="ctb-rabban">
            <h5>Hot Sheets</h5>
          </div>
          <div class="ctb-filter d-flex align-items-center">
            <div class="ctb-search-field">
              <input
                class="ctb-search"
                type="text"
                placeholder="Search Hot Sheets"
              />
            </div>
            <div class="ctb-filters-btns d-flex justify-content-end">
              <button class="ctb-sort">Sort</button>
              <button>Most Viewed</button>
              <button>Filter By Date</button>
            </div>
          </div>
          <div class="ctb-blogs d-flex flex-wrap">
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="/img/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="img/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
            <div class="ctb-blog-box">
              <img src="./assets/imgs/img-3.png" alt="One" />
              <div class="ctb-blog-content">
                <h3>
                  CD47 update, new candidates in AD52, AD48, AD23; another
                  SD03 candidate withdraws.
                </h3>
                <p>May 3, 2023</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="ctb-rabban">
            <h5>Favourite Hot Sheets</h5>
          </div>
          <div class="ctb-fav d-flex flex-column">
            <div class="ctb-fav-box">
              <h2>
                CD47 update, new candidates in AD52, AD48, AD23; another SD03
                candidate withdraws.
              </h2>
              <span>May 3, 2023</span>
            </div>
            <div class="ctb-fav-box">
              <h2>
                CD47 update, new candidates in AD52, AD48, AD23; another SD03
                candidate withdraws.
              </h2>
              <span>May 3, 2023</span>
            </div>
            <div class="ctb-fav-box">
              <h2>
                CD47 update, new candidates in AD52, AD48, AD23; another SD03
                candidate withdraws.
              </h2>
              <span>May 3, 2023</span>
            </div>
            <div class="ctb-fav-box">
              <h2>
                CD47 update, new candidates in AD52, AD48, AD23; another SD03
                candidate withdraws.
              </h2>
              <span>May 3, 2023</span>
            </div>
            <div class="ctb-fav-box">
              <h2>
                CD47 update, new candidates in AD52, AD48, AD23; another SD03
                candidate withdraws.
              </h2>
              <span>May 3, 2023</span>
            </div>
            <div class="ctb-fav-box">
              <h2>
                CD47 update, new candidates in AD52, AD48, AD23; another SD03
                candidate withdraws.
              </h2>
              <span>May 3, 2023</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> --}}

@endsection

@section('scripts')
    <script>gtag('set', { 'book_category': 'hotsheets' });</script>
    <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection


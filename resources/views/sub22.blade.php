@extends('layouts.master')

@section('title', 'California Target Book')

@section('content')

	
    <div class='jumbotron text-center sacto'>
        <h1 class='ctb_title'>California Target Book</h1>
        <h3 class='subheadline'>
                The Essential Toolbox for California Political Professionals
        </h3>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
            Subscribe
        </a>
    </div>

    <div class='container landing_page no-border'>

<!--
        <div class="row">
            <div class="col-md-12">
                <div class="ctb-banner text-center">
                    <h5 class="upper">Upcoming Event</h5>
                    <h3>All Eyes on March</h3>
                    <h3>2020 Primary Election Conference</h3>
                    <p>
                        Primary election overview including three panels on ballot measures, independent expenditures and ground campaigns.
                    </p>
                    <a href="https://www.eventbrite.com/e/california-target-book-2020-primary-election-conference-all-eyes-on-march-tickets-87727913551" class="btn btn-primary">RSVP Now</a>
                </div>
            </div>
        </div> -->

	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<h3 align='justify'>
					Keeping track of campaign news can be incredibly time consuming, especially with new legislative district lines that will be in place for the 2022 elections. With the California Target Book, you will receive Hot Sheets regularly with breaking campaign news and a website with thorough election data.
				</h3>
			</div>
		</div>
	</div>
        <div class="row">
            <div class="col-md-12">
                <div class="ctb-banner text-center">
                    <h5 class="upper">Redistricting Edition Hard Copy</h5>
                    
                    <a href="/uploaded/20210803_RedistrictingBookOrder.pdf" target='_blank'><img src='/uploaded/20210803_BookCover.jpg' width='200px'><br><br>
			<span class="btn btn-primary">Order Now</span></a>
                </div>
            </div>
	</div>


        <div class='row'>
            <div class='col-lg-12 t-justify'>
                <div class='panel'>
                    <h2>Online Edition</h2>
                    <div class='row'>
                        <div class='col-md-8'>
                            <p>
                                The California Target Book is the trusted, unbiased source of comprehensive current data for California political professionals and insiders who need to stay up to date on campaigns and elections at every level in the state.
                            </p>

                            <div id="ctB_carousel" class="carousel slide"
                                 data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#ctB_carousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#ctB_carousel" data-slide-to="1"></li>
                                    <li data-target="#ctB_carousel" data-slide-to="2"></li>
                                    <li data-target="#ctB_carousel" data-slide-to="3"></li>
                                    <li data-target="#ctB_carousel" data-slide-to="4"></li>
                                    <li data-target="#ctB_carousel" data-slide-to="5"></li>
                                    <li data-target="#ctB_carousel" data-slide-to="6"></li>
                                    <li data-target="#ctB_carousel" data-slide-to="7"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active"><img src="/img/pic_1.png" alt="Los Angeles Precinct"></div>
                                    <div class="item"><img src="/img/Slide_District.jpg" alt="District"></div>
                                    <div class="item"><img src="/img/pic_3.jpg" alt="Assembly Map"></div>
                                    <div class="item"><img src="/img/Slide_County.jpg" alt="County Page"></div>
                                    <div class="item"><img src="/img/Slide_City.jpg" alt="City Page"></div>
                                    <div class="item"><img src="/img/Slide_RedistDraft.jpg" alt="Redistricting Draft"></div>
                                    <div class="item"><img src="/img/Slide_HotSheet.jpg" alt="Hot Sheet"></div>
                                    <div class="item"><img src="/img/pic_5.png" alt="FEC Summary Report"></div>
                                </div>

                                <!-- Left and right controls -->
                                <a class="left carousel-control"
                                   href="#ctB_carousel" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control"
                                   href="#ctB_carousel" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                        </div>

                        <div class="col-md-4">

                            <div class='twitter_embed hidden-xs hidden-sm'>
                                <a class="twitter-timeline" data-height="700"
                                        href="https://twitter.com/rpyers/lists/CTB-Tweets">
                                    Tweets from https://twitter.com/rpyers/lists/CTB-Tweets
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-4 '>
                <div class='panel'>
                    <h3 class="text-center">Legislative Districts</h3>
                    <hr class='red' />
                    <p>
                        District-by-district coverage of each of California's 80 Assembly, 40 state Senate and 52 Congressional seats, including maps, vote histories, census and party registration statistics, incumbent interest group ratings and profiles of all candidates who have filed for election.
                    </p>
                </div>
            </div>

            <div class='col-md-4 '>
                <div class='panel'>
                    <h3 class="text-center">County Government</h3>
                    <hr class='blue' />
                    <p>
                       County-level data includes voter registration, past election results, interactive district maps and incumbents for each of California's 296 Supervisorial Districts in the state's 58 counties.
                    </p>
                </div>
            </div>

            <div class='col-md-4 '>
                <div class='panel'>
                    <h3 class="text-center">Ballot Initiatives</h3>
                    <hr class='yellow' />
                    <p>
                        In-depth coverage includes detailed financial data for the organizations supporting and opposing them.
                    </p>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-6 '>
                <div class='panel'>
                    <h3 class="text-center">Campaign Finance Reports</h3>
                    <hr class='green' />
                    <p>
                        Constantly updated data for Assembly, State Senate, Congressional, statewide and independent expenditure campaigns, compiled from the California Secretary of State and Federal Election Commission.
                    </p>
                </div>
            </div>

            <div class='col-md-6 '>
                <div class='panel'>
                    <h3 class="text-center">Candidate Directory</h3>
                    <hr class='midnight' />
                    <p>
                        The California Target Book has compiled election results and a searchable candidate directory for state or federal office over the last ten years and for county, local and school district offices over the last 20 years.
                    </p>
                </div>
            </div>

        </div>

        <div class='row'>
            <div class='col-lg-12 '>
                <div class='panel'>
                    <h3 class="text-center">Hot Sheet</h3>
                    <hr class='red' />
                    <p>
                        Online subscribers have access to the Hot Sheet, reporting late breaking California political developments.
                    </p>
                </div>
            </div>

            <div class='col-lg-12 '>
                <div class='panel'>
                    <h3 class="text-center">Hard Copy Edition</h3>
                    <hr class='blue' />
                    <p>
                        Many readers supplement their online subscriptions by choosing to receive the hard copy edition of the California Target Book, a handy abridged version of the information available on our web site.  It includes vote histories, voter registration and turnout data and candidate profiles.
                    </p>
                    <p>
                        Six editions are published during each election cycle, three in odd numbered off years and three in even numbered election years.
                    </p>
                </div>
            </div>

        </div>
    </div>


@endsection

@section('scripts')
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
@endsection

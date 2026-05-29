
@inject('ctbUtil', 'App\Services\CTB\Util')
@inject('propositions', 'App\Services\CTB\Propositions')
@php ($book_side_nav_active = 'propositions')

@php($votes = $propositions->getVotesFor($prop))
@php($passed = $votes['totals']['yes'] > $votes['totals']['no'])

@php($financeActivity = $propositions->getFinanceActivity($prop))

@extends('layouts.book')

@section('title', "Proposition $prop->prop_no | California Target Book")

@section('content')
    <?php
	Util::require_ctb_api();
	use App\User;
	$role = Auth::user()->role;	
     ?>
    <div>
        <div class="book-page-head row m-n">
            <div>
                <h2 class="m-n pull-left">
                    {{ $propositions->getName($prop) }}
                </h2>
            </div>

            @php ($surrounding = $propositions->getSurrounding($prop))

            <div class="dist-arrows pull-right">
                <a href="{{ route('book.propositions.show', ['id' => $surrounding['prev']->prop_id]) }}">
                    <i class="fa fa-2x fa-arrow-circle-o-left" aria-hidden="true"></i>
                    <span> {{ $propositions->getName($surrounding['prev']) }} </span>
                </a>
                <a href="{{ route('book.propositions.show', ['id' => $surrounding['next']->prop_id]) }}">
                    <i class="fa fa-2x fa-arrow-circle-o-right" aria-hidden="true"></i>
                    <span> {{ $propositions->getName($surrounding['next']) }} </span>
                </a>

            </div>

        </div>

        <div class="container-fluid pt-xl">

            <div class="row">
                <div class="col-lg-8 center-block fn">

                    <nav class='clearfix page-nav'>
                        <ul class="clearfix">
                            <li class="active" >
                                <a href='#Overview' role="tab" data-toggle="tab">
                                    <i class="material-icons">home</i>
                                    Results
                                </a>
                            </li>
                            <li>
                                <a href='#Finance' role="tab" data-toggle="tab">
                                    <i class="material-icons">attach_money</i>
                                    Finance
                                </a>
                            </li>
                            <li>
                                <a href='#Documents' role="tab" data-toggle="tab">
                                    <i class="material-icons">picture_as_pdf</i>
                                    Documents
                                </a>
                            </li>

                            @if ($propositions->getAnalysis($prop->prop_id))
                            	<li>
                            		<a href='#Analysis' role="tab" data-toggle="tab">
                            			<i class="material-icons">article</i>
                            			Analysis
                            		</a>
                            	</li>
                            @endif

                            @if ($propositions->hasAds($prop->prop_id))
                            	<li>
                            		<a href='#Ads' role="tab" data-toggle="tab">
                            			<i class="material-icons">video_label</i>
                            			Ads
                            		</a>
                            	</li>
                            @endif

                        </ul>
                    </nav>

                </div>
            </div>

            <div class="content-wrap pt-xl">
                <section id="Overview" class="active">
                    <div class="row">
                        <div class="col-lg-8 center-block fn">
                            <div class="panel">
                                @if ($prop->prop_nm)
                                    <h3>{{ $prop->prop_nm }}</h3>
                                @else
                                    <h3>Proposition {{ $propositions->getNumber($prop) }}</h3>
                                @endif

                                @if ($propositions->isPending($prop))
                                    <h4 class="text-uppercase sub">
                                        {{ $propositions->getStatus($prop) }}
                                    </h4>
                                @else
                                    <h4 class="text-uppercase {{ $passed ? 'prop-yes' : 'prop-no' }}">
                                        {{ $passed ? 'Passed' : 'Failed' }}
                                    </h4>
                                @endif

                                <h5 class="sub">
                                    FPPC ID <a href="http://cal-access.sos.ca.gov/Campaign/Measures/Detail.aspx?id={{ $prop->prop_id }}&session={{ $propositions->getYear($prop) }}"
                                            target="_blank">#{{ $prop->prop_id }}
                                        <i class="material-icons icon-sm">launch</i>
                                    </a>
                                </h5>

                                <h6 class="sub">{{ $propositions->getYear($prop) }}</h6>

                                <hr/>
                                <p>{{  $prop->prop_dscr  }}</p>


                            </div>


                            @if (($propositions->isPending($prop) && !empty($prop->sigs_deadline)) || $prop->prop_status == '2' )
                                <div class="panel p-n">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Signatures Deadline</th>
						<td><?php 
						if($prop->sigs_deadline) { 
							echo(date('F d, Y',strtotime($prop->sigs_deadline))); 
						} else {
							echo('tbd');
						} ?>
                                            </tr>
                                            <tr>
                                                <th>Signatures Needed</th>
                                                <td>{{ number_format($prop->sigs_needed) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Signatures Submitted</th>
                                                <td>{{ number_format($prop->sigs_submitted) }}</td>
                                            </tr>
                                            @if ($prop->prop_staus > 49)
                                                <tr>
                                                    <th>Valid Signatures Threshold</th>
                                                    <td>{{ number_format((($prop->sigs_needed / $prop->sigs_submitted) * 100), 2) }}%</td>
                                                </tr>
                                                <tr>
                                                    <th>Signatures Valid</th>
                                                    <td>{{ number_format($prop->sigs_valid) }}</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>

                                </div>
                            @else
                            <div class="panel">
                                <h3>Results</h3>

                                <div class="mb-md">
                                    <h5>Statewide</h5>
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <th>Yes</th>
                                            <td>{{ number_format($votes['totals']['yes']) }}</td>
                                            <td>
                                                {{ $ctbUtil->percentFormat($votes['totals']['yes'], $votes['totals']['total']) }}%
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <td>{{ number_format($votes['totals']['no']) }}</td>
                                            <td>
                                                {{ $ctbUtil->percentFormat($votes['totals']['no'], $votes['totals']['total']) }}%
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total</th>
                                            <td>{{ number_format($votes['totals']['total']) }}</td>
                                            <th class="text-uppercase text-right {{ $passed ? 'prop-yes' : 'prop-no' }}">
                                                {{ $passed ? 'Passed' : 'Failed' }}
                                            </th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="">
                                    <h5>By County</h5>

                                    <table class="table table-striped"  v-ctb-table>
                                        <thead>
                                        <tr>
                                            <th>County</th>
                                            <th>Yes</th>
                                            <th>%</th>
                                            <th>No</th>
                                            <th>%</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($votes['counties'] as $county => $countyVote)
                                            <tr>
                                                <th>{{ $ctbUtil->getCounty($county) }}</th>

                                                <td>{{ number_format($countyVote['yes']) }}</td>
                                                <td class="{{ $countyVote['yes'] > $countyVote['no'] ? 'prop-yes' : '' }}">
                                                    {{ $ctbUtil->percentFormat($countyVote['yes'], $countyVote['total']) }}%
                                                </td>

                                                <td>{{ number_format($countyVote['no']) }}</td>
                                                <td class="{{ $countyVote['yes'] < $countyVote['no'] ? 'prop-no' : '' }}">
                                                    {{ $ctbUtil->percentFormat($countyVote['no'], $countyVote['total']) }}%
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                        </div>
                    </div>

                </section>

                <section id="Finance">
                    <div class="row">
                        <div class="col-xs-12 center-block fn">

                            <div class="panel">
                                <h3>Campaign Finance Activity</h3>

                                <table class="table table-striped"  v-ctb-table>
                                    <thead>
                                        <tr>
                                            <th>Committee</th>
                                            <th></th>
                                            <th>Position</th>
                                            <th>Raised Last Period</th>
                                            <th>Raised Since</th>
                                            <th>Total Raised</th>
                                            <th>Spent This Cycle</th>
                                            <th>Last Cash On Hand</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($financeActivity['committees'] as $cmte)
                                            <tr data-committee="{{ $cmte['id'] }}">
                                                <th title='{{$cmte['consultants']}}'>{{ $cmte['name'] }}</th>
                                                <td>
                                                    <a href="https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id={{ $cmte['id'] }}" target="_blank">
                                                        <i class="material-icons">launch</i>
                                                    </a>
                                                </td>
                                                <th class="{{ $cmte['position'] === 'SUPPORT' ? 'prop-yes' : 'prop-no' }}">
                                                    {{ $cmte['position'] }}
                                                </th>
                                                <td>${{ number_format($cmte['raised_last_period']) }}</td>
                                                <td>${{ number_format($cmte['raised_since']) }}</td>
                                                <td>${{ number_format($cmte['total_raised']) }}</td>
                                                <td>${{ number_format($cmte['total_spent']) }}</td>
                                                <td>${{ number_format($cmte['cash_on_hand']) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>


                                <div class="mt-xl">
                                    <h4>Totals</h4>

                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <th>Total Raised</th>
                                            <td class="text-capitalize prop-yes">Support</td>
                                            <td>${{ number_format($financeActivity['totals']['support_raised'] , 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td class="text-capitalize prop-no">Oppose</td>
                                            <td>${{ number_format($financeActivity['totals']['oppose_raised'] , 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Spend</th>
                                            <td class="text-capitalize prop-yes">Support</td>
                                            <td>${{ number_format($financeActivity['totals']['support_spent'] , 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td class="text-capitalize prop-no">Oppose</td>
                                            <td>${{ number_format($financeActivity['totals']['oppose_spent'] , 2, '.', ',') }}</td>
                                        </tr>
                                        </tbody>

                                    </table>
                                </div>

                            </div>

                        </div>
                    </div>
                </section>

                <section id="Documents">
                    <div class="row">
                        <div class="col-lg-10 center-block fn">

                            <div class="panel">
                                <h4>Voting Guide</h4>
                                <div class="embed-responsive embed-responsive-4by3">
                                    <iframe class="embed-responsive-item" height="100%" width="100%"
                                            src="{{ $propositions->getVotingGuideURL($prop) }}#zoom=100">
                                    </iframe>
                                </div>
                            </div>

                            @if ($propositions->isPending($prop))
                                <div class="panel">
                                    <h4>Title & Summary</h4>
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <iframe class="embed-responsive-item" height="100%" width="100%"
                                                src="/docs/Props/Pending_2018/{{$prop->prop_no}}-TS.pdf#zoom=100">
                                        </iframe>
                                    </div>
                                </div>

                                <div class="panel">
                                    <h4>Fiscal Impact Estimate Report</h4>
                                    <div class="embed-responsive embed-responsive-4by3">
                                        <iframe class="embed-responsive-item" height="100%" width="100%"
                                                src="/docs/Props/Pending_2018/{{$prop->prop_no}}-FIER.pdf#zoom=100">
                                        </iframe>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </section>
                @if ($propositions->getAnalysis($prop->prop_id))
                	<section id="Analysis">
                		<div class="row">
                			<div class="col-lg-10 center-block fn">
                				<div class="panel">
                					<h4>Prop {{$prop->prop_id}} Analysis</h4>
							@if($role == "admin")
								<span><a href='http://198.74.49.22/dist_editor.php?id={{$prop->prop_id}}&yr={{$propositions->getYear($prop)}}' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>		
							@endif
                					<hr />
                					{!!$propositions->getAnalysis($prop->prop_id)!!}
                				</div>
                			</div>
                		</div>
                	</section>
                @endif

                @if ($propositions->hasAds($prop->prop_id))
                	<section id="Ads">
                		<div class="row">
                			<div class="col-lg-10 center-block fn">
                				<div class="panel">
                					<h4>Prop {{$prop->prop_id}} Ads ({{$propositions->getYear($prop)}})</h4>
                					<hr />
                					<?php
								$year = $propositions->getYear($prop);
								$fourcode = $prop->prop_id;
								include('../resources/views/old/prop_ads_panel.php');
							?>
							
                				</div>
                			</div>
                		</div>
                	</section>
                @endif


            </div>





        </div>
    </div>

@endsection
@section('scripts')
    <script>gtag('set', { 'book_category': 'propositions' });</script>

	<script type="text/javascript">
  		$(document).ready(function () {
		    $(".arrow-right").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "+=336"
		        }, 750);
		    });
		    $(".arrow-left").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "-=336"
		        }, 750);
		    });
		});
  	</script>

@endsection

@section('styles')

    <style>

  		.title {
  			width: 100%;
  			max-width: 854px;
  			margin: 0 auto;
  			font-size: 1em;
  		}

  		.caption {
  			width: 100%;
  			max-width: 854px;
  			margin: 0 auto;
  			padding: 5px 0;
  			font-size: 0.8em;
			line-height: 0.9em;

  		}

  		.container {
  			width: 100%;
  			max-width: 854px;
  			min-width: 440px;
  			background: #fff;
  			margin: 0 auto;
  		}


  		/*  VIDEO PLAYER CONTAINER
 		############################### */
  		.vid-container {
		    position: relative;
		    padding-bottom: 52%;
		    padding-top: 30px;
		    height: 0;
		}

		.vid-container iframe,
		.vid-container object,
		.vid-container embed {
		    position: absolute;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		}


		/*  VIDEOS PLAYLIST
 		############################### */
		.vid-list-container {
			width: 92%;
			overflow: hidden;
			margin-top: 20px;
			margin-left:4%;
			padding-bottom: 20px;
		}

		.vid-list {
			width: 1344px;
			position: relative;
			top:0;
			left: 0;
		}

		.vid-item {
			display: block;
			width: 148px;
			height: 148px;
			float: left;
			margin: 0;
			padding: 10px;
		}

		.thumb {
			/*position: relative;*/
			overflow:hidden;
			height: 84px;
		}

		.thumb img {
			width: 100%;
			position: relative;
			top: -13px;
		}

		.vid-item .desc {
			color: #21A1D2;
			font-size: 15px;
			margin-top:5px;
		}

		.vid-item:hover {
			background: #eee;
			cursor: pointer;
		}

		.arrows {
			position:relative;
			width: 100%;
		}

		.arrow-left {
			color: #fff;
			position: absolute;
			background: #777;
			padding: 15px;
			left: -25px;
			top: -130px;
			z-index: 99;
			cursor: pointer;
		}

		.arrow-right {
			color: #fff;
			position: absolute;
			background: #777;
			padding: 15px;
			right: -25px;
			top: -130px;
			z-index:100;
			cursor: pointer;
		}

		.arrow-left:hover {
			background: #CC181E;
		}

		.arrow-right:hover {
			background: #CC181E;
		}


		@media (max-width: 624px) {
			body {
				margin: 15px;
			}
			.caption {
				margin-top: 40px;
			}
			.vid-list-container {
				padding-bottom: 20px;
			}

			/* reposition left/right arrows */
			.arrows {
				position:relative;
				margin: 0 auto;
				width:96px;
			}
			.arrow-left {
				left: 0;
				top: -17px;
			}

			.arrow-right {
				right: 0;
				top: -17px;
			}
		}

		.greenme {
			color: green;
		}

		.redme {
			color: red;
		}

        .iframe-container {
            position: relative;
            width: 100%;
        }

        .iframe-container > * {
            display: block;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .greyColumn {
            background: #eee;
        }

    </style>


    <style>

	.greenme {
	     color: green;
	     border-color: green;
	}

        .candidate-panel {
            background-color: #fcfcfc;
            padding: 20px;
            width: 105%;
            max-width: 1190px;
            margin-right: 40px;
            margin-top: 20px;
        }

        .candidate-panel .candidate-content {
            padding: 10px;
        }

        .panel-candidate-header {
            font-weight: bold;
            font-variant: small-caps;
            text-align: right;
            font-size: 1.5em;
            box-shadow: none;
        }

        .content-header {
            text-align: center;
            font-variant: small-caps;
        }

        #years > ul li {
            list-style: none;
            padding: 5px 15px;
            display: inline-block;
            margin: 5px;
            border: 1px solid #ccc;
        }

        #years > ul li.tab-current {
            background: #ddd;
        }

        #years > ul li:hover {
            background: #eee;
        }

        .no-border {
            box-shadow: none;
        }

        .vote-tables .col-sm-3:nth-child(5) {
            clear: both !important;
        }

        .primary_table {
            font-family: 'PT Sans Narrow' !important;
        }

        .panel input {
            margin-left: 0 !important;
        }

        .tablesaw > * {
            font-family: 'PT Sans Narrow' !important;
            padding: 0.02em !important;
        }

        .tablesaw a {
            font-family: 'PT Sans Narrow' !important;
        }

        .ie_iframe {
            min-height: 800px;

        }

        .cmte_contributions td, .cmte_contributions tr, .cmte_contributions p, .cmte_contributions a {
            padding: 0.01em !important;
            line-height: 1em;
        }


    </style>


@endsection


@inject('ctbUtil', 'App\Services\CTB\Util')
@inject('propositions', 'App\Services\CTB\Propositions')
@php $book_side_nav_active = 'propositions' @endphp

@php $votes = $propositions->getVotesFor($prop) @endphp
@php $passed = $votes['totals']['yes'] > $votes['totals']['no'] @endphp

@php $financeActivity = $propositions->getFinanceActivity($prop) @endphp

@extends('layouts.book')

@section('title', "Proposition $prop->prop_no | California Target Book")

@section('content')
    <?php
        Util::require_ctb_api();
        global $prop_info;
        $prop_info = get_pending_info($prop->prop_id);
        $prop_more = get_more($prop, $prop_info);
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

            @php $surrounding = $propositions->getSurrounding($prop) @endphp

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

                            @if (!empty($prop_more['analysis']))
                                <li>
                                    <a href='#Analysis' role="tab" data-toggle="tab">
                                        <i class="material-icons">article</i>
                                        Analysis
                                    </a>
                                </li>
                            @endif

                            @if (!empty($prop_more['ads']))
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
                                @if (!empty($prop->prop_nm))
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

                                @if (!empty($prop_info))
                                <h5 class="sub">
                                    FPPC ID <a href="http://cal-access.sos.ca.gov/Campaign/Measures/Detail.aspx?id={{ $prop_info['fppc_id'] }}&session={{ $propositions->getYear($prop) }}"
                                            target="_blank">#{{ $prop_info['fppc_id'] }}
                                        <i class="material-icons icon-sm">launch</i>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                    AG ID #{{$prop_info['ag_id']}}  
                                    &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                                    SOS ID #{{$prop_info['sos_id']}}

                    <?php $fppc_id = $prop_info['fppc_id']; ?>    
                                </h5>
                                @else
                                <h5 class="sub">
                                    FPPC ID <a href="http://cal-access.sos.ca.gov/Campaign/Measures/Detail.aspx?id={{ $prop->prop_id }}&session={{ $propositions->getYear($prop) }}"
                                            target="_blank">#{{ $prop->prop_id }}
                                        <i class="material-icons icon-sm">launch</i>
                                    </a>
                                <?php $fppc_id = $prop->prop_id; ?>
                                </h5>
                                @endif


                                <h6 class="sub">{{ $propositions->getYear($prop) }}</h6>

                                <hr/>
                                <p>{{  $prop->prop_dscr  }}</p>


                            </div>


                @if(!empty($prop_info['sigs_deadline']) || (isset($prop->prop_status) && $prop->prop_status == '2'))
                    <div class="panel p-n">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Signatures Deadline</th>
                                    <td>
                                        @if(!empty($prop_info['sigs_deadline']))
                                            {{ date('F d, Y', strtotime($prop_info['sigs_deadline'])) }}
                                        @else
                                            tbd
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Signatures Needed</th>
                                    <td>{{ number_format($prop_info['sigs_needed']) }}</td>
                                </tr>
                                <tr>
                                    <th>Signatures Submitted</th>
                                    <td>{{ number_format($prop_info['sigs_submitted']) }}</td>
                                </tr>

                                @if (property_exists($prop, 'prop_status'))
                                    @if ($prop->prop_status > 49)
                                        <tr>
                                            <th>Valid Signatures Threshold</th>
                                            <td>
                                                @if($prop_info['sigs_submitted'] > 0)
                                                    {{ number_format((($prop_info['sigs_needed'] / $prop_info['sigs_submitted']) * 100), 2) }}%
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Signatures Valid</th>
                                            <td>{{ number_format($prop->sigs_valid) }}</td>
                                        </tr>
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                @endif
                <?php $vbd = load_prop_by_dist($fppc_id);               ?>

                @if(($prop->session ?? $prop->prop_session) < 2023 && !empty($votes['totals']['yes']))
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
                                    <h5>Results</h5>
                                    
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-pills mb-3" id="resultTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link active" id="county-tab" data-toggle="pill" href="#county" role="tab" aria-controls="county" aria-selected="true">County</a>
                                        </li>
                                        @if(!empty($vbd['AD']))
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="ad-tab" data-toggle="pill" href="#ad" role="tab" aria-controls="ad" aria-selected="false">AD</a>
                                        </li>
                                        @endif
                                        @if(!empty($vbd['SD']))
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="sd-tab" data-toggle="pill" href="#sd" role="tab" aria-controls="sd" aria-selected="false">SD</a>
                                        </li>
                                        @endif
                                        @if(!empty($vbd['CD']))
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="cd-tab" data-toggle="pill" href="#cd" role="tab" aria-controls="cd" aria-selected="false">CD</a>
                                        </li>
                                        @endif
                                    </ul>

                                    <!-- Tab content -->
                                    <div class="tab-content" id="resultTabsContent">
                                        <!-- County Tab -->
                                        <div class="tab-pane fade show active" id="county" role="tabpanel" aria-labelledby="county-tab">
                                            <table class="table table-striped" v-ctb-table>
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
                                        
                                        @if(!empty($vbd['AD']))
                                            <!-- AD Tab -->
                                            <div class="tab-pane fade" id="ad" role="tabpanel" aria-labelledby="ad-tab">
                                                <table class="table table-striped" v-ctb-table>
                                                    <thead>
                                                        <tr>
                                                            <th>Assembly District</th>
                                                            <th>Yes</th>
                                                            <th>%</th>
                                                            <th>No</th>
                                                            <th>%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($vbd['AD'] as $ad => $adVote)
                                                            <tr>
                                                                <th>{{ $ad }}</th>
                                                                <td>{{ number_format($adVote['yes']) }}</td>
                                                                <td class="{{ $adVote['yes'] > $adVote['no'] ? 'prop-yes' : '' }}">
                                                                    {{ $ctbUtil->percentFormat($adVote['yes'], $adVote['yes'] + $adVote['no']) }}%
                                                                </td>
                                                                <td>{{ number_format($adVote['no']) }}</td>
                                                                <td class="{{ $adVote['yes'] < $adVote['no'] ? 'prop-no' : '' }}">
                                                                    {{ $ctbUtil->percentFormat($adVote['no'], $adVote['yes'] + $adVote['no']) }}%
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        
                                        @if(!empty($vbd['SD']))
                                            <!-- SD Tab -->
                                            <div class="tab-pane fade" id="sd" role="tabpanel" aria-labelledby="sd-tab">
                                                <table class="table table-striped" v-ctb-table>
                                                    <thead>
                                                        <tr>
                                                            <th>State Senate District</th>
                                                            <th>Yes</th>
                                                            <th>%</th>
                                                            <th>No</th>
                                                            <th>%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($vbd['SD'] as $sd => $sdVote)
                                                            <tr>
                                                                <th>{{ $sd }}</th>
                                                                <td>{{ number_format($sdVote['yes']) }}</td>
                                                                <td class="{{ $sdVote['yes'] > $sdVote['no'] ? 'prop-yes' : '' }}">
                                                                    {{ $ctbUtil->percentFormat($sdVote['yes'], $sdVote['yes'] + $sdVote['no']) }}%
                                                                </td>
                                                                <td>{{ number_format($sdVote['no']) }}</td>
                                                                <td class="{{ $sdVote['yes'] < $sdVote['no'] ? 'prop-no' : '' }}">
                                                                    {{ $ctbUtil->percentFormat($sdVote['no'], $sdVote['yes'] + $sdVote['no']) }}%
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        
                                        @if(!empty($vbd['CD']))
                                            <!-- CD Tab -->
                                            <div class="tab-pane fade" id="cd" role="tabpanel" aria-labelledby="cd-tab">
                                                <table class="table table-striped" v-ctb-table>
                                                    <thead>
                                                        <tr>
                                                            <th>Congressional District</th>
                                                            <th>Yes</th>
                                                            <th>%</th>
                                                            <th>No</th>
                                                            <th>%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($vbd['CD'] as $cd => $cdVote)
                                                            <tr>
                                                                <th>{{ $cd }}</th>
                                                                <td>{{ number_format($cdVote['yes']) }}</td>
                                                                <td class="{{ $cdVote['yes'] > $cdVote['no'] ? 'prop-yes' : '' }}">
                                                                    {{ $ctbUtil->percentFormat($cdVote['yes'], $cdVote['yes'] + $cdVote['no']) }}%
                                                                </td>
                                                                <td>{{ number_format($cdVote['no']) }}</td>
                                                                <td class="{{ $cdVote['yes'] < $cdVote['no'] ? 'prop-no' : '' }}">
                                                                    {{ $ctbUtil->percentFormat($cdVote['no'], $cdVote['yes'] + $cdVote['no']) }}%
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Include Bootstrap JS and jQuery if not already included -->
                                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
                                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
                                        @if(!empty($prop_more['finance']))
                                            @foreach ($prop_more['finance'] as $cmte_id => $cmte)
                                                <tr data-committee="{{ $cmte_id }}">
                                                    <td>{{ $cmte['cmte_nm'] }}</th>
                                                    <td>
                                                        <a href="https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id={{ $cmte_id }}" target="_blank">
                                                            <i class="material-icons">launch</i>
                                                        </a>
                                                    </td>
                                                    <th class="{{ $cmte['position'] === 'SUPPORT' ? 'text-success' : 'text-danger' }}">
                                                        {{ $cmte['position'] }}
                                                    </th>
                                                    <td>${{ number_format(floatval($cmte['raised_last'])) }}</td>
                                                    <td>${{ number_format(floatval($cmte['raised_since'])) }}</td>
                                                    <td>${{ number_format(floatval($cmte['rcpt_total'])) }}</td>
                                                    <td>${{ number_format(floatval($cmte['expn_total'])) }}</td>
                                                    <td>${{ number_format(floatval($cmte['last_coh'])) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>


                                <div class="mt-xl">
                                    <h4>Totals</h4>

                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <th>Total Raised</th>
                                            <td class="text-capitalize prop-yes">Support</td>
                                            <td>${{ number_format($prop_more['totals']['sup_raised']) }}</td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td class="text-capitalize prop-no">Oppose</td>
                                            <td>${{ number_format($prop_more['totals']['opp_raised']) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Spend</th>
                                            <td class="text-capitalize prop-yes">Support</td>
                                            <td>${{ number_format($prop_more['totals']['sup_spent']) }}</td>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <td class="text-capitalize prop-no">Oppose</td>
                                            <td>${{ number_format($prop_more['totals']['opp_spent']) }}</td>
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

                            <?php
                                $agId = $prop_info['ag_id'] ?? null;
                                $filePath = base_path("resources/views/docs/Props/Pending_2018/");
                                $full = $filePath . $agId . ".pdf";
                                $ts   = $filePath . $agId . "-TS.pdf";
                                $fier = $filePath . $agId . "-FIER.pdf";

                                $showFullSubmission = $agId && file_exists($full);
                                $showTitleSummary = $agId && file_exists($ts);
                                $showFiscalImpact = $agId && file_exists($fier);
                                $showVotingGuide = !empty($prop->filename);
                                
                            ?>

                            @if($showVotingGuide || $showFullSubmission || $showTitleSummary || $showFiscalImpact)
                                <!-- Nav tabs -->
                                <ul class="nav nav-pills mb-3" id="documentTabs" role="tablist">
                                    @if($showVotingGuide)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" id="voting-guide-tab" data-toggle="pill" href="#voting-guide" role="tab" aria-controls="voting-guide" aria-selected="true">Voting Guide</a>
                                        </li>
                                    @endif
                                    @if($showFullSubmission)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ $showVotingGuide ? '' : '' }}" id="full-submission-tab" data-toggle="pill" href="#full-submission" role="tab" aria-controls="full-submission" aria-selected="{{ $showVotingGuide ? 'false' : 'true' }}">Full Submission</a>
                                        </li>
                                    @endif
                                    @if($showTitleSummary)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ ($showVotingGuide || $showFullSubmission) ? '' : '' }}" id="title-summary-tab" data-toggle="pill" href="#title-summary" role="tab" aria-controls="title-summary" aria-selected="{{ ($showVotingGuide || $showFullSubmission) ? 'false' : 'true' }}">Title & Summary</a>
                                        </li>
                                    @endif
                                    @if($showFiscalImpact)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link {{ ($showVotingGuide || $showFullSubmission || $showTitleSummary) ? '' : '' }}" id="fiscal-impact-tab" data-toggle="pill" href="#fiscal-impact" role="tab" aria-controls="fiscal-impact" aria-selected="{{ ($showVotingGuide || $showFullSubmission || $showTitleSummary) ? 'false' : 'true' }}">Fiscal Impact Estimate Report</a>
                                        </li>
                                    @endif
                                </ul>

                                <!-- Tab content -->
                                <div class="tab-content" id="documentTabsContent">
                                    @if($showVotingGuide)
                                        <div class="tab-pane fade" id="voting-guide" role="tabpanel" aria-labelledby="voting-guide-tab">
                                            <div class="panel">
                                                <h4>Voting Guide</h4>
                                                <div class="embed-responsive embed-responsive-4by3">
                                                    <iframe class="embed-responsive-item" height="100%" width="100%" src="{{ $propositions->getVotingGuideURL($prop) }}#zoom=100"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($showFullSubmission)
                                        <div class="tab-pane fade {{ $showVotingGuide ? '' : '' }}" id="full-submission" role="tabpanel" aria-labelledby="full-submission-tab">
                                            <div class="panel">
                                                <h4>Full Submission</h4>
                                                <div class="embed-responsive embed-responsive-4by3">
                                                    <iframe class="embed-responsive-item" height="100%" width="100%" src="/docs/Props/Pending_2018/{{$prop_info['ag_id']}}.pdf#zoom=100"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($showTitleSummary)
                                        <div class="tab-pane fade {{ ($showVotingGuide || $showFullSubmission) ? '' : '' }}" id="title-summary" role="tabpanel" aria-labelledby="title-summary-tab">
                                            <div class="panel">
                                                <h4>Title & Summary</h4>
                                                <div class="embed-responsive embed-responsive-4by3">
                                                    <iframe class="embed-responsive-item" height="100%" width="100%" src="/docs/Props/Pending_2018/{{$prop_info['ag_id']}}-TS.pdf#zoom=100"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($showFiscalImpact)
                                        <div class="tab-pane fade {{ ($showVotingGuide || $showFullSubmission || $showTitleSummary) ? '' : '' }}" id="fiscal-impact" role="tabpanel" aria-labelledby="fiscal-impact-tab">
                                            <div class="panel">
                                                <h4>Fiscal Impact Estimate Report</h4>
                                                <div class="embed-responsive embed-responsive-4by3">
                                                    <iframe class="embed-responsive-item" height="100%" width="100%" src="/docs/Props/Pending_2018/{{$prop_info['ag_id']}}-FIER.pdf#zoom=100"></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </section>
                @if (!empty($prop_more['analysis']))
                    <section id="Analysis">
                        <div class="row">
                            <div class="col-lg-10 center-block fn">
                                <div class="panel">
                                    <h4>Prop {{$prop->prop_id}} Analysis</h4>
                            @if($role == "admin")
                                <span><a href='http://198.74.49.22/dist_editor.php?id={{ $prop_more['analysis']['dist'] }}&yr={{$propositions->getYear($prop)}}' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>      
                            @endif
                                    <hr />
                                    <?php echo($prop_more['analysis']['text']) ?>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                @if ($propositions->hasAds($prop_more['ads']))
                    <section id="Ads">
                        <div class="row">
                            <div class="col-lg-10 center-block fn">
                                <div class="panel">
                                    <h4>Prop {{$prop->prop_id}} Ads ({{$propositions->getYear($prop)}})</h4>
                                    <hr />
                                    <?php
                                $year = $propositions->getYear($prop);
                                $fourcode = $prop_more['ads'];
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

<?php

function get_pending_info($prop_id) {
    $conn = Util::get_ctb_conn();
    $retval = [];
    $sql = "SELECT * FROM ctb_ca_props_pending WHERE (prop_id = '$prop_id' || fppc_id = '$prop_id')";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row;
            
        }
    }
    return $retval;
}

function render_sig_table() {
    global $prop_info;
    
    if(!empty($prop_info['sigs_deadline'])) {
        $enddraw = '<div class="panel p-n">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td>Signatures Deadline</td>
                                                <td>' . date('F d, Y',strtotime($prop_info['sigs_deadline'])) . "</td>
                                            </tr>
                                            <tr>
                                                <td>Signatures Submitted</td>
                                                <td>" . number_format($prop_info['sigs_submitted']) . "</td>
                                            </tr>
                                            <tr>
                                                <td>Valid Signatures Threshold</td>
                                                <td>" . number_format($prop_info['sigs_needed']) . " (" . number_format((($prop_info['sigs_needed'] / $prop_info['sigs_submitted']) * 100), 2) . "%)</td>
                                            <tr>
                                                <td>Signatures Valid</td>
                                                <td>" . number_format($prop_info['sigs_valid']) . " (" . number_format((($prop_info['sigs_valid'] / $prop_info['sigs_submitted']) * 100), 2) . "%)</td>
                                            </tr>
                                        </tbody>
                                    </table>
                    </div>";
    }
    
    echo $enddraw;
}

function load_prop_by_dist($fppc_id) {
     $conn = Util::get_ctb_conn();
     $retval = [];
     $sql = "SELECT * FROM ctb_prop_by_dist WHERE prop_id = '$fppc_id'";
     $result = $conn->query($sql);
     if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $fourcode = $row['fourcode'];
            $type = mb_substr($fourcode, 0, 2);
        $retval[$type][$fourcode] = $row;
    }
     }
     return $retval;    
}

function get_more($prop, $prop_info) {
    $conn = Util::get_ctb_conn();
    if(!empty($prop_info['fppc_id'])) {
        $fppc_id = $prop_info['fppc_id'];
        $prop_id = $prop_info['prop_id'];
    } else {
        $fppc_id = $prop->prop_id;
        $prop_id = $prop->prop_id;
    }
    $retval['analysis']     = get_prop_analysis($fppc_id, $prop_id);
    $retval['ads']          = get_prop_ads($fppc_id, $prop_id);
    $retval['prop_cmtes']   = get_prop_committees($fppc_id, $prop_id);
    $retval['finance']      = get_prop_finance($retval['prop_cmtes']);
    $retval['totals']['sup_raised'] = 0;
    $retval['totals']['sup_spent'] = 0;
    $retval['totals']['opp_raised'] = 0;
    $retval['totals']['opp_spent'] = 0;
    $retval['totals']['tot_raised'] = 0;
    $retval['totals']['tot_spent'] = 0;

    foreach($retval['finance'] as $cmte_id => $x) {
        $position = strtolower(mb_substr($x['position'], 0, 3));
        if($position == "sup") {
            $retval['totals']['sup_raised'] += $x['rcpt_total'];
            $retval['totals']['sup_spent'] += $x['expn_total'];
        } elseif ($position == "opp") {
            $retval['totals']['opp_raised'] += $x['rcpt_total'];
            $retval['totals']['opp_spent'] += $x['expn_total'];
        }
    }
    $retval['totals']['tot_raised'] = $retval['totals']['sup_raised'] + $retval['totals']['opp_raised'];
    $retval['totals']['tot_spent'] = $retval['totals']['sup_spent'] + $retval['totals']['opp_spent'];
    return $retval;
}

function get_prop_finance($prop_cmtes) {
    $conn = Util::get_ctb_conn();
    $retval = [];
    foreach($prop_cmtes as $cmte_id => $x) {
        $year_start = $x['session'];
        $year_end = $year_start + 1;
        $retval[$cmte_id] = get_cmte_summary($cmte_id, $year_start, $year_end);
        $retval[$cmte_id]['cmte_nm'] = $x['cmte_nm'];
        $retval[$cmte_id]['position'] = $x['position'];
    }
    return $retval;
}

function get_cmte_summary($cmte_id, $year_start, $year_end) {
    $conn = Util::get_ctb_conn();
    $start = $year_start . "-01-01";
    $end = $year_end . "12-31";
    $last_rpt = '';
    $filings = [];
    $retval['rcpt_total'] = 0;
    $retval['expn_total'] = 0;
    $retval['raised_since'] = 0;
    $retval['raised_last'] = 0;
    $retval['last_coh'] = 0;
    $retval['last_rpt'] = '';

    $last_filing = '';
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD
            WHERE FILER_ID = '$cmte_id' && (FORM_ID = 'F497' || FORM_ID = 'F460') && FILING_TYPE != 0 && (RPT_START >= '$start' && RPT_END <= '$end')
            ORDER BY FORM_ID, RPT_END DESC, FILING_ID DESC, FILING_SEQUENCE DESC";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $form_id = $row['FORM_ID'];
            $rpt_end = $row['RPT_END'];
            if($form_id == "F460") {
                if(empty($last_rpt)) {
                    $last_rpt = $rpt_end;
                    $last_filing = $row['FILING_ID'];
                }

                if(empty($filings['F460'][$rpt_end])) {
                    $filings['F460'][$rpt_end] = $row;
                }
            } elseif($form_id == "F497") {
                $filing_id = $row['FILING_ID'];
                if(empty($filings['F497'][$filing_id])) {
                    $filings['F497'][$filing_id] = $row;
                }
            }
        }
    }

    $query = '';
    if(!empty($filings['F460'])) {
        foreach($filings['F460'] as $x) {
            $amend_id = $x['FILING_SEQUENCE'];
            $filing_id = $x['FILING_ID'];
            $query .= " (FILING_ID = '$filing_id' && AMEND_ID = '$amend_id') ||";
        }
        $query = substr($query, 0, -2);
        $sql = "SELECT * FROM calaccess_raw_SMRY_CD WHERE FORM_TYPE = 'F460' && ($query) && LINE_ITEM IN ('2','5','11','16','19') ORDER BY FILING_ID DESC";
        $result = $conn->query($sql);

        //5 - TOTAL CONTRIBUTIONS, 11 - TOTAL EXPENDITURES, 16 - ENDING CASH, 19 - DEBT, 2 - LOANS
        $retval['rcpt_total'] = 0;
        $retval['expn_total'] = 0;
        $retval['raised_since'] = 0;
        if($result->num_rows >0) {
            while($row = $result->fetch_assoc()) {
                $filing_id = $row['FILING_ID'];
                $line_item = $row['LINE_ITEM'];
                if($filing_id == $last_filing) {
                    $retval['last_rpt'] = $last_rpt;
                    if($line_item == 16) {
                        $retval['last_coh'] = $row['AMOUNT_A'];
                    }
                    if($line_item == 5) {
                        $retval['raised_last'] = $row['AMOUNT_A'];
                    }
                }
                if($line_item == 5) {
                    $retval['rcpt_total'] += $row['AMOUNT_A'];
                }
                if($line_item == 11) {
                    $retval['expn_total'] += $row['AMOUNT_A'];
                }
            }
        }
    }
    $query = '';
    if(!empty($filings['F497'])) {
        foreach($filings['F497'] as $filing_id => $x) {
            $amend_id = $x['FILING_SEQUENCE'];
            $query .= " (FILING_ID = '$filing_id' && AMEND_ID = '$amend_id') ||";
        }
        $query = substr($query, 0, -2);
        $sql = "SELECT * FROM calaccess_raw_S497_CD WHERE FORM_TYPE = 'F497P1' && ( $query ) && CTRIB_DATE > '$last_rpt'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $retval['raised_since'] += $row['AMOUNT'];
            }
        }
        $retval['rcpt_total'] += $retval['raised_since'];
    }
    return $retval;
}

function get_prop_ads($fppc_id, $prop_id) {
    $conn = Util::get_ctb_conn();
    $retval = '';
    $sql =  "SELECT fourcode 
            FROM ctb_ads_e18 
            WHERE (fourcode = '$fppc_id' || fourcode = '$prop_id')";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['fourcode'];
        }
    }
    return $retval;
}

function get_prop_analysis($fppc_id, $prop_id) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT dist, text FROM ctb_analysis WHERE (dist = '$fppc_id' || dist = '$prop_id') ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row;
        }
    }
    return '';
}

function get_prop_committees($fppc_id, $prop_id) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT cmte_id, cmte_nm, cmte_position, session, prop_id, prop_no 
            FROM ctb_ca_props_ccl
            WHERE (prop_id = '$fppc_id' || prop_id = '$prop_id')";
    $result = $conn->query($sql);
    $retval = [];
    
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tmp['cmte_id'] = $row['cmte_id'];
            $tmp['cmte_nm'] = $row['cmte_nm'];
            $tmp['position'] = $row['cmte_position'];
            $tmp['prop_id']  = $row['prop_id'];
            $tmp['fppc_id'] = $row['prop_id'];
            $tmp['session'] = $row['session'];
            $tmp['prop_session'] = $row['session'];
            $retval[$row['cmte_id']] = $tmp;
        }
    }
    
    $sql = "SELECT prop_id, cmte_id, cmte_nm, cmte_position, session 
            FROM ctb_ca_props_pending_ccl 
            WHERE (prop_id = '$fppc_id' || prop_id = '$prop_id')";
    $result = $conn->query($sql);
    
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tmp['cmte_id'] = $row['cmte_id'];
            $tmp['cmte_nm'] = $row['cmte_nm'];
            $tmp['position'] = $row['cmte_position'];
            $tmp['prop_id']  = $row['prop_id'];
            if(!empty($fppc_id)) {
                $tmp['fppc_id'] = $fppc_id;    
            } else {
                $tmp['fppc_id'] = '';
            }
            
            $tmp['session'] = $row['session'];
            $tmp['prop_session'] = $row['session'];
            $retval[$row['cmte_id']] = $tmp;
        }
    } 

    return $retval;
    
}



?>    


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

<script>
    $(document).ready(function() {
        $('#county-tab').click();
        $('#documentTabs a:first').click();
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


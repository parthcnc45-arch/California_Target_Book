@extends('layouts.master')

@section('title', 'Federal Campaign Finance - Main | California Target Book')

@section('content')
    <div class="container">

        <h1>Federal Campaign Finance Information</h1>

        <div class='row'>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h2>FEC Filings</h2>
                    <hr />
                    <div class='row'>
                        <div class='col-lg-4'>
                            <!--IMG -->
                        </div>
                        <div class='col-lg-8'>
                            <a href='/book/fec_new'>FEC Filings (New) - Live Feed</a><br />
                            <a href='/book/fec_detailed'>FEC Filings (New) - Detailed Live Feed</a><br />
                            <a href='/book/fec_all'>FEC Filings (All) - Live Feed</a><br />

                        </div>
                    </div>
                </div>
            </div>

            <div class='col-lg-6'>
                <div class='panel'>
                    <h2>Campaign Finance Summaries by State</h2>
                    <p>Lists Campaign Finance Summaries for All Filed Candidates for House & Senate Districts by State,
                        along with Independent Expenditure activity.</p>
                    <hr />
                    <div class='row'>
                        <div class='col-lg-4'>
                            <!--IMG HERE -->
                        </div>

                        <div class='col-lg-8'>
                            <a href='/book/g18_fedsumbrowser'>2018 Campaign Cycle</a><br />
                            <a href='/book/g16_fedsumbrowser'>2016 Campaign Cycle</a><br />
                            <a href='/book/g14_fedsumbrowser'>2014 Campaign Cycle</a><br />
                            <a href='/book/g12_fedsumbrowser'>2012 Campaign Cycle</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h2>FEC Committees</h2>
                    <hr />
                    <div class='row'>
                        <div class='col-lg-4'>
                            <!--IMG HERE-->
                        </div>
                        <div class='col-lg-8'>
                            <a href='/book/fec_cmte_directory'>FEC Committee Directory</a><br />
                            <a href='/book/f3_summaries'>2017 Form 3 Summaries (All Committees)</a><br />
                            <a href='/book/fec_act_blue/'>FEC ActBlue Monthly Summary (2017-2018)</a><br />
			    <a href='/ctb-legacy/actblue_fed_ca' target='_blank'>FEC ActBlue Monthly Summary - California Candidates Only (2017-2018)</a><br/>
                            <a href='heybigspender_18.php'>2018 Independent Expenditures by Cmte</a><br />
                            {{--<a href='heybigspender_16.php'>2016 Independent Expenditures by Cmte</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





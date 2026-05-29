@extends('layouts.master')

@section('title', 'Maps Section - Main | California Target Book')

@section('content')

<div class="container">

    <h1>State Campaign Finance Information</h1>

    <div class='row'>
        <div class='col-lg-6'>
            <div class='panel'>
                <h2><a href='/book/realtime_month.php'>FPPC Filings - Live Feed</a></h2>
                <hr />
                <div class='row'>
                    <div class='col-lg-6'>
                        <img src='/img/FPPC_Realtime_Pic.jpg' width='200px'>
                    </div>

                    <div class='col-lg-6'>
                        <p>Lists the FPPC's live feed of daily filings, updated every 20 minutes.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h2>CA Independent Expenditure Filings</h2>
                    <hr />
                    <div class='row'>
                        <div class='col-lg-6'>
                            <img src='/img/IE_Pic.jpg' width='200px'>
                        </div>
                        <div class='col-lg-6'>
                            <a href='/book/ca_ielist_s17.php'>2017 Off-Year IE Filings</a><br />
                            <a href='/book/ca_ielist_g16.php'>2016 General Election IE Filings</a><br />
                            <a href='/book/ca_ielist_p16.php'>2016 Primary Election IE Filings</a><br />
                            <a href='/book/cal_ie_hist.php'>Lookup IE Filings by Date Range or Election</a><br />
                            <a href='/book/spending_history.php'>Campaign & IE Spending Charts in Past Elections (2010-2016)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h2>FPPC Information</h2>
                    <hr />
                    <div class='row'>
                        <div class='col-lg-4'>
                            <!--IMG -->
                        </div>
                        <div class='col-lg-8'>
                            <a href='/book/ca_candidates_e18_summary.php'>2018 Campaign Finance Summaries for All CA Candidates</a><br />
                            <a href='/book/fppc_active'>FPPC Committee Directory (Active Only)</a><br />
                            <a href='/book/fppc_all'>FPPC Committee Directory (All)</a><br />
                            <a href='/book/fppc_legislator_ballot_cmtes'>CA Legislator Ballot Measure Committees</a><br />
                            <a href='/book/fppc_county_party'>County Political Party Committees</a>
                        </div>
                    </div>
                </div>
            </div>

	  <div class='col-lg-6'>
	     <div class='panel'>
		<h2>Proposition Spending</h2>
		<a href='/book/pending_prop_financials'>Spending on 2018 Pending Propositions</a><br />
        <a href='/book/fppc_past_prop_spending'>Past Spending on Propositions (2008 - 2016)</a>
	     </div>	 
	  </div>

        </div>


    </div>



</div>


@endsection
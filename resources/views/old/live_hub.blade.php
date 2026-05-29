@extends('layouts.book')

@section('title', 'Live Hub | California Target Book')

@section('bodyClasses', 'main-bg-gray')

@section('content')
    <div class="container pt-xxl" >
	<!--
        <div class='row' align='center'>
            <div class="col-md-12">
                <div class='panel' >
                    <h3 align='center'>HEADLINES</h3>
                    <div class="row">
                        <div class='col-lg-12'>
                            <iframe src='/ctb-legacy/newsfeed.php' width='800px' height='100px'></iframe>
                        </div>
                    </div>
                </div>
            </div>

        </div>
	-->
        <div class='row' align='center'>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h3 align='center'>CAL-ACCESS FILERS</h3>
                    <div class="row">
                        <div class='col-lg-12'>
                            <iframe src='/ctb-legacy/last_cmtes.php' width='800px' height='600px'></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h3 align='center'>CANDIDATE FILINGS</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            <iframe src='/ctb-legacy/last_cands.php' width='800px' height='600px'></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row' align='center'>
            <div class='col-lg-12'>
                <div class='panel'>
                    <h3 align='center'>LATE CONTRIBUTIONS</h3>
                     <iframe src='/ctb-legacy/lastfilings_week.php' width='1024px' height='1024px'></iframe>
                </div>
            </div>
            <div class='col-lg-12'>
                <div class='panel'>
                    <h3 align='center'>LATE INDEPENDENT EXPENDITURES (FPPC)</h3>
                    <iframe src='/ctb-legacy/lastie_week.php' width='1024px' height='1024px'></iframe>
                </div>
            </div>

            <div class='col-lg-12'>
                <div class='panel'>
                    <h3 align='center'>LATE INDEPENDENT EXPENDITURES (FEC)</h3>
                    <iframe src='/ctb-legacy/lastfedie_week.php' width='1024px' height='1024px'></iframe>
                </div>
            </div>

        </div>
    </div>
@endsection

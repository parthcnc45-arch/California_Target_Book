
@extends('layouts.master')

@section('title', 'Elections - Main Page | California Target Book')

@section('content')
    <div class="container">

        <h1>Elections</h1>

        <div class='row'>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h2><a href='city_detail_browser.php'>County/Local Election Results 1996 - 2016</a></h2>
                    <p>View past election results by County or City</p>
                </div>
            </div>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h2><a href='city_browser2.php'>Past Election Results by County, County Subdivision, or City</a></h2>
                    <p>Election results for President, U.S. Senate, Governor, and Propositions 2008 - 2016</p>
                    <p>Voter registration statistics 2008 - 2017</p>
                    <p>Census data overview & detail reports using the 2015 ACS-5 year estimates</p>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-12'>
                <h2><a href='past_sov.php'>California Statement of Vote PDFs (1952 - 2016)</a></h2>
                <p>View Primary/General Election Statement of Vote Publications Since 1952</p>
            </div>
        </div>
    </div>

@endsection



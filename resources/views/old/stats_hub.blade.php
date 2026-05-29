
@extends('layouts.master')

@section('title', 'Voter Registration/Census Stats - Main | California Target Book')

@section('content')
    <div class="container">

        <h1>Voter Registration / Census Stats</h1>

        <div class='row'>
            <div class='col-lg-6'>
                <div class='panel'>
                    <h2>CA Voter Registration Trends by District</h2>
                    <hr />
                    <div class='row'>
                        <div class='col-lg-4'>
                            <!-- IMAGE HERE -->
                        </div>
                        <div class='col-lg-8'>
                            <a href='/book/ca_registration_feb_2017'>January 2015 to February 2017</a><br />
                            <a href='/book/ca_registration_oct_2016'>January 2015 to October 2016</a><br />
                            <a href='/book/ca_registration_sep_2016'>January 2015 to September 2016</a><br />
                            <a href='/book/ca_registration_jul_2016'>January 2015 to July 2016</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class='col-lg-6'>
                <div class='panel'>
                    <h2>US Census Data</h2>
                    <hr />
                    <div class='row'>
                        <div class='col-lg-4'>
                            <!--IMAGE HERE -->
                        </div>
                        <div class='col-lg-8'>
                            <a href='/book/ca_census_compare'>Demographic Info by CA Legislative District</a><br />
                            <a href='/book/us_census_compare'>Demographic Info by US Congressional District</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





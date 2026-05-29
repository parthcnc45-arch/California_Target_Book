@extends('layouts.master')

@section('title', 'Maps Section - Main | California Target Book')

@section('content')
    <div class="container">

        <h1>Maps</h1>

        <div class='row'>
            <div class='col-lg-12'>
                <div class='panel'>
                    <h2><a href='new_map_nav2.php'>View District Maps, 1992 - Present</a></h2>
                    <div class='row'>
                        <div class='col-lg-4'>
                            <img src='../img/new_map_nav.jpg' width='200'>
                        </div>
                        <div class='col-lg-8'>
                            <p>View Assembly, State Senate, and Congressional Districts as they existed after the 1990,
                                2000, and 2010 census redistricting.</p>
                            <p>View past officeholders and partisan voter registration trends as they existed for that
                                district over its lifetime.</p>
                            <p>View current County Supervisorial districts, including information about their current
                                officeholder, partisan registration, and past voting preferences for President and
                                Governor.</p>
                            <p>View County Maps with partisan voter registration statistics from 1992 to present.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col-lg-12'>
                <div class='panel'>
                    <h2><a href='precinct_nav2.php'>Precinct-Level Data by County, Congressional, Assembly, or State Senate
                            District</a></h2>
                    <div class='row'>
                        <div class='col-lg-4'>
                            <img src='../img/map_nav.png' width='200'>
                        </div>
                        <div class='col-lg-8'>
                            <p>View past election results by voting precinct.</p>
                            <p>Generates color-coded maps based on precinct's partisan voter registration, turnout level,
                                candidate choice, or Latino or Asian voter registration.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-12'>
                <div class='panel'>
                    <h2><a href='overlap_nav2.php'>Map Overlapping Districts</a></h2>
                    <div class='row'>
                        <div class='col-lg-4'>
                            <img src='../img/overlap_nav.jpg' width='200'>
                        </div>
                        <div class='col-lg-8'>
                            <p>Select two districts of any type from the 1990, 2000, or 2010 redistricting boundaries and
                                view the overlapping areas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





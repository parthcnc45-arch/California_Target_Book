
@extends('layouts.master')

@section('title', 'Candidate Directory - Main')

@section('content')


    <div class="container">

        <h1>Candidate Information</h1>

        <div class='row'>
            <div class='col-lg-4'>
                <div class='panel'>
                    <h2><a href='e18_roster.php'>2018 Candidate Directories</a></h2>
                    <p>California directory of all candidates who have filed to run in the 2017 and 2018 elections</p>
                    <p>California directory of incumbents</p>
                    <p>Nationwide directory of all candidates who have filed with the FEC to run for the US House of
                        Representatives</p>
                    <p>Nationwide directory of all US House incumbents</p>
                </div>
            </div>

            <div class='col-lg-4'>
                <div class='panel'>
                    <h2><a href='ca_cand_directory.php'>Past California Candidates</a></h2>
                    <p>California directory of all 2006-2016 candidates for Assembly, State Senate, Congress, Board of
                        Equalization, and Constitutional Offices</p>
                    <p>California directory of 50,000+ candidates for county-level offices, city council, and school board
                        races 1996-2016</p>
                </div>
            </div>

            <div class='col-lg-4'>
                <div class='panel'>
                    <h2><a href='house_cand_nav.php'>2006 - 2018 US House & Senate Candidates</a></h2>
                    <p>View candidates who filed with the FEC to run for the U.S. House of Representatives or U.S. Senate
                        from 2006 to present.</p>
                    <p>Includes summaries of amounts raised and spent for each candidate's primary campaign committee over
                        the course of the election cycle.</p>
                </div>
            </div>
        </div>

	<div class='row'>
	    <div class='col-lg-4'>
		<div class='panel'>
		     <h2><a href='e18_watchlist'>2018 CA Candidate Watch List</a></h2>
		     <p>Filing status for candidates taking out papers from county registrar's offices during the signatures-in-lieu and open filing periods.</p>
		</div>
	    </div>

	    <div class='col-lg-4'>
		<div class='panel'>
		     <h2><a href='draw_all_e18_ballots'>2018 Candidate Filing Status/June 5th Primary Ballot</a></h2>
		     <p>Filing status, links to county candidate watch lists, and tentative ballot list of candidates & their ballot designations.</p>
		</div>
	    </div>


	</div>
    </div>



@endsection

@section('scripts')
    <script>gtag('set', { 'book_category': 'candidates' });</script>
@endsection

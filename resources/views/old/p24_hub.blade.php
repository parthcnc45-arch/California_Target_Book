@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'March 5th, 2024 Presidential Primary General Election Hub | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        March 5th, 2024 Presidential Primary Election Hub
    </h2>
    <!--<p align='center'><b>Time Until Polls Close</b><br><span id='demo'></span></p>-->

    <p align='center'>SUMMARY RESULTS<br>
		<a href='/ctb-legacy/p24_scoreboard.php' target='lower'>Race Scoreboard</a>  |  
		<a href='/book/p24_results_all' target='_blank'>  All Results</a>
		<!--<a href='/ctb-legacy/g22_pol_scoreboard.php' target='lower'>Nationwide Results (House/Senate/Governor)</a>-->
	</p>
	<p align='center'>MAPPED RESULTS<br>
		<a href='/ctb-legacy/p24_mapped.php?id=ALLAD' target='lower'>Assembly</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p24_mapped.php?id=ALLSD' target='lower'>Senate</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p24_mapped.php?id=ALLCD' target='lower'>Congressional</a>	
	</p>

	<p align='center'>
		<a href='/ctb-legacy/p24_county_progress.php' target='lower'>
				COUNTY COUNT PROGRESS
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/voteprogress_nav.php' target='lower'>
				RESULT CHANGES OVER TIME (FROM ELECTION NIGHT TO CERTIFICATION) - P18/G18/P20/G20/P22/G22/P24
		</a>

		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/vote_shift.php?id=p24' target='lower'>
				EARLY/E-DAY/POST-ELECTION VOTE SHIFTS
		</a>

	</p>

	<!--
	<p align='center'>
		<a href='/ctb-legacy/ctb_past_county_turnout' target='lower'>
				HISTORIC TURNOUT BY COUNTY
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p24_county_sov_limited.php' target='lower'>
				KEY RESULTS BY DISTRICT
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p24_county_sub_sov_limited.php' target='lower'>
				KEY RESULTS BY COUNTY SUBDIVISION
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/ctb_generate_tables_p24.php?id=0' target='lower'>
				TABLE RESULTS
		</a>

	</p>
	-->



	<p align='center'>Final Certified Election Results<br />

		<a href='https://californiatargetbook.com/ctb-legacy/p24_party_by_county' target='lower'>
			 All Counties & Statewide
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;				
		<a href='https://californiatargetbook.com/ctb-legacy/p24_party_by_county.php?id=59' target='lower'>
			Statewide Totals Only
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;

		<a href='/docs/SoV/p2024.pdf' target='lower'>
			Statement of Vote (PDF)
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p24_pr1_usp.php' target='lower'>
				Turnout / Prop 1 / US Senate (Partial) by District
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/uploaded/ctb_p24_deck.pdf' target='lower'>
				Post-Primary Deck
		</a>

	</p>

	<p align='center'>
		<a href='/ctb-legacy/p24_ballot_text_draw.php' target='lower'>
			Final Certified Candidate List
		</a>

		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;

		<a href='/ctb-legacy/e24_watchlist2.php' target='lower'>
			Candidate Filing Status
		</a>

		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;

		<a href='/ctb-legacy/p24_master_list_vs_ballot.php' target='lower'>
			Master Candidate List
		</a>


		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;


		<a href='/book/calendar/'>
			Calendar
		</a>

		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/docs/p24_gop_delegates.pdf' target='lower'>
			GOP Delegate Selection
		</a>

		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;

		<a href='/uploaded/p24_dem_delegates.pdf' target='lower'>
			Democratic Delegate Selection
		</a>

	</p>

    <iframe name='lower' src='/ctb-legacy/p24_party_by_county.php?id=59' target='lower' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection


@section('scripts')


<script>
// Set the date we're counting down to
var countDownDate = new Date("Mar 5, 2024 20:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id="demo"
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "POLLS CLOSED";
    }
}, 1000);
</script>

@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

</style>


@endsection
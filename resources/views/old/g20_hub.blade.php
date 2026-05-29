@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'November 3rd, 2020 General Election Hub | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        November 3rd, 2020 General Election Hub
    </h2>

<!--
	<p align='center' style='font-size: 36px'>Time Remaining Before Polls Close</p>
	<p align='center' style='font-size: 48px' id="demo"></p>
-->
    <p align='center'>SCOREBOARD<br>
		<a href='/ctb-legacy/g20_scoreboard.php' target='lower'>California Races</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/g20_ap_scoreboard.php' target='lower'>Nationwide Pres/House/Senate</a>
	</p>
	<p align='center'>MAPPED RESULTS<br>
		<a href='/ctb-legacy/g20_mapped.php?id=ALLAD' target='lower'>Assembly</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/g20_mapped.php?id=ALLSD' target='lower'>Senate</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/g20_mapped.php?id=ALLCD' target='lower'>Congressional</a>	
	</p>
	<p align='center'>DETAILED RESULTS<br>
		<a href='/ctb-legacy/g20_draw_targets.php' target='lower'>All Races</a>
<!--
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/g20_vote_progression.php' target='lower'>EARLY/ELECTION NIGHT/FINAL RESULTS COMPARISON</a>	
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/g18_turnout_comparison' target='lower'>G12/G14/G16/G18 Turnout Comparison by District/County</a>
	
-->
	<p align='center'><a href='https://tableau.the-pdi.com/t/CampaignTools/views/2020GeneralBaseAVTracker/2020GeneralElectionTrackerVB-Overview?%3Aiid=1&%3AisGuestRedirectFromVizportal=y&%3Aembed=y' target='lower'>PDI Early Vote Return Tracker</a>
	&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href='/ctb-legacy/voteprogress_nav.php' target='lower'>View Vote Progress Over Time (P18/G18/P20/G20)</a>
	&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href='/ctb-legacy/g20_prop_by_dist.php' target='lower'>PRESIDENTIAL RACE/PROPS BY DISTRICT</a>

	</p>




	<p align='center'>
		<a href='/ctb-legacy/g20_county_progress' target='lower'>
				COUNTY COUNT PROGRESS
		</a>
	</p> 




	<p align='center'>Final Certified Election Results<br />
		<a href='https://californiatargetbook.com/ctb-legacy/g20_party_by_county' target='lower'>
			 All Counties & Statewide
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;				
		<a href='https://californiatargetbook.com/ctb-legacy/g20_party_by_county.php?id=59' target='lower'>
			Statewide Totals Only
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;				
		<a href='/docs/SoV/g20.pdf' target='lower'>
			Statement of Vote (PDF)
		</a>
	</p>

	

    <iframe name='lower' src='/ctb-legacy/g20_party_by_county.php?id=59' target='lower' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection


@section('scripts')


<script>
// Set the date we're counting down to
var countDownDate = new Date("Nov 3, 2020 20:00:00").getTime();

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
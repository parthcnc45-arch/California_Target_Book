@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'CA Voter Registration Trends January 2017 - May 2018 | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        June 5th, 2018 Primary Election Hub
    </h2>
    <p align='center'>SUMMARY RESULTS<br>
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=ALL' target='lower'>All Races</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=ALLAD' target='lower'>All Assembly</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=ALLSD' target='lower'>All Senate</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=ALLCD' target='lower'>All Congressional</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=STW' target='lower'>All Statewide</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=AD' target='lower'>Assembly Targets</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=SD' target='lower'>Senate Targets</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_draw_targets2.php?targets=CD' target='lower'>Congressional Targets</a>
	</p>
	<p align='center'>MAPPED RESULTS<br>
		<a href='/ctb-legacy/p18_mapped.php?id=ALLAD' target='lower'>Assembly</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_mapped.php?id=ALLSD' target='lower'>Senate</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/p18_mapped.php?id=ALLCD' target='lower'>Congressional</a>
	</p>
	<p align='center'>
		<a href='/ctb-legacy/p18_county_progress' target='lower'>
				COUNTY COUNT PROGRESS
		</a>
	</p>
	<p align='center'>Final Certified Election Results<br />
		<a href='https://californiatargetbook.com/ctb-legacy/p18_party_by_county' target='lower'>
			 All Counties & Statewide
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='https://californiatargetbook.com/ctb-legacy/p18_party_by_county.php?id=59' target='lower'>
			Statewide Totals Only
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/docs/SoV/p18.pdf' target='lower'>
			Statement of Vote (PDF)
		</a>
	</p> 
    <iframe name='lower' src='/ctb-legacy/p18_party_by_county.php?id=59' target='lower' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection


@section('scripts')


<script>
// Set the date we're counting down to
var countDownDate = new Date("Jun 5, 2018 20:00:00").getTime();

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

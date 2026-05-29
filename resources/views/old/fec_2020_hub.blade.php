@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FEC Filing Hub | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        FEC Filing Hub
    </h2>
    <p align='center'>LATEST FILINGS<br>
		<a href='/ctb-legacy/fec_norss.php' target='lower'>Recent Filings (Past Week)</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/fec_new_norss.php' target='lower'>Detailed/Sorted</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/book/search2'>SEARCH</a>

	</p>
	<!--
	<p align='center'>LEADERBOARDS<br>
		<a href='/ctb-legacy/potus_2020_board.php?sort=rcpt' target='lower'>Presidential Candidates</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/e20_target_finances.php?load=T&rpt=Q319' target='lower'>NRCC / DCCC Targeted Races</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/e20_target_finances.php?load=ALL&rpt=Q319' target='lower'>All Incumbents / Challengers</a>	
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/e20_dem_vs_gop.php' target='lower'>Party Committees</a>	
	</p>
	-->



<!--	<p align='center'>
		<a href='/ctb-legacy/p18_county_progress' target='lower'>
				COUNTY COUNT PROGRESS
		</a>
	</p> -->


	

    <iframe name='lower' src='/ctb-legacy/fec_norss.php' target='lower' width='100%' height='100%' class='ported'></iframe>
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
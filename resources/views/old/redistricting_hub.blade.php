@extends('layouts.book')
@php ($book_side_nav_active = 'census')

@section('title', 'Redistricting Central | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Redistricting Resources
    </h2>
    
    <p align='center'>NEWS / OVERVIEW<br>
	<a href='/ctb-legacy/redist_articles.php' target='lower'>News Articles</a>
	&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href='/ctb-legacy/redist_timeline.php' target='lower'>Timeline</a>
	&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
	<a href='/ctb-legacy/redist_glossary.php' target='lower'>Glossary</a>
    </p>

	<p align='center'>REDISTRICTING COMMISSION<br>
		<a href='/ctb-legacy/redist_members.php' target='lower'>Members</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/redist_members_map.php' target='lower'>Members Mapped by Party/Location</a>
	</p>
	<p align='center'>SITE RESOURCES<br>
		<a href='/book/geo_nav' target='_blank'>Election Results/Past Census Data by Geographical Area
				
		</a>
		&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
		<a href='/ctb-legacy/acs_delta.html' target='lower'>
				Population/Ethnic Demographic Changes by Census Location (2012 -> 2018)
		</a>
	</p>

	

    <iframe name='lower' src='/ctb-legacy/redist_articles.php' target='lower' width='100%' height='100%' class='ported'></iframe>
</div>

@endsection


@section('scripts')


<script>
// Set the date we're counting down to
var countDownDate = new Date("Mar 3, 2020 20:00:00").getTime();

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

@php ($book_side_nav_active = 'search')

@extends('layouts.book')


@section('title', 'Site Search | California Target Book')

@section('content')

<div class='container'>
     <h1>Site Search by Keyword</h1>
     <h5>(Hot Sheets, District Analysis, Candidate Bios)</h5>
     <div class='row'> 
       <input type="text" id="search-box" placeholder="Search...">
     </div>
     <div class='row'>
       <div id="search-results"></div>
     </div>
</div>

<?php

set_time_limit(0);
ini_set('max_execution_time', 180); //3 minutes

?>

@endsection

@section('styles')

<style>

	.text-sm-justify {
	     text-align: justify;
	     font-size: 0.8em;
	}

	.modal-1200 {
		min-width: 90vw !important;
	}

	.modal {
		min-height: 90vh !important;
	}

	.report-label {
		font-size: 1.5em;
		font-family: 'Lato';
		font-variant: small-caps;
	}
</style>

@endsection
@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>

var typingTimer;
var doneTypingInterval = 500;

// When the user starts typing
$('#search-box').on('input', function() {
  clearTimeout(typingTimer);
  if ($('#search-box').val().length > 3) {
    typingTimer = setTimeout(doneTyping, doneTypingInterval);
  }
});

// When the user stops typing
    function doneTyping() {
      var keyword = $('#search-box').val();
      var xmlhttp = new XMLHttpRequest();
      $('#search-results').empty();
      $('#search-results').append("<div class='row'><p align='center'><img src='/img/loading-spinner.gif' width='150' align='center' /></p></div>");

      xmlhttp.onreadystatechange = function () {
	if (this.readyState == 4 && this.status == 200) {
	   $('#search-results').empty();
	    var text = this.responseText;
	    var text_json = JSON.parse(text);
	    var keys = Object.keys(text_json);
	    count = keys.length;
	    $('#search-results').append("<div class='row'><p><i>Returned <span class='greenme boldme'>" + count + "</span> Results</i></p></div>");

	    keys.forEach(function(key) {
		var entry = text_json[key];
		var header = entry.header;
		var context = entry.context;
		$('#search-results').append("<div class='row'><h4>" + header + "</h4><div class='panel'><blockquote><p class='text-sm-justify'>" + context + "</p></blockquote></div></div>");
	    });

	}
      } 
      xmlhttp.open("GET", "/book/ctb_hs_an_bio_srch.php?q=" + keyword, true);
      xmlhttp.send();
      


    }

</script>

</script>


<script type='text/javascript'>



<?php
	
	foreach($endjava as $value) {
		echo($value);
	}

?>

</script>


@endsection


	
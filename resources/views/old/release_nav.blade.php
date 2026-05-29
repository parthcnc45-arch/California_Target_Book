@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', 'Public Releases | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Public Releases
    </h2>

    <p style='line-height: 2em;'></p>

	<select name="release" id="release" class="switcher">
				<option value='2018-10-09_CTB_Release' selected>	October 9th, 2018 - State and County Party Spending Update		</option>    
				<option value='2018-09-28_CA10_CA21'>				September 28th, 2018 - CA10/CA21 Overview						</option>
				<option value='2018-08-15_PROPS_PT3'>				August 15th, 2018 - Propositions Part 3							</option>
				<option value='2018-08-14_PROPS_PT2'>				August 14th, 2018 - Propositions Part 2 						</option>
				<option value='2018-08-13_PROPS_PT1'>				August 13th, 2018 - Propositions Part 1 						</option>
				<option value='2018-08-08_SPI'>						August 8th, 2018 - Superintendent of Public Instruction 		</option>
				<option value='2018-08-06_INS'>						August 6th, 2018 - Insurance Commissioner 						</option>
				<option value='2018-08-05_LEGISLATIVE_TARGETS'>		August 5th, 2018 - Legislative Targets 							</option>
	</select>

    <p style='line-height: 2em;'></p>

    <iframe id='lower_frame' name='lower_frame' class='switch-target ported' src='/ctb-legacy/docs/2018-10-09_CTB_Release.pdf' width='100%' height='100%'></iframe>
</div>

@endsection


@section('scripts')

<script>



$( "#release" ).change(function () {
		
		switcher();

  });


function switcher() {
   var theSelect = document.getElementById('release');
   var theIframe = document.getElementById('lower_frame');
   var x = theSelect.options[theSelect.selectedIndex].value;
   var url = '/ctb-legacy/docs/' + x + '.pdf';
   //alert(url);
   theIframe.src = url;
}

/*
function switcher(x) {
  var url = 'https://californiatargetbook.com/ctb-legacy/docs/' + x + '.pdf';
  $('#lower_frame').attr('src', url); 
}
*/


</script>

@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

</style>


@endsection
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
				<option value='2018-11-06_OneBillion'>						November 6th, 2018 - Campaign 2018 Spending Reaches $1 Billion in California</option>    
				<option value='2018-11-01_Early_Returns_Update'>				November 1st, 2018 - Mail Ballot Returns at 7 Days Out		</option>    
				<option value='2018-10-30_IE_Spend_State'>					October 30th, 2018 - State IE Spending Update			</option>    
				<option value='2018-10-29_IE_Spend_Federal'>					October 29th, 2018 - Federal IE Spending Update			</option>    
				<option value='2018-10-26_Pre-Election_Federal'>				October 26th, 2018 - Pre-Election Reports - Key Federal Races		</option>    
				<option value='2018-10-26_Pre-Election_State'>					October 26th, 2018 - Pre-Election Reports - Key State Races			</option>    
				<option value='2018-10-25_IE_Spend_Federal'>					October 25th, 2018 - Federal IE Spending Update			</option>    
				<option value='2018-10-23_Party_Spend_Update'>					October 23rd, 2018 - State and County Party Spending Update			</option>    
				<option value='2018-10-18_IE_Spend'>						October 18th, 2018 - State and Federal Independent Expenditure Update		</option>    
				<option value='2018-10-16_Party_Spend_Update'>					October 17th, 2018 - State and County Party Spending Update			</option>    
				<option value='2018-10-16_FEC_Q3' >						October 16th, 2018 - FEC 3rd Quarter Reports					</option>    
				<option value='2018-10-11_CTB_Release'>						October 11th, 2018 - State and Federal Independent Expenditure Update		</option>    
				<option value='2018-10-09_CTB_Release'>						October 9th, 2018 - State and County Party Spending Update		</option>    
				<option value='2018-09-28_CA10_CA21'>						September 28th, 2018 - CA10/CA21 Overview						</option>
				<option value='2018-08-15_PROPS_PT3'>						August 15th, 2018 - Propositions Part 3							</option>
				<option value='2018-08-14_PROPS_PT2'>						August 14th, 2018 - Propositions Part 2 						</option>
				<option value='2018-08-13_PROPS_PT1'>						August 13th, 2018 - Propositions Part 1 						</option>
				<option value='2018-08-08_SPI'>								August 8th, 2018 - Superintendent of Public Instruction 		</option>
				<option value='2018-08-06_INS'>								August 6th, 2018 - Insurance Commissioner 						</option>
				<option value='2018-08-05_LEGISLATIVE_TARGETS'>				August 5th, 2018 - Legislative Targets 							</option>
	</select>

    <p style='line-height: 2em;'></p>

    <iframe id='lower_frame' name='lower_frame' class='switch-target ported' src='/ctb-legacy/docs/2018-11-06_OneBillion.pdf' width='100%' height='100%'></iframe>
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
   theIframe.src = url;
}
</script>

@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

</style>


@endsection
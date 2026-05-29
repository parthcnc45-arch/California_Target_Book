@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'PDI Absentee Tracker | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        <a href='https://politicaldata.com' target='_blank'><img src='/uploaded/20181017_pdi_logo.png' height='70px' /></a> Absentee Ballot Tracker
        <small class="sub block mt-sm">2014 - 2024 Elections</small>
    </h2>

	<div style='float: left;' align='left'>
	<input type="radio" id="av" name="av" value="8" checked="checked" />  2024 Primary&nbsp;&nbsp;&nbsp;
	<input type="radio" id="av" name="av" value="7"/>  2022 General&nbsp;&nbsp;&nbsp;
	<input type="radio" id="av" name="av" value="6"/>  2022 Primary&nbsp;&nbsp;&nbsp;
	<input type="radio" id="av" name="av" value="4"/>  2020 Primary&nbsp;&nbsp;&nbsp;
    	<input type="radio" id="av" name="av" value="0"/>  2018 General (District)&nbsp;&nbsp;&nbsp;
    	<input type="radio" id="av" name="av" value="1"/>   2018 General (Statewide/Local)&nbsp;&nbsp;&nbsp;
    	<input type="radio" id="av" name="av" value="2"/>   2016 General&nbsp;&nbsp;&nbsp;
	<input type="radio" id="av" name="av" value="5"/>   2016 Primary&nbsp;&nbsp;&nbsp;
    	<input type="radio" id="av" name="av" value="3"/>   2014 General
    </div>
    <iframe id="lower_frame" src='https://tableau.the-pdi.com/t/CampaignTools/views/2024PrimarylMainAVTracker/2024PrimaryElectionTracker-DateDetail?%3Aembed=y&%3AisGuestRedirectFromVizportal=y' width='100%' height='100%' class='ported'></iframe>
</div>





@endsection


@section('scripts')

<script>

var theIframe = document.getElementById('lower_frame');
$('input[type=radio][name=av]').on('change', function() {
     switch($(this).val()) {
         case '0':
         	 url = "https://tableau.the-pdi.com/t/CampaignTools/views/2018GeneralAVTracker/18GDistrictAVTracker?:embed=y";
         	 theIframe.src = url;
             break;
         case '1':
    		 url = "https://tableau.the-pdi.com/t/CampaignTools/views/2018GeneralLocalStateAVTracker/18GStateLocalTracker?:embed=y#5";
    		 theIframe.src = url;         
             break;
        case '2':
        	 url = "https://public.tableau.com/profile/paulmitche11#!/vizhome/PDIAV2016GeneralWorksheet/PDI2016VOTERRETURNSDASHBOARD?:embed=y";
        	 theIframe.src = url;
        	 break;
		case '3':
			url = "https://public.tableau.com/app/profile/paulmitche11/viz/PDIAV2014Worksheet/PDIVOTERRETURNSDASHBOARD";
			theIframe.src = url;        	
			break;
		case '4':
			url = "https://tableau.the-pdi.com/t/CampaignTools/views/2020PrimaryBaseAVTrackerAWWIP/2020PrimaryElectionTrackerpg1?:embed=y#1";
			theIframe.src = url;
			break;
		case '5':
			url = "https://public.tableau.com/profile/paulmitche11#!/vizhome/PDIAV2016PrimaryWorksheet/PDI2016VOTERRETURNSDASHBOARD?:embed=y";
			theIframe.src = url;
			break;
		case '6':
			url = "https://tableau.the-pdi.com/t/CampaignTools/views/2022PrimaryMainAVTracker/2022GeneralElectionTracker-Overview?%3AisGuestRedirectFromVizportal=y&%3Aembed=y";
			theIframe.src = url;
			break;
		case '7':
			url = "https://tableau.the-pdi.com/t/CampaignTools/views/2022GeneralMainAVTracker/2022GeneralElectionTracker-Overview?%3AisGuestRedirectFromVizportal=y&%3Aembed=y&%3AdeepLinkingDisabled=y";
			theIframe.src = url;
			break;
		case '8':
			url = "https://tableau.the-pdi.com/t/CampaignTools/views/2024PrimarylMainAVTracker/2024PrimaryElectionTracker-DateDetail?%3Aembed=y&%3AisGuestRedirectFromVizportal=y";
			theIframe.src = url;
			break;
     }
});



</script>

@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

</style>


@endsection
@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', 'Public Releases | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        <a href='https://politicaldata.com' target='_blank'><img src='/uploaded/20181017_pdi_logo.png' height='70px' /></a> Absentee Ballot Tracker
        <small class="sub block mt-sm">November 6th, 2018 General Election</small>
    </h2>

	<div style='float: left;' align='left'>
    	<input type="radio" id="av" name="av" value="0" checked="checked" />   District View&nbsp;&nbsp;&nbsp;
    	<input type="radio" id="av" name="av" value="1"/>   Statewide/Local View
    </div>
    <iframe id="lower_frame" src='https://tableau.the-pdi.com/t/CampaignTools/views/2018GeneralAVTracker/18GDistrictAVTracker?:embed=y' width='100%' height='100%' class='ported'></iframe>
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
     }
});

/*
$( "#av" ).change(function () {	
		switcher();
  });


function switcher() {
   var theSelect = document.getElementById('av');
   var theIframe = document.getElementById('lower_frame');
   var urls = [
   	"https://tableau.the-pdi.com/t/CampaignTools/views/2018GeneralAVTracker/18GDistrictAVTracker?:embed=y",
   	"https://tableau.the-pdi.com/t/CampaignTools/views/2018GeneralLocalStateAVTracker/18GStateLocalTracker?:embed=y#5"
   ];
   var x = theSelect.value;
   alert(x);
   var url = urls[x];
   //alert(url);
   theIframe.src = url;
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
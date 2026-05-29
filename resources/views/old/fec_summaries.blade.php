@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'FEC Summary Reports | California Target Book')


@section('content')

<div width='100%' height='100%' style='margin-left: auto; margin-right: auto;'>

<div class='newseg container' style='display: inline-block; padding: 10px; margin-left: auto; margin-right: auto;'>

<div class='panel' style='margin-left: auto; margin-right: auto;'>
<div class='panel-head'>
<h2 align='left'>FEC SUMMARY REPORTS</h2>
</div>
<div class='panel-body'>


<form action="" enctype="text/plain" method="post" onsubmit="return valForm(this);">
    <div class='card card-blue'>
	<div class='card-head'>
	    <h4 align='left'>Choose Report Type</h4>
	</div>
	<div class='card-body'>
    		<input type="radio" name="rpt_type" value="cand" checked>   Candidate Summaries
		<input type="radio" name="rpt_type" value="cmte">   Committee Summaries
	        <input type="radio" name="rpt_type" value="ie">   Independent Expenditure Summaries
	</div>
    </div>

    <div class='card card-green'>
	<div class='card-head'>
    		<h4 align='left'>Choose Election Cycle</h4>
	</div>
	<div class='card-body'>
    		<select class='form-select form-select-lg' name="year" id="year">
        		<option value='2024'>2024</option>
		        <option value='2022'>2022</option>
		        <option value='2020'>2020</option>
		        <option value='2018'>2018</option>
		        <option value='2016'>2016</option>
		        <option value='2014'>2014</option>
		        <option value='2012'>2012</option>
		        <option value='2010'>2010</option>
		        <option value='2008'>2008</option>
	    </select>
	</div>
    </div>
    
    <div id='ie_chamber_div' align='center' class='showonselect' style='margin-bottom: 20px; display: none;'>
    <h3 align='center'>Independent Expenditure Report Options</h3>
    <div class='card card-indigo'>
	<div class='card-head'>
		<h4>Choose Office</h4>
	</div>
	<div class='card-body'>
	    <input type="radio" name="chamber" value="" checked>House  
	    <input type="radio" name="chamber" value="SEN">Senate
	    <input type="radio" name="chamber" value="POTUS">President
	</div>
	</div>
    </div>

    <div id='ie_election_div' align='center' class='showonselect' style='margin-bottom: 20px; display: none;'>
	<div class='card card-copper'>
		<div class='card-head'>
			<h4>Choose Election Type</h4>
		</div>
		<div class='card-body'>
    			<input type="radio" name="election" value="" checked>All
			<input type="radio" name="election" value="P">Primary
			<input type="radio" name="election" value="G">General
			<input type="radio" name="election" value="R">Runoff
			<input type="radio" name="election" value="O">Other
		</div>
	</div>
    </div>

    <div id='ie_state_div' align='center' class='showonselect' style='margin-bottom: 20px; display: none;'>
	<div class='card card-orange'>
		<div class='card-head'>
			<h4>Choose State</h4>
		</div>
		<div class='card-body'>
        <select name="state" id="state">
            <option value="ALL">ALL STATES</option>
            <option value="AL">Alabama</option>
            <option value="AK">Alaska</option>
            <option value="AZ">Arizona</option>
            <option value="AR">Arkansas</option>
            <option value="CA">California</option>
            <option value="CO">Colorado</option>
            <option value="CT">Connecticut</option>
            <option value="DE">Delaware</option>
            <option value="DC">District Of Columbia</option>
            <option value="FL">Florida</option>
            <option value="GA">Georgia</option>
            <option value="HI">Hawaii</option>
            <option value="ID">Idaho</option>
            <option value="IL">Illinois</option>
            <option value="IN">Indiana</option>
            <option value="IA">Iowa</option>
            <option value="KS">Kansas</option>
            <option value="KY">Kentucky</option>
            <option value="LA">Louisiana</option>
            <option value="ME">Maine</option>
            <option value="MD">Maryland</option>
            <option value="MA">Massachusetts</option>
            <option value="MI">Michigan</option>
            <option value="MN">Minnesota</option>
            <option value="MS">Mississippi</option>
            <option value="MO">Missouri</option>
            <option value="MT">Montana</option>
            <option value="NE">Nebraska</option>
            <option value="NV">Nevada</option>
            <option value="NH">New Hampshire</option>
            <option value="NJ">New Jersey</option>
            <option value="NM">New Mexico</option>
            <option value="NY">New York</option>
            <option value="NC">North Carolina</option>
            <option value="ND">North Dakota</option>
            <option value="OH">Ohio</option>
            <option value="OK">Oklahoma</option>
            <option value="OR">Oregon</option>
            <option value="PA">Pennsylvania</option>
            <option value="RI">Rhode Island</option>
            <option value="SC">South Carolina</option>
            <option value="SD">South Dakota</option>
            <option value="TN">Tennessee</option>
            <option value="TX">Texas</option>
            <option value="UT">Utah</option>
            <option value="VT">Vermont</option>
            <option value="VA">Virginia</option>
            <option value="WA">Washington</option>
            <option value="WV">West Virginia</option>
            <option value="WI">Wisconsin</option>
            <option value="WY">Wyoming</option>
        </select>
	</div>
	</div>
    </div>
    <br><br>
    <input class='btn btn-primary' type="button" value="Generate Report" onclick="handleForm()">
    </div>	
</form>

</div>
</div>

<iframe id="destination" width="100%" height="100%"></iframe>


</div>
</body>




@endsection


@section('scripts')

<script>

    //SHOW REPORT SELECTOR
    $('input[name="rpt_type"]').click(function() {
        if(this.value == 'cand') {
             $('#ie_state_div').hide();
             $('#ie_chamber_div').hide();
             $('#ie_election_div').hide();

        } else if(this.value == 'cmte') {
             $('#ie_state_div').hide();
             $('#ie_chamber_div').hide();
             $('#ie_election_div').hide();

        } else if(this.value == 'ie') {

             $('#ie_state_div').show();
             $('#ie_chamber_div').show();
             $('#ie_election_div').show();
        } 
    });

    function handleForm() {
        var add_chamber = '';
        var add_election = '';
        var option = document.querySelector('input[name="rpt_type"]:checked').value;
        var year = document.getElementById("year").value;
        var URL = "/ctb-legacy/ctb_fec_summary.php?cycle=" + year + "&type=" + option;

        if(option == "ie") {
            var state = document.getElementById("state").value
            var chamber = document.querySelector('input[name="chamber"]:checked').value;
            var election = document.querySelector('input[name="election"]:checked').value;

            if(chamber != '') {
                var add_chamber = "&type=" + chamber;
            } 
            if(election != '') {
                var add_election = '&election=' + election;
            }
            var URL = '/ctb-legacy/ctb_fec_ie_spend.php?cycle=' + year + '&state=' + state + add_chamber + add_election;
        }
        document.getElementById("destination").src = URL;
        var iframe = document.getElementById("destination");
        iframe.onload = function() {
            iframe.height=iframe.contentWindow.document.body.scrollHeight + "px";
            iframe.width=iframe.contentWindow.document.body.scrollWidth + "px";
        }
        

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
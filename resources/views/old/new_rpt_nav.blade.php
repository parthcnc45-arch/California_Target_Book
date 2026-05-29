
@php ($book_side_nav_active = 'elections')

@extends('layouts.book')


@section('title', 'Election Detail Report (New) | California Target Book')

@section('content')

<div class='row'>
	<div class='col-lg-6'>
		<div class='card card-orange'>
			<div class='card-head'>
				<h3>Election Detail Report</h3>
			</div>
			<div class='card-body'>

				<form>
				  <div class="form-group">
				    <label for="election-type"><span class='report-label boldme'>Select District Type</span></label>
				    <div>
				      <div class="form-check form-check-inline">
				        <input class="form-check-input" type="radio" name="office-type" id="assembly" value="Assembly">
				        <label class="form-check-label" for="assembly">Assembly</label>
				      </div>
				      <div class="form-check form-check-inline">
				        <input class="form-check-input" type="radio" name="office-type" id="state-senate" value="State Senate">
				        <label class="form-check-label" for="state-senate">State Senate</label>
				      </div>
				      <div class="form-check form-check-inline">
				        <input class="form-check-input" type="radio" name="office-type" id="congressional" value="Congressional">
				        <label class="form-check-label" for="congressional">Congressional</label>
				      </div>
				      <div class="form-check form-check-inline">
				        <input class="form-check-input" type="radio" name="office-type" id="county" value="County">
				        <label class="form-check-label" for="county">County</label>
				      </div>
				    </div>
				  </div>



				  <div><span class='report-label boldme'>Select District / County</span></div>
				  <div class="form-group" id="districts">
				    <!-- District options will be added dynamically here based on the radio button selected -->
				  	<select>
				  	</select>    
				  </div>

				  <div class="form-group" id="county-dropdown">
				    <!-- Counties will be added dynamically here based on the radio button selected -->
				  	<select>
				  	</select>    
				  </div>

				  <div class="form-group">
				    <label for="election"><span class='report-label boldme'>Select Election</span></label>
				    <select class="form-control" name="election" id="election">
				      <option value="g22" selected>2022 General</option>
				      <option value="p22">2022 Primary</option>
				      <option value="s21">2021 Recall</option>
				      <option value="g20">2020 General</option>
				      <option value="p20">2020 Primary</option>
				      <option value="g18">2018 General</option>
				      <option value="p18">2018 Primary</option>
				      <option value="g16">2016 General</option>
				      <option value="p16">2016 Primary</option>
				      <option value="g14">2014 General</option>
				      <option value="p14">2014 Primary</option>
				      <option value="g12">2012 General</option>
				      <option value="p12">2012 Primary</option>
				      <!-- Add more options as needed -->
				    </select>
				  </div>				  

				   	    <button id='generate-report-btn' type='button' class='btn btn-primary' data-toggle='modal' data-target='#report-modal' disabled>
							Generate Report
					    </button>

				  <!--<button type="button" class="btn btn-primary" id="generate-report-btn" disabled>Generate Report</button>-->
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap modal for displaying report -->
<div class="modal fade modal-1200" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-label" aria-hidden="true" width='90vw' height='90vh' align='center'>
  <div class="modal-dialog modal-1200">
    <div class="modal-content">
      <div class="modal-header modal-1200">
        <h4 class="modal-title" id="report-modal-label">Report</h4>
        <button type="button" id='modal-close-0' class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body modal-1200">
        <iframe id='iframe_modal' src='/ctb-legacy/loading_spinner.php' class='modal-1200' height='1024' frameborder='0' sandbox='allow-same-origin allow-scripts allow-popups allow-forms allow-top-navigation' allowtransparency='true'></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" id='modal-close-1' class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



@endsection

@section('styles')

<style>

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

$(document).ready(function() {
  // hide the district dropdown by default
  $('#districts').hide();

  // disable the generate report button by default
  $('#generate-report-btn').prop('disabled', true);

  // show/hide the district dropdown based on the radio button selection
  $('input[type="radio"]').click(function() {
    var selectedValue = $(this).val();
    console.log("Selected " + selectedValue);
    var selectedOffice = selectedValue;

      //DRAW THE DISTRICT OR COUNTY DROPDOWN
	  if (selectedOffice === 'Assembly') {
	    populateDistrictsDropdown(80, 'AD', 'Assembly District');
	  } else if (selectedOffice === 'State Senate') {
	    populateDistrictsDropdown(40, 'SD', 'State Senate District');
	  } else if (selectedOffice === 'Congressional') {
	    populateDistrictsDropdown(53, 'CD', 'Congressional District');
	  } else if (selectedOffice === 'County') {
	    populateCountyDropdown();
	  }

    if (selectedValue === 'Assembly' || selectedValue === 'State Senate' || selectedValue === 'Congressional') {
      console.log("Showing districts, hiding county-dropdown.");
      $('#districts').show();
      $('#districts').find('select').prop('disabled', false);
      $('#districts').find('label').show();
      $('#districts').find('select').val('');
      $('#county-dropdown').hide();
      $('#county-dropdown').find('select').prop('disabled', true);
      $('#county-dropdown').find('select').val('');
    } else if (selectedValue === 'County') {
      console.log("Showing county-dropdown, hiding districts.");
      $('#districts').hide();
      $('#districts').find('select').prop('disabled', true);
      $('#districts').find('label').hide();
      $('#districts').find('select').val('');
      $('#county-dropdown').show();
      $('#county-dropdown').find('select').prop('disabled', false);
      $('#county-dropdown').find('select').val('');
    }
  });

  // enable/disable the generate report button based on the dropdown selections
  $('select').change(function() {
    var districtSelected = false;
    var countySelected = false;
    var electionSelected = false;
    $('input[type="radio"]').each(function() {
      if ($(this).is(':checked')) {
        var selectedValue = $(this).val();
        if (selectedValue === 'County') {
          countySelected = true;
        } else {
          districtSelected = true;
        }
      }
    });
    $('select').each(function() {
      if ($(this).val() !== '') {
        electionSelected = true;
      }
    });
    if ((districtSelected && electionSelected) || (countySelected && electionSelected)) {
      $('#generate-report-btn').prop('disabled', false);
    } else {
      $('#generate-report-btn').prop('disabled', true);
    }
  });

  // open the modal when the generate report button is clicked
  $('#generate-report-btn').click(function() {
    var district = '';
    var county = '';
    var election = '';
    $('input[type="radio"]').each(function() {
      if ($(this).is(':checked')) {
        var selectedValue = $(this).val();
        if (selectedValue === 'County') {
          county = $('#county-dropdown select').val();
        } else {
          district = $('#districts select').val();
        }
      }
    });
    $('select').each(function() {
      if ($(this).val() !== '') {
        election = $(this).val();
      }
    });
    var url = '/ctb-legacy/new_results.php?';
    election = $('#election').val();
    if (district !== '') {
      url += 'dist=' + district + '&';
    } else if (county !== '') {
      url += 'county=' + county + '&';
    }
    url += 'election=' + election;
    var viewportHeight = $(window).height();
    var newHeight = viewportHeight * 0.9;
    $('#iframe_modal').height(newHeight);

    $('#iframe_modal').attr('src', url);
    $('#report-modal').show();
  });

  $('#modal-close-0').click(function(){
  	url = '/ctb-legacy/loading_spinner.php';
  	$('#iframe_modal').attr('src', url);
  }); 

  $('#modal-close-1').click(function(){
  	url = '/ctb-legacy/loading_spinner.php';
  	$('#iframe_modal').attr('src', url);
  });  
});

function populateDistrictsDropdown(numDistricts, districtPrefix, districtName) {
  //console.log("Populating Districts - " + numDistricts);
  $('#districts').show();
  $('#county-dropdown').hide();
  var options = '';
  for (var i = 1; i <= numDistricts; i++) {
    var districtNumber = (i < 10 ? '0' : '') + i;
    options += '<option value="' + districtPrefix + districtNumber + '">' + districtName + ' ' + i + '</option>';
  }
  //console.log(options);
  $('#districts select').html(options);
  $('#districts select').prop('disabled', false);
}

function populateCountyDropdown() {
  $('#districts').hide();
  $('#county-dropdown').show();
  var options = '';
	var counties = [
	  'Alameda', 'Alpine', 'Amador', 'Butte', 'Calaveras', 'Colusa', 'Contra Costa', 'Del Norte', 'El Dorado', 'Fresno', 
	  'Glenn', 'Humboldt', 'Imperial', 'Inyo', 'Kern', 'Kings', 'Lake', 'Lassen', 'Los Angeles', 'Madera', 
	  'Marin', 'Mariposa', 'Mendocino', 'Merced', 'Modoc', 'Mono', 'Monterey', 'Napa', 'Nevada', 'Orange', 
	  'Placer', 'Plumas', 'Riverside', 'Sacramento', 'San Benito', 'San Bernardino', 'San Diego', 'San Francisco', 'San Joaquin', 'San Luis Obispo', 
	  'San Mateo', 'Santa Barbara', 'Santa Clara', 'Santa Cruz', 'Shasta', 'Sierra', 'Siskiyou', 'Solano', 'Sonoma', 'Stanislaus', 
	  'Sutter', 'Tehama', 'Trinity', 'Tulare', 'Tuolumne', 'Ventura', 'Yolo', 'Yuba'
	];

  for (var i = 1; i <= 58; i++) {
    var countyNumber = (i < 10 ? '0' : '') + i;
    var countyAbbr = 'CO' + countyNumber;
    var countyName = counties[i-1];
    options += '<option value="' + countyAbbr + '">' + countyName + '</option>';
  }
  $('#county-dropdown select').html(options);
  $('#county-dropdown select').prop('disabled', false);
}

</script>





@endsection


	
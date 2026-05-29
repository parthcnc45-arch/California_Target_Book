
@php ($book_side_nav_active = 'elections')

@extends('layouts.book')


@section('title', 'Election Detail Report (New) | California Target Book')

@section('content')
<div class='container'>
	<div class='row'>
		<h2>Election Detail Report by Geographical Area</h2>
		<div class="form-group row">
			<p><span class='report-label boldme'>Scope</span></p>
			<div class="form-check form-check-inline col-lg-3">
				<input class="form-check-input" type="radio" name="d1_radio" id="d1_radio" value="d1" checked>
				<label class="form-check-label" for="d1_radio">Single Geography</label>
			</div>
			<div class="form-check form-check-inline col-lg-3">
				<input class="form-check-input" type="radio" name="d1_radio" id="d2_radio" value="d2">
				<label class="form-check-label" for="d2_radio">Overlapping Area</label>
			</div>		
		</div>
		<div class='col-lg-6'>
			<div class='card card-orange'>
				<div class='card-head'>
					<h3>Geo Information</h3>
				</div>
				<div class='card-body'>
					<form>
						<div class="form-group" id="d1-type">
							<span class='report-label boldme'>Select District Type</span>
								<div class='row'>
									<div class='col-lg-6'>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d1-geo-type" id="d1-assembly" value="Assembly">
											<label class="form-check-label" for="d1-assembly">Assembly</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d1-geo-type" id="d1-state-senate" value="State Senate">
											<label class="form-check-label" for="d1-state-senate">State Senate</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d1-geo-type" id="d1-congressional" value="Congressional">
											<label class="form-check-label" for="d1-congressional">Congressional</label>
										</div>
									</div>
									<div class='col-lg-6'>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d1-geo-type" id="d1-county" value="County">
											<label class="form-check-label" for="d1-county">County</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d1-geo-type" id="d1-place" value="City">
											<label class="form-check-label" for="county">City/Place</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d1-geo-type" id="d1-zip" value="ZIP">
											<label class="form-check-label" for="d1-zip">ZIP Code</label>
										</div>
									</div>				      				      
								</div>
							</div>
							<div id="d1-district-div">
								<span class='report-label boldme'>Select District / County</span>
								<div id="d1-county-div" class='row' style="display: none;">

									<div class="form-group col-lg-6" id="d1-county-dropdown">
										<!-- Counties will be added dynamically here based on the radio button selected -->
										<select>
										</select>    
									</div>
									<div class="form-group col-lg-6" id="d1-county-sub-dropdown" style="display: none;">
										<!-- Counties will be added dynamically here based on the radio button selected -->
										<select>
										</select>    
									</div>
								</div>

								<div class="row" id="d1-dist">
									<div class="row">
										<div class="form-group" id="d1-districts" style="display: none;">
											<!-- Counties will be added dynamically here based on the radio button selected -->
											<select>
											</select>    
										</div>
									</div>
									<div class="row" style='border: 2px solid black;'>
										<p style='small' align='center'>Census Year Boundaries</p>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d1-geo-year" id="d1-1990" value="1990">
											<label class="form-check-label" for="d1-1990">1990</label>
										</div>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d1-geo-year" id="d1-2000" value="2000">
											<label class="form-check-label" for="d1-2000">2000</label>
										</div>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d1-geo-year" id="d1-2010" value="2010">
											<label class="form-check-label" for="d1-2010">2010</label>
										</div>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d1-geo-year" id="d1-2020" value="2020" checked>
											<label class="form-check-label" for="d1-2020">2020</label>
										</div>
									</div>
								</div>				      				      				
							</div>


							<div class="form-group" id="d1-city-dropdown" style="display: none;">
								<p><span class='report-label boldme'>Select City/Place</span></p>
								<!-- Counties will be added dynamically here based on the radio button selected -->
								<select>
									<?php populate_city_dropdown(); ?>
								</select>  				    
							</div>

							<div class="form-group" id="d1-zip-dropdown" style="display: none;">
								<p><span class='report-label boldme'>Select ZIP Code</span></p>
								<!-- Counties will be added dynamically here based on the radio button selected -->
								<select>
									<?php populate_zip_dropdown(); ?>
								</select>  				    
							</div>	
						
					</form>
				</div>
			</div>
		</div>


		<div class='col-lg-6' id="geo-2-div" style="display: none;">
			<div class='card card-yellow'>
				<div class='card-head'>
					<h3>Overlapping Geo Information</h3>
				</div>
				<div class='card-body'>

					<form>
						<div class="form-group" id="d2-type">
							<span class='report-label boldme'>Select District Type</span>
								<div class='row'>
									<div class='col-lg-6'>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d2-geo-type" id="d2-assembly" value="Assembly">
											<label class="form-check-label" for="d2-assembly">Assembly</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d2-geo-type" id="d2-state-senate" value="State Senate">
											<label class="form-check-label" for="d2-state-senate">State Senate</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d2-geo-type" id="d2-congressional" value="Congressional">
											<label class="form-check-label" for="d2-congressional">Congressional</label>
										</div>
									</div>
									<div class='col-lg-6'>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d2-geo-type" id="d2-county" value="County">
											<label class="form-check-label" for="d2-county">County</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d2-geo-type" id="d2-place" value="City">
											<label class="form-check-label" for="county">City/Place</label>
										</div>
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="radio" name="d2-geo-type" id="d2-zip" value="ZIP">
											<label class="form-check-label" for="d2-zip">ZIP Code</label>
										</div>
									</div>				      				      
								</div>
							</div>
							<div id="d2-district-div">
								<span class='report-label boldme'>Select District / County</span>
								<div id="d2-county-div" class='row' style="display: none;">

									<div class="form-group col-lg-6" id="d2-county-dropdown">
										<!-- Counties will be added dynamically here based on the radio button selected -->
										<select>
										</select>    
									</div>
									<div class="form-group col-lg-6" id="d2-county-sub-dropdown" style="display: none;">
										<!-- Counties will be added dynamically here based on the radio button selected -->
										<select>
										</select>    
									</div>
								</div>

								<div class="row" id="d2-dist">
									<div class="row">
										<div class="form-group" id="d2-districts" style="display: none;">
											<!-- Counties will be added dynamically here based on the radio button selected -->
											<select>
											</select>    
										</div>
									</div>
									<div class="row" style='border: 2px solid black;'>
										<p style='small' align='center'>Census Year Boundaries</p>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d2-geo-year" id="d2-1990" value="1990">
											<label class="form-check-label" for="d2-1990">1990</label>
										</div>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d2-geo-year" id="d2-2000" value="2000">
											<label class="form-check-label" for="d2-2000">2000</label>
										</div>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d2-geo-year" id="d2-2010" value="2010">
											<label class="form-check-label" for="d2-2010">2010</label>
										</div>
										<div class="form-check form-check-inline col-lg-3">
											<input class="form-check-input" type="radio" name="d2-geo-year" id="d2-2020" value="2020" checked>
											<label class="form-check-label" for="d2-2020">2020</label>
										</div>
									</div>
								</div>				      				      				
							</div>


							<div class="form-group" id="d2-city-dropdown" style="display: none;">
								<p><span class='report-label boldme'>Select City/Place</span></p>
								<!-- Counties will be added dynamically here based on the radio button selected -->
								<select>
									<?php populate_city_dropdown(); ?>
								</select>  				    
							</div>

							<div class="form-group" id="d2-zip-dropdown" style="display: none;">
								<p><span class='report-label boldme'>Select ZIP Code</span></p>
								<!-- Counties will be added dynamically here based on the radio button selected -->
								<select>
									<?php populate_zip_dropdown(); ?>
								</select>  				    
							</div>	
						
					</form>
				</div>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-lg-6">
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

			<button id='generate-report-btn' type='button' class='btn btn-primary' data-toggle='modal' data-target='#report-modal'>
				Generate Report
		    </button>
		</div>
	</div>
</div>


<!-- Bootstrap modal for displaying report -->
<div class="modal fade modal-1200" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-label" aria-hidden="true" width='90vw' align='center'>
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

<?php 

function populate_zip_dropdown() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT ZIP, ZIP_NM, PCT_POP FROM caldist_dist_zips ORDER BY ZIP, PCT_POP DESC";
	$result = $conn->query($sql);
	$arr = [];
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$zip = $row['ZIP'];
			if(!isset($arr[$zip])) {
				$arr[$zip] = $row;
			}
		}
	}
	foreach($arr as $zip => $x) {
		echo("<option value='$zip'>$zip - " . $x['ZIP_NM'] . "</option>");
	}

}

function populate_city_dropdown() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT name FROM ctb_census_places WHERE statefp = '06' ORDER BY name";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$place = $row['name'];
			echo("<option value='$place'>$place</option>");
		}
	}
}

?>

@endsection

@section('styles')

<style>

	.modal-1200 {
		min-width: 90vw !important;
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
  $('#generate-report-btn').prop('disabled', false);

  var qty_val = "d1";
  $('input[name="d1_radio"]').change(function() {
  	qty_val = $(this).val();
  	//console.log("Qty box: " + qty_val);
  	if(qty_val === "d2") {
  		$('#geo-2-div').show();
  	} else {
  		$('#geo-2-div').hide();
  	}
  });

  // show/hide the district dropdown based on the radio button selection
  $('input[name="d1-geo-type"]').click(function() {
    var selectedValue = $(this).val();
    console.log("Selected " + selectedValue);
    var selectedOffice = selectedValue;

      //DRAW THE DISTRICT OR COUNTY DROPDOWN
	  if (selectedOffice === 'Assembly') {
	    populateDistrictsDropdown(80, 'AD', 'Assembly District', 'd1');
	  } else if (selectedOffice === 'State Senate') {
	    populateDistrictsDropdown(40, 'SD', 'State Senate District', 'd1');
	  } else if (selectedOffice === 'Congressional') {
	    populateDistrictsDropdown(53, 'CD', 'Congressional District', 'd1');
	  } else if (selectedOffice === 'County') {
	    populateCountyDropdown("d1");
	  }




    if (selectedValue === 'Assembly' || selectedValue === 'State Senate' || selectedValue === 'Congressional') {
      $('#d1-districts').show();     
      $('#d1-district-div').show();     
      $('#d1-county-div').hide();
      $('#d1-city-dropdown').hide();
      $('#d1-zip-dropdown').hide();    
      $('#d1-county-dropdown').find('select').val('');
      $('#d1-county-sub-dropdown').find('select').val('');
      $('#d1-city-dropdown').find('select').val('');
      $('#d1-zip-dropdown').find('select').val('');
    } else if (selectedValue === 'County') {
      console.log('Showing County, hiding districts, city, zip dropdowns');
      $('#d1-county-div').show();    
      $('#d1-district-div').show();      
      $('#d1-districts').hide();
      $('#d1-city-dropdown').hide();
      $('#d1-zip-dropdown').hide();    
      $('#d1-districts').find('select').val('');
      $('#d1-city-dropdown').find('select').val('');
      $('#d1-zip-dropdown').find('select').val('');
    }else if (selectedValue === 'City') {
      $('#d1-city-dropdown').show();     
      $('#d1-districts').hide();
      $('#d1-district-div').hide();    
      $('#d1-county-div').hide();
      $('#d1-zip-dropdown').hide();    
      $('#d1-districts').find('select').val('');
      $('#d1-county-dropdown').find('select').val('');
      $('#d1-county-sub-dropdown').find('select').val('');
      $('#d1-zip-dropdown').find('select').val('');
    } else if (selectedValue === "ZIP") {
      $('#d1-zip-dropdown').show();     
      $('#d1-districts').hide();
      $('#d1-district-div').hide();    
      $('#d1-city-dropdown').hide();
      $('#d1-county-div').hide();    
      $('#d1-districts').find('select').val('');
      $('#d1-city-dropdown').find('select').val('');
      $('#d1-county-dropdown').find('select').val('');
      $('#d1-county-sub-dropdown').find('select').val('');
    }
  });

  $('#d1-county-dropdown').change(function(){
  		$('#d1-county-sub-dropdown').show();
  		var county_code = $('#d1-county-dropdown select').val();
  		populateCountySubDropdown(county_code, "d1");
  });

  // show/hide the d2 district dropdown based on the radio button selection
  $('input[name="d2-geo-type"]').click(function() {
    var selectedValue = $(this).val();
    console.log("Selected " + selectedValue);
    var selectedOffice = selectedValue;

      //DRAW THE DISTRICT OR COUNTY DROPDOWN
	  if (selectedOffice === 'Assembly') {
	    populateDistrictsDropdown(80, 'AD', 'Assembly District', 'd2');
	  } else if (selectedOffice === 'State Senate') {
	    populateDistrictsDropdown(40, 'SD', 'State Senate District', 'd2');
	  } else if (selectedOffice === 'Congressional') {
	    populateDistrictsDropdown(53, 'CD', 'Congressional District', 'd2');
	  } else if (selectedOffice === 'County') {
	    populateCountyDropdown("d2");
	  }

    if (selectedValue === 'Assembly' || selectedValue === 'State Senate' || selectedValue === 'Congressional') {
      $('#d2-districts').show();     
      $('#d2-district-div').show();     
      $('#d2-county-div').hide();
      $('#d2-city-dropdown').hide();
      $('#d2-zip-dropdown').hide();    
      $('#d2-county-dropdown').find('select').val('');
      $('#d2-city-dropdown').find('select').val('');
      $('#d2-zip-dropdown').find('select').val('');
      $('#d2-county-sub-dropdown').find('select').val('');
    } else if (selectedValue === 'County') {
      $('#d2-county-div').show();         
      $('#d2-district-div').show();     
      $('#d2-districts').hide();
      $('#d2-city-dropdown').hide();
      $('#d2-zip-dropdown').hide();    
      $('#d2-districts').find('select').val('');
      $('#d2-city-dropdown').find('select').val('');
      $('#d2-zip-dropdown').find('select').val('');
    }else if (selectedValue === 'City') {
      $('#d2-city-dropdown').show();     
      $('#d2-districts').hide();
      $('#d2-district-div').hide();     
      $('#d2-county-div').hide();
      $('#d2-zip-dropdown').hide();    
      $('#d2-districts').find('select').val('');
      $('#d2-county-dropdown').find('select').val('');
      $('#d2-zip-dropdown').find('select').val('');
      $('#d2-county-sub-dropdown').find('select').val('');
    } else if (selectedValue == "ZIP") {
      $('#d2-zip-dropdown').show();   
      $('#d2-district-div').hide();       
      $('#d2-districts').hide();
      $('#d2-city-dropdown').hide();
      $('#d2-county-div').hide();    
      $('#d2-districts').find('select').val('');
      $('#d2-city-dropdown').find('select').val('');
      $('#d2-county-dropdown').find('select').val('');
      $('#d2-county-sub-dropdown').find('select').val('');
    }
  });

  $('#d2-county-dropdown').change(function(){
  		$('#d2-county-sub-dropdown').show();
  		var county_code = $('#d2-county-dropdown select').val();
  		populateCountySubDropdown(county_code, "d2");
  });




  // open the modal when the generate report button is clicked
  $('#generate-report-btn').click(function() {
  	console.log('Firing Generate Report');

    var district = '';
    var county = '';
    var election = '';
    var qty = $('input[name="d1-radio"]').val();
    election = $('#election').val();
    var d1t = $("input[name='d1-geo-type']:checked").val();
    var d1y = $('input[name="d1-geo-year"]:checked').val();

    var url = '/ctb-legacy/new_results.php?geo=Y&election=' + election;

    console.log("d1t = " + d1t + " d1y = " + d1y);


    var d1_add = '';
    if(d1t === "Assembly" || d1t == "State Senate" || d1t === "Congressional") {
    	d1_type = "DIST";
    	d1 = $('#d1-districts select').val();
    	d1_add = '&d1_type=' + d1_type + '&d1=' + d1 + '&d1_year=' + d1y;
    } else if (d1t === "ZIP") {
    	d1_type = "ZIP";
    	d1 = $('#d1-zip-dropdown select').val();
    	d1_add = '&d1_type=' + d1_type + '&d1=' + d1;
    } else if (d1t === "County") {
    	d1 = $('#d1-county-dropdown select').val();
    	var d1_sub = $('#d1-county-sub-dropdown select').val();
    	if(d1_sub != '') {
    		d1_type = "SUPE";    		
    		d1_add = '&d1_type=' + d1_type + '&d1=' + d1 + '&d1_sub=' + d1_sub + "&d1_year=" +d1y;
    	} else {
    		d1_type = "COUNTY";
    		d1_add = '&d1_type=' + d1_type + '&d1=' + d1 
    	}
    } else if (d1t === "City") {
    	d1 = $('#d1-city-dropdown select').val();
    	d1_type = "CITY";
    	d1_add = '&d1_type=' + d1_type + '&d1=' + d1 
    }

    var d2_add = '';

    url += d1_add;
    

    if(qty_val === "d2") {
    	var d2t = $("input[name='d2-geo-type']:checked").val();
    	var d2y = $('input[name="d2-geo-year"]:checked').val();

	    if(d2t === "Assembly" || d2t == "State Senate" || d2t === "Congressional") {
	    	d2_type = "DIST";
	    	d2 = $('#d2-districts select').val();
	    	d2_add = '&d2_type=' + d2_type + '&d2=' + d2 + '&d2_year=' + d2y;
	    } else if (d2t === "ZIP") {
	    	d2_type = "ZIP";
	    	d2 = $('#d2-zip-dropdown select').val();
	    	d2_add = '&d2_type=' + d2_type + '&d2=' + d2;
	    } else if (d2t === "County") {
	    	d2 = $('#d2-county-dropdown select').val();
	    	var d2_sub = $('#d2-county-sub-dropdown select').val();
	    	if(d2_sub != '') {
	    		d2_type = "SUPE";    		
	    		d2_add = '&d2_type=' + d2_type + '&d2=' + d2 + '&d2_sub=' + d2_sub + "&d2_year=" +d2y;
	    	} else {
	    		d2_type = "COUNTY";
	    		d2_add = '&d2_type=' + d2_type + '&d2=' + d2 
	    	}
	    } else if (d2t === "City") {
	    	d2 = $('#d2-city-dropdown select').val();
	    	d2_type = "CITY";
	    	d2_add = '&d2_type=' + d2_type + '&d2=' + d2 
	    }
	    url += d2_add;	
    }



    console.log('URL = ' + url);

    
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

function populateDistrictsDropdown(numDistricts, districtPrefix, districtName, geonum) {
  //console.log("Populating Districts - " + numDistricts);
  var district_id = "#" + geonum + "-districts";
  var county_id = "#" + geonum + "-county-dropdown";
  $(district_id).show();
  //$(county_id).hide();
  var options = '';
  for (var i = 1; i <= numDistricts; i++) {
    var districtNumber = (i < 10 ? '0' : '') + i;
    options += '<option value="' + districtPrefix + districtNumber + '">' + districtName + ' ' + i + '</option>';
  }
  //console.log(options);
  $(district_id + ' select').html(options);
  
}

function populateCountySubDropdown(county_code, geonum) {
	//console.log("County Sub Dropdown: " + county_code + ", " + geonum);
	var dd_id = "#" + geonum + "-county-sub-dropdown";
	if(county_code === "CO38") {
		cnt = 8;
	} else {
		cnt = 5;
	}
	var options = "<option value=''>Entire County</option>";
	for(var i = 1; i <= cnt; i++) {
		options += "<option value='" + i + "'>Supervisorial District #" + i + "</option>";
	}
  	$(dd_id + ' select').html(options);
  	
}

function populateCountyDropdown(geonum) {
  var district_id = "#" + geonum + "-districts";
  var county_id = "#" + geonum + "-county-dropdown";
  //$(district_id).hide();
  //$(county_id).show();
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
  $(county_id + ' select').html(options);
  
}

</script>



@endsection


	
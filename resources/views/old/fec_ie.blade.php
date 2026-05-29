<?php

global $endjava, $cmte_id, $hdr;
$endjava = Array();
Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;


?>



@php ($book_side_nav_active = 'finance')

@extends('layouts.book')

@section('title', 'FEC Independent Expenditures | California Target Book')

@section('content')



		<h2>FEC Independent Expenditure Reports</h2>
		<h3>Select Election Cycle and Race</h3>

		<form>

	             <label for="year">Select Year:</label>
	             <select id="year" name="year" onchange="loadRaces()">
            	          <option value='' selected>Select Year</option>
	                  <?php
                		for ($year = 2012; $year <= 2024; $year += 2) {
		                    echo "<option value='$year'>$year</option>";
                		}
	                  ?>
            
		     </select>
        	     <label for="race">Select Race:</label>
	             <select id="race" name="race" onchange="openModal()">
            	          <option value="">Select Race</option> <!-- Default option -->
	             </select>
    		</form>

	        <div id="modal" class="modal" align='center'>
		        <div class="modal-content" align='center'>
		            <span class="close" onclick="closeModal()">&times;</span> <!-- Close button -->
		            <iframe id='modal-iframe' src='/ctb-legacy/loading_spinner.php' width='100%' height='100%'></iframe>
		        </div>
		</div>         

@endsection

@section('scripts')

    <script>
    function loadRaces() {
        const year = document.getElementById("year").value;
        const raceDropdown = document.getElementById("race");
        raceDropdown.innerHTML = "";

        // Make an AJAX request to the PHP script to fetch race data
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {

                const raceData = JSON.parse(xhr.responseText);
                const racesByCategory = {
                    P: [],
                    S: [],
                    H: [],
                };

                for(const key in raceData) {
                    if(key.startsWith("POTUS")) {
                        racesByCategory.P.push(key);
                    } else if (key.endsWith("SEN")) {
                        racesByCategory.S.push(key);
                    } else {
                        racesByCategory.H.push(key);
                    }
                }

                // Add the options to the dropdown
                raceDropdown.innerHTML = '<option value="">Select Race</option>';
                addOptionsToDropdown(raceDropdown, racesByCategory.P);
                addOptionsToDropdown(raceDropdown, racesByCategory.S);
                addOptionsToDropdown(raceDropdown, racesByCategory.H);
            }
        };
        xhr.open("GET", "/ctb-legacy/ie_by_year_autocomplete.php?year=" + year, true);
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.send();
    }

    function addOptionsToDropdown(dropdown, options) {
        options.forEach(function (code) {
            dropdown.innerHTML += `<option value="${code}">${code}</option>`;
        });
    }
        function openModal() {
            const year = document.getElementById("year").value;
            const race = document.getElementById("race").value;

            const modal = document.getElementById("modal");
            const modalIframe = document.getElementById("modal-iframe");
            const modalContent = document.getElementById("modal-content");
            
            modal.style.display = "block";
            modalIframe.src = "/ctb-legacy/draw_ie.php?id=" + race + "&cycle=" + year;
        }
        function closeModal() {
            const modal = document.getElementById("modal");
            const modalIframe = document.getElementById("modal-iframe");

            modal.style.display = "none";
            modalIframe.src = "/ctb-legacy/loading_spinner.php"; // Clear the iframe source
        }

    </script>


@endsection

@section('styles')

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.css"/>


<style>

    @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Blinker&display=swap');


h2, h3, h4, h5, h6 {
  font-family: 'Blinker';
  font-weight: bold;
 
  font-variant: small-caps;
}

        .modal {
            display: none;

	    margin-top: 100px;
            z-index: 999;
            margin-left: auto;
            margin-right: auto;
            width: 90vw;
            height: 90vh;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fff;
            width: 100%;
            height: 100%;
            min-height: 800px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            text-align: center;
            position: relative;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 3em;
            font-weight: bold;
            color: white;
            background-color: #AA0000;
            cursor: pointer;
        }  
    </style>


@endsection



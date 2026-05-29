<!DOCTYPE html>
<html lang="en">

<head>

<?php 

include "php/head.php"; 

?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<style type="text/css">

body {
	background-color: white;
}

   .box1800 {
      background-image: url(box1800.jpg);
      background-position: center;
	}

   .box1200 {
      background-image: url(box1200.jpg);
      background-position: center;
	}

  	.box800 {
      background-image: url(box800.jpg);
      background-position: center;
      background-repeat: no-repeat;
      background-size: contain;
	}


</style>

<?php

include "php/ctb_api.php";

$endjava = Array();


error_reporting(E_ALL);
ini_set('display_errors', '1');
error_reporting(E_ERROR | E_PARSE);

$report = $_GET['id'];

switch($report) {
	case "age":
		age_report();
		break;
	case "race":
		race_report();
		break;
	case "school":
		school_report();
		break;
	case "education":
		education_report();
		break;
	case "veteran":
		veterans_report();
		break;
	case "born":
		born_report();
		break;
	case "language":
		language_report();
		break;
	case "class":
		class_report();
		break;
	case "occupation":
		occupation_report();
		break;
	case "industry":
		industry_report();
		break;
	case "income":
		income_report();
		break;
	default:
		age_report();
		break;
}




function age_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th>
					<th>INCUMBENT</th>
					<th>ADV</th>
					<th>< 5</th>
					<th>5-9</th>
					<th>10-14</th>
					<th>15-19</th>
					<th>20-24</th>
					<th>25-34</th>
					<th>35-44</th>
					<th>45-54</th>
					<th>55-59</th>
					<th>60-64</th>
					<th>65-74</th>
					<th>74-84</th>
					<th>85+</th>
					<th>Median Age</th>
					<th>18+</th>
					<th>21+</th>
					<th>65+</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_ages($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);
		$tablebody .= "
				<tr>
					<td>$fourcode</td>
					<td>$incumbent</td>
					<td>$advantage</td>
					<td>" . $x['VC08'] . "</td>
					<td>" . $x['VC09'] . "</td>
					<td>" . $x['VC10'] . "</td>
					<td>" . $x['VC11'] . "</td>
					<td>" . $x['VC12'] . "</td>
					<td>" . $x['VC13'] . "</td>
					<td>" . $x['VC14'] . "</td>
					<td>" . $x['VC15'] . "</td>
					<td>" . $x['VC16'] . "</td>
					<td>" . $x['VC17'] . "</td>
					<td>" . $x['VC18'] . "</td>
					<td>" . $x['VC19'] . "</td>
					<td>" . $x['VC20'] . "</td>
					<td>" . $x['VC23'] . "</td>
					<td>" . $x['VC26'] . "</td>
					<td>" . $x['VC27'] . "</td>
					<td>" . $x['VC29'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< 5</th>
					<th>5-9</th>
					<th>10-14</th>
					<th>15-19</th>
					<th>20-24</th>
					<th>25-34</th>
					<th>35-44</th>
					<th>45-54</th>
					<th>55-59</th>
					<th>60-64</th>
					<th>65-74</th>
					<th>74-84</th>
					<th>85+</th>
					<th>Median Age</th>
					<th>18+</th>
					<th>21+</th>
					<th>65+</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_ages($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC08'] . "</td>
					<td>" . $x['VC09'] . "</td>
					<td>" . $x['VC10'] . "</td>
					<td>" . $x['VC11'] . "</td>
					<td>" . $x['VC12'] . "</td>
					<td>" . $x['VC13'] . "</td>
					<td>" . $x['VC14'] . "</td>
					<td>" . $x['VC15'] . "</td>
					<td>" . $x['VC16'] . "</td>
					<td>" . $x['VC17'] . "</td>
					<td>" . $x['VC18'] . "</td>
					<td>" . $x['VC19'] . "</td>
					<td>" . $x['VC20'] . "</td>
					<td>" . $x['VC23'] . "</td>
					<td>" . $x['VC26'] . "</td>
					<td>" . $x['VC27'] . "</td>
					<td>" . $x['VC29'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< 5</th>
					<th>5-9</th>
					<th>10-14</th>
					<th>15-19</th>
					<th>20-24</th>
					<th>25-34</th>
					<th>35-44</th>
					<th>45-54</th>
					<th>55-59</th>
					<th>60-64</th>
					<th>65-74</th>
					<th>74-84</th>
					<th>85+</th>
					<th>Median Age</th>
					<th>18+</th>
					<th>21+</th>
					<th>65+</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_ages($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC08'] . "</td>
					<td>" . $x['VC09'] . "</td>
					<td>" . $x['VC10'] . "</td>
					<td>" . $x['VC11'] . "</td>
					<td>" . $x['VC12'] . "</td>
					<td>" . $x['VC13'] . "</td>
					<td>" . $x['VC14'] . "</td>
					<td>" . $x['VC15'] . "</td>
					<td>" . $x['VC16'] . "</td>
					<td>" . $x['VC17'] . "</td>
					<td>" . $x['VC18'] . "</td>
					<td>" . $x['VC19'] . "</td>
					<td>" . $x['VC20'] . "</td>
					<td>" . $x['VC23'] . "</td>
					<td>" . $x['VC26'] . "</td>
					<td>" . $x['VC27'] . "</td>
					<td>" . $x['VC29'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}


function race_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>WHITE</th>
					<th>AF-AM</th>
					<th>LATINO</th>
					<th>ASIAN</th>
					<th>E. IND</th>
					<th>CHINESE</th>
					<th>FILIPINO</th>
					<th>JAPANESE</th>
					<th>KOREAN</th>
					<th>VIETNAMESE</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_races($fourcode);

		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC94'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC87'] . "</td>
					<td>" . $x['VC81'] . "</td>
					<td>" . $x['VC57'] . "</td>
					<td>" . $x['VC58'] . "</td>
					<td>" . $x['VC59'] . "</td>
					<td>" . $x['VC60'] . "</td>
					<td>" . $x['VC61'] . "</td>
					<td>" . $x['VC62'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>WHITE</th>
					<th>AF-AM</th>
					<th>LATINO</th>
					<th>ASIAN</th>
					<th>E. IND</th>
					<th>CHINESE</th>
					<th>FILIPINO</th>
					<th>JAPANESE</th>
					<th>KOREAN</th>
					<th>VIETNAMESE</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_races($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC94'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC87'] . "</td>
					<td>" . $x['VC81'] . "</td>
					<td>" . $x['VC57'] . "</td>
					<td>" . $x['VC58'] . "</td>
					<td>" . $x['VC59'] . "</td>
					<td>" . $x['VC60'] . "</td>
					<td>" . $x['VC61'] . "</td>
					<td>" . $x['VC62'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>WHITE</th>
					<th>AF-AM</th>
					<th>LATINO</th>
					<th>ASIAN</th>
					<th>E. IND</th>
					<th>CHINESE</th>
					<th>FILIPINO</th>
					<th>JAPANESE</th>
					<th>KOREAN</th>
					<th>VIETNAMESE</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_races($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC94'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC87'] . "</td>
					<td>" . $x['VC81'] . "</td>
					<td>" . $x['VC57'] . "</td>
					<td>" . $x['VC58'] . "</td>
					<td>" . $x['VC59'] . "</td>
					<td>" . $x['VC60'] . "</td>
					<td>" . $x['VC61'] . "</td>
					<td>" . $x['VC62'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function school_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>PRESCHOOL</th>
					<th>KINDERGARTEN</th>
					<th>ELEMENTARY</th>
					<th>HIGH SCHOOL</th>
					<th>COLLEGE/GRADUATE SCHOOL</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_school($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC77'] . "</td>
					<td>" . $x['VC78'] . "</td>
					<td>" . $x['VC79'] . "</td>
					<td>" . $x['VC80'] . "</td>
					<td>" . $x['VC81'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>PRESCHOOL</th>
					<th>KINDERGARTEN</th>
					<th>ELEMENTARY</th>
					<th>HIGH SCHOOL</th>
					<th>COLLEGE/GRADUATE SCHOOL</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_school($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC77'] . "</td>
					<td>" . $x['VC78'] . "</td>
					<td>" . $x['VC79'] . "</td>
					<td>" . $x['VC80'] . "</td>
					<td>" . $x['VC81'] . "</td>
				</tr>
		";;
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>PRESCHOOL</th>
					<th>KINDERGARTEN</th>
					<th>ELEMENTARY</th>
					<th>HIGH SCHOOL</th>
					<th>COLLEGE/GRADUATE SCHOOL</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_school($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC77'] . "</td>
					<td>" . $x['VC78'] . "</td>
					<td>" . $x['VC79'] . "</td>
					<td>" . $x['VC80'] . "</td>
					<td>" . $x['VC81'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function education_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< 9TH GRADE</th>
					<th>9TH-12TH GRADE</th>
					<th>HS GRADUATE</th>
					<th>SOME COLLEGE</th>
					<th>ASSOCIATE'S</th>
					<th>BACHELOR'S</th>
					<th>GRADUATE DEGREE</th>
					<th>HS+</th>
					<th>BACHELOR'S+</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_education($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC86'] . "</td>
					<td>" . $x['VC87'] . "</td>
					<td>" . $x['VC88'] . "</td>
					<td>" . $x['VC89'] . "</td>
					<td>" . $x['VC90'] . "</td>
					<td>" . $x['VC91'] . "</td>
					<td>" . $x['VC92'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC96'] . "</td>
		
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< 9TH GRADE</th>
					<th>9TH-12TH GRADE</th>
					<th>HS GRADUATE</th>
					<th>SOME COLLEGE</th>
					<th>ASSOCIATE'S</th>
					<th>BACHELOR'S</th>
					<th>GRADUATE DEGREE</th>
					<th>HS+</th>
					<th>BACHELOR'S+</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_education($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC86'] . "</td>
					<td>" . $x['VC87'] . "</td>
					<td>" . $x['VC88'] . "</td>
					<td>" . $x['VC89'] . "</td>
					<td>" . $x['VC90'] . "</td>
					<td>" . $x['VC91'] . "</td>
					<td>" . $x['VC92'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC96'] . "</td>
		
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< 9TH GRADE</th>
					<th>9TH-12TH GRADE</th>
					<th>HS GRADUATE</th>
					<th>SOME COLLEGE</th>
					<th>ASSOCIATE'S</th>
					<th>BACHELOR'S</th>
					<th>GRADUATE DEGREE</th>
					<th>HS+</th>
					<th>BACHELOR'S+</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_education($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC86'] . "</td>
					<td>" . $x['VC87'] . "</td>
					<td>" . $x['VC88'] . "</td>
					<td>" . $x['VC89'] . "</td>
					<td>" . $x['VC90'] . "</td>
					<td>" . $x['VC91'] . "</td>
					<td>" . $x['VC92'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC96'] . "</td>
		
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function veterans_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>VETERAN</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_veterans($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC101'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>VETERAN</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_veterans($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC101'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>VETERAN</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_veterans($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC101'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function born_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>NATIVE</th>
					<th>BORN IN U.S.</th>
					<th>BORN IN CA</th>
					<th>BORN IN OTHER STATE</th>
					<th>FOREIGN BORN</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_born($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC131'] . "</td>
					<td>" . $x['VC132'] . "</td>
					<td>" . $x['VC133'] . "</td>
					<td>" . $x['VC134'] . "</td>
					<td>" . $x['VC136'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>NATIVE</th>
					<th>BORN IN U.S.</th>
					<th>BORN IN CA</th>
					<th>BORN IN OTHER STATE</th>
					<th>FOREIGN BORN</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_born($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC131'] . "</td>
					<td>" . $x['VC132'] . "</td>
					<td>" . $x['VC133'] . "</td>
					<td>" . $x['VC134'] . "</td>
					<td>" . $x['VC136'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>NATIVE</th>
					<th>BORN IN U.S.</th>
					<th>BORN IN CA</th>
					<th>BORN IN OTHER STATE</th>
					<th>FOREIGN BORN</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_born($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC131'] . "</td>
					<td>" . $x['VC132'] . "</td>
					<td>" . $x['VC133'] . "</td>
					<td>" . $x['VC134'] . "</td>
					<td>" . $x['VC136'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function language_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>ENGLISH-ONLY</th>
					<th>SPANISH</th>
					<th>OTHER INDO-EUROPEAN</th>
					<th>OTHER ASIAN-PACIFIC</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_lang($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC171'] . "</td>
					<td>" . $x['VC174'] . "</td>
					<td>" . $x['VC176'] . "</td>
					<td>" . $x['VC178'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>ENGLISH-ONLY</th>
					<th>SPANISH</th>
					<th>OTHER INDO-EUROPEAN</th>
					<th>OTHER ASIAN-PACIFIC</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_lang($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC171'] . "</td>
					<td>" . $x['VC174'] . "</td>
					<td>" . $x['VC176'] . "</td>
					<td>" . $x['VC178'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>ENGLISH-ONLY</th>
					<th>SPANISH</th>
					<th>OTHER INDO-EUROPEAN</th>
					<th>OTHER ASIAN-PACIFIC</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_lang($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC171'] . "</td>
					<td>" . $x['VC174'] . "</td>
					<td>" . $x['VC176'] . "</td>
					<td>" . $x['VC178'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function occupation_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>MGMT/BUSINESS/SCIENCE/ARTS</th>
					<th>SERVICE</th>
					<th>SALES/OFFICE</th>
					<th>NAT. RESOURCE/CONSTRUCTION/MAINTENANCE</th>
					<th>PRODUCTION/TRANSPORTATION</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_occupation($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC41'] . "</td>
					<td>" . $x['VC42'] . "</td>
					<td>" . $x['VC43'] . "</td>
					<td>" . $x['VC44'] . "</td>
					<td>" . $x['VC45'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>MGMT/BUSINESS/SCIENCE/ARTS</th>
					<th>SERVICE</th>
					<th>SALES/OFFICE</th>
					<th>NAT. RESOURCE/CONSTRUCTION/MAINTENANCE</th>
					<th>PRODUCTION/TRANSPORTATION</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_occupation($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC41'] . "</td>
					<td>" . $x['VC42'] . "</td>
					<td>" . $x['VC43'] . "</td>
					<td>" . $x['VC44'] . "</td>
					<td>" . $x['VC45'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>MGMT/BUSINESS/SCIENCE/ARTS</th>
					<th>SERVICE</th>
					<th>SALES/OFFICE</th>
					<th>NAT. RESOURCE/CONSTRUCTION/MAINTENANCE</th>
					<th>PRODUCTION/TRANSPORTATION</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_occupation($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC41'] . "</td>
					<td>" . $x['VC42'] . "</td>
					<td>" . $x['VC43'] . "</td>
					<td>" . $x['VC44'] . "</td>
					<td>" . $x['VC45'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function industry_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>AG</th>
					<th>CONST</th>
					<th>MFG</th>
					<th>WHOLESALE</th>
					<th>RETAIL</th>
					<th>TRANS</th>
					<th>INFO</th>
					<th>FINANCE/INS/REAL ESTATE</th>
					<th>PROF/SCIEN</th>
					<th>EDUCATION/HEALTH</th>
					<th>ARTS & ENT</th>
					<th>PUBLIC ADMIN</th>
					<th>OTHER</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_industry($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC50'] . "</td>
					<td>" . $x['VC51'] . "</td>
					<td>" . $x['VC52'] . "</td>
					<td>" . $x['VC53'] . "</td>
					<td>" . $x['VC54'] . "</td>
					<td>" . $x['VC55'] . "</td>
					<td>" . $x['VC56'] . "</td>
					<td>" . $x['VC57'] . "</td>
					<td>" . $x['VC58'] . "</td>
					<td>" . $x['VC59'] . "</td>
					<td>" . $x['VC60'] . "</td>
					<td>" . $x['VC62'] . "</td>
					<td>" . $x['VC61'] . "</td>					
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>AG</th>
					<th>CONST</th>
					<th>MFG</th>
					<th>WHOLESALE</th>
					<th>RETAIL</th>
					<th>TRANS</th>
					<th>INFO</th>
					<th>FINANCE/INS/REAL ESTATE</th>
					<th>PROF/SCIEN</th>
					<th>EDUCATION/HEALTH</th>
					<th>ARTS & ENT</th>
					<th>PUBLIC ADMIN</th>
					<th>OTHER</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_industry($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC50'] . "</td>
					<td>" . $x['VC51'] . "</td>
					<td>" . $x['VC52'] . "</td>
					<td>" . $x['VC53'] . "</td>
					<td>" . $x['VC54'] . "</td>
					<td>" . $x['VC55'] . "</td>
					<td>" . $x['VC56'] . "</td>
					<td>" . $x['VC57'] . "</td>
					<td>" . $x['VC58'] . "</td>
					<td>" . $x['VC59'] . "</td>
					<td>" . $x['VC60'] . "</td>
					<td>" . $x['VC62'] . "</td>
					<td>" . $x['VC61'] . "</td>					
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>AG</th>
					<th>CONST</th>
					<th>MFG</th>
					<th>WHOLESALE</th>
					<th>RETAIL</th>
					<th>TRANS</th>
					<th>INFO</th>
					<th>FINANCE/INS/REAL ESTATE</th>
					<th>PROF/SCIEN</th>
					<th>EDUCATION/HEALTH</th>
					<th>ARTS & ENT</th>
					<th>PUBLIC ADMIN</th>
					<th>OTHER</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_industry($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC50'] . "</td>
					<td>" . $x['VC51'] . "</td>
					<td>" . $x['VC52'] . "</td>
					<td>" . $x['VC53'] . "</td>
					<td>" . $x['VC54'] . "</td>
					<td>" . $x['VC55'] . "</td>
					<td>" . $x['VC56'] . "</td>
					<td>" . $x['VC57'] . "</td>
					<td>" . $x['VC58'] . "</td>
					<td>" . $x['VC59'] . "</td>
					<td>" . $x['VC60'] . "</td>
					<td>" . $x['VC62'] . "</td>
					<td>" . $x['VC61'] . "</td>					
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function class_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>PRIVATE EMPLOYMENT</th>
					<th>GOVT EMPLOYMENT</th>
					<th>SELF-EMPLOYED</th>
					<th>UNPAID FAMILY WORKERS</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_class($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC67'] . "</td>
					<td>" . $x['VC68'] . "</td>
					<td>" . $x['VC69'] . "</td>
					<td>" . $x['VC70'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>PRIVATE EMPLOYMENT</th>
					<th>GOVT EMPLOYMENT</th>
					<th>SELF-EMPLOYED</th>
					<th>UNPAID FAMILY WORKERS</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_class($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC67'] . "</td>
					<td>" . $x['VC68'] . "</td>
					<td>" . $x['VC69'] . "</td>
					<td>" . $x['VC70'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>PRIVATE EMPLOYMENT</th>
					<th>GOVT EMPLOYMENT</th>
					<th>SELF-EMPLOYED</th>
					<th>UNPAID FAMILY WORKERS</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_class($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC67'] . "</td>
					<td>" . $x['VC68'] . "</td>
					<td>" . $x['VC69'] . "</td>
					<td>" . $x['VC70'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function income_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< $10K</th>
					<th>$10K-$15K</th>
					<th>$15K-$25K</th>
					<th>$25K-$35K</th>
					<th>$35K-$50K</th>
					<th>$50K-$75K</th>
					<th>$75K-$100K</th>
					<th>$100K-$150K</th>
					<th>$150K-$200K</th>
					<th>$200K+</th>
					<th>Median</th>
					<th>Mean</th>
					<th>w/SS</th>
					<th>w/SSI</th>
					<th>w/Pub Assist</th>
					<th>w/SNAP</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_income($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC75'] . "</td>
					<td>" . $x['VC76'] . "</td>
					<td>" . $x['VC77'] . "</td>
					<td>" . $x['VC78'] . "</td>
					<td>" . $x['VC79'] . "</td>
					<td>" . $x['VC80'] . "</td>
					<td>" . $x['VC81'] . "</td>
					<td>" . $x['VC82'] . "</td>
					<td>" . $x['VC83'] . "</td>
					<td>" . $x['VC84'] . "</td>
					<td>" . $x['VC85'] . "</td>
					<td>" . $x['VC86'] . "</td>
					<td>" . $x['VC90'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC97'] . "</td>
					<td>" . $x['VC99'] . "</td>																
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< $10K</th>
					<th>$10K-$15K</th>
					<th>$15K-$25K</th>
					<th>$25K-$35K</th>
					<th>$35K-$50K</th>
					<th>$50K-$75K</th>
					<th>$75K-$100K</th>
					<th>$100K-$150K</th>
					<th>$150K-$200K</th>
					<th>$200K+</th>
					<th>Median</th>
					<th>Mean</th>
					<th>w/SS</th>
					<th>w/SSI</th>
					<th>w/Pub Assist</th>
					<th>w/SNAP</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_income($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC75'] . "</td>
					<td>" . $x['VC76'] . "</td>
					<td>" . $x['VC77'] . "</td>
					<td>" . $x['VC78'] . "</td>
					<td>" . $x['VC79'] . "</td>
					<td>" . $x['VC80'] . "</td>
					<td>" . $x['VC81'] . "</td>
					<td>" . $x['VC82'] . "</td>
					<td>" . $x['VC83'] . "</td>
					<td>" . $x['VC84'] . "</td>
					<td>" . $x['VC85'] . "</td>
					<td>" . $x['VC86'] . "</td>
					<td>" . $x['VC90'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC97'] . "</td>
					<td>" . $x['VC99'] . "</td>																
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>< $10K</th>
					<th>$10K-$15K</th>
					<th>$15K-$25K</th>
					<th>$25K-$35K</th>
					<th>$35K-$50K</th>
					<th>$50K-$75K</th>
					<th>$75K-$100K</th>
					<th>$100K-$150K</th>
					<th>$150K-$200K</th>
					<th>$200K+</th>
					<th>Median</th>
					<th>Mean</th>
					<th>w/SS</th>
					<th>w/SSI</th>
					<th>w/Pub Assist</th>
					<th>w/SNAP</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_income($fourcode);
		$incumbent = getofficeholder($fourcode);
		$advantage = getpartisanadvantage($fourcode);		
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC75'] . "</td>
					<td>" . $x['VC76'] . "</td>
					<td>" . $x['VC77'] . "</td>
					<td>" . $x['VC78'] . "</td>
					<td>" . $x['VC79'] . "</td>
					<td>" . $x['VC80'] . "</td>
					<td>" . $x['VC81'] . "</td>
					<td>" . $x['VC82'] . "</td>
					<td>" . $x['VC83'] . "</td>
					<td>" . $x['VC84'] . "</td>
					<td>" . $x['VC85'] . "</td>
					<td>" . $x['VC86'] . "</td>
					<td>" . $x['VC90'] . "</td>
					<td>" . $x['VC95'] . "</td>
					<td>" . $x['VC97'] . "</td>
					<td>" . $x['VC99'] . "</td>																
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function housing_report() {
	global $endjava;

	echo("<div class='newseg'><h1>Assembly</h1>");

	$fourcodes = getads();
	$thisid = "adtable";

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>OWNERS</th>
					<th>RENTERS</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_housing($fourcode);
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC64'] . "</td>
					<td>" . $x['VC65'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	echo("<h1>Senate</h1>");

	$fourcodes = getsds();
	$thisid = "sd_table";
	$tablebody = '';

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);
	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>OWNERS</th>
					<th>RENTERS</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_housing($fourcode);
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC64'] . "</td>
					<td>" . $x['VC65'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);

	$fourcodes = getcds();
	$thisid = "cd_table";
	$tablebody = '';
	echo("<h1>Congress</h1>");

	$js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

	array_push($endjava, $js);

	$tablehead = "
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th>DIST</th><th>INCUMBENT</th><th>ADV</th>
					<th>OWNERS</th>
					<th>RENTERS</th>
				</tr>
			</thead>
			<tbody>
	";
	foreach($fourcodes as $fourcode) {
		$x = get_census_housing($fourcode);
		$tablebody .= "
				<tr>
					<td>$fourcode</td><td>$incumbent</td><td>$advantage</td>
					<td>" . $x['VC64'] . "</td>
					<td>" . $x['VC65'] . "</td>
				</tr>
		";
	}

	$tableend = "
		</tbody>
		</table>
	";

	echo($tablehead . $tablebody . $tableend);	
	echo("</div>");
}

function getads() {
	$retval = Array();
	$i=1;
	while($i < 81) {
		$thisfourcode = "AD" . checkaddzero($i);
		array_push($retval, $thisfourcode);
		$i++;
	}
	return $retval;	
	var_dump($retval);
}

function getcds() {
	$retval = Array();
	$i=1;
	while($i < 54) {
		$thisfourcode = "CD" . checkaddzero($i);
		array_push($retval, $thisfourcode);
		$i++;
	}
	return $retval;	
}

function getsds() {
	$retval = Array();
	$i=1;
	while($i < 41) {
		$thisfourcode = "SD" . checkaddzero($i);
		array_push($retval, $thisfourcode);
		$i++;
	}
	return $retval;	
}

function get_census_ages($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp05 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC08'] = $row['HC03_VC08']; //UNDER 5
			$tmp['VC09'] = $row['HC03_VC09']; //
			$tmp['VC10'] = $row['HC03_VC10']; //
			$tmp['VC11'] = $row['HC03_VC11']; //
			$tmp['VC12'] = $row['HC03_VC12']; //
			$tmp['VC13'] = $row['HC03_VC13']; //
			$tmp['VC14'] = $row['HC03_VC14']; //
			$tmp['VC15'] = $row['HC03_VC15']; //
			$tmp['VC16'] = $row['HC03_VC16']; //
			$tmp['VC17'] = $row['HC03_VC17']; //
			$tmp['VC18'] = $row['HC03_VC18']; //
			$tmp['VC19'] = $row['HC03_VC19']; //
			$tmp['VC20'] = $row['HC03_VC20']; //85 PLUS
			$tmp['VC23'] = $row['HC01_VC23']; //MEDIAN AGE
			$tmp['VC26'] = $row['HC03_VC26']; //18+
			$tmp['VC27'] = $row['HC03_VC27']; //21+
			$tmp['VC29'] = $row['HC03_VC29']; //65+
		}
	}
	return $tmp;
}

function get_census_races($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp05 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC94'] = $row['HC03_VC94']; //WHITE ONLY
			$tmp['VC95'] = $row['HC03_VC95']; //AFRICAN AMERICAN
			$tmp['VC87'] = $row['HC03_VC88']; //LATINO
			$tmp['VC81'] = $row['HC03_VC81']; //ASIAN
			$tmp['VC57'] = $row['HC03_VC57']; //E. IND
			$tmp['VC58'] = $row['HC03_VC58']; //CHINESE
			$tmp['VC59'] = $row['HC03_VC59']; //FILIPINO
			$tmp['VC60'] = $row['HC03_VC60']; //JAPANESE
			$tmp['VC61'] = $row['HC03_VC61']; //KOREAN
			$tmp['VC62'] = $row['HC03_VC62']; //VIETNAMESE
		}
	}
	//var_dump($tmp);
	return $tmp;	
}

function get_census_school($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp02 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC77'] = $row['HC03_VC77']; //PRESCHOOL
			$tmp['VC78'] = $row['HC03_VC78']; //KINDERGARTEN
			$tmp['VC79'] = $row['HC03_VC79']; //ELEMENTARY
			$tmp['VC80'] = $row['HC03_VC80']; //HIGH SCHOOL
			$tmp['VC81'] = $row['HC03_VC81']; //COLLEGE/GRADUATE SCHOOL
		}
	}
	return $tmp;	
}

function get_census_education($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp02 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC86'] = $row['HC03_VC86']; //LESS THAN 9TH GRADE
			$tmp['VC87'] = $row['HC03_VC87']; //9th TO 12TH GRADE
			$tmp['VC88'] = $row['HC03_VC88']; //HS GRAD
			$tmp['VC89'] = $row['HC03_VC89']; //SOME COLLEGE
			$tmp['VC90'] = $row['HC03_VC90']; //ASSOCIATE'S
			$tmp['VC91'] = $row['HC03_VC91']; //BACHELOR'S
			$tmp['VC92'] = $row['HC03_VC92']; //GRADUATE DEGREE
			$tmp['VC95'] = $row['HC03_VC95']; //HS+
			$tmp['VC96'] = $row['HC03_VC96']; //BACHELOR'S+
		}
	}
	return $tmp;		
}

function get_census_veterans($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp02 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC100'] = $row['HC03_VC100']; //CIVILIAN
			$tmp['VC101'] = $row['HC03_VC101']; //VETERAN
		}
	}
	return $tmp;		
}

function get_census_born($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp02 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC131'] = $row['HC03_VC131']; //NATIVE
			$tmp['VC132'] = $row['HC03_VC132']; //BORN IN US
			$tmp['VC133'] = $row['HC03_VC133']; //BORN IN CA
			$tmp['VC134'] = $row['HC03_VC134']; //BORN IN OTH STATE
			$tmp['VC136'] = $row['HC03_VC136']; //FOREIGN BORN
				
		}
	}
	return $tmp;	
}

function get_census_lang($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp02 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC171'] = $row['HC03_VC171']; //ENGLISH ONLY
			$tmp['VC174'] = $row['HC03_VC174']; //SPANISH
			$tmp['VC176'] = $row['HC03_VC176']; //INDO-EUROPEAN
			$tmp['VC178'] = $row['HC03_VC178']; //ASIAN-PACIFIC
				
		}
	}
	return $tmp;		
}

function get_census_occupation($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp03 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC41'] = $row['HC03_VC41']; //MGMT/BIZ/SCIENCE/ARTS
			$tmp['VC42'] = $row['HC03_VC42']; //SERVICE
			$tmp['VC43'] = $row['HC03_VC43']; //SALES/OFFICE
			$tmp['VC44'] = $row['HC03_VC44']; //NAT RESOURCE/CONSTRUCTION/MAINT
			$tmp['VC45'] = $row['HC03_VC45']; //PRODUCTION/TRANSPORTATION
		}
	}
	return $tmp;	
}

function get_census_industry($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp03 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC50'] = $row['HC03_VC50']; //AGRICULTURE
			$tmp['VC51'] = $row['HC03_VC51']; //CONSTRUCTION
			$tmp['VC52'] = $row['HC03_VC52']; //MANUFACTURING
			$tmp['VC53'] = $row['HC03_VC53']; //WHOLESALE
			$tmp['VC54'] = $row['HC03_VC54']; //RETAIL
			$tmp['VC55'] = $row['HC03_VC55']; //TRANSPORTATION
			$tmp['VC56'] = $row['HC03_VC56']; //INFORMATION
			$tmp['VC57'] = $row['HC03_VC57']; //FINANCE/INSURANCE/REAL ESTATE
			$tmp['VC58'] = $row['HC03_VC58']; //PROFESSIONAL/SCIENTIFIC
			$tmp['VC59'] = $row['HC03_VC59']; //EDUCATION/HEALTH
			$tmp['VC60'] = $row['HC03_VC60']; //ARTS & ENTERTAINMENT
			$tmp['VC62'] = $row['HC03_VC62']; //PUBLIC ADMINISTRATION
			$tmp['VC61'] = $row['HC03_VC61']; //OTHER
		}
	}
	return $tmp;		
}

function get_census_class($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp03 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC67'] = $row['HC03_VC67']; //PRIVATE
			$tmp['VC68'] = $row['HC03_VC68']; //GOVERNMENT
			$tmp['VC69'] = $row['HC03_VC69']; //SELF-EMPLOYED
			$tmp['VC70'] = $row['HC03_VC70']; //UNPAID FAMILY WORKERS
		}
	}
	return $tmp;		
}

function get_census_income($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp03 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC75'] = $row['HC03_VC75']; // < $10K
			$tmp['VC76'] = $row['HC03_VC76']; //$10-15
			$tmp['VC77'] = $row['HC03_VC77']; //$15-25
			$tmp['VC78'] = $row['HC03_VC78']; //$25-35
			$tmp['VC79'] = $row['HC03_VC79']; //$35-50
			$tmp['VC80'] = $row['HC03_VC80']; //$50-75
			$tmp['VC81'] = $row['HC03_VC81']; //$75-100
			$tmp['VC82'] = $row['HC03_VC82']; //$100-150
			$tmp['VC83'] = $row['HC03_VC83']; //$150-200
			$tmp['VC84'] = $row['HC03_VC84']; //$200K+
			$tmp['VC85'] = $row['HC01_VC85']; //MEDIAN
			$tmp['VC86'] = $row['HC01_VC86']; //MEAN
			$tmp['VC90'] = $row['HC03_VC90']; //W / SS
			$tmp['VC95'] = $row['HC03_VC95']; //W / SSI
			$tmp['VC97'] = $row['HC03_VC97']; //W / PUBLIC ASSISTANCE
			$tmp['VC99'] = $row['HC03_VC99']; //W / SNAP
		}
	}
	return $tmp;			
}

function get_census_housing($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM 2013dp04 WHERE rdist_id = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['VC64'] = $row['HC03_VC67']; //OWNERS
			$tmp['VC65'] = $row['HC03_VC68']; //RENTERS
		}
	}
	return $tmp;	
}

function getofficeholder($fourcode){
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT INCUMBENT, PARTY FROM pd_apr16_reg WHERE DISTRICT = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$incumbent = $row['INCUMBENT'];
			$party = mb_substr($row['PARTY'], 1,1);
		}
	}

	if($party == "R") {
		$retval = "<span class='redme boldme'>$incumbent</span>";
	} elseif ($party == "D") {
		$retval = "<span class='blueme boldme'>$incumbent</span>";
	}
	
	return $retval;
}

function getpartisanadvantage($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM  sos_oct16 WHERE DIST = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0 ){
		while($row = $result->fetch_assoc()) {
			$total = $row['TOT'];
			$rep = $row['REP'];
			$dem = $row['DEM'];
			$npp = $row['NPP'];
		}
	}

	if($rep > $dem) {
		$printme = number_format(((($rep / $total) - ($dem / $total)) * 100), 2);
		if($printme < 10) {
			$printme = " " . $printme;
		}
		$retval = "<span class='redme boldme'>R +$printme</span>";
	} elseif ($dem > $rep) {
		$printme = number_format(((($dem / $total) - ($rep / $total)) * 100), 2);
		if($printme < 10) {
			$printme = " " . $printme;
		}		
		$retval = "<span class='blueme boldme'>D +$printme</span>";		
	}
	
	return $retval;	
}

?>
</body>

<?php include "php/scripts.php" ?>

<script type='text/javascript'>

<?php
	
	foreach($endjava as $value) {
		echo($value);
	}

?>

</script>

</html>

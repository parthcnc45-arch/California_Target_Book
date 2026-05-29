@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', 'June 7th, 2022 Primary Results - All | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        June 7th, 2022 Primary Results - All
    </h2>

<?php

global $last_votes, $last_updates;


Util::require_ctb_api();
$endjava = Array();

$js = "jQuery.tablesorter.addParser({
    id: \"monetaryValue\",
    is: function (s) {
        return false;
    }, format: function (s) {
        var n = parseFloat( s.replace('$','').replace(/,/g,'') );
        return isNaN(n) ? s : n;
    }, type: \"numeric\"
});";
array_push($endjava, $js);

populate_last();

foreach($last_votes as $fourcode => $cands) {
	$end_arr_other[$fourcode]['total'] = $last_votes[$fourcode]['999']['votes'];
	$end_arr_other[$fourcode]['precincts_in'] = $last_votes[$fourcode]['888']['votes'];
	$end_arr_other[$fourcode]['precincts_tot'] = $last_votes[$fourcode]['888']['cand_nm'];
	unset($cands['999']);
	unset($cands['888']);
	uasort($cands, "votes_sort");
	$rank = 1;
	foreach($cands as $cand_id => $x) {
		$end_arr[$fourcode][$rank] = $x;
		$end_arr_other[$fourcode]['party_votes'][$x['party']] += $x['votes'];
		$rank++;
	}

}

$enddraw_nav = '
	<nav class="clearfix page-nav">
    	<ul class="clearfix">
      		<li class="active"><a href="#STW" role="tab" data-toggle="tab" >Statewide  </a></li>
      		<li><a href="#AD" role="tab" data-toggle="tab" >Assembly  </a> </li>
      		<li><a href="#SD" role="tab" data-toggle="tab" >State Senate  </a></li>
      		<li><a href="#CD" role="tab" data-toggle="tab" >Congressional  </a></li>
      		<li><a href="#BOE" role="tab" data-toggle="tab" >Board of Equalization</a></li>
    	</ul>
    </nav>
    <div class="content-wrap pt-xl">
   ';
ksort($end_arr);
foreach($end_arr as $fourcode => $ranks) {
	if(mb_substr($fourcode, 0, 1) == ".") {
		$type = "STW";
	} elseif(mb_substr($fourcode, 0, 3) == "BOE") {
		$type = "BOE";
	} else {
		$type = mb_substr($fourcode, 0, 2);
	}
	$total = $end_arr_other[$fourcode]['total'];
	$r_vot = $end_arr_other[$fourcode]['party_votes']['R'];
	$d_vot = $end_arr_other[$fourcode]['party_votes']['D'];
	$d_pct = number_format((($end_arr_other[$fourcode]['party_votes']['D'] / $total) * 100), 2);
	$r_pct = number_format((($end_arr_other[$fourcode]['party_votes']['R'] / $total) * 100), 2);
	$enddraw[$type] .= "<div class='race_div'>
	<p align='left'><span class='boldme'>$fourcode</span> - " . number_format($end_arr_other[$fourcode]['total']) . " votes in. <span class='small blueme boldme'>D: " . number_format($d_vot) . " ($d_pct%)</span>  
	<span class='small redme boldme'>R: " . number_format($r_vot) . " ($r_pct%)</span></p>
	<table>
		<tbody>";
	foreach($ranks as $ranks => $x) {
		$enddraw[$type] .= "<tr>
						<td>" . $x['cand_nm'] . "</td>
						<td>" . $x['party'] . "</td>
						<td align='right'>" . number_format($x['votes']) . "</td>
						<td align='right'>" . number_format((($x['votes'] / $total) * 100), 2) . "%</td>
					</tr>";
	}
	$enddraw[$type] .= "</tbody></table></div>";
}
echo($enddraw_nav);

$types = Array("STW", "AD", "SD", "CD", "BOE");
$is_active = TRUE;
foreach($types as $type) {
	$active = '';
	if($is_active == TRUE) {
		$active = "active";
		$is_active = FALSE;
	} 
	echo("<section id='$type' class='$active'>" .
			$enddraw[$type] . 
		  "</section>");
}
echo("</div>");

function populate_last() {
	global $master_conn, $last_votes, $last_updates;
	$conn = Util::get_ctb_conn();
	$conn->set_charset("utf8");
	$sql = "SELECT * FROM (
					SELECT fourcode, update_number FROM ctb_p22_results_state
    				GROUP BY fourcode, update_number
    				ORDER by fourcode, update_number DESC
			) A
			GROUP BY fourcode";
	$result = $conn->query($sql);
	$query = '';
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$query .= " (fourcode = \"" . $row['fourcode'] . "\" && update_number =" . $row['update_number'] . ") ||";
		}
	}
	$query = substr($query, 0, -2);
	$sql = "SELECT * FROM ctb_p22_results_state 
			WHERE ( $query )";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$cand_id = $row['cand_id'];
			$last_votes[$fourcode][$cand_id] = $row;
			$last_updates[$fourcode] = $row['update_number'];
		}
	}
}

function votes_sort($a, $b) {

  $retval = $b['votes'] <=> $a['votes'];
  return $retval;
}

?>  


@endsection


@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type='text/javascript'>

<?php
    
    foreach($endjava as $value) {
        echo($value);
    }

?>

</script>


@endsection



@section('styles')

<style>

	.redme {
		color: red !important;
	}

	.blueme {
		color: blue !important;
	}

	.boldme {
		font-weight: bold !important;
	}



.logo {

		position: relative;
		border: none;
		height: 80px;
		width: 80px;
		top: -90px;
		right: 80px;
		z-index: -1;
		float: right;
		margin-right: -80px;

	}

.cand_a {
	float: left;
	margin: 10px;
	border-radius: 10px;
	width: 250px;
	height: 400px;
}

.cand_b {
	float: right;
	margin: 10px;
	border-radius: 10px;
	width: 250px;
	height: 400px;
}

.newseg {
	float: none;
	clear: both;
	display: inline-block;
	min-width: 1200px;
	max-width: 1200px;
	margin-top: 20px;
	margin-left: 10px;
}

.newseg h1 {
	font-size: 4em;
}



.toptwo {
	width: 100%;
	clear: both;
}

.spacer {
	width: 100vw;
	clear: both;
}

.vote_pct {
	font-size: 2em;
	font-weight: bold;
}

.cand_name {
	font-size: 2em;
	font-weight: bold;
}

.vote_count {
	font-size: 1.5em;
	font-weight: bold;
}

.cand_img {
	height: 50px;
	border: none;
	border-radius: 3px;
	margin-left: auto;
	margin-right: auto;
	text-align: center;
	padding: 3px;
}

.registration {
	font-size: 1.3em;
}

.askew {
	

	text-align: center;
	margin-left: auto;
	margin-right: auto;
	padding-left: 75px;
	
}

.askew_container {
	width: 100%;
	text-align: center;
	margin-left: auto;
	margin-right: auto;
	

}

.county_results {
	font-size: 1.4em;
	font-weight: bold;
	border: 2px solid black;
	margin-top: 10px;
	margin-bottom: 10px;
}

.rightme {
	text-align: right !important;
}

th, td {
	padding-left: 4px;
	padding-right: 4px;
}

table {
	margin-top: 15px;
	border: none;
	line-height: 1.2em;
}

.race_div {
	border: none;
	display: inline-block;
	margin: 10px;
	padding: 5px;
	font-family: "PT Sans Narrow";
}

.D {
	
	color: blue;
}

.R {
	
	color: red;

}

.NPP {
	color: gray;
}

.NOP {
	
	

}

.Grn {
	
	color: green;

}

.sep {
	border-right: 2px solid black;
}

</style>


@endsection
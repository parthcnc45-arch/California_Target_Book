<!DOCTYPE html>
<html lang="en">

<head>

<?php 

include "php/head.php"; 

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!--
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link href="https://catargetbook.com/css/app.css" rel="stylesheet">-->

<link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css'>
<link href='http://198.74.49.22/css/ctb.css' rel='stylesheet'>

<style>

	@import url('https://fonts.googleapis.com/css?family=Bellefair');
	@import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow');
	@import url('https://fonts.googleapis.com/css?family=Lato');

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

.border-left {
	border-left: 2px solid black;
}

.border-right {
	border-right: 2px solid black !important;
}

.itcme {
	font-style: italic;
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
	border: 2px solid black;
	line-height: 1em;
}

.race_div {
	border: 3px solid black;
	display: inline-block;
	margin: 10px;
	padding: 5px;
}

.D, .Dem {
	
	color: blue;
}

.R, .Rep {
	
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

.small {
	font-size: 0.6em;
}





</style>

</head>



<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">


<?php

require_once('php/ctb_api.php');
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
populate_topline();
populate_reg();
populate_status();
populate_counties();


$gov_votes = $last_votes['.GOV'][999]['votes'];

$init_threshold = ceil($gov_votes * .05);
$con_threshold = ceil($gov_votes * .08);

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

		$first_two = mb_substr($fourcode, 0, 2);
		$party = mb_substr($x['party'], 0, 1);

		if($first_two == "AD" || $first_two == "CD" || $first_two == "SD" || $first_two == "BO") {
			if($first_two == "BO") {
				$first_two = "BOE";
			}
			if($rank == 1) {
				$ahead[$first_two][$party]++;
			}
		}

		$rank++;
	}

}

$types = Array(
	"CD"	=> 52,
	"AD"	=> 80,
	"SD"	=> 40,
	//"BOE"	=> 4,
	);

$stw = Array(
	"POTUS", ".USS", ".USP"
	);

$props = Array(
	"02"	=> "$10B School Facilities Bond",
	"03"	=> "Repeal Same-Sex Marriage Ban",
	"04"	=> "$10B Climate Bond",
	"05"	=> "Lower Vote Threshold to Approve Certain Bonds",
	"06"	=> "Ban Mandatory Prison Labor",
	"32"	=> "$18 / Hr Minimum Wage",
	"33"	=> "Expand Rent Control",
	"34"	=> "Restrict Spending by Certain Health Care Providers",
	"35"	=> "MCO Tax",
	"36"	=> "Increase Penalties For Theft/Fentanyl Crimes",
	);

$old_balance['AD']['D'] = 62;
$old_balance['AD']['R'] = 17;
$old_balance['SD']['D'] = 31;
$old_balance['SD']['R'] = 9;
$old_balance['CD']['R'] = 12;
$old_balance['CD']['D'] = 40;
//$old_balance['BOE']['D'] = 3;
//$old_balance['BOE']['R'] = 1;

$t_head = "<thead class='text-white bg-dark'>
					<tr>
						<th>OFFICE</th>
						<th>FIRST PLACE</th>
						<th>VOTES</th>
						<th>%</th>
						<th>AHEAD</th>
						<th>SECOND PLACE</th>
						<th>VOTES</th>
						<th>%</th>
						<th>DEM %</th>
						<th>REP %</th>
						<th>TOT</th>
						<th>T/O</th>
					</tr>
				</thead>
				<tbody>";

$thisid = "TABLE_STW";
$enddraw = "<h3 align='center'>Statewide Races</h3>";
$enddraw .= "<table id='$thisid' class='tablesorter table-striped w-auto'>
				$t_head";


$js = "$(document).ready(function() {
  $('#" . $thisid . "').tablesorter(
  	{ headers : {
  		2: { sorter: \"monetaryValue\" },
  		3: { sorter: \"monetaryValue\" },
  		4: { sorter: \"monetaryValue\" },

  		6: { sorter: \"monetaryValue\" },
  		7: { sorter: \"monetaryValue\" },
  		8: { sorter: \"monetaryValue\" },
  		9: { sorter: \"monetaryValue\" },
  		10: { sorter: \"monetaryValue\" },
  		11: { sorter: \"monetaryValue\" },
  		12: { sorter: \"monetaryValue\" },


  		},
			sortList: [0,0]});
	});
  		";


array_push($endjava, $js);

$stw_reg = $reg_arr['.STW']['TOT'];		

foreach($stw as $fourcode) {
	$x = $end_arr[$fourcode];
	$url = "<a href='https://californiatargetbook.com/ctb-legacy/g24_draw.php?id=$fourcode' target='_blank'>$fourcode</a>";

	$this_d_pct = 0;
	$this_r_pct = 0;

	if($x[1]['party'] == "Dem") {
		$this_d_pct += number_format((($x[1]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
	}

	if($x[2]['party'] == "Dem") {
		$this_d_pct += number_format((($x[2]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
	}

	if($x[1]['party'] == "Rep") {
		$this_r_pct += number_format((($x[1]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
	}

	if($x[2]['party'] == "Rep") {
		$this_r_pct += number_format((($x[2]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
	}

	$this_tot = $x[1]['votes'] + $x[2]['votes'];
	$this_to = number_format((($this_tot / $stw_reg) * 100), 2);


	$enddraw .= "<tr>
						<td class='border-right'>$url</td>
						<td class='" . $x[1]['party'] . "'>" . $x[1]['cand_nm'] . "</td>
						<td align='right'>" . number_format($x[1]['votes']) . "</td>
						<td align='right'>" . number_format((($x[1]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2) . "%</td>
						<td align='right' class='border-right'>" . number_format($x[1]['votes'] - $x[2]['votes']) . "</td>

						<td class='" . $x[2]['party'] . "'>" . $x[2]['cand_nm'] . "</td>
						<td align='right'>" . number_format($x[2]['votes']) . "</td>
						<td align='right' class='border-right'>" . number_format((($x[2]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2) . "%</td>

						<td align='right' class='blueme'>$this_d_pct%</td>
						<td align='right' class='redme border-right'>$this_r_pct%</td>
						<td align='right'>" . number_format($this_tot) . "</td>
						<td align='right' class='itcme'>$this_to%</td>

				</tr>";
}
$enddraw .= "</tbody></table>";

$t_head = "<thead class='text-white bg-dark'>
					<tr>
						<th>PROP #</th>
						<th>DESCRIPTION</th>
						<th>YES</th>
						<th>%</th>
						<th>NO</th>
						<th>%</th>
						<th>STATUS</th>
						<th>YES MARGIN</th>
						<th>%</th>
						<th>VOTES</th>
						<th>T/O</th>
					</tr>
				</thead>
				<tbody>";

$thisid = "TABLE_PROP";
$enddraw .= "<h3 align='center'>Propositions</h3>";
$enddraw .= "<table id='$thisid' class='tablesorter table-striped w-auto'>
				$t_head";


$js = "$(document).ready(function() {
  $('#" . $thisid . "').tablesorter(
  	{ headers : {
  		2: { sorter: \"monetaryValue\" },
  		3: { sorter: \"monetaryValue\" },
  		4: { sorter: \"monetaryValue\" },

  		6: { sorter: \"monetaryValue\" },
  		7: { sorter: \"monetaryValue\" },
  		8: { sorter: \"monetaryValue\" },
  		9: { sorter: \"monetaryValue\" },
  		10: { sorter: \"monetaryValue\" },
  		11: { sorter: \"monetaryValue\" },

  		},
			sortList: [0,0]});
	});
  		";


array_push($endjava, $js);


foreach($props as $prop => $dscr) {
	$fourcode = "PR_" . $prop;
	$x = $end_arr[$fourcode];

	if($x[1]['cand_id'] == 111) {
		$status = "<span class='greenme boldme'>PASSING</span>";
		$yes_votes = $x[1]['votes'];
		$no_votes = $x[2]['votes'];
	} else {
		$status = "<span class='redme boldme'>FAILING</span>";
		$yes_votes = $x[2]['votes'];
		$no_votes = $x[1]['votes'];
	}

	$tot_votes = $yes_votes + $no_votes;
	$yes_margin = $yes_votes - $no_votes;
	$this_to = number_format((($tot_votes / $stw_reg) * 100), 2);
	

	$yes_pct = number_format((($yes_votes / $tot_votes) * 100), 2);
	$no_pct = number_format((($no_votes / $tot_votes) * 100), 2);

	$yes_margin_pct = number_format($yes_pct - $no_pct, 2);

	$enddraw .= "<tr>
					<td>Prop $prop</td>
					<td class='border-right'>$dscr</td>
					<td align='right'>" . number_format($yes_votes) . "</td>
					<td align='right' class='border-right'>$yes_pct%</td>
					<td align='right'>" . number_format($no_votes) . "</td>
					<td align='right' class='border-right'>$no_pct%</td>
					<td>$status</td>
					<td align='right'>" . number_format($yes_margin) . "</td>
					<td align='right' class='border-right'>$yes_margin_pct%</td>
					<td align='right'>" . number_format($tot_votes) . "</td>
					<td align='right' class='itcme'>$this_to%</td>
				</tr>";

					
}
$enddraw .= "</tbody></table>";

$t_head = "<thead class='text-white bg-dark'>
					<tr>
						<th>OFFICE</th>
						<th>GOV '18</th>
						<th>PRS '20</th>
						<th>GOV '22</th>
						<th>REG '22</th>
						<th>REG '24</th>
						<th>FIRST PLACE</th>
						<th>VOTES</th>
						<th>%</th>
						<th>AHEAD</th>
						<th>%</th>
						<th>SECOND PLACE</th>
						<th>VOTES</th>
						<th>%</th>
						<th>DEM %</th>
						<th>REP %</th>
						<th>REG</th>
						<th>VOT</th>
						<th>T/O %</th>
					</tr>
				</thead>
				<tbody>";

$verbose_types = Array(
	"CD"	=> "Congressional",
	"AD"	=> "State Assembly",
	"SD"	=> "State Senate",
	//"BOE"	=> "Board of Equalization",
	);

foreach($types as $type => $cutoff) {
	if($type == "SD") {
		$i = 1;
	} else {
		$i = 1;
	}

	$this_type_total = $type_totals[$type]['ALL'];
	$this_type_r     = $type_totals[$type]['Rep'];
	$this_type_d	 = $type_totals[$type]['Dem'];
	$long_type = $verbose_types[$type];


	$header_span .= "<p align='center'>" . number_format($this_type_total) . " Votes Cast in $type Races<br>
				   <span class='blueme boldme'>DEM: " . number_format($this_type_d) . " (" . number_format((($this_type_d / $this_type_total) * 100), 2) . "%)</span>  |  
				   <span class='redme boldme'>REP: " . number_format($this_type_r) . " (" . number_format((($this_type_r / $this_type_total) * 100), 2) . "%)</span>
				   </p>";

	if($type == "SD") {
		$ahead['SD']['D'] = $ahead['SD']['D'] + 14;
		$ahead['SD']['R'] = $ahead['SD']['R'] + 6;
	}

	$header_body .= "<tr>
						<td class='border-right'>$long_type</td>
						<td class='blueme boldme' align='right'>" . number_format($this_type_d) . "</td>
						<td class='blueme boldme border-right' align='right'>" . number_format((($this_type_d / $this_type_total) * 100), 2) . "%</td>
						<td class='redme boldme' align='right'>" . number_format($this_type_r) . "</td>
						<td class='redme boldme border-right' align='right'>" . number_format((($this_type_r / $this_type_total) * 100), 2) . "%</td>
						<td class='blueme boldme' align='right'>" . $old_balance[$type]['D'] . "</td>
						<td class='blueme boldme border-right' align='right'>" . $ahead[$type]['D'] . "</td>
						<td class='redme boldme' align='right'>" . $old_balance[$type]['R'] . "</td>
						<td class='redme boldme' align='right'>" . $ahead[$type]['R'] . "</td>
					</tr>";				   
	$enddraw .= "<h3 align='center'>$long_type</h3>" . $type_span;
	$thisid = "TABLE_" . $type;
	$enddraw .= "<table id='$thisid' class='tablesorter table-striped w-auto'>
					$t_head";

	$js = "$(document).ready(function() {
	  $('#" . $thisid . "').tablesorter(
	  	{ headers : {
	  		4: { sorter: \"monetaryValue\" },
	  		5: { sorter: \"monetaryValue\" },
	  		6: { sorter: \"monetaryValue\" },

	  		7: { sorter: \"monetaryValue\" },
	  		9: { sorter: \"monetaryValue\" },
	  		10: { sorter: \"monetaryValue\" },
	  		11: { sorter: \"monetaryValue\" },
	  		12: { sorter: \"monetaryValue\" },
	  		13: { sorter: \"monetaryValue\" },
	  		14: { sorter: \"monetaryValue\" },
	  		15: { sorter: \"monetaryValue\" },

	  		},
				sortList: [0,0]});
		});
	  		";

	
	array_push($endjava, $js);

	while($i <= $cutoff) {
		if($type != "BOE") {
			$fourcode = $type . checkaddzero($i);	
		} else {
			$fourcode = $type . $i;
		}
		$url = "<a href='https://californiatargetbook.com/ctb-legacy/p22_draw.php?id=$fourcode' target='_blank'>$fourcode</a>";
		$x = $end_arr[$fourcode];

		$this_d_pct = 0;
		$this_r_pct = 0;

		$this_reg = $reg_arr[$fourcode]['TOT'];
		$this_tot = $end_arr_other[$fourcode]['total'];

		$reg_last = $reg_arr_22[$fourcode];
		$reg_now  = $reg_arr[$fourcode];

		$reg_adv_now = get_advantage_raw($reg_now['REP'], $reg_now['DEM'], $reg_now['TOT'], "R", "D");
		$reg_adv_last = get_advantage_raw($reg_last['REP'], $reg_last['DEM'], $reg_last['TOT'], "R", "D");

		$ran_html = $reg_adv_now['html'];
		$ran_dsv  = $reg_adv_now['dsv'];

		$ral_html = $reg_adv_last['html'];
		$ral_dsv  = $reg_adv_last['dsv'];

		$this_turnout = number_format((($this_tot / $this_reg) * 100), 2);

		if($x[1]['party'] == "Dem") {
			$this_d_pct += number_format((($x[1]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
		}

		if($x[2]['party'] == "Dem") {
			$this_d_pct += number_format((($x[2]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
		}

		if($x[1]['party'] == "Rep") {
			$this_r_pct += number_format((($x[1]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
		}

		if($x[2]['party'] == "Rep") {
			$this_r_pct += number_format((($x[2]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
		}

		$pct_diff = number_format((($x[1]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2) - number_format((($x[2]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2);
		$pcf_diff = number_format($pct_diff, 2);

		$enddraw .= "<tr>
						<td class='border-right'>$url</td>
						<td data-sort-value='" . $topline[$fourcode]['gov_18_dsv'] . "'>" . $topline[$fourcode]['gov_18'] . "</td>
						<td data-sort-value='" . $topline[$fourcode]['prs_20_dsv'] . "'>" . $topline[$fourcode]['prs_20'] . "</td>
						<td class='border-right' data-sort-value='" . $topline[$fourcode]['gov_22_dsv'] . "'>" . $topline[$fourcode]['gov_22'] . "</td>


						<td data-sort-value='$ral_dsv'>$ral_html</td>
						<td data-sort-value='$ran_dsv' class='border-right'>$ran_html</td>

						<td class='" . $x[1]['party'] . "'>" . $x[1]['cand_nm'] . "</td>
						<td align='right'>" . number_format($x[1]['votes']) . "</td>
						<td align='right'>" . number_format((($x[1]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2) . "%</td>
						<td align='right'>" . number_format($x[1]['votes'] - $x[2]['votes']) . "</td>
						<td align='right' class='border-right'>" . number_format($pct_diff, 2) . "%</td>

						<td class='" . $x[2]['party'] . "'>" . $x[2]['cand_nm'] . "</td>
						<td align='right'>" . number_format($x[2]['votes']) . "</td>
						<td align='right' class='border-right'>" . number_format((($x[2]['votes'] / $end_arr_other[$fourcode]['total']) * 100), 2) . "%</td>
						<td align='right' class='blueme'>$this_d_pct%</td>
						<td align='right' class='redme border-right'>$this_r_pct%</td>
						<td align='right'>" . number_format($this_reg) . "</td>
						<td align='right'>" . number_format($this_tot) . "</td>
						<td class='itcme'>$this_turnout%</td>

			
					</tr>";

		if($type == "SD") {
			$i++;
			$i++;
		} else {
			$i++;
		}
	}
	$enddraw .= "</tbody></table>";					
}

$t_head = "<thead class='text-white bg-dark'>
					<tr>
						<th>COUNTY</th>
						<th>REGISTERED</th>
						<th>DEM %</th>
						<th>REP %</th>
						<th>NPP %</th>
						<th>ADV</th>
						<th>VOTED</th>
						<th>TURNOUT</th>
						<th>LAST UPDATED</th>
					</tr>
				</thead>
				<tbody>";


	$enddraw .= "<h3 align='center'>County Reporting</h3>";
	$thisid = "TABLE_COUNTY";
	$enddraw .= "<table id='$thisid' class='tablesorter table-striped w-auto'>
					$t_head";

	$js = "$(document).ready(function() {
	  $('#" . $thisid . "').tablesorter(
	  	{ headers : {
	  		1: { sorter: \"monetaryValue\" },
	  		2: { sorter: \"monetaryValue\" },
	  		3: { sorter: \"monetaryValue\" },
	  		4: { sorter: \"monetaryValue\" },
	  		5: { sorter: \"monetaryValue\" },
	  		6: { sorter: \"monetaryValue\" },
	  		7: { sorter: \"monetaryValue\" },

	  		},
				sortList: [0,0]});
		});
	  		";

	
	array_push($endjava, $js);


ksort($county_status);
$i = 1;
foreach($county_status as $county => $x) {
	$fourcode = "CO" . checkaddzero($i);
	$reg = $reg_arr[$fourcode]['TOT'];
	$rep = $reg_arr[$fourcode]['REP'];
	$dem = $reg_arr[$fourcode]['DEM'];
	$npp = $reg_arr[$fourcode]['NPP'];
	$votes = $x['votes'];
	$last_update = $x['last_rpt'];
	$county_nm = $county;



	$rep_pct = number_format((($rep / $reg) * 100), 2);
	$dem_pct = number_format((($dem / $reg) * 100), 2);
	$npp_pct = number_format((($npp / $reg) * 100), 2);

	$to = number_format((($votes / $reg) * 100), 2);

	$adv = get_advantage($rep_pct, $dem_pct, "R", "D");
	$adv_html = $adv['html'];
	$adv_dsv = $adv['dsv'];

	$enddraw .= "<tr>
					<td class='border-right'>$county_nm</td>
					<td align='right' class='border-right'>" . number_format($reg) . "</td>
					<td align='right' class='blueme'>$dem_pct%</td>
					<td align='right' class='redme'>$rep_pct%</td>
					<td align='right'>$npp_pct%</td>
					<td data-sort-value='$adv_dsv' align='right' class='border-right'>$adv_html</td>
					<td align='right' class='border-right'>" . number_format($votes) . "</td>
					<td align='right' class='itcme' class='border-right'>$to%</td>
					<td>" . str_replace("<br>", " ", $last_update) . "</td>
				</tr>";

	$i++;
}
$enddraw .= "</tbody></table>";

$header_table = "<table class='table-striped' style='margin-bottom: 50px;'>
					<thead class='text-white bg-dark'>
						<tr>
							<th>TYPE</th>
							<th>DEM TOTAL</th>
							<th>DEM PCT</th>
							<th>REP TOTAL</th>
							<th>REP PCT</th>
							<th># D OLD</th>
							<th># D NEW</th>
							<th># R OLD</th>
							<th># R NEW</th>
						</tr>
					</thead>
					<tbody>
					$header_body
					</tbody>
				</table>";



$stw_reg = $reg_arr['.STW']['TOT'];
$stw_vot = $last_status['votes'];
$stw_updated = $last_status['last_rpt'];

$status_line = "<p align='center'>" . number_format($stw_vot) . " Ballots Counted, " . number_format($stw_reg) . " Registered Voters - " . number_format((($stw_vot / $stw_reg) * 100), 2) . "% Statewide Turnout - Last Updated $stw_updated</p>"; 

echo("<h1>California Results - November 5th, 2024 General Election</h1>");
echo($status_line);
echo($header_table);
/*
echo("<p align='center' class='itcme'>INITIATIVE SIGNATURE THRESHOLD: <span class='greenme boldme'>" . number_format($init_threshold) . "</span>     |    CONSTITUTIONAL AMENDMENT SIGNATURE THRESHOLD: <span class='greenme boldme'>" . number_format($con_threshold) . "</span></p>" );
*/

echo($enddraw);

function populate_status() {
	global $master_conn, $last_status;
	$conn = $master_conn;
	$sql = "SELECT county, votes, last_rpt 
			FROM ctb_g24_county_status
			WHERE county = 'Statewide'
			ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$last_status = $row;
		}
	}

}

function populate_reg() {
	global $master_conn, $reg_arr, $reg_arr_22;
	$conn = $master_conn;
	$sql = "SELECT * FROM ctb2016_sos_all 
			WHERE RPT_DATE = '2022-10-24'
			ORDER BY DIST";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['DIST'];
			$reg_arr_22[$fourcode] = $row;
		}
	}

	$sql = "SELECT * FROM ctb2016_sos_all 
			WHERE RPT_DATE = '2024-10-21'
			ORDER BY DIST";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['DIST'];
			$reg_arr[$fourcode] = $row;
		}
	}

}

function populate_last() {
	global $master_conn, $last_votes, $last_updates, $type_totals, $ahead_totals;
	$conn = $master_conn;
	$conn->set_charset("utf8");
	$sql = "SELECT * FROM (
					SELECT fourcode, update_number FROM ctb_g24_results_state
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
	$sql = "SELECT * FROM ctb_g24_results_state 
			WHERE ( $query )";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$cand_id = $row['cand_id'];
			$party = $row['party'];
			$last_votes[$fourcode][$cand_id] = $row;
			$last_updates[$fourcode] = $row['update_number'];
			if(mb_substr($fourcode, 0, 1) == ".") {
				//STATEWIDE, DO NOTHING
				$type = $fourcode;
			} elseif(mb_substr($fourcode, 0, 3) == "BOE") {
				$type = "BOE";
			} else {
				$type = mb_substr($fourcode, 0, 2);
			}
			
			if($cand_id != "888" && $cand_id != "999") {
				$type_totals[$type]['ALL'] += $row['votes'];
				$type_totals[$type][$party] += $row['votes'];
			}

		}
	}
}

function votes_sort($a, $b) {

  $retval = $b['votes'] <=> $a['votes'];
  return $retval;
}


function populate_topline() {
	global $topline;
	$raw = file_get_contents('new_dist_topline.json');
	$arr = json_decode($raw, TRUE);
	foreach($arr as $x) {
		$fourcode = $x['DIST'];
		$gov_18 = get_advantage_topline($x['COX_PCT'], $x['NEWSOM_PCT'], "COX", "NEWSOM");
		$prs_20 = get_advantage_topline($x['TRUMP_PCT'], $x['BIDEN_PCT'], "TRUMP", "BIDEN");
		$gov_22 = get_advantage_topline($x['DAHLE_22_PCT'], $x['NEWSOM_22_PCT'], "DAHLE", "NEWSOM");

		$gov_18_html = $gov_18['html'];
		$gov_18_dsv = $gov_18['dsv'];

		$prs_20_html = $prs_20['html'];
		$prs_20_dsv = $prs_20['dsv'];

		$gov_22_html = $gov_22['html'];
		$gov_22_dsv = $gov_22['dsv'];		

		$gov_18_val = $x['COX_PCT'] - $x['NEWSOM_PCT'];
		$prs_20_val = $x['TRUMP_PCT'] - $x['BIDEN_PCT'];
		$gov_22_val = $x['DAHLE_PCT'] - $x['NEWSOM_22_PCT'];

		$topline[$fourcode]['prs_20'] = $prs_20_html;
		$topline[$fourcode]['gov_18'] = $gov_18_html;
		$topline[$fourcode]['gov_22'] = $gov_22_html;
		$topline[$fourcode]['prs_20_value'] = $prs_20_val;
		$topline[$fourcode]['gov_18_value'] = $gov_18_val;
		$topline[$fourcode]['gov_22_value'] = $gov_22_val;
		$topline[$fourcode]['prs_20_dsv'] = $prs_20_dsv;
		$topline[$fourcode]['gov_18_dsv'] = $gov_18_dsv;
		$topline[$fourcode]['gov_22_dsv'] = $gov_22_dsv;
	}
	//echo("<br>TOPLINE DUMP<br>");
	//var_dump($topline);
}

function populate_counties() {
	global $master_conn, $county_status;
	$conn = $master_conn;
	$sql = "SELECT county, votes, last_rpt, updated 
			FROM ctb_g24_county_status
			WHERE county != 'Statewide'
			ORDER BY county, updated DESC";
	$result = $conn->query($sql);
	//echo("<br>$sql<br>");
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$county = $row['county'];
			if(!isset($county_status[$county])) {
				$county_status[$county] = $row;
			} else {
				continue;
			}
		}
	}
	//var_dump($county_status);
}

function get_advantage($r_pct, $d_pct, $r_name, $d_name) {
	$r_pct = str_replace("%", "", $r_pct);
	$d_pct = str_replace("%", "", $d_pct);

	$retval['dsv'] = $d_pct - $r_pct;

	//echo("<br>$r_name: $r_pct $d_name $d_pct");
	if($r_pct > $d_pct) {
		$retval['html'] = "<span class='redme boldme small'>$r_name +" . number_format($r_pct - $d_pct, 1) . "%</span>";
	} elseif($d_pct > $r_pct) {
		$retval['html'] = "<span class='blueme boldme small'>$d_name +" . number_format($d_pct - $r_pct, 1) . "%</span>";
	} else {
		$retval['html'] = "EVEN";
	}
	return $retval;
}

function get_advantage_raw($r, $d, $tot, $r_name, $d_name) {
	$r_pct = number_format((($r / $tot) * 100), 2);
	$d_pct = number_format((($d / $tot) * 100), 2);


	$retval['dsv'] = $d_pct - $r_pct;

	//echo("<br>$r_name: $r_pct $d_name $d_pct");
	if($r_pct > $d_pct) {
		$retval['html'] = "<span class='redme boldme small'>$r_name +" . number_format($r_pct - $d_pct, 1) . "%</span>";
	} elseif($d_pct > $r_pct) {
		$retval['html'] = "<span class='blueme boldme small'>$d_name +" . number_format($d_pct - $r_pct, 1) . "%</span>";
	} else {
		$retval['html'] = "EVEN";
	}
	return $retval;
}

function get_advantage_topline($r_pct, $d_pct, $r_name, $d_name) {
	$r_pct = str_replace("%", "", $r_pct);
	$d_pct = str_replace("%", "", $d_pct);
	$retval['dsv'] = $d_pct - $r_pct;

	//echo("<br>$r_name: $r_pct $d_name $d_pct");
	if($r_pct > $d_pct) {
		$retval['html'] = "<span class='redme boldme small'>$r_name +" . number_format($r_pct - $d_pct, 1) . "%</span>";
	} elseif($d_pct > $r_pct) {
		$retval['html'] = "<span class='blueme boldme small'>$d_name +" . number_format($d_pct - $r_pct, 1) . "%</span>";
	} else {
		$retval['html'] = "EVEN";
	}
	return $retval;
}


?>

</body>

<?php //include "php/scripts.php" ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="js/jquery.quicksearch.js"></script>
<script src="js/jquery-listnav.min.js"></script>
<script>
!function($){$.extend({tablesorter:new function(){var sortWrapper,parsers=[],widgets=[];function benchmark(t,e){log(t+","+(new Date().getTime()-e.getTime())+"ms")}function log(t){"undefined"!=typeof console&&void 0!==console.debug?console.log(t):alert(t)}function buildParserCache(t,e){if(t.config.debug)var r="";if(0!=t.tBodies.length){var n=t.tBodies[0].rows;if(n[0])for(var o=[],i=n[0].cells.length,a=0;a<i;a++){var s=!1;$.metadata&&$(e[a]).metadata()&&$(e[a]).metadata().sorter?s=getParserById($(e[a]).metadata().sorter):t.config.headers[a]&&t.config.headers[a].sorter&&(s=getParserById(t.config.headers[a].sorter)),s||(s=detectParserForColumn(t,n,-1,a)),t.config.debug&&(r+="column:"+a+" parser:"+s.id+"\n"),o.push(s)}return t.config.debug&&log(r),o}}function detectParserForColumn(t,e,r,n){for(var o=parsers.length,i=!1,a=!1,s=!0;""==a&&s;)e[++r]?(i=getNodeFromRowAndCellIndex(e,r,n),a=trimAndGetNodeText(t.config,i),t.config.debug&&log("Checking if value was empty on row:"+r)):s=!1;for(var d=1;d<o;d++)if(parsers[d].is(a,t,i))return parsers[d];return parsers[0]}function getNodeFromRowAndCellIndex(t,e,r){return t[e].cells[r]}function trimAndGetNodeText(t,e){return $.trim(getElementText(t,e))}function getParserById(t){for(var e=parsers.length,r=0;r<e;r++)if(parsers[r].id.toLowerCase()==t.toLowerCase())return parsers[r];return!1}function buildCache(t){if(t.config.debug)var e=new Date;for(var r=t.tBodies[0]&&t.tBodies[0].rows.length||0,n=t.tBodies[0].rows[0]&&t.tBodies[0].rows[0].cells.length||0,o=t.config.parsers,i={row:[],normalized:[]},a=0;a<r;++a){var s=$(t.tBodies[0].rows[a]),d=[];if(s.hasClass(t.config.cssChildRow)){i.row[i.row.length-1]=i.row[i.row.length-1].add(s);continue}i.row.push(s);for(var c=0;c<n;++c)d.push(o[c].format(getElementText(t.config,s[0].cells[c]),t,s[0].cells[c]));d.push(i.normalized.length),i.normalized.push(d),d=null}return t.config.debug&&benchmark("Building cache for "+r+" rows:",e),i}function getElementText(t,e){if(!e)return"";var r=$(e).attr("data-sort-value");if(void 0!==r)return r;var n="";return t.supportsTextContent||(t.supportsTextContent=e.textContent||!1),n="simple"==t.textExtraction?t.supportsTextContent?e.textContent:e.childNodes[0]&&e.childNodes[0].hasChildNodes()?e.childNodes[0].innerHTML:e.innerHTML:"function"==typeof t.textExtraction?t.textExtraction(e):$(e).text()}function appendToTable(t,e){if(t.config.debug)var r=new Date;for(var n=e,o=n.row,i=n.normalized,a=i.length,s=i[0].length-1,d=$(t.tBodies[0]),c=[],u=0;u<a;u++){var f=i[u][s];if(c.push(o[f]),!t.config.appender)for(var l=o[f].length,h=0;h<l;h++)d[0].appendChild(o[f][h])}t.config.appender&&t.config.appender(t,c),c=null,t.config.debug&&benchmark("Rebuilt table:",r),applyWidget(t),setTimeout(function(){$(t).trigger("sortEnd")},0)}function buildHeaders(t){if(t.config.debug)var e=new Date;$.metadata;var r=computeTableHeaderCellIndexes(t),n=$(t.config.selectorHeaders,t).each(function(e){if(this.column=r[this.parentNode.rowIndex+"-"+this.cellIndex],this.order=formatSortingOrder(t.config.sortInitialOrder),this.count=this.order,(checkHeaderMetadata(this)||checkHeaderOptions(t,e))&&(this.sortDisabled=!0),checkHeaderOptionsSortingLocked(t,e)&&(this.order=this.lockedOrder=checkHeaderOptionsSortingLocked(t,e)),!this.sortDisabled){var n=$(this).addClass(t.config.cssHeader);t.config.onRenderHeader&&t.config.onRenderHeader.apply(n)}t.config.headerList[e]=this});return t.config.debug&&(benchmark("Built headers:",e),log(n)),n}function computeTableHeaderCellIndexes(t){for(var e=[],r={},n=t.getElementsByTagName("THEAD")[0].getElementsByTagName("TR"),o=0;o<n.length;o++)for(var i=n[o].cells,a=0;a<i.length;a++){var s,d=i[a],c=d.parentNode.rowIndex,u=c+"-"+d.cellIndex,f=d.rowSpan||1,l=d.colSpan||1;void 0===e[c]&&(e[c]=[]);for(var h=0;h<e[c].length+1;h++)if(void 0===e[c][h]){s=h;break}r[u]=s;for(var h=c;h<c+f;h++){void 0===e[h]&&(e[h]=[]);for(var g=e[h],$=s;$<s+l;$++)g[$]="x"}}return r}function checkCellColSpan(t,e,r){for(var n=[],o=t.tHead.rows,i=o[r].cells,a=0;a<i.length;a++){var s=i[a];s.colSpan>1?n=n.concat(checkCellColSpan(t,headerArr,r++)):(1==t.tHead.length||s.rowSpan>1||!o[r+1])&&n.push(s)}return n}function checkHeaderMetadata(t){return!!$.metadata&&!1===$(t).metadata().sorter}function checkHeaderOptions(t,e){return!!t.config.headers[e]&&!1===t.config.headers[e].sorter}function checkHeaderOptionsSortingLocked(t,e){return!!t.config.headers[e]&&!!t.config.headers[e].lockedOrder&&t.config.headers[e].lockedOrder}function applyWidget(t){for(var e=t.config.widgets,r=e.length,n=0;n<r;n++)getWidgetById(e[n]).format(t)}function getWidgetById(t){for(var e=widgets.length,r=0;r<e;r++)if(widgets[r].id.toLowerCase()==t.toLowerCase())return widgets[r]}function formatSortingOrder(t){return"Number"!=typeof t?"desc"==t.toLowerCase()?1:0:1==t?1:0}function isValueInArray(t,e){for(var r=e.length,n=0;n<r;n++)if(e[n][0]==t)return!0;return!1}function setHeadersCss(t,e,r,n){e.removeClass(n[0]).removeClass(n[1]);var o=[];e.each(function(t){this.sortDisabled||(o[this.column]=$(this))});for(var i=r.length,a=0;a<i;a++)o[r[a][0]].addClass(n[r[a][1]])}function fixColumnWidth(t,e){if(t.config.widthFixed){var r=$("<colgroup>");$("tr:first td",t.tBodies[0]).each(function(){r.append($("<col>").css("width",$(this).width()))}),$(t).prepend(r)}}function updateHeaderSortCount(t,e){for(var r=t.config,n=e.length,o=0;o<n;o++){var i=e[o],a=r.headerList[i[0]];a.count=i[1],a.count++}}function multisort(table,sortList,cache){if(table.config.debug)var sortTime=new Date;for(var dynamicExp="sortWrapper = function(a,b) {",l=sortList.length,i=0;i<l;i++){var c=sortList[i][0],order=sortList[i][1],s="text"==table.config.parsers[c].type?0==order?makeSortFunction("text","asc",c):makeSortFunction("text","desc",c):0==order?makeSortFunction("numeric","asc",c):makeSortFunction("numeric","desc",c),e="e"+i;dynamicExp+="var "+e+" = "+s,dynamicExp+="if("+e+") { return "+e+"; } ",dynamicExp+="else { "}var orgOrderCol=cache.normalized[0].length-1;dynamicExp+="return a["+orgOrderCol+"]-b["+orgOrderCol+"];";for(var i=0;i<l;i++)dynamicExp+="}; ";return dynamicExp+="return 0; ",dynamicExp+="}; ",table.config.debug&&benchmark("Evaling expression:"+dynamicExp,new Date),eval(dynamicExp),cache.normalized.sort(sortWrapper),table.config.debug&&benchmark("Sorting on "+sortList.toString()+" and dir "+order+" time:",sortTime),cache}function makeSortFunction(t,e,r){var n="a["+r+"]",o="b["+r+"]";return"text"==t&&"asc"==e?"("+n+" == "+o+" ? 0 : ("+n+" === null ? Number.POSITIVE_INFINITY : ("+o+" === null ? Number.NEGATIVE_INFINITY : ("+n+" < "+o+") ? -1 : 1 )));":"text"==t&&"desc"==e?"("+n+" == "+o+" ? 0 : ("+n+" === null ? Number.POSITIVE_INFINITY : ("+o+" === null ? Number.NEGATIVE_INFINITY : ("+o+" < "+n+") ? -1 : 1 )));":"numeric"==t&&"asc"==e?"("+n+" === null && "+o+" === null) ? 0 :("+n+" === null ? Number.POSITIVE_INFINITY : ("+o+" === null ? Number.NEGATIVE_INFINITY : "+n+" - "+o+"));":"numeric"==t&&"desc"==e?"("+n+" === null && "+o+" === null) ? 0 :("+n+" === null ? Number.POSITIVE_INFINITY : ("+o+" === null ? Number.NEGATIVE_INFINITY : "+o+" - "+n+"));":void 0}function makeSortText(t){return"((a["+t+"] < b["+t+"]) ? -1 : ((a["+t+"] > b["+t+"]) ? 1 : 0));"}function makeSortTextDesc(t){return"((b["+t+"] < a["+t+"]) ? -1 : ((b["+t+"] > a["+t+"]) ? 1 : 0));"}function makeSortNumeric(t){return"a["+t+"]-b["+t+"];"}function makeSortNumericDesc(t){return"b["+t+"]-a["+t+"];"}function sortText(t,e){return table.config.sortLocaleCompare?t.localeCompare(e):t<e?-1:t>e?1:0}function sortTextDesc(t,e){return table.config.sortLocaleCompare?e.localeCompare(t):e<t?-1:e>t?1:0}function sortNumeric(t,e){return t-e}function sortNumericDesc(t,e){return e-t}function getCachedSortType(t,e){return t[e].type}this.defaults={cssHeader:"header",cssAsc:"headerSortUp",cssDesc:"headerSortDown",cssChildRow:"expand-child",sortInitialOrder:"asc",sortMultiSortKey:"shiftKey",sortForce:null,sortAppend:null,sortLocaleCompare:!0,textExtraction:"simple",parsers:{},widgets:[],widgetZebra:{css:["even","odd"]},headers:{},widthFixed:!1,cancelSelection:!0,sortList:[],headerList:[],dateFormat:"us",decimal:"/.|,/g",onRenderHeader:null,selectorHeaders:"thead th",debug:!1},this.benchmark=benchmark,this.construct=function(t){return this.each(function(){if(this.tHead&&this.tBodies){var e,r,n,o,i,a,s=0;this.config={},i=$.extend(this.config,$.tablesorter.defaults,t),e=$(this),$.data(this,"tablesorter",i),n=buildHeaders(this),this.config.parsers=buildParserCache(this,n),o=buildCache(this);var d=[i.cssDesc,i.cssAsc];fixColumnWidth(this),n.click(function(t){var r=e[0].tBodies[0]&&e[0].tBodies[0].rows.length||0;if(!this.sortDisabled&&r>0){e.trigger("sortStart"),$(this);var a=this.column;if(this.order=this.count++%2,this.lockedOrder&&(this.order=this.lockedOrder),t[i.sortMultiSortKey]){if(isValueInArray(a,i.sortList))for(var s=0;s<i.sortList.length;s++){var c=i.sortList[s],u=i.headerList[c[0]];c[0]==a&&(u.count=c[1],u.count++,c[1]=u.count%2)}else i.sortList.push([a,this.order])}else{if(i.sortList=[],null!=i.sortForce)for(var f=i.sortForce,s=0;s<f.length;s++)f[s][0]!=a&&i.sortList.push(f[s]);i.sortList.push([a,this.order])}return setTimeout(function(){setHeadersCss(e[0],n,i.sortList,d),appendToTable(e[0],multisort(e[0],i.sortList,o))},1),!1}}).mousedown(function(){if(i.cancelSelection)return this.onselectstart=function(){return!1},!1}),e.bind("update",function(){var t=this;setTimeout(function(){t.config.parsers=buildParserCache(t,n),o=buildCache(t)},1)}).bind("updateCell",function(t,e){var r=this.config,n=[e.parentNode.rowIndex-1,e.cellIndex];o.normalized[n[0]][n[1]]=r.parsers[n[1]].format(getElementText(r,e),e)}).bind("sorton",function(t,e){$(this).trigger("sortStart"),i.sortList=e;var r=i.sortList;updateHeaderSortCount(this,r),setHeadersCss(this,n,r,d),appendToTable(this,multisort(this,r,o))}).bind("appendCache",function(){appendToTable(this,o)}).bind("applyWidgetId",function(t,e){getWidgetById(e).format(this)}).bind("applyWidgets",function(){applyWidget(this)}),$.metadata&&$(this).metadata()&&$(this).metadata().sortlist&&(i.sortList=$(this).metadata().sortlist),i.sortList.length>0&&e.trigger("sorton",[i.sortList]),applyWidget(this)}})},this.addParser=function(t){for(var e=parsers.length,r=!0,n=0;n<e;n++)parsers[n].id.toLowerCase()==t.id.toLowerCase()&&(r=!1);r&&parsers.push(t)},this.addWidget=function(t){widgets.push(t)},this.formatFloat=function(t){var e=parseFloat(t);return isNaN(e)?0:e},this.formatInt=function(t){var e=parseInt(t);return isNaN(e)?0:e},this.isDigit=function(t,e){return/^[-+]?\d*$/.test($.trim(t.replace(/[,.']/g,"")))},this.clearTableBody=function(t){if($.browser.msie)for(;t.tBodies[0].firstChild;)t.tBodies[0].removeChild(t.tBodies[0].firstChild);else t.tBodies[0].innerHTML=""}}}),$.fn.extend({tablesorter:$.tablesorter.construct});var ts=$.tablesorter;ts.addParser({id:"text",is:function(t){return!0},format:function(t){return $.trim(t.toLocaleLowerCase())},type:"text"}),ts.addParser({id:"digit",is:function(t,e){var r=e.config;return $.tablesorter.isDigit(t,r)},format:function(t){return $.tablesorter.formatFloat(t)},type:"numeric"}),ts.addParser({id:"currency",is:function(t){return/^[£$€?.]/.test(t)},format:function(t){return $.tablesorter.formatFloat(t.replace(RegExp(/[£$€]/g),""))},type:"numeric"}),ts.addParser({id:"ipAddress",is:function(t){return/^\d{2,3}[\.]\d{2,3}[\.]\d{2,3}[\.]\d{2,3}$/.test(t)},format:function(t){for(var e=t.split("."),r="",n=e.length,o=0;o<n;o++){var i=e[o];2==i.length?r+="0"+i:r+=i}return $.tablesorter.formatFloat(r)},type:"numeric"}),ts.addParser({id:"url",is:function(t){return/^(https?|ftp|file):\/\/$/.test(t)},format:function(t){return jQuery.trim(t.replace(RegExp(/(https?|ftp|file):\/\//),""))},type:"text"}),ts.addParser({id:"isoDate",is:function(t){return/^\d{4}[\/-]\d{1,2}[\/-]\d{1,2}$/.test(t)},format:function(t){return $.tablesorter.formatFloat(""!=t?new Date(t.replace(RegExp(/-/g),"/")).getTime():"0")},type:"numeric"}),ts.addParser({id:"percent",is:function(t){return/\%$/.test($.trim(t))},format:function(t){return $.tablesorter.formatFloat(t.replace(RegExp(/%/g),""))},type:"numeric"}),ts.addParser({id:"usLongDate",is:function(t){return t.match(RegExp(/^[A-Za-z]{3,10}\.? [0-9]{1,2}, ([0-9]{4}|'?[0-9]{2}) (([0-2]?[0-9]:[0-5][0-9])|([0-1]?[0-9]:[0-5][0-9]\s(AM|PM)))$/))},format:function(t){return $.tablesorter.formatFloat(new Date(t).getTime())},type:"numeric"}),ts.addParser({id:"shortDate",is:function(t){return/\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4}/.test(t)},format:function(t,e){var r=e.config;return t=t.replace(/\-/g,"/"),"us"==r.dateFormat&&(t=t.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/,"$3/$1/$2")),"pt"==r.dateFormat?t=t.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/,"$3/$2/$1"):"uk"==r.dateFormat?t=t.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})/,"$3/$2/$1"):("dd/mm/yy"==r.dateFormat||"dd-mm-yy"==r.dateFormat)&&(t=t.replace(/(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{2})/,"$1/$2/$3")),$.tablesorter.formatFloat(new Date(t).getTime())},type:"numeric"}),ts.addParser({id:"time",is:function(t){return/^(([0-2]?[0-9]:[0-5][0-9])|([0-1]?[0-9]:[0-5][0-9]\s(am|pm)))$/.test(t)},format:function(t){return $.tablesorter.formatFloat(new Date("2000/01/01 "+t).getTime())},type:"numeric"}),ts.addParser({id:"metadata",is:function(t){return!1},format:function(t,e,r){var n=e.config,o=n.parserMetadataName?n.parserMetadataName:"sortValue";return $(r).metadata()[o]},type:"numeric"}),ts.addWidget({id:"zebra",format:function(t){if(t.config.debug)var e=new Date;var r,n,o=-1;$("tr:visible",t.tBodies[0]).each(function(e){!(r=$(this)).hasClass(t.config.cssChildRow)&&o++,n=o%2==0,r.removeClass(t.config.widgetZebra.css[n?0:1]).addClass(t.config.widgetZebra.css[n?1:0])}),t.config.debug&&$.tablesorter.benchmark("Applying Zebra widget",e)}})}(jQuery);
</script>


<script type='text/javascript'>

<?php
	
	foreach($endjava as $value) {
		echo($value);
	}

?>

</script>


</html>
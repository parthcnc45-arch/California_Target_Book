@extends('layouts.book_nonav2')

@section('title', 'IE Single | California Target Book')

@section('styles')

<!--

  <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr' crossorigin='anonymous'>
  
<style type="text/css">
	@import url('https://fonts.googleapis.com/css?family=Bellefair');
	@import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow');
	body, html {
		background-color: white !important;
	}

	a {
		color: #0064CB !important;
	}

	table, th, td {
		padding-left: 5px;
		padding-right: 5px;
		font-family: 'PT SAns Narrow';
		line-height: 1em;
	}

	.ie_list_div {
		float: left;
		border: 2px solid black;
		padding: 5px;
		margin: 20px;
	}

	.fa span {
		margin-left: 5px;
	}

	.blackbox {
		border: 2px solid black;
	}

	.sacto {
		background: url('img/sacto_bright.jpg') no-repeat;
        background-size: cover;
        font-family: 'Bellefair';
	}

	.filing_div {
		
		margin-top: 10px;
	}

	.container {
		min-width: 80vw;
	}

	.max1200 {
		max-width: 1300px;
	}

	.align-right {
		text-align: right;
	}

	.align-left {
		text-align: left;
	}

	.header_summary_table  {
		line-height: .9em;
		
	}

	.h1me {
		font-size: 2em;
	}

	.h2me {
		font-size: 1.75em;
		font-weight: bold;
		font-variant: small-caps;
	}

	.h3me {
		font-size: 1.5em;
		font-variant: small-caps;
	}

	.filing_header {
		margin-top: 20px;
		font-family: 'PT SAns Narrow';
		font-weight: bold;
	}

	.f460_rcpt_div {
		float: left;
		margin: 10px;
	}

	.f460_expn_div {
		float: left;
		margin: 10px;
	}

	.big_smry {
		clear: both;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
		font-family: 'Lato';
		font-weight: bold;
		width: 50%;
	}

	.full_smry_div_container {
		display: inline-block;
		font-family: 'PT Sans Narrow';
	}

	.full_smry_div_container p {
		text-align: center;
		font-weight: bold;
	}

	.inverse {
		background-color: black;
		color: white;
		font-family: 'PT Sans NArrow' !important;
	}

	.greenme {
	 	color: green !important;
	}

	.redme {
		color: red !important;
	}

	.boldme {
		font-weight: bold;
	}

	.itcme {
		font-style: italic;
	}

	table {
		border: 2px solid black;
	}

	h1, h2 {
		font-family: 'Bellefair';
		font-variant: small-caps;
	}

	h4 span {
		padding-left: 5px;
	}

	.ctb_logo {
	position:fixed; 
	top:0; 
	right:0;
	} 		
	
	.big-summary {
		max-width: 800px !important;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
	}


   .box1200 {
      background-image: url(box1200.jpg);
      background-position: center;
	}

	.box500 {
		background-image: url(box500.jpg);
		background-position: center;
		background-repeat: no-repeat;
		background-size: contain;
		width: 800px;
		height: 500px;
		float: left;
		padding: 20px;
	}

  	.box800 {
		background-image: url(box800.jpg);
		background-position: center;
		background-repeat: no-repeat;
		background-size: contain;
		width: 800px;
		float: left;
		margin: 10px;
	}

	.dem {
		background-color: #85C1F8;
	}

	.rep {
		background-color: #FFA6A6;
	}

	.oth {
		background-color:#DBE8E3;
	}

	.Support {
		color: green;
		font-weight: bold;
	}	

	.Oppose {
		color: red;
		font-weight: bold;
	}

	.cand_list_div {
		float: left;
		margin-left: 20px;
		margin-right: 20px;
	}

	.DEM {
		color: blue;
		font-weight: bold;
	}

	.REP {
		color: #CE0000;
		font-weight: bold;
	}

	.filer_nm {
		font-weight: bold;
		font-family: 'Lato';
		color: #009FCD;
	}

	.dollar_amt {
		font-family: 'Lato';
		font-weight: bold;
	}

/* bootstrap hack: fix content width inside hidden tabs */
.tab-content > .tab-pane,
.pill-content > .pill-pane {
display: block;     /* undo display:none          */
height: 0;          /* height:0 is also invisible */ 
overflow-y: hidden; /* no-overflow                */
}
.tab-content > .active,
.pill-content > .active {
height: auto;       /* let the content decide it  */
} /* bootstrap hack end */


</style>
-->

@endsection


@section('content')

<?php

ob_start();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
ini_set('memory_limit', '512M');

$endjava = Array();
$final_draw = '';

Util::set_errors();
Util::require_ctb_api();





global $fourcode, $cycle, $year, $filing_arr, $filer_arr, $filer_name_arr, $short_cycle, $cycle_yr1, $cycle_yr2, $cand_ccl;
$fourcode = $_GET['id'];
$year = $_GET['year'];
$cycle = $year;

/*
$key_name = "IE_" . $fourcode . "_" . $year;

if($year != "2018" && $year != "2020") {

    if(Cache::has($key_name)) {
        $final_draw = Cache::get($key_name);
        echo($final_draw);
        //echo("<br>SHOWING CACHED PAGE!");
        exit;
    }
}
*/


$style = "

  <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' integrity='sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr' crossorigin='anonymous'>
  <!--<link href='/css/app.css' rel='stylesheet' id='appStyles'>-->


<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script src='/js/jquery.tablesorter.min.js'></script>
<script src='/js/app.js?id=22eb1c7dca6fbde7adf1'></script>
        
  
<style type='text/css'>
	@import url('https://fonts.googleapis.com/css?family=Bellefair');
	@import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow');
	body, html {
		background-color: white !important;
	}

	a {
		color: #0064CB !important;
	}

	table, th, td {
		padding-left: 5px;
		padding-right: 5px;
		font-family: 'PT SAns Narrow';
		line-height: 1em;
	}

	.ie_list_div {
		float: left;
		border: 2px solid black;
		padding: 5px;
		margin: 20px;
	}

	.fa span {
		margin-left: 5px;
	}

	.blackbox {
		border: 2px solid black;
	}

	.sacto {
		background: url('img/sacto_bright.jpg') no-repeat;
        background-size: cover;
        font-family: 'Bellefair';
	}

	.filing_div {
		
		margin-top: 10px;
	}

	.container {
		min-width: 80vw;
	}

	.max1200 {
		max-width: 1300px;
	}

	.right-align {
		/*
		text-align: right;
		*/
	}

	

	.align-right {
		text-align: right;
	}

	.align-left {
		text-align: left;
	}

	.header_summary_table  {
		line-height: .9em;
		
	}

	.h1me {
		font-size: 2em;
	}

	.h2me {
		font-size: 1.75em;
		font-weight: bold;
		font-variant: small-caps;
	}

	.h3me {
		font-size: 1.5em;
		font-variant: small-caps;
	}

	.filing_header {
		margin-top: 20px;
		font-family: 'PT SAns Narrow';
		font-weight: bold;
	}

	.f460_rcpt_div {
		float: left;
		margin: 10px;
	}

	.f460_expn_div {
		float: left;
		margin: 10px;
	}

	.big_smry {
		clear: both;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
		font-family: 'Lato';
		font-weight: bold;
		width: 50%;
	}

	.full_smry_div_container {
		display: inline-block;
		font-family: 'PT Sans Narrow';
	}

	.full_smry_div_container p {
		text-align: center;
		font-weight: bold;
	}

	.inverse {
		background-color: black;
		color: white;
		font-family: 'PT Sans NArrow' !important;
	}

	.greenme {
	 	color: green !important;
	}

	.redme {
		color: red !important;
	}

	.boldme {
		font-weight: bold;
	}

	.itcme {
		font-style: italic;
	}

	table {
		border: 2px solid black;
	}

	h1, h2 {
		font-family: 'Bellefair';
		font-variant: small-caps;
	}

	h4 span {
		padding-left: 5px;
	}

	.ctb_logo {

} 		
	}
	.big-summary {
		max-width: 800px !important;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
	}


   .box1200 {
      background-image: url(box1200.jpg);
      background-position: center;
	}

	.box500 {
		background-image: url(box500.jpg);
		background-position: center;
		background-repeat: no-repeat;
		background-size: contain;
		width: 800px;
		height: 500px;
		float: left;
		padding: 20px;
	}

  	.box800 {
		background-image: url(box800.jpg);
		background-position: center;
		background-repeat: no-repeat;
		background-size: contain;
		width: 800px;
		float: left;
		margin: 10px;
	}

	.dem {
		background-color: #85C1F8;
	}

	.rep {
		background-color: #FFA6A6;
	}

	.oth {
		background-color:#DBE8E3;
	}

	.Support {
		color: green;
		font-weight: bold;
	}	

	.Oppose {
		color: red;
		font-weight: bold;
	}

	.cand_list_div {
		float: left;
		margin-left: 20px;
		margin-right: 20px;
	}

	.DEM {
		color: blue;
		font-weight: bold;
	}

	.REP {
		color: #CE0000;
		font-weight: bold;
	}

	.filer_nm {
		font-weight: bold;
		font-family: 'Lato';
		color: #009FCD;
	}

	.dollar_amt {
		font-family: 'Lato';
		font-weight: bold;
	}

	/* bootstrap hack: fix content width inside hidden tabs */
	.tab-content > .tab-pane,
	.pill-content > .pill-pane {
	display: block !important;     /* undo display:none          */
	height: 0 !important;          /* height:0 is also invisible */ 
	overflow-y: hidden !important; /* no-overflow                */
	}
	.tab-content > .active,
	.pill-content > .active {
	height: auto !important;       /* let the content decide it  */
	} /* bootstrap hack end */	

</style>";

echo($style);

//$cycle = $year;

if(mb_substr($fourcode, 0, 2) == "CD") {
	$fourcode = "CA" . mb_substr($fourcode, 2, 2);
}

$master_fourcode = $fourcode;

$base_fppc_filing 	= 'http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=';
$base_fppc_cmte 	= 'https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id=';
$base_fppc_cand 	= 'https://californiatargetbook.com/book/get_cand_page_t.php?id=';
$base_fec_filing 	= 'https://californiatargetbook.com/ctb-legacy/fedparser_null.php?id=';
$base_fec_cand 		= 'https://www.fec.gov/data/candidate/';
$base_fec_cmte 		= 'https://californiatargetbook.com/ctb-legacy/fec_cmte_report.php?id=';


$endjava = Array();

$js = "	jQuery.tablesorter.addParser({
	  id: \"fancyNumber\",
	  is: function(s) {
	    return /^[0-9]?[0-9,\.]*$/.test(s);
	  },
	  format: function(s) {
	    return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') );
	  },
	  type: \"numeric\"
	});

";
array_push($endjava, $js);

//$fourcode = "POTUS";
//$cycle = "2016";
//CHECK FOR FEDERAL 'AT-LARGE' FOURCODE, CONVERT ST-AL to ST-00
if(mb_substr($fourcode, 2, 2) == "AL") {
	$fourcode = mb_substr($fourcode, 0, 2) . "00";
}

$short_cycle = mb_substr($cycle, 2, 2);
$cycle_yr1 = $cycle - 1;
$cycle_yr2 = $cycle;

$usefec = TRUE;

$firsttwo = mb_substr($fourcode, 0, 2);

switch($firsttwo) {
	case "AD":
		$usestate = TRUE;
		$usefec = FALSE;
		break;
	case "SD":
		$usestate = TRUE;
		$usefec = FALSE;
		break;
}

$statecodes = Array(".GOV", ".LTG", ".ATG", ".CON", ".TRS", ".INS", ".SOS", ".SPI", "BOE1", "BOE2", "BOE3", "BOE4");
foreach($statecodes as $office) {
	if($office == $fourcode) {
		$usestate = TRUE;
		$usefec = FALSE;
	}
}



if(mb_substr($fourcode, 0, 2) == "CD" || mb_substr($fourcode, 0, 3) == ".SN" || $fourcode == "SD00") {
	$usefec = TRUE;
	$usestate = FALSE;
} 

$candidates = get_candidates($fourcode, $cycle, $usestate, $usefec);



$page['candidates'] = "<div class='container'><h1>CANDIDATES FOR $fourcode ($cycle CYCLE)</h1>";


foreach($candidates as $c) {
	$party = $c['cand_party'];
	$ici   = $c['cand_ici'];
	$cand_id = $c['cand_id'];
	$cmte_id = $c['cmte_id'];

	$cand_nm = strtoupper(trim($c['cand_nm']));
	$cand_naml = strtoupper(trim($c['cand_naml']));



	switch($party) {
		case "D":
			$party_class = "DEM";
			break;
		case "DFL":
			$party_class = "DEM";
			break;
		case "DEM":
			$party_class = "DEM";
			break;
		case "R":
			$party_class = "REP";
			break;
		case "GOP":
			$party_class = "REP";
			break;
		case "REP":
			$party_class = "REP";
			break;
		default:
			$party_class = "OTH";
			break;
	}

	switch($ici) {
		case "Inc":
			$inc_class = "Inc";
			break;
		case "1":
			$inc_class = "Inc";
			break;
		case "I":
			$inc_class = "Inc";
			break;
		default:	
			$inc_class = "";
			break;
	}

	$cand_ccl[$cand_id]['cand_nm'] = $cand_nm;
	$cand_ccl[$cand_id]['party']   = $party_class;

	$img = get_cand_img($cand_id);


	$cand_table[$party_class]['table_body'] .= "<tr>
													<td>$img</td>
													<td>" . $c['cand_nm'] . "</td>
													<td>$cand_id</td>
													<td class='$party_class'>$party</td>
													<td>$inc_class</td>
												</tr>";

	//echo("<br>ADDING $cand_naml, $cand_nm");
	$cand_party_arr[$cand_naml] = $party_class;
	$cand_party_arr[$cand_nm]   = $party_class;
	$cand_party_collision[$cand_naml]++;

	//$page['candidates'] .= "<br>" . $c['cand_id'] . " - " . $c['cand_nm'] . " (" . $c['cand_naml'] . ", " . $c['cand_namf'] . ") - " . $c['cand_party'] . " " . $c['cand_ici'];
}

if($cand_table) {
	foreach($cand_table as $party_class => $t) {
		switch($party_class) {
			case "REP":
				$verbose = "Republican Candidates";
				break;
			case "DEM":
				$verbose = "Democratic Candidates";
				break;
			case "OTH":
				$verbose = "Independents/Other Candidates";
				break;

		}
		$page['candidates'] .= "<div class='cand_list_div'>
								  <p align='center'>$verbose</p>
		                          <table class='table-striped table-hover table-responsive'>
		                              <thead>
		                                  <tr>
		                                      <th></tH>
		                                      <th>CANDIDATE</th>
		                                      <th>ID</th>
		                                      <th>PARTY</th>
		                                      <th>IS INC</th>
		                                  </tr>
		                             </thead>
		                             <tbody>" . $t['table_body'] . "
		                             </tbody>
		                          </table>
		                       </div>";
	}
	$page['candidates'] .= "</div>";
}

if($usefec) {
	$transactions = get_federal_transactions($candidates, $fourcode);
	$cand_finances = get_federal_committees($candidates, $fourcode);
} else {
	$transactions = get_state_transactions($candidates, $fourcode);
	$cand_finances = get_state_committees($candidates, $fourcode);
}

//echo("<br>TRANSACTIONS DUMP<br>");
//var_dump($transactions);

$thisid = "cand_finance_table_$cycle";
$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 
            headers: {"; 

$js .= "6: {
				sorter: 'fancyNumber'
			},
		7: {
				sorter: 'fancyNumber'
			},

		8: {
				sorter: 'fancyNumber'
			},		
		9: {
				sorter: 'fancyNumber'
			},
		10: {
				sorter: 'fancyNumber'
			},			";

rtrim($js, ",");		            

$js.="     } 
        });
});";
array_push($endjava, $js);

$table_head['cand_finances'] = "<table class='table-striped table-hover table-responsive tablesorter' id='$thisid'>
                                    <thead class='inverse'>
                                        <tr>
                                        	<th>CANDIDATE</th>
                                        	<th>PARTY</th>
                                        	<th>ID</th>
                                        	<th>FILED</th>
                                        	<th>COMMITTEE</th>
                                        	<th>ID</th>
                                        	<th>RECEIPTS</th>
                                        	<th>CAND LOANS</th>
                                        	<th>EXPENDITURES</th>
                                        	<th>LAST CASH ON HAND</th>
                                        	<th>DEBT</th>
                                        	<th>LAST RPT DATE</th>
                                        </tr>
                                     </thead>
                                     <tbody>";

foreach($cand_finances as $cand_id => $c) {

	$cand_span = '';
	$cmte_span = '';

	if($c['cmte_id']) {
		if(mb_substr($c['cmte_id'], 0, 1) == "C" ) {
			//USE FEDERAL
			$cmte_span = "<a href='$base_fec_cmte" . $c['cmte_id'] . "&cycle=$cycle' target='_blank'>" . $c['cmte_id'] . "</a>";
			$cand_span = "<a href='$base_fec_cand" . $c['cand_id'] . "/?tab=filings' target='_blank'>" . $c['cand_id']  . "</a>";

		} else {
			//USE STATE
			$cmte_span = "<a href='$base_fppc_cmte" . $c['cmte_id'] . "&cycle=$cycle' target='_blank'>" . $c['cmte_id'] . "</a>";
			$cand_span = "<a href='$base_fppc_cand" . $c['cand_id'] . "' target='_blank'>" . $c['cand_id'] . "</a>";
		}
	} else {
		$cmte_span = "No Committee";
	}

	$party_class = $c['party'];
	$table_body['cand_finances'] .= "<tr>
										<td class='$party_class'>" . $c['cand_nm'] . "</td>
										<td class='$party_class'>" . $c['party']   . "</td>
										<td>" . $cand_span      . "</td>
										<td>" . $c['filed']   . "</td>
										<td>" . $c['cmte_nm'] . "</td>
										<td>" . $cmte_span . "</td>
										<td align='right'>" . number_format($c['rcpt'])    . "</td>
										<td align='right'>" . number_format($c['loan'])    . "</td>
										<td align='right'>" . number_format($c['expn'])    . "</td>
										<td align='right'>" . number_format($c['coh'])     . "</td>
										<td align='right'>" . number_format($c['debt'])    . "</td>
										<td>" . $c['pd_end']  . "</td>
									</tr>";
}

$table_end['cand_finances'] = "</tbody></table>";



if($transactions) {
		$thisid = "ie_detail_$cycle";

	  	$js = "$(document).ready(function() {
		    $('#" . $thisid . "').tablesorter({ 
		            headers: {"; 

		$js .= "4: {
						sorter: 'fancyNumber'
					},";
		
		rtrim($js, ",");		            

		$js.="     } 
		        });
		});";
		array_push($endjava, $js);

		$table_head['ie_detail'] = "<table id='$thisid' class='table-striped table-hover table-responsive tablesorter'>
										<thead class='inverse'>
											<tr>
												<th>RACE</th>
												<th>FILING</th>
												<th>FILER</th>
												<th>DATE</th>
												<th>AMOUNT</th>
												<th>PAYEE</th>
												<th>DSCR</th>
												<th>TRAN ID</th>
												<th>ELECTION</th>
												<th>SUP/OPP</th>
												<th>CANDIDATE</th>
											</tr>
										</thead>
										<tbody>";
	foreach($transactions as $t) {

		$filer_id 	= $t['filer_id'];
		$filer_nm 	= $t['filer_nm'];
		$exp_dat 	= $t['exp_date'];
		$dscr 		= $t['dscr'];
		$amt 		= $t['amount'];
		$election   = $t['election_type'];
		$position   = $t['position'];
		$cand_naml  = trim(strtoupper($t['cand_naml']));
		$fourcode   = $t['fourcode'];
		$cand_full  = trim(strtoupper($t['cand_nm']));
		$filing 	= $t['filing_id'];

		$filing_span = '';
		$filer_span  = '';

		if($usestate) {
			$filing_span = "<a href='$base_fppc_filing" . $filing . "' target='_blank'>" . $filing . "</a>";
			$filer_span  = "<a href='$base_fppc_cmte"   . $filer_id . "&cycle=$cycle' target='_blank'>" . mb_substr($filer_nm, 0, 64) . "</a>";
		} elseif($usefec) {
			$filing_span = "<a href='$base_fec_filing" . $filing . "' target='_blank'>" . $filing . "</a>";
			$filer_span  = "<a href='$base_fec_cmte"   . $filer_id . "&cycle=$cycle' target='_blank'>" . mb_substr($filer_nm, 0, 64) . "</a>";
		}

		switch($election) {
			case "P":
				$election_class = 'Primary';
				break;
			case "G":
				$election_class = "General";
				break;
			case "O":
				$election_class = "Special/Other";
				break;
			case "S":
				$election_class = "Special/Other";
				break;
			case "R":
				$election_class = "Special/Other";
				break;
		}


		if($amt < 100) {
			//DO NOTHING
		} else {

			if($cand_party_collision[$cand_naml] > 1) {
				//echo("<br>COllision with $cand_naml, " . $cand_party_collision[$cand_naml] . " Entries Found, using $cand_full");
				$cand_party = $cand_party_arr[$cand_full];
			}	else {
				$cand_party = $cand_party_arr[$cand_naml];
			}

			$table_body['ie_detail'] .= "<tr>
											<td>" . $t['fourcode'] . "</td>
											<td align='right'>$filing_span</td>
											<td>$filer_span</td>
											<td align='right'>" . $t['exp_date'] . "</td>
											<td align='right'>" . number_format($t['amount']) . "</td>
											<td>" . mb_substr($t['vendor'], 0, 64) . "</td>
											<td>" . mb_substr($t['dscr'], 0, 64) . "</td>
											<td>" . $t['transaction_id'] . "</td>
											<td>" . $t['election_type'] . "</td>
											<td class='$position'>" . $t['position'] . "</td>
											<td class='$cand_party'>" . $t['cand_nm'] . "</td>
										</tr>";
		}

		$filer_index[$filer_id]['filer_nm']										= $filer_nm;
		$filer_totals[$filer_id]['ALL']['TOTAL']								+= $t['amount'];
		$filer_totals[$filer_id][$election_class]['TOTAL']						+= $t['amount'];

		$filer_election_totals[$election_class][$filer_id]['TOTAL']				+= $t['amount'];
		$filer_election_totals['ALL'][$filer_id]['TOTAL']						+= $t['amount'];

		$totals['fourcode'][$fourcode] 											+= $t['amount'];

		$totals['filers'][$filer_id]['summary']['TOTAL'] 						+= $t['amount'];
		$totals['filers'][$filer_id]['elections'][$election_class] 				+= $t['amount'];
		$totals['filers'][$filer_id]['candidates'][$cand_naml]['TOTAL']			+= $t['amount'];
		$totals['filers'][$filer_id]['candidates'][$cand_naml]['POSITION'] 		= $position;
		$totals['filers'][$filer_id]['candidates'][$cand_naml][$election_class]	+= $t['amount'];
		$totals['filers'][$filer_id]['candidates'][$cand_naml]['DSCR'][$dscr] 	= $dscr;
		$totals['filers'][$filer_id]['position'][$position] 					+= $t['amount'];
		$totals['filers'][$filer_id]['candidates_spent_on'][$position][$cand_naml]		+= $t['amount'];
		$totals['filers'][$filer_id]['election_candidates'][$election_class][$cand_full]['position'] = $position;
		$totals['filers'][$filer_id]['election_candidates'][$election_class][$cand_full]['TOTAL'] += $t['amount'];
		$totals['filers'][$filer_id]['election_candidates_naml'][$election_class][$cand_full]['TOTAL'] += $t['amount'];
		$totals['filers'][$filer_id]['election_candidates_naml'][$election_class][$cand_full]['NAML'] = $cand_naml;


		$totals['filers'][$filer_id]['filer_nm']										= $filer_nm;

		$totals['dates'][$exp_dat]														+= $t['amount'];
		$totals['election_dates'][$election_class][$exp_dat]							+= $t['amount'];

		$totals['grand_total']															+= $t['amount'];

		$totals['candidates'][$cand_naml]['summary']['TOTAL']							+= $t['amount'];
		$totals['candidates'][$cand_naml]['summary'][$election_class]['TOTAL']			+= $t['amount'];
		$totals['candidates'][$cand_naml]['summary'][$election_class][$position]		+= $t['amount'];
		$totals['candidates'][$cand_naml]['position'][$position]['TOTAL']				+= $t['amount'];
		$totals['candidates'][$cand_naml]['position'][$position][$election_class]		+= $t['amount'];

		$totals['candidates_election'][$election_class][$cand_naml][$position]			+= $t['amount'];
		$totals['candidates_election']['ALL'][$cand_naml][$position]					+= $t['amount'];

		$totals['candidates_full'][$cand_nm]['summary']['TOTAL']						+= $t['amount'];
		$totals['candidates_full'][$cand_nm]['summary'][$election_class]				+= $t['amount'];
		$totals['candidates_full'][$cand_nm]['position'][$position]['TOTAL']			+= $t['amount'];
		$totals['candidates_full'][$cand_nm]['position'][$position][$election_class]	+= $t['amount'];

		$totals['position_total'][$position]											+= $t['amount'];

		$totals['position_cands'][$position][$cand_naml]['TOTAL']						+= $t['amount'];
		$totals['position_cands'][$position][$cand_naml][$election_class]				+= $t['amount'];

		$totals['elections'][$election_class]['summary']['TOTAL']						+= $t['amount'];
		$totals['elections'][$election_class]['summary'][$position]						+= $t['amount'];
		$totals['elections'][$election_class]['filers'][$filer_id]						+= $t['amount'];

		$totals['by_date'][$election_class][$exp_dat]									+= $t['amount'];
		$totals['by_date']['ALL'][$exp_dat]												+= $t['amount'];

		$totals['by_name'][$election_class][$cand_naml][$position]						+= $t['amount'];
		$totals['by_name']['ALL'][$cand_naml][$position]								+= $t['amount'];



	}
}

$table_end['ie_detail'] = "</tbody></table>";

$page['ie_detail'] = $table_head['ie_detail'] . $table_body['ie_detail'] . $table_end['ie_detail'];


$page['ie_cmte_totals'] .= "<h1>TOTAL INDEPENDENT EXPENDITURES: \$" . number_format($totals['grand_total']) . "</h1>";

if($totals['elections']['Primary']['summary']['TOTAL']) {
	$e_breakout .= "\$" . number_format($totals['elections']['Primary']['summary']['TOTAL']) . " in Primary Election<br>";
}
if($totals['elections']['General']['summary']['TOTAL']) {
	$e_breakout .= "\$" . number_format($totals['elections']['General']['summary']['TOTAL']) . " in General Election<br>";	
}

if($totals['elections']['Special/Other']['summary']['TOTAL']) {
	$e_breakout .= "\$" . number_format($totals['elections']['Special/Other']['summary']['TOTAL']) . " in Special/Other Election<br>";	
}

$page['ie_cmte_totals'] .= "<p align='center'>$e_breakout</p>";

uasort($filer_totals, "totalsort");


$thisid = "ie_cmte_detail_$cycle";
$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 
            headers: {"; 

$js .= "2: {
				sorter: 'fancyNumber'
			},
		3: {
				sorter: 'fancyNumber'
			},

		4: {
				sorter: 'fancyNumber'
			},		
		5: {
				sorter: 'fancyNumber'
			},";

rtrim($js, ",");		            

$js.="     } 
        });
});";
array_push($endjava, $js);

if($totals['grand_total']) {

	$table_head['ie_cmte_detail'] = "<table id='$thisid' class='table-striped table-hover table-responsive tablesorter'>
									<thead class='inverse'>
										<tr>
											<th>COMMITTEE</th>
											<th>ID</th>
											<th>TOTAL</th>
											<th>PRIMARY</th>
											<th>GENERAL</th>
											<th>OTHER</th>
											<th>SUPPORTED</th>
											<th>OPPOSED</th>
										</tr>
									</thead>
									<tbody>";

	foreach($filer_totals as $filer_id => $v) {
		$support_cands = '';
		$oppose_cands = '';
		if($totals['filers'][$filer_id]['candidates_spent_on']['Support']) {
			foreach($totals['filers'][$filer_id]['candidates_spent_on']['Support'] as $cand_nm => $amt) {
				$party_class = $cand_party_arr[$cand_nm];
				$support_cands .= "<span class='$party_class'>" . $cand_nm . "</span>, ";

			}
			$support_cands = rtrim($support_cands, ", ");
		}

		if($totals['filers'][$filer_id]['candidates_spent_on']['Oppose']) {
			foreach($totals['filers'][$filer_id]['candidates_spent_on']['Oppose'] as $cand_nm => $amt) {
				$party_class = $cand_party_arr[$cand_nm];
				$oppose_cands .= "<span class='$party_class'>" . $cand_nm . "</span>, ";

			}
			$oppose_cands = rtrim($oppose_cands, ", ");
		}

		$filer_nm = $filer_index[$filer_id]['filer_nm'];

		$filer_span = '';
		if($usestate) {
			$filer_span  = "<a href='$base_fppc_cmte"   . $filer_id . "&cycle=$cycle' target='_blank'>" . mb_substr($filer_nm, 0, 64) . "</a>";
		} elseif($usefec) {
			$filer_span  = "<a href='$base_fec_cmte"   . $filer_id . "&cycle=$cycle' target='_blank'>" . mb_substr($filer_nm, 0, 64) . "</a>";
		}

		$table_body['ie_cmte_detail'] .= "<tr>
											<td>" . $filer_span . "</td>
											<td>" . $filer_id . "</td>
											<td align='right'>" . number_format($totals['filers'][$filer_id]['summary']['TOTAL'] ) . "</td>
											<td align='right'>" . number_format($filer_totals[$filer_id]['Primary']['TOTAL']) . "</td>
											<td align='right'>" . number_format($filer_totals[$filer_id]['General']['TOTAL']) . "</td>
											<td align='right'>" . number_format($filer_totals[$filer_id]['Special/Other']['TOTAL']) . "</td>
											<td>$support_cands</td>
											<td>$oppose_cands</td>
										</tr>";
	}
	$table_end['ie_cmte_detail'] = "</tbody></table>";
}


$page['ie_cmte_totals'] .= $table_head['ie_cmte_detail'] . $table_body['ie_cmte_detail'] . $table_end['ie_cmte_detail'];

$page['ie_cmte_totals'] .= "<div class='ie_list_div'>
							<p><h3 style='text-align: left;'><b style='color: #4B57B1; text-align: left; !important'>$master_fourcode Independent Expenditures in $cycle Cycle</b><br><b style='color: FireBrick;'>TOTAL IE SPENDING: \$" . 
							number_format($totals['grand_total']) . "</b></h3></p>
<p align='left' style='text-align: left !important;'>";

foreach($filer_totals as $filer_id => $v) {
	$filer_nm = $filer_index[$filer_id]['filer_nm'];

	if($usestate) {
		$filer_span  = "<a href='$base_fppc_cmte"   . $filer_id . "&cycle=$cycle' target='_blank'>" . mb_substr($filer_nm, 0, 64) . "</a>";
	} elseif($usefec) {
		$filer_span  = "<a href='$base_fec_cmte"   . $filer_id . "&cycle=$cycle' target='_blank'>" . mb_substr($filer_nm, 0, 64) . "</a>";
	}


	$page['ie_cmte_totals'] .= "<br><br><span class='filer_nm'>" . $filer_span . "</span> Spent \$<span class='dollar_amt'>" . number_format($v['ALL']['TOTAL']) . "</span>";


	foreach($totals['filers'][$filer_id]['candidates'] as $cand_naml => $c) {
		$page['ie_cmte_totals'] .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$<span class='dollar_amt'>" . number_format($c['TOTAL']) . " to <span class='" . $c['POSITION'] . "'> "  . $c['POSITION'] . "</span> $cand_naml";
	}
}
$page['ie_cmte_totals'] .= "</p>
</div>";

//DO COMMITTEE IE SPENDING BY ELECTION

uasort($filer_election_totals, "election_sort");

$etypes = Array("ALL", "Special/Other", "Primary", "General");

foreach($etypes as $etype) {
	if($totals['elections'][$etype]['summary']['TOTAL']) {
		//GOT TRANSACTIONS FOR THIS ELECTION TYPE

		$first_three = mb_substr($etype, 0, 3);

		$js_functions .= "
						  draw" . $first_three . "Pie_$cycle();
						  draw" . $first_three . "Date_$cycle();
						  draw" . $first_three . "Supopp_$cycle();
		";

		$use_etypes[$etype] = TRUE;

		$page['ie_election_totals'] .= "<div class='ie_list_div'>
		<p><h3 style='text-align: left;'><b style='color: #4B57B1; text-align: left; !important'>$master_fourcode Independent Expenditures in $cycle $etype Election:</b><br><b style='color: FireBrick;'>TOTAL IE SPENDING: \$" . 
		number_format( $totals['elections'][$etype]['summary']['TOTAL'] ) . "</b></h3></p><p align='left' style='text-align: left !important'>";

		uasort($filer_election_totals[$etype], "election_sort");
		foreach($filer_election_totals[$etype] as $filer_id => $amt) {
			$page['ie_election_totals'] .= "<br><br><span class='filer_nm'>" . $filer_index[$filer_id]['filer_nm'] . "</span> Spent <span class='dollar_amt'>\$" . number_format($amt['TOTAL']) . "</span>";
			$pie_function = "draw" . $first_three . "Pie_$cycle";
			$supopp_function = "draw" . $first_three . "Supopp_$cycle";

			$sanitized = str_replace("'", "", $filer_index[$filer_id]['filer_nm']);
			$chart_data[$pie_function] .= "
				['" . $sanitized . "', " . $amt['TOTAL'] . " ],";

			foreach($totals['filers'][$filer_id]['election_candidates'][$etype] as $cand_nm => $x) {
				$page['ie_election_totals'] .= "<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\$<span class='dollar_amt'>" . number_format($x['TOTAL']) . "</span> to <span class='" . $x['position'] . "'>" . $x['position'] . "</span> $cand_nm";	
			}
		}
		$page['ie_election_totals'] .= "</p>
		</div>";

		foreach($totals['candidates_election'][$etype] as $cand_naml => $x) {
			$sup_amt = $x['Support'];
			$opp_amt = $x['Oppose'];
			if(!$sup_amt) {
				$sup_amt = "0";
			}
			if(!$opp_amt) {
				$opp_amt = "0";
			}
			$chart_data[$supopp_function] .= "
				[ \"$cand_naml\", $sup_amt, $opp_amt ],
			";
		}

	}
}


$js = "google.load('visualization', '1.0', {'packages':['corechart'], 'callback': drawCharts_$cycle});

		function drawCharts_$cycle() { 
		$js_functions
}";
array_push($endjava, $js);

//SEED CHART DATA

//EXPENDITURES BY DATE

foreach($etypes as $etype) {
	$first_three = mb_substr($etype, 0, 3);
	$date_function = "draw" . $first_three . "Date_" . $cycle;
	ksort($totals['election_dates'][$etype]);
	foreach($totals['election_dates'][$etype] as $date => $amt) {
		$chart_data[$date_function] .= "
				[ \"$date\", $amt ],
			";		
	}
}

//SUPPORT/OPPOSE CANDIDATE SPENDING

//EXPENDITURES BY COMMITTEE

foreach($etypes as $etype) {
	$first_three = mb_substr($etype, 0, 3);
	if($totals['elections'][$etype]['summary']['TOTAL']) {
		$pie_function = "draw" . $first_three . "Pie_" . $cycle;
		$date_function = "draw" . $first_three . "Date_" . $cycle;
		$supopp_function = "draw" . $first_three . "Supopp_" . $cycle;

		$js = "function draw" . $first_three . "Pie_$cycle() {

		    var data = google.visualization.arrayToDataTable([
		      ['Filer', 'Amount'],
		      " . $chart_data[$pie_function] . "
		    ]);
		 
		    var options = {
		      title: '$master_fourcode Independent Expenditure Composition in $etype Election (\$" . number_format($totals['elections'][$etype]['summary']['TOTAL']) . ")',
		      backgroundColor: 'none',
		      titleTextStyle: {
		        color: '333333',
		        fontName: 'PT Sans Narrow',
		        fontSize: 20
		      },
		      chartArea: {
		       	width: '80%',
		       	height: '80%'
		       },
		       legend: {
		    	textStyle: {
		    		color: '333333',
		      		fontName: 'PT Sans Narrow',
		      		fontSize: 12
		    	}
		  	  }
		    };
		 
		    var chart = new google.visualization.PieChart(document.getElementById('$pie_function'));
		 
		    chart.draw(data, options);

		}

		function $date_function() {

 				var data = google.visualization.arrayToDataTable([
		          ['Date', 'Amount'],
				" . $chart_data[$date_function] . "

		        ]);

		        var options = {

		            title: '$master_fourcode Independent Expenditures By Date in $etype Election (\$" . number_format($totals['elections'][$etype]['summary']['TOTAL']) . ")',
		            titleTextStyle: {
		        		color: '333333',
		        		fontName: 'PT Sans Narrow',
		        		fontSize: 20
		      		},
		            backgroundColor: 'none',
		            titleTextStyle: {
				      color: '333333',
				      fontName: 'PT Sans Narrow',
				      fontSize: 20
				    },
		            annotations: {
		            	alwaysOutside: true,
		            	textStyle: {
		            		fontSize: 9
		            	}
		            },
		 			hAxis: {
		 				slantedText:true, 
		 				slantedTextAngle:90,
		 				textStyle: {
		 					fontSize: 9
		 				}
		 			},
		             vAxis: {
		            	textStyle: {
		            		fontSize: 11
		              	},
		              	viewWindow: {
        					min:0
    					}
		            },

	            legend: 'none',
		            chartArea: {
		            	width: '80%',
		            	height: '75%'
		            }
		        };

		        var chart = new google.visualization.ColumnChart(document.getElementById('$date_function'));

		        chart.draw(data, options);


		}
		function $supopp_function() {
		        var data = google.visualization.arrayToDataTable([
		          ['Candidate', 'Support', 'Oppose'],
				" . $chart_data[$supopp_function] . "

		        ]);

		        var options = {
		            title: '$master_fourcode Independent Expenditures Supporting/Opposing Candidates in $etype Election (\$" . number_format($totals['elections'][$etype]['summary']['TOTAL']) . ")',
		            backgroundColor: 'none',
		            titleTextStyle: {
		        		color: '333333',
		        		fontName: 'PT Sans Narrow',
		        		fontSize: 20
		        	}
		        };

		        var chart = new google.visualization.ColumnChart(document.getElementById('$supopp_function'));

		        chart.draw(data, options);			
		}
		";
		array_push($endjava, $js);


		$chart_divs .= "<div class='box800 blackbox' style='width: 1200px; height: 800px; text-align: center; margin-left: auto; margin-right: auto;'>
							<div id='$pie_function' style='margin-top: 20px; width: 1200px; height: 800px;'></div>
						</div>
						<div class='box800 blackbox' style='width: 1200px; height: 800px; text-align: center; margin-left: auto; margin-right: auto;'>
							<div id='$supopp_function' style='margin-top: 20px; width: 1200px; height: 800px;'></div>
						</div>
						<div class='box800 blackbox' style='width: 1200px; height: 800px; text-align: center; margin-left: auto; margin-right: auto;'>
							<div id='$date_function' style='margin-top: 20px; width: 1200px; height: 800px;'></div>
						</div>";


	}
}

$js = "        
			$('#page_candidates_$cycle').removeClass('active');
			$('#page_candidate_committees_$cycle').removeClass('active');
			$('#page_ie_detail_$cycle').removeClass('active');
			$('#page_cand_graphs_$cycle').removeClass('active');
			$('#page_combined_graphs_$cycle').removeClass('active');";
//array_push($endjava, $js);




//DRAW PAGES

$candidates_page = "<div id='candidates_tab_$cycle' class='tabs tabs-style-bar' style='width: 100%; background-color: white;'>";
$candidates_page .= $page['candidates'];
$candidates_page .= "</div>";

$ie_detail_page = "<div id='ie_details_tab_$cycle' class='tabs tabs-style-bar' style='width: 100%; background-color: white;'>";
$ie_detail_page .= "<nav class='tab-bar'>
					<ul class='nav nav-tabs' role='tablist'>                 
                      <li><a href='#ie_cmte_totals_page_$cycle' data-toggle='tab' class='fa fa-lg fa-file-invoice-dollar'><span>CMTE TOTALS</span></a></li>
                      <li><a href='#ie_detail_table_page_$cycle' data-toggle='tab' class='fa fa-lg fa-file-invoice-dollar'><span>IE DETAIL</span></a></li>
                    </ul>
                    </nav>";
$ie_detail_page .= "<div class='tab-content'>";                    
$ie_detail_page .= "<div id='ie_cmte_totals_page_$cycle' align='center' class='tab-pane active'><h1>IE SUMMARY BY COMMITTEE</h1>" . $page['ie_cmte_totals'] . $page['ie_election_totals'] . "</div>";
$ie_detail_page .= "<div id='ie_detail_table_page_$cycle' align='center' class='tab-pane'><h1>INDEPENDENT EXPENDITURES FOR $master_fourcode ($cycle Cycle)<br>\$" . number_format($totals['grand_total']) . "</h1>$e_breakout" . $page['ie_detail'] . "</div>";
$ie_detail_page .= "</div>";
$ie_detail_page .= "</div>";

$candidate_committees_page = "<div id='cand_committees_tab_$cycle' class='tabs tabs-style-bar' style='width: 100%; background-color: white;'>";
$candidate_committees_page .= "<div class='container' align='center'><p align='center'>" . $table_head['cand_finances'] . $table_body['cand_finances'] . $table_end['cand_finances'] . "</p></div>";
$candidate_committees_page .= "</div>";

//echo($candidates_page);
//echo($ie_detail_page);

$end_draw = "<div class='container'>
				<div class='tabs tabs-style-bar' width='100%' style='background-color: white;'>
					<nav class='tab-bar' width='100%'>
						<ul class='nav nav-tabs' role='tablist'>
							<li><a href='#page_candidates_$cycle' data-toggle='tab' class='fa fa-lg fa-info-circle'><span>CANDIDATES</span></a></li>
							<li><a href='#page_candidate_committees_$cycle' data-toggle='tab' class='fa fa-lg fa-money-bill-wave'><span>CAND COMMITTEES</a></li>
							<li><a href='#page_ie_detail_$cycle' data-toggle='tab' class='fa fa-lg fa-comment-dollar'><span>IE DETAIL</span></a></li>
							<li><a href='#page_ie_graphs_$cycle' data-toggle='tab' class='fa fa-lg fa-chart-pie'><span>IE GRAPHS</span></a></li>
							<li><a href='#page_cand_graphs_$cycle' data-toggle='tab' class='fa fa-lg fa-chart-bar'><span>CAND GRAPHS</span></a></li>
							<li><a href='#page_combined_graphs_$cycle' data-toggle='tab' class='fa fa-lg fa-chart-line'><span>COMBINED GRAPHS</span></a></li>

						</ul>
					</nav>
					<div class='tab-content'>
						<div class='tab-pane' id='page_candidates_$cycle' style='background-color: white;'>
							$candidates_page
						</div>

						<div class='tab-pane ' id='page_candidate_committees_$cycle' style='background-color: white;'>
							$candidate_committees_page
						</div>

						<div class='tab-pane active' id='page_ie_detail_$cycle' style='background-color: white;'>
							$ie_detail_page
						</div>

						<div class='tab-pane ' id='page_ie_graphs_$cycle' style='background-color: white;'>
							$chart_divs
						</div>

						<div class='tab-pane ' id='page_cand_graphs_$cycle' style='background-color: white;'>
							$candidate_graphs_page
						</div>

						<div class='tab-pane ' id='page_combined_graphs_$cycle' style='background-color: white;'>
							$combined_graphs_page
						</div>						


					</div>
				</div>
			</div>";

//echo($end_draw);


//$end_draw .= "<script>";
$js = "
				  $( function() {
				    $( \"#page_candidates_$cycle\" ).tabs();
				  } );  

				  $( function() {
				    $( \"#page_candidate_committees_$cycle\" ).tabs();
				  } );  

				  $( function() {
				    $( \"#page_ie_detail_$cycle\" ).tabs();
				  } ); 

				  $( function() {
				    $( \"#page_ie_graphs_$cycle\" ).tabs();
				  } );  

				$( function() {
				    $( \"#page_cand_graphs_$cycle\" ).tabs();
				  } );

				  $( function() {
				    $( \"#page_combined_graphs_$cycle\" ).tabs();
				  } ); ";


array_push($endjava, $js);

$js = "

        <script src='js/app.js''></script>
        
        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
		<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script type='text/javascript' src='/js/jquery.smartmenus.bootstrap.js'></script>
        <script src='/js/jquery.quicksearch.js'></script>
        <script src='/js/jquery-listnav.min.js'></script>
        <script src='/js/jquery.tablesorter.min.js'></script>
";


echo($end_draw);

echo("<script>");

foreach($endjava as $x) {
	echo($x);
}

echo("</script>");





$output = ob_get_contents();

ob_end_clean();

if($year < 2019) {
        //Cache::forever($key_name, $output);
}

echo($output);  

function  get_federal_transactions($candidates, $fourcode) {
	global $master_conn, $cycle, $filing_arr, $filer_arr, $filer_name_arr, $short_cycle;
	$conn = Util::get_ctb_conn();
	$retval = Array();




	foreach($candidates as $c) {
		$naml = name_cleanup($c['cand_naml']);
		$name_query .= " can_nam LIKE \"" . $naml['cand_naml'] . "%\" ||";
	}
	$name_query = substr($name_query, 0, -2);	
	

	$table = "nufec_ie_" . $short_cycle;
	if(mb_substr($fourcode, 2, 3) == "SEN") {
		$office = "S";
		$query = " can_off = 'S' && can_off_sta = '" . mb_substr($fourcode, 0, 2) . "' ";
	} elseif($fourcode == "POTUS") {
		$office = "P";
		$query = " can_off = 'P'";
	} else {
		$office = "H";
		$query = " can_off = 'H' && can_off_sta = '" . mb_substr($fourcode, 0, 2) . "' && can_off_dis = '" . mb_substr($fourcode, 2, 2) . "' ";
	}

	$sql = "SELECT * FROM $table WHERE ( $query ) && ( $name_query )";	
	//$sql = mysqli_real_escape_string($conn, $sql);
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	$rand_tran = 1;
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$filing_id = $row['file_num'];
			$tran_id   = $row['tra_id'];
			if(!$tran_id) {
				$tran_id = "NA." . $rand_tran;
				$rand_tran++;
			}
			if($row['prev_file_num']) {
				$discarded_filing = $row['prev_file_num'];
				$discarded_filings[$discarded_filing] = $discarded_filing;
				//echo("<br>ADDING " . $row['prev_file_num'] . " to Discard array");
			}
			$tmp_arr[$filing_id][$tran_id] = $row;
		}
	}

	//echo("<br>TMP ARR:<br>");
	//var_dump($tmp_arr);
	foreach($discarded_filings as $filing_id) {
		//echo("<br>UNSETTING $filing_id");
		unset($tmp_arr[$filing_id]);
	}

	$blacklisted = Array("C00616078" => TRUE,//SAVE OUR JOBS PAC, INFLATES TRUMP IE TOTAL BY $50 MILLION
					      "C00746487" => TRUE, //SPIRIT OF AMERICA LUNATIC
					      "C00727552" => TRUE //SPIRIT OF AMERICA LUNATIC
						); 

	foreach($tmp_arr as $tran) {
		foreach($tran as $t) {

			$regex = '~(.*?)\,~mis';
			preg_match($regex, $t['can_nam'], $r);
			$tmp['cand_naml'] = $r[1];
			if($office == "P") {
				$tmp['fourcode'] = "POTUS";
				if($t['can_off_sta'] != "00" && $t['can_off_sta'] != '') {
					$tmp['fourcode'] .= "-" . $t['can_off_sta'];
				}
			} else {
				$tmp['fourcode'] = $fourcode;
			}

			$regex = '~.*?\,(.*)~mis';
			preg_match($regex, $t['can_nam'], $r);
			$tmp['cand_namf'] = $r[1];
			$tmp['cand_nm'] = $tmp['cand_namf'] . " " . $tmp['cand_naml'];


			$tmp['filing_id'] 		= $t['file_num'];
			$tmp['transaction_id'] 	= $t['tra_id'];
			$tmp['amount'] 			= decomma($t['exp_amo']);
			$tmp['exp_date'] 		= convert_date($t['exp_dat']);
			if(!$t['exp_dat'] || trim($t['exp_dat']) == '') {
				$tmp['exp_date'] = convert_date($t['rec_dat']);
			}

			$filer_id = $t['spe_id'];
			if($blacklisted[$filer_id]) {
				continue;
			}
			$tmp['dscr'] 			= $t['pur'];
			$tmp['vendor']			= $t['pay'];
			$tmp['filer_id'] 		= $t['spe_id'];
			$tmp['filer_nm']		= $t['spe_nam'];
			if($t['sup_opp'] == "S") {
				$tmp['position'] = "Support";
			} elseif($t['sup_opp'] == "O") {
				$tmp['position'] = "Oppose";
			} else {
				$tmp['position']		= $t['sup_opp'];
			}
			$tmp['election_type']   = $t['ele_typ'];
			array_push($retval, $tmp);

		}
	}
	//echo("<br>DUMP<br>");
	//var_dump($retval);
	return $retval;


}

function get_state_transactions($candidates, $fourcode) {
	global $master_conn, $cycle, $filing_arr, $filer_arr, $filer_name_arr;
	$conn = Util::get_ctb_conn();

	
	$convert = Array(
		".GOV"	=> "GOV",
		".LTG"	=> "LTG",
		".SOS"	=> "SOS",
		".ATG"	=> "ATT",
		".INS"	=> "INS",
		".SPI"	=> "SUP",
		".CON"	=> "CTR",
		".TRS"	=> "TRE"
		);

	switch($cycle) {
		case "2006":
			$min = "1069178";
			$max = "1225584";
			break;
		case "2008":
			$min = "1225585";
			$max = "1387268";
			break;
		case "2010":
			$min = "1387269";
			$max = "1556549";
			break;
		case "2012":
			$min = "1556450";
			$max = "1722116";
			break;
		case "2014":
			$min = "1722117";
			$max = "1922468";
			break;
		case "2016":
			$min = "1922469";
			$max = "2116204";
			break;
		case "2018":
			$min = "2116205";
			$max = "2331339";
			break;
		case "2020":
			$min = "2331440";
			$max = "2600000";
			break;
	}

	$retval = Array();
	$type = mb_substr($fourcode, 0, 2);					//CHECK FIRST TWO CHARACTERS OF FOURCODE
	$thisdist = mb_substr($fourcode, 2, 2);
	switch($type) {										//AND CHOOSE THE TYPE OF DISTRICT TO LOOK FOR IN THE FILING
		case "SD":
			$type = "SEN";
			break;
		case "AD":
			$type = "ASM";
			break;
		case "BO":
			$type = "BOE";
			$thisdist = mb_substr($fourcode, 3, 1);
			break;
		default:
			break;
	}

	if ($thisdist < 10) {
		$searchfor = $thisdist . "' OR DIST_NO = '" . mb_substr($thisdist, 1, 1);
	} else {
		$searchfor = $thisdist;
	}

	foreach($candidates as $c) {
		$query .= " CONCAT(CAND_NAMF, ' ', CAND_NAML) LIKE \"%" . $c['cand_naml'] . "%\" ||";
	}

	$query = substr($query, 0, -2);


	if($convert[$fourcode]) {
		$sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE OFFICE_CD = '" . $convert[$fourcode] . "' && ( $query ) && FORM_TYPE = 'F496' && (FILING_ID > '$min' && FILING_ID < '$max') ORDER BY FILING_ID DESC, AMEND_ID DESC ";
	} else {
		$sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE (DIST_NO = '" . $searchfor . "') && ( $query ) && FORM_TYPE = 'F496' && (FILING_ID > '$min' && FILING_ID < '$max') ORDER BY FILING_ID DESC, AMEND_ID DESC";
	}

	//$sql = mysqli_real_escape_string($conn, $sql);
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {


		while($row = $result->fetch_assoc()) {
			$this_filing = $row['FILING_ID'];
			$amend_id  = $row['AMEND_ID'];

			if($this_filing == $last_filing) {
				continue;
			}
			$filer_id = $row['FILER_ID'];
			$filer_nm = $row['FILER_NAML'];

			if($row['FILER_NAMF']) {
				$filer_nm = $row['FILER_NAMF'] . " " . $row['FILER_NAML'];
			}
			if($row['CAND_NAMF']) {
				$cand_nm = $row['CAND_NAMF'] . " " . $row['CAND_NAML'];
			} else {
				$cand_nm = $row['CAND_NAML'];
			}
			$x = name_cleanup($cand_nm);
			$position = $row['SUP_OPP_CD'];

			if($position == "S") {
				$position = "Support";
			} elseif($position == "O") {
				$position = "Oppose";
			}

			//echo("<br>SEEDING FILING ARR WITH $this_filing/$this_filing-$amend_id ($filer_nm #$filer_id), $position $cand_nm");

			$filing_arr[$this_filing]['filing_id'] = $this_filing;
			$filing_arr[$this_filing]['amend_id']  = $amend_id;
			$filing_arr[$this_filing]['cand_nm'] = $cand_nm;
			$filing_arr[$this_filing]['cand_namf'] = $x['cand_namf'];
			$filing_arr[$this_filing]['cand_naml'] = $x['cand_naml'];
			$filing_arr[$this_filing]['position'] = $position;
			$filing_arr[$this_filing]['filer_id'] = $filer_id;
			$filing_arr[$this_filing]['filer_nm'] = $filer_nm;
			$filing_arr[$this_filing]['fourcode'] = $fourcode;

			$filer_arr[$filer_id][$this_filing]['filing_id'] = $this_filing;
			$filer_arr[$filer_id][$this_filing]['amend_id']  = $amend_id;
			$filer_arr[$filer_id][$this_filing]['cand_nm'] = $cand_nm;
			$filer_arr[$filer_id][$this_filing]['cand_namf'] = $cand_namf;
			$filer_arr[$filer_id][$this_filing]['cand_naml'] = $cand_naml;
			$filer_arr[$filer_id][$this_filing]['position'] = $position;

			$filer_name_arr[$filer_id] = $filer_nm;

			$last_filing = $this_filing;

		}
	}

	if($filing_arr) {
		//echo("<br>Retrieving Transactions<br>");
		$transactions = get_f496_items($filing_arr);
	}
	//var_dump($transactions);
	return $transactions;

}

function classify_expense($exp_date) {
	global $cycle;
	switch($cycle) {
		case "2006":
			$min 	= "2005-01-01";
			$cutoff = "2006-07-01";
			break;
		case "2008":
			$min 	= "2007-01-01";
			$cutoff = "2008-07-01";
			break;
		case "2010":
			$min 	= "2009-01-01";
			$cutoff = "2010-07-01";
			break;
		case "2012":
			$min 	= "2011-01-01";
			$cutoff = "2012-07-01";
			break;
		case "2014":
			$min 	= "2013-01-01";
			$cutoff = "2014-07-01";
			break;
		case "2016":
			$min 	= "2015-01-01";
			$cutoff = "2016-07-01";
			break;
		case "2018":
			$min 	= "2017-01-01";
			$cutoff = "2018-07-01";
			break;
		case "2020":
			$min 	= "2019-01-01";
			$cutoff = "2020-04-01";
			break;
	}

	if($exp_date > $min && $exp_date < $cutoff) {
		return "P";
	} else {
		return "G";
	}

}

function get_f496_items($filing_arr) {
	$conn = Util::get_ctb_conn();
	$retval = Array();

	
	foreach($filing_arr as $filing_id => $f) {
		$amend_id = $f['amend_id'];
		$query .= " (FILING_ID = $filing_id && AMEND_ID = $amend_id) ||";
	}
	$query = substr($query, 0, -2);
	$sql = "SELECT * FROM calaccess_raw_S496_CD WHERE ( $query ) ORDER BY FILING_ID";
	
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['filing_id'] 		= $row['FILING_ID'];
			$tmp['line_item'] 		= $row['LINE_ITEM'];
			$tmp['transaction_id'] 	= $row['TRAN_ID'];
			$tmp['amount'] 			= $row['AMOUNT'];
			$tmp['exp_date'] 		= $row['EXP_DATE'];
			$tmp['dscr'] 			= $row['EXPN_DSCR'];
			$tmp['cand_nm'] 		= $filing_arr[$row['FILING_ID']]['cand_nm'];
			$tmp['cand_namf'] 		= $filing_arr[$row['FILING_ID']]['cand_namf'];
			$tmp['cand_naml'] 		= $filing_arr[$row['FILING_ID']]['cand_naml'];
			$tmp['filer_id'] 		= $filing_arr[$row['FILING_ID']]['filer_id'];
			$tmp['filer_nm']		= $filing_arr[$row['FILING_ID']]['filer_nm'];
			$tmp['position']		= $filing_arr[$row['FILING_ID']]['position'];
			$tmp['fourcode']		= $filing_arr[$row['FILING_ID']]['fourcode'];
			$tmp['election_type']   = classify_expense($row['EXP_DATE']);
			array_push($retval, $tmp);
		}
	}
	return $retval;
}


function get_candidates($fourcode, $cycle, $usestate, $usefed) {
	global $master_conn, $short_cycle, $cycle_yr1, $cycle_yr2;
	$conn = Util::get_ctb_conn();
	$convert = Array(
		".GOV"	=> "GOV",
		".LTG"	=> "LTG",
		".SOS"	=> "SOS",
		".ATG"	=> "ATG",
		".INS"	=> "INS",
		".SPI"	=> "SPI",
		".CON"	=> "CON",
		".TRS"	=> "TRS"
		);


	$retval = Array();
	if($usestate) {
		if($cycle > 2018) {
			$sql = "SELECT * FROM calaccess_raw_e20_comm WHERE fourcode = '$fourcode' && hide != 1 GROUP BY cand_id";
			$result = $conn->query($sql);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					$tmp['cand_naml'] = $row['naml'];
					$tmp['cand_namf'] = $row['namf'];
					$tmp['cand_nm']   = $row['namf'] . " " . $row['naml'];
					$tmp['cand_party'] = $row['party'];
					$tmp['cand_ici'] = $row['is_inc'];
					$tmp['cand_id'] = $row['cand_id'];
					array_push($retval, $tmp);
				}
			}
		} else {
			$first_two = mb_substr($fourcode, 0, 2);
			switch($first_two) {
				case "AD":
					$query = "disttype = 'addist' && distnum = " . mb_substr($fourcode, 2, 2);
					break;
				case "SD":
					$query = "disttype = 'sddist' && distnum = " . mb_substr($fourcode, 2, 2);
					break;
				case "BO":
					$query = "disttype = 'bedist' && distnum = " . mb_substr($fourcode, 3, 1);
					break;
				default:
					$query = '';
			}
			if(!$query) {
				//NOT AN ASSEMBLY, SENATE, OR CONGRESSIONAL DISTRICT, BUT STILL A STATE LEVEL RACE. CHECK EXECUTIVE OFFICES
				if($convert[$fourcode]) {
					$query = "race LIKE '" . $convert[$fourcode] . "%'";
				}
			}

			$sql = "SELECT * FROM ctb_ca_candidates WHERE ( $query ) && (election = 'p" . $short_cycle . "' || election = 'g" . $short_cycle . "') GROUP BY cand_id";
			$result = $conn->query($sql);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					//REMOVE ALL INSTANCES OF III, Jr., Sr., commas
					$x = name_cleanup($row['name']);
					$tmp['cand_namf'] = $x['cand_namf'];
					$tmp['cand_naml'] = $x['cand_naml'];
					$tmp['cand_nm'] = $x['cand_nm'];
					$tmp['cand_party'] = $row['party'];
					$tmp['cand_ici'] = $row['is_incumbent'];
					$tmp['cand_id'] = $row['cand_id'];
					array_push($retval, $tmp);
				}
			}

		}

	} elseif($usefed) {
		$table = "nufec_cn_" . $short_cycle;
		if(mb_substr($fourcode, 2, 3) == "SEN") {
			$office = "S";
			$query = " CAND_OFFICE = 'S' && CAND_OFFICE_ST = '" . mb_substr($fourcode, 0, 2) . "' ";
		} elseif($fourcode == "POTUS") {
			$office = "P";
			$query = " CAND_OFFICE = 'P'";
		} else {
			$office = "H";
			$query = " CAND_OFFICE = 'H' && CAND_OFFICE_ST = '" . mb_substr($fourcode, 0, 2) . "' && CAND_OFFICE_DISTRICT = '" . mb_substr($fourcode, 2, 2) . "' ";
		}

		$sql = "SELECT * FROM $table WHERE ( $query ) && (CAND_ELECTION_YR = $cycle_yr1 || CAND_ELECTION_YR = $cycle_yr2)";
		//echo("<br>$sql<br>");
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$regex = '~(.*?)\,~mis';
				preg_match($regex, $row['CAND_NAME'], $r);
				$tmp['cand_naml'] = $r[1];

				$regex = '~.*?\,(.*)~mis';
				preg_match($regex, $row['CAND_NAME'], $r);
				$tmp['cand_namf'] = $r[1];

				$tmp['cand_nm'] = $tmp['cand_namf'] . " " . $tmp['cand_naml'];
				$tmp['cand_party'] = $row['CAND_PTY_AFFILIATION'];
				$tmp['cand_ici']   = $row['CAND_ICI'];
				$tmp['cand_id']    = $row['CAND_ID'];
				array_push($retval, $tmp);
			}
		}

	}
	return $retval;
}

function datesort($a, $b) {
	if($a['DATE'] < $b['DATE']) {
		return -1;
	} elseif ($a['DATE'] > $b['DATE']) {
		return 1;
	} else {
		return 0;
	}
}

function totalsort($a, $b) {
	if($a['ALL']['TOTAL'] < $b['ALL']['TOTAL']) {
		return 1;
	} elseif ($a['ALL']['TOTAL'] > $b['ALL']['TOTAL']) {
		return -1;
	} else {
		return 0;
	}
}

function election_sort($a, $b) {
	if($a['TOTAL'] < $b['TOTAL']) {
		return 1;
	} elseif ($a['TOTAL'] > $b['TOTAL']) {
		return -1;
	} else {
		return 0;
	}
}



function convert_date($string) {
	if(mb_substr($string, 2, 1) == "/" && mb_substr($string, 5, 1) == "/") {
		//GOT MM/DD/YYYY FORMAT
		$day = mb_substr($string, 3, 2);
		$month = mb_substr($string, 0, 2);
		$year = mb_substr($string, 6, 4);
		$return_date = $year . "-" . $month . "-" . $day;
	} else {
		$day = mb_substr($string, 0, 2);
		$month_text = mb_substr($string, 3, 3);
		$year = "20" . mb_substr($string, 7, 3);
		switch($month_text) {
			case "JAN":
				$month = "01";
				break;
			case "FEB":
				$month = "02";
				break;
			case "MAR":
				$month = "03";
				break;
			case "APR":
				$month = "04";
				break;
			case "MAY":
				$month = "05";
				break;
			case "JUN":
				$month = "06";
				break;
			case "JUL":
				$month = "07";
				break;
			case "AUG":
				$month = "08";
				break;
			case "SEP":
				$month = "09";
				break;
			case "OCT":
				$month = "10";
				break;
			case "NOV":
				$month = "11";
				break;
			case "DEC":
				$month = "12";
				break;
		}
		$return_date = $year . "-" . $month . "-" . $day;
	}
	return $return_date;
}



function name_cleanup($name) {
	//echo("<br>Processing $name...Removing *....");
	$tmp_nm = rtrim($name, "*"); 		//REMOVE INCUMBENT ASTERICKS
	//echo($tmp_nm . "...Uppercase...");
	$tmp_nm = strtoupper($tmp_nm);		//MAKE ALL UPPERCASE
	//echo($tmp_nm . "...Jr...");
	$tmp_nm = str_replace(" JR", "", $tmp_nm);  //THEN REMOVE INSTANCES OF JR., SR., II, and III
	//echo($tmp_nm . "...Sr...");
	$tmp_nm = str_replace(" SR", "", $tmp_nm);
	//echo($tmp_nm . "...II...");
	$tmp_nm = str_replace(" II", "", $tmp_nm);
	//echo($tmp_nm . "...III...");
	$tmp_nm = str_replace(" III", "", $tmp_nm);
	$tmp_nm = str_replace("(I)", "", $tmp_nm);
	$tmp_nm = str_replace(",", "", $tmp_nm);
	$tmp_nm = str_replace(".", "", $tmp_nm);
	//$tmp_nm = str_replace("'", "", $tmp_nm);
	$tmp_nm = str_replace('"', "", $tmp_nm);
	//echo("...Extracting Last Name...");

	$arr = explode(" ", $tmp_nm);
	foreach($arr as $x) {
		if(!$retval['cand_namf']) {
			$retval['cand_namf'] = trim($x);
		}
		$retval['cand_naml'] = trim($x);
	}

	$retval['cand_nm'] = $retval['cand_namf'] . " " . $retval['cand_naml'];

	
	return $retval;
}

function decomma($string) {
	$tmp_amt = str_replace("$", "", $string);
	$tmp_amt = str_replace(",", "", $tmp_amt);
	return $tmp_amt;
}

function get_cand_img($cand_id) {
    $suffix = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
   
    foreach ($suffix as $s) {
        if (file_exists('img/candidates/' . $cand_id . $s)) {
            $add_img = "<img src=\"/img/candidates/" . $cand_id . $s . "\" width='125px' class='img-responsive img-thumbnail' />";
            //echo("GOT MATCH with $cand_id" . $s);
            break;
        } else {
            $add_img = '';
        }
    }

    return $add_img;
}

function get_federal_committees($candidates, $fourcode) {
	global $master_conn, $cycle, $short_cycle;
	$conn = Util::get_ctb_conn();
	foreach($candidates as $c) {
		$query .= " cand_id = '" . $c['cand_id'] . "' ||";
	}
	$query = substr($query, 0, -2);
	$sql = "SELECT * FROM nufec_fed_candidates WHERE ( $query ) && cycle = '$cycle'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_id = $row['cand_id'];
			$cmte_id = trim($row['cmte_id']);
			$cand_nm = $row['cand_nm'];
			$fourcode = $row['fourcode'];
			$party = $row['party'];
			$filed  = $row['filed'];

			$retval[$cand_id]['cand_id'] = $cand_id;
			$retval[$cand_id]['cmte_id'] = $cmte_id;
			$retval[$cand_id]['cand_nm'] = $cand_nm;
			$retval[$cand_id]['filed']   = $filed;
			$retval[$cand_id]['party']   = $party;
			$retval[$cand_id]['fourcode'] = $fourcode;
			if($cmte_id) {
				$ccl[$cmte_id] = $cand_id;
			} else {
				$missing[$cand_id] = $cand_id;
			}
		}
	}

	if($missing) {
		$query = '';
		foreach($missing as $cand_id) {
			$query .= " CAND_ID = '$cand_id' ||";
		}
		$query = substr($query, 0, -2);
		$table = "nufec_ccl_" . $short_cycle;
		$sql = "SELECT * FROM $table WHERE ( $query ) && ( CAND_ELECTION_YR = $cycle )";
		//echo("<br>$sql<br>");
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$cand_id = $row['CAND_ID'];
				$cmte_id = $row['CMTE_ID'];
				$retval[$cand_id]['cmte_id'] = $cmte_id;
				$ccl[$cmte_id] = $cand_id;
			}
		}
	}
	//$retval contains candidate, committee stuff, now get the cycle amounts

	$query = '';

	foreach($ccl as $cmte_id => $cand_id) {
		$query .= "CAND_ID = '$cand_id' ||";
	}
	$query = substr($query, 0, -2);

	$table = "nufec_weball_" . $short_cycle;
	$sql = "SELECT * FROM $table WHERE ($query )";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_id = $row['CAND_ID'];
			$rcpt    = $row['TTL_RECEIPTS'];
			$loan    = $row['CAND_LOANS'];
			$expn    = $row['TTL_DISB'];
			$pd_end  = convert_date($row['CVG_END_DT']);
			$coh_end = $row['COH_COP'];
			$debt    = $row['DEBTS_OWED_BY'];
			
			$retval[$cand_id]['cmte_nm'] = $cmte_nm;
			$retval[$cand_id]['rcpt']	 = $rcpt;
			$retval[$cand_id]['expn']	 = $expn;
			$retval[$cand_id]['loan']	 = $loan;
			$retval[$cand_id]['coh']	 = $coh_end;
			$retval[$cand_id]['debt']	 = $debt;
			$retval[$cand_id]['pd_end']  = $pd_end;

		}
	}

	$query = '';
	foreach($ccl as $cmte_id => $cand_id) {
		$query .= " CMTE_ID = '$cmte_id' ||";
	}
	$query = substr($query, 0, -2);
	$table = "nufec_cm_" . $short_cycle;
	$sql = "SELECT CMTE_NM, CMTE_ID FROM $table WHERE ( $query )";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cmte_nm = $row['CMTE_NM'];
			$cmte_id = $row['CMTE_ID'];
			$cand_id = $ccl[$cmte_id];
			$retval[$cand_id]['cmte_nm'] = $cmte_nm;
		}
	}

	//var_dump($retval);
	return $retval;


}

function get_state_committees($candidates, $fourcode) {
	global $master_conn, $cycle, $cand_ccl;
	$conn = Util::get_ctb_conn();
	foreach($candidates as $c) {
		$query .= " cand_id = '" . $c['cand_id'] . "' ||";
	}
	$query = substr($query, 0, -2);
	$sql = "SELECT * FROM ctb_ca_ccl WHERE ( $query ) && cmte_nm LIKE '%$cycle%'";
	$result = $conn->query($sql);
	if($result->num_rows  > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_id = $row['cand_id'];
			$cmte_id = $row['cmte_id'];
			$cmte_nm = $row['cmte_nm'];

			$retval[$cand_id]['cmte_nm'] = $cmte_nm;
			$retval[$cand_id]['cand_id'] = $cand_id;
			$retval[$cand_id]['cmte_id'] = $cmte_id;
			$retval[$cand_id]['cand_nm'] = $cand_ccl[$cand_id]['cand_nm'];
			$retval[$cand_id]['party']   = $cand_ccl[$cand_id]['party'];

			$ccl[$cmte_id] = $cand_id;
		}
	}

	//GET F460 FILINGS
	$query = '';
	foreach($ccl as $cmte_id => $cand_id) {
		$query .= " FILER_ID = '$cmte_id' ||";
	}
	$query = substr($query, 0, -2);

	$sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FORM_ID = 'F460' && ( $query ) && PERIOD_ID != 0 ORDER BY FILING_ID, FILING_SEQUENCE DESC";

	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cmte_id   = $row['FILER_ID'];
			$filing_id = $row['FILING_ID'];
			$amend_id  = $row['FILING_SEQUENCE'];
			$pd_start  = $row['RPT_START'];
			$pd_end    = $row['RPT_END'];
			$cand_id  = $ccl[$cmte_id];
			$cmte_nm = $retval[$cand_id]['cmte_nm'];

			$filing_arr[$filing_id]['cmte_id'] = $cmte_id;
			$filing_arr[$filing_id]['amend_id'] = $amend_id;
			$filing_arr[$filing_id]['filing_id'] = $filing_id;
			$filing_arr[$filing_id]['pd_start']  = $pd_start;
			$filing_arr[$filing_id]['pd_end'] = $pd_end;

			if($pd_end > $filer_last[$cmte_id]['pd_end']) {
				//echo("<br>CURRENT $pd_end from $filing_id > " . $filer_last[$cmte_id]['pd_end'] . ", setting $cmte_nm most recent.");
				$filer_last[$cmte_id]['pd_end'] = $pd_end;
				$filer_last[$cmte_id]['filing_id'] = $filing_id;
			}

			$filer_arr[$cmte_id][$filing_id] = $filing_id;

			$filer_lnk[$filing_id]['cmte_id'] = $cmte_id;
			$filer_lnk[$filing_id]['cand_id'] = $ccl[$cmte_id];
		}
	}


	//GET SUMMARY DATA FROM ALL FILINGS

	$query = '';
	foreach($filing_arr as $filing_id => $f) {
		$query .= " (FILING_ID = '$filing_id' && AMEND_ID = '" . $f['amend_id'] . "' ) ||";
	}
	$query = substr($query, 0, -2);

	$sql = "SELECT * FROM calaccess_raw_SMRY_CD WHERE  ( $query ) && FORM_TYPE = 'F460' && (LINE_ITEM = 1 || LINE_ITEM = 4 || LINE_ITEM = 5 || LINE_ITEM = 11 || LINE_ITEM = 12 || LINE_ITEM = 16 || LINE_ITEM = 19) ORDER BY FILING_ID, FORM_TYPE, LINE_ITEM";

	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$filing_id = $row['FILING_ID'];
			$cand_id = $filer_lnk[$filing_id]['cand_id'];
			$cmte_id = $filer_lnk[$filing_id]['cmte_id'];
			$cmte_nm = $retval[$cand_id]['cmte_nm'];

			switch($row['LINE_ITEM']) {
				case "5":
					$rcpt = $row['AMOUNT_A'];
					$retval[$cand_id]['rcpt'] += $rcpt;
					break;
				case "11":
					$expn = $row['AMOUNT_A'];
					$retval[$cand_id]['expn'] += $expn;
					break;
				case "16":
					$coh_end = $row['AMOUNT_A'];
					if($filer_last[$cmte_id]['filing_id'] == $filing_id) {
						//echo("<br>SETTING COH FOR $cmte_nm to $coh_end from $filing_id, filer_last for $cmte_id is #" . $filer_last[$cmte_id]['filing_id'] . " ending " . $filer_last[$cmte_id]['pd_end']);
						$retval[$cand_id]['coh']  = $coh_end;
					}
					break;
				case "19":
					$debt = $row['AMOUNT_A'];
					if($filer_last[$cmte_id]['filing_id'] == $filing_id) {
						$retval[$cand_id]['debt'] = $debt;
						$retval[$cand_id]['pd_end'] = $filer_last[$cmte_id]['pd_end'];
					}					
					break;
			}

		}
	}
	return $retval;
}

?>

@endsection

@section('scripts')

<script>

<?php


?>

</script>

@endsection





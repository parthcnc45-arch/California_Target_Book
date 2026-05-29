
@php ($book_side_nav_active = 'recall')

@extends('layouts.book')


@section('title', '2021 Recall of Gov. Gavin Newsom | California Target Book')

@section('content')



<?php

global $propid_arr, $propno_arr, $prop_cmtes, $cmte_index, $last_reports, $filing_form_index, $filer_filing_form_index, $transactions, $recall_cmtes;

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//require_once("php/ctb_api.php");
Util::require_ctb_api();

$recall_cmtes = Array(
	"1424018" => "CALIFORNIA PATRIOT COALITION - RECALL GOVERNOR GAVIN NEWSOM",
	"1434853" => "RESCUE CALIFORNIA-RECALL GAVIN NEWSOM",
	"1436851" => "STOP THE REPUBLICAN RECALL OF GOVERNOR NEWSOM",
	"1437098" => "RECALL NEWSOM! REPUBLICAN GOVERNORS ASSOCIATION ACTION",
	"1435892" => "CAREGIVERS AND CALIFORNIANS UNITED AGAINST THE RECALL OF GOVERNOR NEWSOM, SPONSORED BY THE NATIONAL UNION OF HEALTHCARE WORKERS",
	"1437408" => "STOP THE STEAL CALIFORNIA, OPPOSING THE RECALL OF GAVIN NEWSOM",
	"1437054" => "FUND FOR A BETTER CALIFORNIA, PRIMARILY FORMED TO SUPPORT KEVIN FAULCONER FOR GOVERNOR 2022",
	"1437864" => "CLEAN UP CALIFORNIA, KEVIN FAULCONER'S BALLOT MEASURE COMMITTEE TO RECALL GAVIN NEWSOM",
	"1439907" => "LARRY ELDER BALLOT MEASURE COMMITTEE RECALL NEWSOM",
	"1439011" => "CAITLYN JENNER'S BALLOT MEASURE COMMITTEE TO SUPPORT RECALL OF GAVIN NEWSOM",

);

get_finances();

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

$sections = Array(
	"OVERVIEW" => "home",
	"FINANCES" => "local_atm" ,
	"CANDIDATES" => "groups",
	"SIGNATURES" => "mode", 
	"TIMELINE" => "access_time",
	"NEWS" => "event_note"
);


$enddraw = "<div class='content-wrap pt-xl'>";
foreach($sections as $section => $icon) {
    $count++;

    if($count == 1) {
        $active_class = 'active';
    } else {
        $active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$section' role='tab' data-toggle='tab' class='header_icon'>
                        <i class='material-icons header_icon'>$icon</i>
                        $section
                    </a>
                  </li>";



    $enddraw .= "<section id='p$section' class='$active_class'> ";
    $enddraw .= "<div class='prop_div' align='center'>";
    $enddraw .= "<h2>$section</h2>";


    //var_dump($x);

    if($section == "FINANCES") {

    	$last = get_last_dl_time();
    	$enddraw .= "<h4 align='center'>Cal-Access Database Updated " . $last['modified'] . "<br>" . $last['modified_elapsed'] . "</h4>";

	    foreach($recall_cmtes as $cmte_id => $cmte_nm) {     
	        $class = $pc['cmte_position'];
	        $cmte_url = "<a href='https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>$cmte_id</a>";
	        $enddraw .= "<div class='cmte_div'>";
	        $enddraw .= "<h5 class='$class'>" . $cmte_nm . "<br>" . $cmte_url . "</h5>";
	        //$enddraw .= "<br>F460<br>";
			$thisid = 'c' . $cmte_id;


	        $f460_table = "<p align='center'>FINANCE REPORTS</p>
	                        <table class='f460_table cust_striped'>
	                            <thead class='inverse'>
	                                <tr>
	                                    <th>FILING</th>
	                                    <th>MONETARY</th>
	                                    <th>NONMONETARY</th>
	                                    <th>RCPT</th>
	                                    <th>PAYMENTS</th>
	                                    <th>ACCRUED</th>
	                                    <th>EXPN</th>
	                                    <th>COH</th>
	                                    <th>DEBT</th>
	                                    <th>PD END</th>
	                                </tr>
	                            </thead>
	                            <tbody>";
	        $rcpt_tot = 0;
	        $expn_tot = 0;   
	        $f460_entries = 0;                         
	        $pd_end = '';
	        $coh = 0;
	        foreach($filer_filing_form_index[$cmte_id]['F460'] as $filing_id => $ignore) {

	            //var_dump($transactions['F460'][$filing_id]);
	            
	            $f460_entries++;

	            $filing_url = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=$filing_id' target='_blank'>$filing_id</a>";

	            $monetary       = $transactions['F460'][$filing_id][1]['AMOUNT_A'];
	            $nonmonetary    = $transactions['F460'][$filing_id][4]['AMOUNT_A'];
	            $rcpt           = $transactions['F460'][$filing_id][5]['AMOUNT_A'];
	            $payments       = $transactions['F460'][$filing_id][6]['AMOUNT_A'];
	            $accrued        = $transactions['F460'][$filing_id][9]['AMOUNT_A'];
	            $expn           = $transactions['F460'][$filing_id][11]['AMOUNT_A'];
	            $debt           = $transactions['F460'][$filing_id][19]['AMOUNT_A'];
	            $coh            = $transactions['F460'][$filing_id][16]['AMOUNT_A'];
	            $pd_end         = $filer_filing_form_index[$cmte_id]['F460'][$filing_id]['RPT_END'];
	            $rcpt_tot += $rcpt;
	            $expn_tot += $expn;

	            $f460_table .= "<tr>
	                                <td>" . $filing_url . "</td>
	                                <td align='right'>" . number_format($monetary) . "</td>
	                                <td align='right'>" . number_format($nonmonetary) . "</td>
	                                <td align='right'>" . number_format($rcpt) . "</td>
	                                <td align='right'>" . number_format($payments) . "</td>
	                                <td align='right'>" . number_format($accrued) . "</td>
	                                <td align='right'>" . number_format($expn) . "</td>
	                                <td align='right'>" . number_format($coh) . "</td>
	                                <td align='right'>" . number_format($debt) . "</td>
	                                <td align='right'>" . $pd_end . "</td>
	                            </tr>";


	            //$enddraw .= "$filing_id - ";
	        }
	        $f460_table .= "</tbody></table>";

	        if($f460_entries < 1) {
	            $f460_table = '';
	        }


	        $since_tot = 0;

			$js = "$(document).ready(function() {
				    $('#$thisid').tablesorter({ 
				            headers: {2: {
								sorter: 'fancyNumber'
							}
						    } 
				        });
				});";
			array_push($endjava, $js);


	        $f497_table = "<p align='center'>LATE CONTRIBUTIONS RECEIVED</p>
	                        <table class='cust_striped f497_table' id='$thisid'>
	                            <thead class='inverse'>
	                                <tr>
	                                    <th>FILING</th>
	                                    <th>TRAN DT</th>
	                                    <th>AMOUNT</th>
	                                    <th>CONTRIBUTOR</th>
	                                    <th>CITY</th>
	                                    <th>STATE</th>
	                                    <th>EMPLOYER</th>
	                                    <th>OCCUPATION</th>
	                                </tr>
	                            </thead>
	                            <tbody>";        

	        $f497_entries = 0;
	        foreach($filer_filing_form_index[$cmte_id]['F497'] as $filing_id => $ignore) {   
	            foreach($transactions['F497'][$filing_id] as $t) {
	                $contributor = '';
	                $f497_entries++;

	                $filing_url = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=$filing_id' target='_blank'>$filing_id</a>";

	                if($t['ENTY_NAML']) {
	                    $contributor = $t['ENTY_NAML'];
	                }

	                if($t['ENTY_NAMF']) {
	                    $contributor .= ", " . $t['ENTY_NAMF'];
	                }


	                $f497_table .= "<tr>
	                                    <td>" . $filing_url . "</td>
	                                    <td>" . $t['CTRIB_DATE'] . "</td>
	                                    <td align='right'>" . number_format($t['AMOUNT']) . "</td>
	                                    <td>" . $contributor . "</td>
	                                    <td>" . $t['ENTY_CITY'] . "</td>
	                                    <td>" . $t['ENTY_ST'] . "</td>
	                                    <td>" . $t['CTRIB_EMP'] . "</td>
	                                    <td>" . $t['CTRIB_OCC'] . "</td>
	                                </tr>";
	                $since_tot += $t['AMOUNT'];
	            }                         

	        }
	        $f497_table .= "</tbody></table>";


	        if($f497_entries < 1) {
	            $f497_table = '';
	        }

	        $enddraw .= "<p align='center'>RAISED: <span class='emph'>\$" . number_format($rcpt_tot + $since_tot) . "</span> (<span class='emph'>\$" . number_format($since_tot) . "</span> Since $pd_end) SPENT: <span class='emph'>\$" . number_format($expn_tot) . "</span> LAST COH: <span class='emph'>\$" . number_format($coh) .  "</span>" . $f460_table . $f497_table . "</p>";
	        //$enddraw .= "<br>F497<br>";
	 
	        $enddraw .= "</div>";
	    }


    } elseif($section == "SIGNATURES") {
    	$sigs = get_sig_table();

    	$sigtable = $sigs['table'];
    	$enddraw .= "<h2 align='center'>" . number_format($sigs['sigs_total']) . " Signatures Submitted</h2>
    				 <h4 align='center'>" . number_format($sigs['sigs_verified']) . " verified, " . number_format($sigs['sigs_valid']) . " valid, " . number_format($sigs['sigs_invalid']) . " invalid<br>
    				 Valid Recall Signatures Needed:  1,495,709<br> 
				 Valid Recall Signatures Remaining: " . number_format(1495709 - $sigs['sigs_valid']) . "<br>	
    				 Percent Verified as Valid: " . $sigs['sigs_percent'] . "%<br>
				 Signatures Submitted But Not Yet Verified: " . number_format($sigs['sigs_total'] - $sigs['sigs_verified']) . "</h4>";
    	$enddraw .= "<p align='center'>
    					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-first-report.pdf' target='_blank'>Report 1</a>  |  
    					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-second.pdf' target='_blank'>Report 2</a>  |  
    					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-third.pdf' target='_blank'>Report 3</a>  |  
    					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-fourth.pdf' target='_blank'>Report 4</a>  |  
    					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-fifth.pdf' target='_blank'>Report 5</a>  |  
    					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-sixth.pdf' target='_blank'>Report 6</a>  |  								<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-seventh.pdf' target='_blank'>Report 7</a>  |  
					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-heatlie-eighth.pdf' target='_blank'>Report 8</a>

    					<br>
					<a href='https://elections.cdn.sos.ca.gov/recalls/cumulative-newsom-heatlie.pdf' target='_blank'>CUMULATIVE  |  
    					<a href='https://elections.cdn.sos.ca.gov/recalls/newsom-calendar.pdf' target='_blank'>CALENDAR</a>  |  
					<a href='https://www.sos.ca.gov/elections/recalls/current-recall-efforts' target='_blank'>SoS RECALL PAGE</a>

    					</p>" . $sigtable;
    } elseif ($section == "OVERVIEW") {
    	$text = get_recall_analysis();
    	$enddraw .= "<div class='panel justifyme'>
    				<p style = 'text-align: justify !important;'>";
    	$enddraw .= $text;
    	$enddraw .= "</p>
    				 </div>";
    	
    } elseif($section == "TIMELINE") {
    	$text = get_timeline_analysis();
    	$enddraw .= "<div class='panel justifyme'>
    				<p style = 'text-align: justify !important;'>";
    	$enddraw .= $text;
    	$enddraw .= "</p>
    				 </div>";    	
    } elseif($section == "CANDIDATES") {
		$text = '';

		$ballot_table = get_recall_ballot();


		$si_table = get_si();
		$filed_table = get_filed(".GOV", "2021");
		

	    $candidates_filed = get_filed(".GOV", $year);
    	//$ballot = get_ballot($fourcode, $year);


    	$enddraw .= "<div class='panel justifyme'>
    				<p style = 'text-align: justify !important;'>
				<p align='center'>PRELIMINARY BALLOT</p>
				$ballot_table

				<p align='center'>STATEMENTS OF INTENTION</p>
				$si_table
				<p align='center'>CANDIDATE FILING STATUS</p>
				$filed_table";
    	$enddraw .= "</p>
    				 </div>";   

    } elseif($section == "NEWS") {

	$recall_links = get_recall_items();
	$enddraw .= "<div class='panel justifyme'>
			<h3 align='left'>RECALL WATCH UPDATES</h3>
			<hr />
			$recall_links
		    </div>";

    }
    $enddraw .=  "</div>";
    $enddraw .= "</section>";
}


//var_dump($chart);

echo("<div class='container-fluid pt-xl'>
        <h1>2021 Gavin Newsom Recall Effort</h1>
        <div class='row'>
            <div class='col-lg-10 center-block fn'>
                <nav class='clearfix page-nav'>
                    <ul class='clearfix'>
                        $nav_draw
                    </ul>
                </nav>
            </div>

            $enddraw
        </div>
    </div>");

//echo($enddraw);

function get_recall_ballot() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT fourcode, namf, namm, naml, party, cand_id, cmte_id, website, ballot_dscr FROM ctb_r21_ballots ORDER BY party, naml, namf";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_nm = $row['naml'] . ", " . $row['namf'] . " " . $row['namm'];
			$cand_id = $row['cand_id'];
			$cmte_id = $row['cmte_id'];
			$dscr = $row['ballot_dscr'];
			$url = $row['website'];

			if(!$row['naml']) {
				$cand_nm = $row['namf'];
			}

			if(!$dscr) {
				$dscr = "N/A";
			}

			if($cmte_id) {
				$cmte_id_field = "<a href='/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>$cmte_id</a>";
			} else { 
				$cmte_id_field = "No Cmte";
			}

			if($cand_id) {
				$cand_id_field = "<a href='https://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=$cand_id' target='_blank'>$cand_id</a>";
			} else {
				$cand_id_field = "No FPPC ID";
			}

			if($url) {
				$website_field = "<a href='http://$url' target='_blank'>$url</a>";
			} else {
				$website_field = '';
			}

			$count[$row['party']]++;
			$all_count++;

			switch($row['party']) {
				case "R":
					$class = 'redme boldme';
					break;
				case "D":
					$class = 'blueme boldme';
					break;
				case "Grn":
					$class = 'greenme boldme';
					break;
				case "Lib":
					$class = 'orangeme boldme';
					break;
				case "NPP":
					$class = '';
					break;
				default:
					$class = '';
					break;
			}

			$table_body .= "<tr class='$class'>
						<td>$cand_nm</td>
						<td>" . $row['party'] . "</td>
						<td>$cand_id_field</td>
						<td>$cmte_id_field</td>
						<td>$website_field</td>
						<td>$dscr</td>											
					</tr>";
		}
	}

	$retval = "<p align='center'>" . $all_count . " Candidates<br>
					REP: " . $count['R']   . "  DEM: " . $count['D']   . "  NPP: " . $count['NPP'] . "<br>
					GRN: " . $count['Grn'] . "  LIB: " . $count['Lib'] . "  AIP: " . $count['AIP'] . "  PAF: " . $count['PAF'] . "</p>";	

	$retval .= "<table class='cust_striped f497_table' align='center' v-ctb-table>
			<thead>
				<tr>
					<th>CANDIDATE</th>
					<th>PARTY</th>
					<th>CAND ID</th>
					<th>CMTE ID</th>
					<th>WEBSITE</th>
					<th>BALLOT DESIGNATION</th>
				</tr>
			</thead>
			<tbody>
			$table_body
			</tbody>
		</table>";
	return $retval;
}

function get_si() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT * FROM ctb_fppc_si WHERE office = 'GOVERNOR' && (year = 2021 || year = 2022) ORDER BY cand_id, year";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$year = $row['year'];
			$cand_id = $row['cand_id'];
			$arr[$cand_id][$year] = $row;
			$index[$cand_id] = $row;
		}
	}
	foreach($arr as $cand_id => $y) {
		if($arr[$cand_id][2021]) {
			$si2021_logged = mb_substr($arr[$cand_id][2021]['logged'], 0, 10);
			$si2021 = "X";
		} else {
			$si2021_logged = "";
			$si2021 = "";
		}

		if($arr[$cand_id][2022]) {
			$si2022_logged = mb_substr($arr[$cand_id][2022]['logged'], 0, 10);
			$si2022 = "X";
		} else {
			$si2022_logged = '';
			$si2022 = '';
		}

		$cand_nm = $index[$cand_id]['cand_nm'];
		$party = $index[$cand_id]['party'];

		if($si2021) {
			$si2021_cnt++;
		}

		if($si2022) {
			$si2022_cnt++;
		}

		if($si2021 && $si2022) {
			$both_cnt++;
		}

		if($si2021 && !$si2022) {
			$si2021_only++;
		}

		if($si2022 && !$si2021) {
			$si2022_only++;
		}

		$all++;

		$cand_url = 'https://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=' . $cand_id;
		$lobb_url = 'https://cal-access.sos.ca.gov/Lobbying/Employers/Detail.aspx?id=' . $cand_id;

		$cand_lnk = "<a href='$cand_url' target='_blank'>$cand_nm</a>";
		$lobb_lnk = "<a href='$lobb_url' target='_blank'>$cand_id</a>";

		$table_body .= "<tr>
							<td>$cand_lnk</td>
							<td>$party</td>
							<td>$lobb_lnk</td>
							<td>$si2021</td>
							<td>$si2021_logged</td>
							<td>$si2022</td>
							<td>$si2022_logged</td>
						</tr>";

	}
	$retval = "<p align='center'>$all Candidates Have Filed FPPC Statements of Intention<br>
				<a href='https://cal-access.sos.ca.gov/Campaign/Candidates/List.aspx?view=intention&sort=RACE&electid=122&electNav=172' target='_blank'>2021</a>: $si2021_cnt Total ($si2021_only for 2021 recall only)<br>
				<a href='https://cal-access.sos.ca.gov/Campaign/Candidates/List.aspx?view=intention&sort=RACE&electid=122' target='_blank'>2022</a>: $si2022_cnt Total ($si2022_only for 2022 primary only)<br>
				Both: $both_cnt
				</p>
				<table class='cust_striped f497_table' v-ctb-table>
				<thead>
					<tr>
						<th>CANDIDATE</th>
						<th>PARTY</th>
						<th>FPPC ID</th>
						<th>2021 SI</th>
						<th>LOGGED</th>
						<th>2022 SI</th>
						<th>LOGGED</th>
					</tr>
				</thead>
				<tbody>" . $table_body . "</tbody></table>";
	return $retval;				
}

function get_recall_items() {
	$conn = Util::get_ctb_conn();
	$months = Array(
		"01" => "January",
		"02" => "February",
		"03" => "March",
		"04" => "April",
		"05" => "May", 
		"06" => "June",
		"07" => "July",
		"08" => "August",
		"09" => "September",
		"10" => "October",
		"11" => "November",
		"12" => "December"
	);

	$days = Array(
		"01" => "1st",
		"02" => "2nd",
		"03" => "3rd",
		"04" => "4th",
		"05" => "5th",
		"06" => "6th",
		"07" => "7th",
		"08" => "8th",
		"09" => "9th",
		"10" => "10th",

		"11" => "11th",
		"12" => "12th",
		"13" => "13th",
		"14" => "14th",
		"15" => "15th",
		"16" => "16th",
		"17" => "17th",
		"18" => "18th",
		"19" => "19th",
		"20" => "20th",

		"21" => "21st",
		"22" => "22nd",
		"23" => "23rd",
		"24" => "24th",
		"25" => "25th",
		"26" => "26th",
		"27" => "27th",
		"28" => "28th",
		"29" => "29th",
		"30" => "30th",				
		"31" => "31st",				
		);


	$sql = "SELECT * FROM `ctb_hot_sheet` WHERE text LIKE '%RECALL WATCH%' GROUP BY post_id ORDER BY post_id DESC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		$retval = "<ul>";
		while($row = $result->fetch_assoc()) {
			$date = $row['post_id'];
			$year = mb_substr($date, 0, 4);
			$month = mb_substr($date, 5, 2);
			$day = mb_substr($date, 8, 2);
			$verbose_date = $months[$month] . " " . $days[$day] . ", " . $year;
			$retval .= "<li><a href='https://californiatargetbook.com/book/hotsheet/$date' target='_blank'>$verbose_date</a></li>";
			
		}
		$retval .= "</ul>";
	}

	return $retval;
}

function get_recall_analysis() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT text FROM ctb_analysis WHERE dist = 'RECALLGOV' && year = 2021 ORDER BY id DESC LIMIT 1";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			//echo("<br>RETURNING:<br>");
			//echo(htmlspecialchars($row['text']));
			return $row['text'];
		}
	}
	return FALSE;
}

function get_timeline_analysis() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT text FROM ctb_analysis WHERE dist = 'RECALLTL' && year = 2021 ORDER BY id DESC LIMIT 1";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			//echo("<br>RETURNING:<br>");
			//echo(htmlspecialchars($row['text']));
			return $row['text'];
		}
	}
	return FALSE;
}

function get_sig_table() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT * FROM ctb_2021_gov_recall_sigs";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {

			if($row['county'] != "TOTAL") {
				$table_body .= "<tr>
									<td>" . $row['county'] . "</td>
									<td align='right'>" . number_format($row['rpt_1']) . "</td>
									<td align='right'>" . number_format($row['rpt_2']) . "</td>
									<td align='right'>" . number_format($row['rpt_3']) . "</td>
									<td align='right'>" . number_format($row['rpt_4']) . "</td>
									<td align='right'>" . number_format($row['rpt_5']) . "</td>
									<td align='right'>" . number_format($row['rpt_6']) . "</td>
									<td align='right'>" . number_format($row['rpt_7']) . "</td>
									<td align='right'>" . number_format($row['rpt_8']) . "</td>
									<td align='right'>" . number_format($row['rpt_9']) . "</td>
									<td align='right'>" . number_format($row['rpt_10']) . "</td>
									<td align='right'>" . number_format($row['total']) . "</td>
									<td align='right'>" . number_format($row['verified']) . "</td>
									<td align='right'>" . number_format($row['valid']) . "</td>								
									<td align='right'>" . number_format($row['invalid']) . "</td>
									<td align='right'>" . number_format((($row['valid'] / $row['verified']) * 100), 2) . "%</td>
								</tr>";
			} else {
				$table_foot .= "</tbody>
								<tfoot>
								<tr>
									<td>" . $row['county'] . "</td>
									<td align='right'>" . number_format($row['rpt_1']) . "</td>
									<td align='right'>" . number_format($row['rpt_2']) . "</td>
									<td align='right'>" . number_format($row['rpt_3']) . "</td>
									<td align='right'>" . number_format($row['rpt_4']) . "</td>
									<td align='right'>" . number_format($row['rpt_5']) . "</td>
									<td align='right'>" . number_format($row['rpt_6']) . "</td>
									<td align='right'>" . number_format($row['rpt_7']) . "</td>
									<td align='right'>" . number_format($row['rpt_8']) . "</td>
									<td align='right'>" . number_format($row['rpt_9']) . "</td>
									<td align='right'>" . number_format($row['rpt_10']) . "</td>
									<td align='right'>" . number_format($row['total']) . "</td>
									<td align='right'>" . number_format($row['verified']) . "</td>
									<td align='right'>" . number_format($row['valid']) . "</td>								
									<td align='right'>" . number_format($row['invalid']) . "</td>
									<td align='right'>" . number_format((($row['valid'] / $row['verified']) * 100), 2) . "%</td>
								</tr>
								</tfoot>
							</table>";

				$retval['sigs_total']  		= $row['total'];
				$retval['sigs_verified'] 	= $row['verified'];
				$retval['sigs_valid'] 		= $row['valid'];
				$retval['sigs_invalid'] 	= $row['invalid'];
				$retval['sigs_percent'] 	= number_format((($row['valid'] / $row['verified']) * 100), 2);
			}
		}
	}

	$table_head = "<table align='center' class='table-striped table-hover tablesorter compact'>
						<thead class='inverse'>
							<tr>
								<th>COUNTY</th>
								<th class='rightme'>RPT 1</th>
								<th class='rightme'>RPT 2</th>
								<th class='rightme'>RPT 3</th>
								<th class='rightme'>RPT 4</th>
								<th class='rightme'>RPT 5</th>
								<th class='rightme'>RPT 6</th>
								<th class='rightme'>RPT 7</th>
								<th class='rightme'>RPT 8</th>
								<th class='rightme'>RPT 9</th>
								<th class='rightme'>RPT 10</th>
								<th class='rightme'>TOTAL</th>
								<th class='rightme'>VERIFIED</th>
								<th class='rightme'>VALID</th>
								<th class='rightme'>INVALID</th>
								<th class='rightme'>%</th>
							</tr>
						</thead>
						<tbody>";

	
	$retval['table'] = $table_head . $table_body . $table_foot;

	return $retval; 						
}

function get_last_dl_time() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT id, DATE_SUB(modified, INTERVAL 8 hour) AS modified, completed FROM snapshot_calaccess ORDER BY id DESC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row;
			$modified = $row['modified'];
		}
	}

	//$timestamp = $year . "-" . $month . "-" . $day . " ($time)";

	$thistime = strtotime($modified);
	$timeago = humanTiming($thistime);

	$date = date('Y-m-d H:i:s');
	$elapsed = time_elapsed_string($modified);

	$retval['modified_elapsed'] = $elapsed;
	return $retval;

	
}

function time_sql2php($sqltime){
    return strtotime($sqltime . " GMT");
}
 

function time_sql2php_pdt($sqltime){
    return strtotime($sqltime . " PDT");
}
// Converts PHP time format to SQL Time Format
 
function time_php2sql($unixtime){
    return gmdate("Y-m-d H:i:s", $unixtime);
}

function time_elapsed_string($datetime, $full = true) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function humanTiming ($time) {

	//echo("<br>Converting $time...");

    $time = (time() - $time); // + 25200 to get the time since that moment
   // echo("Got $time...");
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        //echo("Returning " . $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':''));
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}



function get_finances() {
    global $propid_arr, $propno_arr, $prop_cmtes, $cmte_index, $last_reports, $filing_form_index, $filer_filing_form_index, $transactions, $recall_cmtes;
    $conn = Util::get_ctb_conn();

    //GET ALL SUMMARY AND LATE CONTRIBUTION FILINGS FOR ALL COMMITTEES

    $query = '';

    foreach($recall_cmtes as $cmte_id => $ignore) {
        $query .= " FILER_ID = $cmte_id ||";
    }
    $query = substr($query, 0, -2);
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE (FORM_ID = 'F460' || FORM_ID = 'F497') && (RPT_START > '2018-12-31' && PERIOD_ID != 0) &&  ( $query ) ORDER BY FILING_ID, FILING_SEQUENCE DESC";
    $result = $conn->query($sql);
    //echo("<br>$sql<br>");
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this_filing = $row['FILING_ID'];

	    $ignore_filings = Array(
		"2487551" => TRUE,
		);

            if($this_filing == $last_filing || $ignore_filings[$this_filing]) {
                continue;
            }

            $form_id = $row['FORM_ID'];
            $cmte_id = $row['FILER_ID'];
            $filing_id = $row['FILING_ID'];

            $filer_filing_index[$filing_id] = $cmte_id;
            if($form_id == 'F460') {
                $rpt_end = $row['RPT_END'];
                if(!$last_reports[$cmte_id] || $last_reports[$cmte_id] < $rpt_end) {
                    $last_reports[$cmte_id] = $rpt_end;
                }
            }

            $filer_filing_form_index[$cmte_id][$form_id][$filing_id] = $row;

            $filing_index[$this_filing] = $row;

            if(!$filing_form_index[$form_id]) {
                $filing_form_index[$form_id] = $row;
            }
            array_push($filing_form_index[$form_id], $row);
            $last_filing = $this_filing;
        }
    }

    //echo("<br>RETRIEVED " . sizeof($filing_form_index['F460']) . " Summmary Filings, " . sizeof($filing_form_index['F497']) . " Late Contribution Filings");

    //echo("<br>F497 DUMP<br>");
    //var_dump($filing_form_index['F497']);

    //GET SUMMARIES

    $query = '';

    foreach($filing_form_index['F460'] as $r) {
        $filing_id = $r['FILING_ID'];
        $amend_id = $r['FILING_SEQUENCE'];
        if($filing_id < 5) {
            continue;
        }
        $query .= " (FILING_ID = $filing_id && AMEND_ID = $amend_id) ||";
    }
    $query = substr($query, 0, -2);    

    $sql = "SELECT FILING_ID, AMEND_ID, LINE_ITEM, AMOUNT_A, AMOUNT_B 
            FROM calaccess_raw_SMRY_CD 
            WHERE FORM_TYPE = 'F460' && (LINE_ITEM = 1 || LINE_ITEM = 2 || LINE_ITEM = 4 || LINE_ITEM = 5 || LINE_ITEM = 6 || LINE_ITEM = 9 || LINE_ITEM = 11 || LINE_ITEM = 16 || LINE_ITEM = 19) && ( $query )";

    //echo("<br>$sql<br>");

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $filing_id = $row['FILING_ID'];
            $line_item = $row['LINE_ITEM'];
            $transactions['F460'][$filing_id][$line_item] = $row;
        }
    }

    $query = '';
    foreach($filing_form_index['F497'] as $r) {
        $filing_id = $r['FILING_ID'];
        $amend_id = $r['FILING_SEQUENCE'];
        if($filing_id < 5) {
            continue;
        }
        $query .= " (FILING_ID = $filing_id && AMEND_ID = $amend_id) ||";
    }
    $query = substr($query, 0, -2);

    $sql = "SELECT * FROM calaccess_raw_S497_CD WHERE FORM_TYPE = 'F497P1' && ( $query )";
    //echo("<br>$sql<br>");

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $filing_id = $row['FILING_ID'];
            $cmte_id   = $filer_filing_index[$filing_id];
            $last_date  = $last_reports[$cmte_id];
            $tran_date = $row['CTRIB_DATE'];
            $line_item = $row['LINE_ITEM'];

            if($tran_date > $last_date) {
                $transactions['F497'][$filing_id][$line_item] = $row;
            }                    
        }
    }






}

function totsort($a, $b) {
  $retval = $b['SPENT_TOT'] <=> $a['SPENT_TOT'];
  return $retval;
}

function get_county_registrar_url($county_name, $thisyear) {

    switch($thisyear) {
        case 2018:
            $tablename = "ctb_e18_county_watch";
            break;
        case 2020:
            $tablename = "ctb_e20_county_watch";
            break;
	case 2021:
	    $tablename = "ctb_r21_county_watch";
	    break;          
        default:
            return FALSE;
    }

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM $tablename WHERE county_nm LIKE :id
    ");
    $stmt->execute(['id' => $county_name]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval = $row['url'];
    }
    return $retval;
}

function get_ballot($fourcode, $year) {
	switch($year) {
		case "2018":
			$table = "ctb_e18_ballots";
			break;
		case "2020":
			$table = "ctb_e20_ballots";
			break;
		case "2021":
			$table = "ctb_r21_ballots";
			break;
		default:
			return FALSE;
	}
	$stmt = Util::get_ctb_pdo()->prepare("
			SELECT * FROM $table WHERE fourcode = :id ORDER BY elec_date, party, naml
		");
		$stmt->execute(['id' => $fourcode]);
		$abort = TRUE;
		$arr = Array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$key = $row['elec_type'];

			if(!$arr[$key]) {
				$arr[$key] = Array();
			}

			if($row['namm']) {
				$tmp['cand_nm'] = $row['namf'] . " " . $row['namm'] . " " . $row['naml'];
			} else {

				$tmp['cand_nm'] = $row['namf'] . " " . $row['naml'];
			}

			$tmp['website'] = $row['website'];
			$tmp['party'] = $row['party'];
			$tmp['cand_id'] = $row['cand_id'];
			$tmp['cmte_id'] = $row['cmte_id'];
			$tmp['ballot_dscr'] = $row['ballot_dscr'];
			$tmp['elec_date'] = $row['elec_date'];
			array_push($arr[$key], $tmp);
			$abort = FALSE;
		}





		$table_contain_head = "
								
								<div class='table table-striped table-responsive' align='center' style='display: inline-block;'>
									<p align='center'>";

		foreach($arr as $e => $value) {
			switch(mb_substr($e, 0, 1)) {
				case "s":
					$long_type = "Special Election Primary";
					break;
				case "r":
					$long_type = "Special Election Runoff";
					break;
				case "p":
					$long_type = "Primary Election";
					break;
				case "g":
					$long_type = "General Election";
					break;
				case "k":
					$long_type = "Recall Election";
					break;
				default:
					$long_type = "Unknown";
					break;
			}

			foreach($arr[$e] as $cand) {

				//echo("<br>CAND DUMP<br>");
				//var_dump($cand);

				switch($cand['party']) {
					case "R":
						$class = 'redme boldme';
						break;
					case "D":
						$class = 'blueme boldme';
						break;
					case "Grn":
						$class = 'greenme boldme';
						break;
					default:
						$class = '';
				}

				if($cand['website']) {
				     $name = "<a href='http://" . $cand['website'] . "' target='_blank'>" . $cand['cand_nm'] . "</a>";
				} else {
				     $name = $cand['cand_nm'];
				}

				$this_election = date('F j, Y', strtotime($cand['elec_date']));
				$table_body[$e] .= "<tr class='$class'>
										<td>" . $name . "</td>
										<td>" . $cand['party'] . "</td>
										<td>" . $cand['ballot_dscr'] . "</td>
									</tr>";

			}

			$table_head[$e] = "<h3>$long_type - $this_election</h3>
								<p></p>
								<p></p>
								<table style='margin-left: auto !important; margin-right: auto !important; margin-top: 10px;' align='center'>
									<thead>
										<tr>
											<th>CANDIDATE NAME</th>
											<th>PARTY</th>
											<th>BALLOT DESCRIPTION</th>
										</tr>
									</thead>
									<tbody>";



			$table_end[$e] = "</tbody></table><p></p>";
		}

		$retval = $table_contain_head;
		foreach($table_head as $key => $value) {
			$retval .= $table_head[$key] . $table_body[$key] . $table_end[$e];

		}

		$retval .= "</p></div>";

		if($abort) {
			return FALSE;
		} else {
			return $retval;
		}

}

function get_filed($fourcode, $thisyear)
{
	$thisyear = 2021;
	$fourcode = ".GOV";
    
    
    switch($thisyear) {
        case 2018:
            $tablename = "ctb_p18_filing_status";
            
            break;
        case 2020:
            $tablename = "ctb_p20_filing_status";
            
            break;
	case 2021:
	    $tablename = "ctb_r21_filing_status";
	    break;
        default:

            return FALSE;
    }
    
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM $tablename WHERE fourcode = :id ORDER BY party, naml
    ");
    $stmt->execute(['id' => $fourcode]);
    $abort = TRUE;
    $arr = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr, $row);
        $abort = FALSE;
    }

    

    $table_head = "<div class='table table-striped table-responsive' align='center' style='display: inline-block;'>
                    <p align='center'>
                    <table style='margin-left: auto !important; margin-right: auto !important;' align='center' class='cust_striped f497_table' v-ctb-table>
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>PARTY</th>
                                <th>SIL ISSUE</th>
                                <th>SIL FILE</th>
                                <th>NOM ISSUE</th>
                                <th>NOM FILE</th>
                                <th>COUNTY</th>
                            </tr>
                        </thead>
                        <tbody>";

    foreach($arr as $x) {
        if(isset($x['namm'])) {
            $name = $x['namf'] . " " . $x['namm'] . " " . $x['naml'];
        } else {
            $name = $x['namf'] . " " . $x['naml'];
        }

        $county_url = get_county_registrar_url($x['county_filed'], $thisyear);
        $county_lnk = "<a href='$county_url' target='_blank'>" . $x['county_filed'] . "</a>";

        $table_body .= "<tr>
                            <td>" . $name . "</td>
                            <td>" . $x['party'] . "</td>
                            <td>" . $x['sil_issue'] . "</td>
                            <td>" . $x['sil_file'] . "</td>
                            <td>" . $x['nom_issue'] . "</td>
                            <td>" . $x['nom_file'] . "</td>
                            <td>$county_lnk</td>                            
                        </tr>";
    }

    $retval = $table_head . $table_body . "</tbody></table></p></div>";


    if($abort) {
        return FALSE;
    } else {
        return $retval;
    }

}


        ?>

 @endsection
 
 @section('styles')

 <style>

        @import url('https://fonts.googleapis.com/css?family=Lato');
        @import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow');

        .prop_div {
            border: 2px solid black;
            width: 70vw;
            margin-top: 20px;
	    padding: 5px;

        }
	.boldme {
		font-weight: bold;
	}

	.compact {
		line-height: 1em;
	}

	.small-row {
		line-height: 0.9em !important;
		padding-top: 0px !important;
		padding-bottom: 0px !important;
	}

	.justifyme {
		text-align: justify !important;
	}

        .cmte_div {
            margin: 10px;
            border: 2px solid black;
            width: 90%; 
        }

        table {
            font-family: 'PT Sans Narrow';
            line-height: .9em;
        }

        th, td {
            padding-left: 5px;
            padding-right: 5px;
        }

	.bigme {
		font-size: 1.3em !important;
	}

        .inverse {
            background-color: black;
            color: white;
            font-weight: bold;
        }

	.cust_striped tr:nth-child(even) {
		background-color: #f2f2f2;
	}
	

        .f460_table {
            margin: 10px;
	    line-height: 0.9em !important;
        }

        .f497_table {
            margin: 10px;
	    line-height: 0.9em !important;
        }

        .emph {
            font-weight: bold;
            color: blue;
            font-size: 1.2em;
        }

        .SUPPORT {
            font-weight: bold;
            color: green;
        }

        .OPPOSE {
            font-weight: bold;
            color: red;
        }

        h2, h3, h4, h5 {
            font-family: 'Lato';
        }

   .prop_table {
	width: 850px;
	
    }

    .prop_table table {
	line-height: 1em;
     }

    .rightme {
	text-align: right !important;
    }

    .leftme {
	text-align: left !important;
    }

   .top_block {
	display: inline-block;
	border: 2px solid black;
	margin: 5px;
	padding: 5px;

    }

    .bigtext {
	font-size: 2em;
	font-variant: small-caps;
	font-weight: bold;
     }

    .greenme {
	color: green;
	}

    .smaller_table {
	margin-left: auto;
	margin-right: auto;
	border: 2px solid black;
	margin: 5px;
     }

    .huge_table {
	font-size: 2em;
	font-weight: bold;
	margin: 5px;
	border: 2px solid black;
	width: 865px;
	
    }

   .box1800 {
      background-image: url("/uploaded/box1800.jpg");
      background-position: center;
	}
      border: 2px solid black;
      margin-bottom: 5px;

   .box1200 {
      background-image: url("/uploaded/box1200.jpg");
      background-position: center;
	}

  	.box800 {
      background-image: url("/uploaded/box800.jpg");
      background-position: center;
	}

	.nofloat li {
		float: none;
		clear: both;
		line-height: 1em;
	}

#full_div {
	
	display: inline-block;
	min-width: 95vw;
}


#left_div {
	float: left;
	width: 1024px;
	

}	


#right_div {
	float: left;
	display: inline-block;
	padding-top: 5px;
	margin-left: -78px;
	margin-bottom: 20px;
}


#cycle_div {
	float: none;
	clear: both;
	width: 100%;
}

#chart_div {
	float: right;
	clear: both;
	background-color: white;
	top: -10px;
	
}

#nov_prop_div {
	float: none;
	clear: both;
	width: 100%;
	padding-top: 10px;
	margin-top: 10px;
}

#logo_div {
	width: 600px;
	margin-left: 10px;
}

.header_icon {
	font-size: 1.5em !important;
}

    </style>

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


	



@extends('layouts.book')


@section('title', 'Targeted Races | California Target Book')

@section('content')



<?php

global $races_arr, $propno_arr, $prop_cmtes, $cmte_index, $last_reports, $filing_form_index, $filer_filing_form_index, $transactions, $results_panels;

Util::require_ctb_api();




$races = get_races();
$an_arr = get_target_analysis($races_arr);




unset($transactions['F460'][2487640]); // GET RID OF DUPLICATE FILING
unset($filer_filing_form_index[1421884]['F460'][2487640]);

$count = 0;

$enddraw = "<div class='content-wrap pt-xl'>";
foreach($races_arr as $this_fourcode => $x) {
    $count++;

    if($count == 1) {
        $active_class = 'active';
    } else {
        $active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$this_fourcode' role='tab' data-toggle='tab'>
                        <i class='material-icons'>home</i>
                        $this_fourcode
                    </a>
                  </li>";



    $enddraw .= "<section id='p$this_fourcode' class='$active_class'> ";
    $enddraw .= "<div class='prop_div' align='center'>";
    $enddraw .= "<h2><a href='/book/district/$this_fourcode' target='_blank'>$this_fourcode</a></h2>
          <h4>";

    if($x['is_open']) {
	$enddraw .= "OPEN SEAT  |  ";
    }

    if($x['is_competitive']) {
	$enddraw .= "COMPETITIVE RACE  |  ";
    }

    if($x['same_party']) {
	$enddraw .= "SAME PARTY " . $x['same_party'] . " RUNOFF  |  ";
    }

    if($x['is_target']) {
	$enddraw .= $x['is_target'] . " TARGET  |  ";
    }

    $enddraw = rtrim($enddraw, '  |  ');
    $enddraw .= "</h4>";
    $enddraw .= "<p align='center'><div align='center' class='boxme'>Primary Results" . $results_panels[$this_fourcode] . "</div></p>";
  
    $enddraw .= "<h5>Analysis</h5><p align='justify'>" . $an_arr[$this_fourcode] . "</p>";

    foreach($prop_cmtes[$prop_id] as $pc) {
        $cmte_id = $pc['cmte_id'];
        $class = $pc['cmte_position'];
        $cmte_url = "<a href='https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>$cmte_id</a>";
        $enddraw .= "<div class='cmte_div'>";
        $enddraw .= "<h5 class='$class'>" . $pc['cmte_nm'] . "<br>" . $pc['cmte_position'] . "<br>" . $cmte_url . "</h5>";
        //$enddraw .= "<br>F460<br>";
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

        $f497_table = "<p align='center'>LATE CONTRIBUTIONS RECEIVED</p>
                        <table class='cust_striped f497_table'>
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
    $enddraw .=  "</div>";
    $enddraw .= "</section>";
}

echo("<div class='container-fluid pt-xl'>
        <h1>2020 Open/Competitive/Targeted Races</h1>
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

function get_races() {
    global $races_arr, $propno_arr, $prop_cmtes, $cmte_index, $last_reports, $filing_form_index, $filer_filing_form_index, $transactions;
    $conn = Util::get_ctb_conn();

    //GET PROPOSITION IDS, INFO
    $sql = "SELECT cycle, fourcode, is_open, is_competitive, same_party, is_target FROM ctb_targeted_races WHERE cycle = '2020' ORDER BY fourcode";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
	    $fourcode = $row['fourcode'];
	    $races_arr[$fourcode] = $row;
        }
    }
 



    //GET COMMITTEES
    $query = '';
    foreach($propid_arr as $prop_id => $ignore) {
        $query .= " prop_id = $prop_id ||";
    }
    $query = substr($query, 0, -2);
    $sql = "SELECT * FROM ctb_ca_props_pending_ccl WHERE ( $query )";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cmte_id = $row['cmte_id'];
            $prop_id = $row['prop_id'];

            if(!$prop_cmtes[$prop_id]) {
                $prop_cmtes[$prop_id] = Array();
            }

            array_push($prop_cmtes[$prop_id], $row);
            $cmte_index[$cmte_id] = $row;
        }
    }

    //GET ALL SUMMARY AND LATE CONTRIBUTION FILINGS FOR ALL COMMITTEES

    $query = '';

    foreach($cmte_index as $cmte_id => $ignore) {
        $query .= " FILER_ID = $cmte_id ||";
    }
    $query = substr($query, 0, -2);
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE (FORM_ID = 'F460' || FORM_ID = 'F497') && (RPT_START > '2018-12-31' && PERIOD_ID != 0) &&  ( $query ) ORDER BY FILING_ID, FILING_SEQUENCE DESC";
    $result = $conn->query($sql);
    //echo("<br>$sql<br>");
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this_filing = $row['FILING_ID'];
            if($this_filing == $last_filing) {
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

function get_target_analysis($races) {
	global $results_panels;
	$conn = Util::get_ctb_conn();
	foreach($races as $fourcode => $ignore) {
		if(mb_substr($fourcode, 0, 2) == "CD") {
			$adjusted = "CA" . mb_substr($fourcode, 2, 2);
		} else {
			$adjusted = $fourcode;
		}
		$query .= " (dist = '$adjusted' && year = 2020) ||";
	}
	$query = substr($query, 0, -2);
	$sql = "SELECT dist, year, text FROM ctb_analysis WHERE ( $query ) ORDER BY dist, id DESC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$this_dist = $row['dist'];
			if($this_dist == $last_dist) {
				continue;
			}
			if(mb_substr($this_dist, 0, 2) == "CA") {
				$adjusted = "CD" . mb_substr($this_dist, 2, 2);
			} else {
				$adjusted = $this_dist;
			}

			$retval[$adjusted] = $row['text'];
			$p = get_live_election($adjusted, 2020);
			$results_panels[$adjusted] = $p;
			$last_dist = $this_dist;
		}
	}
	return $retval;

}

function get_live_registration($fourcode, $election_year) {
	global $total_registered;
	$conn = Util::get_ctb_conn();
	$sql = "SELECT * FROM ctb2016_sos_all WHERE DIST = '$fourcode' && RPT_DATE LIKE '$election_year%' ORDER BY RPT_DATE DESC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$x = $row;
		}
	}

	$d = $x['DEM'];
	$r = $x['REP'];
	$npp = $x['NPP'];
	$tot = $x['TOT'];
	$total_registered = $tot;
	$rpt_date = $x['RPT_DATE'];

	$r_pct = number_format((($r / $tot) * 100), 2);
	$d_pct = number_format((($d / $tot) * 100), 2);
	$npp_pct = number_format((($npp / $tot) * 100), 2);

	if($d_pct > $r_pct) {
		$diff = $d_pct - $r_pct;
		$adv = "<span class='blueme boldme'>D +$diff%</span>";
	} elseif($r_pct > $d_pct) {
		$diff = $r_pct - $d_pct;
		$adv = "<span class='redme boldme'>R +$diff</span>";
	} else {
		$adv = "EVEN";
	}

	$retval = "<p align='center'>" . number_format($tot) . " Registered Voters ($rpt_date)<br>
				<span class='blueme boldme'>D: " . number_format($d) . " ($d_pct%)  </span>|  <span class='redme boldme'>R: " . number_format($r) . " ($r_pct%)  </span>|  NPP: " . number_format($npp) . " ($npp_pct%)<br>
				<br />$adv</p>";
	return $retval;
}

function get_live_results($fourcode, $election_year) {
	$conn = Util::get_ctb_conn();
	switch($election_year) {
		case "2018":
			$table = "ctb_g18_results_state";
			break;
		case "2020":
			$table = "ctb_p20_results_state";
			break;
	}

	$candidates = get_live_candidates($fourcode, $election_year);
	foreach($candidates as $cand_id) {
		$sql = "SELECT * FROM $table WHERE cand_id = '$cand_id' && fourcode = '$fourcode' ORDER BY updated DESC LIMIT 2";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			$i = 1;
			while($row = $result->fetch_assoc()) {
				if($i == 1) {
					$retval[$cand_id]['current'] = $row;
				} else {
					$retval[$cand_id]['previous'] = $row;
				}
				$i++;
			}
		}
	}
	return $retval;
}

function get_live_candidates($fourcode, $election_year) {
	$conn = Util::get_ctb_conn();

	switch($election_year) {
		case "2018":
			$table = "ctb_g18_results_state";
			break;
		case "2020":
			$table = "ctb_p20_results_state";
			break;
	}


	$sql = "SELECT cand_id FROM $table WHERE fourcode = '$fourcode' GROUP BY cand_id";
	$retval = Array();
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($retval, $row['cand_id']);
		}
	}
	return $retval;
}



function get_live_election($fourcode, $election_year) {
	global $total_registered;
	$race_html = '';
	$x = get_live_results($fourcode, $election_year);
	$y = get_live_registration($fourcode, $election_year);

	$precincts_tot = $x['888']['current']['cand_nm'];
	$precincts_in = $x['888']['current']['votes'];
	$precincts_last = $x['888']['previous']['votes'];
	$precincts_change = $precincts_in - $precincts_last;

	$votes_in = $x['999']['current']['votes'];
	$votes_last = $x['999']['previous']['votes'];
	$votes_change = $votes_in - $votes_last;
	$turnout = number_format((($votes_in / $total_registered) * 100), 2);

	$race_html = "<div class='table-striped race-div col-lg-12 special_result' align='center'>";

	$race_html .="<h1 align='center'>$fourcode</h1>$y<p align='center'>$precincts_in of $precincts_tot precincts in ($precincts_change added)</p><p align='center'>" . number_format($votes_in) . " votes cast ($votes_change added)<br>$turnout% Voter Turnout</p>";

	unset($x['999']);
	unset($x['888']);

	uasort($x, "previoussort");
	$i = 1;
	foreach($x as $key => $value) {
		$x[$key]['previous']['rank'] = $i;
		$i++;
	}

	uasort($x, "currentsort");
	$i = 1;
	foreach($x as $key => $value) {
		$x[$key]['current']['rank'] = $i;
		$i++;
	}

	$table_head = "<table align='center' style='margin-left: auto; margin-right: auto;'>
						<thead>
							<tr>
								<th></th>
								<th>NAME</th>
								<th>PARTY</th>
								<th class='rightme'>VOTES</th>
								<th class='centerme'>&Delta;</th>
								<th class='centerme'>%</th>
								<th>Rank</th>
								<th>Last</th>
								<th>Votes Behind</th>
							</tr>
						</thead>
						<tbody>";
	$table_body = '';

	foreach($x as $key => $v)	{

		$img = get_live_image_url($key);

		if($last_votes) {
			$votes_behind = $v['current']['votes'] - $last_votes;
		} else {
			$votes_behind = '';
		}

		$designation = get_live_designation($key, $election_year);

		switch($v['current']['party']) {
			case "R":
				$class = 'redme';
				break;
			case "D":
				$class = 'blueme';
				break;
			case "Grn":
				$class = 'greenme';
				break;
			default:
				$class = '';
		}

		$vote_diff = $v['current']['votes'] - $v['previous']['votes'];
		if($vote_diff > 0) {
			$sign = "+";
		} elseif($vote_diff < 0) {
			$sign = "-";
		} else {
			$sign = "";
		}
		$table_body .= "<tr>
							<td>$img</td>
							<td class='$class'>" . $v['current']['cand_nm'] . "<br><em>$designation</em></td>
							<td class='$class centerme'>" . $v['current']['party'] . "</td>
							<td align='right'>" . number_format($v['current']['votes']) . "</td>
							<td align='right'>$sign" . number_format($vote_diff) . "</td>
							<td align='right'>" . number_format((($v['current']['votes'] / $votes_in) * 100), 2) . "%</td>
							<td align='center'>" . $v['current']['rank']  . "</td>
							<td align='center'>" . $v['previous']['rank'] . "</td>
							<td align='right'>" . number_format($votes_behind) . "</td>
						</tr>";
		$last_votes = $v['current']['votes'];

	}

	$race_html .= $table_head . $table_body . "</tbody></table></div>";

	return $race_html;

}

function get_live_image_url($cand_id) {
	$arr = Array(".png", ".jpg", ".jpeg", ".bmp", ".gif");
	foreach($arr as $x) {
		if(file_exists("img/candidates/" . $cand_id . $x)) {
			$retval = "<img src='/img/candidates/" . $cand_id . $x . "' width='75px' class='img-responsive img-thumbnail' />";
			return $retval;
		}
	}
}

function get_live_designation($cand_id, $election_year) {
	$conn = Util::get_ctb_conn();
	switch($election_year) {
		case "2018": 
			$table = "ctb_e18_ballots";
			break;	
		case "2020":
			$table = "ctb_e20_ballots";
			break;
	}
	$sql = "SELECT ballot_dscr FROM $table WHERE cand_id = '$cand_id' ORDER BY elec_date ASC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			return $row['ballot_dscr'];
		}
	}
}

function currentsort($a, $b) {

	if($a['current']['votes'] < $b['current']['votes']) {
		return 1;
	} elseif ($a['current']['votes'] < $b['current']['votes']) {
		return -1;
	}else {
		return 0;
	}
}

function previoussort($a, $b) {

	if($a['previous']['votes'] < $b['previous']['votes']) {
		return 1;
	} elseif ($a['previous']['votes'] < $b['previous']['votes']) {
		return -1;
	}else {
		return 0;
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

	.boxme {
		border: 2px solid black;
		display: inline-block;
	}

    </style>

@endsection



	
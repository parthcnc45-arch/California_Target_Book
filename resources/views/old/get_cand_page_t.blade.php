<?php

if (isset($_GET['id'])) {
    $candidate = $_GET['id'];
} else {
    $candidate = $id;
}
?>

@extends('layouts.master')

@section('title', "Candidate Detail Page - $candidate")

@section('content')
    <div class='container'>
        <div class='row'>
            <div class='col-lg-12'>

                <?php

                Util::set_errors(E_ALL);
                Util::require_ctb_api();

                //error_reporting(E_ALL);
                //ini_set('display_errors', '1');
                setlocale(LC_COLLATE, "en_US");
                setlocale(LC_CTYPE, "en_US");
                $endjava = Array();
                $use_fed=false;
                $float_class='';


		if(isset($_GET['id'])) {
                     $cand_id = $_GET['id'];
		} else {
		     $cand_id = $id;
		}
                if (mb_substr($cand_id, 0, 1) == "H") {
                    $use_fed = TRUE;
                }

                if (!$use_fed) { //BEGIN RETRIEVE CALIFORNIA CANDIDATE
                    //GET ELECTIONS
                    echo("<div class='newseg'>");
                    $pic = get_pic($cand_id);

                    //$headshot = "<div align='center' style='display: inline-block; margin-left: auto !important; margin-right: auto !important;'><img src='$img_src' height='250px' style='border-radius: 15px; margin-left: auto !important; margin-right: auto !important;' align='center' class='img-thumbnail img-responsive dropshadow' /></div>";

                    if ($pic) {
                        echo("<div class='candpic' width='100%' align='center'><img src='$pic' width='250px' class='img-responsive img-thumbnail' /></div>");
                    }

                    $n = get_cal_name($cand_id);
                    echo("<h1>$n</h1>");
		    echo("<p align='center'>FPPC ID# <a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=$cand_id' target='_blank'>$cand_id</a></p>");

                    $e = get_cal_elections($cand_id);

                    //echo("<br>DUMPING ELECTIONS:<br>");
                    //var_dump($e);

                    //GET ELECTION RESULTS

                    $er = get_cal_election_results($e);
                    //echo("<br>DUMPING ELECTION RESULTS:<br>");
                    //var_dump($er);

                    ksort($er);
                    echo("<section width='100%' align='center'>");
                    echo("<div id='elections_container' style='margin-left: auto; margin-right: auto; display: inline-block;'>");

                    foreach ($er as $key => $value) {
                        //var_dump($value);
                        $election = $key;

                        uasort($value, 'votesort');
                        foreach ($value as $c) {
                            $tmp = mb_substr($c['racekey'], 0, 5);
                            $type = mb_substr($tmp, 0, 3);
                            $dist = mb_substr($tmp, 3, 2);

                            switch ($type) {
                                case "ASS":
                                    $fourcode = "AD" . $dist;
                                    break;
                                case "SEN":
                                    $fourcode = "SD" . $dist;
                                    break;
                                case "BOE":
                                    $fourcode = "BOE" . mb_substr($dist, 1, 1);
                                    break;
                                default:
                                    $fourcode = $type;
                                    break;
                            }
                        }

                        $table_body = '';

                        $this_year = mb_substr($election, 0, 4);
                        if (isset($last_year) && $this_year != $last_year) {
                            echo("<div width='100%' style='clear: both;'></div>");
                            $float_class = '';
                        } else {
                            $float_class = "style='float: right; '";
                        }

                        $table_head = "<div class='primary_div' $float_class>
							<table class='bordered cand_votes'>
								<thead>
									<tr>
										<th colspan='4'>$fourcode $election Election</th>
									</tr>
								</thead>
								<tbody>";


                        //echo("<br><br>$fourcode $election Election<br>");
                        $i = 0;
                        foreach ($value as $c) {

                            if ($i == 0) {
                                $add_style = "style=\"font-variant: small-caps; font-weight: bold;\"";
                            } else {
                                $add_style = '';
                            }

                            switch ($c['party']) {
                                case "REP":
                                    $bg_class = 'redbg';
                                    break;
                                case "DEM":
                                    $bg_class = 'bluebg';
                                    break;
                                default:
                                    $bg_class = 'greybg';
                                    break;
                            }

                            $table_body .= "
							<tr $add_style>
								<td class='$bg_class'>" . $c['cand_nm'] . "</td>
								<td class='$bg_class'>" . $c['party'] . "</td>
								<td align='right'>" . $c['votes'] . "</td>
								<td align='right'>" . $c['vote_pct'] . "</td>
							</tr>";

                            //echo("<br>" . $c['cand_nm'] . " (" . $c['party'] . " " . $c['is_incumbent'] . ") ID# " . $c['cand_id'] . " VOTES: " . $c['votes'] . " (" . $c['vote_pct'] . ") " . $c['racekey']);
                            $i++;
                        }

                        $table_end = "</tbody></table></div>";

                        echo($table_head . $table_body . $table_end);
                        $last_year = $this_year;
                    }


                    echo("</div>");

                    $b = get_cal_bio($cand_id);
                    echo("<div class='row'>
                            <div class='col-lg-12'>
                                <div class='panel panel-bio'>
                                    <span class='justify_all' align='left' style='text-align: justify !important; display: inline-block;'>$b</span>
                                </div>
                            </div>
                        </div>");

/*
                    echo("<div class='newseg bio_2 style='text-align: right;' >
			<div class='bio_div' style='text-align: justify;'>
				$b
			</div>
		</div>");
*/

                    //GET COMMITTEES

                    $cm = get_cal_committees($cand_id);
                    echo("</section>");
                    echo("<div style='clear: both;'>");


                    echo("<br><br><p align='center' class='cand_header'>CANDIDATE'S COMMITTEES</p>");
                    foreach ($cm as $c) {
                        echo("<div class='row'>
                                <div class='col-lg-12'>
                                    <div class='panel'>");
                        $cmte_id = $c['cmte_id'];
                        if (mb_substr($c['status'], 0, 6) == "ACTIVE") {
                            $span_class = 'greenme boldme';
                        } else {
                            $span_class = 'redme boldme';
                        }
                        echo("<h3 align='center'>" . $c['cmte_nm'] . "</h3><p align='center' class='cmte_head'>" . "<span class='$span_class'>" . $c['status'] . "</span>" . "<br>FPPC# <a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=$cmte_id' target='_blank'>$cmte_id</a></p>");
                        echo("<hr class='$span_class' />");
                        $html = get_cmte_summary($cmte_id);
                        echo($html);

                        $cns = get_cal_consultants($cmte_id);
                        //var_dump($cns);
                        $consultants = '';
                        $polling = '';

                        if ($cns['CNS']??false) {
                            uasort($cns['CNS'], 'amountsort');
                            foreach ($cns['CNS'] as $key => $value) {
                                if ($value['amount'] > 1000) {
                                    if (!$consultants) {
                                        $consultants = "<span class='boldme'>Campaign Consultants</span>: " . $value['name'];
                                    } else {
                                        $consultants .= ", " . $value['name'];
                                    }
                                }
                            }
                        }

                        if ($cns['POL']??false) {
                            uasort($cns['POL'], 'amountsort');
                            foreach ($cns['POL'] as $key => $value) {
                                if ($value['amount'] > 1000) {
                                    if (!$polling) {
                                        $polling = "<span class='boldme'>Polling</span>: " . $value['name'];
                                    } else {
                                        $polling .= ", " . $value['name'];
                                    }
                                }
                            }
                        }

                        if ($consultants || $polling) {
                            echo("<hr class='$span_class' />");
                            echo("<div class='newseg consultants'>");

                            if ($consultants) {
                                echo("<br>$consultants");
                            }

                            if ($polling) {
                                echo("<br>$polling");
                            }

                            echo("</div>");

                            echo("<br>");
                        }
                        echo("  </div>
                            </div>
                        </div>");

                    }

                    //GET BIO


                    //GET FINANCIALS

                    //$fn = get_cal_financials($c);

                    //GET CONSULTANTS

                    //$cn = get_cal_consultants($c);
                    echo("</div>");

                } else {        //BEGIN RETRIEVE FEDERAL CANDIDATE

                    echo("<div class='newseg'>");
                    $pic = get_pic($cand_id);

                    //$headshot = "<div align='center' style='display: inline-block; margin-left: auto !important; margin-right: auto !important;'><img src='$img_src' height='250px' style='border-radius: 15px; margin-left: auto !important; margin-right: auto !important;' align='center' class='dropshadow' /></div>";

                    if ($pic) {
                        echo("<div class='candpic' width='100%' align='center'><img src='$pic' width='250px' class='img-responsive img-thumbnail'/></div>");
                    }

                    $n = get_fed_name($cand_id);
                    echo("<h1>$n</h1>");

                    //GET ELECTIONS

                    $e = get_fed_elections($cand_id);

                    //GET ALL CANDIDATES & VOTE TOTALS FOR SPECIFIED ELECTION

                    $er = get_fed_election_results($e);

                    echo("<div width='100%' align='center' style='margin-left: auto; margin-right: auto; display: block;'>");
                    echo("<div id='e_container' align='center' style='display: inline-block;'>");

                    foreach ($er as $key => $value) {
                        $year = $key;
                        foreach ($value as $key2 => $value2) {
                            $fourcode = $key2;
                            $table_body = '';
                            $table_head = "<div class='primary_div $float_class'>
								<table class='bordered'>
									<thead>
										<tr>
											<th colspan='4'>$fourcode $year General Election</th>
										</tr>
									</thead>
									<tbody>";

                            uasort($value2, 'votesort');
                            $i = 0;
                            foreach ($value2 as $c) {
                                if ($i == 0) {
                                    //$row_class = 'winner';
                                    $win_style = "style=\"font-weight: bold; font-variant: small-caps;\"";
                                } else {
                                    //$row_class = '';
                                    $win_style = '';
                                }

                                if ($c['is_incumbent'] == "Inc") {
                                    $row_class = ' itcme';
                                    $party = $c['party'] . "-Inc";
                                } else {
                                    $party = $c['party'];
                                    $row_class = '';
                                }

                                if ($c['party'] == "R") {
                                    $bg_class = 'redbg';
                                } elseif ($c['party'] == "D") {
                                    $bg_class = 'bluebg';
                                } else {
                                    $bg_class = 'greybg';
                                }

                                $table_body .= "
								<tr $win_style class='$row_class'>
									<td class='$bg_class'>" . $c['name'] . "</td>
									<td class='$bg_class'>$party</td>
									<td align='right'>" . $c['votes'] . "</td>
									<td align='right'>" . $c['vote_pct'] . "</td>
								</tr>";
                                $i++;

                            }
                            $table_end = "</tbody></table></div>";
                            echo($table_head . $table_body . $table_end);

                        }
                    }


                    echo("</div>");
                    echo("</div>");
                    //GET COMMITTEES

                    $b = get_cal_bio($cand_id);

                    echo("<div class='newseg bio_2' >
			<div class='bio_div'>
				$b
			</div>
		</div>");


                    $fn = get_fed_committees($cand_id);
                    //echo("<br>COMMITTEES DUMP:<br>");
                    //var_dump($fn);
                    //echo("<Br>");

                    $tables = '';
                    foreach ($fn as $key => $v) {
                        $year = $key;

                        $tables .= "<div class='newseg' style='margin-top: 20px; padding: 20px;'>
			<p align='center' class='cmte_head'>$year Election<br>" . $v['cmte_nm'] . " (FEC ID# " . $v['cmte_id'] . ")</p>
			<table class='table table-bordered table-hover tablesaw tablesaw-stack largertext' data-tablesaw-mode='stack'>
				<thead>
					<tr>
						<th>COH Start</th>
						<th>Receipts</th>
						<th>Expenditures</th>
						<th>COH End</th>
						<th>Cand Loans</th>
						<th>Total Debt</th>
						<th>Period End</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>\$" . number_format($v['coh_start']) . "</td>
						<td>\$" . number_format($v['rcpt']) . "</td>
						<td>\$" . number_format($v['expn']) . "</td>
						<td>\$" . number_format($v['coh_end']) . "</td>
						<td>\$" . number_format($v['cand_loans']) . "</td>
						<td>\$" . number_format($v['debts']) . "</td>
						<td>" . $v['pd_end'] . "</td>
					</tr>
				</tbody>
			</table>
			</div>
		";

                    }

                    echo($tables);

                    //GET BIO

                    //GET FINANCIALS

                    //$fn = get_fed_financials($c);


                } // END RETRIEVE FEDERAL CANDIDATE

                function get_fed_committees($cand_id)
                {

                    $conn = Util::get_ctb_conn();
                    $fn=[];
                    //echo("<br>FIRING GET FED COMMITTEES, BEGINNING CYCLE<br>");

                    $elections = Array("2018", "2016", "2014", "2012");
                    foreach ($elections as $e) {
                        switch ($e) {
                            case "2018":
                                $cm = "nufec18_cm";
                                $weball = "nufec18_weball";
                                break;
                            case "2016":
                                $cm = "nufec_cm";
                                $weball = "nufec_weball";
                                break;
                            case "2014":
                                $cm = "nufec_cm_14";
                                $weball = "nufec_weball_14";
                                break;
                            case "2012":
                                $cm = "nufec_cm_12";
                                $weball = "nufec_weball_12";
                                break;
                        }

                        $sql = "SELECT * FROM $weball WHERE CAND_ID = '$cand_id'";
                        //echo("<br>$sql<br>");
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $fn[$e]['rcpt'] = $row['TTL_RECEIPTS'];
                                $fn[$e]['expn'] = $row['TTL_DISB'];
                                $fn[$e]['coh_start'] = $row['COH_BOP'];
                                $fn[$e]['coh_end'] = $row['COH_COP'];
                                $fn[$e]['cand_loans'] = $row['CAND_LOANS'];
                                $fn[$e]['debts'] = $row['DEBTS_OWED_BY'];
                                $fn[$e]['pd_end'] = $row['CVG_END_DT'];

                            }
                        }

                        $sql = "SELECT CMTE_NM, CMTE_ID FROM $cm WHERE CAND_ID = '$cand_id' && CMTE_DSGN = 'P'";
                        //echo("<br>$sql<br>");
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $fn[$e]['cmte_nm'] = $row['CMTE_NM'];
                                $fn[$e]['cmte_id'] = $row['CMTE_ID'];
                            }
                        }
                    }

                    return $fn;

                }

                function get_fed_election_results($elections)
                {
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $er=[];
                    foreach ($elections as $e) {
                        $election_votes = 0;
                        $fourcode = $e['fourcode'];
                        $year = $e['year'];
                        $sql = "SELECT * FROM nufec_election_results WHERE FOURCODE = '$fourcode' && YEAR = '$year' ORDER BY VOTES DESC";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $cand_id = $row['CAND_ID'];
                                $er[$year][$fourcode][$cand_id]['cand_id'] = $cand_id;
                                $er[$year][$fourcode][$cand_id]['name'] = $row['NAMF'] . " " . $row['NAML'];
                                $er[$year][$fourcode][$cand_id]['votes'] = $row['VOTES'];
                                $er[$year][$fourcode][$cand_id]['party'] = $row['PARTY'];
                                $er[$year][$fourcode][$cand_id]['is_incumbent'] = $row['INC'];

                                $election_votes += $row['VOTES'];
                            }
                        }

                        foreach ($er[$year][$fourcode] as $key => $value) {
                            $vote_pct = makepct($value['votes'], $election_votes);
                            $cand_id = $key;
                            $er[$year][$fourcode][$key]['vote_pct'] = $vote_pct;
                        }
                    }
                    ksort($er);

                    return $er;
                }

                function get_fed_elections($cand_id)
                {
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT FOURCODE, YEAR FROM nufec_election_results WHERE CAND_ID = '$cand_id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tmp['year'] = $row['YEAR'];
                            $tmp['fourcode'] = $row['FOURCODE'];
                            array_push($retval, $tmp);

                        }
                    }

                    return $retval;
                }

                function get_fed_name($cand_id)
                {
                    global $fec_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT cand_nm FROM nufec_e18_fed_candidates WHERE cand_id = '$cand_id'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            return $row['cand_nm'];
                        }
                    }

                    $tables = Array("nufec_cn", "nufec_cn_14", "nufec_cn_12");
                    foreach ($tables as $t) {
                        $sql = "SELECT CAND_NAME FROM $t WHERE CAND_ID = '$cand_id'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                return $row['CAND_NAME'];
                            }
                        }
                    }

                    return FALSE;
                }

                function get_highest_amend_id($f)
                {
                    $retval=[];
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT AMEND_ID FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE FILING_ID = '$f' ORDER BY AMEND_ID DESC LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval = $row['AMEND_ID'];
                        }
                    }

                    return $retval;
                }

                function get_cal_consultants($cmte_id)
                {
                    $retval=[];
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $filings = get_all_filings($cmte_id);

                    foreach ($filings as $f) {
                        $highest = get_highest_amend_id($f);
                        if (is_array($f)) {
                            $f=count($f)?$f[0]:null;
                        }
                        if (is_array($highest)) {
                            $highest=count($highest)?$highest[0]:null;
                            
                        }

                        $sql = "SELECT * FROM calaccess_raw_EXPN_CD WHERE FILING_ID = '$f' && (EXPN_CODE = 'CNS' || EXPN_CODE = 'POL') && AMEND_ID = '$highest'";
                        //echo("<br>$sql");
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $amt = $row['AMOUNT'];
                                $code = $row['EXPN_CODE'];
                                if ($row['PAYEE_NAMF']) {
                                    $name = $row['PAYEE_NAMF'] . " " . $row['PAYEE_NAML'];
                                } else {
                                    $name = $row['PAYEE_NAML'];
                                }

                                $retval[$code][$name]['name'] = $name;
                                if (array_key_exists('amount',$retval[$code][$name])) {
                                    $retval[$code][$name]['amount'] += $amt;
                                }else{
                                    $retval[$code][$name]['amount'] = $amt;

                                }
                            }
                        }
                    }

                    return $retval;

                }

                function get_all_filings($cmte_id)
                {
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT FILING_ID FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$cmte_id' && PERIOD_ID != '' && FORM_ID = 'F460' ORDER BY RPT_END DESC, FILING_SEQUENCE DESC";
                    //echo($sql);
                    $result = $conn->query($sql);
                    $retval = Array();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $this_filing = $row['FILING_ID'];
                            if (isset($last_filing) && $this_filing != $last_filing) {
                                array_push($retval, $this_filing);
                            }
                            $last_filing = $this_filing;
                        }
                    }

                    return $retval;
                }

                function votesort($a, $b)
                {

                    if ($a['votes'] < $b['votes']) {
                        return 1;
                    } elseif ($a['votes'] > $b['votes']) {
                        return -1;
                    } else {
                        return 0;
                    }
                }

                function amountsort($a, $b)
                {

                    if ($a['amount'] < $b['amount']) {
                        return 1;
                    } elseif ($a['amount'] > $b['amount']) {
                        return -1;
                    } else {
                        return 0;
                    }
                }

                function electionsort($a, $b)
                {
                    if ($a < $b) {
                        return 1;
                    } elseif ($a > $b) {
                        return -1;
                    } else {
                        return 0;
                    }
                }

                function get_cal_committees($cand_id)
                {
                    global $site_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT * FROM ctb_ca_ccl WHERE cand_id = '$cand_id' ORDER BY cmte_id DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $tmp['cmte_id'] = $row['cmte_id'];
                            $tmp['status'] = $row['status'];
                            $tmp['cmte_nm'] = $row['cmte_nm'];
                            array_push($retval, $tmp);
                        }
                    }

                    return $retval;
                }

                function get_cal_candidates($race, $election)
                {
                    //RETRIEVING CANDIDATES FROM A SINGLE ELECTION
                    global $site_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT * FROM ctb_ca_candidates WHERE election = '$election' && race LIKE '$race%' GROUP BY election, race";
                    //echo("<br>SQL1:<br>");
                    //echo($sql);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $racekey = $row['race'];
                            $x[$racekey]['name'] = $row['name'];
                            $x[$racekey]['race'] = $row['race'];
                            $x[$racekey]['party'] = $row['party'];
                            $x[$racekey]['is_incumbent'] = $row['is_incumbent'];
                            $x[$racekey]['cand_id'] = $row['cand_id'];
                        }
                    }

                    //echo("<br>RESULTS:<br>");
                    //var_dump($x);
                    //echo("<br>");

                    //NOW GET THE VOTE TOTALS

                    foreach ($x as $key => $value) {
                        $racekey = $key;

                        $sql = "SELECT SUM(votes) AS TOTAL FROM ctb_county_results WHERE racekey = '$racekey' && election = '$election'";
                        //echo("<br>SQL2:<br>$sql");
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $x[$racekey]['votes'] = $row['TOTAL'];
                            }
                        }
                    }
                    //echo("<Br>RESULTS BEFORE RETURNING:<br>");
                    //var_dump($x);
                    //echo("<br>");
                    return $x;
                }

                function get_cal_election_results($elections)
                {

                    $er = [];

                    foreach ($elections as $e) {
                        //GET THE LIST OF CANDIDATES
                        $year = "20" . mb_substr($e['election'], 1, 2);
                        $type = mb_substr($e['election'], 0, 1);
                        $this_total = 0;

                        if ($type == "p") {
                            $long_type = "_Jun";
                        } else {
                            $long_type = "_Nov";
                        }

                        $this_election = $year . $long_type;
                        $office = mb_substr($e['race'], 0, 3);

                        if (strtoupper($type) == "P" && $year < 2012) {
                            if ($office == "ASS" || $office == "SEN" || $office == "BOE") {
                                $short_race = mb_substr($e['race'], 0, 8);                        //IF BEFORE 2012 AND A PRIMARY, ONLY RETRIEVE OTHER CANDIDATES IN PARTISAN PRIMARY
                            } else {
                                $short_race = mb_substr($e['race'], 0, 6);
                            }
                        } else {                                                            //OTHERWISE SHORTEN CODE TO RETRIEVE ALL CANDIDATES RUNNING IN TOP-TWO
                            if ($office == "ASS" || $office == "SEN" || $office == "BOE") {
                                $short_race = mb_substr($e['race'], 0, 5);                        //RETRIEVE 3 LETTER PREFIX AND TWO DIGIT DISTRICT, i.e. ASS03XXXXX
                            } else {
                                $short_race = mb_substr($e['race'], 0, 3);
                            }
                        }

                        $c = get_cal_candidates($short_race, strtoupper($e['election']));    //GET ALL CANDIDATES FOR THE RACE IN THIS SPECIFIC ELECTION

                        //echo("<br>GET CAL CANDIDATES DUMP:<br>");
                        //var_dump($c);

                        foreach ($c as $cand) {
                            $this_total += $cand['votes'];        //CYCLE THROUGH ONCE, GET SUM OF ALL VOTES
                        }

                        foreach ($c as $key => $v) {
                            $racekey = $v['race']; //CYCLE THROUGH AGAIN, POPULATE EACH ELECTION WITH CANDIDATES, NAMES, VOTES, AND PERCENTAGE TOTALS
                            $votes = $v['votes'];
                            $cand_nm = $v['name'];
                            $party = $v['party'];
                            $cand_id = $v['cand_id'];
                            $is_incumbent = $v['is_incumbent'];

                            $this_pct = makepct($votes, $this_total);
                            $er[$this_election][$racekey]['racekey'] = $racekey;
                            $er[$this_election][$racekey]['votes'] = $votes;
                            $er[$this_election][$racekey]['vote_pct'] = $this_pct;
                            $er[$this_election][$racekey]['cand_nm'] = $cand_nm;
                            $er[$this_election][$racekey]['party'] = $party;
                            $er[$this_election][$racekey]['cand_id'] = $cand_id;
                            $er[$this_election][$racekey]['is_incumbent'] = $is_incumbent;
                        }
                    }

                    return $er;
                }

                function get_cal_elections($cand_id)
                {
                    global $site_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT election, race FROM ctb_ca_candidates WHERE cand_id = '$cand_id'";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            array_push($retval, $row);
                        }
                    }

                    return $retval;
                }

                function get_cmte_summary($cmte_id)
                {

                    $x[0]['cmte_id'] = $cmte_id;

                    $retval = "<div class='newseg' style='clear: both;'>
                        <table class='table table-bordered bordered tablesorter table-hover tablesaw tablesaw-stack largertext' data-tablesaw-mode='stack'>
                            <thead>
                                <tr>
                                    <th style='max-width: 400px;'>CMTE</th>
                                    <th style='max-width: 150px;'>RAISED LAST</th>
                                    <th style='max-width: 150px;'>SINCE</th>
                                    <th style='max-width: 150px;'>LIFETIME RAISED</th>
                                    <th style='max-width: 150px;'>LIFETIME SPENT</th>
                                    <th style='max-width: 150px;'>CASH ON HAND</th>

                                </tr>
                            </thead>
                            <tbody>

                    ";
                    $key_filings = Array();
                    $lastdate='';

                    foreach ($x as $committee) {

                        $raisedsince = 0;
                        $lifetime_raised = 0;
                        $lifetime_spent = 0;
                        $lastsummary = [];

                        $thiscmte = $committee['cmte_id'];
                        if (!$thiscmte) {
                            continue;
                        }
                        //echo("<br>LOOKING UP $thiscmte");
                        if ($thiscmte) {
                            $thiscmte_nm = get_full_committee_name($thiscmte);
                            $thiscand = $thiscmte_nm;
                            //echo("<br>GOT $thiscmte_nm");
                        }

                        $years = get_filing_years($thiscmte);
                        uasort($years, 'yearsort');

                        foreach ($years as $key => $value) {
                            $thisyear = $key;
                            //echo("<br>RETRIEVING FINAL FILING FOR YEAR $key");
                            //$key_filings[$filing] = get_final_filing($thiscmte, $thisyear);
                            $filing = get_final_filing($thiscmte, $thisyear);
                            if(!is_array($filing)){

                                $key_filings[$filing] = $filing;
                            }
                        }

                        $last = getlastf460($thiscmte);


                        foreach ($key_filings as $key => $value) {
                            //echo("<br>RETRIEVING SUMMARY FROM FILING $value");
                            $z = getsummary($value);
                            if (array_key_exists('YTD_RCPT',$z)) {
                                $lifetime_raised += $z['YTD_RCPT'];
                            }
                            if (array_key_exists('YTD_EXPN',$z)) {
                                $lifetime_spent += $z['YTD_EXPN'];
                            }
                        }
                        if ($last) {
                            $lastdate = $last['RPT_END'];
                            $lastsummary = getsummary($last['FILING_ID']);
                        }


                        $f497s = getf497filingssince($thiscmte, $lastdate);
                        $raisedsince = getf497amounts($f497s, $lastdate);

                        $totalraised = $lifetime_raised + $raisedsince;
                        
                        $cmte_lnk='';
                        if (!is_array($thiscand)) {
                            $cmte_lnk = "<a href='cmlocal2.php?id=$thiscmte' target='_blank'>$thiscand</a>";
                        }

                        $retval .= "
				<tr>
					<td>$cmte_lnk</th>
					<td>\$" . number_format($lastsummary['RCPT']??0, 2, '.', ',') . "</td>
					<td>\$" . number_format($raisedsince, 2, '.', ',') . "</td>
					<td>\$" . number_format($totalraised, 2, '.', ',') . "</td>
					<td>\$" . number_format($lifetime_spent, 2, '.', ',') . "</td>
					<td>\$" . number_format($lastsummary['COH']??0, 2, '.', ',') . "</td>

				<tr>
		";

                    }
                    $retval .= "</tbody></table></div>";

                    return $retval;


                }

                function yearsort($a, $b)
                {

                    if ($a['YEAR'] < $b['YEAR']) {
                        return -1;
                    } elseif ($a['YEAR'] > $b['YEAR']) {
                        return 1;
                    } else {
                        return 0;
                    }
                }


                function getsummary($filing)
                {
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    //CONTRIBUTIONS THIS PERIOD
                    $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['RCPT'] = $row['AMOUNT_A'];

                        }
                    }
                    //CONTRIBUTIONS THIS CALENDAR YEAR
                    $sql = "SELECT AMOUNT_B FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['YTD_RCPT'] = $row['AMOUNT_B'];
                        }
                    }
                    //EXPENDITURES
                    $sql = "SELECT AMOUNT_A from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['EXPN'] = $row['AMOUNT_A'];
                        }
                    }
                    //YTD EXPENDITURES
                    $sql = "SELECT AMOUNT_B from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['YTD_EXPN'] = $row['AMOUNT_B'];
                        }
                    }
                    //CASH ON HAND
                    $sql = "SELECT AMOUNT_A FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '16' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['COH'] = $row['AMOUNT_A'];
                        }
                    }
                    //LOANS
                    $sql = "SELECT AMOUNT_B FROM calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '2' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['LOANS'] = $row['AMOUNT_B'];
                        }
                    }
                    //DEBTS
                    $sql = "SELECT AMOUNT_A from calaccess_raw_SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '19' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['DEBTS'] = $row['AMOUNT_A'];
                        }
                    }

                    return $retval;
                }

                function get_cal_name($cand_id)
                {
                    global $calaccess_conn;
                    $retval='';
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT NAMF, NAML FROM calaccess_raw_FILERNAME_CD WHERE FILER_ID = '$cand_id' LIMIT 1";
                    //echo($sql);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval = $row['NAMF'] . " " . $row['NAML'];
                        }
                    }

                    return $retval;
                }

                function get_pic($cand_id)
                {
                    $suffix = Array(".png", ".jpeg", ".jpg", ".gif", ".bmp");
                    foreach ($suffix as $s) {
                        if (file_exists("img/candidates/$cand_id" . $s))
                            return "/img/candidates/$cand_id" . $s;
                    }

                    return FALSE;
                }


                function get_final_filing($cmte_id, $year)
                {
                    $retval=[];
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT FILING_ID FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$cmte_id' && RPT_END LIKE '$year%' && PERIOD_ID != '' && FORM_ID = 'F460' ORDER BY RPT_END DESC, FILING_SEQUENCE DESC LIMIT 1";
                    //echo($sql);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval = $row['FILING_ID'];
                        }
                    }

                    return $retval;
                }

                function get_filing_years($cmte_id)
                {
                    $retval=[];
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT RPT_START, RPT_END FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$cmte_id' && FORM_ID = 'F460'";
                    //echo($sql);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $year = mb_substr($row['RPT_END'], 0, 4);
                            $retval[$year]['YEAR'] = $year;
                        }
                    }

                    return $retval;

                }

                function getf497filingssince($committee, $date)
                {
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $tmp = Array();
                    $retval = Array();
                    $lastfiling = '';
                    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$committee' && RPT_END > '$date' && FILING_TYPE <> '0' ORDER BY FILING_ID DESC, FILING_SEQUENCE DESC";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $thisfiling = $row['FILING_ID'];
                            if ($thisfiling == $lastfiling) {
                                //DO NOTHING
                            } else {
                                $tmp['FILING_ID'] = $row['FILING_ID'];
                                array_push($retval, $tmp);
                            }
                            $lastfiling = $thisfiling;
                        }
                    }

                    return $retval;
                }

                function getf497amounts($filings, $lastdate)
                {
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = 0;
                    $highest = '';
                    foreach ($filings as $filing) {
                        $sql = "SELECT AMOUNT, AMEND_ID, LINE_ITEM, CTRIB_DATE FROM calaccess_raw_S497_CD WHERE FILING_ID = '" . $filing['FILING_ID'] . "' && FORM_TYPE = 'F497P1' ORDER BY LINE_ITEM ASC, AMEND_ID DESC";
                        //echo("<br>$sql<br>");
                        $result = $conn->query($sql);
                        $highest = '';
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if (!$highest) {
                                    $highest = $row['AMEND_ID'];
                                }
                                $thisamend = $row['AMEND_ID'];
                                if ($thisamend < $highest) {
                                    //DO NOTHING
                                } else {
                                    if ($row['CTRIB_DATE'] > $lastdate) {
                                        $retval += $row['AMOUNT'];
                                    }
                                }
                            }
                        }
                        //echo("<br>Retval is $retval after processing filing #" . $filing['FILING_ID'] . "<Br>");
                    }

                    return $retval;
                }

                function getlastf460($committee)
                {
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && FILING_TYPE <> '0' ORDER BY RPT_END DESC, FILING_SEQUENCE DESC LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['FILING_ID'] = $row['FILING_ID'];
                            $retval['RPT_END'] = $row['RPT_END'];
                        }
                    }

                    return $retval;
                }

                function get_full_committee_name($cmte_id)
                {
                    global $calaccess_conn;
                    $retval=[];
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT NAML from calaccess_raw_FILERNAME_CD WHERE FILER_ID = '" . $cmte_id . "' LIMIT 1";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval = $row['NAML'];
                        }
                    }

                    return $retval;
                }

                function get_cal_bio($cand_id)
                {
                    $retval='';
                    global $site_conn;
                    $conn = Util::get_ctb_conn();
                    $sql = "SELECT text from ctb_cand_bios WHERE cand_id = '$cand_id' ORDER BY date DESC, id DESC LIMIT 1 ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval = $row['text'];
                        }
                    }

                    return $retval;
                }


                ?>

            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script>
      function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight + 25) + 'px';
        obj.style.width = obj.contentWindow.document.body.scrollWidth + 'px';
      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1024pxpx";
        iframe.height = "3800px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv").appendChild(iframe);
        return false;
      }

      function removeiframes() {
        var iframes = document.querySelectorAll('iframe');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }

      function valForm(form, fourcode) {

        var type, datavisappend, electionappend, e1, e2, URL, error = '';
        var URL = 'housevote_bydist.php?id=' + fourcode;


        if (error) {
          alert(URL);
          alert(error);
          return false;
        } else {
          closeiframe();


          var link = "/img/spinner.gif";
          alert(URL);
          window.content.location.href = link;
          document.getElementById("hiddendiv").style["display"] = "inline-block";
          window.content.location.href = URL;
          return false;
        }


      }


    </script>
    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>

@endsection

@section('styles')
<style>

    body {
        background-color: white;
    }

    .dropshadow {
        -webkit-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        -moz-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
    }

    .candpic {
        border-radius: 15px;
    }

    .bio_2 {
        border-radius: 20px;
        -webkit-box-shadow: 8px 8px 20px -8px rgba(0, 0, 0, 0.71);
        -moz-box-shadow: 8px 8px 20px -8px rgba(0, 0, 0, 0.71);
        box-shadow: 8px 8px 20px -8px rgba(0, 0, 0, 0.71);
    }

    .largertext {
        font-size: 1.1em !important;
    }

    .winner {
        font-weight: bold !important;
        font-variant: small-caps !important;
    }

    .primary_div {
        font-family: 'Lato';
        float: left;
        padding: 5px;
        margin: 10px;

    }

    .canddiv {
        background-color: WhiteMist;
        margin-top: 10px;
        padding: 20px;
        font-family: 'Lato';
        line-height: 1.5;
        display: inline-block;
    }

    .canddiv p {
        padding: 10px;
    }

    .canddiv img {
        float: left;
        border-radius: 10px;
        margin: 0px 5px 1px 0px;

    }



/*

    .bluebg {
        background: rgb(235, 241, 246) !important; /* Old browsers */
        background: -moz-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    .redbg {
        background: #f0d4d4; /* Old browsers */
        background: -moz-linear-gradient(top, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f0d4d4', endColorstr='#fefefe', GradientType=0); /* IE6-9 */
    }

    .greybg {
        background: rgb(238, 238, 238); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

*/

    .newseg {
        padding: 30px;
        font-family: 'Lato';
        font-size: 1.2em;
    }

    .bio_div {
        text-align: justify;
        line-height: 1.4;
    }

    h1, p {
        font-family: 'Lato';
        text-align: center;
        font-weight: bold;
    }

    .greenme {
        color: green;
        border-width: 3px;
        border-color: green !important;
    }

    .redme {
        color: red;
        border-width: 3px;
        border-color: red;
    }

    .boldme {
        font-weight: bold;
        border-width: 3px;
    }

    .panel {
        background-color: #fcfcfc;
    }

    .panel-bio p {
        text-align: justify !important;
        font-family: 'Bellefair';
	font-size: 1.4em;
	font-weight: normal;

    }

    .justify_all > * {
        text-align: justify !important;
        width: 100%;
    }

    hr {
        border-width: 3px;
    }

    .cand_votes td {
	padding-left: 5px;
	padding-right: 5px;
	text-align: left;
	
    }  

   .consultants {
	font-size: 1.4em;
	font-family: 'Lato';
   }

   .cand_header {
	font-size: 2.1em;
	font-family: 'Bellefair';
   }

   .largertext th {
	background: transparent;
	}


</style>
@endsection

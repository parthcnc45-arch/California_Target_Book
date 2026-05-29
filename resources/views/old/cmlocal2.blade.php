@extends('layouts.iframe_old')

<?php


if (!isset($_GET['id']) && !isset($id)) {
    redirect()->back();
    exit;
} elseif(isset($id)) {
    $committee = $id;
} elseif(isset($_GET['id'])) {
    $committee = $_GET['id'];
}

Util::require_ctb_api();



$xref = checkxref($committee);
if ($xref) {
    $committee = $xref;
}

$committee_name = getcommitteename($committee);
?>
@section('title', "Campaign Finance Detail for {{$committee_name}}")

@section('content')


    <div class='container' width='100vw' style='background-color: white;'>
        <div class='row'>
            <div class='col-lg-12'>

                <?php

                ini_set('memory_limit', '512M');

                set_time_limit(0);


                $top_lnk = "<p align='center' class='boldme'><a href='#top'>BACK TO TOP</a>";


                $cand_naml = Array();
                $cand_id = Array();
                $comm_id = Array();
                $cand_name = Array();
                $comm_name = Array();
                $endjava = Array();
                $consultants = Array();
                $pollsters = Array();
                $salaried = Array();
                $fundraising = Array();

                $topcontributors = Array();
                $topemployers = Array();
                $topoccupations = Array();
                $topcities = Array();
                $topstates = Array();

                $e00s = 0;
                $e00o = 0;

                $e02s = 0;
                $e02o = 0;

                $e04s = 0;
                $e04o = 0;

                $e06s = 0;
                $e06o = 0;

                $e08s = 0;
                $e08o = 0;

                $e10s = 0;
                $e10o = 0;

                $e12s = 0;
                $e12o = 0;

                $e14s = 0;
                $e14o = 0;

                $e16s = 0;
                $e16o = 0;


                echo("<div class='resultscontainer' id='top'>");

                //PUSH RESULTS INTO CANDIDATE & COMMITTEE ARRAYS

                /*
                        CCCCCCCCCCCCC                  lllllll                                 AAA
                     CCC::::::::::::C                  l:::::l                                A:::A
                   CC:::::::::::::::C                  l:::::l                               A:::::A
                  C:::::CCCCCCCC::::C                  l:::::l                              A:::::::A
                 C:::::C       CCCCCC  aaaaaaaaaaaaa    l::::l                             A:::::::::A            cccccccccccccccc    cccccccccccccccc    eeeeeeeeeeee        ssssssssss       ssssssssss
                C:::::C                a::::::::::::a   l::::l                            A:::::A:::::A         cc:::::::::::::::c  cc:::::::::::::::c  ee::::::::::::ee    ss::::::::::s    ss::::::::::s
                C:::::C                aaaaaaaaa:::::a  l::::l                           A:::::A A:::::A       c:::::::::::::::::c c:::::::::::::::::c e::::::eeeee:::::eess:::::::::::::s ss:::::::::::::s
                C:::::C                         a::::a  l::::l  ---------------         A:::::A   A:::::A     c:::::::cccccc:::::cc:::::::cccccc:::::ce::::::e     e:::::es::::::ssss:::::ss::::::ssss:::::s
                C:::::C                  aaaaaaa:::::a  l::::l  -:::::::::::::-        A:::::A     A:::::A    c::::::c     cccccccc::::::c     ccccccce:::::::eeeee::::::e s:::::s  ssssss  s:::::s  ssssss
                C:::::C                aa::::::::::::a  l::::l  ---------------       A:::::AAAAAAAAA:::::A   c:::::c             c:::::c             e:::::::::::::::::e    s::::::s         s::::::s
                C:::::C               a::::aaaa::::::a  l::::l                       A:::::::::::::::::::::A  c:::::c             c:::::c             e::::::eeeeeeeeeee        s::::::s         s::::::s
                 C:::::C       CCCCCCa::::a    a:::::a  l::::l                      A:::::AAAAAAAAAAAAA:::::A c::::::c     cccccccc::::::c     ccccccce:::::::e           ssssss   s:::::s ssssss   s:::::s
                  C:::::CCCCCCCC::::Ca::::a    a:::::a l::::::l                    A:::::A             A:::::Ac:::::::cccccc:::::cc:::::::cccccc:::::ce::::::::e          s:::::ssss::::::ss:::::ssss::::::s
                   CC:::::::::::::::Ca:::::aaaa::::::a l::::::l                   A:::::A               A:::::Ac:::::::::::::::::c c:::::::::::::::::c e::::::::eeeeeeee  s::::::::::::::s s::::::::::::::s
                     CCC::::::::::::C a::::::::::aa:::al::::::l                  A:::::A                 A:::::Acc:::::::::::::::c  cc:::::::::::::::c  ee:::::::::::::e   s:::::::::::ss   s:::::::::::ss
                        CCCCCCCCCCCCC  aaaaaaaaaa  aaaallllllll                 AAAAAAA                   AAAAAAA cccccccccccccccc    cccccccccccccccc    eeeeeeeeeeeeee    sssssssssss      sssssssssss

                 */

                $committee_name = getcommitteename($committee);                //LOOKUP COMMITTEEE NAME

                $code = identifyrace($committee_name);
                $election = $code['ELECTION'];
                //var_dump($code);
                $office = $code['OFFICE'];
                $code = $code['CODE'];
                $arr = explode(' ', trim($committee_name));
                $lastname = $arr[0];
                $lastname = str_replace(',', '', $lastname);
                //$lastname = $code['NAME'];
                //echo("<br>NAME: $lastname OFFICE: $office: CODE: $code<br>");
                if ($code['GETDIST']) {
                    $tempresult = lookupdist($lastname, $election, $code);
                    $district = $tempresult['DISTRICT'];
                    $party = $tempresult['PARTY'];
                }
                if ($code['ISPARTISAN']) {
                    $tempresult = gettheparty($lastname, $election, $code);
                    $party = $tempresult['PARTY'];
                    $isincumbent = $tempresult['INC'];
                }

                if (!$isincumbent) {
                    $isincumbent = "challenger";
                }

                //echo("<br>Identified $lastname running for $code $district on the $party ticket as $isincumbent<br>");

                if ($district) {
                    $transactions = getie_dist($district, $lastname);
                } else {
                    $transactions = getie_st($office, $lastname);
                }


                $filings = getallf460($committee);                    //RETRIEVE ALL F460 FILINGS


                $time_lnk = "<a href='http://198.74.49.22/st_time_map.php?id=$committee' target='_blank'>Graph Receipts/Expenditures by Date</a>";
                $map_lnk = "<a href='http://198.74.49.22/st_cont_map.php?id=$committee' target='_blank'>Map Top Contributor ZIP Codes</a>";

                $cmte_lnk = "<a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=$committee' target='_blank'>$committee_name</a>";
                $consultants_lnk = "<a href='#consultants'>CONSULTANTS</a>";
                $state_lnk = "<a href='#bystate'>BY STATE</a>";
                $city_lnk = "<a href='#bycity'>BY CITY</a>";
                $emp_lnk = "<a href='#byemployer'>BY EMPLOYER</a>";
                $occ_lnk = "<a href='#byoccupation'>BY OCCUPATION</a>";
                $bycontributor_lnk = "<a href='#bycontributor'>BY GROUP/INDIVIDUAL</a>";

                echo("<div class='newseg'><h1>$cmte_lnk</h1><p class='boldme' align='center'>$map_lnk • $time_lnk<br><br>JUMP TO $consultants_lnk • CONTRIBUTIONS $state_lnk • $city_lnk • $emp_lnk • $occ_lnk • $bycontributor_lnk</p></div>");

                //var_dump($filings);


                $candidates = Array();
                $i = 0;
                $lastf460 = '';
                foreach ($filings as $filing) {
                    $tmp = getf460summary($filing['FILING_ID']);
                    $candidates[$i]['RCPT'] = $tmp['RCPT'];                //THE LAST CAMPAIGN FINANCE STATEMENT
                    $candidates[$i]['EXPN'] = $tmp['EXPN'];                //(RECEIPTS, EXPENDITURES, CASH ON HAND, LOANS, UNPAID BILLS)
                    $candidates[$i]['COH'] = $tmp['COH'];
                    $candidates[$i]['LOANS'] = $tmp['LOANS'];
                    $candidates[$i]['DEBTS'] = $tmp['DEBTS'];
                    $candidates[$i]['FILING_ID'] = $filing['FILING_ID'];
                    $candidates[$i]['COMM_NAME'] = $committee_name;
                    $candidates[$i]['COMM_ID'] = $committee;
                    $candidates[$i]['PD_START'] = $filing['RPT_START'];
                    $candidates[$i]['PD_END'] = $filing['RPT_END'];
                    $candidates[$i]['LAST_F460'] = $filing['FILING_ID'];
                    $candidates[$i]['YTD_RCPT'] = $tmp['YTD_RCPT'];
                    $candidates[$i]['YTD_EXPN'] = $tmp['YTD_EXPN'];

                    if (!$lastf460) {
                        $lastf460 = $filing['FILING_ID'];
                        $last_date = $filing['RPT_END'];
                        $last_date_start = $filing['RPT_START'];
                    }
                    //echo("<br>Processing filing# " . $filing['FILING_ID']);
                    $i++;
                }

                //GET ALL CONTRIBUTIONS SINCE THE END OF THE LAST FILING PERIOD FOR EACH CANDIDATE

                $f497_all = Array();
                $f497_all = getallf497($committee, $last_date);

                $f497_made = getf497given2($committee, $last_date);
                //echo("<br>RESULTS FROM running getf497given2 on CMTE# $committee after $last_date:<br>");
                //var_dump($f497_made);

                $f496_exp = Array();
                $f496_exp = loadf496($committee, $last_date);

                //GET TOTALS AND DETAILS FROM EACH FILING

                $i = 0;
                $j = 0;
                $k = 0;
                $f497_detail = Array();
                $total = 0;
                $entries = Array();
                $tmp_array = Array();

                foreach ($f497_all as $filing2) {                                    //CYCLE THROUGH EACH OF THE RETRIEVED F497 FILINGS
                    $tmp = getf497amt($filing2, $last_date);
                    //echo("<br>Processing F497 fiing $filing2");
                    array_push($tmp_array, $tmp);                                    //AND PUSH THE AMOUNTS ONTO A TEMPORARY ARRAY
                }
                $j = 0;

                foreach ($tmp_array as $value) {                                        //ADD UP THE TOTAL FROM THE AMOUNTS
                    foreach ($tmp_array[$j] as $value2) {
                        $total += $value2['AMOUNT'];
                        array_push($entries, $value2);                                //AND PUSH EACH ENTRY ONTO THE FINAL ARRAY
                    }
                    $j++;
                }

                $candidates[$i]['RAISED_SINCE'] = $total;                            //ADD THE TOTAL 'RAISED SINCE' TO THE CANDIDATE'S ARRAY
                if ($total > 0) {
                    $candidates[$i]['LATE_CONTRIBUTIONS'] = TRUE;
                } else {
                    $candidates[$i]['LATE_CONTRIBUTIONS'] = FALSE;
                }
                array_push($f497_detail, $entries);                                    //AND STORE ALL THE ENTRIES IN THE F497_DETAIL ARRAY

                //echo("<br>");
                //var_dump($f497_detail);


                //GET ALL MONETARY CONTRIBUTIONS FROM LAST F460

                $f460a_detail = Array();
                $i = 0;
                foreach ($filings as $filing) {
                    $tmp = getf460a($filing['FILING_ID']);
                    array_push($f460a_detail, $tmp);
                    $i++;
                }

                //GET ALL NON MONETARY CONTRIBUTIONS FROM LAST F460

                $f460c_detail = Array();
                $i = 0;
                foreach ($filings as $filing) {
                    $tmp = getf460c($filing['FILING_ID']);
                    array_push($f460c_detail, $tmp);
                    $i++;
                }

                //GET EXPENDITURES

                $f460e_detail = Array();
                $i = 0;
                foreach ($filings as $filing) {
                    $tmp = getf460e($filing['FILING_ID']);
                    array_push($f460e_detail, $tmp);
                    $i++;
                }


                /*

                DDDDDDDDDDDDD
                D::::::::::::DDD
                D:::::::::::::::DD
                DDD:::::DDDDD:::::D
                  D:::::D    D:::::D rrrrr   rrrrrrrrr   aaaaaaaaaaaaawwwwwww           wwwww           wwwwwww
                  D:::::D     D:::::Dr::::rrr:::::::::r  a::::::::::::aw:::::w         w:::::w         w:::::w
                  D:::::D     D:::::Dr:::::::::::::::::r aaaaaaaaa:::::aw:::::w       w:::::::w       w:::::w
                  D:::::D     D:::::Drr::::::rrrrr::::::r         a::::a w:::::w     w:::::::::w     w:::::w
                  D:::::D     D:::::D r:::::r     r:::::r  aaaaaaa:::::a  w:::::w   w:::::w:::::w   w:::::w
                  D:::::D     D:::::D r:::::r     rrrrrrraa::::::::::::a   w:::::w w:::::w w:::::w w:::::w
                  D:::::D     D:::::D r:::::r           a::::aaaa::::::a    w:::::w:::::w   w:::::w:::::w
                  D:::::D    D:::::D  r:::::r          a::::a    a:::::a     w:::::::::w     w:::::::::w
                DDD:::::DDDDD:::::D   r:::::r          a::::a    a:::::a      w:::::::w       w:::::::w
                D:::::::::::::::DD    r:::::r          a:::::aaaa::::::a       w:::::w         w:::::w
                D::::::::::::DDD      r:::::r           a::::::::::aa:::a       w:::w           w:::w
                DDDDDDDDDDDDD         rrrrrrr            aaaaaaaaaa  aaaa        www             www

                */


                $drawtabhead = '<div class="tabcontainer">
				<ul class="tabs2">
';

                echo($drawtabhead);

                $i = 0;
                foreach ($filings as $filing) {
                    if ($i == 0) {
                        echo("<li class='tab-link current' data-tab='tab-$i'>" . $filing['RPT_START'] . " - " . $filing['RPT_END'] . "</li>");
                    } else {
                        echo("<li class='tab-link' data-tab='tab-$i'>" . $filing['RPT_START'] . " - " . $filing['RPT_END'] . "</li>");
                    }
                    $i++;
                }
                echo("</ul>");

                $i = 0;
                $raised_since_constant = 0;
                foreach ($filings as $value) {

                    if ($candidates[$i]['RAISED_SINCE']) {
                        $raised_since_constant = $candidates[$i]['RAISED_SINCE'];
                    }

                    $drawall = '';

                    if ($i == 0) {
                        $iscurrent = "current";
                    } else {
                        $iscurrent = "";
                    }

                    echo("<section class='thickborder tab-content $iscurrent' id='tab-$i'>");

                    echo("<h1><a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=" . $candidates[$i]['CAND_ID'] . "' target='_blank'>" . $candidates[$i]['FULLNAME'] . "</a></h1>");
                    echo("<div class='newseg' style='margin-top: 300px;'>");


                    if ($candidates[$i]['PD_START'] == '') {
                        $appendme1 = "<h3 align = 'center'><a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $candidates[$i]['COMM_ID'] . "' target='_blank'>" . $candidates[$i]['COMM_NAME'] . "</a> LAST F460: NONE FILED YET</h3>";
                    } else {
                        $appendme1 = "<h3 align = 'center'><a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $candidates[$i]['COMM_ID'] . "' target='_blank'>" . $candidates[$i]['COMM_NAME'] . "</a> LAST F460: <a href='http://cal-access.ss.ca.gov/PDFGen/pdfgen.prg?filingid=" . $lastf460 . "' target='_blank''>" . $lastf460 . "</a>   " . date("F d Y", strtotime($last_date_start)) . " - " . date("F d Y", strtotime($last_date)) . "</h3>";
                    }

                    echo($appendme1);

                    $drawme = "
		<table id=\"cand" . $i . "_f497\" class='tablesaw tablesaw-stack bordered tablesorter' data-tablesaw-mode='stack' cellspacing = \"0\">
			<thead>
				<tr class='boldme'>
					<th>\$ RAISED YTD</th>
					<th>\$ RAISED THIS PERIOD</th>
					<th>\$ RAISED SINCE PD END</th>
					<th>\$ SPENT THIS PERIOD</b></th>
					<th>\$ SPENT YTD</th>
					<th>ENDING CASH ON HAND</th>
					<th>TOTAL LOANS</th>
					<th>DEBTS</th>
				</tr>
			</thead>
			<tbody>


				<tr class = 'blueme boldme'>
					<td align = 'center'>\$" . number_format($candidates[$i]['YTD_RCPT'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['RCPT'], 2) . "</td>
					<td align = 'center'>\$" . number_format($raised_since_constant, 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['EXPN'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['YTD_EXPN'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['COH'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['LOANS'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['DEBTS'], 2) . "</td>
				</tr>

			</tbody>
		</table>";
                    echo($drawme);
                    $nocommitteedata = FALSE;


                    echo("</div>");

                    if ($candidates[$i]['LATE_CONTRIBUTIONS']) {

                        $thisid = "cand_" . $i . "_f497_cont";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<div class='newseg'><h2 align = 'center'>CONTRIBUTIONS RECEIVED SINCE END OF LAST FILING PERIOD</h2>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'} amount\">AMOUNT</th>
					<th>DONOR</th>
					<th>EMPLOYER</th>
					<th>OCCUPATION</th>
					<th>CITY</th>
					<th>STATE</th>
					<th>ZIP</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>

		";

                        echo($drawme1);

                        //echo("f497 Detail:<br>");
                        //var_dump($f497_detail);


                        $j = 0;
                        foreach ($f497_detail[$i] as $entry2) {
                            $cmte_id = '';
                            if ($entry2['ENTY_NAMF']) {
                                $name = $entry2['ENTY_NAMF'] . " " . $entry2['ENTY_NAML'];
                            } else {
                                $name = $entry2['ENTY_NAMF'] . $entry2['ENTY_NAML'];
                            }
                            if ($entry2['CMTE_ID']) {

                                $x = checkxref($entry2['CMTE_ID']);
                                if ($x) {
                                    $cmte_id = $x;
                                } else {
                                    $cmte_id = $entry2['CMTE_ID'];
                                }


                                $name = "<a href='http://198.74.49.22/cmlocal2.php?id=$cmte_id' target='_blank'>$name</a>";
                            }
                            if ($entry2['AMOUNT']) {
                                $drawme = "
						<tr>
							<td>" . $entry2['CTRIB_DATE'] . "</td>
							<td class='align_right'>\$" . (float)$entry2['AMOUNT'] . fullnum((float)$entry2['AMOUNT']) . "</td>
							<td>" . $name . "</td>
							<td>" . $entry2['CTRIB_EMP'] . "</td>
							<td>" . $entry2['CTRIB_OCC'] . "</td>

							<td>" . $entry2['ENTY_CITY'] . "</td>
							<td>" . $entry2['ENTY_ST'] . "</td>
							<td>" . $entry2['ENTY_ZIP4'] . "</td>
							<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $entry2['FILING'] . "' target='_blank'>" . $entry2['FILING'] . "</a></td>

						</tr>
				";
                                echo($drawme);

                                $amt = $entry2['AMOUNT'];
                                $city = strtoupper($entry2['ENTY_CITY']);
                                $st = $entry2['ENTY_ST'];
                                $emp = strtoupper($entry2['CTRIB_EMP']);
                                $occ = strtoupper($entry2['CTRIB_OCC']);

                                $topcontributors[$name]['NAME'] = $name;
                                $topcontributors[$name]['AMOUNT'] += $amt;

                                $topstates[$st]['NAME'] = $st;
                                $topstates[$st]['AMOUNT'] += $amt;

                                $topcities[$city]['NAME'] = $city;
                                $topcities[$city]['AMOUNT'] += $amt;

                                if ($occ) {
                                    $topoccupations[$occ]['NAME'] = $occ;
                                    $topoccupations[$occ]['AMOUNT'] += $amt;
                                }

                                if ($emp) {
                                    $topemployers[$emp]['NAME'] = $emp;
                                    $topemployers[$emp]['AMOUNT'] += $amt;
                                }

                                $lifetimeraised += $amt;

                                if ($cmte_id) {
                                    $lifetimecommittee += $amt;
                                }


                            }


                            $j++;
                        }


                        echo("				</tbody>
			</table></div>");
                    } //END LATE CONTRIBUTIONS CHECK

                    if ($f497_made) {

                        $thisid = "cand_" . $i . "_f497_made";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<div class='newseg'><h2 align = 'center'>LATE CONTRIBUTIONS MADE SINCE END OF LAST FILING PERIOD</h2>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'} amount\">AMOUNT</th>
					<th>RECIPIENT</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>

		";

                        echo($drawme1);

                        //echo("f497 Detail:<br>");
                        //var_dump($f497_detail);


                        $j = 0;
                        foreach ($f497_made as $entry2) {


                            $name = $entry2['NAME'];
                            if ($entry2['CMTE_ID']) {
                                $name = "<a href='/book/cmlocal2.php?id=" . $entry2['CMTE_ID'] . "' target='_blank'>" . $entry2['NAME'] . "</a>";
                            }
                            if ($entry2['AMOUNT']) {
                                $drawme = "
						<tr>
							<td>" . $entry2['CTRIB_DATE'] . "</td>
							<td class='align_right'>\$" . (float)$entry2['AMOUNT'] . fullnum((float)$entry2['AMOUNT']) . "</td>
							<td>" . $name . "</td>
							<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $entry2['FILING_ID'] . "' target='_blank'>" . $entry2['FILING_ID'] . "</a></td>

						</tr>
				";
                                echo($drawme);
                            }

                            $j++;
                        }


                        echo("				</tbody>
			</table></div>");
                    } //END LATE CONTRIBUTIONS CHECK

                    if ($f496_exp) {

                        $thisid = "cand_" . $i . "_f496_exp";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<div class='newseg'><h2 align = 'center'>LATE EXPENDITURES SINCE END OF LAST FILING PERIOD</h2>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'} amount\">AMOUNT</th>
					<th>REASON</th>
					<th>RACE</th>
					<th>S/O</th>
					<th>CANDIDATE/MEASURE</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>

		";

                        echo($drawme1);

                        foreach ($f496_exp as $filing) {

                            foreach ($filing as $entry) {
                                $link = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $entry['FILING'] . "' target='_blank'>" . $entry['FILING'] . "</a>";
                                $stuff = getf496detail($entry['FILING']);
                                $candidate = $stuff['CAND_NAML'];
                                if (!$candidate) {
                                    $candidate = $stuff['BAL_NAME'];
                                }
                                $type = $stuff['JURIS_CD'];
                                $dist = $stuff['DIST_NO'];
                                $supopp = $stuff['SUP_OPP_CD'];

                                $mergeddist = $type . " " . $dist;
                                switch ($supopp) {
                                    case "S":
                                        $supoppdetail = "to Support";
                                        break;
                                    case "O":
                                        $supoppdetail = "to Oppose";
                                        break;
                                    default:
                                        $supoppdeatil = '';
                                }
                                $drawme = "
				<tr>
					<td>" . $entry['EXP_DATE'] . "</td>
					<td class='align_right'>" . $entry['AMOUNT'] . "</td>
					<td>" . $entry['EXPN_DSCR'] . "</td>
					<td>" . $mergeddist . "</td>
					<td>" . $supoppdetail . "</td>
					<td>" . $candidate . "</td>
					<td>" . $link . "</td>
				</tr>
			";
                                echo($drawme);
                            }
                            //var_dump($entry);

                        }

                        echo("</tbody>
			</table></div>");
                    } //END LATE CONTRIBUTIONS CHECK


                    if ($nocommitteedata == FALSE) {

                        $thisid = "cand_" . $i . "_f460a_cont";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);


                        echo("<div class='newseg'><h2 align = 'center'>MONETARY CONTRIBUTIONS - LAST CAMPAIGN STATEMENT</h2>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
		<thead>
			<tr>
				<th class='date'>DATE</th>
				<th>AMOUNT</th>
				<th>YTD</th>
				<th>DONOR</th>
				<th>?</th>
				<th>EMPLOYER</th>
				<th>OCCUPATION</th>
				<th>CITY</th>
				<th>STATE</th>
				<th>ZIP</th>
				<th>FILING</th>
			</tr>
		</thead>
		<tbody>


		";

                        echo($drawme1);

                        $j = 0;
                        $k = 0;
                        //foreach($f460a_detail as $bycand) {
                        $j = 0;
                        foreach ($f460a_detail[$i] as $entry) {
                            $cmte_id = '';
                            //echo("<br>Amount: " . $f460a_detail[$i][$j]['AMOUNT']);
                            if ($f460a_detail[$i][$j]['AMOUNT']) {
                                if ($f460a_detail[$i][$j]['CTRIB_NAMF']) {
                                    $name = $f460a_detail[$i][$j]['CTRIB_NAML'] . ", " . $f460a_detail[$i][$j]['CTRIB_NAMF'];
                                } else {
                                    $name = $f460a_detail[$i][$j]['CTRIB_NAML'];
                                }
                                if ($f460a_detail[$i][$j]['CMTE_ID']) {
                                    $src_link = '';
                                    $x = checkxref($f460a_detail[$i][$j]['CMTE_ID']);
                                    if ($x) {
                                        $cmte_id = $x;
                                    } else {
                                        $cmte_id = $f460a_detail[$i][$j]['CMTE_ID'];
                                    }
                                    $name = "<a href='http://198.74.49.22/cmlocal2.php?id=" . $cmte_id . "' target='_blank'>$name</a>";
                                } else {
                                    $src_link = "<a href='http://198.74.49.22/srch_donor.php?id=" . cleanup($name) . "' target='_blank'>?</a>";
                                }
                                $drawme = "
						<tr>
							<td>" . $f460a_detail[$i][$j]['RCPT_DATE'] . "</td>
							<td class='align_right'>\$" . (float)$f460a_detail[$i][$j]['AMOUNT'] . fullnum((float)$f460a_detail[$i][$j]['AMOUNT']) . "</td>
							<td class='align_right' class=\"{sorter: 'currency'}\">\$" . (float)$f460a_detail[$i][$j]['CUM_YTD'] . fullnum((float)$f460a_detail[$i][$j]['CUM_YTD']) . "</td>
							<td>" . $name . "</td>
							<td>$src_link</td>
							<td>" . $f460a_detail[$i][$j]['CTRIB_EMP'] . "</td>
							<td>" . $f460a_detail[$i][$j]['CTRIB_OCC'] . "</td>

							<td>" . $f460a_detail[$i][$j]['CTRIB_CITY'] . "</td>
							<td>" . $f460a_detail[$i][$j]['CTRIB_ST'] . "</td>
							<td>" . mb_substr($f460a_detail[$i][$j]['CTRIB_ZIP4'], 0, 5) . "</td>
							<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $f460a_detail[$i][$j]['FILING_ID'] . "' target='_blank'>" . $f460a_detail[$i][$j]['FILING_ID'] . "</a></td>
						</tr>
				";
                                echo($drawme);

                                $amt = $f460a_detail[$i][$j]['AMOUNT'];
                                $city = strtoupper($f460a_detail[$i][$j]['CTRIB_CITY']);
                                $st = $f460a_detail[$i][$j]['CTRIB_ST'];
                                $emp = strtoupper($f460a_detail[$i][$j]['CTRIB_EMP']);
                                $occ = strtoupper($f460a_detail[$i][$j]['CTRIB_OCC']);

                                $topcontributors[$name]['NAME'] = $name;
                                $topcontributors[$name]['AMOUNT'] += $amt;

                                $topstates[$st]['NAME'] = $st;
                                $topstates[$st]['AMOUNT'] += $amt;

                                $topcities[$city]['NAME'] = $city;
                                $topcities[$city]['AMOUNT'] += $amt;

                                if ($occ) {
                                    $topoccupations[$occ]['NAME'] = $occ;
                                    $topoccupations[$occ]['AMOUNT'] += $amt;
                                }

                                if ($emp) {
                                    $topemployers[$emp]['NAME'] = $emp;
                                    $topemployers[$emp]['AMOUNT'] += $amt;
                                }

                                $lifetimeraised += $amt;


                                if ($cmte_id) {
                                    $lifetimecommittee += $amt;
                                }

                            }
                            $j++;
                        }
                        //}

                        echo("				</tbody>
			</table></div>");


                        echo("<div class='newseg'><h2 align = 'center'>NON-MONETARY CONTRIBUTIONS - LAST CAMPAIGN STATEMENT</h2>");
                        $thisid = "cand_" . $i . "_f460c_cont";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<script src='text/javascript'>");

                        echo("$(function() {
    $('#$thisid').tablesorter({
        headers: {
            1: {//zero-based column index
                sorter:'thousands'
            }
            2 : {//zero-based column index
                sorter:'thousands'
            }
        }
    });
});

	");
                        echo("</script>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"amount {sorter: 'thousands'}\">AMOUNT</th>
					<th class=\"amount {sorter: 'thousands'}\">YTD</th>
					<th>DONOR</th>
					<th>EMPLOYER</th>
					<th>OCCUPATION</th>
					<th>CITY</th>
					<th>STATE</th>
					<th>ZIP</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>
		";

                        echo($drawme1);

                        $j = 0;
                        foreach ($f460c_detail[$i] as $entry) {
                            //echo("<br>($i)($j) Amount: " . $f460c_detail[$i][$j]['AMOUNT']);
                            $cmte_id = '';
                            if ($f460c_detail[$i][$j]['AMOUNT']) {
                                if ($f460c_detail[$i][$j]['CTRIB_NAMF']) {
                                    $name = $f460c_detail[$i][$j]['CTRIB_NAML'] . ", " . $f460c_detail[$i][$j]['CTRIB_NAMF'];
                                } else {
                                    $name = $f460c_detail[$i][$j]['CTRIB_NAML'];
                                }

                                if ($f460c_detail[$i][$j]['CMTE_ID']) {
                                    $x = checkxref($f460c_detail[$i][$j]['CMTE_ID']);
                                    if ($x) {
                                        $cmte_id = $x;
                                    } else {
                                        $cmte_id = $f460c_detail[$i][$j]['CMTE_ID'];
                                    }
                                    $name = "<a href='http://198.74.49.22/cmlocal2.php?id=" . $cmte_id . "' target='_blank'>$name</a>";
                                }

                                $drawme = "
						<tr>
							<td>" . $f460c_detail[$i][$j]['RCPT_DATE'] . "</td>
							<td align='right' class=\"{sorter: 'thousands'}\">\$" . (float)$f460c_detail[$i][$j]['AMOUNT'] . fullnum((float)$f460c_detail[$i][$j]['AMOUNT']) . "</td>
							<td align='right' class=\"{sorter: 'thousands'}\">\$" . (float)$f460c_detail[$i][$j]['CUM_YTD'] . fullnum((float)$f460c_detail[$i][$j]['CUM_YTD']) . "</td>
							<td>" . $name . "</td>
							<td>" . $f460c_detail[$i][$j]['CTRIB_EMP'] . "</td>
							<td>" . $f460c_detail[$i][$j]['CTRIB_OCC'] . "</td>
							<td>" . $f460c_detail[$i][$j]['CTRIB_CITY'] . "</td>
							<td>" . $f460c_detail[$i][$j]['CTRIB_ST'] . "</td>
							<td>" . $f460c_detail[$i][$j]['CTRIB_ZIP4'] . "</td>
							<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $f460c_detail[$i][$j]['FILING_ID'] . "' target='_blank'>" . $f460c_detail[$i][$j]['FILING_ID'] . "</a></td>
						</tr>
				";
                                echo($drawme);

                                $amt = $f460c_detail[$i][$j]['AMOUNT'];
                                $city = strtoupper($f460c_detail[$i][$j]['CTRIB_CITY']);
                                $st = $f460c_detail[$i][$j]['CTRIB_ST'];
                                $emp = strtoupper($f460c_detail[$i][$j]['CTRIB_EMP']);
                                $occ = strtoupper($f460c_detail[$i][$j]['CTRIB_OCC']);

                                $topcontributors[$name]['NAME'] = $name;
                                $topcontributors[$name]['AMOUNT'] += $amt;

                                $topstates[$st]['NAME'] = $st;
                                $topstates[$st]['AMOUNT'] += $amt;

                                $topcities[$city]['NAME'] = $city;
                                $topcities[$city]['AMOUNT'] += $amt;

                                if ($occ) {
                                    $topoccupations[$occ]['NAME'] = $occ;
                                    $topoccupations[$occ]['AMOUNT'] += $amt;
                                }

                                if ($emp) {
                                    $topemployers[$emp]['NAME'] = $emp;
                                    $topemployers[$emp]['AMOUNT'] += $amt;
                                }

                                $lifetimeraised += $amt;


                                if ($cmte_id) {
                                    $lifetimecommittee += $amt;
                                }

                            }
                            $j++;
                        }


                        echo("				</tbody>
			</table></div>");


                        echo("<div class='newseg'><h2 align = 'center'>EXPENDITURES - LAST CAMPAIGN STATEMENT</h2>");

                        $thisid = "cand_" . $i . "_f460e_exp";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<script src='text/javascript'>");

                        echo("$(function() {
    $('#$thisid').tablesorter({
        headers: {
            1: {//zero-based column index
                sorter:'thousands'
            }
            2 : {//zero-based column index
                sorter:'thousands'
            }
        }
    });
});

	");
                        echo("</script>");

                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'}\">AMOUNT</th>
					<th>PAYEE</th>
					<th>?</th>
					<th>CODE</th>
					<th>CITY</th>
					<th>STATE</th>
					<th>ZIP</th>
					<th>DESCRIPTION</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>
		";

                        echo($drawme1);

                        $j = 0;
                        $tmptotal = 0;
                        $lastname = '';
                        $expdetail = Array();
                        $tmpexp = Array();
                        foreach ($f460e_detail[$i] as $entry) {
                            //echo("<br>($i)($j) Amount: " . $f460c_detail[$i][$j]['AMOUNT']);
                            if ($f460e_detail[$i][$j]['AMOUNT']) {
                                if ($f460e_detail[$i][$j]['PAYEE_NAMF']) {
                                    $name = $f460e_detail[$i][$j]['PAYEE_NAML'] . ", " . $f460e_detail[$i][$j]['PAYEE_NAMF'];
                                } else {
                                    $name = $f460e_detail[$i][$j]['PAYEE_NAML'];
                                }
                                if ($f460e_detail[$i][$j]['CMTE_ID']) {
                                    $x = checkxref($f460e_detail[$i][$j]['CMTE_ID']);
                                    if ($x) {
                                        $cmte_id = $x;
                                    } else {
                                        $cmte_id = $f460e_detail[$i][$j]['CMTE_ID'];
                                    }
                                    $name = "<a href='http://198.74.49.22/cmlocal2.php?id=" . $cmte_id . "' target='_blank'>$name</a>";
                                    $src_link = '';
                                } else {
                                    $src_link = "<a href='http://198.74.49.22/srch_exp.php?id=" . cleanup($name) . "' target='_blank'>?</a>";
                                }

                                $thisname = $name;

                                $thiscode = $f460e_detail[$i][$j]['EXPN_CODE'];
                                if (!$thiscode) {
                                    $thiscode = "N/A";
                                }

                                $exp_by_code[$thiscode]['AMOUNT'] += $f460e_detail[$i][$j]['AMOUNT'];
                                $exp_by_code[$thiscode]['CODE'] = $thiscode;
                                $total_expcode += $f460e_detail[$i][$j]['AMOUNT'];

                                $exp_by_vendor[$name]['AMOUNT'] += $f460e_detail[$i][$j]['AMOUNT'];
                                $exp_by_vendor[$name]['NAME'] = $name;


                                if ($thisname == $lastname || $lastname == '') {
                                    $tmptotal += $f460e_detail[$i][$j]['AMOUNT'];
                                } else {
                                    $tmpexp['NAME'] = $lastname;
                                    $tmpexp['AMOUNT'] = $tmptotal;
                                    array_push($expdetail, $tmpexp);
                                    $tmptotal = $f460e_detail[$i][$j]['AMOUNT'];

                                }

                                if ($f460e_detail[$i][$j]['EXPN_CODE'] == "CNS") {
                                    $consultants[$name]['NAME'] = $name;
                                    $consultants[$name]['AMOUNT'] += $f460e_detail[$i][$j]['AMOUNT'];
                                }

                                if ($f460e_detail[$i][$j]['EXPN_CODE'] == "POL") {
                                    $pollsters[$name]['NAME'] = $name;
                                    $pollsters[$name]['AMOUNT'] += $f460e_detail[$i][$j]['AMOUNT'];
                                }

                                if ($f460e_detail[$i][$j]['EXPN_CODE'] == "SAL") {
                                    $salaried[$name]['NAME'] = $name;
                                    $salaried[$name]['AMOUNT'] += $f460e_detail[$i][$j]['AMOUNT'];
                                }

                                if ($f460e_detail[$i][$j]['EXPN_CODE'] == "FND") {
                                    $fundraising[$name]['NAME'] = $name;
                                    $fundraising[$name]['AMOUNT'] += $f460e_detail[$i][$j]['AMOUNT'];
                                }

                                $lifetimespent += $f460e_detail[$i][$j]['AMOUNT'];


                                $drawme = "
						<tr>
							<td>" . $f460e_detail[$i][$j]['EXPN_DATE'] . "</td>
							<td align='right' class=\"amount {sorter: 'thousands'}\">\$" . (float)$f460e_detail[$i][$j]['AMOUNT'] . fullnum((float)$f460e_detail[$i][$j]['AMOUNT']) . "</td>
							<td>" . $name . "</td>
							<td>$src_link</td>
							<td>" . $f460e_detail[$i][$j]['EXPN_CODE'] . "</td>
							<td>" . $f460e_detail[$i][$j]['PAYEE_CITY'] . "</td>
							<td>" . $f460e_detail[$i][$j]['PAYEE_ST'] . "</td>
							<td>" . $f460e_detail[$i][$j]['PAYEE_ZIP4'] . "</td>
							<td>" . $f460e_detail[$i][$j]['EXPN_DSCR'] . "</td>
							<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $f460e_detail[$i][$j]['FILING_ID'] . "' target='_blank'>" . $f460e_detail[$i][$j]['FILING_ID'] . "</a></td>
						</tr>
				";
                                echo($drawme);
                            }
                            $lastname = $name;
                            $j++;
                        }
                        $tmpexp['NAME'] = $lastname;
                        $tmpexp['AMOUNT'] = $tmptotal;
                        array_push($expdetail, $tmpexp);
                        echo("</tbody></table>");
                        $drawexpcode = "
		<table class='bordered2'>
			<tbody>
				<tr>
				</tr>

				<tr>
					<td>CMP</td>
					<td>Campaign Paraphenalia</td>
					<td>CNS</td>
					<td>Consultants</td>
					<td>CTB</td>
					<td>Contribution</td>
					<td>CVC</td>
					<td>Civic Donation</td>
				</tr>

				<tr>
					<td>FIL</td>
					<td>Filing/Ballot Fees</td>
					<td>FND</td>
					<td>Fundraising Events</td>
					<td>IND</td>
					<td>Independent Expenture</td>
					<td>LEG</td>
					<td>Legal Defense</td>
				</tr>

				<tr>
					<td>LIT</td>
					<td>Campaign Literature/Mailings</td>
					<td>MBR</td>
					<td>Member Communications</td>
					<td>MTG</td>
					<td>Meetings & Appearances</td>
					<td>OFC</td>
					<td>Office Expenses</td>
				</tr>

				<tr>
					<td>PET</td>
					<td>Petition Circulating</td>
					<td>PHO</td>
					<td>Phone Banks</td>
					<td>POL</td>
					<td>Polling & Research</td>
					<td>POS</td>
					<td>Postage</td>
				</tr>

				<tr>
					<td>PRO</td>
					<td>Professional Services</td>
					<td>PRT</td>
					<td>Print Ads</td>
					<td>RAD</td>
					<td>Radio Airtime</td>
					<td>RFD</td>
					<td>Refunded Contributions</td>
				</tr>

				<tr>
					<td>SAL</td>
					<td>Campaign Workers Salaries</td>
					<td>TEL</td>
					<td>TV Airtime</td>
					<td>TRC</td>
					<td>Candidate Travel</td>
					<td>TRS</td>
					<td>Staff/Spouse Travel</td>
				</tr>

				<tr>
					<td>TSF</td>
					<td>Transfer between Committees</td>
					<td>VOT</td>
					<td>Voter Registration</td>
					<td>WEB</td>
					<td>Internet/Email Costs</td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</table>
		";

                        echo($drawexpcode);


                        echo("</div>");

                        if ($expdetail) {
                            echo("<div class='newseg'><h2 align = 'center'>EXPENDITURE SUMMARY</h2>");
                            $thisid = "cand_" . $i . "_f460e_exp_sum";

                            $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                            array_push($endjava, $js);

                            $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th>PAYEE</th>
					<th>AMOUNT</th>
				</tr>
			</thead>
			<tbody>
		";
                            echo($drawme1);

                            foreach ($expdetail as $entry) {

                                $drawme = "
			<tr>
				<td>" . $entry['NAME'] . "</td>
				<td>\$" . (float)$entry['AMOUNT'] . fullnum((float)$entry['AMOUNT']) . "</td>
			</tr>
		";
                                //(float)$f460e_detail[$i][$j]['AMOUNT'] . fullnum((float)$f460e_detail[$i][$j]['AMOUNT'])
                                echo($drawme);

                            }
                            echo("</tbody></table>");
                            echo("</div>");
                        }

                        if ($ie_committees[$i]) {
                            echo("<div class='newseg'><h2 align = 'center'>INDEPENDENT EXPENDITURES AFFECTING THIS CANDIDATE</h2>");

                            $j = 0;
                            $k = 0;
                            $l = 0;
                            $j = 0;

                            foreach ($ie_committees[$i] as $committee) {
                                $g = 0;
                                $p = 0;
                                $k = 0;
                                $total = 0;

                                if ($ie_committees[$i][$j]['FILER_NAMF']) {
                                    $filername = $ie_committees[$i][$j]['FILER_NAMF'] . " " . $ie_committees[$i][$j]['FILER_NAML'];
                                } else {
                                    $filername = $ie_committees[$i][$j]['FILER_NAML'];
                                }

                                if ($ie_committees[$i][$j]['CAND_NAMF']) {
                                    $candname = $ie_committees[$i][$j]['CAND_NAMF'] . " " . $ie_committees[$i][$j]['CAND_NAML'];
                                } else {
                                    $candname = $ie_committees[$i][$j]['CAND_NAML'];
                                }

                                if ($ie_committees[$i][$j]['SUP_OPP_CD'] == "S") {
                                    $position = "<span class='greenme'>IN SUPPORT OF</span>";
                                } elseif ($ie_committees[$i][$j]['SUP_OPP_CD'] == 'O') {
                                    $position = "<span class='redme'>IN OPPOSITION TO</span>";
                                } else {
                                    $position = '';
                                }
                                $thisid = "cand_" . $i . "_comm_" . $j;

                                $js = "$(document).ready(function() {
		    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
		});";

                                array_push($endjava, $js);


                                $drawhead = "
		<div class='newseg'>
			<h1><a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $ie_committees[$i][$j]['FILER_ID'] . "' target='_blank'>" . $filername . "</a></h1>
		    <h2>" . $position . " " . $candname . "</h2>";

                                $drawtablehead = "
			<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
				<thead>
					<tr>
						<th class='date'>DATE</th>
						<th class='amount'>AMOUNT</th>
						<th>DESCRIPTION</th>
						<th>FILING</th>
					</tr>
				</thead>
				<tbody>

			";
                                echo($drawhead);
                                echo($drawtablehead);
                                foreach ($f496_detail[$i][$j] as $filing) {
                                    $l = 0;
                                    foreach ($f496_detail[$i][$j][$k] as $entry) {
                                        $drawtablebody = "
					<tr>
						<td>" . $f496_detail[$i][$j][$k][$l]['EXP_DATE'] . "</td>
						<td class='align_right'>\$" . (float)$f496_detail[$i][$j][$k][$l]['AMOUNT'] . fullnum((float)$f496_detail[$i][$j][$k][$l]['AMOUNT']) . "</td>
						<td>" . $f496_detail[$i][$j][$k][$l]['EXPN_DSCR'] . "</td>
						<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $f496_detail[$i][$j][$k][$l]['FILING'] . "' target='_blank'>" . $f496_detail[$i][$j][$k][$l]['FILING'] . "</a></td>
					</tr>

					";
                                        echo($drawtablebody);
                                        $total += $f496_detail[$i][$j][$k][$l]['AMOUNT'];
                                        if ($f496_detail[$i][$j][$k][$l]['EXP_DATE'] > $candidates[$i]['PRIMARY_DT']) {
                                            $g += $f496_detail[$i][$j][$k][$l]['AMOUNT'];
                                        } else {
                                            $p += $f496_detail[$i][$j][$k][$l]['AMOUNT'];
                                        }
                                        $l++;
                                    }
                                    $k++;
                                }
                                $drawenddiv = "
				</tbody>
			</table>
		</div>";
                                echo($drawenddiv);
                                $appendme = '';
                                if ($p) {
                                    $appendme = "<h2 class='grayme'><span>\$" . number_format($p, 2) . "</span> SPENT IN PRIMARY ELECTION</h2>";
                                }

                                if ($g) {
                                    $appendme .= "<h2 class'grayme'><span>\$" . number_format($g, 2) . "</span> SPENT IN GENERAL/RUN-OFF ELECTION</h2>";
                                }
                                echo("<div class='newseg'>
			<h2>" . $appendme . "</h2>
			<h1 class='blueme boldme'>CUMULATIVE TOTAL: \$" . number_format($total, 2) . "</h1></div>");
                                $racetotal += $total;
                                $j++;
                            }
                        }


                        $i++;
                        echo("</section>");
                        echo("</div>");
                        echo("</div>");
                        echo("</section>");
                    }

                }//END DISTRICT THINGY
                echo("</section>");

                $i = 0;

                if (!$filings) {
                    echo("<div class='newseg'>");

                    if ($candidates[$i]['PD_START'] == '') {
                        $appendme1 = "<h3 align = 'center'><a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $candidates[$i]['COMM_ID'] . "' target='_blank'>" . $candidates[$i]['COMM_NAME'] . "</a> LAST F460: NONE FILED YET</h3>";
                    } else {
                        $appendme1 = "<h3 align = 'center'><a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $candidates[$i]['COMM_ID'] . "' target='_blank'>" . $candidates[$i]['COMM_NAME'] . "</a> LAST F460: <a href='http://cal-access.ss.ca.gov/PDFGen/pdfgen.prg?filingid=" . $lastf460 . "' target='_blank''>" . $lastf460 . "</a>   " . date("F d Y", strtotime($last_date_start)) . " - " . date("F d Y", strtotime($last_date)) . "</h3>";
                    }


                    echo($appendme1);

                    $drawme = "
		<table id=\"cand" . $i . "_f497\" class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<tbody>
				<tr class='boldme'>
					<th><b>\$ RAISED THIS PERIOD | </b></th>
					<th><b>\$ RAISED SINCE PD END | </b></th>
					<th><b>\$ SPENT THIS PERIOD | </b></th>
					<th><b>ENDING CASH ON HAND | </b></th>
					<th><b>TOTAL LOANS | </b></th>
					<th><b>DEBTS</b></th>
				</tr>

				<tr class = 'blueme boldme'>
					<td align = 'center'>\$" . number_format($candidates[$i]['RCPT'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[0]['RAISED_SINCE'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['EXPN'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['COH'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['LOANS'], 2) . "</td>
					<td align = 'center'>\$" . number_format($candidates[$i]['DEBTS'], 2) . "</td>
				</tr>

			</tbody>
		</table>";
                    echo($drawme);
                    $nocommitteedata = FALSE;


                    echo("</div>");

                    if ($candidates[$i]['LATE_CONTRIBUTIONS']) {

                        $thisid = "cand_" . $i . "_f497_cont";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<div class='newseg'><h2 align = 'center'>CONTRIBUTIONS SINCE END OF LAST FILING PERIOD</h2>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'} amount\">AMOUNT</th>
					<th>DONOR</th>
					<th>EMPLOYER</th>
					<th>OCCUPATION</th>
					<th>CITY</th>
					<th>STATE</th>
					<th>ZIP</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>

		";

                        echo($drawme1);

                        //echo("f497 Detail:<br>");
                        //var_dump($f497_detail);


                        $j = 0;
                        foreach ($f497_detail[$i] as $entry2) {

                            if ($entry2['ENTY_NAMF']) {
                                $name = $entry2['ENTY_NAMF'] . " " . $entry2['ENTY_NAML'];
                            } else {
                                $name = $entry2['ENTY_NAMF'] . $entry2['ENTY_NAML'];
                            }
                            if ($entry2['CMTE_ID']) {
                                $name = "<a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $entry2['CMTE_ID'] . "' target='_blank'>$name</a>";
                            }
                            if ($entry2['AMOUNT']) {
                                $drawme = "
						<tr>
							<td>" . $entry2['CTRIB_DATE'] . "</td>
							<td class='align_right'>\$" . (float)$entry2['AMOUNT'] . fullnum((float)$entry2['AMOUNT']) . "</td>
							<td>" . $name . "</td>
							<td>" . $entry2['CTRIB_EMP'] . "</td>
							<td>" . $entry2['CTRIB_OCC'] . "</td>

							<td>" . $entry2['ENTY_CITY'] . "</td>
							<td>" . $entry2['ENTY_ST'] . "</td>
							<td>" . $entry2['ENTY_ZIP4'] . "</td>
							<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $entry2['FILING'] . "' target='_blank'>" . $entry2['FILING'] . "</a></td>

						</tr>
				";

                                $cmte_id = $entry2['CMTE_ID'];
                                $amt = $entry2['AMOUNT'];
                                $city = strtoupper($entry2['ENTY_CITY']);
                                $st = $entry2['ENTY_ST'];
                                $emp = strtoupper($entry2['CTRIB_EMP']);
                                $occ = strtoupper($entry2['CTRIB_OCC']);

                                $topcontributors[$name]['NAME'] = $name;
                                $topcontributors[$name]['AMOUNT'] += $amt;

                                $topstates[$st]['NAME'] = $st;
                                $topstates[$st]['AMOUNT'] += $amt;

                                $topcities[$city]['NAME'] = $city;
                                $topcities[$city]['AMOUNT'] += $amt;

                                if ($occ) {
                                    $topoccupations[$occ]['NAME'] = $occ;
                                    $topoccupations[$occ]['AMOUNT'] += $amt;
                                }

                                if ($emp) {
                                    $topemployers[$emp]['NAME'] = $emp;
                                    $topemployers[$emp]['AMOUNT'] += $amt;
                                }

                                $lifetimeraised += $amt;

                                if ($cmte_id) {
                                    $lifetimecommittee += $amt;
                                }

                                echo($drawme);
                            }

                            $j++;
                        }


                        echo("				</tbody>
			</table></div>");
                    } //END LATE CONTRIBUTIONS CHECK

                    if ($f497_made) {

                        $thisid = "cand_" . $i . "_f497_made";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<div class='newseg'><h2 align = 'center'>LATE CONTRIBUTIONS MADE SINCE END OF LAST FILING PERIOD</h2>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'} amount\">AMOUNT</th>
					<th>RECIPIENT</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>

		";

                        echo($drawme1);

                        //echo("f497 Detail:<br>");
                        //var_dump($f497_detail);


                        $j = 0;
                        foreach ($f497_made as $entry2) {

                            if ($entry2['ENTY_NAMF']) {
                                $name = $entry2['ENTY_NAMF'] . " " . $entry2['ENTY_NAML'];
                            } else {
                                $name = $entry2['ENTY_NAMF'] . $entry2['ENTY_NAML'];
                            }


                            if ($entry2['CMTE_ID']) {

                                $cmte_id = $entry2['CMTE_ID'];

                                //echo("<br>CHECKING $cmte_id");

                                $cx = checkxref($cmte_id);
                                if ($cx) {
                                    $cmte_id = $cx;
                                    //echo("...GOT XREF $cx<br>");
                                } else {
                                    //echo("...NO XREF<br>");
                                    $cmte_id = $entry2['CMTE_ID'];
                                }


                                $name = "<a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $cmte_id . "' target='_blank'>$name</a>";
                            }


                            if ($entry2['AMOUNT']) {
                                $drawme = "
						<tr>
							<td>" . $entry2['CTRIB_DATE'] . "</td>
							<td>\$" . (float)$entry2['AMOUNT'] . fullnum((float)$entry2['AMOUNT']) . "</td>
							<td>" . $name . "</td>
							<td><a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $entry2['FILING_ID'] . "' target='_blank'>" . $entry2['FILING_ID'] . "</a></td>

						</tr>
				";
                                echo($drawme);
                            }

                            $j++;
                        }


                        echo("				</tbody>
			</table></div>");
                    } //END LATE CONTRIBUTIONS CHECK

                    if ($f496_exp) {

                        $thisid = "cand_" . $i . "_f496_exp";

                        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                        array_push($endjava, $js);

                        echo("<div class='newseg'><h2 align = 'center'>LATE EXPENDITURES SINCE END OF LAST FILING PERIOD</h2>");
                        $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'} amount\">AMOUNT</th>
					<th>REASON</th>
					<th>RACE</th>
					<th>S/O</th>
					<th>CANDIDATE/MEASURE</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>

		";

                        echo($drawme1);

                        foreach ($f496_exp as $filing) {

                            foreach ($filing as $entry) {
                                $link = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $entry['FILING'] . "' target='_blank'>" . $entry['FILING'] . "</a>";
                                $stuff = getf496detail($entry['FILING']);
                                $candidate = $stuff['CAND_NAML'];
                                $type = $stuff['JURIS_CD'];
                                $dist = $stuff['DIST_NO'];
                                $supopp = $stuff['SUP_OPP_CD'];

                                $mergeddist = $type . " " . $dist;
                                switch ($supopp) {
                                    case "S":
                                        $supoppdetail = "to Support";
                                        break;
                                    case "O":
                                        $supoppdetail = "to Oppose";
                                        break;
                                    default:
                                        $supoppdeatil = '';
                                }
                                $drawme = "
				<tr>
					<td>" . $entry['EXP_DATE'] . "</td>
					<td class='align_right'>" . $entry['AMOUNT'] . "</td>
					<td>" . $entry['EXPN_DSCR'] . "</td>
					<td>" . $mergeddist . "</td>
					<td>" . $supoppdetail . "</td>
					<td>" . $candidate . "</td>
					<td>" . $link . "</td>
				</tr>
			";
                                echo($drawme);
                            }
                            //var_dump($entry);

                        }

                        echo("</tbody>
			</table></div>");
                    } //END LATE CONTRIBUTIONS CHECK

                }

                if ($racetotal > 0) {
                    echo("<div class='newseg'><h1 class='redme'>TOTAL IE SPENDING IN THIS RACE: \$" . number_format($racetotal, 2) . "</h1></div>");
                }


                if ($consultants) {
                    uasort($consultants, 'totalsort');
                    echo("<div class='newseg' id='consultants'><h1>Consultants</h1>");
                    echo($top_lnk);
                    $tablehead = "<table id='byconsultants' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
					<thead>
						<tr>
							<th>NAME</th>
							<th>TOTAL AMOUNT PAID</th>
						</tr>
					</thead>
					<tbody>
	";

                    foreach ($consultants as $consultant) {
                        $tablebody .= "<tr>
							<td>" . $consultant['NAME'] . "</td>
							<td class='align_right'>\$" . number_format($consultant['AMOUNT']) . "</td>
						</tr>
		";
                    }
                    echo($tablehead . $tablebody . "</tbody></table></div>");
                }

                $tablebody = '';

                if ($pollsters) {
                    uasort($pollsters, 'totalsort');
                    echo("<div class='newseg'><h1>Polling</h1>");
                    echo($top_lnk);
                    $tablehead = "<table id='pollsters' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
					<thead>
						<tr>
							<th>NAME</th>
							<th>TOTAL AMOUNT PAID</th>
						</tr>
					</thead>
					<tbody>
	";

                    foreach ($pollsters as $pollster) {
                        $tablebody .= "<tr>
							<td>" . $pollster['NAME'] . "</td>
							<td class='align_right'>\$" . number_format($pollster['AMOUNT']) . "</td>
						</tr>
		";
                    }
                    echo($tablehead . $tablebody . "</tbody></table></div>");
                }

                $tablebody = '';

                if ($fundraising) {
                    uasort($fundraising, 'totalsort');
                    echo("<div class='newseg'><h1>Fundraising Expenditures</h1>");
                    echo($top_lnk);
                    $tablehead = "<table id='fundraising' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
					<thead>
						<tr>
							<th>NAME</th>
							<th>TOTAL AMOUNT PAID</th>
						</tr>
					</thead>
					<tbody>
	";

                    foreach ($fundraising as $expense) {
                        $tablebody .= "<tr>
							<td>" . $expense['NAME'] . "</td>
							<td class='align_right'>\$" . number_format($expense['AMOUNT']) . "</td>
						</tr>
		";
                    }
                    echo($tablehead . $tablebody . "</tbody></table></div>");
                }

                $tablebody = '';

                if ($salaried) {
                    uasort($salaried, 'totalsort');
                    echo("<div class='newseg'><h1>Salaried Employees</h1>");
                    echo($top_lnk);
                    $tablehead = "<table id='salaried' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
					<thead>
						<tr>
							<th>NAME</th>
							<th>TOTAL AMOUNT PAID</th>
						</tr>
					</thead>
					<tbody>
	";

                    foreach ($salaried as $employee) {
                        $tablebody .= "<tr>
							<td>" . $employee['NAME'] . "</td>
							<td class='align_right'>\$" . number_format($employee['AMOUNT']) . "</td>
						</tr>
		";
                    }
                    echo($tablehead . $tablebody . "</tbody></table></div>");
                }

                uasort($topstates, 'totalsort');
                echo("<div class='newseg' id='bystate'><h1>Contributions by State</h1>");
                echo($top_lnk);
                $tablehead = "<table id='state' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
				<thead>
					<tr>
						<th>NAME</th>
						<th>AMOUNT</th>
						<th>% OF TOTAL</th>
					</tr>
				</thead>
				<tbody>
";
                $tablebody = '';
                foreach ($topstates as $value) {
                    $name = $value['NAME'];
                    $amount = $value['AMOUNT'];
                    $pct = makepct($amount, $lifetimeraised);

                    $tablebody .= "
					<tr>
						<td>$name</td>
						<td class='align_right'>\$" . number_format($amount) . " </td>
						<td>$pct</td>
					</tr>
	";
                }
                echo($tablehead . $tablebody . "</tbody></table></div>");

                uasort($topcities, 'totalsort');
                echo("<div class='newseg' id='bycity'><h1>Contributions by City</h1>");
                echo($top_lnk);
                $tablehead = "<table id='city' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
				<thead>
					<tr>
						<th>NAME</th>
						<th>AMOUNT</th>
						<th>% OF TOTAL</th>
					</tr>
				</thead>
				<tbody>
";
                $tablebody = '';
                foreach ($topcities as $value) {
                    $name = $value['NAME'];
                    $amount = $value['AMOUNT'];
                    $pct = makepct($amount, $lifetimeraised);

                    $tablebody .= "
					<tr>
						<td>$name</td>
						<td class='align_right'>\$" . number_format($amount) . " </td>
						<td>$pct</td>
					</tr>
	";
                }
                echo($tablehead . $tablebody . "</tbody></table></div>");

                uasort($topemployers, 'totalsort');
                echo("<div class='newseg' id='byemployer'><h1>Contributions by Employer</h1>");
                echo($top_lnk);
                $tablehead = "<table id='employer' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
				<thead>
					<tr>
						<th>NAME</th>
						<th>AMOUNT</th>
						<th>% OF TOTAL</th>
					</tr>
				</thead>
				<tbody>
";
                $tablebody = '';
                foreach ($topemployers as $value) {
                    $name = $value['NAME'];
                    $amount = $value['AMOUNT'];
                    $pct = makepct($amount, $lifetimeraised);

                    $tablebody .= "
					<tr>
						<td>$name</td>
						<td class='align_right'>\$" . number_format($amount) . " </td>
						<td>$pct</td>
					</tr>
	";
                }
                echo($tablehead . $tablebody . "</tbody></table></div>");


                uasort($topoccupations, 'totalsort');
                echo("<div class='newseg' id='byoccupation'><h1>Contributions by Occupation</h1>");
                echo($top_lnk);
                $tablehead = "<table id='occupation' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
				<thead>
					<tr>
						<th>NAME</th>
						<th>AMOUNT</th>
						<th>% OF TOTAL</th>
					</tr>
				</thead>
				<tbody>
";
                $tablebody = '';
                foreach ($topoccupations as $value) {
                    $name = $value['NAME'];
                    $amount = $value['AMOUNT'];
                    $pct = makepct($amount, $lifetimeraised);

                    $tablebody .= "
					<tr>
						<td>$name</td>
						<td class='align_right'>\$" . number_format($amount) . " </td>
						<td>$pct</td>
					</tr>
	";
                }
                echo($tablehead . $tablebody . "</tbody></table></div>");

                uasort($topcontributors, 'totalsort');


                $raised_indiv = $lifetimeraised - $lifetimecommittee;
                $raised_cmte = $lifetimecommittee;

                $displaylifetime = "\$" . number_format($lifetimeraised);

                $indiv_pct = makepct($raised_indiv, $lifetimeraised);
                $cmte_pct = makepct($raised_cmte, $lifetimeraised);

                echo("<div class='newseg' id='bycontributor' ><h1>Contributions by Group/Individual<br>$displaylifetime Total Raised</h1>");
                echo("<h2 align='center' style='padding-left: 0;'>By Individuals: \$" . number_format($raised_indiv) . " ($indiv_pct) | By Committees: \$" . number_format($raised_cmte) . " ($cmte_pct)</h2>");
                echo($top_lnk);

                $tablehead = "<table id='contributor_sum' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
				<thead>
					<tr>
						<th>NAME</th>
						<th>AMOUNT</th>
						<th>% OF TOTAL</th>
					</tr>
				</thead>
				<tbody>
";
                $tablebody = '';
                foreach ($topcontributors as $value) {
                    $name = $value['NAME'];
                    $amount = $value['AMOUNT'];
                    $pct = makepct($amount, $lifetimeraised);

                    $tablebody .= "
					<tr>
						<td>$name</td>
						<td class='align_right'>\$" . number_format($amount) . " </td>
						<td>$pct</td>
					</tr>
	";
                }
                echo($tablehead . $tablebody . "</tbody></table></div>");

                $tablebody = '';
                if ($exp_by_code) {

                    //var_dump($exp_by_code);

                    $thisid = "expcode_" . $i . "_f460e_exp";

                    $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                    array_push($endjava, $js);

                    echo("<div class='newseg'>");
                    echo("<h1>Lifetime Committee Operating Expenditures by Expense Code</h1>");
                    echo ("<p align='center' class='boldme' style='font-size: 16pt;'>$") . number_format($total_expcode, 2) . " Total Operating Expenditures</p>";
                    echo($top_lnk);


                    $tablehead = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th>CODE</th>
					<th>DESCRIPTION</th>
					<th class='align_right'>AMOUNT</th>
					<th>%</th>
				</tr>
			</thead>
			<tbody>

		";

                    uasort($exp_by_code, 'totalsort');
                    foreach ($exp_by_code as $xp) {
                        $thisamt = $xp['AMOUNT'];
                        $thiscode = $xp['CODE'];
                        $longcode = longexpense($thiscode);
                        $thispct = number_format((($thisamt / $total_expcode) * 100), 2);

                        $tablebody .= "
						<tr>
							<td>$thiscode</td>
							<td>$longcode</td>
							<td class='align_right'>\$" . number_format($thisamt) . " </td>
							<td>$thispct</td>
						</tr>
		";

                    }

                    echo($tablehead . $tablebody . "</tbody></table></div>");

                }

                $tablebody = '';
                if ($exp_by_vendor) {

                    //var_dump($exp_by_code);

                    $thisid = "expvendor_" . $i . "_f460e_exp";

                    $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                    array_push($endjava, $js);

                    echo("<div class='newseg'>");
                    echo("<h1>Lifetime Committee Operating Expenditures by Payee</h1>");
                    echo ("<p align='center' class='boldme' style='font-size: 16pt;'>$") . number_format($total_expcode, 2) . " Total Operating Expenditures</p>";
                    echo($top_lnk);

                    $tablehead = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th>PAYEE</th>
					<th class='align_right'>AMOUNT</th>
					<th>%</th>
				</tr>
			</thead>
			<tbody>

		";

                    uasort($exp_by_vendor, 'totalsort');
                    foreach ($exp_by_vendor as $xp) {
                        $thisamt = $xp['AMOUNT'];
                        $thisname = $xp['NAME'];
                        $thispct = number_format((($thisamt / $total_expcode) * 100), 2);

                        $tablebody .= "
						<tr>
							<td>$thisname</td>
							<td class='align_right'>\$" . number_format($thisamt) . " </td>
							<td>$thispct</td>
						</tr>
		";

                    }

                    echo($tablehead . $tablebody . "</tbody></table></div>");

                }


                if ($transactions) {
                    $thisid = "ieall_" . $i . "_f460e_exp";

                    $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

                    array_push($endjava, $js);

                    echo("<div class='newseg'>");
                    echo("<h1>Historical Independent Expenditures</h1>");
                    echo($top_lnk);


                    $drawme1 = "
		<table id='$thisid' class='bordered tablesorter table-hover tablesaw tablesaw-stack' data-tablesaw-mode='stack' cellspacing='0'>
			<thead>
				<tr>
					<th>CMTE</th>
					<th class='date'>DATE</th>
					<th class=\"{sorter: 'thousands'} amount\">AMOUNT</th>
					<th>REASON</th>
					<th>RACE</th>
					<th>S/O</th>
					<th>CANDIDATE/MEASURE</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>

		";

                    echo($drawme1);

                    foreach ($transactions as $entry) {

                        $x = checkxref($entry['FILER_ID']);
                        if ($x) {
                            $filer_id = $x;
                        } else {
                            $filer_id = $entry['FILER_ID'];
                        }

                        $link = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $entry['FILING_ID'] . "' target='_blank'>" . $entry['FILING_ID'] . "</a>";
                        $cmte_link = "<a href='http://198.74.49.22/cmlocal2.php?id=" . $filer_id . "' target='_blank'>" . $entry['FILER_NAML'] . "</a>";
                        $stuff = getf496detail($entry['FILING_ID']);
                        $candidate = $stuff['CAND_NAML'];
                        $type = $stuff['JURIS_CD'];
                        $dist = $stuff['DIST_NO'];
                        $supopp = $stuff['SUP_OPP_CD'];
                        process_amount($entry);
                        $mergeddist = $type . " " . $dist;
                        switch ($supopp) {
                            case "S":
                                $supoppdetail = "to Support";
                                break;
                            case "O":
                                $supoppdetail = "to Oppose";
                                break;
                            default:
                                $supoppdeatil = '';
                        }
                        $drawme = "
			<tr>
				<td>" . $cmte_link . "</td>
				<td>" . $entry['EXP_DATE'] . "</td>
				<td>" . $entry['AMOUNT'] . "</td>
				<td>" . $entry['EXPN_DSCR'] . "</td>
				<td>" . $mergeddist . "</td>
				<td>" . $supoppdetail . "</td>
				<td>" . $candidate . "</td>
				<td>" . $link . "</td>
			</tr>
		";

                        echo($drawme);
                    }


                    echo("</tbody>
				</table></div>");


                    echo("</div>");
                }

                echo("<div class='newseg'>");

                if ($e00s || $e00o) {
                    echo("<h2>2000 Election</h2>");
                    echo("<h3>\$" . number_format($e00s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e00o, 2) . " spent in Opposition</h3>");
                }

                if ($e00s || $e00o) {
                    echo("<h2>2000 Election</h2>");
                    echo("<h3>\$" . number_format($e00s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e00o, 2) . " spent in Opposition</h3>");
                }

                if ($e00s || $e00o) {
                    echo("<h2>2000 Election</h2>");
                    echo("<h3>\$" . number_format($e00s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e00o, 2) . " spent in Opposition</h3>");
                }

                if ($e02s || $e02o) {
                    echo("<h2>2002 Election</h2>");
                    echo("<h3>\$" . number_format($e02s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e02o, 2) . " spent in Opposition</h3>");
                }

                if ($e04s || $e04o) {
                    echo("<h2>2004 Election</h2>");
                    echo("<h3>\$" . number_format($e04s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e04o, 2) . " spent in Opposition</h3>");
                }

                if ($e06s || $e06o) {
                    echo("<h2>2006 Election</h2>");
                    echo("<h3>\$" . number_format($e06s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e06o, 2) . " spent in Opposition</h3>");
                }

                if ($e08s || $e08o) {
                    echo("<h2>2008 Election</h2>");
                    echo("<h3>\$" . number_format($e08s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e08o, 2) . " spent in Opposition</h3>");
                }

                if ($e10s || $e10o) {
                    echo("<h2>2010 Election</h2>");
                    echo("<h3>\$" . number_format($e10s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e10o, 2) . " spent in Opposition</h3>");
                }

                if ($e12s || $e12o) {
                    echo("<h2>2012 Election</h2>");
                    echo("<h3>\$" . number_format($e12s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e12o, 2) . " spent in Opposition</h3>");
                }

                if ($e14s || $e14o) {
                    echo("<h2>2014 Election</h2>");
                    echo("<h3>\$" . number_format($e14s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e14o, 2) . " spent in Opposition</h3>");
                }

                if ($e16s || $e16o) {
                    echo("<h2>2016 Election</h2>");
                    echo("<h3>\$" . number_format($e16s, 2) . " spent in Support</h3>");
                    echo("<h3>\$" . number_format($e16o, 2) . " spent in Opposition</h3>");
                }

                echo("</div>");

                function abbreviate($string)
                {
                    $result = str_replace("California", "CA", $string);
                    $result = str_replace("Association", "Assn", $result);
                    $result = str_replace("Professional", "Prof", $result);
                    $result = str_replace("Entertainment", "Ent", $result);
                    $result = str_replace("Committee", "Cmte", $result);
                    $result = str_replace("Federal", "Fed", $result);
                    $result = str_replace("Independent", "Ind", $result);
                    $result = str_replace("Government", "Govt", $result);
                    $result = str_replace("'", "", $result);

                    return $result;

                }

                function getf497given2($cmte, $lastdate)
                {
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $tmp = Array();
                    $x = Array();
                    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$cmte' && FORM_ID = 'F497' && FILING_DATE > '$lastdate' ORDER BY FILING_ID DESC, FILING_SEQUENCE DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $x = getamounts($row['FILING_ID']);
                            foreach ($x as $value) {
                                $tmp['CTRIB_DATE'] = $value['CTRIB_DATE'];
                                $tmp['AMOUNT'] = $value['AMOUNT'];
                                $tmp['OFFICE_CD'] = $value['OFFICE_CD'];
                                $tmp['DIST_NO'] = $value['DIST_NO'];
                                $tmp['NAME'] = $value['NAME'];
                                $tmp['CMTE_ID'] = $value['CMTE_ID'];
                                $tmp['FILING_ID'] = $value['FILING_ID'];
                                array_push($retval, $tmp);
                            }
                        }
                    }

                    return $retval;
                }

                function getamounts($filing)
                {
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT * FROM calaccess_raw_S497_CD WHERE FILING_ID = '$filing' && FORM_TYPE = 'F497P2' ORDER BY AMEND_ID DESC";
                    $result = $conn->query($sql);
                    $thisamend = '';
                    $highestamend = '';
                    if ($result->num_rows > 0) {
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            if (!$highestamend) {
                                $highestamend = $row['AMEND_ID'];
                            }
                            $thisamend = $row['AMEND_ID'];
                            if ($thisamend < $highestamend) {
                                //DO NOTHING
                            } elseif ($row['CTRIB_DATE'] > "2015-12-31") {
                                if ($row['ENTY_NAMF']) {
                                    $name = $row['ENTY_NAMF'] . " " . $row['ENTY_NAML'];
                                } else {
                                    $name = $row['ENTY_NAML'];
                                }

                                $tmp['CTRIB_DATE'] = $row['CTRIB_DATE'];
                                $tmp['AMOUNT'] = $row['AMOUNT'];
                                $tmp['OFFICE_CD'] = $row['OFFICE_CD'];
                                $tmp['DIST_NO'] = $row['DIST_NO'];
                                $tmp['NAME'] = $name;
                                $tmp['CMTE_ID'] = $row['CMTE_ID'];
                                $tmp['FILING_ID'] = $row['FILING_ID'];
                                array_push($retval, $tmp);

                            } else {
                                //DO NOTHING
                            }
                        }
                    }

                    //echo("<br>Returning a total amount of: " . $retval['TOTAL'] . " FROM $filing<br>");
                    return $retval;
                }


                function lookupdist($name, $election, $code)
                {
                    $conn2 = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT * FROM ctb2016_candidates WHERE name LIKE '%$name%' && race LIKE '$code%' && election = '$election' ";
                    //echo($sql);
                    $result = $conn2->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['DISTRICT'] = $row['distnum'];
                            $retval['PARTY'] = $row['party'];
                            $retval['INC'] = $row['is_incumbent'];
                        }
                    }
                    //echo("<br>lookupdist executed with return value of: <br>");
                    //var_dump($retval);
                    return $retval;
                }

                function gettheparty($name, $election, $code)
                {
                    $conn2 = Util::get_ctb_conn();
                    $retval = Array();
                    $sql = "SELECT * FROM ctb2016_candidates WHERE name LIKE '%$name%' && race LIKE '$code%' && election = '$election' ";
                    //echo($sql);
                    $result = $conn2->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval['PARTY'] = $row['party'];
                            $retval['INC'] = $row['is_incumbent'];
                        }
                    }
                    //echo("<br>gettheparty executed with return value of: <br>");
                    //var_dump($retval);
                    return $retval;
                }

                function identifyrace($committee_name)
                {
                    $retval = Array();
                    $arr = explode(' ', trim($committee_name));
                    $name = $arr[0];
                    $getdist = FALSE;
                    $ispartisan = FALSE;
                    $code = '';
                    $election = '';
                    $office = '';

                    if (contains("BOE", $committee_name)) {
                        $office = "BOE";
                        $code = "BOE";
                        $getdist = TRUE;
                    }

                    if (contains("Council", $committee_name)) {
                        $office = "CCM";
                    }

                    if (contains("Assembly", $committee_name)) {
                        $office = "ASM";
                        $code = "ASS";
                        $getdist = TRUE;
                    }


                    if (contains("Senate", $committee_name)) {
                        $office = "SEN";
                        $code = "SEN";
                        $getdist = TRUE;
                    }

                    if (contains("Governor", $committee_name)) {
                        $office = "GOV";
                        $code = "GOV";
                        $ispartisan = TRUE;
                    }

                    if (contains("Lieutenant", $committee_name) || contains("Lt.", $committee_name)) {
                        $office = "LTG";
                        $code = "LTG";
                        $ispartisan = TRUE;
                    }

                    if (contains("Treasurer", $committee_name)) {
                        $office = "TRS";
                        $code = "TRS";
                        $ispartisan = TRUE;
                    }

                    if (contains("Judge", $committee_name)) {
                        $office = "SCJ";
                    }

                    if (contains("Treasurer", $committee_name)) {
                        $office = "TRS";
                    }

                    if (contains("Supervisor", $committee_name)) {
                        $office = "BSU";
                    }

                    if (contains("Secretary", $committee_name) && contains("State", $committee_name)) {
                        $office = "SOS";
                        $code = "SOS";
                        $ispartisan = TRUE;
                    }

                    if (contains("Mayor", $committee_name)) {
                        $office = "MAY";
                    }

                    if (contains("Insurance", $committee_name)) {
                        $office = "INS";
                        $code = "INS";
                        $ispartisan = TRUE;
                    }

                    if (contains("General", $committee_name)) {
                        $office = "ATT";
                        $code = "ATG";
                        $ispartisan = TRUE;
                    }

                    if (contains("Controller", $committee_name)) {
                        $office = "CON";
                        $code = "CON";
                        $ispartisan = TRUE;
                    }

                    if (contains("Equalization", $committee_name)) {
                        $office = "BOE";
                        $getdist = TRUE;
                        $ispartisan = TRUE;
                    }

                    if (contains("Superintendent", $committee_name)) {
                        $office = "SUP";
                        $code = "SUP";
                    }

                    if (contains("District", $committee_name) && contains("Attorney", $committee_name)) {
                        $office = "DAT";
                    }

                    if (contains("Sheriff", $committee_name)) {
                        $office = "SHC";
                    }

                    if (contains("Assessor", $committee_name)) {
                        $office = "ASR";
                    }

                    if (contains("2018", $committee_name)) {
                        $election = "p18";
                    }

                    if (contains("2016", $committee_name)) {
                        $election = "p16";
                    }

                    if (contains("2014", $committee_name)) {
                        $election = "p14";
                    }

                    if (contains("2012", $committee_name)) {
                        $election = "p12";
                    }

                    if (contains("2010", $committee_name)) {
                        $election = "p10";
                    }

                    if (contains("2008", $committee_name)) {
                        $election = "p08";
                    }

                    if (contains("2006", $committee_name)) {
                        $election = "p06";
                    }

                    $name = str_replace(',', '', $name);

                    $retval['OFFICE'] = $office;
                    $retval['NAME'] = $name;
                    $retval['CODE'] = $code;
                    $retval['ELECTION'] = $election;
                    $retval['GETDIST'] = $getdist;
                    $retval['ISPARTISAN'] = $ispartisan;

                    return $retval;
                }

                function contains($needle, $haystack)
                {
                    $needle = strtoupper($needle);
                    $haystack = strtoupper($haystack);

                    return strpos($haystack, $needle) !== FALSE;
                }

                function cleanup($string)
                {
                    $result = strtoupper($string);
                    $result = str_replace(',', '', $result);
                    $result = str_replace('(', '', $result);
                    $result = str_replace(';', '', $result);
                    $result = str_replace(')', '', $result);
                    $result = str_replace('&', '', $result);
                    $result = str_replace('LLC', '', $result);
                    $result = str_replace(' INC.', '', $result);
                    $result = str_replace(' THE ', '', $result);

                    return $result;
                }

                function getie_st($code, $name)
                {
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $tmp = Array();
                    $filings = Array();
                    $transactions = Array();
                    $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE CAND_NAML like '%$name%' && OFFICE_CD = '$code' && FORM_TYPE = 'F496' ORDER BY FILING_ID DESC, AMEND_ID DESC";
                    //echo($sql);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $thisfiling = $row['FILING_ID'];
                            if ($thisfiling <> $lastfiling) {
                                $tmp['FILING_ID'] = $row['FILING_ID'];
                                $tmp['FILER_NAML'] = strtoupper($row['FILER_NAML']);
                                array_push($filings, $tmp);

                            }
                            $lastfiling = $thisfiling;
                        }
                    }

                    foreach ($filings as $filing) {
                        $x = getf496amt($filing['FILING_ID']);
                        $filer = $filing['FILER_NAML'];
                        foreach ($x as $transaction) {

                            $stuff = getf496detail($transaction['FILING']);
                            $tmp['SUP_OPP_CD'] = $stuff['SUP_OPP_CD'];
                            $tmp['FILER_ID'] = $stuff['FILER_ID'];
                            $tmp['FILER_NAML'] = $filer;
                            $tmp['AMOUNT'] = $transaction['AMOUNT'];
                            $tmp['EXPN_DSCR'] = $transaction['EXPN_DSCR'];
                            $tmp['EXP_DATE'] = $transaction['EXP_DATE'];
                            $tmp['FILING_ID'] = $transaction['FILING'];
                            array_push($transactions, $tmp);
                        }
                    }


                    usort($transactions, 'committee_sort');
                    //echo("<br>F496 Transaction Dump:<br>");
                    //var_dump($transactions);
                    return $transactions;
                }

                function getie_dist($district, $name)
                {
                    $conn = Util::get_ctb_conn();
                    $retval = Array();
                    $tmp = Array();
                    $filings = Array();
                    $transactions = Array();
                    if ($district < 10) {
                        $prepend = "(";
                        $append = " || DIST_NO = '0$district')";
                    } else {
                        $prepend = '';
                        $append = '';
                    }
                    $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE CAND_NAML like '%$name%' && $prepend DIST_NO = '$district' $append && FORM_TYPE = 'F496' ORDER BY FILING_ID DESC, AMEND_ID DESC";
                    //echo($sql);
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $thisfiling = $row['FILING_ID'];
                            if ($thisfiling <> $lastfiling) {
                                $tmp['FILING_ID'] = $row['FILING_ID'];
                                $tmp['FILER_NAML'] = strtoupper($row['FILER_NAML']);
                                array_push($filings, $tmp);

                            }
                            $lastfiling = $thisfiling;
                        }
                    }

                    foreach ($filings as $filing) {
                        $x = getf496amt($filing['FILING_ID']);
                        $filer = $filing['FILER_NAML'];
                        foreach ($x as $transaction) {

                            $stuff = getf496detail($transaction['FILING']);
                            $tmp['SUP_OPP_CD'] = $stuff['SUP_OPP_CD'];
                            $tmp['FILER_ID'] = $stuff['FILER_ID'];
                            $tmp['FILER_NAML'] = $filer;
                            $tmp['AMOUNT'] = $transaction['AMOUNT'];
                            $tmp['EXPN_DSCR'] = $transaction['EXPN_DSCR'];
                            $tmp['EXP_DATE'] = $transaction['EXP_DATE'];
                            $tmp['FILING_ID'] = $transaction['FILING'];
                            array_push($transactions, $tmp);
                        }
                    }


                    usort($transactions, 'committee_sort');
                    //echo("<br>F496 Transaction Dump:<br>");
                    //var_dump($transactions);
                    return $transactions;
                }


                function checkxref($committee)
                {
                    global $calaccess_conn;
                    $conn = Util::get_ctb_conn();
                    $retval = FALSE;
                    $sql = "SELECT FILER_ID FROM calaccess_raw_FILER_XREF_CD WHERE XREF_ID = '$committee' ORDER BY FILER_ID DESC LIMIT 1 ";
                    //echo("<br>$sql<br>");
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $retval = $row['FILER_ID'];
                        }
                    }

                    //echo($retval);
                    return $retval;
                }

                function committee_sort($item1, $item2)
                {
                    if ($item1['FILER_NAML'] == $item2['FILER_NAML']) return 0;

                    return ($item1['FILER_NAML'] > $item2['FILER_NAML']) ? 1 : -1;
                }

                function totalsort($a, $b)
                {

                    if ($a['AMOUNT'] < $b['AMOUNT']) {
                        return 1;
                    } elseif ($a['AMOUNT'] > $b['AMOUNT']) {
                        return -1;
                    } else {
                        return 0;
                    }
                }

                function process_amount($entry)
                {
                    global $e00s;
                    global $e00o;
                    global $e02s;
                    global $e02o;
                    global $e04s;
                    global $e04o;
                    global $e06s;
                    global $e06o;
                    global $e08s;
                    global $e08o;
                    global $e10s;
                    global $e10o;
                    global $e12s;
                    global $e12o;
                    global $e14s;
                    global $e14o;
                    global $e16s;
                    global $e16o;
                    //echo("Processing");
                    //var_dump($entry);
                    if ($entry['EXP_DATE'] > "1998-12-31" && $entry['EXP_DATE'] < "2000-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e00s += $entry['AMOUNT'];
                        } else {
                            $e00o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2000-11-15" && $entry['EXP_DATE'] < "2002-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e02s += $entry['AMOUNT'];
                        } else {
                            $e02o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2002-11-15" && $entry['EXP_DATE'] < "2004-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e04s += $entry['AMOUNT'];
                        } else {
                            $e04o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2004-11-15" && $entry['EXP_DATE'] < "2006-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e06s += $entry['AMOUNT'];
                        } else {
                            $e06o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2006-11-15" && $entry['EXP_DATE'] < "2008-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e08s += $entry['AMOUNT'];
                        } else {
                            $e08o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2008-11-15" && $entry['EXP_DATE'] < "2010-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e10s += $entry['AMOUNT'];
                        } else {
                            $e10o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2010-11-15" && $entry['EXP_DATE'] < "2012-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e12s += $entry['AMOUNT'];
                        } else {
                            $e12o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2012-11-15" && $entry['EXP_DATE'] < "2014-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e14s += $entry['AMOUNT'];
                        } else {
                            $e14o += $entry['AMOUNT'];
                        }
                    }

                    if ($entry['EXP_DATE'] > "2014-11-15" && $entry['EXP_DATE'] < "2016-11-15") {
                        if ($entry['SUP_OPP_CD'] == "S") {
                            $e16s += $entry['AMOUNT'];
                        } else {
                            $e16o += $entry['AMOUNT'];
                        }
                    }

                }

                function longexpense($code)
                {
                    switch ($code) {
                        case "CMP":
                            $x = "Campaign Paraphernalia/Miscellaneous";
                            break;
                        case "CNS":
                            $x = "Campaign Consultants";
                            break;
                        case "CTB":
                            $x = "Contribution";
                            break;
                        case "CVC":
                            $x = "Civic Donations";
                            break;
                        case "FIL":
                            $x = "Candidate Filing/Ballot Fees";
                            break;
                        case "FND":
                            $x = "Fundraising Events";
                            break;
                        case "IND":
                            $x = "Independent Expenditure Supporting/Opposing Others";
                            break;
                        case "LEG":
                            $x = "Legal Defense";
                            break;
                        case "LIT":
                            $x = "Campaign Literature & Mailings";
                            break;
                        case "MBR":
                            $x = "Member Communications";
                            break;
                        case "MTG":
                            $x = "Meetings & Appearances";
                            break;
                        case "N/A":
                            $x = "Unitemized or Multiple Expense Codes";
                            break;
                        case "OFC":
                            $x = "Office Expenses";
                            break;
                        case "PET":
                            $x = "Petition Circulating";
                            break;
                        case "PHO":
                            $x = "Phone Banks";
                            break;
                        case "POL":
                            $x = "Polling & Survey Research";
                            break;
                        case "POS":
                            $x = "Postage, Delivery & Messenger Services";
                            break;
                        case "PRO":
                            $x = "Professional Services (Legal, Accounting)";
                            break;
                        case "PRT":
                            $x = "Print Ads";
                            break;
                        case "RAD":
                            $x = "Radio Airtime & Production Costs";
                            break;
                        case "RFD":
                            $x = "Returned Contributions";
                            break;
                        case "SAL":
                            $x = "Campaign Workers' Salaries";
                            break;
                        case "TEL":
                            $x = "Television or Cable Airtime & Production Costs";
                            break;
                        case "TRC":
                            $x = "Candidate Travel, Lodging, and Meals";
                            break;
                        case "TRS":
                            $x = "Staff/Spouse Travel, Lodging, and Meals";
                            break;
                        case "TSF":
                            $x = "Transfer Between Committees of the Same Candidate/Sponsor";
                            break;
                        case "VOT":
                            $x = "Voter Registration";
                            break;
                        case "WEB":
                            $x = "Information Technology Costs (Internet, Email)";
                            break;
                        default:
                            $x = "Unknown";
                            break;
                    }

                    return $x;
                }

                ?>

            </div>
        </div>
    </div>


@endsection

@section('styles')

<style>

	    .tablesaw > * {
	 	font-family: 'PT Sans Narrow' !important;
		padding: 0.02em !important;
	    }

	    .align_right {
		text-align: right !important;
	    }

</style>

@endsection

@section('scripts')
    <script type='text/javascript'>

$(document).ready(function () {

  $('ul.tabs2 li').click(function () {
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs2 li').removeClass('current');
    $('.tab-content').removeClass('current');

    $(this).addClass('current');
    $("#" + tab_id).addClass('current');
  })

});

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection
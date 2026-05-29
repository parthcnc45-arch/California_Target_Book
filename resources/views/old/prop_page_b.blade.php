<?php

Util::set_errors();
global $cycle;

global $election, $prop;
$election = $_GET['election'];
$prop = $_GET['prop'];
$prop_no = $_GET['prop'];


$title = "Proposition $prop_no ($election)";

?>

@extends('layouts.master')

@section('title', "$title | California Target Book")

@section('content')

    <?php

    Util::include ('prop_head.php')

    ?>

    <div class="book-page-head row m-n">

    <div class="container">

        <?php

        $cycle = $election - 1;

        $x = get_prop_info($prop, $cycle);

        $pdf_object = "<object data='/docs/Props/" . $x['filename'] . "' type='application/pdf' width='800px' height='1200px' align='center'>
        		<embed src='/docs/Props/" . $x['filename'] . "' type='application/pdf' />
    		</object>";

        $e_year = mb_substr($x['filename'], 1, 2);
        $e_type = mb_substr($x['filename'], 0, 1);

        switch ($e_type) {
            case "s":
                $long_type = "Special";
                break;
            case "p":
                $long_type = "Primary";
                break;
            case "g":
                $long_type = "General";
                break;
        }

        if (mb_substr($x['filename'], 0, 3) == "s08") {
            $long_type = "Presidential Primary";
        }

        $long_year = "20" . $e_year;

        echo("<h1 align='center'>" . $x['prop_dscr'] . "</h1><p align='center'>FPPC ID #<a href='http://cal-access.sos.ca.gov/Campaign/Measures/Detail.aspx?id=" . $x['prop_id'] . "&session=$cycle' target='_blank'>" . $x['prop_id'] . "</a></p>");

        $votes = get_prop_votes($prop, $election);

        $table_head = "<div class='newseg_prop' align='center'>
				<table align='center'>
					<thead>
						<tr>
							<th>COUNTY</th>
							<th>YES</th>
							<th>%</th>
							<th>NO</th>
							<th>%</th>
						</tr>
					</thead>
					<tbody>";

        foreach ($votes as $county => $x) {
            $yes = $x['yes'];
            $no = $x['no'];
            $tot = $yes + $no;

            if ($yes > $no) {
                $yes_class = 'greenme boldme';
                $no_class = '';
            } elseif ($no > $yes) {
                $yes_class = '';
                $no_class = 'redme boldme';
            } else {
                $yes_class = 'boldme';
                $no_class = 'boldme';
            }

            $yes_pct = number_format((($yes / $tot) * 100), 2);
            $no_pct = number_format((($no / $tot) * 100), 2);

            if ($county == "Statewide") {
                $boldclass = 'boldme';
                $county_big = "Statewide";
            } else {
                $boldclass = '';
                $county_big = convert_county_num($county);
            }

            $table_body .= "<tr>
						<td class='$yes_class $no_class'>" . $county_big . "</td>
						<td>" . number_format($yes) . "</td>
						<td class='$yes_class'>" . $yes_pct . "%</td>
						<td>" . number_format($no) . "</td>
						<td class='$no_class'>" . $no_pct . "%</td>
					</tr>";

        }

        echo("<h2 align='center'>$long_year<br>$long_type Election</h2>");

        if ($votes['Statewide']['yes'] > $votes['Statewide']['no']) {
            echo("<h2 align='center' style='color: green;' class='boldme'>PASSED $yes_pct% / $no_pct%</h2>");
        } else {
            echo("<h2 align='center' style='color: red;' class='boldme'>FAILED $yes_pct% / $no_pct%</h2>");
        }

        echo("<div class='row'>
		<div class='col-lg-12' align='center'>
			<h2 align='center'>Election Results by County</h2>");

        echo($table_head . $table_body . "</tbody></table>
	</div>
</div>
	</div>");

        echo("<div class='row'>");
        echo("<div class='col-lg-12'>
		<h2 align='center'>Campaign Finance Activity by Committees Supporting/Opposing This Proposition</h2>");
        $x = getprop($prop);
        echo($x);
        echo("</div></div>");

        echo("<div class='row' style='margin-top: 30px' align='center'>
		<div class='col-lg-12'>
		<h2 align='center'>Proposition Information from Voting Guide</h2>");
        echo($pdf_object);
        echo("</div>
	</div>");


        function get_prop_votes($prop, $election) {
            global $site_conn;
            $conn = Util::get_ctb_conn();
            $election_year = mb_substr($election, 2, 2);

            $yes_key = "PR_" . $prop . "_Y";
            $no_key = "PR_" . $prop . "_N";

            $sql = "SELECT * FROM ctb_county_results WHERE election LIKE '%$election_year' && (racekey = '$yes_key' || racekey = '$no_key')";
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $county = $row['county'];
                    $votes = $row['votes'];

                    //echo("<br>GOT $county, $votes, ");


                    if ($row['racekey'] == $yes_key) {
                        $retval[$county]['yes'] = $votes;
                        $yes_total += $votes;
                        //echo("added to YES total<br>");
                    } elseif ($row['racekey'] == $no_key) {
                        $retval[$county]['no'] = $votes;
                        $no_total += $votes;
                        //echo("added to NO total<br>");
                    }
                }
            }

            $retval['Statewide']['yes'] = $yes_total;
            $retval['Statewide']['no'] = $no_total;

            return $retval;

            var_dump($retval);

        }

        function get_prop_info($prop, $cycle) {
            global $site_conn;
            $conn = Util::get_ctb_conn();

            if (mb_substr($prop, 0, 1) == "0") {
                $prop = ltrim($prop, '0');
            }

            $sql = "SELECT * FROM ctb_ca_props WHERE prop_session = '$cycle' && prop_no = '$prop'";
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row;
                }
            }

            return $retval;


        }

        function convert_county_num($num) {

            $conversion_array = Array(
                "001" => "ALAMEDA",
                "003" => "ALPINE",
                "005" => "AMADOR",
                "007" => "BUTTE",
                "009" => "CALAVERAS",
                "011" => "COLUSA",
                "013" => "CONTRA COSTA",
                "015" => "DEL NORTE",
                "017" => "EL DORADO",
                "019" => "FRESNO",
                "021" => "GLENN",
                "023" => "HUMBOLDT",
                "025" => "IMPERIAL",
                "027" => "INYO",
                "029" => "KERN",
                "031" => "KINGS",
                "033" => "LAKE",
                "035" => "LASSEN",
                "037" => "LOS ANGELES",
                "039" => "MADERA",
                "041" => "MARIN",
                "043" => "MARIPOSA",
                "045" => "MENDOCINO",
                "047" => "MERCED",
                "049" => "MODOC",
                "051" => "MONO",
                "053" => "MONTEREY",
                "055" => "NAPA",
                "057" => "NEVADA",
                "059" => "ORANGE",
                "061" => "PLACER",
                "063" => "PLUMAS",
                "065" => "RIVERSIDE",
                "067" => "SACRAMENTO",
                "069" => "SAN BENITO",
                "071" => "SAN BERNARDINO",
                "073" => "SAN DIEGO",
                "075" => "SAN FRANCISCO",
                "077" => "SAN JOAQUIN",
                "079" => "SAN LUIS OBISPO",
                "081" => "SAN MATEO",
                "083" => "SANTA BARBARA",
                "085" => "SANTA CLARA",
                "087" => "SANTA CRUZ",
                "089" => "SHASTA",
                "091" => "SIERRA",
                "093" => "SISKIYOU",
                "095" => "SOLANO",
                "097" => "SONOMA",
                "099" => "STANISLAUS",
                "101" => "SUTTER",
                "103" => "TEHAMA",
                "105" => "TRINITY",
                "107" => "TULARE",
                "109" => "TUOLUMNE",
                "111" => "VENTURA",
                "113" => "YOLO",
                "115" => "YUBA",
            );

            return $conversion_array[$num];

        }


        function getprop($prop_no) {
            global $site_conn;
            global $cycle;
            global $election;

            $retval = "<div class='newseg_prop narrow_prop'>	";

            $committees = getpropcmte($prop_no);


            $totsup = '0.00';
            $totopp = '0.00';
            $oppexp = '0.00';
            $supexp = '0.00';

            foreach ($committees as $committee) {
                $thiscmte = $committee['cmte_id'];
                $thiscand = $committee['cmte_nm'];
                //echo("<br>Processing $thiscmte - $thiscand");
                $last = getnewlastf460($thiscmte, $election);
                //echo("<br>RETURNED F460 for $thiscmte from YEAR $election");
                //var_dump($last);
                $lastsummary = '0.00';
                $y2015summary = '0.00';
                $totalraised = '0.00';
                $raisedthis = '0.00';
                $raised2015 = '0.00';
                $raisedsince = '0.00';
                $totalspent = '0.00';
                $spentthis = '0.00';
                $spent2015 = '0.00';

                $lastdate = '';
                if ($last) {
                    //var_dump($last);
                    $y2015 = getnewlastf460($thiscmte, $cycle);
                    //echo("<br>RETURNED F460 for $thiscmte from YEAR $cycle");
                    //var_dump($y2015);
                    $lastdate = $last['RPT_END'];
                    $lastsummary = getsummary_b($last['FILING_ID']);
                    $y2015summary = getsummary_b($y2015);
                    $raised2015 = $y2015summary['YTD_RCPT'];
                    $raisedthis = $lastsummary['YTD_RCPT'];
                    $spent2015 = $y2015summary['YTD_EXPN'];
                    $spentthis = $lastsummary['YTD_EXPN'];

                }
                //echo("<br>LOOKING UP F497 FILINGS SINCE $lastdate");
                $f497s = getf497filingssince_b($thiscmte, $lastdate);
                //echo("<br>RETURNED F497 FILINGS SINCE $lastdate from $thiscmte");
                //var_dump($f497s);
                $raisedsince = getf497amounts_b($f497s, $lastdate);
                //echo("<br>RETURNED AMOUNTS RAISED SINCE $lastdate");
                //var_dump($raisedsince);


                if ($y2015 == $last['FILING_ID']) {
                    $raisedthis = '0.00';
                }

                $totalraised = $raised2015 + $raisedthis + $raisedsince;
                $totalspent = $spent2015 + $spentthis;

                if ($committee['cmte_position'] == "SUPPORT") {
                    $supopp = "<span class='greenme boldme'>SUPPORTING</span>";
                    $totsup += $totalraised;
                    $supexp += $totalspent;
                } else {
                    $supopp = "<span class='redme boldme'>OPPOSING</span>";
                    $totopp += $totalraised;
                    $oppexp += $totalspent;
                }

                //echo("<br>Got " . $totalraised . " Raised, $totalspent Spent");

                $retval .= "<p class='boldme' align='center'><a href='http://calelections.com/cmlocal2.php?id=$thiscmte' target='_blank'>$thiscand</a> - $supopp</p>";
                //echo("<br>$thiscand GETTING SUMMARY OF totalraised $totalraised FROM raised2015: $raised2015 + raisedthis: $raisedthis + raisedsince: $raisedsince<br>");
                $retval .= "

		<table class='tablesorter bordered' align='center'>
			<thead>
				<tr>
					<th>RAISED LAST PERIOD</th>
					<th>SINCE</th>
					<th>CYCLE</th>
					<th>SPENT THIS CYCLE</th>
					<th>LAST COH</th>

				</tr>
			</thead>
			<tbody>
				<tr>
					<td>\$" . number_format($lastsummary['RCPT'], 2, '.', ',') . "</td>
					<td>\$" . number_format($raisedsince, 2, '.', ',') . "</td>
					<td>\$" . number_format($totalraised, 2, '.', ',') . "</td>
					<td>\$" . number_format($totalspent, 2, '.', ',') . "</td>
					<td>\$" . number_format($lastsummary['COH'], 2, '.', ',') . "</td>

				<tr>
			</tbody>
		</table>
		";
            }
            $retval .= "<p align='center' class='boldme'>AMOUNTS RAISED BY ALL COMMITTEES THIS CYCLE</p><p align='center' class='boldme'>TOTAL SUPPORT: <span class='greenme'>\$" . number_format($totsup, 2, '.', ',') . "</span> - TOTAL OPPOSE: <span class='redme'>\$" . number_format($totopp, 2, '.', ',') . "</span></p>";
            $retval .= "<p align='center' class='boldme'>AMOUNTS SPENT BY ALL COMMITTEES THIS CYCLE</p><p align='center' class='boldme'>TOTAL SUPPORT: <span class='greenme'>\$" . number_format($supexp, 2, '.', ',') . "</span> - TOTAL OPPOSE: <span class='redme'>\$" . number_format($oppexp, 2, '.', ',') . "</span></p>";

            $retval .= "</div>";

            return $retval;

        }


        function getpropcmte($propno) {
            global $site_conn;
            global $cycle;
            $conn = Util::get_ctb_conn();
            $retval = Array();
            $tmp = Array();
            $sql = "SELECT * FROM ctb_ca_props_ccl WHERE prop_no = '$propno' && session = '$cycle' ORDER BY cmte_position DESC";
            //echo($sql);
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp['prop_no'] = $row['prop_no'];
                    $tmp['cmte_id'] = $row['cmte_id'];
                    $tmp['cmte_nm'] = $row['cmte_nm'];
                    $tmp['cmte_position'] = $row['cmte_position'];
                    array_push($retval, $tmp);
                }
            }

            //var_dump($retval);
            return $retval;
        }


        function getnewlastf460($committee, $year) {
            global $calaccess_conn;
            $conn = Util::get_ctb_conn();

            $retval = Array();
            $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && FILING_TYPE <> '0' && RPT_END LIKE '$year%' ORDER BY RPT_END DESC, FILING_SEQUENCE DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval['FILING_ID'] = $row['FILING_ID'];
                    $retval['RPT_END'] = $row['RPT_END'];
                }
            }

            return $retval;
        }


        function getf497filingssince_b($committee, $date) {
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

        function getf497amounts_b($filings, $lastdate) {
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


        function getsummary_b($filing) {
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


        ?>

    </div>
@endsection

@section('styles')
    <style>
        p, td, a, th, thead, tbody {
            font-family: 'PT Sans Narrow';
            padding-left: 5px;
            padding-right: 5px;
        }

        .narrow_prop {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            background-color: white;
            padding: 5px;
            border: 2px solid black;
        }

        .red, .redme {
            color: red;
        }

        .green, .greenme {
            color: green;
        }

        .tablesorter {
            width: 100%;
            font-family: 'PT Sans Narrow';
        }
    </style>
@endsection

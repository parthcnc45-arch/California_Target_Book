
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'Pending 2018 Propositions Financials | California Target Book')

@section('content')

<?php

Util::require_ctb_api();

global $cycle;
$cycle = "2017";

$props = get_props();

foreach($props as $prop_no) {

	$info = get_prop_info($prop_no);
	$x = getprop($prop_no);

	echo("<div class='newseg'>");
	echo("<p align='center'>Prop ID: <a href='http://cal-access.sos.ca.gov/Campaign/Measures/Detail.aspx?id=" . $prop_no . "&session=2017' target='_blank'>" . $prop_no . "</a></p>");
	echo("<p align='center'>" . $info['prop_dscr'] . "</p>");

	echo($x);
	echo("</div>");
}




function get_prop_info($prop_id) {
    global $site_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM ctb_ca_props_pending WHERE prop_id = '$prop_id'";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }

    $prop_no = $retval['prop_no'];
    $status = $retval['prop_status'];

    switch($status) {
        case "1":
            $retval['status'] = "Cleared for Circulation";
            break;
        case "25":
            $retval['status'] = "25% Signatures Threshold Met";
            break;
        case "50":
            $retval['status'] = "Signatures Submitted, Undergoing Verification";
            break;
        case "100":
            $retval['status'] = "Qualified for Ballot";
            break;
        case "0":
            $retval['status'] = "Withdrawn/Failed to Qualify";
            break;
    }


    //var_dump($retval);
    return $retval;


}





        function getprop($prop_no)
        {
            global $site_conn;
            global $cycle;
            global $election;

            $retval = "<div class='newseg narrow'>	";

            $committees = getpropcmte($prop_no);
            if(!$committees) {
            	return "<div class='newseg narrow'><p align='center'>NO COMMITTEES</div>";
            }


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

                <table class='tablesorter bordered'>
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

        function get_props() {
        	global $site_conn;
        	$conn = Util::get_ctb_conn();
        	$retval = Array();
        	$sql = "SELECT prop_id FROM ctb_ca_props_pending ORDER BY prop_id";
        	$result = $conn->query($sql);
        	if($result->num_rows > 0) {
        		while($row = $result->fetch_assoc()) {
        			array_push($retval, $row['prop_id']);
        		}
        	}
        	return $retval;
        }


        function getpropcmte($propno)
        {
            global $site_conn;
            global $cycle;
            $conn = Util::get_ctb_conn();
            $retval = Array();
            $tmp = Array();
            $sql = "SELECT * FROM ctb_ca_props_pending_ccl WHERE prop_id = '$propno'ORDER BY cmte_position DESC";
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


        function getnewlastf460($committee, $year)
        {
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


        function getf497filingssince_b($committee, $date)
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

        function getf497amounts_b($filings, $lastdate)
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


        function getsummary_b($filing)
        {
            global $calaccess_conn;
            $conn = Util::get_ctb_conn();

            if(is_array($filing)) {
                $filing = $filing['FILING_ID'];
            }

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


@endsection

@section('styles')
<style>
		.newseg td {
			padding-left: 5px;
			padding-right: 5px;
			text-align: right;
		}

		.newseg table {
			text-align: right;
		}

		.newseg {
			font-family: 'PT Sans Narrow';
			border: 2px black solid;
			max-width: 1600px;
			position: relative;
			margin-left: auto;
			margin-right: auto;
			position: relative;
		}

		.newseg h2 {
			padding-left: 50px;
			margin: 0;
			border: 1px gray solid;
		}

		.newseg h3 {
			padding-left: 100px;
			color: black;
			border: 1px gray solid;
			margin: 0;
		}

		.newseg h4 {
			padding-left: 200px;
			border: 1px gray solid;
			margin: 0;
		}

		.newseg h5 {
			padding-left: 300px;
			margin: 0;
		}

		.bordered {
			border: 1px solid black;
		}

		.bordered2 td {
			border: 1px solid black;
		}

		table.tablesorter {
			font-size: 14px;
			border: 1px solid #000;
			width: 100%;
			text-align: left;
		}

		table.tablesorter th {
			text-align: left;
			padding-left: 5px;
			padding-right: 5px;
		}

		table.tablesorter th.date {
			width: 70px;
		}

		table.tablesorter th.amount {
			width: 60px;
		}

		table.tablesorter td {
			padding-left: 5px;
			padding-right: 5px;
		}

		table.tablesorter .even {}

		table.tablesorter .odd {}

		table.tablesorter .header {
			background-image: url(bg.gif);
			background-repeat: no-repeat;
			background-position: center right;
			cursor: pointer;
			padding-right: 5px;
		}

		table.tablesorter .headerSortUp {
			background-image: url(asc.gif);
			background-repeat: no-repeat;
			background-position: center right;
		}

		table.tablesorter .headerSortDown {
			background-image: url(desc.gif);
			background-repeat: no-repeat;
			background-position: center right;
		}

		.bordered table {
			box-shadow: 3px 3px 3px #999;
		}

		.bordered th {
			background: rgb(82, 133, 216);
			/* Old browsers */
			background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important;
			/* FF3.6-15 */
			background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important;
			/* Chrome10-25,Safari5.1-6 */
			background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important;
			/* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			font-family: 'PT Sans Narrow';
			color: white;
			font-weight: bold;
		}

		.bordered tbody {
			background: rgb(255, 255, 255);
			background: -moz-linear-gradient(89deg, rgb(255, 255, 255) 8%, rgb(240, 240, 240) 100%);
			background: -webkit-linear-gradient(89deg, rgb(255, 255, 255) 8%, rgb(240, 240, 240) 100%);
			background: -o-linear-gradient(89deg, rgb(255, 255, 255) 8%, rgb(240, 240, 240) 100%);
			background: -ms-linear-gradient(89deg, rgb(255, 255, 255) 8%, rgb(240, 240, 240) 100%);
			background: linear-gradient(179deg, rgb(255, 255, 255) 8%, rgb(240, 240, 240) 100%);
		}

		.greenme {
			color: green;
		}

		.narrow {
			max-width: 800px;
			margin-top: 50px;
		}

		<style>p,
		td,
		a {
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
	</style>
@endsection

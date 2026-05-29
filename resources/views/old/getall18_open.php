<!DOCTYPE html>
<html lang="en">

<head>

<?php 

include "php/head.php"; 

?>


</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<style type="text/css">

body {
	background-color: transparent;
}

</style>

<?php

require_once('php/ctb_api.php');

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//error_reporting(E_ERROR | E_PARSE);

$conn = $calaccess_conn;
$conn3 = $fec18_conn;

echo("<div class='newseg'>
	<h2>This page lists all candidates who have filed statements of intention with the California Secretary of State to run for office in 2018 and any financial activity from their associated active campaign committees. The list includes committees established solely for the purpose of 'parking' campaign contributions for future use, and is not necessarily indicative that a candidate will pursue a 2018 run.

	</div>");


$districts = populatedistricts();




foreach($districts as $dist) {
	$tmp = mb_substr($dist, 0, 2);
	if($dist == ".SN1" || $dist == ".SN2" || $tmp == "CD") {
		$x = getfed($dist);
		echo($x);
	} else {
		$x = getstate($dist);
		echo($x);
	}
}

function getfed($dist) {
	global $conn;
	$retval = "<div class='newseg'><h1>" . longform($dist) . "</h1>
		<table class='tablesorter bordered'>
			<thead>
				<tr>
					<th>CANDIDATE</th>
					<th>RAISED THIS CYCLE</th>
					<th>ENDING $</th>
					<th>SPENT THIS CYCLE</th>
					<th>CAND. LOANS</th>
					<th>END DT</th>
				</tr>
			</thead>
			<tbody>

	";
	$x = getstatecommittees($dist);
	foreach($x as $committee) {
		$thiscmte = $committee['CAND_ID'];
		$thiscand = $committee['NAMF'] . " " . $committee['NAML'];
		$party = $committee['PARTY'];

		switch($party) {
			case "D":
				$party_class = 'blueme boldme';
				break;
			case "R":
				$party_class = 'redme boldme';
				break;
			case "Grn":
				$party_class = 'greenme boldme';
				break;
			default:
				$party_class = 'grayme boldme';
				break;
		}
		if($committee['COMM_ID']) {
			$cmte_lnk = "<a href='http://classic.fec.gov/fecviewer/CandidateCommitteeDetail.do?candidateCommitteeId=" . $committee['COMM_ID'] . "&tabIndex=3' target='blank'>" . $thiscand . " ($party)</a>";
		} elseif($committee['CAND_ID']) {
			$cmte_lnk = "<a href='http://classic.fec.gov/fecviewer/CandidateCommitteeDetail.do?candidateCommitteeId=" . $committee['CAND_ID'] . "&tabIndex=3' target='blank'>" . $thiscand . " ($party)</a>";

		} else {
			$cmte_lnk = $thiscand . " ($party) - no FEC#";
		}

		$fedsummary = getfec18sum($thiscmte);
		$retval .= "
				<tr class='$party_class'>
					<td>$cmte_lnk</th>
					<td>\$" . number_format($fedsummary['RECEIPTS'], 2, '.', ',') . "</td>
					<td>\$" . number_format($fedsummary['COH_END'], 2, '.', ',') . "</td>
					<td>\$" . number_format($fedsummary['EXPN'], 2, '.', ',') . "</td>
					<td>\$" . number_format($fedsummary['CAND_LOANS'], 2, '.', ',') . "</td>
					<td>" . $fedsummary['CVG_END_DT'] . "</td>
				<tr>
		";
	}
	$retval .= "</tbody></table></div>";
	return $retval;

}



function getstate($dist) {
	global $conn;
	$retval = "<div class='newseg'><h1>" . longform($dist) . "</h1>
		<table class='tablesorter bordered'>
			<thead>
				<tr>
					<th>CANDIDATE</th>
					<th>RAISED LAST PERIOD</th>
					<th>SINCE</th>
					<th>CYCLE</th>
					<th>SPENT THIS CYCLE</th>
					<th>CASH ON HAND</th>
					<th>PD END</th>
					
				</tr>
			</thead>
			<tbody>

	";

	$x = getstatecommittees($dist);
	foreach($x as $committee) {
		$thiscmte = $committee['COMM_ID'];
		$thiscandid = $committee['CAND_ID'];
		$thiscand = $committee['NAMF'] . " " . $committee['NAML'];
		$party = $committee['PARTY'];
		$lastdate = '';

		switch($party) {
			case "D":
				$party_class = 'blueme boldme';
				break;
			case "R":
				$party_class = 'redme boldme';
				break;
			case "Grn":
				$party_class = 'greenme boldme';
				break;
			default:
				$party_class = 'grayme boldme';
				break;
		}		

		$last = getlastf460($thiscmte);
		$lastsummary = '0.00';
		$y2015summary = '0.00';
		$totalraised = '0.00';
		$raisedthis = '0.00';
		$raised2015 = '0.00';
		$raisedsince = '0.00';
		$totalspent = '0.00';
		$spentthis = '0.00';
		$spent2015 = '0.00';

		if($last) {
			//var_dump($last);
			$y2015 = get2015f460($thiscmte);
			$lastdate = $last['RPT_END'];
			$lastsummary = getsummary($last['FILING_ID']);
			$y2015summary = getsummary($y2015);
			$raised2015 = $y2015summary['YTD_RCPT'];
			$raisedthis = $lastsummary['YTD_RCPT'];
			$spent2015 = $y2015summary['YTD_EXPN'];
			$spentthis = $lastsummary['YTD_EXPN'];
			
		}
		$f497s = getf497filingssince($thiscmte, $lastdate);
		$raisedsince = getf497amounts($f497s, $lastdate);


		if($y2015 == $last['FILING_ID']) {
			$raisedthis = '0.00';
		}

		if($thiscmte) {
			$thislink = "<a href='http://198.74.49.22/cmlocal2.php?id=$thiscmte' target='_blank'>$thiscand ($party)</a>";
			if(!$lastdate) {
				$lastdate = 'No Report Yet';
			}
		} else {
			$thislink = "<a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=$thiscandid' target='_blank'><em>$thiscand ($party)</em></a>";
			$lastdate = 'No Committee';
		}

		$totalraised = $raised2015 + $raisedthis + $raisedsince;
		$totalspent = $spent2015 + $spentthis;
		//echo("<br>$thiscand GETTING SUMMARY OF totalraised $totalraised FROM raised2015: $raised2015 + raisedthis: $raisedthis + raisedsince: $raisedsince<br>");
		$retval .= "
				<tr class='$party_class'>
					<td>$thislink</th>
					<td>\$" . number_format($lastsummary['RCPT'], 2, '.', ',') . "</td>
					<td>\$" . number_format($raisedsince, 2, '.', ',') . "</td>
					<td>\$" . number_format($totalraised, 2, '.', ',') . "</td>
					<td>\$" . number_format($totalspent, 2, '.', ',') . "</td>
					<td>\$" . number_format($lastsummary['COH'],2,'.',',') . "</td>
					<td>$lastdate</td>
					
				<tr>
		";

	}
	$retval .= "</tbody></table></div>";
	return $retval;
}

function longform($fourcode) {
	if(mb_substr($fourcode, 0, 1) == '.') {
		switch($fourcode) {
			case ".GOV":
				$long = "Governor";
				break;
			case ".LTG":
				$long = "Lieutenant Governor";
				break;
			case ".ATG":
				$long = "Attorney General";
				break;
			case ".INS":
				$long = "Insurance Commissioner";
				break;
			case ".SOS":
				$long = "Secretary of State";
				break;
			case ".CON":
				$long = "Controller";
				break;
			case ".SPI":
				$long = "Superintendent of Public Instruction";
				break;
			case ".TRS":
				$long = "Treasurer";
				break;
			case ".SN1":
				$long = "U.S. Senate Class 2";
				break;
			case ".SN2":
				$long = "U.S. Senate Class 1";
				break;
			default:
				$long = $fourcode;
				break;
		}
	} else {
		$long = $fourcode;
	}
	return $long;
}

function populatedistricts() {
	global $site_conn;
	$conn = $site_conn;
	$sql = "SELECT fourcode FROM e18_open_seats ORDER BY fourcode";
	$retval = Array();
	$tmp = Array();
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($retval, $row['fourcode']);
		}
	}
	return $retval;	
}

function getstatecommittees($dist) {
	global $conn;
	$retval = Array();
	$tmp =  Array();
	$sql = "SELECT * FROM e18_comm WHERE FOURCODE = '$dist' ORDER BY party";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['NAMF'] = $row['namf'];
			$tmp['NAML'] = $row['naml'];
			$tmp['CAND_ID'] = $row['cand_id'];
			$tmp['COMM_ID'] = $row['cmte_id'];
			$tmp['PARTY'] = $row['party'];
			array_push($retval, $tmp);
		}
	}
	return $retval;
}

function getlastf460($committee) {
	global $conn;
	$retval = Array();
	$sql = "SELECT * FROM FILER_FILINGS_CD WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && FILING_TYPE <> '0' ORDER BY RPT_END DESC, FILING_SEQUENCE DESC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['FILING_ID'] = $row['FILING_ID'];
			$retval['RPT_END'] = $row['RPT_END'];
		}
	}
	return $retval;
}

function get2015f460($committee) {
	global $conn;
	$sql = "SELECT * FROM FILER_FILINGS_CD WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && FILING_TYPE <> '0' && RPT_END = '2015-12-31' ORDER BY FILING_SEQUENCE DESC LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row['FILING_ID'];
		}
	}
	return $retval;

}

function getf497filingssince($committee, $date) {
	global $conn;
	$tmp = Array();
	$retval = Array();
	$lastfiling = '';
	$sql = "SELECT * FROM FILER_FILINGS_CD WHERE FILER_ID = '$committee' && RPT_END > '$date' && FILING_TYPE <> '0' ORDER BY FILING_ID DESC, FILING_SEQUENCE DESC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$thisfiling = $row['FILING_ID'];
			if($thisfiling == $lastfiling) {
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

function getf497amounts($filings, $lastdate) {
	global $conn;
	$retval = 0;
	$highest = '';
	foreach($filings as $filing) {
		$sql = "SELECT AMOUNT, AMEND_ID, LINE_ITEM, CTRIB_DATE FROM S497_CD WHERE FILING_ID = '" . $filing['FILING_ID'] . "' && FORM_TYPE = 'F497P1' ORDER BY LINE_ITEM ASC, AMEND_ID DESC";
		//echo("<br>$sql<br>");
		$result = $conn->query($sql);
		$highest = '';
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				if(!$highest) {
					$highest = $row['AMEND_ID'];
				}
				$thisamend = $row['AMEND_ID'];
				if($thisamend < $highest) {
					//DO NOTHING
				} else {
					if($row['CTRIB_DATE'] > $lastdate) {
						$retval += $row['AMOUNT'];
					}
				}
			}
		}
		//echo("<br>Retval is $retval after processing filing #" . $filing['FILING_ID'] . "<Br>");
	}

	return $retval;
}

function getiesince($committee, $date) {

}

function getsummary($filing) {
	global $conn;
	$retval = Array();
	//CONTRIBUTIONS THIS PERIOD
	$sql = "SELECT AMOUNT_A FROM SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['RCPT'] = $row['AMOUNT_A'];

		}
	}
	//CONTRIBUTIONS THIS CALENDAR YEAR
	$sql = "SELECT AMOUNT_B FROM SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '5' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['YTD_RCPT'] = $row['AMOUNT_B'];
		}
	}
	//EXPENDITURES
	$sql = "SELECT AMOUNT_A from SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['EXPN'] = $row['AMOUNT_A'];
		}
	}
	//YTD EXPENDITURES
	$sql = "SELECT AMOUNT_B from SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '11' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['YTD_EXPN'] = $row['AMOUNT_B'];
		}
	}
	//CASH ON HAND
	$sql = "SELECT AMOUNT_A FROM SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '16' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['COH'] = $row['AMOUNT_A'];
		}
	}
	//LOANS
	$sql = "SELECT AMOUNT_B FROM SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '2' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['LOANS'] = $row['AMOUNT_B'];
		}
	}
	//DEBTS
	$sql = "SELECT AMOUNT_A from SMRY_CD WHERE FILING_ID = " . $filing . " && REC_TYPE = 'SMRY' && LINE_ITEM = '19' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['DEBTS'] = $row['AMOUNT_A'];
		}
	}
	return $retval;
}

function getfec18sum($candidate) {
	global $fec18_conn;
	$conn3=$fec18_conn;
	$tmp = Array();
	$retval = Array();
	$sql = "SELECT * FROM weball WHERE CAND_ID = '$candidate'";
	//echo($sql);
	$result = $conn3->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp['RECEIPTS']		= $row['TTL_RECEIPTS'];
			$tmp['EXPN']			= $row['TTL_DISB'];
			$tmp['COH_START']	= $row['COH_BOP'];
			$tmp['COH_END']		= $row['COH_COP'];
			$tmp['CAND_LOANS']	= $row['CAND_LOANS'];
			$tmp['OTH_LOANS']	= $row['OTHER_LOANS'];
			$tmp['CVG_END_DT'] = $row['CVG_END_DATE'];
			$tmp['DEBTS']	   = $row['DEBTS_OWED_BY'];
			$year = mb_substr($row['CVG_END_DT'], 6, 4);
			$month = mb_substr($row['CVG_END_DT'], 0, 2);
			$day = mb_substr($row['CVG_END_DT'], 3,2);
			$tmp['CVG_END_DT'] = $year . "-" . $month . "-" . $day;
			}
	}

	$retval = $tmp;

	return $retval;
}


?>
</body>

</html>

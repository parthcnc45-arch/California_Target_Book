<style>

	.dist_header {
		font-family: 'Lato';
		font-size: 1.4em;
		font-variant: small-caps;
		font-weight: bold;
	}

</style>

<?php 

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$endjava = Array();

require_once "php/ctb_api.php";
require_once "php/head.php";

$districts = populate_districts();
ksort($districts);



foreach($districts as $fourcode => $reason) {
	echo("<p align='center' class='dist_header'>$fourcode<br>$reason</p>");
	$cands = get_candidates($fourcode);


	$table_head = "<div class='newseg'>
					<table class='bordered tablesorter'>
						<thead>
							<tr>
								<th>CAND ID</th>
								<th>NAME</th>
								<th>PARTY</th>
								<th>'17 Q1</th>
								<th>'17 Q2</th>
								<th>'17 Q3</th>
								<th>'17 Q4</th>
								<th>'17 TOT</th>
								<th>EXP TOT</th>
								<th>LAST COH</th>
								<th>DEBT</th>
								<th>LAST FILING</th>
								<th>PD END</th>
							</tr>
						</thead>
						<tbody>";
	$table_body = '';
	foreach($cands as $key => $x) {
		$f = get_financials($x['cmte_id']);
		foreach($f as $key2 => $value) {
			$most_recent_quarter = $key2;
		}
		$tot_rcpt = $f['2017_Q1']['rcpt'] +  $f['2017_Q2']['rcpt'] +  $f['2017_Q3']['rcpt'] +  $f['2017_Q4']['rcpt'];
		$tot_expn = $f['2017_Q1']['expn'] +  $f['2017_Q2']['expn'] +  $f['2017_Q3']['expn'] +  $f['2017_Q4']['expn'];
		switch($x['party']) {
			case "DEM":
				$add_class = 'blueme';
				break;
			case "REP":
				$add_class = 'redme';
				break;
			case "DFL":
				$add_class = "blueme";
				break;
			case "GRE":
				$add_class = "greenme";
				break;
			default:
				$add_class = 'grayme';
				break;

		}

		$party = $x['party'];
		if($x['is_incumbent'] == "I") {
			$party .= "-Inc";
		}

		if($f['2017_Q1']['rcpt']) {
			$q1_2017 = number_format($f['2017_Q1']['rcpt']);
		} else {
			$q1_2017 = '';
		}

		if($f['2017_Q2']['rcpt']) {
			$q2_2017 = number_format($f['2017_Q2']['rcpt']);
		} else {
			$q2_2017 = '';
		}

		if($f['2017_Q3']['rcpt']) {
			$q3_2017 = number_format($f['2017_Q3']['rcpt']);
		} else {
			$q3_2017 = '';
		}

		if($f['2017_Q4']['rcpt']) {
			$q4_2017 = number_format($f['2017_Q4']['rcpt']);
		} else {
			$q4_2017 = '';
		}

		if($tot_rcpt) {
			$tot_rcpt = number_format($tot_rcpt);
		} else {
			$tot_rcpt = '';
		}

		if($tot_expn) {
			$tot_expn = number_format($tot_expn);
		} else {
			$tot_expn = '';
		}

		if($f[$most_recent_quarter]['coh']) {
			$coh = number_format($f[$most_recent_quarter]['coh']);
		} else {
			$coh = '';
		}

		if($f[$most_recent_quarter]['debt']) {
			$debt = number_format($f[$most_recent_quarter]['debt']);
		} else {
			$debt = '';
		}

		if($f[$most_recent_quarter]['filing']) {
			$filing_lnk = "<a href='http://198.74.49.22/fedparser_dist.php?id=" . $f[$most_recent_quarter]['filing'] . "' target ='_blank'>" . $f[$most_recent_quarter]['filing'] . "</a>";
			$pd_end = $f[$most_recent_quarter]['pd_end'];
		} else {
			$filing_lnk = "NO REPORT";
			$pd_end = '';
		}



		$table_body .= "<tr class='$add_class'>
							<td align='left'>" . $key . "</td>
							<td align='left'>" . $x['cand_nm'] . "</td>
							<td align='left'>" . $party . "</td>
							<td align='right'>$q1_2017</td>
							<td align='right'>$q2_2017</td>
							<td align='right'>$q3_2017</td>
							<td align='right'>$q4_2017</td>
							<td align='right'>" . $tot_rcpt . "</td>
							<td align='right'>" . $tot_expn . "</td>
							<td align='right'>$coh</td>
							<td align='right'>$debt</td>
							<td align='right'>$filing_lnk</td>
							<td align='right'>$pd_end</td>
						</tr>";
	}
	echo($table_head . $table_body . "</tbody></table></div>");
}

function get_financials($cmte_id) {
	global $fec_conn;
	$conn = $fec_conn;
	$sql = "SELECT * FROM f3_summary WHERE cmte_id = '$cmte_id' ORDER BY pd_end, filing DESC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$pd_start = $row['pd_start'];
			$pd_end = $row['pd_end'];
			if(mb_substr($pd_start < "2017")) {
				continue;
			}

			switch($pd_end) {
				case "20170331":
					$key = "2017_Q1";
					break;
				case "20170630":
					$key = "2017_Q2";
					break;
				case "20170930":
					$key = "2017_Q3";
					break;
				case "20171231":
					$key = "2017_Q4";
					break;
				case "20180331":
					$key = "2018_Q1";
					break;
				case "20180630":
					$key = "2018_Q2";
					break;
			}

			$retval[$key]['rcpt'] 	= $row['rcpt'];
			$retval[$key]['expn'] 	= $row['expn'];
			$retval[$key]['coh'] 	= $row['coh_end'];
			$retval[$key]['debt'] 	= $row['debt'];
			$retval[$key]['filing'] = $row['filing'];

			$year = mb_substr($pd_end, 0, 4);
			$month = mb_substr($pd_end, 4, 2);
			$day = mb_substr($pd_end, 6, 2);

			$pd_end_date = $year . "-" . $month . "-" . $day;

			$retval[$key]['pd_end'] = $pd_end_date;

		}
	}
	return $retval;
}


function populate_districts() {
	global $fec_conn;
	$conn = $fec_conn;
	$sql = "SELECT * FROM e18_targets ORDER BY fourcode";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$key = $row['fourcode'];
			$retval[$key] = $row['targeted_by'] . " Target";
		}
	}

	$sql = "SELECT * FROM e18_open ORDER BY fourcode";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$key = $row['fourcode'];
			$reason = "OPEN SEAT - " . $row['incumbent'] . " (" . $row['party'] . ") is " . $row['reason'];
			$retval[$key] = $reason;
		}
	}

	return $retval;

}

function get_candidates($fourcode) {
	global $fec18_conn;
	$conn = $fec18_conn;
	$state = mb_substr($fourcode, 0, 2);
	$dist = mb_substr($fourcode, 2, 2);

	$sql = "SELECT * FROM cn WHERE CAND_ELECTION_YR = '2018' && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = '$dist' && CAND_OFFICE = 'H' ORDER BY CAND_PTY_AFFILIATION, CAND_NAME";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$key = $row['CAND_ID'];
			$cmte_id = $row['CAND_PCC'];
			$cand_nm = $row['CAND_NAME'];
			$party = $row['CAND_PTY_AFFILIATION'];
			$is_incumbent = $row['CAND_ICI'];
			$retval[$key]['cmte_id'] = $cmte_id;
			$retval[$key]['cand_nm'] = $cand_nm;
			$retval[$key]['party'] = $party;
			$retval[$key]['is_incumbent'] = $is_incumbent;
		}
	}
	return $retval;

}

?>
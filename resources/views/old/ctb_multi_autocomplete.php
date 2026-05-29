<?php 
/*

multi_autocomplete.php

This PHP script takes a JSON input string that contains the following recognized parameters

@scope (fec, fppc, netfile, ctb)
@search_type (contributor, vendor, treasurer, cand_nm, cmte_nm, cmte_list, dns)
@county
@city
@zip
@name
@start
@end 
@cmte_id

then queries the appropriate database, returning the results in a $response variable that is JSON encoded and echoed back

{"scope":"fec","type":"contributor","name":"1","city":"2","state":"3","zip":"4"}{"scope":"fec","type":"contributor","name":"1","city":"2","state":"3","zip":"4"}

*/

Util::require_ctb_api();
global $response;


//$input = request()->all();
//var_dump($input);


$json_str = $_GET['q'];
//echo($json_str);
$json_str = str_replace("formData=", "", $json_str);
$json_str = urldecode($json_str);
//echo($json_str);
//echo("INPUT: $json_str");
$arr = json_decode($json_str, TRUE);
//var_dump($arr);

switch($arr['scope']) {
	case "fec":
		fec_search($arr);
		break;
	case "fppc":
		fppc_search($arr);
		break;
	case "netfile":
		netfile_search($arr);
		break;
	case "ctb":
		ctb_search($arr);
		break;
}

$response['json_input'] = $json_str;
$json = json_encode($response);


header('Content-type: application/json');
echo($json);


function fec_search($arr) {
	global $response, $master_conn;
	switch($arr['type']) {
		case "contributor":
			fec_contributor($arr);
			break;
		case "vendor":
			fec_vendor($arr);
			break;
		case "treasurer":
			fec_treasurer($arr);
			break;
		case "candidate":
			fec_candidate($arr);
			break;
		case "committee":
			fec_committee($arr);
	}


	
}

function fec_contributor($arr) {
	global $response;

	$conn = Util::get_ctb_conn();

	$q_city = '';
	$q_state = '';
	$q_zip = '';
	$query = '';
	$retval = [];
	$ts = [];

	if(isset($arr['city']) && !empty($arr['city'])) {
		$q_city = " && CITY LIKE \"" . $arr['city'] . "\" ";
	}

	if(isset($arr['state']) && !empty($arr['state'])) {
		$q_state = " && STATE = \"" . $arr['state'] . "\" ";
	}

	if(isset($arr['zip']) && !empty($arr['zip'])) {
		$q_zip = ' && ZIP_CODE LIKE \"' . mb_substr($arr['zip'], 0, 5) . "%\" ";
	}

	if(isset($arr['name']) && !empty($arr['name'])) {
		$tmp = explode(" ", $arr['name']);
		if(isset($tmp[1])) {
			$i = 0;
			foreach($tmp as $x) {
				$x = mysqli_escape_string($conn, $x);
				if($i == 0) {
					$query = "+$x*";
				} else {
					$query .= " +$x* ";
				}
				$i++;
			}
		} else {
			$query = " +" . $arr['name'] . "*";
		}
	}

	$years = ["24", "22", "20", "18", "16", "14", "12"];

	foreach($years as $year) {
		$table = "nufec_indiv_" . $year;
		$sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, NAME, CITY, STATE, ZIP_CODE, EMPLOYER, OCCUPATION
				FROM $table
				WHERE MATCH ( NAME ) AGAINST ( \"$query\" IN BOOLEAN MODE) $q_city $q_state $q_zip
				GROUP BY NAME, CITY, STATE, ZIP_CODE, EMPLOYER, OCCUPATION
				ORDER BY TOTAL DESC
				LIMIT 50";

		$result = $conn->query($sql);
		if($result && $result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$key = $row['NAME'] . $row['CITY'] . $row['STATE'] . mb_substr($row['ZIP_CODE'], 0, 5) . $row['EMPLOYER'] . $row['OCCUPATION'];
				if(!isset($retval[$key])) {
					$retval[$key] = [
						'NAME' => $row['NAME'],
						'CITY' => $row['CITY'],
						'STATE' => $row['STATE'],
						'ZIP_CODE' => mb_substr($row['ZIP_CODE'], 0, 5),
						'EMPLOYER' => $row['EMPLOYER'],
						'OCCUPATION' => $row['OCCUPATION'],
						'TOTAL' => 0
					];
				}
				$retval[$key]['TOTAL'] += $row['TOTAL'];
				$ts[$key] = $retval[$key]['TOTAL'];
			}
		}
	}

	arsort($ts);

	$html = "<table style='border: none;'>
				<thead>
					<tr>
						<th>DONOR</th>
						<th>CITY</th>
						<th>STATE</th>
						<th>ZIP</th>
						<th>EMPLOYER</th>
						<th>OCCUPATION</th>
						<th>TOTAL</th>
				<tbody>";

	if($ts) {
		foreach($ts as $key => $value) {
			$x = $retval[$key];
			$html .= "<tr>
							<td>" . $x['NAME'] . "</td>
							<td>" . $x['CITY'] . "</td>
							<td>" . $x['STATE'] . "</td>
							<td>" . $x['ZIP_CODE'] . "</td>
							<td>" . $x['EMPLOYER'] . "</td>
							<td>" . $x['OCCUPATION'] . "</td>
							<td align='right'>\$" . number_format($x['TOTAL']) . "</td>					
						</tr>";
		}
		$html .= "</tbody></table>";
	} else {
		$html = "<p>No results</p>";
	}
	$response['html'] = $html;
}



function fec_vendor($arr) {
	global $response;

	$conn = Util::get_ctb_conn();
	$q = isset($arr['name']) ? $arr['name'] : '';

	$years = ["24", "22", "20", "18", "16", "14", "12"];
	$retval = [];
	$cm_total = [];

	foreach($years as $year) {
		$table = "nufec_oppexp_" . $year;
		$cm_table = "nufec_cm_" . $year;

		$c1 = $table . ".CMTE_ID";
		$c2 = $cm_table . ".CMTE_ID";

		$query = '';
		$local_query = '';
		$add_like = '';
		$use_first = false;

		$tmp = explode(" ", $q);
		if(isset($tmp[1])) {
			$i = 0;
			foreach($tmp as $x) {
				if($i == 0 && strlen($x) < 2) {
					$use_first = true;
				}
				$x = mysqli_escape_string($conn, $x);
				if($i == 0) {
					$query = "+$x*";
				} else {
					$query .= " +$x* ";
				}
				$i++;
			}
		} else {
			$query = " +$q*";
		}

		if(!empty($arr['city'])) {
			$local_query .= " && CITY LIKE '" . $arr['city'] . "%' ";
		}

		if(!empty($arr['state'])) {
			$local_query .= " && STATE = '" . $arr['state'] . "'";
		}

		if(!empty($arr['zip'])) {
			$local_query .= " && ZIP_CODE LIKE '" . mb_substr($arr['zip'], 0, 5) . "%' ";
		}

		if($use_first) {
			$add_like = " && NAME LIKE \"$q%\" ";
		}

		$sql = "SELECT SUM(TRANSACTION_AMT) AS TOTAL, NAME, CITY, STATE, ZIP_CODE, $c1, CMTE_NM
				FROM $table
				INNER JOIN $cm_table
				ON $c1 = $c2
				WHERE MATCH ( NAME ) AGAINST ( '\"$query\"' IN BOOLEAN MODE) $local_query $add_like
				GROUP BY NAME, CITY, STATE, ZIP_CODE, CMTE_NM
				LIMIT 50";

		$result = $conn->query($sql);

		if($result && $result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$key = $row['NAME'] . $row['CITY'] . $row['STATE'] . mb_substr($row['ZIP_CODE'], 0, 5);
				$this_cmte = $row['CMTE_NM'];
				if(!isset($cm_total[$key][$this_cmte])) {
					$cm_total[$key][$this_cmte] = 0;
				}
				$cm_total[$key][$this_cmte] += $row['TOTAL'];

				if(!isset($retval[$key])) {
					$retval[$key] = [
						'NAME' => $row['NAME'],
						'CITY' => $row['CITY'],
						'STATE' => $row['STATE'],
						'ZIP_CODE' => mb_substr($row['ZIP_CODE'], 0, 5),
						'TOTAL' => 0
					];
				}
				$retval[$key]['TOTAL'] += $row['TOTAL'];
			}
		}
	}

	arsort($retval);

	$html = "<table style='border: none;'>
				<thead>
					<tr>
						<th>VENDOR</th>
						<th>CITY</th>
						<th>STATE</th>
						<th>ZIP</th>
						<th>TOTAL</th>
				<tbody>";

	if($retval) {
		foreach($retval as $key => $x) {
			$title = '';
			arsort($cm_total[$key]);
			foreach($cm_total[$key] as $cmte_nm => $total) {
				$title .= $cmte_nm . " - \$" . number_format($total) . "\n";
			}

			$html .= "<tr title=\"$title\">
							<td>" . $x['NAME'] . "</td>
							<td>" . $x['CITY'] . "</td>
							<td>" . $x['STATE'] . "</td>
							<td>" . $x['ZIP_CODE'] . "</td>
							<td align='right'>\$" . number_format($x['TOTAL']) . "</td>					
						</tr>";
		}
		$html .= "</tbody></table>";
	} else {
		$html = "<p>No Results</p>";
	}
	$response['html'] = $html;
	return $html;
}

function fec_treasurer($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$namf = isset($arr['namf']) ? $arr['namf'] : '';
	$naml = isset($arr['naml']) ? $arr['naml'] : '';

	$sql = "SELECT filing_id, filer_committee_id_number, committee_name, effective_date, treasurer_first_name, treasurer_last_name, agent_first_name, agent_last_name, custodian_first_name, custodian_last_name 
			FROM ctb_fec_f1_db 
			WHERE (treasurer_first_name LIKE \"$namf\" && treasurer_last_name LIKE \"$naml\") || 
				  (custodian_first_name LIKE \"$namf\" && custodian_last_name LIKE \"$naml\") || 
				  (agent_first_name LIKE \"$namf\" && agent_last_name LIKE \"$naml\") 
			GROUP BY filer_committee_id_number 
			ORDER BY filer_committee_id_number DESC ";
	$result = $conn->query($sql);
	$html = "<table style='border: none;'>
				<thead>
					<tr>
						<th>CMTE_ID</th>
						<th>CMTE_NM</th>
						<th>TREASURER</th>
						<th>AGENT</th>
						<th>CUSTODIAN OF RECORDS</th>
					</tr>
				<tbody>";	

	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$treasurer 	= trim($row['treasurer_first_name'] . " " . $row['treasurer_last_name']);
			$agent 		= trim($row['agent_first_name'] . " " . $row['agent_last_name']);
			$custodian 	= trim($row['custodian_first_name'] . " " . $row['custodian_last_name']);
			$html .= "<tr>
						<td>" . $row['filer_committee_id_number'] . "</td>
						<td>" . $row['committee_name'] . "</td>
						<td>" . $treasurer . "</td>
						<td>" . $agent . "</td>
						<td>" . $custodian . "</td>
					</tr>";
		}
	} else {
		$html = "<p>No Result</p>";
	}

	$html .= "</tbody></table>";
	$response['html'] = $html;
}

function fec_candidate($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$name = isset($arr['name']) ? $arr['name'] : '';
	$tmp = explode(" ", $name);
	$query = '';
	if(isset($tmp[1])) {
		foreach($tmp as $x) {
			$query .= " CAND_NAME LIKE \"%" . $x . "%\" &&";
		}
		$query = substr($query, 0, -2);
	} else {
		$query = " CAND_NAME LIKE \"%$name%\"";
	}

	$sql = "SELECT * FROM (
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_24
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_22
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_20
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_18
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_16
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_14
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_12
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_10
				WHERE ( $query )
				UNION ALL
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_08
				WHERE ( $query )
				UNION ALL		
				SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE, CAND_OFFICE_ST, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_STATUS, CAND_PCC
				FROM nufec_cn_06
				WHERE ( $query )
			) A 
			ORDER BY CAND_ELECTION_YR DESC";
	$result = $conn->query($sql);

	$html = "<table style='border: none;'>
				<thead>
					<tr>
						<th>YEAR</th>
						<th>CAND_ID</th>
						<th>CAND_NM</th>
						<th>PARTY</th>
						<th>OFFICE</th>
						<th>ICI</th>
						<th>STATUS</th>
						<th>CMTE_ID</th>
						<th>F3</th>
						<th>ALL</th>
					</tr>
				<tbody>";

	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			switch($row['CAND_OFFICE']) {
				case "P":
					$fourcode = "POTUS";
					break;
				case "H":
					$fourcode = $row['CAND_OFFICE_ST'] . $row['CAND_OFFICE_DISTRICT'];
					break;
				case "S":
					$fourcode = $row['CAND_OFFICE_ST'] . "SEN";
					break;
			}
			$cmte_id = $row['CAND_PCC'];
			$f3_url = $cmte_url = $all_url = '';
			if(!empty($cmte_id)) {
				$f3_url = get_cm_link($cmte_id, "CTB_F3");
				$cmte_url = get_cm_link($cmte_id, "FEC_CMTE");
				$all_url = get_cm_link($cmte_id, "ALL");
			}
			$cand_url = get_cm_link($row['CAND_ID'], "FEC_CAND");
			$html .= "<tr>
						<td>" . $row['CAND_ELECTION_YR'] . "</td>
						<td>" . $cand_url . "</td>
						<td>" . $row['CAND_NAME'] . "</td>
						<td>" . $row['CAND_PTY_AFFILIATION'] . "</td>
						<td>" . get_cm_link($fourcode, "CTB-US") . "</td>
						<td>" . $row['CAND_ICI'] . "</td>
						<td>" . $row['CAND_STATUS'] . "</td>
						<td>" . $cmte_url . "</td>
						<td>" . $f3_url . "</td>
						<td>" . $all_url . "</td>
					</tr>";
		}

	} else {
		$html = "<p>No Results</p>";
	}

	$html .= "</tbody></table>";
	$response['html'] = $html;
}

function fec_committee($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$name = isset($arr['name']) ? $arr['name'] : '';
	$tmp = explode(" ", $name);
	$query = '';
	if(!empty($tmp[1])) {
		foreach($tmp as $x) {
			$query .= " committee_name LIKE \"%" . $x . "%\" &&";
		}
		$query = substr($query, 0, -2);
	} else {
		$query = " committee_name LIKE \"%" . $name . "%\"";
	}

	$sql = "SELECT filer_committee_id_number, committee_name, committee_type, candidate_first_name, candidate_last_name, candidate_office, candidate_state, candidate_district, party_code, date_signed, leadership_pac, affiliated_committee_name, affiliated_first_name, affiliated_last_name
			FROM ctb_fec_f1_db 
			WHERE ( $query )
			GROUP BY filer_committee_id_number 
			ORDER BY filer_committee_id_number DESC ";

	$result = $conn->query($sql);
	$html = "<table style='border: none;'>
				<thead>
					<tr>
						<th>CMTE_ID</th>
						<th>CMTE_NM</th>
						<th>TYPE</th>
						<th>INFO</th>
						<th>F3</th>
						<th>ALL</th>
						<th>IE</th>
					</tr>
				<tbody>";

	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cmte_id = $row['filer_committee_id_number'];
			$cmte_nm = $row['committee_name'];
			$info = '';
			if($row['date_signed'] < "20220401") {
				$type = get_cmte_type($row['committee_type'], "old");	
			} else {
				$type = get_cmte_type($row['committee_type'], "new");	
			}
			if($row['leadership_pac'] == "X") {
				$type = "Leadership PAC";
			}
			if($row['committee_type'] == "A") {
				if(!empty($row['candidate_office'])) {
					switch($row['candidate_office']) {
						case "P":
							$fourcode = "POTUS";
							break;
						case "H":
							$fourcode = $row['candidate_state'] . $row['candidate_district'];
							break;
						case "S":
							$fourcode =  $row['candidate_state'] . "SEN";
							break;
					}
					$info = $row['candidate_first_name'] . " " . $row['candidate_last_name'] . " (" . $row['party_code'] . ") - $fourcode";
				}
			} elseif($type == "Leadership PAC") {
				if(!empty($row['affiliated_last_name'])) {
					$info = $row['affiliated_first_name'] . " " . $row['affiliated_last_name'];
				} elseif(!empty($row['affiliated_committee_name'])) {
					$info = $row['affiliated_committee_name'];
				}
			}
			
			$html .= "<tr>
						<td>" . get_cm_link($cmte_id, "FEC_CMTE") . "</td>
						<td>" . $row['committee_name'] . "</td>
						<td>" . $type . "</td>
						<td>" . $info . "</td>
						<td>" . get_cm_link($cmte_id, "CTB_F3") . "</td>
						<td>" . get_cm_link($cmte_id, "ALL") . "</td>
						<td>" . get_cm_link($cmte_id, "IE") . "</td>
					</tr>";
		}
	} else {
		$html = "<p>No Result</p>";
	}

	$html .= "</tbody></table>";
	$response['html'] = $html;
}


function fppc_search($arr) {

	switch($arr['type']) {
		case "contributor":
			fppc_contributor($arr);
			break;
		case "vendor":
			fppc_vendor($arr);
			break;
		case "committee":
			fppc_filer($arr);
			break;
	}

}

function fppc_contributor($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$name = isset($arr['name']) ? $arr['name'] : '';
	$tmp = explode(" ", $name);
	$city = isset($arr['city']) ? $arr['city'] : '';
	$state = isset($arr['state']) ? $arr['state'] : '';
	$zip = isset($arr['zip']) ? $arr['zip'] : '';

	$filtered = '';
	$query = '';
	$q2 = '';
	$i = 0;

	foreach($tmp as $x) {
		if(strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
			// DO NOTHING
		} else {
			$filtered .= " " . $x;
			$query .= "$x ";
			$q2 .= " NAME LIKE '%" . $x . "%' &&";
		}
		$i++;
	}

	$q2 = substr($q2, 0, -2);

	$local_query = '';
	if($city) {
		$local_query .= " && CTRIB_CITY LIKE '$city%' ";
	}

	if($state) {
		$local_query .= " && CTRIB_ST = '$state'";
	}

	if($zip) {
		$local_query .= " && CTRIB_ZIP4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
	}	

	$sql = "SELECT * FROM (
				SELECT *, CONCAT(CTRIB_NAMF, \" \", CTRIB_NAML) AS NAME, SUM(AMOUNT) AS TOTAL
				FROM calaccess_raw_RCPT_CD
				WHERE MATCH (CTRIB_NAMF, CTRIB_NAML) AGAINST ( '$query' IN BOOLEAN MODE)
				GROUP BY NAME, CTRIB_CITY, CTRIB_ST, CTRIB_ZIP4
			) A
			WHERE $q2 $local_query	
			ORDER BY TOTAL DESC
			LIMIT 20
		";

	$html = "<table>
				<thead>
					<tr>
						<th>NAME</th>
						<th>CITY</th>
						<th>STATE</th>
						<th>ZIP</th>
						<th>EMPLOYER</th>
						<th>OCCUPATION</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>";

	$result = $conn->query($sql);
	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$html .= "<tr>
							<td>" . $row['NAME'] . "</td>
							<td>" . $row['CTRIB_CITY'] . "</td>
							<td>" . $row['CTRIB_ST'] . "</td>
							<td>" . mb_substr($row['CTRIB_ZIP4'], 0, 5) . "</td>
							<td>" . $row['CTRIB_EMP'] . "</td>
							<td>" . $row['CTRIB_OCC'] . "</td>
							<td align='right'>\$" . number_format($row['TOTAL']) . "</td>
					</tr>";
		}
	}

	$html .= "</tbody></table>";
	$response['html'] = $html;
}

function fppc_vendor($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$name = isset($arr['name']) ? $arr['name'] : '';
	$tmp = explode(" ", $name);
	$city = isset($arr['city']) ? $arr['city'] : '';
	$state = isset($arr['state']) ? $arr['state'] : '';
	$zip = isset($arr['zip']) ? $arr['zip'] : '';

	$filtered = '';
	$query = '';
	$q2 = '';
	$i = 0;

	foreach($tmp as $x) {
		if(strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
			// DO NOTHING
		} else {
			$filtered .= " " . $x;
			$query .= "$x ";
			$q2 .= " NAME LIKE '%" . $x . "%' &&";

		}
		$i++;
	}

	$q2 = substr($q2, 0, -2);

	$local_query = '';
	if($city) {
		$local_query .= " && PAYEE_CITY LIKE '$city%' ";
	}

	if($state) {
		$local_query .= " && PAYEE_ST = '$state'";
	}

	if($zip) {
		$local_query .= " && PAYEE_ZIP4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
	}

	$sql = "SELECT * FROM (
				SELECT *, CONCAT(PAYEE_NAMF, \" \", PAYEE_NAML) AS NAME, SUM(AMOUNT) AS TOTAL
				FROM calaccess_raw_EXPN_CD
				WHERE MATCH (PAYEE_NAMF, PAYEE_NAML) AGAINST ( '$query' IN BOOLEAN MODE)
				GROUP BY NAME, PAYEE_CITY, PAYEE_ST, PAYEE_ZIP4
			) A
			WHERE $q2 $local_query
			ORDER BY TOTAL DESC
			LIMIT 20
		";


	$html = "<table>
				<thead>
					<tr>
						<th>NAME</th>
						<th>CITY</th>
						<th>STATE</th>
						<th>ZIP</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>";

	$result = $conn->query($sql);
	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$html .= "<tr>
							<td>" . $row['NAME'] . "</td>
							<td>" . $row['PAYEE_CITY'] . "</td>
							<td>" . $row['PAYEE_ST'] . "</td>
							<td>" . mb_substr($row['PAYEE_ZIP4'], 0, 5) . "</td>
							<td align='right'>\$" . number_format($row['TOTAL']) . "</td>
					</tr>";
		}
	}


	$html .= "</tbody></table>";
	$response['html'] = $html;
	//$response['sql'] = $sql;
	

}

function fppc_filer($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$name = isset($arr['name']) ? $arr['name'] : '';
	$tmp = explode(" ", $name);

	$filtered = '';
	$query = '';
	$q2 = '';
	$i = 0;

	foreach($tmp as $x) {
		if(strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
			// DO NOTHING
		} else {
			$filtered .= " " . $x;
			$query .= "$x ";
			$q2 .= " NAME LIKE \"%" . $x . "%\" &&";
		}
		$i++;
	}

	$q2 = substr($q2, 0, -2);

	$query_t = '';
	$limits = array(
		"type_cand" => "CANDIDATE/OFFICEHOLDER",
		"type_cmte" => "RECIPIENT COMMITTEE",
		"type_donor" => "MAJOR DONOR/INDEPENDENT EXPENDITURE COMMITTEE",
		"type_firm" => "FIRM",
		"type_client" => "CLIENT",
		"type_emp" => "EMPLOYER",
		"type_lobby" => "LOBBYIST"
	);

	foreach($limits as $key => $verbose) {
		if(isset($arr[$key]) && $arr[$key] == TRUE) {
			$query_t .= " FILER_TYPE = \"$verbose\" ||";
		}
	}
	$query_t = substr($query_t, 0, -2);

	$sql = "SELECT * FROM (
				SELECT *, CONCAT(NAMF, \" \", NAML) AS NAME
				FROM calaccess_raw_FILERNAME_CD
				WHERE MATCH (NAMF, NAML) AGAINST ( '$query' IN BOOLEAN MODE)
			) A
			WHERE $q2 && ( $query_t )
			GROUP BY FILER_ID
			ORDER BY FILER_ID DESC
			LIMIT 500
		";


	$result = $conn->query($sql);
	$retval = array();
	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($retval, $row);
		}
	}


	$html = "<table style='border: none; font-size: 0.8em !important; font-family: \"PT Sans Narrow\" !important;'>
				<thead>
					<tr>
						<th>FPPC ID</th>
						<th>RPT</th>
						<th>SMRY</th>
						<th>TYPE</th>
						<th>STATUS</th>
						<th>NAME</th>
						<th>EFFECT DATE</th>
						<th>INFO</th>
					</tr>
				</thead>
				<tbody>";

	foreach($retval as $x) {
		$status_span = ($x['STATUS'] == "ACTIVE") ? "<span class='greenme boldme'>ACTIVE</span>" : "<span class='redme boldme'>" . $x['STATUS'] . "</span>";
		$id = $x['FILER_ID'];
		$ctb_link = '';
		$sos_link = '';
		$smry_link = '';

		$info_link = get_cm_link($id, "CALACCESS_LOBBY");
		$sos_link = get_cm_link($id, "CALACCESS");
		if($x['FILER_TYPE'] == "RECIPIENT COMMITTEE") {
			$ctb_link = get_cm_link($id, "CMLOCAL");
		}
		if($x['FILER_TYPE'] == "RECIPIENT COMMITTEE" || $x['FILER_TYPE'] == "MAJOR DONOR/INDEPENDENT EXPENDITURE COMMITTEE") {
			$smry_link = get_cm_link($id, "IEDETAIL");
		}

		$show_xref = ($id != $x['XREF_FILER_ID']) ? $x['XREF_FILER_ID'] : '';
		$name = trim($x['NAMF'] . " " . $x['NAML']);

		$html .= "<tr>
						<td>" . $sos_link . "</td>
						<td>" . $ctb_link . "</td>
						<td>" . $smry_link . "</td>				
						<td>" . $x['FILER_TYPE'] . "</td>
						<td>" . $status_span . "</td>
						<td>" . mb_substr($name, 0, 128) . "</td>
						<td>" . $x['EFFECT_DT'] . "</td>
						<td>" . $info_link . "</td>
					</tr>";
	}

	$html .= "</tbody></table>";

	$response['html'] = $html;
	//$response['sql'] = $sql;

}


function netfile_search($arr) {

	switch($arr['type']) {
		case "contributor":
			netfile_contributor($arr);
			break;
		case "vendor":
			netfile_vendor($arr);
			break;
		case "committee":
			netfile_committee($arr);
			break;
	}
	
}

function netfile_contributor($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$name = isset($arr['name']) ? $arr['name'] : '';
	$tmp = explode(" ", $name);
	$city = isset($arr['city']) ? $arr['city'] : '';
	$state = isset($arr['state']) ? $arr['state'] : '';
	$zip = isset($arr['zip']) ? $arr['zip'] : '';

	$filtered = '';
	$query = '';
	$q2 = '';

	$i = 0;
	foreach($tmp as $x) {
		if(strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
			// DO NOTHING
		} else {
			$filtered .= " " . $x;
			$query .= "$x ";
			$q2 .= " NAME LIKE '%" . $x . "%' &&";
		}
		$i++;
	}

	$q2 = substr($q2, 0, -2);

	$local_query = '';
	if($city) {
		$local_query .= " && Tran_City LIKE '$city%' ";
	}

	if($state) {
		$local_query .= " && Tran_State = '$state'";
	}

	if($zip) {
		$local_query .= " && Tran_Zip4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
	}

	$sql = "SELECT * FROM (
				SELECT *, CONCAT(Tran_NamF, \" \", Tran_NamL) AS NAME, SUM(Tran_Amt1) AS TOTAL
				FROM netfile_contributions
				WHERE MATCH (Tran_NamF, Tran_NamL) AGAINST ( '$query' IN BOOLEAN MODE) && (Form_Type = 'A' || Form_Type = 'C')
				GROUP BY NAME, Tran_City, Tran_State, Tran_Zip4, Filer_ID, Tran_ID
			) A
			WHERE $q2 $local_query
			
			ORDER BY TOTAL DESC
			LIMIT 20
		";

	$html = "<table>
				<thead>
					<tr>
						<th>NAME<?th>
						<th>CITY</th>
						<th>STATE</th>
						<th>ZIP</th>
						<th>EMPLOYER</th>
						<Th>OCCUPATION</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>";

	$result = $conn->query($sql);
	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$name = $row['NAME'];
			$city = $row['Tran_City'];
			$st   = $row['Tran_State'];
			$zip  = $row['Tran_Zip4'];

			$dk = $name . $city . $st . $zip;

			$final[$dk]['Tran_City'] = $city;
			$final[$dk]['Tran_State'] = $st;
			$final[$dk]['Tran_Zip4'] = $zip;
			$final[$dk]['NAME'] = $name;
			$final[$dk]['Tran_Emp'] = $row['Tran_Emp'];
			$final[$dk]['Tran_Occ'] = $row['Tran_Occ'];
			$final[$dk]['TOTAL'] += $row['Tran_Amt1'];
		}
	}

	foreach($final as $dk => $row) {
		$html .= "<tr>
						<td>" . $row['NAME'] . "</td>
						<td>" . $row['Tran_City'] . "</td>
						<td>" . $row['Tran_State'] . "</td>
						<td>" . mb_substr($row['Tran_Zip4'], 0, 5) . "</td>
						<td>" . $row['Tran_Emp'] . "</td>
						<td>" . $row['Tran_Occ'] . "</td>
						<td align='right'>\$" . number_format($row['TOTAL']) . "</td>
				</tr>";
	}

	$html .= "</tbody></table>";
	$response['html'] = $html;
	//$response['sql'] = $sql;
}

function netfile_vendor($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$name = isset($arr['name']) ? $arr['name'] : '';
	$tmp = explode(" ", $name);
	$city = isset($arr['city']) ? $arr['city'] : '';
	$state = isset($arr['state']) ? $arr['state'] : '';
	$zip = isset($arr['zip']) ? $arr['zip'] : '';

	$filtered = '';
	$query = '';
	$q2 = '';

	$i = 0;
	foreach($tmp as $x) {
		if(strlen($x) == 2 && mb_substr($x, 1, 1) == ".") {
			// DO NOTHING
		} else {
			$filtered .= " " . $x;
			$query .= "$x ";
			$q2 .= " NAME LIKE '%" . $x . "%' &&";
		}
		$i++;
	}

	$q2 = substr($q2, 0, -2);

	$local_query = '';
	if($city) {
		$local_query .= " && Payee_City LIKE '$city%' ";
	}

	if($state) {
		$local_query .= " && Payee_State = '$state'";
	}

	if($zip) {
		$local_query .= " && Payee_Zip4 LIKE '" . mb_substr($zip, 0, 5) . "%' ";
	}

	$sql = "SELECT * FROM (
				SELECT *, CONCAT(Payee_NamF, \" \", Payee_NamL) AS NAME, SUM(AMOUNT) AS TOTAL
				FROM netfile_expenditures
				WHERE MATCH (Payee_NamF, Payee_NamL) AGAINST ( '$query' IN BOOLEAN MODE)
				GROUP BY NAME, Payee_City, Payee_State, Payee_Zip4, Filer_ID, Tran_ID
			) A
			WHERE $q2 $local_query
			
			ORDER BY TOTAL DESC
			LIMIT 20
		";

	$html = "<table>
				<thead>
					<tr>
						<th>NAME<?th>
						<th>CITY</th>
						<th>STATE</th>
						<th>ZIP</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>";

	$result = $conn->query($sql);
	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$name = $row['NAME'];
			$city = $row['Payee_City'];
			$st   = $row['Payee_State'];
			$zip  = $row['Payee_Zip4'];

			$dk = $name . $city . $st . $zip;

			$final[$dk]['Payee_City'] = $city;
			$final[$dk]['Payee_State'] = $st;
			$final[$dk]['Payee_Zip4'] = $zip;
			$final[$dk]['NAME'] = $name;
		        if(!isset($final[$dk]['TOTAL'])) {
			     $final[$dk]['TOTAL'] = $row['Amount'];
			} else {
	    		     $final[$dk]['TOTAL'] += $row['Amount'];
			}
		}
	}

	foreach($final as $dk => $row) {
		$html .= "<tr>
						<td>" . $row['NAME'] . "</td>
						<td>" . $row['Payee_City'] . "</td>
						<td>" . $row['Payee_State'] . "</td>
						<td>" . mb_substr($row['Payee_Zip4'], 0, 5) . "</td>
						<td align='right'>\$" . number_format($row['TOTAL']) . "</td>
				</tr>";
	}	

	$html .= "</tbody></table>";
	//$html .= $sql;
	$response['html'] = $html;
	//$response['sql'] = $sql;
}

function netfile_committee($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$aid = '';
	if(!empty($arr['city'])) {
		$aid = $arr['city'];
	} elseif(!empty($arr['county'])) {
		$aid = $arr['county'];
	}

	if(empty($aid)) {
		$response['html'] = "No location specified.";
		return;
	}

	$sql = "SELECT LOCATION, Filer_ID, Filer_NamL, netfile_locations.verbose, netfile_locations.juris 
			FROM netfile_summary
			INNER JOIN netfile_locations
			ON LOCATION = netfile_locations.aid
			WHERE LOCATION = '$aid'
			GROUP BY Filer_ID
			ORDER BY Filer_NamL";

	$result = $conn->query($sql);
	$html = "<table>
				<thead>
					<tr>
						<th>Location</th>
						<th>Cmte ID</th>
						<th>Committee</th>
					</tr>
				</thead>
				<tbody>";
	if($result && $result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$html .= "<tr>
						<td>" . $row['verbose'] . " (" . $row['juris'] . ")</td>
						<td><a href='https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id=" . $row['Filer_ID'] . "' target='_blank'>" . $row['Filer_ID'] . "</a></td>
						<td>" . $row['Filer_NamL'] . "</td>
					</tr>";
		}
	} else {
		$html .= "<tr><td colspan='3'>No results found.</td></tr>";
	}
	$html .= "</tbody></table>";
	$response['html'] = $html;
	//$response['sql'] = $sql;
}


function ctb_search($arr) {

	switch($arr['type']) {
		case "ca_candidate":
			ctb_ca_candidate($arr);
			break;
		case "domain":
			ctb_domain($arr);
			break;
	}
	//$response['sql'] = $sql;

}

function ctb_ca_candidate($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$q = isset($arr['name']) ? $arr['name'] : '';
	$tmp = isset($arr['name']) ? explode(" ", $arr['name']) : [];
	$retval = Array();

	$query = '';
	$query2 = '';
	$query3 = '';

	if (!empty($tmp)) {
		$i = 0;
		foreach ($tmp as $x) {
			$x = mysqli_escape_string($conn, $x);
			if ($i == 0) {
				$query = "name LIKE '%$x%'";
				$query2 = " CONCAT (namf, ' ', naml) LIKE '%$x%' ";
				$query3 = " CONCAT (IFNULL(namf, ''), ' ', IFNULL(namm, ''), ' ', IFNULL(naml, '')) LIKE '%$x%' ";
			} else {
				$query .= " && name LIKE '%$x%'";
				$query2 .= "&& CONCAT (namf, ' ', naml) LIKE '%$x%' ";
				$query3 .= " && CONCAT (IFNULL(namf, ''), ' ', IFNULL(namm, ''), ' ', IFNULL(naml, '')) LIKE '%$x%' ";
			}
			$i++;
		}
	} else {
		$query = "name LIKE '%$q%'";
		$query2 = " CONCAT (namf, ' ', naml) LIKE '%$q%'";
		$query3 = " CONCAT (IFNULL(namf, ''), ' ', IFNULL(namm, ''), ' ', IFNULL(naml, '')) LIKE '%$q%' ";
	}

	$sql = "SELECT name, cand_id, race, election FROM ctb_ca_candidates WHERE $query";
	$end_sql = $sql;
	$result = $conn->query($sql);
	if ($result && $result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$cand_lnk = "<a href='http://198.74.49.22/get_cand_page_t.php?id=" . $row['cand_id'] . "'>" . $row['name'] . "</a>";
			$tmp['cand_nm'] = $cand_lnk;

			$fourcode = '';
			$party = '';

			if (mb_substr($row['race'], 0, 3) == "ASS") {
				$fourcode = "AD" . mb_substr($row['race'], 3, 2);
				$party = mb_substr($row['race'], 5, 3);
			} elseif (mb_substr($row['race'], 0, 3) == "SEN") {
				$fourcode = "SD" . mb_substr($row['race'], 3, 2);
				$party = mb_substr($row['race'], 5, 3);
			} elseif (mb_substr($row['race'], 0, 3) == "CNG") {
				$fourcode = "CD" . mb_substr($row['race'], 3, 2);
				$party = mb_substr($row['race'], 5, 3);
			} elseif (mb_substr($row['race'], 0, 3) == "BOE") {
				$fourcode = "BOE" . mb_substr($row['race'], 4, 1);
				$party = mb_substr($row['race'], 5, 3);
			} elseif (mb_substr($row['race'], 0, 3) != "PR_") {
				$fourcode = "." . mb_substr($row['race'], 0, 3);
				$party = mb_substr($row['race'], 3, 3);
			}

			$link = "<a href='https://californiatargetbook.com/ctb-legacy/get_cal_page_t.php?id=$fourcode' target='_blank'>$fourcode</a>";
			$tmp['fourcode'] = $link;
			$tmp['party'] = $party;
			$tmp['juris'] = "CA";
			$tmp['date'] = isset($row['election']) ? $row['election'] : '';
			array_push($retval, $tmp);
		}
	}

	$sql = "SELECT NAMF, NAML, CNTYNAME AS COUNTY, PLACE, DATE, OFFICE FROM ctb_votes_local_office WHERE $query2";
	$end_sql .= "\n" . $sql;
	$result = $conn->query($sql);
	if ($result && $result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$tmp['cand_nm'] = $row['NAMF'] . " " . $row['NAML'];

			$link = "<a href='https://californiatargetbook.com/ctb-legacy/get_county_all.php?id=" . $row['COUNTY'] . "' target='_blank'>" . $row['PLACE'] . "</a>";

			$tmp['fourcode'] = $row['OFFICE'];
			$tmp['date'] = isset($row['DATE']) ? $row['DATE'] : '';
			$tmp['party'] = '';
			$tmp['juris'] = $link;
			array_push($retval, $tmp);
		}
	}

	$sql = "SELECT namf, naml, cand_id, party, FOURCODE FROM calaccess_raw_e20_comm WHERE $query2";
	$end_sql .= "\n" . $sql;
	$result = $conn->query($sql);
	if ($result && $result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$cand_nm = $row['cand_nm'] = $row['namf'] . " " . $row['naml'];
			$tmp['fourcode'] = "<a href='https://californiatargetbook.com/book/old/" . $row['FOURCODE'] . "' target='_blank'>" . $row['FOURCODE'] . "</a>";
			$tmp['cand_nm'] = "<a href='https://californiatargetbook.com/ctb-legacy/get_cand_page_t.php?id=" . $row['cand_id'] . "' target='_blank'>" . $cand_nm . "</a>";
			$tmp['date'] = "p20";
			$tmp['party'] = isset($row['party']) ? $row['party'] : '';

			$tmp['juris'] = "CA";
			array_push($retval, $tmp);
		}
	}

	$sql = "SELECT year, type, namf, naml, cand_id, party, fourcode, is_inc, toptwo FROM ctb_cand_filed_v2 WHERE year > 2021 && $query2";
	$end_sql .= "\n" . $sql;
	$result = $conn->query($sql);
	if ($result && $result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$cand_nm = $row['cand_nm'] = $row['namf'] . " " . $row['naml'];
			$tmp['fourcode'] = "<a href='get_cal_page_t.php?id=" . $row['fourcode'] . "' target='_blank'>" . $row['fourcode'] . "</a>";
			$tmp['cand_nm'] = "<a href='get_cand_page_t.php?id=" . $row['cand_id'] . "' target='_blank'>" . $cand_nm . "</a>";
			$year = mb_substr($row['year'], 2, 2);
			if ($row['toptwo'] == 1) {
				$tmp['date'] = "g" . $year;
			} elseif ($row['type'] == "P") {
				$tmp['date'] = "p" . $year;
			} else {
				$tmp['date'] = strtolower($row['type']) . $year;
			}

			$tmp['party'] = isset($row['party']) ? $row['party'] : '';

			$tmp['juris'] = "CA";
			array_push($retval, $tmp);
		}
	}

	$primaries = Array("p18", "p20", "p22", "p24");
	foreach ($primaries as $primary) {
		$table = "ctb_" . $primary . "_filing_status";
		$sql = "SELECT fourcode, namf, namm, naml, party, county_filed FROM $table WHERE ( $query3 )";
		$result = $conn->query($sql);
		if ($result && $result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$cand_nm = $row['namf'];
				if (!empty($row['namm'])) {
					$cand_nm .= " " . $row['namm'];
				}
				if (!empty($row['naml'])) {
					$cand_nm .= " " . $row['naml'];
				}
				$tmp['party'] = isset($row['party']) ? $row['party'] : '';
				$tmp['fourcode'] = isset($row['fourcode']) ? $row['fourcode'] : '';
				$tmp['cand_nm'] = $cand_nm;
				$tmp['date'] = $primary;
				$tmp['juris'] = "PAPERS-" . isset($row['county_filed']) ? $row['county_filed'] : '';
				array_push($retval, $tmp);
			}
		}
	}

	$html = "<table style='border: none;'>
				<tbody>";

	foreach ($retval as $x) {
		$html .= "<tr>
						<td>" . $x['cand_nm'] . "</td>
						<td>" . $x['party'] . "</td>
						<td>" . $x['juris'] . "</td>
						<td>" . $x['fourcode'] . "</td>
						<td>" . $x['date'] . "</td>
					</tr>";
	}

	$html .= "</tbody></table>";
	//$response['sql'] = $sql;
	$response['html'] = $html;
}

function ctb_domain($arr) {
	global $response;
	$conn = Util::get_ctb_conn();
	$tmp = explode(" ", $arr['name']);
	$q = mysqli_real_escape_string($conn, $arr['name']);

	$queryConditions = array();
	foreach ($tmp as $x) {
		$queryConditions[] = "domain LIKE '%$x%'";
	}
	$queryCondition = implode(" AND ", $queryConditions);

	if (empty($queryCondition)) {
		$queryCondition = "domain LIKE '%$q%'";
	}

	$sql = "SELECT * FROM ctb_dns_log WHERE $queryCondition";
	$result = $conn->query($sql);

	$html = "<table>
	           <thead class='inverse thead-inverse'>
	              <tr>
	                 <th>DOMAIN</th>
	                 <th>TYPE</th>
	                 <th>LOGGED</th>	           
	               </tr>
	            </thead>
	            <tbody>";

	if ($result && $result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$html .= "<tr>
			             <td><a href='http://" . htmlspecialchars($row['domain']) . "' target='_blank'>" . htmlspecialchars($row['domain']) . "</a></td>
			             <td>" . htmlspecialchars($row['type']) . "</td>
			             <td><a href='https://www.whois.com/whois/" . htmlspecialchars($row['domain']) . "' target='_blank'>" . htmlspecialchars($row['logged']) . "</a></td>		          
			          </tr>";			
		}
	} else {
		$html .= "<tr><td colspan='3'>No Results</td></tr>";
	}

	$html .= "</tbody></table>";
	$response['html'] = $html;
}


function get_cmte_type($type, $vintage) {

		$new = Array(
			"A"	=> "Principal Campaign Cmte",
			"B"	=> "Authorized Cmte",
			"C" => "Sup/Opp One Cand (Not Authorized)",
			"D" => "Party Committee",
			"E"	=> "Separate Segregated Fund",
			"F"	=> "Sup/Opp Multiple Cand",
			"G" => "IE SuperPAC",
			"H" => "Hybrid PAC",
			"I"	=> "Joint Fundraising Cmte (Authorized)",
			"J" => "Joint Fundraising Cmte (Not Authorized)"
			);

		$old = Array(
			"A"	=> "Principal Campaign Cmte",
			"B"	=> "Authorized Cmte",
			"C" => "Sup/Opp One Cand (Not Authorized)",
			"D" => "Party Committee",
			"E"	=> "Separate Segregated Fund",
			"F"	=> "Sup/Opp Multiple Cand",
			"G"	=> "Joint Fundraising Cmte (Authorized)",
			"H" => "Joint Fundraising Cmte (Not Authorized)"
			);

		if($vintage == "old") {
			return $old[$type];
		} else {
			return $new[$type];
		}		

}

function get_cm_link($cmte_id, $type) {
	if(!$cmte_id) {
		return FALSE;
	}
	global $cycle;
	switch($type) {
		case "SMRY":
			return  "<a href='https://californiatargetbook.com/ctb-legacy/fec_cmte_report.php?cycle=$cycle&id=$cmte_id' target='_blank'>$cmte_id</a>";
		case "ALL":
			return  "<a href='https://californiatargetbook.com/ctb-legacy/getfedfilings.php?id=$cmte_id' target='_blank'>ALL</a>";
		case "CTB_F3":
			return  "<a href='https://californiatargetbook.com/book/fec_f3/$cmte_id/' target='_blank'>F3</a>";
		case "IE":
			return  "<a href='https://californiatargetbook.com/ctb-legacy/iedetail.php?id=$cmte_id' target='_blank'>IE</a>";
		case "IEDETAIL":
			return  "<a href='https://californiatargetbook.com/ctb-legacy/iedetail.php?id=$cmte_id' target='_blank'>SMRY</a>";
		case "FEC_CMTE":
			return "<a href='https://www.fec.gov/data/committee/$cmte_id/' target='_blank'>$cmte_id</a>";
		case "FEC_CAND":
			return "<a href='https://www.fec.gov/data/candidate/$cmte_id/' target='_blank'>$cmte_id</a>";
		case "CALACCESS":
			return "<a href='http://cal-access.sos.ca.gov/Misc/redirector.aspx?id=$cmte_id' target='_blank'>$cmte_id</a>";
		case "CMLOCAL":
			return  "<a href='https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>RPT</a>";
		case "CALACCESS_LOBBY":
			return "<a href='https://cal-access.sos.ca.gov/Lobbying/Employers/Detail.aspx?id=$cmte_id' target='_blank'>INFO</a>";
		case "CTB-US":
			if(mb_substr($cmte_id, 2, 3) == "SEN" || $cmte_id == "POTUS") {
				return $cmte_id;
			} else {
				return "<a href='https://californiatargetbook.com/book/us/$cmte_id' target='_blank'>$cmte_id</a>";
			}

	}
	
}

?>
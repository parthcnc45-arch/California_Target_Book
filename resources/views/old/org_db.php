<?php

$conn = Util::get_ctb_conn();

$chamber = $_GET['chamber'];
$org = $_GET['org'];
$year = $_GET['year'];

if(!empty($year) && !empty($org) && !empty($chamber)) {
	$retval = load_org_year_ratings($chamber, $org, $year);
} elseif(!empty($org) && !empty($chamber)) {
	$retval = load_org_years($chamber, $org);
} elseif(!empty($chamber)) {
	$retval = load_orgs($chamber);
}

echo json_encode($retval);

function load_orgs($chamber) {
	global $conn;
	$sql = "SELECT org FROM ctb_new_org_ratings WHERE office='$chamber' GROUP BY org ORDER BY org";
	$result = $conn->query($sql);

	$retval = [];;
	while ($row = $result->fetch_assoc()) {
    	$retval[] = $row;
	}
	$conn->close();	
	return $retval;
}

function load_org_years($chamber, $org) {
	global $conn;
	$sql = "SELECT years FROM ctb_new_org_ratings WHERE office='$chamber' && org = \"$org\" ORDER BY org";
	$result = $conn->query($sql);

	$retval = [];;
	while ($row = $result->fetch_assoc()) {
    	$retval[] = $row;
	}
	$conn->close();	
	return $retval;	
}

function load_org_year_ratings($chamber, $org, $year) {
	global $conn;
	if(mb_substr($chamber, 0, 1) != "U") {
		$add_state = " && state='CA' ";
	} else {
		$add_state = '';
	}
	$sql = "SELECT * FROM ctb_new_org_ratings WHERE office='$chamber' && org =\"$org\" && year = '$year' $add_state GROUP BY year, org, state, office ORDER BY org";
	$result = $conn->query($sql);

	$retval = [];;
	while ($row = $result->fetch_assoc()) {
    	$retval[] = $row;
	}
	$conn->close();	
	return $retval;	
}


?>

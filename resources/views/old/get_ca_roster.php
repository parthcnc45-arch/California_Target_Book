<?php

Util::set_errors();
Util::require_ctb_api();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$type = '';
$year = '2026';

if(!empty($_GET['type'])) {
	$type = $_GET['type'];
}

if(!empty($_GET['year'])) {
   $year = $_GET['year'];
}


if (empty($type)) {
    $type = "all";
}

$roster_body = '';
if ($type == "all") {
 
    if($year == "2018") {
	$table = "calaccess_raw_e18_comm";
        $sql = "SELECT * FROM $table ORDER BY naml";
    } elseif($year == "2020") {
	$table = "calaccess_raw_e20_comm";
        $sql = "SELECT * FROM $table ORDER BY naml";
    } else {
	$table = "ctb_cand_filed_v2";
	$sql = "SELECT * FROM $table WHERE year >= '$year' && hide != 1";
    }

    $conn = Util::get_ctb_conn();


    //echo("<br>$sql<br>");
    $result = $conn->query($sql);

    $list = Array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($list, $row);
        }
    }

    uasort($list, "namesort");

    $html = "";


    $roster_head = "<table id='roster' class='table table-striped bordered tablesorter' v-ctb-table>
						<thead>
							<tr>
								<th>Candidate</th>
								<th>Party</th>
								<th>District/Office</th>
								<th>Candidate ID</th>
								<th>Committee ID</th>
								<th>Is Incumbent</th>
								<th>Cycle</th>
							</tr>
						</thead>
						<tbody>
	";

    foreach ($list as $x) {

        $name = $x['naml'] . ", " . $x['namf'];
	$name = str_replace ("'", '"', $name);
	$cycle = $x['cycle'];
	if($x['is_inc'] == "1") {
		$inc_field = "INCUMBENT";
	} else {
		$inc_field = "NON-INC";
	}

        if (mb_substr($x['fourcode'], 0, 2) == "CD" || mb_substr($x['fourcode'], 0, 3) == ".SN") {
            $cand_lnk = "<a href='https://www.fec.gov/data/candidate/" . $x['cand_id'] . "/' target='_blank'>" . $x['cand_id'] . "</a>";
            $cmte_lnk = "<a href='https://www.fec.gov/data/committee/" . $x['cmte_id'] . "/?tab=filings' target='_blank'>" . $x['cmte_id'] . "</a>";

            $name_lnk = "<span id='$name'></span><a href='get_cand_page_t.php?id=" . $x['cand_id'] . "'>$name</a>";
        } else {
            $cand_lnk = "<a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=" . $x['cand_id'] . "' target='_blank'>" . $x['cand_id'] . "</a>";
            $cmte_lnk = "<a href='http://cal-access.sos.ca.gov/Campaign/Committees/Detail.aspx?id=" . $x['cmte_id'] . "' target='_blank'>" . $x['cmte_id'] . "</a>";
            $name_lnk = "<span id='$name'></span><a href='get_cand_page_t.php?id=" . $x['cand_id'] . "'>$name</a>";
        }

	if($year > 2021) {
		$dist_lnk = "<a href='/book/new/" . $x['fourcode'] . "' target='_blank'>" . $x['fourcode'] . "</a>";

	} else {
	        $dist_lnk = "<a href='/book/district/" . $x['fourcode'] . "'>" . $x['fourcode'] . "</a>";
	}


        $roster_body .= "
						<tr>
							<td>$name_lnk</td>
							<td>" . $x['party'] . "</td>
							<td>$dist_lnk</td>
							<td>$cand_lnk</td>
							<td>$cmte_lnk</td>
							<td>$inc_field</td>
							<td>$cycle</td>
						</tr>
		";

    }

    $roster_tail = "</tbody></table>";

    $html .= $roster_head . $roster_body . $roster_tail . $sql;
} elseif ($type == "inc") {
    $conn = Util::get_ctb_conn();
    $list = Array();

    switch($year) {
	case "2018":
		$table = "ctb2016_e18_incumbent";
		break;	
        case "2020":
		$table = "ctb2016_e20_incumbent";
		break;
	case "2022":
		$table = "ctb2016_e22_incumbent";
		break;
	case "2024":
		$table = "ctb2016_e24_incumbent";
		break;
	case "2026":
		$table = "ctb2016_e26_incumbent";
		break;
	default:
		$table = "ctb2016_e26_incumbent";
		break;
    }


    $sql = "SELECT * FROM $table ORDER BY DIST ASC";
    $result = $conn->query($sql);

    $html = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($list, $row);
        }
    }

    $roster_head = "<table id='roster' class='table table-striped bordered tablesorter' v-ctb-table>
						<thead>
							<tr>
								<th>Officeholder</th>
								<th>Party</th>
								<th>District/Office</th>
								<th>Date of Birth</th>
								<th>Term Limit</th>
							</tr>
						</thead>
						<tbody>
	";

    foreach ($list as $x) {

        $dist_lnk = "<a href='/book/new/" . $x['DIST'] . "'>" . $x['DIST'] . "</a>";
        $roster_body .= "
						<tr>
							<td>" . $x['LEGISLATOR'] . "</td>
							<td>" . $x['PARTY'] . "</td>
							<td>$dist_lnk</td>
							<td>" . $x['DOB'] . "</td>
							<td>" . $x['TERM_LIMIT'] . "</td>
						</tr>
		";
    }
    $roster_tail = "</tbody></table>";
    $html .= $roster_head . $roster_body . $roster_tail;
}


$response = array(
    'success' => TRUE,
    'content' => $html
);

header('Content-Type: application/json');
echo json_encode($response);


function namesort($a, $b)
{

    if ($a['naml'] < $b['naml']) {
        return -1;
    } elseif ($a['naml'] > $b['naml']) {
        return 1;
    } else {
        if ($a['namf'] < $b['namf']) {
            return -1;
        } elseif ($a['namf'] > $b['namf']) {
            return 1;
        } else {
            return 0;
        }
    }
}

?>


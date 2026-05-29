<?php

Util::set_errors();
Util::require_ctb_api();

$type = '';
$year = "2026";


if(!empty($_GET['type'])) {
	$type = $_GET['type'];
}

if(!empty($_GET['year'])) {
	$year = $_GET['year'];
}

if (empty($type)) {
    $type = "all";
}

if(!$year) {
	$year = "2026";
}

$html = '';
$roster_body = '';

if ($type == "all") {

    
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM nufec_fed_candidates WHERE office = 'H' && cycle = '$year' ORDER BY cand_nm";
    $result = $conn->query($sql);

    $list = Array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($list, $row);
        }
    }

    //uasort($list, "namesort");

    $html = "";


    $roster_head = "<table id='roster' class='table table-striped bordered tablesorter' v-ctb-table>
						<thead>
							<tr>
								<th>Candidate</th>
								<th>Party</th>
								<th>Office</th>
								<th>FEC ID</th>
							</tr>
						</thead>
						<tbody>
	";

    foreach ($list as $x) {

        $cand_nm_lnk = "<a href='get_cand_page_t.php?id=" . $x['cand_id'] . "'>" . $x['cand_nm'] . "</a>";
        //$cand_lnk = "<a href='http://www.fec.gov/fecviewer/CandidateCommitteeDetail.do?&tabIndex=3&candidateCommitteeId=" . $x['cand_id'] . "' target='_blank'>" . $x['cand_id'] . "</a>";
        $cand_lnk = "<a href='https://www.fec.gov/data/candidate/" . $x['cand_id'] . "/' target='_blank'>" . $x['cand_id'] . "</a>";
        $dist_lnk = "<a href='/book/us/" . $x['fourcode'] . "'>" . $x['fourcode'] . "</a>";
        $roster_body .= "
						<tr>
							<td>$cand_nm_lnk</td>
							<td>" . $x['party'] . "</td>
							<td>$dist_lnk</td>
							<td>$cand_lnk</td>
						</tr>
		";

    }

    $roster_tail = "</tbody></table>";

    $html .= $roster_head . $roster_body . $roster_tail;
} elseif ($type == "inc") {
    $conn = Util::get_ctb_conn();
    $list = Array();
    switch($year) {
	case "2018": 
		$table = "ctb2016_e18_fed";
		break;
	case "2020":
		$table = "ctb2016_e20_fed";
		break;
	case "2022":
		$table = "ctb2016_e22_fed";
		break;
	case "2024":
		$table = "ctb2016_e24_fed";
		break;
	case "2026":
		$table = "ctb2016_e26_fed";
		break;
	default:
		$table = "ctb2016_e24_fed";
		break;
    }

    $sql = "SELECT * FROM $table ORDER BY NAML, NAMF";
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
								<th>DOB</th>
								<th>District/Office</th>
								<th>Website</th>
								<th>Twitter</th>
								<th>Facebook</th>

							</tr>
						</thead>
						<tbody>
	";

    foreach ($list as $x) {

        if ($x['WEBSITE']) {
            $website = "<a href='" . $x['WEBSITE'] . "' target='_blank'><img src='/img/icons/gov.png' width='20px' /></a>";
        } else {
            $website = '';
        }

        if ($x['TWITTER']) {
            $twitter = "<a href='http://www.twitter.com/" . $x['TWITTER'] . "' target='_blank'><img src='/img/icons/tw.png' width='20px' /></a>";
        } else {
            $twitter = '';
        }

        if ($x['FACEBOOK']) {
            $facebook = "<a href='http://www.facebook.com/" . $x['FACEBOOK'] . "' target='_blank'><img src='/img/icons/fb.png' width='20px' /></a>";
        } else {
            $facebook = '';
        }

        $dist_lnk = "<a href='/book/us/" . $x['DIST'] . "'>" . $x['DIST'] . "</a>";

        $roster_body .= "
						<tr>
							<td>" . $x['NAML'] . ", " . $x['NAMF'] . "</td>
							<td>" . $x['PARTY'] . "</td>
							<td>" . $x['dob'] . "</td>
							<td>$dist_lnk</td>
							<td>$website</td>
							<td>$twitter</td>
							<td>$facebook</td>
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



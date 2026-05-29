<style>
    .candidate-panel {
        background-color: #fcfcfc;
        -webkit-box-shadow: -1px 1px 23px -5px rgba(0, 0, 0, 0.38);
        -moz-box-shadow: -1px 1px 23px -5px rgba(0, 0, 0, 0.38);
        box-shadow: -1px 1px 23px -5px rgba(0, 0, 0, 0.38);
        padding: 20px;
        width: 105%;
        max-width: 1190px;
        margin-right: 40px;
        margin-top: 20px;
    }

    .candidate-panel .candidate-content {
        background-color: #fcfcfc;
        line-height: 1.5;
        font-size: 1.1em;
        font-family: 'Lato';
        padding: 10px;
    }

    .content-header {
        text-align: center;
        font-variant: small-caps;
    }

    .panel {
        background-color: #fcfcfc;

    }


</style>

<?php
$fourcode = $id;
global $vote_table_stored;
global $master_fourcode;

echo("<div  class='whitebg container-fluid' style='margin-left: auto; margin-right: auto; text-align: center;' align='center'>");

$years = Array("2022", "2020", "2018", "2016", "2014", "2012");

$year_head = "<div id='years' align='center' style='margin-top: 20px; margin-left: auto; margin-right: auto; display: inline-block; width: 100%;'><ul>";

global $year;

foreach ($years as $year) {
    $year_head .= "<li><a href='#e" . $year . "' class='fa fa-lg fa-book'>Election $year</a></li>";
}

echo($year_head);

foreach ($years as $year) {
    include('draw_fed_election_b.php');
}

echo("</ul>");
echo("</div>");
echo("</div>");
echo("</div>");


function getall()
{
    global $fec_conn;
    global $year;
    global $fourcode;
    $retval = Array();
    $candidates = getfiledcandidates();

    foreach ($candidates as $x) {
        $cand_id = $x['CAND_ID'];
        $y = getfinancials($cand_id);
        $y['CAND_NM'] = $x['CAND_NM'];
        $y['PARTY'] = $x['PARTY'];
        $y['CAND_ID'] = $cand_id;
        array_push($retval, $y);

    }

    return $retval;
}

function getgeneral()
{
    global $fec_conn;
    global $year;
    global $fourcode;
    $retval = Array();
    $candidates = getelectioncandidates();
    foreach ($candidates as $x) {
        $cand_id = $x['CAND_ID'];
        $y = getfinancials($cand_id);
        $y['CAND_NM'] = $x['CAND_NM'];
        $y['PARTY'] = $x['PARTY'];
        $y['CAND_ID'] = $cand_id;
        array_push($retval, $y);

    }

    return $retval;
}

function getelectioncandidates()
{
    global $year;
    global $fourcode;
    $retval = Array();
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM nufec_election_results WHERE FOURCODE = '$fourcode' && YEAR = $year";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['CAND_ID'] = $row['CAND_ID'];
            $tmp['CAND_NM'] = $row['NAMF'] . " " . $row['NAML'];
            $tmp['PARTY'] = $row['PARTY'];
            array_push($retval, $tmp);
        }
    }

    return $retval;
}

function getfinancials($cand_id)
{
    global $year;
    global $fourcode;
    global $fec_conn;
    $conn = Util::get_ctb_conn();

    $short_year = mb_substr($year, 2, 2);
    $table = 'nufec_weball_' . $short_year;

    $sql = "SELECT * FROM $table WHERE CAND_ID = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $x['RCPT'] = $row['TTL_RECEIPTS'];
            $x['COH_START'] = $row['COH_BOP'];
            $x['COH_END'] = $row['COH_COP'];
            $x['EXPN'] = $row['TTL_DISB'];
            $x['DEBTS'] = $row['DEBTS_OWED_BY'];
            $x['CAND_NM'] = $row['CAND_NAME'];
            $x['PARTY'] = $row['CAND_PTY_AFFILIATION'];
            $x['END_DATE'] = $row['CVG_END_DT'];
        }
    }

    return $x;
}

function get_committee_link($cand_id)
{
    global $year;
    global $fec_conn;
    $conn = Util::get_ctb_conn();


    $short_year = mb_substr($year, 2, 2);
    $table = 'nufec_cn_' . $short_year;

    $sql = "SELECT CAND_PCC FROM $table WHERE CAND_ID = '$cand_id'";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cmte_id = $row['CAND_PCC'];
            $url = "<a href='http://198.74.49.22/fec_cmte_report.php?cycle=$year&id=" . $cmte_id . "' target='_blank'>$cmte_id</a>";
        }
    }
    $retval['url'] = $url;
    $retval['cmte_id'] = $cmte_id;

    return $retval;
}

function getfiledcandidates()
{
    global $fourcode;
    global $year;
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $state = mb_substr($fourcode, 0, 2);
    $dist = mb_substr($fourcode, 2, 2);
    $retval = Array();

    $short_year = mb_substr($year, 2, 2);
    $table = 'nufec_cn_' . $short_year;
 
    $sql = "SELECT * FROM $table WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist ORDER BY CAND_PTY_AFFILIATION, CAND_NAME";

	
    //echo($sql);

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['CAND_NM'] = $row['CAND_NAME'];
            $tmp['PARTY'] = $row['CAND_PTY_AFFILIATION'];
            $tmp['CAND_ID'] = $row['CAND_ID'];
                       
            array_push($retval, $tmp);
        }

    }

    //var_dump($retval);
    return $retval;
}

//include 'php/storgsearch.php';

function has_late($cmte_id, $end_date) {
     $conn = Util::get_ctb_conn();
     if(!$end_date) {
	$end_date = "20201231";
     }
     $sql = "SELECT SUM(amt) AS amt FROM nufec_f6_log WHERE cmte_id = '$cmte_id' && transaction_dt > '$end_date'";
     $result=$conn->query($sql);
     if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
	    $amt = $row['amt'];
	}
	$retval = "<a href='https://californiatargetbook.com/ctb-legacy/fec_f6_detail.php?id=$cmte_id&dt=$end_date' target='_blank'>" . number_format($amt) . "</a>";
     }
     if($amt > 0) {
	return $retval;
     } else {
        return FALSE;
     }
}


function getfed_since($cmte, $end_date) {
	
	$conn = Util::get_ctb_conn();
	if(!$cmte) {
		return FALSE;
	}


	if(mb_substr($end_date, 2, 1)=="/" ) {
		//DATE IS IN MM/DD/YYYY FORMAT
		$end_year = mb_substr($end_date, 6, 4);
		$end_month = mb_substr($end_date, 0, 2);
		$end_day = mb_substr($end_date, 3, 2);

	} elseif (mb_substr($end_date, 4, 1) == "-") {
		//DATE IS IN YYYY-MM-DD FORMAT
		$end_year = mb_substr($end_date, 0, 4);
		$end_month = mb_substr($end_date, 5, 2);
		$end_day = mb_substr($end_date, 8, 2);
	}

        $adjusted_date = $end_year . $end_month . $end_day;

	$x = has_late($cmte, $adjusted_date);
	if($x) {
	     return $x;
	} else {
	     $sql = "SELECT SUM(amt) AS amt FROM ctb_actblue_summary WHERE cmte_id = '$cmte' && (year >= '$year' && month > $month)";
	}



	if(!$end_date) {
		$end_date = "2020-12-31";
	}

	$sql = "SELECT SUM(amt) AS amt FROM ctb_actblue_summary WHERE cmte_id = '$cmte' && (year >= '$end_year' && month > $end_month)";

	//echo("<br>$sql");

	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = number_format($row['amt']);
		}
	}
	return $retval;
}

function get_cand_name($cand_id)
{
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT cand_nm FROM nufec_e18_fed_candidates WHERE cand_id = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['cand_nm'];
        }
    }

    return $retval;
}

function get_bio($cand_id)
{
    global $site_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT text from ctb_cand_bios WHERE cand_id = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}

function get_cand_links($cand_id)
{
    global $site_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb_cand_links WHERE cand_id = '$cand_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }

    return $retval;
}

function process($x)
{
    global $fec_conn;
    global $fourcode;
    global $active_cands;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM nufec_e18_fed_candidates WHERE fourcode = '$fourcode' ORDER BY party, cand_nm";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cand_id = $row['cand_id'];

            $active_cands[$cand_id]['cand_id'] = $cand_id;

            $active_cands[$cand_id]['naml'] = $row['cand_nm'];
            $active_cands[$cand_id]['party'] = $row['party'];

        }
    }
}

function populate_candidates($year)
{
    //global $fec_conn;
    global $fourcode;
    global $fec_conn;
    global $fec18_conn;

    $state = mb_substr($fourcode, 0, 2);
    $dist = mb_substr($fourcode, 2, 2);

    $conn = Util::get_ctb_conn();

    $short_year = mb_substr($year, 2, 2);
    $table = 'nufec_cn_' . $short_year;

    $retval = Array();
    $sql = "SELECT * FROM $table WHERE CAND_ELECTION_YR = '$year' && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = '$dist' ORDER BY CAND_ICI DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['CAND_ICI'] == "O") {
                $open_seat = TRUE;
            }

            if ($open_seat && $row['CAND_ICI'] == "I") {
                continue;
            }

            $this_cand = $row['CAND_ID'];
            $tmp = $row;
            $tmp['bio'] = get_bio($this_cand);
            array_push($retval, $tmp);

        }
    }

    //var_dump($retval);
    return $retval;
}

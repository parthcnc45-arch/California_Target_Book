<?php

Util::require_ctb_api();

$q = $_REQUEST['q'];
$html = '';
if ($q !== "") {
    if (strlen($q) > 1) {
        $html = populate($q);

        /*
        foreach($arr as $x) {
            $cand_nm = $x['cand_nm'];
            $fourcode = $x['fourcode'];
            if($response === '') {
                $hint = $cand_nm . " ($fourcode)";
            } else {
                $hint .= "<br>$cand_nm ($fourcode)";
            }
        }
        */
    }
}

echo $html === '' ? 'No Match' : $html;

function populate($q)
{
    global $site_conn;
    $conn = Util::get_ctb_conn();

    $retval = Array();
    $arr = explode(" ", $q);
    if (count($arr) > 1) {
        $i = 0;
        foreach ($arr as $x) {
            $x = mysqli_escape_string($conn, $x);
            if ($i == 0) {
                $query = "name LIKE '%$x%'";
                $query2 = " CONCAT (namf, ' ', naml) LIKE '%$x%' ";
            } else {
                $query .= " && name LIKE '%$x%'";
                $query2 .= "&& CONCAT (namf, ' ', naml) LIKE '%$x%' ";
            }
            $i++;
        }
    } else {
        $query = "name LIKE '%$q%'";
        $query2 = " CONCAT (namf, ' ', naml) LIKE '%$q%'";
    }


    $sql = "SELECT name, cand_id, race, election FROM ctb_ca_candidates WHERE $query";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $cand_lnk = "<a href='/book/get_cand_page_t.php?id=" . $row['cand_id'] . "'>" . $row['name'] . "</a>";
            $tmp['cand_nm'] = $cand_lnk;

            //$tmp['fourcode'] = $row['fourcode'];

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
            } else {
                $fourcode = '';
                $party = '';
            }


            $link = "<a href='/book/district/$fourcode' target='_blank'>$fourcode</a>";
            $tmp['fourcode'] = $link;
            $tmp['party'] = $party;
            $tmp['juris'] = "CA";
            $tmp['date'] = $row['election'];
            array_push($retval, $tmp);
        }
    }

    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT NAMF, NAML, COUNTY, DATE, OFFICE FROM ctb2016_county_vote_hist WHERE $query2";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['cand_nm'] = $row['NAMF'] . " " . $row['NAML'];

            $link = "<a href='/book/get_county_all.php?id=" . $row['COUNTY'] . "' target='_blank'>" . $row['COUNTY'] . "</a>";


            $tmp['fourcode'] = $row['OFFICE'];
            $tmp['date'] = $row['DATE'];
            $tmp['party'] = '';
            $tmp['juris'] = $link;
            array_push($retval, $tmp);
        }
    }

    $sql = "SELECT NAMF, NAML, CITY, DATE, OFFICE FROM ctb2016_city_vote_hist WHERE $query2";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['cand_nm'] = $row['NAMF'] . " " . $row['NAML'];
            $tmp['fourcode'] = $row['OFFICE'];
            $tmp['date'] = $row['DATE'];
            $tmp['party'] = '';
            $link = "<a href='/book/get_city_results.php?id=" . $row['CITY'] . "' target='_blank'>" . $row['CITY'] . "</a>";

            $tmp['juris'] = $link;
            array_push($retval, $tmp);
        }
    }

    $sql = "SELECT NAMF, NAML, COUNTY, DATE, OFFICE FROM ctb2016_school_vote_hist WHERE $query2";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['cand_nm'] = $row['NAMF'] . " " . $row['NAML'];

            $link = "<a href='/book/get_county_all.php?id=" . $row['COUNTY'] . "' target='_blank'>" . $row['COUNTY'] . "</a>";


            $tmp['fourcode'] = $row['OFFICE'];
            $tmp['date'] = $row['DATE'];
            $tmp['party'] = '';
            $tmp['juris'] = $link;
            array_push($retval, $tmp);
        }
    }

    global $calaccess_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT namf, naml, cand_id, party, FOURCODE FROM calaccess_raw_e20_comm WHERE $query2";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cand_nm = $row['cand_nm'] = $row['namf'] . " " . $row['naml'];
            $tmp['fourcode'] = "<a href='/book/district/" . $row['FOURCODE'] . "' target='_blank'>" . $row['FOURCODE'] . "</a>";
            $tmp['cand_nm'] = "<a href='/book/get_cand_page_t.php?id=" . $row['cand_id'] . "' target='_blank'>" . $cand_nm . "</a>";
            $tmp['date'] = "p20";
            $tmp['party'] = $row['party'];


            $tmp['juris'] = "CA";
            array_push($retval, $tmp);
        }
    }


    $html = "<table class='table table-striped' v-ctb-table style='border: none;'>
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

    return $html;
}

?>
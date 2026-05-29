<?php

Util::require_ctb_api();

$q = $_REQUEST['q'];

if ($q != "") {
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
    global $fec_conn;
    $conn = $fec_conn;
    $retval = Array();
    $arr = explode(" ", $q);
    if ($arr[1]) {
        $i = 0;
        foreach ($arr as $x) {
            $x = mysqli_escape_string($conn, $x);
            if ($i == 0) {
                $query = "cand_nm LIKE '%$x%'";
                $query2 = " CONCAT (namf, ' ', naml) LIKE '%$x%' ";
            } else {
                $query .= " && cand_nm LIKE '%$x%'";
                $query2 .= "&& CONCAT (namf, ' ', naml) LIKE '%$x%' ";
            }
            $i++;
        }
    } else {
        $query = "cand_nm LIKE '%$q%'";
        $query2 = " CONCAT (namf, ' ', naml) LIKE '%$q%'";
    }


    $sql = "SELECT cand_nm, cand_id, fourcode, party FROM e18_fed_candidates WHERE $query";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            $cand_lnk = "<a href='http://198.74.49.22/get_cand_page_t.php?id=" . $row['cand_id'] . "'>" . $row['cand_nm'] . "</a>";
            $tmp['cand_nm'] = $cand_lnk;
            //$tmp['fourcode'] = $row['fourcode'];

            $link = "<a href='http://198.74.49.22/get_fed_page_t.php?id=" . $row['fourcode'] . "'>" . $row['fourcode'] . "</a>";
            $tmp['fourcode'] = $link;
            $tmp['party'] = $row['party'];
            $tmp['juris'] = "US";
            array_push($retval, $tmp);
        }
    }

    global $calaccess_conn;
    $conn = $calaccess_conn;

    $sql = "SELECT namf, naml, party, FOURCODE FROM e18_comm WHERE $query2";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tmp['cand_nm'] = $row['namf'] . " " . $row['naml'];

            $link = getctblink($row['FOURCODE']) . $row['FOURCODE'] . "</a>";

            $tmp['fourcode'] = $link;
            $tmp['party'] = $row['party'];
            $tmp['juris'] = "CA";
            array_push($retval, $tmp);
        }
    }

    $html = "<table class='table table-striped' style='border: none;'>
				<tbody>";


    foreach ($retval as $x) {
        $html .= "<tr>
						<td>" . $x['cand_nm'] . "</td>
						<td>" . $x['party'] . "</td>
						<td>" . $x['juris'] . "</td>
						<td>" . $x['fourcode'] . "</td>
					</tr>";
    }

    $html .= "</tbody></table>";

    return $html;
}

?>
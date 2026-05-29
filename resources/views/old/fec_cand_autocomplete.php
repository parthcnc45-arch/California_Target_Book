<?php

Util::require_ctb_api();


if (isset($_REQUEST['q'])) {
    $q = $_REQUEST['q'];
    if (strlen($q) > 1) {
        $arr = populate($q);
        foreach ($arr as $x) {
            $cand_nm = $x['cand_nm'];
            $fourcode = $x['fourcode'];
            if ($response === '') {
                $hint = $cand_nm . " ($fourcode)";
            } else {
                $hint .= "<br>$cand_nm ($fourcode)";
            }
        }
    }
}


echo $hint === '' ? 'No Match' : $hint;

function populate($q)
{
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $arr = explode(" ", $q);
    if ($arr[1]) {
        $i = 0;
        $query = '';
        foreach ($arr as $x) {
            $x = mysqli_escape_string($conn, $x);
            if ($i == 0) {
                $query = "cand_nm LIKE '%$x%'";
            } else {
                $query .= " && cand_nm LIKE '%$x%'";
            }
            $i++;
        }
    } else {
        $query = "cand_nm LIKE '%$q%'";
    }


    $sql = "SELECT cand_nm, fourcode FROM nufec_e18_fed_candidates WHERE $query";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($retval, $row);
        }
    }

    return $retval;
}

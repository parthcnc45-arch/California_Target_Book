<?php

Util::set_errors();
Util::require_ctb_api();


$county = $_GET['id'];
$options = '';
//echo("<Br>GOT $state<br>");

if (!$county) {
    $county = "Alameda";
}

if (!isset($county)) {
    $response = array('success' => FALSE);
} else {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT CITY FROM ctb2016_city_vote_hist WHERE COUNTY = '" . $county . "' GROUP BY CITY";
    //echo($sql);
    $result = $conn->query($sql);
    $options = "<option value='All'>$county - All Cities</option>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subdivision = $row['CITY'];
            $options .= "<option value='$subdivision'>$county - $subdivision</option>";
        }
    }
    $response = array(
        'success' => TRUE,
        'options' => $options
    );
}

header('Content-Type: application/json');
echo json_encode($response);



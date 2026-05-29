<?php

Util::set_errors();
Util::require_ctb_api();


//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$county = $_GET['id'];
$options = '';
//echo("<Br>GOT $state<br>");

if (!isset($county)) {
    $response = array('success' => FALSE);
} else {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT SUBDIVISION FROM ctb2016_elec_by_city WHERE COUNTY LIKE '" . $county . "%' && (SUBDIVISION != '' && SUBDIVISION NOT LIKE '%Percent' && SUBDIVISION != 'Cities')";
    //echo($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subdivision = $row['SUBDIVISION'];
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


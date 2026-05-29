<?php


Util::set_errors();
Util::require_ctb_api();

$state = $_GET['id'];
$options = '';
//echo("<Br>GOT $state<br>");

if (!isset($state)) {
    $response = array('success' => FALSE);
} else {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_e18_fed WHERE DIST LIKE '" . $state . "%'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $dist = mb_substr($row['DIST'], 2, 2);
            $naml = $row['NAML'];
            $namf = $row['NAMF'];
            $party = $row['PARTY'];
            $options .= "<option value='$dist'>$dist - $naml, $namf ($party)</option>";
        }
    }
    $response = array(
        'success' => TRUE,
        'options' => $options
    );
}

header('Content-Type: application/json');
echo json_encode($response);



<?php

Util::require_ctb_api();
include "php/rosterqs.php";


$conn = Util::get_ctb_conn();
$cands = Array();
$endjava = Array();

$thisid = "nu_cands";
$table_body='';

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

array_push($endjava, $js);

$sql = "SELECT * FROM ctb_p18_filing_status ORDER BY office, district, naml";
$result = $conn->query($sql);
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		array_push($cands, $row);
	}
}

$table_head = "<div>
				<table class='table table-striped table-responsive tablesorter bordered' v-ctb-table id='$thisid' style='font-size: 0.7em; width: 100% !important; '>
					<thead>
						<tr>";

$i = 0;
foreach($cands[0] as $key => $value) {
	if($i > 9 && $i < 18) {
		$class = 'collapse_me';
	} else {
		$class = '';
	}
	if($key != "id") {
		$table_head .= "
						<th class='$class'>$key</th>";
	}
	$i++;
}

$table_head .= "</tr>
			</thead>
			<tbody>";





foreach($cands as $row) {

	$table_body .= "
					<tr class='rowsearch'>";
	$i = 0;
	foreach($row as $key => $value)	{
		if($i > 9 && $i < 18) {
			$class = 'hidden-sm hidden-xs';
		} else {
			$class = '';
		}
		if($key != "id") {
			$table_body .= "<td class='$class'>" . $value . "</td>";
		}
		$i++;
	}
	$table_body .= "
					</tr>";



}

echo($table_head . $table_body . "</tbody></table></div>");



?>



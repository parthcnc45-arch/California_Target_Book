

@extends('layouts.master')

@section('title', 'FPPC Committees | California Target Book')

@section('content')


<?php

$endjava = Array();

$conn = Util::get_ctb_conn();

include "php/functions.php";
include "php/filingfunctions.php";
include "php/rosterqs.php";

ini_set('memory_limit', '512M');

$sql = "SELECT FILER_ID, NAML, NAMF, ADR1, CITY, ST, ZIP4, PHON, FAX, EMAIL FROM calaccess_raw_FILERNAME_CD WHERE FILER_TYPE like '%COMMITTEE%' GROUP BY FILER_ID ORDER BY NAML, NAMF ";
//echo($sql);

echo("<div class='newseg'>");

$result = $conn->query($sql);

$i = 1;

$thisid = "cmte";

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

array_push($endjava, $js);

$tablehead = "
<table id='$thisid' class='tablesorter bordered'>
	<thead>
		<tr>
			<th>COMMITTEE NAME</th>
			<th>COMMITTEE NUMBER</th>
		</tr>
	</thead>
	<tbody>

";

echo($tablehead);
$drawentry = '';
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        //echo "<section class='listrow'>";
        if ($i <> 0) {

            $cmte_lnk = "<a href='http://cal-access.ss.ca.gov/Misc/redirector.aspx?id=" . $row['FILER_ID'] . "' target='_blank'>" . $row['FILER_ID'] . "</a>";
            if ($row['NAMF']) {
                $fullname = $row['NAML'] . ", " . $row['NAMF'];
            } else {
                $fullname = $row['NAML'];
            }
            $thistitle = $fullname . "\n" . $row['ADR1'] . " \n" . $row['CITY'] . ", " . $row['ST'] . " " . $row['ZIP4'] . " \n" . "PH: " . $row['PHON'] . "\n" . "FX: " . " " . $row['FAX'] . "\n" . "EMAIL: " . $row['EMAIL'];
            $name_lnk = "<a href='http://198.74.49.22/cmlocal2.php?id=" . $row['FILER_ID'] . "'' target='_blank'>" . $fullname . "</a>";
            $drawentry .= "
				<tr class='rowsearch'>
					<td title='$thistitle'>" . $name_lnk . "</td>
					<td>" . $cmte_lnk . "</td>
				</tr>
				";
        }
        $i++;
    }
} else {
    $retval = "0 results";
}

echo($drawentry);
echo("</tbody></table>");
echo("</div>");

?>


@endsection

@section('scripts')

    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection

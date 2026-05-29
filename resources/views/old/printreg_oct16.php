<!DOCTYPE html>
<html lang="en">

<head>
<?php include "php/head.php" ?>


</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<?php

 include "php/ctb_api.php";

 $endjava = Array();

echo("<h1>Assembly Districts</h1>");

$i = 1;

$tablehead = "<div class='newseg'>	
				<table class='tablesorter' id='adtable'>
				<colgroup>
					<col class='whitebg' span='3' />
					<col class='bluebg' span='3' />
					<col class='redbg' span='3' />
					<col class='yellowbg' span='3' />
				</colgroup>				
					<thead>
						<tr>
							<th>DIST</th>
							<th>INCUMBENT</th>
							<th class=\"{sorter: 'text'}\">ADV</th>
							<th>DEM % JAN</th>
							<th>DEM % OCT</th>
							<th>&Delta; %</th>
							<th>REP % JAN</th>
							<th>REP % OCT</th>
							<th>&Delta; %</th>
							<th>NPP % JAN</th>
							<th>NPP % OCT</th>
							<th>&Delta; %</th>
						</tr>
					</thead>
					<tbody>							

";

$tableend = "</tbody></table></div>";
$deminrep = 0;
$repindem = 0;
$deminrepdistricts = '';
$repindemdistricts = '';
while($i < 81) {

	$fourcode = "AD" . checkaddzero($i);
 	$reg = getreg($fourcode);
 	$x = getofficeholder($fourcode);
 	$incumbent = $x['INCUMBENT'];
 	$party = $x['PARTY'];

 	$total = $reg['TOT'];
 	$dem = makepct($reg['DEM'], $total);
 	$rep = makepct($reg['REP'], $total);
 	$npp = makepct($reg['NPP'], $total);
 	$printtotal = number_format($total);

 	$thisdem = ($reg['DEM'] / $total) * 100;
 	$thisrep = ($reg['REP'] / $total) * 100;



 	if($reg['DEM'] > $reg['REP']) {
 		if($thisdem - $thisrep < 10) {
 			$addzero = " ";
 		} else {
 			$addzero = "";
 		}
 		$advantage = "D+ $addzero " . number_format(($thisdem - $thisrep), 2) . "%";
 		$adparty = "D";
 		$adclass = "blueme boldme";
 	} else {
 		if($thisrep - $thisdem < 10) {
 			$addzero = " ";
 		} else {
 			$addzero = "";
 		}
 		$advantage = "R+ $addzero " . number_format(($thisrep - $thisdem), 2) . "%";
 		$adparty = "R";
 		$adclass = "redme boldme";
 	}

 	if($reg['NPP'] > $reg['REP']) {
 		$npppop++;
 		$nppdist .= " $fourcode";
 	}

 	if($party == "R") {
 		$incumbent = "<span class = 'redme'>$incumbent</span>";
 	}

 	if($party == "D") {
 		$incumbent = "<span class='blueme'>$incumbent</span>";
 	}

 	if($party == "D" && $adparty == "D") {
 		$demsame++;
 	}

 	if($party == "R" && $adparty == "R" ) {
 		$repsame++;
 	}

 	if($party == "R" && $adparty == "D") {
 		$repindem++;
 		$repsindemdistricts .= " $fourcode";
 	}

 	if($party == "D" && $adparty == "R") {
 		$deminrep++;
 		$demsinrepdistricts .= " $fourcode";
 	}

 	$oldreg = getjanreg($fourcode);
 	$oldtotal = $oldreg['TOT'];
 	$olddem = makepct($oldreg['DEM'], $oldtotal);
 	$oldrep = makepct($oldreg['REP'], $oldtotal);
 	$oldnpp = makepct($oldreg['NPP'], $oldtotal);
 	$oldprinttotal = number_format($oldtotal); 	

 	$demchange = number_format((($reg['DEM'] / $total) - ($oldreg['DEM'] / $oldtotal)) * 100, 2);
 	$repchange = number_format((($reg['REP'] / $total) - ($oldreg['REP'] / $oldtotal)) * 100, 2);
 	$nppchange = number_format((($reg['NPP'] / $total) - ($oldreg['NPP'] / $oldtotal)) * 100, 2);

 	$fourcode = getctblink($fourcode) . $fourcode . "</a>";

 	$tablebody .= "
					<tr>
						<td>" . $fourcode . "</td>
						<td>" . $incumbent . "</td>
						<td class='$adclass'>" . $advantage . "</td>
						<td>" . $olddem . "%</td>
						<td>" . $dem  	. "%</td>
						<td>" . $demchange . "%</td>

						<td>" . $oldrep . "%</td>
						<td>" . $rep  	. "%</td>
						<td>" . $repchange . "%</td>

						<td>" . $oldnpp . "%</td>
						<td>" . $npp  	. "%</td>
						<td>" . $nppchange . "%</td>	
					</tr>					
 	";
 	if($rep > $dem) {
 		$gopadv++;
 	}

 	if($dem > $rep) {
 		$demadv++;
 	} 	

 	if($oldrep > $olddem) {
 		$oldgopadv++;
 	}

 	if($olddem > $oldrep) {
 		$olddemadv++;
 	}
 	$i++;

 }

echo($tablehead . $tablebody . $tableend);

echo("<div class='newseg' style='margin-top: 20px;'>");
echo("<br>JAN '16:<br>Dem Advantage: $olddemadv<br>Rep Advantage: $oldgopadv<br>");
echo("<br>OCT '16:<br>Dem Advantage: $demadv<br>Rep Advantage: $gopadv<br>");
echo("<br>$deminrep Democratic legislators in districts with Republican registration advantage ($demsinrepdistricts)");
echo("<br>$repindem Republican legislators in districts with Democratic registration advantage ($repsindemdistricts)");
echo("<br>$npppop Districts Where No Party Preference Voters outnumber Republicans ( $nppdist )");
echo("</div>");

$gopadv = 0;
$demadv = 0;
$olddemadv = 0;
$oldgopadv = 0;

$tablebody = '';

echo("<h1>Senate Districts</h1>");


$i = 1;

$tablehead = "<div class='newseg'>	
				<table class='tablesorter' id='sdtable'>
				<colgroup>
					<col class='whitebg' span='3' />
					<col class='bluebg' span='3' />
					<col class='redbg' span='3' />
					<col class='yellowbg' span='3' />
				</colgroup>				
					<thead>
						<tr>
							<th>DIST</th>
							<th>INCUMBENT</th>
							<th class=\"{sorter: 'text'}\">ADV</th>
							<th>DEM % JAN</th>
							<th>DEM % OCT</th>
							<th>&Delta; %</th>
							<th>REP % JAN</th>
							<th>REP % OCT</th>
							<th>&Delta; %</th>
							<th>NPP % JAN</th>
							<th>NPP % OCT</th>
							<th>&Delta; %</th>
						</tr>
					</thead>
					<tbody>							

";

$tableend = "</tbody></table></div>";
$npppop = 0;
$nppdist = '';
$deminrep = 0;
$repindem = 0;
$demsinrepdistricts = '';
$repsindemdistricts = '';
while($i < 41) {

	$fourcode = "SD" . checkaddzero($i);
 	$reg = getreg($fourcode);
 	$x = getofficeholder($fourcode);
 	$incumbent = $x['INCUMBENT'];
 	$party = $x['PARTY'];

 	$total = $reg['TOT'];
 	$dem = makepct($reg['DEM'], $total);
 	$rep = makepct($reg['REP'], $total);
 	$npp = makepct($reg['NPP'], $total);
 	$printtotal = number_format($total);

 	$thisdem = ($reg['DEM'] / $total) * 100;
 	$thisrep = ($reg['REP'] / $total) * 100;

 	if($reg['DEM'] > $reg['REP']) {
 		if($thisdem - $thisrep < 10) {
 			$addzero = " ";
 		} else {
 			$addzero = "";
 		}
 		$advantage = "D+ $addzero " . number_format(($thisdem - $thisrep), 2) . "%";
 		$adparty = "D";
 		$adclass = "blueme boldme";
 	} else {
 		if($thisrep - $thisdem < 10) {
 			$addzero = " ";
 		} else {
 			$addzero = "";
 		}
 		$advantage = "R+ $addzero " . number_format(($thisrep - $thisdem), 2) . "%";
 		$adparty = "R";
 		$adclass = "redme boldme";
 	}

 	if($reg['NPP'] > $reg['REP']) {
 		$npppop++;
 		$nppdist .= " $fourcode";
 	} 	

 	if($party == "R") {
 		$incumbent = "<span class = 'redme'>$incumbent</span>";
 	}

 	if($party == "D") {
 		$incumbent = "<span class='blueme'>$incumbent</span>";
 	}

 	if($party == "D" && $adparty == "D") {
 		$demsame++;
 	}

 	if($party == "R" && $adparty == "R" ) {
 		$repsame++;
 	}

 	if($party == "R" && $adparty == "D") {
 		$repindem++;
 		$repsindemdistricts .= " $fourcode";
 	}

 	if($party == "D" && $adparty == "R") {
 		$deminrep++;
 		$demsinrepdistricts .= " $fourcode";
 	}

 	$oldreg = getjanreg($fourcode);
 	$oldtotal = $oldreg['TOT'];
 	$olddem = makepct($oldreg['DEM'], $oldtotal);
 	$oldrep = makepct($oldreg['REP'], $oldtotal);
 	$oldnpp = makepct($oldreg['NPP'], $oldtotal);
 	$oldprinttotal = number_format($oldtotal); 	

 	$demchange = number_format((($reg['DEM'] / $total) - ($oldreg['DEM'] / $oldtotal)) * 100, 2);
 	$repchange = number_format((($reg['REP'] / $total) - ($oldreg['REP'] / $oldtotal)) * 100, 2);
 	$nppchange = number_format((($reg['NPP'] / $total) - ($oldreg['NPP'] / $oldtotal)) * 100, 2);

 	$fourcode = getctblink($fourcode) . $fourcode . "</a>";

 	$tablebody .= "
					<tr>
						<td>" . $fourcode . "</td>
						<td>" . $incumbent . "</td>
						<td class='$adclass'>" . $advantage . "</td>
						<td>" . $olddem . "%</td>
						<td>" . $dem  	. "%</td>
						<td>" . $demchange . "%</td>

						<td>" . $oldrep . "%</td>
						<td>" . $rep  	. "%</td>
						<td>" . $repchange . "%</td>

						<td>" . $oldnpp . "%</td>
						<td>" . $npp  	. "%</td>
						<td>" . $nppchange . "%</td>	
					</tr>					
 	";
 	if($rep > $dem) {
 		$gopadv++;
 	}

 	if($dem > $rep) {
 		$demadv++;
 	} 	

 	if($oldrep > $olddem) {
 		$oldgopadv++;
 	}

 	if($olddem > $oldrep) {
 		$olddemadv++;
 	}
 	$i++;

 }

echo($tablehead . $tablebody . $tableend);

echo("<div class='newseg' style='margin-top: 20px;'>");
echo("<br>JAN '16:<br>Dem Advantage: $olddemadv<br>Rep Advantage: $oldgopadv<br>");
echo("<br>OCT '16:<br>Dem Advantage: $demadv<br>Rep Advantage: $gopadv<br>");
echo("<br>$deminrep Democratic legislators in districts with Republican registration advantage ($demsinrepdistricts)");
echo("<br>$repindem Republican legislators in districts with Democratic registration advantage ($repsindemdistricts)");
echo("<br>$npppop Districts Where No Party Preference Voters outnumber Republicans ( $nppdist )");
echo("</div>");

$gopadv = 0;
$demadv = 0;
$olddemadv = 0;
$oldgopadv = 0;

echo("<h1>Congressional Districts</h1>");

$i = 1;

$tablehead = "<div class='newseg'>	
				<table class='tablesorter' id='cdtable'>

				<colgroup>
					<col class='whitebg' span='3' />
					<col class='bluebg' span='3' />
					<col class='redbg' span='3' />
					<col class='yellowbg' span='3' />
				</colgroup>

					<thead>
						<tr>
							<th>DIST</th>
							<th>INCUMBENT</th>
							<th class=\"{sorter: 'text'}\">ADV</th>
							<th>DEM % JAN</th>
							<th>DEM % OCT</th>
							<th>&Delta; %</th>
							<th>REP % JAN</th>
							<th>REP % OCT</th>
							<th>&Delta; %</th>
							<th>NPP % JAN</th>
							<th>NPP % OCT</th>
							<th>&Delta; %</th>
						</tr>
					</thead>
					<tbody>							

";


$tableend = "</tbody></table></div>";
$npppop = 0;
$nppdist = '';
$deminrep = 0;
$repindem = 0;
$demsinrepdistricts = '';
$repsindemdistricts = '';
$tablebody = '';
while($i < 54) {

	$fourcode = "CD" . checkaddzero($i);
 	$reg = getreg($fourcode);
 	$x = getofficeholder($fourcode);
 	$incumbent = $x['INCUMBENT'];
 	$party = $x['PARTY'];

 	$total = $reg['TOT'];
 	$dem = makepct($reg['DEM'], $total);
 	$rep = makepct($reg['REP'], $total);
 	$npp = makepct($reg['NPP'], $total);
 	$printtotal = number_format($total);

 	$thisdem = ($reg['DEM'] / $total) * 100;
 	$thisrep = ($reg['REP'] / $total) * 100;

 	if($reg['DEM'] > $reg['REP']) {
 		if($thisdem - $thisrep < 10) {
 			$addzero = " ";
 		} else {
 			$addzero = "";
 		}
 		$advantage = "D+ $addzero " . number_format(($thisdem - $thisrep), 2) . "%";
 		$adparty = "D";
 		$adclass = "blueme boldme";
 	} else {
 		if($thisrep - $thisdem < 10) {
 			$addzero = " ";
 		} else {
 			$addzero = "";
 		}
 		$advantage = "R+ $addzero " . number_format(($thisrep - $thisdem), 2) . "%";
 		$adparty = "R";
 		$adclass = "redme boldme";
 	}

 	if($reg['NPP'] > $reg['REP']) {
 		$npppop++;
 		$nppdist .= " $fourcode";
 	} 	

 	if($party == "R") {
 		$incumbent = "<span class='redme'>$incumbent</span>";
 	}

 	if($party == "D") {
 		$incumbent = "<span class='blueme'>$incumbent</span>";
 	}

 	if($party == "D" && $adparty == "D") {
 		$demsame++;
 	}

 	if($party == "R" && $adparty == "R" ) {
 		$repsame++;
 	}

 	if($party == "R" && $adparty == "D") {
 		$repindem++;
 		$repsindemdistricts .= " $fourcode";
 	}

 	if($party == "D" && $adparty == "R") {
 		$deminrep++;
 		$demsinrepdistricts .= " $fourcode";
 	}

 	$oldreg = getjanreg($fourcode);
 	$oldtotal = $oldreg['TOT'];
 	$olddem = makepct($oldreg['DEM'], $oldtotal);
 	$oldrep = makepct($oldreg['REP'], $oldtotal);
 	$oldnpp = makepct($oldreg['NPP'], $oldtotal);
 	$oldprinttotal = number_format($oldtotal); 	

 	$demchange = number_format((($reg['DEM'] / $total) - ($oldreg['DEM'] / $oldtotal)) * 100, 2);
 	$repchange = number_format((($reg['REP'] / $total) - ($oldreg['REP'] / $oldtotal)) * 100, 2);
 	$nppchange = number_format((($reg['NPP'] / $total) - ($oldreg['NPP'] / $oldtotal)) * 100, 2);

 	$fourcode = getctblink($fourcode) . $fourcode . "</a>";

 	$tablebody .= "
					<tr>
						<td>" . $fourcode . "</td>
						<td>" . $incumbent . "</td>
						<td class='$adclass'>" . $advantage . "</td>
						<td>" . $olddem . "%</td>
						<td>" . $dem  	. "%</td>
						<td>" . $demchange . "%</td>

						<td>" . $oldrep . "%</td>
						<td>" . $rep  	. "%</td>
						<td>" . $repchange . "%</td>

						<td>" . $oldnpp . "%</td>
						<td>" . $npp  	. "%</td>
						<td>" . $nppchange . "%</td>	
					</tr>					
 	";
 	if($rep > $dem) {
 		$gopadv++;
 	}

 	if($dem > $rep) {
 		$demadv++;
 	} 	

 	if($oldrep > $olddem) {
 		$oldgopadv++;
 	}

 	if($olddem > $oldrep) {
 		$olddemadv++;
 	}
 	$i++;

 }

echo($tablehead . $tablebody . $tableend);
echo("<div class='newseg' style='margin-top: 20px;'>");
echo("<br>JAN '16:<br>Dem Advantage: $olddemadv<br>Rep Advantage: $oldgopadv<br>");
echo("<br>OCT '16:<br>Dem Advantage: $demadv<br>Rep Advantage: $gopadv<br>");
echo("<br>$deminrep Democratic legislators in districts with Republican registration advantage ($demsinrepdistricts)");
echo("<br>$repindem Republican legislators in districts with Democratic registration advantage ($repsindemdistricts)");
echo("<br>$npppop Districts Where No Party Preference Voters outnumber Republicans ( $nppdist )");
echo("</div>");

$gopadv = 0;
$demadv = 0;
$olddemadv = 0;
$oldgopadv = 0;

/*
echo("<h1>Counties</h1>");



$tablehead = "<div class='newseg'>	
				<table class='bordered tablesorter' id='cdtable'>
					<thead>
						<tr>
							<th>DIST</th>
							<th>DEM % JAN</th>
							<th>DEM % SEP</th>
							<th>&Delta; %</th>
							<th>REP % JAN</th>
							<th>REP % SEP</th>
							<th>&Delta; %</th>
							<th>NPP % JAN</th>
							<th>NPP % SEP</th>
							<th>&Delta; %</th>
						</tr>
					</thead>
					<tbody>							

";

$i = 1;
while($i < 59) {

	$fourcode = "CO" . checkaddzero($i);
 	$reg = getreg($fourcode);
 	$countyname = getcountyname($i);
 	$total = $reg['TOT'];
 	$dem = makepct($reg['DEM'], $total);
 	$rep = makepct($reg['REP'], $total);
 	$npp = makepct($reg['NPP'], $total);
 	$printtotal = number_format($total);

 	$oldreg = getjanreg($fourcode);
 	$oldtotal = $oldreg['TOT'];
 	$olddem = makepct($oldreg['DEM'], $oldtotal);
 	$oldrep = makepct($oldreg['REP'], $oldtotal);
 	$oldnpp = makepct($oldreg['NPP'], $oldtotal);
 	$oldprinttotal = number_format($oldtotal); 	

 	$demchange = number_format((($reg['DEM'] / $total) - ($oldreg['DEM'] / $oldtotal)) * 100, 2);
 	$repchange = number_format((($reg['REP'] / $total) - ($oldreg['REP'] / $oldtotal)) * 100, 2);
 	$nppchange = number_format((($reg['NPP'] / $total) - ($oldreg['NPP'] / $oldtotal)) * 100, 2);

 	$tablebody .= "
					<tr>
						<td>" . $countyname . "</td>
						<td>" . $olddem . "%</td>
						<td>" . $dem  	. "%</td>
						<td>" . $demchange . "%</td>

						<td>" . $oldrep . "%</td>
						<td>" . $rep  	. "%</td>
						<td>" . $repchange . "%</td>

						<td>" . $oldnpp . "%</td>
						<td>" . $npp  	. "%</td>
						<td>" . $nppchange . "%</td>	
					</tr>					
 	";
 	if($rep > $dem) {
 		$gopadv++;
 	}

 	if($dem > $rep) {
 		$demadv++;
 	} 	

 	if($oldrep > $olddem) {
 		$oldgopadv++;
 	}

 	if($olddem > $oldrep) {
 		$olddemadv++;
 	}
 	$i++;

 }

echo($tablehead . $tablebody . $tableend);

echo("<br>JAN Dem Advantage: $olddemadv<br>Rep Advantage: $oldgopadv<br>");
echo("<br>SEP Dem Advantage: $demadv<br>Rep Advantage: $gopadv<br>");
$gopadv = 0;
$demadv = 0;
$olddemadv = 0;
$oldgopadv = 0;

$tablebody = '';

$thisid = "adtable";
*/

$thisid = "adtable";

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 

        headers: {
            2: {
                sorter: \"text\"
            }
        }
    });
});";

array_push($endjava, $js);

$thisid = "sdtable";

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 

        headers: {
            2: {
                sorter: \"text\"
            }
        }
    });
});";

array_push($endjava, $js);

$thisid = "cdtable";

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 

        headers: {
            2: {
                sorter: \"text\"
            }
        }
    });
});";

array_push($endjava, $js);


function populatefourcodes() {
	$retval = Array();

	$i = 1;
	while($i < 81) {
		$fourcode = "AD" . checkaddzero($i);
		array_push($retval, $fourcode);
		$i++;
	}

	$i = 1;
	while($i < 41) {
		$fourcode = "SD" . checkaddzero($i);
		array_push($retval, $fourcode);
		$i++;
	}
	$i = 1;
	while($i < 54) {
		$fourcode = "CD" . checkaddzero($i);
		array_push($retval, $fourcode);
		$i++;
	}

	return $retval;	
}

function getreg($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;

	$sql = "SELECT * FROM  sos_oct16 WHERE DIST = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0 ){
		while($row = $result->fetch_assoc()) {
			$tmp['TOT'] = $row['TOT'];
			$tmp['REP'] = $row['REP'];
			$tmp['DEM'] = $row['DEM'];
			$tmp['NPP'] = $row['NPP'];
		}
	}
	return $tmp;
}

function getjanreg($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;

	$sql = "SELECT * FROM  sos_feb16 WHERE DIST = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0 ){
		while($row = $result->fetch_assoc()) {
			$tmp['TOT'] = $row['TOT'];
			$tmp['REP'] = $row['REP'];
			$tmp['DEM'] = $row['DEM'];
			$tmp['NPP'] = $row['NPP'];
		}
	}
	return $tmp;
}

function getofficeholder($fourcode){
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT INCUMBENT, PARTY FROM pd_apr16_reg WHERE DISTRICT = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['INCUMBENT'] = $row['INCUMBENT'];
			$retval['PARTY'] = mb_substr($row['PARTY'], 1,1);
		}
	}
	
	return $retval;
}

?>



</body>

<?php include "php/scripts.php" ?>

<script type='text/javascript'>


<?php
	
	foreach($endjava as $value) {
		echo($value);
	}

?>

</script>

</html>
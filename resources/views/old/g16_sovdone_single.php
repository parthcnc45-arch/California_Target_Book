<!DOCTYPE html>
<html lang="en">

<head>
<?php include "php/head.php" ?>

<link href="/css/ctb.css" rel="stylesheet">

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<?php



//error_reporting(E_ALL);
//ini_set('display_errors', '1');

Util::require_ctb_api();

//$fourcode = $_GET['id'];


setlocale(LC_COLLATE, "en_US");
setlocale(LC_CTYPE, "en_US");

$conn = Util::get_ctb_conn();

//echo("<div class='newseg'><h1>Counties</h1>");

$i = 1;
while($i < 59) {
		$name = getcountyname($i);
		$cc = checkdone($i);
		if($cc == "CCC") {
			$class = '';
			//$drawthis .= "$name ";
		} else {
			$status ++;
			//$drawthis .= "<span class='redme'>$name </span>";
		}
		$i++;
}
//echo($drawthis);
//echo("</div>");


$status = 0;
$x = getcounties($fourcode);
foreach($x as $county) {
	$name = getcountyname($county);
	$cc = checkdone($county);
	if($cc == "CCC") {
		$class = '';
		//$drawthis .= "$name ";
	} else {
		$status ++;
		$drawthis .= "<span class='redme'>$name </span>";
	}
}

if($status > 0) {
	$thisstat = "<p align='center'><span class='redme boldme'>2016 GENERAL ELECTION RESULTS INCOMPLETE</span><br>Counties Missing: $drawthis</p>";
} else {
	$thisstat = "";
}

echo($thisstat);

getallreturns($fourcode, "vdetail");

function checkdone2($county) {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT STATUS FROM g16returns_counties WHERE NUM = '$county'";
	//echo($sql);
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row['STATUS'];
			//echo("<br>$retval");
		}
	}	
	return $retval;	
}

function checkdone($county) {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT SOVSTATUS FROM g16returns_counties WHERE NUM = '$county'";
	//echo($sql);
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row['SOVSTATUS'];
			//echo("<br>$retval");
		}
	}	
	return $retval;	
}

function getcounties($fourcode) {
	$conn = Util::get_ctb_conn();
	$retval = Array();

	$tophalf = mb_substr($fourcode, 0, 2);
	$bothalf = mb_substr($fourcode, 2, 2);

	if(mb_substr($bothalf, 0, 1) == "0") {
		$dist = mb_substr($bothalf, 1,1);
	} else {
		$dist = $bothalf;
	}

	switch($tophalf) {
		case "AD":
			$disttype = "addist";
			break;
		case "SD":
			$disttype = "sddist";
			break;
		case "CD":
			$disttype = "cddist";
			break;
	}

	$sql = "SELECT county, SUM(TOTVOTE) AS vote from ctb2016_g12 WHERE $disttype = '$dist' GROUP BY county";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row['vote'] > 0) {
				$tmp = $row['county'];
				array_push($retval, $tmp);
			}
		}
	}	
	return $retval;
}

//getcountyname($dist);


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

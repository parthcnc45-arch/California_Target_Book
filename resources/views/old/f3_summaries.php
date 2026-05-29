<!DOCTYPE html>
<html lang="en">

<head>

<?php 

include "php/head.php"; 

?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top" style='background-color: white;'>

<style type="text/css">

   .box1800 {
      background-image: url(box1800.jpg);
      background-position: center;
	}

   .box1200 {
      background-image: url(box1200.jpg);
      background-position: center;
	}

  	.box800 {
      background-image: url(box800.jpg);
      background-position: center;
	}
</style>

<?php 

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$endjava = Array();

include "php/ctb_api.php";
include "php/rosterqs.php";

$thisid = "cds";

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 
            headers: { 
                5: { 
                    sorter:'fancyNumber' 
                },            	
                6: { 
                    sorter:'fancyNumber' 
                }, 
                7: { 
                    sorter:'fancyNumber' 
				},
                8: { 
                    sorter:'fancyNumber' 
                },
                9: { 
                    sorter:'fancyNumber' 
                }                                                                                   
            } 
        });
});

jQuery.tablesorter.addParser({
  id: \"fancyNumber\",
  is: function(s) {
    return /^[0-9]?[0-9,\.]*$/.test(s);
  },
  format: function(s) {
    return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') );
  },
  type: \"numeric\"
});

";


array_push($endjava, $js);

$filings = populatefilings();

$tablehead = "<div class='newseg'>
				<table id='$thisid' class='bordered tablesorter'>
					<thead>
						<tr>
							<th>FILING</th>
							<th>CMTE_ID</th>
							<th>CMTE NAME</th>
							<th>PERIOD START</th>
							<th>PERIOD END</th>
							<th>COH START</th>
							<th>RECEIPTS</th>
							<th>EXPENDITURES</th>
							<th>COH END</th>
							<th>DEBT</th>
						</tr>
					</thead>
					<tbody>
";

foreach($filings as $x) {

	$cmte_id = $x['cmte_id'];
	$cmte_nm = getfeccommitteename($cmte_id) ;
	$filing = $x['filing'];
	$filing_lnk = "<a href='http://198.74.49.22/fedparser2.php?id=$filing' target='_blank'>$filing</a>";
	$cmte_lnk = "<a href='http://198.74.49.22/getfedfilings.php?id=$cmte_id' target='_blank'>$cmte_id</a>";
	$pd_start = $x['pd_start'];
	$pd_end = $x['pd_end'];
	$coh_start = $x['coh_start'];
	$coh_end = $x['coh_end'];
	$rcpt = $x['rcpt'];
	$exp = $x['exp'];
	$debt = $x['debt'];

	$tablebody .= "
				<tr class='rowsearch'>
					<td>" . $filing_lnk 	. "</td>
					<td>" . $cmte_lnk 		. "</td>
					<td>" . $cmte_nm		. "</td>
					<td>" . $pd_start	 	. "</td>
					<td>" . $pd_end			. "</td>
					<td align='right'>" . number_format($coh_start)		. "</td>
					<td align='right'>" . number_format($rcpt)			. "</td>
					<td align='right'>" . number_format($exp) 	 		. "</td>
					<td align='right'>" . number_format($coh_end) 		. "</td>
					<td align='right'>" . number_format($debt) 			. "</td>
				</tr>
	";
}

echo($tablehead . $tablebody . "</tbody></table></div>");




function istargeted($fourcode) {
	global $fec_conn;
	$conn = $fec_conn;
	$sql = "SELECT * FROM e18_targets WHERE fourcode = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row['targeted_by'];
		}
	}
	return $retval;
}

function getelectionresults($fourcode) {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$sql = "SELECT * FROM e18_fed WHERE DIST = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row;
		}
	}
	return $retval;
}

function populatefedcandidates() {
	global $fec_conn;
	$conn = $fec_conn;
	$retval = Array();
	$sql = "SELECT * FROM e18_fed_candidates ORDER BY fourcode";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp = $row;
			array_push($retval, $row);
		}
	}
	return $retval;
}

function getprimarycommittee($cand_id) {
	global $fec18_conn;
	$conn = $fec18_conn;


	$sql = "SELECT * FROM cn WHERE CAND_ID = '$cand_id' LIMIT 1";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['cmte_id'] = $row['CAND_PCC'];
			$retval['is_incumbent'] = $row['CAND_ICI'];
		}
	}

	return $retval;
}

function getfinancials($cmte_id) {
	global $fec_conn;
	$conn = $fec_conn;
	$sql = "SELECT * FROM weball WHERE CAND_ID = '$cmte_id'";
	//echo("<br>FINANCIALS SQL<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row;
		}
	}

	return $retval;
}

function populatefilings() {
	global $fec_conn;
	$conn = $fec_conn;
	$retval = Array();
	$sql = "SELECT * FROM f3_summary ORDER BY filing DESC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$tmp = $row;
			array_push($retval, $tmp);
		}
	}
	return $retval;
}

function getallresults() {
	global $ctb2016_conn;
	$conn = $ctb2016_conn;
	$retval = Array();
	$sql = "SELECT * FROM e18_fed ORDER BY DIST";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			array_push($retval, $row);
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
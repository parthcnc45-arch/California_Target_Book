<!DOCTYPE html>
<html lang="en">
<meta http-equiv="refresh" content="120" > 

<head>
<?php include "php/head.php" ?>


    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>

</head>



<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<?php



include "php/ctb_api.php";
include "php/rosterqs.php";

setlocale(LC_COLLATE, "en_US");
setlocale(LC_CTYPE, "en_US");
set_time_limit(0);	
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$endjava = Array();


$servername = "198.74.49.22";
$username = "nufec";
$password = "Mrw0mbat8";
$dbname = "p16returns";

$conn = new mysqli($servername, $username, $password, $dbname);


$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header'=>"Accept-language: en\r\n" .
              "Cookie: foo=bar\r\n"
  )
);

$context = stream_context_create($opts);

$xml_raw = file_get_contents('http://efilingapps.fec.gov/rss/generate?preDefinedFilingType=ALL', false, $context);

$xml = simplexml_load_string($xml_raw);
$json = json_encode($xml);
$array = json_decode($json,TRUE);


$tablebody = Array();

$targets = get_targeted();

//var_dump($fedie);

$i = 0;
foreach ($array as $segment) {
	//echo("<br>SEGMENT $i:<br>");
	$j = 0;
	foreach($segment as $entry) {
		if($j == 3) {
			$filings = $entry;	
		}
		$j++;
	}
$i++;
}

$filings = array_reverse($filings);

foreach($filings as $filing) {
	//$filer_name = ltrim($filing['title'], "New filing by ");
	$filer_name = substr($filing['title'], 14);
	$url = $filing['link'];

	$regex = '~FormType:\s(.*?)\s~';
	preg_match($regex, $filing['description'], $results);
	$form_type = $results[1];

	$regex = '~CoverageFrom:\s(.*?)\s~mis';
	preg_match($regex, $filing['description'], $results);
	$period_start = $results[1];

	$regex = '~CoverageThrough:\s(.*?)\s~mis';
	preg_match($regex, $filing['description'], $results);
	$period_end = $results[1];

	$regex = '~CommitteeId:\s(.*?)\s~';
	preg_match($regex, $filing['description'], $results);
	$filer_id = $results[1];

	$regex = '~FilingId:\s(.*?)\s~';
	preg_match($regex, $filing['description'], $results);
	$filing_id = $results[1];	

	$regex = '~.\s(.*?)\s~';
	preg_match($regex, $filing['pubDate'], $results);
	$day = $results[1];

	$regex = '~[0-9]\s(.*?)\s~';
	preg_match($regex, $filing['pubDate'], $results);
	$month = $results[1];
	$month = dateadjust($month);

	$regex = '~[a-z]\s(.*?)\s~';
	preg_match($regex, $filing['pubDate'], $results);
	$year = $results[1];

	$regex = '~\s([0-9][0-9]:.*)\s~';
	preg_match($regex, $filing['pubDate'], $results);
	$time = $results[1];	

	$timestamp = $year . "-" . $month . "-" . $day . " ($time)";

	$thistime = strtotime($year . "-" . $month . "-" . $day . " " . $time);
	$timeago = humanTiming($thistime);


	if($period_start) {
		$coverage = "From $period_start to $period_end";
	} else {
		$coverage =  '';
	}

	if(!$filer_name && $filer_id) {
		$filer_name = getfeccommitteename($filer_id);
		if($form_type == "F2N") {
			$filer_name = "<span class='redme boldme' style='letter-spacing: 5px;'>****   NEW CANDIDATE FILING   ****</span>";
		}
	}

	$fourcode = $all_array[$filer_id]['fourcode'];
	$targeted_by = $all_array[$filer_id]['targeted_by'];
	$party = $all_array[$filer_id]['CAND_PTY_AFFILIATION'];

	if($party == "REP") {
		$color = 'redme';
	}  elseif ($party == "DEM") {
		$color = 'blueme';
	} else {
		$color = '';
	}

	$role = $all_array[$filer_id]['CAND_ICI'];

	switch($role) {
		case "I":
			$long_role = "Incumbent";
			break;
		case "C":
			$long_role = "Challenger";
			break;
		case "O":
			$long_role = "Open";
			break;
		default:
			$long_role = '';
			break;
	}

	//$fourcode = $targets[$filer_id]['fourcode'];
	//$targeted_by = $targets[$filer_id]['targeted_by'];

	$thistype = longform($form_type);
	$summary_link = "<a href='http://docquery.fec.gov/cgi-bin/forms/" . $filer_id . "/" . $filing_id . "' target='_blank'>Summary</a>";

	$filing_link = "<a href='http://docquery.fec.gov/dcdev/posted/" . $filing_id . ".fec'>DOWNLOAD</a>";
	$parser_link = "<a href='http://198.74.49.22/fedparser2.php?id=" . $filing_id . "'>$filing_id</a>";
	$committee_link = "<a href='http://classic.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=" . $filer_id . "' target='_blank'>$filer_id</a>";
	//$committee_link = "<a href='https://www.fec.gov/data/committee/" . $filer_id . "/?tab=filings' target='_blank'>" . $filer_id . "</a>";

	$all_lnk = "<a href='http://198.74.49.22/getfedfilings.php?id=$filer_id' target='_blank'>ALL</a>";

	if($targeted_by) {
		$bold_class ='boldme';
	} else {
		$bold_class = '';
	}

	if($long_role == "Challenger") {
		$itc_class = 'itcme';
	} else {
		$itc_class = '';
	}

	$rcpt = number_format($filing_array[$filing_id]['rcpt']);
	$expn = number_format($filing_array[$filing_id]['exp']);
	$coh_start = number_format($filing_array[$filing_id]['coh_start']);
	$coh_end = number_format($filing_array[$filing_id]['coh_end']);


	//echo("<br>$thistype FILING FROM $filer_name ($filer_id) - (FORM $form_type) $coverage - Filing #$filing_id <br>");
	//var_dump($filing);

	$tmp = "
		<tr title='$thistype' class='$color $bold_class $itc_class rowsearch'>
			<td>$timeago Ago</td>
			<td id='timestamp'>$timestamp</td>
			<td id='formtype'>$form_type</td>
			<td>$parser_link</td>
			<td>$summary_link</td>
			<td id='filing'>$filing_link</td>
			<td>$filer_name</td>
			<td align='right'>$coh_start</td>
			<td align='right'>$rcpt</td>
			<td align='right'>$expn</td>
			<td align='right'>$coh_end</td>
			<td>$period_start</td>
			<td>$period_end</td>
			<td>$committee_link</td>
			<td>$all_lnk</td>
			<td>$fourcode</td>
			<td>$party</td>
			<td>$targeted_by</td>
			<td>$long_role</td>
			
		</tr>
	";

	if(substr($form_type, -1) != "A") {
		if(mb_substr($form_type, 0, 2) != "F8") {
			array_push($tablebody, $tmp);
		}
	}
}

$thisid = "rss";

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 
            headers: { 
                7: { 
                    sorter:'fancyNumber' 
                },            	
                8: { 
                    sorter:'fancyNumber' 
                }, 
                9: { 
                    sorter:'fancyNumber' 
				},
                10: { 
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

$tablehead = "
	<div class='newseg' style='max-width: 100vw'>
		<table id='$thisid' class='bordered tablesorter'>
			<thead>
				<tr>
					<th width='100px'>POSTED</th>
					<th width='120px'>LOGGED</th>
					<th>FORM</th>
					<th width='65px'>VIEW FILING</th>
					<th>SUMMARY</th>
					<th>DOWNLOAD</th>
					<th>FILER NAME</th>
					<th>COH START</th>
					<th>RCPT</th>
					<th>EXPN</th>
					<th>COH END</th>
					<th width='75px'>PERIOD START</th>
					<th width='65px'>PERIOD END</th>
					<th>FILER_ID</th>
					<th>ALL</th>
					<th>DIST</th>
					<th>PARTY</th>
					<th>TGT</th>
					<th>STATUS</th>
			
				<tr>
			</thead>
			<tbody>
";

$tablebody = array_reverse($tablebody);

echo($tablehead);

foreach($tablebody as $entry) {
	echo($entry);
}
echo ("</tbody></table></div>");

function humanTiming ($time) {

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}

function longform($form_type) {

	if($form_type != "F99") {

		$regex = '~F([0-9].*?)[A-Z]~';
		preg_match($regex, $form_type, $results);
		$form_number = $results[1];

		$regex = '~[0-9].*?([A-Z].*)~';
		preg_match($regex, $form_type, $results);
		$interval = $results[1];

		if(mb_substr($interval, 0, 1) == "X") {
			$form_type = "F" . $form_number . "X";
		} elseif (mb_substr($interval, 0, 1) == "L") {
			$form_type = "F" . $form_number . "L";
		} else {
			$form_type = "F" . $form_number;
		}
	}

	switch($form_type) {
		case "F1":
			$id = "Statement of Organization";
			break;
		case "F2":
			$id = "Statement of Candidacy";
			break;
		case "F3":
			$id = "Receipt/Disbursement";
			break;
		case "F3X":
			$id = "Receipt/Disbursement from Non-Candidate Committees";
			break;
		case "F3L":
			$id = "Receipts Bundled by Lobbyists";
			break;
		case "F6":
			$id = "48-Hour Notice of Contributions/Loans Received";
			break;
		case "F8":
			$id = "Debt Settlement Plan";
			break;
		case "F13":
			$id = "Inaugural Committee Donation Report";
			break;
		case "F5":
			$id = "Independent Expenditure Made/Contribution Received";
			break;
		case "F9":
			$id = "24-Hour Notice of Disbursements for Electioneering Communications";
			break;
		case "F24":
			$id = "24-Hour Notice of Contribution Made/Received";
			break;
		case "F99":
			$id = "Miscellaneous Report";
			break;
		case "F4":
			$id = "National Convention Committee Report";
			break;
	}
	return $id;
}

function dateadjust($abbreviation) {
	switch($abbreviation) {
		case "Jan":
			$x = "01";
			break;
		case "Feb":
			$x = "02";
			break;
		case "Mar":
			$x = "03";
			break;
		case "Apr":
			$x = "04";
			break;
		case "May":
			$x = "05";
			break;
		case "Jun":
			$x = "06";
			break;
		case "Jul":
			$x = "07";
			break;
		case "Aug":
			$x = "08";
			break;
		case "Sep":
			$x  = "09";
			break;
		case "Oct":
			$x = "10";
			break;
		case "Nov":
			$x = "11";
			break;
		case "Dec":
			$x = "12";
			break;
	}
	return $x;
}

/*
if($msg) {
	$to      = 'rpyers@gmail.com';
	$subject = 'KEY RACE ALERT';
	$message = $msg;
	$headers = 'From: webmaster@10.0.1.3' . "\r\n" .
	    'Reply-To: webmaster@10.0.1.3' . "\r\n" .
	    'X-Mailer: PHP/' . phpversion();

	$mail = mail($to, $subject, $message, $headers);
	    echo($message);

}
*/


function get_targeted() {
	global $fec_conn;
	$conn = $fec_conn;
	global $all_array;
	global $filing_array;
	$districts = Array();
	$sql = "SELECT fourcode, targeted_by from e18_targets";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$targeted_by = $row['targeted_by'];
			$districts[$fourcode] = $targeted_by;
		}
	}

	$sql = "SELECT * FROM f3_summary ORDER BY id DESC LIMIT 2000";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$filing = $row['filing'];
			$filing_array[$filing] = $row;

		}
	}

	global $fec18_conn;
	$conn = $fec18_conn;

	$sql = "SELECT CAND_ID, CMTE_ID FROM ccl WHERE FEC_ELECTION_YR = '2018' && CMTE_DSGN = 'P'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_id = $row['CAND_ID'];
			$cmte_id = $row['CMTE_ID'];

			$ccl_cand[$cand_id] = $cmte_id;
			$ccl_cmte[$cmte_id] = $cand_id;
		}
	}

	$sql = "SELECT * FROM cn WHERE CAND_ELECTION_YR = 2018 && CAND_OFFICE = 'H'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_id = $row['CAND_ID'];
			$fourcode = $row['CAND_OFFICE_ST'] . $row['CAND_OFFICE_DISTRICT'];
			$pcc = $ccl_cand[$cand_id];
			$master_array[$fourcode][$cand_id] = $row;
			$master_array[$fourcode][$cand_id]['CMTE_ID'] = $pcc;

			$all_array[$pcc] = $row;
			$all_array[$pcc]['fourcode'] = $fourcode;
		}
	}

	foreach($districts as $fourcode => $value) {
		$targeted_by = $value;
		foreach($master_array[$fourcode] as $x) {
			$cmte_id = $x['CMTE_ID'];
			if($cmte_id) {
				$targeted_array[$cmte_id]['fourcode'] = $fourcode;
				$targeted_array[$cmte_id]['targeted_by'] = $targeted_by;
				$all_array[$cmte_id]['targeted_by'] = $targeted_by;
			}
		}
	}



	return $targeted_array;
}


//var_dump($all_array);

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

<script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script> 

</html>


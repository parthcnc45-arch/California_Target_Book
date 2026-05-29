<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$endjava = Array();

Util::require_ctb_api();

$thisid = "ad1";

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

array_push($endjava, $js);

global $cached;
$fourcode = $cached['fourcode'];


$fourcodes = Array($fourcode);


foreach($fourcodes as $fourcode) {

	$x = getdata($fourcode);

	$chi = '';
	$jap = '';
	$jpn = '';
	$viet = '';
	$kor = '';
	$fil = '';
	$ind = '';
	$asian_detail = '';

	if($x['SOS_ASN_PCT'] > 10) {

		if($x['SOS_CHI_PCT'] > 3) {
			$chi = "Chinese: " . $x['SOS_CHI_PCT'] . "%, ";
		}

		if($x['SOS_JPN_PCT'] > 3) {
			$jpn = "Japanese: " . $x['SOS_JPN_PCT'] . "%, ";
		}

		if($x['SOS_VIET_PCT'] > 3) {
			$viet = "Vietnamese: " . $x['SOS_VIET_PCT'] . "%, ";
		}

		if($x['SOS_KOR_PCT'] > 3) {
			$kor = "Korean: " . $x['SOS_KOR_PCT'] . "%, ";
		}

		if($x['SOS_FIL_PCT'] > 3) {
			$fil = "Filipino: " . $x['SOS_FIL_PCT'] . "%, ";
		}

		if($x['SOS_IND_PCT'] > 3) {
			$ind = "E. Indian: " . $x['SOS_IND_PCT'] . "%, ";
		}

		if($ind || $fil || $kor || $viet || $jpn || $chi) {
			$asian_detail = "(" . $chi . $jpn . $viet . $kor . $fil . $ind;
			$asian_detail = rtrim($asian_detail, ", ") ;
			$asian_detail .= ")";
		}


	}
/*
$endhtml .= "<p>$fourcode<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permanent vote-by-mail voters: " . $x['PAV_PCT'] . "
			 <br>PDI
             <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethnic voter registration: Latino " . $x['LATINO'] . "%, Asian: " . $x['ASIAN'] . "%
             <br>SOS
             <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethnic voter registration: Latino " . $x['SOS_LAT_PCT'] . "%, Asian: " . $x['SOS_ASN_PCT'] . "% $asian_detail
             </p>";
*/

@$endhtml .= "<div align='center'>
		<hr />
		<p style='font-weight: bold; font-size: 1.2em;'>
			 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ethnic voter registration: Latino " . $x['SOS_LAT_PCT'] . "%, Asian: " . $x['SOS_ASN_PCT'] . "% $asian_detail
		 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Permanent vote-by-mail voters: " . $x['PAV_PCT'] . "
		<hr />
             </p>
	     </div>";
}


echo($endhtml);


function populateallfourcodes() {
	$i = 1;

	$fourcodes = Array();

	while($i < 81) {
		$fourcode = "AD" . checkaddzero($i);
		array_push($fourcodes, $fourcode);
		$i++;
	}

	$i = 1;

	while($i < 41) {
		$fourcode = "SD" . checkaddzero($i);
		array_push($fourcodes, $fourcode);
		$i++;
	}

	$i = 1;
	while($i < 54) {
		$fourcode = "CD" . checkaddzero($i);
		array_push($fourcodes, $fourcode);
		$i++;
	}

	return $fourcodes;
}


function getdata($fourcode) {
	global $ctb2016_conn;
	$conn = Util::get_ctb_conn();
    $x=[];

	$sql = "SELECT G16_REG_LAT, G16_REG_ASN, G16_TOT FROM ctb2016_g16_pav WHERE FOURCODE = '$fourcode' && DATA_IS = 'VOTER REG'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$x['LATINO']	 	= $row['G16_REG_LAT'] * 100;
			$x['ASIAN']			= $row['G16_REG_ASN'] * 100;
			$x['REG']			= $row['G16_TOT'];
		}
	}

	$sql = "SELECT G16_TOT FROM ctb2016_g16_pav WHERE FOURCODE = '$fourcode' && DATA_IS = 'VBM'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$x['PAV']= $row['G16_TOT'];
		}
	}

	$x['PAV_PCT'] = array_key_exists('PAV',$x)? number_format((($x['PAV'] / $x['REG']) * 100), 2) . "%":'';

	$d = getdisttype($fourcode);
	$disttype = $d['disttype'];
	$distno = $d['distno'];

	$sql = "SELECT SUM(TOTREG) AS TOTREG,
      (SUM(rHISPDEM) + SUM(rHISPREP) + SUM(rHISPDCL) + SUM(rHISPOTH)) AS HISP,
      (SUM(rCHIDEM) + SUM(rCHIREP) + SUM(rCHIDCL) + SUM(rCHIOTH)) AS CHI,
      (SUM(rVIETDEM) + SUM(rVIETREP) + SUM(rVIETDCL) + SUM(rVIETOTH)) AS VIET,
      (SUM(rKORDEM) + SUM(rKORREP) + SUM(rKORDCL) + SUM(rKOROTH)) AS KOR,
      (SUM(rFILDEM) + SUM(rFILREP) + SUM(rFILDCL) + SUM(rFILOTH)) AS FIL,
      (SUM(rJPNDEM) + SUM(rJPNREP) + SUM(rJPNDCL) + SUM(rJPNOTH)) AS JPN,
      (SUM(rINDDEM) + SUM(rINDREP) + SUM(rINDDCL) + SUM(rINDOTH)) AS IND,
      (SUM(rJEWDEM) + SUM(rJEWREP) + SUM(rJEWDCL) + SUM(rJEWOTH)) AS JEW
      FROM ctb2016_g16 WHERE $disttype = $distno";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
    		$asian = $row['CHI'] + $row['VIET'] + $row['KOR'] + $row['FIL'] + $row['JPN'] + $row['IND'];

			$x['SOS_LAT_PCT'] = number_format((($row['HISP'] / $row['TOTREG']) * 100), 2);

			$x['SOS_CHI_PCT'] = number_format((($row['CHI'] / $row['TOTREG']) * 100), 2);
			$x['SOS_VIET_PCT'] = number_format((($row['VIET'] / $row['TOTREG']) * 100), 2);
			$x['SOS_KOR_PCT'] = number_format((($row['KOR'] / $row['TOTREG']) * 100), 2);
			$x['SOS_FIL_PCT'] = number_format((($row['FIL'] / $row['TOTREG']) * 100), 2);
			$x['SOS_JPN_PCT'] = number_format((($row['JPN'] / $row['TOTREG']) * 100), 2);
			$x['SOS_IND_PCT'] = number_format((($row['IND'] / $row['TOTREG']) * 100), 2);
			$x['SOS_ASN_PCT'] = number_format((($asian / $row['TOTREG']) * 100), 2);

			$x['SOS_JEW_PCT'] = number_format((($row['JEW'] / $row['TOTREG']) * 100), 2);

    	}
    }


	return $x;
}

?>


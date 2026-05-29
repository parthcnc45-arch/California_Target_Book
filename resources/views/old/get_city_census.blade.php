@extends('layouts.master_headless')

@section('title', 'IE Single | California Target Book')

@section('content')

<?php

Util::require_ctb_api();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
setlocale(LC_COLLATE, "en_US");
setlocale(LC_CTYPE, "en_US");

$city = $_GET['id'];

loaddp05($city);
loaddp02($city);
loaddp03($city);
loaddp04($city);

function loaddp02($city) {

	$conn = Util::get_ctb_conn();

	$dp02results = Array();
	$dp02longhead = Array();
	$dp02shorthead = Array();
	$dp02sqlstring = "";
	$parseme = Array();

	$sql = "SELECT * FROM ctb2016_dp02_codes";

	$result = $conn->query($sql);

	//echo($sql);

	$i = 0;

	while($row = $result->fetch_assoc()) {
    	array_push($dp02longhead, $row["long"]);
    	array_push($dp02shorthead, $row["short"]);
    	if($i == 0) {
    		$dp02sqlstring = '`' . $row["short"] . '`';
    	} else {
    		$dp02sqlstring.= ", " . '`' . $row["short"] . '`';;
    	}

    	$i++;
	}

	$dp02sqlstring = str_replace("display-label", "displaylabel", $dp02sqlstring);

	$sql = "SELECT " . $dp02sqlstring . " FROM ctb2016_dp02_city WHERE `GEO.displaylabel` = '" . $city . "'";

	//echo($sql) . "<br>";

	//var_dump($dp02longhead);

	echo("<br>");


	$result = $conn->query($sql);

	$i = 0;

	$resultrow = "";
	$lasttime = "";

	while($row = $result->fetch_assoc()) {
		foreach($dp02shorthead as $value) {
			$x = mb_substr($value,0,4);
			
			if($x == "HC01") {
				$resultrow = substr($dp02longhead[$i],9) . " ZqZ " . $row[$value];
			} elseif ($x == "HC03") {
				$resultrow.= "  -- " . $row[$value] . "";
				array_push($parseme, $resultrow);
				//echo($resultrow);
				
			} else {
//				echo("Hi!");
			}

			$i++;
		}



		foreach ($parseme as $value) {
			//echo($value);
			$arr = explode("ZqZ", $value, 2);
			$current = $arr[0];
			$data = $arr[1];
			$arr2 = explode(" - ", $current);
			$seg1 = $arr2[0];
			$seg2 = $arr2[1];
			$seg3 = $arr2[2];
			$seg4 = $arr2[3];
			$seg5 = $arr2[4];
			$thistime = $seg1;

			if($thistime <> $lasttime) {
				$lasttime = $thistime;
				echo("</div><div class='newseg census'><h1>" . $seg1 . "</h1>");
			}

			//$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';

			if($seg5 !=""){
				echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
			}   elseif($seg4 != ""){
				echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
			}   elseif ($seg3 != "") {
				echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
			}	elseif ($seg2 != "") {
				echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
			}   else {
				echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
			}


			//echo($output);

			//echo($seg1) . "<br>";
			//echo($seg2) . "<br>";
			//echo($seg3) . "<br>";
		}

		echo"<div>";




    }




}

function loaddp03($city) {

	$conn = Util::get_ctb_conn();

	$dp03results = Array();
	$dp03longhead = Array();
	$dp03shorthead = Array();
	$dp03sqlstring = "";
	$parseme = Array();

	$sql = "SELECT * FROM ctb2016_dp03_codes";

	$result = $conn->query($sql);

	//echo($sql);

	$i = 0;

	while($row = $result->fetch_assoc()) {
    	array_push($dp03longhead, $row["long"]);
    	array_push($dp03shorthead, $row["short"]);
    	if($i == 0) {
    		$dp03sqlstring = '`' . $row["short"] . '`';
    	} else {
    		$dp03sqlstring.= ", " . '`' . $row["short"] . '`';;
    	}

    	$i++;
	}

	$dp03sqlstring = str_replace("display-label", "displaylabel", $dp03sqlstring);

	$sql = "SELECT " . $dp03sqlstring . " FROM ctb2016_dp03_city WHERE `GEO.displaylabel` = '" . $city . "'";

	//echo($sql) . "<br>";

	//var_dump($dp03longhead);

	echo("<br>");


	$result = $conn->query($sql);

	$i = 0;

	$resultrow = "";

	while($row = $result->fetch_assoc()) {
		foreach($dp03shorthead as $value) {
			$x = mb_substr($value,0,4);
			
			if($x == "HC01") {
				$resultrow = substr($dp03longhead[$i],9) . " ZqZ " . $row[$value];
			} elseif ($x == "HC03") {
				$resultrow.= "  -- " . $row[$value] . "";
				array_push($parseme, $resultrow);
				//echo($resultrow);
				
			} else {
//				echo("Hi!");
			}

			$i++;
		}



		foreach ($parseme as $value) {
			//echo($value);
			$arr = explode("ZqZ", $value, 2);
			$current = $arr[0];
			$data = $arr[1];
			$arr2 = explode(" - ", $current);
			$seg1 = $arr2[0];
			$seg2 = $arr2[1];
			$seg3 = $arr2[2];
			$seg4 = $arr2[3];
			$seg5 = $arr2[4];
			$thistime = $seg1;

			if($thistime <> $lasttime) {
				$lasttime = $thistime;
				echo("</div><div class='newseg'><h1>" . $seg1 . "</h1>");
			}

			//$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';



			if($seg5 !=""){
				echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
			}   elseif($seg4 != ""){
				echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
			}   elseif ($seg3 != "") {
				echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
			}	elseif ($seg2 != "") {
				echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
			}   else {
				echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
			}

			//echo($seg1) . "<br>";
			//echo($seg2) . "<br>";
			//echo($seg3) . "<br>";
		}

		echo"<div>";




    }




}

function loaddp04($city) {

	$conn = Util::get_ctb_conn();

	$dp04results = Array();
	$dp04longhead = Array();
	$dp04shorthead = Array();
	$dp04sqlstring = "";
	$parseme = Array();

	$sql = "SELECT * FROM ctb2016_dp04_codes";

	$result = $conn->query($sql);

	//echo($sql);

	$i = 0;

	while($row = $result->fetch_assoc()) {
    	array_push($dp04longhead, $row["long"]);
    	array_push($dp04shorthead, $row["short"]);
    	if($i == 0) {
    		$dp04sqlstring = '`' . $row["short"] . '`';
    	} else {
    		$dp04sqlstring.= ", " . '`' . $row["short"] . '`';;
    	}

    	$i++;
	}

	$dp04sqlstring = str_replace("display-label", "displaylabel", $dp04sqlstring);

	$sql = "SELECT " . $dp04sqlstring . " FROM ctb2016_dp04_city WHERE `GEO.displaylabel` = '" . $city . "'";

	//echo($sql) . "<br>";

	//var_dump($dp04longhead);

	echo("<br>");


	$result = $conn->query($sql);

	$i = 0;

	$resultrow = "";

	while($row = $result->fetch_assoc()) {
		foreach($dp04shorthead as $value) {
			$x = mb_substr($value,0,4);
			
			if($x == "HC01") {
				$resultrow = substr($dp04longhead[$i],9) . " ZqZ " . $row[$value];
			} elseif ($x == "HC03") {
				$resultrow.= "  -- " . $row[$value] . "";
				array_push($parseme, $resultrow);
				//echo($resultrow);
				
			} else {
//				echo("Hi!");
			}

			$i++;
		}



		foreach ($parseme as $value) {
			//echo($value);
			$arr = explode("ZqZ", $value, 2);
			$current = $arr[0];
			$data = $arr[1];
			$arr2 = explode(" - ", $current);
			$seg1 = $arr2[0];
			$seg2 = $arr2[1];
			$seg3 = $arr2[2];
			$seg4 = $arr2[3];
			$seg5 = $arr2[4];
			$thistime = $seg1;

			if($thistime <> $lasttime) {
				$lasttime = $thistime;
				echo("</div><div class='newseg'><h1>" . $seg1 . "</h1>");
			}

			//$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';



			if($seg5 !=""){
				echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
			}   elseif($seg4 != ""){
				echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
			}   elseif ($seg3 != "") {
				echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
			}	elseif ($seg2 != "") {
				echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
			}   else {
				echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
			}
		}

		echo"<div>";




    }




}

function loaddp05($city) {

	$conn = Util::get_ctb_conn();

	$dp05results = Array();
	$dp05longhead = Array();
	$dp05shorthead = Array();
	$dp05sqlstring = "";
	$parseme = Array();

	$sql = "SELECT * FROM ctb2016_dp05_codes";

	$result = $conn->query($sql);

	//echo($sql);

	$i = 0;

	while($row = $result->fetch_assoc()) {
    	array_push($dp05longhead, $row["long"]);
    	array_push($dp05shorthead, $row["short"]);
    	if($i == 0) {
    		$dp05sqlstring = '`' . $row["short"] . '`';
    	} else {
    		$dp05sqlstring.= ", " . '`' . $row["short"] . '`';;
    	}

    	$i++;
	}

	$dp05sqlstring = str_replace("display-label", "displaylabel", $dp05sqlstring);

	$sql = "SELECT " . $dp05sqlstring . " FROM ctb2016_dp05_city WHERE `GEO.displaylabel` = '" . $city . "'";

	//echo($sql) . "<br>";

	//var_dump($dp05longhead);

	echo("<br>");


	$result = $conn->query($sql);

	$i = 0;

	$resultrow = "";

	while($row = $result->fetch_assoc()) {
		foreach($dp05shorthead as $value) {
			$x = mb_substr($value,0,4);
			
			if($x == "HC01") {
				$resultrow = substr($dp05longhead[$i],9) . " ZqZ " . $row[$value];
			} elseif ($x == "HC03") {
				$resultrow.= "  -- " . $row[$value] . "";
				array_push($parseme, $resultrow);
				//echo($resultrow);
				
			} else {
//				echo("Hi!");
			}

			$i++;
		}



		foreach ($parseme as $value) {
			//echo($value);
			$arr = explode("ZqZ", $value, 2);
			$current = $arr[0];
			$data = $arr[1];
			$arr2 = explode(" - ", $current);
			$seg1 = $arr2[0];
			$seg2 = $arr2[1];
			$seg3 = $arr2[2];
			$seg4 = $arr2[3];
			$seg5 = $arr2[4];
			$thistime = $seg1;

			if($thistime <> $lasttime) {
				$lasttime = $thistime;
				echo("</div><div class='newseg'><h1>" . $seg1 . "</h1>");
			}

			//$output = '<section class="deleteme"><div class="greenme">'.$arr[0].'</div><div class="blueme">'.$seg1.'</div><div class="redme">'.$seg2.'</div><div class="grayme">'.$seg3.'</div><div class="purpleme">'.$seg4.'</div></section>';



			if($seg5 !=""){
				echo("<h5>" . $seg5 . "<span class='demodata'>" . $data . "</span></h5>");
			}   elseif($seg4 != ""){
				echo("<h4>" . $seg4 . "<span class='demodata'>" . $data . "</span></h4>");
			}   elseif ($seg3 != "") {
				echo("<h3>" . $seg3 . "<span class='demodata'>" . $data . "</span></h3>");
			}	elseif ($seg2 != "") {
				echo("<h2>" . $seg2 . "<span class='demodata'>" . $data . "</span></h2>");
			}   else {
				echo("<h1>" . $seg1 . "<span class='demodata'>" . $data . "</span></h1>");
			}
		}

		echo"<div>";




    }




}







?>



@endsection

@section('styles')

<link href="/css/ctb.css" rel="stylesheet">

<style>

body {
	background-color: white;
	font-family: 'Lato';
	font-size: 1em;
}

.dropshadow {
	-webkit-box-shadow: 15px 16px 43px -16px rgba(0,0,0,0.71);
	-moz-box-shadow: 15px 16px 43px -16px rgba(0,0,0,0.71);
	box-shadow: 15px 16px 43px -16px rgba(0,0,0,0.71);	
}

table {
	margin-left: auto;
	margin-right: auto;
	font-family: 'PT Sans Narrow';
}

input.button {
  background: #dedede;
  background-image: -webkit-linear-gradient(top, #dedede, #787878) !important;
  background-image: -moz-linear-gradient(top, #dedede, #787878) !important;
  background-image: -ms-linear-gradient(top, #dedede, #787878) !important;
  background-image: -o-linear-gradient(top, #dedede, #787878) !important;
  background-image: linear-gradient(to bottom, #dedede, #787878) !important;
  -webkit-border-radius: 28 !important;
  -moz-border-radius: 28 !important;
  border-radius: 28px !important;
  -webkit-box-shadow: 0px 1px 3px #666666 !important;
  -moz-box-shadow: 0px 1px 3px #666666 !important;
  box-shadow: 2px 2px 3px #666666 !important;
  font-family: 'Lato' !important;
  font-weight: normal !important;
  color: white !important;
  font-size: 16px !important;
  border: solid black 2px !important;
  width: 28% !important;
  margin: 0px auto !important;
  margin-right: 10px !important;
  margin-top: 0px !important;
  height: 40px !important;
  text-decoration: none !important;
  text-shadow: 1px 2px black !important;
}

input.button:hover {
  background: #3cb0fd !important;
  background-image: -webkit-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
  background-image: -moz-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
  background-image: -ms-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
  background-image: -o-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
  background-image: linear-gradient(to bottom, #3cb0fd, #0a3b5c) !important;
  text-decoration: none !important;
  color: white;
} 

input.close {
  background: #3498db !important;
  display: inline;
  background: #dedede;
  background-image: -webkit-linear-gradient(top, #dedede, #787878) !important;
  background-image: -moz-linear-gradient(top, #dedede, #787878) !important;
  background-image: -ms-linear-gradient(top, #dedede, #787878) !important;
  background-image: -o-linear-gradient(top, #dedede, #787878) !important;
  background-image: linear-gradient(to bottom, #dedede, #787878) !important;
  -webkit-border-radius: 28 !important;
  -moz-border-radius: 28 !important;
  border-radius: 28px !important;
  -webkit-box-shadow: 0px 1px 3px #666666 !important;
  -moz-box-shadow: 0px 1px 3px #666666 !important;
  box-shadow: 0px 1px 3px #666666 !important;
  font-family: 'Lato' !important;
  font-weight: normal !important;
  color: white !important;
  font-size: 14px !important;
  border: solid black 2px !important;
  width: 10% !important;
  margin: 0px auto !important;
  margin-right: 0px !important;
  margin-top: 0px !important;
  height: 40px !important;
  text-decoration: none !important;
  text-shadow: 1px 2px black !important;
}

input.close:hover {
    background: #fc3c3c !important;
  background-image: -webkit-linear-gradient(top, #fc3c3c, #73001d) !important;
  background-image: -moz-linear-gradient(top, #fc3c3c, #73001d) !important;
  background-image: -ms-linear-gradient(top, #fc3c3c, #73001d) !important;
  background-image: -o-linear-gradient(top, #fc3c3c, #73001d) !important;
  background-image: linear-gradient(to bottom, #fc3c3c, #73001d) !important;
  text-decoration: none !important;
  color: white;
  scale: 1.1;
}

input.campaign {
  max-width: 600px !important;
}

   #btmclose {
      display: none;
}

   #btmclose2 {
	display: none;

}

#welcomeDiv {
	display: none;
}

#welcomeDiv2 {
	display: none;
}

</style>

@endsection


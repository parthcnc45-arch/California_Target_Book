<?php

Util::require_ctb_api();

$fourcode = $_GET["id"];    //SYNTAX this.url?id=AD50?rpt=vdetail
$qrep = $_GET["rpt"];

 function clearunused() {
    if($_POST['districttype'] != "") {
        $_POST['raddist'] = "";
    }

    if($_POST['raddist'] != "") {
        $_POST['districttype'] = "";
    }
 }        



?>
@extends('layouts.iframe_old')

@section('title', 'Direct | California Target Book')

@section('content')

    <link href="/css/ctb.css" rel="stylesheet">

    <div class="qcont" text-align="center">

    </div>
    <div class="resultscontainer nocopy">

        <script language="JavaScript">
          document.oncontextmenu = new Function("return false;");
        </script>

        <?php


//        include "php/functions.php";
//        include "php/censusdb.php";
//        include "php/filingfunctions.php";

        //error_reporting(E_ALL);
        //ini_set('display_errors', '1');

        $fourcode = $_GET["id"];    //SYNTAX this.url?id=AD50?rpt=vdetail
        $qrep = $_GET["rpt"];
        $qelec = "g14";

        $key_name = $fourcode . "_" . $qrep;

        if(Cache::has($key_name)) {
            $final_draw = Cache::get($key_name);
            echo($final_draw);
            //echo("<br>SHOWING CACHED PAGE!");
            exit;
        }        
	
        $masterfourcode = $fourcode;

        ob_start();

        //SET VARIABLES

        $addzero = "0";
        $turnout = 0;
        $dadv = 0;
        $tclass = "";

        //INITIALIZE

        //$fourcode = mb_substr($fourcode, 0,4);
        //$qrep = substr($fourcode, 9);

        $x = tophalf($fourcode);

        switch ($x) {
            case "addist":
                $ad = bothalf($fourcode);
                $qdist = tophalf($fourcode);
                $dist = bothalf($fourcode);
                break;
            case "sddist":
                $sd = bothalf($fourcode);
                $qdist = tophalf($fourcode);
                $dist = bothalf($fourcode);
                break;
            case "cddist":
                $cd = bothalf($fourcode);
                $qdist = tophalf($fourcode);
                $dist = bothalf($fourcode);
                break;
            case "county":
                $ct = bothalf($fourcode);
                $qdist = tophalf($fourcode);
                $dist = bothalf($fourcode);
                break;
        }


        if ($_POST['districttype'] == "statewide") {
            $dist = 999;
        }
        clearunused();

        $disttype = strtoupper(mb_substr($qdist, 0, 2));
        $i = 0;
        $result = "";

        $conn = Util::get_ctb_conn();


        // PREPARE QUERY BASED ON USER INPUTS

        if ($qrep == "vto") {
            $sql = "SELECT SUM(TOTREG) AS Reg, SUM(TOTVOTE) as Vote FROM ctb2016_" . $qelec . " GROUP BY " . $qdist . " ";
            $result = $conn->query($sql);
            $i = p12check($qelec);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    if ($i <> 0) {
                        $turnout = calcpct($row["Vote"], $row["Reg"]);
                    }

                    $tclass = calctoclr($turnout);
                    $addzero = checkaddzero($i);

                    if ($i <> 0) echo("<section class='dbtotal " . $tclass . "'><div class='qdist'>" . $disttype . $addzero . "</div><div class='dbsub'><div class='totreg'>Registered: " . $row["Reg"] . "</div><div class='totvote'>Voting: " . $row["Vote"] . "</div><div class='turnout'>Turnout: " . $turnout . "</div></div></section>");
                    $i++;
                }
            } else {
                echo "0 results";
            }

        } elseif ($qrep == "vcensus") {
            $fourcode = makefour($qdist, $dist);

            echo("<div class='redhead'><h1>" . $fourcode . "</h1></div>");
            echo("<h3>All Data Taken From the 2013 5-year Estimates From the US Census</h3>");

            loaddp05($fourcode, $conn);
            loaddp02($fourcode, $conn);
            loaddp03($fourcode, $conn);
            loaddp04($fourcode, $conn);
            loads1101($fourcode, $conn);
        } elseif ($qrep == "vcf") {
            $fourcode = makefour($qdist, $dist);
            header("Location: cf.php?id=$fourcode");
            //include "cf.php";

        } elseif ($qrep == "vreg") {
            $sql = "SELECT SUM(rDEM) AS DEM, SUM(rREP) AS REP, SUM(rDCL) AS DCL, SUM(rTOTREG_R) AS TOTAL FROM ctb2016_" . $qelec . " GROUP BY " . $qdist . " ";
            //echo("SQL: " . $sql);
            $result = $conn->query($sql);
            $i = p12check($qelec);

            if ($result->num_rows > 0) {
                // output data of each row

                while ($row = $result->fetch_assoc()) {
                    if ($i <> 0) {
                        $dempct = calcpct($row["DEM"], $row["TOTAL"]);
                        $reppct = calcpct($row["REP"], $row["TOTAL"]);
                        $npppct = calcpct($row["DCL"], $row["TOTAL"]);

                        $dadv = ($dempct - $reppct);
                        $tclass = calcadvclr($dadv);

                    };

                    $addzero = checkaddzero($i);

                    if ($i <> 0) echo("<section class='dbtotal " . $tclass . "'><div class='qdist'>" . $disttype . $addzero . "</div><div class='dbsub'><div class='totreg'>Registered: " . $row["TOTAL"] . "</div><div class='totdem'>D: " . $dempct . "</div><div class='totrep'>R: " . $reppct . "</div><div class='totnpp'>NPP: " . $npppct . "</div></div></section>");
                    $i++;
                }
            } else {
                echo "0 results";
            }

        } elseif ($qrep == "veth") {


            //echo("vage selected...getting ethnic stats...");

            $printdist = $disttype . $dist;
            $fourcode = makefour($qdist, $dist);

            if ($qdist == "county" && $dist < 999) {
                $printdist = getcountyname($dist) . " County";
            } elseif ($dist == 999) {
                $printdist = "Statewide Totals";
            } else {
                //do nothing
            }

            $electarr = Array("g16", "p16", "g14", "p14", "g12", "p12");
            $asianarr = Array("KOR", "JPN", "CHI", "IND", "VIET", "FIL");

            $otherarr = Array("HISP", "JEW");
            $asiantotal = Array();

            //		$electarr = "g12";
            //		$asianarr = Array("KOR");

            foreach ($electarr as $qelec) {

                switch ($qelec) {
                    case "g16":
                        $printelec = "2016 General Election";
                        break;
                    case "p16":
                        $printelec = "2016 Primary Election";
                        break;
                    case "g14":
                        $printelec = "2014 General Election";
                        break;
                    case "p14":
                        $printelec = "2014 Primary Election";
                        break;
                    case "g12":
                        $printelec = "2012 General Election";
                        break;
                    case "p12":
                        $printelec = "2012 Primary Election";
                        break;
                }

                echo("<div class = 'electhead'><h1>" . $printdist . " - " . $printelec . "</h1></div>");

                $disclaimer = getdisclaimer($qelec, $qrep, $fourcode);
                if ($disclaimer != "") {
                    echo("<div class = 'disclaimer'><h5>" . $disclaimer . "</h5></div>");
                }

                //GET ALL ASIAN SUBGROUPS

                $asianhead = Array("DEM", "REP", "DCL", "OTH", "TOT");
                $asiansreg = Array(0, 0, 0, 0, 0);
                $asiansvot = Array(0, 0, 0, 0, 0);
                $asiandreg = Array(0, 0, 0, 0, 0);
                $asiandvot = Array(0, 0, 0, 0, 0);

                foreach ($asianarr as $ethgrp) {

                    $x = getethnicstats($fourcode, $qelec, $ethgrp, $conn);

                    //debugx($x);

                    //KEEP RUNNING TOTAL OF STATEWIDE ASIAN

                    $i = 0;
                    $j = 0;
                    $ptr = 12;

                    foreach ($asianhead as $value) {
                        $asiandreg[$j] = $asiandreg[$j] + $x[$i];
                        $asiandvot[$j] = $asiandvot[$j] + $x[$i + 1];
                        $asiansreg[$j] = $asiansreg[$j] + $x[$ptr + $i];
                        $asiansvot[$j] = $asiansvot[$j] + $x[$ptr + $i + 1];
                        $i = $i + 2;
                        $j = $j + 1;
                    }

                    //echo("adding " . $x[20] .  " " . $x[21] . " to " . $asiansreg[4] . " " . $asiansvot[4]);

                    //$asiandreg[4] = $asiandreg[4] + $x[10];
                    //$asiandvot[4] = $asiandvot[4] + $x[11];

                    //$asiansreg[4] = $asiansreg[4] + $x[20];
                    //$asiansvot[4] = $asiansvot[4] + $x[21];

                    //var_dump($asiansvot);
                    //var_dump($asiansreg);

                    drawethnicdiv($x);


                }

                //WHEN FINISHED WITH INDIVIDUAL ASIAN SUBGROUPS, REPOPULATE LAST RESULT WITH TOTAL, 'ALL ASIAN' DIVHEAD

                $i = 0;
                $j = 0;
                $rptr = 12;

                $asianhead = Array("DEM", "REP", "DCL", "OTH", "TOT");
                foreach ($asianhead as $value) {
                    //echo("R[" . $j . "]:" . $asiandreg[$j] . "V:" . $asiandvot[$j]);

                    $x[$i] = $asiandreg[$j];
                    $x[$i + 1] = $asiandvot[$j];

                    $x[$ptr + $i] = $asiansreg[$j];
                    $x[$ptr + $i + 1] = $asiansvot[$j];

                    $i = $i + 2;
                    $j++;
                }

                //var_dump($asiandreg);

                $x[30] = "TOTAL ASIAN";

                drawethnicdiv($x);

                foreach ($otherarr as $ethgrp) {

                    $x = getethnicstats($fourcode, $qelec, $ethgrp, $conn);
                    drawethnicdiv($x);

                }
            }

        } elseif ($qrep == "vparty") {

            $printdist = $disttype . $dist;
            $fourcode = makefour($qdist, $dist);

            if ($qdist == "county" && $dist < 999) {
                $printdist = getcountyname($dist) . " County";
            } elseif ($dist == 999) {
                $printdist = "Statewide Totals";
            } else {
                //do nothing
            }

            $divhead2 = Array("DEMOCRATIC PARTY", "REPUBLICAN PARTY", "NO PARTY PREFERENCE", "ALL OTHER PARTIES");
            $parties = Array("DEM", "REP", "DCL", "OTH");
            $elections = Array("g16", "p16", "g14", "p14", "g12", "p12");


            foreach ($elections as $value) {
                $qelec = $value;

                switch ($qelec) {
                    case "g16":
                        $printelec = "2016 General Election";
                        break;
                    case "p16":
                        $printelec = "2016 Primary Election";
                        break;
                    case "g14":
                        $printelec = "2014 General Election";
                        break;
                    case "p14":
                        $printelec = "2014 Primary Election";
                        break;
                    case "g12":
                        $printelec = "2012 General Election";
                        break;
                    case "p12":
                        $printelec = "2012 Primary Election";
                        break;
                }


                echo("<div class = 'electhead'><h1>" . $printdist . " - " . $printelec . "</h1></div>");

                $disclaimer = getdisclaimer($qelec, $qrep, $fourcode);
                if ($disclaimer != "") {
                    echo("<div class = 'disclaimer'><h5>" . $disclaimer . "</h5></div>");
                }

                $i = 0;

                foreach ($parties as $value) {

                    //$x = plansexparty("AD40", "p12", "AGE", "1824", $conn);
                    $x = plansexparty($fourcode, $qelec, "PARTY", $value, $conn);
                    $results = getpartyresults($fourcode, $qelec, $x, $conn);
                    $results[52] = $divhead2[$i];

                    drawpartydiv($results);

                    $i++;

                }
            }

        } elseif ($qrep === "vdetail") {


            //echo("Dist:" . $qdist . " County:" . $dist . " ");
            $printdist = $disttype . $dist;
            $fourcode = makefour($qdist, $dist);

            include(Util::$view_root.'g16_sovdone_single.php');

        } elseif ($qrep === "vage") {

            include 'php/rosterdb.php';
            $x = loadroster($conn);

            foreach ($x as $value) {
                echo($value);
            }
        } elseif ($qrep === "veth") {

            //PLACEHOLDER FOR ETHNIC GROUP REPORTS

        } else {
            $sql = "";
        }




        $output = ob_get_contents();

        ob_end_clean();

        Cache::forever($key_name, $output);

        echo($output);



        ?>

    </div>  <!--END RESULTS CONTAINTER -->



@endsection

@extends('layouts.iframe')

@section('title', 'IE History | California Target Book')

@section('content')


    

    <?php


    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    $endjava = Array();

    Util::set_errors();
    Util::require_ctb_api();
    Util::include("php/rosterqs.php");

//    $conn = $calaccess_conn;
//    $conn2 = $ctb2016_conn;
//    $conn3 = $scrape_conn;

    $conn = Util::get_ctb_conn();

    ini_set('memory_limit', '128M');
    $iespend = Array();
    $candspend = Array();
    $datespend = Array();

    //$pdstart = $_GET['ps'];
    //$pdend = $_GET['pe'];

    $pdstart = $conn->real_escape_string($_GET['ps']);
    $pdend = $conn->real_escape_string($_GET['pe']);

    $year = substr($pdstart, 0, 4);

    switch ($year) {
        case "2014":
            $election = "p14";
            break;
        case "2012":
            $election = "p12";
            break;
        case "2010":
            $election = "p10";
            break;
        case "2008":
            $election = "p08";
            break;
        case "2006":
            $election = "p06";
            break;
        case "2004":
            $election = "p04";
            break;
        case "2002":
            $election = "p02";
            break;
        case "2000":
            $election = "p00";
            break;
        default:
            $election = '';
            break;
    }

    $firstfiling = getfirst($pdstart);
    $lastfiling = getlast($pdend);

    //echo("<br>Last Filing on $pdstart: $firstfiling<br>Last Filing on $pdend: $lastfiling<br>");


    $sql = "SELECT * FROM calccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE FILING_ID > '$firstfiling' && FILING_ID < '$lastfiling' && DIST_NO <> '' && FORM_TYPE = 'F496' ORDER BY FILING_ID DESC, AMEND_ID DESC";

    //echo($sql);

    $result = $conn->query($sql);

    echo("<div class='newseg'>");
    echo("<h1>Primary Independent Expenditure Filings $pdstart to $pdend</h1>");
    echo("<p style='text-align: center; margin-left:auto; margin-right: auto;font-weight: bold; font-size: 14pt;'><a href='#iechart'>Jump to Charts</a></p>");

    $i = 1;

    $iecommittees = Array();

    $thisid = "cmte";

    $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

    array_push($endjava, $js);

    $tablehead = "
<table id='$thisid' class='tablesorter bordered'>
	<thead>
		<tr>
			<th>CANDIDATE</th>
			<th>AMOUNT</th>
			<th>POSITION</th>
			<th>DIST</th>
			<th>NO</th>
			<th>FILER</th>
			<th>FILING</th>
			<th width='75px'>DATE</th>
		</tr>
	</thead>
	<tbody>

";

    echo($tablehead);
    $thisfiling = '';
    $lastfiling = '';
    $drawentry = '';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //echo "<section class='listrow'>";
            $thisfiling = $row['FILING_ID'];

            if ($thisfiling != $lastfiling) {
                $date = getadate($row['FILING_ID']);

                if ($date >= $pdstart && $date <= $pdend) {
                    $tempvar = getamount($row['FILING_ID']);
                    $total = $tempvar['TOTAL'];
                    $title = $tempvar['TITLE'];
                    $filer = $row['FILER_ID'];
                    $filername = $row['FILER_NAML'];
                    $cmte_lnk = "<a href='http://cal-access.ss.ca.gov/Misc/redirector.aspx?id=" . $row['FILER_ID'] . "' target='_blank'>" . mb_substr($row['FILER_NAML'], 0, 100) . "</a>";

                    if ($row['CAND_NAMF']) {
                        $fullname = $row['CAND_NAMF'] . " " . $row['CAND_NAML'];
                        $lastname = $row['CAND_NAML'];
                    } else {
                        $fullname = $row['CAND_NAML'];
                        $pieces = explode(' ', $fullname);
                        $lastname = array_pop($pieces);
                    }

                    if ($lastname == "(I)") {
                        $lastname = array_pop($pieces);
                    }

                    $lastname = strtoupper($lastname);
                    $distno = checkaddzero($row['DIST_NO']);

                    $fourcode = retrievefourcode($lastname, $distno);

                    if (!$fourcode) {
                        $fourcode = getoldfourcode($lastname, $distno);
                    }

                    $candspend[$lastname]['AMOUNT'] += $total;
                    $candspend[$lastname]['NAML'] = $lastname;

                    if ($fourcode) {
                        //echo("<br>Found Assembly Race, Adding $total to iespend['$fourcode']<br>");
                        $iespend[$fourcode]['AMOUNT'] += $total;


                        if ($row['SUP_OPP_CD'] == "O") {
                            $iespend[$fourcode]['OPP'] += $total;
                            $candspend[$lastname]['OPP'] += $total;
                            $iecommittees[$filer]['OPP'] += $total;
                            $iecommittees[$filer]['NAML'] = $filername;
                        }

                        if ($row['SUP_OPP_CD'] == "S") {
                            $iespend[$fourcode]['SUP'] += $total;
                            $candspend[$lastname]['SUP'] += $total;
                            $iecommittees[$filer]['SUP'] += $total;
                            $iecommittees[$filer]['NAML'] = $filername;
                        }

                        $iespend[$fourcode]['DIST'] = "$fourcode";
                        $legtotal += $total;

                    }
                    $candspend[$lastname]['AMOUNT'] += $total;
                    $iecommittees[$filer]['AMOUNT'] += $total;
                    $iecommittees[$filer]['NAML'] = $filername;
                    $name_lnk = "<a href='http://cal-access.ss.ca.gov/Misc/redirector.aspx?id=" . $row['FILER_ID'] . "'' target='_blank'>" . $fullname . "</a>";
                    $filing_lnk = "<a href='http://cal-access.ss.ca.gov/PDFGen/pdfgen.prg?filingid=" . $row['FILING_ID'] . "' target='_blank'>" . $row['FILING_ID'] . "</a>";

                    if ($row['SUP_OPP_CD'] == "O") {
                        $class = 'redme';
                        $status = "OPPOSING";
                    } else {
                        $class = 'greenme';
                        $status = "SUPPORTING";
                    }

                    $drawentry .= "
				<tr class='rowsearch' title='$title'>
					<td>" . $fullname . "</td>
					<td>\$$total</td>
					<td class='$class'>$status</td>
					<td>" . $row['JURIS_CD'] . "</td>
					<td>" . $row['DIST_NO'] . "</td>
					<td>" . $cmte_lnk . "</td>
					<td> $filing_lnk</td>
					<td>$date</td>
				</tr>
				";
                    $grandtotal += $total;
                    $datespend[$date]['AMOUNT'] += $total;
                    $datespend[$date]['DATE'] = $date;

                }
            }
            $lastfiling = $thisfiling;
            $i++;
        }

    } else {
        $retval = "0 results";
    }

    echo($drawentry);
    echo("</tbody></table>");
    echo("</div>");
    echo("<h1>\$" . number_format($grandtotal, 2) . " in Independent Expenditures Recorded</h1>");

    //var_dump($iespend);
    uasort($iespend, 'totalsort');
    foreach ($iespend as $value) {
        $dist = $value['DIST'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$sup) {
            $sup = "0";
        }

        if (!$opp) {
            $opp = "0";
        }
        //echo("<br>$dist: - \$$amount<br>");
        $annotation = "\$" . number_format($amount, 2);
        $drawarray .= "
		['$dist', $amount, '$annotation'],";
        $totalleg += $amount;
    }
    $totalleg = number_format($totalleg, 2);

    uasort($iespend, 'supportsort');
    foreach ($iespend as $value) {
        $dist = $value['DIST'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$sup) {
            $sup = "0";
        } else {
            $supportarray .= "
			['$dist', $sup],";
            $totalsup += $sup;
        }
    }

    uasort($iespend, 'opposesort');
    foreach ($iespend as $value) {
        $dist = $value['DIST'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$sup) {
            $sup = "0";
        }

        if (!$opp) {
            $opp = "0";
        } else {
            $opposearray .= "
			['$dist', $opp],";
            $totalopp += $opp;
        }
    }

    uasort($candspend, 'supportsort');
    foreach ($candspend as $value) {
        $cand = $value['NAML'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$sup) {
            $sup = "0";
        } else {
            $candsupportarray .= "
			['$cand', $sup],";
            $totalcandsup += $sup;
        }
    }

    uasort($candspend, 'opposesort');
    foreach ($candspend as $value) {
        $cand = $value['NAML'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$opp) {
            $opp = "0";
        } else {
            $candopposearray .= "
			['$cand', $opp],";
            $totalcandopp += $opp;
        }
    }
    uasort($iecommittees, 'totalsort');
    foreach ($iecommittees as $value) {
        $dist = str_replace("'", "", $value['NAML']);
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$sup) {
            $sup = "0";
        }

        if (!$opp) {
            $opp = "0";
        }
        //echo("<br>$dist: - \$$amount<br>");
        $annotation = "\$" . number_format($amount, 2);
        if ($amount > 10000) {
            $committeetotalsarray .= "
			['$dist', $amount, '$annotation'],";
        }
        $totalleg += $amount;
    }
    uasort($datespend, 'datesort');
    foreach ($datespend as $value) {
        $date = $value['DATE'];
        $amount = $value['AMOUNT'];
        //echo("A total of \$" . number_format($amount) . " was logged on $date<br>");
        $datearray .= "
		['$date', $amount],";
    }

    $drawarray = substr($drawarray, 0, -1);
    $supportarray = substr($supportarray, 0, -1);
    $opposearray = substr($opposearray, 0, -1);
    $datearray = substr($datearray, 0, -1);

    $totalleg = number_format($totalleg, 2);

    $candsupportarray = substr($candsupportarray, 0, -1);
    $candopposearray = substr($candopposearray, 0, -1);
    $committeetotalsarray = substr($committeetotalsarray, 0, -1);

    $supporttotal = number_format($totalsup, 2);
    $opposetotal = number_format($totalopp, 2);
    $candsupporttotal = number_format($totalcandsup, 2);
    $candopposetotal = number_format($totalcandopp, 2);

    $legtotal = number_format($legtotal, 2);


    $js = "
	  google.load('visualization', '1.0', {'packages':['corechart'], 'callback': drawCharts});


      function drawCharts() {
      	drawLine();
      	drawTotal();
      	drawSupport();
      	drawOppose();
      	drawCandSupport();
      	drawCandOppose();
      	drawCommitteeTotals();
      }

      function drawLine() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Total'],
		  $datearray


        ]);

        var options = {

            title: 'Independent Expenditure Activity by Date',
            backgroundColor: 'none',
            pointSize: 3,
            titleTextStyle: {
		      color: '333333',
		      fontName: 'PT Sans Narrow',
		      fontSize: 28
		    },
            annotations: {
            	alwaysOutside: true,
            	textStyle: {
            		fontSize: 9
            	}
            },
 			hAxis: {
 				slantedText:true,
 				slantedTextAngle:90,
 				textStyle: {
 					fontSize: 10
 				}
 			},
             vAxis: {
            	textStyle: {
            		fontSize: 11
              	}
            },
            legend: 'none',
            chartArea: {
            	width: '80%',
            	height: '80%'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('linechart'));

        chart.draw(data, options);
      }

      function drawTotal() {
        var data = google.visualization.arrayToDataTable([
          ['District', 'Total', {type: 'string', role:'annotation'}],
		  $drawarray


        ]);

        var options = {

            title: '$year Independent Expenditure Activity in Legislative Races - \$$legtotal',
            backgroundColor: 'none',
            titleTextStyle: {
		      color: '333333',
		      fontName: 'PT Sans Narrow',
		      fontSize: 28
		    },
            annotations: {
            	alwaysOutside: true,
            	textStyle: {
            		fontSize: 9
            	}
            },
            hAxis: {
            	title: 'Total Spending',
            	minValue: 0
            },
             vAxis: {
            	textStyle: {
            		fontSize: 11
              	}
            },
            legend: 'none',
            chartArea: {
            	width: '80%',
            	height: '80%'
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('iechart'));

        chart.draw(data, options);
      }


    function drawCommitteeTotals() {
        var data = google.visualization.arrayToDataTable([
          ['Committee', 'Total', {type: 'string', role:'annotation'}],
		  $committeetotalsarray


        ]);

        var options = {

            title: 'Independent Expenditures By Committee',
            backgroundColor: 'none',
            legend: 'none',
            titleTextStyle: {
		      color: '333333',
		      fontName: 'PT Sans Narrow',
		      fontSize: 28
		    },
            annotations: {
            	alwaysOutside: true,
            	textStyle: {
            		fontSize: 9
            	}
            },
            hAxis: {
            	title: 'Total Spending',
            	minValue: 0
            },
             vAxis: {
            	textStyle: {
            		fontSize: 9
              	}
            },
              chartArea: {
            	width: '70%',
            	height: '80%'
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('committeechart'));

        chart.draw(data, options);
      }


      ";


    $js .= "

      function drawSupport() {
        var data = google.visualization.arrayToDataTable([
          ['District', 'Total'],
		  $supportarray


        ]);

        var options = {

            title: 'Independent Expenditure Activity In Support of Legislative Candidates - \$$supporttotal',
            backgroundColor: 'none',
            titleTextStyle: {
		      color: '333333',
		      fontName: 'PT Sans Narrow',
		      fontSize: 24
		    },
            subtitle: 'In Legislative Races',
             vAxis: {
            	textStyle: {
            		fontSize: 11
              	}
            },
            legend: 'none',
            chartArea: {
            	width: '80%',
            	height: '80%'
            }

        };

        var chart = new google.visualization.BarChart(document.getElementById('supchart'));

        chart.draw(data, options);
      }



      ";

    $js .= "

      function drawOppose() {
        var data = google.visualization.arrayToDataTable([
          ['District', 'Total'],
		  $opposearray


        ]);

        var options = {

            title: 'Independent Expenditure Activity In Opposition to Legislative Candidates - \$$opposetotal',
            backgroundColor: 'none',
            titleTextStyle: {
		      color: '333333',
		      fontName: 'PT Sans Narrow',
		      fontSize: 24
		    },
            subtitle: 'In Legislative Races',
          	legend: 'none',
            chartArea: {
            	width: '80%',
            	height: '80%'
            }

        };

        var chart = new google.visualization.BarChart(document.getElementById('oppchart'));

        chart.draw(data, options);
      }



      ";

    $js .= "

      function drawCandSupport() {
        var data = google.visualization.arrayToDataTable([
          ['Candidate', 'Total'],
		  $candsupportarray


        ]);

        var options = {

            title: 'Legislative Candidates Receiving Supportive Independent Expenditure Activity',
            backgroundColor: 'none',
            titleTextStyle: {
		      color: '333333',
		      fontName: 'PT Sans Narrow',
		      fontSize: 28
		    },
            subtitle: 'In Legislative Races',
 			hAxis: {
 				slantedText:true,
 				slantedTextAngle:90,
 				textStyle: {
 					fontSize: 10
 				}
 			},
            vAxis: {
            	textStyle: {
            		fontSize: 10
              	}
            },
 			legend: 'none',
            chartArea: {
            	width: '90%',
            	height: '75%'
            }

        };

        var chart = new google.visualization.ColumnChart(document.getElementById('candsupchart'));

        chart.draw(data, options);
      }



      ";

    $js .= "

      function drawCandOppose() {
        var data = google.visualization.arrayToDataTable([
          ['Candidate', 'Total'],
		  $candopposearray


        ]);

        var options = {
            title: 'Legislative Candidates Receiving Opposing Independent Expenditure Activity',
            backgroundColor: 'none',
            titleTextStyle: {
		      color: '333333',
		      fontName: 'PT Sans Narrow',
		      fontSize: 28
		    },
            subtitle: 'In Legislative Races',
            hAxis: {
            	textStyle: {
            		fontSize: 12
            	},
            	slantedText:false,
            	slantedTextAngle:45
            },
            legend: 'none',
            chartArea: {
            	width: '80%',
            	height: '80%'
            }


        };

        var chart = new google.visualization.BarChart(document.getElementById('candoppchart'));

        chart.draw(data, options);
      }



      ";


    array_push($endjava, $js);


    echo("<div class='box1200' style='width: 1024px; height: 1200px; text-align: center; margin-left: auto; margin-right: auto;'>");
    echo("<div class='newseg' id='iechart' style='margin-top: 20px; width: 1024px; height: 1200px;'></div>");
    echo("</div>");

    echo("<div class='box1200' style='width: 1024px; height: 1200px; text-align: center; margin-left: auto; margin-right: auto;'>");
    echo("<div class='newseg' id='supchart' style='margin-top: 20px; width: 1024px; height: 1200px;'></div>");
    echo("</div>");

    echo("<div class='box800' style='width: 1024px; height: 800px; text-align: center; margin-left: auto; margin-right: auto;'>");
    echo("<div class='newseg' id='oppchart' style='margin-top: 20px; width: 1024px; height: 800px;'></div>");
    echo("</div>");

    echo("<div class='box800' style='width: 1024px; height: 800px; text-align: center; margin-left: auto; margin-right: auto;'>");
    echo("<div class='newseg' id='candsupchart' style='margin-top: 20px; width: 1024px; height: 800px;'></div>");
    echo("</div>");

    echo("<div class='box800' style='width: 1024px; height: 800px; text-align: center; margin-left: auto; margin-right: auto;'>");
    echo("<div class='newseg' id='candoppchart' style='margin-top: 20px; width: 1024px; height: 800px;'></div>");
    echo("</div>");


    echo("<div class='box1800' style='width: 1024px; height: 1800px; text-align: center; margin-left: auto; margin-right: auto;'>");
    echo("<div class='newseg' id='committeechart' style='margin-top: 20px; width: 1024px; height: 1800px;'></div>");
    echo("</div>");

    echo("<div class='box800' style='width: 1024px; height: 800px; text-align: center; margin-left: auto; margin-right: auto;'>");
    echo("<div class='newseg' id='linechart' style='margin-top: 20px; width: 1024px; height: 800px;'></div>");
    echo("</div>");


    function totalsort($a, $b)
    {

        if ($a['AMOUNT'] < $b['AMOUNT']) {
            return 1;
        } elseif ($a['AMOUNT'] > $b['AMOUNT']) {
            return -1;
        } else {
            return 0;
        }
    }

    function supportsort($a, $b)
    {

        if ($a['SUP'] < $b['SUP']) {
            return 1;
        } elseif ($a['SUP'] > $b['SUP']) {
            return -1;
        } else {
            return 0;
        }
    }

    function opposesort($a, $b)
    {

        if ($a['OPP'] < $b['OPP']) {
            return 1;
        } elseif ($a['OPP'] > $b['OPP']) {
            return -1;
        } else {
            return 0;
        }
    }

    function datesort($a, $b)
    {
        if ($a['DATE'] < $b['DATE']) {
            return -1;
        } elseif ($a['DATE'] > $b['DATE']) {
            return 1;
        } else {
            return 0;
        }
    }

    function retrievefourcode($name, $district)
    {
        $conn = Util::get_ctb_conn();
        $sql = "SELECT rdist_id FROM ctb2016_rcandidates WHERE lastname LIKE '%$name%' && rdist_id LIKE '%$district%'";
        //echo("<br>$sql<br");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['rdist_id'];
            }
        }

        //echo("<br>$retval<br>");
        return $retval;

    }

    function getoldfourcode($name, $district)
    {
        $conn = Util::get_ctb_conn();
        global $election;
        if (substr($district, 0, 1) == "0") {
            $district = substr($district, 1, 1);
        }

        $sql = "SELECT * FROM elections_candidates WHERE name like '%$name%' && distnum = '$district' && election = '$election'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $race = $row['race'];
            }
        }

        $type = mb_substr($race, 0, 3);
        $dist = mb_substr($race, 3, 2);
        $party = mb_substr($race, 5, 3);
        $candno = mb_substr($race, 8, 2);

        if ($type == "SEN") {
            $fourcode = "SD" . $dist;
        }

        if ($type == "ASS") {
            $fourcode = "AD" . $dist;
        }

        return $fourcode;
    }

    function getadate($filing)
    {
        $conn = Util::get_ctb_conn();

        $sql = "SELECT FILING_DATE FROM calaccess_raw_FILER_FILINGS_CD WHERE FILING_ID = '$filing'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILING_DATE'];
            }
        }

        return $retval;
    }

    function getfirst($date)
    {
        $conn = Util::get_ctb_conn();
        $sql = "SELECT FILING_ID FROM calccess_raw_FILER_FILINGS_CD WHERE FILING_DATE = '$date' ORDER BY FILING_ID LIMIT 1";
        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILING_ID'];
            }
        }

        return $retval;
    }

    function getlast($date)
    {
        $conn = Util::get_ctb_conn();
        $sql = "SELECT FILING_ID FROM calccess_raw_FILER_FILINGS_CD WHERE FILING_DATE = '$date' ORDER BY FILING_ID DESC LIMIT 1";
        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILING_ID'];
            }
        }

        return $retval;
    }

    function getamount($filing)
    {
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $highest = gethighestamend($filing);

        $sql = "SELECT AMOUNT, FILING_ID, LINE_ITEM, EXPN_DSCR, AMEND_ID FROM calccess_raw_S496_CD WHERE FILING_ID = '$filing' && AMEND_ID = '$highest'";
        $result = $conn->query($sql);
        $thisamend = '';
        $lastamend = '';
        $highestamend = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $thisamend = $row['AMEND_ID'];
                if (!$highestamend) {
                    $highestamend = $row['AMEND_ID'];
                }

                if ($thisamend == $highestamend) {
                    $retval['TOTAL'] += $row['AMOUNT'];
                    $retval['TITLE'] .= "\$" . number_format($row['AMOUNT'], 2) . " for " . $row['EXPN_DSCR'] . "\n";
                } else {
                    //DO NOTHING
                }
                //echo("<br>$thisfiling and $lastfiling<br>");

            }
        }

        return $retval;
    }

    ?>


@endsection

@section('scripts')
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection

@section('styles')
<style type="text/css">

    .box1800 {
        background-image: url(box1800.jpg);
        background-position: center;
    }

    .box1200 {
        background-image: url(box1200.jpg);
        background-position: center;
    }

    .box500 {
        background-image: url(box500.jpg);
        background-position: center;;
    }

    .box800 {
        background-image: url(box800.jpg);
        background-position: center;
    }
</style>
@endsection
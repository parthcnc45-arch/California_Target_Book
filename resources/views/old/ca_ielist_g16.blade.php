
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'CA IE Filings (2016 General) | California Target Book')

@section('content')




    <?php

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    $endjava = Array();

    Util::require_ctb_api();

    $conn = Util::get_ctb_conn();


    ini_set('memory_limit', '128M');
    $iespend = Array();
    $candspend = Array();
    $datespend = Array();


    $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD WHERE FILING_ID > '2060000' && FILING_ID <'2116221' && (DIST_NO <> '' || BAL_NUM <> '') && FORM_TYPE = 'F496' ORDER BY FILING_ID DESC, AMEND_ID DESC";
    $result = $conn->query($sql);

    echo("<div class='newseg'>");
    echo("<h1>2016 General Independent Expenditure Filings</h1>");
    echo("<p style='text-align: center; margin-left:auto; margin-right: auto;font-weight: bold; font-size: 14pt;'><a href='#iecont'>Jump to IE Contributors</a></p>");
    echo("<p style='text-align: center; margin-left:auto; margin-right: auto;font-weight: bold; font-size: 14pt;'><a href='#iechart'>Jump to Charts</a></p>");

    $i = 1;

    $iecommittees = Array();

    $thisid = "cmte";

    $js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
});";

    array_push($endjava, $js);

    $tablehead = "
<table id='$thisid' class='table table-striped tablesorter bordered' v-ctb-table>
	<thead>
		<tr>
			<th>CANDIDATE</th>
			<th>AMOUNT</th>
			<th>POSITION</th>
			<th>DIST</th>
			<th>NO</th>
			<th>?</th>
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

    $grandtotal = 0;

//    $iespend = [];
    $candspend = [];
    $iecommittees = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            //echo "<section class='listrow'>";
            $thisfiling = $row['FILING_ID'];

            if ($thisfiling != $lastfiling)
                if ($i <> 0) {

                    $date = getadate($row['FILING_ID']);
                    $tempvar = getamount($row['FILING_ID']);
                    $total = $tempvar['TOTAL'];
                    $title = $tempvar['TITLE'];
                    $filer = $row['FILER_ID'];
                    $filername = $row['FILER_NAML'];
                    $cmte_id = checkxref($row['FILER_ID']);
                    if (!$cmte_id) {
                        $cmte_id = $row['FILER_ID'];
                    }
                    $cmte_lnk = "<a href='http://cal-access.ss.ca.gov/Misc/redirector.aspx?id=" . $cmte_id . "' target='_blank'>" . mb_substr($row['FILER_NAML'], 0, 100) . "</a>";
                    $cm_lnk = "<a href='http://calelections.com/cmlocal2.php?id=" . $cmte_id . "' target='_blank'>?</a>";
                    if ($row['CAND_NAMF']) {
                        $fullname = $row['CAND_NAMF'] . " " . $row['CAND_NAML'];
                        $lastname = $row['CAND_NAML'];
                    } else {
                        $fullname = $row['CAND_NAML'];
                        $pieces = explode(' ', $fullname);
                        $lastname = array_pop($pieces);

                    }

                    $lastname = strtoupper($lastname);
                    $distno = checkaddzero($row['DIST_NO']);

                    $fourcode = retrievefourcode($lastname, $distno);

                    if ($fourcode == "AD71") {
                        continue;
                    }


                    if ($fourcode) {
                        //echo("<br>Found Assembly Race, Adding $total to iespend['$fourcode']<br>");


                        if (!isset($iespend[$fourcode])) {
                            $iespend[$fourcode] = ['AMOUNT' => 0, 'OPP' => 0, 'SUP' => 0, 'DIST' => 0];
                        }
                        if (!isset($candspend[$lastname])) {
                            $candspend[$lastname] = ['AMOUNT' => 0, 'OPP' => 0, 'SUP' => 0, 'NAML' => 0,];
                        }
                        if (!isset($iecommittees[$filer])) {
                            $iecommittees[$filer] = ['AMOUNT' => 0, 'OPP' => 0, 'SUP' => 0, 'NAML' => 0,];
                        }


                        $iespend[$fourcode]['AMOUNT'] += $total;
                        $candspend[$lastname]['AMOUNT'] += $total;
                        $iecommittees[$filer]['FILER_ID'] = $filer;

                        if ($row['SUP_OPP_CD'] == "O") {
                            $iespend[$fourcode]['OPP'] += $total;
                            $candspend[$lastname]['OPP'] += $total;
                            $iecommittees[$filer]['AMOUNT'] += $total;
                            $iecommittees[$filer]['OPP'] += $total;
                            $iecommittees[$filer]['NAML'] = $filername;
                        }
                        if ($row['SUP_OPP_CD'] == "S") {
                            $iespend[$fourcode]['SUP'] += $total;
                            $candspend[$lastname]['SUP'] += $total;
                            $iecommittees[$filer]['AMOUNT'] += $total;
                            $iecommittees[$filer]['SUP'] += $total;
                            $iecommittees[$filer]['NAML'] = $filername;
                        }

                        $iespend[$fourcode]['DIST'] = "$fourcode";
                        $candspend[$lastname]['NAML'] = $lastname;
                    }


                    $name_lnk = "<a href='http://cal-access.ss.ca.gov/Misc/redirector.aspx?id=" . $row['FILER_ID'] . "'' target='_blank'>" . $fullname . "</a>";
                    $filing_lnk = "<a href='http://cal-access.ss.ca.gov/PDFGen/pdfgen.prg?filingid=" . $row['FILING_ID'] . "' target='_blank'>" . $row['FILING_ID'] . "</a>";
                    if ($row['SUP_OPP_CD'] == "O") {
                        $class = 'redme';
                        $status = "OPPOSING";
                    } else {
                        $class = 'greenme';
                        $status = "SUPPORTING";
                    }

                    if ($row['BAL_NUM']) {
                        $juris = $row['BAL_JURIS'];
                        $fullname = $row['BAL_NAME'];
                        $thisnum = $row['BAL_NUM'];
                    } else {
                        $juris = $row['JURIS_CD'];
                        $thisnum = $row['DIST_NO'];
                    }

                    $drawentry .= "
					<tr class='rowsearch' title='$title'>
						<td>" . $fullname . "</td>
						<td>\$$total</td>
						<td class='$class'>$status</td>
						<td>$juris</td>
						<td>$thisnum</td>
						<td>$cm_lnk</td>
						<td>" . $cmte_lnk . "</td>
						<td> $filing_lnk</td>
						<td>$date</td>
					</tr>
					";
                    $grandtotal += $total;

                    if (!array_key_exists($date, $datespend)) {
                        $datespend[$date] = ['AMOUNT' => 0];
                    }

                    $datespend[$date]['AMOUNT'] += $total;
                    $datespend[$date]['DATE'] = $date;
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

    $drawarray = '';
    $totalleg = 0;

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
        $drawarray .= "['$dist', $amount, '$annotation'],";
        $totalleg += $amount;
    }
    $totalleg = number_format($totalleg, 2);

    $supportarray = '';
    $totalsup = 0;
    uasort($iespend, 'supportsort');
    foreach ($iespend as $value) {
        $dist = $value['DIST'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$sup) {
            $sup = "0";
        } else {
            $supportarray .= "['$dist', $sup],";
            $totalsup += $sup;
        }
    }

    $opposearray = '';
    $totalopp = 0;
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
            $opposearray .= "['$dist', $opp],";
            $totalopp += $opp;
        }
    }

    $candsupportarray = '';
    $totalcandsup = 0;
    uasort($candspend, 'supportsort');
    foreach ($candspend as $value) {
        $cand = $value['NAML'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$sup) {
            $sup = "0";
        } else {
            $candsupportarray .= "['$cand', $sup],";
            $totalcandsup += $sup;
        }
    }

    $candopposearray = '';
    $totalcandopp = 0;
    uasort($candspend, 'opposesort');
    foreach ($candspend as $value) {
        $cand = $value['NAML'];
        $amount = $value['AMOUNT'];
        $sup = $value['SUP'];
        $opp = $value['OPP'];
        if (!$opp) {
            $opp = "0";
        } else {
            $candopposearray .= "['$cand', $opp],";
            $totalcandopp += $opp;
        }
    }

    $committeetotalsarray = '';
    $totalleg = 0;
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
        $committeetotalsarray .= "['$dist', $amount, '$annotation'],";
        $totalleg += $amount;
    }

    $datearray = '';
    uasort($datespend, 'datesort');
    foreach ($datespend as $value) {
        $date = $value['DATE'];
        $amount = $value['AMOUNT'];
        //echo("A total of \$" . number_format($amount) . " was logged on $date<br>");
        $datearray .= "['$date', $amount],";
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
 					fontSize: 9
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

            title: 'Independent Expenditure Activity in Legislative Races - \$$totalleg',
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
            		fontSize: 10
              	}
            },
              chartArea: {
            	width: '80%',
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
 					fontSize: 9
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

    echo("<p id='iecont'></p>");

    foreach ($iecommittees as $value) {
        $filer_id = $value['FILER_ID'];
        $xref = checkxref($filer_id);
        if ($xref) {
            $filer_id = $xref;
        }
        $condition = '';
        $filer_name = str_replace("'", "", $value['NAML']);
        //echo("<br>retrieving filings from $filer_id");
        $filings = getallf460($filer_id);

        $i = 0;
        foreach ($filings as $value2) {
            $filing = $value2['FILING_ID'];
            $amend_id = $value2['FILING_SEQUENCE'];
            $end = $value2['RPT_END'];

            if ($end > "2014-12-31") {
                if ($i == 0) {
                    $condition = "(FILING_ID = '$filing' && AMEND_ID = '$amend_id') ";
                    $i++;
                } else {
                    $condition .= " || (FILING_ID = '$filing' && AMEND_ID = '$amend_id') ";
                    $i++;
                }
            }

        }

        if (empty($condition)) {
            continue;
        }

        $sql = "SELECT CTRIB_NAML, CTRIB_NAMF, SUM(AMOUNT) AS AMOUNT
			FROM calaccess_raw_RCPT_CD
			WHERE $condition
			GROUP BY CTRIB_NAMF, CTRIB_NAML
			ORDER BY AMOUNT DESC
			LIMIT 20
	";
        //echo("<br>$sql</br>");

        $filername = $value['NAML'];
        $total = number_format($value['AMOUNT'], 2);
        echo("
            <div class='newseg' style='margin-top: 20px;'>
                <h2>$filer_name - \$$total in 2016</h2>
                <h3>Top Donors Since January 1st, 2015</h3>
        ");

        $result = Util::get_ctb_conn()->query($sql);


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['CTRIB_NAMF']) {
                    $name = $row['CTRIB_NAMF'] . " " . $row['CTRIB_NAML'];
                } else {
                    $name = $row['CTRIB_NAML'];
                }
                echo("<h4 class='boldme'>\$" . number_format($row['AMOUNT'], 2) . " from $name</h4>");

            }
        }
        echo("</div>");
    }


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
        $sql = "SELECT rdist_id FROM ctb2016_rcandidates WHERE lastname LIKE '%$name%' && rdist_id LIKE '%$district%'";
        //echo("<br>$sql<br");
        $result = Util::get_ctb_conn()->query($sql);
        $retval = False;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['rdist_id'];
            }
        }

        //echo("<br>$retval<br>");
        return $retval;

    }

    function getadate($filing)
    {
        $sql = "SELECT FILING_DATE FROM calaccess_raw_FILER_FILINGS_CD WHERE FILING_ID = '$filing'";
        $result = Util::get_ctb_conn()->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILING_DATE'];
            }
        }

        return $retval;
    }

    function checkxref($committee)
    {
        $retval = FALSE;
        $sql = "SELECT FILER_ID FROM calaccess_raw_FILER_XREF_CD WHERE XREF_ID = '$committee' ORDER BY FILER_ID DESC LIMIT 1 ";
        //echo("<br>$sql<br>");
        $result = Util::get_ctb_conn()->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILER_ID'];
            }
        }

        //echo($retval);
        return $retval;
    }

    function getamount($filing)
    {
        $retval = ['TOTAL' => 0, 'TITLE' => ''];

        $highest = gethighestamend($filing);
        $sql = "SELECT AMOUNT, FILING_ID, LINE_ITEM, EXPN_DSCR, AMEND_ID FROM calaccess_raw_S496_CD WHERE FILING_ID = '$filing' && AMEND_ID = '$highest'";
        $result = Util::get_ctb_conn()->query($sql);
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

    .box800 {
        background-image: url(box800.jpg);
        background-position: center;
    }
</style>
@endsection
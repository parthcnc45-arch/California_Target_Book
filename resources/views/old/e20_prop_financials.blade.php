@php ($book_side_nav_active = 'finance')

@extends('layouts.book')


@section('title', '2020 Propositions Financials | California Target Book')

@section('content')



<?php

global $propid_arr, $propno_arr, $prop_cmtes, $cmte_index, $last_reports, $filing_form_index, $filer_filing_form_index, $transactions;

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

//require_once("php/ctb_api.php");
Util::require_ctb_api();


$shorthand = Array(
	"14" => "Stem Cell Bond",
	"15" => "Split Roll",
	"16" => "Affirmative Action",
	"17" => "Felon Voting Rights",
	"18" => "Voting for 17-Year Olds",
	"19" => "Property Tax Portability",
	"20" => "Prop 47/57 Rollback",
	"21" => "Rent Control",
	"22" => "Gig Workers",
	"23" => "Kidney Dialysis",
	"24" => "Consumer Privacy",
	"25" => "Money Bail"
);

$props = get_props();

$endjava = Array();

$js = "	jQuery.tablesorter.addParser({
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

//var_dump($transactions['F460'][2397590]);

unset($transactions['F460'][2487640]); // GET RID OF DUPLICATE FILING
unset($filer_filing_form_index[1421884]['F460'][2487640]);

$count = 0;

$chart_index_arr = Array(
"1422494" => "14_Y",
"1429603" => "14_N",
"1403098" => "15_Y",
"1403027" => "15_N",
"1059890" => "15_N",
"1426379" => "15_N",
"1427286" => "15_N",
"1425738" => "16_Y",
"1427809" => "16_N",
"1428364" => "17_Y",
"1430333" => "18_Y",
"1429714" => "19_Y",
"1400190" => "19_Y",
"1427752" => "19_N",
"1399447" => "20_Y",
"1421110" => "20_N",
"1418902" => "21_Y",
"1421884" => "21_N",
"1426377" => "21_N",
"1422181" => "22_Y",
"1424537" => "22_N",
"1398274" => "23_Y",
"1424580" => "23_N",
"1423771" => "24_Y",
"1428087" => "24_N",
"1430424" => "24_N",
"1422734" => "25_Y",
"1410088" => "25_N"
);

$enddraw = "<div class='content-wrap pt-xl'>";
$active_class = '';
$nav_draw = '';

foreach($propno_arr as $ballot_no => $x) {
    $count++;
    $prop_id = $x['prop_id'];
    $prop_url = "<a href='http://cal-access.sos.ca.gov/Campaign/Measures/Detail.aspx?id=$prop_id&session=2019' target='_blank'>$prop_id</a>";
    $prop_code = $x['prop_no'];
    $prop_dscr = $x['prop_dscr'];

    if($count == 1) {
        //$active_class = 'active';
    } else {
        //$active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$prop_id' role='tab' data-toggle='tab'>
                        <i class='material-icons'>home</i>
                        Prop $ballot_no
                    </a>
                  </li>";



    $enddraw .= "<section id='p$prop_id' class='$active_class'> ";
    $enddraw .= "<div class='prop_div' align='center'>";
    $enddraw .= "<h2>PROP $ballot_no</h2>
          <h4>FPPC# $prop_url<br>$prop_code - $prop_dscr</h4>";
    //var_dump($x);

    foreach($prop_cmtes[$prop_id] as $pc) {
        $cmte_id = $pc['cmte_id'];
        $class = $pc['cmte_position'];
        $cmte_url = "<a href='https://californiatargetbook.com/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>$cmte_id</a>";
        $enddraw .= "<div class='cmte_div'>";
        $enddraw .= "<h5 class='$class'>" . $pc['cmte_nm'] . "<br>" . $pc['cmte_position'] . "<br>" . $cmte_url . "</h5>";
        //$enddraw .= "<br>F460<br>";
	$thisid = 'c' . $cmte_id;


        $f460_table = "<p align='center'>FINANCE REPORTS</p>
                        <table class='f460_table cust_striped'>
                            <thead class='inverse'>
                                <tr>
                                    <th>FILING</th>
                                    <th>MONETARY</th>
                                    <th>NONMONETARY</th>
                                    <th>RCPT</th>
                                    <th>PAYMENTS</th>
                                    <th>ACCRUED</th>
                                    <th>EXPN</th>
                                    <th>COH</th>
                                    <th>DEBT</th>
                                    <th>PD END</th>
                                </tr>
                            </thead>
                            <tbody>";
        $rcpt_tot = 0;
        $expn_tot = 0;   
        $f460_entries = 0;                         
        $pd_end = '';
        $coh = 0;
	if(!empty($filer_filing_form_index[$cmte_id]['F460'])) {
	        foreach($filer_filing_form_index[$cmte_id]['F460'] as $filing_id => $ignore) {

        	    //var_dump($transactions['F460'][$filing_id]);
            
	            $f460_entries++;

        	    $filing_url = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=$filing_id' target='_blank'>$filing_id</a>";

	            $monetary       = $transactions['F460'][$filing_id][1]['AMOUNT_A'];
        	    $nonmonetary    = $transactions['F460'][$filing_id][4]['AMOUNT_A'];
	            $rcpt           = $transactions['F460'][$filing_id][5]['AMOUNT_A'];
        	    $payments       = $transactions['F460'][$filing_id][6]['AMOUNT_A'];
	            $accrued        = $transactions['F460'][$filing_id][9]['AMOUNT_A'];
        	    $expn           = $transactions['F460'][$filing_id][11]['AMOUNT_A'];
	            $debt           = $transactions['F460'][$filing_id][19]['AMOUNT_A'];
	            $coh            = $transactions['F460'][$filing_id][16]['AMOUNT_A'];
	            $pd_end         = $filer_filing_form_index[$cmte_id]['F460'][$filing_id]['RPT_END'];
	            $rcpt_tot += $rcpt;
	            $expn_tot += $expn;

        	    $f460_table .= "<tr>
                                <td>" . $filing_url . "</td>
                                <td align='right'>" . number_format($monetary) . "</td>
                                <td align='right'>" . number_format($nonmonetary) . "</td>
                                <td align='right'>" . number_format($rcpt) . "</td>
                                <td align='right'>" . number_format($payments) . "</td>
                                <td align='right'>" . number_format($accrued) . "</td>
                                <td align='right'>" . number_format($expn) . "</td>
                                <td align='right'>" . number_format($coh) . "</td>
                                <td align='right'>" . number_format($debt) . "</td>
                                <td align='right'>" . $pd_end . "</td>
                            </tr>";


            	//$enddraw .= "$filing_id - ";
	        }
	}
        $f460_table .= "</tbody></table>";

        if($f460_entries < 1) {
            $f460_table = '';
        }


        $since_tot = 0;

	$js = "$(document).ready(function() {
		    $('#$thisid').tablesorter({ 
		            headers: {2: {
						sorter: 'fancyNumber'
					}
				    } 
		        });
		});";
	array_push($endjava, $js);


        $f497_table = "<p align='center'>LATE CONTRIBUTIONS RECEIVED</p>
                        <table class='cust_striped f497_table' id='$thisid'>
                            <thead class='inverse'>
                                <tr>
                                    <th>FILING</th>
                                    <th>TRAN DT</th>
                                    <th>AMOUNT</th>
                                    <th>CONTRIBUTOR</th>
                                    <th>CITY</th>
                                    <th>STATE</th>
                                    <th>EMPLOYER</th>
                                    <th>OCCUPATION</th>
                                </tr>
                            </thead>
                            <tbody>";        

        $f497_entries = 0;

	if(!empty($filer_filing_form_index[$cmte_id]['F497'])) {
        	foreach($filer_filing_form_index[$cmte_id]['F497'] as $filing_id => $ignore) {   
		    if(empty($transactions['F497'][$filing_id])) {
			continue;
		    }
        	    foreach($transactions['F497'][$filing_id] as $t) {
                	$contributor = '';
	                $f497_entries++;

        	        $filing_url = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=$filing_id' target='_blank'>$filing_id</a>";

                	if($t['ENTY_NAML']) {
	                    $contributor = $t['ENTY_NAML'];
        	        }

                	if($t['ENTY_NAMF']) {
	                    $contributor .= ", " . $t['ENTY_NAMF'];
        	        }


	                $f497_table .= "<tr>
                                    <td>" . $filing_url . "</td>
                                    <td>" . $t['CTRIB_DATE'] . "</td>
                                    <td align='right'>" . number_format($t['AMOUNT']) . "</td>
                                    <td>" . $contributor . "</td>
                                    <td>" . $t['ENTY_CITY'] . "</td>
                                    <td>" . $t['ENTY_ST'] . "</td>
                                    <td>" . $t['CTRIB_EMP'] . "</td>
                                    <td>" . $t['CTRIB_OCC'] . "</td>
                                </tr>";
        	        $since_tot += $t['AMOUNT'];
	            }                         
		}
        }
        $f497_table .= "</tbody></table>";


        if($f497_entries < 1) {
            $f497_table = '';
        }

        $enddraw .= "<p align='center'>RAISED: <span class='emph'>\$" . number_format($rcpt_tot + $since_tot) . "</span> (<span class='emph'>\$" . number_format($since_tot) . "</span> Since $pd_end) SPENT: <span class='emph'>\$" . number_format($expn_tot) . "</span> LAST COH: <span class='emph'>\$" . number_format($coh) .  "</span>" . $f460_table . $f497_table . "</p>";
        //$enddraw .= "<br>F497<br>";
 
        $enddraw .= "</div>";

	if (isset($chart_index_arr[$cmte_id])) {
	    $this_prop_no = mb_substr($chart_index_arr[$cmte_id], 0, 2);
	    $this_prop_pos = mb_substr($chart_index_arr[$cmte_id], 3, 1);

	    // Initialize the arrays if they are not already set
	    if (!isset($chart[$this_prop_no])) {
        	$chart[$this_prop_no] = [];
	    }
	    if (!isset($chart[$this_prop_no][$this_prop_pos])) {
        	$chart[$this_prop_no][$this_prop_pos] = 0;
	    }
	    if (!isset($chart[$this_prop_no]['ALL'])) {
        	$chart[$this_prop_no]['ALL'] = 0;
	    }
	    if (!isset($pro_con_tot[$this_prop_pos])) {
        	$pro_con_tot[$this_prop_pos] = 0;
	    }
	    if (!isset($all_propositions)) {
        	$all_propositions = 0;
	    }

	    $chart[$this_prop_no][$this_prop_pos] += ($rcpt_tot + $since_tot);
	    $chart[$this_prop_no]['ALL'] += ($rcpt_tot + $since_tot);

	    $pro_con_tot[$this_prop_pos] += ($rcpt_tot + $since_tot);

	    $all_propositions += ($rcpt_tot + $since_tot);
	}
    }
    $enddraw .=  "</div>";
    $enddraw .= "</section>";
}

$nav_draw .= "<li class='active'>
                <a href='#summary_div' role='tab' data-toggle='tab'>
                    <i class='material-icons'>home</i>
                    Summary
                </a>
              </li>";

$enddraw .= "<section id='summary_div' class='active'> ";
$enddraw .= "<div class='prop_div' align='center'>";
$enddraw .= "<h2>SUMMARY</h2>";
$enddraw .= "<div class='top_block'>";
$enddraw .= "<p align='center' class='bigme boldme'><span style='font-size: 2em'>\$" . 
                number_format($all_propositions) . 
                "</span><br><span style='font-variant: small-caps;'>raised by main November proposition committees in the 2019-2020 election cycle</span><br>SUPPORT: \$" . 
                number_format($pro_con_tot['Y']) . 
                "<br>OPPOSE: \$" . 
                number_format($pro_con_tot['N']) . 
                "</p>";
$i = 14;

$prop_summary_table = "<table class='table-striped table-hover table-responsive prop_table'>
			<thead class='inverse'>
				<tr class='boldme bigme'>
					<th>Proposition</th>
					<th class='rightme'>Supporting</th>
					<th class='rightme'>Opposing</th>
					<th class='rightme'>Total</th>
				</tr>
			</thead>
			<tbody>";
while($i < 26) {
   $p = $chart[$i];
   $dscr = $shorthand[$i];
   $key = "G20 PROP $i";
    if(empty($p['Y'])) {
	$p['Y'] = 0;
    }
    if(empty($p['N'])) {
	$p['N'] = 0;
    }


   $prop_summary_table .= "<tr class='boldme bigme'>	
				<td>Prop $i ($dscr)</td>
				<td align='right'>\$" . number_format($p['Y']) . "</td>
				<td align='right'>\$" . number_format($p['N']) . "</td>
				<td align='right'>\$" . number_format($p['ALL']) . "</td>
				
			   </tr>";

    $annotation = "\$" . number_format($p['ALL']);
    $yes = $p['Y'];
    $no  = $p['N'];
    $tot = $yes + $no;

    $hist_props[$key]['SPENT_SUP'] = $yes;
    $hist_props[$key]['SPENT_OPP'] = $no;
    $hist_props[$key]['SPENT_TOT'] = $tot;
    $hist_props[$key]['DSCR'] = $dscr;

    if(!$no) {
	$no = 0;
    }
    if(!isset($drawtotalspend)) {
	$drawtotalspend = '';
    }
    $drawtotalspend .= "
					['Prop $i', $yes, $no, '$annotation'],
				";

    $i++;
			
}
$totalheader ="\$" . number_format($all_propositions);

$prop_summary_table .= "</tbody></table>";
$enddraw .= $prop_summary_table;
$enddraw .= "</div>";

$past_arr = get_past_props();


$cycle_totals[2008] = Array(
	"SPENT_SUP" => 278431960,
	"SPENT_OPP" => 146294091,
	"SPENT_TOT" => 424726051
);

$cycle_totals[2010] = Array(
	"SPENT_SUP" => 211076379,
	"SPENT_OPP" => 60376576,
	"SPENT_TOT" => 271452955
);

$cycle_totals[2012] = Array(
	"SPENT_SUP" => 259853007,
	"SPENT_OPP" => 173662814,
	"SPENT_TOT" => 433515821
);

$cycle_totals[2014] = Array(
	"SPENT_SUP" => 44224655,
	"SPENT_OPP" => 130043223,
	"SPENT_TOT" => 174267878
);

$cycle_totals[2016] = Array(
	"SPENT_SUP" => 260000728,
	"SPENT_OPP" => 231940734,
	"SPENT_TOT" => 491941462
);

$cycle_totals[2018] = Array(
	"SPENT_SUP" => 132642138,
	"SPENT_OPP" => 230742859,
	"SPENT_TOT" => 363384997,
);

$cycle_totals[2020] = Array(
	"SPENT_SUP" => 11674884,
	"SPENT_OPP" => 0,
	"SPENT_TOT" => 11674884
);




$cycle_totals[2020]['SPENT_SUP'] += $pro_con_tot['Y'];
$cycle_totals[2020]['SPENT_OPP'] += $pro_con_tot['N'];
$cycle_totals[2020]['SPENT_TOT'] += $all_propositions;

uasort($cycle_totals, "totsort");
$cycle_table_body = '';

foreach($cycle_totals as $year => $c) {
	$cycle_table_body .= "<tr>
				<td>$year</td>
				<td align='right'>" . number_format($c['SPENT_SUP']) . "</td>
				<td align='right'>" . number_format($c['SPENT_OPP']) . "</td>
				<td align='right'>" . number_format($c['SPENT_TOT']) . "</td>
			      </tr>";
}

foreach($past_arr as $p) {
	$type = $p['ELECTION'];
	$year = mb_substr($p['YEAR'], 2, 2);
	$elec = $type . $year;
	$prop_no = $p['PROP_NUM'];
	$key = $elec . " PROP $prop_no";
	$hist_props[$key]['SPENT_SUP'] = $p['SPENT_SUP'];
	$hist_props[$key]['SPENT_OPP'] = $p['SPENT_OPP'];
	$hist_props[$key]['SPENT_TOT'] = ($p['SPENT_OPP'] + $p['SPENT_SUP']);
	$hist_props[$key]['DSCR'] = $p['DSCR'];
	$hist_props[$key]['VOTED_YES'] = $p['VOTED_YES'];
	$hist_props[$key]['VOTED_NO'] = $p['VOTED_NO'];

}

uasort($hist_props, "totsort");

$inc = 0;
$hist_table_body = '';
$drawhist = '';
foreach($hist_props as $key => $x) {
	if($inc >= 30) {
		continue;
	}

	if(empty($x['VOTED_YES'])) {
		continue;
	}
	$yes = $x['SPENT_SUP'];
	$no  = $x['SPENT_OPP'];
	$tot = $x['SPENT_TOT'];

	$vote_yes = $x['VOTED_YES'];
	$vote_no  = $x['VOTED_NO'];
	$dscr     = $x['DSCR'];

	if($yes > $no) {
		$yes_class = 'greenme boldme';
		$no_class = '';
	} elseif($no > $yes) {
		$yes_class = '';
		$no_class = 'redme boldme';
	} else {
		$yes_class = '';
		$no_class = '';
	}

	if($vote_yes > $vote_no) {
		$status = "PASSED";
		$stat_class = 'greenme boldme';
	} elseif($vote_no > $vote_yes) {
		$status = "FAILED";
		$stat_class = 'redme boldme';
	} else {
		$status = "N/A";
		$stat_class = '';
	}

	if(!$yes) {
		$yes = 0;
	}

	if(!$no) {
		$no = 0;
	}

	$annotation = '\$' . number_format($tot);
	if(!$tot) {
		$tot = 0;
		$annotation = '$0';
	}

	$hist_table_body .= "<tr>
				<td align='left'>$key</td>
				<td align='left'>" . mb_substr($dscr, 0, 128) . "</td>
				<td align='right' class='$yes_class'>\$" . number_format($yes) . "</td>
				<td align='right' class='$no_class'>\$" . number_format($no) . "</td>
				<td align='right'>\$" . number_format($tot) . "</td>
				<td align='left' class='$stat_class'>$status</td>
			    </tr>";

	$drawhist .= "
			['$key', $yes, $no, '$annotation'],
		     ";

	$inc++;

}




$js = "
       google.load('visualization', '1.0', {'packages':['corechart'], 'callback': drawCharts});


      function drawCharts() {
      	drawTotalStacked();
	drawHistoric();
      }";

array_push($endjava, $js);

$js = "

   function drawTotalStacked() {
      var data = google.visualization.arrayToDataTable([
        ['Prop', 'Support', 'Oppose', {type: 'string', role:'annotation'}],
        $drawtotalspend
      ]);

      var options = {
        title: 'Total Fundraising for November 2020 Propositions - $totalheader',
        backgroundColor: 'none',
        titleTextStyle: {
	       color: '333333',
	       fontName: 'PT Sans Narrow',
	       fontSize: 28
	     },
        annotations: {
        	alwaysOutside: true,
        	textStyle: {
        		color: '333333',
        		fontSize: 15
        	}
        },
        hAxis: {
        	title: 'Total Raised',
        	minValue: 0,
		textStyle: {
		   fontSize: 11
		}
        },
         vAxis: {
        	textStyle: {
        		fontSize: 15
          	}
        },
	legend: { position: 'top', 
		  alignment: 'start', 
		  textStyle: {
			fontSize: 12
		  }
		},
        chartArea: {
        	width: '80%',
        	height: '80%'
        },
        isStacked: true
      };
      var chart = new google.visualization.BarChart(document.getElementById('stacked_total'));
      chart.draw(data, options);
   }";

array_push($endjava, $js);

$js = "

   function drawHistoric() {
      var data = google.visualization.arrayToDataTable([
        ['Prop', 'Support', 'Oppose', {type: 'string', role:'annotation'}],
        $drawhist
      ]);

      var options = {
        title: 'Top Propositions by Amount Spent 2008 - Present (November 2020 Props Calculated by Amount Raised)',
        backgroundColor: 'none',
        titleTextStyle: {
	       color: '333333',
	       fontName: 'PT Sans Narrow',
	       fontSize: 16
	     },
        annotations: {
        	alwaysOutside: true,
        	textStyle: {
        		color: '333333',
        		fontSize: 11
        	}
        },
        hAxis: {
        	title: 'Total Raised',
        	minValue: 0,
		textStyle: {
		   fontSize: 11
		}
        },
         vAxis: {
        	textStyle: {
        		fontSize: 11
          	}
        },
	legend: { position: 'top', 
		  alignment: 'start', 
		  textStyle: {
			fontSize: 12
		  }
		},
        chartArea: {
        	width: '80%',
        	height: '80%'
        },
        isStacked: true
      };
      var chart = new google.visualization.BarChart(document.getElementById('stacked_hist'));
      chart.draw(data, options);
   }";

array_push($endjava, $js);
   

$enddraw .= "<div class='box1200' style='width: 1024px; height: 1200px; text-align: center; margin-left: auto; margin-right: auto;'>";
$enddraw .= "<div class='newseg' id='stacked_total' style='margin-top: 20px; width: 1024px; height: 1200px; border: 2px solid black;'></div>"; 
$enddraw .= "</div>";

$enddraw .= "<div class='smaller_table' align='center'>
		<p align='center'><span class='bigtext' style='font-variant: small-caps'>Top Propositions 2008 - Present by Spending</span><br><h3 align='center'>November 2020 Props Calculated by Amount Raised</h3></p>
		<table class='table-striped table-hover table-responsive tablesorter' align='center'>
			<thead class='inverse'>
				<tr>
					<th class='leftme'>Election/Prop</th>
					<th class='leftme'>Description</th>
					<th class='rightme'>Supporting</th>
					<th class='rightme'>Opposing</th>
					<th class='rightme'>Total</th>
					<th class='leftme'>Status</th>
				</tr>
			</thead>
			<tbody>
			$hist_table_body
			</tbody>
		</table>
	    </div>";

$enddraw .= "<div class='box1800' style='width: 1024px; height: 1800px; text-align: center; margin-left: auto; margin-right: auto;'>";
$enddraw .= "<div class='newseg' id='stacked_hist' style='margin-top: 20px; width: 1024px; height: 1800px; border: 2px solid black;'></div>"; 
$enddraw .= "</div>";

$enddraw .= "<div class='huge_table top_block' align='center'>
		<p align='center'><span class='bigme'>Proposition Spending by Election Cycle (2008 - 2020)</span><br><h3 align='center'>November 2020 Props Calculated by Amount Raised</h3></p>
		<table class='table-striped table-hover table-responsive prop_table'>
			<thead class='inverse'>
				<tr>
					<th>Cycle</th>
					<th class='rightme'>Supporting</th>
					<th class='rightme'>Opposing</th>
					<th class='rightme'>Total</th>
				</tr>
			</thead>
			<tbody>
			$cycle_table_body
			</tbody>
		</table>
	     </div>";


$enddraw .= "</div>";
$enddraw .= "</section>";

//var_dump($chart);

echo("<div class='container-fluid pt-xl'>
        <h1>2020 Proposition Financials</h1>
        <div class='row'>
            <div class='col-lg-10 center-block fn'>
                <nav class='clearfix page-nav'>
                    <ul class='clearfix'>
                        $nav_draw
                    </ul>
                </nav>
            </div>

            $enddraw
        </div>
    </div>");

//echo($enddraw);

function get_past_props() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT id, YEAR, ELECTION, PROP_ID, PROP_NUM, DSCR, VOTED_YES, VOTED_NO, SPENT_SUP, SPENT_OPP FROM ctb_prop_summaries";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$id = $row['id'];
			$retval[$id] = $row;
		}
	}
	return $retval;
	
}

function get_props() {
    global $propid_arr, $propno_arr, $prop_cmtes, $cmte_index, $last_reports, $filing_form_index, $filer_filing_form_index, $transactions;
    $conn = Util::get_ctb_conn();
    $filing_form_index['F460'] = [];
    $filing_form_index['F497'] = [];

    //GET PROPOSITION IDS, INFO
    $sql = "SELECT prop_id, prop_no, CAST(ballot_no AS UNSIGNED) AS ballot_no, prop_dscr, prop_nm, prop_status FROM ctb_ca_props_pending WHERE (ballot_no > 13 && ballot_no < 26) ORDER BY ballot_no";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $ballot_no = $row['ballot_no'];
            $prop_id  = $row['prop_id'];

            $propid_arr[$prop_id] = $row;
            $propno_arr[$ballot_no] = $row;
        }
    }
 



    //GET COMMITTEES
    $query = '';
    foreach($propid_arr as $prop_id => $ignore) {
        $query .= " prop_id = $prop_id ||";
    }
    $query = substr($query, 0, -2);
    $sql = "SELECT * FROM ctb_ca_props_pending_ccl WHERE ( $query )";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cmte_id = $row['cmte_id'];
            $prop_id = $row['prop_id'];

            if(!isset($prop_cmtes[$prop_id])) {
                $prop_cmtes[$prop_id] = Array();
            }

            array_push($prop_cmtes[$prop_id], $row);
            $cmte_index[$cmte_id] = $row;
        }
    }

    //GET ALL SUMMARY AND LATE CONTRIBUTION FILINGS FOR ALL COMMITTEES

    $query = '';

    foreach($cmte_index as $cmte_id => $ignore) {
        $query .= " FILER_ID = $cmte_id ||";
    }
    $query = substr($query, 0, -2);
    $sql = "SELECT * FROM calaccess_raw_FILER_FILINGS_CD WHERE (FORM_ID = 'F460' || FORM_ID = 'F497') && (RPT_START > '2018-12-31' && PERIOD_ID != 0) &&  ( $query ) ORDER BY FILING_ID, FILING_SEQUENCE DESC";
    $result = $conn->query($sql);
    //echo("<br>$sql<br>");
    $last_filing = '';
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $this_filing = $row['FILING_ID'];
            if($this_filing == $last_filing) {
                continue;
            }

            $form_id = $row['FORM_ID'];
            $cmte_id = $row['FILER_ID'];
            $filing_id = $row['FILING_ID'];

            $filer_filing_index[$filing_id] = $cmte_id;
            if($form_id == 'F460') {
                $rpt_end = $row['RPT_END'];
                if(!isset($last_reports[$cmte_id])) {
		     $last_reports[$cmte_id] = $rpt_end;
		} elseif($last_reports[$cmte_id] < $rpt_end) {
                    $last_reports[$cmte_id] = $rpt_end;
                }
            }

            $filer_filing_form_index[$cmte_id][$form_id][$filing_id] = $row;

            $filing_index[$this_filing] = $row;

            if(!isset($filing_form_index[$form_id])) {
                $filing_form_index[$form_id] = $row;
            }
            array_push($filing_form_index[$form_id], $row);
            $last_filing = $this_filing;
        }
    }

    //echo("<br>RETRIEVED " . sizeof($filing_form_index['F460']) . " Summmary Filings, " . sizeof($filing_form_index['F497']) . " Late Contribution Filings");

    //echo("<br>F497 DUMP<br>");
    //var_dump($filing_form_index['F497']);

    //GET SUMMARIES

    $query = '';


    if(!empty($filing_form_index['F460'])) {
    	foreach($filing_form_index['F460'] as $r) {
        	$filing_id = $r['FILING_ID'];
	        $amend_id = $r['FILING_SEQUENCE'];
        	if($filing_id < 5) {
	            continue;
        	}
	        $query .= " (FILING_ID = $filing_id && AMEND_ID = $amend_id) ||";
	    }
	    $query = substr($query, 0, -2);    
	    $sql = "SELECT FILING_ID, AMEND_ID, LINE_ITEM, AMOUNT_A, AMOUNT_B 
            	FROM calaccess_raw_SMRY_CD 
            	WHERE FORM_TYPE = 'F460' && (LINE_ITEM = 1 || LINE_ITEM = 2 || LINE_ITEM = 4 || LINE_ITEM = 5 || LINE_ITEM = 6 || LINE_ITEM = 9 || LINE_ITEM = 11 || LINE_ITEM = 16 || LINE_ITEM = 19) && ( $query )";

    	$result = $conn->query($sql);
	    if($result->num_rows > 0) {
        	while($row = $result->fetch_assoc()) {
	            $filing_id = $row['FILING_ID'];
        	    $line_item = $row['LINE_ITEM'];
            	$transactions['F460'][$filing_id][$line_item] = $row;
	        }
	    }
    } 


    //echo("<br>$sql<br>");


    $query = '';
    $last_date = '';
    if(!empty($filing_form_index['F497'])) {
	    foreach($filing_form_index['F497'] as $r) {
        	$filing_id = $r['FILING_ID'];
	        $amend_id = $r['FILING_SEQUENCE'];
        	if($filing_id < 5) {
	            continue;
        	}
	        $query .= " (FILING_ID = $filing_id && AMEND_ID = $amend_id) ||";
	    }
	    $query = substr($query, 0, -2);

	    $sql = "SELECT * FROM calaccess_raw_S497_CD WHERE FORM_TYPE = 'F497P1' && ( $query )";
	    //echo("<br>$sql<br>");

	    $result = $conn->query($sql);
	    if($result->num_rows > 0) {
        	while($row = $result->fetch_assoc()) {
	            $filing_id = $row['FILING_ID'];
        	    $cmte_id   = $filer_filing_index[$filing_id];
		    if(!empty($last_reports[$cmte_id])) {
		            $last_date  = $last_reports[$cmte_id];
		    } else {
			$last_date = '';
		    }
        	    $tran_date = $row['CTRIB_DATE'];
	            $line_item = $row['LINE_ITEM'];

            	if($tran_date > $last_date) {
                	$transactions['F497'][$filing_id][$line_item] = $row;
	            }                    
        	}
	}
    }






}

function totsort($a, $b) {
  $retval = $b['SPENT_TOT'] <=> $a['SPENT_TOT'];
  return $retval;
}


        ?>

 @endsection
 
 @section('styles')

 <style>

        @import url('https://fonts.googleapis.com/css?family=Lato');
        @import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow');

        .prop_div {
            border: 2px solid black;
            width: 70vw;
            margin-top: 20px;
	    padding: 5px;

        }
	.boldme {
		font-weight: bold;
	}

        .cmte_div {
            margin: 10px;
            border: 2px solid black;
            width: 90%; 
        }

        table {
            font-family: 'PT Sans Narrow';
            line-height: .9em;
        }

        th, td {
            padding-left: 5px;
            padding-right: 5px;
        }

	.bigme {
		font-size: 1.3em !important;
	}

        .inverse {
            background-color: black;
            color: white;
            font-weight: bold;
        }

	.cust_striped tr:nth-child(even) {
		background-color: #f2f2f2;
	}
	

        .f460_table {
            margin: 10px;
	    line-height: 0.9em !important;
        }

        .f497_table {
            margin: 10px;
	    line-height: 0.9em !important;
        }

        .emph {
            font-weight: bold;
            color: blue;
            font-size: 1.2em;
        }

        .SUPPORT {
            font-weight: bold;
            color: green;
        }

        .OPPOSE {
            font-weight: bold;
            color: red;
        }

        h2, h3, h4, h5 {
            font-family: 'Lato';
        }

   .prop_table {
	width: 850px;
	
    }

    .prop_table table {
	line-height: 1em;
     }

    .rightme {
	text-align: right !important;
    }

    .leftme {
	text-align: left !important;
    }

   .top_block {
	display: inline-block;
	border: 2px solid black;
	margin: 5px;
	padding: 5px;

    }

    .bigtext {
	font-size: 2em;
	font-variant: small-caps;
	font-weight: bold;
     }

    .greenme {
	color: green;
	}

    .smaller_table {
	margin-left: auto;
	margin-right: auto;
	border: 2px solid black;
	margin: 5px;
     }

    .huge_table {
	font-size: 2em;
	font-weight: bold;
	margin: 5px;
	border: 2px solid black;
	
    }

   .box1800 {
      background-image: url("/uploaded/box1800.jpg");
      background-position: center;
	}
      border: 2px solid black;
      margin-bottom: 5px;

   .box1200 {
      background-image: url("/uploaded/box1200.jpg");
      background-position: center;
	}

  	.box800 {
      background-image: url("/uploaded/box800.jpg");
      background-position: center;
	}

	.nofloat li {
		float: none;
		clear: both;
		line-height: 1em;
	}

    </style>

@endsection

@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type='text/javascript'>

<?php
	
	foreach($endjava as $value) {
		echo($value);
	}

?>

</script>


@endsection


	
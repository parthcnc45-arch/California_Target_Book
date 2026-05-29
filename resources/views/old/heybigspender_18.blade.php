
@php ($book_side_nav_active = 'finance')
@extends('layouts.book')

@section('title', 'Big Spender | California Target Book')

@section('content')


    <div id="legacy-styles">


    <?php

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    ini_set('memory_limit', '512M');
    $endjava = Array();

    Util::set_errors();
    Util::require_ctb_api();

    $committees = Array();

    $ies = bigspenders();


    foreach ($ies as $ie) {
        $thisid = $ie['spe_id'];
        $thisoff = $ie['can_off'];
        $thisst = $ie['can_off_sta'];
        $thisdist = $ie['can_off_dis'];
        $thisamt = $ie['TOTAL'];
        $thiscand = $ie['can_nam'];
        $thissupopp = $ie['sup_opp'];
        $thiselec = $ie['ele_typ'];

        if ($thisoff == "P") {
            if ($thisst == "00") {
                $thisst = "USA";
            }

            if ($thisdist == "00") {
                $thisdist = $thiscand;
            }
        }

        $committees[$thisid]['Name'] = $ie['spe_nam'];
        $committees[$thisid]['ID'] = $ie['spe_id'];

        if ($thiselec == "P") {

            $committees[$thisid]['Primary'][$thisoff][$thisst][$thisdist][$thissupopp]['TOTAL'] += $thisamt;
            $committees[$thisid]['Primary'][$thisoff][$thisst][$thisdist][$thissupopp]['CAND'] = $thiscand;
            $committees[$thisid]['Primary'][$thisoff][$thisst][$thisdist][$thissupopp]['SUPOPP'] = $thissupopp;
            $committees[$thisid]['Primary'][$thisoff][$thisst][$thisdist][$thissupopp]['ST'] = $thisst;
            $committees[$thisid]['Primary'][$thisoff][$thisst][$thisdist][$thissupopp]['DIST'] = $thisdist;
            $committees[$thisid]['P_Total'] += $thisamt;
            $committees[$thisid]['Total'] += $thisamt;
            $totalprimary += $thisamt;
        }

        if ($thiselec == "G") {

            $committees[$thisid]['General'][$thisoff][$thisst][$thisdist][$thissupopp]['TOTAL'] += $thisamt;
            $committees[$thisid]['General'][$thisoff][$thisst][$thisdist][$thissupopp]['CAND'] = $thiscand;
            $committees[$thisid]['General'][$thisoff][$thisst][$thisdist][$thissupopp]['SUPOPP'] = $thissupopp;
            $committees[$thisid]['General'][$thisoff][$thisst][$thisdist][$thissupopp]['ST'] = $thisst;
            $committees[$thisid]['General'][$thisoff][$thisst][$thisdist][$thissupopp]['DIST'] = $thisdist;
            $committees[$thisid]['General'][$thisoff][$thisst][$thisdist]['DIST'] = $thisdist;
            $committees[$thisid]['G_Total'] += $thisamt;
            $committees[$thisid]['Total'] += $thisamt;
            $totalgeneral += $thisamt;
        }

        $grandtotal += $thisamt;

    }


    uasort($committees, 'totalsort');


    $js = "
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

    echo("<div id='legacy-styles' class='newseg'><h1>\$" . number_format($grandtotal) . " Total Spent in Campaign 2016</h1></div>");

    foreach ($committees as $committee) {

        $tablebody = '';

        $url = "http://www.fec.gov/fecviewer/CommitteeDetailFilings.do?tabIndex=3&candidateCommitteeId=" . $committee['ID'];
        $otherurl = "fediecmtedetail.php?id=" . $committee['ID'];
        $header = "<h1><a href='$otherurl' target='_blank'>" . $committee['Name'] . "</a><br>(FEC #<a href='$url' target='_blank'>" . $committee['ID'] . "</a>)</h1>";
        $header .= "<h1>\$" . number_format($committee['Total']) . " Spent</h1>";

        if ($committee['P_Total'] > 0) {
            $header .= "<h2>\$" . number_format($committee['P_Total']) . " in Primary Election</h2>";
        }

        if ($committee['G_Total'] > 0) {
            $header .= "<h2>\$" . number_format($committee['G_Total']) . " in General Election</h2>";
        }

        $thisid = $committee['ID'];

        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({
	            headers: {
	                3: {
	                    sorter:'fancyNumber'
	                }
	            }
	        });
	});";

        array_push($endjava, $js);

        $tablehead = "
		<table id='$thisid' class='table table-striped bordered tablesorter' v-ctb-table>
			<thead>
				<tr>
					<th>Pri/Gen</th>
					<th>Office</th>
					<th>State/District</th>
					<th>Amount</th>
					<th>Sup/Opp</th>
					<th>Candidate</th>
				</tr>
			</thead>
			<tbody>
	";


        //echo("<br><br>" . $committee['Name'] . " (" . $committee['ID'] . ") Spent \$" . number_format($committee['Total']) . " Total<br>\$" . number_format($committee['P_Total']) . " in the Primary, \$" . number_format($committee['G_Total']) . " in the General<br>");


        foreach ($committee['Primary']['H'] as $state) {

            foreach ($state as $x) {
                foreach ($x as $district) {

                    $fourcode = $district['ST'] . $district['DIST'];
                    $link = "<a href='allfeddetail.php?id=" . $district['ST'] . "' target='_blank'>$fourcode</a>";
                    $amt = $district['TOTAL'];
                    if ($amt < 10) {
                        continue;
                    }
                    $cand = $district['CAND'];
                    $supopp = $district['SUPOPP'];
                    //echo("<br>P16 - $fourcode - \$" . number_format($amt) . " to $supopp $cand");
                    $tablebody .= "
								<tr>
									<td>P</td>
									<td>House</td>
									<td>$link</td>
									<td>" . number_format($amt) . "</td>
									<td>$supopp</td>
									<td>$cand</td>
								</tr>
				";
                }
            }
        }


        foreach ($committee['General']['H'] as $state) {
            foreach ($state as $x) {
                foreach ($x as $district) {
                    $fourcode = $district['ST'] . $district['DIST'];
                    $link = "<a href='allfeddetail.php?id=" . $district['ST'] . "' target='_blank'>$fourcode</a>";
                    $amt = $district['TOTAL'];
                    if ($amt < 10) {
                        continue;
                    }
                    $cand = $district['CAND'];
                    $supopp = $district['SUPOPP'];
                    //echo("<br>G16 - $fourcode - \$" . number_format($amt) . " to $supopp $cand");
                    $tablebody .= "
								<tr>
									<td>G</td>
									<td>House</td>
									<td>$link</td>
									<td>" . number_format($amt) . "</td>
									<td>$supopp</td>
									<td>$cand</td>
								</tr>
				";
                }
            }
        }

        foreach ($committee['Primary']['S'] as $state) {
            foreach ($state as $x) {
                foreach ($x as $district) {
                    $fourcode = $district['ST'] . "SN";
                    $link = "<a href='allfeddetail.php?id=" . $district['ST'] . "' target='_blank'>$fourcode</a>";
                    $amt = $district['TOTAL'];
                    if ($amt < 10) {
                        continue;
                    }
                    $cand = $district['CAND'];
                    $supopp = $district['SUPOPP'];
                    //echo("<br>P16 - $fourcode - \$" . number_format($amt) . " to $supopp $cand");
                    $tablebody .= "
								<tr>
									<td>P</td>
									<td>Senate</td>
									<td>$link</td>
									<td>" . number_format($amt) . "</td>
									<td>$supopp</td>
									<td>$cand</td>
								</tr>
				";
                }
            }
        }

        foreach ($committee['General']['S'] as $state) {
            foreach ($state as $x) {
                foreach ($x as $district) {
                    $fourcode = $district['ST'] . "SN";
                    $link = "<a href='allfeddetail.php?id=" . $district['ST'] . "' target='_blank'>$fourcode</a>";
                    $amt = $district['TOTAL'];
                    if ($amt < 10) {
                        continue;
                    }
                    $cand = $district['CAND'];
                    $supopp = $district['SUPOPP'];
                    //echo("<br>G16 - $fourcode - \$" . number_format($amt) . " to $supopp $cand");
                    $tablebody .= "
								<tr>
									<td>G</td>
									<td>Senate</td>
									<td>$link</td>
									<td>" . number_format($amt) . "</td>
									<td>$supopp</td>
									<td>$cand</td>
								</tr>
				";
                }
            }
        }


        $fourcode = "PRES";
        foreach ($committee['Primary']['P'] as $state) {
            foreach ($state as $x) {
                foreach ($x as $district) {
                    if ($district['ST']) {
                        $fourcode = "PRES-" . $district['ST'];
                    } else {
                        $fourcode = "PRES";
                    }

                    $amt = $district['TOTAL'];
                    if ($amt < 10) {
                        continue;
                    }
                    $cand = $district['CAND'];
                    $supopp = $district['SUPOPP'];
                    //echo("<br>P16 - $fourcode - \$" . number_format($amt) . " to $supopp $cand $appendme");
                    $tablebody .= "
								<tr>
									<td>P</td>
									<td>President</td>
									<td>" . $fourcode . "</td>
									<td>" . number_format($amt) . "</td>
									<td>$supopp</td>
									<td>$cand</td>
								</tr>
				";
                }
            }
        }

        foreach ($committee['General']['P'] as $state) {
            foreach ($state as $x) {
                foreach ($x as $district) {
                    if ($district['ST']) {
                        $fourcode = "PRES-" . $district['ST'];
                    } else {
                        $fourcode = "PRES";
                    }
                    $amt = $district['TOTAL'];
                    if ($amt < 10) {
                        continue;
                    }
                    $cand = $district['CAND'];
                    $supopp = $district['SUPOPP'];
                    //echo("<br>G16 - $fourcode - \$" . number_format($amt) . " to $supopp $cand $appendme");
                    $tablebody .= "
								<tr>
									<td>G</td>
									<td>President</td>
									<td>" . $fourcode . "</td>
									<td>" . number_format($amt) . "</td>
									<td>$supopp</td>
									<td>$cand</td>
								</tr>
				";
                }
            }
        }

        $tableend = "</tbody></table>";

        echo("<div class='newseg' style='margin-top: 20px;'>$header $tablehead $tablebody $tableend </div>");

    }


    function bigspenders()
    {
        global $fec_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();

        $sql = "SELECT spe_nam, spe_id, SUM(replace(replace(exp_amo, ',', ''), '$', '')) AS TOTAL, can_off, can_off_sta, can_off_dis, can_nam, sup_opp, ele_typ, tra_id
			FROM (SELECT * FROM (
					SELECT DISTINCT tra_id, can_off, can_off_sta, can_off_dis, ele_typ, sup_opp, can_par_aff, exp_dat, spe_nam, spe_id, file_num, exp_amo, can_nam, pay
					FROM nufec_ie_18
					ORDER BY file_num DESC) A
	  			  GROUP BY spe_nam, can_off, can_off_sta, can_off_dis, tra_id, exp_dat, pay, can_nam, sup_opp ) B
			GROUP BY spe_nam, can_off, can_off_sta, can_off_dis, sup_opp, can_nam, ele_typ
			ORDER BY TOTAL DESC
	";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp['spe_nam'] = $row['spe_nam'];
                $tmp['spe_id'] = $row['spe_id'];
                $tmp['can_off_sta'] = $row['can_off_sta'];
                $tmp['can_off'] = $row['can_off'];
                $tmp['can_off_dis'] = $row['can_off_dis'];
                $tmp['can_nam'] = $row['can_nam'];
                $tmp['sup_opp'] = $row['sup_opp'];
                $tmp['ele_typ'] = $row['ele_typ'];

                if ($row['ele_typ'] == "S" || $row['ele_typ'] == "R" || $row['ele_typ'] == "O") {
                    $tmp['ele_typ'] = "G";
                }

                $tmp['TOTAL'] = $row['TOTAL'];
                if ($row['can_off'] == "P" && $row['can_off_sta'] == '') {
                    $tmp['can_off_sta'] = "Nationwide";
                    $tmp['can_off_dis'] = "Nationwide";
                }

                if ($tmp['spe_id'] == "C00616078" || $row['TOTAL'] == "0") {
                    continue;
                }
                array_push($retval, $tmp);
            }
        }

        return $retval;
    }

    function totalsort($a, $b)
    {

        if ($a['Total'] < $b['Total']) {
            return 1;
        } elseif ($a['Total'] > $b['Total']) {
            return -1;
        } else {
            return 0;
        }
    }


    ?>

    </div>

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
        background-image: url(/img/ctb_dark.png);
        background-size: 100px 80px;
        background-position: right top;
        background-repeat: no-repeat;

    }

    .ignoreme {
        display: none;
    }

</style>
@endsection
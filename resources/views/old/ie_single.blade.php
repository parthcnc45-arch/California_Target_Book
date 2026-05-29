@extends('layouts.iframe_old')

@section('title', 'IE Single | California Target Book')

@section('content')

    <?php


    ob_start();

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    ini_set('memory_limit', '512M');



    $endjava = Array();
    $final_draw = '';

    Util::set_errors();
    Util::require_ctb_api();

    $iespend = Array();
    $candspend = Array();
    $datespend = Array();

    global $fourcode, $year, $detail_table;
    $fourcode = $_GET['id'];
    $year = $_GET['year'];

    $key_name = "IE_" . $fourcode . "_" . $year;

    if($year != "2018" && $year != "2020") {

        if(Cache::has($key_name)) {
            $final_draw = Cache::get($key_name);
            echo($final_draw);
            //echo("<br>SHOWING CACHED PAGE!");
            exit;
        }
    }

    $e_array[$year] = Array();

    $final_draw = '<link href="/css/legacy.css" rel="stylesheet">';

    $final_draw .= "<div class='container narrow' style='background-color: white; font-family: \"PT Sans Narrow\";'>";

    //echo("<div class='container narrow' style='background-color: white; font-family: \"PT Sans Narrow\";'>");


    //RETRIEVE PRIMARY AND GENERAL ELECTION CANDIDATES

    if($year < "2018") {
        //echo("<br>RETRIEVING NON-2018 CANDIDATES<br>");
        $p_candidates = getprimarycandidates($year);
        $g_candidates = getgeneralcandidates($year);
    } else {
        $p_candidates = get_p18_candidates();
        $g_candidates = get_g18_candidates();
    }

    //echo("<br>PRIMARY CANDIDATES:<br>");
    //var_dump($p_candidates);

    $candidates = [];

    foreach ($p_candidates as $item) {
        $p_vote += $item['VOTES'];
        $name = name_cleanup($item['NAME']);
        $candidates[$name]['NAME'] = $name;
    }

    foreach ($g_candidates as $item) {
        $g_vote += $item['VOTES'];
        $name = name_cleanup($item['NAME']);
        $candidates[$name]['NAME'] = $name;
    }


    //$candidates = fetchcandidates($fourcode);

    //echo("<br>");
    //var_dump($candidates);

    foreach ($candidates as $candidate) {
        $append = '';
        $elections[$year]['YEAR'] = $year;
        foreach ($elections as $election) {
            $yr = $election['YEAR'];
            $append .= " " . $election['YEAR'];
            $tmp['YEAR'] = $yr;
            $tmp['CANDIDATE'] = $candidate['NAME'];

            if (!array_key_exists($yr, $e_array)) {
                $e_array[$yr] = [];
            }

            array_push($e_array[$yr], $tmp);
        }

        if (!$append) {
            //echo("<br>Discarding " . $candidate['NAME'] . ", pre-2006 candidate");
        } else {
            //echo("<br>FOUND IE SPEND FOR " . $candidate['NAME'] . " in $fourcode in $append");
        }


    }

    $enddraw = '';

    foreach ($e_array as $key => $value) {
        $processed = Array();
        $p_vote = 0;
        $g_vote = 0;
        $p_total = 0;
        $g_total = 0;
        $detaildraw = Array();

        $p_candidates = getprimarycandidates($key);
        $g_candidates = getgeneralcandidates($key);

        foreach ($p_candidates as $item) {
            $p_vote += $item['VOTES'];
        }

        foreach ($g_candidates as $item) {
            $g_vote += $item['VOTES'];
        }

        $p_tablebody = '';
        $g_tablebody = '';

        //var_dump($p_candidates);

        $e_tablehead = "<table class='bordered tablesorter tablesaw tablesaw-stack' data-tablesaw-mode='stack'>
						<thead>
							<tr>
								<th>CANDIDATE</th>
								<th>PARTY</th>
								<th>INC</th>
								<th>VOTES</th>
								<th>%</th>
							</tr>
						</thead>
						<tbody>
	";

        foreach ($p_candidates as $candidate) {
            $p_tablebody .= "
							<tr>
								<td>" . $candidate['NAME'] . "</td>
								<td>" . $candidate['PARTY'] . "</td>
								<td>" . $candidate['INC'] . "</td>
								<td>" . $candidate['VOTES'] . "</td>
								<td>" . makepct($candidate['VOTES'], $p_vote) . "</td>

							</tr>
		";
        }

        foreach ($g_candidates as $candidate) {
            $g_tablebody .= "
							<tr>
								<td>" . $candidate['NAME'] . "</td>
								<td>" . $candidate['PARTY'] . "</td>
								<td>" . $candidate['INC'] . "</td>
								<td>" . $candidate['VOTES'] . "</td>
								<td>" . makepct($candidate['VOTES'], $g_vote) . "</td>
							</tr>
		";
        }

        $p_table = $e_tablehead . $p_tablebody . "</tbody></table>";
        $g_table = $e_tablehead . $g_tablebody . "</tbody></table>";

        $e_candidates = "<div style='display: inline-block;' align='center' width='100%'>
						<div style='float: left; margin: 10px; padding: 10px;' width='50%' class='bordered'><p align='center' class='boldme'>PRIMARY ELECTION CANDIDATES</p>
							$p_table
						</div>

						<div style='float: right; margin: 10px; padding: 10px;' width='50%' class='bordered'><p align='center' class='boldme'>GENERAL ELECTION CANDIDATES</p>
							$g_table
						</div>
					</div>
	";

        $endfile = Array();
        $endsum = Array();
        $endsum_draw = '';
        $e_year = $key;
        $i = 0;
        foreach ($value as $cand) {
            if (!$cand['CANDIDATE']) {
                continue;
            }
            //echo("<br>CAND $i - INITIAL:     " . $cand['CANDIDATE']);
            $s496 = getfilingstargeting($cand['CANDIDATE'], $key);
            $thiscand = strtoupper($cand['CANDIDATE']);

            //echo("<br>FILING DUMP:<br>");
            //var_dump($s496);

            foreach ($s496 as $filing) {
                if ($filing['TOTAL']) {
                    //echo("<br>S496 LOOP thiscand = $thiscand<br>");
                    $thisfiling = $filing['FILING_ID'];
                    if ($processed[$thisfiling]) {
                        continue;
                    }
                    $cand_name = $thiscand;

                    $filer_id = $filing['FILER_ID'];
                    $filer_naml = $filing['FILER_NAML'];
                    $filer_namf = $filing['FILER_NAMF'];
                    $g = $filing['G'];
                    $p = $filing['P'];
                    $tot = $filing['TOTAL'];

                    $cx = checkxref($filer_id);
                    if ($cx) {
                        $filer_id = $cx;
                    } else {
                        $filer_id = $filer_id;
                    }

                    if ($filer_namf) {
                        $tmp = $filer_namf . " " . $filer_naml;
                    } else {
                        $tmp = $filer_naml;
                    }

                    $tmp = getcommitteename($filer_id);

                    $f_link = "<a href='/ctb-legacy/cmlocal2.php?id=$filer_id' target='_blank'>$tmp</a>";


                    if ($g) {
                        if ($filing['SUP_OPP_CD'] == "S") {
                            $endsum[$cand_name]['G']['S'] += $filing['TOTAL'];
                            $endsum[$cand_name]['T']['S'] += $filing['TOTAL'];
                            $g_total += $filing['TOTAL'];
                            $detaildraw['G'][$f_link][$cand_name]['S'] += $filing['TOTAL'];
                        }

                        if ($filing['SUP_OPP_CD'] == "O") {
                            $endsum[$cand_name]['G']['O'] += $filing['TOTAL'];
                            $endsum[$cand_name]['T']['O'] += $filing['TOTAL'];
                            $g_total += $filing['TOTAL'];
                            $detaildraw['G'][$f_link][$cand_name]['O'] += $filing['TOTAL'];
                        }
                    }

                    if ($p) {
                        if ($filing['SUP_OPP_CD'] == "S") {
                            $endsum[$cand_name]['P']['S'] += $filing['TOTAL'];
                            $endsum[$cand_name]['T']['S'] += $filing['TOTAL'];
                            $p_total += $filing['TOTAL'];
                            $detaildraw['P'][$f_link][$cand_name]['S'] += $filing['TOTAL'];
                        }

                        if ($filing['SUP_OPP_CD'] == "O") {
                            $endsum[$cand_name]['P']['O'] += $filing['TOTAL'];
                            $endsum[$cand_name]['T']['O'] += $filing['TOTAL'];
                            $p_total += $filing['TOTAL'];
                            $detaildraw['P'][$f_link][$cand_name]['O'] += $filing['TOTAL'];
                        }
                    }

                    $endfile[$filer_id]['FILER_ID'] = $filer_id;
                    $endfile[$filer_id]['TOTAL'] += $filing['TOTAL'];

                    $endfile[$filer_id]['SUP_OPP_CD'] = $filing['SUP_OPP_CD'];
                    //echo("<br>thiscand = $thiscand<br>");
                    if ($filing['SUP_OPP_CD'] == "S") {
                        $endfile[$filer_id]['S_CANDIDATE'] = $thiscand;
                        $endfile[$filer_id]['S_AMOUNT'] += $filing['TOTAL'];
                    } else {
                        $endfile[$filer_id]['O_CANDIDATE'] = $thiscand;
                        $endfile[$filer_id]['O_AMOUNT'] += $filing['TOTAL'];
                    }

                    $endfile[$filer_id]['FILER_NAML'] = $filer_naml;
                    $endfile[$filer_id]['FILER_NAMF'] = $filer_namf;

                    if ($filing['P']) {
                        $endfile[$filer_id]['P'] += $filing['TOTAL'];
                        //echo("<br>" . $filing['TOTAL'] . " spent by " . $filing['FILER_NAML'] . " to " . $filing['SUP_OPP_CD'] . " " . $cand['CANDIDATE'] . " in the Primary");
                    } elseif ($filing['G']) {
                        $endfile[$filer_id]['G'] += $filing['TOTAL'];
                        //echo("<br>" . $filing['TOTAL'] . " spent by " . $filing['FILER_NAML'] . " to " . $filing['SUP_OPP_CD'] . " " . $cand['CANDIDATE'] . " in the General");
                    }
                }


                $processed[$thisfiling] = TRUE;
            }
            $i++;
        }



        foreach ($endsum as $key2 => $value) {
            $endsum_draw .= "<div style='float: left; margin: 10px; padding: 10px;' class='bordered'>";
            $endsum_draw .= "<p>$key2 - \$" . number_format($value['T']['S']) . " Supportive Spending, \$" . number_format($value['T']['O']) . " Opposition Spending</p>";

            if ($value['P']) {
                if ($value['P']['S']) {
                    $endsum_draw .= "<br>\$" . number_format($value['P']['S']) . " Supporting spending in the Primary Election";
                }
                if ($value['P']['O']) {
                    $endsum_draw .= "<br>\$" . number_format($value['P']['O']) . " Opposing spending in the Primary Election";
                }

            }

            if ($value['G']) {
                if ($value['G']['S']) {
                    $endsum_draw .= "<br>\$" . number_format($value['G']['S']) . " Supporting spending in the General Election";
                }
                if ($value['G']['O']) {
                    $endsum_draw .= "<br>\$" . number_format($value['G']['O']) . " Opposing spending in the General Election";
                }

            }
            $endsum_draw .= "</div>";
        }

        //echo("<br>ENDSUM DUMP:<br>");
        //var_dump($endsum);


        uasort($endfile, 'totalsort');

        $tablehead = "<div class='row'>
					<div class='col-lg-12'>
						<table id='$thisid' class='bordered tablesorter tablesaw tablesaw-stack' data-tablesaw-mode='stack'>
							<thead>
								<tr>
									<th align='right'>AMOUNT</th>
									<th>COMMITTEE</th>
									<th align='right'>SUPPORT_AMT</th>
									<th>SUPPORT_CAND</th>
									<th align='right'>OPPOSE_AMT</th>
									<th>OPPOSE_CAND</th>
								</tr>
							</thead>
							<tbody>
	";
        $tablebody = '';

        $s_total = 0;
        $o_total = 0;
        $grand_total = 0;

        foreach ($endfile as $entity) {
            $supporting = '';
            $opposing = '';

            $filer_id = $entity['FILER_ID'];

            if ($pf[$filer_id]) {
                //continue;
                //echo("<br>ABORTING");
            }
            $filer_naml = $entity['FILER_NAML'];
            $filer_namf = $entity['FILER_NAMF'];

            if ($filer_namf) {
                $filer = $filer_namf . " " . $filer_naml;
            } else {
                $filer = $filer_naml;
            }

            $cx = checkxref($filer_id);
            if ($cx) {
                $filer_id = $cx;
            } else {
                $filer_id = $filer_id;
            }

            $filer = "<a href='/ctb-legacy/cmlocal2.php?id=$filer_id' target='_blank'>$filer</a>";

            if ($entity['S_AMOUNT']) {
                $supamt = "$" . number_format($entity['S_AMOUNT'], 2);
            } else {
                $supamt = '';
            }

            if ($entity['O_AMOUNT']) {
                $oppamt = "$" . number_format($entity['O_AMOUNT'], 2);
            } else {
                $oppamt = '';
            }

            $tablebody .= "
							<tr>
								<td align='right'>\$" . number_format($entity['TOTAL'], 2) . "</td>
								<td>" . $filer . "</td>
								<td align='right'>$supamt</td>
								<td>" . $entity['S_CANDIDATE'] . "</td>
								<td align='right'>$oppamt</td>
								<td>" . $entity['O_CANDIDATE'] . "</td>

							</tr>
		";

            $s_total += $entity['S_AMOUNT'];
            $o_total += $entity['O_AMOUNT'];

            $grand_total += $entity['TOTAL'];


            //echo("<br>$filer_naml Spent a Total of " . $entity['TOTAL'] . " ($supporting | $opposing)");
            //$pf[$filer_id] = TRUE;
        }


        if ($totaliespending) {
            if ($totalprimary) {

                $final_draw .= "<div class='row'>
                                    <div class='col-lg-12'>
                                        <p><b style='color: #4B57B1;'>Independent Expenditure Activity in Primary:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING \$" . number_format($totalprimary, 2) . "</b><p>" 
                                        . $endieprimary . 
                                    "</div>
                                </div>";

            }

            if ($totalgeneral) {

                $final_draw .= "<div class='row'>
                                    <div class='col-lg-12'>
                                        <p><b style='color: #4B57B1;'>Independent Expenditure Activity in General:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING \$" . number_format($totalgeneral, 2) . "</b><p>" 
                                        . $endiegeneral . 
                                    "</div>
                                </div>";

            }
        } else

            if ($totaliespending) {

                $final_draw .= "<h1 class='redme'>Total IE Spending: \$" . number_format($totaliespending, 2) . "</h1>";
            }

        if ($grand_total) {
            $enddraw .= "<div class='row' style='margin-top: 10px; padding: 10px;'>";
            $enddraw .= "<div class='col-lg-12'>";
            //$enddraw .= $e_candidates;
            $enddraw .= "<h1>\$" . number_format($grand_total) . "<br>Total Independent Expenditures</h1>";
            $enddraw .= "<h2>\$" . number_format($s_total) . " Supporting, \$" . number_format($o_total) . " Opposing</h2>";
            $enddraw .= "<h2>\$" . number_format($p_total) . " Primary, \$" . number_format($g_total) . " General</h2>";
            $enddraw .= $endsum_draw;
            $enddraw .= $tablehead . $tablebody . "</tbody></table></div></div></div>";

            if ($detaildraw['P']) {
                $enddraw .= "<div class='row' style='margin-top: 10px; padding: 10px;'>
							<div class='col-lg-12'><p><b style='color: #4B57B1;'>Independent Expenditure Activity in Primary:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING \$" . number_format($p_total, 2) . "</b></p>";

                foreach ($detaildraw['P'] as $filer => $candidates) {
                    $enddraw .= "<br>";
                    foreach ($candidates as $candidate => $spend) {
                        if ($spend['S']) {
                            $enddraw .= "<br><b>$filer spent \$" . number_format($spend['S']) . " <span class='greenme'>IN SUPPORT OF</span> $candidate</b>";
                        }

                        if ($spend['O']) {
                            //$enddraw .= "<br>$filer spent \$" . number_format($spend['O']) . " in opposition to $candidate";
                            $enddraw .= "<br><b>$filer spent \$" . number_format($spend['O']) . " <span class='redme'>IN OPPOSITION TO</span> $candidate</b>";

                        }
                    }
                }
                $enddraw .= "</div></div>";
            }

            if ($detaildraw['G']) {
                $enddraw .= "<div class='row' style='margin-top: 10px; padding: 10px;'>
							<div class='col-lg-12'><p><b style='color: #4B57B1;'>Independent Expenditure Activity in General:</b>&nbsp;<b style='color: FireBrick;'>TOTAL IE SPENDING \$" . number_format($g_total, 2) . "</b></p>";

                foreach ($detaildraw['G'] as $filer => $candidates) {
                    $enddraw .= "<br>";
                    foreach ($candidates as $candidate => $spend) {
                        if ($spend['S']) {
                            $enddraw .= "<br><b>$filer spent \$" . number_format($spend['S']) . " <span class='greenme'>IN SUPPORT OF</span> $candidate</b>";
                        }

                        if ($spend['O']) {
                            $enddraw .= "<br><b>$filer spent \$" . number_format($spend['O']) . " <span class='redme'>IN OPPOSITION TO</span> $candidate</b>";

                        }
                    }
                }
                $enddraw .= "</div></div>";
            }
        }


    }

    if ($enddraw) {

        $final_draw .= $enddraw;

        $final_draw .= "<div class='row' align='center'>
                            <div class='col-lg-12'>
                                <input type='button' value='Show Expenditure Detail Table' onclick='toggleTable();'>";

        $js = "function toggleTable() {
			    var lTable = document.getElementById('detail_table');
			    lTable.style.display = (lTable.style.display == 'table') ? 'none' : 'table';
			}
	";
        array_push($endjava, $js);

        $thisid = "ie_detail" . $year;

        $js = "$(document).ready(function() {
	    $('#" . $thisid . "').tablesorter({ sortlist: [0,0]});
	});";

        array_push($endjava, $js);

        $tablediv = "<div class='row' id='detail_table' style='display: none;'>
					<div class='col-lg-12'>
					<table id='$thisid' class='bordered tablesorter tablesaw tablesaw-stack' data-tablesaw-mode='stack'>
						<thead>
							<tr>
								<th>FILER</th>
								<th>EXP DATE</th>
								<th>AMOUNT</th>
								<th>DESCRIPTION</th>
								<th>CANDIDATE</th>
								<th>FILING</th>
							</tr>
						</thead>
						<tbody>
	";

        $tablediv .= $detail_table . "<tbody></table></div>";

        $final_draw .= $tablediv . "</div></div>";


    } else {
        $final_draw .= "<div class='row'><div class='col-lg-12'><p align='center' style='font-family: \"Lato\"; font-size: 1.3em; font-weight: bold; font-variant: small-caps;'>No Independent Expenditures Recorded in $year</p></div></div>";
    }

    //var_dump($e_array);

    $final_draw .= "</div>";

if($year > "2017") {

        $final_draw .= "<div align='center' width='100%'>";
	$short = mb_substr($year, 2, 2);
	$url = "draw_ie_graphs_" . $short . "?id=" . $fourcode;
        $local_js = "
	
	function showCityDiv(z) {

		var url = '/ctb-legacy/$url';

		if(z == 1) {
			document.getElementById('cityDiv').style.display = 'block';
			document.getElementById('btmClose').style.display = 'block';
			document.getElementById('cityHidden').src = url;
		} else {
			document.getElementById('cityDiv').style.display = 'none';
			document.getElementById('btmClose').style.display = 'none';
			document.getElementById('cityHidden').src = '/img/spinner.gif';
		}

	}";

        // echo($local_js);
        array_push($endjava, $local_js);

        $city_detail_div = "
	<p style='margin-top: 20px;'><input name=\"answer\" value=\"Show Graphs\" onclick=\"showCityDiv(1)\" title=\"Show Graphs\" width=\"300px\" type=\"button\" /> <input class=\"close\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<div id=\"cityDiv\" style=\"display:none;\" class=\"answer_list\"><iframe src=\"/img/spinner.gif\" id=\"cityHidden\" height=\"1000px\" width=\"1024px\"></iframe></div>
	<p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"close btmclose\" style=\"display: none;\" id=\"btmClose\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>";

        $final_draw .= $city_detail_div . "</div>";
}

    $final_draw .= '  <script type="text/javascript" src="/js/legacy.js"></script>
                       <script type="text/javascript">';

        foreach ($endjava as $value) {
            $final_draw .= $value;
        }



    $final_draw .= "</script>";

    echo($final_draw);


    $output = ob_get_contents();

    ob_end_clean();

    if($year < 2019) {
        Cache::forever($key_name, $output);
    }

   echo($output);    

    
    function totalsort($a, $b)
    {

        if ($a['TOTAL'] < $b['TOTAL']) {
            return 1;
        } elseif ($a['TOTAL'] > $b['TOTAL']) {
            return -1;
        } else {
            return 0;
        }
    }


    function lookupelections($naml)
    {
        global $fourcode;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $x = getdisttype($fourcode);
        $disttype = $x['disttype'];
        $distno = $x['distno'];

        $sql = "SELECT * FROM ctb2016_candidates WHERE name LIKE '%$naml%' && disttype = '$disttype' && distnum = $distno";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $year = "20" . mb_substr($row['election'], 1, 2);
                $retval[$year]['YEAR'] = $year;
            }
        }

        return $retval;
    }

    function getfilingstargeting($naml, $year)
    {
        global $calaccess_conn;
        global $fourcode;
        global $detail_table;
        $conn = Util::get_ctb_conn();
        $filings = Array();
        $dist_no = mb_substr($fourcode, 2, 2);
        $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD
			WHERE DIST_no = $dist_no && FORM_TYPE = 'F496' && CAND_NAML LIKE '%$naml%' ORDER BY FILING_ID DESC, AMEND_ID DESC";

        if(mb_substr($fourcode, 0, 1) == ".") {
            $type = mb_substr($fourcode, 1, 3);
            switch($type) {
                case "GOV":
                    $type = "GOV";
                    break;
                case "LTG":
                    $type = "LTG";
                    break;
                case "ATG":
                    $type = "ATT";
                    break;
                case "SOS":
                    $type = "SOS";
                    break;
                case "CON":
                    $type = "CON";
                    break;
                case "INS":
                    $type = "INS";
                    break;
                case "SPI":
                    $type = "SUP";
                    break;
                case "TRS":
                    $type = "TRE";
                    break;
            }
            $sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD 
                    WHERE CONCAT(CAND_NAMF, ' ', CAND_NAML) LIKE '%" . $naml . "%' && 
                          FORM_TYPE = 'F496' && 
                          OFFICE_CD = '$type' 
                    ORDER BY FILING_ID DESC, AMEND_ID DESC";
            $thisdist = '';
        }

	if(mb_substr($fourcode, 0, 3) == "BOE") {
		$type = "BOE";
		$dist_no = mb_substr($fourcode, 3, 1);
        	$sql = "SELECT * FROM calaccess_raw_CVR_CAMPAIGN_DISCLOSURE_CD
			WHERE DIST_no = $dist_no && 
			      OFFICE_CD = '$type' &&
			      FORM_TYPE = 'F496' && 
			      CAND_NAML LIKE '%$naml%' 
			ORDER BY FILING_ID DESC, AMEND_ID DESC";
	}

        //echo("<br>$sql");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $thisfiling = $row['FILING_ID'];


                if ($thisfiling == $lastfiling) {
                    $lastfiling = $thisfiling;
                    continue;
                } else {

                    $filing = $row['FILING_ID'];
                    $filings[$filing]['FILING_ID'] = $filing;
                    $filings[$filing]['CAND_NM'] = $naml;
                    $filings[$filing]['FILER_ID'] = $row['FILER_ID'];
                    $filings[$filing]['FILING_ID'] = $row['FILING_ID'];
                    $filings[$filing]['AMEND_ID'] = $row['AMEND_ID'];
                    $filings[$filing]['FILER_NAML'] = $row['FILER_NAML'];
                    $filings[$filing]['FILER_NAMF'] = $row['FILER_NAMF'];
                    $filings[$filing]['SUP_OPP_CD'] = $row['SUP_OPP_CD'];


                }
                $lastfiling = $thisfiling;
            }
        }
        //echo("<br>FOUND FILINGS:<br>");
        //var_dump($filings);

        foreach ($filings as $value) {

            $thisfiling = $value['FILING_ID'];
            $amend = gethighestamend($thisfiling);


            $sql = "SELECT * FROM calaccess_raw_S496_CD WHERE FILING_ID = '" . $value['FILING_ID'] . "' && AMEND_ID = '$amend' ORDER BY LINE_ITEM";

            if ($thisfiling == "2088635") {
                //echo("<br>PROCESSING FILING $thisfiling<br>");
                //echo("<br>$sql<br>");
            }
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
		    $start_year = $year - 1;
                    $expdate = $row['EXP_DATE'];
                    if ($expdate > "$year-12-31" || $expdate < "$start_year-01-01") {
                        //echo("<br>FOUND EXP DATE OF $expdate OUTSIDE $year, SKIPPING");
                        continue;
                    } else {
                        //echo("<br>Adding " . $row['AMOUNT'] . " to filings[$thisfiling]['TOTAL']" );

			if($fourcode == "AD01" && ($year == 2019 || $year == 2020) && $thisfiling < 2400000) {
				continue;
			}

                        if ($value['FILER_NAMF']) {
                            $filer_name = $value['FILER_NAMF'] . " " . $value['FILER_NAML'];
                        } else {
                            $filer_name = $value['FILER_NAML'];
                        }

                        $filer_lnk = "<a href='/ctb-legacy/cmlocal2.php?id=" . $value['FILER_ID'] . "' target='_blank'>$filer_name</a>";
                        $filing_lnk = "<a href='http://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=$thisfiling' target='_blank'>$thisfiling</a>";
                        if ($value['SUP_OPP_CD'] == "S") {
                            $cand_span = "<span class='greenme'>+" . $value['CAND_NM'] . "</span>";
                        } else {
                            $cand_span = "<span class='redme'>-" . $value['CAND_NM'] . "</span>";
                        }
                        $detail_table .= "
						<tr>
							<td>$filer_lnk</td>
							<td>$expdate</td>
							<td align='right'>" . $row['AMOUNT'] . "</td>
							<td>" . $row['EXPN_DSCR'] . "</td>
							<td>$cand_span</td>
							<td>$filing_lnk</td>
						</tr>

					";


                        $filings[$thisfiling]['TOTAL'] += $row['AMOUNT'];
                        if ($expdate > "$year-06-15") {
                            $filings[$thisfiling]['G'] += $row['AMOUNT'];
                        } else {
                            $filings[$thisfiling]['P'] += $row['AMOUNT'];
                        }
                    }
                }
            }

        }

        return $filings;


    }

    function getelectionresults($election, $distkey)
    {
        global $fourcode;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $x = getdisttype($fourcode);
        $disttype = $x['disttype'];
        $distno = $x['distno'];
        $sql = "SELECT SUM($distkey) AS VOTES FROM ctb2016_$election WHERE $disttype = $distno";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['VOTES'];
            }
        }

        return $retval;

    }

    function get_p18_candidates() {
        global $fourcode, $year;
	$short = mb_substr($year, 2, 2);

	$this_table = "calaccess_raw_e" . $short . "_comm";
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $sql = "SELECT namf, naml, party FROM $this_table WHERE FOURCODE = '$fourcode' && hide != '1'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $tmp['NAME'] = $row['namf'] . " " . $row['naml'];
                $tmp['PARTY'] = $row['party'];
                array_push($retval, $tmp);

            }
        }
        return $retval;
    }

    function get_g18_candidates() {
        global $fourcode, $year;
	$short = mb_substr($year, 2, 2);
	$this_table = "calaccess_raw_e" . $short . "_comm";
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $sql = "SELECT namf, naml, party FROM $this_table WHERE FOURCODE = '$fourcode' && hide != '1'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $tmp['NAME'] = $row['namf'] . " " . $row['naml'];
                $tmp['PARTY'] = $row['party'];
                array_push($retval, $tmp);

            }
        }
        return $retval;
    }

    function getgeneralcandidates($year)
    {
        global $fourcode;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $year = mb_substr($year, 2, 2);
        $election = "g" . $year;
        if(mb_substr($fourcode, 0, 1) == ".") {
            $office = mb_substr($fourcode, 1, 3);
            $sql = "SELECT * FROM ctb_ca_candidates WHERE election = '$election' && race LIKE '$office%' ";
        } else {
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            $sql = "SELECT * FROM ctb_ca_candidates where disttype = '$disttype' && distnum = $distno && election = '$election'";
        }      
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp['NAME'] = $row['name'];
                $tmp['PARTY'] = $row['party'];
                $tmp['INC'] = $row['is_incumbent'];
                $distkey = $row['distkey'];
                $tmp['VOTES'] = getelectionresults($election, $distkey);
                array_push($retval, $tmp);
            }
        }

        return $retval;
    }

    function getprimarycandidates($year)
    {
        global $fourcode;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $year = mb_substr($year, 2, 2);
        $election = "p" . $year;

        if(mb_substr($fourcode, 0, 1) == ".") {
            $office = mb_substr($fourcode, 1, 3);
            $sql = "SELECT * FROM ctb_ca_candidates WHERE election = '$election' && race LIKE '$office%' ";
        } else {
            $x = getdisttype($fourcode);
            $disttype = $x['disttype'];
            $distno = $x['distno'];
            $sql = "SELECT * FROM ctb_ca_candidates where disttype = '$disttype' && distnum = $distno && election = '$election'";
        }

        //echo("<br>" . $sql . "<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp['NAME'] = $row['name'];
                $tmp['PARTY'] = $row['party'];
                $tmp['INC'] = $row['is_incumbent'];
                $distkey = $row['distkey'];
                $tmp['VOTES'] = getelectionresults($election, $distkey);
                array_push($retval, $tmp);
            }
        }

        return $retval;
    }

    function checkxref($committee)
    {
        global $calaccess_conn;
        $conn = Util::get_ctb_conn();
        $retval = FALSE;
        $sql = "SELECT FILER_ID FROM calccess_raw_FILER_XREF_CD WHERE XREF_ID = '$committee' ORDER BY FILER_ID DESC LIMIT 1 ";
        //echo("<br>$sql<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILER_ID'];
            }
        }

        //echo($retval);
        return $retval;
    }


    function name_cleanup($name)
    {
        //echo("<br>Processing $name...Removing *....");
        $tmp_nm = rtrim($name, "*");        //REMOVE INCUMBENT ASTERICKS
        //echo($tmp_nm . "...Uppercase...");
        $tmp_nm = strtoupper($tmp_nm);        //MAKE ALL UPPERCASE
        //echo($tmp_nm . "...Jr...");
        $tmp_nm = str_replace(", JR.", "", $tmp_nm);  //THEN REMOVE INSTANCES OF JR., SR., II, and III
        //echo($tmp_nm . "...Sr...");
        $tmp_nm = str_replace(", SR.", "", $tmp_nm);
        //echo($tmp_nm . "...II...");
        $tmp_nm = str_replace(" II", "", $tmp_nm);
        //echo($tmp_nm . "...III...");
        $tmp_nm = str_replace(" III", "", $tmp_nm);
        $tmp_nm = str_replace(",", "", $tmp_nm);
        //echo("...Extracting Last Name...");

        $regex = '~.*\s(.*)~';
        preg_match($regex, $tmp_nm, $results);

        //echo("Returning " . trim($results[1]));
        return trim($results[1]);
    }

    ?>


@endsection

@section('scripts')



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

    .narrow {
        font-family: 'PT Sans Narrow';
    }
</style>


@endsection
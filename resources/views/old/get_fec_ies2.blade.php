@extends('layouts.iframe_old')

@section('title', 'FEC IES | California Target Book')

@section('content')


    <div class="container">
        <?php

        Util::set_errors();
        Util::require_ctb_api();

        //error_reporting(E_ALL);
        //ini_set('display_errors', '1');
        setlocale(LC_COLLATE, "en_US");
        setlocale(LC_CTYPE, "en_US");
        
        $ie_cmte = Array();
        $ie_cands = Array();

        global $year, $fourcode, $election, $ie_cmte, $ie_cmte_cands;
        $year = $_GET['yr'];
        $fourcode = $_GET['id'];
        $election = $_GET['type'];

	if(mb_substr($fourcode, 0, 2) == "CD") {
		$fourcode = "CA" . mb_substr($fourcode, 2, 3);
	}

        global $endtable, $endjava;

        if(!$endjava) {
            $endjava = Array();
        }
        $endtable = [];

        $key_name = "IE_" . $fourcode . "_" . $year;

	
        if(Cache::has($key_name)) {
            $final_draw = Cache::get($key_name);
            echo($final_draw);
            //echo("<br>SHOWING CACHED PAGE!");
            exit;
        }       

        /*

        $js = "jQuery.tablesorter.addParser({
              id: \"fancyNumber\",
              is: function(s) {
                return /^[0-9]?[0-9,\.]*$/.test(s);
              },
              format: function(s) {
                return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') );
              },
              type: \"numeric\"
            });";
    
        array_push($endjava, $js);
        */

        ob_start() ;

        echo('<link href="/css/legacy.css" rel="stylesheet">');

        $lastnames = getlastnames();

        foreach ($lastnames as $naml) {
            $x = lookupthisie($fourcode, $naml);
            $n[$naml]['gs'] = $x['GEN_TOTAL_S'];
            $n[$naml]['go'] = $x['GEN_TOTAL_O'];
            $n[$naml]['ps'] = $x['PRI_TOTAL_S'];
            $n[$naml]['po'] = $x['PRI_TOTAL_O'];


            $primary_combined += $x['PRI_TOTAL_S'];
            $primary_combined += $x['PRI_TOTAL_O'];

            $general_combined += $x['GEN_TOTAL_S'];
            $general_combined += $x['GEN_TOTAL_O'];

            $special_combined += $x['SPC_TOTAL_S'];
            $special_combined += $x['SPC_TOTAL_O'];

        }

        foreach ($ie_cands as $team) {
            $naml = $team['cand_nm'];
            if (!$team1) {
                $team1['S']['cand_nm'] = $naml;
                $team2['O']['cand_nm'] = $naml;

                $team1['P']['amt'] += $n[$naml]['ps'];
                $team2['P']['amt'] += $n[$naml]['po'];

                $team1['G']['amt'] += $n[$naml]['gs'];
                $team2['G']['amt'] += $n[$naml]['go'];

                continue;
            } elseif (!$team2['S']) {
                $team2['S']['cand_nm'] = $naml;
                $team1['O']['cand_nm'] = $naml;

                $team2['P']['amt'] += $n[$naml]['ps'];
                $team1['P']['amt'] += $n[$naml]['po'];

                $team2['G']['amt'] += $n[$naml]['gs'];
                $team1['G']['amt'] += $n[$naml]['go'];

            }
        }

        if ($team2['G']['amt'] > 0 || $team1['G']['amt'] > 0) {

            $c1 = $team1['S']['cand_nm'];
            $c2 = $team2['S']['cand_nm'];

            if ($team1['G']['amt'] > 0) {
                $general_summary = "<br>Team $c1 Spent \$" . number_format($team1['G']['amt']) . " in the General Election ";
                if ($n[$c1]['gs'] > 0 && $n[$c2]['go'] > 0) {
                    $general_summary .= "Supporting $c1 (\$" . number_format($n[$c1]['gs']) . ") and Opposing $c2 (\$" . number_format($n[$c2]['go']) . ")";
                } elseif ($n[$c2]['go'] > 0) {
                    $general_summary .= "Opposing $c2 (\$" . number_format($n[$c2]['go']) . ")";
                } else {
                    $general_summary .= "Supporting $c1 (\$" . number_format($n[$c1]['gs']) . ")";
                }
            }

            if ($team2['G']['amt'] > 0) {
                $general_summary .= "<br>Team $c2 Spent \$" . number_format($team2['G']['amt']) . " in the General Election ";
                if ($n[$c2]['gs'] > 0 && $n[$c1]['go'] > 0) {
                    $general_summary .= "Supporting $c2 (\$" . number_format($n[$c2]['gs']) . ") and Opposing $c1 (\$" . number_format($n[$c1]['go']) . ")";
                } elseif ($n[$c1]['go'] > 0) {
                    $general_summary .= "Opposing $c1 (\$" . number_format($n[$c1]['go']) . ")";
                } else {
                    $general_summary .= "Supporting $c2 (\$" . number_format($n[$c2]['gs']) . ")";
                }
            }

        }

        if ($team2['P']['amt'] > 0 || $team1['P']['amt'] > 0) {

            $c1 = $team1['S']['cand_nm'];
            $c2 = $team2['S']['cand_nm'];

            if ($team1['P']['amt'] > 0) {
                $primary_summary = "<br>Team $c1 Spent \$" . number_format($team1['P']['amt']) . " in the Primary ";
                if ($n[$c1]['ps'] > 0 && $n[$c2]['po'] > 0) {
                    $primary_summary .= "Supporting $c1 (\$" . number_format($n[$c1]['ps']) . ") and Opposing $c2 (\$" . number_format($n[$c2]['po']) . ")";
                } elseif ($n[$c2]['po'] > 0) {
                    $primary_summary .= "Opposing $c2 (\$" . number_format($n[$c2]['po']) . ")";
                } else {
                    $primary_summary .= "Supporting $c1 (\$" . number_format($n[$c1]['ps']) . ")";
                }
            }

            if ($team2['P']['amt'] > 0) {
                $primary_summary .= "<br>Team $c2 Spent \$" . number_format($team2['P']['amt']) . " in the Primary ";
                if ($n[$c2]['ps'] > 0 && $n[$c1]['po'] > 0) {
                    $primary_summary .= "Supporting $c2 (\$" . number_format($n[$c2]['ps']) . ") and Opposing $c1 (\$" . number_format($n[$c1]['po']) . ")";
                } elseif ($n[$c1]['po'] > 0) {
                    $primary_summary .= "Opposing $c1 (\$" . number_format($n[$c1]['po']) . ")";
                } else {
                    $primary_summary .= "Supporting $c2 (\$" . number_format($n[$c2]['ps']) . ")";
                }
            }
        }

        /*
        echo("T1 DUMP:<br>");
        var_dump($team1);

        echo("<br>T2 DUMP:<br>");
        var_dump($team2);

        echo("<br>N DUMP:<br>");
        var_dump($n);
        */

        //echo($primary_summary . $general_summary);


        $tablebody = $x['HTML'];


        $grand_total = $primary_combined + $general_combined;
        if ($grand_total > 0) {
            $ie_draw = "<div class='newseg' style='font-weight: bold;'>";
            $ie_draw .= "<h1>\$" . number_format($grand_total, 2) . "<br>Total $year Independent Expenditures</h1>";
        } elseif ($special_combined > 0) {
            $ie_draw = "<div class='newseg' style='font-weight: bold;'>";
            $ie_draw .= "<h1>\$" . number_format($special_combined, 2) . "<br>Total $year Special Election Independent Expenditures</h1>";
        }

        //var_dump($ie_cmte_cands);

        if ($primary_combined > 0) {
            //DRAW PRIMARY EXPENDITURES
            uasort($ie_cmte, 'primary_sort');
            $sup_span = '';
            $opp_span = '';
            $ie_draw .= "<p style='font-family: \"PT Sans Narrow\";' class='boldme'><span style='color: FireBrick;'>TOTAL $year PRIMARY ELECTION INDEPENDENT EXPENDITURES</span> - \$" . number_format($primary_combined, 2) . "<br><br>$primary_summary</p>";
            foreach ($ie_cmte as $x) {
                $cmte_id = $x['cmte_id'];
                $cmte_span = '';
                $sup_span = '';
                $opp_span = '';
                $cmte_lnk = "<a href='http://198.74.49.22/fec_cmte_report.php?cycle=$year&id=" . $x['cmte_id'] . "' target='_blank'>" . $x['cmte_nm'] . "</a>";

                foreach($ie_cmte_cands[$cmte_id] as $cand => $cmte) {
                    if($cmte['ps_amount']) {
                        $sup_span .= "<br>" . $cmte_lnk . " Spent \$" . number_format($cmte['ps_amount'], 2) . " <span class='greenme'>To Support</span> " . $cand; 
                    }

                    if($cmte['po_amount']) {
                        $opp_span .= "<br>" . $cmte_lnk . " Spent \$" . number_format($cmte['po_amount'], 2) . " <span class='redme'>To Oppose</span> " . $cand;
                    }                       
                        
                }
                if($sup_span || $opp_span) {
                     $cmte_span = "<br>" . $sup_span . $opp_span;
                }
                $p_draw .= $cmte_span;
            }
            
        }

        if($p_draw) {
            $ie_draw .= $p_draw . "<hr />";
        }


        if ($general_combined > 0) {
            //DRAW PRIMARY EXPENDITURES
            uasort($ie_cmte, 'general_sort');
            $ie_draw .= "<p style='font-family: \"PT Sans Narrow\";' class='boldme'><span style='color: FireBrick;'>TOTAL $year GENERAL ELECTION INDEPENDENT EXPENDITURES</span> - \$" . number_format($general_combined, 2) . "<br><br>$general_summary</p>";
            $sup_span = '';
            $opp_span = '';           
            foreach ($ie_cmte as $x) {
                $cmte_id = $x['cmte_id'];
                $cmte_span = '';
                $sup_span = '';
                $opp_span = '';
                $cmte_lnk = "<a href='http://198.74.49.22/fec_cmte_report.php?cycle=$year&id=" . $x['cmte_id'] . "' target='_blank'>" . $x['cmte_nm'] . "</a>";

                foreach($ie_cmte_cands[$cmte_id] as $cand => $cmte) {
                    if($cmte['gs_amount']) {
                        $sup_span .= "<br>" . $cmte_lnk . " Spent \$" . number_format($cmte['gs_amount'], 2) . " <span class='greenme'>To Support</span> " . $cand; 
                    }

                    if($cmte['go_amount']) {
                        $opp_span .= "<br>" . $cmte_lnk . " Spent \$" . number_format($cmte['go_amount'], 2) . " <span class='redme'>To Oppose</span> " . $cand;
                    }                       
                        
                }
                if($sup_span || $opp_span) {
                    $cmte_span = "<br>" . $sup_span . $opp_span;
                }
                $g_draw .= $cmte_span;
            }
        }

        if($g_draw) {
             $ie_draw .= $g_draw;
        }

        if ($special_combined > 0) {
            //DRAW PRIMARY EXPENDITURES
            uasort($ie_cmte, 'special_sort');
            $ie_draw .= "<p style='font-family: \"PT Sans Narrow\";' class='boldme'><span style='color: FireBrick;'>TOTAL $year SPECIAL ELECTION INDEPENDENT EXPENDITURES</span> - \$" . number_format($special_combined, 2) . "<br><br>$special_summary</p>";
            $sup_span = '';
            $opp_span = '';           
            foreach ($ie_cmte as $x) {
                $cmte_id = $x['cmte_id'];
                $cmte_span = '';
                $sup_span = '';
                $opp_span = '';
                $cmte_lnk = "<a href='http://198.74.49.22/fec_cmte_report.php?cycle=$year&id=" . $x['cmte_id'] . "' target='_blank'>" . $x['cmte_nm'] . "</a>";



                foreach($ie_cmte_cands[$cmte_id] as $cand => $cmte) {
                    if($cmte['ss_amount']) {
                        $sup_span .= "<br>" . $cmte_lnk . " Spent \$" . number_format($cmte['ss_amount'], 2) . " <span class='greenme'>To Support</span> " . $cand; 
                    }

                    if($cmte['so_amount']) {
                        $opp_span .= "<br>" . $cmte_lnk . " Spent \$" . number_format($cmte['so_amount'], 2) . " <span class='redme'>To Oppose</span> " . $cand;
                    }                       
                        
                }
                if($sup_span || $opp_span) {
                    $cmte_span = "<br>" . $sup_span . $opp_span;
                }
                $s_draw .= $cmte_span;
            }
        }

        if($s_draw) {
            $ie_draw .= $s_draw;
        }


        if ($ie_draw) {
            echo($ie_draw);

          $thisid = "IE_TABLE_$year";

          $js = "$(document).ready(function() {
              $('#" . $thisid . "').tablesorter(
                    

                    {            
                    headers: {
                     
                     //2: { sorter: 'thousands' },
                     6: { sorter:  'text'  }, 

                    }
            });
          });

        $.tablesorter.addParser({ 
            id: 'thousands',
            is: function(s) { 
                return false; 
            }, 
            format: function(s) {
                return s.replace('$','').replace(/,/g,'');
            }, 
            type: 'numeric' 
        }); 

        $.tablesorter.addParser({
              id: 'fancyNumber',
              is: function(s) {
                return /^[0-9]?[0-9,\.]*$/.test(s);
              },
              format: function(s) {
                return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') );
              },
              type: 'numeric'
            });

";
        array_push($endjava, $js);


            echo("<div class='newseg'>
		<table class='bordered tablesorter tablesaw tablesaw-stack' data-tablesaw-mode='stack' style='font-weight: normal;' id='$thisid'>
			<thead class='thead-inverse inverse'>
				<tr>
					<th>ELECTION</th>
					<th>CMTE</th>
					<th class=\"{sorter: 'digit'}\">AMT</th>
					<th>TARGET</th>
					<th>DESCRIPTION</th>
					<th>PAYEE</th>
					<th>EXP DATE</th>
					<th>FILING</th>
				</tr>
			</thead>
			<tbody>" . $endtable['HTML'] . "</table></div>");

            if($year >= 2017) {

                    $final_draw .= "<div align='center' width='100%'>";
		    $short_year = mb_substr($year, 2, 2);
                    $local_js = "
                
                function showCityDiv(z) {

                    var url = '/ctb-legacy/draw_ie_graphs_" . $short_year . "?id=$fourcode';

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
                    echo($final_draw);
            }


        } else {
            echo("<p style='font-size: 1.3em; font-variant: small-caps; font-family: \"Lato\";' align='center'>No $year Independent Expenditures Recorded</p>");
        }


        $output = ob_get_contents();

        ob_end_clean();

        if($year < 2020) {
            Cache::forever($key_name, $output);
        }

        echo($output);        


        function primary_sort($a, $b)
        {

            if ($a['p'] < $b['p']) {
                return 1;
            } elseif ($a['p'] > $b['p']) {
                return -1;
            } else {
                return 0;
            }
        }

        function general_sort($a, $b)
        {

            if ($a['g'] < $b['g']) {
                return 1;
            } elseif ($a['g'] > $b['g']) {
                return -1;
            } else {
                return 0;
            }
        }

        function total_sort($a, $b)
        {

            if ($a['t'] < $b['t']) {
                return 1;
            } elseif ($a['t'] > $b['t']) {
                return -1;
            } else {
                return 0;
            }
        }

        function special_sort($a, $b)
        {

            if ($a['s'] < $b['s']) {
                return 1;
            } elseif ($a['s'] > $b['s']) {
                return -1;
            } else {
                return 0;
            }
        }


        


        function lookupthisie($fourcode, $lastname)
        {
            global $fec_conn;
            global $ie_cmte;
            global $ie_cmte_cands;
            global $logger;
            global $endtable;
            global $year;
            global $ie_cands;

	    $this_shortyear = mb_substr($year, 2, 2);

	    $table = "nufec_ie_" . $this_shortyear;

            if ($logger[$fourcode][$lastname]) {
                return FALSE;
            } else {
                $logger[$fourcode][$lastname] = TRUE;
            }

            $conn = Util::get_ctb_conn();
            $state = mb_substr($fourcode, 0, 2);
            $dist = mb_substr($fourcode, 2, 2);
            $retval = Array();

            if ($lastname == "Rubio" || $lastname == "Murphy") {

            }

            if ($state == "VT" || $state == "ND" || $state == "WY" || $state == "SD" || $state == "AK" || $state == "MT" || $state == "DE") {

                $sql = "SELECT *
	            FROM  (SELECT * FROM (
	                        SELECT DISTINCT tra_id, can_nam, spe_id, spe_nam, ele_typ, can_off, can_off_sta, can_off_dis, can_par_aff, exp_amo, exp_dat, sup_opp, pur, pay, file_num, amn_ind, ima_num, rec_dat
	                        FROM $table
	                        WHERE can_nam LIKE '%$lastname%' && can_off_sta = '$state' && (can_off_dis = '$dist' || can_off_dis = '01') && can_off = 'H'
	                        ORDER BY file_num DESC
	                    ) A
	                    GROUP BY spe_nam, tra_id, pay, exp_dat, can_off_dis ) B

	    ";


            } else {

                $sql = "SELECT *
	            FROM  (SELECT * FROM (
	                        SELECT DISTINCT tra_id, can_nam, spe_id, spe_nam, ele_typ, can_off, can_off_sta, can_off_dis, can_par_aff, exp_amo, exp_dat, sup_opp, pur, pay, file_num, amn_ind, ima_num, rec_dat
	                        FROM $table
	                        WHERE can_nam LIKE '%$lastname%' && can_off_sta = '$state' && can_off_dis = '$dist' && can_off = 'H'
	                        ORDER BY file_num DESC
	                    ) A
	                    GROUP BY spe_nam, tra_id, pay, exp_dat, can_off_dis, pur ) B

	    ";
            }


            //echo("<br>$lastname<br>");
            //echo("<br>$sql");
            //echo("<br>");

            $result = $conn->query($sql);

            //echo("<br>$fourcode RESULT DUMP:<br>");
            //var_dump($result);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $amount = $row['exp_amo'];
                    $amount = str_replace('$', '', $amount);
                    $amount = str_replace(',', '', $amount);

                    $cmte_nm = $row['spe_nam'];
                    $cmte_id = $row['spe_id'];
                    $election = $row['ele_typ'];

		    if($year == 2018) {
                    	if (($fourcode == "GA06" || $fourcode == "MT00" || $fourcode == "CA34" || $fourcode == "PA18") && $election == "G") {
                        	$election = "S";
                    	}

                    	if ($fourcode == "MT00" && $election == "P") {
                        	$election = "S";
	                    }
		    }

                    if ($election == "O" || $election == "R") {
                        $election = "S";
                    }
                    $support = $row['sup_opp'];
                    $purpose = $row['pur'];
                    $filing_id = $row['file_num'];
                    $date = $row['rec_dat'];
                    $payee = $row['pay'];
                    $filing_link = "<a href='/ctb-legacy/fedparser_null.php?id=$filing_id' target='_blank'>$filing_id</a>";

                    if ($election == "G") {
                        $gentotal += $amount;
                        if ($support == "Support" || $support == "S") {
                            $gensupport += $amount;
                            $ie_cmte[$cmte_id]['cmte_nm'] = $cmte_nm;
                            $ie_cmte[$cmte_id]['cmte_id'] = $cmte_id;
                            $ie_cmte_cands[$cmte_id][$lastname]['gs_amount'] += $amount;
                            $ie_cmte[$cmte_id]['gs_cand'] = $lastname;
                            $ie_cmte[$cmte_id]['gs_cand_cnt'][$lastname] = 1;
                            $ie_cmte[$cmte_id]['g'] += $amount;
                            $ie_cands[$lastname]['cand_nm'] = $lastname;

                        } elseif ($support == "Oppose" || $support == "O") {
                            $genoppose += $amount;
                            $ie_cmte[$cmte_id]['cmte_nm'] = $cmte_nm;
                            $ie_cmte[$cmte_id]['cmte_id'] = $cmte_id;
                            $ie_cmte_cands[$cmte_id][$lastname]['go_amount'] += $amount;
                            $ie_cmte[$cmte_id]['go_cand'] = $lastname;
                            $ie_cmte[$cmte_id]['go_cand_cnt'][$lastname] = 1;
                            $ie_cmte[$cmte_id]['g'] += $amount;
                            $ie_cands[$lastname]['cand_nm'] = $lastname;
                        }
                        $electionclass = '';

                    }

                    if ($election == "S") {
                        $spctotal += $amount;
                        if ($support == "Support" || $support == "S") {
                            $spcsupport += $amount;
                            $ie_cmte[$cmte_id]['cmte_nm'] = $cmte_nm;
                            $ie_cmte[$cmte_id]['cmte_id'] = $cmte_id;
                            $ie_cmte_cands[$cmte_id][$lastname]['ss_amount'] += $amount;
                            $ie_cmte[$cmte_id]['ss_cand'] = $lastname;
                            $ie_cmte[$cmte_id]['ss_cand_cnt'][$lastname] = 1;
                            $ie_cmte[$cmte_id]['s'] += $amount;
                            $ie_cands[$lastname]['cand_nm'] = $lastname;

                        } elseif ($support == "Oppose" || $support == "O") {
                            $spcoppose += $amount;
                            $ie_cmte[$cmte_id]['cmte_nm'] = $cmte_nm;
                            $ie_cmte[$cmte_id]['cmte_id'] = $cmte_id;
                            $ie_cmte_cands[$cmte_id][$lastname]['so_amount'] += $amount;
                            $ie_cmte[$cmte_id]['so_cand'] = $lastname;
                            $ie_cmte[$cmte_id]['so_cand_cnt'][$lastname] = 1;
                            $ie_cmte[$cmte_id]['s'] += $amount;
                            $ie_cands[$lastname]['cand_nm'] = $lastname;
                        }
                        $electionclass = '';

                    }


                    if ($election == "P") {
                        $primtotal += $amount;
                        if ($support == "Support" || $support == "S") {
                            $primsupport += $amount;
                            $ie_cmte[$cmte_id]['cmte_nm'] = $cmte_nm;
                            $ie_cmte[$cmte_id]['cmte_id'] = $cmte_id;
                            $ie_cmte_cands[$cmte_id][$lastname]['ps_amount'] += $amount;
                            $ie_cmte[$cmte_id]['ps_cand'] = $lastname;
                            $ie_cmte[$cmte_id]['ps_cand_cnt'][$lastname] = 1;
                            $ie_cmte[$cmte_id]['p'] += $amount;
                            $ie_cands[$lastname]['cand_nm'] = $lastname;
                        } elseif ($support == "Oppose" || $support == "O") {
                            $primoppose += $amount;
                            $ie_cmte[$cmte_id]['cmte_nm'] = $cmte_nm;
                            $ie_cmte[$cmte_id]['cmte_id'] = $cmte_id;
                            $ie_cmte_cands[$cmte_id][$lastname]['po_amount'] += $amount;
                            $ie_cmte[$cmte_id]['po_cand'] = $lastname;
                            $ie_cmte[$cmte_id]['po_cand_cnt'][$lastname] = 1;
                            $ie_cmte[$cmte_id]['p'] += $amount;
                            $ie_cands[$lastname]['cand_nm'] = $lastname;
                        }
                        //$electionclass= 'itcme';
                    }

                    if ($support == "Support" || $support == "S") {
                        $sup_txt = "<span class='greenme'>+" . $lastname . "</span>";
                    } elseif ($support == "Oppose" || $support == "O") {
                        $sup_txt = "<span class='redme'>-" . $lastname . "</span>";
                    }

                    // $link = "<a href='http://198.74.49.22/fediecmtedetail.php?id=" . $cmte_id . "' target='_blank'>$cmte_nm</a>";
                    $link = "<a href='https://www.fec.gov/data/committee/$cmte_id/?tab=filings' target='_blank'>$cmte_nm</a>";

                    if ($amount >= 1000) {
                        $endtable['HTML'] .= "
                    <tr class='$electionclass'>
                        <td>$election</td>
                        <td>$link</td>
                        <td class='rightme {sorter: \"thousands\" } '>" . number_format($amount, 0, '.', '') . "</td>
                        <td>$sup_txt</td>
                        <td>$purpose</td>
                        <td>$payee</td>
                        <td>" . normalize_date($date) . "</td>
                        <td>$filing_link</td>
                    </tr>

                ";
                    }

                }
            }

            $retval['CAND_TOTAL'] = $gentotal + $primtotal;
            $retval['GEN_TOTAL_S'] = $gensupport;
            $retval['GEN_TOTAL_O'] = $genoppose;

            $retval['SPC_TOTAL_S'] = $spcsupport;
            $retval['SPC_TOTAL_O'] = $spcoppose;

            $retval['PRI_TOTAL_S'] = $primsupport;
            $retval['PRI_TOTAL_O'] = $primoppose;

            //echo("<br>RETURNING G + $gensupport, G - $genoppose, P + $primsupport, P - $primoppose");
            //echo("<br>INSIDE FUNCTION:<br>");
            //var_dump($ie_cmte_cands);
            //echo("<br>----<br>");

            return $retval;

        }


        function getlastnames()
        {
            global $fec_conn;
            global $year;
            global $fourcode;
            $conn = Util::get_ctb_conn();
            $retval = Array();

            if ($year < 2018) {
                $sql = "SELECT NAML FROM nufec_election_results WHERE YEAR = $year && FOURCODE = '$fourcode' GROUP BY NAML";
            } else {
		$this_shortyear = mb_substr($year, 2, 2);
		$cand_table = "nufec_cn_" . $this_shortyear;
		$state = mb_substr($fourcode, 0, 2);
		$yr1 = $year;
		$yr2 = $year - 1;
		
		if(mb_substr(fourcode, 2, 3) == "SEN") {
			$sql = "SELECT CAND_NAME AS cand_nm FROM $cand_table WHERE CAND_OFFICE = 'S' && CAND_OFFICE_ST = '$state' && (CAND_ELECTION_YR = '$yr1' || CAND_ELECTION_YR = '$yr2')"; 
		} else {
			if(mb_substr($fourcode, 0, 2) == "CD") {
				$state = "CA";
			} 

			$dist = mb_substr($fourcode, 2, 2);
			$sql = "SELECT CAND_NAME AS cand_nm FROM $cand_table WHERE CAND_OFFICE = 'H' && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = '$dist' && (CAND_ELECTION_YR = '$yr1' || CAND_ELECTION_YR = '$yr2')"; 
		}
		
            }
	    //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    if ($year < 2018) {
                        $naml = $row['NAML'];
                    } else {
                        $tmpname = $row['cand_nm'];
                        $arr = explode(",", $tmpname);
                        $naml = $arr[0];
                    }
                    array_push($retval, $naml);
                }
            }

	    //echo("<br>RETVAL DUMP<br>");
            //var_dump($retval);
            return $retval;
        }

        function getall()
        {
            global $fec_conn;
            global $year;
            global $fourcode;
            $retval = Array();
            $candidates = getfiledcandidates();

            foreach ($candidates as $x) {
                $cand_id = $x['CAND_ID'];
                $y = getfinancials($cand_id);
                $y['CAND_NM'] = $x['CAND_NM'];
                $y['PARTY'] = $x['PARTY'];
                $y['CAND_ID'] = $cand_id;
                array_push($retval, $y);

            }

            return $retval;
        }

        function getgeneral()
        {
            global $fec_conn;
            global $year;
            global $fourcode;
            $conn = $fec_conn;
            $retval = Array();
            $candidates = getelectioncandidates();
            foreach ($candidates as $x) {
                $cand_id = $x['CAND_ID'];
                $y = getfinancials($cand_id);
                $y['CAND_NM'] = $x['CAND_NM'];
                $y['PARTY'] = $x['PARTY'];
                $y['CAND_ID'] = $cand_id;
                array_push($retval, $y);

            }

            return $retval;
        }

        function getelectioncandidates()
        {
            global $year;
            global $fourcode;
            $retval = Array();
            global $fec_conn;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT * FROM nufec_election_results WHERE FOURCODE = '$fourcode' && YEAR = $year";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $tmp['CAND_ID'] = $row['CAND_ID'];
                    $tmp['CAND_NM'] = $row['NAMF'] . " " . $row['NAML'];
                    $tmp['PARTY'] = $row['PARTY'];
                    array_push($retval, $tmp);
                }
            }

            return $retval;
        }

        function getfinancials($cand_id)
        {
            global $year;
            global $fourcode;
            global $fec_conn;
            $conn = Util::get_ctb_conn();
            switch ($year) {
                case "2018":
                    $suffix = '_18';
                    break;
                case "2016":
                    $suffix = '';
                    break;
                case "2014":
                    $suffix = "_14";
                    break;
                case "2012":
                    $suffix = "_12";
                    break;
            }

            $sql = "SELECT * FROM nufec_weball" . $suffix . " WHERE CAND_ID = '$cand_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $x['RCPT'] = $row['TTL_RECEIPTS'];
                    $x['COH_START'] = $row['COH_BOP'];
                    $x['COH_END'] = $row['COH_COP'];
                    $x['EXPN'] = $row['TTL_DISB'];
                    $x['DEBTS'] = $row['DEBTS_OWED_BY'];
                    $x['CAND_NM'] = $row['CAND_NAME'];
                    $x['PARTY'] = $row['CAND_PTY_AFFILIATION'];
                }
            }

            return $x;
        }

        function getfiledcandidates()
        {
            global $fourcode;
            global $year;
            global $fec_conn;
            $conn = Util::get_ctb_conn();
            $state = mb_substr($fourcode, 0, 2);
            $dist = mb_substr($fourcode, 2, 2);
            $retval = Array();

            switch ($year) {
                case "2018":
                    $sql = "SELECT * FROM nufec_e18_fed_candidates WHERE FOURCODE = '$fourcode'";
                    break;
                case "2016":
                    $sql = "SELECT * FROM nufec_cn WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist";
                    break;
                case "2014":
                    $sql = "SELECT * FROM nufec_cn_14 WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist";
                    break;
                case "2012":
                    $sql = "SELECT * FROM nufec_cn_12 WHERE CAND_ELECTION_YR = $year && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = $dist";
                    break;
            }

            //echo($sql);

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($year != "2018") {
                        $tmp['CAND_NM'] = $row['CAND_NAME'];
                        $tmp['PARTY'] = $row['CAND_PTY_AFFILIATION'];
                        $tmp['CAND_ID'] = $row['CAND_ID'];
                    } else {
                        $tmp['CAND_NM'] = $row['cand_nm'];
                        $tmp['PARTY'] = $row['party'];
                        $tmp['CAND_ID'] = $row['cand_id'];
                    }
                    array_push($retval, $tmp);
                }

            }

            //var_dump($retval);
            return $retval;
        }

function normalize_date($value) {
    /*
        TYPE 1: MMDDYYYY
        TYPE 2: DD-MMM-YY (IE 2018-2020)
        TYPE 3: MM/DD/YYYY (OP EXP 2012 - 2020, IE 2012-2016)
    */

    

    $value = str_replace("/", "-", $value);
    $value = trim($value);

    

    if(strlen($value) == "8") {
        if(mb_substr($value, 4, 2) == "20") {
            $type = 1;
        } 
    } elseif(strlen($value) == "10") {
        if(mb_substr($value, 2, 1) == "-" && mb_substr($value, 5, 1) === "-") {
            $type = 3;
        }
    } elseif(strlen($value) == "9") {
        if(mb_substr($value, 2, 1) == "-" && mb_substr($value, 6, 1) == "-") {
            $type = 2;
        }        
    }

    

    $textmonth = Array(
        "JAN" => "01",
        "FEB" => "02",
        "MAR" => "03",
        "APR" => "04",
        "MAY" => "05",
        "JUN" => "06",
        "JUL" => "07",
        "AUG" => "08",
        "SEP" => "09",
        "OCT" => "10",
        "NOV" => "11",
        "DEC" => "12"
        );

    switch($type) {
        case "1":
            $year = mb_substr($value, 4, 4);
            $month = mb_substr($value, 0, 2);
            $day = mb_substr($value, 2, 2);
            break;
        case "2":
            $year = mb_substr($value, 7, 4);
            $day = mb_substr($value, 0, 2);
            $tmp_month = mb_substr($value, 3, 3);
            $month = $textmonth[$tmp_month];
            break;
        case "3":
            $year = mb_substr($value, 6, 4);
            $month = mb_substr($value, 0, 2);
            $day = mb_substr($value, 3, 2);
            break;
    }

    if(strlen($year) == 2) {
        $year = "20" . $year;
    }

    
    if($year && $month && $day) {
        $retval = $year . "-" . $month . "-" . $day;
        return $retval;
    } else {
        $old_length = strlen($value);
        //$value = "L$old_length" . "T". $type . mb_substr($value, 2, 1) . mb_substr($value, 5, 1);
        return $value;
    }
    
}


        //include 'php/storgsearch.php';


        ?>

    </div>

@endsection

@section('scripts')

    {{--  <script type="text/javascript" src="js/tablesaw.jquery.js"></script>
    <script type="text/javascript" src="js/tablesaw-init.js"></script>

      --}}

    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>

@endsection

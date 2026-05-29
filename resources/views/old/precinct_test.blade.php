@extends('layouts.iframe_old')

@section('title', 'Precinct Test | California Target Book')

@section('content')
    


    <?php

    ini_set('memory_limit', '1512M');

    Util::set_errors();
    Util::require_ctb_api();

    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    set_time_limit(0);


    $endjava = Array();
    $candidate_array = Array();
    $coordinates = Array();


    global $fourcode, $election, $vis;
    $fourcode = $_GET['id'];
    $election = $_GET['election'];
    $vis = $_GET['vis'];

    $mainfourcode = $fourcode;

    $overlaps = get_overlaps($fourcode);

    //echo("<Br>OVERLAPS:<br>");
    //var_dump($overlaps);

    foreach ($overlaps as $tempcode) {
        get_candidates($tempcode);
    }

    //echo("<br>CANDIDATE ARRAY:<br>");
    //var_dump($candidate_array);

    $i = 1;

    $precincts = get_precincts($mainfourcode, $election);


    echo("<br>PRECINCT DUMP:<br>");
    var_dump($precincts);




    /*





    MMMMMMMM               MMMMMMMM                                        SSSSSSSSSSSSSSS RRRRRRRRRRRRRRRRR   PPPPPPPPPPPPPPPPP   RRRRRRRRRRRRRRRRR           CCCCCCCCCCCCC
    M:::::::M             M:::::::M                                      SS:::::::::::::::SR::::::::::::::::R  P::::::::::::::::P  R::::::::::::::::R       CCC::::::::::::C
    M::::::::M           M::::::::M                                     S:::::SSSSSS::::::SR::::::RRRRRR:::::R P::::::PPPPPP:::::P R::::::RRRRRR:::::R    CC:::::::::::::::C
    M:::::::::M         M:::::::::M                                     S:::::S     SSSSSSSRR:::::R     R:::::RPP:::::P     P:::::PRR:::::R     R:::::R  C:::::CCCCCCCC::::C
    M::::::::::M       M::::::::::M  aaaaaaaaaaaaa  ppppp   ppppppppp   S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::R C:::::C       CCCCCC
    M:::::::::::M     M:::::::::::M  a::::::::::::a p::::ppp:::::::::p  S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::RC:::::C
    M:::::::M::::M   M::::M:::::::M  aaaaaaaaa:::::ap:::::::::::::::::p  S::::SSSS           R::::RRRRRR:::::R   P::::PPPPPP:::::P   R::::RRRRRR:::::R C:::::C
    M::::::M M::::M M::::M M::::::M           a::::app::::::ppppp::::::p  SS::::::SSSSS      R:::::::::::::RR    P:::::::::::::PP    R:::::::::::::RR  C:::::C
    M::::::M  M::::M::::M  M::::::M    aaaaaaa:::::a p:::::p     p:::::p    SSS::::::::SS    R::::RRRRRR:::::R   P::::PPPPPPPPP      R::::RRRRRR:::::R C:::::C
    M::::::M   M:::::::M   M::::::M  aa::::::::::::a p:::::p     p:::::p       SSSSSS::::S   R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
    M::::::M    M:::::M    M::::::M a::::aaaa::::::a p:::::p     p:::::p            S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
    M::::::M     MMMMM     M::::::Ma::::a    a:::::a p:::::p    p::::::p            S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::R C:::::C       CCCCCC
    M::::::M               M::::::Ma::::a    a:::::a p:::::ppppp:::::::pSSSSSSS     S:::::SRR:::::R     R:::::RPP::::::PP          RR:::::R     R:::::R  C:::::CCCCCCCC::::C
    M::::::M               M::::::Ma:::::aaaa::::::a p::::::::::::::::p S::::::SSSSSS:::::SR::::::R     R:::::RP::::::::P          R::::::R     R:::::R   CC:::::::::::::::C
    M::::::M               M::::::M a::::::::::aa:::ap::::::::::::::pp  S:::::::::::::::SS R::::::R     R:::::RP::::::::P          R::::::R     R:::::R     CCC::::::::::::C
    MMMMMMMM               MMMMMMMM  aaaaaaaaaa  aaaap::::::pppppppp     SSSSSSSSSSSSSSS   RRRRRRRR     RRRRRRRPPPPPPPPPP          RRRRRRRR     RRRRRRR        CCCCCCCCCCCCC
                                                     p:::::p
                                                     p:::::p
                                                    p:::::::p
                                                    p:::::::p
                                                    p:::::::p
                                                    ppppppppp

    */

    foreach ($precincts as $precinct) {
        $srprec = $precinct['srprec'];
        $county = $precinct['county'];
        //$dumpmode = TRUE;

        if ($srprec == "0300006B") {
            //	$dumpmode = TRUE;
            //	echo("<br>PROCESSING PRECINCT #$srprec");
        }


        $x = get_precinct_polygons($srprec, $county);

        if ($dumpmode) {
            echo("<br>DUMP OF PRECINCT POLGYONS:<br>");
            var_dump($x);
        }
        if (!$x) {

            if ($dumpmode) {
                echo("<br>NO COORDINATES<bt> for $srprec in County $county<br>");
            }
            continue;
        }
        $stats = get_stats($srprec, $county);

        if ($dumpmode) {
            echo("<br>STATS DUMP:<br>");
            var_dump($stats);
        }

        $polys = parse_poly_strings($x);

        if ($dumpmode) {
            echo("<br>PARSED RESULTS DUMP:<br>");
            var_dump($polys);
        }

        if (is_array($polys)) {
            $coordinates[$srprec]['POLYS'] = $polys;
        } else {
            $coordinates[$srprec]['COORDINATES'] = $polys;
            $coordinates[$srprec]['COORDINATES'] = rtrim($coordinates[$srprec]['COORDINATES'], ',');
        }


        $coordinates[$srprec]['TOTREG'] = $stats['TOTREG'];
        $coordinates[$srprec]['TOTVOTE'] = $stats['TOTVOTE'];
        $coordinates[$srprec]['AD'] = "AD" . checkaddzero($stats['AD']);
        $coordinates[$srprec]['SD'] = "SD" . checkaddzero($stats['SD']);
        $coordinates[$srprec]['CD'] = "CD" . checkaddzero($stats['CD']);
        $coordinates[$srprec]['ALL'] = $stats['ALL'];

        $i++;

    }


    //echo("<br>parsed:<br>$coordinates");


    //INITIALIZING PORTION OF JAVASCRIPT
    $js = "
	  var polys = [];

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: {lat: 38.886, lng: -118.268},
          mapTypeId: google.maps.MapTypeId.TERRAIN
        });

		var infowindow = new google.maps.InfoWindow({
			content: \"Blah\"
		});

";

    array_push($endjava, $js);


    /*


    MMMMMMMM               MMMMMMMM                                        SSSSSSSSSSSSSSS      tttt                                    tttt
    M:::::::M             M:::::::M                                      SS:::::::::::::::S  ttt:::t                                 ttt:::t
    M::::::::M           M::::::::M                                     S:::::SSSSSS::::::S  t:::::t                                 t:::::t
    M:::::::::M         M:::::::::M                                     S:::::S     SSSSSSS  t:::::t                                 t:::::t
    M::::::::::M       M::::::::::M  aaaaaaaaaaaaa  ppppp   ppppppppp   S:::::S        ttttttt:::::ttttttt      aaaaaaaaaaaaa  ttttttt:::::ttttttt        ssssssssss
    M:::::::::::M     M:::::::::::M  a::::::::::::a p::::ppp:::::::::p  S:::::S        t:::::::::::::::::t      a::::::::::::a t:::::::::::::::::t      ss::::::::::s
    M:::::::M::::M   M::::M:::::::M  aaaaaaaaa:::::ap:::::::::::::::::p  S::::SSSS     t:::::::::::::::::t      aaaaaaaaa:::::at:::::::::::::::::t    ss:::::::::::::s
    M::::::M M::::M M::::M M::::::M           a::::app::::::ppppp::::::p  SS::::::SSSSStttttt:::::::tttttt               a::::atttttt:::::::tttttt    s::::::ssss:::::s
    M::::::M  M::::M::::M  M::::::M    aaaaaaa:::::a p:::::p     p:::::p    SSS::::::::SS    t:::::t              aaaaaaa:::::a      t:::::t           s:::::s  ssssss
    M::::::M   M:::::::M   M::::::M  aa::::::::::::a p:::::p     p:::::p       SSSSSS::::S   t:::::t            aa::::::::::::a      t:::::t             s::::::s
    M::::::M    M:::::M    M::::::M a::::aaaa::::::a p:::::p     p:::::p            S:::::S  t:::::t           a::::aaaa::::::a      t:::::t                s::::::s
    M::::::M     MMMMM     M::::::Ma::::a    a:::::a p:::::p    p::::::p            S:::::S  t:::::t    tttttta::::a    a:::::a      t:::::t    ttttttssssss   s:::::s
    M::::::M               M::::::Ma::::a    a:::::a p:::::ppppp:::::::pSSSSSSS     S:::::S  t::::::tttt:::::ta::::a    a:::::a      t::::::tttt:::::ts:::::ssss::::::s
    M::::::M               M::::::Ma:::::aaaa::::::a p::::::::::::::::p S::::::SSSSSS:::::S  tt::::::::::::::ta:::::aaaa::::::a      tt::::::::::::::ts::::::::::::::s
    M::::::M               M::::::M a::::::::::aa:::ap::::::::::::::pp  S:::::::::::::::SS     tt:::::::::::tt a::::::::::aa:::a       tt:::::::::::tt s:::::::::::ss
    MMMMMMMM               MMMMMMMM  aaaaaaaaaa  aaaap::::::pppppppp     SSSSSSSSSSSSSSS         ttttttttttt    aaaaaaaaaa  aaaa         ttttttttttt    sssssssssss
                                                     p:::::p
                                                     p:::::p
                                                    p:::::::p
                                                    p:::::::p
                                                    p:::::::p
                                                    ppppppppp



    */


    $count = 1;
    //LOOP THROUGH ALL THE ZIP CODES AND DRAW INDIVIDUAL SEGMENTS


    foreach ($precincts as $value) {

        $ad_candidates = '';
        $cd_candidates = '';
        $sd_candidates = '';

        $gov_candidates = '';
        $ltg_candidates = '';
        $atg_candidates = '';
        $sos_candidates = '';
        $trs_candidates = '';
        $con_candidates = '';
        $ins_candidates = '';
        $spi_candidates = '';

        $sen_candidates = '';

        $dpp_candidates = '';
        $rpp_candidates = '';

        $prs_candidates = '';

        $votes = Array();

        $ad_vote = 0;
        $sd_vote = 0;
        $cd_vote = 0;

        $gov_vote = 0;
        $ltg_vote = 0;
        $atg_vote = 0;
        $sos_vote = 0;
        $trs_vote = 0;
        $con_vote = 0;
        $ins_vote = 0;
        $spi_vote = 0;
        $sen_vote = 0;
        $dpp_vote = 0;
        $rpp_vote = 0;
        $prs_vote = 0;

        $num_ad_candidates = 0;
        $num_sd_candidates = 0;
        $num_cd_candidates = 0;

        $num_gov_candidates = 0;
        $num_ltg_candidates = 0;
        $num_atg_candidates = 0;
        $num_sos_candidates = 0;
        $num_trs_candidates = 0;
        $num_con_candidates = 0;
        $num_ins_candidates = 0;
        $num_spi_candidates = 0;
        $num_dpp_candidates = 0;
        $num_rpp_candidates = 0;
        $num_sen_candidates = 0;
        $num_prs_candidates = 0;

        $dem_sd = 0;
        $dem_ad = 0;
        $dem_cd = 0;

        $dem_gov = 0;
        $dem_ltg = 0;
        $dem_atg = 0;
        $dem_sos = 0;
        $dem_trs = 0;
        $dem_con = 0;
        $dem_ins = 0;
        $dem_spi = 0;
        $dem_dpp = 0;
        $dem_sen = 0;

        $rep_sd = 0;
        $rep_ad = 0;
        $rep_cd = 0;

        $rep_gov = 0;
        $rep_ltg = 0;
        $rep_atg = 0;
        $rep_sos = 0;
        $rep_trs = 0;
        $rep_con = 0;
        $rep_ins = 0;
        $rep_spi = 0;
        $rep_rpp = 0;
        $rep_sen = 0;

        $ind_sd = 0;
        $ind_cd = 0;
        $ind_ad = 0;

        $precinct = $value['srprec'];
        $county = $value['county'];
        $verbosecounty = getcountyname($county);
        //$dist = checkaddzero($i);
        //$fourcode = "AD$dist";

        $vot = $coordinates[$precinct]['TOTVOTE'];

        $ad = $coordinates[$precinct]['AD'];
        $cd = $coordinates[$precinct]['CD'];
        $sd = $coordinates[$precinct]['SD'];

        $ad_cands = $candidate_array[$ad];
        $cd_cands = $candidate_array[$cd];
        $sd_cands = $candidate_array[$sd];

        //CREATE THE PROPOSITIONS ARRAY
        $prop_array = [];
        foreach ($candidate_array as $key => $value) {
            if (mb_substr($key, 0, 2) == "PR") {
                //FOUND A PROP
                $position = substr($key, -1);
                $propno = ltrim($key, "PR");
                $propno = rtrim($propno, $position);
                $distkey = $value['DISTKEY'];
                //echo("<br>FOUND PROP $propno, $position Position");

                if (!isset($prop_array[$propno])) {
                    $prop_array[$propno] = [];
                }

                if ($propno && $position) {
                    $prop_array[$propno][$position] = $value;
                }

            }
        }

        if (mb_substr($election, 0, 1) == "p") {
            $is_primary = TRUE;
        } else {
            $is_primary = FALSE;
        }

        //echo("<br>PROP ARRAY: <br>");
        //var_dump($prop_array);

        $gov_cands = $candidate_array['.GOV'];
        $ltg_cands = $candidate_array['.LTG'];
        $atg_cands = $candidate_array['.ATG'];
        $sos_cands = $candidate_array['.SOS'];
        $trs_cands = $candidate_array['.TRS'];
        $con_cands = $candidate_array['.CON'];
        $ins_cands = $candidate_array['.INS'];
        $spi_cands = $candidate_array['.SPI'];
        $sen_cands = $candidate_array['.USS'];
        $prs_cands = $candidate_array['.PRS'];
        $dpp_cands = Array();
        $rpp_cands = Array();

        $i = 0;
        foreach ($prop_array as $key1 => $value1) {
            foreach ($value1 as $key2 => $value2) {
                foreach ($value2 as $value3) {
                    $distkey = $value3['RACE'];
                }

                $thisvote = $coordinates[$precinct]['ALL'][$distkey];
                //echo("<br>Retrieving votes from coordinates $precinct - ALL - $distkey RETURNS $thisvote");
                $votes[$key1]['TOTAL'] += $thisvote;
                $votes[$key1][$key2] = $thisvote;
            }
        }

        //echo("<br>PARSED PROP ARRAY:<br>");
        //var_dump($votes);

        $prop_html = '';

        $prop_html = "<section class='boldme newseg' style='clear: both; display: inline-block; width: 95%;'><div class='stw'>";

        foreach ($votes as $key => $prop) {
            $yes = $prop['Y'];
            $no = $prop['N'];
            $proptot = $prop['TOTAL'];
            $yes_pct = makepct($yes, $proptot);
            $prop_undervote = makepct(($vot - $proptot), $vot);
            $no_pct = makepct($no, $proptot);
            $prop_html .= "<p align='center'>PROP $key - $proptot Votes ($prop_undervote Undervote) <span class='greenme'>YES: $yes ($yes_pct)</span> &mdash;<span class='redme'> NO: $no ($no_pct)</span></p>";
            //echo("<br>SRPREC $precinct: PROP $key: YES $yes ($yes_pct) - NO $no ($no_pct)");
        }

        $prop_html .= "</div></section>";

        $i = 0;
        $dem_id = 0;
        $rep_id = 0;
        foreach ($prs_cands as $value) {
            $party = $value['PARTY'];
            $distkey = $value['DISTKEY'];
            $num_prs_candidates++;

            if (mb_substr($election, 0, 1) == "p") {
                //POPULATE PRESIDENTIAL CANDIDATES DURING THE PRIMARY
                if ($party == "DEM") {
                    $dpp_cands[$distkey]['DISTKEY'] = $distkey;
                    $dpp_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
                    $dpp_cands[$distkey]['ID'] = $dem_id;
                    $dpp_cands[$distkey]['NAME'] = $value['NAME'];
                    $dpp_vote += $coordinates[$precinct]['ALL'][$distkey];
                    $dem_id++;
                } elseif ($party == "REP") {
                    $rpp_cands[$distkey]['DISTKEY'] = $distkey;
                    $rpp_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
                    $rpp_cands[$distkey]['NAME'] = $value['NAME'];
                    $rpp_cands[$distkey]['ID'] = $rep_id;
                    $rpp_vote += $coordinates[$precinct]['ALL'][$distkey];
                    $rep_id++;
                }

            } else {
                $prs_cands[$distkey]['DISTKEY'] = $distkey;
                $prs_cands[$distkey]['ID'] = $i;
                $prs_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
                $prs_vote += $coordinates[$precinct]['ALL'][$distkey];
            }
            $i++;
        }


        $i = 0;
        foreach ($gov_cands as $value) {
            $distkey = $value['DISTKEY'];
            $gov_vote += $coordinates[$precinct]['ALL'][$distkey];
            $gov_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $gov_cands[$distkey]['ID'] = $i;
            $num_gov_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_gov++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_gov++;
            } else {
                $ind_gov++;
            }
            $i++;
        }

        $i = 0;
        foreach ($ltg_cands as $value) {
            $distkey = $value['DISTKEY'];
            $ltg_vote += $coordinates[$precinct]['ALL'][$distkey];
            $ltg_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $ltg_cands[$distkey]['ID'] = $i;
            $num_ltg_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_ltg++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_ltg++;
            } else {
                $ind_ltg++;
            }
            $i++;
        }

        $i = 0;
        foreach ($atg_cands as $value) {
            $distkey = $value['DISTKEY'];
            $atg_vote += $coordinates[$precinct]['ALL'][$distkey];
            $atg_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $atg_cands[$distkey]['ID'] = $i;
            $num_atg_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_atg++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_atg++;
            } else {
                $ind_atg++;
            }
            $i++;
        }

        $i = 0;
        foreach ($sos_cands as $value) {
            $distkey = $value['DISTKEY'];
            $sos_vote += $coordinates[$precinct]['ALL'][$distkey];
            $sos_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $sos_cands[$distkey]['ID'] = $i;
            $num_sos_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_sos++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_sos++;
            } else {
                $ind_sos++;
            }
            $i++;
        }

        $i = 0;
        foreach ($con_cands as $value) {
            $distkey = $value['DISTKEY'];
            $con_vote += $coordinates[$precinct]['ALL'][$distkey];
            $con_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $con_cands[$distkey]['ID'] = $i;
            $num_con_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_con++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_con++;
            } else {
                $ind_con++;
            }
            $i++;
        }

        $i = 0;
        foreach ($ins_cands as $value) {
            $distkey = $value['DISTKEY'];
            $ins_vote += $coordinates[$precinct]['ALL'][$distkey];
            $ins_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $ins_cands[$distkey]['ID'] = $i;
            $num_ins_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_ins++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_ins++;
            } else {
                $ind_ins++;
            }
            $i++;
        }

        $i = 0;
        foreach ($trs_cands as $value) {
            $distkey = $value['DISTKEY'];
            $trs_vote += $coordinates[$precinct]['ALL'][$distkey];
            $trs_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $trs_cands[$distkey]['ID'] = $i;
            $num_trs_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_trs++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_trs++;
            } else {
                $ind_trs++;
            }
            $i++;
        }

        $i = 0;
        foreach ($spi_cands as $value) {
            $distkey = $value['DISTKEY'];
            $spi_vote += $coordinates[$precinct]['ALL'][$distkey];
            $spi_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $spi_cands[$distkey]['ID'] = $i;
            $num_spi_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_spi++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_spi++;
            } else {
                $ind_spi++;
            }
            $i++;
        }

        $i = 0;
        foreach ($sen_cands as $value) {
            $distkey = $value['DISTKEY'];
            $sen_vote += $coordinates[$precinct]['ALL'][$distkey];
            $sen_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $sen_cands[$distkey]['ID'] = $i;
            $num_sen_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_sen++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_sen++;
            } else {
                $ind_sen++;
            }
            $i++;
        }

        $i = 0;
        foreach ($ad_cands as $value) {
            $distkey = $value['DISTKEY'];
            $ad_vote += $coordinates[$precinct]['ALL'][$distkey];
            $ad_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $ad_cands[$distkey]['ID'] = $i;
            $num_ad_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_ad++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_ad++;
            } else {
                $ind_ad++;
            }
            $i++;
        }

        $i = 0;
        foreach ($sd_cands as $value) {
            $distkey = $value['DISTKEY'];
            $sd_vote += $coordinates[$precinct]['ALL'][$distkey];
            $sd_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $sd_cands[$distkey]['ID'] = $i;
            $num_sd_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_sd++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_sd++;
            } else {
                $ind_sd++;
            }
            $i++;
        }

        $i = 0;
        foreach ($cd_cands as $value) {
            $distkey = $value['DISTKEY'];
            $cd_vote += $coordinates[$precinct]['ALL'][$distkey];
            $cd_cands[$distkey]['PRECVOT'] = $coordinates[$precinct]['ALL'][$distkey];
            $cd_cands[$distkey]['ID'] = $i;
            $num_cd_candidates++;

            if ($value['PARTY'] == "REP") {
                $rep_cd++;
            } elseif ($value['PARTY'] == "DEM") {
                $dem_cd++;
            } else {
                $ind_cd++;
            }
            $i++;
        }


        $cand = 0;
        $topvote = "0";
        uasort($gov_cands, 'votesort');
        foreach ($gov_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            if ($vote) {
                $gov_candidates .= "$candidate ($party): $vote (" . makepct($vote, $gov_vote) . ")<br>";
            }

            if ($vote > $topvote) {
                $govoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_gov_candidates < 3 && $rep_gov < 2 && !$ind_gov) {
                    $govoffset = 0;
                }

                if ($party == "DEM" && $num_gov_candidates < 3 && $dem_gov < 2 && !$ind_gov) {
                    $govoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($ltg_cands, 'votesort');
        foreach ($ltg_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            if ($vote) {
                $ltg_candidates .= "$candidate ($party): $vote (" . makepct($vote, $ltg_vote) . ")<br>";
            }

            if ($vote > $topvote) {
                $ltgoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_ltg_candidates < 3 && $rep_ltg < 2 && !$ind_ltg) {
                    $ltgoffset = 0;
                }

                if ($party == "DEM" && $num_ltg_candidates < 3 && $dem_ltg < 2 && !$ind_ltg) {
                    $ltgoffset = 1;
                }
            }
        }


        $cand = 0;
        $topvote = "0";
        uasort($atg_cands, 'votesort');
        foreach ($atg_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $atg_candidates .= "$candidate ($party): $vote (" . makepct($vote, $atg_vote) . ")<br>";

            if ($vote > $topvote) {
                $atgoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_atg_candidates < 3 && $rep_atg < 2 && !$ind_atg) {
                    $atgoffset = 0;
                }

                if ($party == "DEM" && $num_atg_candidates < 3 && $dem_atg < 2 && !$ind_atg) {
                    $atgoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($sos_cands, 'votesort');
        foreach ($sos_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $sos_candidates .= "$candidate ($party): $vote (" . makepct($vote, $sos_vote) . ")<br>";

            if ($vote > $topvote) {
                $sosoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_sos_candidates < 3 && $rep_sos < 2 && !$ind_sos) {
                    $sosoffset = 0;
                }

                if ($party == "DEM" && $num_sos_candidates < 3 && $dem_sos < 2 && !$ind_sos) {
                    $sosoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($trs_cands, 'votesort');
        foreach ($trs_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $trs_candidates .= "$candidate ($party): $vote (" . makepct($vote, $trs_vote) . ")<br>";

            if ($vote > $topvote) {
                $trsoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_trs_candidates < 3 && $rep_trs < 2 && !$ind_trs) {
                    $trsoffset = 0;
                }

                if ($party == "DEM" && $num_trs_candidates < 3 && $dem_trs < 2 && !$ind_trs) {
                    $trsoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($con_cands, 'votesort');
        foreach ($con_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $con_candidates .= "$candidate ($party): $vote (" . makepct($vote, $con_vote) . ")<br>";

            if ($vote > $topvote) {
                $conoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_con_candidates < 3 && $rep_con < 2 && !$ind_con) {
                    $conoffset = 0;
                }

                if ($party == "DEM" && $num_con_candidates < 3 && $dem_con < 2 && !$ind_con) {
                    $conoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($ins_cands, 'votesort');
        foreach ($ins_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $ins_candidates .= "$candidate ($party): $vote (" . makepct($vote, $ins_vote) . ")<br>";

            if ($vote > $topvote) {
                $insoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_ins_candidates < 3 && $rep_ins < 2 && !$ind_ins) {
                    $insoffset = 0;
                }

                if ($party == "DEM" && $num_ins_candidates < 3 && $dem_ins < 2 && !$ind_ins) {
                    $insoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($spi_cands, 'votesort');
        foreach ($spi_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $spi_candidates .= "$candidate ($party): $vote (" . makepct($vote, $spi_vote) . ")<br>";

            if ($vote > $topvote) {
                $spioffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_spi_candidates < 3 && $rep_spi < 2 && !$ind_spi) {
                    $spioffset = 0;
                }

                if ($party == "DEM" && $num_spi_candidates < 3 && $dem_spi < 2 && !$ind_spi) {
                    $spioffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($sen_cands, 'votesort');
        foreach ($sen_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            if ($vote) {
                $sen_candidates .= "$candidate ($party): $vote (" . makepct($vote, $sen_vote) . ")<br>";
            }

            if ($vote > $topvote) {
                $senoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_sen_candidates < 3 && $rep_sen < 2 && !$ind_sen) {
                    $senoffset = 0;
                }

                if ($party == "DEM" && $num_sen_candidates < 3 && $dem_sen < 2 && !$ind_sen) {
                    $senoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($dpp_cands, 'votesort');
        foreach ($dpp_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            //echo("<br>Processing $precinct DPP candidate $candidate with $vote Votes");
            if ($vote) {
                $dpp_candidates .= "$candidate (DEM): $vote (" . makepct($vote, $dpp_vote) . ")<br>";
            }

            if ($vote > $topvote) {
                $dppoffset = $cand;
                $topvote = $vote;
            }
        }


        $cand = 0;
        $topvote = "0";
        uasort($rpp_cands, 'votesort');
        foreach ($rpp_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            if ($vote) {
                $rpp_candidates .= "$candidate (REP): $vote (" . makepct($vote, $rpp_vote) . ")<br>";
            }

            if ($vote > $topvote) {
                $rppoffset = $cand;
                $topvote = $vote;
            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($prs_cands, 'votesort');
        foreach ($prs_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            if ($vote) {
                $prs_candidates .= "$candidate ($party): $vote (" . makepct($vote, $prs_vote) . ")<br>";
            }

            if ($vote > $topvote) {
                $prsoffset = $cand;
                $topvote = $vote;
                if ($party == "REP" && $num_prs_candidates < 3 && $rep_prs < 2 && !$ind_prs) {
                    $prsoffset = 0;
                }

                if ($party == "DEM" && $num_prs_candidates < 3 && $dem_prs < 2 && !$ind_prs) {
                    $prsoffset = 1;
                }
            }
        }

        $cand = 0;
        $topvote = "0";
        //echo("<br>CYCLING THROUGH $num_ad_candidates candidates<Br>");

        uasort($ad_cands, 'votesort');
        foreach ($ad_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $ad_candidates .= "$candidate ($party): $vote (" . makepct($vote, $ad_vote) . ")<br>";

            if ($vote > $topvote) {
                $adoffset = $cand;
                $topvote = $vote;

                if ($party == "REP" && $num_ad_candidates < 3 && $rep_ad < 2 && !$ind_ad) {
                    $adoffset = 0;
                }

                if ($party == "DEM" && $num_ad_candidates < 3 && $dem_ad < 2 && !$ind_ad) {
                    $adoffset = 1;
                }

            }
        }

        //echo("<br>PREC: $precinct - $winner ($adoffset) with $vote votes is highest, offset set to $adoffset<br>");

        $cand = 0;
        $topvote = "0";

        uasort($sd_cands, 'votesort');
        foreach ($sd_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];

            $sd_candidates .= "$candidate ($party): $vote (" . makepct($vote, $sd_vote) . ")<br>";


            if ($vote > $topvote) {
                $sdoffset = $cand;
                $topvote = $vote;


                if ($party == "REP" && $num_sd_candidates < 3 && $rep_sd < 2 && !$ind_sd) {
                    $sdoffset = 0;
                }

                if ($party == "DEM" && $num_sd_candidates < 3 && $dem_sd < 2 && !$ind_sd) {
                    $sdoffset = 1;
                }

            }
        }

        $cand = 0;
        $topvote = "0";
        uasort($cd_cands, 'votesort');
        foreach ($cd_cands as $value) {
            $cand = $value['ID'];
            $distkey = $value['DISTKEY'];
            $candidate = $value['NAME'];
            $incumbent = $value['INCUMBENT'];
            $party = $value['PARTY'];
            $vote = $coordinates[$precinct]['ALL'][$distkey];
            $cd_candidates .= "$candidate ($party): $vote (" . makepct($vote, $cd_vote) . ")<br>";


            if ($vote > $topvote) {
                $cdoffset = $cand;
                $topvote = $vote;


                if ($party == "REP" && $num_cd_candidates < 3 && $rep_cd < 2 && !$ind_cd) {
                    $cdoffset = 0;
                }

                if ($party == "DEM" && $num_cd_candidates < 3 && $dem_cd < 2 && !$ind_cd) {
                    $cdoffset = 1;
                }

            }
        }

        $reg = $coordinates[$precinct]['TOTREG'];
        $vot = $coordinates[$precinct]['TOTVOTE'];
        $turnout = makepct($vot, $reg);
        $turnoutoffset = ($vot / $reg) * 100;


        $dem = $coordinates[$precinct]['ALL']['rDEM'];
        $rep = $coordinates[$precinct]['ALL']['rREP'];
        $npp = $coordinates[$precinct]['ALL']['rDCL'];
        $tot = $coordinates[$precinct]['ALL']['rTOTREG_R'];

        $lat = $coordinates[$precinct]['ALL']['rHISPREP'] + $coordinates[$precinct]['ALL']['rHISPDEM'] + $coordinates[$precinct]['ALL']['rHISPDCL'] + $coordinates[$precinct]['ALL']['rHISPOTH'];
        $jap = $coordinates[$precinct]['ALL']['rJPNREP'] + $coordinates[$precinct]['ALL']['rJPNDEM'] + $coordinates[$precinct]['ALL']['rJPNDCL'] + $coordinates[$precinct]['ALL']['rJPNOTH'];
        $fil = $coordinates[$precinct]['ALL']['rFILREP'] + $coordinates[$precinct]['ALL']['rFILDEM'] + $coordinates[$precinct]['ALL']['rFILDCL'] + $coordinates[$precinct]['ALL']['rFILOTH'];
        $ind = $coordinates[$precinct]['ALL']['rINDREP'] + $coordinates[$precinct]['ALL']['rINDDEM'] + $coordinates[$precinct]['ALL']['rINDDCL'] + $coordinates[$precinct]['ALL']['rINDOTH'];
        $kor = $coordinates[$precinct]['ALL']['rKORREP'] + $coordinates[$precinct]['ALL']['rKORDEM'] + $coordinates[$precinct]['ALL']['rKORDCL'] + $coordinates[$precinct]['ALL']['rKOROTH'];
        $chi = $coordinates[$precinct]['ALL']['rCHIREP'] + $coordinates[$precinct]['ALL']['rCHIDEM'] + $coordinates[$precinct]['ALL']['rCHIDCL'] + $coordinates[$precinct]['ALL']['rCHIOTH'];
        $viet = $coordinates[$precinct]['ALL']['rVIETREP'] + $coordinates[$precinct]['ALL']['rVIETDEM'] + $coordinates[$precinct]['ALL']['rVIETDCL'] + $coordinates[$precinct]['ALL']['rVIETOTH'];


        $asn = $jap + $fil + $ind + $kor + $chi + $viet;

        $asnrep = $coordinates[$precinct]['ALL']['rJPNREP'] + $coordinates[$precinct]['ALL']['rFILREP'] + $coordinates[$precinct]['ALL']['rINDREP'] + $coordinates[$precinct]['ALL']['rKORREP'] + $coordinates[$precinct]['ALL']['rCHIREP'] + $coordinates[$precinct]['ALL']['rVIETREP'];
        $asndem = $coordinates[$precinct]['ALL']['rJPNDEM'] + $coordinates[$precinct]['ALL']['rFILDEM'] + $coordinates[$precinct]['ALL']['rINDDEM'] + $coordinates[$precinct]['ALL']['rKORDEM'] + $coordinates[$precinct]['ALL']['rCHIDEM'] + $coordinates[$precinct]['ALL']['rVIETDEM'];
        $asndcl = $coordinates[$precinct]['ALL']['rJPNDCL'] + $coordinates[$precinct]['ALL']['rFILDCL'] + $coordinates[$precinct]['ALL']['rINDDCL'] + $coordinates[$precinct]['ALL']['rKORDCL'] + $coordinates[$precinct]['ALL']['rCHIDCL'] + $coordinates[$precinct]['ALL']['rVIETDCL'];
        $asnoth = $coordinates[$precinct]['ALL']['rJPNOTH'] + $coordinates[$precinct]['ALL']['rFILOTH'] + $coordinates[$precinct]['ALL']['rINDOTH'] + $coordinates[$precinct]['ALL']['rKOROTH'] + $coordinates[$precinct]['ALL']['rCHIOTH'] + $coordinates[$precinct]['ALL']['rVIETOTH'];

        $asnrep_pct = makepct($asnrep, $asn);
        $asndem_pct = makepct($asndem, $asn);
        $asndcl_pct = makepct($asndcl, $asn);
        $asnoth_pct = makepct($asnoth, $asn);

        $jap_pct = makepct($jap, $tot);
        $fil_pct = makepct($fil, $tot);
        $ind_pct = makepct($ind, $tot);
        $kor_pct = makepct($kor, $tot);
        $chi_pct = makepct($chi, $tot);
        $viet_pct = makepct($viet, $tot);


        $dempct = makepct($dem, $tot);
        $reppct = makepct($rep, $tot);
        $npppct = makepct($npp, $tot);

        $latpct = makepct($lat, $tot);
        $asnpct = makepct($asn, $tot);

        $asnoffset = ($asn / $tot) * 100;
        $latoffset = ($lat / $tot) * 100;

        $latdem = $coordinates[$precinct]['ALL']['rHISPDEM'];
        $latrep = $coordinates[$precinct]['ALL']['rHISPREP'];
        $latdcl = $coordinates[$precinct]['ALL']['rHISPDCL'];
        $latoth = $coordinates[$precinct]['ALL']['rHISPOTH'];

        $latdem_pct = makepct($latdem, $lat);
        $latrep_pct = makepct($latrep, $lat);
        $latdcl_pct = makepct($latdcl, $lat);
        $latoth_pct = makepct($latoth, $lat);

        if ($lat) {
            $latin_head = "<p align='center'>Latino: $lat ($latpct)<br>";
            $latin_head .= "<span class='blueme'>DEM $latdem ($latdem_pct)</span>&nbsp;&mdash;&nbsp;";
            $latin_head .= "<span class='redme'>GOP $latrep ($latrep_pct)</span>&nbsp;&mdash;&nbsp;";
            $latin_head .= "<span class='grayme'>NPP $latdcl ($latdcl_pct)</span>&nbsp;&mdash;&nbsp;";
            $latin_head .= "<span class=''>OTH $latoth ($latoth_pct)</span></p>";
        } else {
            $latin_head = '';
        }


        if ($asn) {

            $asian_head = "<p align='center'>Asian $asn ($asnpct)<br>";

            if ($chi) {
                $asian_head .= " Chinese: $chi ($chi_pct) —";
            }

            if ($jap) {
                $asian_head .= " Japanese: $jap ($jap_pct) —";
            }

            if ($kor) {
                $asian_head .= " Korean: $kor ($kor_pct) —";
            }

            if ($viet) {
                $asian_head .= " Vietnamese: $viet ($viet_pct) —";
            }

            if ($fil) {
                $asian_head .= " Filipino: $fil ($fil_pct) —";
            }

            if ($ind) {
                $asian_head .= " E. Indian: $ind ($ind_pct) —";
            }


            $asian_head .= "<br><span class='blueme'>DEM $asndem ($asndem_pct)</span>&nbsp;&mdash;&nbsp;";
            $asian_head .= "<span class='redme'>GOP $asnrep ($asnrep_pct)</span>&nbsp;&mdash;&nbsp;";
            $asian_head .= "<span class='grayme'>NPP $asndcl ($asndcl_pct)</span>&nbsp;&mdash;&nbsp;";
            $asian_head .= "<span class=''>OTH $asnoth ($asnoth_pct)</span>&nbsp;&mdash;&nbsp;</p>";
        } else {
            $asian_head = "";
        }

        $ethnic = $latin_head . $asian_head;


        $dpp = ($dem / $tot) * 100;
        $rpp = ($rep / $tot) * 100;

        $dp = $dpp - $rpp;
        $rp = $rpp - $dpp;


        if ($dem > $rep) {
            if ($dp < 5) {
                $reg_color = get_blue(1);
            } elseif ($dp < 10) {
                $reg_color = get_blue(2);
            } elseif ($dp < 20) {
                $reg_color = get_blue(3);
            } elseif ($dp < 30) {
                $reg_color = get_blue(4);
            } elseif ($dp < 40) {
                $reg_color = get_blue(5);
            } elseif ($dp >= 40) {
                $reg_color = get_blue(6);
            }
        }

        if ($rep > $dem) {
            if ($rp < 3) {
                $reg_color = get_red(1);
            } elseif ($rp < 7) {
                $reg_color = get_red(2);
            } elseif ($rp < 13) {
                $reg_color = get_red(3);
            } elseif ($rp < 18) {
                $reg_color = get_red(4);
            } elseif ($rp < 25) {
                $reg_color = get_red(5);
            } elseif ($rp >= 25) {
                $reg_color = get_red(6);
            }
        }

        switch ($vis) {
            case "CD":
                $color = get_color($cdoffset);
                break;
            case "AD":
                $color = get_color($adoffset);
                //echo("<br>Got Color $color from offset $adoffset");
                break;
            case "SD":
                $color = get_color($sdoffset);
                break;
            case "REG":
                $color = $reg_color;
                break;
            case "GOV":
                //echo("<br>$precinct - GOV OFFSET: $govoffset");
                $color = get_color($govoffset);
                //echo("...returned COLOR: $color");
                break;
            case "LTG":
                $color = get_color($ltgoffset);
                break;
            case "ATG":
                $color = get_color($atgoffset);
                break;
            case "SOS":
                $color = get_color($sosoffset);
                break;
            case "CON":
                $color = get_color($conoffset);
                break;
            case "INS":
                $color = get_color($insoffset);
                break;
            case "TRS":
                $color = get_color($trsoffset);
                break;
            case "SPI":
                $color = get_color($spioffset);
                break;
            case "PRS":
                $color = get_color($prsoffset);
                break;
            case "DPP":
                $color = get_color($dppoffset);
                break;
            case "RPP":
                $color = get_color($rppoffset);
                break;
            case "SEN":
                $color = get_color($senoffset);
                break;
            case "LAT":
                $color = get_ethnic_heatmap($latoffset);
                //echo("<br>fed $latoffset, got <span style='color: $color;'>$color back</span>");
                break;
            case "ASN":
                $color = get_ethnic_heatmap($asnoffset);
                break;
            case "VOT":
                $color = get_ethnic_heatmap($turnoutoffset);
                break;
            case "POP":
                $color = get_population_heatmap($reg);
        }

        //echo("...left routine with COLOR: $color");

        if (!$coordinates[$precinct]['COORDINATES'] && !$coordinates[$precinct]['POLYS']) {
            continue;
        }

        if ($tot == 0) {
            $color = '';
        }

        $container_start = "<div class='container;' style='display: inline-block;'>";
        $container_end = "</div>";


        $htmlhead = "<section class='newseg boldme'><h1 align='center'>$precinct</h1><p align='center' class='boldme'>$verbosecounty County</p><p align='center' class='boldme'>REGISTERED: $reg&nbsp;&mdash;&nbsp;VOTED: $vot&nbsp;&mdash;&nbsp;TURNOUT: $turnout<br>";
        $htmlhead .= "<span class='blueme'>DEM: $dem ($dempct)</span>&nbsp;<span class='redme'>GOP: $rep ($reppct)</span>&nbsp;<span class='grayme'>NPP: $npp ($npppct)</span>$ethnic</section>";

        $ad_undervote = makepct(($vot - $ad_vote), $vot);
        $sd_append = '';
        if ($sd_vote) {
            $sd_undervote = makepct(($vot - $sd_vote), $vot);
            $sd_append = " ($sd_undervote Undervote)";
        }
        $cd_undervote = makepct(($vot - $cd_vote), $vot);

        $legraces = "<section class='boldme newseg' style='clear: both; display: inline-block; width: 99%; margin-left: auto; margin-right: auto;'>";
        $legraces .= "<div class='stw'>$ad - $ad_vote Votes ($ad_undervote Undervote)<br>$ad_candidates</div>";
        $legraces .= "<div class='stw'>$sd - $sd_vote Votes$sd_append<br>$sd_candidates</div>";
        $legraces .= "<div class='stw'>$cd - $cd_vote Votes ($cd_undervote Undervote)<br>$cd_candidates</div></section>";

        if ($num_gov_candidates > 0) {

            $gov_undervote = makepct(($vot - $gov_vote), $vot);
            $ltg_undervote = makepct(($vot - $ltg_vote), $vot);
            $atg_undervote = makepct(($vot - $atg_vote), $vot);
            $trs_undervote = makepct(($vot - $trs_vote), $vot);
            $con_undervote = makepct(($vot - $con_vote), $vot);
            $sos_undervote = makepct(($vot - $sos_vote), $vot);
            $ins_undervote = makepct(($vot - $ins_vote), $vot);
            $spi_undervote = makepct(($vot - $spi_vote), $vot);

            $statewide = '';
            $statewide = "<section class='boldme newseg' align='center' style='clear: both; display: inline-block; width: 99%;'>";
            $statewide .= "<div class='container' width='100%' style='clear: both;'>";
            $statewide .= "<div class='stw'>GOV - $gov_vote Votes ($gov_undervote Undervote)<br>$gov_candidates</div>";
            $statewide .= "<div class='stw'>LTG - $ltg_vote Votes ($ltg_undervote Undervote)<br>$ltg_candidates</div>";
            $statewide .= "<div class='stw'>ATG - $atg_vote Votes ($atg_undervote Undervote)<br>$atg_candidates</div>";
            $statewide .= "</div><div class='container' width='100%' style='clear: both;'>";
            $statewide .= "<div class='stw'>SOS - $sos_vote Votes ($sos_undervote Undervote)<br>$sos_candidates</div>";
            $statewide .= "<div class='stw'>TRS - $trs_vote Votes ($trs_undervote Undervote)<br>$trs_candidates</div>";
            $statewide .= "<div class='stw'>INS - $ins_vote Votes ($ins_undervote Undervote)<br>$ins_candidates</div>";
            $statewide .= "</div><div class='container' width='100%' style='clear: both;'>";
            $statewide .= "<div class='stw'>CON - $con_vote Votes ($con_undervote Undervote)<br>$con_candidates</div>";
            $statewide .= "<div class='stw'>SPI - $spi_vote Votes ($spi_undervote Undervote)<br>$spi_candidates</div>";
            $statewide .= "</div></section>";
        }

        if ($num_sen_candidates > 0) {
            $ussenate = '';
            $sen_undervote = makepct(($vot - $sen_vote), $vot);
            $ussenate = "<section class='boldme newseg' align='center' style='clear: both; display: inline-block; width: 99%;>";
            $ussenate .= "<div class='stw'>US SENATE - $sen_vote Votes ($sen_undervote Undervote)<br>$sen_candidates</div></section>";
        }

        if ($num_prs_candidates > 0) {
            if (mb_substr($election, 0, 1) == "p") {
                $presidential = '';
                $presidential = "<section class='boldme newseg' align='center' style='clear: both; display: inline-block; width: 98%;'>";
                $presidential .= "<div class='container' width='100%' style='clear: both;'>";
                $presidential .= "<div class='stw'>PRESIDENT (DEM PRIMARY) - $dpp_vote Votes<br>$dpp_candidates</div>";
                $presidential .= "<div class='stw'>PRESIDENT (GOP PRIMARY) - $rpp_vote Votes<br>$rpp_candidates</div>";
                $presidential .= "</div></section>";
            } else {
                $prs_undervote = makepct(($vot - $prs_vote), $vot);
                $presidential = '';
                $presidential = "<section class='boldme newseg' align='center' style='clear: both; display: inline-block; width: 98%;'>";
                $presidential .= "<div class='container' width='100%' style='clear: both;'>";
                $presidential .= "<div class='stw'>PRESIDENT OF THE UNITED STATES - $prs_vote Votes ($prs_undervote Undervote)</br>$prs_candidates</div>";
                $presidential .= "</div></section>";
            }
        }

        //echo("...and populating HTML with <span style='color: \"$color;\"'>color $color</span>");

        $html = $container_start . $htmlhead . $presidential . $legraces . $statewide . $ussenate . $prop_html . $container_end;

        if ($coordinates[$precinct]['POLYS']) {
            foreach ($coordinates[$precinct]['POLYS'] as $polygons) {
                //echo("...MULTIPOLYGON");


                $js = "
				polys[$i] = new google.maps.Polygon({
					html: \"$html\",
					fillColor: \"$color\",
					strokeColor: \"$color\",
					strokeWeight: 2,
					paths: " . $polygons . "
				});

				polys[$i].setMap(map);


				polys[$i].addListener('click', showArrays);

			";
                array_push($endjava, $js);
                $i++;

            }
        } else {

            $js = "
			polys[$i] = new google.maps.Polygon({
				html: \"$html\",
				fillColor: \"$color\",
				strokeColor: \"$color\",
				strokeWeight: 2,
				paths: " . $coordinates[$precinct]['COORDINATES'] . "
			});

			polys[$i].setMap(map);


			polys[$i].addListener('click', showArrays);

		";
            array_push($endjava, $js);
            $i++;
        }
        $count++;
    }


    $js = "

	  function showArrays(event) {
	  	html = this.html;
	  	var contentString = html;

  		infowindow.setContent(contentString);
  		infowindow.setPosition(event.latLng);
  		infowindow.open(map);

	  }

}";
    array_push($endjava, $js);


    echo("<div id='map_canvas' width='800px' height='600px'></div>");
    echo("<div id='map' width='800px' height='600px'></div>");


    /*


         OOOOOOOOO                                                                  lllllll
       OO:::::::::OO                                                                l:::::l
     OO:::::::::::::OO                                                              l:::::l
    O:::::::OOO:::::::O                                                             l:::::l
    O::::::O   O::::::Ovvvvvvv           vvvvvvv eeeeeeeeeeee    rrrrr   rrrrrrrrr   l::::l   aaaaaaaaaaaaa  ppppp   ppppppppp       ssssssssss
    O:::::O     O:::::O v:::::v         v:::::vee::::::::::::ee  r::::rrr:::::::::r  l::::l   a::::::::::::a p::::ppp:::::::::p    ss::::::::::s
    O:::::O     O:::::O  v:::::v       v:::::ve::::::eeeee:::::eer:::::::::::::::::r l::::l   aaaaaaaaa:::::ap:::::::::::::::::p ss:::::::::::::s
    O:::::O     O:::::O   v:::::v     v:::::ve::::::e     e:::::err::::::rrrrr::::::rl::::l            a::::app::::::ppppp::::::ps::::::ssss:::::s
    O:::::O     O:::::O    v:::::v   v:::::v e:::::::eeeee::::::e r:::::r     r:::::rl::::l     aaaaaaa:::::a p:::::p     p:::::p s:::::s  ssssss
    O:::::O     O:::::O     v:::::v v:::::v  e:::::::::::::::::e  r:::::r     rrrrrrrl::::l   aa::::::::::::a p:::::p     p:::::p   s::::::s
    O:::::O     O:::::O      v:::::v:::::v   e::::::eeeeeeeeeee   r:::::r            l::::l  a::::aaaa::::::a p:::::p     p:::::p      s::::::s
    O::::::O   O::::::O       v:::::::::v    e:::::::e            r:::::r            l::::l a::::a    a:::::a p:::::p    p::::::pssssss   s:::::s
    O:::::::OOO:::::::O        v:::::::v     e::::::::e           r:::::r           l::::::la::::a    a:::::a p:::::ppppp:::::::ps:::::ssss::::::s
     OO:::::::::::::OO          v:::::v       e::::::::eeeeeeee   r:::::r           l::::::la:::::aaaa::::::a p::::::::::::::::p s::::::::::::::s
       OO:::::::::OO             v:::v         ee:::::::::::::e   r:::::r           l::::::l a::::::::::aa:::ap::::::::::::::pp   s:::::::::::ss
         OOOOOOOOO                vvv            eeeeeeeeeeeeee   rrrrrrr           llllllll  aaaaaaaaaa  aaaap::::::pppppppp      sssssssssss
                                                                                                              p:::::p
                                                                                                              p:::::p
                                                                                                             p:::::::p
                                                                                                             p:::::::p
                                                                                                             p:::::::p
                                                                                                             ppppppppp


    */


    function get_overlaps($fourcode)
    {
        global $ctb2016_conn;

        global $election;
        //$election = 'g14';
        $conn = Util::get_ctb_conn();
        $x = getdisttype($fourcode);
        $disttype = $x['disttype'];
        $distno = $x['distno'];

        $year = mb_substr($election, 1, 2);
        if ($year < 12) {
            $use_districts = "g08";
        } else {
            $use_districts = "g14";
        }

        $sql = "SELECT * FROM ctb2016_$use_districts WHERE $disttype = '$distno' GROUP BY county, cddist, addist, sddist";
        //echo("<br>OVERLAPS SQL:<br>$sql<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['addist']) {
                    $ad = "AD" . checkaddzero($row['addist']);
                    $sd = "SD" . checkaddzero($row['sddist']);
                    $cd = "CD" . checkaddzero($row['cddist']);
                    $boe = "BOE" . $row['bedist'];
                    $co = "CO" . checkaddzero($row['county']);
                    $retval[$co] = $row['county'];
                } else {
                    $ad = "AD" . checkaddzero($row['ADDIST']);
                    $sd = "SD" . checkaddzero($row['SDDIST']);
                    $cd = "CD" . checkaddzero($row['CDDIST']);
                    $boe = "BOE" . $row['BEDIST'];
                    $co = "CO" . checkaddzero($row['COUNTY']);
                    $retval[$co] = $row['COUNTY'];
                }

                $retval[$ad] = $ad;
                $retval[$sd] = $sd;
                $retval[$cd] = $cd;
                $retval[$boe] = $boe;
            }
        }

        return $retval;
    }

    /*

            CCCCCCCCCCCCC                 lllllll
         CCC::::::::::::C                 l:::::l
       CC:::::::::::::::C                 l:::::l
      C:::::CCCCCCCC::::C                 l:::::l
     C:::::C       CCCCCC   ooooooooooo    l::::l    ooooooooooo   rrrrr   rrrrrrrrr       ssssssssss
    C:::::C               oo:::::::::::oo  l::::l  oo:::::::::::oo r::::rrr:::::::::r    ss::::::::::s
    C:::::C              o:::::::::::::::o l::::l o:::::::::::::::or:::::::::::::::::r ss:::::::::::::s
    C:::::C              o:::::ooooo:::::o l::::l o:::::ooooo:::::orr::::::rrrrr::::::rs::::::ssss:::::s
    C:::::C              o::::o     o::::o l::::l o::::o     o::::o r:::::r     r:::::r s:::::s  ssssss
    C:::::C              o::::o     o::::o l::::l o::::o     o::::o r:::::r     rrrrrrr   s::::::s
    C:::::C              o::::o     o::::o l::::l o::::o     o::::o r:::::r                  s::::::s
     C:::::C       CCCCCCo::::o     o::::o l::::l o::::o     o::::o r:::::r            ssssss   s:::::s
      C:::::CCCCCCCC::::Co:::::ooooo:::::ol::::::lo:::::ooooo:::::o r:::::r            s:::::ssss::::::s
       CC:::::::::::::::Co:::::::::::::::ol::::::lo:::::::::::::::o r:::::r            s::::::::::::::s
         CCC::::::::::::C oo:::::::::::oo l::::::l oo:::::::::::oo  r:::::r             s:::::::::::ss
            CCCCCCCCCCCCC   ooooooooooo   llllllll   ooooooooooo    rrrrrrr              sssssssssss


    */

    function get_color($offset)
    {
        $colors = Array(
            "#FF0000", //RED
            "#0000FF", //BLUE
            "#00FF00", //GREEN
            "#FFFF00", //YELLOW
            "#FF00FF", //PURPLE
            "#00FFFF", //LT BLUE
            "#FFA800", //ORANGE
            "#770000", //DARK RED
            "#001677", //DARK BLUE
            "#116700", //DARK GREEN
            "#8E9631", //DARK YELLOW
            "#B0B0FF", //LIGHTEST BLUE
            "#6F0000",  //DARKEST RED
            "#8080FF", //
            "#FFB0B0", //LIGHTEST RED
            "#9F0000", //
            "#CF0000", //
            "#4040FF", //
            "#0000CF", //
            "#FF4040", //
            "#00009F", //
            "#FF8080", //
            "#00006F" //DARKEST BLUE
        );

        return $colors[$offset];
    }

    function get_red($offset)
    {
        $colors = Array(
            "#FFB0B0", //LIGHTEST
            "#FF8080", //
            "#FF4040", //
            "#FF0000", //MIDDLE
            "#CF0000", //
            "#9F0000", //
            "#6F0000"  //DARKEST
        );

        return $colors[$offset];
    }

    function get_blue($offset)
    {
        $colors = Array(
            "#B0B0FF", //LIGHTEST
            "#8080FF", //
            "#4040FF", //
            "#0000FF", //MIDDLE
            "#0000CF", //
            "#00009F", //
            "#00006F"  //DARKEST
        );

        return $colors[$offset];
    }

    function get_ethnic_heatmap($pct)
    {

        if ($pct < 100) {
            $retval = "#820000"; //DARKEST RED
        }

        if ($pct < 90) {
            $retval = "#B60000"; //DARK RED
        }

        if ($pct < 80) {
            $retval = "#FF0000"; //BRIGHT RED
        }

        if ($pct < 70) {
            $retval = "#FF6000"; //RED/ORANGE
        }

        if ($pct < 60) {
            $retval = "#FF9000"; //ORANGE
        }

        if ($pct < 50) {
            $retval = "#FFC000"; //MUSTARD
        }

        if ($pct < 40) {
            $retval = "#FFF000"; //YELLOW
        }

        if ($pct < 30) {
            $retval = "#D0FF00"; //YELLOW/GREEN
        }

        if ($pct < 20) {
            $retval = "#A0FF00"; // LIGHT GREEN
        }

        if ($pct < 15) {
            $retval = "#40FF00"; //GREEN
        }

        if ($pct < 10) {
            $retval = "#00FFBA"; //LIGHT BLUE/GREEN
        }

        if ($pct < 5) {
            $retval = "#00FFF6"; //ICE BLUE
        }

        return $retval;

    }

    function get_population_heatmap($reg)
    {

        if ($reg >= 3000) {
            $retval = "#820000"; //DARKEST RED
        }

        if ($reg < 3000) {
            $retval = "#B60000"; //DARK RED
        }

        if ($reg < 2000) {
            $retval = "#FF0000"; //BRIGHT RED
        }

        if ($reg < 1000) {
            $retval = "#FF6000"; //RED/ORANGE
        }

        if ($reg < 750) {
            $retval = "#FF9000"; //ORANGE
        }

        if ($reg < 500) {
            $retval = "#FFC000"; //MUSTARD
        }

        if ($reg < 400) {
            $retval = "#FFF000"; //YELLOW
        }

        if ($reg < 300) {
            $retval = "#D0FF00"; //YELLOW/GREEN
        }

        if ($reg < 200) {
            $retval = "#A0FF00"; // LIGHT GREEN
        }

        if ($reg < 100) {
            $retval = "#40FF00"; //GREEN
        }

        if ($reg < 50) {
            $retval = "#00FFBA"; //LIGHT BLUE/GREEN
        }

        if ($reg < 25) {
            $retval = "#00FFF6"; //ICE BLUE
        }

        return $retval;


    }


    /*

                                                                        dddddddd
            CCCCCCCCCCCCC                                               d::::::d
         CCC::::::::::::C                                               d::::::d
       CC:::::::::::::::C                                               d::::::d
      C:::::CCCCCCCC::::C                                               d:::::d
     C:::::C       CCCCCC  aaaaaaaaaaaaa  nnnn  nnnnnnnn        ddddddddd:::::d     ssssssssss
    C:::::C                a::::::::::::a n:::nn::::::::nn    dd::::::::::::::d   ss::::::::::s
    C:::::C                aaaaaaaaa:::::an::::::::::::::nn  d::::::::::::::::d ss:::::::::::::s
    C:::::C                         a::::ann:::::::::::::::nd:::::::ddddd:::::d s::::::ssss:::::s
    C:::::C                  aaaaaaa:::::a  n:::::nnnn:::::nd::::::d    d:::::d  s:::::s  ssssss
    C:::::C                aa::::::::::::a  n::::n    n::::nd:::::d     d:::::d    s::::::s
    C:::::C               a::::aaaa::::::a  n::::n    n::::nd:::::d     d:::::d       s::::::s
     C:::::C       CCCCCCa::::a    a:::::a  n::::n    n::::nd:::::d     d:::::d ssssss   s:::::s
      C:::::CCCCCCCC::::Ca::::a    a:::::a  n::::n    n::::nd::::::ddddd::::::dds:::::ssss::::::s
       CC:::::::::::::::Ca:::::aaaa::::::a  n::::n    n::::n d:::::::::::::::::ds::::::::::::::s
         CCC::::::::::::C a::::::::::aa:::a n::::n    n::::n  d:::::::::ddd::::d s:::::::::::ss
            CCCCCCCCCCCCC  aaaaaaaaaa  aaaa nnnnnn    nnnnnn   ddddddddd   ddddd  sssssssssss

            */


    function get_candidates($fourcode)
    {
        global $ctb2016_conn;
        global $candidate_array;
        global $election;
        $conn = Util::get_ctb_conn();


        //$election = 'p16';
        //$eyear = mb_substr($election, 1,2);
        //$esearch = "p" . $eyear;


        $x = getdisttype($fourcode);
        $disttype = $x['disttype'];
        $distno = $x['distno'];
        //$sql = "SELECT distkey, party, name, is_incumbent, disttype, CAST(distnum AS UNSIGNED) AS distnum FROM candidates where disttype='$disttype' && distnum='$distno' && election = '$election'";
        $sql = "SELECT * FROM ctb2016_candidates WHERE disttype = '$disttype' && (distnum = '$distno' || distnum = '" . checkaddzero($distno) . "') && election = '$election'";
        //echo("<br>$fourcode<br>$sql<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $distkey = $row['distkey'];
                $party = $row['party'];
                $name = $row['name'];
                $is_incumbent = $row['is_incumbent'];

                $race = mb_substr($distkey, 0, 3);

                if ($race == "CNG" || $race == "SEN" || $race == "ASS") {
                    $fourcode = $fourcode;
                } else {
                    if ($race == "GOV" || $race == "LTG" || $race == "SPI" || $race == "SOS" || $race == "ATG" || $race == "TRS" || $race == "CON" || $race == "PRS" || $race == "INS" || $race == "USS") {
                        //echo("<br>GOT $race");
                        $fourcode = "." . $race;
                    } else {
                        $string = $row['race'];
                        $regex = "~PR_(.*?)_~";
                        preg_match($regex, $string, $results);
                        $prop_no = $results[1];
                        $position = substr($string, -1);
                        $fourcode = "PR" . $prop_no . $position;
                        //$fourcode = "PROP";
                    }
                }
                $candidate_array[$fourcode][$distkey]['RACE'] = $row['race'];
                $candidate_array[$fourcode][$distkey]['DISTKEY'] = $distkey;
                $candidate_array[$fourcode][$distkey]['PARTY'] = $party;
                $candidate_array[$fourcode][$distkey]['INCUMBENT'] = $is_incumbent;
                $candidate_array[$fourcode][$distkey]['NAME'] = $name;


            }
        }
    }

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

    function votesort($a, $b)
    {

        if ($a['PRECVOT'] < $b['PRECVOT']) {
            return 1;
        } elseif ($a['PRECVOT'] > $b['PRECVOT']) {
            return -1;
        } else {
            return 0;
        }
    }

    /*

       SSSSSSSSSSSSSSS      tttt                                    tttt
     SS:::::::::::::::S  ttt:::t                                 ttt:::t
    S:::::SSSSSS::::::S  t:::::t                                 t:::::t
    S:::::S     SSSSSSS  t:::::t                                 t:::::t
    S:::::S        ttttttt:::::ttttttt      aaaaaaaaaaaaa  ttttttt:::::ttttttt
    S:::::S        t:::::::::::::::::t      a::::::::::::a t:::::::::::::::::t
     S::::SSSS     t:::::::::::::::::t      aaaaaaaaa:::::at:::::::::::::::::t
      SS::::::SSSSStttttt:::::::tttttt               a::::atttttt:::::::tttttt
        SSS::::::::SS    t:::::t              aaaaaaa:::::a      t:::::t
           SSSSSS::::S   t:::::t            aa::::::::::::a      t:::::t
                S:::::S  t:::::t           a::::aaaa::::::a      t:::::t
                S:::::S  t:::::t    tttttta::::a    a:::::a      t:::::t    tttttt
    SSSSSSS     S:::::S  t::::::tttt:::::ta::::a    a:::::a      t::::::tttt:::::t
    S::::::SSSSSS:::::S  tt::::::::::::::ta:::::aaaa::::::a      tt::::::::::::::t
    S:::::::::::::::SS     tt:::::::::::tt a::::::::::aa:::a       tt:::::::::::tt
     SSSSSSSSSSSSSSS         ttttttttttt    aaaaaaaaaa  aaaa         ttttttttttt

    */

    function get_stats($precinct, $county)
    {
        global $ctb2016_conn;
        global $election;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT * FROM ctb2016_$election WHERE srprec = '$precinct' &&  county = '$county'";
        //echo("<br>STATS SQL:<br>$sql<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row['addist']) {
                    $retval['AD'] = $row['addist'];
                    $retval['CD'] = $row['cddist'];
                    $retval['SD'] = $row['sddist'];
                } else {
                    $retval['AD'] = $row['ADDIST'];
                    $retval['CD'] = $row['CDDIST'];
                    $retval['SD'] = $row['SDDIST'];
                }
                $retval['TOTREG'] = $row['TOTREG'];
                $retval['TOTVOTE'] = $row['TOTVOTE'];
                $retval['ALL'] = $row;
            }
        }

        return $retval;
    }

    /*

            GGGGGGGGGGGGG                             tttt             SSSSSSSSSSSSSSS RRRRRRRRRRRRRRRRR   PPPPPPPPPPPPPPPPP   RRRRRRRRRRRRRRRRR           CCCCCCCCCCCCC
         GGG::::::::::::G                          ttt:::t           SS:::::::::::::::SR::::::::::::::::R  P::::::::::::::::P  R::::::::::::::::R       CCC::::::::::::C
       GG:::::::::::::::G                          t:::::t          S:::::SSSSSS::::::SR::::::RRRRRR:::::R P::::::PPPPPP:::::P R::::::RRRRRR:::::R    CC:::::::::::::::C
      G:::::GGGGGGGG::::G                          t:::::t          S:::::S     SSSSSSSRR:::::R     R:::::RPP:::::P     P:::::PRR:::::R     R:::::R  C:::::CCCCCCCC::::C
     G:::::G       GGGGGG    eeeeeeeeeeee    ttttttt:::::ttttttt    S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::R C:::::C       CCCCCC
    G:::::G                ee::::::::::::ee  t:::::::::::::::::t    S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::RC:::::C
    G:::::G               e::::::eeeee:::::eet:::::::::::::::::t     S::::SSSS           R::::RRRRRR:::::R   P::::PPPPPP:::::P   R::::RRRRRR:::::R C:::::C
    G:::::G    GGGGGGGGGGe::::::e     e:::::etttttt:::::::tttttt      SS::::::SSSSS      R:::::::::::::RR    P:::::::::::::PP    R:::::::::::::RR  C:::::C
    G:::::G    G::::::::Ge:::::::eeeee::::::e      t:::::t              SSS::::::::SS    R::::RRRRRR:::::R   P::::PPPPPPPPP      R::::RRRRRR:::::R C:::::C
    G:::::G    GGGGG::::Ge:::::::::::::::::e       t:::::t                 SSSSSS::::S   R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
    G:::::G        G::::Ge::::::eeeeeeeeeee        t:::::t                      S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C
     G:::::G       G::::Ge:::::::e                 t:::::t    tttttt            S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::R C:::::C       CCCCCC
      G:::::GGGGGGGG::::Ge::::::::e                t::::::tttt:::::tSSSSSSS     S:::::SRR:::::R     R:::::RPP::::::PP          RR:::::R     R:::::R  C:::::CCCCCCCC::::C
       GG:::::::::::::::G e::::::::eeeeeeee        tt::::::::::::::tS::::::SSSSSS:::::SR::::::R     R:::::RP::::::::P          R::::::R     R:::::R   CC:::::::::::::::C
         GGG::::::GGG:::G  ee:::::::::::::e          tt:::::::::::ttS:::::::::::::::SS R::::::R     R:::::RP::::::::P          R::::::R     R:::::R     CCC::::::::::::C
            GGGGGG   GGGG    eeeeeeeeeeeeee            ttttttttttt   SSSSSSSSSSSSSSS   RRRRRRRR     RRRRRRRPPPPPPPPPP          RRRRRRRR     RRRRRRR        CCCCCCCCCCCCC

    */


    function get_precincts($fourcode)
    {
        global $ctb2016_conn;
        global $election;
        $conn = Util::get_ctb_conn();

        $x = getdisttype($fourcode);
        $disttype = $x['disttype'];
        $distno = $x['distno'];

        $retval = Array();


        $sql = "SELECT srprec, county FROM ctb2016_$election WHERE $disttype = '$distno'";
        echo("<br>RETRIEVING PRECINCTS USING<br>$sql<br>");
        $result = $conn->query($sql);
	$i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
		if($i > 2) {
			break;
		}
                $tmp['srprec'] = $row['srprec'];
                $tmp['county'] = $row['county'];
                array_push($retval, $tmp);
		$i++;
            }
        }
        //echo("<br>RETURNING:<br>");
        //var_dump($retval);
	
        return $retval;
    }

    /*

       SSSSSSSSSSSSSSS RRRRRRRRRRRRRRRRR   PPPPPPPPPPPPPPPPP   RRRRRRRRRRRRRRRRR           CCCCCCCCCCCCCPPPPPPPPPPPPPPPPP                   lllllll
     SS:::::::::::::::SR::::::::::::::::R  P::::::::::::::::P  R::::::::::::::::R       CCC::::::::::::CP::::::::::::::::P                  l:::::l
    S:::::SSSSSS::::::SR::::::RRRRRR:::::R P::::::PPPPPP:::::P R::::::RRRRRR:::::R    CC:::::::::::::::CP::::::PPPPPP:::::P                 l:::::l
    S:::::S     SSSSSSSRR:::::R     R:::::RPP:::::P     P:::::PRR:::::R     R:::::R  C:::::CCCCCCCC::::CPP:::::P     P:::::P                l:::::l
    S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::R C:::::C       CCCCCC  P::::P     P:::::P  ooooooooooo    l::::lyyyyyyy           yyyyyyy
    S:::::S              R::::R     R:::::R  P::::P     P:::::P  R::::R     R:::::RC:::::C                P::::P     P:::::Poo:::::::::::oo  l::::l y:::::y         y:::::y
     S::::SSSS           R::::RRRRRR:::::R   P::::PPPPPP:::::P   R::::RRRRRR:::::R C:::::C                P::::PPPPPP:::::Po:::::::::::::::o l::::l  y:::::y       y:::::y
      SS::::::SSSSS      R:::::::::::::RR    P:::::::::::::PP    R:::::::::::::RR  C:::::C                P:::::::::::::PP o:::::ooooo:::::o l::::l   y:::::y     y:::::y
        SSS::::::::SS    R::::RRRRRR:::::R   P::::PPPPPPPPP      R::::RRRRRR:::::R C:::::C                P::::PPPPPPPPP   o::::o     o::::o l::::l    y:::::y   y:::::y
           SSSSSS::::S   R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C                P::::P           o::::o     o::::o l::::l     y:::::y y:::::y
                S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::RC:::::C                P::::P           o::::o     o::::o l::::l      y:::::y:::::y
                S:::::S  R::::R     R:::::R  P::::P              R::::R     R:::::R C:::::C       CCCCCC  P::::P           o::::o     o::::o l::::l       y:::::::::y
    SSSSSSS     S:::::SRR:::::R     R:::::RPP::::::PP          RR:::::R     R:::::R  C:::::CCCCCCCC::::CPP::::::PP         o:::::ooooo:::::ol::::::l       y:::::::y
    S::::::SSSSSS:::::SR::::::R     R:::::RP::::::::P          R::::::R     R:::::R   CC:::::::::::::::CP::::::::P         o:::::::::::::::ol::::::l        y:::::y
    S:::::::::::::::SS R::::::R     R:::::RP::::::::P          R::::::R     R:::::R     CCC::::::::::::CP::::::::P          oo:::::::::::oo l::::::l       y:::::y
     SSSSSSSSSSSSSSS   RRRRRRRR     RRRRRRRPPPPPPPPPP          RRRRRRRR     RRRRRRR        CCCCCCCCCCCCCPPPPPPPPPP            ooooooooooo   llllllll      y:::::y
                                                                                                                                                         y:::::y
                                                                                                                                                        y:::::y
                                                                                                                                                       y:::::y
                                                                                                                                                      y:::::y
                                                                                                                                                     yyyyyyy



    */


    function get_precinct_polygons($srprec, $county)
    {
        global $precincts_conn;
        $conn = Util::get_ctb_conn();
        global $table;
        global $election;
        global $dist;
        if (mb_substr($dist, 0, 1) == "0") {
            $dist = mb_substr($dist, 1, 1);
        }

        if (preg_match("/[a-z]/i", $srprec)) {
            $has_alpha = TRUE;
        }

        if (preg_match("~\-~", $srprec)) {
            $has_alpha = TRUE;
        }

        $numcheck = (int)$srprec;
        if (!$has_alpha) {
            $srprec = $numcheck;
            $sql = "SELECT CAST(SRPREC AS UNSIGNED) AS SRPREC,  ST_AsText(SHAPE) AS SHAPE FROM precincts_precincts WHERE SRPREC = $srprec && COUNTY = '$county' && ELECTION = '$election'";
        } else {
            $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM precincts_precincts WHERE SRPREC = '$srprec' && COUNTY = '$county' && ELECTION = '$election'";
        }

        global $dumpmode;
        if ($dumpmode) {
            echo("<br>SQL POLY QUERY FOR PRECINCT $srprec<br>$sql<br>");
        }

        //echo("<br>$sql<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['SHAPE'];
            }
        }
        if ($dumpmode) {
            echo("<br>Returning: $retval</br>");
        }

        return $retval;
    }

    /*


    PPPPPPPPPPPPPPPPP                                                                         PPPPPPPPPPPPPPPPP                   lllllll
    P::::::::::::::::P                                                                        P::::::::::::::::P                  l:::::l
    P::::::PPPPPP:::::P                                                                       P::::::PPPPPP:::::P                 l:::::l
    PP:::::P     P:::::P                                                                      PP:::::P     P:::::P                l:::::l
      P::::P     P:::::Paaaaaaaaaaaaa  rrrrr   rrrrrrrrr       ssssssssss       eeeeeeeeeeee    P::::P     P:::::P  ooooooooooo    l::::lyyyyyyy           yyyyyyy
      P::::P     P:::::Pa::::::::::::a r::::rrr:::::::::r    ss::::::::::s    ee::::::::::::ee  P::::P     P:::::Poo:::::::::::oo  l::::l y:::::y         y:::::y
      P::::PPPPPP:::::P aaaaaaaaa:::::ar:::::::::::::::::r ss:::::::::::::s  e::::::eeeee:::::eeP::::PPPPPP:::::Po:::::::::::::::o l::::l  y:::::y       y:::::y
      P:::::::::::::PP           a::::arr::::::rrrrr::::::rs::::::ssss:::::se::::::e     e:::::eP:::::::::::::PP o:::::ooooo:::::o l::::l   y:::::y     y:::::y
      P::::PPPPPPPPP      aaaaaaa:::::a r:::::r     r:::::r s:::::s  ssssss e:::::::eeeee::::::eP::::PPPPPPPPP   o::::o     o::::o l::::l    y:::::y   y:::::y
      P::::P            aa::::::::::::a r:::::r     rrrrrrr   s::::::s      e:::::::::::::::::e P::::P           o::::o     o::::o l::::l     y:::::y y:::::y
      P::::P           a::::aaaa::::::a r:::::r                  s::::::s   e::::::eeeeeeeeeee  P::::P           o::::o     o::::o l::::l      y:::::y:::::y
      P::::P          a::::a    a:::::a r:::::r            ssssss   s:::::s e:::::::e           P::::P           o::::o     o::::o l::::l       y:::::::::y
    PP::::::PP        a::::a    a:::::a r:::::r            s:::::ssss::::::se::::::::e        PP::::::PP         o:::::ooooo:::::ol::::::l       y:::::::y
    P::::::::P        a:::::aaaa::::::a r:::::r            s::::::::::::::s  e::::::::eeeeeeeeP::::::::P         o:::::::::::::::ol::::::l        y:::::y
    P::::::::P         a::::::::::aa:::ar:::::r             s:::::::::::ss    ee:::::::::::::eP::::::::P          oo:::::::::::oo l::::::l       y:::::y
    PPPPPPPPPP          aaaaaaaaaa  aaaarrrrrrr              sssssssssss        eeeeeeeeeeeeeePPPPPPPPPP            ooooooooooo   llllllll      y:::::y
                                                                                                                                               y:::::y
                                                                                                                                              y:::::y
                                                                                                                                             y:::::y
                                                                                                                                            y:::::y
                                                                                                                                           yyyyyyy



    */

    function parse_poly_strings($string)
    {
        //echo("<br>PARSING STRING...<br>");
        //echo($string);
        if (strpos($string, "MULTIPOLYGON") === FALSE) {

            $retval = '[';
            $initial = str_replace("(", "", $string);
            $initial = str_replace(")", "", $initial);
            $initial = str_replace("POLYGON", "", $initial);
            $initial = str_replace("MULTI", "", $initial);
            //echo("<br>STRIPPED CHARACTERS, STRING IS NOW:<br>$initial");
            $arr = explode(",", $initial);

            $first = '';
            foreach ($arr as $value) {
                $coordinates = explode(" ", $value);
                $lat = $coordinates[1];
                $lng = $coordinates[0];
                //echo("<br>LAT: $lat LNG: $lng<br>");
                $retval .= "\n{lat: $lat, lng: $lng},";

            }
            $retval = rtrim($retval, ',');
            $retval .= "],";

            //echo("<br>RETURNING:<br>$retval<br>");
            return $retval;
        } else {

            $retval = Array();

            //echo("<br>FOUND MULTIPOLYGON STRING<br>");
            //echo($string);
            $dumpmode = TRUE;


            $initial = str_replace("MULTIPOLYGON(", "", $string);
            $arr = explode("((", $initial);
            $i = 0;
            foreach ($arr as $poly) {
                $tmp = "[";
                $poly = str_replace("(", "", $poly);
                $poly = str_replace(")", "", $poly);
                $points = explode(",", $poly);
                foreach ($points as $entry) {
                    $coordinates = explode(" ", $entry);
                    $lat = $coordinates[1];
                    $lng = $coordinates[0];
                    if ($lat && $lng) {
                        $tmp .= "\n{lat: $lat, lng: $lng},";
                    }
                }
                $tmp = rtrim($tmp, ',');
                $tmp .= "],";
                if ($i > 0) {
                    array_push($retval, $tmp);
                }


                $i++;

            }
            //$retval[$i] = rtrim($retval[$i], ',');
            //$retval .= "],";
            //$retval = str_replace("(),", "", $retval);
            //echo("<br>PARSED MULTIPOLYGON STRING RETURNS ARRAY VALUES:<br>");
            //var_dump($retval);
            return $retval;

        }

    }


    ?>


@endsection

@section('scripts')

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>
    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>

    
@endsection

@section('styles')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map {
        height: 100%;
    }

    .gm-style-iw {
        height: 900px !important;
        width: 600px !important;
    }

    .newseg .stw {
        float: left;
        display: inline-block;
        margin: 5px;
        border: 2px solid black;
        padding: 5px;

    }
</style>
@endsection
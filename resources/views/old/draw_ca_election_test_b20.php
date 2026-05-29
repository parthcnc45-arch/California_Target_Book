<?php

    global $cached;
    $fourcode = $fourcode;

    $cdivs = [];
    $master_year = $year;

    $juris = "CA";

    if (mb_substr($fourcode, 0, 2) == "CA") {
        $juris = "US";
    }

    $analysis = get_analysis($year);
    //var_dump($analysis);
    $ballot = '';

    $ballot_special = '';
    $candidates_filed_special = '';
    $intention_table = '';

    if ($year < 2017) {
        $candidates = get_candidates($year);
    } elseif ($year == 2018) {
        $candidates = get_2018_candidates($fourcode);
        $candidates_filed = get_filed($fourcode, $year);
        $ballot = get_ballot($fourcode, $year);

    } elseif ($year == 2020) {
        $candidates = get_2020_candidates($fourcode);
        $candidates_filed = get_filed($fourcode, $year);
        $ballot = get_ballot($fourcode, $year);
        //echo(htmlspecialchars($candidates_filed));

        if($fourcode == "CD25") {
        $ballot_special = get_ballot("CD25+", $year);
        $candidates_filed_special = get_filed("CD25+", $year);
        }
    } elseif ($year == 2022) {
        $candidates = get_new_candidates($fourcode, $year);
        $candidates_filed = get_filed($fourcode, $year);
        $intention_table = lookup_si($fourcode, $year) ;
        $ballot = get_ballot($fourcode, $year);
    } elseif ($year == 2024) {
        $candidates = get_new_candidates($fourcode, $year);
        $intention_table = lookup_si($fourcode, $year) ;
	$candidates_filed = get_filed($fourcode, $year);
        $ballot = get_ballot($fourcode, $year);
    } elseif ($year == 2026) {
        $candidates = get_new_candidates($fourcode, $year);
        $intention_table = lookup_si($fourcode, $year) ;
    }

    //var_dump($candidates);

    $vote_results = '';
    $primary = [];
    $general = [];
    $r_primary = [];
    $d_primary = [];
    $top_two_body = '';
    $r_primary_body = '';
    $d_primary_body = '';
    $general_body = '';

    $display_cands = '';
    $inc_div = '';
    $g_votes = 0;
    $p_votes = 0;

    $d_primary_votes = 0;
    $r_primary_votes = 0;


        foreach ($candidates as $cand_id) {
            //echo("<br>PROCESSING $cand_id");
            if ($year < 2018) {
                $x = lookup_cand_name($cand_id, $master_year);
            } elseif ($year == 2018) {
                $x = lookup_cand_name_18($cand_id);
            } elseif ($year == 2020) {
                $x = lookup_cand_name_20($cand_id);
            } elseif ($year > 2021) {
	        $x = lookup_cand_name_new($cand_id, $year);
            } 
            $cand_nm = $x['cand_nm'];

            $party = $x['party'];

            //echo("<br>DUMPING X after looking up candidate $cand_id name for Year $master_year:<br>");
            //var_dump($x);

            //echo("...got $cand_nm ($party)");

            if (substr($cand_nm, -1) == "*") {
                $inc = "-Inc";
            } else {
                $inc = '';
            }

            $cand_nm = str_replace("*", "", $cand_nm);

            switch ($party) {
                case "DEM":
                    $party = "D";
                    break;
                case "IND":
                    $party = "NPP";
                    break;
                case "NPP":
                    $party = "NPP";
                    break;
                case "PAF":
                    $party = "PAF";
                    break;
                case "AIP":
                    $party = "AIP";
                    break;
                case "LIB":
                    $party = "Lib";
                    break;
                case "REP":
                    $party = "R";
                    break;
                case "GRN":
                    $party = "Grn";
                    break;
                default:
                    $party = $party;
                    break;
            }

            if (isset($inc)) {
                $party = $party . $inc;
            }

            $x = get_votes($cand_id, $year);

            if ($year > 2011) {
                if ($x['p']) {
                    $primary[$cand_id]['cand_id'] = $cand_id;
                    $primary[$cand_id]['votes'] = $x['p'];
                    $primary[$cand_id]['name'] = $cand_nm;
                    $primary[$cand_id]['party'] = $party;
                    $p_votes += $x['p'];
                }
            } else {
                if (isset($x['p'])) {
                    if (mb_substr($party, 0, 1) == "R") {
                        $r_primary[$cand_id]['cand_id'] = $cand_id;
                        $r_primary[$cand_id]['votes'] = $x['p'];
                        $r_primary[$cand_id]['name'] = $cand_nm;
                        $r_primary[$cand_id]['party'] = $party;
                        $r_primary_votes += $x['p'];
                    } elseif (mb_substr($party, 0, 1) == "D") {
                        $d_primary[$cand_id]['cand_id'] = $cand_id;
                        $d_primary[$cand_id]['votes'] = $x['p'];
                        $d_primary[$cand_id]['name'] = $cand_nm;
                        $d_primary[$cand_id]['party'] = $party;
                        $d_primary_votes += $x['p'];
                    }
                } else {
                    $o_primary[$cand_id]['cand_id'] = $cand_id;
                    $o_primary[$cand_id]['votes'] = $votes;
                    $o_primary[$cand_id]['name'] = $cand_nm;
                    $o_primary[$cand_id]['party'] = $party;
                }
            }

            if (isset($x['g'])) {
                $general[$cand_id]['cand_id'] = $cand_id;
                $general[$cand_id]['votes'] = $x['g'];
                $general[$cand_id]['name'] = $cand_nm;
                $general[$cand_id]['party'] = $party;
                $g_votes += $x['g'];
            }


            //echo("<br>$cand_nm $party");
        }


        if ($year > 2011) {
            uasort($primary, 'votesort2');

            //echo("<br>TOP-TWO PRIMARY<br>");

            if($year == 2020) {
            $verbose_month = "March";
            } else {
            $verbose_month = "June";
            }

            $top_two_head = "<div class='primary_div'>
                                <table class='primary_table' id='voteTable'>
                                    <thead>
                                        <tr>
                                            <th colspan='6'>$verbose_month Top-Two Primary</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

            $top_two_body = '';


            $i = 0;
            foreach ($primary as $x) {

                if ($i < 2) {
                    $row_class = 'winner '. $x['party'];
                    $check_mark = "<span class='greenme boldme'>&#x2714;</span>";
                } else {
                    $row_class = '';
                    $check_mark = '';
                }

                if (mb_substr($x['party'], 0, 1) == "D") {
                    $bg_class = 'bluebg';
                } elseif (mb_substr($x['party'], 0, 1) == "R") {
                    $bg_class = 'redbg';
                } else {
                    $bg_class = '';
                }
                $vote_pct = makepct($x['votes'], $p_votes);

                $cand_img = get_candidate_image_sm($x['cand_id']);

                $top_two_body .= "
                                    <tr class='$row_class'>
                                        <td class='img_cell'>$cand_img</td>
                                        <td class='$bg_class'>" . $x['name'] . "</td>
                                        <td class='$bg_class'>" . $x['party'] . "</td>
                                        <td class='' align='right'>" . number_format($x['votes']) . "</td>
                                        <td class='' align='right'>$vote_pct</td>
                                        <td class='whitebg'>$check_mark</td>
                                    </tr>";

                $i++;
                //echo("<br>" . $x['name'] . " " . $x['party'] . " " . $x['votes'] . " ($vote_pct)");
            }
            $vote_results = $top_two_head . $top_two_body . "</tbody></table></div>";
        } else {
            uasort($r_primary, 'votesort2');
            if ($r_primary) {
                //echo("<br>REPUBLICAN PRIMARY<br>");
                $i = 0;
                $r_primary_head = "<div class='primary_div'>
                                    <table class='bordered primary_table'>
                                        <thead>
                                            <tr>
                                                <th colspan='6'>June Republican Primary</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

            $r_primary_body = '';
                foreach ($r_primary as $x) {
                    if ($i == 0) {
                        $row_class = 'winner';
                        $check_mark = "<span class='greenme boldme'>&#x2714;</span>";
                    } else {
                        $row_class = '';
                        $check_mark = '';
                    }

                    $cand_img = get_candidate_image_sm($x['cand_id']);
                    $vote_pct = makepct($x['votes'], $r_primary_votes);
                    $bg_class = 'redbg';
                    $r_primary_body .= "
                                    <tr class='$row_class'>
                                        <td class='img_cell'>$cand_img</td>
                                        <td class='$bg_class'>" . $x['name'] . "</td>
                                        <td class='$bg_class'>" . $x['party'] . "</td>
                                        <td class='' align='right'>" . number_format($x['votes']) . "</td>
                                        <td class='' align='right'>$vote_pct</td>
                                        <td class='whitebg'>$check_mark</td>
                                    </tr>";


                    //echo("<br>" . $x['name'] . " " . $x['party'] . " " . $x['votes'] . " ($vote_pct)");
                    $i++;
                }
                $vote_results .= $r_primary_head . $r_primary_body . "</tbody></table></div>";
            }

            uasort($d_primary, 'votesort2');
            if ($d_primary) {
                $d_primary_head = "<div class='primary_div'>
                                    <table class='bordered primary_table'>
                                        <thead>
                                            <tr>
                                                <th colspan='6'>June Democratic Primary</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

            $d_primary_body = '';
                $i = 0;
                foreach ($d_primary as $x) {
                    $vote_pct = makepct($x['votes'], $d_primary_votes);
                    if ($i == 0) {
                        $row_class = 'winner';
                        $check_mark = "<span class='greenme boldme'>&#x2714;</span>";
                    } else {
                        $row_class = '';
                        $check_mark = '';
                    }
                    $bg_class = 'bluebg';
                    $cand_img = get_candidate_image_sm($x['cand_id']);
                    $d_primary_body .= "
                                    <tr>
                                        <td class='img_cell'>$cand_img</td>
                                        <td class='$bg_class'>" . $x['name'] . "</td>
                                        <td class='$bg_class'>" . $x['party'] . "</td>
                                        <td class='graybg' align='right'>" . number_format($x['votes']) . "</td>
                                        <td class='graybg' align='right'>$vote_pct</td>
                                        <td class='whitebg'>$check_mark</td>
                                    </tr>";


                    //echo("<br>" . $x['name'] . " " . $x['party'] . " " . $x['votes'] . " ($vote_pct)");
                    $i++;
                }
                $vote_results .= $d_primary_head . $d_primary_body . "</tbody></table></div>";
            }


            if (isset($o_primary)) {
                uasort($o_primary, 'votesort2');

                $o_primary_head = "<div class='primary_div'>
                                    <table class='bordered primary_table'>
                                        <thead>
                                            <tr>
                                                <th colspan='3'>Other Primary Candidates</th>
                                            </tr>
                                        </thead>
                                        <tbody>";

            $o_primary_body = '';
                //echo("<br>3RD PARTY PRIMARY CANDIDATES<Br>");
                foreach ($o_primary as $x) {
                    $bg_class = 'graybg';
                    $o_primary_body .= "
                                    <tr>
                                        <td class='$bg_class'>" . $x['name'] . "</td>
                                        <td class='$bg_class'>" . $x['party'] . "</td>
                                        <td class='graybg' align='right'>" . $x['votes'] . "</td>
                                    </tr>";
                }
                $vote_results .= $o_primary_head . $o_primary_body . "</tbody></table></div>";
            }
        }


        uasort($general, 'votesort2');

        //echo("<br>GENERAL<br>");

        $general_head = "<div class='primary_div'>
                                <table class='bordered primary_table'>
                                    <thead>
                                        <tr>
                                            <th colspan='6'>November General Election</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
        $general_body = '';
        $i = 0;
        foreach ($general as $x) {

            if (mb_substr($x['party'], 0, 1) == "D") {
                $bg_class = 'bluebg';
            } elseif (mb_substr($x['party'], 0, 1) == "R") {
                $bg_class = 'redbg';
            } else {
                $bg_class = '';
            }

            if ($i == 0) {
                $row_class = 'winner';
                $check_mark = "<span class='greenme boldme'>&#x2714;</span>";
            } else {
                $row_class = '';
                $check_mark = '';
            }

            $vote_pct = makepct($x['votes'], $g_votes);
            $cand_img = get_candidate_image_sm($x['cand_id']);

            $general_body .= "
                            <tr class='$row_class'>
                                <td class='img_cell'>$cand_img</td>
                                <td class='$bg_class'>" . $x['name'] . "</td>
                                <td class='$bg_class'>" . $x['party'] . "</td>
                                <td class='' align='right'>" . number_format($x['votes']) . "</td>
                                <td class='' align='right'>$vote_pct</td>
                                <td class='whitebg'>$check_mark</td>
                            </tr>";
            $i++;
        }

        $vote_results .= $general_head . $general_body . "</tbody></table></div>";

        if (($year % 2) == 1 || $year == 2022 || $year == 2024) {
            $vote_results = '';
        } else {
            $vote_results = "<div class='vote_container'>" . $vote_results . "</div>";
        }

        $c_divs = Array();

        foreach ($candidates as $cand_id) {
            $text = fetch_bio($cand_id);
            $name = fetch_name($cand_id, $year);
            if (!isset($text)) {
                $text = $name;
            }

            if ($year != 2018 && $year != 2010 && $year != 2020 && $year != 2022 && $year != 2024 && $year != 2026 && $year != 2028 && $year != 2030) {
                $pp = fetch_party($cand_id, $year);
            } elseif ($year == 2018) {
                $pp = lookup_cand_name_18($cand_id);
            } elseif ($year == 2020) {
                $pp = lookup_cand_name_20($cand_id);
            } elseif ($year > 2021) {
            	$pp = lookup_cand_name_new($cand_id, $year);
            }

            $party = array_key_exists('party', $pp)?$pp['party']:'';
            if (array_key_exists('is_incumbent', $pp)) {
                $is_incumbent = $pp['is_incumbent'];
            } else {
                $is_incumbent = False;
            }
            $suffix = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
            foreach ($suffix as $s) {
                if (file_exists('img/candidates/' . $cand_id . $s)) {
                    $add_img = "<a href='https://californiatargetbook.com/book/get_cand_page_t.php?id=$cand_id' target='_blank'><img src=\"https://californiatargetbook.com/img/candidates/" . $cand_id . $s . "\" class='client-image img-fluid' /></a>";
                    break;
                } else {
                    $add_img = "<a href='https://californiatargetbook.com/book/get_cand_page_t.php?id=$cand_id' target='_blank'><img src=\"https://californiatargetbook.com/img/candidates/NO_IMAGE.jpg\" width='150px'  class='client-image img-fluid'/></a>";
                }
            }

            if($role == "admin") {
            $add_img = "<div>$add_img<div style='z-index: 99; margin-top: -10px;'><a href='http://198.74.49.22/img_uploader.php?id=" . $cand_id . "' target='_blank'><img src='/img/edit_btn.png' height='15px' width='15px'></a></div></div>";
            }

            switch ($party) {
                case "REP":
                    $class = 'repdiv';
		    $flag = "/img/FlagRed.jpg";
                    $display_party = "(R)";
                    break;
                case "DEM":
                    $class = 'demdiv';
                    $display_party = "(D)";	
		    $flag = "/img/FlagBlue.jpg";
                    break;
                case "GRN":
                    $class = 'grndiv';
                    $display_party = "(Grn)";
		    $flag = "/img/FlagWhite.jpg";
                    break;
                case "R":
                    $class = 'repdiv';
                    $display_party = "(R)";
		    $flag = "/img/FlagRed.jpg";
                    break;
                case "D":
                    $class = 'demdiv';
                    $display_party = "(D)";
		    $flag = "/img/FlagBlue.jpg";
                    break;
                default:
                    $class = 'inddiv';
                    $display_party = "($party)";
		    $flag = "/img/FlagWhite.jpg";
                    break;
            }

            $cand_links = Array();


            $city_add = '';
            $dob_add = '';
            $city_dob_span = '';
            if(isset($pp['dob']) && strlen($pp['dob']) > 2) {
            $dob_add = "<span>DOB: " . $pp['dob'] . "</span>";
            }

            if(isset($pp['city'])) {
            $city_add = "<span>CITY: " . $pp['city'] . "</span>";
            }

            if(strlen($city_add) > 2 && strlen($dob_add) > 2) {
            $city_dob_span = "<h4 align='left' style='text-style: small-caps;'>$city_add    |    $dob_add</h4>";
            } elseif(isset($city_add)) {
            $city_dob_span = "<h4 align='left' style='text-style: small-caps;'>$city_add</h4>";
            } elseif(isset($dob_add)) {
            $city_dob_span = "<h4 align='left' style='text-style: small-caps;'>$dob_add</h4>";
            } else {
            $city_dob_span = '';
            }

            $y = get_cand_links($cand_id);

            $twitter_btn = '';

   	    $icon_arr = Array(
		"twitter"	=> "fab fa-twitter",
		"linkedin"  => "fab fa-linkedin",
		"facebook"  => "fab fa-facebook",
		"snapchat"	=> "fab fa-snapchat",
		"instagram" => "fab fa-instagram",
		"youtube"	=> "fab fa-youtube",
		"campaign"	=> "fas fa-bullhorn",
		"official"	=> "fas fa-landmark"

		);

	     $add_prefix = Array(
		"twitter"	=> "https://twitter.com/",
		"facebook"	=> "https://facebook.com/",
		"instagram" => "https://instagram.com/",
		);

            foreach($icon_arr as $k => $v) {
		if(!empty($y[$k])) {
		    if(!empty($add_prefix[$k])) {
			$url = $add_prefix[$k] . $y[$k];
		    } else {
			$url = $y[$k];
		    }
		    $tmp = "<span style='font-size: 1.5rem;'><a href='$url' target='_blank'><i class='$v'></i></a>&nbsp;</span>";
		    array_push($cand_links, $tmp);
		}
	    }

	    /*
            if (isset($y['campaign'])) {
                $tmp = "<a href='" . $y['campaign'] . "' target='_blank'>Campaign</a>";
                array_push($cand_links, $tmp);
            }

            if (isset($y['official'])) {
                $tmp = "<a href='" . $y['official'] . "' target='_blank'>Official</a>";
                array_push($cand_links, $tmp);
            }

            if (isset($y['facebook'])) {
                $tmp = "<a href='http://www.facebook.com/" . $y['facebook'] . "' target='_blank'>Facebook</a>";
                array_push($cand_links, $tmp);
            }

            if (isset($y['twitter'])) {
                $tmp = "<a href='http://twitter.com/" . $y['twitter'] . "' target='_blank'>Twitter</a>";
                $twitter_btn = "<div style='margin-top: 5px'><a href='https://twitter.com/" . $y['twitter'] . "' class='twitter-follow-button' data-show-count='false'>Follow @" . $y['twitter'] . "</a></div>";
                array_push($cand_links, $tmp);
            }

            if (isset($y['linkedin'])) {
                $tmp = "<a href='" . $y['linkedin'] . "' target='_blank'>Linkedin</a>";
                array_push($cand_links, $tmp);
            }

            if (isset($y['instagram'])) {
                $tmp = "<a href='https://instagram.com/" . $y['instagram'] . "' target='_blank'>Instagram</a>";
                array_push($cand_links, $tmp);
            }

            if (isset($y['business'])) {
                $tmp = "<a href='" . $y['business'] . "' target='_blank'>Business</a>";
                array_push($cand_links, $tmp);
            }


            if (isset($y['youtube'])) {
                $tmp = "<a href='" . $y['youtube'] . "' target='_blank'>Youtube</a>";
                array_push($cand_links, $tmp);
            }
	    */

            if (isset($cand_id)) {

                if (mb_substr($fourcode, 0, 2) == "CD" || mb_substr($fourcode, 0, 3) == ".SN") {
                    $fppc_id = "<p align='left'><a href='https://www.fec.gov/data/candidate/$cand_id/?tab=filings' target='_blank'>FEC ID# $cand_id</a></p>";
                } else {
                    $fppc_id = "<p align='left'><a href='http://cal-access.sos.ca.gov/Campaign/Candidates/Detail.aspx?id=" . $cand_id . "' target='_blank'>FPPC ID# $cand_id</a> | <a href='/ctb-legacy/lifetime_contributions.php?id=$cand_id' target='_blank'> Detail Rpt</a></p>";
                }
            }

            $l = 0;

            $link_draw = '';
            foreach ($cand_links as $l_value) {
                if ($l > 0) {
                    $link_draw .= " " . $l_value;
                } else {
                    $link_draw .= $l_value;
                }
                $l++;
            }

            if (isset($add_img) && isset($twitter_btn)) {
                $final_img = "<div width='150' align='center' style='display: inline-block; float: left;'>" . $add_img . $twitter_btn . "</div>";
            } else {
                $final_img = $add_img;
            }
            //$final_img = $add_img;


            /*

                $cand_div = "<div class='whitebg canddiv $class'><p style='float: left'>" . $final_img . $text . "</p>
                        <p style='clear: both;' align='center'>$link_draw</p>
                        $fppc_id
                        </div>
                ";

                */

            //echo("<br>IDENTIFYING $cand_id candidate's committee for the year $year and district $fourcode ");
            $cand_cmte = identify_committee($cand_id, $year, $fourcode);
            //var_dump($cand_cmte);


            if($role == "admin") {
                if(mb_substr($fourcode, 0, 2) == "CD" || mb_substr($fourcode, 0, 3) == ".SN") {
                    $edit_btn = "<span><a href='http://198.74.49.22/cand_editor.php?cand_id=" . $cand_id . "&juris=US' target='_blank'><img src='/img/edit_btn.png' height='20px' width='20px' style='opacity: 0.3;'></a></span>";
                } else {
                    $edit_btn = "<span><a href='http://198.74.49.22/cand_editor.php?cand_id=" . $cand_id . "&juris=CA' target='_blank'><img src='/img/edit_btn.png' height='20px' width='20px' style='opacity: 0.3;'></a></span>";
                }
            } else {
                $edit_btn = '';
            }

            $cand_div= '<div class="mt-3 col-md-6 d-flex align-items-stretch">
                <div class="analysis-condidates bg-white pb-4 ctb-border-radius">
                    <div class="ctb-analysis-profile-img">
                        <img src="' . $flag . '" alt="Banner Img" width="100%" />
                    </div>
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="">'.$final_img.'</div>
                        <div class="d-flex gap-2 social_links">'.$link_draw.'</div>
                    </div>
                    <div class="ctb-analysis-profile-des px-3">
                        <div>
                            <h2>'.$name .$display_party.$edit_btn.'</h2>
                            <p>'.$city_dob_span.'</p>
                            '.$fppc_id.'
                            <p>'.$text.'</p>'.
                        '</div>';



            if (isset($is_incumbent)) {
                $cdivs[$cand_id]['cmte_id'] = $cand_cmte;
                $cdivs[$cand_id]['div_start'] = $cand_div;
                $cdivs[$cand_id]['is_inc'] = TRUE;
            } else {
                $cdivs[$cand_id]['is_inc'] = FALSE;
                $cdivs[$cand_id]['cmte_id'] = $cand_cmte;
                $cdivs[$cand_id]['div_start'] = $cand_div;
            }
        }

        $end_div = "			</div> <!--END CANDIDATE CONTENT -->
                            </div> <!--END CANDIDATE PANEL -->
                        </div> <!--END CANDIDATE DIV -->";



        if (mb_substr($fourcode, 0, 2) == "CD" || mb_substr($fourcode, 0, 3) == ".SN") {

            $adjusted_fourcode = "CA" . mb_substr($fourcode, 2, 2);
            if(mb_substr($fourcode, 0, 3) == ".SN") {
            $adjusted_fourcode = "CASEN";
            }
            //echo("<br>Looking up financials for $adjusted_fourcode, $year");
            $financials = draw_fec_financial_table($adjusted_fourcode, $year);
            $use_fed = TRUE;
        } else {
            $use_fed = FALSE;
            $financials = get_financials($year);
        }

        if (!$use_fed) {
            //$ies = "<div class='iframe-container working'><iframe src='/book/ie_single?id=" . $fourcode . "&year=$year' class='ie_iframe' align='center'></iframe></div>";
            $ies = "<div class='iframe-container working'><iframe src='/book/ie_test?id=" . $fourcode . "&year=$year' class='ie_iframe' align='center'></iframe></div>";
        } else {
            //$ies = "<div class='iframe-container working'><iframe src='/book/get_fec_ies2.php?id=" . $adjusted_fourcode . "&yr=$year' class='ie_iframe' align='center'></iframe></div>";
            $ies = "<div class='iframe-container working'><iframe src='/book/ie_test?id=" . $fourcode . "&year=$year' class='ie_iframe' align='center'></iframe></div>";

        }


            if($role == "admin") {
                if(mb_substr($fourcode, 0, 2) == "CD" || mb_substr($fourcode, 0, 3) == ".SN") {
                    if(mb_substr($fourcode, 0, 2) == "CD") {
                        $alt_fourcode = "CA" . mb_substr($fourcode, 2, 2);
                    } else {
                        $alt_fourcode = $fourcode;
                    }

                    $edit_btn = "<span><a href='http://198.74.49.22/dist_editor.php?id=" . $alt_fourcode . "&yr=$year&juris=US' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";
                } else {
                    $edit_btn = "<span><a href='http://198.74.49.22/dist_editor.php?id=" . $fourcode . "&yr=$year' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";
                }
            } else {
                $edit_btn = '';
            }

        $this_endorsement = '';
        if($year > 2017)  {

            $endorsements = get_party_endorsements($fourcode, $year);
            $add_endorse = '';

            foreach($endorsements as $party => $e) {
                switch($party) {
                    case "D":
                        $long_party = "Democratic";
                        break;
                    case "R":
                        $long_party = "Republican";
                        break;
                }

                if(isset($e['pre_conference'])) {
                    $add_endorse .= "<br>$long_party Party Pre-Endorsement Conference Endorsement (Primary): " . $e['pre_conference'];
                }

                if(isset($e['primary_election'])) {
                    $add_endorse .= "<br>$long_party Party Primary Endorsement: " . $e['primary_election'];
                }

                if(isset($e['general_election'])) {
                    $add_endorse .= "<br>$long_party Party General Election Endorsement: " . $e['general_election'];
                }
            }


            if(isset($add_endorse)) {
                $this_endorsement = "<p align='center'>" . $add_endorse . "</p>";
            }

        }
	$candidates_filed_panel[$year] = '';
	$candidates_on_ballot[$year] = '';

	if(!empty($candidates_filed)) {
	    $candidates_filed_panel[$year] = "<div class='row panel'>
						<h3 align='center'>Candidate Filing Status</h3>
							$candidates_filed
					     </div>";
	}

	if(!empty($ballot)) {
	    $candidates_on_ballot[$year] = "<div class='row panel'>
						$ballot
					    </div>";
	}


        global $lookup_cmte;

        if($year > 2017) {
            include('temp_cands.php');
        }


@extends('layouts.iframe')

@section('title', 'Super District | California Target Book')

@section('content')


    <?php

    Util::set_errors();
    Util::require_ctb_api();

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();

    global $county, $distno, $sub;
    $county = $_GET['id'];
    //$sub = $_GET['sub'];
    $distno = $_GET['sub'];
    $sub = "Supervisorial District $distno";

    echo("<p align='center'>$county County  - $sub</p>");

    $x = get_the_stats();

    //CALCULATE VOTER REGISTRATION

    $dem = number_format((($x['O17_DEM'] / $x['O17_TOT']) * 100), 2);
    $rep = number_format((($x['O17_REP'] / $x['O17_TOT']) * 100), 2);
    $npp = number_format((($x['O17_NPP'] / $x['O17_TOT']) * 100), 2);
    $tot = number_format($x['O17_TOT']);


    $y = get_past_reg();
    $z = get_supe_elect();

    //echo("<br>COUNTY SUPERVISOR ELECTION RESULTS DUMP:<br>");
    //var_dump($z);

    foreach ($z as $c) {

        $election = $c['ELECTION'];

        if ($c['IS_INCUMBENT']) {
            $inc_class = 'itcme';
            $add_inc = " (Inc)";
        } else {
            $inc_class = '';
            $add_inc = '';
        }

        if ($c['ELECTED'] == "Yes" || $c['ELECTED'] == "Runoff") {
            $bold_class = 'boldme';
        } else {
            $bold_class = '';
        }

        switch ($election) {
            case "p12":
                $p12_tablebody .= "<tr>
								<td id='blueColumn' class='$bold_class $inc_class'>" . $c['NAMF'] . " " . $c['NAML'] . $add_inc . "</td>
								<td id='greyColumn'>" . $c['DESIGNATION'] . "</td>
								<td id='greyColumn'>" . number_format(($c['CAND_PCT'] * 100), 2) . "%</td>
							   </tr>";
                break;
            case "g12":
                $g12_tablebody .= "<tr>
								<td id='blueColumn' class='$bold_class $inc_class'>" . $c['NAMF'] . " " . $c['NAML'] . $add_inc . "</td>
								<td id='greyColumn'>" . $c['DESIGNATION'] . "</td>
								<td id='greyColumn'>" . number_format(($c['CAND_PCT'] * 100), 2) . "%</td>
							   </tr>";
                break;
            case "p14":
                $p14_tablebody .= "<tr>
								<td id='blueColumn' class='$bold_class $inc_class'>" . $c['NAMF'] . " " . $c['NAML'] . $add_inc . "</td>
								<td id='greyColumn'>" . $c['DESIGNATION'] . "</td>
								<td id='greyColumn'>" . number_format(($c['CAND_PCT'] * 100), 2) . "%</td>
							   </tr>";
                break;
            case "g14":
                $g14_tablebody .= "<tr>
								<td id='blueColumn' class='$bold_class $inc_class'>" . $c['NAMF'] . " " . $c['NAML'] . $add_inc . "</td>
								<td id='greyColumn'>" . $c['DESIGNATION'] . "</td>
								<td id='greyColumn'>" . number_format(($c['CAND_PCT'] * 100), 2) . "%</td>
							   </tr>";
                break;
            case "p16":
                $p16_tablebody .= "<tr>
								<td id='blueColumn' class='$bold_class $inc_class'>" . $c['NAMF'] . " " . $c['NAML'] . $add_inc . "</td>
								<td id='greyColumn'>" . $c['DESIGNATION'] . "</td>
								<td id='greyColumn'>" . number_format(($c['CAND_PCT'] * 100), 2) . "%</td>
							   </tr>";
                break;
            case "g16":
                $g16_tablebody .= "<tr>
								<td id='blueColumn' class='$bold_class $inc_class'>" . $c['NAMF'] . " " . $c['NAML'] . $add_inc . "</td>
								<td id='greyColumn'>" . $c['DESIGNATION'] . "</td>
								<td id='greyColumn'>" . number_format(($c['CAND_PCT'] * 100), 2) . "%</td>
							   </tr>";
                break;
        }

    }

    $p12_tablehead = "<table id='districtWrapper' class='supeclass'>
					<tbody style='font-size: 12pt;'>
						<tr>
							<th colspan='3'>Board of Supervisors $distno - 2012 Primary</th>
						</tr>";

    $g12_tablehead = "<table id='districtWrapper' class='supeclass'>
					<tbody style='font-size: 12pt;'>
						<tr>
							<th colspan='3'>Board of Supervisors $distno - 2012 General</th>
						</tr>";

    $p14_tablehead = "<table id='districtWrapper' class='supeclass'>
					<tbody style='font-size: 12pt;'>
						<tr>
							<th colspan='3'>Board of Supervisors $distno - 2014 Primary</th>
						</tr>";

    $g14_tablehead = "<table id='districtWrapper' class='supeclass'>
					<tbody style='font-size: 12pt;'>
						<tr>
							<th colspan='3'>Board of Supervisors $distno - 2014 General</th>
						</tr>";

    $p16_tablehead = "<table id='districtWrapper' class='supeclass supeclear'>
					<tbody style='font-size: 12pt;'>
						<tr>
							<th colspan='3'>Board of Supervisors $distno - 2016 Primary</th>
						</tr>";

    $g16_tablehead = "<table id='districtWrapper' class='supeclass'>
					<tbody style='font-size: 12pt;'>
						<tr>
							<th colspan='3'>Board of Supervisors $distno - 2016 General</th>
						</tr>";

    $table_end = "</tbody></table>";


    $findme = "District";
    $is_district = substr_count($sub, $findme);

    if ($is_district) {
        $is_city = 0;
        //echo("<br>IDENTIFIED GROUP PRONE TO REDISTRICTING, IGNORING PRE-2012 RESULTS");
    } else {
        $is_city = 1;
        //echo("<br>IDENTIFIED CITY OR COUNTY");
    }


    $g17_rep = $x['O17_REP'];
    $g17_dem = $x['O17_DEM'];
    $g17_npp = $x['O17_NPP'];
    $g17_tot = $x['O17_TOT'];

    $g17_adv = vote_adv($g17_dem, $g17_rep, $g17_tot);


    $g16_rep = $y['G16_REP'];
    $g16_dem = $y['G16_DEM'];
    $g16_npp = $y['G16_NPP'];
    $g16_tot = $y['G16_TOT'];
    $g16_adv = vote_adv($g16_dem, $g16_rep, $g16_tot);


    $g14_rep = $y['G14_REP'];
    $g14_dem = $y['G14_DEM'];
    $g14_npp = $y['G14_NPP'];
    $g14_tot = $y['G14_TOT'];
    $g14_adv = vote_adv($g14_dem, $g14_rep, $g14_tot);

    $g12_rep = $y['G12_REP'];
    $g12_dem = $y['G12_DEM'];
    $g12_npp = $y['G12_NPP'];
    $g12_tot = $y['G12_TOT'];
    $g12_adv = vote_adv($g12_dem, $g12_rep, $g12_tot);

    $g10_rep = $y['G10_REP'];
    $g10_dem = $y['G10_DEM'];
    $g10_npp = $y['G10_NPP'];
    $g10_tot = $y['G10_TOT'];
    $g10_adv = vote_adv($g10_dem, $g10_rep, $g10_tot);

    $g08_rep = $y['G08_REP'];
    $g08_dem = $y['G08_DEM'];
    $g08_npp = $y['G08_NPP'];
    $g08_tot = $y['G08_TOT'];
    $g08_adv = vote_adv($g08_dem, $g08_rep, $g08_tot);

    $g17_span = "<br><span class='boldme'>NOW:</span>
			 <span class='blueme boldme'>DEM: " . number_format($g17_dem) . " (" . makepct($g17_dem, $g17_tot) . ")</span> |
			 <span class='redme boldme'>REP: " . number_format($g17_rep) . " (" . makepct($g17_rep, $g17_tot) . ")</span> |
			 <span class='grayme boldme'>NPP: " . number_format($g17_npp) . " (" . makepct($g17_npp, $g17_tot) . ")</span> |
			 <span class='boldme'>TOTAL REGISTERED - " . number_format($g17_tot) . "</span> | " . $g17_adv;

    $g16_span = "<br><span class='boldme'>G16:</span>
			 <span class='blueme boldme'>DEM: " . number_format($g16_dem) . " (" . makepct($g16_dem, $g16_tot) . ")</span> |
			 <span class='redme boldme'>REP: " . number_format($g16_rep) . " (" . makepct($g16_rep, $g16_tot) . ")</span> |
			 <span class='grayme boldme'>NPP: " . number_format($g16_npp) . " (" . makepct($g16_npp, $g16_tot) . ")</span> |
			 <span class='boldme'>TOTAL REGISTERED - " . number_format($g16_tot) . "</span> | " . $g16_adv;

    $g14_span = "<br><span class='boldme'>G14:</span>
			 <span class='blueme boldme'>DEM: " . number_format($g14_dem) . " (" . makepct($g14_dem, $g14_tot) . ")</span> |
			 <span class='redme boldme'>REP: " . number_format($g14_rep) . " (" . makepct($g14_rep, $g14_tot) . ")</span> |
			 <span class='grayme boldme'>NPP: " . number_format($g14_npp) . " (" . makepct($g14_npp, $g14_tot) . ")</span> |
			 <span class='boldme'>TOTAL REGISTERED - " . number_format($g14_tot) . "</span> | " . $g14_adv;

    $g12_span = "<br><span class='boldme'>G12:</span>
			 <span class='blueme boldme'>DEM: " . number_format($g12_dem) . " (" . makepct($g12_dem, $g12_tot) . ")</span> |
			 <span class='redme boldme'>REP: " . number_format($g12_rep) . " (" . makepct($g12_rep, $g12_tot) . ")</span> |
			 <span class='grayme boldme'>NPP: " . number_format($g12_npp) . " (" . makepct($g12_npp, $g12_tot) . ")</span> |
			 <span class='boldme'>TOTAL REGISTERED - " . number_format($g12_tot) . "</span> | " . $g12_adv;

    if ($is_city) {

        $g10_span = "<br><span class='boldme'>G10:</span>
				 <span class='blueme boldme'>DEM: " . number_format($g10_dem) . " (" . makepct($g10_dem, $g10_tot) . ")</span> |
				 <span class='redme boldme'>REP: " . number_format($g10_rep) . " (" . makepct($g10_rep, $g10_tot) . ")</span> |
				 <span class='grayme boldme'>NPP: " . number_format($g10_npp) . " (" . makepct($g10_npp, $g10_tot) . ")</span> |
				 <span class='boldme'>TOTAL REGISTERED - " . number_format($g10_tot) . "</span> | " . $g10_adv;

        $g08_span = "<br><span class='boldme'>G08:</span>
				 <span class='blueme boldme'>DEM: " . number_format($g08_dem) . " (" . makepct($g08_dem, $g08_tot) . ")</span> |
				 <span class='redme boldme'>REP: " . number_format($g08_rep) . " (" . makepct($g08_rep, $g08_tot) . ")</span> |
				 <span class='grayme boldme'>NPP: " . number_format($g08_npp) . " (" . makepct($g08_npp, $g08_tot) . ")</span> |
				 <span class='boldme'>TOTAL REGISTERED - " . number_format($g08_tot) . "</span> | " . $g08_adv;

        $g08_prs_tot = $x['G08_PRSDEM'] + $x['G08_PRSREP'] + $x['G08_PRSAIP'] + $x['G08_PRSGRN'] + $x['G08_PRSLIB'] + $x['G08_PRSPAF'];
        $g10_gov_tot = $x['G10_GOVDEM'] + $x['G10_GOVREP'] + $x['G10_GOVAIP'] + $x['G10_GOVGRN'] + $x['G10_GOVLIB'] + $x['G10_GOVPAF'];
        $g10_uss_tot = $x['G10_USSDEM'] + $x['G10_USSREP'] + $x['G10_USSAIP'] + $x['G10_USSGRN'] + $x['G10_USSLIB'] + $x['G10_USSPAF'];

        $bo = $x['G08_PRSDEM'];
        $jm = $x['G08_PRSREP'];

        $bo_pct = ($bo / $g08_prs_tot) * 100;
        $jm_pct = ($jm / $g08_prs_tot) * 100;

        if ($bo_pct > $jm_pct) {
            $g08p_span = "<span class='boldme blueme'>OBAMA + " . number_format(($bo_pct - $jm_pct), 2) . "</span> | ";
        } elseif ($jm_pct > $bo_pct) {
            $g08p_span = "<span class='boldme redme'>MCCAIN + " . number_format(($jm_pct - $bo_pct), 2) . "<span> | ";
        } else {
            $g08p_span = "<span class='boldme'>TIE IN 2008</span>";
        }


        $alt_table = "<table width='800px' class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
				<tbody style='font-size: 12pt;'>
					<tr>
						<th colspan='2'>President '08</th>
						<th colspan='2'>Governor '10</th>
						<th colspan='2'>U.S. Senate '10</th>
					</tr>
					<tr>
						<td id='blueColumn'>Barack Obama (D)<br>John McCain (R)</td>
						<td id='greyColumn'>" . number_format((($x['G08_PRSDEM'] / $g08_prs_tot) * 100), 2) . "<br>" . number_format((($x['G08_PRSREP'] / $g08_prs_tot) * 100), 2) . "</td>
						<td id='blueColumn'>Jerry Brown (D)<br>Meg Whitman (R)</td>
						<td id='greyColumn'>" . number_format((($x['G10_GOVDEM'] / $g10_gov_tot) * 100), 2) . "<br>" . number_format((($x['G10_GOVREP'] / $g10_gov_tot) * 100), 2) . "</td>
						<td id='blueColumn'>Barbara Boxer (D-Inc)<br>Carly Fiorina (R)</td>
						<td id='greyColumn'>" . number_format((($x['G10_USSDEM'] / $g10_uss_tot) * 100), 2) . "<br>" . number_format((($x['G10_USSREP'] / $g10_uss_tot) * 100), 2) . "</td>
					</tr>
				</tbody>
			</table>";


    }

    $past_reg_span = $g17_span . $g16_span . $g14_span . $g12_span . $g10_span . $g08_span;


    if ($dem > $rep) {
        $reg_span = "<span class='blueme boldme'>D + " . number_format(($dem - $rep), 2) . "</span>";
    } elseif ($rep > $dem) {
        $reg_span = "<span class='redme boldme'>R + " . number_format(($rep - $dem), 2) . "</span>";
    } else {
        $reg_span = "<span class='grayme boldme'>GOP / DEM AT PARITY</span>";
    }

    $djt = $x['G16_PRSREP'];
    $hrc = $x['G16_PRSDEM'];

    $bho = $x['G12_PRSDEM'];
    $wmr = $x['G12_PRSREP'];

    $g12_prs_tot = $x['G12_PRSDEM'] + $x['G12_PRSREP'] + $x['G12_PRSLIB'] + $x['G12_PRSPAF'] + $x['G12_PRSAIP'] + $x['G12_PRSGRN'];
    $g12_uss_tot = $x['G12_USSDEM'] + $x['G12_USSREP'];
    $g14_gov_tot = $x['G14_GOVDEM'] + $x['G14_GOVREP'];
    $g16_prs_tot = $x['G16_PRSDEM'] + $x['G16_PRSREP'] + $x['G16_PRSLIB'] + $x['G16_PRSPAF'] + $x['G16_PRSGRN'];

    $djt_pct = ($djt / $g16_prs_tot) * 100;
    $hrc_pct = ($hrc / $g16_prs_tot) * 100;

    $bho_pct = ($bho / $g12_prs_tot) * 100;
    $wmr_pct = ($wmr / $g12_prs_tot) * 100;

    if ($bho_pct > $wmr_pct) {
        $g12_span = "<span class='boldme blueme'>OBAMA + " . number_format(($bho_pct - $wmr_pct), 2) . "</span>";
    } elseif ($wmr_pct > $bho_pct) {
        $g12_span = "<span class='boldme redme'>ROMNEY + " . number_format(($wmr_pct - $bho_pct), 2) . "</span>";
    } else {
        $g12_span = "<span class='boldme'>TIE IN 2012</span>";
    }

    if ($hrc_pct > $djt_pct) {
        $g16_span = "<span class='boldme blueme'>CLINTON + " . number_format(($hrc_pct - $djt_pct), 2) . "</span>";
    } elseif ($djt_pct > $hrc_pct) {
        $g16_span = "<span class='boldme redme'>TRUMP + " . number_format(($djt_pct - $hrc_pct), 2) . "</span>";
    } else {
        $g16_span = "<span class='boldme'>TIE IN 2016</span>";
    }

    $pres_span = "<p align='center'>" . $g08p_span . $g12_span . " | " . $g16_span . "</p>";

    $g12_p30_tot = $x['G12_P30Y'] + $x['G12_P30N'];
    $g12_p31_tot = $x['G12_P31Y'] + $x['G12_P31N'];
    $g12_p32_tot = $x['G12_P32Y'] + $x['G12_P32N'];
    $g12_p33_tot = $x['G12_P33Y'] + $x['G12_P33N'];
    $g12_p34_tot = $x['G12_P34Y'] + $x['G12_P34N'];
    $g12_p35_tot = $x['G12_P35Y'] + $x['G12_P35N'];
    $g12_p36_tot = $x['G12_P36Y'] + $x['G12_P36N'];
    $g12_p37_tot = $x['G12_P37Y'] + $x['G12_P37N'];
    $g12_p38_tot = $x['G12_P38Y'] + $x['G12_P38N'];
    $g12_p39_tot = $x['G12_P39Y'] + $x['G12_P39N'];
    $g12_p40_tot = $x['G12_P40Y'] + $x['G12_P40N'];
    $g14_p1_tot = $x['G14_P1Y'] + $x['G14_P1N'];
    $g14_p2_tot = $x['G14_P2Y'] + $x['G14_P2N'];
    $g14_p45_tot = $x['G14_P45Y'] + $x['G14_P45N'];
    $g14_p46_tot = $x['G14_P46Y'] + $x['G14_P46N'];
    $g14_p47_tot = $x['G14_P47Y'] + $x['G14_P47N'];
    $g14_p48_tot = $x['G14_P48Y'] + $x['G14_P48N'];
    $g16_p51_tot = $x['G16_P51Y'] + $x['G16_P51N'];
    $g16_p52_tot = $x['G16_P52Y'] + $x['G16_P52N'];
    $g16_p53_tot = $x['G16_P53Y'] + $x['G16_P53N'];
    $g16_p54_tot = $x['G16_P54Y'] + $x['G16_P54N'];
    $g16_p55_tot = $x['G16_P55Y'] + $x['G16_P55N'];
    $g16_p56_tot = $x['G16_P56Y'] + $x['G16_P56N'];
    $g16_p57_tot = $x['G16_P57Y'] + $x['G16_P57N'];
    $g16_p58_tot = $x['G16_P58Y'] + $x['G16_P58N'];
    $g16_p59_tot = $x['G16_P59Y'] + $x['G16_P59N'];
    $g16_p60_tot = $x['G16_P60Y'] + $x['G16_P60N'];
    $g16_p61_tot = $x['G16_P61Y'] + $x['G16_P61N'];
    $g16_p62_tot = $x['G16_P62Y'] + $x['G16_P62N'];
    $g16_p63_tot = $x['G16_P63Y'] + $x['G16_P63N'];
    $g16_p64_tot = $x['G16_P64Y'] + $x['G16_P64N'];
    $g16_p65_tot = $x['G16_P65Y'] + $x['G16_P65N'];
    $g16_p66_tot = $x['G16_P66Y'] + $x['G16_P66N'];
    $g16_p67_tot = $x['G16_P67Y'] + $x['G16_P67N'];


    $voter_reg = "<p align='center'><span class='boldme'>TOTAL REGISTERED VOTERS: $tot</span><br>
				<span class='redme boldme'>R: $rep%</span> | <span class='blueme boldme'>D: $dem%</span> | <span class='grayme boldme'>NPP: $npp%</span></p>";

    $main_table = "<table width='1024px' class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
				<tbody style='font-size: 12pt;'>
					<tr>
						<th colspan='2'>President '12</th>
						<th colspan='2'>U.S. Senate '12</th>
						<th colspan='2'>Governor '14</th>
						<th colspan='2'>President '16</th>
					</tr>
					<tr>
						<td id='blueColumn'>Barack Obama (D-Inc)<br>Mitt Romney (R)</td>
						<td id='greyColumn'>" . number_format((($x['G12_PRSDEM'] / $g12_prs_tot) * 100), 2) . "<br>" . number_format((($x['G12_PRSREP'] / $g12_prs_tot) * 100), 2) . "</td>
						<td id='blueColumn'>Dianne Feinstein (D-Inc)<br>Elizabeth Emken (R)</td>
						<td id='greyColumn'>" . number_format((($x['G12_USSDEM'] / $g12_uss_tot) * 100), 2) . "<br>" . number_format((($x['G12_USSREP'] / $g12_uss_tot) * 100), 2) . "</td>
						<td id='blueColumn'>Jerry Brown (D-Inc)<br>Neel Kashkari (R)</td>
						<td id='greyColumn'>" . number_format((($x['G14_GOVDEM'] / $g14_gov_tot) * 100), 2) . "<br>" . number_format((($x['G14_GOVREP'] / $g14_gov_tot) * 100), 2) . "</td>
						<td id='blueColumn'>Hillary Clinton (D)<br>Donald Trump (R)</td>
						<td id='greyColumn'>" . number_format((($x['G16_PRSDEM'] / $g16_prs_tot) * 100), 2) . "<br>" . number_format((($x['G16_PRSREP'] / $g16_prs_tot) * 100), 2) . "</td>
					</tr>
				</tbody>
			</table>";


    //echo("<br>RETRIEVED RESULTS:<br>");
    echo($voter_reg . "<p align='center'>$reg_span</p>");
    echo("<p align='center'>$past_reg_span</p>");

    $prop_table = "<table width='1024px' class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
				<tbody style='font-size: 12pt;'>
					<tr>
						<th colspan='2'>P30 (Jerry Brown's Temp Tax Increase)</th>
						<th colspan='2'>P31 (Mandate 2-Year Budget Cycle)</th>
						<th colspan='2'>P32 (Union/Corporate Campaign Restrictions)</th>
						<th colspan='2'>P33 (Auto Insurance Persistency Discounts)</th>

					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P30Y'] / $g12_p30_tot) * 100), 2) . "<br>" . number_format((($x['G12_P30N'] / $g12_p30_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P31Y'] / $g12_p31_tot) * 100), 2) . "<br>" . number_format((($x['G12_P31N'] / $g12_p31_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P32Y'] / $g12_p32_tot) * 100), 2) . "<br>" . number_format((($x['G12_P32N'] / $g12_p32_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P33Y'] / $g12_p33_tot) * 100), 2) . "<br>" . number_format((($x['G12_P33N'] / $g12_p33_tot) * 100), 2) . "</td>
					</tr>
					<tr>
						<th colspan='2'>P34 (Eliminate Death Penalty)</th>
						<th colspan='2'>P35 (Increase Human Trafficking Penalties)</th>
						<th colspan='2'>P36 (Modify Three-Strikes Law)</th>
						<th colspan='2'>P37 (Mandatory GMO Labeling)</th>
					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P34Y'] / $g12_p34_tot) * 100), 2) . "<br>" . number_format((($x['G12_P34N'] / $g12_p34_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P35Y'] / $g12_p35_tot) * 100), 2) . "<br>" . number_format((($x['G12_P35N'] / $g12_p35_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P36Y'] / $g12_p36_tot) * 100), 2) . "<br>" . number_format((($x['G12_P36N'] / $g12_p36_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P37Y'] / $g12_p37_tot) * 100), 2) . "<br>" . number_format((($x['G12_P37N'] / $g12_p37_tot) * 100), 2) . "</td>
					</tr>
					<tr>
						<th colspan='2'>P38 (Tax Increase for Education)</th>
						<th colspan='2'>P39 (Tax Increase on Multi-State Businesses)</th>
						<th colspan='2'>P40 (Redistricting Referendum)</th>
						<th colspan='2'>P1 ($7.2B Water Bond)</th>
					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P38Y'] / $g12_p38_tot) * 100), 2) . "<br>" . number_format((($x['G12_P38N'] / $g12_p38_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P39Y'] / $g12_p39_tot) * 100), 2) . "<br>" . number_format((($x['G12_P39N'] / $g12_p39_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G12_P40Y'] / $g12_p40_tot) * 100), 2) . "<br>" . number_format((($x['G12_P40N'] / $g12_p40_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G14_P1Y'] / $g14_p1_tot) * 100), 2) . "<br>" . number_format((($x['G14_P1N'] / $g14_p1_tot) * 100), 2) . "</td>
					</tr>
					<tr>
						<th colspan='2'>P2 (Increase Rainy Day Fund)</th>
						<th colspan='2'>P45 (Public Notice for Insurance Rates)</th>
						<th colspan='2'>P46 (Increase Cap on Medical Damages)</th>
						<th colspan='2'>P47 (Criminal Code Reform)</th>
					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G14_P2Y'] / $g14_p2_tot) * 100), 2) . "<br>" . number_format((($x['G14_P2N'] / $g14_p2_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G14_P45Y'] / $g14_p45_tot) * 100), 2) . "<br>" . number_format((($x['G14_P45N'] / $g14_p45_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G14_P46Y'] / $g14_p46_tot) * 100), 2) . "<br>" . number_format((($x['G14_P46N'] / $g14_p46_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G14_P47Y'] / $g14_p47_tot) * 100), 2) . "<br>" . number_format((($x['G14_P47N'] / $g14_p47_tot) * 100), 2) . "</td>
					</tr>
					<tr>
						<th colspan='2'>P48 (Ratify Gaming Compact)</th>
						<th colspan='2'>P51 (School Construction Bond)</th>
						<th colspan='2'>P52 (Medi-Cal Hospital Fee)</th>
						<th colspan='2'>P53 (Voter Approval of Revenue Bonds)</th>
					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G14_P48Y'] / $g14_p48_tot) * 100), 2) . "<br>" . number_format((($x['G14_P48N'] / $g14_p48_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P51Y'] / $g16_p51_tot) * 100), 2) . "<br>" . number_format((($x['G16_P51N'] / $g16_p51_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P52Y'] / $g16_p52_tot) * 100), 2) . "<br>" . number_format((($x['G16_P52N'] / $g16_p52_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P53Y'] / $g16_p53_tot) * 100), 2) . "<br>" . number_format((($x['G16_P53N'] / $g16_p53_tot) * 100), 2) . "</td>
					</tr>
					<tr>
						<th colspan='2'>P54 (Legislative Transparency)</th>
						<th colspan='2'>P55 (Extend Prop 30 Tax Rates)</th>
						<th colspan='2'>P56 (Tax on Tobacco Products)</th>
						<th colspan='2'>P57 (Parole / Juvenile Justice Reform)</th>
					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P54Y'] / $g16_p54_tot) * 100), 2) . "<br>" . number_format((($x['G16_P54N'] / $g16_p54_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P55Y'] / $g16_p55_tot) * 100), 2) . "<br>" . number_format((($x['G16_P55N'] / $g16_p55_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P56Y'] / $g16_p56_tot) * 100), 2) . "<br>" . number_format((($x['G16_P56N'] / $g16_p56_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P57Y'] / $g16_p57_tot) * 100), 2) . "<br>" . number_format((($x['G16_P57N'] / $g16_p57_tot) * 100), 2) . "</td>
					</tr>
					<tr>
						<th colspan='2'>P58 (Multilingual Education)</th>
						<th colspan='2'>P59 (Citizens United Advisory)</th>
						<th colspan='2'>P60 (Mandate Condoms in Adult Films)</th>
						<th colspan='2'>P61 (Prescription Drug Price Control)</th>
					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P58Y'] / $g16_p58_tot) * 100), 2) . "<br>" . number_format((($x['G16_P58N'] / $g16_p58_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P59Y'] / $g16_p59_tot) * 100), 2) . "<br>" . number_format((($x['G16_P59N'] / $g16_p59_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P60Y'] / $g16_p60_tot) * 100), 2) . "<br>" . number_format((($x['G16_P60N'] / $g16_p60_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P61Y'] / $g16_p61_tot) * 100), 2) . "<br>" . number_format((($x['G16_P61N'] / $g16_p61_tot) * 100), 2) . "</td>
					</tr>
					<tr>
						<th colspan='2'>P62 (Eliminate Death Penalty)</th>
						<th colspan='2'>P63 (Firearms & Ammunition Restrictions)</th>
						<th colspan='2'>P64 (Legalize Marijuana)</th>
						<th colspan='2'>P65 (Divert Carryout Bag Fees From Retailers)</th>
					</tr>
					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P62Y'] / $g16_p62_tot) * 100), 2) . "<br>" . number_format((($x['G16_P62N'] / $g16_p62_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P63Y'] / $g16_p63_tot) * 100), 2) . "<br>" . number_format((($x['G16_P63N'] / $g16_p63_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P64Y'] / $g16_p64_tot) * 100), 2) . "<br>" . number_format((($x['G16_P64N'] / $g16_p64_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P65Y'] / $g16_p65_tot) * 100), 2) . "<br>" . number_format((($x['G16_P65N'] / $g16_p65_tot) * 100), 2) . "</td>
					</tr>

					<tr>
						<th colspan='2'>P66 (Strengthen Death Penalty)</th>
						<th colspan='2'>P67 (Uphold Plastic Bag Ban)</th>
						<th colspan='2'></th>
						<th colspan='2'></th>
					</tr>

					<tr>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P66Y'] / $g16_p66_tot) * 100), 2) . "<br>" . number_format((($x['G16_P66N'] / $g16_p66_tot) * 100), 2) . "</td>
						<td id='blueColumn'>YES<br>NO</td>
						<td id='greyColumn'>" . number_format((($x['G16_P67Y'] / $g16_p67_tot) * 100), 2) . "<br>" . number_format((($x['G16_P67N'] / $g16_p67_tot) * 100), 2) . "</td>
						<td id='blueColumn'></td>
						<td id='greyColumn'></td>
						<td id='blueColumn'></td>
						<td id='greyColumn'></td>
					</tr>

				</tbody>
			</table>";


    echo($pres_span);
    echo($main_table);

    if ($alt_table) {
        echo($alt_table);
    }
    echo("<div width='100%' align='center'>");
    echo("<div align='center' style='display: inline-block;'>");

    if ($p12_tablebody) {
        echo($p12_tablehead . $p12_tablebody . $table_end);
    }

    if ($g12_tablebody) {
        echo($g12_tablehead . $g12_tablebody . $table_end);
    }

    if ($p14_tablebody) {
        echo($p14_tablehead . $p14_tablebody . $table_end);
    }

    if ($g14_tablebody) {
        echo($g14_tablehead . $g14_tablebody . $table_end);
    }

    if ($p16_tablebody) {
        echo($p16_tablehead . $p16_tablebody . $table_end);
    }

    if ($g16_tablebody) {
        echo($g16_tablehead . $g16_tablebody . $table_end);
    }

    echo("</div>");
    echo("</div>");

    echo($prop_table);

    //var_dump($x);

    function vote_adv($d, $r, $t)
    {

        $dem = number_format((($d / $t) * 100), 2);
        $rep = number_format((($r / $t) * 100), 2);

        if ($dem > $rep) {
            $reg_span = "<span class='blueme boldme'>D + " . number_format(($dem - $rep), 2) . "</span>";
        } elseif ($rep > $dem) {
            $reg_span = "<span class='redme boldme'>R + " . number_format(($rep - $dem), 2) . "</span>";
        } else {
            $reg_span = "<span class='grayme boldme'>GOP / DEM AT PARITY</span>";
        }

        return $reg_span;


    }

    function get_supe_elect()
    {
        global $county;
        global $distno;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $thiscounty = strtoupper($county);
        $sql = "SELECT * FROM ctb2016_ca_county_votes WHERE COUNTY = '$thiscounty' && OFFICE = 'COUNTY SUPERVISOR' &&  DISTRICT = $distno";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($retval, $row);
            }
        }

        return $retval;
    }

    function get_past_reg()
    {
        global $county;
        global $sub;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();

        $sql = "SELECT * FROM ctb2016_reg_hist WHERE COUNTY = '$county' && SUBDIVISION = '$sub'";

        $findme = "Unincorporated";
        $is_unincorporated = substr_count($sub, $findme);

        if ($is_unincorporated) {
            $sql = "SELECT * FROM ctb2016_reg_hist WHERE COUNTY = '$county' && SUBDIVISION LIKE 'Unincorporated area%'";
        }


        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }

        return $retval;
    }

    function get_the_stats()
    {
        global $county;
        global $sub;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();

        $sql = "SELECT * FROM ctb2016_vote_hist WHERE COUNTY LIKE '$county%' && SUBDIVISION = '$sub'";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }

        return $retval;
    }


    ?>


@endsection

@section('scripts')
    <script>
      function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight + 25) + 'px';
        obj.style.width = obj.contentWindow.document.body.scrollWidth + 'px';
      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1024pxpx";
        iframe.height = "3800px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv").appendChild(iframe);
        return false;
      }

      function removeiframes() {
        var iframes = document.querySelectorAll('iframe');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }

      function valForm(form, fourcode) {

        var type, datavisappend, electionappend, e1, e2, URL, error = '';
        var URL = 'housevote_bydist.php?id=' + fourcode;


        if (error) {
          alert(URL);
          alert(error);
          return false;
        } else {
          closeiframe();


          var link = "/img/spinner.gif";
          alert(URL);
          window.content.location.href = link;
          document.getElementById("hiddendiv").style["display"] = "inline-block";
          window.content.location.href = URL;
          return false;
        }


      }


    </script>
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

    body {
        background-color: white;
        font-family: 'Lato';
        font-size: 1em;
    }

    .dropshadow {
        -webkit-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        -moz-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
    }

    table {
        margin-left: auto;
        margin-right: auto;
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

    .analysis {
        line-height: 170%;
        font-family: 'Lato';
        font-size: 1.1em;
        padding: 5%;
        text-align: justify;
        margin-left: auto;
        margin-right: auto;
    }

    .analysis strong, b {
        font-weight: bold;
        color: blue;
    }

    .analysis img {
        border-radius: 15px;
        float: left;
        max-width: 150px;
        padding: 5px;
    }

    .campaignHead {
        font-size: 2.0em;
        font-weight: bold;
        color: FireBrick;
        text-align: center;
        font-family: 'Lato';
        font-variant: small-caps;
    }

    .campaignSubHead {
        font-size: 1.5em;
        font-weight: bold;
        color: black;
        text-align: center;
        font-family: 'Lato';
        font-variant: small-caps;
    }

    #districtWrapper {
        box-shadow: 3px 3px 3px #999;
    }

    .supeclass {
        max-width: 500px;
        float: left;
        margin: 10px;
    }

    .supeclear {
        clear: both;
    }

    #districtanalyses th {
        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    th {

        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        color: white;

    }

    #districtWrapper td {

        font-family: 'Lato';
        padding: 5px;
    }

    #greyColumn {

        background: rgb(238, 238, 238); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    #blueColumn {
        background: rgb(235, 241, 246) !important; /* Old browsers */
        background: -moz-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    .winner {
        font-weight: bold;
        font-variant: small-caps;
    }
</style>
@endsection
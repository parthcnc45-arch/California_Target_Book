<?php
Util::set_errors();
if (!$fourcode) {
    $fourcode = $_GET['id'];
}
if (!$sub) {
    $sub = $_GET['sub'];
}
//echo("<br>SUB: $sub, FOURCODE: $fourcode");
global $sub_store, $county_store;
$sub_store = $sub;
$county_store = $id;
?>

@extends('layouts.book')

@section('title', "City/County Subdivision Detail Rpt - $fourcode - $sub")

@section('content')


    <div class="container-fluid">

    <?php
    Util::require_ctb_api();
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();
    global $county, $sub;
    $county = $_GET['id'];
    $sub = $_GET['sub'];
    if ($county_store) {
        $county = $county_store;
    }
    if ($sub_store) {
        $sub = $sub_store;
    }
    //echo("<br>SUB: $sub");
    if (!$county) {
        
        $county2 = lookup_city_county($sub);
        echo("<p align='center'>City of $sub<br>$county2</p>");
    } else {
            echo("<p align='center'>$county - $sub</p>");
    }
    $x = get_the_stats();
    $y = get_past_reg();
    //CALCULATE VOTER REGISTRATION
    $dem = number_format((($y['NOW_DEM'] / $y['NOW_TOT']) * 100), 2);
    $rep = number_format((($y['NOW_REP'] / $y['NOW_TOT']) * 100), 2);
    $npp = number_format((($y['NOW_NPP'] / $y['NOW_TOT']) * 100), 2);
    $tot = number_format($y['NOW_TOT']);
    
    $findme = "District";
    $is_district = substr_count($sub, $findme);
    if ($is_district) {
        $is_city = 0;
        //echo("<br>IDENTIFIED GROUP PRONE TO REDISTRICTING, IGNORING PRE-2012 RESULTS");
    } else {
        if ($sub != "County Totals") {
            $is_city = 1;
        }
        //echo("<br>IDENTIFIED CITY OR COUNTY");
    }
    $now_rep = $y['NOW_REP'];
    $now_dem = $y['NOW_DEM'];
    $now_npp = $y['NOW_NPP'];
    $now_tot = $y['NOW_TOT'];
    $now_adv = vote_adv($now_dem, $now_rep, $now_tot);

    $g18_rep = $y['G18_REP'];
    $g18_dem = $y['G18_DEM'];
    $g18_npp = $y['G18_NPP'];
    $g18_tot = $y['G18_TOT'];
    $g18_adv = vote_adv($g18_dem, $g18_rep, $g18_tot);    
    
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

    $now_span = "<br><span class='boldme'>NOW:</span>
             <span class='blueme boldme'>DEM: " . number_format($now_dem) . " (" . makepct($now_dem, $now_tot) . ")</span> |
             <span class='redme boldme'>REP: " . number_format($now_rep) . " (" . makepct($now_rep, $now_tot) . ")</span> |
             <span class='grayme boldme'>NPP: " . number_format($now_npp) . " (" . makepct($now_npp, $now_tot) . ")</span> |
             <span class='boldme'>TOTAL REGISTERED - " . number_format($now_tot) . "</span> | " . $now_adv;

    $now_row = "<tr class='boldme'>
                    <td>NOW</td>

                    <td class='blueme'>DEM</td>
                    <td class='blueme' align='right'>" . number_format($now_dem) . "</td>
                    <td class='blueme' align='right'>" . makepct($now_dem, $now_tot) . "</td>

                    <td class='redme'>REP</td>
                    <td class='redme' align='right'>" . number_format($now_rep) . "</td>
                    <td class='redme' align='right'>" . makepct($now_rep, $now_tot) . "</td>

                    <td class='grayme'>NPP</td>
                    <td class='grayme' align='right'>" . number_format($now_npp) . "</td>
                    <td class='grayme' align='right'>" . makepct($now_npp, $now_tot) . "</td>

                    <td>TOTAL REGISTERED</td>
                    <td align='right'>" . number_format($now_tot) . "</td>
                    <td>" . $now_adv . "</td>
                </tr>";

             

    $g18_row = "<tr class='boldme'>
                    <td>G18</td>

                    <td class='blueme'>DEM</td>
                    <td class='blueme' align='right'>" . number_format($g18_dem) . "</td>
                    <td class='blueme' align='right'>" . makepct($g18_dem, $g18_tot) . "</td>

                    <td class='redme'>REP</td>
                    <td class='redme' align='right'>" . number_format($g18_rep) . "</td>
                    <td class='redme' align='right'>" . makepct($g18_rep, $g18_tot) . "</td>

                    <td class='grayme'>NPP</td>
                    <td class='grayme' align='right'>" . number_format($g18_npp) . "</td>
                    <td class='grayme' align='right'>" . makepct($g18_npp, $g18_tot) . "</td>

                    <td>TOTAL REGISTERED</td>
                    <td align='right'>" . number_format($g18_tot) . "</td>
                    <td>" . $g18_adv . "</td>
                </tr>";


    $g16_row = "<tr class='boldme'>
                    <td>G16</td>

                    <td class='blueme'>DEM</td>
                    <td class='blueme' align='right'>" . number_format($g16_dem) . "</td>
                    <td class='blueme' align='right'>" . makepct($g16_dem, $g16_tot) . "</td>

                    <td class='redme'>REP</td>
                    <td class='redme' align='right'>" . number_format($g16_rep) . "</td>
                    <td class='redme' align='right'>" . makepct($g16_rep, $g16_tot) . "</td>

                    <td class='grayme'>NPP</td>
                    <td class='grayme' align='right'>" . number_format($g16_npp) . "</td>
                    <td class='grayme' align='right'>" . makepct($g16_npp, $g16_tot) . "</td>

                    <td>TOTAL REGISTERED</td>
                    <td align='right'>" . number_format($g16_tot) . "</td>
                    <td>" . $g16_adv . "</td>
                </tr>";

    $g14_row = "<tr class='boldme'>
                    <td>G14</td>

                    <td class='blueme'>DEM</td>
                    <td class='blueme' align='right'>" . number_format($g14_dem) . "</td>
                    <td class='blueme' align='right'>" . makepct($g14_dem, $g14_tot) . "</td>

                    <td class='redme'>REP</td>
                    <td class='redme' align='right'>" . number_format($g14_rep) . "</td>
                    <td class='redme' align='right'>" . makepct($g14_rep, $g14_tot) . "</td>

                    <td class='grayme'>NPP</td>
                    <td class='grayme' align='right'>" . number_format($g14_npp) . "</td>
                    <td class='grayme' align='right'>" . makepct($g14_npp, $g14_tot) . "</td>

                    <td>TOTAL REGISTERED</td>
                    <td align='right'>" . number_format($g14_tot) . "</td>
                    <td>" . $g14_adv . "</td>
                </tr>";

    $g12_row = "<tr class='boldme'>
                    <td>G12</td>

                    <td class='blueme'>DEM</td>
                    <td class='blueme' align='right'>" . number_format($g12_dem) . "</td>
                    <td class='blueme' align='right'>" . makepct($g12_dem, $g12_tot) . "</td>

                    <td class='redme'>REP</td>
                    <td class='redme' align='right'>" . number_format($g12_rep) . "</td>
                    <td class='redme' align='right'>" . makepct($g12_rep, $g12_tot) . "</td>

                    <td class='grayme'>NPP</td>
                    <td class='grayme' align='right'>" . number_format($g12_npp) . "</td>
                    <td class='grayme' align='right'>" . makepct($g12_npp, $g12_tot) . "</td>

                    <td>TOTAL REGISTERED</td>
                    <td align='right'>" . number_format($g12_tot) . "</td>
                    <td>" . $g12_adv . "</td>
                </tr>";                                                



    if ($is_city) {

        $alt_prop_table = generate_table($x, TRUE);


        $g10_row = "<tr class='boldme'>
                        <td>G10</td>

                        <td class='blueme'>DEM</td>
                        <td class='blueme' align='right'>" . number_format($g10_dem) . "</td>
                        <td class='blueme' align='right'>" . makepct($g10_dem, $g10_tot) . "</td>

                        <td class='redme'>REP</td>
                        <td class='redme' align='right'>" . number_format($g10_rep) . "</td>
                        <td class='redme' align='right'>" . makepct($g10_rep, $g10_tot) . "</td>

                        <td class='grayme'>NPP</td>
                        <td class='grayme' align='right'>" . number_format($g10_npp) . "</td>
                        <td class='grayme' align='right'>" . makepct($g10_npp, $g10_tot) . "</td>

                        <td>TOTAL REGISTERED</td>
                        <td align='right'>" . number_format($g10_tot) . "</td>
                        <td>" . $g10_adv . "</td>
                    </tr>";    

        $g08_row = "<tr class='boldme'>
                        <td>G08</td>

                        <td class='blueme'>DEM</td>
                        <td class='blueme' align='right'>" . number_format($g08_dem) . "</td>
                        <td class='blueme' align='right'>" . makepct($g08_dem, $g08_tot) . "</td>

                        <td class='redme'>REP</td>
                        <td class='redme' align='right'>" . number_format($g08_rep) . "</td>
                        <td class='redme' align='right'>" . makepct($g08_rep, $g08_tot) . "</td>

                        <td class='grayme'>NPP</td>
                        <td class='grayme' align='right'>" . number_format($g08_npp) . "</td>
                        <td class='grayme' align='right'>" . makepct($g08_npp, $g08_tot) . "</td>

                        <td>TOTAL REGISTERED</td>
                        <td align='right'>" . number_format($g08_tot) . "</td>
                        <td>" . $g08_adv . "</td>
                    </tr>";                    


       
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
                <tbody style='font-size: 0.9em;'>
                    <tr>
                        <th colspan='3'>President '08</th>
                        <th colspan='3'>Governor '10</th>
                        <th colspan='3'>U.S. Senate '10</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>Barack Obama (D)<br>John McCain (R)</td>
                        <td id='greyColumn'>" . number_format($x['G08_PRSDEM']) . "<br>" . number_format($x['G08_PRSREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G08_PRSDEM'] / $g08_prs_tot) * 100), 2) . "%<br>" . number_format((($x['G08_PRSREP'] / $g08_prs_tot) * 100), 2) . "%</td>
                        <td id='blueColumn'>Jerry Brown (D)<br>Meg Whitman (R)</td>
                        <td id='greyColumn'>" . number_format($x['G10_GOVDEM']) . "<br>" . number_format($x['G10_GOVREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G10_GOVDEM'] / $g10_gov_tot) * 100), 2) . "%<br>" . number_format((($x['G10_GOVREP'] / $g10_gov_tot) * 100), 2) . "%</td>
                        <td id='blueColumn'>Barbara Boxer (D-Inc)<br>Carly Fiorina (R)</td>
                        <td id='greyColumn'>" . number_format($x['G10_USSDEM']) . "<br>" . number_format($x['G10_USSREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G10_USSDEM'] / $g10_uss_tot) * 100), 2) . "%<br>" . number_format((($x['G10_USSREP'] / $g10_uss_tot) * 100), 2) . "%</td>
                    </tr>
                </tbody>
            </table>";
    } else {
        $alt_prop_table = generate_table($x, FALSE);
    }

    $past_reg_span = "<table class='pad_table' align='center'><tbody>" . $g08_row . $g10_row . $g12_row . $g14_row . $g16_row . $g18_row . $now_row . "</tbody></table>";
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

    $g18_uss_tot = $x['G18_USSDEM1'] + $x['G18_USSDEM2'];
    $g18_gov_tot = $x['G18_GOVDEM'] + $x['G18_GOVREP'];    
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

    $g08_p1a_tot = $x['G08_P1AY'] + $x['G08_P1AN'];
    $g08_p2_tot = $x['G08_P2Y'] + $x['G08_P2N'];
    $g08_p3_tot = $x['G08_P3Y'] + $x['G08_P3N'];
    $g08_p4_tot = $x['G08_P4Y'] + $x['G08_P4N'];
    $g08_p5_tot = $x['G08_P5Y'] + $x['G08_P5N'];
    $g08_p6_tot = $x['G08_P6Y'] + $x['G08_P6N'];
    $g08_p7_tot = $x['G08_P7Y'] + $x['G08_P7N'];
    $g08_p8_tot = $x['G08_P8Y'] + $x['G08_P8N'];
    $g08_p9_tot = $x['G08_P9Y'] + $x['G08_P9N'];
    $g08_p10_tot = $x['G08_P10Y'] + $x['G08_P10N'];
    $g08_p11_tot = $x['G08_P11Y'] + $x['G08_P11N'];
    $g08_p12_tot = $x['G08_P12Y'] + $x['G08_P12N'];    

    $g10_p19_tot = $x['G10_P19Y'] + $x['G10_P19N'];
    $g10_p20_tot = $x['G10_P20Y'] + $x['G10_P20N'];
    $g10_p21_tot = $x['G10_P21Y'] + $x['G10_P21N'];
    $g10_p22_tot = $x['G10_P22Y'] + $x['G10_P22N'];
    $g10_p23_tot = $x['G10_P23Y'] + $x['G10_P23N'];
    $g10_p24_tot = $x['G10_P24Y'] + $x['G10_P24N'];
    $g10_p25_tot = $x['G10_P25Y'] + $x['G10_P25N'];
    $g10_p26_tot = $x['G10_P26Y'] + $x['G10_P26N'];
    $g10_p27_tot = $x['G10_P27Y'] + $x['G10_P27N'];
    
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

    $g18_p1_tot = $x['G18_P1Y'] + $x['G18_P1N'];
    $g18_p2_tot = $x['G18_P2Y'] + $x['G18_P2N'];
    $g18_p3_tot = $x['G18_P3Y'] + $x['G18_P3N'];
    $g18_p4_tot = $x['G18_P4Y'] + $x['G18_P4N'];
    $g18_p5_tot = $x['G18_P5Y'] + $x['G18_P5N'];
    $g18_p6_tot = $x['G18_P6Y'] + $x['G18_P6N'];
    $g18_p7_tot = $x['G18_P7Y'] + $x['G18_P7N'];
    $g18_p8_tot = $x['G18_P8Y'] + $x['G18_P8N'];
    $g18_p10_tot = $x['G18_P10Y'] + $x['G18_P10N'];
    $g18_p11_tot = $x['G18_P11Y'] + $x['G18_P11N'];
    $g18_p12_tot = $x['G18_P12Y'] + $x['G18_P12N'];     
    
    $voter_reg = "<p align='center'><span class='boldme'>TOTAL REGISTERED VOTERS: $tot</span><br>
                <span class='redme boldme'>R: $rep%</span> | <span class='blueme boldme'>D: $dem%</span> | <span class='grayme boldme'>NPP: $npp%</span></p>";
    $main_table = "<table width='1024px' class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
                <tbody style='font-size: 0.9em;'>
                    <tr>
                        <th colspan='3'>President '12</th>
                        <th colspan='3'>U.S. Senate '12</th>
                        <th colspan='3'>Governor '14</th>
                        <th colspan='3'>President '16</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>Barack Obama (D-Inc)<br>Mitt Romney (R)</td>
                        <td id='greyColumn'>" . number_format($x['G12_PRSDEM']) . "<br>" . number_format($x['G12_PRSREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G12_PRSDEM'] / $g12_prs_tot) * 100), 2) . "%<br>" . number_format((($x['G12_PRSREP'] / $g12_prs_tot) * 100), 2) . "%</td>
                        <td id='blueColumn'>Dianne Feinstein (D-Inc)<br>Elizabeth Emken (R)</td>
                        <td id='greyColumn'>" . number_format($x['G12_USSDEM']) . "<br>" . number_format($x['G12_USSREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G12_USSDEM'] / $g12_uss_tot) * 100), 2) . "%<br>" . number_format((($x['G12_USSREP'] / $g12_uss_tot) * 100), 2) . "%</td>
                        <td id='blueColumn'>Jerry Brown (D-Inc)<br>Neel Kashkari (R)</td>
                        <td id='greyColumn'>" . number_format($x['G14_GOVDEM']) . "<br>" . number_format($x['G14_GOVREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G14_GOVDEM'] / $g14_gov_tot) * 100), 2) . "%<br>" . number_format((($x['G14_GOVREP'] / $g14_gov_tot) * 100), 2) . "%</td>
                        <td id='blueColumn'>Hillary Clinton (D)<br>Donald Trump (R)</td>
                        <td id='greyColumn'>" . number_format($x['G16_PRSDEM']) . "<br>" . number_format($x['G16_PRSREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G16_PRSDEM'] / $g16_prs_tot) * 100), 2) . "%<br>" . number_format((($x['G16_PRSREP'] / $g16_prs_tot) * 100), 2) . "%</td>
                    </tr>
                </tbody>
            </table>";


    $main_table .= "<table width='1024px' class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
                <tbody style='font-size: 0.9em;'>
                    <tr>
                        <th colspan='3'>Governor '18</th>
                        <th colspan='3'>U.S. Senate '18</th>
                    </tr>
                    <tr>
                        
                        <td id='blueColumn'>Gavin Newsom (D)<br>John Cox (R)</td>
                        <td id='greyColumn'>" . number_format($x['G18_GOVDEM']) . "<br>" . number_format($x['G18_GOVREP']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G18_GOVDEM'] / $g18_gov_tot) * 100), 2) . "%<br>" . number_format((($x['G18_GOVREP'] / $g18_gov_tot) * 100), 2) . "%</td>

                        <td id='blueColumn'>Dianne Feinstein (D-Inc)<br>Kevin de Leon (D)</td>
                        <td id='greyColumn'>" . number_format($x['G18_USSDEM2']) . "<br>" . number_format($x['G18_USSDEM1']) . "</td>
                        <td id='greyColumn'>" . number_format((($x['G18_USSDEM2'] / $g18_uss_tot) * 100), 2) . "%<br>" . number_format((($x['G18_USSDEM1'] / $g18_uss_tot) * 100), 2) . "%</td>


                    </tr>
                </tbody>
            </table>";

    //echo("<br>RETRIEVED RESULTS:<br>");
    echo($voter_reg . "<p align='center'>$reg_span</p>");
    echo("<p align='center'>$past_reg_span</p>");
    

    /*
    $old_prop_table = " <tr>
                        <th colspan='3'>P1A ($9.95B HSR Bond)</th>
                        <th colspan='3'>P2 (Regulate Animal Confinement)</th>
                        <th colspan='3'>P3 ($908M Childrens Hospitals Bond)</th>
                        <th colspan='3'>P4 (Abortion-Parental Notification)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P1AY'] / $g08_p1a_tot) * 100), 2) . "<br>" . number_format((($x['G08_P1AN'] / $g08_p1a_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P1AY']) . "<br>" . number_format($x['G08_P1AN']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P2Y'] / $g08_p2_tot) * 100), 2) . "<br>" . number_format((($x['G08_P2N'] / $g08_p2_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P2Y']) . "<br>" . number_format($x['G08_P2N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P3Y'] / $g08_p3_tot) * 100), 2) . "<br>" . number_format((($x['G08_P3N'] / $g08_p3_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P3Y']) . "<br>" . number_format($x['G08_P3N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P4Y'] / $g08_p4_tot) * 100), 2) . "<br>" . number_format((($x['G08_P4N'] / $g08_p4_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P4Y']) . "<br>" . number_format($x['G08_P4N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P5 (Reduce Penalties For Nonviolent Crimes)</th>
                        <th colspan='3'>P6 (Boost Crime Prevention, Increase Penalties)</th>
                        <th colspan='3'>P7 (Promote Use of Alternative Fuels)</th>
                        <th colspan='3'>P8 (Eliminate Gay Marriage)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P5Y'] / $g08_p5_tot) * 100), 2) . "<br>" . number_format((($x['G08_P5N'] / $g08_p5_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P5Y']) . "<br>" . number_format($x['G08_P5N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P6Y'] / $g08_p6_tot) * 100), 2) . "<br>" . number_format((($x['G08_P6N'] / $g08_p6_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P6Y']) . "<br>" . number_format($x['G08_P6N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P7Y'] / $g08_p7_tot) * 100), 2) . "<br>" . number_format((($x['G08_P7N'] / $g08_p7_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P7Y']) . "<br>" . number_format($x['G08_P7N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P8Y'] / $g08_p8_tot) * 100), 2) . "<br>" . number_format((($x['G08_P8N'] / $g08_p8_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P8Y']) . "<br>" . number_format($x['G08_P8N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P9 (Victim Bill of Rights)</th>
                        <th colspan='3'>P10 ($5B Alternative Fuels Bond)</th>
                        <th colspan='3'>P11 (Independent Redistricting Commission)</th>
                        <th colspan='3'>P12 ($900M Veteran Assistance Bond)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P9Y'] / $g08_p9_tot) * 100), 2) . "<br>" . number_format((($x['G08_P9N'] / $g08_p9_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P9Y']) . "<br>" . number_format($x['G08_P9N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P10Y'] / $g08_p10_tot) * 100), 2) . "<br>" . number_format((($x['G08_P10N'] / $g08_p10_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P10Y']) . "<br>" . number_format($x['G08_P10N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P11Y'] / $g08_p11_tot) * 100), 2) . "<br>" . number_format((($x['G08_P11N'] / $g08_p11_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P11Y']) . "<br>" . number_format($x['G08_P11N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G08_P12Y'] / $g08_p12_tot) * 100), 2) . "<br>" . number_format((($x['G08_P12N'] / $g08_p12_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G08_P12Y']) . "<br>" . number_format($x['G08_P12N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P19 (Marijuana Legalization)</th>
                        <th colspan='3'>P20 (House Districts Drawn By Commission)</th>
                        <th colspan='3'>P21 (Hike Vehicle Fees to Fund Parks)</th>
                        <th colspan='3'>P22 (Prohibit State From Raiding Local Funds)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P19Y'] / $g10_p19_tot) * 100), 2) . "<br>" . number_format((($x['G10_P19N'] / $g10_p19_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P19Y']) . "<br>" . number_format($x['G10_P19N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P20Y'] / $g10_p20_tot) * 100), 2) . "<br>" . number_format((($x['G10_P20N'] / $g10_p20_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P20Y']) . "<br>" . number_format($x['G10_P20N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P21Y'] / $g10_p21_tot) * 100), 2) . "<br>" . number_format((($x['G10_P21N'] / $g10_p21_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P21Y']) . "<br>" . number_format($x['G10_P21N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P22Y'] / $g10_p22_tot) * 100), 2) . "<br>" . number_format((($x['G10_P22N'] / $g10_p22_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P22Y']) . "<br>" . number_format($x['G10_P22N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P23 (Suspend Pollution Law Until Economy Rebounds)</th>
                        <th colspan='3'>P24 (Eliminate Business Tax Breaks)</th>
                        <th colspan='3'>P25 (Simple Majority to Pass Budget)</th>
                        <th colspan='3'>P26 (2/3 Majority for Tax Increases)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P23Y'] / $g10_p23_tot) * 100), 2) . "<br>" . number_format((($x['G10_P23N'] / $g10_p23_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P23Y']) . "<br>" . number_format($x['G10_P23N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P24Y'] / $g10_p24_tot) * 100), 2) . "<br>" . number_format((($x['G10_P24N'] / $g10_p24_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P24Y']) . "<br>" . number_format($x['G10_P24N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P25Y'] / $g10_p25_tot) * 100), 2) . "<br>" . number_format((($x['G10_P25N'] / $g10_p25_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P25Y']) . "<br>" . number_format($x['G10_P25N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P26Y'] / $g10_p26_tot) * 100), 2) . "<br>" . number_format((($x['G10_P26N'] / $g10_p26_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P26Y']) . "<br>" . number_format($x['G10_P26N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P27 (Eliminate Redistricting Commission)</th>
                        <th colspan='3'></th>
                        <th colspan='3'></th>
                        <th colspan='3'></th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G10_P27Y'] / $g10_p27_tot) * 100), 2) . "<br>" . number_format((($x['G10_P27N'] / $g10_p27_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G10_P27Y']) . "<br>" . number_format($x['G10_P27N']) . "</td>
                        <td id='blueColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='blueColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='blueColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='greyColumn'></td>
                    </tr>";
    if (!$g08_p8_tot) {
        $old_prop_table = '';
    }

    */

    /*
    $prop_table = "<table width='1024px' class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' class='propTable' style='clear: both; margin-top: 10px;'>
                <tbody style='font-size: 0.9em;' id='propTable'>
                    <tr>
                        <th colspan='3'>P30 (Jerry Brown's Temp Tax Increase)</th>
                        <th colspan='3'>P31 (Mandate 2-Year Budget Cycle)</th>
                        <th colspan='3'>P32 (Union/Corporate Campaign Restrictions)</th>
                        <th colspan='3'>P33 (Auto Insurance Persistency Discounts)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P30Y'] / $g12_p30_tot) * 100), 2) . "<br>" . number_format((($x['G12_P30N'] / $g12_p30_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P30Y']) . "<br>" . number_format($x['G12_P30N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P31Y'] / $g12_p31_tot) * 100), 2) . "<br>" . number_format((($x['G12_P31N'] / $g12_p31_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P31Y']) . "<br>" . number_format($x['G12_P31N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P32Y'] / $g12_p32_tot) * 100), 2) . "<br>" . number_format((($x['G12_P32N'] / $g12_p32_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P32Y']) . "<br>" . number_format($x['G12_P32N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P33Y'] / $g12_p33_tot) * 100), 2) . "<br>" . number_format((($x['G12_P33N'] / $g12_p33_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P33Y']) . "<br>" . number_format($x['G12_P33N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P34 (Eliminate Death Penalty)</th>
                        <th colspan='3'>P35 (Increase Human Trafficking Penalties)</th>
                        <th colspan='3'>P36 (Modify Three-Strikes Law)</th>
                        <th colspan='3'>P37 (Mandatory GMO Labeling)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P34Y'] / $g12_p34_tot) * 100), 2) . "<br>" . number_format((($x['G12_P34N'] / $g12_p34_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P34Y']) . "<br>" . number_format($x['G12_P34N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P35Y'] / $g12_p35_tot) * 100), 2) . "<br>" . number_format((($x['G12_P35N'] / $g12_p35_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P35Y']) . "<br>" . number_format($x['G12_P35N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P36Y'] / $g12_p36_tot) * 100), 2) . "<br>" . number_format((($x['G12_P36N'] / $g12_p36_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P36Y']) . "<br>" . number_format($x['G12_P36N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P37Y'] / $g12_p37_tot) * 100), 2) . "<br>" . number_format((($x['G12_P37N'] / $g12_p37_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P37Y']) . "<br>" . number_format($x['G12_P37N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P38 (Tax Increase for Education)</th>
                        <th colspan='3'>P39 (Tax Increase on Multi-State Businesses)</th>
                        <th colspan='3'>P40 (Redistricting Referendum)</th>
                        <th colspan='3'>P1 ($7.2B Water Bond)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P38Y'] / $g12_p38_tot) * 100), 2) . "<br>" . number_format((($x['G12_P38N'] / $g12_p38_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P38Y']) . "<br>" . number_format($x['G12_P38N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P39Y'] / $g12_p39_tot) * 100), 2) . "<br>" . number_format((($x['G12_P39N'] / $g12_p39_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P39Y']) . "<br>" . number_format($x['G12_P39N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G12_P40Y'] / $g12_p40_tot) * 100), 2) . "<br>" . number_format((($x['G12_P40N'] / $g12_p40_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G12_P40Y']) . "<br>" . number_format($x['G12_P40N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G14_P1Y'] / $g14_p1_tot) * 100), 2) . "<br>" . number_format((($x['G14_P1N'] / $g14_p1_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G14_P1Y']) . "<br>" . number_format($x['G14_P1N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P2 (Increase Rainy Day Fund)</th>
                        <th colspan='3'>P45 (Public Notice for Insurance Rates)</th>
                        <th colspan='3'>P46 (Increase Cap on Medical Damages)</th>
                        <th colspan='3'>P47 (Criminal Code Reform)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G14_P2Y'] / $g14_p2_tot) * 100), 2) . "<br>" . number_format((($x['G14_P2N'] / $g14_p2_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G14_P2Y']) . "<br>" . number_format($x['G14_P2N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G14_P45Y'] / $g14_p45_tot) * 100), 2) . "<br>" . number_format((($x['G14_P45N'] / $g14_p45_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G14_P45Y']) . "<br>" . number_format($x['G14_P45N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G14_P46Y'] / $g14_p46_tot) * 100), 2) . "<br>" . number_format((($x['G14_P46N'] / $g14_p46_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G14_P46Y']) . "<br>" . number_format($x['G14_P46N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G14_P47Y'] / $g14_p47_tot) * 100), 2) . "<br>" . number_format((($x['G14_P47N'] / $g14_p47_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G14_P47Y']) . "<br>" . number_format($x['G14_P47N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P48 (Ratify Gaming Compact)</th>
                        <th colspan='3'>P51 (School Construction Bond)</th>
                        <th colspan='3'>P52 (Medi-Cal Hospital Fee)</th>
                        <th colspan='3'>P53 (Voter Approval of Revenue Bonds)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G14_P48Y'] / $g14_p48_tot) * 100), 2) . "<br>" . number_format((($x['G14_P48N'] / $g14_p48_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G14_P48Y']) . "<br>" . number_format($x['G14_P48N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P51Y'] / $g16_p51_tot) * 100), 2) . "<br>" . number_format((($x['G16_P51N'] / $g16_p51_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P51Y']) . "<br>" . number_format($x['G16_P51N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P52Y'] / $g16_p52_tot) * 100), 2) . "<br>" . number_format((($x['G16_P52N'] / $g16_p52_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P52Y']) . "<br>" . number_format($x['G16_P52N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P53Y'] / $g16_p53_tot) * 100), 2) . "<br>" . number_format((($x['G16_P53N'] / $g16_p53_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P53Y']) . "<br>" . number_format($x['G16_P53N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P54 (Legislative Transparency)</th>
                        <th colspan='3'>P55 (Extend Prop 30 Tax Rates)</th>
                        <th colspan='3'>P56 (Tax on Tobacco Products)</th>
                        <th colspan='3'>P57 (Parole / Juvenile Justice Reform)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P54Y'] / $g16_p54_tot) * 100), 2) . "<br>" . number_format((($x['G16_P54N'] / $g16_p54_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P54Y']) . "<br>" . number_format($x['G16_P54N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P55Y'] / $g16_p55_tot) * 100), 2) . "<br>" . number_format((($x['G16_P55N'] / $g16_p55_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P55Y']) . "<br>" . number_format($x['G16_P55N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P56Y'] / $g16_p56_tot) * 100), 2) . "<br>" . number_format((($x['G16_P56N'] / $g16_p56_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P56Y']) . "<br>" . number_format($x['G16_P56N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P57Y'] / $g16_p57_tot) * 100), 2) . "<br>" . number_format((($x['G16_P57N'] / $g16_p57_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P57Y']) . "<br>" . number_format($x['G16_P57N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P58 (Multilingual Education)</th>
                        <th colspan='3'>P59 (Citizens United Advisory)</th>
                        <th colspan='3'>P60 (Mandate Condoms in Adult Films)</th>
                        <th colspan='3'>P61 (Prescription Drug Price Control)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P58Y'] / $g16_p58_tot) * 100), 2) . "<br>" . number_format((($x['G16_P58N'] / $g16_p58_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P58Y']) . "<br>" . number_format($x['G16_P58N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P59Y'] / $g16_p59_tot) * 100), 2) . "<br>" . number_format((($x['G16_P59N'] / $g16_p59_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P59Y']) . "<br>" . number_format($x['G16_P59N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P60Y'] / $g16_p60_tot) * 100), 2) . "<br>" . number_format((($x['G16_P60N'] / $g16_p60_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P60Y']) . "<br>" . number_format($x['G16_P60N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P61Y'] / $g16_p61_tot) * 100), 2) . "<br>" . number_format((($x['G16_P61N'] / $g16_p61_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P61Y']) . "<br>" . number_format($x['G16_P61N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P62 (Eliminate Death Penalty)</th>
                        <th colspan='3'>P63 (Firearms & Ammunition Restrictions)</th>
                        <th colspan='3'>P64 (Legalize Marijuana)</th>
                        <th colspan='3'>P65 (Divert Carryout Bag Fees From Retailers)</th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P62Y'] / $g16_p62_tot) * 100), 2) . "<br>" . number_format((($x['G16_P62N'] / $g16_p62_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P62Y']) . "<br>" . number_format($x['G16_P62N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P63Y'] / $g16_p63_tot) * 100), 2) . "<br>" . number_format((($x['G16_P63N'] / $g16_p63_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P63Y']) . "<br>" . number_format($x['G16_P63N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P64Y'] / $g16_p64_tot) * 100), 2) . "<br>" . number_format((($x['G16_P64N'] / $g16_p64_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P64Y']) . "<br>" . number_format($x['G16_P64N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P65Y'] / $g16_p65_tot) * 100), 2) . "<br>" . number_format((($x['G16_P65N'] / $g16_p65_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P65Y']) . "<br>" . number_format($x['G16_P65N']) . "</td>
                    </tr>
                    <tr>
                        <th colspan='3'>P66 (Strengthen Death Penalty)</th>
                        <th colspan='3'>P67 (Uphold Plastic Bag Ban)</th>
                        <th colspan='3'></th>
                        <th colspan='3'></th>
                    </tr>
                    <tr>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P66Y'] / $g16_p66_tot) * 100), 2) . "<br>" . number_format((($x['G16_P66N'] / $g16_p66_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P66Y']) . "<br>" . number_format($x['G16_P66N']) . "</td>
                        <td id='blueColumn'>YES<br>NO</td>
                        <td id='greyColumn'>" . number_format((($x['G16_P67Y'] / $g16_p67_tot) * 100), 2) . "<br>" . number_format((($x['G16_P67N'] / $g16_p67_tot) * 100), 2) . "</td>
                        <td id='greyColumn' align='right'>" . number_format($x['G16_P67Y']) . "<br>" . number_format($x['G16_P67N']) . "</td>
                        <td id='blueColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='blueColumn'></td>
                        <td id='greyColumn'></td>
                        <td id='greyColumn'></td>
                    </tr>" . $old_prop_table .
        "</tbody>
            </table>";

    */
    echo($pres_span);
    echo($main_table);
    if ($alt_table) {
        echo($alt_table);
    }
    //echo($prop_table);
    echo($alt_prop_table);
    //echo(htmlspecialchars($alt_prop_table));
    $has_local = has_local($sub);
    if ($sub == "County Totals") {
        $is_county = TRUE;
    }
    if ($is_city && $has_local) {
                $elections_div = "<div align='center' width='100%'><p align='center'><br><br><h2>ELECTION RESULTS</h2><br>
                                <input type='radio' name='ev' id='p12' value='p12'/>
                                <label for='p12'>2012 Primary</label>
                                <input type='radio' name='ev' id='g12' value='g12'/>
                                <label for='g12'>2012 General</label>
                                <input type='radio' name='ev' id='p14' value='p14'/>
                                <label for='p14'>2014 Primary</label>
                                <input type='radio' name='ev' id='g14' value='g14'/>
                                <label for='g14'>2014 General</label>
                                <input type='radio' name='ev' id='p16' value='p16'/>
                                <label for='p16'>2016 Primary</label>
                                <input type='radio' name='ev' id='g16' value='g16'/>
                                <label for='g16'>2016 General</label>
                                <input type='radio' name='ev' id='local' value='local'/>                                                                                                                                                                    
                                <label for='local'>Local Elections</label>
                                <input id='btmClose1' class='btn' value='CLOSE' onclick='closeCityDiv()' type='button' style='display: none;'/>
                                </p>



        ";
        echo($elections_div);

        $local_js = "
    <script type='text/javascript'>
    $(\"input[name='ev']\").change(function(){
        var x = $(\"input[name='ev']:checked\").val();
        switch(x) {
            case 'p12':
                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p12';
                break;
            case 'g12':
                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g12';
                break;
            case 'p14':
                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p14';
                break;
            case 'g14':
                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g14';
                break;
            case 'p16':
                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p16';
                break;
            case 'g16':
                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g16';
                break;
            case 'local':
                var url = '/book/get_city_results.php?id=$sub';
                break;
        }
        document.getElementById('cityDiv').style.display = 'block';
        document.getElementById('btmClose1').style.display = 'block';
        document.getElementById('btmClose2').style.display = 'block';
        document.getElementById('cityHidden').src = url;
        

    });


    function closeCityDiv() {
        document.getElementById('cityDiv').style.display = 'none';
        document.getElementById('btmClose1').style.display = 'none';
        document.getElementById('btmClose2').style.display = 'none';
        document.getElementById('cityHidden').src = '/img/spinner.gif';
    }
    
    </script>";

        // echo($local_js);
        array_push($endjava, $local_js);
        ?>
        <p align='center'>
    <div id="cityDiv" style="display:none;" class="answer_list">
        <iframe src="/img/spinner.gif" id="cityHidden" height="1000" width="1024"></iframe>
    </div>
    <p style='margin-left: auto !important; margin-right: auto !important;' align='center'>
        <input class="btn" style="display: none;" id="btmClose2" value="CLOSE" onclick="closeCityDiv()" type="button" />
    </p>
        </p>
        </div>

   <?php
   
    } elseif ($is_county) {
        echo("<div align='center' width='100%'>");
        $local_js = "
    <script type='text/javascript'>
    function showCityDiv(z) {
        var url = '/ctb-legacy/get_county_all.php?id=$county';
        if(z == 1) {
            document.getElementById('cityDiv').style.display = 'block';
            document.getElementById('btmClose').style.display = 'block';
            document.getElementById('cityHidden').src = url;
        } else {
            document.getElementById('cityDiv').style.display = 'none';
            document.getElementById('btmClose').style.display = 'none';
            document.getElementById('cityHidden').src = '/img/spinner.gif';
        }
    }
    </script>";
        // echo($local_js);
        array_push($endjava, $local_js);
        $city_detail_div = "
    <p><input class=\"button btn btn-primary\" name=\"answer\" value=\"Past Local Election Results\" onclick=\"showCityDiv(1)\" title=\"Past Local Election Results\" width=\"300px\" type=\"button\" /> <input class=\"close\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <div id=\"cityDiv\" style=\"display:none;\" class=\"answer_list\"><iframe src=\"/img/spinner.gif\" id=\"cityHidden\" height=\"1000\" width=\"1024px\"></iframe></div>
    <p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"close btmclose\" style=\"display: none;\" id=\"btmClose\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>";
        echo($city_detail_div . "</div>");
    }
    if ($is_city) {
        ?>
           <div class="col-md-10 center-block fn">
               @include('old.get_city_demographics', [ 'id' => $sub ])
           </div>
    <?php
//        echo("<div width='100%' align='center'><iframe style='margin-right: auto; margin-left: auto;' align='center' src='/book/get_city_demographics?id=$sub' height=\"1000\" width='1024px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>");
        $census_js = "
    <script type='text/javascript'>
    function showCensusDiv(z) {
        var url = '/book/get_city_census?id=$sub';
        if(z == 1) {
            document.getElementById('censusDiv').style.display = 'block';
            document.getElementById('btmClose3').style.display = 'block';
            document.getElementById('btmClose4').style.display = 'block';
            document.getElementById('censusHidden').src = url;
        } else {
            document.getElementById('censusDiv').style.display = 'none';
            document.getElementById('btmClose3').style.display = 'none';
            document.getElementById('btmClose4').style.display = 'none';
            document.getElementById('censusHidden').src = '/img/spinner.gif';
        }
    }
    </script>";
        // echo($census_js);
        array_push($endjava, $census_js);
        $census_detail_div = "
    <p align='center'><input class=\"btn btn-success\" name=\"answer\" value=\"Full Census Detail\" onclick=\"showCensusDiv(1)\" title=\"Census Data\" width=\"300px\" type=\"button\" /> 
    <input id='btmClose3' class=\"btn btn-primary\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\" style='display: none;'/></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p align='center'>
    <div id=\"censusDiv\" style=\"display:none;\" class=\"answer_list\" align='center'><iframe src=\"/img/spinner.gif\" id=\"censusHidden\" height=\"1000px\" width=\"1024px\" align='center'></iframe></div>
    <p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"btn btn-primary\" style=\"display: none;\" id=\"btmClose4\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\" /></p>";
        echo($census_detail_div . "</div></p>");
    }
    if ($is_city && !$is_county) {
        $info = get_city_info($sub);
        //var_dump($info);
        if ($info) {
            $link = "<a href='" . $info['weblink'] . "' target='_blank'>" . $sub . "</a>";
            $city_info_div = "<div width='100%' align='center'><p align='center'>$link<br>Incorporated " . $info['dateincorp'] . "<br>" . number_format($info['land_sqmi'], 2) . " Square Miles</p></div>";
            echo($city_info_div);
        }
        echo("<div width='100%' align='center' style='margin-top: 20px'><p align='center'>LOCATION</p><iframe src='/book/draw_leg?city=$sub' height='610px' width='810px' style='margin-left: auto; margin-right: auto; overflow: hidden;'></iframe></div>");
    }
    //var_dump($x);



    function generate_table($x, $getall) {
        $props['G08'] = Array("P1A", "P2", "P3", "P4", "P5", "P6", "P7", "P8", "P9", "P10", "P11", "P12");
        $props['G10'] = Array("P19", "P20", "P21", "P22", "P23", "P24", "P25", "P26", "P27");
        $props['G12'] = Array("P30", "P31", "P32", "P33", "P34", "P35", "P36", "P37", "P38", "P39", "P40");
        $props['G14'] = Array("P1", "P2", "P45", "P46", "P47", "P48");
        $props['G16'] = Array("P51", "P52", "P53", "P54", "P55", "P56", "P57", "P58", "P59", "P60", "P61", "P62", "P63", "P64", "P65", "P66", "P67");
        $props['G18'] = Array("P1", "P2", "P3", "P4", "P5", "P6", "P7", "P8", "P10", "P11", "P12");

        if($getall) {
            $elections = Array("G08", "G10", "G12", "G14", "G16", "G18");
        } else {
            $elections = Array("G12", "G14", "G16", "G18");
        }

        $props_per_row = 4;
        $i = 0;
        foreach ($elections as $election) {
            foreach ($props[$election] as $p) {
                $header[$i] = "<th colspan='3'>$p (" . get_prop($election . "_" . $p) . ")</th>";
                $yes = $election . "_" . $p . "Y";
                $no = $election . "_" . $p . "N";
                $yes_vote = $x[$yes];
                $no_vote = $x[$no];
                $tot_vote = $yes_vote + $no_vote;
                if ($yes_vote > $no_vote) {
                    $yes_span = 'greenme boldme';
                    $no_span = '';
                } elseif ($no_vote > $yes_vote) {
                    $yes_span = '';
                    $no_span = 'redme boldme';
                } else {
                    $yes_span = '';
                    $no_span = '';
                }
                $yes_pct = number_format((($yes_vote / $tot_vote) * 100), 2);
                $no_pct = number_format((($no_vote / $tot_vote) * 100), 2);
                $body[$i] = "<td id='blueColumn'><span class='$yes_span'>YES</span><br><span class='$no_span'>NO</span></td>
                         <td id='greyColumn' align='right' width='40'><span class='$yes_span'>" . number_format($yes_vote) . "</span><br><span class='$no_span'>" . number_format($no_vote) . "</span></td>
                         <td id='greyColumn' align='right' width='40'><span class='$yes_span'>" . $yes_pct . "%</span><br><span class='$no_span'>" . $no_pct . "%</span></td>
                         ";
                $tot_votes[$i] = $tot_vote;
                $i++;
            }
        }
        $l = $i;
        $i = 0;
        $r = 0;
        while ($i < $l) {
            $c = 0;
            while ($c < $props_per_row) {
                $offset = $i + $c;
                //echo("<br>R: $r I: $i C: $c O: $offset - HEADER");
                if ($c == 0) {
                    $html .= "<tr>";
                }
                if ($tot_votes[$offset]) {
                    $html .= $header[$offset];
                }
                $c++;
            }
            $html .= "</tr>";
            $c = 0;
            while ($c < $props_per_row) {
                $offset = $i + $c;
                //echo("<br>R: $r I: $i C: $c O: $offset - BODY");
                if ($c == 0) {
                    $html .= "<tr>";
                }
                if ($tot_votes[$offset]) {
                    $html .= $body[$offset];
                }
                $c++;
            }
            $html .= "</tr>";
            $i = $i + $props_per_row;
            $r++;
        }
        //var_dump($header);
        $retval = "<table width='1024px' class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' class='propTable' style='clear: both; margin-top: 10px;'>
                <tbody style='font-size: 0.9em;' id='propTable'>" . $html . "</tbody></table>";
        return $retval;
    }
    function get_prop($header) {
        $prop_array = Array(
            "G08_P1A" => "$9.95B HSR Bond",
            "G08_P2" => "Regulate Animal Confinement",
            "G08_P3" => "$980M Childrens Hospitals Bond",
            "G08_P4" => "Abortion-Parental Notificaton",
            "G08_P5" => "Reduce Penalties for Nonviolent Crimes",
            "G08_P6" => "Boost Crime Prevention, Increase Penalties",
            "G08_P7" => "Promote Use of Alternative Fuels",
            "G08_P8" => "Eliminate Gay Marriage",
            "G08_P9" => "Victim Bill of Rights",
            "G08_P10" => "$5B Alternative Fuels Bond",
            "G08_P11" => "Independent Redistricting Commission",
            "G08_P12" => "$900M Veteran Assistance Bond",
            "G10_P19" => "Marijuana Legalization",
            "G10_P20" => "House Districts Drawn By Commission",
            "G10_P21" => "Hike Vehicle Fees to Fund Parks",
            "G10_P22" => "Prohibit State From Raiding Local Funds",
            "G10_P23" => "Suspend Pollution Laws Until Economy Rebounds",
            "G10_P24" => "Eliminate Business Tax Breaks",
            "G10_P25" => "Simple Majority to Pass Budget",
            "G10_P26" => "2/3 Majority for Tax Increases",
            "G10_P27" => "Eliminate Redistricting Commission",
            "G12_P30" => "Jerry Brown's Tax Increase",
            "G12_P31" => "Mandate 2-Year Budget Cycle",
            "G12_P32" => "Union/Corporate Campaign Restrictions",
            "G12_P33" => "Auto Insurance Persistency Discounts",
            "G12_P34" => "Eliminate Death Penalty",
            "G12_P35" => "Increase Penalties for Human Trafficking",
            "G12_P36" => "Modify 3-Strikes Law",
            "G12_P37" => "Mandatory GMO Labeling",
            "G12_P38" => "Tax Increase for Education",
            "G12_P39" => "Tax Increase on Multi-State Businesses",
            "G12_P40" => "Redistricting Referendum",
            "G14_P1" => "$7.2B Water Bond",
            "G14_P2" => "Increase Rainy Day Fund",
            "G14_P45" => "Public Notice for Insurance Rates",
            "G14_P46" => "Increase Cap on Medical Damages",
            "G14_P47" => "Criminal Code Reform",
            "G14_P48" => "Ratify Gaming Compact",
            "G16_P51" => "School Construction Bond",
            "G16_P52" => "Medi-Cal Hospital Fee",
            "G16_P53" => "Voter Approval of Revenue Bonds",
            "G16_P54" => "Legislative Transparency",
            "G16_P55" => "Extend Prop 30 Tax Increases",
            "G16_P56" => "Tax on Tobacco Products",
            "G16_P57" => "Parole/Juvenile Justice Reform",
            "G16_P58" => "Multilingual Education",
            "G16_P59" => "Citizens United Advisory",
            "G16_P60" => "Mandate Condoms in Adult Films",
            "G16_P61" => "Prescription Drug Price Control",
            "G16_P62" => "Eliminate Death Penalty",
            "G16_P63" => "Firearms & Ammunition Restrictions",
            "G16_P64" => "Legalize Marijuana",
            "G16_P65" => "Divert Carryout Bag Fees From Retailers",
            "G16_P66" => "Strengthen Death Penalty",
            "G16_P67" => "Uphold Plastic Bag Ban",

            "G18_P1" => "Veterans Housing Bond",
            "G18_P2" => "Homeless Housing Bond",
            "G18_P3" => "Water Projects Bond",
            "G18_P4" => "Childrens Hospitals Bond",
            "G18_P5" => "Prop 13 Tax Portability",
            "G18_P6" => "Gas Tax Repeal",
            "G18_P7" => "Eliminate Daylight Savings Time",
            "G18_P8" => "Regulate Kidney Dialysis Clinics",
            "G18_P10" => "Rent Control (Repeal Costa-Hawkins)",
            "G18_P11" => "Private Sector Ambulance Rules",
            "G18_P12" => "Humane Animal Confinement",


        );
        return $prop_array[$header];
    }
    function vote_adv($d, $r, $t) {
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
    function get_city_info($sub) {
        $conn = Util::get_ctb_conn();
        $sql = "SELECT land_sqmi, dateincorp, weblink FROM cal_cities_ca_cities WHERE name = '$sub'";
        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
    }

    function lookup_city_county($city) {
        $conn = Util::get_ctb_conn();
        $sql = "SELECT COUNTY FROM ctb2016_vote_hist_UPDATED WHERE SUBDIVISION = '$city'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $retval = $row['COUNTY'];
            }
        }
        return $retval;
    }
    function has_local($sub) {
        $city = $sub;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $sql = "SELECT * FROM ctb2016_city_vote_hist_UPDATED WHERE CITY = '$city' ORDER BY DATE DESC, OFFICE, SEAT DESC, VOTE_PCT DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($retval, $row);
                return TRUE;
            }
        }
        return FALSE;
    }
    function get_past_reg() {
        global $county, $sub;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE COUNTY = '$county' && SUBDIVISION = '$sub'";
        if (!$county) {
            $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE SUBDIVISION = '$sub'";
        }
        $findme = "Unincorporated";
        $is_unincorporated = substr_count($sub, $findme);
        if ($is_unincorporated) {
            $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE COUNTY = '$county' && SUBDIVISION LIKE 'Unincorporated area%'";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }
        return $retval;
    }
    function get_the_stats() {
        global $county;
        global $sub;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT * FROM ctb2016_vote_hist_UPDATED WHERE COUNTY LIKE '$county%' && SUBDIVISION = '$sub'";
        if (!$county) {
            $sql = "SELECT * FROM ctb2016_vote_hist_UPDATED WHERE SUBDIVISION = '$sub'";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }
        return $retval;
    }
    ?>
    </div>


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

    <?php
    foreach ($endjava as $value) {
        echo($value);
    }
    ?>

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
        input.button {
            background: #dedede;
            background-image: -webkit-linear-gradient(top, #dedede, #787878) !important;
            background-image: -moz-linear-gradient(top, #dedede, #787878) !important;
            background-image: -ms-linear-gradient(top, #dedede, #787878) !important;
            background-image: -o-linear-gradient(top, #dedede, #787878) !important;
            background-image: linear-gradient(to bottom, #dedede, #787878) !important;
            -webkit-box-shadow: 0px 1px 3px #666666 !important;
            -moz-box-shadow: 0px 1px 3px #666666 !important;
            box-shadow: 2px 2px 3px #666666 !important;
            font-family: 'Lato' !important;
            font-weight: normal !important;
            color: white !important;
            font-size: 16px !important;
            border: solid black 2px !important;
            width: 28% !important;
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
            -webkit-box-shadow: 0px 1px 3px #666666 !important;
            -moz-box-shadow: 0px 1px 3px #666666 !important;
            box-shadow: 0px 1px 3px #666666 !important;
            font-family: 'Lato' !important;
            font-weight: normal !important;
            color: white !important;
            font-size: 14px !important;
            border: solid black 2px !important;
            margin-left: auto !important;
            margin-right: auto !important;
            width: 10% !important;          
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
        #districtanalyses th {
            background: rgb(82, 133, 216); /* Old browsers */
            background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        }
        th {
            color: white;
            background: rgb(82, 133, 216); /* Old browsers */
            background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        }
        #districtWrapper td {
            font-family: 'Lato';
            padding: 5px;
        }
        .greyColumn {
            background: rgb(238, 238, 238); /* Old browsers */
            background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        }
        .blueColumn {
            background: rgb(235, 241, 246) !important; /* Old browsers */
            background: -moz-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* FF3.6-15 */
            background: -webkit-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
            background: linear-gradient(to bottom, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
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
        .greenme {
            color: green;
        }

        .pad_table td, th {
            padding-left: 5px;
            padding-right: 5px;
        }
    </style>
@endsection
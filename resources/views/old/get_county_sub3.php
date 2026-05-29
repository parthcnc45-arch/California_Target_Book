
<?php

global $county;
global $sub;

//echo("<br>$county - $sub - $id");

Util::require_ctb_api();





//error_reporting(E_ALL); 
//ini_set('display_errors', '1');
setlocale(LC_COLLATE, "en_US");
setlocale(LC_CTYPE, "en_US");
//$endjava = Array();

if (!$county) {
    //global $county;
    //$county = $_GET['id'];
}

if (!$sub) {
    //global $sub;
    $sub = "County Totals";
}



$old_tables = '';
$new_table = '';
$prop_table = '';
$g08p_span = '';

//CALCULATE VOTER REGISTRATION



$x = get_the_stats($county, $sub);



$y = get_past_reg();


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

if ($sub == "County Totals") {
    $cnty_tot = TRUE;
} else {
    $cnty_tot = FALSE;
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

$reg_table = "<table class='registration_table'>
				<thead>
					<tr>
						<th>YEAR</th>
						<th>ADV</th>
						<th>DEM</th>
						<th>REP</th>
						<th>NPP</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>";

if ($is_city || $cnty_tot) {
    $arr = Array("NOW", "G18", "G16", "G14", "G12", "G10", "G08");
} else {
    $arr = Array("NOW", "G18", "G16", "G14", "G12");
}

foreach ($arr as $e) {
    $dem_key = $e . "_DEM";
    $rep_key = $e . "_REP";
    $npp_key = $e . "_NPP";
    $tot_key = $e . "_TOT";

    //echo("<br>GOT KEYs: $dem_key $rep_key $npp_key $tot_key");

    

    $dem = $y[$dem_key];
    $rep = $y[$rep_key];
    $npp = $y[$npp_key];
    $tot = $y[$tot_key];
    

    $dem_pct = makepct($dem, $tot);
    $rep_pct = makepct($rep, $tot);
    $npp_pct = makepct($npp, $tot);

    $adv = vote_adv($dem, $rep, $tot);

    $reg_table .= "<tr>
						<td>$e</td>
						<td>$adv</td>
						<td class='boldme blueme'>" . number_format($dem) . " ($dem_pct)</td>
						<td class='boldme redme'>" . number_format($rep) . " ($rep_pct)</td>
						<td class='boldme grayme'>" . number_format($npp) . " ($npp_pct)</td>
						<td class='boldme'>" . number_format($tot) . "</td>
					</tr>";

    if ($e == "NOW") {

        $reg_span = $adv;

        $voter_reg = "<p align='center'><span class='boldme'>TOTAL REGISTERED VOTERS: " . number_format($tot) . "</span><br>
						<span class='redme boldme'>R: $rep_pct</span> | <span class='blueme boldme'>D: $dem_pct</span> | <span class='grayme boldme'>NPP: $npp_pct</span></p>";
    }
}


$reg_table .= "</tbody>
			</table>";


if ($is_city || $cnty_tot) {

    $old_tables = "<div class='row' style='margin-top: 10px;'>";


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

    $g08_prs_table = "<div class='col-md-4'>
						<table class='bordered' cellspacing='0' align='center' id='districtWrapper' style='clear: both;'>
							<tbody style='font-size: 1.1em;'>
								<tr>
									<th colspan='3'>President '08</th>
								</tr>
								<tr>
									<td class='blueColumn'>Barack Obama (D-Inc)</td>
									<td class='greyColumn'>" . number_format($x['G08_PRSDEM']) . "</td>
									<td class='greyColumn'>" . number_format((($x['G08_PRSDEM'] / $g08_prs_tot) * 100), 2) . "%</td>
								</tr>
								<tr>
									<td class='blueColumn'>John McCain (R)</td>
									<td class='greyColumn'>" . number_format($x['G08_PRSREP']) . "</td>
									<td class='greyColumn'>" . number_format((($x['G08_PRSREP'] / $g08_prs_tot) * 100), 2) . "%</td>
								</tr>
							</tbody>
						</table>
					</div>";

    $g10_gov_table = "<div class='col-md-4'>
						<table class='bordered' cellspacing='0' align='center' id='districtWrapper' style='clear: both;'>
							<tbody style='font-size: 1.1em;'>
								<tr>
									<th colspan='3'>Governor '10</th>
								</tr>
								<tr>
									<td class='blueColumn'>Jerry Brown (D)</td>
									<td class='greyColumn'>" . number_format($x['G10_GOVDEM']) . "</td>
									<td class='greyColumn'>" . number_format((($x['G10_GOVDEM'] / $g10_gov_tot) * 100), 2) . "%</td>
								</tr>
								<tr>
									<td class='blueColumn'>Meg Whitman (R)</td>
									<td class='greyColumn'>" . number_format($x['G10_GOVREP']) . "</td>
									<td class='greyColumn'>" . number_format((($x['G10_GOVREP'] / $g10_gov_tot) * 100), 2) . "%</td>
								</tr>
							</tbody>
						</table>
					</div>";

    $g10_uss_table = "<div class='col-md-4'>
						<table class='bordered' cellspacing='0' align='center' id='districtWrapper' style='clear: both;'>
							<tbody style='font-size: 1.1em;'>
								<tr>
									<th colspan='3'>US Senate '10</th>
								</tr>
								<tr>
									<td class='blueColumn'>Barbara Boxer (D-Inc)</td>
									<td class='greyColumn'>" . number_format($x['G10_USSDEM']) . "</td>
									<td class='greyColumn'>" . number_format((($x['G10_USSDEM'] / $g10_uss_tot) * 100), 2) . "%</td>
								</tr>
								<tr>
									<td class='blueColumn'>Carly Fiorina (R)</td>
									<td class='greyColumn'>" . number_format($x['G10_USSREP']) . "</td>
									<td class='greyColumn'>" . number_format((($x['G10_USSREP'] / $g10_uss_tot) * 100), 2) . "%</td>
								</tr>
							</tbody>
						</table>
					</div>";

    $old_tables .= $g08_prs_table . $g10_gov_table . $g10_uss_table . "</div>";
}


$djt = $x['G16_PRSREP'];
$hrc = $x['G16_PRSDEM'];

$bho = $x['G12_PRSDEM'];
$wmr = $x['G12_PRSREP'];

$g12_prs_tot = $x['G12_PRSDEM'] + $x['G12_PRSREP'] + $x['G12_PRSLIB'] + $x['G12_PRSPAF'] + $x['G12_PRSAIP'] + $x['G12_PRSGRN'];
$g12_uss_tot = $x['G12_USSDEM'] + $x['G12_USSREP'];
$g14_gov_tot = $x['G14_GOVDEM'] + $x['G14_GOVREP'];
$g16_prs_tot = $x['G16_PRSDEM'] + $x['G16_PRSREP'] + $x['G16_PRSLIB'] + $x['G16_PRSPAF'] + $x['G16_PRSGRN'];
$g18_gov_tot = $x['G18_GOVDEM'] + $x['G18_GOVREP'];
$g18_uss_tot = $x['G18_USSDEM1'] + $x['G18_USSDEM2'];

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


$g12_prs_table = "<div class='col-md-3'>
					<table class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<tbody style='font-size: 12pt;'>
							<tr>
								<th colspan='3'>President '12</th>
							</tr>
								<td class='blueColumn'>Barack Obama (D-Inc)</td>
								<td class='greyColumn'>" . number_format($x['G12_PRSDEM']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G12_PRSDEM'] / $g12_prs_tot) * 100), 2) . "%</td>
							<tr>
							</tr>
								<td class='blueColumn'>Mitt Romney (R)</td>
								<td class='greyColumn'>" . number_format($x['G12_PRSREP']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G12_PRSREP'] / $g12_prs_tot) * 100), 2) . "%</td>
							<tr>					
						</tbody>
					</table>
				</div>";

$g16_prs_table = "<div class='col-md-3'>
					<table class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<tbody style='font-size: 12pt;'>
							<tr>
								<th colspan='3'>President '16</th>
							</tr>
								<td class='blueColumn'>Hillary Clinton (D)</td>
								<td class='greyColumn'>" . number_format($x['G16_PRSDEM']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G16_PRSDEM'] / $g16_prs_tot) * 100), 2) . "%</td>
							<tr>
							</tr>
								<td class='blueColumn'>Donald Trump (R)</td>
								<td class='greyColumn'>" . number_format($x['G16_PRSREP']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G16_PRSREP'] / $g16_prs_tot) * 100), 2) . "%</td>
							<tr>						
						</tbody>
					</table>
				</div>";

$g12_uss_table = "<div class='col-md-3'>
					<table class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<tbody style='font-size: 12pt;'>
							<tr>
								<th colspan='3'>US Senate '12</th>
							</tr>
								<td class='blueColumn'>Dianne Feinstein (D-Inc)</td>
								<td class='greyColumn'>" . number_format($x['G12_USSDEM']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G12_USSDEM'] / $g12_uss_tot) * 100), 2) . "%</td>
							<tr>
							</tr>
								<td class='blueColumn'>Elizabeth Emken (R)</td>
								<td class='greyColumn'>" . number_format($x['G12_USSREP']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G12_USSREP'] / $g12_uss_tot) * 100), 2) . "%</td>
							<tr>						
						</tbody>
					</table>
				</div>";

$g14_gov_table = "<div class='col-md-3'>
					<table class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<tbody style='font-size: 12pt;'>
							<tr>
								<th colspan='3'>Governor '14</th>
							</tr>
								<td class='blueColumn'>Jerry Brown (D-Inc)</td>
								<td class='greyColumn'>" . number_format($x['G14_GOVDEM']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G14_GOVDEM'] / $g14_gov_tot) * 100), 2) . "%</td>
							<tr>
							</tr>
								<td class='blueColumn'>Neel Kashkari (R)</td>
								<td class='greyColumn'>" . number_format($x['G14_GOVREP']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G14_GOVREP'] / $g14_gov_tot) * 100), 2) . "%</td>
							<tr>						
						</tbody>
					</table>
				</div>";

$g18_gov_table = "<div class='col-md-3'>
					<table class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<tbody style='font-size: 12pt;'>
							<tr>
								<th colspan='3'>Governor '18</th>
							</tr>
								<td class='blueColumn'>Gavin Newsom (D)</td>
								<td class='greyColumn'>" . number_format($x['G18_GOVDEM']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G18_GOVDEM'] / $g18_gov_tot) * 100), 2) . "%</td>
							<tr>
							</tr>
								<td class='blueColumn'>John Cox (R)</td>
								<td class='greyColumn'>" . number_format($x['G18_GOVREP']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G18_GOVREP'] / $g18_gov_tot) * 100), 2) . "%</td>
							<tr>						
						</tbody>
					</table>
				</div>";


$g18_uss_table = "<div class='col-md-3'>
					<table class='bordered' cellspacing='0' border='0' align='center' id='districtWrapper' style='clear: both; margin-top: 10px;'>
						<tbody style='font-size: 12pt;'>
							<tr>
								<th colspan='3'>US Senate '18</th>
							</tr>
								<td class='blueColumn'>Dianne Feinstein (D-Inc)</td>
								<td class='greyColumn'>" . number_format($x['G18_USSDEM2']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G18_USSDEM2'] / $g18_uss_tot) * 100), 2) . "%</td>
							<tr>
							</tr>
								<td class='blueColumn'>Kevin de Leon (D)</td>
								<td class='greyColumn'>" . number_format($x['G18_USSDEM1']) . "</td>
								<td class='greyColumn'>" . number_format((($x['G18_USSDEM1'] / $g18_uss_tot) * 100), 2) . "%</td>
							<tr>						
						</tbody>
					</table>
				</div>";


$new_table = "<div class='row'>" . $g12_prs_table . $g14_gov_table . $g16_prs_table . $g18_gov_table . "</div>
              <div class='row'>" . $g12_uss_table . $g18_uss_table . "</div>";


$props['G08'] = Array(
    "1A" => "$9.95B High Speed Rail Bond",
    "2" => "Regulate Animal Confinement",
    "3" => "$900M Childrens Hostpials Bond",
    "4" => "Abortion-Parental Notification",
    "5" => "Reudce Penalties for Nonviolent Crimes",
    "6" => "Boost Crime Prevention, Increase Penalties",
    "7" => "Promote Use of Alternative Fuels",
    "8" => "Eliminate Gay Marriage",
    "9" => "Victim Bill of Rights",
    "10" => "$5B Alternative Fuels Bond",
    "11" => "Independent Redistricting Commission",
    "12" => "$900M Veteran Assistance Bond"
);

$props['G10'] = Array(
    "19" => "Marijuana Legalization",
    "20" => "House Districts Drawn by Commission",
    "21" => "Hike Vehicle Fees to Fund Parks",
    "22" => "Prohibit State from Raiding Local Funds",
    "23" => "Suspend Pollution Law Until Economy Rebounds",
    "24" => "Eliminate Business Tax Breaks",
    "25" => "Simple Majority to Pass Budget",
    "26" => "2/3 Majority for Tax Increases",
    "27" => "Eliminate Redistricting Commission"
);

$props['G12'] = Array(
    "30" => "Jerry Brown's Temp Tax Increase",
    "31" => "Mandate 2-Year Budget Cycle",
    "32" => "Union/Corporate Campaign Restrictions",
    "33" => "Auto Insurance Persistency Discounts",
    "34" => "Eliminate Death Penalty",
    "35" => "Increase Human Trafficking Penalties",
    "36" => "Modify 3-Strikes Law",
    "37" => "Mandatory GMO Labeling",
    "38" => "Tax Increase for Education",
    "39" => "Tax Increase on Multi-State Businesses",
    "40" => "Redistricting Referendum"
);

$props['G14'] = Array(
    "1" => "$7.2B Water Bond",
    "2" => "Increase Rainy Day Fund",
    "45" => "Public Notice for Insurance Rates",
    "46" => "Increase Cap on Medical Damages",
    "47" => "Criminal Code Reform",
    "48" => "Ratify Gaming Compact"
);

$props['G16'] = Array(
    "51" => "School Facilities Construction Bond",
    "52" => "Medi-Cal Hospital Fee",
    "53" => "Voter Approval of Revenue Bonds",
    "54" => "Legislative Transparency",
    "55" => "Extend Propr 30 Tax Rates",
    "56" => "Tax on Tobacco Products",
    "57" => "Parole/Juvenile Justice Reform",
    "58" => "Multilingual Education",
    "59" => "Citizens United Advisory",
    "60" => "Mandate Condoms in Adult Films",
    "61" => "Prescription Drug Price Control",
    "62" => "Eliminate Death Penalty",
    "63" => "Firearms & Ammunition Restrictions",
    "64" => "Legalize Marijuana",
    "65" => "Divert Carryout Bag Fees From Retailers",
    "66" => "Strengthen Death Penalty",
    "67" => "Uphold Plastic Bag Ban"
);

$props['G18'] = Array(

    "1" => "Veterans Housing Bond",
    "2" => "Homeless Housing Bond",
    "3" => "Water Projects Bond",
    "4" => "Childrens Hospitals Bond",
    "5" => "Prop 13 Tax Portability",
    "6" => "Gas Tax Repeal",
    "7" => "Eliminate Daylight Savings Time",
    "8" => "Regulate Kidney Dialysis Clinics",
    "10" => "Rent Control (Repeal Costa-Hawkins)",
    "11" => "Private Sector Ambulance Rules",
    "12" => "Humane Animal Confinement"


	);

if ($is_city) {
    $arr = Array("G08", "G10", "G12", "G14", "G16", "G18");
} else {
    $arr = Array("G12", "G14", "G16", "G18");
}

foreach ($arr as $e) {
    foreach ($props[$e] as $key => $value) {
        $prop_name = $value;
        $yes_key = $e . "_P" . $key . "Y";
        $no_key = $e . "_P" . $key . "N";

        $yes = $x[$yes_key];
        $no = $x[$no_key];
        $tot = $yes + $no;

        if ($yes > $no) {
            $yes_class = 'boldme greenme';
            $no_class = '';
        } elseif ($no > $yes) {
            $no_class = 'boldme redme';
            $yes_class = '';
        } else {
            $yes_class = 'boldme';
            $no_class = 'boldme';
        }

        $prop_table .= "<div style='margin-top: 10px; float: left;'><!--PROP TABLE START-->
							<table style='min-width: 250px' align='center'>
								<tbody>
									<tr>
										<th colspan='3'>P" . $key . " - $prop_name</th>
									</tr>
									<tr class='$yes_class'>
										<td class='blueColumn'>YES</td>
										<td class='greyColumn'>" . number_format($yes) . "</td>
										<td class='greyColumn'>" . number_format((($yes / $tot) * 100), 2) . "%</td>
									</tr>
									<tr class='$no_class'>
										<td class='blueColumn'>NO</td>
										<td class='greyColumn'>" . number_format($no) . "</td>
										<td class='greyColumn'>" . number_format((($no / $tot) * 100), 2) . "%</td>
									</tr>								
								</tbody>
							</table>
						</div><!--PROP TABLE END-->";
    }
}


$page_header = "<div class='col-lg-12 text-center'><!--BEGIN COUNTY SUBDIVISION CONTAINER-->
						<h2>$county County - $sub</h2>";
echo($page_header);
echo($voter_reg . "<p align='center'>$reg_span</p>");
echo($reg_table);
echo($pres_span);


//echo("<br>RETRIEVED RESULTS:<br>");

echo("<div class='text-center'><!--BEGIN TABLES CONTAINER-->");
echo("<div class='row'><!--BEGIN TABLE ROW PRECEDING NEW, OLD, AND PROP TABLES-->");

echo($new_table);
echo($old_tables);
echo($prop_table);
echo("</div><!--END TABLE ROW-->");

/*

echo("<div class='row'><!--BEGIN LOCAL ROW-->");




$has_local = has_local($sub);

if($sub == "County Totals") {
	$is_county = TRUE;
}

if($is_city && $has_local) {
	echo("<div align='center' class='col-lg-12' width='100%' style='clear: both; margin-top: 30px;'><!--BEGIN CITY DIV-->");


	$city_detail_div = "
	<p width='100%' style='clear: both;'><input class=\"button campaign\" name=\"answer\" value=\"Past Local Election Results\" onclick=\"showCityDiv(1)\" title=\"Past Local Election Results\" width=\"300px\" type=\"button\" /> <input class=\"close\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<div id=\"cityDiv\" style=\"display:none;\" class=\"answer_list\"><iframe src=\"/img/spinner.gif\" id=\"cityHidden\" height=\"1000px\" width=\"1024px\"></iframe></div>
	<p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"close btmclose\" style=\"display: none;\" id=\"btmClose\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>";

	echo($city_detail_div . "</div><!--END CITY DIV-->");	

} elseif ($is_county) {

	echo("<div align='center' width='100%'><!--BEGIN COUNTY DIV-->");
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
	array_push($endjava, $local_js);

	$city_detail_div = "
	<p><input class=\"button campaign\" name=\"answer\" value=\"Past Local Election Results\" onclick=\"showCityDiv(1)\" title=\"Past Local Election Results\" width=\"300px\" type=\"button\" /> <input class=\"close\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<div id=\"cityDiv\" style=\"display:none;\" class=\"answer_list\"><iframe src=\"/img/spinner.gif\" id=\"cityHidden\" height=\"1000px\" width=\"1024px\"></iframe></div>
	<p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"close btmclose\" style=\"display: none;\" id=\"btmClose\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>";

	echo($city_detail_div . "</div><!--END COUNTY DIV-->");	

}


if($is_city) {
	echo("<div width='100%' align='center'><!--BEGIN CITY DEMOGRAPHICS DIV-->
			<iframe style='margin-right: auto; margin-left: auto;' align='center' src='get_city_demographics.php?id=$sub' width='1024px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>");

	$census_js = "
	<script type='text/javascript'>
	function showCensusDiv(z) {

		var url = '/ctb-legacy/get_city_census.php?id=$sub';

		if(z == 1) {
			document.getElementById('censusDiv').style.display = 'block';
			document.getElementById('btmClose').style.display = 'block';
			document.getElementById('censusHidden').src = url;
		} else {
			document.getElementById('censusDiv').style.display = 'none';
			document.getElementById('btmClose').style.display = 'none';
			document.getElementById('censusHidden').src = '/img/spinner.gif';
		}
	   
	}
	</script>";

	echo($census_js);

	$census_detail_div = "
	<p><input class=\"button campaign\" name=\"answer\" value=\"Full Census Detail\" onclick=\"showCensusDiv(1)\" title=\"Census Data\" width=\"300px\" type=\"button\" /> <input class=\"close\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\" /></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<p></p>
	<div id=\"censusDiv\" style=\"display:none;\" class=\"answer_list\"><iframe src=\"/img/spinner.gif\" id=\"censusHidden\" height=\"1000px\" width=\"1024px\"></iframe></div>
	<p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"close btmclose\" style=\"display: none;\" id=\"btmClose\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\" /></p>";

	echo($census_detail_div . "</div><!--END CITY DEMOGRAPHICS DIV-->");	

	//include("/ctb-legacy/get_city_demographics.php?id=$sub");
}




if($is_city && !$is_county) {

	$info = get_city_info($sub);
	//var_dump($info);
	if($info) {
		$link = "<a href='" . $info['weblink'] . "' target='_blank'>" . $sub . "</a>";

		$city_info_div = "<div width='100%' align='center'><!--BEGIN CITY INFO DIV--><p align='center'>$link<br>Incorporated " . $info['dateincorp'] . "<br>" . number_format($info['land_sqmi'], 2) . " Square Miles</p></div><!--END CITY INFO DIV-->";
		echo($city_info_div);
	}

	echo("<div width='100%' align='center' style='margin-top: 20px'><!--BEGIN CITY MAP DIV--><p align='center'>LOCATION</p><iframe src='/ctb-legacy/draw_ca_city.php?id=$sub' height='610px' width='810px' style='margin-left: auto; margin-right: auto; overflow: hidden;'></iframe></div><!--END CITY MAP DIV-->");
}

//var_dump($x);

echo("</div><!--END LOCAL ROW-->");

*/
echo("</div><!--END TABLES CONTAINER-->");
echo("</div><!--END COUNTY SUB CONTAINER-->");






<?php

//POST-2020 REDISTRICTING VERSION

global $fourcode, $role, $endjava;
$fourcode = $id;
$endjava = Array();

Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;

?>



@php ($book_side_nav_active = 'district')

@extends('layouts.book')

@section('title', 'NEW '.$id.' | California Target Book')

@section('content')

    <div>
        @include('components.dist_head_20')

        <div class="container-fluid pt-xl">

            <?php
                global $cached;
                $cached = populate_cached($id);
                $cached['fourcode'] = $id;
                $fourcode = $id;
		$type = mb_substr($fourcode, 0, 2);

		$old_fourcodes = get_fourcode_index();
		$dists = Array($fourcode);
		$cvap = get_cvap($type, $dists);
		$pres = get_pres($type);
		$reg  = get_reg();



            ?>

            <div class="row">
                <div class="col-lg-10 center-block fn">
                    <nav class='clearfix page-nav'>
                        <ul class="clearfix">
                            <li class='active'>
                                <a href='#Overview' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">person</i>
                                    Overview
                                </a>
                            </li>

                            <li>
                                <a href='#Cities' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">location_city</i>
                                    Cities
                                </a>
                            </li>

                            <li>
                                <a href='#OldRes' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">ballot</i>
                                    Old Results
                                </a>
                            </li>

                            <li>
                                <a href='#Diff' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">sync_alt</i>
                                    Difference Report
                                </a>
                            </li>


                            <li>
                                <a href='#Incumbent' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">person</i>
                                    Incumbent
                                </a>
                            </li>
                            <li>
                                <a href='#Campaigns' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">poll</i>
                                    Campaigns
                                </a>
                            </li>

                            <li>
                                <a href='#PastHS' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">whatshot</i>
                                    Past Hot Sheets
                                </a>
                            </li>

                        </ul>
                    </nav>

                    <div class="content-wrap pt-xl">
			<section id="Overview"  class="active">
				<?php
				      $type = mb_substr($fourcode, 0, 2);
				      $dist = (int)mb_substr($fourcode, 2,2);
				      if(mb_substr($fourcode, 0, 3) == "BOE") {
						$type = "BD";
						$dist = mb_substr($fourcode, 3, 1);
				      }
				      $old_fourcode = $old_fourcodes['new'][$fourcode];
				      $dist_dscr = get_district_info($fourcode);
				      $cand_tables = locate_candidates($fourcode);
				      $zip_div = get_redist_zips($fourcode);



				      $url = "/ctb-legacy/draw_viz.php?city=VIZ8_" . $type . "&cd=" . $dist;
				      $iframe_html = "<iframe src='$url' width='800' height='600' align='center' scrolling='no'></iframe>";
				      $cvap_add = "<div align='center'><p align='center'>" . $cvap[$fourcode] . "</p></div>";

				      $prev_span = "<h5 align='center' style=\"font-family: 'Lato';\" >Previous district ($old_fourcode) had a " . $reg[$old_fourcode]['ADV'] . " registration advantage and voted " . $pres[$old_fourcode]['ADV'] . " in the 2020 election.</h5>";
				      $prev_span .= "<h6 align='center'>DEM: " . number_format((($reg[$old_fourcode]['DEM'] / $reg[$old_fourcode]['TOT']) * 100), 2) . ",
							       REP: " . number_format((($reg[$old_fourcode]['REP'] / $reg[$old_fourcode]['TOT']) * 100), 2) . "  |
							       Biden: " . number_format((($pres[$old_fourcode]['PRSDEM01'] / $pres[$old_fourcode]['TOT']) * 100), 2) . ",
							       Trump: " . number_format((($pres[$old_fourcode]['PRSREP01'] / $pres[$old_fourcode]['TOT']) * 100), 2) . "</h6>";

				      if(!isset($cached['AD_NEW'])) {
						//DRAW THE OVERLAPPING CONGRESSIONAL AND SENATE DISTRICTS

						$overlap_div = "<div class='row'>
									<h2 align='center'>District Overlaps</h2>
									<div class='col-lg-6'>
										<h3 align='center'>Congressional</h3>
										<div class='row'>
											<div class='col-lg-6'>" .
												$cached['CD_NEW'] .
											"</div>
											<div class='col-lg-6'>" .
												$cached['CD'] .
											"</div>
										</div>
									</div>

									<div class='col-lg-6'>
										<h3 align='center'>State Senate</h3>
										<div class='row'>
											<div class='col-lg-6'>" .
												$cached['SD_NEW'] .
											"</div>
											<div class='col-lg-6'>" .
												$cached['SD'] .
											"</div>
										</div>
									</div>
								</div>";

		                      } elseif(!isset($cached['SD_NEW'])) {
						//DRAW THE OVERLAPPING CONGRESSIONAL AND ASSEMBLY DISTRICTS

						$overlap_div = "<div class='row'>
									<h2 align='center'>District Overlaps</h2>
									<div class='col-lg-6'>
										<h3 align='center'>Congressional</h3>
										<div class='row'>
											<div class='col-lg-6'>" .
												$cached['CD_NEW'] .
											"</div>
											<div class='col-lg-6'>" .
												$cached['CD'] .
											"</div>
										</div>
									</div>

									<div class='col-lg-6'>
										<h3 align='center'>Assembly</h3>
										<div class='row'>
											<div class='col-lg-6'>" .
												$cached['AD_NEW'] .
											"</div>
											<div class='col-lg-6'>" .
												$cached['AD'] .
											"</div>
										</div>
									</div>
								</div>";


				      } elseif(!isset($cached['CD_NEW'])) {
						//DRAW THE OVERLAPPING ASSEMBLY AND SENATE DISTRICTS
						$overlap_div = "<div class='row'>
									<h2 align='center'>District Overlaps</h2>
									<div class='col-lg-6'>
										<h3 align='center'>State Senate</h3>
										<div class='row'>
											<div class='col-lg-6'>" .
												$cached['SD_NEW'] .
											"</div>
											<div class='col-lg-6'>" .
												$cached['SD'] .
											"</div>
										</div>
									</div>

									<div class='col-lg-6'>
										<h3 align='center'>Assembly</h3>
										<div class='row'>
											<div class='col-lg-6'>" .
												$cached['AD_NEW'] .
											"</div>
											<div class='col-lg-6'>" .
												$cached['AD'] .
											"</div>
										</div>
									</div>
								</div>";

				      }

				      $draw =
					      "<div class='row'>
						 $prev_span
						 <div class='col-sm-3' align='center'>
							<br><h3>Registration (Nov '2020)</h3>" . $cached['LAST_REG'] .



						 "</div>


						 <div class='col-lg-6' style='max-width: 830px;'>
                        				<h3>Map</h3>
				                        <div class='iframe-container'>
								$iframe_html
				                        </div>
			                      </div>

						  <div class='col-sm-3' align='center'>
							<h3>Old District Composition</h3>" . $cached['OLD_DIST'] .
							"<span class='small-table'>
							 <div class='row'>
							 	<div class='col-lg-6'>
								 	<h3>Officeholders In District</h3>" . $cand_tables['inc'] .
							"	</div>
								 <div class='col-lg-6'>
									<h3>Candidates In District</h3>" . $cand_tables['non_inc'] .
						 "		</div>
						   </div>
						</span>
						</div>
						</div>
						<div class='col-sm-12' style='zoom: 0.8;'>" .

						$cached['TOPLINE'] .

						"</div>
						<div class='row'>
						  <div class='col-sm-4' align='center'>
							<h3>Ethnic CVAP</h3>" . $cvap_add .
						  "</div>
						  <div class='col-sm-3' align='center'>
							<h3>Counties in District</h3>" . $cached['CO'] .
							"<div class='panel'>
									<h3>District Information</h3>

									<p align='justify'>$dist_dscr</p>
							</div>

						   </div>
						   <div class='col-sm-5' align='center'>
							<br><h3>Past Registration Trend</h3>" . $cached['PAST_REG'] .
						   "</div>

					 	</div>
						$overlap_div
						$zip_div


						";

				      echo($draw);

				?>
			</section>

			<section id='Cities'>
				<?php echo($cached['CITIES']); ?>
			</section>

			<section id='OldRes'>
				<?php echo($cached['PAST_RESULTS']); ?>
			</section>

			<section id='Diff' class='table-striped' style='line-height: 1em;'>
				<?php echo($cached['DIFF']); ?>
			</section>

                        <section id="Incumbent">
                            <?php include(Util::$view_root.'incumbent_page_20Backup.php') ?>
                        </section>


                        <section id="Campaigns">

                        <?php include(Util::$view_root.'cal_campaigns_20Backup.php') ?>

                        </section>



		    <section id='PastHS'>
			<div class='panel'>
			<?php
				$x = get_hs_items($fourcode);
				echo($x);
			?>
			</div>
		    </section>

                    </div>
                </div>
            </div>


        </div>


    </div>

<?php

function populate_cached($fourcode) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb_redist_cached_1220 WHERE fourcode = '$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
	    $type = $row['type'];
            $retval[$type] = $row['html'];
        }
    }
    return $retval;
}

function get_cal_incumbent_bio($fourcode) {
    global $site_conn;
    $conn = $site_conn;
    $incumbent_id = get_cal_incumbent($fourcode);
    //echo("<br>RETRIEVED INCUMBENT ID: $incumbent_id FOR $fourcode<br>");
    $bio = get_cal_bio($incumbent_id);

    //echo("<br>RETRIEVED<br>$bio<br>");
    return $bio;
}

function get_cal_bio($cand_id) {
    global $site_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT text FROM ctb_cand_bios WHERE cand_id = '$cand_id' ORDER BY date DESC, id DESC LIMIT 1";
    //echo("<Br>$sql");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}

function get_cal_incumbent($fourcode) {
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT CAND_ID FROM ctb2016_e22_incumbent WHERE DIST = '$fourcode'";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['CAND_ID'];
        }
    }

    return $retval;
}


function get_fec_analysis($year) {
    global $site_conn;
    $conn = Util::get_ctb_conn();
    global $fourcode;
    $sql = "SELECT text from ctb_analysis WHERE dist = '$fourcode' && year = '$year' ORDER BY date DESC, id DESC LIMIT 1";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}

function is_targeted() {
    global $fourcode;
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT targeted_by FROM nufec_e20_targets WHERE fourcode = '$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $x = $row['targeted_by'];
        }
    }
    if ($x == "DCCC") {
        $retval = "<span class='boldme blueme'>2020 DCCC Target</span>";
    }

    if ($x == "NRCC") {
        $retval = "<span class='boldme redme'>2020 NRCC Target</span>";
    }

    return $retval;
}

function get_hs_items($fourcode) {
	$conn = Util::get_ctb_conn();
	$months = Array(
		"01" => "January",
		"02" => "February",
		"03" => "March",
		"04" => "April",
		"05" => "May",
		"06" => "June",
		"07" => "July",
		"08" => "August",
		"09" => "September",
		"10" => "October",
		"11" => "November",
		"12" => "December"
	);

	$days = Array(
		"01" => "1st",
		"02" => "2nd",
		"03" => "3rd",
		"04" => "4th",
		"05" => "5th",
		"06" => "6th",
		"07" => "7th",
		"08" => "8th",
		"09" => "9th",
		"10" => "10th",

		"11" => "11th",
		"12" => "12th",
		"13" => "13th",
		"14" => "14th",
		"15" => "15th",
		"16" => "16th",
		"17" => "17th",
		"18" => "18th",
		"19" => "19th",
		"20" => "20th",

		"21" => "21st",
		"22" => "22nd",
		"23" => "23rd",
		"24" => "24th",
		"25" => "25th",
		"26" => "26th",
		"27" => "27th",
		"28" => "28th",
		"29" => "29th",
		"30" => "30th",
		"31" => "31st",
		);


	$sql = "SELECT post_id, updated FROM `ctb_hot_sheet` WHERE text LIKE '%$fourcode%' && UPDATED > '2021-12-01' GROUP BY post_id ORDER BY updated DESC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		$retval = "<ul>";
		while($row = $result->fetch_assoc()) {
			$date = $row['post_id'];
			if(substr_count($date, '-') < 2) {
				$year = mb_substr($date, 0, 4);
				$month = mb_substr($date, 4, 2);
				$day = mb_substr($date, 6, 2);

			} else {
				$year = mb_substr($date, 0, 4);
				$month = mb_substr($date, 5, 2);
				$day = mb_substr($date, 8, 2);
			}
			$verbose_date = $months[$month] . " " . $days[$day] . ", " . $year;
			$retval .= "<li><a href='https://californiatargetbook.com/book/hotsheet/$date' target='_blank'>$verbose_date</a></li>";

		}
		$retval .= "</ul>";
	}

	return $retval;
}


function getstats() {
    global $incumbent;
    global $hrc;
    global $djt;
    global $bho;
    global $wmr;
    global $party;
    global $fourcode;
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM ctb2016_e22_fed WHERE DIST = '$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $incumbent = $row['NAMF'] . " " . $row['NAML'];
            $party = $row['PARTY'];
            $hrc = $row['CLINTON'];
            $djt = $row['TRUMP'];
            $bho = $row['OBAMA'];
            $wmr = $row['ROMNEY'];
        }
    }
}

function get_long_string($fourcode) {
    $state = mb_substr($fourcode, 0, 2);
    $dist = mb_substr($fourcode, 2, 2);

    $long_state = convert_state($state);
    $long_dist = convert_district($dist);

    return $long_state . "<br>" . $long_dist . " Congressional District";
}

function convert_district($dist) {
    $longform = Array(
        "00" => "At Large",
        "01" => "First",
        "02" => "Second",
        "03" => "Third",
        "04" => "Fourth",
        "05" => "Fifth",
        "06" => "Sixth",
        "07" => "Seventh",
        "08" => "Eighth",
        "09" => "Ninth",
        "10" => "Tenth",
        "11" => "Eleventh",
        "12" => "Twelfth",
        "13" => "Thirteenth",
        "14" => "Fourteenth",
        "15" => "Fifteenth",
        "16" => "Sixteenth",
        "17" => "Seventeenth",
        "18" => "Eighteenth",
        "19" => "Nineteenth",
        "20" => "Twentieth",
        "21" => "Twenty-First",
        "22" => "Twenty-Second",
        "23" => "Twenty-Third",
        "24" => "Twenty-Fourth",
        "25" => "Twenty-Fifth",
        "26" => "Twenty-Sixth",
        "27" => "Twenty-Seventh",
        "28" => "Twenty-Eighth",
        "29" => "Twenty-Ninth",
        "30" => "Thirtieth",
        "31" => "Thirty-First",
        "32" => "Thirty-Second",
        "33" => "Thirty-Third",
        "34" => "Thirty-Fourth",
        "35" => "Thirty-Fifth",
        "36" => "Thirty-Sixth",
        "37" => "Thirty-Seventh",
        "38" => "Thirty-Eighth",
        "39" => "Thirty-Ninth",
        "40" => "Fortieth",
        "41" => "Forty-First",
        "42" => "Forty-Second",
        "43" => "Forty-Third",
        "44" => "Forty-Fourth",
        "45" => "Forty-Fifth",
        "46" => "Forty-Sixth",
        "47" => "Forty-Seventh",
        "48" => "Forty-Eighth",
        "49" => "Forty-Ninth",
        "50" => "Fiftieth",
        "51" => "Fifty-First",
        "52" => "Fifty-Second",
        "53" => "Fifty-Third",

    );

    return $longform[$dist];
}

function convert_state($name, $to = 'abbrev') {
    $states = array(
        array('name' => 'Alabama', 'abbrev' => 'AL'),
        array('name' => 'Alaska', 'abbrev' => 'AK'),
        array('name' => 'Arizona', 'abbrev' => 'AZ'),
        array('name' => 'Arkansas', 'abbrev' => 'AR'),
        array('name' => 'California', 'abbrev' => 'CA'),
        array('name' => 'Colorado', 'abbrev' => 'CO'),
        array('name' => 'Connecticut', 'abbrev' => 'CT'),
        array('name' => 'Delaware', 'abbrev' => 'DE'),
        array('name' => 'Florida', 'abbrev' => 'FL'),
        array('name' => 'Georgia', 'abbrev' => 'GA'),
        array('name' => 'Hawaii', 'abbrev' => 'HI'),
        array('name' => 'Idaho', 'abbrev' => 'ID'),
        array('name' => 'Illinois', 'abbrev' => 'IL'),
        array('name' => 'Indiana', 'abbrev' => 'IN'),
        array('name' => 'Iowa', 'abbrev' => 'IA'),
        array('name' => 'Kansas', 'abbrev' => 'KS'),
        array('name' => 'Kentucky', 'abbrev' => 'KY'),
        array('name' => 'Louisiana', 'abbrev' => 'LA'),
        array('name' => 'Maine', 'abbrev' => 'ME'),
        array('name' => 'Maryland', 'abbrev' => 'MD'),
        array('name' => 'Massachusetts', 'abbrev' => 'MA'),
        array('name' => 'Michigan', 'abbrev' => 'MI'),
        array('name' => 'Minnesota', 'abbrev' => 'MN'),
        array('name' => 'Mississippi', 'abbrev' => 'MS'),
        array('name' => 'Missouri', 'abbrev' => 'MO'),
        array('name' => 'Montana', 'abbrev' => 'MT'),
        array('name' => 'Nebraska', 'abbrev' => 'NE'),
        array('name' => 'Nevada', 'abbrev' => 'NV'),
        array('name' => 'New Hampshire', 'abbrev' => 'NH'),
        array('name' => 'New Jersey', 'abbrev' => 'NJ'),
        array('name' => 'New Mexico', 'abbrev' => 'NM'),
        array('name' => 'New York', 'abbrev' => 'NY'),
        array('name' => 'North Carolina', 'abbrev' => 'NC'),
        array('name' => 'North Dakota', 'abbrev' => 'ND'),
        array('name' => 'Ohio', 'abbrev' => 'OH'),
        array('name' => 'Oklahoma', 'abbrev' => 'OK'),
        array('name' => 'Oregon', 'abbrev' => 'OR'),
        array('name' => 'Pennsylvania', 'abbrev' => 'PA'),
        array('name' => 'Rhode Island', 'abbrev' => 'RI'),
        array('name' => 'South Carolina', 'abbrev' => 'SC'),
        array('name' => 'South Dakota', 'abbrev' => 'SD'),
        array('name' => 'Tennessee', 'abbrev' => 'TN'),
        array('name' => 'Texas', 'abbrev' => 'TX'),
        array('name' => 'Utah', 'abbrev' => 'UT'),
        array('name' => 'Vermont', 'abbrev' => 'VT'),
        array('name' => 'Virginia', 'abbrev' => 'VA'),
        array('name' => 'Washington', 'abbrev' => 'WA'),
        array('name' => 'West Virginia', 'abbrev' => 'WV'),
        array('name' => 'Wisconsin', 'abbrev' => 'WI'),
        array('name' => 'Wyoming', 'abbrev' => 'WY'),
        array('name' => 'Alberta', 'abbrev' => 'AB'),
        array('name' => 'British Columbia', 'abbrev' => 'BC'),
        array('name' => 'Manitoba', 'abbrev' => 'MB'),
        array('name' => 'New Brunswick', 'abbrev' => 'NB'),
        array('name' => 'Newfoundland', 'abbrev' => 'NL'),
        array('name' => 'Northwest Territories', 'abbrev' => 'NT'),
        array('name' => 'Nova Scotia', 'abbrev' => 'NS'),
        array('name' => 'Nunavut', 'abbrev' => 'NU'),
        array('name' => 'Ontario', 'abbrev' => 'ON'),
        array('name' => 'Prince Edward Island', 'abbrev' => 'PE'),
        array('name' => 'Quebec', 'abbrev' => 'QC'),
        array('name' => 'Saskatchewan', 'abbrev' => 'SK'),
        array('name' => 'Yukon Territory', 'abbrev' => 'YT')
    );

    $return = false;
    foreach ($states as $state) {
        foreach ($state as $title => $value) {
            if (strtolower($value) == strtolower(trim($name))) {
                if ($to == 'name') {
                    $return = $state['abbrev'];
                } else {
                    $return = $state['name'];
                }
                break;
            }
        }
    }

    return $return;
}


//echo("<p style='font-family: \"Montserrat\"; font-size: 16pt; text-align: justify;'>$bio_txt</p>");

function retrieve_image($fourcode) {
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT BIOGUIDE, NAML, NAMF, PARTY FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bioguide = $row['BIOGUIDE'];
            $name = $row['NAMF'] . " " . $row['NAML'];
            $party = $row['PARTY'];
        }
    }
    $img_url = "/img/congress/" . $bioguide . ".jpg";
    $bio_txt = retrieve_bio($bioguide);

    $retval['IMG'] = $img_url;
    $retval['BIO'] = $bio_txt;
    $retval['NAME'] = $name;
    $retval['PARTY'] = $party;

    return $retval;
}

function get_dist_location($fourcode) {
    global $site_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT text from ctb_dist_loc WHERE dist = '$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}

function get_dist_profile($fourcode) {
    global $site_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT text from ctb_dist_profile WHERE dist='$fourcode'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}

function retrieve_bio($id) {
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT bio FROM nufec_bios WHERE bioguide = '$id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['bio'];
        }
    }

    return $retval;
}

function getanalysis($fourcode, $year) {
    global $fec_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT text FROM nufec_analysis WHERE fourcode = '$fourcode' && year = $year";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row['text'];
        }
    }

    return $retval;
}


function populate_elections() {
	$elections = Array(
		"p12"	=> "June 5, 2012 Presidential Primary",
		"g12"	=> "November 6, 2012 General Election",
		"p14"	=> "June 3, 2014 Primary Election",
		"g14"	=> "November 4, 2014 General Election",
		"p16"	=> "June 7, 2016 Presidential Primary",
		"g16"	=> "November 8, 2016 General Election",
		"p18"	=> "June 5, 2018 Primary Election",
		"g18"	=> "November 6, 2018 General Election",
		"p20"	=> "March 3, 2020 Presidential Primary",
		"g20"	=> "November 3, 2020 General Election"
		);

	foreach($elections as $e => $verbose) {
		$enddraw .= "<option value='&election=$e'>$verbose</option>";
	}
	echo $enddraw;

}

function populate_datasets() {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT dataset FROM census_codes GROUP BY dataset ORDER BY dataset";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dataset = $row['dataset'];
            $verbose = $dataset;
            if(mb_substr($dataset, 0, 3) == "INC") {
                if($income_set) {
                    continue;
                }
                $dataset = "INCOME AND BENEFITS";
                $verbose = "INCOME AND BENEFITS";
                $income_set = TRUE;
            } elseif($dataset == "Total housing units" || $dataset == "Race alone or in combination with one or more other races") {
                continue;
            } elseif(mb_substr($dataset, 0, 8) == "CITIZEN,") {
                continue;
            } elseif(mb_substr($dataset, 0, 8) == "CITIZEN ") {
                $dataset = "CITIZEN";
                $verbose = "CITIZEN VOTING AGE POPULATION";
            }
            $enddraw .= "<option value='&dataset=$dataset'>$verbose</option>";

        }
    }
    echo($enddraw);

}

function get_cvap($type, $dists) {
	$conn = Util::get_ctb_conn();
	$is_vra = get_vra();
	$jur_name = "VIZ8_" . $type;
	$old_fourcodes = get_fourcode_index();
	$sql = "SELECT district, name FROM ctb_ca_city_shp WHERE jur_name = '$jur_name'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$map_nm = $row['district'];
			//$short_map = mb_substr($row['name'], 0, 12);
			$fourcode = $type . checkaddzero($row['district']);
			$map_nm_index[$map_nm] = $fourcode;
			$fourcode_map_index[$fourcode] = $map_nm;
		}
	}

	$sql = "SELECT * FROM ctb_redist_cvap_2011 WHERE fourcode LIKE '$type%'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$cvap_11[$fourcode] = $row;
		}
	}

	switch($type) {
		case "CD":
			$c19_q = "Congressional District";
			break;
		case "AD":
			$c19_q = "Assembly District";
			break;
		case "SD":
			$c19_q = "State Senate District";
			break;
	}

	$sql = "SELECT fourcode, district, name, population, cvap_19, hisp, ind, black, asian, white, target, deviation FROM ctb_redist_cvap_1220";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$cvap_data[$fourcode] = $row;
		}
	}
	$c19_fields = Array(
		"1"	=> "total",
		"4"	=> "asian",
		"5"	=> "black",
		"7"	=> "white",
		"8"	=> "ind",
		"13"	=> "hisp"
	);

	$sql = "SELECT geoname, lnnumber, cvap_est
		FROM ctb_redist_cvap_2019
		WHERE geoname LIKE '$c19_q%' && (lnnumber = 1 || lnnumber = 4 || lnnumber = 5 || lnnumber = 7 || lnnumber = 8 || lnnumber = 13)";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$regex = '~' . $c19_q . '\s([0-9].*?)\s~mis';
			preg_match($regex, $row['geoname'], $r);
			$dist = $r[1];
			$fourcode = $type . checkaddzero($dist);
			$key = $c19_fields[$row['lnnumber']];
			$cvap_19[$fourcode][$key] = (int)$row['cvap_est'];
		}
	}

	$eth_keys = Array(
			"White"	=> "white",
			"Asian" => "asian",
			"Latino" => "hisp",
			"Black"	=> "black",
		);

	foreach($dists as $fourcode) {
		$old_fourcode = $old_fourcodes['new'][$fourcode];
		$x = $cvap_data[$fourcode];
		$y = $cvap_11[$old_fourcode];
		$z = $cvap_19[$old_fourcode];

		//$map_nm = $d['name'];
		$cvap = $x['cvap_19'];


		$tmp_11['Asian'] = number_format(($y['asian'] * 100), 1);
		$tmp_11['Latino'] = number_format(($y['hisp'] * 100), 1);
		$tmp_11['Black'] = number_format(($y['black'] * 100), 1);
		$tmp_11['White'] = number_format(($y['white'] * 100), 1);


		$tmp_19['White'] = number_format((($z['white'] / $z['total']) * 100), 1);
		$tmp_19['Asian'] = number_format((($z['asian'] / $z['total']) * 100), 1);
		$tmp_19['Black'] = number_format((($z['black'] / $z['total']) * 100), 1);
		$tmp_19['Latino'] = number_format((($z['hisp'] / $z['total']) * 100), 1);
		//$tmp_19['Indigenous'] = number_format((($z['ind'] / $z['total']) * 100), 1);





		$tmp['White'] 		= number_format((($x['white'] / $cvap) * 100), 1);
		$tmp['Asian'] 		= number_format((($x['asian'] / $cvap) * 100), 1);
		$tmp['Latino'] 		= number_format((($x['hisp'] / $cvap) * 100), 1);
		$tmp['Black'] 		= number_format((($x['black'] / $cvap) * 100), 1);
		$tmp['Indigenous'] 	= number_format((($x['ind'] / $cvap) * 100), 1);

		arsort($tmp);

		$i = 0;
		$first_grp = '';
		$eth_body = '';
		$dscr = '';
		if(isset($is_vra[$fourcode])) {
			$dscr = "<span class='boldme'>VRA District</span><br>";
		}

		foreach($tmp as $group => $pct) {
			if($i < 1) {
				$first_grp = $group;
				if($group != "White") {
					//GOT MINORITY DISTRICT
					if($pct >= 50) {
						//MAJORITY-MINORITY DISTRICT
						$dscr .= "Majority $group";
					} else {
						$dscr .= "Plurality $group";
					}
				}
			} else {
				if($group == "Black" && $pct >= 20) {
					$dscr .= "<br>Substantial Black Population";
				}
			}
			$this_key = $eth_keys[$group] ?? '';
			$this_raw = $x[$this_key] ?? '';
			$this_11 = $tmp_11[$group] ?? '';
			$this_19 = $tmp_19[$group] ?? '';

			$eth_body .= "<tr>
								<td class='boldme'>$group</td>
								<td align='right' class='boldme'>" . number_format((int)$this_raw) ?? '' . "</td>
								<td align='right' class='boldme'>" . $pct . "%</td>
								<td align='right' class='itcme'>" . $this_11 . "%</td>
								<td align='right' class='itcme'>" . $this_19 . "%</td>
						  </tr>";


			$i++;
		}

		$cvap_table[$fourcode] = "
				<table class='table'>
				     <thead>
					<tr>
						<th>DISTRICT</th>
						<th>MAP NAME</th>
						<th>POPULATION</th>
						<th>TARGET SIZE</th>
						<th>DEVIATION</th>
						<th>%</th>
					</tr>
				     </thead>

				     <tbody>
					<tr>
						<td>$fourcode</td>
						<td>" . $x['name'] . "</td>
						<td align='right'>" . number_format($x['population']) . "</td>
						<td align='right'>" . number_format($x['target']) . "</td>
						<td align='right'>" . number_format($x['deviation']) . "</td>
						<td align='right'>" . number_format((($x['deviation'] / $x['target']) * 100), 2) . "</td>
					</tr>
				</tbody>
			</table>

				<p align='center'>ETHNIC DATA<br>
				CVAP Population: " . number_format($cvap) . " (" . number_format((($cvap / $x['population']) * 100), 1) . "%)<br>$dscr<br>
				<table class='table table-striped table-responsive'>
					<thead>
						<tr>
							<th>GROUP</th>
							<th class='rightme'>CVAP NEW</th>
							<th class='rightme'>% NEW</th>
							<th class='rightme'>$old_fourcode '11</th>
							<th class='rightme'>$old_fourcode '19</th>
						</tr>
					</thead>
					<tbody>
						$eth_body
					</tbody>
				</table><h6 align='center' class='itcme'>The \"% '11\" column indicates the CVAP of the previous $old_fourcode at the time the lines were drawn in 2011, and the \"% '19\" column indicates the CVAP of the previous $old_fourcode as of the most recent American Community Survey</h6>";

	}
	return $cvap_table;
}

function get_reg() {

    $conn = Util::get_ctb_conn();
    $sql = "SELECT DIST, TOT, DEM, REP FROM ctb2016_sos_all WHERE RPT_DATE = '2021-08-30'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
	     $adv = '';
	     $fourcode = $row['DIST'];
	     $adv = get_advantage_raw($row['DEM'], $row['REP'], $row['TOT']);
	     $retval[$fourcode] = $row;
	     $retval[$fourcode]['ADV'] = $adv;
	}
    }
    return $retval;

}

function get_pres($type) {

    $conn = Util::get_ctb_conn();
    switch($type) {
	case "AD":
	    $long_type = "addist";
	    break;
        case "SD":
	    $long_type = "sddist";
	    break;
        case "CD":
	    $long_type = "cddist";
	    break;
    }


    $sql = "SELECT $long_type, SUM(PRSDEM01) AS PRSDEM01, SUM(PRSREP01) AS PRSREP01, SUM(PRSGRN01) AS PRSGRN01, SUM(PRSAIP01) AS PRSAIP01, SUM(PRSLIB01) AS PRSLIB01, SUM(PRSPAF01) AS PRSPAF01
	    FROM ctb2016_g20_v
	    GROUP BY $long_type";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
	     $fourcode = $type . checkaddzero($row[$long_type]);
	     $adv = '';
	     $tot = $row['PRSDEM01'] + $row['PRSREP01'] + $row['PRSGRN01'] + $row['PRSAIP01'] + $row['PRSLIB01'] + $row['PRSPAF01'];
	     $dem = $row['PRSDEM01'];
	     $rep = $row['PRSREP01'];
	     $adv = get_advantage_pres($dem, $rep, $tot);
	     $retval[$fourcode] = $row;
	     $retval[$fourcode]['ADV'] = $adv;
	     $retval[$fourcode]['TOT'] = $tot;
	}
    }
    return $retval;

}

function get_district_info($fourcode) {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT text from ctb_redist_dist_dscr_20 WHERE fourcode = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			return $row['text'];
		}
	}
}

function get_fourcode_index() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT fourcode, old_fourcode FROM ctb_redist_VIZ_1220_sum2";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$old_fourcode = $row['old_fourcode'];

			$index['old'][$old_fourcode] = $fourcode;
			$index['new'][$fourcode] = $old_fourcode;
		}
	}
	return $index;
}

function get_vra() {
	$is_vra = Array(
	  	"AD27" 	=> TRUE,
	  	"AD29"	=> TRUE,
	  	"AD31"	=> TRUE,
	  	"AD33"	=> TRUE,
	  	"AD35"	=> TRUE,
	  	"AD36"	=> TRUE,
	  	"AD39"	=> TRUE,
	  	"AD45"	=> TRUE,
	  	"AD48"	=> TRUE,
	  	"AD49"	=> TRUE,
	  	"AD50"	=> TRUE,
	  	"AD53"	=> TRUE,
	  	"AD56"	=> TRUE,
		"AD58"	=> TRUE,
	  	"AD60"	=> TRUE,
	  	"AD62"	=> TRUE,
	  	"AD64"	=> TRUE,
	  	"AD68"	=> TRUE,
	  	"AD80"	=> TRUE,
	  	"SD14"	=> TRUE,
	  	"SD16"	=> TRUE,
	  	"SD18"	=> TRUE,
	  	"SD22"	=> TRUE,
	  	"SD29"	=> TRUE,
	  	"SD30"	=> TRUE,
	  	"SD31"	=> TRUE,
	  	"SD33"	=> TRUE,
	  	"SD34"	=> TRUE,
	  	"CD13"	=> TRUE,
	  	"CD18"	=> TRUE,
	  	"CD21"	=> TRUE,
	  	"CD22"	=> TRUE,
	  	"CD25"	=> TRUE,
	  	"CD31"	=> TRUE,
	  	"CD33"	=> TRUE,
	  	"CD35"	=> TRUE,
	  	"CD38"	=> TRUE,
	  	"CD39" 	=> TRUE,
	  	"CD42"	=> TRUE,
	  	"CD44"	=> TRUE,
	  	"CD46"	=> TRUE,
	  	"CD52"	=> TRUE


	  	);

	return $is_vra;

}

function get_advantage_raw ($dem, $rep, $tot) {

	$d = number_format((($dem / $tot) * 100), 2);
	$r = number_format((($rep / $tot) * 100), 2);

	if($d > $r) {
		//DEM ADVANTAGE
		$adv = number_format(($d - $r), 2);
		$retval = "<span class='blueme boldme'>D +" . $adv . "%</span>";
	} elseif ($r > $d) {
		//REP ADVANTAGE
		$adv = number_format(($r - $d), 2);
		$retval = "<span class='redme boldme'>R +" . $adv . "%</span>";
	} elseif($d == $r && $d > 0) {
		//AT PARITY
		$retval = 'EVEN';
	}
	return $retval;
}

function get_advantage_pres ($dem, $rep, $tot) {

	$d = number_format((($dem / $tot) * 100), 2);
	$r = number_format((($rep / $tot) * 100), 2);

	if($d > $r) {
		//DEM ADVANTAGE
		$adv = number_format(($d - $r), 2);
		$retval = "<span class='blueme boldme'>BIDEN +" . $adv . "%</span>";
	} elseif ($r > $d) {
		//REP ADVANTAGE
		$adv = number_format(($r - $d), 2);
		$retval = "<span class='redme boldme'>TRUMP +" . $adv . "%</span>";
	} elseif($d == $r && $d > 0) {
		//AT PARITY
		$retval = 'EVEN';
	}
	return $retval;
}

function get_redist_zips($fourcode) {
	$conn = Util::get_ctb_conn();
	$fourcode = mb_substr($fourcode, 0, 5);
	$partial_zip = '';
	$complete_zip = '';
	$sql = "SELECT fourcode, zip, pct FROM ctb_redist_zips_20 WHERE fourcode = '$fourcode' ORDER BY zip";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
	     while($row = $result->fetch_assoc()) {
		$pct = number_format($row['pct']);
		if($pct == "100") {
			$complete_zip .= $row['zip'] . ", ";
		} else {
			$partial_zip .= $row['zip'] . " (" . number_format($pct) . "%), ";
		}
	     }
	     $complete_zip = substr($complete_zip, 0, -2);
	     $partial_zip = substr($partial_zip, 0, -2);
	}
	$retval = "<div class='row'>
			<h3 align='center'>ZIP Codes Within District</h3>
			<div class='col-lg-6'>
				<h4 align='center'>COMPLETE</h4>
				<p style='text-align: justify;'>
					$complete_zip
				</p>
			</div>
			<div class='col-lg-6'>
				<h4 align='center'>PARTIAL</h4>
				<p style='text-align: justify;'>
					$partial_zip
				</p>
			</div>
		    </div>";
	return $retval;
}

function locate_candidates($fourcode) {
	$conn = Util::get_ctb_conn();
	$fourcode = mb_substr($fourcode, 0, 5);
	$sql = "SELECT ST_AsText(SHAPE) AS SHAPE
		FROM supe_dists_ca_legislative
		WHERE year = '2020' && fourcode = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$z = $row['SHAPE'];
		}
	}
	$sql = "SELECT cand_id FROM ctb_e22_cand_geo WHERE ST_Intersects( SHAPE, ST_GeomFromText ( '$z', 1) )";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_id = $row['cand_id'];
			$cand_arr[$cand_id] = $cand_id;
		}
	}


	$q = '';
	foreach($cand_arr as $cand_id => $ignore) {
		$q .= " cand_id = '$cand_id' ||";
	}
	$q = substr($q, 0, -2);

	$sql = "SELECT *, fourcode as FOURCODE FROM ctb_cand_filed_v2 WHERE ( $q ) && cycle = 2022 && hide != 1";

	//echo("<br>$sql<br>");

	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cand_id = $row['cand_id'];
			if($row['is_inc']) {
				$arr[1][$cand_id] = $row;
			} else {
				$arr[0][$cand_id] = $row;
			}
		}
	}

	$inc_table = "<table class='table-striped'>
			<tbody>";
	foreach($arr[1] as $id => $x) {
		$inc_table .= "<tr>
					<td>" . $x['FOURCODE'] . "</td>
					<td>" . $x['namf'] . " " . $x['naml'] . "</td>
					<td>" . $x['party'] . "</td>
				</tr>";
	}
	$inc_table .= "</tbody></table>";

	$non_inc_table = "<table class='table-striped'>
			<tbody>";

	foreach($arr[0] as $id => $x) {
		$non_inc_table .= "<tr>
					<td>" . $x['FOURCODE'] . "</td>
					<td>" . $x['namf'] . " " . $x['naml'] . "</td>
					<td>" . $x['party'] . "</td>
				</tr>";
	}
	$non_inc_table .= "</tbody></table>";
	$retval['inc'] = $inc_table;
	$retval['non_inc'] = $non_inc_table;
	return $retval;

}


?>


@endsection

@section('scripts')
    <script>gtag('set', { 'book_category': 'districts' });</script>

    {{--  Incumbent page scripts  --}}

    <script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=180464472033211";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
    <script async src='//platform.twitter.com/widgets.js' charset='utf-8'></script>

    <script src="/js/cbpFWTabs.js"></script>
    <script>


      document.addEventListener("DOMContentLoaded", function () {
        load_run1(); // Handler when the DOM is fully loaded
      });


      $(function () {

        // setTimeout(function() {
        // Hack to reload the iframes
        $('iframe').toArray()
            .forEach(function (iframe) {
              iframe.src += '';
            })
        // }, 10);

        $('nav.tab-bar a').on('click', function (e) {
          e.preventDefault();
          var id = this.href.split('#')[1];

          $('.content-wrap section').css('display', 'none');
          $('section#' + id).css('display', 'block');

          $('nav.tab-bar li').removeClass('tab-current');
          $(this).parent().addClass('tab-current');
        });

        var current = window.location.hash || '#Overview';
        $('nav.tab-bar a[href="' + current + '"]').click();
      });

      /**
       * For campaigns page
       */
      $(function () {
        $('#years > ul a').on('click', function (e) {
          e.preventDefault();
          var elec = $(this).attr('for');

          $('#years > div').css('display', 'none');
          $('#years > div' + elec).css('display', 'block');

          $('#years > ul li').removeClass('tab-current');
          $(this).parent().addClass('tab-current');
        });
        $('#years > ul a').first().click();
      });

      function load_run1() {
        runme1();
        runme2();
      }


      function runme2() {
        $('input[name="scope2"]').click(function () {

          //alert('CLICK');

          var fourcode = "<?= $cached['fourcode'] ?>"

          if (this.value == 'vdetail') {
            url = '/book/direct?id=' + fourcode + '&rpt=' + this.value;
          }

          if (this.value == 'veth') {
            url = '/book/direct?id=' + fourcode + '&rpt=' + this.value;
          }

          if (this.value == 'vparty') {
            url = '/book/direct?id=' + fourcode + '&rpt=' + this.value;
          }

          //alert(url);

          closeiframe2();

          document.getElementById("hiddendiv2").style["display"] = "inline-block";
          window.content.location.href = url;

        });

      }

      function closeiframe2(type) {
        removeiframes2();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1030px";
        iframe.height = "800px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv2").appendChild(iframe);
        return false;
      }

      function removeiframes2() {
        var iframes = document.querySelectorAll('iframe[name="content"]');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }

      function runme1() {
        $('input[name="scope1"]').click(function () {

          //alert('CLICK');

          if (this.value == 'new_map_nav') {
            url = '/book/new_map_nav2';
          }

          if (this.value == 'map_nav') {
            url =  <?php

              $url = "'/book/map_nav?id=" . $cached['fourcode'] . "';";
              echo $url;

              ?>
          }

          if (this.value == 'overlap_nav') {
            url = '/book/overlap_nav2';
          }

          //alert(url);

          closeiframe();

          document.getElementById("hiddendiv1").style["display"] = "inline-block";
          window.content.location.href = url;

        });

      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1030px";
        iframe.height = "800px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv1").appendChild(iframe);
        return false;
      }

      function removeiframes() {
        var iframes = document.querySelectorAll('iframe[name="content"]');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }


    </script>

    <script src="/js/cbpFWTabs2.js"></script>
    <script>
      (function () {

        [].slice.call(document.querySelectorAll('.tabs2'))
            .forEach(function (el) {
              new CBPFWTabs2(el);
            });

      })();
    </script>

	<script type="text/javascript">
  		$(document).ready(function () {
		    $(".arrow-right").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "+=336"
		        }, 750);
		    });
		    $(".arrow-left").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "-=336"
		        }, 750);
		    });
		});
  	</script>

<script type="text/javascript"> <!--BEGIN ENDJAVA SECTION -->

<?php
foreach ($endjava as $value) {
    echo($value);
}
?>

</script> <!--END ENDJAVA SECTION-->
@endsection

@section('styles')

    <style>

  		.title {
  			width: 100%;
  			max-width: 854px;
  			margin: 0 auto;
  			font-size: 1em;
  		}

  		.caption {
  			width: 100%;
  			max-width: 854px;
  			margin: 0 auto;
  			padding: 5px 0;
  			font-size: 0.8em;
			line-height: 0.9em;

  		}

  		.container {
  			width: 100%;
  			max-width: 854px;
  			min-width: 440px;
  			background: #fff;
  			margin: 0 auto;
  		}


  		/*  VIDEO PLAYER CONTAINER
 		############################### */
  		.vid-container {
		    position: relative;
		    padding-bottom: 52%;
		    padding-top: 30px;
		    height: 0;
		}

		.vid-container iframe,
		.vid-container object,
		.vid-container embed {
		    position: absolute;
		    top: 0;
		    left: 0;
		    width: 100%;
		    height: 100%;
		}


		/*  VIDEOS PLAYLIST
 		############################### */
		.vid-list-container {
			width: 92%;
			overflow: hidden;
			margin-top: 20px;
			margin-left:4%;
			padding-bottom: 20px;
		}

		.vid-list {
			width: 1344px;
			position: relative;
			top:0;
			left: 0;
		}

		.vid-item {
			display: block;
			width: 148px;
			height: 148px;
			float: left;
			margin: 0;
			padding: 10px;
		}

		.thumb {
			/*position: relative;*/
			overflow:hidden;
			height: 84px;
		}

		.thumb img {
			width: 100%;
			position: relative;
			top: -13px;
		}

		.vid-item .desc {
			color: #21A1D2;
			font-size: 15px;
			margin-top:5px;
		}

		.vid-item:hover {
			background: #eee;
			cursor: pointer;
		}

		.arrows {
			position:relative;
			width: 100%;
		}

		.arrow-left {
			color: #fff;
			position: absolute;
			background: #777;
			padding: 15px;
			left: -25px;
			top: -130px;
			z-index: 99;
			cursor: pointer;
		}

		.arrow-right {
			color: #fff;
			position: absolute;
			background: #777;
			padding: 15px;
			right: -25px;
			top: -130px;
			z-index:100;
			cursor: pointer;
		}

		.arrow-left:hover {
			background: #CC181E;
		}

		.arrow-right:hover {
			background: #CC181E;
		}


		@media (max-width: 624px) {
			body {
				margin: 15px;
			}
			.caption {
				margin-top: 40px;
			}
			.vid-list-container {
				padding-bottom: 20px;
			}

			/* reposition left/right arrows */
			.arrows {
				position:relative;
				margin: 0 auto;
				width:96px;
			}
			.arrow-left {
				left: 0;
				top: -17px;
			}

			.arrow-right {
				right: 0;
				top: -17px;
			}
		}

		.greenme {
			color: green;
		}

		.redme {
			color: red;
		}

        .iframe-container {
            position: relative;
            width: 100%;
        }

        .iframe-container > * {
            display: block;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .greyColumn {
            background: #eee;
        }

    </style>


    <style>

	.greenme {
	     color: green;
	     border-color: green;
	}

        .candidate-panel {
            background-color: #fcfcfc;
            padding: 20px;
            width: 105%;
            max-width: 1190px;
            margin-right: 40px;
            margin-top: 20px;
        }

        .candidate-panel .candidate-content {
            padding: 10px;
        }

        .panel-candidate-header {
            font-weight: bold;
            font-variant: small-caps;
            text-align: right;
            font-size: 1.5em;
            box-shadow: none;
        }

        .content-header {
            text-align: center;
            font-variant: small-caps;
        }

        #years > ul li {
            list-style: none;
            padding: 5px 15px;
            display: inline-block;
            margin: 5px;
            border: 1px solid #ccc;
        }

        #years > ul li.tab-current {
            background: #ddd;
        }

        #years > ul li:hover {
            background: #eee;
        }

        .no-border {
            box-shadow: none;
        }

        .vote-tables .col-sm-3:nth-child(5) {
            clear: both !important;
        }

        .primary_table {
            font-family: 'PT Sans Narrow' !important;
        }

        .panel input {
            margin-left: 0 !important;
        }

        .tablesaw > * {
            font-family: 'PT Sans Narrow' !important;
            padding: 0.02em !important;
        }

        .tablesaw a {
            font-family: 'PT Sans Narrow' !important;
        }

        .ie_iframe {
            min-height: 800px;

        }

        .cmte_contributions td, .cmte_contributions tr, .cmte_contributions p, .cmte_contributions a {
            padding: 0.01em !important;
            line-height: 1em;
        }

	.nav-icon {
		font-size: 2.5em !important;
	}

	.small-table .table-striped {
		line-height: 1em !important;
		padding-top: 0px;
		padding-bottom: 0px;
		font-size: 0.8em;
	}

	.header_icon {
		font-size: 1.3em !important;
	}



    </style>


@endsection



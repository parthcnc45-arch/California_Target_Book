<?php

global $fourcode, $role, $endjava;
$fourcode = $id;
$endjava = Array();

Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;

function populate_cached($fourcode) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb_cached_data WHERE dist = '$fourcode'";
    $retval=[];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
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


	$sql = "SELECT post_id, updated FROM `ctb_hot_sheet` WHERE text LIKE '%$fourcode%' GROUP BY post_id ORDER BY updated DESC";
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
		@$enddraw .= "<option value='&election=$e'>$verbose</option>";
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
                if(isset($income_set)) {
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
            @$enddraw .= "<option value='&dataset=$dataset'>$verbose</option>";

        }
    }
    echo($enddraw);

}



?>


@php ($book_side_nav_active = 'district')

@extends('layouts.bookNew')

@section('title', 'CA District '.$id.' | California Target Book')

@section('content')

    <div>
        @include('components.dist_head')

        <div class="container-fluid pt-xl">

            <?php
                global $cached;
                $cached = populate_cached($id);
                $cached['fourcode'] = $id;
		$fourcode = $id;
            ?>

            <div class="row">
                <div class="col-lg-10 center-block fn">
                    <nav class='clearfix page-nav'>
                        <ul class="clearfix">
                            <li class="active" >
                                <a href='#Overview' role="tab" data-toggle="tab">
                                    {{-- <i class="material-icons">home</i> --}}
                                    Overview
                                </a>
                            </li>
                            <li>
                                <a href='#Incumbent' role="tab" data-toggle="tab">
                                    {{-- <i class="material-icons">person</i> --}}
                                    Incumbent
                                </a>
                            </li>
                            <li>
                                <a href='#District' role="tab" data-toggle="tab">
                                    {{-- <i class="material-icons">map</i> --}}
                                    District
                                </a>
                            </li>
                            <li>
                                <a href='#Campaigns' role="tab" data-toggle="tab">
                                    {{-- <i class="material-icons">poll</i> --}}
                                    Campaigns
                                </a>
                            </li>

                            <li>
                                <a href='#PastElections' role="tab" data-toggle="tab">
                                    {{-- <i class="material-icons">filter_list</i> --}}
                                    Election Reports
                                </a>
                            </li>
                            <li>
                                <a href='#Census' role="tab" data-toggle="tab">
                                    {{-- <i class="material-icons">place</i> --}}
                                    Census Trends
                                </a>
                            </li>
                            <li>
                                <a href='#PastHS' role="tab" data-toggle="tab">
                                    {{-- <i class="material-icons">place</i> --}}
                                    Past Hot Sheets
                                </a>
                            </li>

                        </ul>
                    </nav>

                    <div class="content-wrap pt-xl">
                        <section id="Overview" class="active">
                            {{-- @cache($id.'-Overview') --}}
                            <?php include(Util::$view_root.'dist_overview.php') ?>
                            {{-- @endcache --}}
                        </section>

                        <section id="Incumbent">
                            {{-- @cache($id.'-Incumbent') --}}
                            <?php include(Util::$view_root.'incumbent_page.php') ?>
                            {{-- @endcache --}}
                        </section>

                        <section id="District">
                            {{-- @cache($id.'-District_Detail') --}}
                            <?php include(Util::$view_root.'district_page.php') ?>
                            {{-- @endcache --}}
                        </section>

                        <section id="Campaigns">

                        <?php include(Util::$view_root.'cal_campaigns.php') ?>

                        </section>



                 <section id="PastElections">

                        <div align='center'>

                            <select name="pastelec" id="pastelec" class="distval showonselect">
                            <option value=''>Select Election</option>


                                <?php
                                    populate_elections();
                                ?>

                            </select>
                        </div>

                        <?php
                              $local_js = "


                                $(document).ready(function () {
                                    $('#pastelec').on('change', function () {
                                        var x = $(this).val();
                                        var url = '/ctb-legacy/individual_results.php?geo=N&dist=$fourcode' + x;
                                        document.getElementById('pastelecDiv').style.display = 'block';
                                        document.getElementById('btmCloseElec').style.display = 'block';
                                        document.getElementById('hiddenElec').src = url;
                                    });
                                });

                            function closePastElectDiv() {
                                document.getElementById('pastelecDic').style.display = 'none';
                                document.getElementById('btmCloseElec').style.display = 'none';
                                document.getElementById('hiddenElec').src = '/img/spinner.gif';
                            }

                           ";

                            // echo($local_js);
                            array_push($endjava, $local_js);



                        ?>

                      <p align='center'>
                        <div id="pastelecDiv" style="display:none;" class="answer_list">
                            <iframe src="/img/spinner.gif" id="hiddenElec" height="1000" width="100%" align='center'></iframe>
                        </div>
                        <p style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                            <input class="btn" style="display: none;" id="btmCloseElec" value="CLOSE" onclick="closePastElectDiv()" type="button" />
                        </p>
                     </p>





                    </section>


                    <section id="Census">


                        <div align='center'>

                            <select name="trend" id="trend" class="distval showonselect">
                            <option value=''>Select Dataset</option>


                                <?php
                                    populate_datasets();
                                ?>

                            </select>
                        </div>

                        <?php
                              $local_js = "


                                $(document).ready(function () {
                                    $('#trend').on('change', function () {
                                        var x = $(this).val();
                                        var url = '/ctb-legacy/census_stat_graph_v2?geo=" . $fourcode . "' + x;
                                        document.getElementById('trendDiv').style.display = 'block';
                                        document.getElementById('btmClose6').style.display = 'block';
                                        document.getElementById('cityHidden4').src = url;
                                    });
                                });

                            function closeTrendDiv() {
                                document.getElementById('trendDiv').style.display = 'none';
                                document.getElementById('btmClose6').style.display = 'none';
                                document.getElementById('cityHidden4').src = '/img/spinner.gif';
                            }

  				";

                            // echo($local_js);
                            array_push($endjava, $local_js);



                        ?>

                      <p align='center'>
                        <div id="trendDiv" style="display:none;" class="answer_list">
                            <iframe src="/img/spinner.gif" id="cityHidden4" height="1000" width="100%" align='center'></iframe>
                        </div>
                        <p style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                            <input class="btn" style="display: none;" id="btmClose6" value="CLOSE" onclick="closeTrendDiv()" type="button" />
                        </p>
                     </p>





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


    </style>


@endsection



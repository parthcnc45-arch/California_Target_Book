<?php

//POST-2020 REDISTRICTING VERSION

global $fourcode, $st, $role, $endjava, $cached, $info, $dist_status;
$fourcode = $id;
//$st = $state;
$cached['fourcode'] = $fourcode;
$endjava = Array();
//echo("<br>$st - $fourcode<br>");
Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;
$dist_status = check_dist_status($fourcode);

?>



@php ($book_side_nav_active = 'district')

@extends('layouts.book')

@section('title', 'NEW '.$id.' | California Target Book')

@section('content')



    <div>
	<?php echo($dist_status); ?>	
        <div class="container-fluid pt-xl">
            
            <div class="row">
		
                <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-sm-12 center-block fn">
		
                    <nav class='clearfix page-nav'>
                        <ul class="clearfix">
                            <li class='active'>
                                <a href='#Summary' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">newspaper</i>
                                    Summary
                                </a>
                            </li>
                            <li>
                                <a href='#Incumbent' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">person</i>
                                    Incumbent
                                </a>
                            </li>

                            <li>
                                <a href='#Rollcall' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">ballot</i>
                                    Roll Call Votes
                                </a>
                            </li>                            
                            <li>
                                <a href='#Campaigns' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">poll</i>
                                    Campaigns
                                </a>
                            </li>
                            <!--
                            <li>
                                <a href='#Overview' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">map</i>
                                    Overlaps
                                </a>
                            </li>




                            <li>
                                <a href='#Campaigns' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">poll</i>
                                    Campaigns
                                </a>
                            </li>
                            -->


                        </ul>
                    </nav>

                    <div class="content-wrap pt-xl">

            <section id="Summary" class="active">
            	<div class='row'>
            		<div class='panel col-lg-6'>

		            	<?php
						      $url = "https://californiatargetbook.com/ctb-legacy/draw_map22.php?id=$fourcode";
						      //echo("<br>$url<br>");
						      echo("<h1>U.S. House - $fourcode</h1>");
						      $iframe_html = "<iframe src='$url' width='800' height='600' align='center' scrolling='no'></iframe>";
						      echo($iframe_html);
                              $base = "HOUSE";
                              $state = mb_substr($fourcode, 0, 2);
						      //echo($url);
						      $overlaps = get_overlaps($base, $state, $fourcode);
						      $e_results = get_election_results($state, $fourcode);
                              //echo("<br>INFO DUMP<Br>");
                              $info = retrieve_incumbent_info($fourcode);
                              $inc_cand_id = $info['CAND_ID'];
			                  $social = get_cand_social($inc_cand_id);
                              $inc_cmte_assignments = get_committee_assignments($inc_cand_id, "2022");
                              $rc["2023"] = load_roll_call_votes($fourcode, "2023");
                              //var_dump($info);
                              echo("<hr />");
                              echo $overlaps;                              

		            	?>
		            </div>
		            <div class='panel col-lg-6'>
		            	<?php 


                              $img_url = "<img src='" . $info['IMG'] . "' class='img-thumbnail' width='300' />";
                              
                              $cand_nm = $info['INCUMBENT'] . " (" . $info['PARTY'] . ")";
                              if(!empty($info['HOMETOWN'])) {
                                $hometown_add = "<h4 align='center'>" . $info['HOMETOWN'] . "</h4>";
                              }
                              if(!empty($info['BIOGUIDE'])) {
                                $cand_nm = "<a href='https://bioguide.congress.gov/search/bio/" . $info['BIOGUIDE'] . "' target='_blank'>$cand_nm</a>";
                              }
                              $inc_span = "<p align='center'>$img_url<br><h3 align='center'>$cand_nm</h3><h4 align='center'>$social</h4>$hometown_add</p>";
                              if(!empty($info['OFFICE'])) {
                                $office_span = "<div class='smallbox' align='center'>
                                                 <div class='card wide-card card-blue'>
                                                    <div class='card-head'>
                                                        <h6 align='center'>118th Congress Office Info</h6>
                                                    </div>
                                                    <div class='card-body text-center'>
                                                        <h4 align='center'>" . $info['OFFICE'] . "</h4>
                                                        <h5 align='center'>PH: (202) 22" . mb_substr($info['PHONE'], 0, 1) . "-" . mb_substr($info['PHONE'], 1, 4) . "</h5>
                                                    </div>
                                                </div>
                                            </div>";
                              }

                              echo($inc_span . $office_span);
                              echo($inc_cmte_assignments);
                              echo $e_results;
                              echo($info['PRS_TABLE']);

		            	 ?>
		            </div>

		        </div>


            </section>
			<section id="Overview">
				<?php
						//GET OVERLAPS
				?>

			</section>



	        <section id="Incumbent">
	            <?php include(Util::$view_root.'incumbent_fed.php') ?>
	        </section>


            <section id="Rollcall">
                <h2>118th Congress Roll Call Votes</h2> 
                <?php 
                    echo($rc['2023']);
                ?>
            </section>

            <section id="Campaigns">
                <?php include(Util::$view_root.'fed_campaigns_20.php') ?>
            

            </section>


	    


                    </div>
                </div>
            </div>


        </div>


    </div>

<?php 

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

function get_election_results($st, $fourcode) {
	$conn = Util::get_ctb_conn();
	if($fourcode && !$st) {
		$st = mb_substr($fourcode, 0, 2);
	}
	
	$sql = "SELECT * FROM ctb_us_results 
			WHERE state = '$st' && (fourcode = '$fourcode') 
			ORDER BY fourcode, cand_votes DESC";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	$i = 0;
    $last_fourcode = '';
    $enddraw = '';
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			if($fourcode == $last_fourcode) {
				$i++;
			} else {
				$i = 0;
			}
			$arr[$fourcode][$i] = $row;
			$last_fourcode = $fourcode;

		}
	}
	foreach($arr as $fourcode => $cands) {
		$enddraw .= "<p align='center'>$fourcode (2022)</p>";
		$enddraw .= "<table class='table table-striped w-auto table-fit blackbox' align='center'><tbody>";
		foreach($cands as $i => $x) {
			if($x['cand_party'] == "Rep") {
				$color_class = 'redme';
			} elseif($x['cand_party'] == "Dem") {
				$color_class = 'blueme';
			} else {
				$color_class = '';
			}
			if($x['outcome'] == "W") {
				$add_class = 'boldme';
			} else {
				$add_class = 'itcme';
			}
			if($x['cand_status'] == "I") {
				$add_status = "-Inc";
			} else {
				$add_status = '';
			}
			if($x['uncontested'] == 1) {
				$add_uncontested = " (Uncontested)";
			} else {
				$add_uncontested = '';
			}
			$party = $x['cand_party'] . $add_status;

			$enddraw .= "<tr class='$add_class'><td class='$color_class'>" . $x['cand_namf'] . " " . $x['cand_naml'] . "</td><td class='$color_class'>" . 
			$party . "</td><td align='right'>" . number_format($x['cand_votes']) . "</td><td>$add_uncontested</td><td>" . number_format((($x['cand_votes'] / $x['total_votes']) * 100), 2) . "%</td></tr>";
		}
		$enddraw .= "</tbody></table>";

	}
	return $enddraw;
}

function get_committee_assignments($cand_id, $year) {
    $conn = Util::get_ctb_conn();
    $enddraw = '';
    $sql = "SELECT * FROM ctb_fed_cmte_assignments WHERE cand_id = '$cand_id' && year = '$year' ORDER BY cmte_code";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $code = $row['cmte_code'];
            $this_short = mb_substr($code, 0, 2);
            if(mb_substr($code, 2, 2) == "00") {
                $arr[$this_short]['main'][$code] = $row;
            } else {
                $arr[$this_short]['sub'][$code] = $row;
            }
        }
    } else {
        return FALSE;
    }
    foreach($arr as $short => $cmtes) {
        $main_long_code = $short . "00";
        $main_cmte_nm = $cmtes['main'][$main_long_code]['cmte_long'];
        $main_cmte_rank = $cmtes['main'][$main_long_code]['rank'];
        $main_cmte_is_chair = $cmtes['main'][$main_long_code]['is_chair'];
        if($main_cmte_is_chair == 1) {
            $add_chair = " (Chair)";
        } else {
            $add_chair = '';
        }
        $enddraw .= $main_cmte_nm . $add_chair . " &mdash; Rank: $main_cmte_rank<br>";
        if(!empty($arr[$short]['sub'])) {
            if(sizeof($arr[$short]['sub']) > 0) {
                $enddraw .= "<ul>";
                foreach($cmtes['sub'] as $code => $x) {
                    $enddraw .= "<li>" . $x['cmte_long'];
                    if($x['is_chair'] == 1) {
                        $sub_add_chair = " (Chair)";
                    } else {
                        $sub_add_chair = "";
                    }
                    $enddraw .= $sub_add_chair . " &mdash; Rank: " . $x['rank'] . "</li>";
                }
                $enddraw .= "</ul>";
            }
        }
       
    }

    $retval = "<div class='card wide-card card-green w-auto'>
                <div class='card-head'>
                    <span class='small'>118th Congress Committee Assignments</span>
                </div>
                <div class='card-body text-left'>
                    $enddraw 
                </div>
               </div>";
    return $retval;               
}

function check_dist_status($fourcode) {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT * FROM nufec_e24_open WHERE fourcode = '$fourcode'";
	$open = '';
	$span = '';
	$target = '';
	$retval_text = '';
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$open = $row;
		}
	}
	$sql = "SELECT * FROM nufec_e24_targets WHERE fourcode = '$fourcode'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$target = $row;
		}
	}
	if(!empty($open) || !empty($target)) {
		if(!empty($open)) {
			$retval_text = "<div class='row bg-success pad10'>
								<div class='col-lg-12'>
									<div class='row'>
										<div class='col-lg-12'>
											<h4 class='boldme text-lato text-info text-smallcap'>OPEN SEAT IN 2024 - Incumbent " . $open['incumbent'] . " (" . $open['party'] . ") - " . $open['reason'] . "</h4>
										</div>
									</div>
								</div>
							</div>";
		}
		if(!empty($target)) {
			$bg_class = '';
			if($target['targeted_by'] == "NRCC") {
				$bg_class= 'bg-danger';
			} elseif($target['targeted_by'] == "DCCC") {
				$bg_class = 'bg-primary';
			}
			$retval_text.= "<div class='row $bg_class pad10'>
								<div class='col-lg-12'>
									<h4>Seat is on the " . $target['targeted_by'] . "'s 2024 Target List</h4>
								</div>
							</div>";
		}
	}
	//echo(htmlspecialchars($retval_text));
	return $retval_text;
};

function get_overlaps($base, $state, $this_fourcode) {
	$conn = Util::get_ctb_conn();

	if(!$state && !empty($this_fourcode)) {
		$state = mb_substr($this_fourcode, 0, 2);
	}
	$sql = "SELECT * FROM ctb_overlaps_20 WHERE base_type = '$base' && state = '$state' && fourcode = '$this_fourcode'";
	//echo("<Br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$type = $row['overlap_type'];
			$id = $row['id'];
			if($type == "PLACE") {
				if(substr($row['overlap_nm'], -3) == "CDP") {
					$type = "CDP";
					$row['overlap_nm'] = substr($row['overlap_nm'], 0, -3);
				} elseif(substr($row['overlap_nm'], -4) == "city") {
					$type = "CITY";
					$row['overlap_nm'] = substr($row['overlap_nm'], 0, -4);
				} elseif(substr($row['overlap_nm'], -4) == "town") {
					$type = "TOWN";
					$row['overlap_nm'] = substr($row['overlap_nm'], 0, -4);
				} elseif(substr($row['overlap_nm'], -7) == "village") {
                    $type = "VILLAGE";
                    $row['overlap_nm'] = substr($row['overlap_nm'], 0, -7);
                } else {
					$type = "OTHER";
				}
			}
			$arr[$type][$id] = $row;
		}
	}
	//var_dump($arr);
	$order = Array("HOUSE" => TRUE, "UPPER" => TRUE, "LOWER" => TRUE, "COUNTY" => TRUE, "CITY" => TRUE, "TOWN" => TRUE, "VILLAGE" => TRUE, "CDP" => TRUE, "OTHER" => "TRUE", "ZIP" => TRUE);
	unset($order[$base]);
	$retval = "<div class='w-90'>";
	foreach($order as $type => $ignore) {
		switch($type) {
			case "HOUSE":
				$verbose = "U.S. House";
                $color = "green";
				break;
			case "UPPER":
				$verbose = "State Senate";
                $color = "blue";
				break;
			case "LOWER":
				if($state == "CA" || $state == "NV" || $state == "NY" || $state == "WI") {
					$verbose = "State Assembly";
				} else {
					$verbose = "State House";
				}
                $color = "blue";
				break;
			case "COUNTY":
				$verbose = "Counties";
                $color = "orange";
				break;
			case "PLACE":
				$verbose = "Cities / Places";
                $color = "yellow";
				break;
            case "CITY":
                $color = "yellow";
                $verbose = "Cities";
                break;
            case "TOWN":
                $color = "yellow";
                $verbose = "Towns";
                break;
            case "VILLAGE":
                $color = "yellow";
                $verbose = "Villages";
                break;
            case "CDP":
                $color = "yellow";
                $verbose = "Census Designated Places";
                break;
			case "ZIP":
				$verbose = "ZIP Codes";
                $color = "teal";
				break;
			default:
                $color = "yellow";
				$verbose = $type;
				break;
		}

		if(!empty($arr[$type])) {

    		if(sizeof($arr[$type]) > 0) {
    			$retval .= "<div class='d-flex wide-card card card-" . $color . "'>
                                <div class='card-head'>
                                    <span class='boldme'>$verbose</span>
                                </div>
                                <div class='card-body'>";
    			foreach($arr[$type] as $id => $x) {
                    if($state == "CA") {
                        if($type == "CITY") {
                            $retval .= "<a href='/book/city/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";
                        } elseif($type == "COUNTY") {
                            $retval .= "<a href='/book/county/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";
                        } elseif($type == "TOWN") {
                            $retval .= "<a href='/book/city/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";
                        } elseif($type == "UPPER") {
                            $retval .= "<a href='/book/new/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";
                        } elseif($type == "LOWER") {
                            $retval .= "<a href='/book/new/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";
                        } elseif($type == "HOUSE") {
                            $tmp_fourcode = "CD" . mb_substr($x['overlap_nm'], 2, 2);
                            $retval .= "<a href='/book/new/" . $tmp_fourcode . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";
                        } else {
                            $retval .= trim($x['overlap_nm']);    
                        }
                    } else {
                        if($type == "LOWER") {
                            $retval .= "<a href='/book/leg/$state/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";  
                        } elseif($type == "UPPER") {
                            $retval .= "<a href='/book/leg/$state/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";  
                        } elseif($type == "COUNTY") {
                            $retval .= "<a href='/book/us_county/$state/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";  
                        } elseif($type == "HOUSE") {
                            $retval .= "<a href='/book/us/" . trim($x['overlap_nm']) . "' target='_blank'>" . trim($x['overlap_nm']) . "</a>";  
                        } else {
                            $retval .= trim($x['overlap_nm']);    
                        }
                    }
    				
    				if($x['pct'] != 100) {
    					$retval .= " (" . $x['pct'] . "%), ";
    				} else {
    					$retval .= ", ";
    				}
    			}
    			$retval = substr($retval, 0, -2);
    			$retval .= "</div>
                        </div>";
            }
		}

	}
	$retval .= "</div>";
	return $retval;
}

function load_roll_call_votes($fourcode, $year) {
    global $endjava;
    $conn = Util::get_ctb_conn();
    //SEED INDEX
    $sql = "SELECT rollnumber, vote_date, bill_id, type, description, vote_result, totyea, totnoe, totprs, totnv FROM ctb2016_fedsummary_" . $year . " ORDER BY rollnumber";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $roll = $row['rollnumber'];
            $index[$roll] = $row;
        }
    }
    $sql = "SELECT dist, legislator, cand_id, vote, rollnumber FROM ctb2016_fedvote_" . $year . " WHERE dist = '$fourcode' ORDER BY rollnumber";
    $result = $conn->query($sql);

    $thisid = "housevote_$year";
    $js = "
            $(document).ready(function () {
            	//$('#$thisid').DataTable();


	    		$('#$thisid').DataTable({
				dom: 'Bfrtip',	    			
				buttons: ['copy', 'excel', 'pdf']
				});

                $('.dataTables_length').addClass('bs-select');
            });




    ";


    array_push($endjava, $js);

    $table = "<table class='table-striped table-fit w-auto line-1em' id='$thisid'>
                        <thead>
                            <tr>
                                <th>LEGISLATOR</th>
                                <th>DATE</th>
                                <th>ROLL #</th>
                                <th>BILL</th>
                                <th>DSCR</th>
                                <th>VOTED</th>
                                <th>RESULT</th>
                                <th>YES</th>
                                <th>NO</th>
                                <th>PRES</th>
                                <th>NV</th>
                            </tr>
                        </thead>
                        <tbody>";
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $roll = $row['rollnumber'];
            $d = $index[$roll];
            $bill_id = $d['bill_id'];
            $date = $d['vote_date'];
            $type = $d['type'];
            $dscr = $type . " - " . $d['description'];

            if($roll < 10) {
                $draw_roll = "00" . $roll;
            } elseif($roll < 100) {
                $draw_roll = "0" . $roll;
            } else {
                $draw_roll = $roll;
            }

            $url = 'https://clerk.house.gov/Votes/2023' . $draw_roll;


            $table .= "<tr>
                            <td>" . $row['legislator'] . "</td>
                            <td>" . $date . "</td>
                            <td><a href='$url' target='_blank'>" . $draw_roll . "</a></td>
                            <td>" . $bill_id . "</td>
                            <td class='small'>" . $dscr . "</td>
                            <td>" . $row['vote'] . "</td>
                            <td>" . $d['vote_result'] . "</td>
                            <td>" . $d['totyea'] . "</td>
                            <td>" . $d['totnoe'] . "</td>
                            <td>" . $d['totprs'] . "</td>
                            <td>" . $d['totnv'] . "</td>
                        </tr>";
        }
    }
    $table .= "</tbody></table>";
    return $table;
}

function retrieve_incumbent_info($fourcode)
{
    
    $conn = Util::get_ctb_conn();

    if(mb_substr($fourcode, 2, 3) != "SEN") {
        $sql = "SELECT * FROM ctb2016_e24_fed WHERE DIST = '$fourcode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
                $retval['INCUMBENT'] = $row['NAMF'] . " " . $row['NAML'];
                $id = $row['CAND_ID'];
                $cand_id = $id;
            }
        }

        $types = Array(".jpg", ".jpeg", ".png", ".gif", ".bmp");
        $retval['IMG'] = '';
        $retval['BIO'] = '';

        foreach ($types as $type) {
            $tmp_file = "img/candidates/$id" . $type;
            //echo("<br>Checking for $tmp_file...");
            if (file_exists($tmp_file)) {
                $retval['IMG'] = '/' . $tmp_file;
                //echo("Success!");
                break;
            }
        }

        $sql = "SELECT text from ctb_cand_bios WHERE cand_id = '$id' ORDER BY id DESC LIMIT 1";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['BIO'] = $row['text'];
            }
        }
    } else {

    }


    if($retval['PRSDEM_20'] > $retval['PRSREP_20']) {
        $adv_20 = "<span class='blueme boldme'>Biden +" . number_format($retval['PRSDEM_20'] - $retval['PRSREP_20'], 1) . "%</span>";
        $c3[0] = "Biden (D)";
        $c4[0] = $retval['PRSDEM_20'];
        $c3[1] = "Trump (R-Inc)";
        $c4[1] = $retval['PRSREP_20'];

    } else {
        $adv_20 = "<span class='redme boldme'>Trump +" . number_format($retval['PRSREP_20'] - $retval['PRSDEM_20'], 1) . "%</span>";
        $c3[1] = "Biden (D)";
        $c4[1] = $retval['PRSDEM_20'];
        $c3[0] = "Trump (R-Inc)";
        $c4[0] = $retval['PRSREP_20'];
    }



    if($retval['PRSDEM_16'] > $retval['PRSREP_16']) {
        $adv_16 = "<span class='blueme boldme'>Clinton +" . number_format($retval['PRSDEM_16'] - $retval['PRSREP_16'], 1) . "%</span>";
        $c1[0] = "Clinton (D)";
        $c2[0] = $retval['PRSDEM_16'];
        $c1[1] = "Trump (R)";
        $c2[1] = $retval['PRSREP_16'];
    } else {
        $adv_16 = "<span class='redme boldme'>Trump +" . number_format($retval['PRSREP_16'] - $retval['PRSDEM_16'], 1) . "%</span>";
        $c1[1] = "Clinton (D)";
        $c2[1] = $retval['PRSDEM_16'];
        $c1[0] = "Trump (R)";
        $c2[0] = $retval['PRSREP_16'];
    }


    $prs_table = "<p></p><table class='table-striped w-auto table-fit blackbox' align='center'>
                    <thead>
                        <tr>
                            <th colspan='2' class='border-right'>POTUS '16 - $adv_16</th>
                            <th colspan='2'>POTUS '20 - $adv_20</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>" . $c1[0] . "</td>
                            <td class='border-right'>" . number_format($c2[0], 1) . "%</td>
                            <td>" . $c3[0] . "</td>
                            <td>" . number_format($c4[0], 1) . "%</td>
                        </tr>
                        <tr>
                            <td>" . $c1[1] . "</td>
                            <td class='border-right'>" . number_format($c2[1],1) . "%</td>
                            <td>" . $c3[1] . "</td>
                            <td>" . number_format($c4[1], 1) . "%</td>
                        </tr>
                    </tbody>
                </table>";
    $retval['PRS_TABLE'] = $prs_table;
    
    return $retval;
}

function get_cand_social($cand_id) {
	global $master_conn;
	$retval = '';
	$conn = Util::get_ctb_conn();
	$icon_arr = Array(
		"twitter"	=> "fab fa-twitter",
		"linkedin"  => "fab fa-linkedin",
		"facebook"  => "fab fa-facebook",
		"snapchat"	=> "fab fa-snapchat",
		"instagram" => "fab fa-instagram",
		"youtube"	=> "fab fa-youtube",
		"campaign"	=> "fas fa-bullhorn",
		"official"	=> "fas fa-landmark",
		"business"	=> "fas fa-landmark"


		);

	$add_prefix = Array(
		"twitter"	=> "https://twitter.com/",
		"facebook"	=> "https://facebook.com/",
		"instagram" => "https://instagram.com/",
		);

	$sql = "SELECT twitter, facebook, youtube, linkedin, campaign, official, business, instagram FROM ctb_cand_links WHERE cand_id = '$cand_id' LIMIT 1";
	$result = $conn->query($sql);
    $list = '';
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			foreach($row as $key => $value) {
				if(!$value) {
					continue;
				}
				if(!empty($value) && strlen($value) > 1) {
					if(!empty($add_prefix[$key])) {
						$list .= "
									<span style='font-size: 1.5rem;'>
										
											<a href='" . $add_prefix[$key] . "$value' target='_blank'>
												<i class='" . $icon_arr[$key] . "'></i>
												
											</a>
											&nbsp;
						    		</span>
						  		";
					} else {
						$list .= "
									<span style='font-size: 1.5rem;'>
										
											<a href='$value' target='_blank'>
												<i class='" . $icon_arr[$key] . "'></i>
												
											</a>
											&nbsp;						  
						    		</span>
						  		";						
					}
				}
			}

		}
	}
	if(!empty($list)) {
		$retval = $list;
	}


	return $retval;
}


//echo("<p style='font-family: \"Montserrat\"; font-size: 16pt; text-align: justify;'>$bio_txt</p>");




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

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    

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

 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.js"></script>


<script type="text/javascript"> 

<?php
foreach ($endjava as $value) {
    echo($value);
}
?>

</script> 
@endsection

@section('styles')

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.css"/>


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

    .compact-table {
        line-height: 1em !important;
    }

    .compact-table td {
        padding-left: 2px;
        padding-right: 2px;
    }

	.header_icon {
		font-size: 1.3em !important;
	}

table.table-fit {
    width: auto !important;
    table-layout: auto !important;
}
table.table-fit thead th, table.table-fit tfoot th {
    width: auto !important;
}
table.table-fit tbody td, table.table-fit tfoot td {
    width: auto !important;
}

.chart {
	width: 100%;
	min-height: 400px;
}

	.so_div {
		border: 2px solid black;
		float: left;
		display: inline-block;
		padding: 2px;
		font-size: .9em;
		font-weight: bold;
		margin-left: 5px;
		margin-right: 5px;
		font-family: 'Lato';
	}

	.so_div_container {
		float: none;
		clear: both;
		display: inline-block;
		margin-left: auto;
		margin-right: auto;
	}

	.Support {
		color: green;
		font-weight: bold;
	}

	.Oppose {
		color: red;
		font-weight: bold;
	}

    .float-left {
        float: left !important;
    }

    .blackbox {
        border: 2px solid black;
    }

    .box800 {
        background-image: url(box800.jpg);
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        width: 800px;
        float: left;
        margin: 10px;
    }
    .rightme {
        text-align: right !important;
    }

    .leftme {
        text-align: left !important;
    }

    .border-right {
        border-right: 2px solid black !important;
    }

    .border-left {
        border-left: 2px solid black !important;
    }

    .width-90 {
        width: 90% !important;
    }

    .smallbox {
        max-width: 250px !important;
        margin-left: auto;
        margin-right: auto;
    }

    .line-1em {
        line-height: 1.1em !important;
    }

    .table-striped2 tbody > tr:nth-of-type(odd) {
      background-color: #f9f9f9;
    }

.table-striped2 thead > tr > th,
.table-striped2 thead > tr > td,
.table-striped2 tbody > tr > th,
.table-striped2 tbody > tr > td,
.table-striped2 tfoot > tr > th,
.table-striped2 tfoot > tr > td {
  padding-left: 3px;
  padding-right: 3px;
  vertical-align: top;
  border-top: 1px solid #ddd;
}

	.text-lato {
		font-family: "Lato";
	}

	.text-info {
		color: #007BA4;
	}

	.text-smallcap {
		font-variant: small-caps;
	}

	.pad10 {
		padding: 10px;
	}

	body {
		background-color: white !important;
	}
    .wide-card {
        min-width: 400px;
    }


    </style>


@endsection



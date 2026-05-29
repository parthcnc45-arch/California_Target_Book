@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'December Visualization CVAP | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        December Visualzation Citizen Voting Age Population (CVAP) Data
    </h2>

<?php

Util::require_ctb_api();
$endjava = Array();
global $pages, $fed_filed, $endjava_sections, $incumbents;

$places = populate_draft();

$incumbents = populate_incumbents();


$sections = Array(
//    "AD" 		=> "Assembly Districts",
//    "SD"       		=> "Senate Districts",
    "CD"         	=> "Congressional Districts",  
);



$js = " jQuery.tablesorter.addParser({
      id: \"fancyNumber\",
      is: function(s) {
        return /^[0-9]?[0-9,\.]*$/.test(s);
      },
      format: function(s) {
        return jQuery.tablesorter.formatFloat( s.replace(/,/g,'') );
      },
      type: \"numeric\"
    });

";
array_push($endjava, $js);

/*
$js = "$(document).ready(function() {
        $('#lemp_table').tablesorter({ 
                headers: {
                1: {
                    sorter: 'fancyNumber'
                },
                    2: {
                    sorter: 'fancyNumber'
                },
                3: {
                    sorter: 'fancyNumber'
                }
                    } 
            });
    });";
array_push($endjava, $js);
*/

$count = 0;
foreach($sections as $section => $verbose) {
    $count++;


    if($count == 1) {
        $active_class = 'active';
    } else {
        $active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$section' role='tab' data-toggle='tab' class='header_icon'>
                        <i class='material-icons header_icon'>local_atm</i>
                        $verbose
                    </a>
                  </li>";

    $enddraw .= "<section id='p$section' class='$active_class'> <!--BEGIN SECTION DIV-->";
    $enddraw .= "<div class='prop_div' align='center'> <!--BEGIN PROP DIV--> ";
    $enddraw .= "<h2>$verbose</h2>";

   if($section == "AD") {
   	  $target = 494709;
      $enddraw .= "<div class='panel justifyme'> <!--BEGIN ASSEMBLY PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
	
	   $table = generate_table($places['AD'], "AD", $target, $incumbents);
  	 $enddraw .= $table;
     $enddraw .= "</div> <!--END ASSEMBLY PANEL DIV -->";
     $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END ASSEBMLY SECTION-->";

   } elseif($section == "SD") {

      $target = 989419;
      $enddraw .= "<div class='panel justifyme'> <!--BEGIN SENATE PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
  
     $table = generate_table($places['SD'], "SD", $target, $incumbents);
     $enddraw .= $table;
     $enddraw .= "</div> <!--END SENATE PANEL DIV -->";
     $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END SENATE SECTION-->";

   } elseif($section == "CD") {

      $target = 761091;
      $enddraw .= "<div class='panel justifyme'> <!--BEGIN CONGRESS PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
  
     $table = generate_table($places['CD'], "CD", $target, $incumbents);
     $enddraw .= $table;
     $enddraw .= "</div> <!--END CONGRESS PANEL DIV -->";
     $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END CONGRESS SECTION-->";


   } elseif($section == "COUNTY") {

      $target = 0;
      $enddraw .= "<div class='panel justifyme'> <!--BEGIN COUNTY PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
  
     $table = generate_table($places['COUNTY'], "COUNTY", $target);
     $enddraw .= $table;
     $enddraw .= "</div> <!--END COUNTY PANEL DIV -->";
     $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END COUNTY SECTION-->";

   } elseif($section == "CITY") {

      $target = 0;
      $enddraw .= "<div class='panel justifyme'> <!--BEGIN CITY PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
  
     $table = generate_table($places['CITY'], "CITY", $target);
     $enddraw .= $table;
     $enddraw .= "</div> <!--END CITY PANEL DIV -->";
     $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END CITY SECTION-->";

   } elseif($section == "CDP") {

      $target = 0;
      $enddraw .= "<div class='panel justifyme'> <!--BEGIN CDP PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
  
     $table = generate_table($places['CDP'], "CDP", $target);
     $enddraw .= $table;
     $enddraw .= "</div> <!--END CDP PANEL DIV -->";
     $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END CDP SECTION-->";

   }

    $js = $endjava_sections[$section];
    array_push($endjava, $js);



}



echo("

        <div class='row'> <!--BEGIN MAIN ROW -->
            <div class='col-lg-10 center-block fn'> <!--BEGIN NAV DIV -->
                <nav class='clearfix page-nav'>
                    <ul class='clearfix'>
                        $nav_draw
                    </ul>
                </nav>
            </div> <!--END NAV DIV-->    

        <div class='content-wrap pt-xl'> <!--BEGIN CONTENT WRAP -->
        <!--BEGIN ENDDRAW-->

            $enddraw

       <!--END ENDDRAW-->

        </div> <!--END CONTENT WRAP -->
    
    </div> <!--END MAIN ROW-->

        
");

//$conn = Util::get_ctb_conn();

function generate_table($arr, $type, $target, $incumbents) {
  global $endjava_sections;
  $thisid = $type . "_table";




  switch($type) {
    case "AD":
      $is_dist = TRUE;
      $label = "ASSEMBLY DISTRICT";
      break;
    case "SD":
      $is_dist = TRUE;
      $label = "SENATE DISTRICT";
      break;
    case "CD":
      $is_dist = TRUE;
      $label = "CONGRESSIONAL DISTRICT";
      break;
    case "COUNTY":
      $is_dist = FALSE;
      $label = "COUNTY";
      break;
    case "CITY":
      $is_dist = FALSE;
      $label = "CITY";
      break;
    case "CDP":
      $is_dist = FALSE;
      $label = "PLACE";
      break;
  }

  $style = get_colors($type);
  $th_style = $style['head'];
  $colspan = $style['cols'];  
  

  if($is_dist) {


  $js = "$(document).ready(function() {
          $('#$thisid').tablesorter({ 
                  headers: {
                  1: {
                      sorter: 'fancyNumber'
                  },
                  3: {
                      sorter: 'fancyNumber'
                  },
                  5: {
                      sorter: 'fancyNumber'
                  },
                  7: {
                      sorter: 'fancyNumber'
                  },
                  8: {
                      sorter: 'fancyNumber'
                  },
                  11: {
                      sorter: 'fancyNumber'
                  },
                  12: {
                      sorter: 'fancyNumber'
                  }                                                      
                } 
              });
      });";
    $endjava_sections[$type] = $js;

    $retval = "<div>
      <table class='table table-hover table-responsive' align='center' id='$thisid'>
        <thead style='$th_style'>
		<tr>	
			<th colspan='2'></th>
			<th colspan='4'>DRAFT MAP STATISTICS</th>
			<th colspan='5'>DRAFT MAP CVAP</th>
			<th colspan='4'>2011 CVAP (OLD DISTRICTS)</th>
			<th colspan='4'>2019 CVAP (OLD DISTRICTS)</th>
		</tr>
		<tr>
			<th>DISTRICT</th>
			<th>INCUMBENT</th>
			<th>MAP NAME</th>
			<th class='rightme'>POPULATION</th>
			<th class='rightme'>CVAP</th>
			<th class='rightme'>%</th>
			<th class='rightme'>WHT</th>
			<th class='rightme'>LAT</th>
			<th class='rightme'>ASN</th>
			<th class='rightme'>BLK</th>
			<th class='rightme'>IND</th>
			<th class='rightme'>WHT</th>
			<th class='rightme'>LAT</th>
			<th class='rightme'>ASN</th>
			<th class='rightme'>BLK</th>
			<th class='rightme'>WHT</th>
			<th class='rightme'>LAT</th>
			<th class='rightme'>ASN</th>
			<th class='rightme'>BLK</th>
		</tr>
        </thead>
        $colspan
        <tbody>
    ";


    foreach($arr as $place => $x)  {

      $fourcode = $place;

      $tmp_19 = $x[2019];
      $tmp_11 = $x[2011];  
      
      $inc = $incumbents[$fourcode]['LEGISLATOR'];
      $party = $incumbents[$fourcode]['PARTY'];
      if($party == "D") {
        $span_class = 'blueme boldme';
      } elseif($party == "R") {
        $span_class = 'redme boldme';
      } else {
        $span_class = 'boldme';
      }

      $inc_draw = "<span class='$span_class'>" . $inc . "</span>";

      $this_map = str_replace("CD_", "", $x[2021]['mapname']);
      $this_map = str_replace("_1206", "", $this_map);

      $retval .= "<tr>
                    <td>" . $fourcode . "</td>
                    <td>" . $inc_draw . "</td>
		    <td>" . $this_map . "</td>
		    <td align='right'>" . number_format($x[2021]['population']) . "</td>
		    <td align='right'>" . number_format($x[2021]['cvap']) . "</td>
		    <td align='right'>" . number_format((($x[2021]['cvap'] / $x[2021]['population']) * 100), 1) . "</td>
		    <td align='right'>" . $x[2021]['White'] . "</td>
	    	    <td align='right'>" . $x[2021]['Latino'] . "</td>
		    <td align='right'>" . $x[2021]['Asian'] . "</td>
		    <td align='right'>" . $x[2021]['Black'] . "</td>
		    <td align='right'>" . $x[2021]['Indigenous'] . "</td>
		    <td align='right'>" . $tmp_11['White'] . "</td>
		    <td align='right'>" . $tmp_11['Latino'] . "</td>
		    <td align='right'>" . $tmp_11['Asian'] . "</td>
		    <td align='right'>" . $tmp_11['Black'] . "</td>
		    <td align='right'>" . $tmp_19['White'] . "</td>
		    <td align='right'>" . $tmp_19['Latino'] . "</td>
		    <td align='right'>" . $tmp_19['Asian'] . "</td>
		    <td align='right'>" . $tmp_19['Black'] . "</td>
                  </tr>";
    }
    $retval .= "</tbody></table>";

  } 
  return $retval;
}

function populate_draft() {
	//global $master_conn;
	//$conn = $master_conn;
	$conn = Util::get_ctb_conn();

	$sql = "SELECT jur_name, district FROM ctb_ca_city_shp WHERE jur_name LIKE 'VIZ6_%'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$jur_name = $row['jur_name'];
			$jur_name = str_replace("VIZ6_", "", $jur_name);
			$fourcode = $jur_name . checkaddzero($row['district']);
			$retval[$fourcode] = TRUE;

		}
	}

	$types = Array(
		"AD"	=> 80,
		"SD"	=> 40,
		"CD"	=> 53
	);

	foreach($types as $type => $cutoff) {
		$i = 1;
		//echo("\nChecking $type...");
		while($i <= $cutoff) {
			$fourcode = $type . checkaddzero($i);
			if(!isset($retval[$fourcode])) {
				//echo("\nAdding $fourcode");
				$retval[$fourcode] = TRUE;
			}
			$i++;
		}	
	}
	$cvap = get_cvap($retval);
	//var_dump($cvap);
	return $cvap;
}

function get_cvap($dists) {
	//global $master_conn;
	//$conn = $master_conn;
	$conn = Util::get_ctb_conn();


	$jur_name = "VIZ6_";
	$sql = "SELECT district, name, jur_name FROM ctb_ca_city_shp WHERE jur_name LIKE '$jur_name%'";
	//echo("\n$sql");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		//echo("<br>Returned " . $result->num_rows . " Rows.");
		while($row = $result->fetch_assoc()) {
			$type = mb_substr($row['jur_name'], 5, 2);
			$map_nm = "CD_" . $row['name'] . "_1206";
				
			$fourcode = $type . checkaddzero($row['district']);
			$map_nm_index[$map_nm] = $fourcode;
			$fourcode_map_index[$fourcode] = $map_nm;
		}
	}
	//echo("<br>MAP NAME DUMP<br>");
	//var_dump($map_nm_index);

	$sql = "SELECT * FROM ctb_redist_cvap_2011";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			$cvap_11[$fourcode] = $row;
		}
	}
	//echo("\n$sql");

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

	$c19_arr = Array(
		"CD"	=> "Congressional District",
		"AD"	=> "Assembly District",
		"SD"	=> "State Senate District"
		);
	
	$sql = "SELECT district, name, population, cvap_19, hisp, ind, black, asian, white, target, deviation FROM ctb_redist_cvap_1206";
	//echo("\n$sql");	
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$map_nm = $row['name'];
			$fourcode = $map_nm_index[$map_nm];
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
		WHERE (lnnumber = 1 || lnnumber = 4 || lnnumber = 5 || lnnumber = 7 || lnnumber = 8 || lnnumber = 13)";

	//echo("\n$sql");		
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$first_three = mb_substr($row['geoname'], 0, 3);
			switch($first_three) {
				case "Ass":
					$c19_q = $c19_arr['AD'];
					$type = "AD";
					break;
				case "Con":
					$c19_q = $c19_arr['CD'];
					$type = "CD";
					break;
				case "Sta":
					$c19_q = $c19_arr['SD'];
					$type = "SD";
					break;
			}

			$regex = '~' . $c19_q . '\s([0-9].*?)\s~mis';
			preg_match($regex, $row['geoname'], $r);
			$dist = $r[1];
			$fourcode = $type . checkaddzero($dist);
			//echo("<br>Checking " . $row['geoname'] . ", Got $c19_q, Extracted $dist, is $fourcode, setting field.");
			$key = $c19_fields[$row['lnnumber']];
			$cvap_19[$fourcode][$key] = (int)$row['cvap_est'];
		}
	}
	//echo("<br>CVAP_19 DUMP<br>");
	//var_dump($cvap_19);

	$eth_keys = Array(
			"White"	=> "white",
			"Asian" => "asian",
			"Latino" => "hisp",
			"Black"	=> "black",
			"Indigenous" => "ind"
		);
	ksort($dists);
	foreach($dists as $fourcode => $ignore) {
		
		$this_type = mb_substr($fourcode, 0, 2);
		$x = $cvap_data[$fourcode];
		$cvap = $x['cvap_19'];

		
		$y = $cvap_11[$fourcode];
		$z = $cvap_19[$fourcode];

		$tmp[2021]['population'] = $x['population'];
		$tmp[2021]['mapname'] = $fourcode_map_index[$fourcode];
		$tmp[2021]['cvap'] = $x['cvap_19'];


		$tmp[2011]['Asian'] = number_format(($y['asian'] * 100), 1);
		$tmp[2011]['Latino'] = number_format(($y['hisp'] * 100), 1);
		$tmp[2011]['Black'] = number_format(($y['black'] * 100), 1);
		$tmp[2011]['White'] = number_format(($y['white'] * 100), 1);


		$tmp[2019]['White'] = number_format((($z['white'] / $z['total']) * 100), 1);
		$tmp[2019]['Asian'] = number_format((($z['asian'] / $z['total']) * 100), 1);
		$tmp[2019]['Black'] = number_format((($z['black'] / $z['total']) * 100), 1);
		$tmp[2019]['Latino'] = number_format((($z['hisp'] / $z['total']) * 100), 1);
	
		$tmp[2021]['White'] 		= number_format((($x['white'] / $cvap) * 100), 1);
		$tmp[2021]['Asian'] 		= number_format((($x['asian'] / $cvap) * 100), 1);
		$tmp[2021]['Latino'] 		= number_format((($x['hisp'] / $cvap) * 100), 1);
		$tmp[2021]['Black'] 		= number_format((($x['black'] / $cvap) * 100), 1);
		$tmp[2021]['Indigenous'] 	= number_format((($x['ind'] / $cvap) * 100), 1);

		$cvap_table[$this_type][$fourcode] = $tmp;
	}
	return $cvap_table;
}






function get_colors($section) {
  switch($section) {
    case "AD":
      //DARK BLUE - ASSEMBLY
      $head = "#00334d";
      $columns = Array("#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#fffee3", "#fffee3", "#fffee3", "#fffee3", "#fff0e6", "#fff0e6", "#fff0e6", "#fff0e6");
      break;
    case "SD":
      //DARK GREEN - STATE SENATE
      $head = "#133913";
      $columns = Array("#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#fffee3", "#fffee3", "#fffee3", "#fffee3", "#fff0e6", "#fff0e6", "#fff0e6", "#fff0e6");
      break;
    case "CD":
      //DARK PURPLE - CONSTITUTIONAL
      $head = "#330033";
      $columns = Array("#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#ecf9ec", "#fffee3", "#fffee3", "#fffee3", "#fffee3", "#fff0e6", "#fff0e6", "#fff0e6", "#fff0e6");
      break;
    case "CITY":
      //DARK RED - CONGRESS
      $head = "#4d0000";
      $columns = Array("#ffffff", "#f0f0f5", "#ffe6e6", "#ffe6e6", "#ffb3b3", "#ffb3b3", "#ff9999", "#ff9999", "#ff8080", "#ff8080");
      break;
    case "COUNTY":
      //ORANGE - US CSENATE
      $head = "#4d1f00";
      $columns = Array("#ffffff", "#f0f0f5", "#fff0e6", "#fff0e6", "#ffe0cc", "#ffe0cc", "#ffd1b3", "#ffd1b3", "#ffc299", "#ffc299");
      break;
    case "CDP":
      //DARK RED - CONGRESS
      $head = "#4d0000";
      $columns = Array("#ffffff", "#f0f0f5", "#ffe6e6", "#ffe6e6", "#ffb3b3", "#ffb3b3", "#ff9999", "#ff9999", "#ff8080", "#ff8080");
      break;
    default:
      break;
      
  }
  $head_style = "background-color: $head; color: white; font-weight: bold;";
  $cols = "<colgroup>";
  foreach($columns as $color) {
    $cols .= "<col style='background-color: $color;'>";
  }
  $cols .= "</colgroup>";
  

  $retval['head'] = $head_style;
  $retval['cols'] = $cols;
  return $retval;
    

}

function populate_incumbents() {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT DIST, LEGISLATOR, PARTY FROM ctb2016_e22_incumbent ORDER BY DIST";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $fourcode = $row['DIST'];
        $retval[$fourcode] = $row;
      }
    }
    return $retval;
}


function get_advantage ($d, $r) {
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

function get_advantage_prs ($d, $r) {
	if($d > $r) {
		//DEM ADVANTAGE
		$adv = number_format(($d - $r), 2);
		$retval = "<span class='blueme boldme'>Biden +" . $adv . "%</span>";
	} elseif ($r > $d) {
		//REP ADVANTAGE
		$adv = number_format(($r - $d), 2);
		$retval = "<span class='redme boldme'>Trump +" . $adv . "%</span>";
	} elseif($d == $r && $d > 0) {
		//AT PARITY
		$retval = 'EVEN';
	}
	return $retval;
}


?>  


@endsection


@section('scripts')

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type='text/javascript'>

<?php
    
    foreach($endjava as $value) {
        echo($value);
    }

?>

</script>


@endsection



@section('styles')

<style>

.ported {
    height: 100vh;
}

.rightme {
  text-align: right;
}

.leftme {
  text-align: left;
}

.redme {
  color: red;
}

.blueme {
  color: blue;
}

.boldme {
  font-weight: bold;
}

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
}

</style>


@endsection
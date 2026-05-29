@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Final Maps Summary | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Final Maps Summary
    </h2>

<?php

Util::require_ctb_api();
$endjava = Array();
global $pages, $fed_filed, $endjava_sections, $incumbents;

$places = populate_draft();
$incumbents = populate_incumbents();


$sections = Array(
    "AD" 		=> "Assembly Districts",
    "SD"       		=> "Senate Districts",
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
          	<th></th>
		<th></th>
          	<th></th>
          	<th colspan='3'>DEM REG</th>
          	<th colspan='3'>REP REG</th>
          	<th colspan='2'>ADVANTAGE</th>
          	<th colspan='3'>BIDEN '20</th>
          	<th colspan='3'>TRUMP '20</th>
          	<th colspan='2'>ADVANTAGE</th>
          	<th colspan='2'>DISTRICT</th>
          <tr>
            <th>NEW #</th>
	    <th>OLD #</th>
            <th>INCUMBENT</th>
            <th class='rightme'>OLD</th>   
            <th class='rightme'>NEW</th>
            <th class='rightme'>&Delta;</th>

            <th class='rightme'>OLD</th>   
            <th class='rightme'>NEW</th>
            <th class='rightme'>&Delta;</th>

            <th class='rightme'>OLD</th>   
            <th class='rightme'>NEW</th>
 

            <th class='rightme'>OLD</th>   
            <th class='rightme'>NEW</th>
            <th class='rightme'>&Delta;</th>

            <th class='rightme'>OLD</th>   
            <th class='rightme'>NEW</th>
            <th class='rightme'>&Delta;</th>

            <th class='rightme'>OLD</th>   
            <th class='rightme'>NEW</th>


            <th>% Kept</th>
            <th>From Other Districts</th>

      
          </tr>
        </thead>
        $colspan
        <tbody>
    ";

    foreach($arr as $place => $x)  {

      $fourcode = $x['fourcode'];
      $old_fourcode = $x['old_fourcode'];

      $new_lnk = "<a href='/book/new/$fourcode' target='_blank'>$fourcode</a>";
      $old_lnk = "<a href='/book/district/$old_fourcode' target='_blank'>$old_fourcode</a>";

      $reg_dem_old = $x['old_dem'];
      $reg_rep_old = $x['old_rep'];
      $prs_dem_old = $x['old_biden'];
      $prs_rep_old = $x['old_trump'];

      $reg_dem_new = $x['new_dem'];
      $reg_rep_new = $x['new_rep'];
      $prs_dem_new = $x['new_biden'];
      $prs_rep_new = $x['new_trump'];

      $pct_orig    = $x['pct_orig'];
      $other_dists = $x['other_dists'];
      $res_inc	   = $x['res_inc'];
      $res_other   = $x['res_other'];
      
      $inc = $incumbents[$old_fourcode]['LEGISLATOR'];
      $party = $incumbents[$old_fourcode]['PARTY'];
      if($party == "D") {
        $span_class = 'blueme boldme';
      } elseif($party == "R") {
        $span_class = 'redme boldme';
      } else {
        $span_class = 'boldme';
      }

      $inc_draw = "<span class='$span_class'>" . $inc . "</span>";

      $retval .= "<tr>
                    <td>" . $new_lnk . "</td>
                    <td>" . $old_lnk . "</td>
                    <td>" . $inc_draw . "</td>
                    <td align='right'>" . number_format($reg_dem_old, 2) . "</td>
                    <td align='right'>" . number_format($reg_dem_new, 2) . "</td>
                    <td align='right'>" . number_format(($reg_dem_new - $reg_dem_old), 2) . "</td>
                    
                    <td align='right'>" . number_format($reg_rep_old, 2) . "</td>
                    <td align='right'>" . number_format($reg_rep_new, 2) . "</td>
                    <td align='right'>" . number_format(($reg_rep_new - $reg_rep_old), 2) . "</td>

                    <td align='right'>" . get_advantage($reg_dem_old, $reg_rep_old) . "</td>
                    <td align='right'>" . get_advantage($reg_dem_new, $reg_rep_new) . "</td>

                    
                    <td align='right'>" . number_format($prs_dem_old, 2) . "</td>
                    <td align='right'>" . number_format($prs_dem_new, 2) . "</td>
                    <td align='right'>" . number_format(($prs_dem_new - $prs_dem_old), 2) . "</td>
                    
                    <td align='right'>" . number_format($prs_rep_old, 2) . "</td>
                    <td align='right'>" . number_format($prs_rep_new, 2) . "</td>
                    <td align='right'>" . number_format(($prs_rep_new - $prs_rep_old), 2) . "</td>

                    <td align='right'>" . get_advantage_prs($prs_dem_old, $prs_rep_old) . "</td>
                    <td align='right'>" . get_advantage_prs($prs_dem_new, $prs_rep_new) . "</td>

                    <td align='right'>" . number_format($pct_orig) . "</td>
                    <td>" . $other_dists . "</td>

                  </tr>";
    }
    $retval .= "</tbody></table>";

  } 
  return $retval;
}

function populate_draft() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT * FROM ctb_redist_VIZ_1220_sum2";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$type = mb_substr($row['fourcode'], 0, 2);
			$fourcode = $row['fourcode'];
			$retval[$type][$fourcode] = $row;
		}
	}
	return $retval;
}






function get_colors($section) {
  switch($section) {
    case "AD":
      //DARK BLUE - ASSEMBLY
      $head = "#00334d";
      $columns = Array("#ffffff", "#ffffff", "#ffffff","#e6f7ff", "#e6f7ff", "#e6f7ff", "#ffe6e6", "#ffe6e6", "#ffe6e6", "#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ffe6e6", "#ffe6e6", "#ffe6e6", "#ffffff", "#ffffff");
      break;
    case "SD":
      //DARK GREEN - STATE SENATE
      $head = "#133913";
      $columns = Array("#ffffff", "#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ffe6e6", "#ffe6e6", "#ffe6e6", "#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ffe6e6", "#ffe6e6", "#ffe6e6", "#ffffff", "#ffffff");
      break;
    case "CD":
      //DARK PURPLE - CONSTITUTIONAL
      $head = "#330033";
      $columns = Array("#ffffff", "#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ffe6e6", "#ffe6e6", "#ffe6e6", "#ffffff", "#ffffff", "#e6f7ff", "#e6f7ff", "#e6f7ff", "#ffe6e6", "#ffe6e6", "#ffe6e6", "#ffffff", "#ffffff");
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
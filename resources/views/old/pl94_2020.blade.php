@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', '2020 US Census PL-94 Data | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        2020 US Census PL-94 Data
    </h2>

<?php

Util::require_ctb_api();
$endjava = Array();
global $pages, $fed_filed, $endjava_sections, $incumbents;

$places = populate_pl94();
$incumbents = populate_incumbents();


$sections = Array(
    "AD" 		=> "Assembly Districts",
    "SD"       		=> "Senate Districts",
    "CD"         	=> "Congressional Districts",
    "COUNTY"            => "Counties",
    "CITY"       	=> "Cities",
    "CDP"      		=> "Census Designated Places"
    
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
$nav_draw='';
$enddraw='';
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
            <th>$label</th>
            <th>INCUMBENT</th>
            <th class='rightme'>TOTAL</th>   
            <th class='rightme'>WHITE</th>
            <th class='rightme'>%</th>
            <th class='rightme'>LATINO</th>
            <th class='rightme'>%</th>
            <th class='rightme'>BLACK</th>
            <th class='rightme'>%</th>
            <th class='rightme'>ASIAN</th>
            <th class='rightme'>%</th>
            <th class='rightme'>TARGET</th>            
            <th class='rightme'>DIFF</th>            
          </tr>
        </thead>
        $colspan
        <tbody>
    ";

    foreach($arr as $place => $x)  {
      $tot = $x['TOTAL'];
      $wht = $x['WHITE'];
      $blk = $x['BLACK'];
      $lat = $x['LATINO'];
      $asn = $x['ASIAN'];
      $this_place = $x['DISTRICT'];
      $inc = $incumbents[$this_place]['LEGISLATOR'];
      $party = $incumbents[$this_place]['PARTY'];
      if($party == "D") {
        $span_class = 'blueme boldme';
      } elseif($party == "R") {
        $span_class = 'redme boldme';
      } else {
        $span_class = 'boldme';
      }

      $inc_draw = "<span class='$span_class'>" . $inc . "</span>";



      $wht_pct = number_format((($wht / $tot) * 100), 2);
      $blk_pct = number_format((($blk / $tot) * 100), 2);
      $lat_pct = number_format((($lat / $tot) * 100), 2);
      $asn_pct = number_format((($asn / $tot) * 100), 2);
      $diff = $tot - $target;

      $retval .= "<tr>
                    <td>" . $x['DISTRICT'] . "</td>
                    <td>" . $inc_draw . "</td>
                    <td align='right'>" . number_format($tot) . "</td>
                    <td align='right'>" . number_format($wht) . "</td>
                    <td align='right'>" . $wht_pct . "</td>
                    <td align='right'>" . number_format($lat) . "</td>
                    <td align='right'>" . $lat_pct . "</td>
                    <td align='right'>" . number_format($blk) . "</td>
                    <td align='right'>" . $blk_pct . "</td>
                    <td align='right'>" . number_format($asn) . "</td>
                    <td align='right'>" . $asn_pct . "</td>
                    <td align='right'>" . number_format($target) . "</td>
                    <td align='right'>" . number_format($diff) . "</td>
                  </tr>";
    }
    $retval .= "</tbody></table>";

  } else {

    $js = "$(document).ready(function() {
          $('#$thisid').tablesorter({ 
                  headers: {
                  1: {
                      sorter: 'fancyNumber'
                  },
                  2: {
                      sorter: 'fancyNumber'
                  },
                  4: {
                      sorter: 'fancyNumber'
                  },
                  4: {
                      sorter: 'fancyNumber'
                  },
                  6: {
                      sorter: 'fancyNumber'
                  },
                  8: {
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
            <th>$label</th>
            <th class='rightme'>TOTAL</th>   
            <th class='rightme'>WHITE</th>
            <th class='rightme'>%</th>
            <th class='rightme'>LATINO</th>
            <th class='rightme'>%</th>
            <th class='rightme'>BLACK</th>
            <th class='rightme'>%</th>
            <th class='rightme'>ASIAN</th>
            <th class='rightme'>%</th>
          </tr>
        </thead>
        $colspan
        <tbody>
    ";

    foreach($arr as $place => $x)  {
      $tot = $x['TOTAL'];
      $wht = $x['WHITE'];
      $blk = $x['BLACK'];
      $lat = $x['LATINO'];
      $asn = $x['ASIAN'];

      $wht_pct = number_format((($wht / $tot) * 100), 2);
      $blk_pct = number_format((($blk / $tot) * 100), 2);
      $lat_pct = number_format((($lat / $tot) * 100), 2);
      $asn_pct = number_format((($asn / $tot) * 100), 2);
     

      $retval .= "<tr>
                    <td>" . $x['DISTRICT'] . "</td>
                    <td align='right'>" . number_format($tot) . "</td>
                    <td align='right'>" . number_format($wht) . "</td>
                    <td align='right'>" . $wht_pct . "</td>
                    <td align='right'>" . number_format($lat) . "</td>
                    <td align='right'>" . $lat_pct . "</td>
                    <td align='right'>" . number_format($blk) . "</td>
                    <td align='right'>" . $blk_pct . "</td>
                    <td align='right'>" . number_format($asn) . "</td>
                    <td align='right'>" . $asn_pct . "</td>
                 </tr>";
    }
    $retval .= "</tbody></table>";

  }
  return $retval;
}

function populate_pl94() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT * FROM PL94_SUMMARY ORDER BY TYPE, DISTRICT";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$type = $row['TYPE'];
			$place = $row['DISTRICT'];
			$retval[$type][$place] = $row;
		}
	}
	return $retval;
}






function get_colors($section) {
  switch($section) {
    case "AD":
      //DARK BLUE - ASSEMBLY
      $head = "#00334d";
      $columns = Array("#ffffff", "#ffffff", "#f0f0f5", "#e6f7ff", "#e6f7ff", "#cceeff", "#cceeff", "#b3e6ff", "#b3e6ff",  "#99ddff", "#99ddff", "#80d4ff", "#66ccff");
      //$columns = Array("#ffffff", "#e6e6ff", "#ccccff", "#b3b3ff", "#9999ff", "#8080ff", "#6666ff", "#4d4dff", "#f0f0f5");
      break;
    case "SD":
      //DARK GREEN - STATE SENATE
      $head = "#133913";
      $columns = Array("#ffffff", "#ffffff", "#f0f0f5", "#ecf9ec", "#ecf9ec", "#d9f2d9", "#d9f2d9", "#c6ecc6", "#c6ecc6", "#b3e6b3", "#b3e6b3", "#9fdf9f", "#8cd98c");
      break;
    case "CD":
      //DARK PURPLE - CONSTITUTIONAL
      $head = "#330033";
      $columns = Array("#ffffff", "#ffffff", "#f0f0f5", "#ffe6ff", "#ffe6ff", "#ffccff", "#ffccff", "#ffb3ff", "#ffb3ff", "#ff99ff", "#ff99ff", "#ff80ff", "#ff66ff");
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
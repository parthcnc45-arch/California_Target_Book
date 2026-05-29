@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Assembly Visualizations - B - Northern & Central Coast | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        Assembly Visualizations - B - Northern & Central Coast
    </h2>

<?php



Util::require_ctb_api();
$endjava = Array();
global $pages, $fed_filed, $endjava_sections, $incumbents;

use App\User;
$role = Auth::user()->role;


$prefix = "COAST";
$version = "B";
$geo     = "AD";

$sections = Array(
    "SUM"   => "Overview",
    "V01"   => "$prefix 01",
    "V02"   => "$prefix 02",
    "V03"   => "$prefix 03",
    "V04"   => "$prefix 04",
    "V05"   => "$prefix 05",
    "V06"   => "$prefix 06",
    "V07"   => "$prefix 07",
    "V08"   => "$prefix 08",
    "V09"   => "$prefix 09",
    "V10"   => "$prefix 10",
    "V11"   => "$prefix 11",
    "V12"   => "$prefix 12",
    "V13"   => "$prefix 13",
    "V14"   => "$prefix 14",
    "V15"   => "$prefix 15",
    "V16"   => "$prefix 16",
    "V17"   => "$prefix 17",
    "V18"   => "$prefix 18",
    "V19"   => "$prefix 19",
    "V20"   => "$prefix 20",
    "V21"   => "$prefix 21",
    "V22"   => "$prefix 22",

    
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

    if($section != "SUM") {
      $distnum = mb_substr($section, 1, 2);
    } else {
      $distnum = "SUM";
    }

    $analysis_key = "VIZ_" . $geo . $version . "_" . $prefix . "_" . $distnum;
    $analysis = get_analysis($analysis_key);

    if($role === "admin") {

      $add_edit = "<p><a href='http://198.74.49.22/dist_editor.php?yr=2021&id=$analysis_key' target='_blank'>EDIT</a></p>";

    }

    $enddraw .= "<div class='panel justifyme'> <!--BEGIN ASSEMBLY PANEL DIV -->
                     <p style = 'text-align: center !important;'>$analysis_key</p>
                     $add_edit
                     $analysis
                     
                  </div>";

    $enddraw .= "</section>";


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

function get_analysis($analysis_key) {
    $conn = Util::get_ctb_conn();  
    $sql = "SELECT * FROM ctb_analysis WHERE dist = '$analysis_key' ORDER BY date DESC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        return $row['text'];
      }
    }
    return FALSE;
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
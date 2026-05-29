@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Vizualisations v4 | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>


<?php
	switch($type) {
		case "AD":
			$verbose_type = "Assembly"; 
			break;
		case "CD":
			$verbose_type = "Congressional";
			break;
		case "SD":	
			$verbose_type = "State Senate";
			break;
	}

	switch($geo) {
		case "LA":
			$verbose_geo = "Los Angeles County";
			break;	
		case "SOCAL":
			$verbose_geo = "Southern California";
			break;
		case "NORCAL":
			$verbose_geo = "Central / Northern California";
			break;
		case "COAST":
			$verbose_geo = "Northern & Central Coast / Bay Area";
			break;
		
	}
	echo("$verbose_type Visualizations - $verbose_geo");


?>

    </h2>

<?php



Util::require_ctb_api();
$endjava = Array();
global $pages, $fed_filed, $endjava_sections, $incumbents;

use App\User;
$role = Auth::user()->role;

//$geo = $_GET['geo'];
//$type = $_GET['type'];

if(!$type) {
	$type = "CD";
}

if(!$geo) {
	$geo = "LA";
}

switch($type) {
	case "CD":
		switch($geo) {
			case "LA":
				$dists = Array("CD25", "CD27", "CD28", "CD29", "CD30", "CD32", "CD33", "CD34", "CD37", "CD38", "CD40", "CD43", "CD44");
				break;
			case "SOCAL":
				$dists = Array("CD08", "CD31", "CD35", "CD36", "CD39", "CD41", "CD42", "CD45", "CD46", "CD48", "CD49", "CD50", "CD51", "CD52", "CD53");
				break;
			case "NORCAL":
				$dists = Array("CD01", "CD04", "CD06", "CD07", "CD09", "CD10", "CD16", "CD21", "CD22", "CD23");
				break;
			case "COAST":
				$dists = Array("CD02", "CD03", "CD11", "CD12", "CD13", "CD14", "CD15", "CD17", "CD18", "CD19", "CD20", "CD24", "CD26", "CD99");
				break;
		}
	break;
	case "SD":
		switch($geo) {
			case "LA":
				$dists = Array("SD18", "SD22", "SD24", "SD25", "SD26", "SD27", "SD30", "SD32", "SD33", "SD35");
				break;
			case "SOCAL":
				$dists = Array("SD20", "SD21", "SD23", "SD28", "SD29", "SD31", "SD34", "SD36", "SD37", "SD38", "SD39", "SD40");
				break;
			case "NORCAL":
				$dists = Array("SD01", "SD04", "SD05", "SD06", "SD08", "SD12", "SD14", "SD16");
				break;
			case "COAST":
				$dists = Array("SD02", "SD03", "SD07", "SD09", "SD10", "SD11", "SD13", "SD15", "SD17", "SD19");
				break;
		}
		break;
	case "AD":
		switch($geo) {
			case "LA":
				$dists = Array("AD36", "AD38", "AD39", "AD41", "AD43", "AD45", "AD46", "AD48", "AD49", "AD50", "AD51", "AD54", "AD57", "AD58", "AD62", "AD63", "AD64", "AD66", "AD70", "AD99");
				break;
			case "SOCAL":
				$dists = Array("AD33", "AD40", "AD42", "AD47", "AD52", "AD55", "AD56", "AD60", "AD61", "AD65", "AD67", "AD68", "AD69", "AD71", "AD72", "AD73", "AD74", "AD75", "AD77", "AD78", "AD79", "AD80", "AD98" );
				break;
			case "NORCAL":
				$dists = Array("AD01", "AD06", "AD07", "AD08", "AD09", "AD12", "AD13", "AD21", "AD23", "AD26", "AD31", "AD32", "AD34", "AD96", "AD97");
				break;
			case "COAST":
				$dists = Array("AD02", "AD04", "AD10", "AD11", "AD14", "AD15", "AD16", "AD17", "AD18", "AD19", "AD20", "AD22", "AD24", "AD25", "AD27", "AD29", "AD30", "AD35", "AD37", "AD44", "AD94", "AD95");
				break;
				
		}
}

$sections = [];
$sections['SUM'] = "Overview";

foreach($dists as $dist) {

	$sections[$dist] = $dist;

}



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
      $distnum = mb_substr($section, 2, 2);
    } else {
      $distnum = "SUM";
    }

    $analysis_key = "VIZ4_" . $type . "_" . $geo . "_" . $distnum;
    $map_url = '/uploaded/viz21d/' . $verbose . '_Map.jpg';
    $res_url = '/uploaded/viz21d/' . $verbose . '_Res.jpg';

    


    $analysis = get_analysis($analysis_key);

    if($role === "admin") {

      $add_edit = "<p><a href='http://198.74.49.22/dist_editor.php?yr=2021&id=$analysis_key' target='_blank'>EDIT</a></p>";

    }

    if($distnum == "SUM") {

    	$enddraw .= "<div class='panel justifyme'> <!--BEGIN ASSEMBLY PANEL DIV -->
                     <p style = 'text-align: center !important;'>$analysis_key</p>
                     $add_edit
                     $analysis
                   
                  </div>";


    } else {
	$this_fourcode = $type . $distnum;
    	$enddraw .= "<div class='panel justifyme'> <!--BEGIN ASSEMBLY PANEL DIV -->
                     <p style = 'text-align: center !important;'>$analysis_key</p>
                     $add_edit
		     <p align='center'><img src='$map_url' width='800px'></p>
		     <p align='center'><a href='$res_url' target='_blank'><img src='$res_url' width='800px'></a></p>
		     <p align='center'><a href='/book/block_report/$this_fourcode' target='_blank'>View Full Report</a></p>
                     $analysis
                     
                  </div>";


    }


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
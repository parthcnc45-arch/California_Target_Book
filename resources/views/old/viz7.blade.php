@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Draft Maps v1 | California Target Book')


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
	echo("$verbose_type Draft Maps - $verbose_geo");


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
				$dists = Array("CD25", "CD27", "CD28", "CD29", "CD30", "CD32", "CD33", "CD34", "CD37", "CD38", "CD43", "CD44", "CD47");
				break;
			case "SOCAL":
				$dists = Array("CD08", "CD31", "CD35", "CD36", "CD39", "CD41", "CD42", "CD45", "CD46", "CD48", "CD49", "CD50", "CD51", "CD52", "CD98");
				break;
			case "NORCAL":
				$dists = Array("CD01", "CD04", "CD06", "CD07", "CD09", "CD10", "CD16", "CD21", "CD22", "CD23");
				break;
			case "COAST":
				$dists = Array("CD02", "CD05", "CD11", "CD12", "CD13", "CD14", "CD15", "CD17", "CD18", "CD19", "CD20", "CD24", "CD26", "CD99");
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
				$dists = Array("AD39", "AD40", "AD41", "AD43", "AD45", "AD46", "AD48", "AD49", "AD51", "AD52", "AD54", "AD55", "AD56", "AD57", "AD61", "AD62", "AD64", "AD65", "AD66", "AD69");
				break;
			case "SOCAL":
				$dists = Array("AD34", "AD36", "AD44", "AD47", "AD50", "AD53", "AD58", "AD59", "AD60", "AD63", "AD67", "AD68", "AD70", "AD71", "AD72", "AD73", "AD74", "AD75", "AD76", "AD77", "AD78", "AD79", "AD80");
				break;
			case "NORCAL":
				$dists = Array("AD01", "AD03", "AD04", "AD05", "AD06", "AD07", "AD08", "AD09", "AD10", "AD13", "AD22", "AD27", "AD31", "AD32", "AD33", "AD35");
				break;
			case "COAST":
				$dists = Array("AD02", "AD11", "AD12", "AD14", "AD15", "AD16", "AD17", "AD18", "AD19", "AD20", "AD21", "AD23", "AD24", "AD25", "AD26", "AD28", "AD29", "AD30", "AD37", "AD38", "AD42");
				break;
				
		}
}

$sections = [];
$sections['SUM'] = "Overview";
$old_fourcodes = get_fourcode_index();

foreach($dists as $dist) {

	$sections[$dist] = $dist;

}

$cvap = get_cvap($type, $dists);
$pres = get_pres($type);
$reg  = get_reg();


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

    $analysis_key = "VIZ7_" . $type . "_" . $geo . "_" . $distnum;
    $map_url = '/uploaded/viz21f/' . $verbose . '_Map.jpg';
    $res_url = '/uploaded/viz21f/' . $verbose . '_Res.jpg';
    $dif_url = '/uploaded/viz21f/' . $verbose . "_Diff.jpg";

    


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
	$old_fourcode = $old_fourcodes['new'][$this_fourcode];
	if(isset($cvap[$this_fourcode])) {
		$cvap_add = "<div style='max-width: 800px;' align='center'><p align='center'>" . $cvap[$this_fourcode] . "</p></div>";
	} else {
		$cvap_add = '';
	}
	//$cvap_add = '';

	if(isset($reg[$this_fourcode])) {
		$prev_span = "<h5 align='center' style=\"font-family: 'Lato';\" >Existing district ($old_fourcode) has a " . $reg[$old_fourcode]['ADV'] . " registration advantage and voted " . $pres[$old_fourcode]['ADV'] . " in the 2020 election.</h5>";
		if($role != "adminnn") {
		$prev_span .= "<h6>DEM: " . number_format((($reg[$old_fourcode]['DEM'] / $reg[$old_fourcode]['TOT']) * 100), 2) . ", 
			       REP: " . number_format((($reg[$old_fourcode]['REP'] / $reg[$old_fourcode]['TOT']) * 100), 2) . "  |  
			       Biden: " . number_format((($pres[$old_fourcode]['PRSDEM01'] / $pres[$old_fourcode]['TOT']) * 100), 2) . ",
			       Trump: " . number_format((($pres[$old_fourcode]['PRSREP01'] / $pres[$old_fourcode]['TOT']) * 100), 2) . "</h6>";
		}

	} else {
		$prev_span = '';
	}


	if($type == "CD" || $type == "SD" || $type == "AD") {
		$diff_add = "<hr /><p align='center'><h2 align='center'>Changes From 2010 Lines to New Draft Lines</h2><a href='$dif_url' target='_blank'><img src='$dif_url' width='800px'></a></p>";
	} else {
		$diff_add = '';
	}
	$diff_add = '';
    	$enddraw .= "<div class='panel justifyme'> <!--BEGIN ASSEMBLY PANEL DIV -->
		     $prev_span
                     <p style = 'text-align: center !important;'>$analysis_key</p>
                     $add_edit
		     $cvap_add
		     <!--<p align='center'><img src='$map_url' width='800px'></p>-->
		     <p align='center'><span style='font-weight: bold;'><u>CLICK IMAGE TO EXPAND TO FULL SIZE</u></span><br><a href='$res_url' target='_blank'><img src='$res_url' width='800px'></a></p>
		     <p align='center'><a href='/book/block_report_v1208/$this_fourcode' target='_blank'>View Full Report</a></p>
		     $diff_add
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

function get_cvap($type, $dists) {
	$conn = Util::get_ctb_conn();
	$jur_name = "VIZ7_" . $type;
	$old_fourcodes = get_fourcode_index();
	$sql = "SELECT district, name FROM ctb_ca_city_shp WHERE jur_name = '$jur_name'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$map_nm = mb_substr($row['name'], 0, 12);
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
	
	$sql = "SELECT district, name, population, cvap_19, hisp, ind, black, asian, white, target, deviation FROM ctb_redist_cvap_1208";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$map_nm = $row['district'];
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
			"Indigenous" => "ind"
		);

	foreach($dists as $fourcode) {
		$old_fourcode = $old_fourcodes['new'][$fourcode];
		$x = $cvap_data[$fourcode];
		$y = $cvap_11[$old_fourcode];
		$z = $cvap_19[$old_fourcode];

		$map_nm = $d['name'];
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
		foreach($tmp as $group => $pct) {
			if($i < 1) {
				$first_grp = $group;
				if($group != "White") {
					//GOT MINORITY DISTRICT
					if($pct >= 50) {
						//MAJORITY-MINORITY DISTRICT
						$dscr = "<span class='boldme'>VRA DISTRICT</span><br>Majority $group";
					} else {
						$dscr = "Plurality $group";
					}
				}
			} else {
				if($group == "Black" && $pct >= 20) {
					$dscr .= "<br>Substantial Black Population";
				}
			}
			$this_key = $eth_keys[$group];
			$this_raw = $x[$this_key];
			$this_11 = $tmp_11[$group];
			$this_19 = $tmp_19[$group];

			$eth_body .= "<tr>
								<td class='boldme'>$group</td>
								<td align='right' class='boldme'>" . number_format($this_raw) . "</td>
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
				</table><h6 align='center' class='itcme'>The \"% '11\" column indicates the CVAP of the existing $fourcode at the time the lines were drawn in 2011, and the \"% '19\" column indicates the CVAP of the existing $fourcode as of the most recent American Community Survey</h6>";

	}
	return $cvap_table;
}


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

function get_fourcode_index() {
	$conn = Util::get_ctb_conn();  
	$sql = "SELECT fourcode, old_fourcode FROM ctb_redist_VIZ_1208_sum2";
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

.itcme {
	font-style: italic;
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
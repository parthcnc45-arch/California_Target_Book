
@php ($book_side_nav_active = 'candidates')
@extends('layouts.book')

@section('title', '2022 Primary Ballot (All Races) | California Target Book')

@section('content')

<?php

global $extends;

$fourcodes = populate_fourcodes();

$sections = Array(
    "ASSEMBLY"	 	      => "person_outline",
    "STATE_SENATE"		      => "person_outline",
    "US_HOUSE"		  => "person_outline",
    "US_SENATE"	  => "person_outline",
    "STATEWIDE" 	  => "person_outline",
    "BOE" => "person_outline",
);


$e_dists = Array("CD03", "CD13", "CD15", "CD37", "CD42",
		 "AD05", "AD10", "AD11", "AD12", "AD17", "AD20", "AD21", "AD22", "AD27", "AD28", "AD30", "AD35", "AD37",
		 "AD39", "AD47", "AD51", "AD50", "AD61", "AD63", "AD64", "AD68", "AD69", "AD70", "AD71", "AD72", "AD80",
		 "SD04", "SD06", "SD08", "SD10", "SD18", "SD20", "SD28", "SD32", "SD36", "SD38",
		 "BOE3"
	
	);

foreach($e_dists as $dist) {
	$extends[$dist] = " (Filing Extended to 3/16)";
}


foreach($fourcodes as $fourcode) {
	$x = get_ballot($fourcode);
	$y = get_filed($fourcode);
	if(substr($fourcode, -1) == "+") {
		$display_fourcode = substr($fourcode, 0, -1);
		$add_special = " - Special Election Primary";
	} else {
		$display_fourcode = $fourcode;
		$add_special = '';
	}

	$div = "<hr width='100vw;' />
			<div style='display: inline-block; clear: both; margin-left: auto; margin-right: auto; margin-top: 20px; padding: 20px;' align='center'>
				<h2 align='center'><a href='/book/new/$display_fourcode' target='_blank'>" . $display_fourcode . $add_special . "</a></h2>
				<div>
					$y
				</div>

				<div>
					$x
				</div>
			</div>";

	if($fourcode == ".SN2") {
		$divs['US_SENATE'] .= $div;
	} elseif(mb_substr($fourcode, 0, 2) == "CD") {
		$divs['US_HOUSE'] .= $div;
	} elseif(mb_substr($fourcode, 0, 2) == "SD") {
		$divs['STATE_SENATE'].= $div;
	} elseif(mb_substr($fourcode, 0, 2) == "AD") {
		$divs['ASSEMBLY'] .= $div;
	} elseif(mb_substr($fourcode, 0, 3) == "BOE") {
		$divs['BOE'] .= $div;
	} else {
		$divs['STATEWIDE'] .= $div;
	}


}

echo("<div class='container-fluid text-center'>
			 <h2>California June 7th, 2022 Primary - Candidate Filing Status</h2>
			 
			     ");

$count = 0;
foreach($sections as $section => $icon) {

    $count++;

    if($count == 1) {
        $active_class = 'active';
    } else {
        $active_class = '';
    }

    $nav_draw .= "<li class='$active_class'>
                    <a href='#p$section' role='tab' data-toggle='tab' class='header_icon'>
                        <i class='material-icons header_icon'>$icon</i>
                        $section
                    </a>
                  </li>";

    $enddraw .= "<section id='p$section' class='$active_class'> <!--BEGIN $section SECTION DIV-->";
    $enddraw .= "<div class='prop_div' align='center'> <!--BEGIN $section PROP DIV--> ";
    $enddraw .= "<h2>$section</h2>";

    $enddraw .= "<div class='panel justifyme'> <!--BEGIN $section PANEL DIV -->
                    <p style = 'text-align: justify !important;'>
                    $divs[$section];
                    </p>
                  </div> <!--END $section PANEL DIV-->
                </div> <!--END $section PROP DIV--> 
                </section> <!--END $section SECTION -->";



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


function populate_fourcodes() {
	$stmt = Util::get_ctb_pdo()->prepare("
			SELECT fourcode FROM ctb_p22_filing_status GROUP BY fourcode ORDER BY fourcode
		");
	$stmt->execute();
	$retval = Array();
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($retval, $row['fourcode']);
	}
	return $retval;
}

function get_filed($fourcode)
{

	global $extends;
    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM ctb_p22_filing_status WHERE fourcode = :id ORDER BY party, naml
    ");
    $stmt->execute(['id' => $fourcode]);
    $abort = TRUE;
    $arr = Array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($arr, $row);
        $abort = FALSE;
    }

    $table_head = "<h3 align='center'>Filing Log" . $extends[$fourcode] . "</h3>
    				<div class='table table-striped table-responsive' align='center' style='display: inline-block;'>
                    <p align='center'>
                    <table class='table table-striped table-responsive'  style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>PARTY</th>
                                <th>SIL ISSUE</th>
                                <th>SIL FILE</th>
                                <th>NOM ISSUE</th>
                                <th>NOM FILE</th>
                                <th>COUNTY</th>
                            </tr>
                        </thead>
                        <tbody>";

    foreach($arr as $x) {
        if(isset($x['namm'])) {
            $name = $x['namf'] . " " . $x['namm'] . " " . $x['naml'];
        } else {
            $name = $x['namf'] . " " . $x['naml'];
        }

				switch($x['party']) {
					case "R":
						$class = 'redme boldme';
						break;
					case "D":
						$class = 'blueme boldme';
						break;
					case "Grn":
						$class = 'greenme boldme';
						break;
					default:
						$class = '';
				}


        $county_url = get_county_registrar_url($x['county_filed']);
        $county_lnk = "<a href='$county_url' target='_blank'>" . $x['county_filed'] . "</a>";

        $table_body .= "<tr class='$class'>
                            <td>" . $name . "</td>
                            <td>" . $x['party'] . "</td>
                            <td>" . $x['sil_issue'] . "</td>
                            <td>" . $x['sil_file'] . "</td>
                            <td>" . $x['nom_issue'] . "</td>
                            <td>" . $x['nom_file'] . "</td>
                            <td>$county_lnk</td>
                        </tr>";
    }

    $retval = $table_head . $table_body . "</tbody></table></p></div>";


    if($abort) {
        return FALSE;
    } else {
        return $retval;
    }

}

function get_ballot($fourcode) {
	//return FALSE;
	$stmt = Util::get_ctb_pdo()->prepare("
			SELECT * FROM ctb_e22_ballots WHERE fourcode = :id ORDER BY elec_date, party, naml
		");
		$stmt->execute(['id' => $fourcode]);
		$abort = TRUE;
		$arr = Array();
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$key = $row['elec_type'];

			if(!$arr[$key]) {
				$arr[$key] = Array();
			}

			if($row['namm']) {
				$tmp['cand_nm'] = $row['namf'] . " " . $row['namm'] . " " . $row['naml'];
			} else {

				$tmp['cand_nm'] = $row['namf'] . " " . $row['naml'];
			}

			$tmp['website'] = $row['website'];
			$tmp['party'] = $row['party'];
			$tmp['cand_id'] = $row['cand_id'];
			$tmp['cmte_id'] = $row['cmte_id'];
			$tmp['ballot_dscr'] = $row['ballot_dscr'];
			$tmp['elec_date'] = $row['elec_date'];
			array_push($arr[$key], $tmp);
			$abort = FALSE;
		}





		$table_contain_head = "

								<div class='table table-striped table-responsive' align='center' style='display: inline-block;'>
									<p align='center'>";

		foreach($arr as $e => $value) {
			switch(mb_substr($e, 0, 1)) {
				case "s":
					$long_type = "Special Election Primary";
					break;
				case "r":
					$long_type = "Special Election Runoff";
					break;
				case "p":
					$long_type = "Primary Election";
					break;
				case "g":
					$long_type = "General Election";
					break;
				default:
					$long_type = "Unknown";
					break;
			}

			foreach($arr[$e] as $cand) {

				//echo("<br>CAND DUMP<br>");
				//var_dump($cand);

				switch($cand['party']) {
					case "R":
						$class = 'redme boldme';
						break;
					case "D":
						$class = 'blueme boldme';
						break;
					case "Grn":
						$class = 'greenme boldme';
						break;
					default:
						$class = '';
				}

				if($cand['website']) {
				     $name = "<a href='http://" . $cand['website'] . "' target='_blank'>" . $cand['cand_nm'] . "</a>";
				} else {
				     $name = $cand['cand_nm'];
				}


				$this_election = date('F j, Y', strtotime($cand['elec_date']));
				$table_body[$e] .= "<tr class='$class'>
										<td>" . $name . "</td>
										<td>" . $cand['party'] . "</td>
										<td>" . $cand['ballot_dscr'] . "</td>
									</tr>";

			}

			$table_head[$e] = "<h3>$long_type - $this_election</h3>
								<p></p>
								<p></p>
								<table class='table table-striped' v-ctb-table style='margin-left: auto !important; margin-right: auto !important; margin-top: 10px;' align='center'>
									<thead>
										<tr>
											<th>CANDIDATE NAME</th>
											<th>PARTY</th>
											<th>BALLOT DESCRIPTION</th>
										</tr>
									</thead>
									<tbody>";



			$table_end[$e] = "</tbody></table><p></p>";
		}

		$retval = $table_contain_head;
		foreach($table_head as $key => $value) {
			$retval .= $table_head[$key] . $table_body[$key] . $table_end[$e];

		}

		$retval .= "</p></div>";

		if($abort) {
			return FALSE;
		} else {
			return $retval;
		}

}

function get_county_registrar_url($county_name) {

    $stmt = Util::get_ctb_pdo()->prepare("
      SELECT * FROM ctb_e22_county_watch WHERE county_nm LIKE :id
    ");
    $stmt->execute(['id' => $county_name]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $retval = $row['url'];
    }
    return $retval;
}

?>

@endsection

@section('styles')

<style>

.greenme {
   color: green;
}
</style>

@endsection
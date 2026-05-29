@extends('layouts.book')
@php ($book_side_nav_active = 'redist')

@section('title', 'Vizualisations v3 | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>

	Election Report - $id
	
    </h2>

<?php

global $master_conn, $reg_index, $headers_index, $prop_index, $races_index, $method, $map_iframe, $type, $incumbents;



Util::require_ctb_api();
$fourcode = $id;


if($fourcode) {
	$type = mb_substr($fourcode, 0, 2);
	$dist = mb_substr($fourcode, 2, 2);
	//echo("\nLooking Up $type, $dist");
	$map = lookup_map($type, $dist);
	$first_three = "V" . $type . "_";
	$last_four = "_1102";
	//echo("\nGot $map.");
	if($type == "AD") {
		$city = "VIZ4_" . $type;
		$last_four = "_1107";
	} else {
		$city = "VIZ3_" . $type;
	}
	$map = str_replace($first_three, "", $map);
	$map = str_replace($last_four, "", $map);

	$cd = $dist;
	
} else {
	$type = strtoupper($_GET['type']);
	$map = strtoupper($_GET['map']);
	$x = dist_lookup($type, $map);
	$city = $x['city'];
	$cd = $x['cd'];

}

if(!$method) {
	$method = 2;
}


if(!$type) {
	$type = "SD";
	$map = "NORCA";
}




$master_fourcode = $type . checkaddzero($cd);

if($fourcode) {
	$fourcode_draw = $fourcode;
} else {
	$fourcode_draw = $master_fourcode;
}


$mapdiv = "<iframe src='https://californiatargetbook.com/ctb-legacy/draw_viz.php?city=$city&cd=$cd' width='810px' height='610px' align='center'></iframe>";

$map_iframe = "<div width='100%' align='center'>
					<h1 align='center'>$fourcode_draw</h1>
					<div align='center'>
						$mapdiv
					</div>
				</div>";

//echo("<br>$city - $cd<br>");
$incumbents = locate_incumbents($city, $cd);



$blocks = get_blocks($type, $map);
echo("<br>Retrieved " . sizeof($blocks) . " Blocks for V" . $type . "_1102_" . $map);
//echo("<br>Retrieving Results...");

get_prop_index();

$arr = get_results($blocks);


function locate_incumbents($city, $cd) {
	global $master_conn;
	$conn = Util::get_ctb_conn();  
	$sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM ctb_ca_city_shp WHERE jur_name = '$city' && district = $cd";
	//echo("\n$sql");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$z = $row['SHAPE'];
		}
	}

	$sql = "SELECT id, FOURCODE, naml, namf, party, is_inc FROM ctb_e22_cand_detail WHERE ST_Intersects( SHAPE, ST_GeomFromText ( '$z', 1) )  ORDER BY naml";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$id = $row['id'];
			if($row['is_inc']) {
				$retval[1][$id] = $row;
			} else {
				$retval[0][$id] = $row;
			}
		}
	}
	//echo("\n$sql");
	//var_dump($retval);
	return $retval;
}

function get_blocks($type, $map) {
	global $master_conn;
	$conn = Util::get_ctb_conn();  
	if($type == "AD") {
		$table = "ctb_redist_V" . $type . "_1107";	
		$sql = "SELECT BLOCK20 FROM $table WHERE MAPNAME = '$map' ORDER BY BLOCK20";
	} else {
		$table = "ctb_redist_V" . $type . "_1102";
		$sql = "SELECT BLOCK20 FROM $table WHERE MAPNAME LIKE '$map%' ORDER BY BLOCK20";
	}
	//echo("\n$sql\n");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$block = $row['BLOCK20'];
			$retval[$block] = TRUE;
		}
	}
	return $retval;
}

function get_results($blocks) {
	global $master_conn, $reg_index, $headers_index, $prop_index, $races_index, $method, $map_iframe, $type, $incumbents;
	//$conn = Util::get_ctb_conn();  
	//echo("\nBuilding Query...");

	$servername = "127.0.0.1";
	$username = "nufec";
	$password = "Mrw0mbat8";
	$dbname = "ctb";

	$conn = new mysqli($servername, $username, $password, $dbname);

	$min_block = '';
	$max_block = '';

	$inc_table = "<table class='table'>
							<tbody>";
	foreach($incumbents[1] as $id => $x) {
		$inc_table .= "<tr>
							<td>" . $x['FOURCODE'] . "</td>
							<td>" . $x['namf'] . " " . $x['naml'] . "</td>
							<td>" . $x['party'] . "</td>
						</tr>";
	}
	$inc_table .= "</tbody></table>";

	$non_inc_table = "<table class='table'>
							<tbody>";
	foreach($incumbents[0] as $id => $x) {
		$non_inc_table .= "<tr>
							<td>" . $x['FOURCODE'] . "</td>
							<td>" . $x['namf'] . " " . $x['naml'] . "</td>
							<td>" . $x['party'] . "</td>
						</tr>";	
	}
	$non_inc_table .= "</tbody></table>";	

	if($method == 1) {
		foreach($blocks as $block => $ignore) {
			$this_block_int = (int)$block;
			$this_block = $block;

			if(!$first_block) {
				$first_block = $this_block;
			}

			if(!$last_block) {
				//FIRST RUN, DO NOTHING
			} else {
				if(($this_block_int - 1) == $last_block_int) {
					//DO NOTHING
					$range++;
				} else {
					//NEW RANGE STARTED
					if($range > 0) {
						$block_query .= " (BLOCK20 >= '$first_block' && BLOCK20 <= '$last_block') ||";
					} else {
						$block_query .= " (BLOCK20 = '$first_block') ||";
					}
					$first_block = '';
					$range = 0;
				}
			}

			$last_block_int = $this_block_int;
			$last_block = $this_block;
		}

	} elseif($method == 2) {
		foreach($blocks as $block => $ignore) {
			$block_int = (int)$block;
			$block_arr[$block_int] = $block;
		}
		ksort($block_arr);
		foreach($block_arr as $block_int => $block) {
			if(!$first_block) {
				$first_block = $block;
			}

			if(!$last_block) {
				//FIRST RUN, DO NOTHING
			} else {
				if($last_int == ($block_int - 1)) {
					//STILL GOOD
					$range++;
				} else {
					//NEW RANGE STARTED
					if($range > 1) {
						$block_query .= " (BLOCK20 >= '$first_block' && BLOCK20 <= '$last_block') ||";	
					} elseif ($first_block == $last_block) {
						$block_query .= " (BLOCK20 = '$last_block') ||";
					}
					$range = 0;
					$first_block = $block;
				}
			}

			$last_int = $block_int;
			$last_block = $block;
		}

	} else {
		foreach($blocks as $block => $ignore) {
			$block_query .= " BLOCK20 = '$block' ||";
		}

	}





	$block_query = substr($block_query, 0, -2);

	$elections = Array("g20", "g18", "g16", "g14", "g12", "g10", "g08");
	$elections = Array("g20", "g18", "g16");

	foreach($elections as $election) {
		$query = '';
		$headers_index = [];
		get_race_headers($election); //POPULATE HEADERS, SAVE RACE KEY AND CANDIDATE INFO IN $races_index, SAVE TABLE HEADER ROWS IN $headers_index
		//echo("<br>HEADERS INDEX AFTER RUN<br>");
		//var_dump($headers_index);
		$race_query = '';
		foreach($headers_index as $column => $ignore) {
			if(!$column) {
				continue;
			}
			if($election == "g08" || $election == "g10") {
				if($election == "g10" && $column == "CNGIND") {
					continue;
				} elseif($election == "g10" && mb_substr($column, 0, 3) == "SPI") {
					$race_query .= " SUM($column) AS $column, ";	
				}elseif(mb_substr($column, 0, 3) == "PR_") {
					$race_query .= " SUM($column) AS $column, ";	
				} else {
					$race_query .= " SUM($column" . "01) AS $column, ";
				}
			} else {
				$race_query .= " SUM($column) AS $column, ";
			}
		}
		$race_query = substr($race_query, 0, -2);
		$race_query = str_replace("ASS", "ASM", $race_query);
		//echo("<br>$race_query<br>");

		$v_types = Array("r", "", "p", "m", "a");
		$parties = Array("TOTREG_R", "DEM", "REP", "DCL", "LIB", "GRN", "AIP", "PAF");
		$eth_parties = Array("DEM", "REP", "DCL", "OTH");
		$eth_groups = Array("HISP", "KOR", "JPN", "CHI", "IND", "VIET", "FIL");

		$eth_query = '';

		foreach($v_types as $prefix) {
			foreach($eth_groups as $eth_group) {
				foreach($eth_parties as $eth_party) {
					$key = $prefix . $eth_group . "_" . $eth_party;
					$eth_query .= " SUM($key) AS $key, ";
				}
			}			
		}
		$eth_query = substr($eth_query, 0, -2);

		$party_query = '';
		foreach($v_types as $prefix) {
			foreach($parties as $party) {
				$key = $prefix . $party;
				$party_query .= " SUM($key) AS $key, ";
			}
		}
		$party_query = substr($party_query, 0, -2);




		//$block_query = 'ASM_DIST = 1';

		/*
		$sql = "SELECT COUNTY20, PLACE20, ASM_DIST, CNG_DIST, SEN_DIST,
					$race_query,
					$eth_query,
					$party_query
				FROM ctb2016_g20_c
				WHERE ($block_query)
				GROUP BY COUNTY20, PLACE20, ASM_DIST, CNG_DIST, SEN_DIST";
		*/

		$sql = "SELECT COUNTY20, PLACE20, ASM_DIST, CNG_DIST, SEN_DIST,
				$race_query,
				$party_query
				FROM ctb2016_" . $election . "_c" . "
				WHERE ($block_query)
				GROUP BY ASM_DIST, CNG_DIST, SEN_DIST";
		
		echo("<br>$election Query Ready. SQL string is " . strlen($sql) . " characters. Executing.<br><br>");
		//echo("<br>$sql<br>");

		$skip = Array(
			"COUNTY20" => TRUE,
			"PLACE20"  => TRUE,
			"ASM_DIST" => TRUE,
			"CNG_DIST" => TRUE,
			"SEN_DIST" => TRUE,
			"TYPE" => TRUE,
			"rTYPE" => TRUE,
			"mTYPE" => TRUE,
			"pTYPE" => TRUE,
			"aTYPE" => TRUE
			);
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$addist = $row['ASM_DIST'];
				$cddist = $row['CNG_DIST'];
				$sddist = $row['SEN_DIST'];
				$place  = $row['PLACE20'];
				$county = $row['COUNTY20'];

				foreach($row as $k => $v) {
					if($skip[$k]) {
						$e_results[$election][$k] = $v;
						continue;
					} else {
						$e_results[$election][$k] += $v;
						$d_results[$election]['ASM'][$addist][$k] += $v;
						$d_results[$election]['CNG'][$cddist][$k] += $v;
						$d_results[$election]['SEN'][$sddist][$k] += $v;
					}
				}

				

			}
		}
		//echo("<br>Query Completed. Retrieving " . sizeof($places) . " Place Names.");


	}
	//var_dump($e_results);
	//return FALSE;

	$sql = "SELECT COUNTY20, PLACE20, ASM_DIST, CNG_DIST, SEN_DIST,
			$party_query
			FROM ctb2016_g20_c
			WHERE ($block_query)
			GROUP BY ASM_DIST, CNG_DIST, SEN_DIST, COUNTY20, PLACE20";
	
	//echo("<br>$election Query Ready. SQL string is " . strlen($sql) . " characters. Executing.<br><br>");
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$addist = $row['ASM_DIST'];
			$cddist = $row['CNG_DIST'];
			$sddist = $row['SEN_DIST'];
			$place  = $row['PLACE20'];
			$county = $row['COUNTY20'];

			foreach($parties as $this_party) {
				$this_key = "r" . $this_party;
				$now_reg[$this_party] += $row[$this_key];
			}

			$retval['AD'][$addist][$county][$place] = $row;
			$retval['CD'][$cddist][$county][$place] = $row;
			$retval['SD'][$sddist][$county][$place] = $row;
			$retval['CO'][$county][$county][$place] = $row;
			$retval['CITY'][$county][$place] = $row;
			$places[$place] = TRUE;

			$reg_index['AD'][$addist]['rTOTREG_R'] += $row['rTOTREG_R'];
			$reg_index['AD'][$addist]['rREP'] += $row['rREP'];
			$reg_index['AD'][$addist]['rDEM'] += $row['rDEM'];

			$reg_index['CD'][$cddist]['rTOTREG_R'] += $row['rTOTREG_R'];
			$reg_index['CD'][$cddist]['rREP'] += $row['rREP'];
			$reg_index['CD'][$cddist]['rDEM'] += $row['rDEM'];

			$reg_index['SD'][$sddist]['rTOTREG_R'] += $row['rTOTREG_R'];
			$reg_index['SD'][$sddist]['rREP'] += $row['rREP'];
			$reg_index['SD'][$sddist]['rDEM'] += $row['rDEM'];



			$reg_index['CO'][$county]['rTOTREG_R'] += $row['rTOTREG_R'];
			$reg_index['CO'][$county]['rREP'] += $row['rREP'];
			$reg_index['CO'][$county]['rDEM'] += $row['rDEM'];

			$reg_index['CITY'][$county][$place]['rTOTREG_R'] += $row['rTOTREG_R'];
			$reg_index['CITY'][$county][$place]['rREP'] += $row['rREP'];
			$reg_index['CITY'][$county][$place]['rDEM'] += $row['rDEM'];				
			$reg_index['CITY'][$county][$place]['COUNTY'] = $county;

			$reg_index['TOTAL']['rTOTREG_R'] += $row['rTOTREG_R'];
			$reg_index['TOTAL']['rREP'] += $row['rREP'];
			$reg_index['TOTAL']['rDEM'] += $row['rDEM'];
			$reg_index['TOTAL']['rDCL'] += $row['rDCL'];
		}
	}

	if(!$city_names) {
		$city_names = get_cities($places);
	}

	$county_size = sizeof($reg_index['CO']);

	if($county_size < 5) {
		$panel_size = 'col-lg-3';
		$font_size  = '1.5em;';
	} else {
		$panel_size = 'col-lg-2';
		$font_size = '1em;';
	}

	uasort($reg_index['CO'], "totreg_sort");
	$county_panel = "<div class='row'>
						<div class='col-lg-12'>";
	$pc = 0;						
	foreach($reg_index['CO'] as $county => $places) {
		if($pc > 5) {
			$county_panel .= "</div></div>
							  <div class='row' align='center'>
							  <div class='col-lg-12' align='center'>";
			$pc = 0;
		}
		$county_panel .= "<div class='$panel_size'>";
		
		if($reg_index['CO'][$county]['rREP'] > $reg_index['CO'][$county]['rDEM']) {
			$p_class = "repdiv";
		} elseif($reg_index['CO'][$county]['rDEM'] > $reg_index['CO'][$county]['rREP']) {
			$p_class = "demdiv";
		}
		$adjusted_county = ($county + 1) / 2;
		$adv = get_advantage_raw($reg_index['CO'][$county]['rDEM'], $reg_index['CO'][$county]['rREP'], $reg_index['CO'][$county]['rTOTREG_R']);
		$county_nm = getcountyname($adjusted_county);		

		$total_reg = $reg_index['TOTAL']['rTOTREG_R'];
		$county_reg = $reg_index['CO'][$county]['rTOTREG_R'];

		$county_panel .= "<h3 align='center'>$county_nm - " . number_format($county_reg) . " - $adv - <em><b>" . number_format((($county_reg / $total_reg) * 100), 2) . "%</b></em></h3>";


		$county_panel .= "<p class='$p_class'></p>";
		uasort($reg_index['CITY'][$county], "totreg_sort");
		$county_panel .= "<table style='font-size: $font_size'>
							<thead>
								<tr>
									<th>PLACE</th>
									<th>REGISTERED</th>
									<th>ADV</th>
									<th>% OF DIST</th>
								</tr>
							</thead>
							<tbody>";
		foreach($reg_index['CITY'][$county] as $place => $x) {
			$city_nm = $city_names[$place];
			if(!$x['rTOTREG_R']) {
				continue;
			}
			if(!$city_nm) {
				$city_nm = $place;
			}				
			if($city_nm == "9901") {
				$city_nm = "Unincorporated";
			}
			$adv = get_advantage_raw($x['rDEM'], $x['rREP'], $x['rTOTREG_R']);
			$county_panel .= "<tr>
									<td>" . mb_substr($city_nm, 0, 24) . "</td>
									<td align='right'>" . number_format($x['rTOTREG_R']) . "</td>
									<td>$adv</td>
									<td align='right' class='boldme'>" . number_format((($x['rTOTREG_R'] / $reg_index['TOTAL']['rTOTREG_R']) * 100), 2) . "%</td>
							</tr>";

		}
		$county_panel .= "</tbody></table></div>";
		$pc++;

	}

	$p_arr = Array(
		"REP"	=> "Republican",
		"DEM"	=> "Democratic",
		"DCL"	=> "No Party Preference",
		"PAF"	=> "Peace & Freedom",
		"AIP"	=> "American Independent",
		"LIB"	=> "Libertarian",
		"GRN"	=> "Green",
		"TOTREG_R" => "TOTAL REGISTERED"
		);

	arsort($now_reg);
	$tot_reg = $reg_index['TOTAL']['rTOTREG_R'];
	$this_adv = get_advantage_raw($now_reg['DEM'], $now_reg['REP'], $tot_reg);
	$big_table_left = "<table class='big_left'>
							<tbody>";
	foreach($now_reg as $this_party => $this_reg) {
		$verbose = $p_arr[$this_party];
		$this_pct = number_format((($this_reg / $tot_reg) * 100), 2);
		$big_table_left .= "<tr>
								<td>$verbose</td>
								<td align='right'>" . number_format($this_reg) . "</td>
								<td align='right'>" . $this_pct . "%</td>
							</tr>";
	}
	$big_table_left .= "</tbody></table>";
	$big_table_left .= "<h2 align='center'>$this_adv</td>";
	

	switch($type) {
		case "SD":
			$order = Array("SD", "AD", "CD", "CO");
			break;
		case "CD":
			$order = Array("CD", "SD", "AD", "CO");
			break;
		case "AD":
			$order = Array("AD", "SD", "CD", "CO");
			break;
	}

	$first = 0;
	foreach($order as $this_type) {
		uasort($reg_index[$this_type], "totreg_sort");

		foreach($reg_index[$this_type] as $dist => $x) {
			$jur_nm = $this_type . checkaddzero($dist);
			if(!$x['rTOTREG_R']) {
				continue;
			}
			if($this_type == "CO") {
				$adjusted_county = ($dist + 1) / 2;	
				$jur_nm = getcountyname($adjusted_county); 
			}
			$adv = get_advantage_raw($x['rDEM'], $x['rREP'], $x['rTOTREG_R']);

			$table_body[$this_type] .= "<tr>
										<td align='right' class='boldme'>" . number_format((($x['rTOTREG_R'] / $reg_index['TOTAL']['rTOTREG_R']) * 100), 2) . "%</td>
										<td>$jur_nm</td>
										<td align='right'>" . number_format($x['rTOTREG_R']) . "</td>
										<td>$adv</td>
										
									</tr>";

		}

		$table_head[$this_type] = "<table class='pastreg2'>
								<thead>
									<tr>
										<th>%</th>
										<th>PLACE</th>
										<th>REG</th>
										<th>ADV</th>
										
									</tr>
								</thead>
								<tbody>";

	if($first < 1) {
		$big_table_head = "<table class='big_table'>
								
								<tbody>";
		$big_table_body = $table_body[$this_type];
		unset($table_head[$this_type]);
		unset($table_body[$this_type]);
	}
	$table_end[$this_type] = "</tbody></table>";
	$first++;									

	}


	//echo("<br><br>");

	$prs['g08'] = Array("PRSDEM", "PRSREP", "PRSLIB", "PRSPAF", "PRSAIP", "PRSGRN");
	$prs['g12'] = Array("PRSDEM01", "PRSREP01", "PRSLIB01", "PRSPAF01", "PRSAIP01", "PRSGRN01");
	$prs['g16'] = Array("PRSDEM01", "PRSREP01", "PRSLIB01", "PRSPAF01", "PRSAIP01", "PRSGRN01");
	$prs['g20'] = Array("PRSDEM01", "PRSREP01", "PRSLIB01", "PRSPAF01", "PRSAIP01", "PRSGRN01");
	
	
	
	$gov['g10'] = Array("GOVDEM", "GOVREP");
	$gov['g14'] = Array("GOVDEM01", "GOVREP01");
	$gov['g18'] = Array("GOVDEM01", "GOVREP01");
	
	$cng['g14'] = Array("CNGDEM01", "CNGDEM02", "CNGREP01", "CNGREP02");
	$cng['g16'] = Array("CNGDEM01", "CNGDEM02", "CNGREP01", "CNGREP02");
	$cng['g18'] = Array("CNGDEM01", "CNGDEM02", "CNGREP01", "CNGREP02");
	$cng['g20'] = Array("CNGDEM01", "CNGDEM02", "CNGREP01");

	$asm['g14'] = Array("ASMDEM01", "ASMDEM02", "ASMREP01", "ASMREP02");
	$asm['g16'] = Array("ASMDEM01", "ASMDEM02", "ASMREP01", "ASMREP02");
	$asm['g18'] = Array("ASMDEM01", "ASMDEM02", "ASMREP01", "ASMREP02");
	$asm['g20'] = Array("ASMDEM01", "ASMDEM02", "ASMREP01", "ASMREP02");
	
	
	


	foreach($gov as $election => $cands) {
		foreach($cands as $racekey) {
			$big['GOV'][$election][$racekey]['VOTES'] 		= $e_results[$election][$racekey];
			$big['GOV'][$election][$racekey]['CAND_NM'] 	= $races_index[$election][$racekey]['name'];
			$big['GOV'][$election][$racekey]['PARTY'] 		= $races_index[$election][$racekey]['party'];
			$big['GOV'][$election][$racekey]['CAND_ID'] 	= $races_index[$election][$racekey]['cand_id'];
			$big['GOV'][$election][$racekey]['IS_INC'] 		= $races_index[$election][$racekey]['is_incumbent'];
			$sum_arr['GOV'][$election]['TOTAL'] += $e_results[$election][$racekey];
		}
	}

	foreach($prs as $election => $cands) {
		foreach($cands as $racekey) {
			$big['PRS'][$election][$racekey]['VOTES'] 		= $e_results[$election][$racekey];
			$big['PRS'][$election][$racekey]['CAND_NM'] 	= $races_index[$election][$racekey]['name'];
			$big['PRS'][$election][$racekey]['PARTY'] 		= $races_index[$election][$racekey]['party'];
			$big['PRS'][$election][$racekey]['CAND_ID'] 	= $races_index[$election][$racekey]['cand_id'];
			$big['PRS'][$election][$racekey]['IS_INC'] 		= $races_index[$election][$racekey]['is_incumbent'];
			$sum_arr['PRS'][$election]['TOTAL'] += $e_results[$election][$racekey];
		}
	}

	foreach($cng as $election => $cands) {
		foreach($cands as $racekey) {
			if(mb_substr($racekey, 3, 3) == "DEM") {
				$this_key = "CNGDEM";
				$this_party = "DEM";
			} else {
				$this_key = "CNGREP";
				$this_party = "REP";
			}
			$big['CNG'][$election][$this_key]['VOTES'] += $e_results[$election][$racekey];
			$big['CNG'][$election][$this_key]['PARTY'] = $this_party;
			$sum_arr['CNG'][$election]['TOTAL'] += $e_results[$election][$racekey];
		}

	}
	
	foreach($asm as $election => $cands) {
		foreach($cands as $racekey) {
			if(mb_substr($racekey, 3, 3) == "DEM") {
				$this_key = "ASMDEM";
				$this_party = "DEM";
			} else {
				$this_key = "ASMREP";
				$this_party = "REP";
			}
			$big['ASM'][$election][$this_key]['VOTES'] += $e_results[$election][$racekey];
			$big['ASM'][$election][$this_key]['PARTY'] = $this_party;
			$sum_arr['ASM'][$election]['TOTAL'] += $e_results[$election][$racekey];
		}

	}


	$elections = Array("g08", "g10", "g12", "g14", "g16", "g18", "g20");
	foreach($elections as $election) {
		$this_tot = $e_results[$election]['rTOTREG_R'];
		$this_rep = $e_results[$election]['rREP'];
		$this_dem = $e_results[$election]['rDEM'];
		$this_npp = $e_results[$election]['rDCL'];
		$this_adv = get_advantage_raw($this_dem, $this_rep, $this_tot);


		$table_body['PAST_REG'] .= "<tr>
										<td class='boldme'>" . strtoupper($election) . "</td>
										<td align='right'>" . number_format($this_tot) . "</td>
										<td align='right' class='blueme'>" . number_format($this_dem) . "</td>
										<td align='right' class='blueme'>" . number_format((($this_dem / $this_tot) * 100),2) . "%</td>
										<td align='right' class='redme'>" . number_format($this_rep) . "</td>
										<td align='right' class='redme'>" . number_format((($this_rep / $this_tot) * 100),2) . "%</td>
										<td align='right' class=''>" . number_format($this_npp) . "</td>
										<td align='right' class=''>" . number_format((($this_npp / $this_tot) * 100),2) . "%</td>
										<td>$this_adv</td>
									</tr>";
	}
	$table_head['PAST_REG'] = "<table align='center' class='pastreg'>
									<thead>
										<tr>
											<th></th>
											<th>REGISTERED</th>
											<th colspan='2' align='center'>DEMOCRATIC</th>
											<th colspan='2' align='center'>REPUBLICAN</th>
											<th colspan='2' align='center'>NO PARTY PREFERENCE</th>
											<th>ADVANTAGE</th>
										</tr>
									</thead>
									<tbody>";

	

	$gov_section = "<div class='container'>
						<div class='row col-lg-12'>";


	foreach($big['GOV'] as $election => $cands) {
		uasort($cands, "votes_sort");
		
		$gov_section .= "<div class='panel col-lg-4'>";
		$i = 0;
		foreach($cands as $c) {
			$cand[$i]['VOTES'] = $c['VOTES'];
			$cand[$i]['CAND_NM'] = $c['CAND_NM'];
			$cand[$i]['PARTY'] = $c['PARTY'];
			$cand[$i]['PCT'] = number_format((($c['VOTES'] / $sum_arr['GOV'][$election]['TOTAL']) * 100), 2);
			$cand[$i]['CAND_ID'] = $c['CAND_ID'];
			$i++;
		}
		$win_img = get_image_url($cand[0]['CAND_ID']);
		$win_pct = number_format(($cand[0]['PCT'] - $cand[1]['PCT']), 2);
		$margin  = number_format($cand[0]['VOTES'] - $cand[1]['VOTES']);
		if($cand[0]['PARTY'] == "DEM") {
			$p_class = "demdiv";
		} elseif ($cand[0]['PARTY'] == "REP") {
			$p_class = "repdiv";
		}
		$gov_section .= "<div class='row'>
							<div class='col-lg-12'>
								<h5 align='center'>GOVERNOR '" . mb_substr($election, 1, 2) . "</h5>
								<p align='center' class='$p_class'></p>
								<div style='float: left;' class='col-lg-4' align='center'>
									$win_img
									<div align='center' style='display: inline-block; width='100%'>
										<h4 align='center'>+ $win_pct%<br>+ $margin votes</h4>
									</div>										
								</div>
							<div style='float: right;' class='col-lg-8'>
							<table class='wintable table-striped table-responsive'>
								<tbody>
									<tr>
										<td>" . $cand[0]['CAND_NM'] . "</td>
										<td>" . $cand[0]['PARTY'] . "</td>
										<td align='right'>" . number_format($cand[0]['VOTES']) . "</td>
										<td align='right'>" . $cand[0]['PCT'] . "%</td>
									</tr>
									<tr>
										<td>" . $cand[1]['CAND_NM'] . "</td>
										<td>" . $cand[1]['PARTY'] . "</td>
										<td align='right'>" . number_format($cand[1]['VOTES']) . "</td>
										<td align='right'>" . $cand[1]['PCT'] . "%</td>
									</tr>									
								</tbody>
							</table>
						
						</div>


					</div>
				</div>
			</div>";
	}
	$gov_section .= "</div></div>";
	

	$prs_section = "<div class='container'>
						<div class='row col-lg-12'>";

	foreach($big['PRS'] as $election => $cands) {
		uasort($cands, "votes_sort");
		//echo("<br><br>$election");
		$prs_section .= "<div class='panel col-lg-3'>";
		$i = 0;
		foreach($cands as $c) {
			$cand[$i]['VOTES'] = $c['VOTES'];
			$cand[$i]['CAND_NM'] = $c['CAND_NM'];
			$cand[$i]['PARTY'] = $c['PARTY'];
			$cand[$i]['PCT'] = number_format((($c['VOTES'] / $sum_arr['PRS'][$election]['TOTAL']) * 100), 2);
			$cand[$i]['CAND_ID'] = $c['CAND_ID'];
			$i++;
		}
		$win_img = get_image_url($cand[0]['CAND_ID']);
		$win_pct = number_format(($cand[0]['PCT'] - $cand[1]['PCT']), 2);
		$margin  = number_format($cand[0]['VOTES'] - $cand[1]['VOTES']);
		if($cand[0]['PARTY'] == "DEM") {
			$p_class = "demdiv";
		} elseif ($cand[0]['PARTY'] == "REP") {
			$p_class = "repdiv";
		}		
		$prs_section .= "<div class='row'>
							<div class='col-lg-12'>
								<h5 align='center'>PRESIDENT '" . mb_substr($election, 1, 2) . "</h5>
								<p align='center' class='$p_class'></p>
								<div style='float: left;' class='col-lg-4' align='center'>
									$win_img
									<div align='center' style='display: inline-block'>
										<h4 align='center'>+ $win_pct%<br>+ $margin votes</h4>
									</div>										
								</div>
							<div style='float: right;' class='col-lg-8'>
							<table class='wintable table-striped table-responsive'>
								<tbody>
									<tr>
										<td>" . $cand[0]['CAND_NM'] . "</td>
										<td>" . $cand[0]['PARTY'] . "</td>
										<td align='right'>" . number_format($cand[0]['VOTES']) . "</td>
										<td align='right'>" . $cand[0]['PCT'] . "%</td>
									</tr>
									<tr>
										<td>" . $cand[1]['CAND_NM'] . "</td>
										<td>" . $cand[1]['PARTY'] . "</td>
										<td align='right'>" . number_format($cand[1]['VOTES']) . "</td>
										<td align='right'>" . $cand[1]['PCT'] . "%</td>
									</tr>									
								</tbody>
							</table>
							
						</div>
					</div>
				</div>
			</div>";
	}
	$prs_section .= "</div></div>";



	$cng_section = "<div class='container'>
						<div class='row col-lg-12'>";


	foreach($big['CNG'] as $election => $cands) {
		uasort($cands, "votes_sort");
		
		$cng_section .= "<div class='panel col-lg-3'>";
		$i = 0;
		foreach($cands as $c) {
			$cand[$i]['VOTES'] = $c['VOTES'];
			$cand[$i]['PARTY'] = $c['PARTY'];
			$cand[$i]['PCT'] = number_format((($c['VOTES'] / $sum_arr['CNG'][$election]['TOTAL']) * 100), 2);
			$i++;
		}

		
		$win_pct = number_format(($cand[0]['PCT'] - $cand[1]['PCT']), 2);
		$margin  = number_format($cand[0]['VOTES'] - $cand[1]['VOTES']);
		if($cand[0]['PARTY'] == "DEM") {
			$p_class = "demdiv";
			$win_img = "<img src='/img/DEM.png' height='150px' class='thumbnail' />";
		} elseif ($cand[0]['PARTY'] == "REP") {
			$p_class = "repdiv";
			$win_img = "<img src='/img/GOP.png' height='150px' class='thumbnail' />";
		}
		$cng_section .= "<div class='row'>
							<div class='col-lg-12'>
								<h5 align='center'>CONGRESS '" . mb_substr($election, 1, 2) . "</h5>
								<p align='center' class='$p_class'></p>
								<div style='float: left;' class='col-lg-4' align='center'>
									$win_img
									<div align='center' style='display: inline-block; width='100%'>
										<h4 align='center'>+ $win_pct%<br>+ $margin votes</h4>
									</div>										
								</div>
							<div style='float: right;' class='col-lg-8'>
							<table class='wintable table-striped table-responsive'>
								<tbody>
									<tr>
										
										<td>ALL " . $cand[0]['PARTY'] . " CANDIDATES</td>
										<td align='right'>" . number_format($cand[0]['VOTES']) . "</td>
										<td align='right'>" . $cand[0]['PCT'] . "%</td>
									</tr>
									<tr>
										
										<td>ALL " . $cand[1]['PARTY'] . " CANDIDATES</td>
										<td align='right'>" . number_format($cand[1]['VOTES']) . "</td>
										<td align='right'>" . $cand[1]['PCT'] . "%</td>
									</tr>									
								</tbody>
							</table>
						
						</div>


					</div>
				</div>
			</div>";
	}
	$cng_section .= "</div></div>";


	$asm_section = "<div class='container'>
						<div class='row col-lg-12'>";


	foreach($big['ASM'] as $election => $cands) {
		uasort($cands, "votes_sort");
		
		$asm_section .= "<div class='panel col-lg-3'>";
		$i = 0;
		foreach($cands as $c) {
			$cand[$i]['VOTES'] = $c['VOTES'];
			$cand[$i]['PARTY'] = $c['PARTY'];
			$cand[$i]['PCT'] = number_format((($c['VOTES'] / $sum_arr['ASM'][$election]['TOTAL']) * 100), 2);
			$i++;
		}

		
		$win_pct = number_format(($cand[0]['PCT'] - $cand[1]['PCT']), 2);
		$margin  = number_format($cand[0]['VOTES'] - $cand[1]['VOTES']);
		if($cand[0]['PARTY'] == "DEM") {
			$p_class = "demdiv";
			$win_img = "<img src='/img/DEM.png' height='150px' class='thumbnail' />";
		} elseif ($cand[0]['PARTY'] == "REP") {
			$p_class = "repdiv";
			$win_img = "<img src='/img/GOP.png' height='150px' class='thumbnail' />";
		}
		$asm_section .= "<div class='row'>
							<div class='col-lg-12'>
								<h5 align='center'>ASSEMBLY '" . mb_substr($election, 1, 2) . "</h5>
								<p align='center' class='$p_class'></p>
								<div style='float: left;' class='col-lg-4' align='center'>
									$win_img
									<div align='center' style='display: inline-block; width='100%'>
										<h4 align='center'>+ $win_pct%<br>+ $margin votes</h4>
									</div>										
								</div>
							<div style='float: right;' class='col-lg-8'>
							<table class='wintable table-striped table-responsive'>
								<tbody>
									<tr>
										
										<td>ALL " . $cand[0]['PARTY'] . " CANDIDATES</td>
										<td align='right'>" . number_format($cand[0]['VOTES']) . "</td>
										<td align='right'>" . $cand[0]['PCT'] . "%</td>
									</tr>
									<tr>
										
										<td>ALL " . $cand[1]['PARTY'] . " CANDIDATES</td>
										<td align='right'>" . number_format($cand[1]['VOTES']) . "</td>
										<td align='right'>" . $cand[1]['PCT'] . "%</td>
									</tr>									
								</tbody>
							</table>
						
						</div>


					</div>
				</div>
			</div>";
	}
	$asm_section .= "</div></div>";

	$mid_section = "<div class='row'>
						<div class='col-lg-12'>
							<div class='col-lg-6'>
								<div class='table-striped pastreg'>" . 
									$table_head['PAST_REG'] . $table_body['PAST_REG'] . "</tbody></table>
								</div>
							</div>";

	switch($type) {
		case "SD":
			$order = Array("SD", "AD", "CD", "CO");
			break;
		case "CD":
			$order = Array("CD", "SD", "AD", "CO");
			break;
		case "AD":
			$order = Array("AD", "SD", "CD", "CO");
			break;
	}							

	//echo("<br>ORDER DUMP - TYPE: $type<br>");
	//var_dump($order);
	//echo("<br>");
	foreach($order as $this_type) {
		if(isset($table_head[$this_type])) {
			$mid_section .= "<div class='col-lg-2''>
								<div class='table-striped'><h3 align='center'>$this_type</h3>" .
									$table_head[$this_type] . $table_body[$this_type] . "</tbody></table>
							 	</div>
							</div>";


		} else {
			//echo("<br>NO TABLE_HEAD FOR $this_type");
			continue;
		}
	}
	$mid_section .= "</div></div>";

	$big_right = "<div>" . $big_table_head . $big_table_body . "</tbody></table></div>";
	$big_left = "<div>" . $big_table_left . "</div>";
	$spacer_div = "<div style='width: 100vw float: none; clear: both; height: 5px;'></div>";

	$top_div = "<div class='row'>
					<div class='col-lg-12'>
						<div class='col-lg-3'>
							<div class='panel'>
								<div class='table-striped' align='center'>
									$big_left
								</div>
							</div>
						</div>
						<div class='col-lg-6'>
							<div class='panel'>
								$map_iframe
							</div>
						</div>
						<div class='col-lg-3'>
							<div class='panel'>
								<div class='table-striped'>

									$big_right
									<div class='row'>
										<div class='col-lg-6'>

											<p style='width: 100%'></p>
											<p align='center'>OFFICEHOLDERS IN DISTRICT</p>
											$inc_table
										</div>
										<div class='col-lg-6'>

											<p style='width: 100%'></p>
											<p align='center'>CANDIDATES IN DISTRICT</p>
											$non_inc_table
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";



	$elections = Array("g20", "g18", "g16", "g14", "g12", "g10", "g08");

	$top_order = Array("PRS", "USS", "GOV", "LTG", "SOS", "ATG", "TRS", "CON", "INS", "SPI");
	$dist_order = Array("CNG", "SEN", "ASM");

	foreach($elections as $election) {
		//DRAW STATEWIDES
		$res_section .= $spacer_div . 
						"<div class='col-lg-12'>
							<h2 align='center'>$election</h2>";
		foreach($top_order as $prefix) {
			//FIND RACES MATCHING PREFIX IN RACES LIST AND ASSIGN RESULTS TO A TEMPORARY ARRAY
			$tmp_arr = [];
			$tmp_arr_tot = 0;
			foreach($races_index[$election] as $racekey => $x) {
				if(mb_substr($racekey, 0, 3) == $prefix) {
					$tmp_arr[$racekey] = $e_results[$election][$racekey];
					$tmp_arr_tot += $e_results[$election][$racekey];
				}
			}
			arsort($tmp_arr);
			if($tmp_arr_tot) {
				$res_class = '';
				$res_head = "<div class='col-sm-2'>
								<p>$prefix</p>";

				$res_table = "<table class='table table-striped res_table'>
									<tbody>";
				foreach($tmp_arr as $racekey => $votes) {
					if(!$res_class) {
						$res_class = strtolower($races_index[$election][$racekey]['party']) . "div";
					}
					$res_table .= "<tr>
									<td>" . $races_index[$election][$racekey]['name'] . "</td>
									<td>" . $races_index[$election][$racekey]['party'] . "</td>
									<td align='right'>" . number_format($votes) . "</td>
									<td align='right'>" . number_format((($votes / $tmp_arr_tot) * 100), 2) . "%</td>
								  </tr>";
				}
				$res_table .= "</tbody></table></div>";
				$res_section .= $res_head . "<p class='$res_class'></p>" . $res_table;
				
			}
		}

		//DRAW DISTRICT RACES


		$res_section .= $spacer_div;
		foreach($dist_order as $prefix) {
			if($election == "g10" || $election == "g08") {
				continue;
			}
			//FIND RACES MATCHING PREFIX IN RACES LIST AND ASSIGN RESULTS TO A TEMPORARY ARRAY
			$tmp_arr = [];
			$tmp_arr_tot = [];
			foreach($races_index[$election] as $racekey => $x) {
				
				if(mb_substr($racekey, 0, 3) == $prefix || ($prefix == "ASM" && mb_substr($racekey, 0, 3) == "ASS")) {
					

					$tmp_dist = mb_substr($racekey, 3, 2);
					$tmp_dist = (int)$tmp_dist;
					$distkey = $x['distkey'];
					if($prefix == "ASM") {
						$distkey = str_replace("ASS", "ASM", $distkey);
					}

					if($d_results[$election][$prefix][$tmp_dist][$distkey]) {
						$tmp_arr[$tmp_dist][$racekey] = $d_results[$election][$prefix][$tmp_dist][$distkey];
						$tmp_arr_tot[$tmp_dist] += $d_results[$election][$prefix][$tmp_dist][$distkey];
					}
				} 
			}
			foreach($tmp_arr as $tmp_dist => $tmp_arr2) {

				arsort($tmp_arr2);
				
				if($tmp_arr_tot[$tmp_dist]) {
					$res_class = '';
					$res_head = "<div class='col-sm-2'>
									<p>$prefix $tmp_dist</p>";
					$res_table = "<table class='table table-striped res_table'>
										<tbody>";
					foreach($tmp_arr2 as $racekey => $votes) {
						if(!$res_class) {
							$res_class = strtolower($races_index[$election][$racekey]['party']) . "div";
						}						
						$res_table .= "<tr>
										<td>" . $races_index[$election][$racekey]['name'] . "</td>
										<td>" . $races_index[$election][$racekey]['party'] . "</td>
										<td align='right'>" . number_format($votes) . "</td>
										<td align='right'>" . number_format((($votes / $tmp_arr_tot[$tmp_dist]) * 100), 2) . "%</td>
									  </tr>";
					}
					$res_table .= "</tbody></table></div>";
					$res_section .= $res_head . "<p class='$res_class'></p>" . $res_table;
				}

			}
			
		}


		//DRAW PROPS

		$res_section .= $spacer_div;

		//FIND RACES MATCHING PREFIX IN RACES LIST AND ASSIGN RESULTS TO A TEMPORARY ARRAY
		$tmp_arr = [];
		$tmp_arr_tot = [];

		foreach($races_index[$election] as $racekey => $x) {
			
			if(mb_substr($racekey, 0, 3) == "PR_") {
				
				$regex = '~PR\_(.*?)\_~mis';
				preg_match($regex, $racekey, $results);
				$prop_id = $results[1];

				if($e_results[$election][$racekey]) {
					$tmp_arr[$prop_id][$racekey] = $e_results[$election][$racekey];
					$tmp_arr_tot[$prop_id] += $e_results[$election][$racekey];
				}
			} 
		}

		foreach($tmp_arr as $tmp_dist => $tmp_arr2) {

			arsort($tmp_arr2);
			$prop_nm = $prop_index[$election][$tmp_dist];
			$res_class = '';
			$res_head = "<div class='col-sm-2'>
							<p>PROP $tmp_dist - $prop_nm</p>";

			$res_table = "<table class='table table-striped res_table'>
								<tbody>";
			foreach($tmp_arr2 as $racekey => $votes) {
				if(substr($racekey, -1) == "Y") {
					$this_name = "YES";
				} else {
					$this_name = "NO";
				}

				if(!$res_class) {
					if($this_name == "YES") {
						$res_class = "grndiv";
					} else {
						$res_class = 'repdiv';
					}
				}					
				$res_table .= "<tr>
								<td>" . $this_name . "</td>
								<td align='right'>" . number_format($votes) . "</td>
								<td align='right'>" . number_format((($votes / $tmp_arr_tot[$tmp_dist]) * 100), 2) . "%</td>
							  </tr>";
			}
			$res_table .= "</tbody></table></div>";
			$res_section .= $res_head . "<p class='$res_class'></p>" . $res_table;	
		}
			
		


		$res_section .= "</div>";
	}



	//DRAW EVERYTHING


	echo("<section class='container'>");	
	echo("<h1 align='center'>$master_fourcode</h1>");
	echo($top_div);
	echo($spacer_div);
	
	echo($gov_section);
	echo($prs_section);	
	echo($cng_section);
	echo($asm_section);
	echo($mid_section);
	echo($county_panel);
	

	echo("</section>");	
	echo("<section class='container'>");
	echo($res_section);
	echo("</section>");

}

function get_cities($cities) {
	global $master_conn;
	$conn = Util::get_ctb_conn();  

	foreach($cities as $place => $ignore) {
		$query .= " PLACE = '$place' ||";
	}
	$query = substr($query, 0, -2);
	//echo("<br>$sql<br>");
	

	$sql = "SELECT PLACE, BASENAME FROM `PL_GEO` WHERE ( $query) && PARTFLAG = 'W' && (FUNCSTAT = 'A' || FUNCSTAT = 'S') GROUP BY BASENAME";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$place = $row['PLACE'];
			$name = $row['BASENAME'];
			$retval[$place] = $name;
		}
	}
	//var_dump($retval);
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

function get_race_headers($election) {
	global $master_conn, $races_index, $headers_index, $prop_index;
	$conn = Util::get_ctb_conn();  
	$sql = "SELECT race, name, disttype, distnum, distkey, election, party, is_incumbent, cand_id
			FROM ctb_ca_candidates
			WHERE election = '$election' && race != 'PRSWRI'";

	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$racekey = $row['race'];
			$distkey = $row['distkey'];
			if(mb_substr($racekey, 0, 3) == "PR_") {
				$races_index[$election][$racekey] =  $row;
				$headers_index[$racekey] = TRUE;

			} else {
				$races_index[$election][$racekey] =  $row;
				$headers_index[$distkey] = TRUE;
			}
		}
	}
}

function get_prop_index() {
	global $master_conn, $prop_index;
	$conn = Util::get_ctb_conn();  

	$sql = "SELECT prop_no, prop_dscr, prop_session FROM ctb_ca_props";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$this_election = "g" . checkaddzero((mb_substr($row['prop_session'], 2, 2) + 1));
			$prop_no = $row['prop_no'];
			$prop_index[$this_election][$prop_no] = $row['prop_dscr'];
		}
	}


}

function dist_lookup($type, $map) {
	global $master_conn;
	$conn = Util::get_ctb_conn();  
	if($type == "AD") {
		$full_map = "V" . $type . "_" . $map . "_1107";
		$jur_name = "VIZ4_" . $type;
	} else {
		$full_map = "V" . $type . "_" . $map . "_1102";
		$jur_name = "VIZ3_" . $type;
	}
	$sql = "SELECT jur_name, district FROM ctb_ca_city_shp WHERE jur_name = '$jur_name' && name = '$full_map'";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval['city'] = $row['jur_name'];
			$retval['cd'] = $row['district'];
		}
	}
	//var_dump($retval);
	return $retval;
}

function totreg_sort($a, $b){
	if ($a['rTOTREG_R'] == $b['rTOTREG_R']) {
		return 0;	
	} elseif ($a['rTOTREG_R'] < $b['rTOTREG_R']) {
		return 1;
	} else {
		return -1;
	}
		
}

function votes_sort($a, $b){
	if ($a['VOTES'] == $b['VOTES']) {
		return 0;	
	} elseif ($a['VOTES'] < $b['VOTES']) {
		return 1;
	} else {
		return -1;
	}
		
}

function get_image_url($cand_id) {
	$arr = Array(".png", ".jpg", ".jpeg", ".bmp", ".gif");
	foreach($arr as $x) {
		if(file_exists("img/candidates/" . $cand_id . $x)) {
			$retval = "<img src='img/candidates/" . $cand_id . $x . "' height='150px' class='thumbnail' />";
			return $retval;
		}
	}
}

function lookup_map($type, $dist) {
	
	$conn = Util::get_ctb_conn();  
	$this_dist = (int)$dist;
	if($type == "AD") {
		$sql = "SELECT name FROM ctb_ca_city_shp WHERE jur_name = 'VIZ4_" . $type . "' && district = $this_dist"; 
	} else {
		$sql = "SELECT name FROM ctb_ca_city_shp WHERE jur_name = 'VIZ3_" . $type . "' && district = $this_dist"; 	
	}
	
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$retval = $row['name'];
		}
	}
	//echo("<br>RETRIEVED $retval");
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



	@import url('https://fonts.googleapis.com/css?family=Bellefair');
	@import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow');
	body, html {
		background-color: white !important;
		font-family: 'Lato';
	}

	.ported {
	    height: 100vh;
	}

	.arial_font {
		font-family: Arial;
	}

	table, th, td {
		padding-left: 5px;
		padding-right: 5px;
		font-family: 'PT SAns Narrow';
		line-height: 1em;
	}

	.fa span {
		margin-left: 5px;
	}

	.sacto {
		background: url('img/sacto_bright.jpg') no-repeat;
        background-size: cover;
        font-family: 'Bellefair';
	}

	.filing_div {
		
		margin-top: 10px;
	}

	.container {
		min-width: 80vw;
	}

	.max1200 {
		max-width: 1300px;
	}

	.right-align {
		/*
		text-align: right;
		*/
	}

	

	.align-right {
		text-align: right;
	}

	.align-left {
		text-align: left;
	}

	.header_summary_table  {
		line-height: .9em;
		
	}

	.h1me {
		font-size: 2em;
	}

	.h2me {
		font-size: 1.75em;
		font-weight: bold;
		font-variant: small-caps;
	}

	.h3me {
		font-size: 1.5em;
		font-variant: small-caps;
	}

	.filing_header {
		margin-top: 20px;
		font-family: 'PT SAns Narrow';
		font-weight: bold;
	}

	.f460_rcpt_div {
		float: left;
		margin: 10px;
	}

	.f460_expn_div {
		float: left;
		margin: 10px;
	}

	.big_smry {
		clear: both;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
		font-family: 'Lato';
		font-weight: bold;
		width: 50%;
	}

	.full_smry_div_container {
		display: inline-block;
		font-family: 'PT Sans Narrow';
	}

	.full_smry_div_container p {
		text-align: center;
		font-weight: bold;
	}

	.inverse {
		background-color: black;
		color: white;
		font-family: 'PT Sans NArrow' !important;
	}

	.greenme {
	 	color: green !important;
	}

	.redme {
		color: red !important;
	}

	.blueme {
		color: blue !important;
	}

	.boldme {
		font-weight: bold;
	}

	.itcme {
		font-style: italic;
	}

	table {
		border: 2px solid black;
	}

	h1, h2 {
		font-family: 'Bellefair';
		font-variant: small-caps;
	}

	h4 span {
		padding-left: 5px;
	}

	.wintable {
		border: none;
		font-family: 'Lato';
		font-size: 1.3em !important;
	}

	.pastreg {
		font-size: 1.4em !important;
		line-height: 1em;
	}

	.pastreg2 {
		font-size: 1.5em !important;
		line-height: 1em;
	}

	.big_table {
		font-size: 2em;
		border: none;
		font-family: 'Lato' !important;
		line-height: 1.5em !important;
		padding: 5px;
		
	}

	.big_left {
		font-size: 2em;
		border: none;
		font-family: 'Lato';
	}
	.container {
		width: 90vw;
	}

	.res_table td {
		font-size: 1em !important;

	}
	
	.ctb_logo {
/*
	background-image:url(/img/ctb_dark.png);
*/	
/*
	background-size: 100px 80px;
	*/
	position:fixed; 
	top:0; 
	right:0;

/*
	background-position: right top;
	background-repeat: no-repeat;	
	background-attachment: fixed;
	z-index: 9999 !important;
	*/

} 		
	}
	.big-summary {
		max-width: 800px !important;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
	}

	

</style>

@endsection
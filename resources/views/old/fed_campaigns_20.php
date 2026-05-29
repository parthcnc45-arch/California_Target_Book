<?php
//FED CAMPAIGNS 20
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
global $update_table, $detail_table, $party_arr, $endjava, $chart_divs, $finance_tables, $ie_div, $f2s;

seed_stuff();

?>

<div class="row">
    <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-sm-12 center-block fn">
    	<nav class='clearfix page-nav'>
            <ul class="clearfix">
                <li class='active'>
                    <a href='#e2024' id='e2024-trigger' role="tab" data-toggle="tab" class='header_icon'>
                    	<i class="material-icons nav-icon">ballot</i>
                        2024
                    </a>
                </li>
                <li>
                    <a href='#e2022' id='e2022-trigger' role="tab" data-toggle="tab" class='header_icon'>
                        <i class="material-icons nav-icon">ballot</i>
                        2022
                    </a>
                </li>
            </ul>
        </nav>

        <div class="content-wrap pt-xl">
            <section id="e2024" class="active">
            	<h2>2024</h2>
            	<?php
            		if(!empty($f2s['2024'])) {
            			echo("<div class='row'>
            					<div class='col-lg-6'>
            						<div class='panel'>
            							<h3>FEC STATEMENT OF CANDIDACY FILINGS</h3>"
            							. $f2s['2024'] . 
            						"</div>
            					</div>
            				</div>");
            		}
            	?>

            	<div class='row'>
            		<div class='col-lg-12'>
            			<div class='panel' align='center'>
            				<h3 align='center'>FINANCE REPORTS</h3>
        					<nav class='clearfix page-nav'>
        						<ul class='clearfix'>
        							<li class='active'>
        								<a href='#e2024_smry' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">attach_money</i>
        									OVERVIEW
        								</a>
        							</li>
        							<li>
        								<a href='#e2024_rcpt' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">monetization_on</i>
        									RECEIPTS BY QUARTER
        								</a>
        							</li>
        							<li>
        								<a href='#e2024_expn' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">monetization_on</i>
        									SPENDING BY QUARTER
        								</a>
        							</li>
        							<li>
        								<a href='#e2024_coh' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">monetization_on</i>
        									ENDING CASH ON HAND BY QUARTER
        								</a>
        							</li>
        						</ul> 
        					</nav>
							<div class="content-wrap pt-xl">
        						<section id="e2024_smry" class="active">            					
		  							<?php 
        								echo("<h4 align='center'>OVERVIEW</h4>");
        								echo($finance_tables['2024']['smry']); 
        							?>
        						</section> 

        						<section id="e2024_rcpt">            					
		  							<?php 
        								echo("<h4 align='center'>RECEIPTS BY QUARTER</h4>");
        								echo($finance_tables['2024']['rcpt']); 
        							?>
        						</section> 

        						<section id="e2024_expn">            					
		  							<?php 
        								echo("<h4 align='center'>SPENDING BY QUARTER</h4>");
        								echo($finance_tables['2024']['expn']); 
        							?>
        						</section> 

        						<section id="e2024_coh">            					
		  							<?php 
        								echo("<h4 align='center'>ENDING CASH ON HAND BY QUARTER</h4>");
        								echo($finance_tables['2024']['coh']); 
        							?>
        						</section>             						            						

        					</div>

            			</div>

            	<?php

            		if(!empty($ie_div["2024"])) {
            			echo($ie_div['2024']);
            		}

            	?>

            		</div>
            	</div>


            </section>
            <section id="e2022">
            	<h2>2022</h2>
            	<?php
            		if(!empty($f2s['2022'])) {
            			echo("<div class='row'>
            					<div class='col-lg-6'>
            						<div class='panel'>
            							<h3>FEC STATEMENT OF CANDIDACY FILINGS</h3>"
            							. $f2s['2022'] . 
            						"</div>
            					</div>
            				</div>");
            		}
            	?>

            	<div class='row'>
            		<div class='col-lg-12'>
            			<div class='panel' align='center'>
            				<h3 align='center'>FINANCE REPORTS</h3>
        					<nav class='clearfix page-nav'>
        						<ul class='clearfix'>
        							<li class='active'>
        								<a href='#e2022_smry' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">attach_money</i>
        									OVERVIEW
        								</a>
        							</li>
        							<li>
        								<a href='#e2022_rcpt' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">monetization_on</i>
        									RECEIPTS BY QUARTER
        								</a>
        							</li>
        							<li>
        								<a href='#e2022_expn' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">monetization_on</i>
        									SPENDING BY QUARTER
        								</a>
        							</li>
        							<li>
        								<a href='#e2022_coh' role="tab" data-toggle="tab" class='header_icon'>
        									<i class="material-icons nav-icon">monetization_on</i>
        									ENDING CASH ON HAND BY QUARTER
        								</a>
        							</li>
        						</ul> 
        					</nav>
							<div class="content-wrap pt-xl">
        						<section id="e2022_smry" class="active">            					
		  							<?php 
        								echo("<h4 align='center'>OVERVIEW</h4>");
        								echo($finance_tables['2022']['smry']); 
        							?>
        						</section> 

        						<section id="e2022_rcpt">            					
		  							<?php 
        								echo("<h4 align='center'>RECEIPTS BY QUARTER</h4>");
        								echo($finance_tables['2022']['rcpt']); 
        							?>
        						</section> 

        						<section id="e2022_expn">            					
		  							<?php 
        								echo("<h4 align='center'>SPENDING BY QUARTER</h4>");
        								echo($finance_tables['2022']['expn']); 
        							?>
        						</section> 

        						<section id="e2022_coh">            					
		  							<?php 
        								echo("<h4 align='center'>ENDING CASH ON HAND BY QUARTER</h4>");
        								echo($finance_tables['2022']['coh']); 
        							?>
        						</section>             						            						

        					</div>
            			</div>
            		</div>
            	</div>

            	<?php

            		if(!empty($ie_div["2022"])) {
            			echo($ie_div['2022']);
            		}

            	?>
            	<div class='row'>
            		<div class='col-lg-12'>
            			<div class='panel'>
            				<div class='row'>
            					<h3 align='left'>November 2022 Vote Count Progress</h3>
            						<?php			
            							echo($update_table);
	            						echo($detail_table);
	            					?>
	            			</div>
	            			<div class='row'>
	            				<?php 
	            					echo($chart_divs);
	            				?>
	            			</div>
	            		</div>
	            	</div>
	            </div>
            </section>
        </div>
    </div>
</div>    


<?php

function seed_stuff() {
	global $id, $fourcode, $master_fourcode, $finance_tables, $ie_div, $f2s;
	//LOAD ELECTION RESULTS

	//LOAD ELECTION RESULTS TRAJECTORY
	
	$votes = load_vote_progress($fourcode, "2022");
	//var_dump($votes);
	render_vote_progress($votes);

	//LOAD CAMPAIGN FINANCE SUMMARIES
	$finance_tables = load_finance_summaries($fourcode);

	//LOAD FEC STATEMENTS OF CANDIDACY
	$f2s = load_f2s($fourcode);

	//LOAD CANDIDATE PANELS

	//LOAD INDEPENDENT EXPENDITURES
	$ie_div['2022'] = load_ies($fourcode, "2022");
	$ie_div['2024'] = load_ies($fourcode, "2024");
}

function load_f2s($fourcode) {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT cycle, year, cand_id, cand_nm, fourcode, party, cmte_id, filed 
			FROM nufec_fed_candidates 
			WHERE cycle > 2020 && fourcode = '$fourcode'
			ORDER BY cycle, filed";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$cycle = $row['cycle'];
			$cand_id = $row['cand_id'];
			$arr[$cycle][$cand_id] = $row;
		}
	}

	foreach($arr as $cycle => $cands) {
		$f2_table[$cycle] = "<table class='w-auto table-striped' align='center'>
						<thead>
							<tr>
								<th>CAND NM</th>
								<th>PARTY</th>
								<th>CAND ID</th>
								<th>CMTE ID</th>
								<th>DATE FILED</th>
							</tr>
						</thead>
						<tbody>";
		foreach($cands as $cand_id => $x) {
			$f2_table[$cycle] .= "<tr>
									<td>" . $x['cand_nm'] . "</td>
									<td>" . $x['party'] . "</td>
									<td>" . $x['cand_id'] . "</td>
									<td>" . $x['cmte_id'] . "</td>
									<td>" . $x['filed'] . "</td>
								</tr>";
		}
		$f2_table[$cycle] .= "</tbody></table>";
	}
	return $f2_table;

}

function load_ies($fourcode, $cycle) {

	$url = "http://198.74.49.22/draw_ie_json.php?id=$fourcode&cycle=$cycle";
	//include($url);

	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Accept: application/json'
        ));

	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($curl, CURLOPT_HEADER, false);
	$data = curl_exec($curl);
	curl_close($curl);

	$json = $data;

	$arr = json_decode($json, true);


	$ie_div = '';

	if(!empty($arr['ie_cmte_summary'])) {
		//GOT IES, GET AMOUNTS, ADD SUP/OPP STUFF FOR CANDIDATES, DRAW IE SUMMARY TABLE
		$ie_tot = 0;
		$ie_pri = 0;
		$ie_gen = 0;
		$ie_oth = 0;
		if(!empty($arr['ie_totals']['grand_total'])) {
			$ie_tot = $arr['ie_totals']['grand_total'];
		}
		if(!empty($arr['ie_totals']['primary'])) {
			$ie_pri = $arr['ie_totals']['primary'];
		}
		if(!empty($arr['ie_totals']['general'])) {
			$ie_tot = $arr['ie_totals']['general'];
		}
		if(!empty($arr['ie_totals']['other'])) {
			$ie_tot = $arr['ie_totals']['other'];
		}

		$ie_total_span = "<h3>\$" . number_format($ie_tot) . " Total";
		if($ie_pri) {
			$ie_total_span .= "  -  \$" . number_format($ie_pri) . " Primary, ";
		}
		if($ie_gen) {
			$ie_total_span .= "\$" . number_format($ie_gen) . " General, ";
		}
		if($ie_oth) {
			$ie_total_span .= "\$" . number_format($ie_oth) . " Special/Other, ";
		}
		$ie_total_span = substr($ie_total_span, 0, -2);
		$ie_total_span .= "</h3>";

		$so_div = "<div class='so_div_container'>";

		foreach($arr['ie_cand_totals'] as $cand_naml => $x) {
			$so_div .= "<div class='so_div'><p align='center'>$cand_naml";
			if(!empty($x['support_total'])) {
				$so_div .= "<br>Sup: <span class='Support'>\$" . number_format($x['support_total']) . "</span> - (";
				$pg_span = '';
				if(!empty($x['support_P'])) {
					$pg_span .= "P: \$" . number_format($x['support_P']) . ", ";
				}
				if(!empty($x['support_G'])) {
					$pg_span .= "G: \$" . number_format($x['support_G']) . ", ";
				}
				if(!empty($x['support_O'])) {
					$pg_span .= "O: \$" . number_format($x['support_O']) . ", ";
				}
				$pg_span = substr($pg_span, 0, -2);
				$so_div .= $pg_span . ")";
			}

			if(!empty($x['oppose_total'])) {
				$so_div .= "<br>Opp: <span class='Oppose'>\$" . number_format($x['oppose_total']) . "</span> - (";
				$pg_span = '';
				if(!empty($x['oppose_P'])) {
					$pg_span .= "P: \$" . number_format($x['oppose_P']) . ", ";
				}
				if(!empty($x['oppose_G'])) {
					$pg_span .= "G: \$" . number_format($x['oppose_G']) . ", ";
				}
				if(!empty($x['oppose_O'])) {
					$pg_span .= "O: \$" . number_format($x['oppose_O']) . ", ";
				}
				$pg_span = substr($pg_span, 0, -2);
				$so_div .= $pg_span . ")";
			}			
			$so_div .= "</p></div>"	;
		}
		$so_div .= "</div>";



		$ie_cmte_table = "<table>
							<thead>
								<tr>
									<th>CMTE</th>
									<th>PRIMARY</th>
									<th>GENERAL</th>
									<th>OTHER</th>
									<th>SUPPORT</th>
									<th>OPPOSE</th>
									<th>TOTAL</th>
								</tr>
							</thead>
							<tbody>";
		foreach($arr['ie_cmte_summary'] as $cmte_id => $x) {
			$ie_cmte_table .= "<tr>
								  <td>" . $x['cmte_lnk'] . "</td>
								  <td align='right'>\$" . number_format($x['primary']) . "</td>
								  <td align='right'>\$" . number_format($x['general']) . "</td>
								  <td align='right'>\$" . number_format($x['other']) . "</td>
								  <td>" . $x['cands_supported'] . "</td>
								  <td>" . $x['cands_opposed'] . "</td>
								 <td align='right'>\$" . number_format($x['grand_total']) . "</td>
								 </tr>";
		}
		$ie_cmte_table .= "</tbody></table>";
		$ie_div = "<div class='row'>
						<div class='col-lg-12'>
							<h2>Independent Expenditure Summary</h2>
							<div class='panel'>
								$ie_total_span
								$so_div
								<div class='table-responsive table-striped'>					
									$ie_cmte_table
								</div>
							</div>
						</div>
					</div>";
	}
	return $ie_div;					



}

function load_finance_summaries($fourcode) {
	$conn = Util::get_ctb_conn();
	$state = mb_substr($fourcode, 0, 2);
	$dist = mb_substr($fourcode, 2, 2);
	if($state == "AK" || $state == "DE" || $state == "SD" || $state == "ND" || $state == "VT" || $state == "WY") {
		$dist = "00";
	}

	$years = Array("2022", "2024");
	$query = [];
	foreach($years as $year) {
		$short_year = mb_substr($year, 2, 2);
		//LOAD CANDIDATES
		$sql = "SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE_ST, CAND_OFFICE, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_PCC 
				FROM nufec_cn_" . $short_year . "
				WHERE CAND_ELECTION_YR = $year && CAND_OFFICE = 'H' && CAND_OFFICE_ST = '$state' && CAND_OFFICE_DISTRICT = '$dist'";
		//echo("<br>$sql<br>");
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$cand_id = $row['CAND_ID'];
				$cmte_id = $row['CAND_PCC'];
				$cand_index[$year][$cand_id] = $row;
				$cmte_index2[$cmte_id] = $row;
				$cmte_years[$year][$cmte_id] = $row;
			}
		}
	}

	foreach($years as $year) {
		$query[$year] = '';
		foreach($cand_index[$year] as $cand_id => $ignore) {
			$query[$year] .= " CAND_ID = '$cand_id' ||";
		}
		$query[$year] = substr($query[$year], 0, -2);
	}

	foreach($years as $year) {
		$short_year = mb_substr($year, 2, 2);
		$sql = "SELECT CAND_ID, TTL_RECEIPTS, TTL_DISB, COH_COP, CAND_LOANS, DEBTS_OWED_BY, CVG_END_DT
				FROM nufec_weball_" . $short_year . "
				WHERE ( " . $query[$year] . " )";
		//echo("<br>$sql<br>");
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$cand_id = $row['CAND_ID'];
				$cmte_index[$year][$cand_id] = $row;
			}
		}
	}

	foreach($years as $year) {
		$table[$year]['smry'] = "<table class='table-striped w-auto table-fit'>
							<thead class='bg-dark text-white'>
								<tr>
									<th>CANDIDATE</th>
									<th>PARTY</th>
									<th class='rightme'>RCPT</th>
									<th class='rightme'>EXPN</th>
									<th class='rightme'>LAST COH</th>
									<th class='rightme'>LOANS</th>
									<th class='rightme'>DEBT</th>
									<th class='rightme'>PD END</th>
									<th>CMTE ID</th>
									<th>RPT</th>
									<th>ALL</th>
								</tr>
							</thead>
							<tbody>";
		foreach($cand_index[$year] as $cand_id => $c) {
			$ici = $c['CAND_ICI'];
			$class = '';
			$cmte_id = $c['CAND_PCC'];
			$party = $c['CAND_PTY_AFFILIATION'];
			$cand_nm = $c['CAND_NAME'];

			if(!empty($cmte_index[$year][$cand_id])) {
				$cm = $cmte_index[$year][$cand_id];
	
				$rcpt = $cm['TTL_RECEIPTS'];
				$expn = $cm['TTL_DISB'];
				$coh = $cm['COH_COP'];
				$loan = $cm['CAND_LOANS'];
				$debt = $cm['DEBTS_OWED_BY'];
				$end_dt = $cm['CVG_END_DT'];
			} else {
				$rcpt = 0;
				$expn = 0;
				$coh = 0;
				$loan = 0;
				$debt = 0;
				$end_dt = '';
			}
			if($party == "REP") {
				$class='redme';
			} elseif($party == "DFL" || $party == "DEM") {
				$class='blueme';
			}

			if($ici == "I") {
				$party = $party . "-Inc";
			}

			$cand_url = "<a href='https://www.fec.gov/data/candidate/$cand_id/?tab=filings' target='_blank'>$cand_nm</a>";
			if(!empty($cmte_id)) {
				$cmte_url = "<a href='https://www.fec.gov/data/committee/$cmte_id/?tab=filings' target='_blank'>$cmte_id</a>";
				$rpt_url = "<a href='/ctb-legacy/fec_cmte_report?id=$cmte_id&cycle=$year' target='_blank'>RPT</a>";
				$all_url = "<a href='/ctb-legacy/getfedfilings.php?id=$cmte_id' target='_blank'>ALL</a>";
			} else {
				$cmte_url = "NO CMTE";
				$rpt_url = '';
				$all_url = '';
			}

			$table[$year]['smry'] .= "<tr>
								<td class='$class'>$cand_url</td>
								<td class='$class'>$party</td>
								<td align='right'>\$" . number_format($rcpt) . "</td>
								<td align='right'>\$" . number_format($expn) . "</td>
								<td align='right'>\$" . number_format($coh) . "</td>
								<td align='right'>\$" . number_format($loan) . "</td>
								<td align='right'>\$" . number_format($debt) . "</td>
								<td align='right'>$end_dt</td>
								<td>$cmte_url</td>
								<td>$rpt_url</td>
								<td>$all_url</td>
							</tr>";


		}
		$table[$year]['smry'] .= "</tbody></table>";
	}


	//SEED INDIVIDUAL QUARTERLY FILING SUMMARIES
	$query = '';
	foreach($cmte_index2 as $cmte_id => $ignore) {
		$query .= "cmte_id = '$cmte_id' ||";
	}
	$query = substr($query, 0, -2);
	$sql = "SELECT * FROM nufec_f3_summary 
			WHERE ($query) && pd_start > '20201231' ORDER BY cmte_id, pd_end, filing DESC";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$pd_end = $row['pd_end'];
			$cmte_id = $row['cmte_id'];
			if(!isset($filings[$cmte_id][$pd_end])) {
				$filings[$cmte_id][$pd_end] = $row;
				$filing_id = $row['filing'];

				$this_year = (int)mb_substr($pd_end, 0, 4);
				$date = mb_substr($pd_end, 4, 4);

				//FIND LAST REPORTING DATE WITHIN FISCAL QUARTER
				if($date >= "0101" && $date <= "0331") {
					$q = "Q1";
				} elseif($date >= "0401" && $date <= "0630") {
					$q = "Q2";
				} elseif($date >= "0701" && $date <= "0930") {
					$q = "Q3";
				} elseif($date >= "1001" && $date <= "1231") {
					$q = "Q4";
				} else {
					continue;
				}
				$hdr = $q . "-" . $this_year;

				if(empty($last_q_dt[$cmte_id][$hdr])) {
					$last_q_dt[$cmte_id][$hdr] = $pd_end;
					$last_q_filing[$cmte_id][$hdr] = $filing_id;
				}
				if($pd_end > $last_q_dt[$cmte_id][$hdr]) {
					$last_q_dt[$cmte_id][$hdr] = $pd_end;
					$last_q_filing[$cmte_id][$hdr] = $filing_id;
				}
			}
		}
	}

	//SEED QUARTERLY VALUES ARRAY
	foreach($cmte_years as $year => $cmtes) {
		$y1 = (int)$year - 1;
		$y2 = $year;
		foreach($cmtes as $cmte_id => $ignore) {
			if(empty($filings[$cmte_id])) {
			     continue;
			}
			foreach($filings[$cmte_id] as $pd_end => $x) {
				$this_year = (int)mb_substr($pd_end, 0, 4);
				$date = mb_substr($pd_end, 4, 4);
				if($this_year != $y1 && $this_year != $y2) {
					
					continue;
				}
				if($date >= "0101" && $date <= "0331") {
					$q = "Q1";
				} elseif($date >= "0401" && $date <= "0630") {
					$q = "Q2";
				} elseif($date >= "0701" && $date <= "0930") {
					$q = "Q3";
				} elseif($date >= "1001" && $date <= "1231") {
					$q = "Q4";
				} else {
					continue;
				}
				$hdr = $q . "-" . $this_year;
				if(empty($arr[$cmte_id][$hdr]['rcpt'])) {
					$arr[$cmte_id][$hdr]['rcpt'] = 0;
				}
				if(empty($arr[$cmte_id][$hdr]['expn'])) {
					$arr[$cmte_id][$hdr]['expn'] = 0;
				}
				$arr[$cmte_id][$hdr]['rcpt'] += $x['rcpt'];;
				$arr[$cmte_id][$hdr]['expn'] += $x['exp'];

				if($pd_end == $last_q_dt[$cmte_id][$hdr]) {
					$arr[$cmte_id][$hdr]['coh'] = $x['coh_end'];
				}
			}
		}
	}
	//echo("<br>LAST Q DT DUMP<br>");
	//var_dump($last_q_dt);

	foreach($cmte_years as $year => $cmtes) {
		$y1 = (int)$year - 1;
		$y2 = $year;

		$t_types = Array("rcpt", "expn", "coh");

		$headers = Array(
			"Q1-$y1", "Q2-$y1", "Q3-$y1", "Q4-$y1", "Q1-$y2", "Q2-$y2", "Q3-$y2", "Q4-$y2"
			);

		//GENERATE HEADER ROW FOR TABLES

		foreach($t_types as $type) {
			$t_head[$year][$type] = "<table class='table-fit table-striped line-1em'>
								<thead>
									<tr>
										<th>CANDIDATE</th>";
			foreach($headers as $hdr) {
				$t_head[$year][$type] .= "<th>$hdr</th>";
			}
			$t_head[$year][$type] .= "</tr>
							</thead>
							<tbody>";
		}

		foreach($cmtes as $cmte_id => $ignore) {
			$cand_nm = $cmte_index2[$cmte_id]['CAND_NAME'];
			foreach($t_types as $type) {
				if(empty($t_body[$year][$type])) {
					$t_body[$year][$type] = '';
				}
				$t_body[$year][$type] .= "<tr>
									<td>$cand_nm</td>";
				foreach($headers as $hdr_key) {
					if(!empty($arr[$cmte_id][$hdr_key][$type])) {
						$filing_id = $last_q_filing[$cmte_id][$hdr_key];
						$t_body[$year][$type] .= "<td align='right'><a href='/ctb-legacy/fedparser_null.php?id=$filing_id' target='_blank'>" . 
						"\$" . number_format($arr[$cmte_id][$hdr_key][$type]) . "</a></td>";
					} else {
						$t_body[$year][$type] .= "<td></td>";
					}
					
				}
			}
		}
	}

	foreach($t_types as $type) {
		foreach($years as $year) {
			$table[$year][$type] = $t_head[$year][$type] . $t_body[$year][$type] . "</tbody></table>";
		}
	}


	
	return $table;

}

function render_vote_progress($votes) {
	global $chart_divs, $update_table, $detail_table, $endjava, $id;
	$fourcode = $id;
	$cycle = '';
	$chart_data_1 = '';
	$chart_data_2 = '';
	$cutoff = 2;
	foreach($votes as $update_number => $cands) {
		if($update_number <= $cutoff) {
			continue;
		}

		if(empty($arrsize)) {
			$arrsize = sizeof($votes[$update_number]);
		}

		//echo("<br>Update $update_number Cands size: " . sizeof($cands) . " - Expected: $arrsize");
		$this_date = $cands['TOTAL']['updated'];
		$this_total = $cands['TOTAL']['votes'];
		if($this_total < 1 || $arrsize != sizeof($cands)) {
			continue;
		}


		
		//CLEAR OUT THE TOTAL AND THE PRECINCTS
		unset($cands['TOTAL']);
		//unset($cands['888']);
		$this_line_1 = "['$update_number', ";
		$this_line_2 = "['$update_number', ";
		$lc = 0;


		$candidates = '';
		$series = '';
		foreach($cands as $c) {
			if(empty($index_line_1) && $update_number > $cutoff) {
				//echo("<br>SEEDING INDEX LINE USING $update_number (cutoff = $cutoff)");
				//$cand_nm = replaceAccents($c['cand_nm']);
				$cand_nm = $c['cand_nm'];
				$cand_nm = str_replace('"', "", $cand_nm);
				$cand_nm = str_replace("'", "", $cand_nm);
				$cand_nm = str_replace(".", "", $cand_nm);
			
				$party = $c['party'];
				$candidates .= " '$cand_nm', ";
				if(empty($party_cnt[$party])) {
					$party_cnt[$party] = 0;
				}
				$party_cnt[$party]++;
				$tmp['cand_nm'] = $cand_nm;
				$tmp['party'] = $party;
				$tmp['party_cnt'] = $party_cnt[$party];
				$position_index[$lc] = $tmp;
				$lc++;
			}
		
			$this_pct = number_format((($c['votes'] / $this_total) * 100), 2);
			$this_votes = $c['votes'];

			$this_line_1 .= "$this_pct, ";
			$this_line_2 .= "$this_votes, ";
		}




		$candidates = substr($candidates, 0, -2);
		$this_line_1 = substr($this_line_1, 0, -2);
		$this_line_2 = substr($this_line_2, 0, -2);
		$this_line_1 .= "],
		";
		$this_line_2 .= "],
		";
		if(empty($index_line_1)) {
			$index_line_1 = "['Update', $candidates ],";
		}

		//echo("<br>$this_line_1<br>");
		$chart_data_1 .= $this_line_1;
		$chart_data_2 .= $this_line_2;
	}


	$blues = Array(
		"DEM" => TRUE,
		"D"	  => TRUE,
		"DFL" => TRUE,
		"Dem" => TRUE,
	);

	$reds = Array(
		"REP" => TRUE,
		"R"	  => TRUE,
		"GOP" => TRUE,
		"Rep" => TRUE,
	);

	foreach($position_index as $lc => $x) {
		$party = $x['party'];
		$cand_nm = $x['cand_nm'];
		$position = $x['party_cnt'];
		//echo("<br>");
		//var_dump($position);
		if(!empty($reds[$party])) {
			$color = get_reds($position);
			//echo("<br>$position - $color - $cand_nm");
		} elseif(!empty($blues[$party])) {
			$color = get_blues($position);
		} else {
			$color = get_other($position);
		}
		$series .= "
			$lc: { color: '$color' },
		";
	}

	$color_series = "series: {
		$series
	},";

	//echo("<br>CHART DATA 1:<br>$chart_data_1<br>");

	$js = "google.load('visualization', '1.0', {'packages':['corechart']});

	$('a[data-toggle=\"tab\"]').on('shown.bs.tab', function (e) {
	  if($(e.target).attr('id') == 'e2022-trigger')
	  {
	    draw_pct();
	    draw_raw();
	  }
	
	});

	
	";
	array_push($endjava, $js);


	$js = "function draw_pct() {
		var data = google.visualization.arrayToDataTable([
		$index_line_1
		$chart_data_1
		]);

	    var options = {
	      title: '$fourcode - $cycle (Percent Total)',
	      backgroundColor: 'none',
	      $color_series
	      titleTextStyle: {
	        color: '333333',
	        fontName: 'PT Sans Narrow',
	        fontSize: 20
	      },
	      chartArea: {
	       	width: '80%',
	       	height: '80%'
	       },
	       legend: {
	    	textStyle: {
	    		color: '333333',
	      		fontName: 'PT Sans Narrow',
	      		fontSize: 12
	    	}
	  	  }
	    };
	 
	    var chart = new google.visualization.LineChart(document.getElementById('pct_chart'));
	 
	    chart.draw(data, options);
	}


	function draw_raw() {
		var data = google.visualization.arrayToDataTable([
		$index_line_1
		$chart_data_2
		]);

	    var options = {
	      title: '$fourcode - $cycle (Raw Votes)',
	      backgroundColor: 'none',
	      $color_series
	      titleTextStyle: {
	        color: '333333',
	        fontName: 'PT Sans Narrow',
	        fontSize: 20
	      },
	      chartArea: {
	       	width: '80%',
	       	height: '80%'
	       },
	       legend: {
	    	textStyle: {
	    		color: '333333',
	      		fontName: 'PT Sans Narrow',
	      		fontSize: 12
	    	}
	  	  }
	    };
	 
	    var chart = new google.visualization.LineChart(document.getElementById('raw_chart'));
	 
	    chart.draw(data, options);
	}
	";

	array_push($endjava, $js);

	$chart_divs .= "<div class='box800 blackbox' style='width: 800px; height: 600px; text-align: center; margin-left: auto; margin-right: auto;'>
						<div id='pct_chart' style='margin-top: 20px; width: 800px; height: 600px;'></div>
					</div>
					<div class='box800 blackbox' style='width: 800px; height: 600px; text-align: center; margin-left: auto; margin-right: auto;'>
						<div id='raw_chart' style='margin-top: 20px; width: 800px; height: 600px;'></div>
					</div>";

}


function load_vote_progress($fourcode, $cycle) {
	global $update_table, $detail_table, $endjava;
	$conn = Util::get_ctb_conn();
	$detail_table_body = '';
	if($cycle == "2022") {
		$sql = "SELECT fourcode, votes, cand_nm, party, update_number, CONVERT_TZ(updated, '+0:00', '-8:00') AS updated 
				FROM ctb_g22_politico_results 
				WHERE fourcode = '$fourcode' && update_number > 1
				ORDER BY update_number, cand_nm";
			

		$result = $conn->query($sql);
		//echo("<br>$sql<br>");
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$update_number = $row['update_number'];
				$cand_id = $row['cand_nm'];
				$cand_nm = $row['cand_nm'];
				$fourcode = $row['fourcode'];
				if($cand_id != 'TOTAL') {
					$party = $row['party'];
					if(empty($party_arr[$update_number][$party])) {
						$party_arr[$update_number][$party] = 0;
					}
					$party_arr[$update_number][$party] += $row['votes'];
				}
				if(empty($retval[$update_number]['TOTAL']['votes'])) {
				     $retval[$update_number]['TOTAL']['votes'] = 0;
				}
				$retval[$update_number]['TOTAL']['votes'] += $row['votes'];
				$retval[$update_number]['TOTAL']['updated'] = $row['updated'];
				$retval[$update_number][$cand_id] = $row;
			}
		}
	}

	//GENERATE UPDATE SUMMARY TABLE

	$update_table = "<table class='w-auto small compact-table float-left table-fit table-striped2 line-1em'>
						<thead class='inverse'>
							<tr>
								<th>UPDATE<br>NUMBER</th>
								<th>LOGGED</th>
								<th>TOTAL<br>VOTES</th>
								
							</tr>
						</thead>
						<tbody>";

	foreach($retval as $update_number => $x) {
		$timestamp = '';
		$this_votes = 0;
		$this_precincts = '';
		if(!empty($retval[$update_number]['TOTAL']['updated'])) {
			$timestamp = $retval[$update_number]['TOTAL']['updated'];
		}
		if(!empty($retval[$update_number]['TOTAL']['votes'])) {
			$this_votes = $retval[$update_number]['TOTAL']['votes'];
		}
		if(!empty($retval[$update_number]['TOTAL']['party'])) {
			$this_precincts = $retval[$update_number]['TOTAL']['party'];
		}
		$update_table .= "<tr>
							<td>$update_number</td>
							<td>$timestamp</td>
							<td align='right'>" . number_format($this_votes) . "</td>
							
						</tr>";
		uasort($x, "votesort");						
		$rank_cnt =  1;
		foreach($x as $cand_id => $y) {
			if($cand_id == "TOTAL") {
				continue;
			}

			$y['rank'] = $rank_cnt;

			$retval[$update_number][$cand_id]['rank'] = $rank_cnt;

			if($y['rank'] == 1) {
				$leader_board[$update_number]['first_nm'] = $y['cand_nm'];
				$leader_board[$update_number]['first_votes'] = $y['votes'];
				$leader_board[$update_number]['first_pct'] = number_format((($y['votes'] / $this_votes) * 100), 2);
			} elseif($y['rank'] == 2) {
				$leader_board[$update_number]['second_nm'] = $y['cand_nm'];
				$leader_board[$update_number]['second_votes'] = $y['votes'];
				$leader_board[$update_number]['second_pct'] = number_format((($y['votes'] / $this_votes) * 100), 2);				
			} elseif($y['rank'] == 3) {
				$leader_board[$update_number]['third_nm'] = $y['cand_nm'];
				$leader_board[$update_number]['third_votes'] = $y['votes'];
				$leader_board[$update_number]['third_pct'] = number_format((($y['votes'] / $this_votes) * 100), 2);				

			}

			$rank_cnt++;
		}						
							
	}
	$update_table .= "</tbody></table>";


	//GENERATE UPDATE DETAIL TABLE

	//GET CANDIDATES, SEED HEADER ROW

	if(!empty($leader_board[$update_number]['third_votes'])) {
		$use_primary = TRUE;
		$primary_add_line_1 = "<th></th>";
		$primary_add_line_2 = "<th>SECOND</th>";
	} else {
		$use_primary = FALSE;
		$primary_add_line_1 = '';
		$primary_add_line_2 = '';
	}




	$cand_nm_hdr_1 = "<tr><th></th><th></th><th></th>$primary_add_line_1<th colspan='2'>TOTAL</th><th colspan='2'>ALL GOP</th><th colspan='2'>ALL DEM</th>";

	$cand_nm_hdr_2 = "<tr>
						<th>UPDATE</th>
						<th>LOGGED</th>
						<th>LEADER</th>
						$primary_add_line_2
						<th>VOTES IN</th>
						<th>VOTES &Delta;</th>
						<th>TOTAL</th>
						<th>UPDATE</th>
						<th>TOTAL</th>
						<th>UPDATE</th>";

	//var_dump($x);

	foreach($x as $cand_id => $stuff) {
		if($cand_id == "888" || $cand_id == "TOTAL" || !empty($ignore[$cand_id]) || $stuff['cand_nm'] == 'Roque "Rocky" De La Fuente III') {
			continue;
		}
		$cand_nm_hdr_1 .= "<th colspan='4'>" . $stuff['cand_nm'] . "</th>";
		$cand_nm_hdr_2 .= "<th align='right'>VOTES</th>
						   <th align='right'>%</th>
						   <th align='right'>&Delta;</th>
						   <th align='right'>%</th>";
		$cand_id_arr[$cand_id] = $cand_id;
	}

	$cand_nm_hdr_1 .= "</tr>";
	$cand_nm_hdr_2 .= "</tr>";

	$last_votes = 0;
	$last_dem = 0;
	$last_rep = 0;
	foreach($retval as $update_number => $x) {
		$this_votes = $x['TOTAL']['votes'];
		$diff = $this_votes - $last_votes;

		if(!empty($party_arr[$update_number]['DEM'])) {
			$this_dem   = $party_arr[$update_number]['DEM'];
		} else {
			$this_dem = 0;
		}
		if(!empty($party_arr[$update_number]['REP'])) {
			$this_rep   = $party_arr[$update_number]['REP'];
		} else {
			$this_rep  = 0;
		}


		$dem_diff = $this_dem - $last_dem;
		$rep_diff = $this_rep - $last_rep;

		$rep_pct_total = number_format((($this_rep / $this_votes) * 100), 2);
		$dem_pct_total = number_format((($this_dem / $this_votes) * 100), 2);

		$rep_pct_this = number_format((($rep_diff / $diff) * 100), 2);
		$dem_pct_this = number_format((($dem_diff / $diff) * 100), 2);

		
		$leader_nm = $leader_board[$update_number]['first_nm'];
		$leader_vote_diff = $leader_board[$update_number]['first_votes'] - $leader_board[$update_number]['second_votes'];
		$leader_pct_diff  = $leader_board[$update_number]['first_pct'] - $leader_board[$update_number]['second_pct'];
		if($leader_pct_diff < 10) {
			$leader_space = ' ';
		} else {
			$leader_space = '';
		}
		if($use_primary) {
			$second_nm = $leader_board[$update_number]['second_nm'];
			$second_vote_diff = $leader_board[$update_number]['second_votes'] - $leader_board[$update_number]['third_votes'];
			$second_pct_diff = $leader_board[$update_number]['second_pct'] - $leader_board[$update_number]['third_pct'];
			if($second_pct_diff < 10) {
				$second_space = ' ';
			} else {
				$second_space = '';
			}

			$add_primary = "<td>" . $second_nm . " +" . $second_space . number_format($second_pct_diff, 2) . " (+" . $second_space . number_format($second_vote_diff) . ")</td>";
		} else {
			$add_primary = '';
		}

		$detail_table_body .= "<tr>
								<td>$update_number</td>
								<td>" . $x['TOTAL']['updated'] . "</td>
								<td>" . $leader_nm . " +" . $leader_space . number_format($leader_pct_diff, 2) . " (+" . $leader_space . number_format($leader_vote_diff) . ")</td>
								$add_primary
								<td align='right'>" . number_format($this_votes) . "</td>
								<td align='right'>" . number_format($diff) . "</td>
								
								<td align='right' class='redme boldme'>" . $rep_pct_total . "%</td>
								<td align='right' class='redme itcme'>" . $rep_pct_this . "%</td>
								<td align='right' class='blueme boldme'>" . $dem_pct_total . "%</td>
								<td align='right' class='blueme itcme'>" . $dem_pct_this . "%</td>";


		foreach($cand_id_arr as $cand_id) {
			$this_cand_votes = $x[$cand_id]['votes'];
			if(empty($last_cand_votes[$cand_id])) {
				$last_cand_votes[$cand_id] = 0;
			}
			$this_cand_pct = number_format((($this_cand_votes / $this_votes) * 100), 2);
			$this_cand_diff = $this_cand_votes - $last_cand_votes[$cand_id];
			$this_update_pct = number_format((($this_cand_diff / $diff) * 100), 2);

			$detail_table_body .= "<td align='right'>" . number_format($this_cand_votes) . "</td>
								   <td align='right' class='boldme'>" . $this_cand_pct . "%</td>
								   <td align='right'>" . number_format($this_cand_diff) . "</td>
								   <td align='right' class='itcme'>" . $this_update_pct . "%</td>";

			$last_cand_votes[$cand_id] = $this_cand_votes;

		}
		$detail_table_body .= "</tr>";

		$last_votes = $this_votes;
		$last_rep = $this_rep;
		$last_dem = $this_dem;
	}

	$detail_table = "<table class='w-auto small compact-table float-left table-fit table-striped2 line-1em'>
						<thead class='bg-dark text-white'>
							$cand_nm_hdr_1
							$cand_nm_hdr_2
						</thead>
						<tbody>
							$detail_table_body
						</tbody>
					</table>
				</div>";
	return $retval;


}

function get_reds($position) {
	$reds = Array(
		"#FF0000", 
		"#930101",
		"#FB5656",
		"#B53232",
		"#950505",
		"#CF7878",
		"#B55B5B",
		"#FF0000", 
		"#930101",
		"#FB5656",
		"#B53232",
		"#950505",
		"#CF7878",
		"#B55B5B",
		"#FF0000", 
		"#930101",
		"#FB5656",
		"#B53232",
		"#950505",
		"#CF7878",
		"#B55B5B",				
		);
	return $reds[$position];
}

function get_blues($position) {
	$blues = Array(
		"#1200FF",
		"#0004A9",
		"#715EFF",
		"#061C6C",
		"#00A6B5",
		"#008AFF",
		"#66D3FB",
		"#1200FF",
		"#0004A9",
		"#715EFF",
		"#061C6C",
		"#00A6B5",
		"#008AFF",
		"#66D3FB",
		"#1200FF",
		"#0004A9",
		"#715EFF",
		"#061C6C",
		"#00A6B5",
		"#008AFF",
		"#66D3FB",				
		);
	return $blues[$position];
}

function get_other($position) {

	$others = Array(
	"#00D952",
	"#F99608",
	"#D3CC00",
	"#BF00B4",
	"#6E037E",
	"#C55B06",
	"#00D952",
	"#F99608",
	"#D3CC00",
	"#BF00B4",
	"#6E037E",
	"#C55B06",
	"#00D952",
	"#F99608",
	"#D3CC00",
	"#BF00B4",
	"#6E037E",
	"#C55B06",
	);
	return $others[$position];

}


function votesort($a, $b) {
	
	if($a['votes'] < $b['votes']) {
		return 1;
	} elseif ($a['votes'] > $b['votes']) {
		return -1;
	}else {
		return 0;
	}
}

?>
<?php

//POST-2020 REDISTRICTING VERSION
global $endjava, $cmte_id, $hdr;
$endjava = Array();
//echo("<br>$st - $fourcode<br>");
Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;


//$cmte_id = $_GET['id'];


?>



@php ($book_side_nav_active = 'finance')

@extends('layouts.book')

@section('title', 'Recent FEC Form 2 Filings | California Target Book')

@section('content')




<?php 

//echo("<br>ID: $cmte_id $id");



$url = "http://198.74.49.22/ctb_f3_info_json.php?id=$id";
//echo("<br>$url<br>");
$curl = curl_init();

curl_setopt($curl, CURLOPT_HTTPHEADER, array(
          'Content-Type: application/json',
          'Accept: application/json'
      ));
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($curl);
curl_close($curl);

$json = $data;
$arr = json_decode($json, true);
$hdr = generate_header_elements($arr);
$summary_table = load_summary($arr);
$header_cards = generate_header_cards($arr);
krsort($arr['by_pd_end']);
$i = 0;



$detail_button = get_detail_button($id);
$nav_items = '';
$section_items = '';
foreach($arr['by_pd_end'] as $pd_end => $f) {
	if($i == 0) {
		$add_class = 'active';
	} else {
		$add_class = '';	
	}
	$filing_id = $f['filing_id'];
	$pd_start = $f['pd_start'];
	$year = mb_substr($f['pd_end'], 0, 4);
	$rpt = $f['rpt_code'];
	$this_span = "<span class='boldme border-bottom'>" . $year . "-" . $rpt . "</span><br><span class='small itcme'>$pd_start<br>$pd_end</span>";
	$target = 'f' . $filing_id;

	if(!empty($arr['finance'][$filing_id])) {
		$x = $arr['finance'][$filing_id];
		$html = generate_html($x);

		$nav_items .= "<li class='$add_class'>
				<a href='#" . $target . "' role='tab' data-toggle='tab' class='header-icon'>
					$this_span
				</a>
			</li>";
		$section_items .= "<section class='$add_class' id='$target'>
				$html
			    </section>";
	}
	$i++;	
}

?>

    <div>
        <div class="container-fluid pt-xl">
            
            <div class="row">
		<?php echo($header_cards); ?>
	    </div>
	    <div class='row'>
		
                <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-sm-12 center-block fn">
                	<div class='row'>
                		<div class='center-block'>
                			<?php echo($summary_table) ?>
                		</div>
                	</div>

		
                    <nav class='clearfix page-nav'>
                        <ul class="clearfix">
				<?php echo($nav_items); ?>                          
                        </ul>
                    </nav>

                    <div class="content-wrap pt-xl">
				<?php echo($section_items); ?>
                    </div>
                </div>
            </div>

			<div class='modal fade modal-1200' id='filing_modal' tabindex='-1' role='dialog' aria-labelledby='mlabel' aria-hidden='true' width='90vw'>
			    <div class='modal-dialog modal-1200'>
			        <div class='modal-content'>
			            <div class='modal-header modal-1200'>
			                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			            </div>
			            <div class='modal-body modal-1200'>
			                <h4 class='modal-title' id='mlabel'>Filing Detail</h4>
			                <iframe id='iframe_modal' src='/ctb-legacy/loading_spinner.php' class='modal-1200' height='1024' frameborder='0' sandbox='allow-same-origin allow-scripts allow-popups allow-forms allow-top-navigation' allowtransparency='true'></iframe>
			            </div>
			        </div>
			        <!-- /.modal-content -->
			    </div>
			    <!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->

			<div class='modal fade modal-1200' id='loader_modal' tabindex='-1' role='dialog' aria-labelledby='mlabel' aria-hidden='true' width='90vw'>
			    <div class='modal-dialog modal-1200'>
			        <div class='modal-content'>
			        <div class="spinner-border" role="status">
			            <span class="sr-only">Loading...</span>
			        </div>
			            <div class='modal-header modal-1200'>
			                <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
			            </div>
			            <div class='modal-body modal-1200'>
			                <h4 class='modal-title' id='mlabel'>Filing Detail</h4>
			                <iframe id='loader_iframe' src='/ctb-legacy/server_time.php' class='modal-1200' height='1024' frameborder='0' sandbox='allow-same-origin allow-scripts allow-popups allow-forms allow-top-navigation' allowtransparency='true'></iframe>
					<pre id='cl_output'></pre>
			            </div>
			        </div>
			        <!-- /.modal-content -->
			    </div>
			    <!-- /.modal-dialog -->
			</div>
			<!-- /.modal -->



			<div class='row'>
			<div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-sm-12 center-block fn">
				<div class='col-lg-2'>
					<br>
					<button id='button_loader' type='button' class='btn btn-primary' data-toggle='modal' data-target='#loader_modal'>
					<!--<button id='button_loader' type='button' class='btn btn-primary'>-->
						Load Expenditures
			     	        </button>
				</div>
				<div class='col-lg-2'>
					<br>
					<?php echo($detail_button); ?>
				</div>
			</div>
		</div>
        </div>


    </div>

<?php




    $js = "
            $(document).ready(function () {
               $('#button_loader').click(function() {
  			$('#loader_iframe').attr('src', 'https://calelections.com/test_live_cl.php?id=$id');
			//var wnd = window.open('/ctb-legacy/test_live_cl.php?id=$id');
			//wnd.close();
			//getOutput();
  		});
            });

    ";

    /*

               $('#button_loader').click(function() {

               		var timer;
         			timer=setInterval(makeRequest('/ctb-legacy/f3_getter.php?sid=$sid', function(response) {
             			document.getElementById('percentageDiv').innerHTML=response;
          			}),1000);               		
               		//alert('Running f3_exp_loader.php?id=$id');
  					//$('#loader_iframe').attr('src', '/ctb-legacy/f3_exp_loader.php?id=$id&sid=$sid');

 					makeRequest('/ctb-legacy/f3_exp_loader.php?id=$id&sid=$sid', function(response) {
             			document.getElementById('sumDiv').innerHTML='Total sum =' + response;
             			clearInterval(timer);
         			});



  				});


    */

  array_push($endjava, $js);

function generate_html($x) {
  switch($x['form_type']) {
    case "F3X":
    case "F3XA":
    case "F3XN":
    case "F3XT":
      $html = generate_f3x($x);
      break;
    case "F3P":
    case "F3PN":
    case "F3PA":
    case "F3PT":
      $html = generate_f3p($x);
      break;
    case "F3":
    case "F3N":
    case "F3A":
    case "F3T":
      $html = generate_f3($x);
      break;
    default: 
      return FALSE;
  }
  return $html;
}

function generate_f3x($x) {
  global $hdr;
  $a_keys = Array("individuals_itemized"   => "Contributions from Individuals (Itemized)", 
                  "individuals_unitemized" => "Contributions from Individuals (Un-Itemized)",
                  "individual_contribution_total"      => "Total Contributions from Individuals",
                  "political_party_committees"       => "Contributions from Party Committees",
                  "other_political_committees_pacs"                   => "Contributions from Other Political Committeees",
                  "transfers_from_aff_other_party_cmttees"           => "Transfers from Authorized Committees",
                  "total_loans"                         => "Total Loans",
                  "total_loan_repayments_received"    => "Total Loan Repayments Received",
                  "offset_to_expenditures"    => "Offsets to Operating Expenditures",
                  "federal_refunds"         => "Refunds of Contributions to Federal Cmtes",
                  "other_federal_receipts"                      => "Other Receipts",
                  "total_nonfederal_transfers"  => "Transfers from Non-Federal/Levin Funds",
                  "total_receipts"                      => "Total Receipts"
              );

  $b_keys = Array("total_operating_expenditures"        =>  "Operating Expenditures",
                  "transfers_to_affiliated"       =>  "Transfers to Affiliated Committees",
                  "contributions_to_candidates"    =>  "Contributions to Federal Candidates/Committees",
                  "independent_expenditures"    => "Independent Expenditures",
                  "coordinated_expenditures_by_party_committees" => "Coordinated Expenditures",
                  "loan_repayments_made"         =>  "Loan Repayments Made",
                  "loans_made"         =>  "Loans Made",
                  "refunds_to_individuals"        =>  "Contribution Refunds to Individuals",
                  "refunds_to_party_committees"   =>  "Contribution Refunds to Party Committees",
                  "refunds_to_other_committees"   =>  "Contribution Refunds to Other Committees",
                  "total_refunds"                 =>  "Total Contribution Refunds",
                  "other_disbursements"           =>  "Other Disbursements",
                  "total_disbursements"           =>  "Total Disbursements"
                  );

  $a_table = generate_itemized_table($a_keys, $x);
  $b_table = generate_itemized_table($b_keys, $x);
  $sum_keys = Array("col_a_cash_on_hand_beginning_period" => "CASH ON HAND START" , 
                    "col_a_total_receipts"                  => "TOTAL RECEIPTS THIS PERIOD",
                    "col_a_total_disbursements"             => "TOTAL EXPENDITURES THIS PERIOD",
                    "col_a_cash_on_hand_close_of_period"    => "CASH ON HAND END",
                    "col_a_debts_by"                        => "TOTAL DEBT"         
                    );
  $sum_table = generate_sum_table($sum_keys, $x);
  $trs_table = generate_cmte_info_table($x);

  $html = compile_div($hdr, $a_table, $b_table, $sum_table, $trs_table, $x['filing_id']);
  //echo(htmlspecialchars($html));
  return $html;  

}

function generate_f3p($x) {
  global $hdr;
  $a_keys = Array("individuals_itemized"   					=> "Contributions from Individuals (Itemized)", 
                  "individuals_unitemized" 					=> "Contributions from Individuals (Un-Itemized)",
                  "total_individual_contributions"      	=> "Total Contributions from Individuals",
                  "political_party_committees_receipts" 	=> "Contributions from Party Committees",
                  "other_political_committees_pacs"         => "Contributions from Other Political Committeees",
                  "transfers_from_aff_other_party_cmttees"  => "Transfers from Authorized Committees",
                  "the_candidate"             				=> "Contributions from the Candidate",
                  "received_from_or_guaranteed_by_cand"     => "Loans from the Candidate",
                  "other_loans"                         	=> "Loans from Others",
                  "total_loans"                         	=> "Total Loans",
                  "total_offsets_to_expenditures"    		=> "Offsets to Operating Expenditures",
                  "other_receipts"                      	=> "Other Receipts",
                  "total_receipts"                      	=> "Total Receipts"
              );

  $b_keys = Array("operating_expenditures"        =>  "Operating Expenditures",
                  "transfers_to_other_authorized_committees"       =>  "Transfers to Authorized Committees",
                  "made_or_guaranteed_by_candidate"     =>  "Repayment of Loans Made by Candidate",
                  "other_repayments"         =>  "Repayment of Loans Made by Others",
                  "total_loan_repayments_made"         =>  "Total Loan Repayments Made",
                  "individuals"        =>  "Contribution Refunds to Individuals",
                  "political_party_committees_refunds"   =>  "Contribution Refunds to Party Committees",
                  "other_political_committees"   =>  "Contribution Refunds to Other Committees",
                  "total_contributions_refunds"                 =>  "Total Contribution Refunds",
                  "other_disbursements"           =>  "Other Disbursements",
                  "total_disbursements"           =>  "Total Disbursements"
                  );

  $a_table = generate_itemized_table($a_keys, $x);
  $b_table = generate_itemized_table($b_keys, $x);
  $sum_keys = Array("col_a_cash_on_hand_beginning_period" => "CASH ON HAND START" , 
                    "col_a_total_receipts"                  => "TOTAL RECEIPTS THIS PERIOD",
                    "col_a_total_disbursements"             => "TOTAL EXPENDITURES THIS PERIOD",
                    "col_a_cash_on_hand_close_of_period"    => "CASH ON HAND END",
                    "col_a_debts_by"                        => "TOTAL DEBT"         
                    );
  $sum_table = generate_sum_table($sum_keys, $x);
  $trs_table = generate_cmte_info_table($x);

  $html = compile_div($hdr, $a_table, $b_table, $sum_table, $trs_table, $x['filing_id']);
  //echo(htmlspecialchars($html));
  return $html;
}

function generate_f3($x) {
  global $hdr;
  $a_keys = Array("individual_contributions_itemized"   => "Contributions from Individuals (Itemized)", 
                  "individual_contributions_unitemized" => "Contributions from Individuals (Un-Itemized)",
                  "total_individual_contributions"      => "Total Contributions from Individuals",
                  "political_party_contributions"       => "Contributions from Party Committees",
                  "pac_contributions"                   => "Contributions from Other Political Committeees",
                  "transfers_from_authorized"           => "Transfers from Authorized Committees",
                  "candidate_contributions"             => "Contributions from the Candidate",
                  "candidate_loans"                     => "Loans from the Candidate",
                  "other_loans"                         => "Loans from Others",
                  "total_loans"                         => "Total Loans",
                  "offset_to_operating_expenditures"    => "Offsets to Operating Expenditures",
                  "other_receipts"                      => "Other Receipts",
                  "total_receipts"                      => "Total Receipts"
              );

  $b_keys = Array("operating_expenditures"        =>  "Operating Expenditures",
                  "transfers_to_authorized"       =>  "Transfers to Authorized Committees",
                  "candidate_loan_repayments"    =>  "Repayment of Loans Made by Candidate",
                  "other_loan_repayments"         =>  "Repayment of Loans Made by Others",
                  "total_loan_repayments"         =>  "Total Loan Repayments Made",
                  "refunds_to_individuals"        =>  "Contribution Refunds to Individuals",
                  "refunds_to_party_committees"   =>  "Contribution Refunds to Party Committees",
                  "refunds_to_other_committees"   =>  "Contribution Refunds to Other Committees",
                  "total_refunds"                 =>  "Total Contribution Refunds",
                  "other_disbursements"           =>  "Other Disbursements",
                  "total_disbursements"           =>  "Total Disbursements"
                  );

  $a_table = generate_itemized_table($a_keys, $x);
  $b_table = generate_itemized_table($b_keys, $x);
  $sum_keys = Array("col_a_cash_beginning_reporting_period" => "CASH ON HAND START" , 
                    "col_a_total_receipts"                  => "TOTAL RECEIPTS THIS PERIOD",
                    "col_a_total_disbursements"             => "TOTAL EXPENDITURES THIS PERIOD",
                    "col_a_cash_on_hand_close_of_period"    => "CASH ON HAND END",
                    "col_a_debts_by"                        => "TOTAL DEBT"         
                    );
  $sum_table = generate_sum_table($sum_keys, $x);
  $trs_table = generate_cmte_info_table($x);

  $html = compile_div($hdr, $a_table, $b_table, $sum_table, $trs_table, $x['filing_id']);
  //echo(htmlspecialchars($html));
  return $html;
}

function compile_div($hdr, $a_table, $b_table, $sum_table, $trs_table, $filing_id) {

  global $endjava;
  $html = "<div class='outer_container' align='center'>
            <div class='cmte_headline'>" . $hdr['cmte_nm'] . "</div>
            <div class='cmte_subhead'>
              <div class='cmte_description'>" . $hdr['cmte_dscr'] . "</div>";

  if(!empty($hdr['cand_dscr'])) {
    $html .= "<div class='cand_description'>" . $hdr['cand_dscr'] . "</div>";
  }
  $html .= "</div>";
  $html .= "<div class='report_info'>" . $trs_table . "</div>";
  $html .= "<div class='detail_row'>
            <div class='a_div'>
              <h3 class='rcpt_smry_headline'>Contribution Summary</h3>
              <div class='table-striped2'>
                $a_table 
              </div>
            </div>
            <div class='b_div'>
              <h3 class='expn_smry_headline'>Expenditure Summary</h3>
              <div class='table-striped2'>
                $b_table 
              </div>
            </div>
          </div>
            <div class='clearfix'></div>
            <div class='smry_div table-striped2'>
              $sum_table 
            </div>

        <p align='center'>
 	    <button id='button_" . $filing_id . "' type='button' class='btn btn-primary' data-toggle='modal' data-target='#filing_modal'>
		View Filing $filing_id
	    </button>
	    </p>
	  </div>


";

    $js = "
            $(document).ready(function () {
               $('#button_" . $filing_id . "').click(function() {
					 
  					$('#iframe_modal').attr('src', '/ctb-legacy/test_parse.php?id=$filing_id');
  				});
            });

    ";

  array_push($endjava, $js);


  return $html;            

}

function load_summary($arr) {

	foreach($arr['by_pd_end'] as $end_date => $x) {
		$filing_id = $x['filing_id'];
		if(!empty($arr['finance'][$filing_id])) {
		     $smry[$filing_id] = summary_process($arr['finance'][$filing_id]);
		}
	}


	$nan = Array(
		"FILING" => TRUE,
		"RPT"	=> TRUE,
		"PD START" => TRUE,
		"PD END" => TRUE
		);
	$table = "<table class='table-striped2 table-fit small'>
				<thead class='bg-dark text-white'>
					<tr>";

	$thead = '';
	foreach($smry as $filing_id => $x) {
		if(empty($thead)) {
			foreach($x as $key => $ignore) {
				$key_arr[$key] = $key;
				$thead .= "<th>$key</th>";
			}
		}
		break;
	}
	$table .= $thead . "</tr><tbody>";
	foreach($smry as $filing_id => $x) {
		$table .= "<tr>";
		foreach($x as $k => $v) {
			if(isset($nan[$k])) {
				if($k == "PD START" || $k == "PD END") {
					$table .= "<td>" . date_convert($v) . "</td>";
				} else {
					$table .= "<td>$v</td>";
				}
			} else {
				$table .= "<td align='right'>\$" . number_format($v) . "</td>";
				if(mb_substr($k, 0, 3) != "COH") {
					if(!isset($life[$k])) {
					     $life[$k] = 0;
					}
					$life[$k] += $v;
				}
			}
		}
		$table .= "</tr>";
	}
	$table .= "</tbody>
			   <tfoot>
			   		<tr class='boldme'>";

	foreach($key_arr as $key => $ignore) {
		if(!empty($life[$key])) {
			$table .= "<td align='right'>\$" . number_format($life[$key]) . "</td>";
		} else {
			$table .= "<td></td>";
		}
	}
	$table .= "</tr>
			</tfoot>
			</table>";
	return $table;			
}

function summary_process($x) {
	switch($x['form_type']) {
		case "F3X":
		case "F3XN":
		case "F3XA":
		case "F3XT":
			$keys = Array(
				"FILING" 		=> "filing_id",
				"RPT"	 		=> "report_code",
				"PD START" 		=> "coverage_from_date",
				"PD END"		=> "coverage_through_date",
				"COH START"		=> "col_a_cash_on_hand_beginning_period",
				"IND (ITEM)"	=> "col_a_individuals_itemized",
				"IND (UN)"		=> "col_a_individuals_unitemized",
				"CMTE RCPT"		=> "col_a_other_political_committees_pacs",
				"XFER IN"		=> "col_a_transfers_from_aff_other_party_cmttees",
				"LOAN"			=> "col_a_total_loans",
				"OTH RCPT"		=> "col_a_other_federal_receipts",
				"RCPT TOT"		=> "col_a_total_receipts",
				"OPEXP"			=> "col_a_total_operating_expenditures",
				"XFER OUT"		=> "col_a_transfers_to_affiliated",
				"CMTE CTRIB"	=> "col_a_contributions_to_candidates",
				"IE"			=> "col_a_independent_expenditures",
				"REFUND"		=> "col_a_total_refunds",
				"OTH EXPN"		=> "col_a_other_disbursements",
				"EXPN TOT"		=> "col_a_total_disbursements",
				"COH END"		=> "col_a_cash_on_hand_close_of_period"
				);
			break;
		case "F3":
		case "F3N":
		case "F3A":
		case "F3T":
			$keys = Array(
				"FILING" 		=> "filing_id",
				"RPT"	 		=> "report_code",
				"PD START" 		=> "coverage_from_date",
				"PD END"		=> "coverage_through_date",
				"COH START"		=> "col_a_cash_beginning_reporting_period",
				"IND (ITEM)"	=> "col_a_individual_contributions_itemized",
				"IND (UN)"		=> "col_a_individual_contributions_unitemized",
				"CMTE RCPT"		=> "col_a_pac_contributions",
				"XFER IN"		=> "col_a_transfers_from_authorized",
				"LOAN"			=> "col_a_total_loans",
				"OTHER"			=> "col_a_other_receipts",
				"RCPT TOT"		=> "col_a_total_receipts",
				"OPEXP"			=> "col_a_operating_expenditures",
				"XFER OUT"		=> "col_a_transfers_to_authorized",
				"CMTE CTRIB"	=> "col_a_contributions_to_candidates",
				"REFUND"		=> "col_a_total_refunds",
				"OTHER"			=> "col_a_other_disbursements",
				"EXPN TOT"		=> "col_a_total_disbursements",
				"COH END"		=> "col_a_cash_on_hand_close_of_period"				
				);
			break;
		case "F3P":
		case "F3PN":
		case "F3PA":
		case "F3PT":
			$keys = Array(
				"FILING" 		=> "filing_id",
				"RPT"	 		=> "report_code",
				"PD START" 		=> "coverage_from_date",
				"PD END"		=> "coverage_through_date",
				"COH START"		=> "col_a_cash_on_hand_beginning_period",
				"IND (ITEM)"	=> "col_a_individuals_itemized",
				"IND (UN)"		=> "col_a_individuals_unitemized",
				"CMTE RCPT"		=> "col_a_other_political_committees_pacs",
				"XFER IN"		=> "col_a_transfers_from_aff_other_party_cmttees",
				"LOAN"			=> "col_a_total_loans",
				"OTH RCPT"			=> "col_a_other_receipts",
				"RCPT TOT"		=> "col_a_total_receipts",
				"OPEXP"			=> "col_a_operating_expenditures",
				"XFER OUT"		=> "col_a_transfers_to_other_authorized_committees",
				"CMTE CTRIB"	=> "",
				"IE"			=> "",
				"REFUND"		=> "col_a_total_contributions_refunds",
				"OTHER"			=> "col_a_other_disbursements",
				"EXPN TOT"		=> "col_a_total_disbursements",
				"COH END"		=> "col_a_cash_on_hand_close_of_period"				
				);
		break;
	}
	foreach($keys as $k => $k2) {
		if(!empty($x[$k2])) {
			$retval[$k] = $x[$k2];
		}
	}
	return $retval;
}

function get_detail_button($cmte_id) {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT COUNT(id) as count FROM ctb_f3_exp_tmp WHERE cmte_id = '$cmte_id'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row['count'] > 0) {
				return "<a href='/book/f3_tmp_exp/$cmte_id' target='_blank'><button class='btn btn-lg btn-info'>View " . number_format($row['count']) . " transactions</button></a>";
			}
		}
		return FALSE;
	}
}

function generate_address($addr1, $addr2, $city, $state, $zip) {
	if(!empty($addr2)) {
		return $addr1 . " " . $addr2 . "<br>" . $city . ", " . $state . " " . $zip;
	} else {
		return $addr1 . "<br>" . $city . ", " . $state . " " . $zip;
	}
}

function generate_header_elements($arr) {
  $x = $arr['cmte_info'];

  $cmte_nm = $x['committee_name'];
  $cmte_id = $x['filer_committee_id_number'];
  $cmte_dscr = decode_cmte_type($arr['cmte_info']['committee_type']);


  if(!empty($arr['cand_info'])) {
    $y = $arr['cand_info'];
    $cand_nm = generate_name($y['candidate_prefix'], $y['candidate_first_name'], $y['candidate_middle_name'], $y['candidate_last_name'], $y['candidate_suffix']);
    switch($y['candidate_office']) {
      case "H":
        $fourcode = $y['candidate_state'] . $y['candidate_district'];
        break;
      case "S":
        $fourcode = $y['candidate_state'] . "SEN";
        break;
      case "P":
        $fourcode = "POTUS";
        break;
    }
    $party = $y['candidate_party_code'];
    $year = $y['election_year'];
    $id = $y['candidate_id_number'];

    $cand_span = $cand_nm . " (<span class='$party'>" . $party . "</span>)<br>" . $fourcode . " - " . $year . " Election";
  } elseif(!empty($arr['leadership']) || $x['leadership_pac'] == "X") {
    if(!empty($arr['leadership'])) {
        $cmte_dscr = "LEADERSHIP PAC - " . $arr['leadership']['sponsor'];
    } else {
      $cmte_dscr = "LEADERSHIP PAC - " . generate_name($x['affiliated_prefix'], $x['affiliated_first_name'], $x['affiliated_middle_name'], $x['affiliated_last_name'], $x['affiliated_last_name']);
      if(!empty($x['party_code'])) {
        $cmte_dscr .= " - " . $x['party_code'];
      }
    }
  }

  if(!empty($x['organization_type'])) {
    $cmte_dscr .= " - " . decode_org_type($x['organization_type']);
  }

  $retval['cmte_nm'] = $cmte_nm;
  $retval['cmte_id'] = $cmte_id;
  $retval['cmte_dscr'] = $cmte_dscr;
  if(!empty($cand_span)) {
       $retval['cand_dscr'] = $cand_span;
  }

  return $retval;

}

function decode_cmte_type($type) {
  $arr = Array(
    "A" => "Principal Campaign Cmte",
    "B" => "Authorized Cmte",
    "C" => "Sup/Opp Single Cand (Not Auth)",
    "D" => "Party Cmte",
    "E" => "Sep Seg Fund",
    "F" => "Sup/Opp Mult Cand",
    "G" => "IE SuperPAC",
    "H" => "Hybrid PAC",
    "I" => "Joint Fund Cmte (Auth)" ,
    "J" => "Joint Fund Cmte (Not Auth)"
    );
  return $arr[$type];
}

function decode_org_type($type) {
  $arr = Array(
    "C" => "Corporation",
    "T" => "Trade Assn",
    "L" => "Labor Org",
    "M" => "Member Org",
    "V" => "Cooperative",
    "W" => "Corp. w/o Cap Stock"
    );
  return $arr[$type];
}

function generate_header_cards($arr) {

	$x = '';
	$c = '';
	$l = '';

	if(!empty($arr['cmte_info'])) {
		$x = $arr['cmte_info'];
	}

	if(!empty($arr['cand_info'])) {
		$c = $arr['cand_info'];
	}
	if(!empty($arr['leadership'])) {
		$l = $arr['leadership'];
	}

	$p1 = '';
	$p2 = '';
	$p3 = '';
	$p4 = '';
	$p5 = '';
	$p6 = '';

	$p1 = "<div class='col-lg-3 col-md-4 col-sm-6'>
		<div class='panel'>
		  <h3 align='left'>" . $x['committee_name'] . "</h3>
		  <h4 align='left'>" . $x['filer_committee_id_number'] . "</h4>";

	$type = decode_cmte_type($x['committee_type']);
	if(!empty($x['organization_type'])) {
		$type .= " - " . decode_org_type($x['organization_type']);
	}
	if(!empty($x['leadership_pac'])) {
		$type .= "<br>Leadership PAC";
	}
	if(!empty($x['lobbyist_registrant_pac'])) {
		$type .= "<br>Lobbyist Registrant PAC";
	}
	$p1 .= "<h4 align='left'>$type</h4>";
	$p1 .= "</div>
		</div>";

	$addr = generate_address($x['street_1'], $x['street_2'], $x['city'], $x['state'], $x['zip_code']);

	$p2 = "<div class='col-lg-3 col-md-4 col-sm-6'>
		<div class='panel'>
		  <h5>$addr";

	if(!empty($x['committee_email'])) {
		$p2 .= "<br>" . $x['committee_email'];
	}

	if(!empty($x['committee_url'])) {
		$p2 .= "<br>" . $x['committee_url'];
	}
	$p2 .= "</div>
		</div>";
	if(!empty($c) || !empty($l) || !empty($x['candidate_office'])) {
		if($c['candidate_office']) {
			$cand_nm = generate_name($c['candidate_prefix'], $c['candidate_first_name'], $c['candidate_middle_name'], $c['candidate_last_name'], $c['candidate_suffix']);
			if(!empty($c['candidate_id_number'])) {
				$cand_id = "<br>" . $c['candidate_id_number'];
			}
			switch($c['candidate_office']) {
				case "H":
					$fourcode = $c['candidate_state'] . $c['candidate_district'];
					break;		
				case "S":
					$fourcode = $c['candidate_state'] . "SEN";
					break;			
				case "P":
					$fourcode = "POTUS";
					break;
			}
			if(!empty($c['candidate_party_code'])) {
				$cand_nm .= " (<span class='" . $c['candidate_party_code'] . "'>" . $c['candidate_party_code'] . "</span>)";
			}
			$cand_election = "<br>" . $fourcode . " - " . $c['election_year'] . " Election";
			$p3 = "<div class='col-lg-3 col-md-4 col-sm-6'>
					<div class='panel'>
					  <h5>" . $cand_nm . $cand_id . $cand_election . "</h5>
					</div>
				</div>";
		}
	}	
	

	return $p1 . $p2 . $p3 . $p4 . $p5 . $p6;
}

function date_convert($str) {
  $year = mb_substr($str, 0, 4);
  $month = mb_substr($str, 4, 2);
  $day = mb_substr($str, 6, 2);
  return $year . "-" . $month . "-" . $day;
}

function generate_name($prefix, $first, $middle, $last, $suffix) {
  $retval = $prefix;
  if($prefix) {
    $retval .= " ";
  }
  $retval .= $first;
  if($middle) {
    $retval .= " ";
  }
  $retval .= $middle;
  if($last) {
    $retval .= " ";
  }
  $retval .= $last;

  if($suffix) {
    $retval .= " " . $suffix;
  }
  return $retval;
}

function generate_cmte_info_table($x) {

  if($x['change_of_address']) {
    $add_class = 'itcme';
  } else {
    $add_class = '';
  }

  $street = $x['street_1'];
  if($x['street_2']) {
    $street .= " " . $x['street_2'];
  }
  $city_st_zip = $x['city'] . ", " . $x['state'] . " " . mb_substr($x['zip_code'], 0, 5);
  if($x['report_code'] == "TER") {
    $rpt_code = "<span class='redme boldme'>* * * TERMINATION REPORT * * *</span>";
  } else {
    $rpt_code = $x['report_code'];
  }
  $coverage = "Period Starting <span class='greenme boldme'>" . date_convert($x['coverage_from_date']) . "</span> and Ending <span class='greenme boldme'>" . date_convert($x['coverage_through_date']) . "</span>";
  $trs_info = "Filed by " . generate_name($x['treasurer_prefix'], $x['treasurer_first_name'], $x['treasurer_middle_name'], $x['treasurer_last_name'], $x['treasurer_suffix']) . " on " . date_convert($x['date_signed']);

  $retval = "<div class='cmte_info_div'>
              $street
              <br>$city_st_zip
              <br>$rpt_code
              <br>$coverage 
              <br>$trs_info
            </div>";
  return $retval;            
}

function generate_sum_table($keys, $x) {
  $table = "<table>
              <tbody>";
  foreach($keys as $key => $verbose)               {
    $table .= "<tr class='boldme'>
                <td>$verbose</td>
                <td align='right'>\$" . number_format($x[$key],2) . "</td>
              </tr>";
  }
  $table .= "</tbody></table>";
  return $table;
}

function generate_itemized_table($keys, $x) {

  $table = "<table>
              <thead class='bg-dark text-white'>
                <tr>
                  <th></th>
                  <th>THIS PERIOD</th>
                  <th>THIS ELECTION</th>
                </tr>
              </thead>
              <tbody>";

  foreach($keys as $key => $verbose) {
    $a_key = "col_a_" . $key;
    $b_key = "col_b_" . $key;
    $a_value = 0;
    $b_value = 0;

    if(!empty($x[$a_key])) {
	$a_value = $x[$a_key];
    }
    if(!empty($x[$b_key])) {
	$b_value = $x[$b_key];
    }

    $table .= "<tr>
                  <td class='text-left'>$verbose</td>
                  <td align='right'>\$" . number_format($a_value,2) . "</td>
                  <td align='right'>\$" . number_format($b_value,2) . "</td>
                </tr>";
  }
  $table .= "</tbody>
          </table>";
  return $table;          

}


?>


@endsection

@section('scripts')

    <script>
	var last_length = 0;
	var last_data = '';
	var current_length = 0;
	var current_data = '';

	function getOutput() {
		$.ajax({
			url: '/ctb-legacy/test_live_cl2.php',
			success: function(data) {
				current_data = data;
				current_length = data.length;
				if(last_length > 0 && last_length < current_length) {
					append_text = current_data.replace(last_data, "");				
				} else {
					append_text = data;
				}
				console.log('DATA: ', data);
				console.log('current_length', current_length, 'last_length',last_length);
				console.log('append_text', append_text);
				$('#cl_output').append(append_text);
				last_length = current_length;
				last_data = current_data;
				setTimeout(getOutput, 1000);
			}
		});
	}

    </script>
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
        //runme1();
        //runme2();
      }


      function runme2() {
        $('input[name="scope2"]').click(function () {

          //alert('CLICK');


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




	    function makeRequest(toPHP, callback) {
	    	//alert(toPHP);
	        var xmlhttp;
	        if (window.XMLHttpRequest)
	          {// code for IE7+, Firefox, Chrome, Opera, Safari
	          xmlhttp=new XMLHttpRequest();
	          }
	        else
	          {// code for IE6, IE5
	          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	          }
	        xmlhttp.onreadystatechange=function()
	          {
	              if (xmlhttp.readyState==4 && xmlhttp.status==200)
	                {
	                    callback(xmlhttp.response);
	                }
	          }
	        xmlhttp.open("GET",toPHP,true);
	        xmlhttp.send();
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

    @import url('https://fonts.googleapis.com/css2?family=Open+Sans&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Blinker&display=swap');


h2, h3, h4, h5, h6 {
  font-family: 'Blinker';
  font-weight: bold;
 
  font-variant: small-caps;
}

.outer_container {
  float: none;
  clear: both;
  width: 1400px;
  height: 1000px;
  border: 5px solid black;
  border-radius: 20px;
}
.cmte_headline {
  font-size: 4em;
  font-weight: bold;
  font-family: 'Open Sans';
  font-variant: small-caps;
}

.cmte_subhead {
  font-weight: bold;
  line-height: 1.1em;
  font-family: 'Blinker';
}
.cmte_description {}
.cand_description {}
.report_info {
  border: 2px solid black;
  display: inline-block;
  font-size: 0.8em;
  line-height: 1.1em;
  padding: 5px;
  margin-top: 10px;
}
.detail_row{
  width: 100%;
  margin-left: 10px;
  margin-right: 10px;
  text-align: center;
  height: 400px;
}

.detail_row table {
  border: 2px solid black;
  font-family: 'Lato';
  font-size: 1.1em;
  line-height: 1.4em;
}
.a_div{
  float: left;
  margin-left: 20px;
  
}
.b_div{
  float: right;
  margin-right: 30px;
  
}
.rcpt_smry_headline {}
.expn_smry_headline {}
.smry_div {
  font-family: 'Lato';
  font-size: 1.6em;
  border: 2px solid black;
  display: inline-block;
  margin-top: 20px;
}

.text-left {
  text-align: left !important;
}

.greenme {
  color: green;
}

.REP {
  color: red;
}

.DEM, .DFL {
  color: blue;
}

.boldme {
  font-weight: bold;
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

    .border-bottom {
	border-bottom: 2px solid gray !important;
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

	.modal-1200 {
		min-width: 90vw !important;
	}

     body {
	background-color: white !important;
     }


    </style>


@endsection



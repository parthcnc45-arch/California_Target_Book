@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', '2024 Ballot Measure Finances | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        2024 Ballot Measure Finances
    </h2>

<?php

Util::require_ctb_api();
$endjava = Array();
global $pages, $prop_arr, $fed_filed;

$props = get_props();
$cmtes = get_cmtes($prop_arr);

$statuses = [
  "101" => "SUMMARY",
  "100" => "QUALIFIED",
  "25"  => "25% THRESHOLD",
  "1"   => "IN CIRCULATION",
  "2"   => "SUBMITTED",
];

$prop_index_all = [];
$prop_spend = [];
$prop_spend_tot = [];
$div_index = [];
$div_index_amt = [];
$summary_row = "";
$page = [];
$nav_draw = "";
$enddraw = "";
$sup_tot = 0;
$opp_tot = 0;
$count = 0;

foreach ($props as $status => $arr) {
  foreach ($arr as $id => $x) {
    $prop_index_all[$id] = $x;
    $prop_div = "<h3 align='center'>" . $x['prop_nm'] . "</h3>";
    $prop_id = $x['prop_id'];
    $prop_url = "<a href='/book/propositions/$prop_id' target='_blank'>$prop_id</a>";
    $total_spend = 0;
    $title = $x['prop_nm'];
    if(!empty($cmtes[$id])) {
      foreach ($cmtes[$id] as $position => $arr2) {
        $span_class = ($position == "SUPPORT") ? 'greenme' : 'redme';
        $prop_div .= "<hr /><h4 align='center' class='$span_class'>$position</h4>";

        foreach ($arr2 as $cmte_id => $y) {
          $s = get_cmte_summary($cmte_id);
          $cmte_url = "<a href='/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>$cmte_id</a>";
          $filing_url = isset($s['LAST_FILING']) ? "<a href='https://cal-access.sos.ca.gov/PDFGen/pdfgen.prg?filingid=" . $s['LAST_FILING'] . "' target='_blank'>" . $s['LAST_FILING'] . "</a>" : "NO RPT YET";

          $table = "<p align='center'>" . $y['cmte_nm'] . "</p>
                    <div class='table-responsive'>
                    <table align='center' class='table table-striped table-hover table-fit'>
                      <thead>
                        <tr>
                          <th>CMTE ID</th>
                          <th>LAST RPT</th>
                          <th>RAISED LAST</th>
                          <th>RAISED SINCE</th>
                          <th>RAISED TOTAL</th>
                          <th>SPENT TOTAL</th>
                          <th>DEBTS</th>
                          <th>LOANS</th>
                          <th>LAST COH</th>
                          <th>RPT DATE</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td align='left'>$cmte_url</td>
                          <td align='left'>$filing_url</td>
                          <td align='right'>\$" . number_format($s['LAST_RCPT'] ?? 0) . "</td>
                          <td align='right'>\$" . number_format($s['LATE_CONTRIBUTIONS'] ?? 0) . "</td>
                          <td align='right' class='boldme'>\$" . number_format($s['LIFETIME_RCPT'] ?? 0) . "</td>
                          <td align='right'>\$" . number_format($s['LIFETIME_EXPN'] ?? 0) . "</td>
                          <td align='right'>\$" . number_format($s['DEBTS'] ?? 0) . "</td>
                          <td align='right'>\$" . number_format($s['LOANS'] ?? 0) . "</td>
                          <td align='right'>\$" . number_format($s['COH'] ?? 0) . "</td>
                          <td align='left'>" . ($s['LAST_DATE'] ?? '') . "</td>
                        </tr>
                      </tbody>
                    </table>
                    </div>";

          $total_spend += $s['LIFETIME_RCPT'] ?? 0;
          $prop_spend[$prop_id][$position] = ($prop_spend[$prop_id][$position] ?? 0) + ($s['LIFETIME_RCPT'] ?? 0);
          $prop_spend_tot[$prop_id] = ($prop_spend_tot[$prop_id] ?? 0) + ($s['LIFETIME_RCPT'] ?? 0);
          $short_cmte_url = "<a href='/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>" . mb_substr($y['cmte_nm'], 0, 64) . "</a>";

          $one_letter = mb_substr($position, 0, 1);
          $summary_row .= "<tr title='$title'>
                            <td>$prop_url</td>
                            <td>$short_cmte_url</td>
                            <td>$one_letter</td>
                            <td align='right'>\$" . number_format($s['LAST_RCPT'] ?? 0) . "</td>
                            <td align='right'>\$" . number_format($s['LATE_CONTRIBUTIONS'] ?? 0) . "</td>
                            <td align='right' class='boldme'>\$" . number_format($s['LIFETIME_RCPT'] ?? 0) . "</td>
                            <td align='right'>\$" . number_format($s['LIFETIME_EXPN'] ?? 0) . "</td>
                            <td align='right'>\$" . number_format($s['COH'] ?? 0) . "</td>
                            <td align='left'>" . ($s['LAST_DATE'] ?? '') . "</td>
                          </tr>";
          $prop_div .= $table;
        }
      }
    }

    $div_index[$status][$id] = $prop_div;
    $div_index_amt[$status][$id]['AMOUNT'] = $total_spend;
  }
}

$prop_summary_table = "<table class='table table-striped table-hover table-fit' v-ctb-table>
                        <thead>
                          <tr>
                            <th>PROP #</th>
                            <th>PROP ID</th>
                            <th>DSCR</th>
                            <th>SUPPORT</th>
                            <th>OPPOSE</th>
                            <th>TOTAL</th>
                          </tr>
                        </thead>
                        <tbody>";

foreach ($prop_index_all as $prop_id => $x) {
  $support_amount = $prop_spend[$prop_id]['SUPPORT'] ?? 0;
  $oppose_amount = $prop_spend[$prop_id]['OPPOSE'] ?? 0;

  $sup_tot += $support_amount;
  $opp_tot += $oppose_amount;

  $prop_summary_table .= "<tr>
                            <td>" . ($x['ballot_no'] ?? '') . "</td>
                            <td><a href='/book/propositions/$prop_id' target='_blank'>$prop_id</a></td>
                            <td>" . mb_substr($x['prop_nm'], 0, 128) . "</td>
                            <td align='right'>\$" . number_format($support_amount) . "</td>
                            <td align='right'>\$" . number_format($oppose_amount) . "</td>
                            <td align='right'>\$" . number_format($support_amount + $oppose_amount) . "</td>
                          </tr>";
}

$prop_summary_table .= "</tbody>
                        <tfoot>
                          <tr class='boldme'>
                            <td colspan='3'>TOTAL</td>
                            <td align='right'>\$" . number_format($sup_tot) . "</td>
                            <td align='right'>\$" . number_format($opp_tot) . "</td>
                            <td align='right'>\$" . number_format($sup_tot + $opp_tot) . "</td>
                          </tr>
                        </tfoot>
                      </table>";

$summary_table = "<table class='table table-striped table-hover table-fit' v-ctb-table>
                    <thead>
                      <tr>
                        <th>PROP ID</th>
                        <th>CMTE</th>
                        <th>SUP/OPP</th>
                        <th class='rightme'>RAISED LAST</th>
                        <th class='rightme'>RAISED SINCE</th>
                        <th class='rightme'>RAISED TOT</th>
                        <th class='rightme'>SPENT TOT</th>
                        <th class='rightme'>LAST COH</th>
                        <th>LAST RPT</th>
                      </tr>
                    </thead>
                    <tbody>$summary_row</tbody>
                  </table>";

$page[101] = "<div class='prop_div'>
                <h2 align='center'>BALLOT MEASURE SUMMARY</h2>
                <div class='table-responsive'>
                  $prop_summary_table
                </div>
                <hr />
                <h2 align='center'>COMMITTEE SUMMARY</h2>
                <div class='table-responsive'>
                  $summary_table
                </div>
              </div>";

foreach ($statuses as $status => $verbose) {
  if (!empty($div_index_amt[$status])) {
    uasort($div_index_amt[$status], function($a, $b) {
      return $b['AMOUNT'] <=> $a['AMOUNT'];
    });
    $page[$status] = '';
 
   foreach ($div_index_amt[$status] as $id => $x) {
     $link = "<a href='/book/propositions/$id' target='_blank'>$id</a>";
     $page[$status] .= "<div class='prop_div'><h3 align='center'>Prop $link</h3>";
     $page[$status] .= "<h3 align='center' class='boldme'>\$" . number_format($x['AMOUNT']) . " Raised by All Committees</h3>";
     $page[$status] .= $div_index[$status][$id];
     $page[$status] .= "</div>";
   }
  }
}

foreach ($statuses as $section => $verbose) {
  $count++;
  if(empty($page[$section])) {
	$page[$section] = '';
  }
  $active_class = ($count == 1) ? 'active' : '';

  $nav_draw .= "<li class='$active_class'>
                  <a href='#p$section' role='tab' data-toggle='tab' class='header_icon'>
                    <i class='material-icons header_icon'>local_atm</i>
                    $verbose
                  </a>
                </li>";

  $enddraw .= "<section id='p$section' class='$active_class'>
                  <div class='prop_div' align='center'>
                    <h2>$verbose</h2>
                    <div class='panel justifyme'>" . 
                      $page[$section] . "
                    </div>
                  </div>
                </section>";
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

/*
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

   if($section == "CONSTITUTIONAL") {

        foreach($c_order as $fourcode => $verbose2) {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN CONSTITUTIONAL PANEL DIV -->
                        <p style = 'text-align: center !important;'>$verbose2</p>";
          
          $enddraw .= get_state($fourcode, $section);
          $enddraw .= "</div> <!--END CONSTITUTIONAL PANEL DIV -->";


        }
        $enddraw .= "</div><!--END PROP DIV-->
                  </section><!--END CONSTITUTITONAL SECTION-->";

   } elseif($section == "ASSEMBLY") {
      foreach($pages['ASSEMBLY'] as $fourcode => $ignore) {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN ASSEMBLY PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode</p>";         
          $enddraw .= get_state($fourcode, $section);
          $enddraw .= "</div> <!--END ASSEMBLY PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END ASSEMBLY SECTION-->";
  } elseif($section == "SENATE") {
      foreach($pages['SENATE'] as $fourcode => $ignore) {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN SENATE PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode</p>";         
          $enddraw .= get_state($fourcode, $section);
          $enddraw .= "</div> <!--END SENATE PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END SENATE SECTION-->";


  } elseif($section == "BOE") {
      foreach($pages['BOE'] as $fourcode => $ignore) {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN BOE PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode</p>";         
          $enddraw .= get_state($fourcode, $section);
          $enddraw .= "</div> <!--END BOE PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END BOE SECTION-->";


  } elseif($section == "CONGRESS") {
      foreach($pages['CONGRESS'] as $fourcode => $ignore) {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN US CONGRESS PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode</p>";         
          $enddraw .= get_fed($fourcode, $section);
          $enddraw .= "</div> <!--END US CONGRESS PANEL DIV -->";
      }
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END US CONGRESS SECTION-->";

  } elseif($section == "US_SENATE") {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN US SENATE PANEL DIV -->
                        <p style = 'text-align: center !important;'>$fourcode</p>";         
          $enddraw .= get_fed(".SN2", $section);
          $enddraw .= "</div> <!--END US SENATE PANEL DIV -->";
          $enddraw .= "</div><!--END PROP DIV-->  
              </section><!--END BOE SECTION-->";          

  }


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

*/

//$conn = Util::get_ctb_conn();




function get_colors($section) {
  switch($section) {
    case "ASSEMBLY":
      //DARK BLUE - ASSEMBLY
      $head = "#00334d";
      $columns = Array("#ffffff", "#e6f7ff", "#cceeff", "#b3e6ff", "#99ddff", "#80d4ff", "#66ccff", "#4dc3ff", "#f0f0f5");
      //$columns = Array("#ffffff", "#e6e6ff", "#ccccff", "#b3b3ff", "#9999ff", "#8080ff", "#6666ff", "#4d4dff", "#f0f0f5");
      break;
    case "SENATE":
      //DARK GREEN - STATE SENATE
      $head = "#133913";
      $columns = Array("#ffffff", "#ecf9ec", "#d9f2d9", "#c6ecc6", "#b3e6b3", "#9fdf9f", "#8cd98c", "#79d279", "#f0f0f5");
      break;
    case "CONSTITUTIONAL":
      //DARK PURPLE - CONSTITUTIONAL
      $head = "#330033";
      $columns = Array("#ffffff", "#ffe6ff", "#ffccff", "#ffb3ff", "#ff99ff", "#ff80ff", "#ff66ff", "#ff4dff", "#f0f0f5");
      break;
    case "BOE":
      //DARK BROWN - BOARD OF EQUALIZATION
      $head = "#4d3900";
      $columns = Array("#ffffff", "#fff9e6", "#fff2cc", "#ffecb3", "#ffe699", "#ffdf80", "#ffd966", "#ffd24d", "#f0f0f5");
      break;
    case "CONGRESS":
      //DARK RED - CONGRESS
      $head = "#4d0000";
      $columns = Array("#ffffff", "#ffffff", "#ffe6e6", "#ffb3b3", "#ff9999", "#ff8080", "#f0f0f5");
      break;
    case "US_SENATE":
      //ORANGE - US CSENATE
      $head = "#4d1f00";
      $columns = Array("#ffffff", "#ffffff", "#fff0e6", "#ffe0cc", "#ffd1b3", "#ffc299", "#f0f0f5");
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

function get_cmtes($props) {
  $conn = Util::get_ctb_conn();
  $q = '';
  foreach($props as $prop_id => $ignore) {
    $q .= " (prop_id = '$prop_id') ||";
  }
  $q = substr($q, 0, -2);
  $sql = "SELECT prop_id, cmte_id, cmte_nm, cmte_position
          FROM ctb_ca_props_pending_ccl
          WHERE ( $q )";
  //echo("<br>$sql<br>");
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $prop_id = $row['prop_id'];
      $cmte_id = $row['cmte_id'];
      $position = $row['cmte_position'];

      $retval[$prop_id][$position][$cmte_id] = $row;
    }
  }
  return $retval;
}

function get_props() {
  global $prop_arr;
  $conn = Util::get_ctb_conn();
  $sql = "SELECT prop_id, fppc_id, ballot_no, prop_dscr, prop_status, prop_nm, sigs_needed, sigs_deadline, session, sigs_submitted, sigs_valid
          FROM ctb_ca_props_pending 
          WHERE session = 2023 && prop_status != 0 && prop_id != 1438975
          ORDER BY sigs_deadline";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $id = $row['prop_id'];
        $status = $row['prop_status'];
        $prop_arr[$id] = $row;
        $retval[$status][$id] = $row;
    }
  }
  return $retval;
}


function get_cmte_summary($cmte_id) {
  $conn = Util::get_ctb_conn();
  $pd_start = "2023-01-01";
  $pd_end   = "2024-12-31";

  if($cmte_id == "1425966" || $cmte_id == "1431407" || $cmte_id == "1423638" || $cmte_id == "1424396") {
    $pd_start = "2020-01-01";
  } elseif($cmte_id == "1422397") {
    $pd_start = "2019-01-01";
  }

  $retval = [
    'LAST_DATE' => null,
    'LAST_FILING' => null,
    'LAST_RCPT' => 0,
    'LIFETIME_RCPT' => 0,
    'LIFETIME_EXPN' => 0,
    'COH' => 0,
    'LOANS' => 0,
    'DEBTS' => 0,
    'LATE_CONTRIBUTIONS' => 0,
  ];
  
  $filing_reports = [];
  $last_report_date = '';
  $last_end = '';

  //STEP 1 - LOAD CAMPAIGN FINANCE STATEMENTS
  $sql = "SELECT * 
          FROM calaccess_raw_FILER_FILINGS_CD 
          WHERE FILER_ID = '$cmte_id' && FORM_ID = 'F460' && FILING_TYPE <> '0' && RPT_END >= '$pd_start'
          ORDER BY RPT_END DESC, FILING_ID DESC, FILING_SEQUENCE DESC";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    $query = '';
    $last_report_filing = null;
    while($row = $result->fetch_assoc()) {
      $this_end = $row['RPT_END'];
      if(!$last_report_date) {
        $last_report_date = $this_end;
        $last_report_filing = $row['FILING_ID'];
        $retval['LAST_DATE'] = $last_report_date;
        $retval['LAST_FILING'] = $last_report_filing;
      }

      if(isset($filing_reports[$this_end])) {
        continue;
      } else {
        $filing_reports[$this_end] = TRUE;
      }

      $tmp['FILING_ID'] = $row['FILING_ID'];
      $tmp['AMEND_ID']  = $row['FILING_SEQUENCE'];
      $tmp['RPT_END'] = $row['RPT_END'];
      if($this_end == $last_end) {
        //DO NOTHING
      } else {
        $query .= " ( FILING_ID = '" . $tmp['FILING_ID'] . "' && AMEND_ID = '" . $tmp['AMEND_ID'] . "' ) ||";
      }
      $last_end = $row['RPT_END'];
    }
  }

  //STEP 2 - LOAD SUMMARY FIGURES FROM CAMPAIGN FINANCE STATEMENTS
  if(!empty($query)) {
    $query = substr($query, 0, -2);

    $sql = "SELECT AMOUNT_A, AMOUNT_B, AMEND_ID, LINE_ITEM, FILING_ID 
            FROM calaccess_raw_SMRY_CD 
            WHERE ( $query ) && (LINE_ITEM = 5 || LINE_ITEM = 11 || LINE_ITEM = 16 || LINE_ITEM = 2 || LINE_ITEM = 19) 
            ORDER BY FILING_ID DESC, LINE_ITEM";

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        $line_item = $row['LINE_ITEM'];

        switch($line_item) {
          case "5": //RCPT
            if($row['FILING_ID'] == $last_report_filing) {
              $retval['LAST_RCPT'] = $row['AMOUNT_A'];
            }
            $retval['LIFETIME_RCPT'] += $row['AMOUNT_A'];
            break;
          case "11": //EXPN
            //$retval['EXPN'] = $row['AMOUNT_A'];
            //$retval['YTD_EXPN'] = $row['AMOUNT_B'];
            $retval['LIFETIME_EXPN'] += $row['AMOUNT_A'];
            break;
          case "16": //COH
            if($row['FILING_ID'] == $last_report_filing) {
              $retval['COH'] = $row['AMOUNT_A'];
            }       
            break;
          case "2": //LOANS
            $retval['LOANS'] = $row['AMOUNT_A'];
            break;
          case "19": //DEBT
            if($row['FILING_ID'] == $last_report_filing) {
              $retval['DEBTS'] = $row['AMOUNT_A'];
            }         
            break;
          default:
            break;
        }
      }
    }
  }

  //STEP 3 - GET LATE CONTRIBUTION FILINGS
  $tmp = [];
  $f497s = [];
  $lastfiling = null;
  $sql = "SELECT * 
          FROM calaccess_raw_FILER_FILINGS_CD 
          WHERE FILER_ID = '$cmte_id' && RPT_END > '$last_report_date' && FILING_TYPE <> '0' && FORM_ID = 'F497'
          ORDER BY FILING_ID DESC, FILING_SEQUENCE DESC";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $thisfiling = $row['FILING_ID'];
      if($thisfiling == $lastfiling) {
        //DO NOTHING
      } else {
        $tmp['FILING_ID'] = $row['FILING_ID'];
        array_push($f497s, $tmp);
      }
      $lastfiling = $thisfiling;
    }
  }

  //STEP 4 - GET LATE CONTRIBUTION AMOUNTS
  $highest = '';
  foreach($f497s as $filing) {
    $sql = "SELECT AMOUNT, AMEND_ID, LINE_ITEM, CTRIB_DATE FROM calaccess_raw_S497_CD WHERE FILING_ID = '" . $filing['FILING_ID'] . "' && FORM_TYPE = 'F497P1' ORDER BY LINE_ITEM ASC, AMEND_ID DESC";
    $result = $conn->query($sql);
    $highest = '';
    if($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
        if(!$highest) {
          $highest = $row['AMEND_ID'];
        }
        $thisamend = $row['AMEND_ID'];
        if($thisamend < $highest) {
          //DO NOTHING
        } else {
          if($row['CTRIB_DATE'] > $last_report_date) {
            $retval['LATE_CONTRIBUTIONS'] += $row['AMOUNT'];
          }
        }
      }
    }
  }
  $retval['LIFETIME_RCPT'] += $retval['LATE_CONTRIBUTIONS'];

  return $retval;
}


  function totalsort($a, $b) {
    
    if($a['AMOUNT'] < $b['AMOUNT']) {
      return 1;
    } elseif ($a['AMOUNT'] > $b['AMOUNT']) {
      return -1;
    }else {
      return 0;
    }
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
  text-align: right !important;
}

.prop_div {
  border: 2px solid black;
  margin-top: 10px;
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

.greenme {
  color: green;
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

th, td {
  padding-left: 5px;
  padding-right: 5px;
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

</style>


@endsection
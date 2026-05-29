@extends('layouts.book')
@php ($book_side_nav_active = 'finance')

@section('title', '2024 FEC Finance Summaries | California Target Book')


@section('content')

<div class='container-fluid pt-lg' height='100%'>
    <h2>
        2024 FEC Finance Summaries
    </h2>

<?php

Util::require_ctb_api();

ini_set('memory_limit', '4048M');
set_time_limit(0);

$endjava = Array();
global $pages, $fed_filed, $total_raised, $total_spent, $cycle, $end_arr, $all_draw;

$cycle = "2024";

populate_fed();

$sections = Array(
    "HOUSE"       => "U.S. House",
    "SENATE"         => "U.S. Senate",
    "PRESIDENT"       => "President",   
    "ALL"             => "ALL",
);

$nav_draw = '';
$enddraw = '';

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

   if($section == "SENATE") {
      $enddraw .= $end_arr['SENATE'];
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END SENATE SECTION-->";


  } elseif($section == "HOUSE") {
      $enddraw .= $end_arr['HOUSE'];
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END BOE SECTION-->";


  } elseif($section == "PRESIDENT") {
      $enddraw .= $end_arr['PRESIDENT'];     
      $enddraw .= "</div><!--END PROP DIV-->
          </section><!--END US CONGRESS SECTION-->";

  } elseif($section == "ALL") {
          $enddraw .= "<div class='panel justifyme'> <!--BEGIN ALL DIV -->
                        <p style = 'text-align: center !important;'>ALL</p>";         
          $enddraw .= "<div class='boxcontainer'>
  <div class='box1'>
    <div align='center' class='fixme'>
      <form action=''>
      <input type='text' name='search' value='' id='people_search' placeholder='Search By Candidate/Jurisdiction' title='Start typing to narrow results' autofocus />
        <br>
      </form>
    </div>
  </div>

  <div class='box2'>
  </div>
</div>";                        
          $enddraw .= get_all();
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

function get_all() {
    global $all_draw;
    $style = get_colors("ALL");
    $th_style = $style['head'];
    $colspan = $style['cols'];
      $enddraw = "<div class='panel justifyme'> <!--BEGIN DISTRICT PANEL DIV -->
                                <div>
                                  <table class='table table-hover table-responsive table-fit' align='center' v-ctb-table>
                                        <thead style='$th_style' class='white-text'>
                                          <tr>
                                            <th>OFFICE</th>
                                            <th>RACE</th>
                                            <th>CANDIDATE</th>
                                            <th>PARTY</th>
                                            <th>INC</th>
                                            <th>CMTE ID</th>
                                            <th class='rightme'>RCPT TOT</th>
                                            <th class='rightme'>EXPN TOT</th>
                                            <th class='rightme'>LAST COH</th>
                                            <th class='rightme'>Y1Q1</th>
                                            <th class='rightme'>Y1Q2</th>
                                            <th class='rightme'>Y1Q3</th>
                                            <th class='rightme'>Y1Q4</th>
                                            <th class='rightme'>Y2Q1</th>
                                            <th class='rightme'>Y2Q2</th>
                                            <th class='rightme'>Y2Q3</th>
                                            <th class='rightme'>Y2Q4</th>
                                            <th class='rightme'>LAST RPT</th>
                                          </tr>
                                        </thead>

                                        <tbody>
                                        $all_draw
                                        </tbody>
                              </table>
                            </div>
                          </div>";
  return $enddraw;                          

}


function populate_fed() {
  global $end_arr, $all_draw;
  $conn = Util::get_ctb_conn();
  $sql = "SELECT CAND_ID, CAND_NAME, CAND_PTY_AFFILIATION, CAND_ELECTION_YR, CAND_OFFICE_ST, CAND_OFFICE, CAND_OFFICE_DISTRICT, CAND_ICI, CAND_PCC
          FROM nufec_cn_24
          WHERE CAND_ELECTION_YR = '2024'";
  $result = $conn->query($sql);



  //SEED CANDIDATES
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      switch($row['CAND_OFFICE']) {
        case "H":
          $fourcode = $row['CAND_OFFICE_ST'] . $row['CAND_OFFICE_DISTRICT'];
          break;
        case "S":
          $fourcode = $row['CAND_OFFICE_ST'] . "SEN";
          break;
        case "P":
          $fourcode = "POTUS";
          break;
      }
      $cand_id = $row['CAND_ID'];
      $cmte_id = $row['CAND_PCC'];

      $office = $row['CAND_OFFICE'];

      if($fourcode == "POTUS" && !$cmte_id) {
        continue;
      }


      $end_arr['by_dist'][$office][$fourcode][$cand_id] = $row;
      $end_arr['by_cand'][$cand_id] = $row;
      if(!empty($cmte_id)) {
        $end_arr['by_cmte'][$cmte_id] = $row;
      }
    }
  }


  //BUILD F3 QUERY
  $q = '';
  foreach($end_arr['by_cmte'] as $cmte_id => $ignore) {
    $q .= " filer_committee_id_number = '$cmte_id' ||";
  }
  $q = substr($q, 0, -2);

  //EXECUTE F3 QUERY
  $sql = "SELECT filing_id, form_type, filer_committee_id_number, coverage_from_date, coverage_through_date, col_a_total_receipts, col_a_total_disbursements, col_a_cash_on_hand_close_of_period
          FROM ctb_f3_db
          WHERE ( $q ) && coverage_from_date > '20221231'
          ORDER BY filer_committee_id_number, coverage_through_date, filing_id DESC";
  $result = $conn->query($sql);
  if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $pd_end = $row['coverage_through_date'];
      $cmte_id = $row['filer_committee_id_number'];
      $rcpt = $row['col_a_total_receipts'];
      $expn = $row['col_a_total_disbursements'];
      $coh  = $row['col_a_cash_on_hand_close_of_period'];
      $filing_id = $row['filing_id'];

      if(!isset($end_arr['filings_by_cmte'][$cmte_id][$pd_end])) {
        $end_arr['filings_by_cmte'][$cmte_id][$pd_end] = $row;
      }
    }
  }



  //NOW, CYCLE THROUGH HOUSE, SENATE, PRESIDENT, AND DRAW STUFF
  $offices = Array("H" => "HOUSE", 
    "S" => "SENATE", 
    "P" => "PRESIDENT"
    );
  $rpts = Array("y1q1", "y1q2", "y1q3", "y1q4", "y2q1", "y2q2", "y2q3", "y2q4");
  
  foreach($offices as $this_office => $verbose) {
    $enddraw = '';
    //SORT THE OFFICES ALPHABETICALLY
    ksort($end_arr['by_dist'][$this_office]);
    $style = get_colors($verbose);
    $th_style = $style['head'];
    $colspan = $style['cols'];


    foreach($end_arr['by_dist'][$this_office] as $fourcode => $cands) {
      //echo("<br>$fourcode<br>");

      //DRAW PANEL & TABLE FOR EACH RACE
      $enddraw .= "<div class='panel justifyme'> <!--BEGIN DISTRICT PANEL DIV -->
                                <p style = 'text-align: center !important;'>$fourcode</p>
                                <div>
                                  <table class='table table-responsive w-auto table-fit' align='center' v-ctb-table>
                                        <thead style='$th_style' class='white-text'>
                                          <tr>
                                            <th>CANDIDATE</th>
                                            <th>PARTY</th>
                                            <th>INC</th>
                                            <th>CMTE ID</th>
                                            <th class='rightme'>RCPT TOT</th>
                                            <th class='rightme'>EXPN TOT</th>
                                            <th class='rightme'>LAST COH</th>
                                            <th class='rightme'>Y1Q1</th>
                                            <th class='rightme'>Y1Q2</th>
                                            <th class='rightme'>Y1Q3</th>
                                            <th class='rightme'>Y1Q4</th>
                                            <th class='rightme'>Y2Q1</th>
                                            <th class='rightme'>Y2Q2</th>
                                            <th class='rightme'>Y2Q3</th>
                                            <th class='rightme'>Y2Q4</th>
                                            <th class='rightme'>LAST RPT</th>
                                          </tr>

                                        </thead>
                                        
                                        <tbody>

                              ";
      
      //LOOP THROUGH THE CANDIDATES TO FILL OUT THE TABLE BODY                             
      foreach($cands as $cand_id => $x) {

        $cand_nm = $x['CAND_NAME'];
        $party = $x['CAND_PTY_AFFILIATION'];
        $cmte_id = $x['CAND_PCC'];
        $cand_ici = $x['CAND_ICI'];

	$q = [];
	if(!empty($end_arr['filings_by_cmte'][$cmte_id])) {
	        $q = sort_quarterly($cmte_id, $end_arr['filings_by_cmte'][$cmte_id]);
	}

        if(!empty($cmte_id)) {
          $cmte_lnk = "<a href='https://californiatargetbook.com/book/fec_f3/$cmte_id' target='_blank'>$cmte_id</a>";
        } else {
          $cmte_lnk = '';
        }

        $tmp = [];
        
        $rcpt_tot = 0;
        $expn_tot = 0;
        if(!empty($q['coh'])) {
          $coh_td = "<td align='right'>\$" . number_format($q['coh']) . "</td>";
        } else {
          $coh_td = "<td></td>";
        }

        foreach($rpts as $this_rpt) {
          if(!empty($q[$this_rpt])) {
            $filing_id = $q[$this_rpt]['filing_id'];
            $rcpt_tot += $q[$this_rpt]['rcpt'];
            $expn_tot += $q[$this_rpt]['expn'];
          }
          if(!empty($q[$this_rpt]['rcpt'])) {
            $tmp[$this_rpt] = "<td align='right'><a href='https://californiatargetbook.com/ctb-legacy/fedparser_null.php?id=$filing_id' target='_blank'>\$" . number_format($q[$this_rpt]['rcpt']) . "</td>";
          } else {
            $tmp[$this_rpt] = "<td></td>";
          }          
        }
        if($fourcode == "POTUS" && $rcpt_tot < 100) {
          continue;
        }


        $dist_row = "<tr>
                      <td>$cand_nm</td>
                      <td>$party</td>
                      <td>$cand_ici</td>
                      <td>$cmte_lnk</td>
                      <td align='right'>\$" . number_format($rcpt_tot) . "</td>
                      <td align='right'>\$" . number_format($expn_tot) . "</td>
                      $coh_td";

        foreach($rpts as $this_rpt) {
          $dist_row .= $tmp[$this_rpt];
        }
        $dist_row .= "<td>" . ($q['last_rpt'] ?? '') . "</td>
                    </tr>";

        //echo($dist_row);
        $enddraw .= $dist_row;



        $all_row = "<tr class='rowsearch'>
                      <td>$verbose</td>
                      <td>$fourcode</td>
                      <td>$cand_nm</td>
                      <td>$party</td>
                      <td>$cand_ici</td>
                      <td>$cmte_lnk</td>
                      <td align='right'>\$" . number_format($rcpt_tot) . "</td>
                      <td align='right'>\$" . number_format($expn_tot) . "</td>
                      $coh_td";

        foreach($rpts as $this_rpt) {
          $all_row .= $tmp[$this_rpt];
        }
        $all_row .= "<td>" . ($q['last_rpt'] ?? '') . "</td>
                    </tr>";                        

        $all_draw .= $all_row;            
      }
      $enddraw .= "</tbody></table></div></div>";
      //$end_arr[$verbose] .= $enddraw;
      
    }
    //$end_arr[$verbose] = $enddraw[$verbose];
    //echo("<br>$verbose HTML<br>");
    //echo($enddraw);
    $end_arr[$verbose] = $enddraw;
    //echo(htmlspecialchars($enddraw[$verbose]));
  }
}

function sort_quarterly($cmte_id, $filings_arr) {
    global $cycle;
    $y1 = $cycle - 1;
    $y2 = $cycle;
    $quarters = ["0331", "0630", "0930", "1231"];

    $quarter_dates = [];
    foreach ([$y1, $y2] as $year) {
        foreach ($quarters as $quarter) {
            $quarter_dates[] = $year . $quarter;
        }
    }

    $retval = [];

    /*
      filing_id, form_type, filer_committee_id_number, coverage_from_date, coverage_through_date, col_a_total_receipts, col_a_total_disbursements, col_a_cash_on_hand_close_of_period
    */

    asort($filings_arr);
    foreach($filings_arr as $end_dt => $x) {
        foreach ($quarter_dates as $index => $quarter_end) {
            if ($end_dt <= $quarter_end) {
                $rpt = 'y' . (($index < 4) ? '1' : '2') . 'q' . (($index % 4) + 1);
                if (!isset($retval[$rpt])) {
                    $retval[$rpt] = ['rcpt' => 0, 'expn' => 0, 'filing_id' => null];
                }
                $retval[$rpt]['rcpt'] += $x['col_a_total_receipts'];
                $retval[$rpt]['expn'] += $x['col_a_total_disbursements'];
                $retval[$rpt]['filing_id'] = $x['filing_id'];
                $retval['coh'] = $x['col_a_cash_on_hand_close_of_period'];
                $retval['last_rpt'] = $end_dt;
                break;
            }
        }
    }
    return $retval;
}




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
    case "HOUSE":
      //DARK RED - CONGRESS
      $head = "#4d0000";
      $columns = Array("#ffffff", "#ffffff", "#ffe6e6", "#ffb3b3", "#ff9999", "#ff8080", "#f0f0f5");
      break;
    case "PRESIDENT":
      //ORANGE - US SENATE
      $head = "#4d1f00";
      $columns = Array("#ffffff", "#ffffff", "#fff0e6", "#ffe0cc", "#ffd1b3", "#ffc299", "#f0f0f5");
      break;
    case "ALL":
      //DARK PURPLE
      $head = "#330033";
      $columns = Array("#ffffff", "#ffffff", "#ffffff", "#ffffff", "#ffe6ff", "#ffccff", "#ffb3ff", "#ff99ff", "#f0f0f5");
      break;

    default:
      break;
      
  }
  $head_style = "background-color: $head; color: white !important; font-weight: bold;";
  $cols = "<colgroup>";
  foreach($columns as $color) {
    $cols .= "<col style='background-color: $color;'>";
  }
  $cols .= "</colgroup>";
  

  $retval['head'] = $head_style;
  $retval['cols'] = $cols;
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

.countdown {
  text-align: center;
  font-family: 'Lato';
  font-size: 60px;
  margin-top:0px;
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

.white-text {
	color: white !important;
	font-weight: bold;
}

th {
	color: white !important;
}

</style>


@endsection
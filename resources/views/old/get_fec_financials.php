<?php

Util::set_errors();
Util::require_ctb_api();

setlocale(LC_COLLATE, "en_US");
setlocale(LC_CTYPE, "en_US");
global $endjava;
if (!isset($endjava)) {
    $endjava = Array();
}

global $year;
global $election;
if (!isset($year)) {
    $year = $_GET['yr'];
}
$fourcode = $_GET['id'];
//$election = $_GET['type'];

$tablebody = '';

if ($election == "G") {
    $financials = getgeneral();
} else {
    $financials = getall();
}

if($year == "2018") {

//var_dump($financials);

}

$thisid = $fourcode . "_Financials_" . $year . "_" . $election;

$js = "$(document).ready(function() {
    $('#" . $thisid . "').tablesorter({ 
            headers: { 
                2: { 
                    sorter:'fancyNumber' 
                },            	
                3: { 
                    sorter:'fancyNumber' 
                }, 
                4: { 
                    sorter:'fancyNumber' 
				},
                5: { 
                    sorter:'fancyNumber' 
                },
                6: { 
                    sorter:'fancyNumber' 
                }                                                                                   
            } 
        });
});

jQuery.tablesorter.addParser({
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


$tablehead = "<div class='newseg'>
				<table id='$thisid' class='table table-bordered table-hover tablesaw tablesaw-stack bordered tablesorter' data-tablesaw-mode='stack'>
					<thead>
						<tr>
							<th>CANDIDATE</th>
							<th>PARTY</th>
							<th>BEGINNING $</th>
							<th>RECEIPTS</th>
							<th>SPENT</th>
							<th>ENDING $</th>
							<th>DEBT</th>
							<th>END DATE</th>
							<th>$ SINCE</th>
							<th>CMTE</th>
						</tr>
					</thead>
					<tbody>";

foreach ($financials as $x) {
    $cand_lnk = "<a href='http://www.fec.gov/fecviewer/CandidateCommitteeDetail.do?&tabIndex=3&candidateCommitteeId=" . $x['CAND_ID'] . "' target='_blank'>" . $x['CAND_NM'] . "</a>";
    $cmte_lnk = get_committee_link($x['CAND_ID']);
    $bgclass = 'greybg';
    if ($x['PARTY'] == "DEM" || $x['PARTY'] == "D") {
        $bgclass = 'bluebg';
    }

    if ($x['PARTY'] == "REP" || $x['PARTY'] == "R") {
        $bgclass = 'redbg';
    }
    //echo("<br>Retrieving from " . $cmte_lnk['cmte_id'] . " - " . $x['END_DATE']);
    $since = getfed_since($cmte_lnk['cmte_id'], $x['END_DATE']);
    $tablebody .= "<tr class='$bgclass' style='font-family: \"PT Sans Narrow\";'>
						<td>$cand_lnk</td>
						<td align='right'>" . $x['PARTY'] . "</td>
						<td align='right'>" . number_format($x['COH_START']) . "</td>
						<td align='right'>" . number_format($x['RCPT']) . "</td>
						<td align='right'>" . number_format($x['EXPN']) . "</td>
						<td align='right'>" . number_format($x['COH_END']) . "</td>
						<td align='right'>" . number_format($x['DEBTS']) . "</td>
						<td align='right'>" . $x['END_DATE'] . "</td>
						<td align='right'>" . $since . "</td>
						<td align='right'>" . $cmte_lnk['url'] . "</td>
					</tr>
	";
}

echo($tablehead . $tablebody . "</tbody></table></div>");


?>






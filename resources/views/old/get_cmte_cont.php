
<?php

Util::require_ctb_api();

global $lookup_cmte, $endjava, $year;

//$lookup_cmte = $_GET['lookup_cmte'];

//echo("<br>LOOKING UP CMTE ID: $lookup_cmte<br>");

if (!isset($endjava)) {
    $endjava = array();
}

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

$total = 0;
$cmte = $lookup_cmte;

if (mb_substr($cmte, 0, 1) == "C") {
    $use_fed = TRUE;
    $use_state = FALSE;
} else {
    //echo("<br>RUNNING STATE</br>");
    $use_state = TRUE;
    $use_fed = FALSE;
}


if ($use_state) {
    //BEGIN CALACCESS SUMMARY RETRIEVE
    $x = getstate($cmte);
    //var_dump($x);
} else {
    //BEGIN FEDERAL SUMMARY RETRIEVE
    $x = getfed($cmte);
    //echo($x);
}

//<table id='" . $table_id . "_t' class='bordered tablesorter tablesaw tablesaw-stack' data-tablesaw-mode='stack'>

if (isset($cmte) && isset($x)) {

    $table_id = "detail_table_" . $cmte . "_" . $year;
    $amt = $x['total'];
    if(!isset($x['table_body'])) $x['table_body'] = '';



    $container = "<div class='row'><!--BEGIN ROW / CONTAINER FOR CMTE CONTRIBUTIONS-->
					<div class='col-lg-12 compain-btn  text-left'><!--BEGIN LARGE COLUMN-->
						<button type='button' class='btn btn-primary bg_bluee' data-toggle='collapse' data-target='#" . $table_id . "'>View Details of $amt in Contributions From Committees</button>
  							<div id='$table_id' class='collapse' style='margin-top: 20px;'><!--BEGIN COLLAPSE DIV-->


								<table id='$table_id" . "_t" . "'class='bordered tablesorter tablesaw tablesaw-stack cmte_contributions' data-tablesaw-mode='stack'>
									<thead>
										<tr>
											<th align='right'>AMOUNT</th>
											<th align='left'>COMMITTEE</th>
											<th align='right'>FPPC ID</th>
										</tr>
									</thead>
									<tbody>" .$x['table_body'] ."</tbody>
								</table>
							</div><!--END COLLAPSE DIV-->
                    </div><!--END LARGE COLUMN-->
                </div><!--END ROW/CONTAINER-->";


    echo($container);

}

//echo($x);









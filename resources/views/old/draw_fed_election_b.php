<?php

//global $fourcode;
//global $year;
global $master_fourcode;

//echo("<br>FOURCODE: $fourcode - YEAR: $year - ID: $id - MASTER FOURCODE: $master_fourcode");

switch ($year) {
    case "2012":
        $vote_results = $vote_table_stored['g12'];
        break;
    case "2014":
        $vote_results = $vote_table_stored['g14'];
        break;
    case "2016":
        $vote_results = $vote_table_stored['g16'];
        break;
    case "2018":
        $vote_results = $vote_table_stored['g18'];
        break;

}

//$ies = "<div class='iframe-container'><iframe src='/ctb-legacy/t/get_fec_ies.php?id=" . $master_fourcode . "&yr=$year' align='center'></iframe></div>";
//$ies = "<div class='iframe-container working center-block'><iframe class='center-block col-xs-12' src='/book/get_fec_ies?id=" . $master_fourcode . "&yr=$year' height='600' class='ie_iframe' align='center'></iframe></div>";
$ies = "<div class='iframe-container working center-block'><iframe class='center-block col-xs-12' src='/book/ie_test?id=" . $master_fourcode . "&year=$year' height='600' class='ie_iframe' align='center'></iframe></div>";

//var_dump($vote_table_stored);

echo("<div id='e$year' class='whitebg' style='width: 100%; max-width: 1200px; margin-top: 50px; background-color: white !important; text-align: justify;'>");

echo("<p class='campaign_head whitebg' style='font-size: 1.8em; text-align: center;'>Campaign $year</p>");
echo("<hr />");
echo("<div class='row whitebg' align='center'>
		<div class='col-lg-12' align='center'>$vote_results
	 	</div>
	 </div>");
echo("<hr />");

echo("<div class='row'>
		<div class='col-lg-12'>
			<h2 align='center'>GENERAL ELECTION</h2>");
$election = 'G';
include('get_fec_financials.php');

echo("	</div>
	  </div>");

echo("<div class='row'>
		<div class='col-lg-12'>
			<h2 align='center'>PRIMARY ELECTION</h2>");
$election = 'P';
include('get_fec_financials.php');

echo("	</div>
	  </div>");
echo("<hr />");

if ($year != "2022") {
    echo("<div class='row'>
			<div class='col-lg-12' style='font-family: \"Lato\"; font-size: 1.1em;'>");

    include('get_fec_candidates.php');
    echo("   </div>
		   </div>");
    echo("<hr />");
}

echo("<div class='row'>
		<div class='col-lg-12'>
			<div class='iframe-container'>
				$ies
			</div>
		</div>
	  </div>");

echo("</div>");

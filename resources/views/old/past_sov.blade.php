@extends('layouts.book')
@php ($book_side_nav_active = 'elections')

@section('title', 'Statement of Vote Archives (1912-2024) | California Target Book')


<?php

Util::set_errors();
Util::require_ctb_api();

function get_sov()
{
    $path = "/docs/SoV/";



    $years = Array("2024", "2022", "2021", "2020", 
		   "2018", "2016", "2014", "2012", "2010",
		   "2009", "2008", "2006", "2005", "2004", "2003", "2002", "2000",
		   "1998", "1996", "1994", "1993", "1992", "1990",
		   "1988", "1986", "1984", "1982", "1980",
		   "1979", "1978", "1976", "1974", "1973", "1972", "1970",
		   "1968", "1966", "1964", "1962", "1960",
		   "1958", "1956", "1954", "1952", "1950",
		   "1948", "1946", "1944", "1942", "1940",
		   "1939", "1938", "1936", "1935", "1934", "1933", "1932", "1930",
		   "1928", "1926", "1924", "1922", "1920",
		   "1918", "1916", "1915", "1914", "1912", "1911",
		   "1896", "1892",
		   "1886", "1882",
		);  


    $types = Array(
	"pp" => "Pres. Primary",
        "p" => "Primary",
        "g" => "General",
        "s" => "Special"
    );

    $pdfs = [];

    foreach ($years as $year) {
        $pdfs[$year] = ['pp' => '', 'p' => '', 'g' => '', 's' => ''];
        foreach ($types as $key => $value) {
            $filename = $path . $key . $year . ".pdf";
            //echo("<br>Checking for $filename");
            if (file_exists(resource_path('views'.$filename))) {
                $pdfs[$year][$key] = "<a href='$filename' target='_blank'>$value</a>";
            }
        }
    }

    //var_dump($pdfs);

    $tablehead = "<table v-ctb-tablee class='table-striped table-hover small-line max-50' width='50%' align='center'>
					<thead>
						<tr>
							<th>Year</th>
							<th>Pres. Pri</th>
							<th>Primary</th>
							<th>General</th>						
							<th>Special</th>
						</tr>
					</thead>
					<tbody>";

    $tablebody = '';

    foreach ($years as $year) {
	$display_year = $year;

        $tablebody .= "<tr>
							<td>$display_year</td>
							<td>" . $pdfs[$year]['pp'] . "</td>
							<td>" . $pdfs[$year]['p'] . "</td>
							<td>" . $pdfs[$year]['g'] . "</td>
							<td>" . $pdfs[$year]['s'] . "</td>
						</tr>";
    }

    $retval = $tablehead . $tablebody . "</tbody></table>";

    return $retval;

}

?>

@section('styles')
<style type="text/css">

.small-line table, th, td, tr {
	line-height: 1em !important;
	padding-bottom: 1px !important;
	padding-top: 1px !important;
	
}

.max-50 {
	max-width: 50% !important;
}
</style>

@endsection

@section('content')
    <div class="container-fluid pt-lg">

        <h2>Past Statements of Vote</h2>

        <div class='row'>
            <div class='col-lg-12'>
                <?= get_sov(); ?>
            </div>
        </div>
    </div>
@endsection






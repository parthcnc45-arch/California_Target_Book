
@extends('layouts.master')

@section('title', 'Cal Org. | California Target Book')

@section('content')

    <?php

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');

    Util::set_errors();
    Util::require_ctb_api();


    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    set_time_limit(0);

    $id = $_GET['id'];

    $x = retrieve_info($id);

    $orgs = Array("LCV" => "League of Conservation Voters",
        "LCV+" => "(Lifetime)",
        "SIERRA" => "Sierra Club",
        "CEJA" => "California Environmental Justice Association",
        "CWA" => "Clean Water Action",
        "HS" => "Humane Society",
        "PP" => "Planned Parenthood",
        "CLF" => "California Labor Federation",
        "CLF+" => "(Lifetime)",
        "UDW" => "United Domestic Workers",
        "NASW" => "National Association of Social Workers",
        "CMTA" => "California Manufacturers & Technology Association",
        "CCC" => "California Chamber of Commerce",
        "NFIB" => "National Federation of Independent Businesses",
        "HJTA" => "Howard Jarvis Taxpayers' Association",
        "CTAX" => "California Taxpayers' Association",
        "ACU" => "American Conservative Union",
        "ACU+" => "(Lifetime)",
        "CRA" => "California Republican Assembly"
    );

    $tablehead = "<div class='newseg' style='max-width: 600px;'>
				<table class='orgstyle' style='font-size: 16pt;'>
					<thead style='background-color: white;'>
						<tr>
							<th style='text-align: right;'>Organization</th>
							<th style='text-align: right;'>Score</th>
						</tr>
					</thead>
					<tbody>";

    foreach ($orgs as $key => $value) {
        if ($x[$key] != NULL) {
            $txt_class = '';

            if ($x[$key] <= 10) {
                $txt_class = 'redme';
            }

            if ($x[$key] >= 90) {
                $txt_class = 'greenme';
            }

            if ($x[$key] == 0) {
                $txt_class = 'redme boldme';
            }

            if ($x[$key] == 100) {
                $txt_class = 'greenme boldme';
            }

            if ($key == "CCC") {
                $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . number_format($x[$key], 0) . "%</td></tr>";
            } else {
                $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . $x[$key] . "%</td></tr>";

            }
        }
    }


    echo("<div align='center' style='font-family: \"PT Sans Narrow\";'><p align='center' style='font-size: 16pt; font-weight: bold'>" . $x['LEGISLATOR'] . " Organizational Ratings</p>");

    if ($org_draw) {
        echo($tablehead . $org_draw . "</tbody></table></div>");
    } else {
        echo("<p>No Scorecard for this Legislator Yet</p>");
    }
    echo("</div>");

    $endjava = Array();

    function retrieve_info($fourcode)
    {
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT * FROM ctb2016_org_2016_ca WHERE FOURCODE = '$fourcode'";
        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;

            }
        }

        return $retval;
    }


    ?>



@endsection

@section('scripts')

    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>

    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap"></script>
@endsection

@section('styles')
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map {
        height: 100%;
    }

    th {
        background-color: white !important;
    }
</style>
@endsection

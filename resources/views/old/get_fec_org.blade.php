@extends('layouts.iframe')

@section('title', 'FEC Org. | California Target Book')

@section('content')
    


    <?php

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');

    Util::set_errors();
    Util::require_ctb_api();


    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    set_time_limit(0);

    global $id;
    $id = $_GET['id'];

    $x = retrieve_info($id);

    $orgs = Array("ORG_PPUNCH" => "Progressive Punch",
        "ORG_PPUNCH+" => "(Lifetime)",
        "ORG_ADA" => "Americans for Democratic Action",
        "ORG_ACLU" => "American Civil Liberties Union",
        "ORG_LCV" => "League of Conservation Voters",
        "ORG_LCV+" => "(Lifetime)",
        "ORG_PPACT" => "Planned Parenthood",
        "ORG_AFLCIO" => "AFL/CIO",
        "ORG_AFLCIO+" => "(Lifetime)",
        "ORG_TEAMSTERS" => "Teamsters",
        "ORG_UFCW" => "United Food and Commercial Workers",
        "ORG_AFSCME" => "American Federation of State, County, and Municipal Employees",
        "ORG_GOVTEMP" => "American Federation of Government Employees",
        "ORG_NEA" => "National Education Association",
        "ORG_COC" => "U.S. Chamber of Commerce",
        "ORG_COC+" => "(Lifetime)",
        "ORG_NAM" => "National Association of Manufacturers",
        "ORG_NFIB" => "National Federation of Independent Businesses",
        "ORG_NAPO" => "National Association of Police Organizations",
        "ORG_NRA" => "National Rifle Association",
        "ORG_FWORKS" => "FreedomWorks",
        "ORG_AFP" => "Americans for Prosperity",
        "ORG_CCAGW" => "Concerned Citizens Against Government Waste",
        "ORG_FRC" => "Family Research Council",
        "ORG_NUMBUSA" => "Numbers USA",
        "ORG_ACU" => "American Conservative Union",
        "ORG_ACU+" => "(Lifetime)"

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

            $org_draw .= "<tr><td align='right'>$value</td><td align='right' class='$txt_class'>" . $x[$key] . "%</td></tr>";
        }
    }


    echo("<div align='center' style='font-family: \"PT Sans Narrow\";'><p align='center' style='font-size: 16pt; font-weight: bold'>Organizational Ratings</p>");

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
        $sql = "SELECT * FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
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
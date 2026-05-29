@extends('layouts.master')

@section('title', 'P16 Mapped Ad | California Target Book')

@section('content')


    <?php

    Util::set_errors();

    include "php/functions.php";
    include "php/filingfunctions2.php";


    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    set_time_limit(0);

    $servername = "198.74.49.22";
    $username = "nufec";
    $password = "Mrw0mbat8";
    $dbname = "caldist";

    $conn = new mysqli($servername, $username, $password, $dbname);

    $dbname = "ctb2016";

    $conn2 = new mysqli($servername, $username, $password, $dbname);

    $dbname = "p16returns";
    $conn3 = new mysqli($servername, $username, $password, $dbname);

    $endjava = Array();
    $coordinates = Array();
    $type = mb_substr($fourcode, 0, 2);
    $dist = mb_substr($fourcode, 2, 2);
    $table = "ad";

    $i = 1;

    while ($i < 81) {
        $dist = checkaddzero($i);
        $fourcode = "AD$dist";
        $x = get_dist_polygons($fourcode);

        //echo("<br>x = $x");
        $coordinates[$fourcode]['COORDINATES'] = parse_poly_strings($x);
        $coordinates[$fourcode]['COORDINATES'] = rtrim($coordinates[$fourcode]['COORDINATES'], ',');
        $html = '';
        $x = get_voting_results($fourcode);

        $totalvote = 0;
        uasort($x, votesort);

        $topparty = '';

        foreach ($x as $value) {
            $totalvote += $value['VOTES'];
            if (!$topparty) {
                $topparty = $value['PARTY'];
            }

            if ($topparty == "REP") {
                $color = "#FF0000";
            }

            if ($topparty == "DEM") {
                $color = "#0000FF";
            }
            $progress = $value['PROGRESS'];
        }

        foreach ($x as $value) {
            $pct = number_format((($value['VOTES'] / $totalvote) * 100), 2);
            $name = $value['NAME'];
            $votes = $value['VOTES'];
            $party = $value['PARTY'];

            $html .= "$name ($party) $votes ($pct%)<br>";

        }


        $coordinates[$fourcode]['COLOR'] = $color;
        $coordinates[$fourcode]['OPACITY'] = 0.6;
        $coordinates[$fourcode]['PARTY'] = $party;
        $coordinates[$fourcode]['HTML'] = $html;
        $coordinates[$fourcode]['PROGRESS'] = $progress;


        $i++;
    }

    //echo("<br>parsed:<br>$coordinates");


    //INITIALIZING PORTION OF JAVASCRIPT
    $js = "
	  var polys = [];

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          center: {lat: 38.886, lng: -118.268},
          mapTypeId: google.maps.MapTypeId.TERRAIN
        });

		var infowindow = new google.maps.InfoWindow({
			content: \"Blah\"
		});

";

    array_push($endjava, $js);


    $i = 1;
    //LOOP THROUGH ALL THE ZIP CODES AND DRAW INDIVIDUAL SEGMENTS

    foreach ($coordinates as $value) {

        $dist = checkaddzero($i);
        $fourcode = "AD$dist";

        $color = $coordinates[$fourcode]['COLOR'];
        $opacity = $coordinates[$fourcode]['OPACITY'];
        $progress = $coordinates[$fourcode]['PROGRESS'];

        $x = getincumbent($fourcode);
        $imgsrc = $x['IMG'];
        $name = $x['NAME'];
        $party = $x['INC_PARTY'];

        $tmp = $coordinates[$fourcode]['HTML'];

        //$votingstats = "<p align='center'>DEM $demreg ($dempct%)<br>REP $repreg ($reppct%)<br>NPP $nppreg ($npppct%)</p>";
        $imglink = "<img border='0' height='300px' width='200px' align='top' src='/img/$imgsrc'>";
        //$term = $x['TERM_LIMIT'];
        //$termlimit = "Term Limit: $term";


        //$html = "<p>$fourcode</p><p>$advantage</p>$votingstats";

        $html = "<h1 align='center'>$fourcode</h1><p align='center'><p align='center'><b>$name - $party</b></p><p>$imglink</p><p><b>$progress<br>$tmp</b></p>";

        $js = "
		polys[$i] = new google.maps.Polygon({
			html: \"$html\",
			paths: " . $coordinates[$fourcode]['COORDINATES'] . ",
			strokeColor: \"$color\",
			strokeOpacity: $opacity,
			strokeWeight: 2,
			fillColor: \"$color\",
			fillOpacity: $opacity
		});

		polys[$i].setMap(map);


		polys[$i].addListener('click', showArrays);

	";
        array_push($endjava, $js);
        $i++;
    }


    $js = "

	  function showArrays(event) {
	  	html = this.html;
	  	var contentString = html;

  		infowindow.setContent(contentString);
  		infowindow.setPosition(event.latLng);
  		infowindow.open(map);

	  }

}";
    array_push($endjava, $js);


    echo("<div id='map_canvas' width='800px' height='600px'></div>");
    echo("<div id='map' width='800px' height='600px'></div>");

    function votesort($a, $b)
    {

        if ($a['VOTES'] < $b['VOTES']) {
            return 1;
        } elseif ($a['VOTES'] > $b['VOTES']) {
            return -1;
        } else {
            return 0;
        }
    }

    function totalsort($a, $b)
    {

        if ($a['AMOUNT'] < $b['AMOUNT']) {
            return 1;
        } elseif ($a['AMOUNT'] > $b['AMOUNT']) {
            return -1;
        } else {
            return 0;
        }
    }

    function getincumbent($fourcode)
    {
        global $conn2;
        $retval = Array();
        $sql = "SELECT firstname, lastname, party, img_name, term_limit FROM rcandidates WHERE rdist_id = '$fourcode' && is_incumbent <> '' LIMIT 1";
        $result = $conn2->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['NAME'] = $row['firstname'] . " " . $row['lastname'];
                $retval['IMG'] = $row['img_name'];
                $retval['INC_PARTY'] = $row['party'];
                $retval['TERM_LIMIT'] = $row['term_limit'];
            }
        }

        return $retval;
    }

    function get_partisan_advantage($array)
    {
        $retval = Array();
        $total = $array['TOT'];
        $rep = $array['REP'];
        $dem = $array['DEM'];

        $demreg = ($dem / $total) * 100;
        $repreg = ($rep / $total) * 100;

        $diff = abs($demreg - $repreg);

        $retval['ADV'] = $diff;

        if ($demreg > $repreg) {
            $retval['COLOR'] = "#0000FF";
            $retval['PARTY'] = "Dem";
        } else {
            $retval['COLOR'] = "#FF0000";
            $retval['PARTY'] = "Rep";
        }

        $retval['OPACITY'] = 0.2 + ($diff / 100);

        //var_dump($retval);
        return $retval;

    }


    function get_dist_registration($fourcode)
    {
        global $conn2;
        $retval = Array();
        $sql = "SELECT * FROM sos_jun16 WHERE DIST = '$fourcode'";
        //echo($sql);
        $result = $conn2->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['TOT'] = $row['TOT'];
                $retval['REP'] = $row['REP'];
                $retval['DEM'] = $row['DEM'];
                $retval['NPP'] = $row['NPP'];
                $retval['AIP'] = $row['AIP'];
                $retval['GRN'] = $row['GRN'];
                $retval['LIB'] = $row['LIB'];
                $retval['PAF'] = $row['PAF'];
                $retval['OTH'] = $row['OTH'];
            }
        }

        //var_dump($retval);
        return $retval;
    }

    function get_zip_polygons($zip)
    {
        global $conn2;
        $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM tl_2013_us_zcta510 WHERE geoid10 = '$zip'";
        $result = $conn2->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['SHAPE'];
            }
        }

        return $retval;
    }

    function get_dist_polygons($fourcode)
    {
        global $conn;
        global $table;
        global $dist;
        if (mb_substr($dist, 0, 1) == "0") {
            $dist = mb_substr($dist, 1, 1);
        }

        $sql = "SELECT ST_AsText(SHAPE) AS SHAPE FROM $table WHERE FOURCODE = '$fourcode'";

        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['SHAPE'];
            }
        }

        //echo("<br>Returning: $retval</br>");
        return $retval;
    }

    function get_voting_results($fourcode)
    {
        global $conn3;
        $retval = Array();
        $tmp = Array();
        $sql = "SELECT * FROM candidates WHERE FOURCODE = '$fourcode'";
        $result = $conn3->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tmp['NAME'] = $row['NAME'];
                $tmp['PARTY'] = $row['PARTY'];
                $tmp['VOTES'] = $row['VOTES'];
                $tmp['PROGRESS'] = $row['PROGRESS'];
                array_push($retval, $tmp);
            }
        }

        return $retval;
    }

    function parse_poly_strings($string)
    {
        //echo("<br>PARSING STRING...<br>");
        $retval = '[';
        $initial = str_replace("(", "", $string);
        $initial = str_replace(")", "", $initial);
        $initial = str_replace("POLYGON", "", $initial);
        $initial = str_replace("MULTI", "", $initial);
        //echo("<br>STRIPPED CHARACTERS, STRING IS NOW:<br>$initial");
        $arr = explode(",", $initial);

        $first = '';
        foreach ($arr as $value) {
            $coordinates = explode(" ", $value);
            $lat = $coordinates[1];
            $lng = $coordinates[0];
            //echo("<br>LAT: $lat LNG: $lng<br>");
            $retval .= "\n{lat: $lat, lng: $lng},";

        }
        $retval = rtrim($retval, ',');
        $retval .= "],";

        return $retval;

    }

    function lookup_f460s($committee)
    {
        global $conn;
        $year = '2016';
        $retval = Array();

        $sql = "SELECT * FROM `FILER_FILINGS_CD`
		        WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && FILING_TYPE <> '' && RPT_END LIKE '%$year%'
		        ORDER BY RPT_END DESC, FILING_SEQUENCE DESC
		        LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['YR2'] = $row['FILING_ID'];
            }
        }

        $year2 = $year - 1;

        $sql = "SELECT * FROM `FILER_FILINGS_CD`
		        WHERE FILER_ID = '$committee' && FORM_ID = 'F460' && FILING_TYPE <> '' && RPT_END LIKE '%$year2%'
		        ORDER BY RPT_END DESC, FILING_SEQUENCE DESC
		        LIMIT 1";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['YR1'] = $row['FILING_ID'];
            }
        }

        return $retval;


    }

    function checkxref($committee)
    {
        global $conn;
        $retval = FALSE;
        $sql = "SELECT FILER_ID FROM FILER_XREF_CD WHERE XREF_ID = '$committee' ORDER BY FILER_ID DESC LIMIT 1 ";
        //echo("<br>$sql<br>");
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['FILER_ID'];
            }
        }

        //echo($retval);
        return $retval;
    }

    function get_zips_and_totals($committee)
    {
        global $conn;
        $retval = Array();
        //CHECK COMMITTEE FOR XREF
        $xref = checkxref($committee);
        if ($xref) {
            $filer_id = $xref;
        } else {
            $filer_id = $committee;
        }

        //GET ALL THE F460 FILINGS FOR THE COMMITTEE
        $filings = getallf460($filer_id);
        $i = 0;

        //START BUILDING THE SQL QUERY WITH THE FILING ID AND THE LAST AMENDED NUMBER
        foreach ($filings as $value2) {
            $filing = $value2['FILING_ID'];
            $amend_id = $value2['FILING_SEQUENCE'];
            $end = $value2['RPT_END'];

            if ($end > "2014-12-31") {
                if ($i == 0) {
                    $condition = "(FILING_ID = '$filing' && AMEND_ID = '$amend_id') ";
                    $i++;
                } else {
                    $condition .= " || (FILING_ID = '$filing' && AMEND_ID = '$amend_id') ";
                    $i++;
                }
            }
        }

        $sql = "SELECT CTRIB_ZIP4, CTRIB_CITY, CTRIB_ST, SUM(AMOUNT) AS AMOUNT
		FROM RCPT_CD
		WHERE $condition
		GROUP BY CTRIB_ZIP4
		ORDER BY AMOUNT DESC
		LIMIT 40
		";

        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $zip = $row['CTRIB_ZIP4'];
                if (strlen($zip) > 5) {
                    $zip = mb_substr($zip, 0, 5);
                }
                $retval[$zip]['AMOUNT'] = $row['AMOUNT'];
                $retval[$zip]['ZIP'] = $zip;
                $retval[$zip]['CITY'] = $row['CTRIB_CITY'];
                $retval[$zip]['STATE'] = $row['CTRIB_ST'];
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




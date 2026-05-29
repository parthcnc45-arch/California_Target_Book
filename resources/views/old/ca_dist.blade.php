
@extends('layouts.master')

@section('title', 'CA District')

@section('content')


<?php 

//require('includes/config.php');

//if not logged in redirect to login page
//User::authenticate();

//define page title
//$title = $_GET['id'] . ' District Page';
$title = $id . ' District Page';
$page = $title;
//$user = User::findById($_SESSION['memberID']);
//$user->track($page);

$endjava = Array();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
    <body class='greybg' id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">


        <?php

        //error_reporting(E_ALL);
        //ini_set('display_errors', '1');

       
        $fourcode = $id;

        $path = '/var/www/ctb/resources/views/old/';

        require_once $path . 'php/ctb_api.php';
        //require_once 'dist_nav_bar.php';
        include '/var/www/ctb/resources/views/components/dist_head.blade.php';
        include $path . 'tab_head.php';

	$cached = populate_cached($id);
    $cached['fourcode'] = $id;
    $fourcode = $id;

        echo("<div class='content-wrap'>");
	//var_dump($cached);

        echo("<section>");
        include $path . 'dist_overview.php';
        echo("</section>");

        echo("<section>");
        include $path . 'incumbent_page.php';
        echo("</section>");

        echo("<section>");
        include $path . 'district_page.php';
        echo("</section>");

        echo("<section>");
        include $path . 'cal_campaigns.php';
        echo("</section>");

        echo("<section>");
        include $path . 'results_tab.php';
        echo("</section>");

        echo("<section>");
        include $path . 'map_tab.php';
        echo("</section>");

        echo("</div>");
        echo("</div>");
        echo("</section>");
        //echo("</div>");


        setlocale(LC_COLLATE, "en_US");
        setlocale(LC_CTYPE, "en_US");


        $js = '  $( function() {
    $( "#tabs" ).tabs();
  });

  $( function() {
    $( "#years" ).tabs();
  });
';

        //array_push($endjava, $js);




        function get_cal_incumbent_bio($fourcode)
        {
	
            $conn = Util::get_ctb_conn();

            $incumbent_id = get_cal_incumbent($fourcode);
            //echo("<br>RETRIEVED INCUMBENT ID: $incumbent_id FOR $fourcode<br>");
            $bio = get_cal_bio($incumbent_id);

            //echo("<br>RETRIEVED<br>$bio<br>");
            return $bio;
        }

        function get_cal_bio($cand_id)
        {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT text FROM ctb_cand_bios WHERE cand_id = '$cand_id' ORDER BY date DESC, id DESC LIMIT 1";
            //echo("<Br>$sql");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function get_cal_incumbent($fourcode)
        {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT CAND_ID FROM ctb_e18_incumbent WHERE DIST = '$fourcode'";
            //echo("<br>$sql<br>");
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['CAND_ID'];
                }
            }

            return $retval;
        }


        function get_fec_analysis($year)
        {
            $conn = Util::get_ctb_conn();
            global $fourcode;
            $sql = "SELECT text from ctb_analysis WHERE dist = '$fourcode' && year = '$year' ORDER BY date DESC, id DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function is_targeted()
        {
            global $fourcode;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT targeted_by FROM nufec_e18_targets WHERE fourcode = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $x = $row['targeted_by'];
                }
            }
            if ($x == "DCCC") {
                $retval = "<span class='boldme blueme'>2018 DCCC Target</span>";
            }

            if ($x == "NRCC") {
                $retval = "<span class='boldme redme'>2018 NRCC Target</span>";
            }

            return $retval;
        }

        function getstats()
        {
            global $incumbent;
            global $hrc;
            global $djt;
            global $bho;
            global $wmr;
            global $party;
            global $fourcode;
            $conn = Util::get_ctb_conn();

            $sql = "SELECT * FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $incumbent = $row['NAMF'] . " " . $row['NAML'];
                    $party = $row['PARTY'];
                    $hrc = $row['CLINTON'];
                    $djt = $row['TRUMP'];
                    $bho = $row['OBAMA'];
                    $wmr = $row['ROMNEY'];
                }
            }
        }

        function get_long_string($fourcode)
        {
            $state = mb_substr($fourcode, 0, 2);
            $dist = mb_substr($fourcode, 2, 2);

            $long_state = convert_state($state);
            $long_dist = convert_district($dist);

            return $long_state . "<br>" . $long_dist . " Congressional District";
        }

        function convert_district($dist)
        {
            $longform = Array(
                "00" => "At Large",
                "01" => "First",
                "02" => "Second",
                "03" => "Third",
                "04" => "Fourth",
                "05" => "Fifth",
                "06" => "Sixth",
                "07" => "Seventh",
                "08" => "Eighth",
                "09" => "Ninth",
                "10" => "Tenth",
                "11" => "Eleventh",
                "12" => "Twelfth",
                "13" => "Thirteenth",
                "14" => "Fourteenth",
                "15" => "Fifteenth",
                "16" => "Sixteenth",
                "17" => "Seventeenth",
                "18" => "Eighteenth",
                "19" => "Nineteenth",
                "20" => "Twentieth",
                "21" => "Twenty-First",
                "22" => "Twenty-Second",
                "23" => "Twenty-Third",
                "24" => "Twenty-Fourth",
                "25" => "Twenty-Fifth",
                "26" => "Twenty-Sixth",
                "27" => "Twenty-Seventh",
                "28" => "Twenty-Eighth",
                "29" => "Twenty-Ninth",
                "30" => "Thirtieth",
                "31" => "Thirty-First",
                "32" => "Thirty-Second",
                "33" => "Thirty-Third",
                "34" => "Thirty-Fourth",
                "35" => "Thirty-Fifth",
                "36" => "Thirty-Sixth",
                "37" => "Thirty-Seventh",
                "38" => "Thirty-Eighth",
                "39" => "Thirty-Ninth",
                "40" => "Fortieth",
                "41" => "Forty-First",
                "42" => "Forty-Second",
                "43" => "Forty-Third",
                "44" => "Forty-Fourth",
                "45" => "Forty-Fifth",
                "46" => "Forty-Sixth",
                "47" => "Forty-Seventh",
                "48" => "Forty-Eighth",
                "49" => "Forty-Ninth",
                "50" => "Fiftieth",
                "51" => "Fifty-First",
                "52" => "Fifty-Second",
                "53" => "Fifty-Third",

            );

            return $longform[$dist];
        }

        function convert_state($name, $to = 'abbrev')
        {
            $states = array(
                array('name' => 'Alabama', 'abbrev' => 'AL'),
                array('name' => 'Alaska', 'abbrev' => 'AK'),
                array('name' => 'Arizona', 'abbrev' => 'AZ'),
                array('name' => 'Arkansas', 'abbrev' => 'AR'),
                array('name' => 'California', 'abbrev' => 'CA'),
                array('name' => 'Colorado', 'abbrev' => 'CO'),
                array('name' => 'Connecticut', 'abbrev' => 'CT'),
                array('name' => 'Delaware', 'abbrev' => 'DE'),
                array('name' => 'Florida', 'abbrev' => 'FL'),
                array('name' => 'Georgia', 'abbrev' => 'GA'),
                array('name' => 'Hawaii', 'abbrev' => 'HI'),
                array('name' => 'Idaho', 'abbrev' => 'ID'),
                array('name' => 'Illinois', 'abbrev' => 'IL'),
                array('name' => 'Indiana', 'abbrev' => 'IN'),
                array('name' => 'Iowa', 'abbrev' => 'IA'),
                array('name' => 'Kansas', 'abbrev' => 'KS'),
                array('name' => 'Kentucky', 'abbrev' => 'KY'),
                array('name' => 'Louisiana', 'abbrev' => 'LA'),
                array('name' => 'Maine', 'abbrev' => 'ME'),
                array('name' => 'Maryland', 'abbrev' => 'MD'),
                array('name' => 'Massachusetts', 'abbrev' => 'MA'),
                array('name' => 'Michigan', 'abbrev' => 'MI'),
                array('name' => 'Minnesota', 'abbrev' => 'MN'),
                array('name' => 'Mississippi', 'abbrev' => 'MS'),
                array('name' => 'Missouri', 'abbrev' => 'MO'),
                array('name' => 'Montana', 'abbrev' => 'MT'),
                array('name' => 'Nebraska', 'abbrev' => 'NE'),
                array('name' => 'Nevada', 'abbrev' => 'NV'),
                array('name' => 'New Hampshire', 'abbrev' => 'NH'),
                array('name' => 'New Jersey', 'abbrev' => 'NJ'),
                array('name' => 'New Mexico', 'abbrev' => 'NM'),
                array('name' => 'New York', 'abbrev' => 'NY'),
                array('name' => 'North Carolina', 'abbrev' => 'NC'),
                array('name' => 'North Dakota', 'abbrev' => 'ND'),
                array('name' => 'Ohio', 'abbrev' => 'OH'),
                array('name' => 'Oklahoma', 'abbrev' => 'OK'),
                array('name' => 'Oregon', 'abbrev' => 'OR'),
                array('name' => 'Pennsylvania', 'abbrev' => 'PA'),
                array('name' => 'Rhode Island', 'abbrev' => 'RI'),
                array('name' => 'South Carolina', 'abbrev' => 'SC'),
                array('name' => 'South Dakota', 'abbrev' => 'SD'),
                array('name' => 'Tennessee', 'abbrev' => 'TN'),
                array('name' => 'Texas', 'abbrev' => 'TX'),
                array('name' => 'Utah', 'abbrev' => 'UT'),
                array('name' => 'Vermont', 'abbrev' => 'VT'),
                array('name' => 'Virginia', 'abbrev' => 'VA'),
                array('name' => 'Washington', 'abbrev' => 'WA'),
                array('name' => 'West Virginia', 'abbrev' => 'WV'),
                array('name' => 'Wisconsin', 'abbrev' => 'WI'),
                array('name' => 'Wyoming', 'abbrev' => 'WY'),
                array('name' => 'Alberta', 'abbrev' => 'AB'),
                array('name' => 'British Columbia', 'abbrev' => 'BC'),
                array('name' => 'Manitoba', 'abbrev' => 'MB'),
                array('name' => 'New Brunswick', 'abbrev' => 'NB'),
                array('name' => 'Newfoundland', 'abbrev' => 'NL'),
                array('name' => 'Northwest Territories', 'abbrev' => 'NT'),
                array('name' => 'Nova Scotia', 'abbrev' => 'NS'),
                array('name' => 'Nunavut', 'abbrev' => 'NU'),
                array('name' => 'Ontario', 'abbrev' => 'ON'),
                array('name' => 'Prince Edward Island', 'abbrev' => 'PE'),
                array('name' => 'Quebec', 'abbrev' => 'QC'),
                array('name' => 'Saskatchewan', 'abbrev' => 'SK'),
                array('name' => 'Yukon Territory', 'abbrev' => 'YT')
            );

            $return = false;
            foreach ($states as $state) {
                foreach ($state as $title => $value) {
                    if (strtolower($value) == strtolower(trim($name))) {
                        if ($to == 'name') {
                            $return = $state['abbrev'];
                        } else {
                            $return = $state['name'];
                        }
                        break;
                    }
                }
            }

            return $return;
        }


        //echo("<p style='font-family: \"Montserrat\"; font-size: 16pt; text-align: justify;'>$bio_txt</p>");
 
        function populate_cached($fourcode) 
	{
		$conn = Util::get_ctb_conn();
		$sql = "SELECT * FROM ctb_cached_data WHERE dist = '$fourcode'";
		$result = $conn->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$retval = $row;
			}
		}
		return $retval;
	}

        function retrieve_image($fourcode)
        {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT BIOGUIDE, NAML, NAMF, PARTY FROM ctb2016_e18_fed WHERE DIST = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bioguide = $row['BIOGUIDE'];
                    $name = $row['NAMF'] . " " . $row['NAML'];
                    $party = $row['PARTY'];
                }
            }
            $img_url = "/img/congress/" . $bioguide . ".jpg";
            $bio_txt = retrieve_bio($bioguide);

            $retval['IMG'] = $img_url;
            $retval['BIO'] = $bio_txt;
            $retval['NAME'] = $name;
            $retval['PARTY'] = $party;

            return $retval;
        }

        function get_dist_location($fourcode)
        {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT text from ctb_dist_loc WHERE dist = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function get_dist_profile($fourcode)
        {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT text from ctb_dist_profile WHERE dist='$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function retrieve_bio($id)
        {

	    $conn = Util::get_ctb_conn();
            $sql = "SELECT bio FROM nufec_bios WHERE bioguide = '$id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['bio'];
                }
            }

            return $retval;
        }

        function getanalysis($fourcodee, $year)
        {
        global $fourcode;
        global $id;
	    $conn = Util::get_ctb_conn();
            $sql = "SELECT text FROM ctb_analysis WHERE fourcode = '$fourcode' && year = $year";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        ?>

        <script src="/js/cbpFWTabs.js"></script>
        <script>
          (function () {

            [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
              new CBPFWTabs(el);
            });

          })();
        </script>


    </body>


    


</html>

@endsection


@section('scripts')
<script type='text/javascript'>

    <?php

    foreach ($endjava as $value) {
        echo($value);
    }

    ?>

</script>
<script>

    $(function () {
        $("#tabs").tabs();
    });

</script>

@endsection

@section('styles')
<style>

    .greybg {
        background-color: #E6E6E6;
    }

    .graybg {
        background-color: #F7F7F7
    }

    .whitebg {
        background-color: white;
    }

    .yellowbg {
        background-color: #F7FEAA;
    }

    .container {
        margin-top: 25px;
        margin-bottom: 25px;
        box-shadow: 0 0 30px black;
        padding: 0 15px 0 15px;
    }

    body, html {
        background-color: white;
    }

    .analysis {
        font-family: 'Lato';
    }

    .analysis p {
        font-size: 1.3em;
        padding: 5%;
        line-height: 1.7;
        text-align: justify;
    }

    .analysis strong, b {
        font-weight: bold;
        color: blue;
    }

    .campaign_head {
        color: FireBrick;
        font-weight: bold;
        font-variant: small-caps;
        text-align: center;
        font-family: 'Lato';
    }

    .analysis img {
        border-radius: 10px;
        float: left;
        padding: 2%;
        max-width: 100px;

    }

    .vote_container {
        margin-left: auto;
        margin-right: auto;
        text-align: center;
        border: 2px solid black;
        display: inline-block;
    }

    th {
        text-align: center !important;
        margin-left: auto;
        margin-right: auto;
        font-size: 1.1em;
        color: white;
        font-style: 'Lato';
        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    /*
    .bluebg {
        background: rgb(235,241,246) !important;
        background: -moz-linear-gradient(top,  rgba(235,241,246,1) 0%, rgba(171,211,238,1) 50%,           rgba(137,195,235,1) 51%, rgba(213,235,251,1) 100%) !important;
        background: -webkit-linear-gradient(top,  rgba(235,241,246,1) 0%,rgba(171,211,238,1) 50%,rgba(137,195,235,1) 51%,rgba(213,235,251,1) 100%) !important;
        background: linear-gradient(to bottom,  rgba(235,241,246,1) 0%,rgba(171,211,238,1) 50%,rgba(137,195,235,1) 51%,rgba(213,235,251,1) 100%) !important; /
    }

    .redbg {
    background: #f0d4d4;
    background: -moz-linear-gradient(top, #f0d4d4 0%, #eccaca 50%, #e7bbbb 51%, #fefefe 100%);
    background: -webkit-linear-gradient(top, #f0d4d4 0%,#eccaca 50%,#e7bbbb 51%,#fefefe 100%);
    background: linear-gradient(to bottom, #f0d4d4 0%,#eccaca 50%,#e7bbbb 51%,#fefefe 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f0d4d4', endColorstr='#fefefe',GradientType=0 );
    }

    */

    .bluebg {
        color: blue;
        background-color: white;
    }

    .redbg {
        color: red;
        background-color: white;
    }

    .greybg {
        background: rgb(238, 238, 238); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    .winner {
        font-weight: bold;
        font-variant: small-caps;
    }

    .primary_div {
        font-family: 'PT Sans Narrow';
        float: left;
        margin: 10px;
        font-size: 1.4em;
    }

    .primary_table th {
        background-color: black;
    }

    .primary_table td {
        padding-left: 2px;
        padding-right: 2px;
        padding-top: 2px;
        text-align: right;
    }

    .canddiv {
        background-color: #F8F8F8;
        margin-top: 10px;
        padding: 1%;
        font-family: 'Lato';
        line-height: 1.5;
        display: inline-block;
        font-size: 1em;
    }

    .canddiv p {
        font-size: 1em;
    }

    .canddiv img {
        float: left;
        border-radius: 10px;
        margin: 0px 5px 1px 0px;

    }

    .demdiv {
        border: 2px solid blue;
        border-radius: 10px;
        background-color: #F3F4FE;

    }

    .grndiv {
        border: 2px solid green;
        border-radius: 10px;

    }

    .repdiv {
        border: 2px solid red;
        border-radius: 10px;
        background-color: #FFF4F4;
    }

    .inddiv {
        border: 2px solid gray;
        border-radius: 10px;
    }

    .financials {
        font-size: 1.1em;
        font-family: 'PT Sans Narrow';
        width: 100%;
        margin: 10px;
        background-color: white;
        padding: 1%;
        text-align: right;
    }

    .primary_div .img_cell {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }

    .tab-bar span {
        padding: 5px;
    }

</style>
@endsection

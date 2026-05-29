<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once('includes/config.php');
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <link href="https://fonts.googleapis.com/css?family=Bellefair|Nunito+Sans" rel="stylesheet">
        <link rel="stylesheet" href="style/tablesaw.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    </head>

    <style>

        @font-face {
            font-family: Bellefair;
            src: 'fonts/Bellefair.ttf';
        }

        .navbar, .navbar-inverse {
            border-radius: 0;
            border: none;
            margin-bottom: 0;
            min-height: 80px;
            /*
            background-image: url('../img/bigdark_md.jpg');
            background-size: contain;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: right top;
            */
        }

        .nav li {
            display: inline;
            color: white;
        }

        .navbar-inverse .navbar-nav > li > a {
            color: #ffffff;
            font-family: Lato;
            font-size: 1.3em;
            font-weight: 300;
            padding: 30px 25px 33px 25px;
        }

        .navbar-inverse .navbar-nav li a:hover {
            background-color: #444444;
            transition: 0.7s all linear;
            height: 100%;
        }

        .tablesaw {
            font-family: 'PT Sans Narrow';
        }

        /*
        .dropdown-submenu {
            position: relative;
             display: inline-block;
        }
        .dropdown-menu {
            width: 400px;
        }
        .dropdown-menu li {
            clear: both;
        }
        .dropdown-submenu>.dropdown-menu {
            top: 0;
            left: 100%;
            margin-top: -6px;
            margin-left: -1px;
            -webkit-border-radius: 0 6px 6px 6px;
            -moz-border-radius: 0 6px 6px;
            border-radius: 0 6px 6px 6px;
        }
        .dropdown-submenu:hover>.dropdown-menu {
            display: block;
        }
        .dropdown-submenu>a:after {
            display: block;
            content: " ";
            float: right;
            width: 0;
            height: 0;
            border-color: transparent;
            border-style: solid;
            border-width: 5px 0 5px 5px;
            border-left-color: #ccc;
            margin-top: 5px;
            margin-right: -10px;
        }
        .dropdown-submenu:hover>a:after {
            border-left-color: #fff;
        }
        .dropdown-submenu.pull-left {
            float: none;
        }
        .dropdown-submenu.pull-left>.dropdown-menu {
            left: -100%;
            margin-left: 10px;
            -webkit-border-radius: 6px 0 6px 6px;
            -moz-border-radius: 6px 0 6px 6px;
            border-radius: 6px 0 6px 6px;
        }
        */
    </style>
    <link href="style/jquery.smartmenus.bootstrap.css" rel="stylesheet">

    <?php Util::require_ctb_api(); ?>

    <nav class="navbar navbar-inverse navbar-static-top" role="navigation">
        <div class="container" style='width: 100vw;'>
            <div class="navbar-header">
                <a href="#" class="navbar-right"><img src="../img/bigdark_md.jpg" height='80'></a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" align='center'>
                <ul class="nav navbar-nav">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="hotsheet.php">Hot Sheet</a></li>

                    <li>
                        <a href="#">
                            Districts<b class="caret"></b>
                        </a>
                        <ul class='dropdown-menu'>
                            <?= get_district_nav() ?>
                        </ul>
                    </li>

                    <li>
                        <a href="#">
                            Propositons<b class="caret"></b></a>
                        <ul class='dropdown-menu'>
                            <?= get_prop_nav() ?>
                        </ul>

                    </li>


                    <li><a href='candidates_hub.php'>Candidates</a></li>
                    <li><a href='stats_hub.php'>Registration/Census Data</a></li>
                    <li><a href='#'>Campaign Finance<b class="caret"></b></a>
                        <ul class='dropdown-menu'>
                            <li><a href='state_finance_hub.php'>State</a></li>
                            <li><a href='federal_finance_hub.php'>Federal</a></li>
                            <li><a href='local_finance_hub.php'>Local</a></li>
                            <li><a href='finance_hub.php'>Old Campaign Finance Hub</a></li>
                        </ul>
                    </li>
                    <li><a href='maps_hub.php'>Maps</a></li>
                    <li><a href='elections_hub.php'>Elections</a></li>
                    <li><a href="#">Sample Pages<b class='caret'></b></a>
                        <ul class='dropdown-menu'>
                            <li><a href='sample_assembly.php'>Sample Assembly Page</a></li>
                            <li><a href='sample_senate.php'>Sample State Senate Page</a></li>
                            <li><a href='sample_congress.php'>Sample Congressional Page</a></li>
                            <li><a href='sample_county_page.php'>Sample County Page</a></li>
                        </ul>
                    </li>
                    <li><a href='about.php'>About<b class="caret"></b></a>
                        <ul class='dropdown-menu'>
                            <li><a href='editors.php'>About Us</a></li>
                            <li><a href='subscriber_list.php'>Partial List of Subscribers</a></li>
                            <li><a href='subscription_info.php'>Subscription Information</a></li>
                        </ul>
                    </li>

                    <?php
                    $user = unserialize($_SESSION['user']);
                    if (!empty($user)) {
                        ?>
                        <li>
                            <p style='color: white;'>
                                Logged In as <?= $user->email ?><br>
                                Subscription Valid Until <?= $user->expires ?><br>
                                <a href='logout.php'>Logout</a>
                            </p>
                        </li>

                    <?php } else { ?>
                        <li>
                            <a href='login.php'>
                                Login
                            </a>
                        </li>
                    <?php } ?>

                </ul>

            </div>

        </div>
    </nav>


    <?php

    function get_prop_nav()
    {
        global $site_conn;
        $conn = $site_conn;
        $sql = "SELECT * FROM ca_props WHERE prop_no != '' && prop_session > 2003 ORDER BY prop_session, prop_no";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $election = $row['prop_session'] + 1;
                $prop_dscr = $row['prop_dscr'];
                $prop_no = $row['prop_no'];

                $prop_arr[$election][$prop_no] = $prop_dscr;
            }
        }

        foreach ($prop_arr as $e_key => $e_arr) {
            if ($e_arr) {
                $prop_nav .= "<li><a href='#'>$e_key</a>
							<ul class='dropdown-menu'>";

                foreach ($prop_arr[$e_key] as $prop_no => $prop_dscr) {
                    $url = 'prop_page_b.php?prop=' . $prop_no . "&election=" . $e_key;
                    $prop_nav .= "<li><a href='$url'>PROP " . $prop_no . " - " . $prop_dscr . "</a></li>";
                }

                $prop_nav .= "</ul>
						</li>";
            }

        }

        return $prop_nav;


    }

    function get_district_nav()
    {
        global $ctb2016_conn;
        $conn = $ctb2016_conn;
        $sql = "SELECT * FROM e18_incumbent WHERE DIST LIKE 'AD%' ORDER BY DIST ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $listbody .= "<li><a href='get_ctb_page_b.php?id=" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['ALIAS'] . ")</a></li>";
            }
        }
        $asm_nav = "<li><a href='#'>Assembly</a>
					<ul class='dropdown-menu'>" .
            $listbody .
            "</ul>
				</li>";
        $listbody = '';
        $sql = "SELECT * FROM e18_incumbent WHERE DIST LIKE 'SD%' ORDER BY DIST ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $listbody .= "<li><a href='get_ctb_page_b.php?id=" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['ALIAS'] . ")</a></li>";
            }
        }
        $sen_nav = "<li><a href='#'>State Senate</a>
					<ul class='dropdown-menu'>" .
            $listbody .
            "</ul>
				</li>";
        $listbody = '';
        $sql = "SELECT * FROM e18_incumbent WHERE DIST LIKE 'CD%' ORDER BY DIST ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $listbody .= "<li><a href='get_ctb_page_b.php?id=" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['ALIAS'] . ")</a></li>";
            }
        }
        $cng_nav = "<li><a href='#'>Congress (CA)</a>
					<ul class='dropdown-menu'>" .
            $listbody .
            "</ul>
				</li>";
        $listbody = '';
        $boe_nav = "<li><a href='#'>Board of Equalization</a>
					<ul class='dropdown-menu'>
						<li><a href='get_ctb_page_b.php?id=BOE1'>BOE1 (R-Runner)</a></li>
						<li><a href='get_ctb_page_b.php?id=BOE2'>BOE2 (D-Ma)</a></li>
						<li><a href='get_ctb_page_b.php?id=BOE3'>BOE3 (D-Horton)</a></li>
						<li><a href='get_ctb_page_b.php?id=BOE4'>BOE4 (R-Harkey)</a></li>
					</ul>
				</li>";
        $state_offc_nav = "<li><a href='#'>Constitutional Offices</a>
					<ul class='dropdown-menu'>
						<li><a href='get_ctb_page_b.php?id=.GOV'>Governor (D-Brown)</a></li>
						<li><a href='get_ctb_page_b.php?id=.LTG'>Lt. Governor (D-Newsom)</a></li>
						<li><a href='get_ctb_page_b.php?id=.ATG'>Attorney General (D-Becerra)</a></li>
						<li><a href='get_ctb_page_b.php?id=.SOS'>Secretary of State (D-Padilla)</a></li>
						<li><a href='get_ctb_page_b.php?id=.TRS'>Treasurer (D-Chiang)</a></li>
						<li><a href='get_ctb_page_b.php?id=.CON'>Controller (D-Yee)</a></li>
						<li><a href='get_ctb_page_b.php?id=.INS'>Insurance Commissioner (D-Jones)</a></li>
						<li><a href='get_ctb_page_b.php?id=.SPI'>Superintendent of Public Instruction (NOP-Torlakson)</a></li>
					</ul>
				</li>";
        $ca_sen_nav = "<li><a href='#'>U.S. Senate (CA)</a>
					<ul class='dropdown-menu'>
						<li><a href='get_ctb_page_b.php?id=.SN1'>U.S. Senate 1 (D-Feinstein)</a></li>
						<li><a href='get_ctb_page_b.php?id=.SN2'>U.S. Senate 2 (D-Harris)</a></li>
					</ul>
				</li>";
        $states_array = Array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY");
        $house_nav = "<li><a href='#'>U.S. House of Representatives</a>
    				<ul class='dropdown-menu'>";
        foreach ($states_array as $st) {
            $long_state = convert_state2($st);
            $house_nav .= "<li><a href='#'>$long_state</a>
    						<ul class='dropdown-menu'>";
            $sql = "SELECT DIST, NAML, PARTY FROM e18_fed WHERE DIST LIKE '$st%' ORDER BY DIST ASC";
            //echo($sql) . "<br>";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $house_nav .= "<li><a href='get_fed_page_b.php?id=" . $row['DIST'] . "'>" . $row['DIST'] . " (" . $row['PARTY'] . "-" . $row['NAML'] . ")</a></li>";
                }
            }
            $house_nav .= "</ul>
    				</li>";
        }
        $house_nav .= "</ul>
    			</li>";
        $county_nav = get_county_nav();
        $retval = $asm_nav . $sen_nav . $cng_nav . $boe_nav . $state_offc_nav . $ca_sen_nav . $county_nav . $house_nav;

        return $retval;
    }

    function get_county_nav()
    {
        $conversion_array = Array(
            "ALAMEDA" => "01",
            "ALPINE" => "02",
            "AMADOR" => "03",
            "BUTTE" => "04",
            "CALAVERAS" => "05",
            "COLUSA" => "06",
            "CONTRA COSTA" => "07",
            "DEL NORTE" => "08",
            "EL DORADO" => "09",
            "FRESNO" => "10",
            "GLENN" => "11",
            "HUMBOLDT" => "12",
            "IMPERIAL" => "13",
            "INYO" => "14",
            "KERN" => "15",
            "KINGS" => "16",
            "LAKE" => "17",
            "LASSEN" => "18",
            "LOS ANGELES" => "19",
            "MADERA" => "20",
            "MARIN" => "21",
            "MARIPOSA" => "22",
            "MENDOCINO" => "23",
            "MERCED" => "24",
            "MODOC" => "25",
            "MONO" => "26",
            "MONTEREY" => "27",
            "NAPA" => "28",
            "NEVADA" => "28",
            "ORANGE" => "30",
            "PLACER" => "31",
            "PLUMAS" => "32",
            "RIVERSIDE" => "33",
            "SACRAMENTO" => "34",
            "SAN BENITO" => "35",
            "SAN BERNARDINO" => "36",
            "SAN DIEGO" => "37",
            "SAN FRANCISCO" => "38",
            "SAN JOAQUIN" => "39",
            "SAN LUIS OBISPO" => "40",
            "SAN MATEO" => "41",
            "SANTA BARBARA" => "42",
            "SANTA CLARA" => "43",
            "SANTA CRUZ" => "44",
            "SHASTA" => "45",
            "SIERRA" => "46",
            "SISKIYOU" => "47",
            "SOLANO" => "48",
            "SONOMA" => "49",
            "STANISLAUS" => "50",
            "SUTTER" => "51",
            "TEHAMA" => "52",
            "TRINITY" => "53",
            "TULARE" => "54",
            "TUOLUMNE" => "55",
            "VENTURA" => "56",
            "YOLO" => "57",
            "YUBA" => "58"
        );
        foreach ($conversion_array as $key => $value) {
            $listbody .= "<li><a href='get_county_page_b.php?id=$key'>$key</a></li>";
        }
        $retval = "<li><a href='#'>Counties</a>
    				<ul class='dropdown-menu'>" .
            $listbody .
            "</ul>
    			</li>";

        return $retval;
    }

    function convert_state2($name, $to = 'abbrev')
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
        );
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

    ?>

    <!-- SmartMenus jQuery plugin -->
    <script type="text/javascript" src="js/jquery.smartmenus.min.js"></script>

    <!-- SmartMenus jQuery Bootstrap Addon -->
    <script type="text/javascript" src="js/jquery.smartmenus.bootstrap.min.js"></script>
    <script type="text/javascript" src="js/tablesaw.jquery.js"></script>
    <script type="text/javascript" src="js/tablesaw-init.js"></script>
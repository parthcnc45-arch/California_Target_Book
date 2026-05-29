<?php
Util::set_errors();
$title = $_GET['id'] . ' District Page';

?>

@extends('layouts.master')

@section('title', "$title | California Target Book")

@section('content')
    




    <?php

    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');

    global $id, $fourcode;
    $id = $_GET['id'];
    $fourcode = $_GET['id'];

    Util::require_ctb_api();

    ?>

    @include('components.dist_head')

    <section>
        <div class='tabs tabs-style-bar' style='width: 100%; background-color: white;'>
            <nav class='tab-bar'>
                <ul>
                    <li><a href='#Overview' class='fa fa-lg fa-home'><span>Overview</span></a></li>
                    <li><a href='#Incumbent' class='fa fa-lg fa-user'><span>Incumbent</span></a></li>
                    <li><a href='#Campaigns' class='fa fa-lg fa-book'><span>Campaigns</span></a></li>
                </ul>
            </nav>
        </div>
    </section>

    <div class='content-wrap'>
        <section id="Overview">
            <?php Util::include('dist_overview_fed.php') ?>
        </section>
        <section id="Incumbent">
            <?php Util::include('incumbent_fed.php') ?>
        </section>
        <section id="Campaigns">
            <?php Util::include('fed_campaigns.php') ?>
        </section>
    </div>


    <?php


    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();

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
        global $site_conn;
        $incumbent_id = get_cal_incumbent($fourcode);
        //echo("<br>RETRIEVED INCUMBENT ID: $incumbent_id FOR $fourcode<br>");
        $bio = get_cal_bio($incumbent_id);

        //echo("<br>RETRIEVED<br>$bio<br>");
        return $bio;
    }

    function get_cal_bio($cand_id)
    {
        global $site_conn;
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
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT CAND_ID FROM ctb2016_e18_incumbent WHERE DIST = '$fourcode'";
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
        global $site_conn;
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
        global $fec_conn;
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
        global $ctb2016_conn;
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

    function retrieve_image($fourcode)
    {
        global $ctb2016_conn;
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
        global $site_conn;
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
        global $site_conn;
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
        global $fec_conn;
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

    function getanalysis($fourcode, $year)
    {
        global $fec_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT text FROM nufec_analysis WHERE fourcode = '$fourcode' && year = $year";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['text'];
            }
        }

        return $retval;
    }

    ?>


@endsection

@section('scripts')
    <script>

      $(function () {
        $("#tabs").tabs();
      });

      $(function () {
        $("#years").tabs();
      });

    </script>

    <script type='text/javascript'>

        <?php

        foreach ($endjava as $value) {
            echo($value);
        }

        ?>

    </script>
@endsection

@section('styles')
<style>

</style>
@endsection
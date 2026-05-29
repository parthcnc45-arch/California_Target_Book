<?php

global $fourcode;
global $county;
global $sub;
$fourcode = $id;
$county = $id;

//echo("<br>$fourcode - $county - $id");

Util::require_ctb_api();

?>

@php ($book_side_nav_active = 'district')

@extends('layouts.book')

@section('title', "$county County Page | California Target Book")

@section('content')
	@include('components.dist_head')

    <?php

    Util::set_errors();
    Util::require_ctb_api();

    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");

    global $endjava;
    $endjava = [];

    //echo("<br>ON RUN $county - $fourcode - $id");

    //$county = $_GET['id'];

    $fourcode = "CO" . convert_supe($county);

    $lb = "<div width='100%' style='clear: both;'></div>";

    $images = get_images($county);
    $cities = get_cities($county);

    $cities = rtrim($cities, ", ");
    if (!$cities) {
        $cities = "No Incorporated Cities";
    }

    $profile = get_dist_profile($fourcode);

    $location_div = "<div class='col-lg-2'><img width='100%' src='" . $images['LOCATION'] . "' /><p align='center' style='width: 100%;'>CITIES<br>$cities</p></div>";
    $supe_district_div = "<div align='justify' class='col-lg-3'><a href='" . $images['DISTRICTS'] . "' target='_blank'><img width='100%' src='" . $images['DISTRICTS'] . "' /></a><p>$profile</p></div>";

    $i = 1;

    $dist_iframes = Array();
    $supe_tables = Array();

    if ($county == "SAN FRANCISCO") {
        while ($i < 12) {
            $districts .= "<li><a href='#D$i'>D$i</a></li>";
            $sub = "Supervisorial District $i";
            //$dist_iframes[$i] = "<iframe src='/ctb-legacy/t/get_county_sub3.php?id=" . $county . "&sub=Supervisorial%20District%20" . $i . "' width='1024px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $supe_tables[$i] = get_supe_table($county, $i);
            $tmp = get_supe_incumbent($county, $i);
            $supe_incumbent[$i] = $tmp['html'];
            $supe_inc[$i] = $tmp['incumbent'];
            $supe_elec[$i] = $tmp['elections'];
            $radio_list .= "<li style='float: left;'><input type='radio' name='distmapper' class='radioMap' value='county=$county&sub=$i'>D" . $i . "</li>";
            $i++;
        }
        $radio_list .= "<li style='float: left;'><input type='radio' name='distmapper' class='radioMap' value='county=$county&sub=ALL'>ALL</li>";
    } else {
        while ($i < 6) {
            $districts .= "<li><a href='#D$i' role='tab' data-toggle='tab'>D$i</a></li>";
            //$dist_iframes[$i] = "<iframe src='get_county_sub3.php?id=" . $county . "&sub=Supervisorial%20District%20" . $i . "' width='1024px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";
            $dist_iframes[$i] = "<iframe src='/ctb-legacy/t/get_county_sub3.php?id=" . $county . "&sub=Supervisorial%20District%20" . $i . "' width='1040px' height='1280px'></iframe>";
            $supe_tables[$i] = get_supe_table($county, $i);

            $tmp = get_supe_incumbent($county, $i);
            $supe_incumbent[$i] = $tmp['html'];
            $supe_inc[$i] = $tmp['incumbent'];
            $supe_elec[$i] = $tmp['elections'];
            $radio_list .= "<li style='float: left;'><input type='radio' name='distmapper' class='radioMap' value='county=$county&sub=$i'>D" . $i . "</li>";
            $i++;
        }
        $radio_list .= "<li style='float: left;'><input type='radio' name='distmapper' class='radioMap' value='county=$county&sub=ALL'>ALL</li>";
    }
    $radio_list .= "<li style='float: left;'><input type='radio' name='distmapper' class='radioMap' value='county=$county'>COUNTY</li>";


    $tab_head = "<section class='container-fluid pt-xl'> <!--TAB SECTION START -->
                <div class='col-lg-10' style='width: 100vw;'> <!--TAB HEAD START -->
                  <nav class='page-nav'>
                    <ul class='clearfix'>
                	    <li><a href='#County' role='tab' data-toggle='tab'>County</a></li>
                      $districts
                      <li><a href='#Precincts' role='tab' data-toggle='tab'>Precinct</a></li>
                      <li><a href='#LocDetail' role='tab' data-toggle='tab'>Local Election Detail</a></li>
                      <li><a href='#Maps' role='tab' data-toggle='tab'>District Maps</a></li>
                    </ul>
                  </nav>";


    /*
    $tab_head = "<div id='tabs' style='width: 100%;'>
    <ul>
      <li><a href='#County'>County</a></li>
      $districts
      <li><a href='#Precincts'>Precinct</a></li>
      <li><a href='#LocDetail'>Local Election Detail</li>
    </ul>";



    $tab_head = "<section>
    <div class='tabs tabs-style-bar' style='width: 100%; background-color: white;'>
    <nav class='tab-bar'>
      <ul>
        <li><a href='#Overview' class='fa fa-lg fa-home'><span>Overview</span></a></li>
        <li><a href='#Incumbent' class='fa fa-lg fa-user'><span>Incumbent</span></a></li>
        <li><a href='#District' class='fa fa-lg fa-database'><span>District</span></a></li>
        <li><a href='#Campaigns' class='fa fa-lg fa-book'><span>Campaigns</span></a></li>
    </ul>
    </nav>";

    echo($tab_head);


    */

    //echo("<div class='container' style='display: inline-block; max-width: 1280px'>");
    //echo("<section style='-webkit-transform:scale(0.8);-moz-transform-scale(0.8); width: 110%; margin-left: -10%; margin-top: -5%;'>");

    //$county_stats = "<iframe src='get_county_sub3.php?id=" . $county . "&sub=County%20Totals' width='1024px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>";

    echo($tab_head);
    echo("<div class='content-wrap'><!--BEGIN CONTENT WRAP-->");


    echo("<section id='County' class='active'> <!--BEGIN COUNTY MAIN PAGE SECTION -->");
    echo("<div  width='100vw' class='row' style='max-width: 100vw !important;'><!--BEGIN COUNTY CONTAINER -->");
    echo("<div class='row'>");
    echo($location_div);
    echo("<div class='col-lg-7'>");
    Util::include('get_county_sub3.php', ['county' => $county, 'sub' => '']);
    echo("</div>");

    echo($supe_district_div);
    echo("</div>");
    //echo($county_stats);

    //echo($incumbent_div);
    //echo($map);
    //echo($loc_overlap);
    //echo($profile_div);
    echo("</div> <!--END COUNTY CONTAINER-->");
    echo("</section> <!--END COUNTY MAIN PAGE SECTION-->");


    $js = "  $('#checkbox_div input:radio').click(function() {

    var options = $('.radioMap:checked').val();
    var URL = '/ctb-legacy/draw_leg.php?' + options;

    //alert(URL);

    closeiframe2();
    var link = '/img/spinner.gif';
    //alert(URL);
    window.content.location.href=link;
    document.getElementById('hiddendiv_map').style['display'] = 'inline-block';
    window.content.location.href=URL;
    return false;


   });

function closeiframe2(type) {
  removeiframes2();
  var link = '/img/spinner.gif';
  var iframe = document.createElement('iframe');
  iframe.frameBorder=0;
  iframe.width='1030px';
  iframe.height='800px';
  iframe.id='hiddeniframe2';
  iframe.name='content';
  iframe.class='destroy_me';
  iframe.setAttribute('src', link);
  iframe.setAttribute('background-color', 'white');
  document.getElementById('hiddendiv_map').appendChild(iframe);
  return false;
}

";

    array_push($endjava, $js);

    /*
    $map_frame = "<p align='center'><div id='radio_div'><ul style='float: left; list-style: none;'>" . $radio_list . "</ul></div></p>
                <div height='1024' width='100%'>
                  <div id='hiddendiv_map' class='holds-the-iframe' style='display: inline-block;'></div>
                </div>";

                */

    $map_frame = "<p align='center'></p>
            <div height='1024' width='100%'>
              <div id='hiddendiv_map' class='holds-the-iframe' style='display: inline-block;'></div>
            </div>";


    $i = 1;
    foreach ($supe_tables as $f) {
        echo("<section id='D$i'> <!--BEGIN DISTRICT $i SECTION-->
          <div class='container' style='width: 100vw;'><!--BEGIN DISTRICT $i CONTAINER -->
            <div class='row'><!--BEGIN ROW-->
              <div class='col-lg-2'><!--BEGIN PAST SUPERVISOR ELECTION RESULTS, INCUMBENT-->");

        $sub = "Supervisorial District $i";

        echo($supe_inc[$i] . $supe_tables[$i] . "</div><!--END PAST SUPERVISOR ELECTION RESULTS, INCUMBENT-->");
        echo("</div><!--END SUPE INCUMBENT DIV THINGY? -->");

        echo("<div class='col-lg-7'><!--BEGIN COUNTY SUBDIVISION DETAILS-->");

	Util::include('get_county_sub3.php', ['county' => $county, 'sub' => $sub]);

        echo("</div><!--END COUNTY SUBDIVISION DETAILS-->");

        echo("<div class='col-lg-3'><!--BEGIN PAST ELECTIONS ANALYSES-->");
        echo($supe_elec[$i]);
        echo("</div><!--END PAST ELECTIONS ANALYSES-->");
        echo("</div><!--END ROW-->"); //END ROW
        echo("</div><!--END DISTRICT $i CONTAINER-->");
        echo("</section><!--END DISTRICT $i SECTION-->");
        $i++;
    }


    //array_push($endjava, $js);


    $cap_county = strtoupper($county);
    $num = convert_supe($cap_county);

    $precinct_frame = "<iframe src='/book/map_nav.php?id=CO" . $num . "' width='900px' height='950px'></iframe>";

    $local_detail_frame = "<iframe src='/book/get_county_all.php?id=$county' width='100%x' height='1280'></iframe>";


    echo("<section id='Precincts'><!--BEGIN PRECINCTS SECTION-->");
    echo("<div >$precinct_frame</div>");
    echo("</section><!--END PRECINCTS SECTION-->");

    echo("<section id='LocDetail' ><!--BEGIN LOCAL DETAIL SECTION-->");
    echo("<div width='100%' height='1280'>$local_detail_frame</div>");
    echo("</section><!--END LOCAL DETAIL SECTION-->");


    /*
    $test_frame = " <table id='checkbox_div'><tr><td>
     <ul>
    <li><input type='radio'  name='theme' value='theme1'/>Theme1</li>
    <li><input type='radio'  name='theme' value='theme2'/>Theme2</li>
    <ul>
    <li><input type='checkbox'  name='view1' />Tags</li>
    </ul>
    <li><input type='radio'  name='theme' value='theme3'/>Theme3</li>
    <li><input type='radio'  name='theme' value='theme4'/>Theme4</li>
    </ul>
       </td></tr> </table>";

    */

    $test_frame = "<table id='checkbox_div'>
                <tr>
                  <td>
                    <ul style='list-style: none;'>$radio_list</ul>
                  </td>
                </tr>
              </table>
              ";

    echo("<section id='Maps' ><!--BEGIN MAP SECTION-->");
    echo("<div width='100%' height='1200'>$test_frame" . $map_frame . "</div>");
    echo("</section><!--END MAP SECTION-->");


    echo("</div><!--END CONTENT WRAP-->");
    echo("</div><!--END TABS DIV-->");
    echo("</section><!--END TABS SECTION-->");


    function vote_adv($d, $r, $t)
    {

        $dem = number_format((($d / $t) * 100), 2);
        $rep = number_format((($r / $t) * 100), 2);

        if ($dem > $rep) {
            $reg_span = "<span class='blueme boldme'>D + " . number_format(($dem - $rep), 2) . "</span>";
        } elseif ($rep > $dem) {
            $reg_span = "<span class='redme boldme'>R + " . number_format(($rep - $dem), 2) . "</span>";
        } else {
            $reg_span = "<span class='grayme boldme'>GOP / DEM AT PARITY</span>";
        }

        return $reg_span;


    }

    function get_city_info($sub)
    {
        $conn = Util::get_ctb_conn();

        $sql = "SELECT land_sqmi, dateincorp, weblink FROM cal_cities_ca_cities WHERE name = '$sub'";
        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }

    }

    function has_local($sub)
    {
        $city = $sub;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $retval = Array();
        $sql = "SELECT * FROM ctb2016_city_vote_hist WHERE CITY = '$city' ORDER BY DATE DESC, OFFICE, SEAT DESC, VOTE_PCT DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($retval, $row);

                return TRUE;
            }
        }

        return FALSE;
    }

    function get_past_reg()
    {
        global $county;
        global $sub;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();

        $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE COUNTY = '$county' && SUBDIVISION = '$sub'";

        $findme = "Unincorporated";
        $is_unincorporated = substr_count($sub, $findme);

        if ($is_unincorporated) {
            $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE COUNTY = '$county' && SUBDIVISION LIKE 'Unincorporated area%'";
        }


        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }

        return $retval;
    }



    function get_cand_bio($id)
    {
        global $site_conn;
        $conn = Util::get_ctb_conn();
        $sql = "SELECT text from ctb_cand_bios WHERE juris = 'CA' && cand_id = '$id' ORDER BY date DESC, id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row['text'];
            }
        }

        //echo("<br>$sql<br>YIELDS $retval");
        return $retval;
    }

    function get_election_tabs($dist)
    {
        global $site_conn;
        global $county;
        global $endjava;

        $conn = Util::get_ctb_conn();

        $js = "  $( function() {
    $( \"#D" . $dist . "years\" ).tabs();
  } );  ";

        array_push($endjava, $js);

        $orig_dist = $dist;

        $dist = checkaddzero($dist);

        $cap_county = strtoupper($county);
        $county_num = convert_supe($cap_county);

        $fourcode = "CO" . $county_num;

        $sql = "SELECT text, year FROM ctb_analysis WHERE juris = 'CA' && dist = '$fourcode' && subdist = $dist ORDER BY year DESC, id DESC";
        //echo($sql);

        $result = $conn->query($sql);
        $tmp = [];
        $last_yr = '';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this_yr = $row['year'];
                if ($this_yr == $last_yr) {
                    continue;
                }

                $tmp[$this_yr] = $row['text'];
                $last_yr = $this_yr;
            }
        }

        $year_tabs = '';
        foreach ($tmp as $key => $value) {
            $year = $key;

            $year_tabs .= "<li><a href='#D" . $orig_dist . "_$year'>$year</a></li>";

            $sql = "SELECT * FROM ctb_ca_supe_cands WHERE COUNTY_NUM = $county_num && DIST = $dist && year = $year";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if (!$cands[$year]) {
                        $cands[$year] = Array();
                    }

                    $row['BIO'] = get_cand_bio($row['OTHER_ID']);

                    if ($row['CMTE_ID']) {
                        $row['NETFILE'] = "<a href='nf.php?id=" . $row['CMTE_ID'] . "' target='_blank'>CAMPAIGN FINANCE DETAILS</a>";
                    }

                    array_push($cands[$year], $row);
                }
            }
        }

        $year_head = "<div id='D" . $orig_dist . "years' align='justify'>
                  <ul>
                  $year_tabs
                  </ul>";


        $end_html = $year_head;

        foreach ($tmp as $key => $value) {
            $year_div = "<div id = 'D" . $orig_dist . "_" . $key . "'>" . $value . "<hr />";

            foreach ($cands[$key] as $c) {
                $cand_id = $c['OTHER_ID'];
                $img = get_image_url($cand_id);
                if ($c['BIO']) {
                    $bio = $c['BIO'];
                } else {
                    $bio = $c['NAMF'] . " " . $c['NAML'];
                }
                $year_div .= "<div class='canddiv inddiv'><p>" . $img . $bio . "</p>";
                if ($c['NETFILE']) {
                    $year_div .= "<br>" . $c['NETFILE'];
                }
                $year_div .= "</div>";
            }

            $year_div .= "</div>";

            $end_html .= $year_div;
            $year_div = '';

        }

        $end_html .= "</div>";

        //$end_html .= "<div><iframe src='draw_supe.php?county=" . $county . "&dist=" . $old_dist . "' width='600px' height='400px'><iframe></div>";

        return $end_html;

    }

    function get_image_url($cand_id)
    {
        $filetypes = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
        $path = "img/candidates/";
        foreach ($filetypes as $suffix) {
            if (file_exists($path . $cand_id . $suffix)) {
                $url = ($path . $cand_id . $suffix);
                break;
            }
        }
        if ($url) {
            $img_lnk = "<img src='/$url' />";
        } else {
            $img_lnk = "<img src='/img/candidates/NO_IMAGE.jpg' />";
        }

        return $img_lnk;

    }


    function get_images($county)
    {
        //global $county;
        $prefix = strtoupper($county);
        $path = "img/";
        $supe_prefix = $prefix . "_SUPE";

        $filetypes = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");

        foreach ($filetypes as $suffix) {
            if (file_exists($path . $prefix . $suffix)) {
                $retval['LOCATION'] = ('/' . $path . $prefix . $suffix);
            }
            if (file_exists($path . $supe_prefix . $suffix)) {
                $retval['DISTRICTS'] = ('/' . $path . $supe_prefix . $suffix);
            }
        }

        return $retval;
    }

    function get_cities($county)
    {
        //global $county;
        $conn = Util::get_ctb_conn();


        $this_county = strtoupper($county);
        $sql = "SELECT name FROM cal_cities_ca_cities WHERE COUNTY = '$this_county' GROUP BY name";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $city = $row['name'];
                $link = "<a href='/book/city/$city' target='_blank'>$city</a>" . ", ";
                $retval .= $link;
            }
        }

        return $retval;

    }

    function get_supe_table($county, $dist)
    {
        //global $county;
        global $ctb2016_conn;
        $conn = Util::get_ctb_conn();
        $county = strtoupper($county);
        $sql = "SELECT * FROM ctb2016_county_vote_hist WHERE COUNTY = '$county' && OFFICE = 'COUNTY SUPERVISOR' && SEAT = '$dist' ORDER BY DATE DESC, VOTE_CAND DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $year = mb_substr($row['DATE'], 0, 4);
                $election = $row['DATE'];
                if (!$e_yr[$year][$election]) {
                    $e_yr[$year][$election] = Array();
                }
                array_push($e_yr[$year][$election], $row);
            }
        }

        $retval = '';
        foreach ($e_yr as $year => $x) {
            $retval .= "<p align='center' style='font-weight: bold; font-size: 1.4em;'>$year</p>";
            foreach ($x as $election => $y) {
                $tablehead = "<table id='districtWrapper' cellspacing='0' border='0' align='center' style='margin-top: 10px;'>
                      <thead>
                        <tr>
                          <th colspan=4>$election</th>
                        </tr>
                      </thead>
                      <tbody>";
                $tablebody = '';

                $i = 0;

                foreach ($y as $c) {
                    $vote_pct = number_format((($c['VOTE_CAND'] / $c['VOTE_TOT']) * 100), 2);
                    $rowclass = '';
                    if ($c['IS_INCUMBENT']) {
                        $rowclass = 'itcme';
                    }

                    if ($i < 1) {
                        $rowclass .= ' boldme';
                    }

                    $tablebody .= "<tr class='$rowclass'>
                        <td class='blueColumn'>" . $c['NAMF'] . " " . $c['NAML'] . "</td>
                        <td class='greyColumn'>" . $c['DESIGNATION'] . "</td>
                        <td class='blueColumn'>" . number_format($c['VOTE_CAND']) . "</td>
                        <td class='blueColumn'>" . $vote_pct . "</td>
                      </tr>
                        ";
                    $i++;
                }

                $retval .= $tablehead . $tablebody . "</tbody></table>";

            }

        }

        return $retval;

    }

    function get_supe_incumbent($county, $district)
    {
        global $site_conn;
        //global $county;
        $old_dist = $district;
        $district = checkaddzero($district);
        $conn = Util::get_ctb_conn();
        $sql = "SELECT * FROM ctb_ca_county_incumbents WHERE COUNTY = '$county' && DIST = '$district'";
        //echo($sql);
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['cand_id'] = $row['OTHER_ID'];
                $retval['namf'] = $row['NAMF'];
                $retval['naml'] = $row['NAML'];
                $retval['url'] = $row['URL'];
                if ($row['TERM_LIMIT']) {
                    $term_limit = "Term Limit: " . $row['TERM_LIMIT'] . "<br>";
                } else {
                    $term_limit = '';
                }

                $path = "img/candidates/" . $row['OTHER_ID'];

                $types = Array(".png", ".jpg", ".jpeg", ".bmp", ".gif");

                foreach ($types as $suffix) {
                    if (file_exists($path . $suffix)) {
                        $retval['img'] = '/' . $path . $suffix;
                        break;
                    }
                }
            }
        }

        //echo("<br>AFTER QUERY, RETVAL DUMP:<br>");
        //var_dump($retval);

        $sql = "SELECT text from ctb_cand_bios WHERE cand_id = '" . $retval['cand_id'] . "' ORDER BY date DESC, id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['bio'] = $row['text'];
            }
        }

        $t = get_election_tabs($old_dist);;


        $html = "<div align='center'>
            <p align='center' style='font-weight: bold; font-size: 1.2em; font-variant: small-caps;'>
              <img src='" . $retval['img'] . "' width='200px' />
              <br>" . $retval['namf'] . " " . $retval['naml'] .
            "<br>" . $term_limit .
            "</p>
             <div width='100%' align='justify'>
             <p style='text-align: justify !important;'>" . $retval['bio'] . "</p>
             </div>";

        $retval['incumbent'] = $html;
        $retval['elections'] = $t;

        if ($t) {
            $html .= $t;
        }


        $html .= "</div>";
        $retval['html'] = $html;

        return $retval;
    }

    function get_cal_incumbent_bio($fourcode)
    {
        global $site_conn;
        $conn = $site_conn;
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

    function convert_supe($county)
    {
        $this_county = strtoupper($county);

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

        return $conversion_array[$county];

    }


    //echo("<p style='font-family: \"Montserrat\"; font-size: 16pt; text-align: justify;'>$bio_txt</p>");


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

    function drawreg($fourcode)
    {

        if (mb_substr($fourcode, 0, 2) == "CA") {
            global $ctb2016_conn;
            $conn = Util::get_ctb_conn();
            $dist = mb_substr($fourcode, 2, 2);
            $adjusted = "CD" . $dist;
            $sql = "SELECT * FROM ctb2016_sos_oct16 WHERE DIST = '$adjusted'";
        } else {
            global $fl_conn;
            $conn = $fl_conn;
            $sql = "SELECT * FROM ctb2016_state_reg WHERE FOURCODE = '$fourcode'";
        }

        //echo("<br>$sql<br>");
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $dem = $row['DEM'];
                $rep = $row['REP'];
                $npp = $row['NPP'];
                $tot = $row['TOT'];
                $oth = $row['OTH'];
            }
        }

        $dem_pct = makeplainpercent($dem, $tot);
        $rep_pct = makeplainpercent($rep, $tot);

        $dem_pct_draw = makepct($dem, $tot);
        $rep_pct_draw = makepct($rep, $tot);
        $npp_pct_draw = makepct($npp, $tot);
        $oth_pct_draw = makepct($oth, $tot);

        if ($dem_pct > $rep_pct) {
            $advantage = "<span class='blueme boldme'>D +" . number_format(($dem_pct - $rep_pct), 2) . "%</span>";
        }

        if ($rep_pct > $dem_pct) {
            $advantage = "<span class='redme boldme'>R +" . number_format(($rep_pct - $dem_pct), 2) . "%</span>";
        }

        $drawme = "
        <p class='boldme' align='center'>TOTAL VOTERS: " . number_format($tot) . "</p><p align='center'>$advantage</p><p align='center'><span class='blueme boldme'>DEM: $dem_pct_draw</span>&nbsp;--&nbsp;<span class='redme boldme'>REP: $rep_pct_draw</span>&nbsp;--&nbsp;NPP: $npp_pct_draw -- OTH: $oth_pct_draw</p>";

        if (!$dem) {
            $drawme = '';
        }

        $arr = Array("AL", "GA", "HI", "IL", "IN", "MI", "MN", "MS", "MO", "MT", "ND", "OH", "SC", "TN", "TX", "VT", "VA", "WA", "WI");
        foreach ($arr as $entry) {
            $thisstate = mb_substr($fourcode, 0, 2);
            //echo("<br>COMPARING $thisstate with Array entry $entry");
            if (mb_substr($fourcode, 0, 2) == $entry) {
                $drawme = "<h2 class='boldme itcme' align='center'>This State Does Not Have Partisan Voter Registration</h2>";
            }
        }

        $arr = Array("AR", "CT", "ID", "MA", "NE", "NH", "NC", "OK", "PA", "RI", "UT", "WV");
        foreach ($arr as $entry) {
            if (mb_substr($fourcode, 0, 2) == $entry) {
                $drawme = "<h2 class='boldme itcme' align='center'>This State Fails to Provide its Partisan Registration by Congressional District</h2>";
            }
        }

        return $drawme;

    }

    function makeplainpercent($portion, $total)
    {
        $x = ($portion / $total) * 100;

        return $x;
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


function get_the_stats($county, $sub)
{
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM ctb2016_vote_hist_UPDATED WHERE COUNTY LIKE '$county%' && SUBDIVISION = '$sub'";
    

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
    <script src="/js/modernizr.custom.js"></script>

    <script>
      $(function () {
        $("#tabs").tabs();
      });

      $(function () {
        $("#years").tabs();
      });
    </script>

    <script>
      function resizeIframe(obj) {
        obj.style.height = (obj.contentWindow.document.body.scrollHeight + 25) + 'px';
      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1024pxpx";
        iframe.height = "3800px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv").appendChild(iframe);
        return false;
      }


      function removeiframes() {
        var iframes = document.querySelectorAll('iframe');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }

      function removeiframes2() {
        var iframes = document.querySelectorAll('#hiddeniframe2');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }

      var selectElement = form.querySelector('input[name="pwd"]');

      function mapSelect() {

        var options = $(".radioMap:checked").val();
        var URL = '/ctb-legacy/draw_leg.php?' + options;
        alert(URL);

        if (error) {
          alert(URL);
          alert(error);
          return false;
        } else {
          closeiframe();


          var link = "/img/spinner.gif";
          alert(URL);
          window.content.location.href = link;
          document.getElementById("hiddendiv").style["display"] = "inline-block";
          window.content.location.href = URL;
          return false;
        }
      }


      //$("input:radio:first").prop("checked", true).trigger("click");


    </script>

    <script src="/js/cbpFWTabs.js"></script>
    <script>
      (function () {

        [].slice.call(document.querySelectorAll('.tabs')).forEach(function (el) {
          new CBPFWTabs(el);
        });

      })();
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

    body {
        background-color: white;
    }

    .dropshadow {
        -webkit-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        -moz-box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
        box-shadow: 15px 16px 43px -16px rgba(0, 0, 0, 0.71);
    }

    .holds-the-iframe {
        background: url('/img/spinner.gif') no-repeat;

    }

    .boldme {
        font-weight: bold;
    }

    .itcme {
        font-style: italic;
    }

    input.button {
        background: #dedede;
        background-image: -webkit-linear-gradient(top, #dedede, #787878) !important;
        background-image: -moz-linear-gradient(top, #dedede, #787878) !important;
        background-image: -ms-linear-gradient(top, #dedede, #787878) !important;
        background-image: -o-linear-gradient(top, #dedede, #787878) !important;
        background-image: linear-gradient(to bottom, #dedede, #787878) !important;
        -webkit-border-radius: 28 !important;
        -moz-border-radius: 28 !important;
        border-radius: 28px !important;
        -webkit-box-shadow: 0px 1px 3px #666666 !important;
        -moz-box-shadow: 0px 1px 3px #666666 !important;
        box-shadow: 2px 2px 3px #666666 !important;
        font-family: 'Lato' !important;
        font-weight: normal !important;
        color: white !important;
        font-size: 16px !important;
        border: solid black 2px !important;
        width: 28% !important;
        margin: 0px auto !important;
        margin-right: 10px !important;
        margin-top: 0px !important;
        height: 40px !important;
        text-decoration: none !important;
        text-shadow: 1px 2px black !important;
    }

    input.button:hover {
        background: #3cb0fd !important;
        background-image: -webkit-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
        background-image: -moz-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
        background-image: -ms-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
        background-image: -o-linear-gradient(top, #3cb0fd, #0a3b5c) !important;
        background-image: linear-gradient(to bottom, #3cb0fd, #0a3b5c) !important;
        text-decoration: none !important;
        color: white;
    }

    input.close {
        background: #3498db !important;
        display: inline;
        background: #dedede;
        background-image: -webkit-linear-gradient(top, #dedede, #787878) !important;
        background-image: -moz-linear-gradient(top, #dedede, #787878) !important;
        background-image: -ms-linear-gradient(top, #dedede, #787878) !important;
        background-image: -o-linear-gradient(top, #dedede, #787878) !important;
        background-image: linear-gradient(to bottom, #dedede, #787878) !important;
        -webkit-border-radius: 28 !important;
        -moz-border-radius: 28 !important;
        border-radius: 28px !important;
        -webkit-box-shadow: 0px 1px 3px #666666 !important;
        -moz-box-shadow: 0px 1px 3px #666666 !important;
        box-shadow: 0px 1px 3px #666666 !important;
        font-family: 'Lato' !important;
        font-weight: normal !important;
        color: white !important;
        font-size: 14px !important;
        border: solid black 2px !important;
        width: 10% !important;
        margin: 0px auto !important;
        margin-right: 0px !important;
        margin-top: 0px !important;
        height: 40px !important;
        text-decoration: none !important;
        text-shadow: 1px 2px black !important;
    }

    input.close:hover {
        background: #fc3c3c !important;
        background-image: -webkit-linear-gradient(top, #fc3c3c, #73001d) !important;
        background-image: -moz-linear-gradient(top, #fc3c3c, #73001d) !important;
        background-image: -ms-linear-gradient(top, #fc3c3c, #73001d) !important;
        background-image: -o-linear-gradient(top, #fc3c3c, #73001d) !important;
        background-image: linear-gradient(to bottom, #fc3c3c, #73001d) !important;
        text-decoration: none !important;
        color: white;
        scale: 1.1;
    }

    input.campaign {
        max-width: 600px !important;
    }

    #btmclose {
        display: none;
    }

    #btmclose2 {
        display: none;

    }

    #welcomeDiv {
        display: none;
    }

    #welcomeDiv2 {
        display: none;
    }

    .analysis {
        line-height: 170%;
        font-family: 'Lato';
        font-size: 1.1em;
        padding: 5%;
        text-align: justify;
        margin-left: auto;
        margin-right: auto;
    }

    .analysis strong, b {
        font-weight: bold;
        color: blue;
    }

    .analysis img {
        border-radius: 15px;
        float: left;
        max-width: 150px;
        padding: 5px;
    }

    .campaignHead {
        font-size: 2.0em;
        font-weight: bold;
        color: FireBrick;
        text-align: center;
        font-family: 'Lato';
        font-variant: small-caps;
    }

    .campaignSubHead {
        font-size: 1.5em;
        font-weight: bold;
        color: black;
        text-align: center;
        font-family: 'Lato';
        font-variant: small-caps;
    }

    iframe {
        border: none;
    }

    #districtWrapper {
        box-shadow: 3px 3px 3px #999;
        min-width: 100%;
    }

    #districtanalyses th {
        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    th {

        background: rgb(82, 133, 216); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(82, 133, 216, 1) 0%, rgba(5, 11, 21, 1) 46%, rgba(0, 1, 2, 1) 50%, rgba(4, 9, 16, 1) 53%, rgba(29, 67, 127, 1) 76%, rgba(21, 48, 91, 1) 87%, rgba(10, 23, 44, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        color: white;
        font-family: 'Lato';

    }

    #districtWrapper td {

        font-family: 'PT Sans Narrow';
        padding: 5px;
        font-size: 1em;
    }

    .greyColumn {

        background: rgb(238, 238, 238); /* Old browsers */
        background: -moz-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(238, 238, 238, 1) 0%, rgba(204, 204, 204, 1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */

    }

    .blueColumn {
        background: rgb(235, 241, 246) !important; /* Old browsers */
        background: -moz-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* FF3.6-15 */
        background: -webkit-linear-gradient(top, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, rgba(235, 241, 246, 1) 0%, rgba(171, 211, 238, 1) 50%, rgba(137, 195, 235, 1) 51%, rgba(213, 235, 251, 1) 100%) !important; /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
    }

    .winner {
        font-weight: bold;
        font-variant: small-caps;
    }

    .greenme {
        color: green;
    }

    .canddiv {
        background-color: WhiteMist;
        margin-top: 10px;
        padding: 20px;
        font-family: 'Lato';
        line-height: 1.5;
        display: inline-block;
    }

    .canddiv img {
        float: left;
        border-radius: 10px;
        width: 100px;
        margin: 0px 5px 1px 0px;

    }

    .demdiv {
        border: 2px solid blue;
        border-radius: 10px;

    }

    .grndiv {
        border: 2px solid green;
        border-radius: 10px;

    }

    .repdiv {
        border: 2px solid red;
        border-radius: 10px;
    }

    .inddiv {
        border: 2px solid gray;
        border-radius: 10px;
    }

    .container table {
        font-family: 'PT Sans Narrow';
        font-size: 1em;
    }

    table th {
        text-align: center;
        font-family: 'PT Sans Narrow';
        font-weight: bold;
    }

    .registration_table {
        font-size: 1.2em;
        padding-left: 5px;
        padding-right: 5px;
        width: 100%;
    }


</style>
@endsection

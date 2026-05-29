<?php
    global $fourcode, $role, $endjava;
    $fourcode = $id;
    $endjava = Array();

    Util::require_ctb_api();

    use App\User;
    $role = Auth::user()->role;

?>

@php ($book_side_nav_active = 'district')

@extends('layouts.bookNew')

@section('title', 'NEW '.$id.' | California Target Book')

@section('content')

    <?php
        global $cached, $json_cache, $json_ie, $ror_info, $cvap_table_store;

        populate_cached($id);
        //$cached = populate_cached($id);
        $cached['fourcode'] = $id;

        $ror_info = get_last_ror($id);
        $fourcode = $id;
        $type = mb_substr($fourcode, 0, 2);
        $old_fourcode = $fourcode;

        $old_fourcodes = get_fourcode_index();
        $dists = Array($fourcode);
        $cvap_table_store = get_cvap($type, $dists);
        $pres = get_pres($type);
        $reg  = get_reg($ror_info['rpt_date']);

            if(mb_substr($fourcode, 0, 1) != ".") {
             $dist = (int)mb_substr($fourcode, 2,2);
             if(mb_substr($fourcode, 0, 3) == "BOE") {
                    $type = "BD";
                    $dist = mb_substr($fourcode, 3, 1);
            $old_fourcodes['new'][$fourcode] = $fourcode;
             }
        
             $old_fourcode = $old_fourcodes['new'][$fourcode];
            } 
        $dist_dscr = get_district_info($fourcode);
        //$cand_tables = locate_candidates($fourcode);
        $zip_div = get_redist_zips($fourcode);


        $sov_tables = retrieve_sov_tables($fourcode, "2022");
        $sov_table_draw['2022']['p'] = $sov_tables['p'];
        $sov_table_draw['2022']['g'] = $sov_tables['g'];

        $sov_tables = retrieve_sov_tables($fourcode, "2024");
        $sov_table_draw['2024']['p'] = $sov_tables['p'];

    if(mb_substr($fourcode, 0, 1) == ".") {
       $url = "/ctb-legacy/drawcd_20.php?id=CASEN";
    } else {
           $url = "/ctb-legacy/draw_viz.php?city=VIZ8_" . $type . "&cd=" . $dist;
        }
        $iframe_html = "<iframe src='$url' width='600' height='480' align='center' scrolling='no'></iframe>";
        

    ?>

    <ul class="hot-breadcumb d-flex">
        <li><a href="{{ route('book') }}" class="text-decoration-none">California Target Book</a></li>
        <li><a href="{{ route('old.new_districts') }}" class="text-decoration-none">District</a></li>
        <li class="active">District details</li>
    </ul>

    <div class="container-fluid pt-lg">
        <div class="ctb-main-container ps-xl-0" style="background-color:#eeeef1">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="ctb-districts-container">
                                <ul class="nav nav-pills general-pill-tab mb-3  bg-white pt-2 ctb-inline-tab  ctb-border-radius" id="pills-tab">
                                    <li class="nav-item active">
                                        <a class="nav-link" data-toggle="pill" href="#pills-summary"><span>Summary</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#pills-district"><span>District</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#pills-cities"><span>Cities</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#pills-old-results"><span>Past Results</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#pills-difference-report"><span>Difference Report</span></a>
                                    </li>
                                    <li class="nav-item" data-tab="incumbent">
                                        <a class="nav-link" data-toggle="pill" href="#pills-incumbent"><span>Incumbent</span></a>
                                    </li>
                                    <li class="nav-item" data-tab="campaigns">
                                        <a class="nav-link" data-toggle="pill" href="#pills-campaigns"><span>Campaigns</span></a>
                                    </li>
                                    <li class="nav-item" data-tab="hot-sheets">
                                        <a class="nav-link" data-toggle="pill" href="#pills-hot-sheets"><span>Hot Sheets</span></a>
                                    </li>


                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <!-- Summary -->
                                    <div class="tab-pane fade active in districts_tabs" id="pills-summary">

                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="headingDiv">
                                                    <h5>{{ $fourcode }} {!! get_incumbent($fourcode) !!}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">

                                            <div class="col-md-6">
                                                <div class="headingDiv">
                                                    <h5>Incumbent</h5>
                                                </div>
                                                <div class="ctb-incumbent-box mt-3 ctb-border-radius bg-white summary_Incumbent">
                                                    <?php include(Util::$view_root.'incumbent_info_test.php') ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="headingDiv">
                                                    <h5>District</h5>
                                                </div>
                                                <div class="ctb-incumbent-box mt-3 bg-white ctb-border-radius">
                                                    <div class="ctb-incumbent-content">
                                                        <div class="ctb-incumbent-profile-img text-center">
                                                            <?php echo $iframe_html; ?>
                                                        </div>
                                                        <div class="ctb-incumbent-description px-4 py-2 mt-2">
                                                            <p><?php echo $dist_dscr; ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                            draw_district_registration($fourcode);
                                        ?>

                                        <?php
                                            get_county_registration_div($fourcode);
                                        ?>

                                        <div class='col-md-12 mt-3'>
                                            <div class="headingDiv">
                                                <h5>2024 Primary</h5>
                                            </div>                                        
                                            <div class='ctb-county-registration bg-white mt-3 pt-3 ctb-border-radius'>
                                                <div class='ctb-country-content new px-4'>
                                                    <?php echo($sov_tables['p']); ?>
                                                </div>
                                            </div>
                                        </div>
                
                    <!--
                                        <div class='col-md-12 mt-3'>
                                            <div class="headingDiv">
                                                <h5>2022 General</h5>
                                            </div>                                            
                                            <div class='ctb-county-registration bg-white pt-3 mt-3 ctb-border-radius'>
                                                <div class='ctb-country-content new px-4'>
                                                    <?php //echo($sov_tables['g']); ?>
                                                </div>
                                            </div>
                                        </div>
                    -->

                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="headingDiv">
                                                    <h5>District Overlaps</h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="d-grid three_coll bg-white">
                                                <?php  
                                                    $first_two = mb_substr($fourcode, 0, 2);
                                                    switch($first_two) {
                                                        case "AD":
                                                            draw_overlap("CO", $fourcode, $json_cache);
                                                            draw_overlap("SD_NEW", $fourcode, $json_cache);
                                                            draw_overlap("CD_NEW", $fourcode, $json_cache);
                                                            break;
                                                        case "SD":
                                                            draw_overlap("CO", $fourcode, $json_cache);
                                                            draw_overlap("AD_NEW", $fourcode, $json_cache);
                                                            draw_overlap("CD_NEW", $fourcode, $json_cache);
                                                            break;
                                                        case "CD":
                                                            draw_overlap("CO", $fourcode, $json_cache);
                                                            draw_overlap("AD_NEW", $fourcode, $json_cache);
                                                            draw_overlap("SD_NEW", $fourcode, $json_cache);
                                                            break;
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>                                        

                                        <div class="row my-3">
                                            <div class="col-md-12">
                                                <div class="headingDiv">
                                                    <h5>Census Data</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3 ethnic_cvap">
                                                <?php
                            if(!empty($cvap_table_store)) {
                                echo($cvap_table_store);
                            }
                        ?>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- District -->
                                    <div class="tab-pane fade districts_tabs" id="pills-district"  >
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="ctb-ribbon">
                                                    <div class="d-flex align-items-center headingDiv">
                                                        <div class="col-md-6 p-0">
                                                            <div class="ctb-ribbon">
                                                                <h5 class="mb-0 ">Registration (<?php echo($ror_info['long_date']); ?>)</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 p-0">
                                                            <p class="text-sm-start text-md-end mb-0 big-reg" style="font-family: 'Lato', sans-serif; font-size: 2.5em; font-weight: bold; line-height: 30px;">
                                                                <?php echo($reg[$fourcode]['ADV']); ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3 d-grid district_Registration_boxes row_before_none">
                                            <?php

                                                $arr = $reg[$fourcode];
                                                unset($arr['DIST']);
                                                unset($arr['ADV']);
                                                unset($arr['OTH']);
                                                arsort($arr);

                                                $long_parties = Array(
                                                    "TOT"   => "Total Registation",
                                                    "DEM"   => "Democratic",
                                                    "REP"   => "Republican",
                                                    "NPP"   => "No Party Preference",
                                                    "LIB"   => "Libertarian",
                                                    "GRN"   => "Green Party",
                                                    "AIP"   => "American Independent Party",
                                                    "PAF"   => "Peace & Freedom Party"
                                                    );
                                                $tot = $arr['TOT'];
                                                foreach($arr as $key => $v) {
                                                    if($key == "ADV") {
                                                        continue;
                                                    }
                                                    $this_long = $long_parties[$key];
                                                    if($key == "TOT") {
                                                        $this_pct = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                                    } else {
                                                        $this_pct = number_format((($v / $tot) * 100), 2) . "%";
                                                    }


                                                    echo'<div class="col-md-12 p-0">
                                                        <div class="ctb-district-normal-box bg-white p-3 ctb-border-radius">
                                                            <div class="col-lg-6" align="left">
                                                                <h4>' . number_format($v) . '</h4>
                                                            </div>
                                                            <div class="col-lg-6" align="right">
                                                                <h4>' . $this_pct . '</h4>
                                                            </div>
                                                            <p class="mb-0" align="center">'. $this_long . '</p>
                                                        </div>
                                                    </div>';                                                    
                                                }
                                            ?>
                                        </div>


                                        <div class="row">
                                            <div class="governer_rows">
                                                <div class="row">
                                                <?php
                                                    $races = Array("g22-GOV", "g18-GOV", "g14-GOV", "g10-GOV");
                                                    draw_topline($races);
                                                ?>
                                                </div>
                                                <div class="row">
                                                <?php
                                                    $races = Array("g20-PRS", "g16-PRS", "g12-PRS", "g08-PRS");
                                                    draw_topline($races);
                                                ?>
                                                </div>
                                            </div>
                                        </div>




                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="headingDiv">
                                                    <h5>Ethnic CVAP and Counties - Co</h5>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="row mt-3">
                                            <div class="col-md-6 ethnic_cvap">
                                                <?php
                            if(!empty($cvap_table_store)) {
                                echo($cvap_table_store);
                            }
                        ?>
                                            </div>

                                            <div class="col-md-6 pe-0">
                                                <div class="h-100 ctb-district-counties-container bg-white py-3 px-3 ctb-border-radius">
                                                    <h3>Counties - Co</h3>
                                                    <div class="ctb-district-counties-co">
                                                        <?php
                                                            draw_overlap("CO", $fourcode, $json_cache);
                                                            $first_two = mb_substr($fourcode, 0, 2);
                                                            $long_types = Array(
                                                                "CD" => "Congressional Districts",
                                                                "AD" => "Assembly Districts",
                                                                "SD" => "State Senate Districts",
                                                                );
                                                            switch($first_two) {
                                                                case "AD":
                                                                    $p1 = "SD";
                                                                    $p2 = "CD";
                                                                    break;
                                                                case "SD":
                                                                    $p1 = "AD";
                                                                    $p2 = "CD";
                                                                    break;
                                                                case "CD":
                                                                    $p1 = "AD";
                                                                    $p2 = "SD";
                                                                    break;
                                                                default:
                                                                    $p1 = '';
                                                                    $p2 = '';
                                                            }
                                                        ?>
                                                        <!--
                                                        if(array_key_exists("CO",$cached)){
                                                                echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['CO']);
                                                        }else echo '<h4>No data available'
                                                        ?>
                                                        -->
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="headingDiv">
                                                    <h5>District Overlaps</h5>
                                                    <p class="mb-0">(2020 General Election Redistricting Data)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 px-0">
                                                <div class="h-100 ctb-district-congressional-container bg-white p-3 ctb-border-radius">
                                                    <h3>
                            <?php 
                                if(!empty($long_types[$p1])) {
                                    echo($long_types[$p1]);
                                }
                             ?>
                                </h3>
                                                    <div class="ctb-district-congressional general-pill-tab">


                                                        <ul class="nav nav-pills mb-3 bg-white pt-2 ctb-inline-tab  ctb-border-radius" id="pills-tab">
                                                            <li class="nav-item activee">
                                                                <a class="nav-link" data-toggle="pill" href="#p1_new"><span><?php echo($p1); ?></span></a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="pill" href="#p1"><span><?php echo($p1 . " Old"); ?></span></a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade activee" id="p1_new" >
                                                                <?php draw_overlap($p1 . "_NEW", $fourcode, $json_cache); ?>
                                                            </div>

                                                            <div class="tab-pane fade" id="p1" >
                                                                <?php draw_overlap($p1, $fourcode, $json_cache); ?>                                                               
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pe-0">
                                                <div class="h-100 ctb-district-state-senate-container  bg-white p-3 ctb-border-radius">
                                                    <h3>
                            <?php 
                                if(!empty($long_types[$p2])) {
                                    echo($long_types[$p2]);
                                }
                             ?>

                            </h3>
                                                    <div class="ctb-district-state-senate general-pill-tab">


                                                        <ul class="nav nav-pills mb-3 bg-white pt-2 ctb-inline-tab  ctb-border-radius" id="pills-tab">
                                                            <li class="nav-item activee">
                                                                <a class="nav-link" data-toggle="pill" href="#p2_new"><span><?php echo($p2); ?></span></a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="pill" href="#p2"><span><?php echo($p2 . " Old"); ?></span></a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade activee" id="p2_new" >
                                                                <?php draw_overlap($p2 . "_NEW", $fourcode, $json_cache); ?>
                                                            </div>

                                                            <div class="tab-pane fade" id="p2" >
                                                                <?php draw_overlap($p2, $fourcode, $json_cache); ?>                                                               
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="headingDiv">
                                                    <h5>ZIP Codes Within District</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <?php
                                                $dom = new DOMDocument;
                                                $dom->loadHTML($zip_div);

                                                // Get all <p> tags
                                                $pTags = $dom->getElementsByTagName('p');
                                                $pTagText = [];

                                                foreach ($pTags as $pTag) {
                                                    $pTagText[] = $pTag->textContent;
                                                }
                                                $completeArray = explode(', ', $pTagText[0]);
                                                $partialArray = explode(', ', $pTagText[1]);

                                            ?>
                                            <div class="col-md-6 p-0">
                                                <div class="ctb-district-complete-container bg-white p-3 ctb-border-radius">
                                                    <h3>Complete</h3>
                                                    <div class="table-responsive row">
                                                        @foreach($completeArray as $value)
                                                            <div class="col-md-2 p-0">
                                                                <table class="table">
                                                                    <tr>
                                                                        <td>{{ $value }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pe-0">
                                                <div class="h-100 ctb-district-partial-container bg-white p-3 ctb-border-radius">
                                                    <h3>Partial</h3>
                                                    <div class="table-responsive row">
                                                        @foreach($partialArray as $value)
                                                            <div class="col-md-2 p-0">
                                                                <table class="table">
                                                                    <tr>
                                                                        <td>{{ $value }}</td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Cities -->
                                    <div class="tab-pane fade" id="pills-cities"  >
                                        <div class="row mt-3">
                                            <?php 
                        if(!empty($cached['CITIES'])) {
                            echo($cached['CITIES']); 
                        }
                        ?>
                                        </div>
                                    </div>
                                    <!-- Old Results -->
                                    <div class="tab-pane fade" id="pills-old-results" >
                                        <div class="row mt-3">
                                            <?php //echo($cached['PAST_RESULTS']);
                        if(mb_substr($fourcode, 0, 1) != ".") {
                                                    generate_past_results($fourcode);
                        }
                                            ?>
                                        </div>
                                    </div>
                                    <!-- Difference Report -->
                                    <div class="tab-pane fade" id="pills-difference-report" >
                                        <section id='Diff' class='table-striped' style='line-height: 1em;'>
                                            <?php 

                        if(!empty($cached['DIFF'])) { 
                            echo($cached['DIFF']); 
                        }
                        ?>
                                        </section>
                                    </div>
                                    <!-- Incumbent -->
                                    <div class="tab-pane fade districts_tabs" id="pills-incumbent" style="padding: 0 !important" >
                                        <?php include(Util::$view_root.'incumbent_page_test_20.php') ?>
                                    </div>
                                    <!-- Camaigns -->
                                    <div class="tab-pane fade districts_tabs pills-campaigns_tabs" id="pills-campaigns" style="padding: 0 !important">
                                        <?php include(Util::$view_root.'cal_campaigns_test_20.php') ?>
                                    </div>
                                    <!-- Past Hot Sheets -->
                                    <div class="tab-pane fade districts_tabs" id="pills-hot-sheets"  >

                                        <div class="row mt-3">
                                            <div class="col-md-8 ps-0">
                                            <div class="headingDiv">
                                                <h5>Hot Sheets</h5>
                                            </div>
                                            <form class="ctb-filter d-flex align-items-center gap-2" method="POST" action="{{ route('book.hotsheet.filterArticles') }}" id="filter-form">
                                                @csrf
                                                <input type="hidden" id='districtField' value="{{ $fourcode }}">
                                                <div class="ctb-search-field">
                                                    <input
                                                    class="ctb-search w-100"
                                                    type="text"
                                                    id='searchQuery'
                                                    placeholder="Search Hot Sheets"
                                                    />
                                                </div>
                                                <div class="ctb-filters-btns d-flex justify-content-end align-items-center">
                                                    <div class="ctb-search-field">
                                                        <input
                                                        class="ctb-input"
                                                        type="date"
                                                        id='dateField'
                                                        />
                                                    </div>
                                                    <button type="button" id='applyFilter' class="p-2 ctb-input btn-default">Filter</button>
                                        
                                                </div>
                                            </form>
                                            <div id="loader" class="text-center mt-5 hidden">
                                                <ctb-loader></ctb-loader>
                                            </div>
                                            <div class="" id='articaleList'>
                                                @include('book.articaleList', [ 'other_articles' => App\Book\Hotsheet::getArticleByForcode($fourcode) ])
                                            </div>
                                        
                                            </div>
                                            @include('book.recentHotsheets' , [ 'favorite_article' => App\Book\Hotsheet::getFavoriteArticle() ])
                                        </div>
                                        <?php //include(Util::$view_root.'district_20hs.php') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php

        function populate_cached($fourcode) {
            global $cached, $json_cache, $json_ie;
        $json = '';
        if(mb_substr($fourcode, 0, 1) == ".") {
            $json_cache = [];
            $json_ie = [];
        }
            $conn = Util::get_ctb_conn();
            $conn->set_charset("utf8");
            $sql = "SELECT * FROM ctb_redist_cached_1220 WHERE fourcode = '$fourcode' LIMIT 150";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                $type = $row['type'];
                    $cached[$type] = $row['html'];
                }
            }
    
            $sql = "SELECT json FROM ctb_cached_json WHERE fourcode = '$fourcode'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $json = $row['json'];
                }
            }
            $json_cache = json_decode($json, TRUE);
            $this_fourcode = $fourcode;
            if(mb_substr($fourcode, 0, 2) == "CD") {
                $this_fourcode = "CA" . mb_substr($fourcode, 2, 2);
            }
            $sql = "SELECT year, json FROM ctb_cached_json_ie WHERE year > 2021";
            $result = $conn->query($sql);
            if($result->num_rows >0) {
                while($row = $result->fetch_assoc()) {
                    $year = $row['year'];
                    $arr = json_decode($row['json'], TRUE);
                    $json_ie[$year] = $arr;
                }
            }
        

        }

        function get_cal_incumbent_bio($fourcode) {
            global $site_conn;
            $conn = $site_conn;
            $incumbent_id = get_cal_incumbent($fourcode);
            $bio = get_cal_bio($incumbent_id);

            return $bio;
        }

        function get_cal_bio($cand_id) {
            global $site_conn;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT text FROM ctb_cand_bios WHERE cand_id = '$cand_id' ORDER BY date DESC, id DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['text'];
                }
            }

            return $retval;
        }

        function get_cal_incumbent($fourcode) {
            global $ctb2016_conn;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT CAND_ID FROM ctb2016_e24_incumbent WHERE DIST = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $retval = $row['CAND_ID'];
                }
            }

            return $retval;
        }


        function get_fec_analysis($year) {
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

        function is_targeted() {
            global $fourcode;
            global $fec_conn;
            $conn = Util::get_ctb_conn();
            $sql = "SELECT targeted_by FROM nufec_e20_targets WHERE fourcode = '$fourcode'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $x = $row['targeted_by'];
                }
            }
            if ($x == "DCCC") {
                $retval = "<span class='boldme blueme'>2020 DCCC Target</span>";
            }

            if ($x == "NRCC") {
                $retval = "<span class='boldme redme'>2020 NRCC Target</span>";
            }

            return $retval;
        }




        function getstats() {
            global $incumbent;
            global $hrc;
            global $djt;
            global $bho;
            global $wmr;
            global $party;
            global $fourcode;
            global $ctb2016_conn;
            $conn = Util::get_ctb_conn();

            $sql = "SELECT * FROM ctb2016_e22_fed WHERE DIST = '$fourcode'";
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

        function get_long_string($fourcode) {
            $state = mb_substr($fourcode, 0, 2);
            $dist = mb_substr($fourcode, 2, 2);

            $long_state = convert_state($state);
            $long_dist = convert_district($dist);

            return $long_state . "<br>" . $long_dist . " Congressional District";
        }

        function convert_district($dist) {
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

        function convert_state($name, $to = 'abbrev') {
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



        function retrieve_image($fourcode) {
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

        function get_dist_location($fourcode) {
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

        function get_dist_profile($fourcode) {
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

        function retrieve_bio($id) {
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

        function getanalysis($fourcode, $year) {
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


        function populate_elections() {
            $elections = Array(
                "p12"   => "June 5, 2012 Presidential Primary",
                "g12"   => "November 6, 2012 General Election",
                "p14"   => "June 3, 2014 Primary Election",
                "g14"   => "November 4, 2014 General Election",
                "p16"   => "June 7, 2016 Presidential Primary",
                "g16"   => "November 8, 2016 General Election",
                "p18"   => "June 5, 2018 Primary Election",
                "g18"   => "November 6, 2018 General Election",
                "p20"   => "March 3, 2020 Presidential Primary",
                "g20"   => "November 3, 2020 General Election"
                );

            foreach($elections as $e => $verbose) {
                $enddraw .= "<option value='&election=$e'>$verbose</option>";
            }
            echo $enddraw;

        }

        function populate_datasets() {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT dataset FROM census_codes GROUP BY dataset ORDER BY dataset";
            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $dataset = $row['dataset'];
                    $verbose = $dataset;
                    if(mb_substr($dataset, 0, 3) == "INC") {
                        if($income_set) {
                            continue;
                        }
                        $dataset = "INCOME AND BENEFITS";
                        $verbose = "INCOME AND BENEFITS";
                        $income_set = TRUE;
                    } elseif($dataset == "Total housing units" || $dataset == "Race alone or in combination with one or more other races") {
                        continue;
                    } elseif(mb_substr($dataset, 0, 8) == "CITIZEN,") {
                        continue;
                    } elseif(mb_substr($dataset, 0, 8) == "CITIZEN ") {
                        $dataset = "CITIZEN";
                        $verbose = "CITIZEN VOTING AGE POPULATION";
                    }
                    $enddraw .= "<option value='&dataset=$dataset'>$verbose</option>";

                }
            }
            echo($enddraw);

        }

        function get_cvap($type, $dists) {
            $tmp_11=[
                    "White" => "white",
                    "Asian" => "asian",
                    "Latino" => "hisp",
                    "Black" => "black",
                    "Indigenous" => "ind",
            ];
            $tmp=$tmp_11;
            $tmp_19=$tmp;
            $conn = Util::get_ctb_conn();
            $is_vra = get_vra();
            $jur_name = "VIZ8_" . $type;
            $old_fourcodes = get_fourcode_index();
            $sql = "SELECT district, name FROM ctb_ca_city_shp WHERE jur_name = '$jur_name'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $map_nm = $row['district'];
                    //$short_map = mb_substr($row['name'], 0, 12);
                    $fourcode = $type . checkaddzero($row['district']);
                    $map_nm_index[$map_nm] = $fourcode;
                    $fourcode_map_index[$fourcode] = $map_nm;
                }
            }

            $sql = "SELECT * FROM ctb_redist_cvap_2011 WHERE fourcode LIKE '$type%'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $fourcode = $row['fourcode'];
                    $cvap_11[$fourcode] = $row;
                }
            }

            switch($type) {
                case "CD":
                    $c19_q = "Congressional District";
                    break;
                case "AD":
                    $c19_q = "Assembly District";
                    break;
                case "SD":
                    $c19_q = "State Senate District";
                    break;
        default:
            return '';
            }

            $sql = "SELECT fourcode, district, name, population, cvap_19, hisp, ind, black, asian, white, target, deviation FROM ctb_redist_cvap_1220";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $fourcode = $row['fourcode'];
                    $cvap_data[$fourcode] = $row;
                }
            }
            $c19_fields = Array(
                "1" => "total",
                "4" => "asian",
                "5" => "black",
                "7" => "white",
                "8" => "ind",
                "13"    => "hisp"
            );

            $sql = "SELECT geoname, lnnumber, cvap_est
                FROM ctb_redist_cvap_2019
                WHERE geoname LIKE '$c19_q%' && (lnnumber = 1 || lnnumber = 4 || lnnumber = 5 || lnnumber = 7 || lnnumber = 8 || lnnumber = 13)";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $regex = '~' . $c19_q . '\s([0-9].*?)\s~mis';
                    preg_match($regex, $row['geoname'], $r);
                    $dist = $r[1];
                    $fourcode = $type . checkaddzero($dist);
                    $key = $c19_fields[$row['lnnumber']];
                    $cvap_19[$fourcode][$key] = (int)$row['cvap_est'];
                }
            }

            $eth_keys = Array(
                    "White" => "white",
                    "Asian" => "asian",
                    "Latino" => "hisp",
                    "Black" => "black",
                );

            foreach($dists as $fourcode) {
                $old_fourcode = $old_fourcodes['new'][$fourcode];
                $x = $cvap_data[$fourcode]??[];
                $y = $cvap_11[$old_fourcode]??[];
                $z = $cvap_19[$old_fourcode]??[];

                //$map_nm = $d['name'];
                $cvap = $x['cvap_19'];

                if (is_array($y)) {
                    $tmp_11['Asian'] = number_format(($y['asian'] ?? 0) * 100, 1);
                    $tmp_11['Latino'] = number_format(($y['hisp'] ?? 0) * 100, 1);
                    $tmp_11['Black'] = number_format(($y['black'] ?? 0) * 100, 1);
                    $tmp_11['White'] = number_format(($y['white'] ?? 0) * 100, 1);
                }

                if (is_array($z)) {
                    $total = $z['total'] ?? 1;
                    $tmp_19['White'] = number_format((($z['white'] ?? 0) / $total) * 100, 1);
                    $tmp_19['Asian'] = number_format((($z['asian'] ?? 0) / $total) * 100, 1);
                    $tmp_19['Black'] = number_format((($z['black'] ?? 0) / $total) * 100, 1);
                    $tmp_19['Latino'] = number_format((($z['hisp'] ?? 0) / $total) * 100, 1);
                }

                if (is_array($x)) {
                    $tmp['White'] = number_format((($x['white'] ?? 0) / $cvap) * 100, 1);
                    $tmp['Asian'] = number_format((($x['asian'] ?? 0) / $cvap) * 100, 1);
                    $tmp['Latino'] = number_format((($x['hisp'] ?? 0) / $cvap) * 100, 1);
                    $tmp['Black'] = number_format((($x['black'] ?? 0) / $cvap) * 100, 1);
                    $tmp['Indigenous'] = number_format((($x['ind'] ?? 0) / $cvap) * 100, 1);
                }
                arsort($tmp);

                $i = 0;
                $first_grp = '';
                $eth_body = '';
                $dscr = '';
                if(isset($is_vra[$fourcode])) {
                    $dscr = "<span class='boldme'>VRA District</span><br>";
                }

                foreach($tmp as $group => $pct) {
                    if($i < 1) {
                        $first_grp = $group;
                        if($group != "White") {
                            //GOT MINORITY DISTRICT
                            if($pct >= 50) {
                                //MAJORITY-MINORITY DISTRICT
                                $dscr .= "Majority $group";
                            } else {
                                $dscr .= "Plurality $group";
                            }
                        }
                    } else {
                        if($group == "Black" && $pct >= 20) {
                            $dscr .= "<br>Substantial Black Population";
                        }
                    }
                    $this_key = $eth_keys[$group] ?? '';
                    $this_raw = $x[$this_key] ?? '';
                    $this_11 = $tmp_11[$group] ?? 'N/A';
                    $this_19 = $tmp_19[$group] ?? 'N/A';

                    $eth_body .= "<tr>
                                        <td class='boldme'>$group</td>
                                        <td align='right' class='boldme'>" . number_format((int)$this_raw) . "</td>
                                        <td align='right' class='boldme'>" . $pct . "%</td>
                                        <td align='right' class='itcme'>" . $this_11 . "%</td>
                                        <td align='right' class='itcme'>" . $this_19 . "%</td>
                                </tr>";


                    $i++;
                }

                $cvap_table[$fourcode] = "
                        <h3>Ethnic CVAP</h3>
                        <div class='table-responsive'>
                            <div class='table-striped'>
                                <table class='pastreg2 table-striped w-auto'>
                                    <thead>
                                    <tr>
                                        <th>DISTRICT</th>
                                        <th>MAP NAME</th>
                                        <th>POPULATION</th>
                                        <th>TARGET SIZE</th>
                                        <th>DEVIATION</th>
                                        <th>%</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>$fourcode</td>
                                            <td>" . $x['name'] . "</td>
                                            <td align='right'>" . number_format($x['population']) . "</td>
                                            <td align='right'>" . number_format($x['target']) . "</td>
                                            <td align='right'>" . number_format($x['deviation']) . "</td>
                                            <td align='right'>" . number_format((($x['deviation'] / $x['target']) * 100), 2) . "</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <h3>Summary</h3>
                        <p>ETHNIC DATA
                        CVAP Population: " . number_format($cvap) . " (" . number_format((($cvap / $x['population']) * 100), 1) . "%)<br>$dscr<br>
                        <div class='table-responsive'>
                            <div class='table-striped'>
                                <table class='pastreg2 table-striped w-auto'>
                                    <thead>
                                        <tr>
                                            <th>GROUP</th>
                                            <th class='rightme'>CVAP NEW</th>
                                            <th class='rightme'>% NEW</th>
                                            <th class='rightme'>$old_fourcode '11</th>
                                            <th class='rightme'>$old_fourcode '19</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        $eth_body
                                    </tbody>
                                </table>
                            </div>
                        </div> ";

            }
            return $cvap_table[$fourcode];
        }



        function get_reg($rpt_date) {

            $conn = Util::get_ctb_conn();
            $sql = "SELECT DIST, TOT, DEM, REP, NPP, LIB, GRN, PAF, AIP FROM ctb2016_sos_all WHERE RPT_DATE = '$rpt_date'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $adv = '';
                $fourcode = $row['DIST'];
                $adv = get_advantage_raw($row['DEM'], $row['REP'], $row['TOT']);
                $retval[$fourcode] = $row;
                $retval[$fourcode]['ADV'] = $adv;
            }
            }
            return $retval;

        }

        function get_pres($type) {

            $conn = Util::get_ctb_conn();
            switch($type) {
                case "AD":
                    $long_type = "addist";
                    break;
                case "SD":
                    $long_type = "sddist";
                    break;
                case "CD":
                    $long_type = "cddist";
                    break;
            default:
            return FALSE;
            }


            $sql = "SELECT $long_type, SUM(PRSDEM01) AS PRSDEM01, SUM(PRSREP01) AS PRSREP01, SUM(PRSGRN01) AS PRSGRN01, SUM(PRSAIP01) AS PRSAIP01, SUM(PRSLIB01) AS PRSLIB01, SUM(PRSPAF01) AS PRSPAF01
                FROM ctb2016_g20_v
                GROUP BY $long_type";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $fourcode = $type . checkaddzero($row[$long_type]);
                $adv = '';
                $tot = $row['PRSDEM01'] + $row['PRSREP01'] + $row['PRSGRN01'] + $row['PRSAIP01'] + $row['PRSLIB01'] + $row['PRSPAF01'];
                $dem = $row['PRSDEM01'];
                $rep = $row['PRSREP01'];
                $adv = get_advantage_pres($dem, $rep, $tot);
                $retval[$fourcode] = $row;
                $retval[$fourcode]['ADV'] = $adv;
                $retval[$fourcode]['TOT'] = $tot;
            }
            }
            return $retval;

        }

        function get_incumbent($id)
        {
            $conn = Util::get_ctb_conn();
            $term_limit='';
            $name='';
            $party='';

            $first_two = mb_substr($id, 0, 2);

            $cal_headers = Array("CD", "SD", "AD", "BO", ".A", ".G", ".C", ".S", ".T", ".I");
            $use_cal = in_array($first_two, $cal_headers);


            if ($use_cal) {
                $sql = "SELECT * FROM ctb2016_e24_incumbent WHERE DIST = '$id'";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $name = $row['LEGISLATOR'];
                        $party = $row['PARTY'];
                        // $term_limit = $row['TERM_LIMIT'];
                    }
                }

            } else {
                $sql = "SELECT * FROM ctb2016_e24_fed WHERE DIST = '$id'";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $name = $row['NAMF'] . " " . $row['NAML'];
                        $party = $row['PARTY'];
                    }
                }
            }

            return $name.' ('.$party.')';
        }

        function get_district_info($fourcode) {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT text from ctb_redist_dist_dscr_20 WHERE fourcode = '$fourcode'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row['text'];
                }
            }
            return "No data found";
        }

        function get_fourcode_index() {
            $conn = Util::get_ctb_conn();
            $sql = "SELECT fourcode, old_fourcode FROM ctb_redist_VIZ_1220_sum2";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $fourcode = $row['fourcode'];
                    $old_fourcode = $row['old_fourcode'];

                    $index['old'][$old_fourcode] = $fourcode;
                    $index['new'][$fourcode] = $old_fourcode;
                }
            }
            return $index;
        }

        function get_vra() {
            $is_vra = Array(
                "AD27"  => TRUE,
                "AD29"  => TRUE,
                "AD31"  => TRUE,
                "AD33"  => TRUE,
                "AD35"  => TRUE,
                "AD36"  => TRUE,
                "AD39"  => TRUE,
                "AD45"  => TRUE,
                "AD48"  => TRUE,
                "AD49"  => TRUE,
                "AD50"  => TRUE,
                "AD53"  => TRUE,
                "AD56"  => TRUE,
                "AD58"  => TRUE,
                "AD60"  => TRUE,
                "AD62"  => TRUE,
                "AD64"  => TRUE,
                "AD68"  => TRUE,
                "AD80"  => TRUE,
                "SD14"  => TRUE,
                "SD16"  => TRUE,
                "SD18"  => TRUE,
                "SD22"  => TRUE,
                "SD29"  => TRUE,
                "SD30"  => TRUE,
                "SD31"  => TRUE,
                "SD33"  => TRUE,
                "SD34"  => TRUE,
                "CD13"  => TRUE,
                "CD18"  => TRUE,
                "CD21"  => TRUE,
                "CD22"  => TRUE,
                "CD25"  => TRUE,
                "CD31"  => TRUE,
                "CD33"  => TRUE,
                "CD35"  => TRUE,
                "CD38"  => TRUE,
                "CD39"  => TRUE,
                "CD42"  => TRUE,
                "CD44"  => TRUE,
                "CD46"  => TRUE,
                "CD52"  => TRUE


                );

            return $is_vra;

        }

        function get_advantage_raw ($dem, $rep, $tot) {
     

        $d = 0;
        $r = 0;
        $retval = '';
        if($dem > 0) {
                $d = number_format((($dem / $tot) * 100), 2);
        }
        if($rep > 0) {
                $r = number_format((($rep / $tot) * 100), 2);
        }

            if($d > $r) {
                //DEM ADVANTAGE
                $adv = number_format(($d - $r), 2);
                $retval = "<span class='blueme boldme'>D +" . $adv . "%</span>";
            } elseif ($r > $d) {
                //REP ADVANTAGE
                $adv = number_format(($r - $d), 2);
                $retval = "<span class='redme boldme'>R +" . $adv . "%</span>";
            } elseif($d == $r && $d > 0) {
                //AT PARITY
                $retval = 'EVEN';
            }
            return $retval;
        }

        function get_advantage_pres ($dem, $rep, $tot) {

            $d = number_format((($dem / $tot) * 100), 2);
            $r = number_format((($rep / $tot) * 100), 2);

            if($d > $r) {
                //DEM ADVANTAGE
                $adv = number_format(($d - $r), 2);
                $retval = "<span class='blueme boldme'>BIDEN +" . $adv . "%</span>";
            } elseif ($r > $d) {
                //REP ADVANTAGE
                $adv = number_format(($r - $d), 2);
                $retval = "<span class='redme boldme'>TRUMP +" . $adv . "%</span>";
            } elseif($d == $r && $d > 0) {
                //AT PARITY
                $retval = 'EVEN';
            }
            return $retval;
        }

        function get_advantage_raw_labeled ($dem, $d_nm, $rep, $r_nm, $tot) {

            $d = number_format((($dem / $tot) * 100), 2);
            $r = number_format((($rep / $tot) * 100), 2);

            $retval['d_pct'] = $d;
            $retval['r_pct'] = $r;
            $retval['d_raw'] = $dem;
            $retval['r_raw'] = $rep;
            $retval['t_raw'] = $tot;

            if($d_nm == "Yes") {
                $d_color_class = 'greenme';
            } elseif($d_nm == "No") {
                $d_color_class = 'redme';
            } else {
                $d_color_class = 'blueme';
            }

            if($r_nm == "Yes") {
                $r_color_class = 'greenme';
            } elseif($d_nm == "No") {
                $r_color_class = 'redme';
            } else {
                $r_color_class = 'redme';
            }


            if($d > $r) {
                //DEM ADVANTAGE
                $adv = number_format(($d - $r), 2);
                $retval['adv'] = "<span class='$d_color_class boldme'>$d_nm +" . $adv . "%</span>";
            } elseif ($r > $d) {
                //REP ADVANTAGE
                $adv = number_format(($r - $d), 2);
                $retval['adv'] = "<span class='$r_color_class boldme'>$r_nm +" . $adv . "%</span>";
            } elseif($d == $r && $d > 0) {
                //AT PARITY
                $retval['adv'] = 'EVEN';
            }
            return $retval;
        }


        function get_redist_zips($fourcode) {
            $conn = Util::get_ctb_conn();
            $fourcode = mb_substr($fourcode, 0, 5);
            $partial_zip = '';
            $complete_zip = '';
            $sql = "SELECT fourcode, zip, pct FROM ctb_redist_zips_20 WHERE fourcode = '$fourcode' ORDER BY zip";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                $pct = number_format($row['pct']);
                if($pct == "100") {
                    $complete_zip .= $row['zip'] . ", ";
                } else {
                    $partial_zip .= $row['zip'] . " (" . number_format($pct) . "%), ";
                }
                }
                $complete_zip = substr($complete_zip, 0, -2);
                $partial_zip = substr($partial_zip, 0, -2);
            }
            $retval = "<div class='row'>
                    <h3 align='center'>ZIP Codes Within District</h3>
                    <div class='col-lg-6'>
                        <h4 align='center'>COMPLETE</h4>
                        <p style='text-align: justify;'>
                            $complete_zip
                        </p>
                    </div>
                    <div class='col-lg-6'>
                        <h4 align='center'>PARTIAL</h4>
                        <p style='text-align: justify;'>
                            $partial_zip
                        </p>
                    </div>
                    </div>";
            return $retval;
        }

function generate_past_results($fourcode) {
    global $master_conn;
    $conn = Util::get_ctb_conn();
    $conn->set_charset("utf8");
    $sql = "SELECT json FROM ctb_cached_json WHERE fourcode = '$fourcode'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $json = $row['json'];
        }
    }
    $arr = json_decode($json, TRUE);
    $e_arr = $arr['past_results'];

    $enddraw = "
        
        <ul id=\"past_results_tabs\" class=\"nav nav-pills nav-justified\" role=\"tablist\" data-tabs=\"tabs\">";
    $active = TRUE;
    foreach($e_arr as $election => $races) {
        if($active == TRUE) {
            $enddraw .= "<li class=\"active\"><a href=\"#past_res_$election\" data-toggle=\"tab\" role=\"tab\">$election</a></li>";
            $active = FALSE;
        } else {
            $enddraw .= "<li><a href=\"#past_res_$election\" data-toggle=\"tab\" role=\"tab\">$election</a></li>";
        }
    }
    $enddraw .= "</ul>";

    echo($enddraw);
    echo("<div class=\"tab-content\">");
    $active = TRUE;


    foreach($e_arr as $election => $races) {
        if($active) {
            echo("<div role=\"tabpanel\" class=\"tab-pane fade in active\" id=\"past_res_$election\"><p>$election Results</p>");
            $active = FALSE;
            draw_past_results_panels($races['races']);
            echo("</div>");
        } else {
            echo("<div role=\"tabpanel\" class=\"tab-pane fade\" id=\"past_res_$election\"><p>$election Results</p>");
            draw_past_results_panels($races['races']);
            echo("</div>");
        }
    }
    echo("
        </div>");

}

function draw_past_results_panels($races) {

    //var_dump($races);
    //echo("<br>");
    $stw = Array(".PRS", ".USS", ".USP", ".GOV", ".LTG", ".ATG", ".SOS", ".TRS", ".CON", ".INS", ".SPI");
    $stw_races = [];
    $stw_fed_races = [];

    foreach($stw as $fourcode)  {
        if($fourcode == ".PRS" || $fourcode == ".USS" || $fourcode == ".USP") {
            $stw_fed = TRUE;
        } else {
            $stw_fed = FALSE;
        }
        if(!empty($races[$fourcode])) {
            if($stw_fed) {
                $stw_fed_races[$fourcode] = $races[$fourcode];
                unset($races[$fourcode]);
            } else {
                $stw_races[$fourcode] = $races[$fourcode];
                unset($races[$fourcode]);
            }
        }
    }

    $boe = [];
    $props = [];
    $sen = [];
    $asm = [];
    $cng =[];


    foreach($races as $fourcode => $arr) {
        if(mb_substr($fourcode, 0, 4) == "PROP" || mb_substr($fourcode, 0, 3) == "PR_") {
            $props[$fourcode] = $arr;
        } elseif(mb_substr($fourcode, 0, 2) == "CD") {
            $cng[$fourcode] = $arr;
        } elseif(mb_substr($fourcode, 0, 2) == "SD") {
            $sen[$fourcode] = $arr;
        } elseif(mb_substr($fourcode, 0, 2) == "AD") {
            $asm[$fourcode] = $arr;
        } elseif(mb_substr($fourcode, 0, 3) == "BOE") {
            $boe[$fourcode] = $arr;
        }
    }

    $order = Array(
        "FEDERAL - STATEWIDE" => $stw_fed_races,
        "CONSTITUTIONAL" => $stw_races,
        "CONGRESSIONAL" => $cng,
        "STATE SENATE" => $sen,
        "ASSEMBLY" => $asm,
        "BOARD OF EQUALIZATION" => $boe,
        "PROPOSITIONS" => $props,
        );
    //var_dump($order);

    $enddraw = '';
    foreach($order as $key => $races) {
        if(empty($races)) {
            continue;
        }
        $enddraw .= "<div class='spacer'></div>
                     <h2>$key</h2>";
        foreach($races as $race_id => $x) {
            $contest_name = $x['contest_name'];
            
            //$contest_name = $race_id;
            
            uasort($x['results'], "past_votes_sort");

            //RUN THROUGH FIRST TIME AND GET DIV CLASS FROM WINNER, BREAK AFTER CHECKING FIRST ENTRY
            foreach($x['results'] as $key => $v) {
                if($v['cand_nm'] == "YES") {
                    $class = 'grndiv';
                } elseif($v['cand_nm'] == "NO") {
                    $class = 'repdiv';
                } elseif($v['party'] == "DEM") {
                    $class = 'demdiv';
                } elseif($v['party'] == "REP") {
                    $class = 'repdiv';
                } else {
                    $class = '';
                }
                break;
            }

            //NOW LET'S DRAW THE THING

            $enddraw .= "<div class='col-xl-3 col-lg-6 col-md-6 col-sm-12 col-xs-12'>
                        <div class='card w-auto wide-card'>
                            <p class='small'>$contest_name</p>
                            <p class='$class'></p>
                            <p align='center'>
                            <table class='table table-responsive table-striped w-auto table-fit' align='center'>";

            foreach($x['results'] as $key => $v) {
                if(!empty($v['party'])) {
                    $party_field = "<td>" . $v['party'] . "</td>";
                } else {
                    $party_field = '';
                }
                $enddraw .= "<tr>
                                <td align='left'>" . $v['cand_nm'] . "</td>
                                $party_field
                                <td align='right'>" . number_format($v['votes']) . "</td>
                                <td align='right'>" . $v['pct'] . "</td>
                            </tr>";
            }
            $enddraw .= "</table></p></div></div>";

        }
    }
    echo($enddraw); 
}

function draw_district_registration($fourcode) {
    global $json_cache, $endjava, $visdiv1, $visdiv2, $chart_functions, $thisid, $chart1_data, $chart2_data, $chart3_data, $ror_info;
    $conn = Util::get_ctb_conn();
    $thisid = '';
    //RETRIEVE MOST RECENT REPORT DATE
    $sql = "SELECT rpt_date, rpt_type, rpt_election FROM ctb_ror_reports ORDER BY rpt_date DESC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $last_ror = $row;
        }
    }
    $now_date = $last_ror['rpt_date'];
    $now_year = mb_substr($now_date, 0, 4);
    $sql = "SELECT * FROM ctb2016_sos_all WHERE DIST = '$fourcode' && RPT_DATE = '$now_date'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            foreach($row as $k => $v) {
                $reg[$now_year][$k] = $v;
            }
        }
    }
    foreach($json_cache['past_registration'] as $key => $r) {
        $year = str_replace("g", "20", $key);
        foreach($r as $kk => $vv) {
            $this_key = strtoupper($kk);
            $reg[$year][$this_key] = $vv;
        }
    }
    ksort($reg);

    $past_reg_div = "<table class='w-auto' align='center'>
                    <thead>
                        <tr>
                            <th>YEAR</th>
                            <th>TOTAL</th>
                            <th>DEM</th>
                            <th>%</th>
                            <th>REP</th>
                            <th>%</th>
                            <th>NPP</th>
                            <th>%</th>
                            <th class='embiggen'>ADV</th>
                        </tr>
                    </thead>
                    <tbody>";

    $chart1_data = '';
    $chart2_data = '';
    $chart3_data = '';                  

    foreach($reg as $year => $x) {


        $d_pct = number_format((($x['DEM'] / $x['TOT']) * 100), 2);
        $r_pct = number_format((($x['REP'] / $x['TOT']) * 100), 2);
        $n_pct = number_format((($x['NPP'] / $x['TOT']) * 100), 2);

        $d_abs = $x['DEM'];
        $r_abs = $x['REP'];
        $n_abs = $x['NPP'];

        $totreg = $x['TOT'];

        $adv = get_advantage_raw_labeled($d_abs, "D", $r_abs, "R", $totreg);

        $past_reg_div .= "<tr class='boldme'>
                            <td>$year</td>
                            <td align='right'>" . number_format($totreg) . "</td>
                            <td align='right' class='blueme'>" . number_format($d_abs) . "</td>
                            <td align='right' class='blueme'>" . number_format($d_pct, 1) . "%</td>
                            <td align='right' class='redme'>" . number_format($r_abs) . "</td>
                            <td align='right' class='redme'>" . number_format($r_pct, 1) . "%</td>
                            <td align='right' class='grayme'>" . number_format($n_abs) . "</td>
                            <td align='right' class='grayme'>" . number_format($n_pct, 1) . "%</td>
                            <td>" . trim($adv['adv'])  . "</td>
                        </tr>";

        if($year == 2024) {
            $o_pct = 100 - ($d_pct + $r_pct + $n_pct);

            $chart3_data = "
                ['PARTY', 'Percent'],           
                ['DEM', $d_pct],
                ['REP', $r_pct],
                ['NPP', $n_pct],
                ['OTH', $o_pct]
            ";
        }
        

        $chart1_data .= "
        ['$year', $d_pct, $r_pct, $n_pct],";

        $chart2_data .= "
            ['$year', $d_abs, $r_abs, $n_abs, $totreg],";
        
    }

    $past_reg_div .= "</tbody></table>";



    $chart1_data = substr($chart1_data, 0, -1);
    $chart2_data = substr($chart2_data, 0, -1);

    $thisid = str_replace(" ", "_", $fourcode);
    $thisid = str_replace(".", "", $thisid);    


    $js = "function drawPieChart() {
        var data = google.visualization.arrayToDataTable([
          $chart3_data
        ]);

        var options = {
          title: 'Current Registration',
          pieHole: 0.5,
          chartArea: {
            width: '95%',
            height: '90%'
            }
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    ";  
    array_push($endjava, $js);

    $js = generate_javascript();
    array_push($endjava, $js);









    $js = "
          google.load('visualization', '1.0', {'packages':['corechart'], 'callback': drawCharts});


          function drawCharts() {
            drawPieChart();
            $chart_functions
          }";

    array_push($endjava, $js);



    $reg_div = "<div class='clearfix'></div>
                <div class='headingDiv'>
                       <h5>District Registration (As of {$ror_info['long_date']})</h5>
                </div>

                <div class='mt-3 mb-3 d-grid summary_Registration'>
                    
                        <div id='donutchart' class='py-3 bg-white ctb-border-radius'></div>
                        $visdiv1
                        $visdiv2
                        
                </div>

                <div class='headingDiv'>
                       <h5>Registration History</h5>
                </div>              

                <div class='col-lg-12 bg-white mt-3'>
                    <div class='table table-striped table-hover table-responsive w-auto table-fit'>
                        $past_reg_div
                    </div>
                </div>
                <div class='clearfix'></div>";
        echo($reg_div);





}


        function locate_candidates($fourcode) {
            $conn = Util::get_ctb_conn();
            $fourcode = mb_substr($fourcode, 0, 5);
            $sql = "SELECT ST_AsText(SHAPE) AS SHAPE
                FROM supe_dists_ca_legislative
                WHERE year = '2020' && fourcode = '$fourcode'";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $z = $row['SHAPE'];
                }
            }
            $sql = "SELECT cand_id FROM ctb_e22_cand_geo WHERE ST_Intersects( SHAPE, ST_GeomFromText ( '$z', 1) )";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $cand_id = $row['cand_id'];
                    $cand_arr[$cand_id] = $cand_id;
                }
            }


            $q = '';
            foreach($cand_arr as $cand_id => $ignore) {
                $q .= " cand_id = '$cand_id' ||";
            }
            $q = substr($q, 0, -2);

            $sql = "SELECT *, fourcode as FOURCODE FROM ctb_cand_filed_v2 WHERE ( $q ) && cycle = 2022 && hide != 1";


            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $cand_id = $row['cand_id'];
                    if($row['is_inc']) {
                        $arr[1][$cand_id] = $row;
                    } else {
                        $arr[0][$cand_id] = $row;
                    }
                }
            }

            $inc_table = "<table class='table-striped'>
                    <tbody>";
                    if (array_key_exists(1,$arr)) {
                        foreach($arr[1] as $id => $x) {
                            $inc_table .= "<tr>
                                        <td>" . $x['FOURCODE'] . "</td>
                                        <td>" . $x['namf'] . " " . $x['naml'] . "</td>
                                        <td>" . $x['party'] . "</td>
                                    </tr>";
                        }
                    }
            $inc_table .= "</tbody></table>";

            $non_inc_table = "<table class='table-striped'>
                    <tbody>";
            if (array_key_exists(0,$arr)) {
                foreach($arr[0] as $id => $x) {
                    $non_inc_table .= "<tr>
                                <td>" . $x['FOURCODE'] . "</td>
                                <td>" . $x['namf'] . " " . $x['naml'] . "</td>
                                <td>" . $x['party'] . "</td>
                            </tr>";
                }
            }
            $non_inc_table .= "</tbody></table>";
            $retval['inc'] = $inc_table;
            $retval['non_inc'] = $non_inc_table;
            return $retval;

        }

function generate_javascript() {
    global $chart1_data, $chart2_data, $thisid, $county, $chart_functions, $visdiv1, $visdiv2, $fourcode, $long_fourcode;


    $retval = "
        function drawChart1_$thisid() {
            var data = google.visualization.arrayToDataTable([
                ['Date', 'Dem', 'GOP', 'NPP'],
                $chart1_data
                ]);

            var options = {
                title: '$long_fourcode Registration by Party (by %): 2008 - NOW',
                titleTextStlye: {
                    color: '333333',
                    fontName: 'PT Sans Narrow',
                    fontSize: 20
                },
                hAxis: {
                    slantedText:true, 
                    slantedTextAngle:90,
                    textStyle: {
                        fontSize: 9
                    }
                },                      
                legend: 'none',
                chartArea: {
                    width: '90%',
                    height: '80%'
                }
            } 
 
            var chart = new google.visualization.LineChart(document.getElementById('chart1_$thisid'));
            chart.draw(data, options);
        }

        function drawChart2_$thisid() {
            var data = google.visualization.arrayToDataTable([
                ['Year', 'Dem', 'Rep', 'NPP', 'Total'],
                $chart2_data
                ]);

            var options = {
                title: '$long_fourcode Registration by Party (Raw): 2008 - NOW',
                titleTextStlye: {
                    color: '333333',
                    fontName: 'PT Sans Narrow',
                    fontSize: 20
                },
                vAxis: {
                    textStyle: {
                        fontSize: 11
                    }
                },
                hAxis: {
                    slantedText:true, 
                    slantedTextAngle:90,
                    textStyle: {
                        fontSize: 9
                    }
                },                  
                legend: 'none',
                chartArea: {
                    width: '75%',
                    height: '80%'
                }
            } 

            var chart = new google.visualization.LineChart(document.getElementById('chart2_$thisid'));
            chart.draw(data, options);
        }       

    ";

    $chart_functions .= "
        drawChart1_$thisid();
        drawChart2_$thisid();";

/*
    $visdiv1 = "<div class='box500' style='width: 500px; height: 400px; text-align: center, margin-left: auto; margin-right: auto; float: left;'>
                    <div id='chart1_$thisid' style='margin-top: 20px; width: 500px; height: 400px;'></div>
                </div>";

    $visdiv2 = "<div class='box500' style='width: 500px; height: 400px; text-align: center, margin-left: auto; margin-right: auto; float: left;'>
                    <div id='chart2_$thisid' style='margin-top: 20px; width: 500px; height: 400px;'></div>
                </div>";    
*/

    $visdiv1 = "
                    <div id='chart1_$thisid' class='py-3 bg-white ctb-border-radius chart'></div>
                ";

    $visdiv2 = "
                    <div id='chart2_$thisid' class='py-3 bg-white ctb-border-radius chart'></div>
                ";  


    return $retval;                                 
    
}


function past_votes_sort($a, $b) {
  $retval = $b['votes'] <=> $a['votes'];
  return $retval;
}



function new_votes_sort($a, $b) {
  $retval = $b['VOTES'] <=> $a['VOTES'];
  return $retval;
}

function tot_sort($a, $b) {
  $retval = $b['tot'] <=> $a['tot'];
  return $retval;
}

function get_county_registration_div($fourcode) {
    global $ror_info;
    if(mb_substr($fourcode, 0, 1) == ".") {
    return '';
    }
    //GET CURRENT COUNTY BREAKDOWN
    $conn = Util::get_ctb_conn();

    $first_two = mb_substr($fourcode, 0, 2);

    switch($first_two) {
        case "AD":  
            $verbose = "State Assembly District " . (int)mb_substr($fourcode, 2, 2);
            break;
        case "SD":
            $verbose = "Senate District " . (int)mb_substr($fourcode, 2, 2);
            break;
        case "CD":
            $verbose = "Congressional District " . (int)mb_substr($fourcode, 2, 2);
            break;
        case "BO": 
            $verbose = "Board of Equalization District " . mb_substr($fourcode, 3, 1);
            break;
        default:
            $verbose = '';
    }
    $sql = "SELECT * FROM ctb_reg_subdivision 
        WHERE SUBDIVISION = '$verbose'
        ORDER BY NOW_TOT DESC";

    $ik = Array(
        "id" => TRUE,
        "COUNTY" => TRUE,
        "SUBDIVISION" => TRUE
    );


    $query = '';
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $county = $row['COUNTY'];
            $query .= " COUNTY = '$county' ||";
            foreach($row as $key => $v) {
                if(isset($ik[$key])) {
                    continue;
                }           
                $ck[$county][$key] = $v;
                if(empty($ck_tot[$key])) {
                    $ck_tot[$key] = $v;
                } else {
                    $ck_tot[$key] += $v;
                }
            }       
        }
    }
    $query = substr($query, 0, -2);
    $sql = "SELECT * FROM ctb_reg_subdivision 
        WHERE SUBDIVISION = 'County Totals' && ( $query )";

    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $county = $row['COUNTY'];
            $county_totals[$county] = $row;
        }
    }

    $county_reg_table = "<table>
                <thead>
                   <tr>
                        <th>COUNTY</th>
                        <th>% OF COUNTY</th>
                    <th>ADV</th>
                    <th>DEM</th>
                    <th>%</th>
                    <th>REP</th>
                    <th>%</th>
                    <th>NPP</th>
                    <th>%</th>
                    <th>TOT</th>
                    <th>% OF DIST</th>
                   </tr>
                </thead>
                <tbody>";

    foreach($ck as $county => $x) {
        // Check if the denominator is zero before calculating $c1_pct
        if ($county_totals[$county]['NOW_TOT'] != 0) {
            $c1_pct = number_format((($x['NOW_TOT'] / $county_totals[$county]['NOW_TOT']) * 100), 2);
        } else {
            $c1_pct = '0.00';  // Handle division by zero case
        }

        // Check if the denominator is zero before calculating $c2_pct
        if ($ck_tot['NOW_TOT'] != 0) {
            $c2_pct = number_format((($x['NOW_TOT'] / $ck_tot['NOW_TOT']) * 100), 2);
        } else {
            $c2_pct = '0.00';  // Handle division by zero case
        }

        $adv = get_advantage_raw($x['NOW_DEM'], $x['NOW_REP'], $x['NOW_TOT']);

        // Build the table row
        $county_reg_table .= "<tr>
                    <td>$county</td>
                    <td align='right'>$c1_pct%</td>
                    <td>$adv</td>
                    <td align='right'>" . number_format($x['NOW_DEM']) . "</td>";

        // Check if the denominator is zero before calculating the percentage of NOW_DEM
        if ($x['NOW_TOT'] != 0) {
            $county_reg_table .= "<td align='right'>" . number_format((($x['NOW_DEM'] / $x['NOW_TOT']) * 100), 2) . "%</td>";
        } else {
            $county_reg_table .= "<td align='right'>0.00%</td>";
        }

        $county_reg_table .= "<td align='right'>" . number_format($x['NOW_REP']) . "</td>";

        // Check if the denominator is zero before calculating the percentage of NOW_REP
        if ($x['NOW_TOT'] != 0) {
            $county_reg_table .= "<td align='right'>" . number_format((($x['NOW_REP'] / $x['NOW_TOT']) * 100), 2) . "%</td>";
        } else {
            $county_reg_table .= "<td align='right'>0.00%</td>";
        }

        $county_reg_table .= "<td align='right'>" . number_format($x['NOW_NPP']) . "</td>";

        // Check if the denominator is zero before calculating the percentage of NOW_NPP
        if ($x['NOW_TOT'] != 0) {
            $county_reg_table .= "<td align='right'>" . number_format((($x['NOW_NPP'] / $x['NOW_TOT']) * 100), 2) . "%</td>";
        } else {
            $county_reg_table .= "<td align='right'>0.00%</td>";
        }

        $county_reg_table .= "<td align='right'>" . number_format($x['NOW_TOT']) . "</td>
                    <td align='right'>$c2_pct%</td>
                 </tr>";
    }
    $county_reg_table .= "</thead>
                  <tfoot>
                    <tr>
                        <td>TOTAL</td>
                        <td></td>
                        <td>" . get_advantage_raw($ck_tot['NOW_DEM'], $ck_tot['NOW_REP'], $ck_tot['NOW_TOT']) . "</td>
                        <td align='right'>" . number_format($ck_tot['NOW_DEM']) . "</td>";

    if ($ck_tot['NOW_TOT'] != 0) {
        $county_reg_table .= "<td align='right'>" . number_format((($ck_tot['NOW_DEM'] / $ck_tot['NOW_TOT']) * 100), 2) . "%</td>";
    } else {
        $county_reg_table .= "<td align='right'>0.00%</td>";
    }

    $county_reg_table .= "<td align='right'>" . number_format($ck_tot['NOW_REP']) . "</td>";

    if ($ck_tot['NOW_TOT'] != 0) {
        $county_reg_table .= "<td align='right'>" . number_format((($ck_tot['NOW_REP'] / $ck_tot['NOW_TOT']) * 100), 2) . "%</td>";
    } else {
        $county_reg_table .= "<td align='right'>0.00%</td>";
    }

    $county_reg_table .= "<td align='right'>" . number_format($ck_tot['NOW_NPP']) . "</td>";

    if ($ck_tot['NOW_TOT'] != 0) {
        $county_reg_table .= "<td align='right'>" . number_format((($ck_tot['NOW_NPP'] / $ck_tot['NOW_TOT']) * 100), 2) . "%</td>";
    } else {
        $county_reg_table .= "<td align='right'>0.00%</td>";
    }

    $county_reg_table .= "<td align='right'>" . number_format($ck_tot['NOW_TOT']) . "</td>
                        <td align='right'>100%</td>
                    </tr>
                </tfoot>
                 </table>";




    $county_reg_div ="  <div class='clearfix'></div>
                <div class='ctb-county-registration bg-white pt-3 ctb-border-radius'>
                        <div class='ctb-country-content px-4'>
                            <h2>District Registration by County</h2>
                            <h4 align='left'>(As of " . $ror_info['long_date'] . ")</h4>

                            <div class='panel'>             
                                <div class='table-responsive table-striped'>                    
                                    $county_reg_table
                                </div>
                            </div>
                        </div>
                    </div>";
    echo($county_reg_div);


}

function get_last_ror() {
    $conn = Util::get_ctb_conn();
    $abbrev['month'] = Array(
        "01" => "January",
        "02" => "February",
        "03" => "March",
        "04" => "April",
        "05" => "May",
        "06" => "June",
        "07" => "July",
        "08" => "August",
        "09" => "September",
        "10" => "October",
        "11" => "November",
        "12" => "December"
    );

    $abbrev['day'] = Array(
        "01" => "1",
        "02" => "2",
        "03" => "3",
        "04" => "4",
        "05" => "5",
        "06" => "6",
        "07" => "7",
        "08" => "8",
        "09" => "9",
        "10" => "10",
        "11" => "11",
        "12" => "12",
        "13" => "13",
        "14" => "14",
        "15" => "15",
        "16" => "16",
        "17" => "17",
        "18" => "18",
        "19" => "19",
        "20" => "20",
        "21" => "21",
        "22" => "22",
        "23" => "23",
        "24" => "24",
        "25" => "25",
        "26" => "26",
        "27" => "27",
        "28" => "28",
        "29" => "29",
        "30" => "30",
        "31" => "31",

        );


    $sql = "SELECT rpt_date, rpt_election, rpt_type 
            FROM ctb_ror_reports 
            ORDER BY rpt_date DESC LIMIT 1";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $retval = $row;
            $month = mb_substr($row['rpt_date'], 5, 2);
            $day = mb_substr($row['rpt_date'], 8, 2);
            $long_date = $abbrev['month'][$month] . " " . $abbrev['day'][$day] . ", " . mb_substr($row['rpt_date'], 0, 4);
            $retval['long_date'] = $long_date;
        }
    }
    $ror_info = $retval;
    //var_dump($retval);
    return $retval;
}

function retrieve_sov_tables($fourcode, $cycle) {

    $this_cycle = $cycle;
    $pri = "p" . mb_substr($this_cycle, 2, 2);
    $gen = "g" . mb_substr($this_cycle, 2, 2);

    $vote_results['p'] = populate_sov($pri);
    $vote_results['g'] = populate_sov($gen);
    $dscr_arr = populate_sov_dscr($pri, $gen);


    $p_table = draw_sov_table($vote_results['p'], "p", $dscr_arr);
    $g_table = draw_sov_table($vote_results['g'], "g", $dscr_arr);


    if(strlen($p_table) > 10) {
        $p_table_draw = "<div class='table-striped table-responsive table-fit'><p align='left'>PRIMARY</p>$p_table</div>";
    } else {
        $p_table_draw = '';
    }

    if(strlen($g_table) > 10) {
        $g_table_draw = "<div class='table-striped table-responsive table-fit'><p align='left'>GENERAL</p>$g_table</div>";
    } else {
        $g_table_draw = '';
    }

    $retval['p'] = $p_table_draw;
    $retval['g'] = $g_table_draw;

    //var_dump($retval);
    return $retval;
    

}

function populate_sov_dscr($pri, $gen) {
    //global $master_conn, $pri, $gen, $dscr_arr;
    //$conn = $master_conn;
    $conn = Util::get_ctb_conn();
    $p_table = "ctb_" . $pri . "_candidates";
    $g_table = "ctb_" . $gen . "_candidates";

    $sql = "SELECT cand_dscr, cand_id FROM $p_table";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cand_id = $row['cand_id'];
            $dscr = $row['cand_dscr'];
            $dscr_arr['p'][$cand_id] = $dscr;
        }
    }

    if($gen != "g24") {

        $sql = "SELECT cand_dscr, cand_id FROM $g_table";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cand_id = $row['cand_id'];
            $dscr = $row['cand_dscr'];
            $dscr_arr['g'][$cand_id] = $dscr;
        }
        }
    }
    return $dscr_arr;

}

function populate_sov($election) {
    global $master_conn, $gen, $fourcode, $county_index;
    if($election == "g24") {
        return FALSE;
    }
    //$conn = $master_conn;
    $conn = Util::get_ctb_conn();
    $this_type = mb_substr($election, 0, 1);
    $sov_fourcode = str_replace(".", "", $fourcode);
    $table = "ctb_" . $election . "_by_county";
    $retval = [];
    $sql = "SELECT COUNTY_ID, COUNTY_NM, FOURCODE, CAND_ID, CAND_NM, PARTY, IS_INC, WRITE_IN_FLAG, VOTES 
            FROM $table
            WHERE FOURCODE = '$sov_fourcode'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $county_id = $row['COUNTY_ID'];
            $county_nm = $row['COUNTY_NM'];
            $county_index[$county_id] = $county_nm;
            $cand_id = $row['CAND_ID'];
            $retval[$county_id][$cand_id] = $row;
        }
    }
    return $retval;
}


function draw_sov_table($v, $type, $dscr_arr) {


    global $county_index;
    if(is_bool($v)) {
        return '';
    }
    if($type == "p") {
        //$img_height = '75';
        $img_class = 'p_img';
    } else {
        //$img_height = '150'
        $img_class = 'g_img';
    }

    if(sizeof($v) > 14) {
        foreach($v as $key => $ignore) {
            if($key != 59) {
                unset($v[$key]);
            }
        }
    }

    if(empty($v[59])) {
        return '';
    }

    uasort($v[59], "new_votes_sort");
    $i = 1;
    foreach($v[59] as $x) {
        $cand_id = $x['CAND_ID'];
        $rank[$i] = $cand_id;
        $cand_id_rank[$cand_id] = $i;
        $cand_nm = $x['CAND_NM'];
        $party = $x['PARTY'];
        $is_inc = $x['IS_INC'];
        $write_in = $x['WRITE_IN_FLAG'];

        $cand_index[$cand_id]['cand_nm'] = $cand_nm;
        $cand_index[$cand_id]['party'] = $party;
        $cand_index[$cand_id]['is_inc'] = $is_inc;
        $cand_index[$cand_id]['write_in'] = $write_in;

        $i++;
    }
    foreach($v as $county_id => $cands) {
        foreach($cands as $x) {
            $cand_id = $x['CAND_ID'];
            $this_rank = $cand_id_rank[$cand_id];
            $votes = $x['VOTES'];
            $grid[$this_rank][$county_id] = $x;
            if(empty($county_totals[$county_id])) {
                $county_totals[$county_id] = $votes;
            } else {
                $county_totals[$county_id] += $votes;
            }
        }
    }
    if($county_totals[59] < 1) {
        return FALSE;
    }
    ksort($county_totals);


    $table = "<table class='table-responsive'>
                <thead>
                    <tr>
                        <th></th>
                        <th class='border-right'>CAND</th>";

    foreach($county_totals as $county_id => $ignore) {
        $county_nm = $county_index[$county_id];
        if($county_id != 59) {
            $table .= "<th colspan='2' class='centerme border-right'>$county_nm</th>";
        } else {
            $table .= "<th colspan='2' class='centerme'>TOTAL</th>";
        }
    }
    $table .= "</tr>
                </thead>
                <tbody class='table-group-divider ctb-divider-brown'>";

    ksort($grid);
    $prev_votes = '';
    foreach($grid as $this_rank => $counties) {
        ksort($counties);
        
        $cand_id = $rank[$this_rank];
        $cand_nm = $cand_index[$cand_id]['cand_nm'];
        $party   = $cand_index[$cand_id]['party'];
        $is_inc  = $cand_index[$cand_id]['is_inc'];
        $write_in = $cand_index[$cand_id]['write_in'];
        $add_class = '';

        $add_party = '';
        if($write_in == "Y") {
            $add_class = 'itcme';
        }
        if($is_inc == "Y") {
            $display_cand = $cand_nm . " (" . $party . "-Inc)";
        } else {
            $display_cand = $cand_nm . " (" . $party . ")";
        }

        $img_url = get_cand_image_url($cand_id);
        $img = "<img align='center' class='img-thumbnail $img_class' src='$img_url' />";

        if(!empty($dscr_arr[$type][$cand_id])) {
            $this_dscr = $dscr_arr[$type][$cand_id];
        } else {
            $this_dscr = '';
        }
        $this_class = '';
        $diff_span = '';

        $table .= "<tr>
                        <td class='centerme'>$img</td>
                        <td class='border-right'>$display_cand<br><span class='small itcme'>$this_dscr</span></td>";
        foreach($counties as $county_id => $x) {
            $this_tot = $county_totals[$county_id];
            $this_votes = $x['VOTES'];
            if($county_id == 59) {
                $this_class = 'boldme';
                $diff_span = '';
                if(!$prev_votes) {
                    $prev_votes = $this_votes;          
                } else {
                    $this_diff = $this_votes - $prev_votes;
                    $diff_span = "<br><span class='small itcme'>" . number_format($this_diff) . "</span>";
                    $prev_votes = $this_votes;
                }
            }
            if($this_votes > 0) {
                $this_pct = number_format((($this_votes / $this_tot) * 100), 2);
            } else {
                $this_pct = "0";
            }
            $table .= "<td align='right'><span class='$this_class'>" . number_format($this_votes) . "</span>" . $diff_span . "</td>
                       <td align='right' class='border-right $this_class'>$this_pct%</td>";
            $diff_span = '';
        }
        $table .= "</tr>";
    }
    $table .= "</tbody></table>";
    return $table;
    
}


function get_cand_image_url($cand_id) {
    $arr = Array(".jpg", ".jpeg", ".png", ".bmp", ".gif");
    foreach($arr as $x) {
        if(file_exists("img/candidates/" . $cand_id . $x)) {
            $retval = "<img align='center' class='cand_img img-thumbnail' src='img/candidates/" . $cand_id . $x . "'  />";
            $url = '/img/candidates/' . $cand_id . $x;
            return $url;
        } 
    }
    $url = '/img/candidates/NO_IMAGE.jpg';
    return $url;
    
}

function draw_topline($races) {
    global $json_cache;
    if(empty($json_cache['past_results'])) {
    return '';
    }
    $res = $json_cache['past_results'];
    $html = '';

    foreach($races as $race) {
        $election = mb_substr($race, 0, 3);
        $race = "." . mb_substr($race, 4, 3);
        $arr = $res[$election]['races'][$race];
        $html .= draw_big_result_panel($arr, $election, $race);
    }
    echo($html);
}

function draw_big_result_panel($arr, $election, $race) {
    $x = $arr['results'];
    uasort($x, 'past_votes_sort');
    $long_race = Array(".PRS" => "PRESIDENT",
                       ".GOV" => "GOVERNOR",
                       ".USS" => "US SENATE",
                       ".LTG" => "LT. GOVERNOR",
                       ".INS" => "INSURANCE COMMISSIONER",
                       ".CON" => "CONTROLLER",
                       ".TRS" => "TREASURER",
                       ".SOS" => "SECRETARY OF STATE",
                       ".SPI" => "SUPERINTENDENT OF PUBLIC INSTRUCTION",
                       ".ATG" => "ATTORNEY GENERAL");

    $abbrev_year = str_replace("g", "'", $election);
    $i = 0;
    foreach($x as $r) {

        if($i < 1) {
            $win_id = $r['cand_id'];
            if($r['party'] == "DEM") {
                $class = 'demdiv';
                $class2 = 'blueme boldme';
            } elseif($r['party'] == "REP") {
                $class = 'repdiv';
                $class2 = 'redme boldme';
            } else {
                $class = '';
                $class2 = '';
            }
            $pct_01 = str_replace("%", "", $r['pct']);
            $votes_01 = $r['votes'];
        } elseif ($i == 1) {
            $pct_02 = str_replace("%", "", $r['pct']);
            $votes_02 = $r['votes'];
        }
        $i++;
        
    }
    $win_pct = number_format(($pct_01 - $pct_02), 2);
    $win_raw = number_format($votes_01 - $votes_02);

    $html = "<div class='panel col-lg-4'>
                <div class='row'>
                    <div class='col-lg-12'>
                        <h3 align='center'>" . $long_race[$race] . " $abbrev_year</h3>
                        <p align='center' class='$class'></p>
                        <div class='row'>
                            <div class='col-lg-3' align='center'>
                                <img src='/img/candidates/" . $win_id . ".jpg' height='100px' class='thumbnail' />
                                <div align='center' style='display: inline-block;' width='100%'>
                                    <h3 align='center'><span class='$class2'>+$win_pct%</span></h3>
                                    <h5>+ $win_raw votes</h5>
                                </div>
                            </div>
                            <div class='col-lg-9'>
                                <div class='table-striped'>
                                    <table class='wintable'>
                                        <tbody>";
    $i = 0;
    foreach($x as $r) {
        if($i > 1) {
            break;
        }
        $html .= "<tr>
                    <td>" . $r['cand_nm'] . "</td>
                    <td>" . $r['party'] . "</td>
                    <td align='right'>" . number_format($r['votes']) . "</td>
                    <td align='right'>" . $r['pct'] . "</td>
                  </tr>";
        $i++;                 
    }
    $html .= "</tbody>
            </table>
            </div>
           </div>
          </div>
         </div>
        </div>
       </div>";
    return $html;      

    /*

".SPI":{"results":{"SPINOP01":{"cand_nm":"Lance Ray Christensen","cand_id":"1446111","party":"NOP","votes":80307,"pct":"47.69%"},"SPINOP02":{"cand_nm":"Tony K. Thurmond","cand_id":"1295704","party":"NOP","votes":88089,"pct":"52.31%"}},"contest_name":".SPI","total_votes":168396},

    */
}

    function retrieve_incumbent_info($fourcode)
    {
        $conn = Util::get_ctb_conn();
        $id='';
        $retval=[];

        global $cand_id;
        $sql = "SELECT * FROM ctb2016_e24_incumbent WHERE DIST = '$fourcode'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['CAND_ID'];
                $cand_id = $id;
                $retval['PARTY'] = $row['PARTY'];
                $retval['INCUMBENT'] = $row['LEGISLATOR'];
                $retval['DOB'] = $row['DOB'];
                $retval['TERM_LIMIT'] = $row['TERM_LIMIT'];
                $retval['CAND_ID'] = $row['CAND_ID'];
            }
        }

        $types = Array(".png", ".jpg", ".jpeg", ".gif", ".bmp");
        $retval['IMG'] = '';
        foreach ($types as $type) {
            $tmp_file = "img/candidates/" . $id . $type;
            if (file_exists($tmp_file)) {
                $retval['IMG'] = '/img/candidates/' . $id . $type;
                break;
            }
        }


        $sql = "SELECT text from ctb_cand_bios WHERE cand_id = '$id' ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval['BIO'] = $row['text'];
            }
        }
        return $retval;
    }

    function retrieve_incumbent_social_media($cand_id)
    {
        $conn = Util::get_ctb_conn();
        $retval=[];
        $sql = "SELECT * from ctb_cand_links WHERE cand_id = '$cand_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $retval = $row;
            }
        }

        return $retval;
    }


    function draw_overlap($type, $fourcode, $json_cache) {
        if(!empty($json_cache['redist']['composition'][$type])) {
            $arr = $json_cache['redist']['composition'][$type];
        } else {
            return FALSE;
        }

        $long_types = Array(
            "CO" => "Counties",
            "SD" => "Old Senate Districts",
            "SD_NEW" => "Senate Districts",
            "AD" => "Old Assembly Districts",
            "AD_NEW" => "Assembly Districts",
            "CD" => "Old Congressional Districts",
            "CD_NEW" => "Congressional Districts"
            );

        $long_type = $long_types[$type];

        uasort($arr, "tot_sort");
        $retval = "<div class='col-md-12 px-0'>
                    <div class='ctb-overlaps-content px-4'>
                        <h3>$long_type</h3>
                            <div class='table-responsive'>
                                <div class='table-striped'>
                                    <table class='pastreg2 table-striped'>
                                        <thead>
                                            <tr>
                                                <th>%</th>
                                                <th>PLACE</th>
                                                <th>REG</th>
                                                <th>ADV</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
        foreach($arr as $place => $x) {
            if(mb_substr($x['adv'], 0, 1) == "D") {
                $class = 'blueme boldme';
            } elseif (mb_substr($x['adv'], 0, 1) == "R") {
                $class ='redme boldme';
            } else {
                $class = '';
            }
            //'pct', 'tot', 'adv'
            $retval .= "<tr>
                            <td align='right'>" . $x['pct'] . "</td>
                            <td>$place</td>
                            <td align='right'>" . number_format($x['tot']) . "</td>
                            <td align='right' class='$class'>" . $x['adv'] . "</td>
                        </tr>";
        }
        $retval .= "                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>";

        echo($retval);


    }   


    ?>

@endsection

@section('scripts')
    
    @include('book.hsFilterJs')

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> 

<script>
    // Wait for the document to be fully loaded
    document.addEventListener("DOMContentLoaded", function() {
        // Trigger click event on the first tab link
        document.querySelector('.nav-pills .nav-link:first-child').click();
    });
</script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var tabSets = document.querySelectorAll('.nav-pills');
        
            // Loop through each set of tabs
            tabSets.forEach(function(tabSet) {
                // Trigger click event on the first tab link within each set
                tabSet.querySelector('.nav-link:first-child').click();
            });         
            var tabs = document.querySelectorAll('.dynamic-tab');

            tabs.forEach(function(tab) {
                tab.addEventListener('click', function() {
                    var tabName = tab.getAttribute('data-tab');
                    var additionalData = {
                        old_fourcode: @json($old_fourcode),
                        fourcode: @json($fourcode),
                        role: @json($role),
                    };
                    $('#'+tabName+'Loader').removeClass('hidden');
                        fetch('/load-content/' + tabName, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            },
                            body: JSON.stringify(additionalData),
                        })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById('pills-' + tabName).innerHTML=''
                            document.getElementById('pills-' + tabName).innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

        });
        $("#dateField").change(function() {
            if (!isValidDate(this.value)) {
                alert('Invalid date. Please enter a valid date in the format MM-DD-YYYY.');
                this.value=''
            }
        });

        function isValidDate(dateString) {
            var regex = /^\d{4}-\d{2}-\d{2}$/;
            return regex.test(dateString);
        }
    </script>

	<script type="text/javascript">
  		$(document).ready(function () {
		    $(".arrow-right").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "+=336"
		        }, 750);
		    });
		    $(".arrow-left").bind("click", function (event) {
		        event.preventDefault();
		        $(".vid-list-container").stop().animate({
		            scrollLeft: "-=336"
		        }, 750);
		    });
		});
  	</script>


<script type="text/javascript"> 

<?php
foreach ($endjava as $value) {
    echo($value);
}
?>

</script> 

@endsection

@section('styles')

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <style>
        .panel{
            padding: 0px !important;
        }
    </style>

    <style>
        .panel {
            padding: 0px !important;
        }

        .summary_grid {
            grid-template-columns: repeat(4, 1fr);
            display: grid;gap: 16px;
        }

        .summary_grid a.panel .bg_whiteee {
            background: #ffffff !important;
        }

        .summary_grid>div {
            background-color: white;
            border-radius: 6px;
            overflow: hidden;
        }

        .summary_grid>div img.img-fluid {
            width: 100%;
        }
        .grid.summary_grid a {
            font-style: unset;
            text-decoration: none;
            margin-bottom: 0 !important;
        }

        .summary_Incumbent .ctb-incumbentBox {
            display: unset !important;
        }

        .summary_Incumbent .ctb-incumbentBox:before, .row_before_none:before {
            display: none;
        }

        .summary_Incumbent .ctb-incumbentBox .ctb-incumbent-banner-img img {
            min-height: 160px;
            object-fit: cover;
        }

        .summary_Incumbent .ctb-incumbentBox .ctb-incumbent-profile-img + div {
            display: none;
        }

        .summary_Incumbent .ctb-incumbentBox .ctb-incumbentBox-avatar {
            display: block !important;
            position: relative;
        }
        .summary_Registration, .three_coll {
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .district_Registration_boxes {
            gap: 16px;
            grid-template-columns: repeat(4, 1fr);
        }
        .pills-campaigns_tabs li.nav-item {
            background: white;
            border-radius: 6px;
        }

        .pills-campaigns_tabs  ul#pills-tab {
            gap: 16px;
            justify-content: flex-start;
            border: 0;
        }

        .pills-campaigns_tabs ul#pills-tab:before {
            display: none;
        }

        .pills-campaigns_tabs li.nav-item.active a {
            background: linear-gradient(132deg, #324B83 0%, #728ACE 100%);
            color: white;
        }

        .pills-campaigns_tabs li.nav-item a {
            font-size: 14px;
            font-family: 'Nunito';
            color: #11101E;
            font-weight: 500;
        }
        button.btn.btn-primary.bg_bluee {
            background: #498EE9;
            font-family: 'Lato';
            font-size: 12px;
        }

    #past_results_tabs li {
        float: left;
        width: 100px;
        margin: 10px;
    }

    .spacer {
        width: 100vw;
        height: 5px;
        float: none;
        clear: both;
    }
    .chart {
        width: 100%;
        min-height: 400px;
    }

    .wide-card {
        min-width: 400px;
    }

    .wide-card table {
        margin-left: auto;
        margin-right: auto;
    }

    .big-reg span {
        font-size: 1.2em;
    }

    .g_img {
        width: 50px;
    }

    .p_img {
        width: 50px;
    }

    .full-width {
        width: 100%;
    }

    .embiggen {
        min-width: 75px;
    }

    .modal-1200 {
	min-width: 90vw !important;
    }
   .modal {
	min-height: 90vh !important;
    }


        .title {
            width: 100%;
            max-width: 854px;
            margin: 0 auto;
            font-size: 1em;
        }

        .caption {
            width: 100%;
            max-width: 854px;
            margin: 0 auto;
            padding: 5px 0;
            font-size: 0.8em;
            line-height: 0.9em;

        }

        .container {
            width: 100%;
            max-width: 854px;
            min-width: 440px;
            background: #fff;
            margin: 0 auto;
        }


        /*  VIDEO PLAYER CONTAINER
        ############################### */
        .vid-container {
            position: relative;
            padding-bottom: 52%;
            padding-top: 30px;
            height: 0;
        }

        .vid-container iframe,
        .vid-container object,
        .vid-container embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }


        /*  VIDEOS PLAYLIST
        ############################### */
        .vid-list-container {
            width: 92%;
            overflow: hidden;
            margin-top: 20px;
            margin-left:4%;
            padding-bottom: 20px;
        }

        .vid-list {
            width: 1344px;
            position: relative;
            top:0;
            left: 0;
        }

        .vid-item {
            display: block;
            width: 148px;
            height: 148px;
            float: left;
            margin: 0;
            padding: 10px;
        }

        .thumb {
            /*position: relative;*/
            overflow:hidden;
            height: 84px;
        }

        .thumb img {
            width: 100%;
            position: relative;
            top: -13px;
        }

        .vid-item .desc {
            color: #21A1D2;
            font-size: 15px;
            margin-top:5px;
        }

        .vid-item:hover {
            background: #eee;
            cursor: pointer;
        }

        .arrows {
            position:relative;
            width: 100%;
        }

        .arrow-left {
            color: #fff;
            position: absolute;
            background: #777;
            padding: 15px;
            left: -25px;
            top: -130px;
            z-index: 99;
            cursor: pointer;
        }

        .arrow-right {
            color: #fff;
            position: absolute;
            background: #777;
            padding: 15px;
            right: -25px;
            top: -130px;
            z-index:100;
            cursor: pointer;
        }

        .arrow-left:hover {
            background: #CC181E;
        }

        .arrow-right:hover {
            background: #CC181E;
        }


        @media (max-width: 624px) {
            body {
                margin: 15px;
            }
            .caption {
                margin-top: 40px;
            }
            .vid-list-container {
                padding-bottom: 20px;
            }

            /* reposition left/right arrows */
            .arrows {
                position:relative;
                margin: 0 auto;
                width:96px;
            }
            .arrow-left {
                left: 0;
                top: -17px;
            }

            .arrow-right {
                right: 0;
                top: -17px;
            }
        }

        .greenme {
            color: green;
        }

        .redme {
            color: red;
        }

        .close-btn {
	   background-color: red !important;
	   color: white;
	   font-weight: bold;
	   font-size: 3.5em;
	   position: absolute;
	   right: 0;
	   top: 0;
	   opacity: 100%;
	}

        .iframe-container {
            position: relative;
            width: 100%;
        }

        .iframe-container > * {
            display: block;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .greyColumn {
            background: #eee;
        }


    </style>


@endsection

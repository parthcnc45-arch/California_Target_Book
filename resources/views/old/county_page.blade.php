<?php
Util::set_errors();



use App\User;
$role = Auth::user()->role;


if (empty($fourcode)) {
    $fourcode = $_GET['id'] ?? '';
}
if (empty($sub)) {
    $sub = $_GET['sub'] ?? '';
}
//echo("<br>SUB: $sub, FOURCODE: $fourcode");
global $sub_store, $county_store;
$sub_store = $sub;
$county_store = $id;
?>

@php ($book_side_nav_active = 'district')

@extends('layouts.book')

@section('title', "$id County")

@section('content')

    <?php
    Util::require_ctb_api();
    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();
    global $county, $sub, $winner_span, $ror_info;
    //$sub = $_GET['sub'];
    if ($county_store) {
        $county = $county_store;
    }
    if ($sub_store) {
        $sub = $sub_store;
    }
    if (!$county) {        
        $county2 = lookup_city_county($sub);
    } 

    $county_short = str_replace("County", "", $county);

    if(strtoupper($county_short) == "SAN FRANCISCO") {
        $districts = 8;
    } else {
        $districts = 5;
    }

    $ror_info = get_last_ror();
    $incumbents = get_incumbents($county_short);

    //var_dump($incumbents);

    $cities_span = get_cities($county_short);
    $overlaps = get_overlaps($county_short);


    $dist_nav = '';
    $dist_html = '';
    $i = 1;
    while($i <= $districts) {
        $dist_nav .= "<li>
                        <a href='#D$i' role='tab' data-toggle='tab'>
                            <i class='material-icons'>place</i>
                            District $i
                        </a>
                      </li>
                      ";

        //BEGIN GENERATING DISTRICT HTML

        $supe_dist_verbose = "Supervisorial District $i";

        $dist_html .= "<section id='D$i'> <!--BEGIN SUPE DISTRICT $i SECTION -->
                        <div> <!--EXTRA DIV 1 START -->
                            <div class=''> <!--EXTRA DIV 2 START -->
                                <div class='col-md-12'> <!--FULL SPAN COLUMN START -->";


        $inc_info = $incumbents['districts'][$i];

        $this_cand_nm = $inc_info['NAMF'] . " " . $inc_info['NAML'];
        $this_term = $inc_info['TERM_LIMIT'];
        $this_cand_id = $inc_info['OTHER_ID'];
        $this_bio = $incumbents['bios'][$this_cand_id] ?? '';
        $this_img = get_cand_img($this_cand_id);
        $this_lnk = "<br><a href='" . $inc_info['URL'] . "' target='_blank'>COUNTY WEBSITE</a>";

        if($this_term) {
            $term_span = "<br><h4>Term Limit: $this_term</h4>";
        } else {
            $term_span = '';
        }

        $add_img = '';
        $edit_btn = '';
        if($role == "admin") {
            $add_img = "<div>$add_img<div style='margin-top: -10px;'><a href='http://198.74.49.22/img_uploader.php?id=" . $this_cand_id . "' target='_blank'><img src='/img/edit_btn.png' height='15px' width='15px'></a></div></div>";   
            $edit_btn = "<span><a href='http://198.74.49.22/cand_editor.php?cand_id=$this_cand_id&juris=CA" . "' target='_blank'><img src='/img/edit_btn.png' height='30px' width='30px'></a></span>";          
        } 

        $dist_html .= "<div class='row panel'>
                        <div class='col-lg-5'>
                            <h2>$this_cand_nm<br>$supe_dist_verbose</h2>
                            $term_span
                        </div>
                        <div class='col-lg-2'>
                            $this_img
                            $add_img
                            $this_lnk
                        </div>
                        <div class='col-lg-5' style='text-align: justify;'>
                        $this_bio
                        <br>$edit_btn
                        </div>
                     </div>";



        $loc_table = get_supe_dist_results($county_short, $i);
        $dist_html .= "<div class='panel row vote-tables'>" . $loc_table . "</div>";    

        $dist_html .= "<div class='panel row vote-tables'>";
        $x = get_the_stats($county_short, $supe_dist_verbose);
        $stuff = generate_vote_tables($x, TRUE);
        $dist_html .= $stuff['table'] . "</div>";

        $dist_html .= "<div class='panel row'>" . $stuff['winners'] . "</div>";

        $y = get_past_reg($county_short, $supe_dist_verbose);
        $html = generate_registration($y);

        $dist_html .= "<div class='row'>
                         <div class='col-lg-6'>
                            <h3>Registration (as of " . $ror_info['long_date'] . ")</h3>";

        $dist_html .= $html['current_reg'];
        $dist_html .= "</div>";
        $dist_html .= "<div class='col-lg-6'>";
        $dist_html .= $html['past_reg'];
        $dist_html .= "</div>";
        $dist_html .= "</div>";

    



        $dist_html .= "</div> <!--FULL SPAN COLUMN END -->
                     </div> <!--EXTRA DIV 2 END -->
                    </div> <!--EXTRA DIV 1 END -->
                </section> <!--END SUPE DISTRICT $i SECTION -->";

        $i++;
    }



    ?>

<div> <!--BEGIN MAIN CONTENT DIV -->

    <div class="book-page-head row m-n">
        <div>
            <h2 class="m-n pull-left">
            <?php 
            echo("$county County"); 
            ?> 
            </h2>

        </div>
    </div>

    <div class="clear"></div>

    <div class="container-fluid pt-xl">

        
        <div class="row">
            <div class="col-lg-10 center-block fn">
                <nav class='clearfix page-nav'>
                    <ul class="clearfix">
                        <li class="active" >
                            <a href='#Overview' role="tab" data-toggle="tab">
                                <i class="material-icons">home</i>
                                Overview
                            </a>
                        </li>
                        <?php
                            echo($dist_nav);
                        ?>

                        <li>
                            <a href='#Maps' role="tab" data-toggle="tab">
                                <i class="material-icons">map</i>                                   
                                District Maps
                            </a>
                        </li>    


                        <li>
                            <a href='#ByGeo' role="tab" data-toggle="tab">
                                <i class="material-icons">poll</i>                                  
                                Election Results
                            </a>
                        </li>

                    
            
                        <li>
                            <a href='#Finance' role="tab" data-toggle="tab">
                                <i class="material-icons">filter_list</i>
                                Campaign Reports
                            </a>
                        </li>
                        <li>
                            <a href='#Census' role="tab" data-toggle="tab">
                                <i class="material-icons">place</i>
                                Census Detail
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="content-wrap pt-xl"> <!--BEGIN CONTENT WRAP DIV -->

                    <section id="Overview" class="active">
                        <div>
                            <div class="">
                                <div class='row'>
                                    <div class="col-md-12">
                                        <div class="panel row vote-tables">
                                        <?php
                                            $x = get_the_stats($county_short, "County Totals");
                                            $html = generate_vote_tables($x, FALSE);
                                            echo($html['table']);
                                        ?>
                                        </div>

                                        <div class="panel row">
                                        <?php
                                            echo($winner_span);
                                        ?>
                                        </div>

                                        <div class="panel row">
                                            <div class="col-lg-6">
                                                <h3>Map</h3> 
                                                <div class="iframe-container">
                                                    <iframe src=<?php echo("'/book/draw_leg?county=$county'") ?> height='610px' width='810px' style='margin-left: auto; margin-right: auto; overflow: hidden;'></iframe>

                                                    <?php echo($cities_span); ?>
                                                </div>
                                            </div> 
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h3>Registration (as of <?php echo($ror_info['long_date']); ?>)</h3> 
                                                        <?php
                                                            $y = get_past_reg($county_short, "County Totals");
                                                            $html = generate_registration($y);
                                                            echo($html['current_reg']);
                                                            echo($html['past_reg']);
                                                        ?>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>

                                        <div class='panel row'>
                                            <div class="col-lg-12 center-block fn">
                                                <?php
                                                        echo($overlaps['CITY']);
                                                ?>
                                            </div>

                                        </div>



                                        <div class="panel row">
                                                <div class="col-lg-12 center-block fn">
                                                        

                                                    <h3 align='center'>CENSUS DATA (2019 ACS 5-YEAR ESTIMATE)</h3>

                                                    <?php

                                                    $d = draw_demographics2($county_short);
                                                    echo("<div class='col-md-6'><h4>Population & Ethnic Statistics</h4><hr class='red' />" . $d['population'] . "</div>");
                                                    echo("<div class='col-md-6'><h4>Household Income</h4><hr class='blue' />" . $d['income'] . "</div>");

                                                    ?>

                                                </div>
                                                 <div class="clear"></div>    

                                                <div class='row'>

                                                    <?php
                                                    echo("<div class='col-md-4'><h4>Housing</h4><hr class='green' />" . $d['housing'] . "</div>");
                                                    echo("<div class='col-md-4'><h4>Education</h4><hr class='yellow' />" . $d['education'] . "</div>");
                                                    echo("<div class='col-md-4'><h4>Poverty Level</h4><hr class='midnight' />" . $d['poverty'] . "</div>");
                                                    ?>
                                                </div>

                                                
                                        </div>                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <?php
                        echo($dist_html);
                    ?>

                    <section id="Maps"> <!--BEGIN DISTRICT MAPS SECTION -->

                        <?php
                            $cd = get_council_districts();
                            if($cd) {
                                $elections_div = "<div align='center' width='100%'><p align='center'><br><br><h2>COUNCIL DISTRICTS</h2><br>
                                                    <p align='center' class='itcme'>2020 General Election results shown. For previous elections, visit the '<a href='/book/geo_nav' target='_blank'>Past Election Results by Geographic Area'</a> page</p>";

                                foreach($cd as $dist => $ignore) {
                                     $d_nm = "D" . $dist;
                                     $elections_div .=  "<label for='$d_nm'>District $dist</label>
                                                        <input type='radio' name='mv' id='$d_nm' value='$dist'/>";  
                                }
                                $elections_div .= "</div>";
                                $upper = strtoupper($sub);
                                echo($elections_div);


                                $local_js = "
                            <script type='text/javascript'>
                            $(\"input[name='mv']\").change(function(){
                                var x = $(\"input[name='mv']:checked\").val();
                                var url = '/ctb-legacy/geo_lookup?city=$upper&cd=' + x + '&election=g20';
                                document.getElementById('councilDiv').style.display = 'block';
                                document.getElementById('btmClose5').style.display = 'block';
                                document.getElementById('cityHidden3').src = url;                              

                            });


                            function closeCouncilDiv() {
                                document.getElementById('councilDiv').style.display = 'none';
                                document.getElementById('btmClose5').style.display = 'none';
                                document.getElementById('cityHidden3').src = '/img/spinner.gif';
                            }

                            </script>";

                            // echo($local_js);
                            array_push($endjava, $local_js);

                            ?>

                            <p align='center'>
                                <div id="councilDiv" style="display:none;" class="answer_list">
                                    <iframe src="/img/spinner.gif" id="cityHidden3" height="1000" width="1024"></iframe>
                                </div>
                                <p style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                                <input class="btn" style="display: none;" id="btmClose5" value="CLOSE" onclick="closeCouncilDiv()" type="button" />
                            </p>
                            </p>
                           

                    <?php

                    }  else {
                                echo("<h3 align='center'>Supervisorial District Maps In Progress</h3>");
                    }


                        ?>

                    </section> <!--END DISTRICT MAPS SECTION -->



                    <section id="ByGeo"> <!--BEGIN ELECTION RESULTS BY GEO SECTION -->

                    <?php

                    $is_city = TRUE;
                    $has_local = TRUE;
                    if ($is_city && $has_local) {
                        $elections_div = "<div align='center' width='100%'><p align='center'><br><br><h2>ELECTION RESULTS</h2><br>
                            <input type='radio' name='gv' id='p06' value='p06'/>
                            <label for='p06'>P06</label>
                            <input type='radio' name='gv' id='g06' value='g06'/>
                            <label for='g06'>G06</label>                        
                            <input type='radio' name='gv' id='p08' value='p08'/>
                            <label for='p08'>P08</label>
                            <input type='radio' name='gv' id='g08' value='g08'/>
                            <label for='g08'>G08</label>                        
                            <input type='radio' name='gv' id='p10' value='p10'/>
                            <label for='p10'>P10</label>
                            <input type='radio' name='gv' id='g10' value='g10'/>
                            <label for='g10'>G10</label>                        
                            <input type='radio' name='gv' id='p12' value='p12'/>
                            <label for='p12'>P12</label>
                            <input type='radio' name='gv' id='g12' value='g12'/>
                            <label for='g12'>G12</label>
                            <input type='radio' name='gv' id='p14' value='p14'/>
                            <label for='p14'>P14</label>
                            <input type='radio' name='gv' id='g14' value='g14'/>
                            <label for='g14'>G14</label>
                            <input type='radio' name='gv' id='p16' value='p16'/>
                            <label for='p16'>P16</label>
                            <input type='radio' name='gv' id='g16' value='g16'/>
                            <label for='g16'>G16</label>
                            <input type='radio' name='gv' id='p18' value='p18'/>
                            <label for='p18'>P18</label>
                            <input type='radio' name='gv' id='g18' value='g18'/>
                            <label for='g18'>G18</label>
                            <input type='radio' name='gv' id='p20' value='p20'/>
                            <label for='p20'>P20</label>
                            <input type='radio' name='gv' id='g20' value='g20'/>
                            <label for='g20'>G20</label>                                                                                                                
                            <input id='btmClose3' class='btn' value='CLOSE' onclick='closeGeoDiv()' type='button' style='display: none;'/>
                            </p>



                        ";

                        $elections_div = "<div align='center'><p align='center'>IN PROGRESS<br>To View Past Election Results by Supervisorial District, <a href='https://californiatargetbook.com/book/geo_nav' target='_blank'>Click Here</a></p>";
                        echo($elections_div);

                        $local_js = "
                    <script type='text/javascript'>
                    $(\"input[name='gv']\").change(function(){
                        var x = $(\"input[name='gv']:checked\").val();
                        switch(x) {
                            case 'p06':                               
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p06';
                                break;
                            case 'g06':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g06';
                                break;                            
                            case 'p08':                               
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p08';
                                break;
                            case 'g08':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g08';
                                break;                            
                            case 'p10':                               
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p10';
                                break;
                            case 'g10':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g10';
                                break;                            
                            case 'p12':                               
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p12';
                                break;
                            case 'g12':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g12';
                                break;
                            case 'p14':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p14';
                                break;
                            case 'g14':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g14';
                                break;
                            case 'p16':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p16';
                                break;
                            case 'g16':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g16';
                                break;
                            case 'p18':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p18';
                                break;
                            case 'g18':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g18';
                                break;
                            case 'p20':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=p20';
                                break;
                            case 'g20':
                                var url ='/ctb-legacy/geo_lookup?place=$sub&election=g20';
                                break;                                                             

                        }
                        document.getElementById('geoDiv').style.display = 'block';
                        document.getElementById('btmClose3').style.display = 'block';
                        document.getElementById('btmClose4').style.display = 'block';
                        document.getElementById('cityHidden2').src = url;
                        

                    });


                    function closeGeoDiv() {
                        document.getElementById('geoDiv').style.display = 'none';
                        document.getElementById('btmClose3').style.display = 'none';
                        document.getElementById('btmClose4').style.display = 'none';
                        document.getElementById('cityHidden2').src = '/img/spinner.gif';
                    }

                    </script>";

                        // echo($local_js);
                        array_push($endjava, $local_js);
                        ?>
                        <p align='center'>
                    <div id="geoDiv" style="display:none;" class="answer_list">
                        <iframe src="/img/spinner.gif" id="cityHidden2" height="1000" width="1024"></iframe>
                    </div>
                    <p style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                        <input class="btn" style="display: none;" id="btmClose4" value="CLOSE" onclick="closeGeoDiv()" type="button" />
                    </p>
                        </p>
                        </div>

                    <?php

                    }

                    ?>

                    </section> <!--END ELECTION RESULTS BY GEO SECTION -->

                    <section id="Finance"> <!--BEGIN FINANCE SECTION -->

                        <div class='row'>
                            <div class="col-md-12">
                               <div class="panel row">                    

                                <?php
                                    $l = check_locals($county_short);
                                    if($l) {
                                        echo($l);
                                    } else {
                                        echo("<h3 align='center'>No Reports Available For This Locality</h3>");
                                    }

                                ?>
                                </div>
                            </div>
                        </div>                            

                    </section> <!--END FINANCE SECTION -->

                    <section id="Census"> <!--BEGIN CENSUS SECTION -->

                    <?php
                        $geo = get_geo($county_short);
                    ?>

                        <div align='center'>

                            <select name="trend" id="trend" class="distval showonselect">
                            <option value=''>Select Dataset</option>


                                <?php 
                                    populate_datasets();
                                ?>

                            </select>
                        </div>   

                        <?php
                              $local_js = "
                            <script type='text/javascript'>

                                $(document).ready(function () {
                                    $('#trend').on('change', function () {
                                        var x = $(this).val();
                                        var url = '/ctb-legacy/census_stat_graph_v2?geo=" . $geo . "' + x;
                                        document.getElementById('trendDiv').style.display = 'block';
                                        document.getElementById('btmClose6').style.display = 'block';
                                        document.getElementById('cityHidden4').src = url;
                                    });
                                });

                            function closeTrendDiv() {
                                document.getElementById('trendDiv').style.display = 'none';
                                document.getElementById('btmClose6').style.display = 'none';
                                document.getElementById('cityHidden4').src = '/img/spinner.gif';
                            }

                            </script>";

                            // echo($local_js);
                            array_push($endjava, $local_js);



                        ?>

                      <p align='center'>
                        <div id="trendDiv" style="display:none;" class="answer_list">
                            <iframe src="/img/spinner.gif" id="cityHidden4" height="1000" width="100%" align='center'></iframe>
                        </div>
                        <p style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                            <input class="btn" style="display: none;" id="btmClose6" value="CLOSE" onclick="closeTrendDiv()" type="button" />
                        </p>
                     </p>
                     
                        



                    </section> <!--END CENSUS SECTION -->

                </div> <!--END CONTENT WRAP DIV -->
            </div> <!--END CENTER BLOCK -->
        </div> <!--END ROW -->
    </div> <!--END CONTAINER FLUID -->
</div>    <!--END MAIN CONTENT -->                            



<?php




if ($is_city) {
    ?>

<?php
//        echo("<div width='100%' align='center'><iframe style='margin-right: auto; margin-left: auto;' align='center' src='/book/get_city_demographics?id=$sub' height=\"1000\" width='1024px' frameborder='0' scrolling='no' onload='resizeIframe(this)'></iframe>");
    $census_js = "
<script type='text/javascript'>
function showCensusDiv(z) {
    var url = '/book/get_city_census?id=$sub';
    if(z == 1) {
        document.getElementById('censusDiv').style.display = 'block';
        document.getElementById('btmClose3').style.display = 'block';
        document.getElementById('btmClose4').style.display = 'block';
        document.getElementById('censusHidden').src = url;
    } else {
        document.getElementById('censusDiv').style.display = 'none';
        document.getElementById('btmClose3').style.display = 'none';
        document.getElementById('btmClose4').style.display = 'none';
        document.getElementById('censusHidden').src = '/img/spinner.gif';
    }
}
</script>";
    // echo($census_js);
    array_push($endjava, $census_js);
    $census_detail_div = "
<p align='center'><input class=\"btn btn-success\" name=\"answer\" value=\"Full Census Detail\" onclick=\"showCensusDiv(1)\" title=\"Census Data\" width=\"300px\" type=\"button\" /> 
<input id='btmClose3' class=\"btn btn-primary\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\" style='display: none;'/></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p align='center'>
<div id=\"censusDiv\" style=\"display:none;\" class=\"answer_list\" align='center'><iframe src=\"/img/spinner.gif\" id=\"censusHidden\" height=\"1000px\" width=\"1024px\" align='center'></iframe></div>
<p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"btn btn-primary\" style=\"display: none;\" id=\"btmClose4\" value=\"CLOSE\" onclick=\"showCensusDiv(0)\" type=\"button\" /></p>";
    //echo($census_detail_div . "</div></p>");
}

//var_dump($x);

function check_locals($county_short) {
    $upper = strtoupper($county_short);

    $locals = Array(
        "ALAMEDA"           => "COA",
        "BUTTE"             => "BCO",
        "CONTRA COSTA"      => "CCC",
        "KERN"              => "KERN",
        "MADERA"            => "MAD",
        "MARIN"             => "CMAR",
        "MONTEREY"          => "MCE",
        "NEVADA"            => "NEV",
        "ORANGE"            => "COC",
        "PLACER"            => "PLA",
        "RIVERSIDE"         => "CTRIV",
        "SACRAMENTO"        => "SCO",
        "SAN BERNARDINO"    => "SBD",
        "SAN FRANCISCO"     => "SFO",
        "SAN JOAQUIN"       => "SJC",
        "SAN LUIS OBISPO"   => "SLOCO",
        "SAN MATEO"         => "MAT",
        "SANTA CLARA"       => "SCC",
        "SANTA CRUZ"        => "SCCO",
        "SHASTA"            => "CSHA",
        "VENTURA"           => "VCO",

        );

        if($locals[$upper]) {
            $aid = $locals[$upper];
            $cmtes = populate_aid($aid);
            $retval = "<h2 align='center'>Local Candidate Campaign Finance Reports</h2>
                        <table align='center' class='table-striped table-hover table-responsive table-fit'>
                            <thead class='inverse'>
                                <tr>
                                    <th>FPPC ID</th>
                                    <th>CMTE NM</th>
                                    <th>REPORTS</th>
                                </tr>
                            </thead>
                            <tbody>";
            foreach($cmtes as $row) {
                $cmte_id = $row['Filer_ID'];
                $cmte_nm = $row['Filer_NamL'];
                $rpt_lnk = "<a href='/ctb-legacy/cmlocal2.php?id=$cmte_id' target='_blank'>VIEW REPORTS</a>";

                $retval .= "<tr>
                                <td>$cmte_id</td>
                                <td>$cmte_nm</td>
                                <td>$rpt_lnk</td>
                            </tr>";
            }
            $retval .= "</tbody></table>";
            return $retval;
        } else {
            return FALSE;
        }
        return FALSE;

}

function populate_aid($aid) {
    $conn = Util::get_ctb_conn();
    $retval = Array();

    $sql = "SELECT * FROM netfile_summary WHERE LOCATION = '$aid' GROUP BY Filer_ID ORDER BY Filer_NamL";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            array_push($retval, $row);
        }
    }
    return $retval;
}

function juris_decode($string) {

    $aid = Array(

        //COUNTIES
        "COA" =>                "ALAMEDA COUNTY",
        "BCO" =>                "BUTTE COUNTY",
        "CCC" =>                "CONTRA COSTA COUNTY",
        "KERN" =>               "KERN COUNTY",
        "MAD" =>                "MADERA COUNTY",
        "CMAR" =>               "MARIN COUNTY",
        "MCE" =>                "MONTEREY COUNTY",
        "NEV" =>                "NEVADA COUNTY",
        "COC" =>                "ORANGE COUNTY",
        "PLA" =>                "PLACER COUNTY",
        "CTRIV" =>              "RIVERSIDE COUNTY",
        "SCO" =>                "SACRAMENTO COUNTY",
        "SBD" =>                "SAN BERNARDINO",
        "SFO" =>                "SAN FRANCISCO COUNTY",
        "SJC" =>                "SAN JOAQUIN COUNTY",
        "SLOCO" =>              "SAN LUIS OBISPO",
        "MAT" =>                "SAN MATEO COUNTY",
        "SCC" =>                "SANTA CLARA COUNTY",
        "SCCO" =>               "SANTA CRUZ COUNTY",
        "CSHA" =>               "SHASTA COUNTY",
        "VCO" =>                "VENTURA COUNTY",


        //CITIES
        "ANA" =>                "ANAHEIM",
        "BRK" =>                "BERKELEY",
        "COB" =>                "BURBANK",
        "CAP" =>                "CAPITOLA",
        "CAR" =>                "CARLSBAD",
        "CRSN" =>               "CARSON",
        "CHCO" =>               "CHICO",
        "CCV" =>                "CHULA VISTA",
        "CVN" =>                "COVINA",
        "COF" =>                "FRESNO",
        "GIL" =>                "GILROY",
        "GLD" =>                "GLENDALE",
        "COG" =>                "GLENDORA",
        "HWD" =>                "HAYWARD",
        "CHB" =>                "HUNTINGTON BEACH",
        "COI" =>                "IRVINE",
        "CLN" =>                "LAGUNA NIGUEL",
        "CLF" =>                "LAKE FOREST",
        "LIV" =>                "LIVERMORE",
        "CMB" =>                "MANHATTAN BEACH",
        "MTA" =>                "MANTECA",
        "MGH" =>                "MORGAN HILL",
        "MTV" =>                "MOUNTAIN VIEW",
        "CMA" =>                "MURIETTA",
        "COAK" =>               "OAKLAND",
        "OCN" =>                "OCEANSIDE",
        "CPA" =>                "PALO ALTO",
        "PSDA" =>               "PASADENA",
        "PTSN" =>               "PATTERSON",
        "COP" =>                "PLEASANTON",
        "PRS" =>                "PERRIS",
        "CRC" =>                "RANCHO CUCAMONGA",
        "CRB" =>                "REDONDO BEACH",
        "RIAL" =>               "RIALTO",
        "CITRIV" =>             "RIVERSIDE",
        "SAC" =>                "SACRAMENTO",
        "SLNS" =>               "SALINAS",
        "CSBN" =>               "SAN BERNARDINO",
        "CSD" =>                "SAN DIEGO",
        "SDM" =>                "SAN DIMAS",
        "CSJ" =>                "SAN JOSE",
        "SLO" =>                "SAN LUIS OBISPO",
        "CSA" =>                "SANTA ANA",
        "CSB" =>                "SANTA BARBARA",
        "CSC" =>                "SANTA CLARA",
        "CRUZ" =>               "SANTA CRUZ",
        "SMAR" =>               "SANTA MARIA",
        "CSM" =>                "SANTA MONICA",
        "CSR" =>                "SANTA ROSA",
        "SAU" =>                "SAUSALITO",
        "SHA" =>                "SHAFTER",
        "STO" =>                "STOCKTON",
        "COS" =>                "SUNNYVALE",
        "COV" =>                "VENTURA",
        "WEHO" =>               "WEST HOLLYWOOD",
        "WESTSAC" =>            "WEST SACRAMENTO",
        "COW" =>                "WESTMINSTER",
        "TOY" =>                "YOUNTVILLE"

        
        );
    if($aid[$string]) {
        return $aid[$string];
    } else {
        return "UNKNOWN";
    }


}




function get_prop($header) {
    $prop_array = Array(
        "G08_P1A" => "$9.95B HSR Bond",
        "G08_P2" => "Regulate Animal Confinement",
        "G08_P3" => "$980M Childrens Hospitals Bond",
        "G08_P4" => "Abortion-Parental Notificaton",
        "G08_P5" => "Reduce Penalties for Nonviolent Crimes",
        "G08_P6" => "Boost Crime Prevention, Increase Penalties",
        "G08_P7" => "Promote Use of Alternative Fuels",
        "G08_P8" => "Eliminate Gay Marriage",
        "G08_P9" => "Victim Bill of Rights",
        "G08_P10" => "$5B Alternative Fuels Bond",
        "G08_P11" => "Independent Redistricting Commission",
        "G08_P12" => "$900M Veteran Assistance Bond",
        "G10_P19" => "Marijuana Legalization",
        "G10_P20" => "House Districts Drawn By Commission",
        "G10_P21" => "Hike Vehicle Fees to Fund Parks",
        "G10_P22" => "Prohibit State From Raiding Local Funds",
        "G10_P23" => "Suspend Pollution Laws Until Economy Rebounds",
        "G10_P24" => "Eliminate Business Tax Breaks",
        "G10_P25" => "Simple Majority to Pass Budget",
        "G10_P26" => "2/3 Majority for Tax Increases",
        "G10_P27" => "Eliminate Redistricting Commission",
        "G12_P30" => "Jerry Brown's Tax Increase",
        "G12_P31" => "Mandate 2-Year Budget Cycle",
        "G12_P32" => "Union/Corporate Campaign Restrictions",
        "G12_P33" => "Auto Insurance Persistency Discounts",
        "G12_P34" => "Eliminate Death Penalty",
        "G12_P35" => "Increase Penalties for Human Trafficking",
        "G12_P36" => "Modify 3-Strikes Law",
        "G12_P37" => "Mandatory GMO Labeling",
        "G12_P38" => "Tax Increase for Education",
        "G12_P39" => "Tax Increase on Multi-State Businesses",
        "G12_P40" => "Redistricting Referendum",
        "G14_P1" => "$7.2B Water Bond",
        "G14_P2" => "Increase Rainy Day Fund",
        "G14_P45" => "Public Notice for Insurance Rates",
        "G14_P46" => "Increase Cap on Medical Damages",
        "G14_P47" => "Criminal Code Reform",
        "G14_P48" => "Ratify Gaming Compact",
        "G16_P51" => "School Construction Bond",
        "G16_P52" => "Medi-Cal Hospital Fee",
        "G16_P53" => "Voter Approval of Revenue Bonds",
        "G16_P54" => "Legislative Transparency",
        "G16_P55" => "Extend Prop 30 Tax Increases",
        "G16_P56" => "Tax on Tobacco Products",
        "G16_P57" => "Parole/Juvenile Justice Reform",
        "G16_P58" => "Multilingual Education",
        "G16_P59" => "Citizens United Advisory",
        "G16_P60" => "Mandate Condoms in Adult Films",
        "G16_P61" => "Prescription Drug Price Control",
        "G16_P62" => "Eliminate Death Penalty",
        "G16_P63" => "Firearms & Ammunition Restrictions",
        "G16_P64" => "Legalize Marijuana",
        "G16_P65" => "Divert Carryout Bag Fees From Retailers",
        "G16_P66" => "Strengthen Death Penalty",
        "G16_P67" => "Uphold Plastic Bag Ban",

        "G18_P1" => "Veterans Housing Bond",
        "G18_P2" => "Homeless Housing Bond",
        "G18_P3" => "Water Projects Bond",
        "G18_P4" => "Childrens Hospitals Bond",
        "G18_P5" => "Prop 13 Tax Portability",
        "G18_P6" => "Gas Tax Repeal",
        "G18_P7" => "Eliminate Daylight Savings Time",
        "G18_P8" => "Regulate Kidney Dialysis Clinics",
        "G18_P10" => "Rent Control (Repeal Costa-Hawkins)",
        "G18_P11" => "Private Sector Ambulance Rules",
        "G18_P12" => "Humane Animal Confinement",


    );
    return $prop_array[$header];
}
function vote_adv($d, $r, $t) {
    $dem = number_format((($d / $t) * 100), 2);
    $rep = number_format((($r / $t) * 100), 2);
    $add_space = '';
    if ($dem > $rep) {
        if(($dem - $rep) < 10) {
            $add_space = ' ';
        }
        $reg_span = "<span class='blueme boldme'>D + " . $add_space . number_format(($dem - $rep), 2) . "</span>";
    } elseif ($rep > $dem) {
        if(($rep - $dem) < 10) {
            $add_space = ' ';
        }
        $reg_span = "<span class='redme boldme'>R + " . $add_space . number_format(($rep - $dem), 2) . "</span>";
    } else {
        $reg_span = "<span class='grayme boldme'>GOP / DEM AT PARITY</span>";
    }
    return $reg_span;
}
function get_city_info($sub) {
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

function lookup_city_county($city) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT COUNTY FROM ctb2016_vote_hist_UPDATED WHERE SUBDIVISION = '$city'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $retval = $row['COUNTY'];
        }
    }
    return $retval;
}
function has_local($sub) {
    $city = $sub;
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $retval = Array();
    $sql = "SELECT * FROM ctb2016_city_vote_hist_UPDATED WHERE CITY = '$city' ORDER BY DATE DESC, OFFICE, SEAT DESC, VOTE_PCT DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($retval, $row);
            return TRUE;
        }
    }
    return FALSE;
}
function get_past_reg($county, $sub) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE COUNTY LIKE '$county' && SUBDIVISION = '$sub'";
    //echo("<br>$county - $sub REGISTRATION QUERY:<br>$sql<br>");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }

    $sql = "SELECT * FROM ctb_reg_subdivision WHERE COUNTY LIKE '$county' && SUBDIVISION = '$sub'";
    //echo("<br>$county - $sub REGISTRATION QUERY:<br>$sql<br>");
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
	    foreach($row as $key => $value) {
		$retval[$key] = $value;
	    }
            
        }
    }


    return $retval;
}
function get_the_stats($county, $sub) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_vote_hist_UPDATED WHERE COUNTY LIKE '$county%' && SUBDIVISION = '$sub'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }
    $sql = "SELECT * FROM ctb2016_vote_hist_22 WHERE COUNTY LIKE '%$county%' && SUBDIVISION = '$sub'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		foreach($row as $k => $v) {
			$retval[$k] = $v;
		}
	}
    } 
    return $retval;
}



function draw_demographics2($county) {

    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM census_acs_data WHERE YEAR = 2019 && (NAME LIKE '$county%' && (NAME LIKE '%County%' && NAME LIKE '%California%') )";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dp = $row['dp_table'];
            $cd[$dp] = $row;
        }
    }

    /*

    

    2019

    DP02
    K0001 - Total Households
    K0002 - Family Households
    K0068 - Bachelor's Degree or Higher
    K0066 - Graduate Degree

    DP03
    K0062 - Median Household Income
    K0063 - Mean Household income
    K0088 - Per Capita Income
    K0099 - No Health Insurance
    K0128 - Below Poverty Level

    DP04
    K0046 - Owner Occupied
    K0047 - Renter Occupied
    K0089 - Median Value
    K0134 - Median Rent

    DP05
    K0001 - Total Population
    K0077 - Non-Hispanic White
    K0071 - Hispanic
    K0078 - Black
    K0080 - Asian

*/


    $population = "<p>
        <em>Total Population: " . number_format($cd['DP05']['K0001E']) . "</em>

       <br>White: "  . number_format($cd['DP05']['K0077E']) . " (" . $cd['DP05']['K0077PE'] . "%)
       <br>Latino: " . number_format($cd['DP05']['K0071E']) . " (" . $cd['DP05']['K0071PE'] . "%)
       <br>Black: "  . number_format($cd['DP05']['K0078E']) . " (" . $cd['DP05']['K0078PE'] . "%)
       <br>Asian: "  . number_format($cd['DP05']['K0080E']) . " (" . $cd['DP05']['K0080PE'] . "%)
       </p>";

    $hshld_tot = $cd['DP02']['K0001E'];
    $hshld_fam = $cd['DP02']['K0002E'];
    $hshld_fam_pct = $cd['DP02']['K0002PE'];
    $hshld_nfm_pct = 100 - $hshld_fam_pct;
    $hshld_nfm = number_format($hshld_tot - $hshld_fam);

    $median_income = $cd['DP03']['K0062E'];
    if($median_income == "250") {
        $median_income = "250,000+";
    } else {
        $median_income = number_format($cd['DP03']['K0062E']);
    }

    $median_value = $cd['DP04']['K0089E'];
    if($median_value == "2") {
        $median_value = "2,000,000+";
    } else {
        $median_value = number_format($median_value);
    }

    $income = "<p>
     <em>Total Households: "        . number_format($hshld_tot) . "</em><br>
     Family Households: "       . number_format($cd['DP02']['K0002E'])    . " (" . $cd['DP02']['K0002PE'] . "%), 
     Non-Family Households: "   . $hshld_nfm    . " (" . number_format($hshld_nfm_pct)  . "%)

     <br>Median Household Income: \$"   . $median_income . "
     <br>Mean Household Income: \$"     . number_format($cd['DP03']['K0063E']) . "
     <br>Per-Capita Income: \$"         . number_format($cd['DP03']['K0088E']) . "
     </p>";


    $housing = "<p>
    Owner Occupied: "   . number_format($cd['DP04']['K0046E']) . " ("     . $cd['DP04']['K0046PE'] . "%)<br>
    Median Value: \$"   . $median_value . "<br>
    Renter Occupied: "  . number_format($cd['DP04']['K0047E']) . " ("     . $cd['DP04']['K0047PE'] . "%)<br>
    Median Rent: \$"    . number_format($cd['DP04']['K0134E']) . 
    "</p>";


    $education = "<p>
    Bachelor's Degree or Higher: "  . number_format($cd['DP02']['K0068E']) . " (" . $cd['DP02']['K0068PE'] . "%)<br>
    Graduate Degree: "              . number_format($cd['DP02']['K0066E']) . " (" . $cd['DP02']['K0066PE'] . "%)
    </p>";

    $poverty = "<p>
    Population Below Poverty Level: "                                                       . $cd['DP03']['K0128PE'] . "%<br>
    Population Without Health Insurance: "  . number_format($cd['DP03']['K0099E']) . " ("   . $cd['DP03']['K0099PE'] . "%)
    </p>";


    $retval['population']   = $population;
    $retval['income']       = $income;
    $retval['housing']      = $housing;
    $retval['education']    = $education;
    $retval['poverty']      = $poverty;    

    return $retval;

}

function generate_vote_tables($v, $skip_first) {
    global $winner_span;   

    if($skip_first) {

        //TABLE STRUCTURE - 4 ROWS, 3 RESULTS WIDE


        $r[0] = Array("G12_PRS" => "President '12",
                      "G14_GOV" => "Governor '14",
                      "G12_USS" => "US Senate '12",  
            );

        $r[1] = Array(
                        "G16_PRS" => "President '16",
                        "G18_GOV" => "Governor '18",
                        "G18_USS" => "US Senate '18"
            );

        $r[2] = Array(
                    "G20_PRS" => "President '20",
                    "S21_REC" => "Gov Recall '21",
                    "G22_GOV" => "Governor '22"
            );

    } else {

        //TABLE STRUCTURE - 4 ROWS, 3 RESULTS WIDE
        $r[0] = Array("G08_PRS" => "President '08", 
                      "G10_GOV" => "Governor '10",
                      "G10_USS" => "US Senate '10");

        $r[1] = Array("G12_PRS" => "President '12",
                      "G14_GOV" => "Governor '14",
                      "G12_USS" => "US Senate '12",  
            );

        $r[2] = Array(
                        "G16_PRS" => "President '16",
                        "G18_GOV" => "Governor '18",
                        "G18_USS" => "US Senate '18"
            );

        $r[3] = Array(
                    "G20_PRS" => "President '20",
                    "S21_REC" => "Gov Recall '21",
                    "G22_GOV" => "Governor '22"
            );
    }



    $cands = Array(
        "G08_PRSDEM"    => "Barack Obama (D)",
        "G08_PRSREP"    => "John McCain (R)",
        "G12_PRSDEM"    => "Barack Obama (D-Inc)",
        "G12_PRSREP"    => "Mitt Romney (R)",
        "G16_PRSDEM"    => "Hillary Clinton (D)",
        "G16_PRSREP"    => "Donald Trump (R)",
        "G20_PRSDEM"    => "Joe Biden (D)",
        "G20_PRSREP"    => "Donald Trump (R-Inc)",
        "G10_GOVDEM"    => "Jerry Brown (D)",
        "G10_GOVREP"    => "Meg Whitman (R)",
        "G14_GOVDEM"    => "Jerry Brown (D-Inc)",
        "G14_GOVREP"    => "Neal Kashkari (R)",
        "G18_GOVDEM"    => "Gavin Newsom (D)",
        "G18_GOVREP"    => "John Cox (R)",
        "G10_USSREP"    => "Carly Fiorina (R)",
        "G10_USSDEM"    => "Barbara Boxer (D-Inc)",
        "G12_USSDEM"    => "Dianne Feinstein (D-Inc)",
        "G12_USSREP"    => "Elizabeth Emken (R)",
        "G18_USSDEM1"   => "Kevin de Leon (D)",
        "G18_USSDEM2"   => "Dianne Feinstein (D-Inc)",
	"G22_GOVDEM"	=> "Gavin Newsom (D-Inc)",
	"G22_GOVREP"	=> "Brian Dahle (R)",
        "G12_P30Y"      => "Yes",
        "G12_P30N"      => "No",
        "S21_RECY"      => "Yes on Recall",
        "S21_RECN"      => "No on Recall",
        "G20_P15Y"      => "Yes",
        "G20_P15N"      => "No"
        );

    $short_cands = Array(
        "Barack Obama (D)" => "OBAMA",
        "John McCain (R)"  => "MCCAIN",
        "Barack Obama (D-Inc)"  => "OBAMA",
        "Mitt Romney (R)"   => "ROMNEY",
        "Hillary Clinton (D)"   => "CLINTON",
        "Donald Trump (R)"  => "TRUMP",
        "Joe Biden (D)" => "BIDEN",
        "Donald Trump (R-Inc)"  => "TRUMP",
        "Jerry Brown (D)"   => "BROWN",
        "Meg Whitman (R)"   => "WHITMAN",
        "Jerry Brown (D-Inc)"   => "BROWN",
        "Neal Kashkari (R)" => "KASHKARI",
        "Gavin Newsom (D)"  => "NEWSOM",
        "John Cox (R)"  => "COX",
	"Gavin Newsom (D-Inc)" => "NEWSOM",
	"Brian Dahle (R)" => "DAHLE",
	"Yes on Recall" => "RECALL Y",
	"No on Recall" => "RECALL N",

        );

    $multi_table = '';
    foreach($r as $row => $races) {
        $offset = 0;
        
        foreach($races as $table_key => $verbose) {

            $tmp = [];
            $this_total = 0;

            foreach($v as $key => $value) {
                if(mb_substr($key, 0, 7) == $table_key) {
                    //GOT MATCH
                    $tmp[$key] = $value;
                    $this_total += $value;
                }
            }

            arsort($tmp);

            $w =0;
            foreach($tmp as $key => $value) {
                $this_votes = number_format($value);
                $this_pct = number_format((($value / $this_total) * 100), 2);
                $party = mb_substr($key, 7, 3);
                if($w == 0) {

                    if($party == "DEM" || $key == "S21_RECN") {
                        $table_color = 'dem-table';
			$party = "DEM";
                    } elseif($party == "REP" || $key == "S21_RECY") {
                        $table_color = 'rep-table';
			$party = "REP";
                    } else {
                        $table_color = '';
                    }
                    $winning_cand = $cands[$key];
                    $winning_pct = $this_pct;
                    $winning_party = $party;

                    $winners[$table_key]['winner_nm'] = $winning_cand;
                    $winners[$table_key]['winner_pct'] = $winning_pct;
                    $winners[$table_key]['winner_party'] = $winning_party;

                    $multi_table .= "<div class='col-lg-4 col-md-6 col-sm-6'>
                                    <table id='voteTable' class='table table-sm table-responsive $table_color' style='font-size: 0.75em;'>
                                        <thead class='thead-inverse'>
                                            <tr>
                                                <th colspan='3'>" . $verbose . "</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class='blueColumn t_spacer'>" . ($cands[$key] ?? '') . "</td>
                                            <td class='greyColumn'>" . $this_votes . "</td>
                                            <td class='greyColumn'>" . $this_pct . "%</td>
                                        </tr>";
                    
                } elseif($w == 1) {

                    $losing_pct = $this_pct;
                    $multi_table .= "<tr>
                                        <td class='blueColumn t_spacer'>" . ($cands[$key] ?? '') . "</td>
                                        <td class='greyColumn'>" . $this_votes . "</td>
                                        <td class='greyColumn'>" . $this_pct . "%</td>
                                    </tr>"; 


                    $winners[$table_key]['loser_pct'] = $losing_pct;
                    



                }
                $w++;
            }
                                
            $offset++;
            $multi_table .= "</tbody></table></div>";

        }

    }

    $retval['table'] = $multi_table;


    $winner_check = Array("G08_PRS", "G12_PRS", "G16_PRS", "G20_PRS", "G10_GOV", "G14_GOV", "G18_GOV", "S21_REC", "G22_GOV");

    $winner_span = "<p align='center' class='win_spans'>";

    if($skip_first) {
        $winner_check = Array("G12_PRS", "G16_PRS", "G20_PRS", "G14_GOV", "G18_GOV", "S21_REC", "G22_GOV");
    }

    foreach($winner_check as $table_key) {
        $election = "'" . mb_substr($table_key, 1, 2);

        $winner_long = $winners[$table_key]['winner_nm'];
        $winner_short = $short_cands[$winner_long];
        $winner_party = $winners[$table_key]['winner_party'];

        if($winner_party == "DEM") {
            $this_class = 'blueme boldme';
        } elseif($winner_party == "REP") {
            $this_class = 'redme boldme';
        }
        $margin = number_format($winners[$table_key]['winner_pct'] - $winners[$table_key]['loser_pct'], 2);

        if($table_key == "G10_GOV") {
            $winner_span = substr($winner_span, 0, -45);
            $winner_span .= "</span><br>";
        }

        $winner_span .= "<span class='boldme'>$election:&nbsp;</span><span class='$this_class'>" . $winner_short . " +$margin%&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>";

    }
    $winner_span = substr($winner_span, 0, -45);
    $winner_span .= "</span></p>";
    $winner_span = "<div width='100%' align='center'><div style='display: inline-block;' align='center'><p align='center'>" . $winner_span . "</p></div></div>";
    $retval['winners'] = trim($winner_span);
    return $retval;


    

}

function get_incumbents($county) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_ca_county_incumbents WHERE COUNTY = '$county' ORDER BY DIST";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dist = ltrim($row['DIST'], "0");
            $retval['districts'][$dist] = $row;
            $cand_id = $row['OTHER_ID'];
            $cand_list[$cand_id] = TRUE;
        }
    }



    $query = '';
    foreach($cand_list as $cand_id => $ignore) {
        $query .= " cand_id = '$cand_id' ||";
    }
    $query = substr($query, 0, -2);
    $sql = "SELECT cand_id, text, date FROM ctb_cand_bios WHERE ($query) ORDER BY cand_id, date DESC";


    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $cand_id = $row['cand_id'];
            if(!isset($retval['bios'][$cand_id])) {
                $retval['bios'][$cand_id] = $row['text'];
            }
        }
    }
    return $retval;
}

function get_supe_dist_results($county_short, $dist_num) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb_votes_local_office 
            WHERE CNTYNAME = '$county_short' && OFFICE = 'COUNTY SUPERVISOR' && AREA = $dist_num
            ORDER BY DATE DESC, VOTES DESC";

    //echo("<br>$county_short - $dist_num SQL<br>$sql<br>");
    $result = $conn->query($sql);

    $r = 0; //INITIALIZE RACE COUNTER
    $i = 1; //INITIALIZE CANDIDATE RANK

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $year = $row['YEAR'];
            $date = $row['DATE'];
            $rec_id = $row['RecordID'];
            $race_id = $row['RACEID'];

            if(!isset($year_set[$year])) {
                $year_set[$year] = $date; //GRAB THE LAST ELECTION DATE FOR THIS RACE TO SEE IF IT RESOLVED IN THE PRIMARY OR IF IT WENT TO NOVEMBER
                if(mb_substr($date, 5, 2) == "11") {
                    $verbose_race = $year . " General";
                } else {
                    $verbose_race = $year . " Primary";
                }

                $i = 1; //RESET CANDIDATE RANK
                $r++; //INCREMENT RACE COUNTER
                $race_index[$r] = $verbose_race;
            }

            if($date != $year_set[$year]) {
                continue; //IF THE RACE WAS UNRESOLVED IN THE PRIMARY, IGNORE, PROCEED TO NEXT YEAR
            }

            $race_results[$r][$i] = $row;


            $i++;
        }
    }

    //echo("<br>RETURNED " . sizeof($race_results) . " ($r) Races<br>");
    //var_dump($race_results);

    $table = generate_supe_results_table($race_results, $race_index);
    return $table;
   //echo($table);

}

function generate_supe_results_table($races, $index) {
    //$table_html .= "<div class='row vote-tables'>";
    $table_html = '';
    foreach($races as $race_num => $candidates) {
        $verbose = $index[$race_num];

        if(($race_num - 1) % 3 === 0) {
            //echo("<br>RACE NUM $race_num<br>");
           // $table_html .= "</div> <!--END PANEL ROW RACE NUM $race_num -->
           //                 <div class='row vote-tables'> <!--BEGIN PANEL ROW RACE NUM $race_num -->";
        }

        $table_html .= "<div class='col-lg-4 col-md-6 col-sm-6'> <!--BEGIN VOTE TABLE DIV -->
                            <table class='table table-sm table-responsive' style='font-size: 0.75em;'>
                                <thead class='thead-inverse'>
                                    <tr>
                                        <th colspan='3'>" . $verbose . "</th>
                                    </tr>
                                </thead>
                                <tbody>";

        foreach($candidates as $c) {
            $table_html .= "<tr>
                                <td class='blueColumn t_spacer'>" . $c['NAMF'] . " " . $c['NAML'] . "<br><span class='itcme'>" . $c['BALDESIG'] . "</span></td>
                                <td class='greyColumn' align='right'>" . number_format($c['VOTES']) . "</td>
                                <td class='greyColumn' align='right'>" . number_format((($c['VOTES'] / $c['TOTVOTES']) * 100), 2) . "%</td>
                            </tr>";
        }
        $table_html .= "</tbody>
                        </table>
                        </div> <!--END VOTE TABLE DIV-->";
    }
    //$table_html .= "</div>";

    //echo("<br>TABLE HTML DUMP<br>");
    //echo(htmlspecialchars($table_html));
    return $table_html;

}

function generate_registration($y) {
    $years = Array("G08", "G10", "G12", "G14", "G16", "G18", "G20", "G22", "NOW");
    
    $tablebody = '';
    foreach($years as $year) {
        $dem_key = $year . "_DEM";
        $rep_key = $year . "_REP";
        $npp_key = $year . "_NPP";
        $tot_key = $year . "_TOT";
        $lib_key = $year . "_LIB";
        $grn_key = $year . "_GRN";
        $paf_key = $year . "_PAF";
        $aip_key = $year . "_AIP";
        $oth_key = $year . "_OTH";
        

        $dem = $y[$dem_key];
        $rep = $y[$rep_key];
        $npp = $y[$npp_key];
        $tot = $y[$tot_key];
      
        $adv = vote_adv($dem, $rep, $tot);

        if($year == "NOW") {
            $header_span = "<p align='center' class='boldme'>TOTAL REGISTERED VOTERS: " . number_format($tot) . "<br>
            <table class='reg_now table-striped table-responsive' align='center'>
                <tbody>";

            $r['Democratic'] = $y[$dem_key];
            $r['Republican'] = $y[$rep_key];
            $r['Libertarian'] = $y[$lib_key];
            $r['No Party Preference'] = $y[$npp_key];
            $r['Green Party'] = $y[$grn_key];
            $r['American Independent'] = $y[$aip_key];
            $r['Peace & Freedom'] = $y[$paf_key];
            $r['Other'] = $y[$oth_key];
        

            arsort($r);

            foreach($r as $verbose => $value) {
                $header_span .= "<tr>
                                    <td>" . $verbose . "</td>
                                    <td align='right'>" . number_format($value) . "</td>
                                    <td align='right'>" . number_format((($value / $tot) * 100), 2) . "%</td>
                                </tr>";
            }
            $header_span .= "</tbody></table>";
            

            
        }

        $tablebody .= "<tr class='boldme'>
                <td>$year</td>

                <td class='blueme'>D</td>
                <td class='blueme' align='right'>" . number_format($dem) . "</td>
                <td class='blueme' align='right'>" . makepct($dem, $tot) . "</td>

                <td class='redme'>R</td>
                <td class='redme' align='right'>" . number_format($rep) . "</td>
                <td class='redme' align='right'>" . makepct($rep, $tot) . "</td>

                <td class='grayme'>NPP</td>
                <td class='grayme' align='right'>" . number_format($npp) . "</td>
                <td class='grayme' align='right'>" . makepct($npp, $tot) . "</td>

                <td>TOT</td>
                <td align='right'>" . number_format($tot) . "</td>
                <td>" . $adv . "</td>
            </tr>";


    }

    $retval['current_reg'] = $header_span;
    $retval['past_reg'] = "<h3>Past Registration</h3>
                            <br>
                            <table class='reg_past table-responsive'>
                            $tablebody
                            </table>";

    
    return $retval;

    

}

function get_overlaps($county) {
    global $ror_info;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb_reg_subdivision WHERE COUNTY LIKE '$county'";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sub = $row['SUBDIVISION'];

            if(mb_substr($sub, 0, 8) == "Supervis") {
                $type = "SUPE";
            } elseif(mb_substr($sub, 0, 8) == "Congress") {
                $type = "CD";
            } elseif(mb_substr($sub, 0, 6) == "Senate") {
                $type = "SD";
            } elseif(!$sub) {
                continue;
            } elseif(mb_substr($sub, 0, 8) == "State As") {
                $type = "AD";
            } elseif(mb_substr($sub, 0, 8) == "Board of") {
                $type = "BOE";
            } elseif($sub == "County Totals" || $sub == "Percent") {
                continue;
            } else {
                $type = "CITY";
                $city_list[$sub] = TRUE;              
            }

            $reg[$type][$sub] = $row;
        }
    }

    $query = '';
    foreach($city_list as $city_nm => $ignore) {
        $query .= " DISTRICT = '$city_nm' ||";
    }
    $query = substr($query, 0, -2);

    $sql = "SELECT * FROM PL94_SUMMARY WHERE TYPE = 'CITY' && ( $query ) ORDER BY TOTAL DESC";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $sub = $row['DISTRICT'];
            $census_index[$sub] = $row;
        }
    }

    $city_table = "<h3>Cities</h3>
	            <h5>Population Data From 2020 Census, Voter Registration Data from the CA Secretary of State's " . $ror_info['long_date'] . " Report of Registration</h5>
                    <div class='table table-responsive table-striped table-hover w-auto'>
                    <table class='table-fit w-auto' style='font-size: 0.75em;' v-ctb-table>
                        <thead class='thead-inverse'>
                            <tr>
                                <th>CITY</tH>
                                <th class='rightme'>POPULATION</th>
                                <th class='rightme'>WHITE</th>
                                <th class='rightme'>%</th>
                                <th class='rightme'>LATINO</th>
                                <th class='rightme'>%</th>
                                <th class='rightme'>ASIAN</th>
                                <th class='rightme'>%</th>
                                <th class='rightme'>BLACK</th>
                                <th class='rightme'>%</th>
                                <th class='rightme'>REGISTERED</th>
                                <th class='rightme'>DEM</th>
                                <th class='rightme'>%</th>
                                <th class='rightme'>REP</th>
                                <th class='rightme'>%</th>
                                <th class='rightme'>NPP</th>
                                <th class='rightme'>%</th>
                                <th class='rightme' style='width: 55px !important;'>REG ADV</th>
                            </tr>
                        </thead>
                        <tbody>";


    foreach($reg['CITY'] as $sub => $x) {
        $c = $census_index[$sub] ?? [];
        
        $c_tot = $c['TOTAL'] ?? 0;
        $c_wht = $c['WHITE'] ?? 0;
        $c_lat = $c['LATINO'] ?? 0;
        $c_asn = $c['ASIAN'] ?? 0;
        $c_blk = $c['BLACK'] ?? 0;
        
        $r_tot = $x['NOW_TOT'] ?? 0;
        $r_dem = $x['NOW_DEM'] ?? 0;
        $r_rep = $x['NOW_REP'] ?? 0;
        $r_npp = $x['NOW_NPP'] ?? 0;

        $lnk = "<a href='/book/city/$sub' target='_blank'>$sub</a>";

        $adv = vote_adv($r_dem, $r_rep, $r_tot);


	$city_table .= "<tr>
                    <td>$lnk</td>
                    <td align='right'>" . number_format($c_tot) . "</td>
                    <td align='right'>" . number_format($c_wht) . "</td>
                    <td align='right'>" . number_format(($c_tot != 0 ? ($c_wht / $c_tot) * 100 : 0), 2) . "%</td>

                    <td align='right'>" . number_format($c_lat) . "</td>
                    <td align='right'>" . number_format(($c_tot != 0 ? ($c_lat / $c_tot) * 100 : 0), 2) . "%</td>

                    <td align='right'>" . number_format($c_asn) . "</td>
                    <td align='right'>" . number_format(($c_tot != 0 ? ($c_asn / $c_tot) * 100 : 0), 2) . "%</td>

                    <td align='right'>" . number_format($c_blk) . "</td>
                    <td align='right'>" . number_format(($c_tot != 0 ? ($c_blk / $c_tot) * 100 : 0), 2) . "%</td>

                    <td align='right'>" . number_format($r_tot) . "</td>
                    <td align='right'>" . number_format($r_dem) . "</td>
                    <td align='right'>" . number_format(($r_tot != 0 ? ($r_dem / $r_tot) * 100 : 0), 2) . "%</td>         

                    <td align='right'>" . number_format($r_rep) . "</td>
                    <td align='right'>" . number_format(($r_tot != 0 ? ($r_rep / $r_tot) * 100 : 0), 2) . "%</td>   

                    <td align='right'>" . number_format($r_npp) . "</td>
                    <td align='right'>" . number_format(($r_tot != 0 ? ($r_npp / $r_tot) * 100 : 0), 2) . "%</td>                                                                              

                    <td align='right'>$adv</td>
                </tr>";   
    }
    $city_table .= "</tbody></table></div>";

    $retval['CITY'] = $city_table;

    return $retval;
    
                    
}


function get_cities($county) {
    //global $county;
    $conn = Util::get_ctb_conn();

    $retval = '';
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


function get_geo($sub) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT GEO_ID FROM DP02_merged WHERE (NAME LIKE '%County%' && NAME LIKE '%$sub%') GROUP BY GEO_ID";
    //echo("<br>$sql<br>");
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            return $row['GEO_ID'];
        }
    }
    return FALSE;
}

function populate_datasets() {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT dataset FROM census_codes GROUP BY dataset ORDER BY dataset";
    $result = $conn->query($sql);
    $enddraw = '';
    $income_set = FALSE;
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

function get_council_districts() {
    global $sub;
    $conn = Util::get_ctb_conn();
    $retval = FALSE;

    $upper = strtoupper($sub);
    $sql = "SELECT jur_name, district FROM ctb_ca_city_shp WHERE jur_name = '$upper' ORDER BY district";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $dist = $row['district'];
            $retval[$dist] = $row;
        }
    }
    return $retval;
}

function get_cand_img($cand_id) {
    $arr = Array(".png", ".jpg", ".jpeg", ".bmp", ".gif");
    foreach($arr as $x) {
        if(file_exists("img/candidates/" . $cand_id . $x)) {
            $retval = "<img src='/img/candidates/" . $cand_id . $x . "' width='200px' class='img-responsive img-thumbnail' />";
            return $retval;
        }
    }
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

?>
</div>


@endsection

@section('scripts')
<script>
  function resizeIframe(obj) {
    obj.style.height = (obj.contentWindow.document.body.scrollHeight + 25) + 'px';
    obj.style.width = obj.contentWindow.document.body.scrollWidth + 'px';
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
  function valForm(form, fourcode) {
    var type, datavisappend, electionappend, e1, e2, URL, error = '';
    var URL = 'housevote_bydist.php?id=' + fourcode;
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
</script>

<?php
foreach ($endjava as $value) {
    echo($value);
}
?>

@endsection


@section('styles')

<style>

.redme {
    color: red;
}

.blueme {
    color: blue;
}

.greenme {
    color: green;
}

.rightme {
    text-align: right;
}

.reg_now td {
    padding-left: 8px;
    padding-right: 8px;
}

.reg_past td {
    padding-left: 2px;
    padding-right: 2px;
}

.greyColumn {
    background-color: #F2F2F2 !important;
}

.itcme {
    font-style: italic;
}

.dk_brown {
    color: white;
    background-color: #663d00;
}

.lt_brown {
    background-color: #ffebcc;
}

.win_span {
	width: 100%;
	clear: both;
}
.win_spans span {
	float: left;
}

</style>

@endsection
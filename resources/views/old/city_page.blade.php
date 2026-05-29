<?php
Util::set_errors();

if (empty($sub)) {
    $sub = $_GET['sub'];
}
//echo("<br>SUB: $sub, FOURCODE: $fourcode");
global $sub_store, $county_store;
$id = '';
$sub_store = $sub;
$county_store = $id;
?>


@extends('layouts.book')

@section('title', "City/County Subdivision Detail Rpt $sub")

@section('content')

    <?php
    Util::require_ctb_api();
    setlocale(LC_COLLATE, "en_US");
    setlocale(LC_CTYPE, "en_US");
    $endjava = Array();
    global $county, $sub, $winner_span, $ror_info;

    if ($county_store) {
        $county = $county_store;
    }
    if ($sub_store) {
        $sub = $sub_store;
    }
    if (!$county) {        
        $county2 = lookup_city_county($sub);
    } 

    $ror_info = get_last_ror();

    ?>

<div> <!--BEGIN MAIN CONTENT DIV -->

    <div class="book-page-head row m-n">
        <div>
            <h2 class="m-n pull-left">
            <?php 
            echo("City of $sub"); 
            ?> 
            </h2>

            <div class="clear"></div>

            <h5 class="m-n pull-left">
            <?php 
            echo($county2); 
            ?> 
            </h5>

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
                        <li>
                            <a href='#Maps' role="tab" data-toggle="tab">
                                <i class="material-icons">map</i>                                   
                                Maps / Districts
                            </a>
                        </li>
                        <li>
                            <a href='#Statewide' role="tab" data-toggle="tab">
                                <i class="material-icons">poll</i>                                  
                                Election Results (by city)
                            </a>
                        </li>

                        <li>
                            <a href='#ByGeo' role="tab" data-toggle="tab">
                                <i class="material-icons">poll</i>                                  
                                Election Results (by area)
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
                                            $x = get_the_stats();
                                            generate_vote_tables($x);
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
                                                    <iframe src=<?php echo("'/book/draw_leg?city=$sub'") ?> height='610px' width='810px' style='margin-left: auto; margin-right: auto; overflow: hidden;'></iframe>
                                                    <?php

                                                        $info = get_city_info($sub);
                                                        //var_dump($info);
                                                        if ($info) {
                                                            $link = "<a href='" . $info['weblink'] . "' target='_blank'>" . $sub . "</a>";
                                                            $city_info_div = "<div width='100%' align='center'><p align='center'>$link<br>Incorporated " . $info['dateincorp'] . "<br>" . number_format($info['land_sqmi'], 2) . " Square Miles</p></div>";
                                                            echo($city_info_div);
                                                        }
                                                    ?>
                                                    
                                                </div>
                                            </div> 
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h3>Registration (as of <?php echo($ror_info['long_date']); ?>)</h3> 
                                                        <?php
                                                            $y = get_past_reg();
                                                            generate_registration($y);
                                                        ?>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>



                                        <div class="panel row">
                                                <div class="col-lg-12 center-block fn">
                                                        

                                                    <h3 align='center'>CENSUS DATA (2019 ACS 5-YEAR ESTIMATE)</h3>

                                                    <?php

                                                    $d = draw_demographics2();
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

                    <section id="Maps">

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
                                var url = '/ctb-legacy/geo_lookup.php?city=$upper&cd=' + x + '&election=g20';
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
                                echo("<h3 align='center'>No Council District Maps on File</h3>");
                    }


                        ?>

                    </section>

                    <section id="Statewide">
                    <?php

                    $is_city = TRUE;
                    $has_local = TRUE;
                    if ($is_city && $has_local) {
                        $elections_div = "<div align='center' width='100%'><p align='center'><br><br><h2>ELECTION RESULTS</h2><br>
                            <input type='radio' name='ev' id='p12' value='p12'/>
                            <label for='p12'>P12</label>
                            <input type='radio' name='ev' id='g12' value='g12'/>
                            <label for='g12'>G12</label>
                            <input type='radio' name='ev' id='p14' value='p14'/>
                            <label for='p14'>P14</label>
                            <input type='radio' name='ev' id='g14' value='g14'/>
                            <label for='g14'>G14</label>
                            <input type='radio' name='ev' id='p16' value='p16'/>
                            <label for='p16'>P16</label>
                            <input type='radio' name='ev' id='g16' value='g16'/>
                            <label for='g16'>G16</label>
                            <input type='radio' name='ev' id='p18' value='p18'/>
                            <label for='p18'>P18</label>
                            <input type='radio' name='ev' id='g18' value='g18'/>
                            <label for='g18'>G18</label>
                            <input type='radio' name='ev' id='p20' value='p20'/>
                            <label for='p20'>P20</label>
                            <input type='radio' name='ev' id='g20' value='g20'/>
                            <label for='g20'>G20</label>           
                            <input type='radio' name='ev' id='p22' value='p22'/>
                            <label for='p22'>P22</label>                                                                                                      
                            <input type='radio' name='ev' id='g22' value='g22'/>
                            <label for='g22'>G22</label> 
                            <input type='radio' name='ev' id='local' value='local'/>                                                                                                                                                                    
                            <label for='local'>Local Elections</label>
                            <input id='btmClose1' class='btn' value='CLOSE' onclick='closeCityDiv()' type='button' style='display: none;'/>
                            </p>



                        ";
                        echo($elections_div);

                        $local_js = "
                    <script type='text/javascript'>
                    $(\"input[name='ev']\").change(function(){
                        var x = $(\"input[name='ev']:checked\").val();
                        switch(x) {
                            case 'p12':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p12';
                                break;
                            case 'g12':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g12';
                                break;
                            case 'p14':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p14';
                                break;
                            case 'g14':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g14';
                                break;
                            case 'p16':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p16';
                                break;
                            case 'g16':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g16';
                                break;
                            case 'p18':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p18';
                                break;
                            case 'g18':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g18';
                                break;
                            case 'p20':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p20';
                                break;
                            case 'g20':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g20';
                                break;
                            case 'p22':
                                var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=p22';
                                break;   
			    case 'g22':
				var url='/ctb-legacy/swdb_cityvote.php?id=$sub&e=g22';
				break;                                                                  
                            case 'local':
                                var url = '/ctb-legacy/get_city_results.php?id=$sub';
                                break;
                        }
                        document.getElementById('cityDiv').style.display = 'block';
                        document.getElementById('btmClose1').style.display = 'block';
                        document.getElementById('btmClose2').style.display = 'block';
                        document.getElementById('cityHidden').src = url;
                        

                    });


                    function closeCityDiv() {
                        document.getElementById('cityDiv').style.display = 'none';
                        document.getElementById('btmClose1').style.display = 'none';
                        document.getElementById('btmClose2').style.display = 'none';
                        document.getElementById('cityHidden').src = '/img/spinner.gif';
                    }

                    </script>";

                        // echo($local_js);
                        array_push($endjava, $local_js);
                        ?>
                        <p align='center'>
                    <div id="cityDiv" style="display:none;" class="answer_list">
                        <iframe src="/img/spinner.gif" id="cityHidden" height="1000" width="1024"></iframe>
                    </div>
                    <p style='margin-left: auto !important; margin-right: auto !important;' align='center'>
                        <input class="btn" style="display: none;" id="btmClose2" value="CLOSE" onclick="closeCityDiv()" type="button" />
                    </p>
                        </p>
                        </div>

                    <?php

                    } elseif ($is_county) {
                        echo("<div align='center' width='100%'>");
                        $local_js = "
                    <script type='text/javascript'>
                    function showCityDiv(z) {
                        var url = '/ctb-legacy/get_county_all.php?id=$county';
                        if(z == 1) {
                            document.getElementById('cityDiv').style.display = 'block';
                            document.getElementById('btmClose').style.display = 'block';
                            document.getElementById('cityHidden').src = url;
                        } else {
                            document.getElementById('cityDiv').style.display = 'none';
                            document.getElementById('btmClose').style.display = 'none';
                            document.getElementById('cityHidden').src = '/img/spinner.gif';
                        }
                    }
                    </script>";
                        // echo($local_js);
                        array_push($endjava, $local_js);
                        $city_detail_div = "
                    <p><input class=\"button btn btn-primary\" name=\"answer\" value=\"Past Local Election Results\" onclick=\"showCityDiv(1)\" title=\"Past Local Election Results\" width=\"300px\" type=\"button\" /> <input class=\"close\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <p></p>
                    <div id=\"cityDiv\" style=\"display:none;\" class=\"answer_list\"><iframe src=\"/img/spinner.gif\" id=\"cityHidden\" height=\"1000\" width=\"1024px\"></iframe></div>
                    <p style='margin-left: auto !important; margin-right: auto !important;' align='center'><input class=\"close btmclose\" style=\"display: none;\" id=\"btmClose\" value=\"CLOSE\" onclick=\"showCityDiv(0)\" type=\"button\" /></p>";
                        echo($city_detail_div . "</div>");
                    }
                    ?>

                    </section>

                    <section id="ByGeo">

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
                            <input type='radio' name='gv' id='s21' value='s21'/>
                            <label for='s21'>S21</label>   
                            <input type='radio' name='gv' id='p22' value='p22'/>
                            <label for='p22'>P22</label>   
                            <input type='radio' name='ev' id='g22' value='g22'/>
                            <label for='g22'>G22</label> 
                                                                                                              
                            <input id='btmClose3' class='btn' value='CLOSE' onclick='closeGeoDiv()' type='button' style='display: none;'/>

                            </p>



                        ";
                        echo($elections_div);

                        $local_js = "
                    <script type='text/javascript'>
                    $(\"input[name='gv']\").change(function(){
                        var x = $(\"input[name='gv']:checked\").val();
                        switch(x) {
                            case 'p06':                               
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p06';
                                break;
                            case 'g06':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g06';
                                break;                            
                            case 'p08':                               
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p08';
                                break;
                            case 'g08':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g08';
                                break;                            
                            case 'p10':                               
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p10';
                                break;
                            case 'g10':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g10';
                                break;                            
                            case 'p12':                               
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p12';
                                break;
                            case 'g12':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g12';
                                break;
                            case 'p14':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p14';
                                break;
                            case 'g14':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g14';
                                break;
                            case 'p16':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p16';
                                break;
                            case 'g16':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g16';
                                break;
                            case 'p18':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p18';
                                break;
                            case 'g18':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g18';
                                break;
                            case 'p20':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p20';
                                break;
                            case 'g20':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g20';
                                break;  
                            case 's21':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=s21';
                                break; 
                            case 'p22':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=p22';
                                break;                                                            
                            case 'g22':
                                var url ='/ctb-legacy/geo_lookup.php?place=$sub&election=g22';
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

                    </section>

                    <section id="Finance">

                        <div class='row'>
                            <div class="col-md-12">
                               <div class="panel row">                    

                                <?php
                                    $l = check_locals();
                                    if($l) {
                                        echo($l);
                                    } else {
                                        echo("<h3 align='center'>No Reports Available For This Locality</h3>");
                                    }

                                ?>
                                </div>
                            </div>
                        </div>                            

                    </section>

                    <section id="Census">

                    <?php
                        $geo = get_geo($sub);
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
                     
                        



                    </section>

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

function check_locals() {
    global $sub;
    $upper = strtoupper($sub);

    $locals = Array(
        "ADELANTO" => "ADE",
        "ANAHEIM" => "ANA",
        "ANTIOCH" => "ANT",
        "ARROYO GRANDE" => "CAG",
        "BERKELEY" => "BRK",
        "BURBANK" => "COB",
        "CALISTOGA" => "CAL",
        "CAPITOLA" => "CAP",
        "CARLSBAD" => "CAR",
        "CARSON" => "CRSN",
        "CHICO" => "CHCO",
        "CHULA VISTA" => "CCV",
        "CORONADO" => "COR",
        "COVINA" => "CVN",
        "CULVER CITY" => "CUL",
        "DESERT HOT SPRINGS" => "DHS",
        "DUBLIN" => "DUB",
        "EAST PALO ALTO" => "EPA",
        "ESCONDIDO" => "ESC",
        "FREMONT" => "FRE",
        "FRESNO" => "COF",
        "FULLERTON" => "FUL",
        "GARDEN GROVE" => "GGV",
        "GILROY" => "GIL",
        "GLENDALE" => "GLD",
        "GLENDORA" => "COG",
        "HALF MOON BAY" => "HMB",
        "HAYWARD" => "HWD",
        "HESPERIA" => "HES",
        "HOLLISTER" => "HOL",
        "HUNTINGTON BEACH" => "CHB",
        "INDIO" => "IND",
        "IRVINE" => "COI",
        "LA MESA" => "LMSA",
        "LAGUNA NIGUEL" => "CLN",
        "LAKE ELSINORE" => "LES",
        "LAKE FOREST" => "CLF",
        "LANCASTER" => "LAN",
        "LIVERMORE" => "LIV",
        "LODI" => "LODI",
        "LOS GATOS" => "GAT",
        "MANHATTAN BEACH" => "CMB",
        "MANTECA" => "MTA",
        "MENIFEE" => "MEN",
        "MENLO PARK" => "CMP",
        "MILPITAS" => "MIL",
        "MODESTO" => "MOD",
        "MONROVIA" => "MON",
        "MONTCLAIR" => "MONT",
        "MONTEREY" => "CMO",
        "MORGAN HILL" => "MGH",
        "MOUNTAIN VIEW" => "MTV",
        "MURIETTA" => "CMA",
        "NATIONAL CITY" => "CNC",
        "NEWPORT BEACH" => "CNB",
        "OAKLAND" => "COAK",
        "OAKLEY" => "OAK",
        "OCEANSIDE" => "OCN",
        "OROVILLE" => "ORO",
        "PALM SPRINGS" => "CPS",
        "PALO ALTO" => "CPA",
        "PASADENA" => "PSDA",
        "PATTERSON" => "PTSN",
        "PLEASANTON" => "COP",
        "PERRIS" => "PRS",
        "RANCHO CUCAMONGA" => "CRC",
        "REDDING" => "RED",
        "REDONDO BEACH" => "CRB",
        "RIALTO" => "RIAL",
        "RICHMOND" => "RICH",
        "RIVERSIDE" => "CITRIV",
        "SACRAMENTO" => "SAC",
        "SALINAS" => "SLNS",
        "SAN BERNARDINO" => "CSBN",
        "SAN BRUNO" => "BRU",
        "SAN DIEGO" => "CSD",
        "SAN DIMAS" => "SDM",
        "SAN GABRIEL" => "CSG",
        "SAN JOSE" => "CSJ",
        "SAN LUIS OBISPO" => "SLO",
        "SAN RAFAEL" => "RAF",
        "SANTA ANA" => "CSA",
        "SANTA BARBARA" => "CSB",
        "SANTA CLARA" => "CSC",
        "SANTA CRUZ" => "CRUZ",
        "SANTA FE SPRINGS" => "SFS",
        "SANTA MARIA" => "SMAR",
        "SANTA MONICA" => "CSM",
        "SANTA ROSA" => "CSR",
        "SANTEE" => "STE",
        "SAUSALITO" => "SAU",
        "SONOMA" => "SMA",
        "SHAFTER" => "SHA",
        "STOCKTON" => "STO",
        "SUNNYVALE" => "COS",
        "TEMECULA" => "TEM",
        "TEMPLE CITY" => "TMPL",
        "TORRANCE" => "TOR",
        "VENTURA" => "COV",
        "VICTORVILLE" => "VIC",
        "WATSONVILLE" => "WAT",
        "WEST HOLLYWOOD" => "WEHO",
        "WEST SACRAMENTO" => "WESTSAC",
        "WESTMINSTER" => "COW",
        "YOUNTVILLE" => "TOY",

        );

        if(!empty($locals[$upper])) {
            $aid = $locals[$upper];
            $cmtes = populate_aid($aid);
            $retval = "<h2 align='center'>Local Candidate Campaign Finance Reports</h2>
                        <table align='center' class='table-striped table-hover table-responsive'>
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
    if ($dem > $rep) {
        $reg_span = "<span class='blueme boldme'>D + " . number_format(($dem - $rep), 2) . "</span>";
    } elseif ($rep > $dem) {
        $reg_span = "<span class='redme boldme'>R + " . number_format(($rep - $dem), 2) . "</span>";
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
function get_past_reg() {
    global $county, $sub;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE COUNTY = '$county' && SUBDIVISION = '$sub'";
    if (!$county) {
        $sql = "SELECT * FROM ctb2016_reg_hist_UPDATED WHERE SUBDIVISION = '$sub'";
    }
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

    if(!$county) {
	    $sql = "SELECT * FROM ctb_reg_subdivision WHERE SUBDIVISION = '$sub'";
	    $result = $conn->query($sql);
	    if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			foreach($row as $key => $value) {
	
				$retval[$key] = $value;
			}
		}
	    }
	}

	
        return $retval;
}
function get_the_stats() {
    global $county;
    global $sub;
    global $ctb2016_conn;
    $conn = Util::get_ctb_conn();
    $sql = "SELECT * FROM ctb2016_vote_hist_UPDATED WHERE COUNTY LIKE '$county%' && SUBDIVISION = '$sub'";
    if (!$county) {
        $sql = "SELECT * FROM ctb2016_vote_hist_UPDATED WHERE SUBDIVISION = '$sub'";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $retval = $row;
        }
    }
    if(!$county) {
	$sql = "SELECT * FROM ctb2016_vote_hist_22 WHERE SUBDIVISION = '$sub'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			foreach($row as $k => $v) {
				$retval[$k] = $v;
			}
		}
	}
    }
    return $retval;
}



function draw_demographics2() {

    global $sub;
    $conn = Util::get_ctb_conn();

    $sql = "SELECT * FROM census_acs_data WHERE YEAR = 2019 && (NAME LIKE '$sub%' && (NAME LIKE '%City%' || NAME LIKE '%Town%') )";
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

function generate_vote_tables($v) {
    global $winner_span;   

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
        "S21_RECY"      => "Yes on Recall",
        "S21_RECN"      => "No on Recall",
        "G22_GOVREP"      => "Brian Dahle (R)",
        "G22_GOVDEM"      => "Gavin Newsom (D-Inc)"
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
                                            <td class='blueColumn t_spacer'>" . $cands[$key] . "</td>
                                            <td class='greyColumn'>" . $this_votes . "</td>
                                            <td class='greyColumn'>" . $this_pct . "%</td>
                                        </tr>";
                    
                } elseif($w == 1) {

                    $losing_pct = $this_pct;
                    $multi_table .= "<tr>
                                        <td class='blueColumn t_spacer'>" . $cands[$key] . "</td>
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

    echo($multi_table);


    $winner_check = Array("G08_PRS", "G12_PRS", "G16_PRS", "G20_PRS", "G10_GOV", "G14_GOV", "G18_GOV", "S21_REC", "G22_GOV");

    $winner_span = "<div class='row'>";

    foreach($winner_check as $table_key) {
        $election = "'" . mb_substr($table_key, 1, 2);

        $winner_long = $winners[$table_key]['winner_nm'];
        $winner_short = trim($short_cands[$winner_long]);
        $winner_party = $winners[$table_key]['winner_party'];

        if($winner_party == "DEM") {
            $this_class = 'blueme boldme';
        } elseif($winner_party == "REP") {
            $this_class = 'redme boldme';
        }
        $margin = number_format($winners[$table_key]['winner_pct'] - $winners[$table_key]['loser_pct'], 2);

        if($table_key == "G10_GOV") {
            
            $winner_span .= "</div><div class='row'>";
        }

        $winner_span .= "<div class='col-lg-2'><span class='boldme'>$election</span>: <span class='$this_class'>" . $winner_short . " +$margin%</span></div>";

    }
    //$winner_span = substr($winner_span, 0, -37);
    $winner_span .= "</div>";


    

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

    echo($header_span . "<br><h3>Past Registration</h3><br><table class='reg_past table-responsive'>" . $tablebody . "</table>");

}

function get_geo($sub) {
    $conn = Util::get_ctb_conn();
    $sql = "SELECT GEO_ID FROM DP02_merged WHERE (NAME LIKE '%city%' && NAME LIKE '%$sub%') GROUP BY GEO_ID";
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

</style>

@endsection
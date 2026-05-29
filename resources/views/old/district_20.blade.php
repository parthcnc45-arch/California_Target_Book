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
		global $cached;
		$cached = populate_cached($id);
		$cached['fourcode'] = $id;

		$fourcode = $id;
		$type = mb_substr($fourcode, 0, 2);

		$old_fourcodes = get_fourcode_index();
		$dists = Array($fourcode);
		$cvap = get_cvap($type, $dists);
		$pres = get_pres($type);
		$reg  = get_reg();

		$dist = (int)mb_substr($fourcode, 2,2);
		if(mb_substr($fourcode, 0, 3) == "BOE") {
            $type = "BD";
            $dist = mb_substr($fourcode, 3, 1);
		}
		$old_fourcode = $old_fourcodes['new'][$fourcode];
		$dist_dscr = get_district_info($fourcode);
		$cand_tables = locate_candidates($fourcode);
		$zip_div = get_redist_zips($fourcode);


		$url = "/ctb-legacy/draw_viz.php?city=VIZ8_" . $type . "&cd=" . $dist;
		$iframe_html = "<iframe src='$url' width='680' height='330' align='center' scrolling='no'></iframe>";
        $pres_old_fourcode=$pres[$old_fourcode]??[];
        $reg_old_fourcode=$reg[$old_fourcode]??[];

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
                                        <a class="nav-link" data-toggle="pill" href="#pills-old-results"><span>Old Results</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#pills-difference-report"><span>Difference Report</span></a>
                                    </li>
                                    <li class="nav-item dynamic-tab" data-tab="incumbent">
                                        <a class="nav-link" data-toggle="pill" href="#pills-incumbent"><span>Incumbent</span></a>
                                    </li>
                                    <li class="nav-item dynamic-tab" data-tab="campaigns">
                                        <a class="nav-link" data-toggle="pill" href="#pills-campaigns"><span>Campaigns</span></a>
                                    </li>
                                    <li class="nav-item" data-tab="hot-sheets">
                                        <a class="nav-link" data-toggle="pill" href="#pills-hot-sheets"><span>Hot Sheets</span></a>
                                    </li>


                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <!-- Summery -->
                                    <div class="tab-pane fade active in districts_tabs" id="pills-summary">

                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>{{ $fourcode }} {!! get_incumbent($fourcode) !!}</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">

                                            <div class="col-md-6">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>Incumbent</h5>
                                                </div>
                                                <div class="ctb-incumbent-box mt-3 ctb-border-radius bg-white summary_Incumbent">
                                                    <?php include(Util::$view_root.'incumbent_info.php') ?>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="ctb-rabban headingDiv">
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
                                        <!-- ********************* -->
                                        <!-- **** Graph  Part **** -->
                                        <!-- ********************* -->
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>District Registration (As of February 10, 2023)</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 d-grid summary_Registration">
                                            <div id="donutchart" class="py-3 bg-white ctb-border-radius"></div>
                                            <div id="chart1_AD29" class="py-3 bg-white ctb-border-radius"></div>
                                            <div id="chart2_AD29" class="py-3 bg-white ctb-border-radius"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>District Registration</h5>
                                                    <span> (As of February 10, 2023)</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="ctb-country-registration bg-white pt-3 ctb-border-radius">
                                                    <div class="ctb-country-content px-4">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover" id='jqueryDataTable'>
                                                                <thead>
                                                                    <tr>
                                                                    <th scope="col">COUNTY</th>
                                                                    <th scope="col">% OF COUNTY</th>
                                                                    <th scope="col">ADV</th>
                                                                    <th scope="col">DEM</th>
                                                                    <th scope="col">%</th>
                                                                    <th scope="col">REP</th>
                                                                    <th scope="col">%</th>
                                                                    <th scope="col">NPP</th>
                                                                    <th scope="col">%</th>
                                                                    <th scope="col">TOT</th>
                                                                    <th scope="col">% OF DIST</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-group-divider ctb-divider-brown">
                                                                    {{-- @dd($reg) --}}
                                                                    @foreach($reg as $r)
                                                                        <tr>
                                                                            <th scope="row">SHASTA</th>
                                                                            <td>100.00%</td>
                                                                            <td>{{  strip_tags($r['ADV']) }}</td>
                                                                            <td>{{ $r['DEM'] }}</td>
                                                                            <td>{{ number_format((($r['DEM'] / $r['TOT']) * 100), 2) }}</td>
                                                                            <td>{{ $r['REP'] }}</td>
                                                                            <td>{{ number_format((($r['REP'] / $r['TOT']) * 100), 2) }}</td>
                                                                            <td>{{ $r['NPP'] }}</td>
                                                                            <td>{{ number_format((($r['NPP'] / $r['TOT']) * 100), 2) }}</td>
                                                                            <td>{{ $r['TOT'] }}</td>
                                                                            <td>33.76%</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>Candidates</h5>
                                                    <span>Primary and General</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="ctb-country-registration bg-white pt-3 ctb-border-radius">
                                                <div class="ctb-country-content new px-4">
                                                    <div class="table-responsive">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="2">CAND</th>
                                                                    <th>Alpine</th>
                                                                    <th>Amador</th>
                                                                    <th>El Dorado</th>
                                                                    <th>Lassen</th>
                                                                    <th>Modoc</th>
                                                                    <th>Nevada</th>
                                                                    <th>Placer</th>
                                                                    <th>Plumas</th>
                                                                    <th>Shasta</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="table-group-divider ctb-divider-brown">

                                                                <tr>
                                                                    <th rowspan="2">
                                                                        <a href="#">Joshua Brown (PAF)</a>
                                                                        <p>Assemblywoman/Farmer/Businesswoman</p>
                                                                    </th>
                                                                    <th>PRIMARY</th>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>GENERAL</th>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                    <td>169</td>
                                                                </tr>
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>District Overlaps</h5>
                                                    <span style="font-family: 'Nunito', sans-serif; font-weight: 600; font-size: 14px; line-height: 21px; color: #828192;">(2020 General Election Redistricting Data)</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="d-grid three_coll">
                                                    <div class="col-md-12 px-0">
                                                        <div class="h-100 ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                                            <div class="ctb-overlaps-content px-4">
                                                                <h3>Counties - CO</h3>
                                                                <div class="table-responsive">

                                                                    <?php
                                                                        if(array_key_exists("CO",$cached)){
                                                                            // str_replace("<h3 align='center'>", "<h3>Counties - ", $cached['CO']);
                                                                                echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['CO']);
                                                                        }else echo '<h4>No data available'
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 px-0">
                                                        <div class="h-100 ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                                            <div class="ctb-overlaps-content px-4">
                                                                <h3>CState Senate - SD (NEW)</h3>
                                                                <div class="table-responsive">
                                                                    <?php
                                                                        if(array_key_exists("SD_NEW",$cached)){
                                                                            echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['SD_NEW']);
                                                                        }else echo '<h4>No data available'
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 px-0">
                                                        <div class="h-100 ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                                            <div class="ctb-overlaps-content px-4">
                                                                <h3>Congress - CD (NEW)</h3>
                                                                <div class="table-responsive">
                                                                        <?php
                                                                            if(array_key_exists("CD_NEW",$cached)){
                                                                                echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['CD_NEW']);
                                                                            }else echo '<h4>No data available'
                                                                        ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col-md-12">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>Census Data</h5>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3 ethnic_cvap">
                                                {!! $cvap[$fourcode] !!}

                                            </div>
                                        </div>
                                    </div>
                                    <!-- District -->
                                    <div class="tab-pane fade districts_tabs" id="pills-district"  >
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="ctb-normal-district bg-white d-flex justify-content-between align-items-center gap-2 py-2 px-1 flex-wrap ctb-border-radius">
                                                    <div class="px-2 w-50">
                                                        <p class="mb-0">Previous district ({!! $old_fourcode !!}) had a <span>{!! $pres_old_fourcode['ADV']??'' !!}</span> registration advantage and voted <span>{!! $pres_old_fourcode['ADV']??'' !!}</span> in the 2020 election.</p>
                                                    </div>
                                                    <div class="ctb-normal-district-table bg-white p-2">
                                                        <div class="table-responsive d-flex">
                                                            <table class="table border border-0 border-white mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>DEM</th>
                                                                        <th>REP</th>
                                                                        <th>Biden</th>
                                                                        <th>Trump</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <?php $reg_old_fourcode_ttl=$reg_old_fourcode['TOT']??1; $pres_old_fourcode_ttl=$pres_old_fourcode['TOT']??1;?>
                                                                        <td>{{ number_format((($reg_old_fourcode['DEM']??0 / $reg_old_fourcode_ttl) * 100), 2) }}</td>
                                                                        <td>{{ number_format((($reg_old_fourcode['REP']??0 / $reg_old_fourcode_ttl) * 100), 2) }}</td>
                                                                        <td>{{ number_format((($pres_old_fourcode['PRSDEM01']??0 / $pres_old_fourcode_ttl) * 100), 2) }}</td>
                                                                        <td>{{ number_format((($pres_old_fourcode['PRSREP01'] ??0/ $pres_old_fourcode_ttl) * 100), 2) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="ctb-rabban">
                                                    <div class="d-flex align-items-center headingDiv">
                                                        <div class="col-md-6 p-0">
                                                            <div class="ctb-rabban">
                                                                <h5 class="mb-0 ">Registration (February 10, 2023)</h5>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 p-0">
                                                            <p class="text-sm-start text-md-end mb-0" style="font-family: 'Lato', sans-serif; font-size: 20px; font-weight: 400; line-height: 30px; color: #B6433E">R +12.39%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3 d-grid district_Registration_boxes row_before_none">
                                            <?php
                                                $dom = new DOMDocument();

                                                libxml_use_internal_errors(true);
                                                $dom->loadHTML($cached['LAST_REG']);
                                                libxml_use_internal_errors(false);

                                                $tableRows = $dom->getElementsByTagName('tbody')->item(0)->getElementsByTagName('tr');

                                                foreach ($tableRows as $row) {
                                                    $tableData = $row->getElementsByTagName('td');

                                                    $rowData = [];

                                                    foreach ($tableData as $td) {
                                                        $rowData[] = $td->textContent;
                                                    }
                                                    // print_r($rowData) ;

                                                    echo'<div class="col-md-12 p-0">
                                                        <div class="ctb-district-normal-box bg-white p-3 ctb-border-radius"><h4>'
                                                            .$rowData[1].' '.$rowData[2].
                                                        '</h4>
                                                            <p class="mb-0">'.$rowData[0].'</p>
                                                        </div>
                                                    </div>';
                                                }
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="governer_rows">
                                                {!! $cached['TOPLINE'] !!}
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>Ethnic CVAP and Counties - Co</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 ethnic_cvap">
                                                {!! $cvap[$fourcode] !!}
                                            </div>
                                            <div class="col-md-6 pe-0">
                                                <div class="h-100 ctb-district-counties-container bg-white py-3 px-3 ctb-border-radius">
                                                    <h3>Counties - Co</h3>
                                                    <div class="ctb-district-counties-co">
                                                        <?php
                                                        if(array_key_exists("CO",$cached)){
                                                                echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['CO']);
                                                        }else echo '<h4>No data available'
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="ctb-rabban headingDiv">
                                                    <h5>District Overlaps</h5>
                                                    <p class="mb-0">(2020 General Election Redistricting Data)</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6 px-0">
                                                <div class="h-100 ctb-district-congressional-container bg-white p-3 ctb-border-radius">
                                                    <h3>Congressional</h3>
                                                    <div class="ctb-district-congressional general-pill-tab">


                                                        <ul class="nav nav-pills mb-3 bg-white pt-2 ctb-inline-tab  ctb-border-radius" id="pills-tab">
                                                            <li class="nav-item active">
                                                                <a class="nav-link" data-toggle="pill" href="#cd_new"><span>CD New</span></a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="pill" href="#cd"><span>CD</span></a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade" id="cd_new" >
                                                                <div class="ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                                                    <div class="ctb-overlaps-content px-4">
                                                                        <h3>CD (NEW)</h3>
                                                                        <div class="table-responsive">
                                                                            <?php
                                                                                if(array_key_exists("CD_NEW",$cached)){
                                                                                    echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['CD_NEW']);
                                                                                }else echo '<h4>No data available'
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="cd" >
                                                                <div class="ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                                                    <div class="ctb-overlaps-content px-4">
                                                                        <h3>CD</h3>
                                                                        <div class="table-responsive">
                                                                            <?php
                                                                                if(array_key_exists("CD",$cached)){
                                                                                    echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['CD']);
                                                                                }else echo '<h4>No data available'
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 pe-0">
                                                <div class="h-100 ctb-district-state-senate-container  bg-white p-3 ctb-border-radius">
                                                    <h3>State Senate</h3>
                                                    <div class="ctb-district-state-senate general-pill-tab">



                                                        <ul class="nav nav-pills mb-3 bg-white pt-2 ctb-inline-tab  ctb-border-radius" id="pills-tab">
                                                            <li class="nav-item active">
                                                                <a class="nav-link" data-toggle="pill" href="#Sd_new"><span>SD New</span></a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" data-toggle="pill" href="#Sd"><span>SD</span></a>
                                                            </li>
                                                        </ul>

                                                        <div class="tab-content" id="pills-tabContent">
                                                            <div class="tab-pane fade" id="Sd_new" >
                                                                <div class="ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                                                    <div class="ctb-overlaps-content px-4">
                                                                        <h3>SD (NEW)</h3>
                                                                        <div class="table-responsive">
                                                                            <?php
                                                                                if(array_key_exists("SD_NEW",$cached)){
                                                                                    echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['SD_NEW']);
                                                                                }else echo '<h4>No data available'
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="tab-pane fade" id="Sd" >
                                                                <div class="ctb-district-overlaps bg-white pt-3 ctb-border-radius">
                                                                    <div class="ctb-overlaps-content px-4">
                                                                        <h3>SD</h3>
                                                                        <div class="table-responsive">
                                                                            <?php
                                                                                if(array_key_exists("SD",$cached)){
                                                                                    echo preg_replace('/<h3[^>]*>.*?<\/h3>/si', '', $cached['SD']);
                                                                                }else echo '<h4>No data available'
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-12 p-0">
                                                <div class="ctb-rabban headingDiv">
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
                                            <?php echo($cached['CITIES']); ?>
                                        </div>
                                    </div>
                                    <!-- Old Results -->
                                    <div class="tab-pane fade" id="pills-old-results" >
                                        <div class="row mt-3">
                                            <?php echo($cached['PAST_RESULTS']); ?>
                                        </div>
                                    </div>
                                    <!-- Difference Report -->
                                    <div class="tab-pane fade" id="pills-difference-report" >
                                        <section id='Diff' class='table-striped' style='line-height: 1em;'>
                                            <?php echo($cached['DIFF']); ?>
                                        </section>
                                    </div>
                                    <!-- Incument -->
                                    <div class="tab-pane fade districts_tabs" id="pills-incumbent" style="padding: 0 !important" >
                                        <div id="incumbentLoader" class="text-center mt-5 hidden">
                                            <ctb-loader></ctb-loader>
                                        </div>
                                        <?php //include(Util::$view_root.'incumbent_page_20.php') ?>
                                    </div>
                                    <!-- Camaigns -->
                                    <div class="tab-pane fade districts_tabs pills-campaigns_tabs" id="pills-campaigns" style="padding: 0 !important">
                                        <div id="campaignsLoader" class="text-center mt-5 hidden">
                                            <ctb-loader></ctb-loader>
                                        </div>
                                        <?php //include(Util::$view_root.'cal_campaigns_20.php') ?>
                                    </div>
                                    <!-- Past Hot Sheets -->
                                    <div class="tab-pane fade districts_tabs" id="pills-hot-sheets"  >
                                        <div id="hot-sheetsLoader" class="text-center mt-5 hidden">
                                            <ctb-loader></ctb-loader>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-8 ps-0">
                                            <div class="ctb-rabban headingDiv">
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
            $conn = Util::get_ctb_conn();
            $sql = "SELECT * FROM ctb_redist_cached_1220 WHERE fourcode = '$fourcode' LIMIT 150";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                $type = $row['type'];
                    $retval[$type] = $row['html'];
                }
            }
            return $retval;
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
            $sql = "SELECT CAND_ID FROM ctb2016_e22_incumbent WHERE DIST = '$fourcode'";
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
                "p12"	=> "June 5, 2012 Presidential Primary",
                "g12"	=> "November 6, 2012 General Election",
                "p14"	=> "June 3, 2014 Primary Election",
                "g14"	=> "November 4, 2014 General Election",
                "p16"	=> "June 7, 2016 Presidential Primary",
                "g16"	=> "November 8, 2016 General Election",
                "p18"	=> "June 5, 2018 Primary Election",
                "g18"	=> "November 6, 2018 General Election",
                "p20"	=> "March 3, 2020 Presidential Primary",
                "g20"	=> "November 3, 2020 General Election"
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
                    "White"	=> "white",
                    "Asian" => "asian",
                    "Latino" => "hisp",
                    "Black"	=> "black",
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
                "1"	=> "total",
                "4"	=> "asian",
                "5"	=> "black",
                "7"	=> "white",
                "8"	=> "ind",
                "13"	=> "hisp"
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
                    "White"	=> "white",
                    "Asian" => "asian",
                    "Latino" => "hisp",
                    "Black"	=> "black",
                );

            foreach($dists as $fourcode) {
                $old_fourcode = $old_fourcodes['new'][$fourcode];
                $x = $cvap_data[$fourcode]??[];
                $y = $cvap_11[$old_fourcode]??[];
                $z = $cvap_19[$old_fourcode]??[];

                //$map_nm = $d['name'];
                $cvap = $x['cvap_19'];

                if (is_array($y)) {
                    $tmp_11['Asian'] = number_format(($y['asian']??0 * 100), 1);
                    $tmp_11['Latino'] = number_format(($y['hisp']??0 * 100), 1);
                    $tmp_11['Black'] = number_format(($y['black']??0 * 100), 1);
                    $tmp_11['White'] = number_format(($y['white']??0 * 100), 1);
                }

                if (is_array($z)) {
                    $z['total']=array_key_exists('total',$z)?$z['total'] : 1 ;
                    $tmp_19['White'] = number_format((($z['white']??0 / $z['total']) * 100), 1);
                    $tmp_19['Asian'] = number_format((($z['asian']??0 / $z['total']) * 100), 1);
                    $tmp_19['Black'] = number_format((($z['black']??0 / $z['total']) * 100), 1);
                    $tmp_19['Latino'] = number_format((($z['hisp']??0 / $z['total']) * 100), 1);
                }

                if (is_array($x)) {
                    $tmp['White'] 		= number_format((($x['white']??0 / $cvap) * 100), 1);
                    $tmp['Asian'] 		= number_format((($x['asian']??0 / $cvap) * 100), 1);
                    $tmp['Latino'] 		= number_format((($x['hisp']??0 / $cvap) * 100), 1);
                    $tmp['Black'] 		= number_format((($x['black']??0 / $cvap) * 100), 1);
                    $tmp['Indigenous'] 	= number_format((($x['ind'] ??0/ $cvap) * 100), 1);
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
                                        <td align='right' class='boldme'>" . number_format((int)$this_raw) ?? '' . "</td>
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
                                <table class='pastreg2 table-striped'>
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
                                <table class='pastreg2 table-striped'>
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
            return $cvap_table;
        }



        function get_reg() {

            $conn = Util::get_ctb_conn();
            $sql = "SELECT DIST, TOT, DEM, REP,OTH, NPP FROM ctb2016_sos_all WHERE RPT_DATE = '2023-02-10'";
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
                $sql = "SELECT * FROM ctb2016_e22_incumbent WHERE DIST = '$id'";

                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $name = $row['LEGISLATOR'];
                        $party = $row['PARTY'];
                        // $term_limit = $row['TERM_LIMIT'];
                    }
                }

            } else {
                $sql = "SELECT * FROM ctb2016_e22_fed WHERE DIST = '$id'";

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
                "AD27" 	=> TRUE,
                "AD29"	=> TRUE,
                "AD31"	=> TRUE,
                "AD33"	=> TRUE,
                "AD35"	=> TRUE,
                "AD36"	=> TRUE,
                "AD39"	=> TRUE,
                "AD45"	=> TRUE,
                "AD48"	=> TRUE,
                "AD49"	=> TRUE,
                "AD50"	=> TRUE,
                "AD53"	=> TRUE,
                "AD56"	=> TRUE,
                "AD58"	=> TRUE,
                "AD60"	=> TRUE,
                "AD62"	=> TRUE,
                "AD64"	=> TRUE,
                "AD68"	=> TRUE,
                "AD80"	=> TRUE,
                "SD14"	=> TRUE,
                "SD16"	=> TRUE,
                "SD18"	=> TRUE,
                "SD22"	=> TRUE,
                "SD29"	=> TRUE,
                "SD30"	=> TRUE,
                "SD31"	=> TRUE,
                "SD33"	=> TRUE,
                "SD34"	=> TRUE,
                "CD13"	=> TRUE,
                "CD18"	=> TRUE,
                "CD21"	=> TRUE,
                "CD22"	=> TRUE,
                "CD25"	=> TRUE,
                "CD31"	=> TRUE,
                "CD33"	=> TRUE,
                "CD35"	=> TRUE,
                "CD38"	=> TRUE,
                "CD39" 	=> TRUE,
                "CD42"	=> TRUE,
                "CD44"	=> TRUE,
                "CD46"	=> TRUE,
                "CD52"	=> TRUE


                );

            return $is_vra;

        }

        function get_advantage_raw ($dem, $rep, $tot) {

            $d = number_format((($dem / $tot) * 100), 2);
            $r = number_format((($rep / $tot) * 100), 2);

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


    ?>

@endsection

@section('scripts')
	<?php include(Util::$view_root.'district_20_js.php') ?>
    @include('book.hsFilterJs')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
@endsection

@section('styles')

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
    </style>


@endsection

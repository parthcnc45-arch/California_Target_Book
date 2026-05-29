<?php

//POST-2020 REDISTRICTING VERSION
global $endjava;
$endjava = Array();
//echo("<br>$st - $fourcode<br>");
Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;

$arr = populate_last();
$tables = populate_tables($arr);

?>



@php ($book_side_nav_active = 'finance')

@extends('layouts.book')

@section('title', 'Recent FEC Form 2 Filings | California Target Book')

@section('content')



    <div>
        <div class="container-fluid pt-xl">
            
            <div class="row">
		
                <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-sm-12 center-block fn">
		
                    <nav class='clearfix page-nav'>
                        <ul class="clearfix">
                            <li class='active'>
                                <a href='#House' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">person</i>
                                    House
                                </a>
                            </li>
                            <li>
                                <a href='#Senate' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">person</i>
                                    Senate
                                </a>
                            </li>

                            <li>
                                <a href='#President' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">person</i>
                                    President
                                </a>
                            </li>                            
                        </ul>
                    </nav>

                    <div class="content-wrap pt-xl">

            		<section id="House" class="active">
				<?php echo($tables['H']); ?>
	                </section>
			<section id="Senate">
				<?php echo($tables['S']); ?>

			</section>
	        	<section id="President">
				<?php echo($tables['P']); ?>

	        	</section>

                    </div>
                </div>
            </div>


        </div>


    </div>

<?php 

function populate_tables($arr) {
	global $endjava;

	foreach($arr as $filing_id => $x) {

		$type = $x['candidate_office'];
		switch($type) {
			case "H":
				$fourcode = $x['candidate_state'] . $x['candidate_district'];
				break;
			case "S":
				$fourcode = $x['candidate_state'] . "SEN";
				break;
			case "P":
				$fourcode = "POTUS";
				break;
		}
		$auth_info = '';
		$cand_nm = generate_name($x['candidate_prefix'], $x['candidate_first_name'], $x['candidate_middle_name'], $x['candidate_last_name'], $x['candidate_suffix']);
		$sig_nm = generate_name($x['candidate_signature_prefix'], $x['candidate_signature_first_name'], $x['candidate_signature_middle_name'], $x['candidate_signature_last_name'], $x['candidate_signature_suffix']);
		$sig = $sig_nm . "<br>"	 . date_convert($x['date_signed']);
		$sig = generate_sig($x);
		$cand_addr = generate_address($x['candidate_street_1'], $x['candidate_street_2'], $x['candidate_city'], $x['candidate_addr_state'], $x['candidate_zip_code']);
		$cmte_addr = generate_address($x['committee_street_1'], $x['committee_street_2'], $x['committee_city'], $x['committee_state'], $x['committee_zip_code']);
		if(!empty($x['committee_id_number'])) {
			$cmte_info = $x['committee_name'] . "<br>" . $x['committee_id_number'];
		} else {
			$cmte_info = $x['committee_name'];
		}

		if(!empty($x['authorized_committee_id_number'])) {
			$auth_info = $x['authorized_committee_name'] . "<br>" . $x['authorized_committee_id_number'];
		}
		$tbody[$type] .= "<tr>
						<td>" . $x['filing_id'] . "</td>
						<td>" . $x['election_year'] . "</td>
						<td>" . $fourcode . "</td>
						<td>" . $x['candidate_id_number'] . "</td>
						<td>" . $cand_nm . "</td>
						<td>" . $x['candidate_party_code'] . "</td>
						<td>" . $cmte_info . "</td>
						<td>" . $cmte_addr . "</td>
						<td>" . $auth_info . "</td>
						<td>" . $sig . "</td>
					</tr>";
	}

	foreach($tbody as $type => $t) {
	    $thisid = "table_$type";
	    $js = "
	            $(document).ready(function () {
	                $('#$thisid').DataTable({
	                	order: [[0, 'desc']],
	                });
	                $('.dataTables_length').addClass('bs-select');
	            });
	    ";
	    array_push($endjava, $js);	
		$table[$type] = "<table class='table table-striped' id='$thisid'>
					<thead>
						<tr>
							<th>FILING</th>
							<th>ELECTION YR</th>
							<th>OFFICE</th>
							<th>CAND ID</th>
							<th>CANDIDATE NAME</th>
							<th>PARTY</th>
							<th>COMMITTEE</th>
							<th>CMTE ADDR</th>
							<th>AUTH CMTE</th>
							<th>SIGNED</th>
						</tr>
					</thead>
					<tbody>" . 
						$t . 
					"</tbody>
				</table>";    
	}

	return $table;
}

function filter_keys($x, $keys) {
	foreach($keys as $key) {
		if(strlen($x[$key]) > 0) {
			$retval[$key] = $x[$key];
		} else {
			//DO NOTHING
		}
	}
	return $retval;
}

function generate_cmte_type_info($x) {
	$type = decode_cmte_type($x['committee_type']);
	if($x['leadership_pac']) {
		$leadership = "<br>Leadership PAC";
		$cand_nm = generate_name($x['affiliated_prefix'], $x['affiliated_first_name'], $x['affiliated_middle_name'], $x['affiliated_last_name'], $x['affiliated_suffix']);

		if(strlen($cand_nm) > 0) {
			$cand_nm = "<br>$cand_nm";
		}
		if(!empty($x['affiliated_candidate_id_number'])) {
			$cand_nm .= "<br>" . $x['affiliated_candidate_id_number'];
		}

	}
	if(!empty($x['organization_type'])) {
		$org_type = "<br>" . decode_org_type($x['organization_type']);
	}
	if(!empty($x['lobbyist_registrant_pat'])) {
		$lobby = "<br>Lobbyist Registrant PAC";
	}
	$cand =  trim(generate_cand($x));
	if(strlen($cand) > 0) {
		$cand_nm = "<br>$cand";
	}
	return $type . $leadership . $cand_nm . $org_type . $lobby;
}

function generate_cand($x) {
	$cand_nm = trim(generate_name($x['candidate_prefix'], $x['candidate_first_name'], $x['candidate_middle_name'], $x['candidate_last_name'], $x['candidate_suffix']));
	if(!empty($x['candidate_office'])) {
		if($x['candidate_office'] == "H") {
			$fourcode = $x['candidate_state'] . $x['candidate_district'];
		} elseif($x['candidate_office'] == "S") {
			$fourcode = $x['candidate_state'] . "SEN";
		} elseif($x['candidate_office'] == "P")  {
			$fourcode = "POTUS";
		}
		$dist_info = "<br>$fourcode";
	}
	if(!empty($x['party_code']) && strlen($cand_nm) > 0) {
		$cand_nm .= " (" . $x['party_code'] . ")";
	}
	if(!empty($x['candidate_id_number'])) {
		$cand_id = "<br>" . $x['candidate_id_number'];
	}
	return $cand_nm . $cand_id . $dist_info;

}

function generate_address($addr1, $addr2, $city, $state, $zip) {
	if(!empty($addr2)) {
		return $addr1 . " " . $addr2 . "<br>" . $city . ", " . $state . " " . $zip;
	} else {
		return $addr1 . "<br>" . $city . ", " . $state . " " . $zip;
	}
}

function generate_name($prefix, $first, $middle, $last, $suffix) {
	$retval = $prefix;
	if($prefix) {
		$retval .= " ";
	}
	$retval .= $first;
	if($middle) {
		$retval .= " ";
	}
	$retval .= $middle;
	if($last) {
		$retval .= " ";
	}
	$retval .= $last;

	if($suffix) {
		$retval .= " " . $suffix;
	}
	return $retval;
}

function generate_cmte_info($x) {
	$keys = Array("street_1", "street_2", "city", "state", "zip_code", "change_of_committee_email", "committee_email", "change_of_committee_url", "committee_url");
	$v = filter_keys($x, $keys);
	$addr = generate_address($v['street_1'], $v['street_2'], $v['city'], $v['state'], $v['zip_code']);
	if(!empty($v['committee_url'])) {
		$tmp = $v['committee_url'];
		$tmp = str_replace("https://", "", $tmp);
		$tmp = str_replace("http://", "", $tmp);

		$url = "<br>WEB: <a href='http://$tmp' target='_blank'>$tmp</a>";
	} else {
		$url = '';
	}
	if(!empty($v['committee_email'])) {
		$email = "<br>EMAIL: " . $v['committee_email'];
	}
	return $addr . $url  . $email;
}


function date_convert($str) {
	$year = mb_substr($str, 0, 4);
	$month = mb_substr($str, 4, 2);
	$day = mb_substr($str, 6, 2);
	return $year . "-" . $month . "-" . $day;
}

function generate_sig($x) {
	$sig_nm = trim(generate_name($x['signature_prefix'], $x['signature_first_name'], $x['signature_middle_name'], $x['signature_last_name'], $x['signature_suffix']));
	return $sig_nm . "<br>" . date_convert($x['date_signed']);



}

function generate_bank($x) {
	$bank_nm = $x['bank_name'];
	$bank_addr = generate_address($x['bank_street_1'], $x['bank_street_2'], $x['bank_city'], $x['bank_state'], $x['bank_zip_code']);
	return $bank_nm . "<br>" . $bank_addr;

}

function generate_trs($x) {
	$trs_nm = trim(generate_name($x['treasurer_prefix'], $x['treasurer_first_name'], $x['treasurer_middle_name'], $x['treasurer_last_name'], $x['treasurer_suffix']));
	if(!empty($x['treasurer_title'])) {
		$trs_nm .= ", " . $x['treasurer_title'];
	}
	$addr = trim(generate_address($x['treasurer_street_1'], $x['treasurer_street_2'], $x['treasurer_city'], $x['treasurer_state'], $x['treasurer_zip_code']));

	if(strlen($addr) > 0) {
		$trs_addr = "<br>" . $addr;
	}
	if(!empty($x['treasurer_telephone'])) {
		$ph = trim(convert_phone($x['treasurer_telephone']));
		$trs_ph = "<br>$ph";
	}
	return $trs_nm . $trs_addr . $trs_ph;
}

function convert_phone($str) {
	$area = mb_substr($str, 0, 3);
	$exchange = mb_substr($str, 4, 3);
	$last = mb_substr($str, 6, 4);
	return "($area) $exchange" . "-" . $last;
}

function generate_cus($x) {

}

function generate_agt($x) {

}



function decode_cmte_type($type) {
	$arr = Array(
		"A"	=> "Principal Campaign Cmte",
		"B" => "Authorized Cmte",
		"C" => "Sup/Opp Single Cand (Not Auth)",
		"D" => "Party Cmte",
		"E" => "Sep Seg Fund",
		"F" => "Sup/Opp Mult Cand",
		"G" => "IE SuperPAC",
		"H" => "Hybrid PAC",
		"I" => "Joint Fund Cmte (Auth)" ,
		"J" => "Joint Fund Cmte (Not Auth)"
		);
	return $arr[$type];
}

function decode_org_type($type) {
	$arr = Array(
		"C"	=> "Corporation",
		"T"	=> "Trade Assn",
		"L" => "Labor Org",
		"M" => "Member Org",
		"V" => "Cooperative",
		"W" => "Corp. w/o Cap Stock"
		);
	return $arr[$type];
}

function populate_last() {
	$conn = Util::get_ctb_conn();
	$sql = "SELECT * FROM ctb_fec_f2_db WHERE election_year > 2022 ORDER BY filing_id DESC LIMIT 1000";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$filing_id = $row['filing_id'];
			$retval[$filing_id] = $row;
		}
	}
	return $retval;
}

?>


@endsection

@section('scripts')
    <script>gtag('set', { 'book_category': 'districts' });</script>

    {{--  Incumbent page scripts  --}}

    <script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=180464472033211";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
    <script async src='//platform.twitter.com/widgets.js' charset='utf-8'></script>

	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>    

    <script src="/js/cbpFWTabs.js"></script>
    <script>


      document.addEventListener("DOMContentLoaded", function () {
        load_run1(); // Handler when the DOM is fully loaded
      });


      $(function () {

        // setTimeout(function() {
        // Hack to reload the iframes
        $('iframe').toArray()
            .forEach(function (iframe) {
              iframe.src += '';
            })
        // }, 10);

        $('nav.tab-bar a').on('click', function (e) {
          e.preventDefault();
          var id = this.href.split('#')[1];

          $('.content-wrap section').css('display', 'none');
          $('section#' + id).css('display', 'block');

          $('nav.tab-bar li').removeClass('tab-current');
          $(this).parent().addClass('tab-current');
        });

        var current = window.location.hash || '#Overview';
        $('nav.tab-bar a[href="' + current + '"]').click();
      });

      /**
       * For campaigns page
       */
      $(function () {
        $('#years > ul a').on('click', function (e) {
          e.preventDefault();
          var elec = $(this).attr('for');

          $('#years > div').css('display', 'none');
          $('#years > div' + elec).css('display', 'block');

          $('#years > ul li').removeClass('tab-current');
          $(this).parent().addClass('tab-current');
        });
        $('#years > ul a').first().click();
      });

      function load_run1() {
        runme1();
        runme2();
      }


      function runme2() {
        $('input[name="scope2"]').click(function () {

          //alert('CLICK');

          var fourcode = "<?= $cached['fourcode'] ?>"

          if (this.value == 'vdetail') {
            url = '/book/direct?id=' + fourcode + '&rpt=' + this.value;
          }

          if (this.value == 'veth') {
            url = '/book/direct?id=' + fourcode + '&rpt=' + this.value;
          }

          if (this.value == 'vparty') {
            url = '/book/direct?id=' + fourcode + '&rpt=' + this.value;
          }

          //alert(url);

          closeiframe2();

          document.getElementById("hiddendiv2").style["display"] = "inline-block";
          window.content.location.href = url;

        });

      }

      function closeiframe2(type) {
        removeiframes2();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1030px";
        iframe.height = "800px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv2").appendChild(iframe);
        return false;
      }

      function removeiframes2() {
        var iframes = document.querySelectorAll('iframe[name="content"]');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }

      function runme1() {
        $('input[name="scope1"]').click(function () {

          //alert('CLICK');

          if (this.value == 'new_map_nav') {
            url = '/book/new_map_nav2';
          }

          if (this.value == 'map_nav') {
            url =  <?php

              $url = "'/book/map_nav?id=" . $cached['fourcode'] . "';";
              echo $url;

              ?>
          }

          if (this.value == 'overlap_nav') {
            url = '/book/overlap_nav2';
          }

          //alert(url);

          closeiframe();

          document.getElementById("hiddendiv1").style["display"] = "inline-block";
          window.content.location.href = url;

        });

      }

      function closeiframe(type) {
        removeiframes();
        var link = "/img/spinner.gif";
        var iframe = document.createElement('iframe');
        iframe.frameBorder = 0;
        iframe.width = "1030px";
        iframe.height = "800px";
        iframe.id = "hiddeniframe";
        iframe.name = "content";
        iframe.setAttribute("src", link);
        iframe.setAttribute("background-color", "white");
        document.getElementById("hiddendiv1").appendChild(iframe);
        return false;
      }

      function removeiframes() {
        var iframes = document.querySelectorAll('iframe[name="content"]');
        for (var i = 0; i < iframes.length; i++) {
          iframes[i].parentNode.removeChild(iframes[i]);
        }
      }


    </script>

    <script src="/js/cbpFWTabs2.js"></script>
    <script>
      (function () {

        [].slice.call(document.querySelectorAll('.tabs2'))
            .forEach(function (el) {
              new CBPFWTabs2(el);
            });

      })();
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

 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.js"></script>


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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-colvis-2.3.3/b-html5-2.3.3/b-print-2.3.3/cr-1.6.1/fh-3.3.1/r-2.4.0/datatables.min.css"/>


    <style>
	

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


    <style>

	.greenme {
	     color: green;
	     border-color: green;
	}

        .candidate-panel {
            background-color: #fcfcfc;
            padding: 20px;
            width: 105%;
            max-width: 1190px;
            margin-right: 40px;
            margin-top: 20px;
        }

        .candidate-panel .candidate-content {
            padding: 10px;
        }

        .panel-candidate-header {
            font-weight: bold;
            font-variant: small-caps;
            text-align: right;
            font-size: 1.5em;
            box-shadow: none;
        }

        .content-header {
            text-align: center;
            font-variant: small-caps;
        }

        #years > ul li {
            list-style: none;
            padding: 5px 15px;
            display: inline-block;
            margin: 5px;
            border: 1px solid #ccc;
        }

        #years > ul li.tab-current {
            background: #ddd;
        }

        #years > ul li:hover {
            background: #eee;
        }

        .no-border {
            box-shadow: none;
        }

        .vote-tables .col-sm-3:nth-child(5) {
            clear: both !important;
        }

        .primary_table {
            font-family: 'PT Sans Narrow' !important;
        }

        .panel input {
            margin-left: 0 !important;
        }

        .tablesaw > * {
            font-family: 'PT Sans Narrow' !important;
            padding: 0.02em !important;
        }

        .tablesaw a {
            font-family: 'PT Sans Narrow' !important;
        }

        .ie_iframe {
            min-height: 800px;

        }

        .cmte_contributions td, .cmte_contributions tr, .cmte_contributions p, .cmte_contributions a {
            padding: 0.01em !important;
            line-height: 1em;
        }

	.nav-icon {
		font-size: 2.5em !important;
	}

	.small-table .table-striped {
		line-height: 1em !important;
		padding-top: 0px;
		padding-bottom: 0px;
		font-size: 0.8em;
	}

    .compact-table {
        line-height: 1em !important;
    }

    .compact-table td {
        padding-left: 2px;
        padding-right: 2px;
    }

	.header_icon {
		font-size: 1.3em !important;
	}

table.table-fit {
    width: auto !important;
    table-layout: auto !important;
}
table.table-fit thead th, table.table-fit tfoot th {
    width: auto !important;
}
table.table-fit tbody td, table.table-fit tfoot td {
    width: auto !important;
}

.chart {
	width: 100%;
	min-height: 400px;
}

	.so_div {
		border: 2px solid black;
		float: left;
		display: inline-block;
		padding: 2px;
		font-size: .9em;
		font-weight: bold;
		margin-left: 5px;
		margin-right: 5px;
		font-family: 'Lato';
	}

	.so_div_container {
		float: none;
		clear: both;
		display: inline-block;
		margin-left: auto;
		margin-right: auto;
	}

	.Support {
		color: green;
		font-weight: bold;
	}

	.Oppose {
		color: red;
		font-weight: bold;
	}

    .float-left {
        float: left !important;
    }

    .blackbox {
        border: 2px solid black;
    }

    .box800 {
        background-image: url(box800.jpg);
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        width: 800px;
        float: left;
        margin: 10px;
    }
    .rightme {
        text-align: right !important;
    }

    .leftme {
        text-align: left !important;
    }

    .border-right {
        border-right: 2px solid black !important;
    }

    .border-left {
        border-left: 2px solid black !important;
    }

    .width-90 {
        width: 90% !important;
    }

    .smallbox {
        max-width: 250px !important;
        margin-left: auto;
        margin-right: auto;
    }

    .line-1em {
        line-height: 1.1em !important;
    }

    .table-striped2 tbody > tr:nth-of-type(odd) {
      background-color: #f9f9f9;
    }

.table-striped2 thead > tr > th,
.table-striped2 thead > tr > td,
.table-striped2 tbody > tr > th,
.table-striped2 tbody > tr > td,
.table-striped2 tfoot > tr > th,
.table-striped2 tfoot > tr > td {
  padding-left: 3px;
  padding-right: 3px;
  vertical-align: top;
  border-top: 1px solid #ddd;
}

	.text-lato {
		font-family: "Lato";
	}

	.text-info {
		color: #007BA4;
	}

	.text-smallcap {
		font-variant: small-caps;
	}

	.pad10 {
		padding: 10px;
	}


    </style>


@endsection



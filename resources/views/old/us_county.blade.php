<?php

//POST-2020 REDISTRICTING VERSION

global $fourcode, $st, $role, $endjava;
$fourcode = $id;
$st = $state;
$endjava = Array();
//echo("<br>$st - $fourcode<br>");
Util::require_ctb_api();

use App\User;
$role = Auth::user()->role;

?>



@php ($book_side_nav_active = 'district')

@extends('layouts.book')

@section('title', 'NEW '.$id.' | California Target Book')

@section('content')



    <div>

        <div class="container-fluid pt-xl">

            <div class="row">
                <div class="col-xl-10 col-lg-10 col-md-12 col-xs-12 col-sm-12 center-block fn">
                    <nav class='clearfix page-nav'>
                        <ul class="clearfix">
                            <li class='active'>
                                <a href='#Summary' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">newspaper</i>
                                    Summary
                                </a>
                            </li>
                            <!--
                            <li>
                                <a href='#Overview' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">map</i>
                                    Overlaps
                                </a>
                            </li>


                            <li>
                                <a href='#Incumbent' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">person</i>
                                    Incumbent
                                </a>
                            </li>

                            <li>
                                <a href='#Campaigns' role="tab" data-toggle="tab" class='header_icon'>
                                    <i class="material-icons nav-icon">poll</i>
                                    Campaigns
                                </a>
                            </li>
                            -->


                        </ul>
                    </nav>

                    <div class="content-wrap pt-xl">

            <section id="Summary" class="active">
            	<div class='row'>
            		<div class='panel col-lg-6'>

		            	<?php
						      $url = "/ctb-legacy/draw_map22.php?state=$state&county=$fourcode";
						      //echo("<br>$url<br>");
						      echo("<h1>$state - $fourcode County</h1>");
						      $iframe_html = "<iframe src='$url' width='800' height='600' align='center' scrolling='no'></iframe>";
						      $base = "COUNTY";
						      echo($iframe_html);
						      $overlaps = get_overlaps($base, $state, $fourcode);
						      //$e_results = get_election_results($state, $fourcode);

		            	?>
		            </div>
		            <div class='panel col-lg-6'>
		            	<?php echo $e_results;
		            		  echo("<hr />");
		            		  echo $overlaps;
		            	 ?>
		            </div>

		        </div>


            </section>
			<section id="Overview">
				<?php
						//GET OVERLAPS
				?>

			</section>



	        <section id="Incumbent">
	            
	        </section>


            <section id="Campaigns">

            

            </section>


	    


                    </div>
                </div>
            </div>


        </div>


    </div>

<?php 

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

function get_election_results($st, $fourcode) {
	$conn = Util::get_ctb_conn();
	if($fourcode && !$st) {
		$st = mb_substr($fourcode, 0, 2);
	}
	
	$sql = "SELECT * FROM ctb_us_results 
			WHERE state = '$st' && (fourcode = '$fourcode') 
			ORDER BY fourcode, cand_votes DESC";
	//echo("<br>$sql<br>");
	$result = $conn->query($sql);
	$i = 0;
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$fourcode = $row['fourcode'];
			if($fourcode == $last_fourcode) {
				$i++;
			} else {
				$i = 0;
			}
			$arr[$fourcode][$i] = $row;
			$last_fourcode = $fourcode;

		}
	}
	foreach($arr as $fourcode => $cands) {
		$enddraw .= "<br>$fourcode (2022)<br>";
		$enddraw .= "<table class='table table-striped'><tbody>";
		foreach($cands as $i => $x) {
			if($x['cand_party'] == "Rep") {
				$color_class = 'redme';
			} elseif($x['cand_party'] == "Dem") {
				$color_class = 'blueme';
			} else {
				$color_class = '';
			}
			if($x['outcome'] == "W") {
				$add_class = 'boldme';
			} else {
				$add_class = 'itcme';
			}
			if($x['cand_status'] == "I") {
				$add_status = "-Inc";
			} else {
				$add_status = '';
			}
			if($x['uncontested'] == 1) {
				$add_uncontested = " (Uncontested)";
			} else {
				$add_uncontested = '';
			}
			$party = $x['cand_party'] . $add_status;

			$enddraw .= "<tr class='$add_class'><td class='$color_class'>" . $x['cand_namf'] . " " . $x['cand_naml'] . "</td><td class='$color_class'>" . 
			$party . "</td><td align='right'>" . number_format($x['cand_votes']) . "</td><td>$add_uncontested</td><td>" . number_format((($x['cand_votes'] / $x['total_votes']) * 100), 2) . "%</td></tr>";
		}
		$enddraw .= "</tbody></table>";

	}
	return $enddraw;
}

function get_overlaps($base, $state, $this_fourcode) {
	$conn = Util::get_ctb_conn();

	if(!$state && !empty($this_fourcode)) {
		$state = mb_substr($this_fourcode, 0, 2);
	}
	$sql = "SELECT * FROM ctb_overlaps_20 WHERE base_type = '$base' && state = '$state' && fourcode = '$this_fourcode'";
	//echo("<Br>$sql<br>");
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$type = $row['overlap_type'];
			$id = $row['id'];
			if($type == "PLACE") {
				if(substr($row['overlap_nm'], -3) == "CDP") {
					$type = "CDP";
					$row['overlap_nm'] = substr($row['overlap_nm'], 0, -3);
				} elseif(substr($row['overlap_nm'], -4) == "city") {
					$type = "CITY";
					$row['overlap_nm'] = substr($row['overlap_nm'], 0, -4);
				} elseif(substr($row['overlap_nm'], -4) == "town") {
					$type = "TOWN";
					$row['overlap_nm'] = substr($row['overlap_nm'], 0, -4);
				} else {
					$type = "OTHER";
				}
			}
			$arr[$type][$id] = $row;
		}
	}
	//var_dump($arr);
	$order = Array("HOUSE" => TRUE, "UPPER" => TRUE, "LOWER" => TRUE, "COUNTY" => TRUE, "CITY" => TRUE, "TOWN" => TRUE, "CDP" => TRUE, "OTHER" => "TRUE", "ZIP" => TRUE);
	unset($order[$base]);
	$retval = "<p align='center'>";
	foreach($order as $type => $ignore) {
		switch($type) {
			case "HOUSE":
				$verbose = "U.S. House";
				break;
			case "UPPER":
				$verbose = "State Senate";
				break;
			case "LOWER":
				if($state == "CA" || $state == "NV" || $state == "NY" || $state == "WI") {
					$verbose = "State Assembly";
				} else {
					$verbose = "State House";
				}
				break;
			case "COUNTY":
				$verbose = "Counties";
				break;
			case "PLACE":
				$verbose = "Cities / Places";
				break;
			case "ZIP":
				$verbose = "ZIP Codes";
				break;
			default:
				$verbose = $type;
				break;
		}

		if(sizeof($arr[$type]) > 0) {
			$retval .= "<br><span class='boldme'>$verbose</span><br>";
			foreach($arr[$type] as $id => $x) {
				$retval .= trim($x['overlap_nm']);
				if($x['pct'] != 100) {
					$retval .= " (" . $x['pct'] . "%), ";
				} else {
					$retval .= ", ";
				}
			}
			$retval = substr($retval, 0, -2);
			$retval .= "<br>";
		}

	}
	$retval .= "</p>";
	return $retval;
}




//echo("<p style='font-family: \"Montserrat\"; font-size: 16pt; text-align: justify;'>$bio_txt</p>");




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

<script type="text/javascript"> <!--BEGIN ENDJAVA SECTION -->

<?php
foreach ($endjava as $value) {
    echo($value);
}
?>

</script> <!--END ENDJAVA SECTION-->
@endsection

@section('styles')

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

    </style>


@endsection



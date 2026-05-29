
@extends('layouts.book')
@php ($book_side_nav_active = 'stats')

@section('title', 'CA Voter Registration Trends January 2017 - April 2018 | California Target Book')


@section('content')







</head>
<body>

<div class="container">
	<!-- THE YOUTUBE PLAYER -->
	<div class="vid-container">
	    <iframe id="vid_frame" src="http://www.youtube.com/embed/eg6kNoJmzkY?rel=0&showinfo=0&autohide=1" frameborder="0" width="560" height="315"></iframe>
	</div>


	<div class='vid-list-container'>
    	<div class="vid-list">

			<?php
		    
			$fourcode = $id;

			$ads = get_vids($fourcode);

			//var_dump($ads);
			

			$i = 0;
			foreach($ads as $x) {
				

							
				if($x['provider'] == "youtube")	{
					

					$regex = '~watch\?v\=(.*)~mis';
					preg_match($regex, $x['url'], $results);
					if($i == 0) {
						$class ='active';
					} else {
						$class = '';
					}
					if($results[1]) {
						switch($x['position']) {
							case "support":
								$position = "<span class='greenme'> +";
								break;
							case "oppose":
								$position = "<span class='redme'> -";
								break;
							default:
								$position = "<span>";
								break;
						}
						$vid_list .= "
								    <div class='vid-item' onClick=\"document.getElementById('vid_frame').src='https://www.youtube.com/embed/" . $results[1] . "'\">
								    	<div class='thumb'><img src='https://img.youtube.com/vi/" . $results[1] . "/0.jpg'></div>
										<div class='desc'>
							    		<p class='caption'>" . $x['name'] . " (" . $position . " " . $x['candidate'] . ")</span><br>" . $x['type'] . " ad From " . $x['buyer'] . "</p>
							    		</div>
									</div>";
					}
				}
									 
				$i++;
			}

			if(!$vid_list) {
				$vid_list = "<div class='vid-item'>
								<div class='desc'>NO ADS FOUND</div>
							</div>";
			}			

			echo($vid_list);


			function get_vids($fourcode) {
				//global $master_conn;
				//$conn = $master_conn;
				$conn = Util::get_ctb_conn();
				$sql = "SELECT * FROM ctb_ads_e18 WHERE fourcode = '$fourcode' && provider='youtube' ORDER BY candidate, position";
				$result = $conn->query($sql);
				$retval = Array();
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						array_push($retval, $row);
					}
				}
				return $retval;
			}

			?>
		</div>
	</div>


    <!-- LEFT AND RIGHT ARROWS -->
    <div class="arrows">
      	<div class="arrow-left"><i class="fa fa-chevron-left fa-lg"></i></div>
       	<div class="arrow-right"><i class="fa fa-chevron-right fa-lg"></i></div>
    </div>
</div>


</body>


@endsection


@section('scripts')

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


@endsection



@section('styles')


  	<style type="text/css">


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

		p {
			line-height: .8em;
		}

  	</style>



@endsection

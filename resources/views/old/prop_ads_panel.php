			<?php

			//require_once('php/ctb_api.php');
		    
			//$fourcode = ".GOV";

			$ads = get_vids($fourcode, $year);

			//var_dump($ads);
			

			$i = 0;
            $vid_list =null;
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
					if($i == 0) {
						$first_vid_url = 'https://www.youtube.com/embed/' . $results[1];
					}
				}
									 
				$i++;
			}
			if(!$vid_list) {
				$vid_list = "<div class='vid-item'>
								<div class='desc'>NO ADS FOUND</div>
							</div>";
			}

			//echo($vid_list);

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


<div class='container'>
<div class="row panel">
	<!-- THE YOUTUBE PLAYER -->
	<h2 align='center'>Campaign Ads</h2>
	<div class="vid-container">
		<?php echo("<iframe id='vid_frame' src='$first_vid_url' frameborder='0' width='560' height='315' allowfullscreen></iframe>"); ?>    
	</div>


	<div class='vid-list-container'>
    	<div class="vid-list">
    		<?php echo($vid_list); ?>
		</div>
	</div>


    <!-- LEFT AND RIGHT ARROWS -->
    <div class="arrows">
      	<div class="arrow-left"><i class="fa fa-chevron-left fa-lg"></i></div>
       	<div class="arrow-right"><i class="fa fa-chevron-right fa-lg"></i></div>
    </div>
</div>
</div>

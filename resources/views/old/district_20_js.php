<!-- //  charts section   -->
<script type="text/javascript">
	console.log(<?php echo json_encode($reg_old_fourcode); ?>)
	function drawPieChart() {
		var total=<?php echo json_encode($reg_old_fourcode_ttl); ?>;

		var REP=<?php echo json_encode($reg_old_fourcode['REP']??0); ?>;
		var DEM=<?php echo json_encode($reg_old_fourcode['DEM']??0); ?>;
		var NPP=<?php echo json_encode($reg_old_fourcode['NPP']??0); ?>;
		var OTH=<?php echo json_encode($reg_old_fourcode['OTH']??0); ?>;

		var repValue=(( REP /total ) * 100).toFixed(2)
		var demValue=(( DEM /total ) * 100).toFixed(2)
		var nppValue=(( NPP /total ) * 100).toFixed(2)
		var othValue=(( OTH /total ) * 100).toFixed(2)
		console.log(nppValue,othValue,repValue,demValue)
		var data = google.visualization.arrayToDataTable([

			['PARTY', 'Percent'],
			['DEM', demValue],
			['REP', repValue],
			['NPP', nppValue],
			['OTH', othValue]


		]);
		// var data = google.visualization.arrayToDataTable([

		// 	['PARTY', 'Percent'],
		// 	['DEM', 29.6],
		// 	['REP', 42.00],
		// 	['NPP', 18.30],
		// 	['OTH', 10.00]

		// ]);

		var options = {
			title: 'Current Registration',
			pieHole: 0.5,
			chartArea: {
				width: '75%',
				height: '50%'
			}
		};

		var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
		chart.draw(data, options);
	}

	function drawChart1_AD29() {
		var data = google.visualization.arrayToDataTable([
			['Date', 'Dem', 'GOP', 'NPP'],

			['2008', 52.89, 25.98, 17.09],
			['2010', 56.37, 23.72, 15.77],
			['2012', 54.70, 23.00, 18.79],
			['2014', 52.77, 22.47, 20.95],
			['2016', 52.64, 21.31, 22.31],
			['2018', 50.88, 19.38, 25.82],
			['2020', 52.60, 19.43, 22.81],
			['2022', 53.23, 19.30, 21.20]
		]);

		var options = {
			title: ' Registration by Party (by %): 2008 - NOW',
			titleTextStlye: {
				color: '333333',
				fontName: 'Nunito',
				fontSize: 20
			},
			hAxis: {
				slantedText: true,
				slantedTextAngle: 90,
				textStyle: {
					fontSize: 9
				}
			},
			legend: 'none',
			chartArea: {
				width: '70%',
				height: '80%'
			}
		}

		var chart = new google.visualization.LineChart(document.getElementById('chart1_AD29'));
		chart.draw(data, options);
	}

	function drawChart2_AD29() {
		var data = google.visualization.arrayToDataTable([
			['Year', 'Dem', 'Rep', 'NPP', 'Total'],

			['2008', 80281, 39430, 25947, 151782],
			['2010', 90667, 38149, 25370, 160853],
			['2012', 88930, 37388, 30541, 162578],
			['2014', 87463, 37240, 34721, 165731],
			['2016', 99033, 40094, 41965, 188130],
			['2018', 98702, 37590, 50083, 193975],
			['2020', 118817, 43898, 51534, 225906],
			['2022', 123291, 44696, 49111, 231641]
		]);

		var options = {
			title: 'Registration by Party (Raw): 2008 - NOW',
			titleTextStlye: {
				color: '333333',
				fontName: 'Nunito',
				fontSize: 20
			},
			vAxis: {
				textStyle: {
					fontSize: 11
				}
			},
			hAxis: {
				slantedText: true,
				slantedTextAngle: 90,
				textStyle: {
					fontSize: 9
				}
			},
			legend: 'none',
			chartArea: {
				width: '70%',
				height: '80%'
			}
		}

		var chart = new google.visualization.LineChart(document.getElementById('chart2_AD29'));
		chart.draw(data, options);
	}

	google.load('visualization', '1.0', { 'packages': ['corechart'], 'callback': drawCharts });

	function drawCharts() {
		drawPieChart();
		drawChart1_AD29();
		drawChart2_AD29();
	}
</script>

<script>
	gtag('set', { 'book_category': 'districts' });
</script>

<!-- Incumbent page scripts   -->

<script>
	(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=180464472033211";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<script async src='//platform.twitter.com/widgets.js' charset='utf-8'></script>

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

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">

        <title>@yield('title')</title>
        <link rel="shortcut icon" href="/ctb_logo.ico" />

        <meta name="robots" content="noindex,nofollow">
        <meta name="googlebot" content="noindex,nofollow">

        <meta name="author" content="California Target Book">
        <meta name="keywords" content="Political Campaign, California Election Spending, Political, Political Consulting, Political Consultant, California Non-Partisan, California Voter Guide, Strategist, Political Analyst">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="api_token" content="{{ Auth::user()->api_token }}">

    </head>
  <link href='/css/app.css' rel='stylesheet' id='appStyles'>

  <link rel='stylesheet' href='https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'>
  <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' integrity='sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr' crossorigin='anonymous'>


       
  
<style type='text/css'>
	@import url('https://fonts.googleapis.com/css?family=Bellefair');
	@import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow');
	body, html {
		background-color: white !important;
	}

	a {
		color: #0064CB !important;
	}

	table, th, td {
		padding-left: 5px;
		padding-right: 5px;
		font-family: 'PT SAns Narrow';
		line-height: 1em;
	}

	.ie_list_div {
		float: left;
		border: 2px solid black;
		padding: 5px;
		margin: 20px;
	}

	.fa span {
		margin-left: 5px;
	}

	.blackbox {
		border: 2px solid black;
	}

	.sacto {
		background: url('img/sacto_bright.jpg') no-repeat;
        background-size: cover;
        font-family: 'Bellefair';
	}

	.filing_div {
		
		margin-top: 10px;
	}

	.container {
		min-width: 80vw;
	}

	.max1200 {
		max-width: 1300px;
	}

	.right-align {
		/*
		text-align: right;
		*/
	}

	

	.align-right {
		text-align: right;
	}

	.align-left {
		text-align: left;
	}

	.header_summary_table  {
		line-height: .9em;
		
	}

	.h1me {
		font-size: 2em;
	}

	.h2me {
		font-size: 1.75em;
		font-weight: bold;
		font-variant: small-caps;
	}

	.h3me {
		font-size: 1.5em;
		font-variant: small-caps;
	}

	.filing_header {
		margin-top: 20px;
		font-family: 'PT SAns Narrow';
		font-weight: bold;
	}

	.f460_rcpt_div {
		float: left;
		margin: 10px;
	}

	.f460_expn_div {
		float: left;
		margin: 10px;
	}

	.big_smry {
		clear: both;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
		font-family: 'Lato';
		font-weight: bold;
		width: 50%;
	}

	.full_smry_div_container {
		display: inline-block;
		font-family: 'PT Sans Narrow';
	}

	.full_smry_div_container p {
		text-align: center;
		font-weight: bold;
	}

	.inverse {
		background-color: black;
		color: white;
		font-family: 'PT Sans NArrow' !important;
	}

	.greenme {
	 	color: green !important;
	}

	.redme {
		color: red !important;
	}

	.boldme {
		font-weight: bold;
	}

	.itcme {
		font-style: italic;
	}

	table {
		border: 2px solid black;
	}

	h1, h2 {
		font-family: 'Bellefair';
		font-variant: small-caps;
	}

	h4 span {
		padding-left: 5px;
	}

	.ctb_logo {

} 		
	}
	.big-summary {
		max-width: 800px !important;
		margin-left: auto;
		margin-right: auto;
		font-size: 1.2em;
	}


   .box1200 {
      background-image: url(box1200.jpg);
      background-position: center;
	}

	.box500 {
		background-image: url(box500.jpg);
		background-position: center;
		background-repeat: no-repeat;
		background-size: contain;
		width: 800px;
		height: 500px;
		float: left;
		padding: 20px;
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

	.dem {
		background-color: #85C1F8;
	}

	.rep {
		background-color: #FFA6A6;
	}

	.oth {
		background-color:#DBE8E3;
	}

	.Support {
		color: green;
		font-weight: bold;
	}	

	.Oppose {
		color: red;
		font-weight: bold;
	}

	.cand_list_div {
		float: left;
		margin-left: 20px;
		margin-right: 20px;
	}

	.DEM {
		color: blue;
		font-weight: bold;
	}

	.REP {
		color: #CE0000;
		font-weight: bold;
	}

	.filer_nm {
		font-weight: bold;
		font-family: 'Lato';
		color: #009FCD;
	}

	.dollar_amt {
		font-family: 'Lato';
		font-weight: bold;
	}

	/* bootstrap hack: fix content width inside hidden tabs */
	.tab-content > .tab-pane,
	.pill-content > .pill-pane {
	display: block !important;     /* undo display:none          */
	height: 0 !important;          /* height:0 is also invisible */ 
	overflow-y: hidden !important; /* no-overflow                */
	}
	.tab-content > .active,
	.pill-content > .active {
	height: auto !important;       /* let the content decide it  */
	} /* bootstrap hack end */	

</style>


    <body>
                   @yield('content')
    </body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--<script src='/js/app.js'></script>-->
<script src="/js/jquery.tablesorter.min.js"></script>
<script src='https://www.gstatic.com/charts/loader.js'></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


		  @yield('scripts')

</html>
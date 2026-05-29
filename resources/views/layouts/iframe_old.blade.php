<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <meta name="author" content="California Target Book">
        <meta name="keywords" content="Political Campaign, California Election Spending, Political, Political Consulting, Political Consultant, California Non-Partisan, California Voter Guide, Strategist, Political Analyst">

        <link href="/css/normalize.css" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Bellefair|Nunito+Sans" rel="stylesheet">

        @include('components.analytics')

        <link href="/css/main.css" rel="stylesheet">
        <link href="/css/tablesaw.css" rel="stylesheet">
        <link href="/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">

        <link href="{{ mix('css/app.css') }}" rel="stylesheet" />
        <link href="/css/main.css" rel="stylesheet">
        <link href="/css/tablesaw.css" rel="stylesheet">
        <link href="/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
        <link href="/css/tabs.css" rel="stylesheet">
        <link href="/css/tabstyles.css" rel="stylesheet">
        <link href="/css/ctb.css" rel="stylesheet">
        <link href="/css/ctb_styles.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <link href='https://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>

        <style>


            @font-face {
                font-family: Bellefair;
                src: 'fonts/Bellefair.ttf';
            }

            .navbar, .navbar-inverse {
                border-radius: 0;
                border: none;
                margin-bottom: 0;
                min-height: 80px;
                /*
                background-image: url('../img/bigdark_md.jpg');
                background-size: contain;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: right top;
                */
            }

            .nav li {
                display: inline;
                color: white;
            }

            .navbar-inverse .navbar-nav > li > a {
                color: #ffffff;
                font-family: Lato;
                font-size: 1.3em;
                font-weight: 300;
                padding: 30px 25px 33px 25px;
            }

            .navbar-inverse .navbar-nav li a:hover {
                background-color: #444444;
                transition: 0.7s all linear;
                height: 100%;
            }

            .tablesaw {
                font-family: 'PT Sans Narrow';
            }

            /*
            .dropdown-submenu {
                position: relative;
                 display: inline-block;
            }
            .dropdown-menu {
                width: 400px;
            }
            .dropdown-menu li {
                clear: both;
            }
            .dropdown-submenu>.dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -6px;
                margin-left: -1px;
                -webkit-border-radius: 0 6px 6px 6px;
                -moz-border-radius: 0 6px 6px;
                border-radius: 0 6px 6px 6px;
            }
            .dropdown-submenu:hover>.dropdown-menu {
                display: block;
            }
            .dropdown-submenu>a:after {
                display: block;
                content: " ";
                float: right;
                width: 0;
                height: 0;
                border-color: transparent;
                border-style: solid;
                border-width: 5px 0 5px 5px;
                border-left-color: #ccc;
                margin-top: 5px;
                margin-right: -10px;
            }
            .dropdown-submenu:hover>a:after {
                border-left-color: #fff;
            }
            .dropdown-submenu.pull-left {
                float: none;
            }
            .dropdown-submenu.pull-left>.dropdown-menu {
                left: -100%;
                margin-left: 10px;
                -webkit-border-radius: 6px 0 6px 6px;
                -moz-border-radius: 6px 0 6px 6px;
                border-radius: 6px 0 6px 6px;
            }
            */


            hr {
                border-width: 2px;
                width: 100%;
                margin: 5px 0;
            }

            h2, h3 {
                text-align: center;
            }

            .panel {
                padding: 5%;
                min-height: 400px;
            }

            .sacto {
                background: url('../img/sacto_bright.jpg') no-repeat;
                background-size: cover;
            }

            .landing_page {
                font-family: 'Lato';
                font-size: 1.4em;
            }

            .red {
                color: red;
                border-color: red;
            }

            .yellow {
                color: yellow #BABA04;
                border-color: #BABA04;
            }

            .blue {
                color: blue;
                border-color: blue;
            }

            .midnight {
                color: #012C84;
                border-color: #012C84;
            }

            .green {
                color: green;
                border-color: green;
            }

            .subheadline {
                font-style: italic;
                font-variant: small-caps;
            }

            body, html {
                background-color: #F4F4F4;
            }

            .first_row {
                position: relative;
                margin-top: -30px;
            }

            .sacto h1 {
                font-family: 'Bellefair';
            }

            h3 {
                font-family: 'Bellefair';
            }

            main {
                padding: 0;
            }

            hr.spacer {
                margin:  5px 0;
                width:  100%;
            }

	    a, tr, td, .tablesaw > * {
	 	font-family: 'PT Sans Narrow' !important;
		padding: 1px !important;
		line-height: 1em;
	    }

        </style>

    </head>

    <body>


        <main>
            @yield('content')
        </main>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <!-- SmartMenus jQuery plugin -->
        <script type="text/javascript" src="/js/jquery.smartmenus.min.js"></script>

        <!-- SmartMenus jQuery Bootstrap Addon -->
        <script type="text/javascript" src="/js/jquery.smartmenus.bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/tablesaw.jquery.js"></script>
        <script type="text/javascript" src="/js/tablesaw-init.js"></script>

        <script src="/js/jquery.quicksearch.js"></script>
        <script src="/js/jquery-listnav.min.js"></script>
        <script src="/js/jquery.tablesorter.min.js"></script>

        <script src="/js/ctb.js"></script>

        @yield('scripts')




    </body>
</html>
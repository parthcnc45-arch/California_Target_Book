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
        <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Bellefair|Nunito+Sans" rel="stylesheet">

        @include('components.analytics')


    <link href="/css/test_site.css" rel="stylesheet">
	<link href="/css/main.css" rel="stylesheet">
        <link href="/css/tablesaw.css" rel="stylesheet">
        <link href="/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
        <link href="/css/tabs.css" rel="stylesheet">
        <link href="/css/tabstyles.css" rel="stylesheet">
    <link href="/css/ctb_styles.css" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" />

        <!-- Custom Fonts -->

        {{--<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">--}}
        {{--<link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>--}}
        {{--<link href='http://fonts.googleapis.com/css?family=BenchNine:300,400,700' rel='stylesheet' type='text/css'>--}}

        <style>

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


            hr {
                border-width: 2px;
                width: 80%;
            }


            .panel {
                padding: 5%;
            }

            .sacto {
                background: url('/img/sacto_bright.jpg') no-repeat;
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

            .first_row {
                position: relative;
                margin-top: -30px;
            }

            .sacto h1 {
                font-family: 'Bellefair';
            }


        </style>

        @yield('styles')


        <script>
            window.STRIPE_PUB_KEY = "{{ env('STRIPE_PUB_KEY') }}";
        </script>

    </head>

    <body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

        <div id="app">

            @if(Session::get('message'))
                <div class="notice">
                    {{ Session::get('message') }}
                    <i class="fa fa-times"></i>
                </div>
            @endif

            <main>
                @yield('content')
            </main>


        </div>


        <script src="https://js.stripe.com/v3/"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
        <script src="{{ mix('js/app.js') }}"></script>

        @yield('scripts')


    </body>
</html>
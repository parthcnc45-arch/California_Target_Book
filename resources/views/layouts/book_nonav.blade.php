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

        @include('components.analytics')

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" id="appStyles">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

        @yield('styles')


        <script>
            window.STRIPE_PUB_KEY = "{{ env('STRIPE_PUB_KEY') }}";

            window.globals = {
                STRIPE_PUB_KEY: "{{ env('STRIPE_PUB_KEY') }}",
            };
        </script>

    </head>


    <body class="
        book-page
        @yield('bodyClasses')

    " id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

        <div id="app">

           

            <div class="content">

                <main>
                    @yield('content')
                </main>

            </div>

        </div>


        @yield('scripts-dependencies')
        <script src="https://js.stripe.com/v3/"></script>


        <script src="{{ mix('js/app.js') }}"></script>
        
        <script type='text/javascript' src='https://www.google.com/jsapi'></script>
	<script type='"text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script type="text/javascript" src="/js/jquery.smartmenus.bootstrap.js"></script>
        <script src="/js/jquery.quicksearch.js"></script>
        <script src="/js/jquery-listnav.min.js"></script>
        <script src="/js/jquery.tablesorter.min.js"></script>
        

        <script src="/js/ctb.js"></script>



        @yield('scripts')



    </body>
</html>
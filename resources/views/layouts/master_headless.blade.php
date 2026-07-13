<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- API Token -->
    @if(Auth::check())
        <meta name="api_token" content="{{ Auth::user()->api_token }}">
    @endif

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
    <link href="/css/toaster.css" rel="stylesheet">
    <link href="/css/tablesaw.css" rel="stylesheet">
    <link href="/css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <link href="/css/tabs.css" rel="stylesheet">
    <link href="/css/tabstyles.css" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" />

    @yield('styles')

    <script>
        window.STRIPE_PUB_KEY = "{{ config('app.STRIPE_PUB_KEY') }}";
    </script>
</head>

<body class="@yield('body_class')" id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">
    <div id="app">
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

    <script src="{{ mix('js/app.js') }}"></script>
    <script src="/js/jquery.quicksearch.js"></script>
    <script src="/js/jquery-listnav.min.js"></script>
    <script src="/js/jquery.tablesorter.min.js"></script>
    <script src="/js/ctb.js"></script>

    @yield('scripts')

    @if(Session::get('message'))
        <div class="toast-notice" id="toast-notice">
            <div class="toast-content">
                <i class="fa fa-info-circle toast-icon"></i>
                <span>{{ Session::get('message') }}</span>
            </div>
            <i class="fa fa-times toast-close" onclick="document.getElementById('toast-notice').style.display='none'"></i>
        </div>
    @endif
</body>
</html>
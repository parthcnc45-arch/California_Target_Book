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
        {{-- NEW --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- custom css -->
        <link rel="stylesheet" type="text/css" href="http://localhost:8000/css/style.css" />
        <link rel="stylesheet" href="http://localhost:8000/css/hotSheets.css" />

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" id="appStyles">

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
        @if (Auth::user()->role === 'admin') admin @endif
    " id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

        <div id="app">

            @include('components.nav-condensed')

            <div class="content">
                <div>
                    @include('components.book-sidenav')
                </div>

                <main v-cloak>
                    @yield('content')
                </main>

            </div>

        </div>


        @yield('scripts-dependencies')
        <script src="https://js.stripe.com/v3/"></script>
        <script src="{{ mix('js/app.js') }}"></script>

        <script type="text/javascript" src="/js/jquery.smartmenus.bootstrap.js"></script>
        <script src="/js/jquery.quicksearch.js"></script>
        <script src="/js/jquery-listnav.min.js"></script>
        <script src="/js/jquery.tablesorter.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

        <script src="/js/ctb.js"></script>

        @yield('scripts')



    </body>
</html>

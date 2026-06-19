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
        {{-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700&display=swap" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&amp;family=Nunito:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
        <!-- custom css -->
        <link rel="stylesheet" type="text/css" href="{{ url('assets/css/style.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/css/hotSheets.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/css/hot-sheets-details.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/css/incumbent.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/css/districts.css') }}" />
        <link rel="stylesheet" href="{{ url('assets/css/districts-details.css') }}" />

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
{{--

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" id="appStyles">

        @yield('styles')



        <script>
            window.STRIPE_PUB_KEY = "{{ config('app.STRIPE_PUB_KEY') }}";

            window.globals = {
                STRIPE_PUB_KEY: "{{ config('app.STRIPE_PUB_KEY') }}",
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

            <div class="content overflow-hidden">
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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>


        <script src="/js/ctb.js"></script>
        <script>
            let table = new DataTable('#jqueryDataTable',{
                // searching: false,
                // ordering:  false,
                // paging: false,
            });
            new DataTable('.districtTable');
        </script>
        <script>
            // Custom hybrid tab switcher to support Bootstrap 3/5 active classes on list items and anchors
            $(document).on('click', 'a[data-toggle="pill"], a[data-toggle="tab"], a[data-bs-toggle="pill"], a[data-bs-toggle="tab"]', function (e) {
                e.preventDefault();
                var $anchor = $(this);
                
                // 1. Sync active class on parent list item (Bootstrap 3/4 styling)
                var $parentLi = $anchor.closest('li.nav-item, li');
                $parentLi.addClass('active').siblings().removeClass('active');
                
                // 2. Sync active class on the link itself (Bootstrap 5 styling)
                $anchor.addClass('active');
                $anchor.closest('li').siblings().find('a.nav-link').removeClass('active');

                // 3. Sync active, in, and show classes on the corresponding tab pane
                var targetPane = $anchor.attr('href') || $anchor.attr('data-bs-target');
                if (targetPane && targetPane.startsWith('#')) {
                    var $target = $(targetPane);
                    if ($target.length) {
                        $target.addClass('active in show').siblings('.tab-pane').removeClass('active in show');
                    }
                }
            });
        </script>
        <!-- <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script> -->

        @yield('scripts')



    </body>
</html>

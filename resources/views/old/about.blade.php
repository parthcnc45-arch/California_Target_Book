@extends('layouts.master')

@section('title', 'About | California Target Book')

@section('content')

    <div class="container">


        <h2>About</h2>

        <div class="container">
            <div class="row">
                <div class="col-xs-12">

                    <table id='' class='bordered tablesorter tablesaw tablesaw-stack' data-tablesaw-mode='stack'>
                        <thead>
                            <tr>
                                <th align='right'>AMOUNT</th>
                                <th>COMMITTEE</th>
                                <th align='right'>SUPPORT_AMT</th>
                                <th>SUPPORT_CAND</th>
                                <th align='right'>OPPOSE_AMT</th>
                                <th>OPPOSE_CAND</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td align='right'>$349,224.06</td>
                                <td><a href='http://198.74.49.22/cmlocal2.php?id=1283921' target='_blank'>California
                                        Alliance for Progress and Education, an alliance of small business
                                        organizations</a>
                                </td>
                                <td align='right'>$215,986.79</td>
                                <td>FLORA</td>
                                <td align='right'>$133,237.27</td>
                                <td>VOGEL</td>

                            </tr>

                            <tr>
                                <td align='right'>$324,719.42</td>
                                <td><a href='http://198.74.49.22/cmlocal2.php?id=1363266' target='_blank'>Building and
                                        Protecting a Strong California, A Coalition of Firefighters, Building Trades,
                                        REALTORS. and Correctional Officers Organizations</a></td>
                                <td align='right'>$123,526.39</td>
                                <td>FLORA</td>
                                <td align='right'>$201,193.03</td>
                                <td>VOGEL</td>

                            </tr>

                            <tr>
                                <td align='right'>$26,035.43</td>
                                <td><a href='http://198.74.49.22/cmlocal2.php?id=1069777' target='_blank'>CALIFORNIA
                                        REAL
                                        ESTATE INDEPENDENT EXPENDITURE COMMITTEE - CALIFORNIA ASSOCIATION OF
                                        REALTORS</a>
                                </td>
                                <td align='right'>$26,035.43</td>
                                <td>FLORA</td>
                                <td align='right'></td>
                                <td></td>

                            </tr>

                            <tr>
                                <td align='right'>$24,629.37</td>
                                <td><a href='http://198.74.49.22/cmlocal2.php?id=1270707' target='_blank'>American
                                        Federation of State, County & Municipal Employees - CA People (AFSCME CA People)
                                        Independent Expenditure Committee</a></td>
                                <td align='right'>$24,629.37</td>
                                <td>FLORA</td>
                                <td align='right'></td>
                                <td></td>

                            </tr>

                            <tr>
                                <td align='right'>$24,543.15</td>
                                <td><a href='http://198.74.49.22/cmlocal2.php?id=1362802' target='_blank'>United Food
                                        and
                                        Commercial Workers Western States Council Independent Expenditure PAC</a></td>
                                <td align='right'>$24,543.15</td>
                                <td>FLORA</td>
                                <td align='right'></td>
                                <td></td>

                            </tr>

                            <tr>
                                <td align='right'>$10,000.00</td>
                                <td><a href='http://198.74.49.22/cmlocal2.php?id=1026184' target='_blank'>CAL FIRE Local
                                        2881 Small Contributor PAC</a></td>
                                <td align='right'>$10,000.00</td>
                                <td>FLORA</td>
                                <td align='right'></td>
                                <td></td>

                            </tr>

                            <tr>
                                <td align='right'>$6,785.08</td>
                                <td><a href='http://198.74.49.22/cmlocal2.php?id=1325942' target='_blank'>PACE of
                                        California
                                        School Employees Association Local, State, Federal Candidates (Fed PAC ID
                                        #C00480830)</a></td>
                                <td align='right'>$6,785.08</td>
                                <td>FLORA</td>
                                <td align='right'></td>
                                <td></td>

                            </tr>
                        </tbody>
                    </table>
                    <table class='table table-bordered table-hover tablesaw tablesaw-stack' data-tablesaw-mode="stack">
                        <thead>
                            <tr>
                                <th>Column 1</th>
                                <th>Column 2</th>
                                <th>Column 3</th>
                                <th>Column 4</th>
                                <th>Column 5</th>
                                <th>Column 6</th>
                                <th>Column 7</th>
                                <th>Column 8</th>
                                <th>Column 9</th>
                                <th>Column 10</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Amount 1</td>
                                <td>Amount 2</td>
                                <td>Amount 3</td>
                                <td>Amount 4</td>
                                <td>Amount 5</td>
                                <td>Amount 6</td>
                                <td>Amount 7</td>
                                <td>Amount 8</td>
                                <td>Amount 9</td>
                                <td>Amount 10</td>
                            </tr>
                            <tr>
                                <td>Amount 1</td>
                                <td>Amount 2</td>
                                <td>Amount 3</td>
                                <td>Amount 4</td>
                                <td>Amount 5</td>
                                <td>Amount 6</td>
                                <td>Amount 7</td>
                                <td>Amount 8</td>
                                <td>Amount 9</td>
                                <td>Amount 10</td>
                            </tr>
                            <tr>
                                <td>Amount 1</td>
                                <td>Amount 2</td>
                                <td>Amount 3</td>
                                <td>Amount 4</td>
                                <td>Amount 5</td>
                                <td>Amount 6</td>
                                <td>Amount 7</td>
                                <td>Amount 8</td>
                                <td>Amount 9</td>
                                <td>Amount 10</td>
                            </tr>
                        </tbody>
                    </table>


                    <table summary="This table shows how to create responsive tables using Tablesaw's functionality"
                           class="table table-bordered table-hover tablesaw tablesaw-stack" data-tablesaw-mode="stack">
                        <caption class="text-center">An example of a responsive table based on <a
                                    href="https://github.com/filamentgroup/tablesaw" target="_blank"> Tablesaw</a>:
                        </caption>
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Languages</th>
                                <th>Population</th>
                                <th>Median Age</th>
                                <th>Area (Km²)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Argentina</td>
                                <td>Spanish (official), English, Italian, German, French</td>
                                <td>41,803,125</td>
                                <td>31.3</td>
                                <td>2,780,387</td>
                            </tr>
                            <tr>
                                <td>Australia</td>
                                <td>English 79%, native and other languages</td>
                                <td>23,630,169</td>
                                <td>37.3</td>
                                <td>7,739,983</td>
                            </tr>
                            <tr>
                                <td>Greece</td>
                                <td>Greek 99% (official), English, French</td>
                                <td>11,128,404</td>
                                <td>43.2</td>
                                <td>131,956</td>
                            </tr>
                            <tr>
                                <td>Luxembourg</td>
                                <td>Luxermbourgish (national) French, German (both administrative)</td>
                                <td>536,761</td>
                                <td>39.1</td>
                                <td>2,586</td>
                            </tr>
                            <tr>
                                <td>Russia</td>
                                <td>Russian, others</td>
                                <td>142,467,651</td>
                                <td>38.4</td>
                                <td>17,076,310</td>
                            </tr>
                            <tr>
                                <td>Sweden</td>
                                <td>Swedish, small Sami- and Finnish-speaking minorities</td>
                                <td>9,631,261</td>
                                <td>41.1</td>
                                <td>449,954</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <p class="p">Demo by George Martsoukos. <a
                    href="http://www.sitepoint.com/responsive-data-tables-comprehensive-list-solutions" target="_blank">See
                article</a>.</p>


    </div>


    </div>

@endsection

@section('scripts')

    <script>

      $(window).on('load resize', function () {
        if ($(this).width() < 640) {
          $('table tfoot').hide();
        } else {
          $('table tfoot').show();
        }
      });

    </script>

@endsection

@section('styles')
    <style>

        h2 {
            text-align: center;
            padding-top: 20px 0;
        }

        .table-bordered {
            border: 1px solid #ddd !important;
        }

        table caption {
            padding: .5em 0;
        }

        table tfoot tr td {
            text-align: center !important;
        }

        @media (max-width: 39.9375em) {
            .tablesaw-stack tbody tr:not(:last-child) {
                border-bottom: 2px solid #0B0B0D;
            }
        }

        .p {
            text-align: center;
            padding-top: 140px;
            font-size: 14px;
        }

    </style>
@endsection
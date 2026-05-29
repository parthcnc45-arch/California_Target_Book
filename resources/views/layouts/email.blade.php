<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>
        <link rel="shortcut icon" href="/ctb_logo.ico" />

        <link href="https://fonts.googleapis.com/css?family=Bellefair|Nunito+Sans" rel="stylesheet">


        <style>
          html {
            height: 100%;
            box-sizing: border-box;
          }

          *,
          *:before,
          *:after {
            box-sizing: inherit;
          }

          html, body {
            position: relative;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            overflow-y: scroll;
          }

          body {
            margin: 0;
            min-height: 100%;
            background: #e4eaef;
            position: relative;
            font-family: Nunito Sans,sans-serif;
            font-size: 16px;
            color: #222;
            width: 100vw;
            padding-bottom: 6rem;
          }

          h1 {
            font-weight: 500;
            font-family: Bellefair,serif;
          }

          .content {
            position: relative;
            margin: 80px auto;
            max-width: 90%;
            background: #fff;
            border-radius: 0;
            padding: 10px 20px 10px;
            max-width: 500px;
            width: 94%;
          }

          a {
            color: #c14747;
          }
          a:hover {
            color: #ab3a3a;
          }

          .text-red {
              color: #c14747;
          }

          .btn {
            border-radius: 0;
            border: 1px solid;
            border-bottom-width: 3px;
            box-shadow: none;
            margin: 0;
            cursor: pointer;
            color: #fff;
            padding-top: 5px;
            padding-bottom: 5px;
            outline: none!important;
            position: relative;

            display: inline-block;
            margin-bottom: 0;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            white-space: nowrap;
            padding: 8px 16px;
            font-size: 16px;
            line-height: 1.42857143;
            user-select: none;
            text-decoration: none;
          }
          .btn.btn-primary {
            background-color: #c14747;
            border-color: #ab3a3a!important;
          }

          .btn.btn-primary:hover {
            background-color: #c75a5a;
            color: #fff;
          }

          .footer {
            background: #34393e;
            padding: 12px;
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            text-align: center;
          }
          .footer p {
            color: #fff;
          }

          .text-center {
            text-align: center;
          }

          table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
            background-color: transparent;
          }
          .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #eceeef;
          }
          .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #eceeef;
          }
          .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0,0,0,.05);
          }
          th {
            text-align: left;
          }

        </style>


    </head>

    <body>

        <div class="content">
          @yield('content')
        </div>

        <div class="footer">
           <p class="text-center m-n">
                ©2017 California Target Book. All Rights Reserved. |
                <a href="{{url('/copyright')}}">Copyright</a>
            </p>
        </div>

    </body>
</html>

@extends('layouts.master')

@section('title', 'Expired | California Target Book')

@section('content')


    <div class="container">

        <div class='row'>
            <div class='col-lg-12'>
                <h1 align='center'>Your Subscription Expired <?= $user->expires ?></h1>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-12'>
                <h2 align='center'>Please <a href='renew.php'>Renew Now</a> to Continue</h2>
            </div>
        </div>

        <div class='row'>
            <div class='col-lg-12'>
                <p align='center'>If you believe you have received this message in error,
                    please contact Tom Shortridge at (424) 254-2598.</p>
            </div>
        </div>

    </div>


@endsection


@section("scripts")
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

    .container {
        font-family: 'Lato';
    }

    .panel img {
        border-radius: 20px;
    }

    .panel p {
        text-align: justify;
    }

    hr {
        border-width: 3px;
    }

</style>
@endsection

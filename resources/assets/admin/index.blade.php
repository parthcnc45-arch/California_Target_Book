<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin | California Target Book</title>

    <meta name="robots" content="noindex, nofollow">
    <meta name="ctb_api_token" content="{{Auth::User()->api_token}}"/>
    <base href="/ctb-admin/">
    <link rel="shortcut icon" href="/ctb_logo.ico"/>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://js.stripe.com/v3/"></script>

    <script>
      window.ADMIN_USER = {
        name: '{{ $admin_user->first_name }} {{ $admin_user->last_name }}',
        id: '{{ $admin_user->id }}',
        email: '{{ $admin_user->email }}',
        role: '{{ $admin_user->role }}',
      };

      window.globals = {
        stripe: window.Stripe("{{ config('app.STRIPE_PUB_KEY') }}"),

        SUBSCRIPTION_COST_1YR: {{ config('subscriptions.one_year_online') }},
        SUBSCRIPTION_COST_2YR: {{ config('subscriptions.two_year_online') }},
        ADDON_COST_1YR: {{ config('subscriptions.additional_seat') }},
        ADDON_COST_2YR: {{ config('subscriptions.additional_seat') }},
        BOOK_COST: {{ config('subscriptions.additional_seat') }},

        getBookCountForSubscription: function (yrCount) {
          var yr = (new Date()).getFullYear();
          var mth = (new Date()).getMonth();

          var bookDeliveries = {
            /* (odd/even year): [monthDelivered] */
            0: [3, 5, 10],
            1: [5, 11],
          };

          // Cycle through months to see how many deliveries line up.
          var bookCount = 0;
          for (var i = 0, b = yr % 2; i < (yrCount * 12); i++) {
            var m = i + mth;
            if (m % 12 === 0 && m !== 0) b = (b + 1) % 2;
            if (~bookDeliveries[b].indexOf(m % 12)) bookCount++;
          }

          return bookCount;
        }
      };

    </script>
</head>
<body>
<ctb-root></ctb-root>
</body>
</html>

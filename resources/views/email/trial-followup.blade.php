@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{ $name }},
</p>
<p>
  Your Target Book trial subscription has come to end.
</p>

<p>
  To continue to receive access to the Target Book, you will
  need to renew your subscription. Click below to renew.
</p>

<div class="text-center">

  <a href="{{url('/account/renew')}}" class="btn btn-primary">
    Create Account
  </a>

</div>


@endsection
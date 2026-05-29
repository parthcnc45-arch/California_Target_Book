@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{$name}},
</p>
<p>
  Your subscription payment has been recieved.
  You may now access the California Target Book online.
  Click the following link to verify your email and login.
</p>


<div class="text-center">
  
  <a href="{{url('/verifyemail/'.$email_token)}}" class="btn btn-primary">
    Verify Email
  </a>

</div>


@endsection
@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{$name}},
</p>
<p>
  Click the following link to verify your email and enable your subscription.
</p>


<div class="text-center">
  
  <a href="{{url('/verifyemail/'.$email_token)}}" class="btn btn-primary">
    Verify Email
  </a>

</div>


@endsection
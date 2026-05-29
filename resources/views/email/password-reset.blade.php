@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{$name}},
</p>
<p>
  You've requested to reset your password.
  Click below to change it.
</p>

<div class="text-center">
  
  <a href="{{url('/password/reset/'.$token)}}" class="btn btn-primary">
    Reset Password
  </a>

</div>


@endsection
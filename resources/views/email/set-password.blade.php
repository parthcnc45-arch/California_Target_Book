@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{$name}},
</p>
<p>
  A California Target Book admin has enabled your account,
  simply click below to set your password and complete your account.
</p>

<div class="text-center">

  <a href="{{url('/password/set/'.$token)}}?email={{$email}}" class="btn btn-primary">
    Complete Account
  </a>

</div>


@endsection
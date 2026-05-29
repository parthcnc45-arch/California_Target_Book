@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello,
</p>
<p>
  You've been invited by
  <a href="mailto:{{ $baseUserEmail }}">{{ $baseUserName }}</a>
  to join as an add on account of
  {{ $company_name }}.
</p>

<p>Click below to set up your account.</p>

<div class="text-center">

  <a href="{{url('/verifyaddon/'.$email_token)}}" class="btn btn-primary">
    Create Account
  </a>

</div>


@endsection
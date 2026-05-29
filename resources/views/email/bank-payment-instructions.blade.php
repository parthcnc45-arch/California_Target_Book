@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{$name}},
</p>
<p>
  We've received your request for a California Target Book subscription,
  and only require bank verification to activate your subscription.
</p>

<ol>
  <li>
    <b>In 1-2 business days, look for 2 deposits in your bank account</b>
    <br />
    We’ll send 2 small deposit amounts (less than $1.00) and retrieve them both in 1 withdrawal.
  </li>
  <li>
    <b>Enter deposit amounts on your account page.</b>
    <br />
    Log in to the Target Book, and enter the 2 deposit amounts to confirm your bank.
  </li>
</ol>

<p>
  Once your bank is verified we will enable your account and withdraw the full invoice amount.
</p>

<p>
  If you have any questions, please get in touch with Tom Shortridge.
  Either call (424) 254-9598, or email
  <a href="mailto:tom@californiatargetbook.com">tom@californiatargetbook.com</a>.
</p>



@endsection
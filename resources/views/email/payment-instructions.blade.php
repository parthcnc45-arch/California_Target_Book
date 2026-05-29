@extends('layouts.email')

@section('content')

<h1>California Target Book</h1>

<p>
  Hello {{$name}},
</p>
<p>
  We've received your request for a California Target Book subscription,
  and only require a check to activate your subscription.
</p>
<p>
  Please make your check payable to
  <strong>California Target Book</strong>.
  In the memo be sure to include your email, {{$email}}, so that we can identify your account.
  Then mail your check to:
</p>
<p class="text-center">
  <strong>
    CA Target Book, <br/>
    PO BOX 5978, <br/>
    Beverly Hills, CA 90209
  </strong>
</p>

<p>
  You will be notified when we receive your payment,
  and your account will be activated.
</p>

<p>
  If you have any questions, please get in touch with Tom Shortridge.
  Either call (424) 254-9598, or email
  <a href="mailto:tom@californiatargetbook.com">tom@californiatargetbook.com</a>.
</p>



@endsection
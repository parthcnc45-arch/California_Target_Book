
@extends('layouts.master')

@section('title', 'Thank You! | California Target Book')

@section('content')

    <div class="container focused-form">

        <div class="col-md-8 col-md-offset-2">

            @if($registrationEmailResend)
                <div class="alert alert-success clearfix">
                    <i class="material-icons pull-left">check_circle</i>
                    <p class="pull-left ml-md">Resent email to setup account successfully.</p>
                </div>
            @endif

            <div class="panel">
                <h1>Thank You!</h1>

                <p>
                    You will receive an email soon with instructions to finish setting up your account.
                    If you didn't receive an email,
                    <a href="/register/thank-you?resend=1">click here</a>
                    to have it resent.
                </p>

                @if($invoice)
                    <p class="mb-xl">
                        Your invoice ID is
                        <i class="text-red">{{ $invoice->number }}</i>.
                        <br/>
                        You will receive a copy of your invoice by email.
                    </p>

                    <h3 class="upper text-red">Subscription Summary</h3>
                    <table class="table table-striped">
                        <tbody>
                        @foreach($invoice->lines->data as $line)
                            <tr>
                                <td>{{ $line->description }}</td>
                                <td>${{ $line->amount / 100 }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th>Order Total</th>
                            <th>${{ $invoice->total / 100 }}</th>
                        </tr>
                        </tbody>
                    </table>
                @else
                    <p class="mb-xl">
                        Your subscription has been created.
                        <br/>
                        If you opted for a manual payment method (such as check), you will receive payment instructions by email.
                    </p>
                @endif

            </div>

        </div>
    </div>

@endsection

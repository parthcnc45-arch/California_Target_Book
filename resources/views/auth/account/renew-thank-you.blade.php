
@extends('layouts.master')

@section('title', 'Thank You! | California Target Book')

@section('content')

    <div class="container focused-form">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel">
                <h1>Thank You!</h1>

                @if($invoice)
                    <p class="mb-xl">
                        Your invoice ID is
                        <i class="text-red">{{ $invoice->number }}</i>.
                        <br/>
                        You will receive a copy of your invoice by email.
                    </p>

                    <h3 class="upper text-red">Subscription Renewal Summary</h3>
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
                        Your subscription has been renewed.
                        <br/>
                        If you opted for a manual payment method (such as check), you will receive payment instructions by email shortly.
                    </p>
                @endif

                <div class="mt-md clearfix">
                    <a href="{{ route('book') }}" class="btn btn-primary pull-right">Go To Book</a>
                </div>

            </div>

        </div>
    </div>

@endsection

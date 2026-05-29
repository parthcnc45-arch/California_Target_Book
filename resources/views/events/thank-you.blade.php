
@extends('layouts.master')

@section('title', 'Thank You! | California Target Book')

@section('content')

    <div class="container focused-form">

        <div class="col-md-8 col-md-offset-2">

            <div class="panel">
                <h1>Thank You!</h1>

                <p class="mb-xl">
                    Your invoice ID is
                    <i class="text-red">{{ $invoice['id'] }}</i>.
                    You should receive a copy of your invoice by email soon.
                </p>

                <h3 class="upper text-red">Order Summary</h3>
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <th>Event</th>
                        <td>{{ $event['name'] }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{!! $event['date'] !!}</td>
                    </tr>
                    <tr>
                        <th>Tickets Purchased</th>
                        <td>{{ $invoice['ticketCount'] }}</td>
                    </tr>
                    <tr>
                        <th>Order Total</th>
                        <td>${{ $invoice['total'] / 100 }}</td>
                    </tr>
                    </tbody>

                </table>

            </div>

        </div>
    </div>

@endsection

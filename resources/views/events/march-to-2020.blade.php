@extends('layouts.master')
@section('title', 'March to 2020')

@section('content')

    @php
        $user = Auth::user();
        if (!empty($user)) {
            $profile = $user->profile();
        } else {
            $profile = [];
        }
    @endphp

    <ctb-event-signup inline-template class="container focused-form" :user="{{ json_encode($profile) }}"
            :server-errors="{{ json_encode($errors) }}" :old-input="{{ json_encode(old()) }}">

        <div class="" id="event">

            <form class="form row" method="POST" action="/events/march-to-2020" @submit="isLoading = true">
                {{ csrf_field() }}
                <input class="hidden" value="{{ Auth::id() ?? old('buyer_id') }}" name="buyer_id"/>

                <div class="col-lg-10 col-lg-offset-1">
                    {{--<div class="alert alert-danger sold-out">--}}
                    {{--<div class="row">--}}
                    {{--<div class="col-xs-1 text-center">--}}
                    {{--<i class="material-icons">info</i>--}}
                    {{--</div>--}}
                    {{--<div class="col-xs-11">--}}
                    {{--<h4 class="upper"> This event is sold out.</h4>--}}
                    {{--<p>--}}
                    {{--To be placed on a wait list, please email Roxanne Connelly,--}}
                    {{--<a href="mailto:roxanne@californiatargetbook.com,">roxanne@californiatargetbook.com,</a>--}}
                    {{--with your contact information. If space becomes available, we will contact you.--}}
                    {{--</p>--}}
                    {{--</div>--}}
                    {{--</div>--}}
                    {{--</div>--}}


                    <div class="panel panel-accent p-n">
                        <div class="row m-n event-hero ">
                            <div class="col-md-8 jumbotron text-center mb-n"></div>
                            <div class="col-md-4 event-header">
                                <h5 class="upper text-red mb-lg">
                                    JUN <br/> <span class="h4">10</span>
                                </h5>
                                <h3>The March to 2020</h3>
                                <h5 class="text-light mb-xl">
                                    Sacramento Conference </h5>

                                <h5 class=" text-light">$60</h5>
                            </div>
                        </div>
                        <div class="panel-body p-xl row">

                            <div class="col-sm-6 col-md-8">

                                <h5 class="upper text-red">Description</h5>

                                <p>Expert panel discussions on the Presidential primary, Congressional and legislative targets, and ballot measures.</p>

                                <p class="mb-xl"> Special Featured Keynote Speaker announced soon! </p>

                            </div>

                            <div class="col-sm-6 col-md-4 event-info">

                                <div class="mb-lg">
                                    <h5 class="upper text-red">Location</h5>
                                    <p>
                                        California Chamber of Commerce <br/>
                                        California Room <br/>
                                        1215 K Street, Suite 1400, Sacramento </p>
                                </div>

                                <div class="mb-lg">
                                    <h5 class="upper text-red">Date & Time</h5>
                                    <p>
                                        Monday, June 10, 2019 <br/>
                                        1:00 pm to 4:30 pm </p>
                                </div>

                                <div class="mb-lg">
                                    <h5 class="upper text-red">RSVP Deadline</h5>
                                    <p>Monday, June 4, 2019</p>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h3>Contact Information</h3>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">First Name</label>

                                    <div class="">
                                        <input id="first_name" type="text" class="form-control" name="first_name"
                                                value="{{ old('first_name') ?? Auth::user()->first_name }}" required>
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Last Name</label>

                                    <div class="">
                                        <input id="last_name" type="text" class="form-control" name="last_name"
                                                value="{{ old('last_name') ?? Auth::user()->last_name }}" required>
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('company') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Organization</label>

                                    <div class="">
                                        <input id="company" type="text" class="form-control" name="company"
                                                value="{{ old('company') ?? $profile['company'] }}" required>

                                        @if ($errors->has('company'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('company') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('phone_number') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">Phone Number</label>

                                    <div class="">
                                        <input id="phone_number" type="tel" class="form-control" name="phone_number"
                                                value="{{ old('phone_number') ?? Auth::user()->phone_number }}"
                                                required>

                                        @if ($errors->has('phone_number'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">E-Mail Address</label>

                                    <div class="">
                                        <input id="email" type="email" class="form-control" name="email"
                                                value="{{ old('email') ?? Auth::user()->email }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h3>Tickets</h3>
                                <p class="sub">
                                    Tickets to this event are $60 each.
                                    ***Tickets are not refundable. </p>
                            </div>

                            <div class="col-md-12">

                                <div class="form-group row">

                                    <div class="col-md-12">
                                        <div class="incrementor">
                                            <span class="decrement" @click="decrement()">-</span>
                                            <input type="hidden" name="ticketCount" v-model="ticketCount"/>
                                            <span class="value">@{{ticketCount}}</span>
                                            <span class="increment" @click="increment()">+</span>
                                        </div>

                                        <span class="pull-right">
                                            $@{{ totalCost | currency }}
                                        </span>
                                    </div>

                                    <div class="col-md-12 mt-md" v-if="ticketCount">
                                        <label class="control-label mb-sm">Ticket Holder's</label>

                                        <div v-for="i in ticketCount"
                                                class="mb-sm form-group  {{ $errors->has('ticket_holders.*') ? ' has-error' : '' }}">
                                            <input class="form-control" type="text" v-model="tickets[i-1]"
                                                    name="ticket_holders[]" required placeholder="Ticket Holder Name">

                                            @foreach ($errors->get('ticket_holders.*') as $err)
                                                <span class="help-block">
                                                    <strong>{{ $err }}</strong>
                                                </span>
                                            @endforeach
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h3>Payment</h3>
                            </div>

                            <div class="col-md-12">

                                <div class="form-group select-options row">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="stripe-payment"
                                                v-bind:class="{ selected: paymentMethod === 'stripe' }">
                                            <input name="payment_method" type="radio" id="stripe-payment" value="stripe"
                                                    @if (old('payment_method') == 'stripe') checked @endif
                                                    v-model="paymentMethod"/>
                                            <span class="pl-md">By Credit/Debit Card</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="check-payment"
                                                v-bind:class="{ selected: paymentMethod === 'check' }">
                                            <input name="payment_method" type="radio" id="check-payment" value="check"
                                                    @if(old('payment_method') == 'check') checked @endif
                                                    v-model="paymentMethod"/>
                                            <span class="pl-md">By Check</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('stripe_token') ? ' has-error' : '' }}"
                                        v-if="paymentMethod === 'stripe'">
                                    <stripe-element></stripe-element>
                                    @if ( $errors->has('stripe_token') )
                                        <span class="help-block">
                                        <strong>{{ $errors->first('stripe_token') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group" v-if="paymentMethod === 'check'">
                                    <p>
                                        To pay by check, make the check payable to California Target Book Inc. and mail
                                        to PO Box 5978 Beverly Hills CA 90209. </p>
                                    <p>
                                        Contact Tom Shortridge at <a href="mailto:tom@californiartargetbook.com">tom@californiartargetbook.com</a>
                                        for invoices or questions. </p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h3>Summary</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group"></div>

                                <table class="table table-striped table-lg" v-cloak>
                                    <tbody>
                                    <tr>
                                        <th>
                                            Total
                                        </th>
                                        <td class="text-right">$@{{ totalCost | currency }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="pull-right col-md-4">
                            <button type="submit" class="btn btn-block btn-primary" :disabled="isLoading"
                                    :class="{'is-loading': isLoading}">
                                Purchase
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </ctb-event-signup>
@endsection


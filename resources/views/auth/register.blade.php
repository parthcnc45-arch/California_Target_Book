@extends('layouts.master')
@section('title', 'Register | California Target Book')

@section('content')
    <ctb-register inline-template class="container focused-form" id="register"
            :old-input="{{ json_encode(old()) }}">
        <div class="">
            <div class="col-md-8 col-md-offset-2">

                <form novalidate class="form row" method="POST" id="register-form" action="{{ route('register') }}" @submit="onSubmit($event)">

                    {{ csrf_field() }}

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h2 class="mb-sm mt-n">Subscribe Today</h2>
                            <p class="sub">
                                If you run into any problems, or have more specific needs, please email Tom Shortridge at
                                <a href="mailto:tom@californiatargetbook.com">tom@californiatargetbook.com</a>
                                for help and information. </p>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-xs-12">
                                <h3 class="mt-n">Account Information</h3>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    <label for="name" class="control-label">First Name</label>

                                    <div class="">
                                        <input id="first_name" type="text" class="form-control" name="first_name"
                                                value="{{ old('first_name') }}" required autofocus="autofocus">
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
                                                value="{{ old('last_name') }}" required autofocus>
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 clear">
                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="control-label">E-Mail Address</label>

                                    <div class="">
                                        <input id="email" type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
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
                                                value="{{ old('phone_number') }}" required>

                                        @if ($errors->has('phone_number'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 clear">
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="control-label">Password</label>

                                    <div class="">
                                        <input id="password" type="password" class="form-control" name="password"
                                                required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm" class="control-label">Confirm Password</label>

                                    <div class="">
                                        <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="col-xs-12">
                                <h3 class="mt-n">Organization</h3>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group {{ $errors->has('company') ? ' has-error' : '' }}">
                                            <label for="name" class="control-label">Organization Name</label>

                                            <div class="">
                                                <input id="company" type="text" class="form-control" name="company[name]"
                                                        value="{{ old('company.name') }}" required>

                                                @if ($errors->has('company'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('company') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <ctb-address-block :input="{{ json_encode(old('company.address')) }}" name="company[address]"></ctb-address-block>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <h3 class="mt-n">Have a Coupon?</h3>
                                <p class="sub">If you have a coupon, for the California Target Book, apply it here.</p>
                                <div class="row mb-n">
                                    <div class="col-sm-9">
                                        <input type="text" v-model="couponCode"
                                                @keyup.enter="applyCoupon()"
                                                class="form-control" name="coupon">
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="button"
                                                @click="applyCoupon()"
                                                :disabled="couponLoading"
                                                :class="{'is-loading': couponLoading}"
                                                class="btn btn-primary btn-block">
                                            Apply
                                        </button>
                                    </div>

                                    <div class="col-md-12">
                                        <div v-if="couponInvalid && !couponLoading" class="alert alert-danger clearfix mt-md">
                                            <i class="material-icons pull-left">error_outline</i>
                                            <p class="pull-left ml-md">
                                                That coupon code is not valid.
                                            </p>
                                        </div>

                                        <div v-if="couponValid && !couponLoading" class="alert alert-success clearfix mt-md">
                                            <i class="material-icons pull-left">check_circle</i>
                                            <p class="pull-left ml-md">
                                                Success! Your coupon is valid for a 7 day trial subscription.
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <h3 class="mt-n">Subscription</h3>
                                <div class="form-group select-options row {{ $errors->has('subscription_length') ? ' has-error' : '' }}">
                                    <div v-if="couponValid" class="col-sm-12">
                                        <label class="control-label" for="trial"
                                                :class="{ selected: subLength === '0' }">
                                            <input class="pull-left" name="subscription_length" type="radio" id="trial"
                                                    value="0"
                                                    @if( old('subscription_length') === '0') checked @endif
                                                    v-model="subLength"/>

                                            <span class="pl-md">
                                                7 Day Trial
                                                <span class="pull-right">
                                                    Free
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label" for="1yr"
                                                :class="{ selected: subLength === '12' }">
                                            <input class="pull-left" name="subscription_length" type="radio" id="1yr"
                                                    value="12"
                                                    @if( old('subscription_length') == '12') checked @endif
                                                    v-model="subLength"/>

                                            <span class="pl-md">
                                                12 Month Subscription
                                                <span class="pull-right">
                                                    $@{{ pricing['12'].base | currency }}
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label" for="2yr"
                                                v-bind:class="{ selected: subLength === '24' }">
                                            <input class="pull-left" name="subscription_length" type="radio" id="2yr"
                                                    value="24"
                                                    @if(old('subscription_length') == '24') checked @endif
                                                    v-model="subLength"/>
                                            <span class="pl-md">
                                                24 Month Subscription
                                                <span class="pull-right">
                                                    $@{{ pricing['24'].base | currency }}
                                                </span>
                                            </span>
                                        </label>
                                    </div>

                                    @if ($errors->has('subscription_length'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('subscription_length') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group row" v-if="!isTrial">
                                    <div class="col-md-12">
                                        <h4>Books</h4>
                                        <p class="sub">
                                            Hard Copy Subscription: You will be mailed the hard copy of the California
                                            Target Book. New editions are made every March, June, and November in even
                                            years, and every June and December in odd years. </p>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="incrementor">
                                            <span class="decrement" @click="decrementBooks()">-</span>
                                            <input type="hidden" name="bookCount" v-model="bookCount"/>
                                            <span class="value">@{{bookCount}}</span>
                                            <span class="increment" @click="incrementBooks()">+</span>
                                        </div>

                                        <span class="pull-right">
                                            $@{{ bookTotalCost | currency }}
                                        </span>
                                    </div>


                                    <div class="col-md-12 mt-md" v-if="bookCount">

                                        <div v-for="(address, i) in bookAddresses"
                                                class="mb-sm form-group-sm address-block row">
                                            <label class="control-label mb-sm block">Mailing Address @{{i + 1}}</label>

                                            <ctb-address-block
                                                    :input="address"
                                                    :name="'book_addresses[' + i + ']'">
                                            </ctb-address-block>

                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row" v-if="!isTrial">
                                    <div class="col-md-12">
                                        <h4>Add On Accounts</h4>
                                        <p class="sub">
                                            Add on accounts for $100/year. Add their emails below and we will send them
                                            an invitation to register under this account. </p>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="incrementor">
                                            <span class="decrement" @click="decrementAddons()">-</span>
                                            <input type="hidden" name="addonCount" v-model="addonCount"/>
                                            <span class="value">@{{addonCount}}</span>
                                            <span class="increment" @click="incrementAddons()">+</span>
                                        </div>

                                        <span class="pull-right">
                                        $@{{ addonTotalCost | currency }}
                                    </span>
                                    </div>

                                    <div class="col-md-12 mt-md" v-if="addonCount">
                                        <label class="control-label mb-sm">E-mail Addresses</label>

                                        <div v-for="i in addonCount"
                                                class="mb-sm form-group  {{ $errors->has('addons.*') ? ' has-error' : '' }}">
                                            <input class="form-control addon" type="email" v-model="addons[i-1]"
                                                    @input="edit(i-1, $event)" name="addons[]" required
                                                    :placeholder="'Addon Email #' + i">

                                            @foreach ($errors->get('addons.*') as $addonError)
                                                <span class="help-block">
                                                <strong>{{ $addonError }}</strong>
                                            </span>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default" v-if="!isTrial">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <h3 class="mt-n">Payment</h3>

                                <ctb-payment-block
                                        @if($errors->has('stripe_token'))
                                        :errors="{ 'stripe_token': '{{ addslashes($errors->first('stripe_token')) }}' }"
                                        @endif
                                        payment-method="{{ old('payment_method') }}">
                                </ctb-payment-block>

                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h3 class="mt-n">Summary</h3>

                                    <table class="table table-striped table-lg" v-cloak>
                                        <tbody>
                                        <tr>
                                            <th v-if="isTrial">
                                                7 Day Trial Subscription
                                            </th>
                                            <th v-if="!isTrial">
                                                @{{ subLength }} Month Subscription
                                            </th>
                                            <td class="text-right">$@{{ baseCost | currency }}</td>
                                        </tr>
                                        <tr v-if="bookCount">
                                            <th>
                                                @{{ bookCount }} Hard Copy Subscriptions
                                            </th>
                                            <td class="text-right">$@{{ bookTotalCost | currency }}</td>
                                        </tr>
                                        <tr v-if="addonCount">
                                            <th>
                                                @{{ addonCount }} Add On Accounts
                                            </th>
                                            <td class="text-right">$@{{ addonTotalCost | currency }}</td>
                                        </tr>
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


                            <div class="form-group">
                                <div class="pull-right col-md-4">
                                    <button type="submit" class="btn btn-block btn-primary" :disabled="isLoading"
                                            :class="{'is-loading': isLoading}">
                                        Subscribe
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </ctb-register>
@endsection

@section('scripts-dependencies')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBH018pbcVij9pf5O0p-fkMI457nBV-keQ&libraries=places"></script>
@endsection

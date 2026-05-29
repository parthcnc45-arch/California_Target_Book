@extends('layouts.master')

@section('title', 'Renew Your Subscription | California Target Book')

@section('content')
    <ctb-renew inline-template
            :cur-subscription="{{ json_encode($subscription)  }}"
            :cur-payment-method="'{{ $currentPaymentMethod }}'"
            :_cur-addons="{{ json_encode($addons) }}"
            :_cur-book-subscriptions="{{ json_encode($bookSubscriptions) }}"
            :card="{{ json_encode($card) }}"
            :old-input="{{ json_encode(old()) }}">

        <div class="container focused-form">
            <div class="row">
                <div class="col-sm-8 center-block fn">
                    <form class="form row" method="POST" action="{{ route('auth.account.renew') }}" @submit="isLoading = true">

                        {{ csrf_field() }}

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <h2 class="mb-sm mt-n">Renew Today</h2>
                                <p class="sub">
                                    Your current California Target Book subscription ends on
                                    <b>{{ $cycle_end }}</b>.
                                    Renew now before you lose access.
                                </p>
                                <p class="sub">
                                    If you run into any problems, or have more specific needs, please email Tom Shortridge at
                                    <a href="mailto:tom@californiatargetbook.com">tom@californiatargetbook.com</a>
                                    for help and information. </p>
                                </p>
                            </div>
                        </div>

                        <div class="current-subscription panel panel-default">
                            <div class="panel-body">


                                <div class="row">
                                    <div class="col-md-12">
                                        <h3 class="mt-n">Your Subscription</h3>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="upper text-red">Account</h4>
                                        <table class="table">
                                            <tr>
                                                <th>Name</th>
                                                <td>{{ $user->name() }}</td>
                                            </tr>
                                            <tr>
                                                <th>Organization</th>
                                                <td>{{ $user->company()->first()->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Current Payment</th>
                                                @if ($card)
                                                    <td>{{ $card->brand }} {{ $card->last4 }} {{ $card->expMonth }}/{{ $card->expYear }}</td>
                                                @else
                                                    <td><i>N/A</i></td>
                                                @endif
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="upper text-red">Subscription</h4>
                                        <div class="select-options row">

                                            <div class="col-sm-12">
                                                <label class="control-label" for="1yr" :class="{ selected: subLength === '12' }">
                                                    <input class="pull-left" name="subscription_length" type="radio" id="1yr"
                                                            value="12" v-model="subLength"/>

                                                    <span class="pl-md">
                                                12 Month Subscription
                                                <span class="pull-right">$@{{ pricing['12'].base | currency }}</span>
                                            </span>
                                                </label>
                                            </div>
                                            <div class="col-sm-12">
                                                <label class="control-label" for="2yr" :class="{ selected: subLength === '24' }">
                                                    <input class="pull-left" name="subscription_length" type="radio" id="2yr"
                                                            value="24" v-model="subLength"/>
                                                    <span class="pl-md">
                                                        24 Month Subscription
                                                        <span class="pull-right"> $@{{ pricing['24'].base | currency }} </span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="upper text-red">Hard Copy Subscriptions</h4>
                                        <p class="sub">Hard Copy Subscription: You will be mailed the hard copy of the California
                                            Target Book. New editions are made every March, June, and November in even
                                            years, and every June and December in odd years. </p>

                                        <p v-if="_curBookSubscriptions.length" class="sub">
                                            If you have hard copy subscriptions already listed below, you can leave them and they will renew, or you can remove them by clicking the "X".
                                        </p>

                                        <table v-if="curBookSubscriptions.length" class="table table-striped">
                                            <tbody>
                                                <tr v-for="book in curBookSubscriptions">
                                                    <td v-html="$options.filters.address(book.address)"></td>
                                                    <td class="text-right">
                                                        <a @click="removeOldSubscription(book.id)">
                                                            <i class="material-icons text-red">clear</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <input type="hidden"
                                                :value="bookSubscriptionsToRemoveValue"
                                                name="book_subscriptions_to_remove"/>

                                        <div class="mt-md">

                                            <div v-for="(address, i) in bookAddresses"
                                                    class="mb-sm form-group-sm well clearfix">
                                                <label class="control-label mb-sm block">
                                                    Mailing Address @{{i + 1}}
                                                    <a @click="bookAddresses.splice(i,1)" class="pull-right">
                                                        <i class="material-icons text-red">clear</i>
                                                    </a>
                                                </label>

                                                <ctb-address-block
                                                        :input="address"
                                                        :name="'book_address[' + i + ']'">
                                                </ctb-address-block>

                                            </div>

                                            <a class="addLink" @click="addBook()">
                                                <i class="material-icons">add</i>
                                                Add Hard Copy Subscription
                                            </a>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="upper text-red">Addons</h4>
                                        <p class="sub">
                                            Add on accounts for $100/year. Add their emails below and we will send them
                                            an invitation to register under this account.
                                        </p>

                                        <p v-if="_curAddons.length" class="sub">
                                            If you have addon accounts already listed below, you can leave them and they will renew, or you can remove them by clicking the "X".
                                        </p>

                                        <table v-if="curAddons.length" class="table table-striped">
                                            <tbody>
                                            <tr v-for="addon in curAddons">
                                                <td>
                                                    <span v-if="addon.first_name">
                                                        @{{ addon.first_name }} @{{ addon.last_name }} <br/>
                                                    </span>
                                                    @{{ addon.email }}
                                                </td>
                                                <td class="text-right">
                                                    <a @click="removeOldAddon(addon.id)">
                                                        <i class="material-icons text-red">clear</i>
                                                    </a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>

                                        <input type="hidden"
                                                :value="addonsToRemoveValue"
                                                name="addons_to_remove"/>

                                        <div v-if="addons.length" class="mt-md">
                                            <label class="control-label mb-sm">E-mail Addresses</label>

                                            <div v-for="(addon, i) in addons"
                                                    class="mb-sm form-group addon-block {{ $errors->has('addons.*') ? ' has-error' : '' }}">

                                                <input type="hidden" :value="addon.id" :name="'addons['+i+'][id]'" />
                                                <div>
                                                    <input class="form-control addon"
                                                            type="email"
                                                            v-model="addons[i].email"
                                                            :name="'addons['+i+'][email]'"
                                                            required
                                                            :placeholder="'Addon Email #' + (i + 1)">

                                                    <a @click="addons.splice(i,1)" class="remove-addon">
                                                        <i class="material-icons text-red">clear</i>
                                                    </a>
                                                </div>
                                                @foreach ($errors->get('addons.*') as $addonError)
                                                    <span class="help-block">
                                                        <strong>{{ $addonError }}</strong>
                                                    </span>
                                                @endforeach
                                            </div>

                                        </div>

                                        <a class="addLink" @click="addAddon()">
                                            <i class="material-icons">add</i>
                                            Add Add-on Account
                                        </a>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="upper text-red">Payment</h4>

                                        <ctb-payment-block
                                                @if($errors->has('stripe_token'))
                                                :errors="{ 'stripe_token': '{{ addslashes($errors->first('stripe_token')) }}' }"
                                                @endif
                                                payment-method="{{ old('payment_method') }}">
                                        </ctb-payment-block>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="upper text-red">Summary</h4>
                                        <table class="table table-striped table-lg" v-cloak>
                                            <tbody>
                                            <tr>
                                                <th>
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


                                <div class="row">
                                    <div class="form-group">
                                        <div class="pull-right col-md-4">
                                            <button type="submit" class="btn btn-block btn-primary"
                                                    :disabled="isLoading"
                                                    :class="{'is-loading': isLoading}">
                                                Renew Subscription
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>

    </ctb-renew>
@endsection

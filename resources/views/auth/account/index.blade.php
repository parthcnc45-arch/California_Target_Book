@extends('layouts.master')

@section('title', 'Your Account | California Target Book')

@section('content')
<div class="container focused-form">
    <div class="row">
        <div class="col-sm-8 center-block fn">

          @if($pending_bank)
            <div class="alert alert-info">
              <div class="row">
                <div class="col-xs-1 text-center">
                  <i class="material-icons">account_balance</i>
                </div>
                <div class="col-xs-11">
                  <h4 class="upper">Pending Bank Account</h4>
                  <p>
                    Your bank account is still awaiting verification.
                    Check your bank account for 2 small deposits (under $1.00) and click the button below.
                  </p>
                  <p>
                    Account Holder: {{ $pending_bank->account_holder_name }}
                    <br/>
                    Routing Number: {{ $pending_bank->routing_number }}
                    <br/>
                    Account Number: XXXXXX{{ $pending_bank->last4 }}
                  </p>

                  <button class="pull-right btn btn-primary"  @click="showVerifyBankModal = true">Verify Bank</button>
                  <verify-bank-modal v-if="showVerifyBankModal" @close="showVerifyBankModal = false"></verify-bank-modal>
                </div>
              </div>
            </div>
          @endif

          <div class="panel panel-default p-n">
            <div class="panel-heading p-md">
              <h2>Account</h2>
            </div>
            <div class="panel-body">

              <table class="table mb-n">
                <tr>
                  <th>Name</th>
                  <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                </tr>
                <tr>
                  <th>Email</th>
                  <td>{{ $user->email }}</td>
                </tr>
                <tr>
                  <th>Password</th>
                  <td>
                    ******
                    <a class="pull-right" @click="showChangePasswordModal = true">Change</a>
                    <change-password-modal v-if="showChangePasswordModal"
                        @close="showChangePasswordModal = false">
                    </change-password-modal>
                  </td>
                </tr>
                <tr>
                  <th>Company</th>
                  <td>{{ $user->company->name }}</td>
                </tr>
              </table>

            </div>
          </div>
            <div class="panel panel-default p-n">
              <div class="panel-heading p-md clearfix">
                <div class="pull-left">
                  <h2>Subscription</h2>
                </div>


                  @if($sub['role'] === 'subscriber' && !empty($invoice))
                  <div class="pull-right">
                    <a @click="showInvoiceModal = true">See Invoice</a>
                    <invoice-modal v-if="showInvoiceModal"
                        :invoice="{{ json_encode($sub['invoice']) }}"
                        @close="showInvoiceModal = false">
                    </invoice-modal>
                  </div>
                  @endif
              </div>

              <div class="panel-body">
                  <table class="table m-n">
                    <tr>
                      <th>Subscription Status</th>
                      <td class="capitalize">{{ $sub['status'] }}</td>
                    </tr>
                    <tr>
                      <th>Started On</th>
                      <td>{{ $sub['start'] }}</td>
                    </tr>
                    <tr>
                      <th>Expires On</th>
                      <td>{{ $sub['end'] }}</td>
                    </tr>

                    @if($sub['role'] === 'addon' && !empty($sub['base_account']))
                      <tr>
                      <th>Base Account</th>
                      <td>
                        {{ $sub['base_account']->first_name }} {{ $sub['base_account']->last_name }} <br/>
                        <a class="red" href="mailto:{{ $sub['base_account']->email }}">{{ $sub['base_account']->email }}</a>
                      </td>
                      </tr>
                    @endif

                    @if($sub['role'] === 'subscriber' )

                      <tr>
                        <th>Hard Copy Subscriptions</th>
                        <td>
                          @if(count($sub['books']))
                            @foreach($sub['books'] as $book)

                              <div class="address">
                                <p>{{ $book->address->line1 }}</p>
                                <p>{{ $book->address->line2 }}</p>
                                <p>
                                  {{ $book->address->city }},
                                  {{ $book->address->state }}
                                  {{ $book->address->zip_code }}
                                </p>
                                <p>
                                  <b>Instructions:</b>
                                  {{ $book->address->special_instructions ?? 'N/A' }}
                                </p>
                              </div>

                              @if (!$loop->last)
                                <hr class="m0 mt-sm mb-sm"/>
                              @endif
                            @endforeach
                          @else
                            <i>No Hard Copy Subscriptions</i>
                          @endif
                        </td>
                      </tr>

                      <tr>
                        <th>Addon Accounts</th>
                        <td>
                          @if(count($sub['addons']))
                            @foreach($sub['addons'] as $acct)
                              {{ $acct->first_name }} {{ $acct->last_name }} <br/>
                              <a class="red" href="mailto:{{ $acct->email }}">{{ $acct->email }}</a>
                              @if (!$loop->last)
                                <hr class="m0 mt-sm mb-sm"/>
                              @endif
                            @endforeach
                          @else
                            <i>No Addon Accounts</i>
                          @endif
                        </td>
                      </tr>
                    @endif

                  </table>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

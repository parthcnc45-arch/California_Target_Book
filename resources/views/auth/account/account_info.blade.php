@extends('layouts.portal')

@section('portal_content')
    @if($pending_bank)
        <div class="alert alert-info border-0 rounded-3 mb-4 p-4 shadow-sm" style="background-color: #e0f2fe; color: #0369a1;">
            <div class="d-flex" style="display: flex;">
                <i class="bi bi-bank me-3" style="font-size: 24px; margin-right: 16px;"></i>
                <div class="w-100">
                    <h4 class="fw-bold mb-2" style="font-size: 15px; font-weight: 700; margin-top: 0; margin-bottom: 8px;">Pending Bank Account</h4>
                    <p class="mb-3" style="font-size: 13.5px; margin-bottom: 12px;">
                        Your bank account is still awaiting verification. 
                        Check your bank account for 2 small deposits (under $1.00) and click the button below to verify.
                    </p>
                    <p class="mb-3 font-monospace" style="font-size: 12px; line-height: 1.6; font-family: monospace; margin-bottom: 12px;">
                        Account Holder: {{ $pending_bank->account_holder_name }}<br>
                        Routing Number: {{ $pending_bank->routing_number }}<br>
                        Account Number: XXXXXX{{ $pending_bank->last4 }}
                    </p>
                    <button class="btn btn-primary btn-sm px-3" @click="showVerifyBankModal = true" style="border-radius: 6px;">Verify Bank</button>
                </div>
            </div>
        </div>
    @endif

    <section id="section-account-info" class="portal-section active">
        <header class="section-header">
            <div class="header-avatar">
                {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
            </div>
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Account Info</h1>
                    <span class="status-pill active-status">Active</span>
                </div>
                <p class="header-subtitle">Manage your profile and login details.</p>
            </div>
        </header>

        <account-info-form
            :initial-user="{{ json_encode($user) }}"
            :initial-company="{{ json_encode($user->company) }}"
            :initial-billing-address="{{ json_encode($user->company ? $user->company->address : null) }}"
            :initial-shipping-address="{{ json_encode(count($sub['books']) ? $sub['books'][0]->address : null) }}"
            :has-subscription="{{ count($sub['books']) ? 'true' : 'false' }}">
        </account-info-form>
    </section>
@endsection

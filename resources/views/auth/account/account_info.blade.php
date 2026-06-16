@extends('layouts.portal')

@section('portal_content')
    @if($pending_bank)
        <div class="alert alert-info border-0 rounded-3 mb-4 p-4 shadow-sm bank-pending-alert">
            <div class="d-flex">
                <i class="bi bi-bank me-3 bank-pending-icon"></i>
                <div class="w-100">
                    <h4 class="fw-bold mb-2 bank-pending-title">Pending Bank Account</h4>
                    <p class="mb-3 bank-pending-text">
                        Your bank account is still awaiting verification. 
                        Check your bank account for 2 small deposits (under $1.00) and click the button below to verify.
                    </p>
                    <p class="mb-3 font-monospace bank-pending-details">
                        Account Holder: {{ $pending_bank->account_holder_name }}<br>
                        Routing Number: {{ $pending_bank->routing_number }}<br>
                        Account Number: XXXXXX{{ $pending_bank->last4 }}
                    </p>
                    <button class="btn btn-primary btn-sm px-3 btn-verify-bank" @click="showVerifyBankModal = true">Verify Bank</button>
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
            :initial-shipping-addresses="{{ json_encode($sub['books']) }}"
            :has-subscription="{{ count($sub['books']) ? 'true' : 'false' }}">
        </account-info-form>
    </section>
@endsection

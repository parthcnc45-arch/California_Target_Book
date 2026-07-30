@extends('layouts.portal')

@section('portal_content')
    <section id="section-account-info" class="portal-section active">
        <header class="section-header">
            <div class="header-avatar">
                {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
            </div>
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Account Info</h1>
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

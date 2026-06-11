@extends('layouts.master_headless')

@section('title', 'Your Account | California Target Book')

@section('styles')
<!-- Google Fonts - Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary-color: #d93838; /* Branding Red */
        --primary-light: #fdf2f2;
        --border-color: #e2e8ee;
        --bg-light: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --sidebar-width: 240px;
    }

    body {
        background-color: var(--bg-light) !important;
        color: var(--text-dark);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    #app {
        display: flex;
        min-height: 100vh;
        width: 100%;
        background-color: var(--bg-light);
    }

    /* Account Portal Layout */
    .account-portal {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* Portal Left Sidebar */
    .portal-sidebar {
        width: var(--sidebar-width);
        background: #ffffff;
        border-right: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        padding: 24px 16px;
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        z-index: 100;
        box-sizing: border-box;
    }

    .sidebar-brand {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        padding-left: 8px;
    }

    .brand-text {
        display: flex;
        flex-direction: column;
    }

    .brand-line1 {
        font-weight: 800;
        font-size: 12.5px;
        color: #0f172a;
        line-height: 1.1;
    }

    .brand-line2 {
        font-weight: 500;
        font-size: 11.5px;
        color: #475569;
        line-height: 1.1;
    }

    .sidebar-profile {
        display: flex;
        align-items: center;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 20px;
        padding-left: 8px;
    }

    .profile-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: var(--primary-color);
        color: #ffffff;
        font-weight: 700;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .profile-info {
        min-width: 0;
    }

    .profile-name {
        font-weight: 700;
        font-size: 12.5px;
        color: #0f172a;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-transform: uppercase;
    }

    .profile-email {
        font-size: 11px;
        color: var(--text-muted);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 1px;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 2px;
        flex: 1;
    }

    .nav-section-title {
        font-size: 10px;
        font-weight: 800;
        color: #94a3b8;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        margin-top: 10px;
        padding-left: 12px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        color: #475569;
        font-size: 13px;
        font-weight: 500;
        border-radius: 6px;
        text-decoration: none !important;
        transition: all 0.15s;
    }

    .nav-link i {
        font-size: 15px;
        margin-right: 12px;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .nav-link:hover {
        background-color: #f1f5f9;
        color: var(--primary-color);
    }

    .nav-link:hover i {
        color: var(--primary-color);
    }

    .nav-link.active {
        background-color: var(--primary-light);
        color: var(--primary-color);
        font-weight: 600;
        border-left: 3px solid var(--primary-color);
        border-radius: 0 6px 6px 0;
        padding-left: 9px;
    }

    .nav-link.active i {
        color: var(--primary-color);
    }

    .sidebar-actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        border-top: 1px solid var(--border-color);
        padding-top: 16px;
        margin-top: auto;
    }

    .btn-open-app {
        border: 1px solid var(--border-color);
        background-color: #ffffff;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        padding: 8px 12px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none !important;
        transition: all 0.2s;
    }

    .btn-open-app:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }

    .signout-link {
        padding: 6px 12px;
        color: #ef4444;
    }
    .signout-link:hover {
        background-color: #fef2f2;
        color: #dc2626;
    }

    /* Portal Main Content */
    .portal-main {
        flex: 1;
        margin-left: var(--sidebar-width);
        padding: 32px 40px;
        min-width: 0;
        box-sizing: border-box;
    }

    .portal-main .container-fluid {
        padding: 0;
    }

    .portal-section {
        display: none;
    }

    @media (min-width: 1600px) {
        .col-xl-custom {
            width: 58.33333333% !important;
            float: left;
        }
    }

    .portal-section.active {
        display: block;
    }

    .section-header {
        display: flex;
        align-items: center;
        margin-bottom: 24px;
    }

    .header-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background-color: #f97316; /* Orange avatar background */
        color: #ffffff;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .bg-blue-avatar {
        background-color: #2563eb !important;
    }

    .header-title-container {
        display: flex;
        align-items: center;
    }

    .header-title {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .header-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 2px;
        margin-bottom: 0;
    }

    .status-pill {
        padding: 2px 8px;
        font-size: 10px;
        font-weight: 600;
        border-radius: 12px;
        margin-left: 8px;
        display: inline-block;
    }

    .active-status {
        background-color: #e6f4ea;
        color: #137333;
    }

    /* Card Details */
    .portal-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        margin-top: 16px;
        width: 100%;
        box-sizing: border-box;
    }

    .card-header-custom {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-title-custom {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    .btn-edit-profile {
        background: none;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        transition: all 0.15s;
    }

    .btn-edit-profile:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }

    .card-body-custom {
        padding: 0;
        overflow-x: auto;
    }

    .account-info-card {
        width: 100%;
        max-width: 800px;
        box-sizing: border-box;
    }

    .info-table {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }

    .info-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        box-sizing: border-box;
    }

    .info-table tr:last-child td {
        border-bottom: none;
    }

    .info-label {
        width: 35%;
        font-weight: 500;
        color: var(--text-muted);
        font-size: 13px;
        box-sizing: border-box;
    }

    .info-value {
        width: 65%;
        font-weight: 500;
        color: #0f172a;
        font-size: 13px;
        box-sizing: border-box;
        word-break: normal;
        overflow-wrap: normal;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .info-value-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .btn-change-password {
        color: var(--primary-color) !important;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none !important;
        margin-left: 12px;
        transition: color 0.15s;
    }

    .btn-change-password:hover {
        color: #b91c1c !important;
    }
</style>
@endsection

@section('content')
<div class="account-portal">
    <!-- Left Sidebar -->
    <aside class="portal-sidebar">
        <div class="sidebar-brand">
            <img src="/img/ctb_logo.png" alt="California Target Book Logo" class="brand-logo">
            <div class="brand-text">
                <div class="brand-line1">California</div>
                <div class="brand-line2">Target Book</div>
            </div>
        </div>
        
        <div class="sidebar-profile">
            <div class="profile-avatar">
                {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
            </div>
            <div class="profile-info">
                <div class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                <div class="profile-email">{{ $user->email }}</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">MY ACCOUNT</div>
            <a href="/" class="nav-link"><i class="bi bi-house-door"></i> Home</a>
            <a href="#account-info" class="nav-link active" id="tab-account-info"><i class="bi bi-person"></i> Account info</a>
            <a href="#subscriptions" class="nav-link" id="tab-subscriptions"><i class="bi bi-credit-card-2-front"></i> Subscriptions</a>
            <a href="#transaction-history" class="nav-link" id="tab-transaction-history"><i class="bi bi-coin"></i> Transaction History</a>
            <a href="#shipping-tracking" class="nav-link" id="tab-shipping-tracking"><i class="bi bi-truck"></i> Shipping & Tracking</a>
            <a href="#settings" class="nav-link" id="tab-settings"><i class="bi bi-gear"></i> Settings</a>
            <a href="#help-support" class="nav-link" id="tab-help-support"><i class="bi bi-question-circle"></i> Help & Support</a>
        </nav>

        <div class="sidebar-actions">
            <a href="https://app.californiatargetbook.com" class="btn btn-open-app w-100">
                <span>Open Book App</span>
                <i class="bi bi-box-arrow-up-right"></i>
            </a>
            <a href="/logout" class="nav-link signout-link"><i class="bi bi-box-arrow-left"></i> Sign Out</a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="portal-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-lg-8 col-xl-custom">
        
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

        <!-- Account Info Section -->
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

            <div class="portal-card account-info-card">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Account Information</h2>
                    <button class="btn-edit-profile" onclick="alert('Profile editing is not available. Please contact support to change your name or company.')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
                <div class="card-body-custom">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td class="info-label">Full Name</td>
                                <td class="info-value">{{ $user->first_name }} {{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Email Address</td>
                                <td class="info-value">{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Password</td>
                                <td class="info-value">
                                    <div class="info-value-flex">
                                        <span>••••••••</span>
                                        <a href="javascript:void(0)" @click="showChangePasswordModal = true" class="btn-change-password">Change Password</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="info-label">Company Name</td>
                                <td class="info-value">{{ $user->company->name }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Phone Number</td>
                                <td class="info-value">{{ $user->phone_number ?? '(916) 555-0142' }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Billing Address</td>
                                <td class="info-value">
                                    @if($user->company && $user->company->address)
                                        {{ $user->company->address->line1 }}{{ $user->company->address->line2 ? ', ' . $user->company->address->line2 : '' }}, {{ $user->company->address->city }}, {{ $user->company->address->state }} {{ $user->company->address->zip_code }}
                                    @else
                                        1215 K Street, Suite 1150, Sacramento, CA, 95814
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="info-label">Shipping Address</td>
                                <td class="info-value">
                                    @if(count($sub['books']))
                                        {{ $sub['books'][0]->address->line1 }}{{ $sub['books'][0]->address->line2 ? ', ' . $sub['books'][0]->address->line2 : '' }}, {{ $sub['books'][0]->address->city }}, {{ $sub['books'][0]->address->state }} {{ $sub['books'][0]->address->zip_code }}
                                    @elseif($user->company && $user->company->address)
                                        {{ $user->company->address->line1 }}{{ $user->company->address->line2 ? ', ' . $user->company->address->line2 : '' }}, {{ $user->company->address->city }}, {{ $user->company->address->state }} {{ $user->company->address->zip_code }}
                                    @else
                                        1215 K Street, Suite 1150, Sacramento, CA, 95814
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Subscriptions Section -->
        <section id="section-subscriptions" class="portal-section">
            <header class="section-header">
                <div class="header-avatar bg-blue-avatar">
                    <i class="bi bi-credit-card-2-front text-white" style="font-size: 18px; display: flex; align-items: center; justify-content: center; height: 100%;"></i>
                </div>
                <div>
                    <div class="header-title-container">
                        <h1 class="header-title">Subscriptions</h1>
                        <span class="status-pill active-status capitalize">{{ $sub['status'] }}</span>
                    </div>
                    <p class="header-subtitle">Manage your payment methods, hard copies, and addon accounts.</p>
                </div>
            </header>

            <div class="portal-card account-info-card">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Subscription Status</h2>
                    @if($sub['role'] === 'subscriber' && !empty($invoice))
                        <button class="btn-edit-profile" @click="showInvoiceModal = true" style="border-radius: 6px;">
                            <i class="bi bi-receipt"></i> See Invoice
                        </button>
                    @endif
                </div>
                <div class="card-body-custom">
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td class="info-label">Subscription Status</td>
                                <td class="info-value capitalize fw-semibold text-success">{{ $sub['status'] }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Started On</td>
                                <td class="info-value">{{ $sub['start'] }}</td>
                            </tr>
                            <tr>
                                <td class="info-label">Expires On</td>
                                <td class="info-value">{{ $sub['end'] }}</td>
                            </tr>

                            @if($sub['role'] === 'addon' && !empty($sub['base_account']))
                                <tr>
                                    <td class="info-label">Base Account Owner</td>
                                    <td class="info-value" style="white-space: normal;">
                                        {{ $sub['base_account']->first_name }} {{ $sub['base_account']->last_name }} <br>
                                        <a class="text-danger fw-semibold" href="mailto:{{ $sub['base_account']->email }}">{{ $sub['base_account']->email }}</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            @if($sub['role'] === 'subscriber')
                <!-- Hard Copy Subscriptions Card -->
                <div class="portal-card mt-4" style="margin-top: 24px;">
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Hard Copy Subscriptions</h2>
                    </div>
                    <div class="card-body-custom" style="padding: 16px 20px;">
                        @if(count($sub['books']))
                            @foreach($sub['books'] as $book)
                                <div class="hardcopy-item p-3 mb-3 border rounded shadow-sm" style="padding: 16px; margin-bottom: 16px;">
                                    <div class="fw-bold mb-1" style="font-weight: 700; margin-bottom: 4px;">{{ $book->address->line1 }}</div>
                                    @if($book->address->line2)
                                        <div class="mb-1" style="margin-bottom: 4px;">{{ $book->address->line2 }}</div>
                                    @endif
                                    <div class="text-muted">{{ $book->address->city }}, {{ $book->address->state }} {{ $book->address->zip_code }}</div>
                                    <div class="text-secondary mt-2 pt-2 border-top small" style="margin-top: 12px; padding-top: 12px; border-top: 1px solid #f1f5f9; font-size: 12px; color: #64748b;">
                                        <strong>Delivery Instructions:</strong> {{ $book->address->special_instructions ?? 'None' }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted" style="text-align: center; padding: 32px 0;">
                                <i class="bi bi-book-half" style="font-size: 36px; display: block; margin-bottom: 12px; color: var(--text-muted);"></i>
                                <span>No Hard Copy Subscriptions active.</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Addon Accounts Card -->
                <div class="portal-card mt-4" style="margin-top: 24px;">
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Addon Accounts</h2>
                    </div>
                    <div class="card-body-custom" style="padding: 16px 20px;">
                        @if(count($sub['addons']))
                            @foreach($sub['addons'] as $acct)
                                <div class="addon-item d-flex justify-content-between align-items-center p-3 mb-3 border rounded shadow-sm" style="display: flex; align-items: center; justify-content: space-between; padding: 16px; margin-bottom: 16px;">
                                    <div>
                                        <div class="fw-bold" style="font-weight: 700;">{{ $acct->first_name }} {{ $acct->last_name }}</div>
                                        <a href="mailto:{{ $acct->email }}" class="text-secondary small" style="font-size: 12.5px; color: #64748b; text-decoration: none;">{{ $acct->email }}</a>
                                    </div>
                                    <span class="badge bg-success" style="font-size: 11px; padding: 4px 8px; background-color: #22c55e; color: white; border-radius: 4px;">Addon Member</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5 text-muted" style="text-align: center; padding: 32px 0;">
                                <i class="bi bi-people" style="font-size: 36px; display: block; margin-bottom: 12px; color: var(--text-muted);"></i>
                                <span>No Addon Accounts registered.</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </section>

        <!-- Transaction History Section -->
        <section id="section-transaction-history" class="portal-section">
            <header class="section-header">
                <div class="header-avatar" style="background-color: #0d9488; color: #ffffff; font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; text-transform: uppercase; margin-right: 12px; flex-shrink: 0;">
                    <i class="bi bi-coin" style="font-size: 18px; display: flex; align-items: center; justify-content: center;"></i>
                </div>
                <div>
                    <div class="header-title-container">
                        <h1 class="header-title">Transaction History</h1>
                    </div>
                    <p class="header-subtitle">View your past billing cycles, payments, and receipts.</p>
                </div>
            </header>

            <div class="portal-card account-info-card">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Billing & Payment History</h2>
                </div>
                <div class="card-body-custom">
                    @if(count($cycles))
                        <table class="info-table">
                            <thead>
                                <tr style="background-color: #f8fafc; border-bottom: 1px solid var(--border-color);">
                                    <th style="padding: 14px 20px; text-align: left; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; width: 30%;">Period</th>
                                    <th style="padding: 14px 20px; text-align: left; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; width: 25%;">Payment Method</th>
                                    <th style="padding: 14px 20px; text-align: left; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; width: 25%;">Invoice Status</th>
                                    <th style="padding: 14px 20px; text-align: right; font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; width: 20%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cycles as $c)
                                    <tr>
                                        <td class="info-value" style="width: 30%; white-space: nowrap;">
                                            {{ \Carbon\Carbon::parse($c->starts_on)->toFormattedDateString() }} - {{ \Carbon\Carbon::parse($c->ends_on)->toFormattedDateString() }}
                                        </td>
                                        <td class="info-value capitalize" style="width: 25%; white-space: nowrap;">
                                            {{ $c->payment_method }}
                                        </td>
                                        <td class="info-value" style="width: 25%; white-space: nowrap;">
                                            @if($c->isPending())
                                                <span class="badge" style="background-color: #eab308; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px;">Pending</span>
                                            @else
                                                <span class="badge" style="background-color: #22c55e; color: white; padding: 2px 8px; border-radius: 4px; font-size: 11px;">Paid</span>
                                            @endif
                                        </td>
                                        <td style="padding: 14px 20px; text-align: right; width: 20%; box-sizing: border-box;">
                                            @if($c->invoice_id)
                                                <a href="javascript:void(0)" @click="showInvoiceModal = true" class="text-danger fw-semibold" style="font-size: 12px; color: var(--primary-color); text-decoration: none;">View Invoice</a>
                                            @else
                                                <span class="text-muted" style="font-size: 12px;">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-5 text-muted" style="text-align: center; padding: 48px 0;">
                            <i class="bi bi-receipt-cutoff" style="font-size: 36px; display: block; margin-bottom: 12px; color: var(--text-muted);"></i>
                            <span>No transaction records found.</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Shipping & Tracking Section -->
        <section id="section-shipping-tracking" class="portal-section">
            <header class="section-header">
                <div class="header-avatar" style="background-color: #3b82f6; color: #ffffff; font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; text-transform: uppercase; margin-right: 12px; flex-shrink: 0;">
                    <i class="bi bi-truck" style="font-size: 18px; display: flex; align-items: center; justify-content: center;"></i>
                </div>
                <div>
                    <div class="header-title-container">
                        <h1 class="header-title">Shipping & Tracking</h1>
                    </div>
                    <p class="header-subtitle">Track the delivery status of your California Target Book hard copies.</p>
                </div>
            </header>

            <div class="portal-card account-info-card">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Active Hard Copy Deliveries</h2>
                </div>
                <div class="card-body-custom" style="padding: 20px;">
                    @if(count($sub['books']))
                        @foreach($sub['books'] as $book)
                            <div class="hardcopy-item" style="padding: 20px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 20px; background-color: #ffffff;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                                    <div>
                                        <div style="font-weight: 700; font-size: 14px; color: var(--text-dark); margin-bottom: 4px;">{{ $book->address->line1 }}</div>
                                        @if($book->address->line2)
                                            <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">{{ $book->address->line2 }}</div>
                                        @endif
                                        <div style="font-size: 13px; color: var(--text-muted);">{{ $book->address->city }}, {{ $book->address->state }} {{ $book->address->zip_code }}</div>
                                    </div>
                                    <span class="badge" style="background-color: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 12px; font-size: 11px; font-weight: 600;">Active Shipment</span>
                                </div>

                                <div class="tracking-timeline" style="margin-top: 24px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                    <h4 style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 16px; margin-top: 0;">Shipment Status</h4>
                                    
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; color: #15803d; flex-shrink: 0;">
                                            <i class="bi bi-check2-circle" style="font-size: 18px;"></i>
                                        </div>
                                        <div>
                                            <div style="font-size: 13.5px; font-weight: 600; color: #1e293b;">Preparing for next release</div>
                                            <div style="font-size: 12px; color: var(--text-muted); margin-top: 2px;">Your hard copy is being scheduled for the upcoming publication delivery cycle.</div>
                                        </div>
                                    </div>
                                    
                                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px dashed #e2e8f0; font-size: 12.5px; color: var(--text-muted);">
                                        <strong>Delivery Method:</strong> Standard USPS Mail Delivery (delivered within 3-5 business days of release)
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5 text-muted" style="text-align: center; padding: 48px 0;">
                            <i class="bi bi-box-seam" style="font-size: 36px; display: block; margin-bottom: 12px; color: var(--text-muted);"></i>
                            <span>No hard copy subscriptions active to track.</span>
                            <p style="font-size: 12.5px; margin-top: 4px;">Only customers with hard copy subscription add-ons will see shipment tracking information here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Settings Section -->
        <section id="section-settings" class="portal-section">
            <header class="section-header">
                <div class="header-avatar" style="background-color: #6366f1; color: #ffffff; font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; text-transform: uppercase; margin-right: 12px; flex-shrink: 0;">
                    <i class="bi bi-gear" style="font-size: 18px; display: flex; align-items: center; justify-content: center;"></i>
                </div>
                <div>
                    <div class="header-title-container">
                        <h1 class="header-title">Settings</h1>
                    </div>
                    <p class="header-subtitle">Configure your account preferences and email notification options.</p>
                </div>
            </header>

            <div class="portal-card account-info-card">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Notification Preferences</h2>
                </div>
                <div class="card-body-custom" style="padding: 20px 24px;">
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Release Notifications</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Receive an email notification when a new book release is ready.</p>
                            </div>
                            <div>
                                <input type="checkbox" id="settings-release-notif" checked style="width: 16px; height: 16px; cursor: pointer;">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Hotsheet Alerts</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Get notified immediately when new Hotsheets and articles are published.</p>
                            </div>
                            <div>
                                <input type="checkbox" id="settings-hotsheet-alerts" checked style="width: 16px; height: 16px; cursor: pointer;">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Billing & Renewal Reminders</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Receive early reminders about subscription renewals and invoice updates.</p>
                            </div>
                            <div>
                                <input type="checkbox" id="settings-billing-reminders" checked style="width: 16px; height: 16px; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portal-card account-info-card" style="margin-top: 24px;">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Portal Interface Settings</h2>
                </div>
                <div class="card-body-custom" style="padding: 20px 24px;">
                    <div style="display: flex; flex-direction: column; gap: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid #f1f5f9;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Default Landing Route</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Choose which view to load by default when logging in.</p>
                            </div>
                            <div>
                                <select style="padding: 6px 12px; font-size: 13px; border-radius: 6px; border: 1px solid var(--border-color); background: #ffffff; color: var(--text-dark); cursor: pointer;">
                                    <option value="account-info">Account Info Portal</option>
                                    <option value="book-app">Open Book App</option>
                                </select>
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <h4 style="margin: 0; font-size: 13.5px; font-weight: 600; color: #1e293b;">Dark Mode (Beta)</h4>
                                <p style="margin: 4px 0 0 0; font-size: 12px; color: var(--text-muted);">Toggle dark mode for the account portal interface.</p>
                            </div>
                            <div>
                                <input type="checkbox" id="settings-dark-mode" style="width: 16px; height: 16px; cursor: pointer;" onclick="alert('Dark Mode feature will be available soon!')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Help & Support Section -->
        <section id="section-help-support" class="portal-section">
            <header class="section-header">
                <div class="header-avatar" style="background-color: #ec4899; color: #ffffff; font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; text-transform: uppercase; margin-right: 12px; flex-shrink: 0;">
                    <i class="bi bi-question-circle" style="font-size: 18px; display: flex; align-items: center; justify-content: center;"></i>
                </div>
                <div>
                    <div class="header-title-container">
                        <h1 class="header-title">Help & Support</h1>
                    </div>
                    <p class="header-subtitle">Need help with your subscription or have questions about the Target Book? Get in touch with us.</p>
                </div>
            </header>

            <div style="display: flex; flex-direction: column; gap: 24px; max-width: 800px; width: 100%;">
                <div class="portal-card" style="margin-top: 0;">
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Contact Information</h2>
                    </div>
                    <div class="card-body-custom" style="padding: 20px 24px;">
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            <div style="display: flex; align-items: flex-start; gap: 12px;">
                                <i class="bi bi-geo-alt text-danger" style="font-size: 18px; margin-top: 2px;"></i>
                                <div>
                                    <div style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin-bottom: 2px;">Office Address</div>
                                    <div style="font-size: 13px; color: var(--text-muted);">1215 K Street, Suite 1150, Sacramento, CA 95814</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                <i class="bi bi-envelope text-primary" style="font-size: 18px; margin-top: 2px;"></i>
                                <div>
                                    <div style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin-bottom: 2px;">Email Support</div>
                                    <div style="font-size: 13px; color: var(--text-muted);">
                                        <a href="mailto:info@californiatargetbook.com" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">info@californiatargetbook.com</a>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: flex-start; gap: 12px; border-top: 1px solid #f1f5f9; padding-top: 14px;">
                                <i class="bi bi-telephone text-success" style="font-size: 18px; margin-top: 2px;"></i>
                                <div>
                                    <div style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin-bottom: 2px;">Phone Support</div>
                                    <div style="font-size: 13px; color: var(--text-muted);">(916) 444-5550</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="portal-card" style="margin-top: 0;">
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Send us a Message</h2>
                    </div>
                    <div class="card-body-custom" style="padding: 20px 24px;">
                        <form id="support-contact-form" onsubmit="event.preventDefault(); alert('Your message has been sent successfully. Our support team will get back to you shortly.'); this.reset();">
                            <div style="margin-bottom: 16px;">
                                <label style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Subject</label>
                                <input type="text" required style="width: 100%; padding: 8px 12px; font-size: 13px; border-radius: 6px; border: 1px solid var(--border-color); box-sizing: border-box;" placeholder="How can we help you?">
                            </div>
                            <div style="margin-bottom: 16px;">
                                <label style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Message Description</label>
                                <textarea required rows="4" style="width: 100%; padding: 8px 12px; font-size: 13px; border-radius: 6px; border: 1px solid var(--border-color); box-sizing: border-box; resize: vertical;" placeholder="Provide details about your query..."></textarea>
                            </div>
                            <button type="submit" style="background-color: var(--primary-color); color: white; border: none; border-radius: 6px; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='var(--primary-color)'">Submit Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
            @endif
        </section>

                </div>
            </div>
        </div>

        <!-- Hidden Modals (Vue bindings preserved) -->
        <change-password-modal v-if="showChangePasswordModal" @close="showChangePasswordModal = false"></change-password-modal>
        
        @if($pending_bank)
            <verify-bank-modal v-if="showVerifyBankModal" @close="showVerifyBankModal = false"></verify-bank-modal>
        @endif
        
        @if($sub['role'] === 'subscriber' && !empty($invoice))
            <invoice-modal v-if="showInvoiceModal" :invoice="{{ json_encode($sub['invoice']) }}" @close="showInvoiceModal = false"></invoice-modal>
        @endif
    </main>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Sidebar tab toggles
        $('#tab-account-info').on('click', function(e) {
            e.preventDefault();
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            $('.portal-section').removeClass('active');
            $('#section-account-info').addClass('active');
            window.location.hash = 'account-info';
        });

        $('#tab-subscriptions').on('click', function(e) {
            e.preventDefault();
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            $('.portal-section').removeClass('active');
            $('#section-subscriptions').addClass('active');
            window.location.hash = 'subscriptions';
        });

        $('#tab-transaction-history').on('click', function(e) {
            e.preventDefault();
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            $('.portal-section').removeClass('active');
            $('#section-transaction-history').addClass('active');
            window.location.hash = 'transaction-history';
        });

        // Tab selection for Shipping & Tracking
        $('#tab-shipping-tracking').on('click', function(e) {
            e.preventDefault();
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            $('.portal-section').removeClass('active');
            $('#section-shipping-tracking').addClass('active');
            window.location.hash = 'shipping-tracking';
        });

        // Tab selection for Settings
        $('#tab-settings').on('click', function(e) {
            e.preventDefault();
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            $('.portal-section').removeClass('active');
            $('#section-settings').addClass('active');
            window.location.hash = 'settings';
        });

        // Tab selection for Help & Support
        $('#tab-help-support').on('click', function(e) {
            e.preventDefault();
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
            $('.portal-section').removeClass('active');
            $('#section-help-support').addClass('active');
            window.location.hash = 'help-support';
        });

        // Parse hash on load
        let hash = window.location.hash;
        if (hash === '#subscriptions') {
            $('#tab-subscriptions').trigger('click');
        } else if (hash === '#account-info') {
            $('#tab-account-info').trigger('click');
        } else if (hash === '#transaction-history') {
            $('#tab-transaction-history').trigger('click');
        } else if (hash === '#shipping-tracking') {
            $('#tab-shipping-tracking').trigger('click');
        } else if (hash === '#settings') {
            $('#tab-settings').trigger('click');
        } else if (hash === '#help-support') {
            $('#tab-help-support').trigger('click');
        }
    });
</script>
@endsection

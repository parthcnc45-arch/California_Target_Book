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
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }
    h1, h2, h3, h4, h5, h6, label, a , button{
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }
    .btn{
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
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

    @media (min-width: 1600px) {
        .col-xl-custom {
            width: 58.33333333% !important;
            float: left;
        }
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
        max-width: 100%;
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
@yield('portal_styles')
@endsection

@section('content')
<div class="account-portal">
    <!-- Left Sidebar -->
    <aside class="portal-sidebar">
        <div class="sidebar-brand">
            <img src="{{asset('img/ctb-logo-6QqsiqVS.png')}}" alt="California Target Book Logo" class="brand-logo">
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
            <a href="/account/account-info" class="nav-link {{ Request::is('account/account-info') ? 'active' : '' }}"><i class="bi bi-person"></i> Account info</a>
            <a href="/account/subscriptions" class="nav-link {{ Request::is('account/subscriptions') ? 'active' : '' }}"><i class="bi bi-credit-card-2-front"></i> Subscriptions</a>
            <a href="/account/transaction-history" class="nav-link {{ Request::is('account/transaction-history') ? 'active' : '' }}"><i class="bi bi-coin"></i> Transaction History</a>
            <a href="/account/shipping-tracking" class="nav-link {{ Request::is('account/shipping-tracking') ? 'active' : '' }}"><i class="bi bi-truck"></i> Shipping & Tracking</a>
            <a href="/account/settings" class="nav-link {{ Request::is('account/settings') ? 'active' : '' }}"><i class="bi bi-gear"></i> Settings</a>
            <a href="/account/help-support" class="nav-link {{ Request::is('account/help-support') ? 'active' : '' }}"><i class="bi bi-question-circle"></i> Help & Support</a>
        </nav>

        <div class="sidebar-actions">
            <a href="/logout" class="nav-link signout-link"><i class="bi bi-box-arrow-left"></i> Sign Out</a>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="portal-main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    @yield('portal_content')
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
@yield('portal_scripts')
@endsection

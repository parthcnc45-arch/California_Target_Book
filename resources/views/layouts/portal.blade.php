@extends('layouts.master_headless')

@section('title', 'Your Account | California Target Book')

@section('body_class', 'portal-body')

@section('styles')
<!-- Google Fonts - Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<link href="/css/portal_custom.css" rel="stylesheet">
@if(auth()->check() && auth()->user()->isAdmin())
<link href="/css/admin_settings.css" rel="stylesheet">
@endif
@include('components.admin-menu-state')
@yield('portal_styles')
@endsection

@section('content')
<div class="account-portal">
    <!-- Left Sidebar -->
    <aside class="portal-sidebar">
        <div class="sidebar-brand">
            <img src="/img/ctb-logo-6QqsiqVS.png" alt="California Target Book Logo" class="brand-logo">
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
            <!-- User Nav Menu -->
            <div id="user-nav-menu">
                <!-- @if ($user->isAdmin())
                    <div class="nav-section-title admin-section-title">ADMINISTRATION</div>
                    <a href="/ctb-admin" class="nav-link admin-dashboard-link-nav"><i class="bi bi-lock-fill"></i> Admin Dashboard</a>
                @endif -->
                <div class="nav-section-title">MY ACCOUNT</div>
                <a href="/" class="nav-link"><i class="bi bi-house-door"></i> Home</a>
                <!-- <a href="/classifieds" class="nav-link {{ Request::is('classifieds*') ? 'active' : '' }}"><i class="bi bi-megaphone"></i> Classifieds</a> -->
                <a href="/account/account-info" class="nav-link {{ Request::is('account/account-info') ? 'active' : '' }}"><i class="bi bi-person"></i> Account info</a>
                <a href="/account/subscriptions" class="nav-link {{ Request::is('account/subscriptions') ? 'active' : '' }}"><i class="bi bi-credit-card-2-front"></i> Subscriptions</a>
                <!-- <a href="/account/manage-add-ons" class="nav-link {{ Request::is('account/manage-add-ons') || Request::is('account/addon-checkout') ? 'active' : '' }}"><i class="bi bi-gift"></i> Manage add-ons</a> -->
                <a href="/account/transaction-history" class="nav-link {{ Request::is('account/transaction-history') ? 'active' : '' }}"><i class="bi bi-coin"></i> Transaction History</a>
                <a href="/account/shipping-tracking" class="nav-link {{ Request::is('account/shipping-tracking') ? 'active' : '' }}"><i class="bi bi-truck"></i> Shipping & Tracking</a>
                <a href="/account/notification-settings" class="nav-link {{ Request::is('account/notification-settings') ? 'active' : '' }}"><i class="bi bi-gear"></i> Notifications</a>
                <a href="/account/help-support" class="nav-link {{ Request::is('account/help-support') ? 'active' : '' }}"><i class="bi bi-question-circle"></i> Help & Support</a>
            </div>

            <!-- Admin Settings Submenu -->
            @if ($user->isAdmin())
                <div id="admin-settings-menu">
                    <a href="/account/account-info" onclick="handleBackToMainMenu(event)" class="nav-link" style="margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; font-weight: 600;"><i class="bi bi-arrow-left"></i> Back to Main Menu</a>
                    <div class="nav-section-title admin-section-title">ADMIN SETTINGS</div>
                    <a href="/ctb-admin/new/subscriptions" class="nav-link {{ Request::is('ctb-admin/new/subscriptions*') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Subscriptions</a>
                    <a href="/ctb-admin/new/hard-copy-subscriptions" class="nav-link {{ Request::is('ctb-admin/new/hard-copy-subscriptions') ? 'active' : '' }}"><i class="bi bi-book"></i> Shipments</a>
                    <a href="/ctb-admin/new/digital-addon-orders" class="nav-link {{ Request::is('ctb-admin/new/digital-addon-orders') ? 'active' : '' }}"><i class="bi bi-cloud-arrow-down"></i> Digital Orders</a>
                    <a href="/ctb-admin/new/contacts" class="nav-link {{ Request::is('ctb-admin/new/contacts') ? 'active' : '' }}"><i class="bi bi-people"></i> Contacts</a>
                    <a href="/ctb-admin/new/classifieds" class="nav-link {{ Request::is('ctb-admin/new/classifieds') ? 'active' : '' }}"><i class="bi bi-megaphone"></i> Classifieds</a>
                    <!-- <a href="/ctb-admin/new/classifieds/settings" class="nav-link {{ Request::is('ctb-admin/new/classifieds/settings') ? 'active' : '' }}"><i class="bi bi-sliders"></i> Classifieds Settings</a> -->


                </div>
            @endif
            
            @php
                $isActive = false;
                $dbStatus = strtolower($sub['status'] ?? '');
                if ($dbStatus !== 'expired' && $dbStatus !== 'none') {
                    if (isset($sub['stripe_data']) && $sub['stripe_data']) {
                        if (strtolower($sub['stripe_data']->status) === 'active' || strtolower($sub['stripe_data']->status) === 'trialing') {
                            $isActive = true;
                        }
                    } else {
                        if ($dbStatus === 'active' || $dbStatus === 'trialing') {
                            $isActive = true;
                        }
                    }
                }
            @endphp
            
            @if($isActive)
            <a href="/book" class="btn-open-app" style="margin-top: 16px;">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Open Book App</span>
            </a>
            @endif
        </nav>

        <div id="bottom-actions-menu">
            <div class="sidebar-actions">
                @if ($user->isAdmin())
                <a href="/ctb-admin/new/subscriptions" onclick="openAdminSettings(event)" class="nav-link signout-link"><i class="bi bi-sliders"></i> Admin Settings</a>
                @endif
                <a href="/logout" class="nav-link signout-link"><i class="bi bi-box-arrow-left"></i> Sign Out</a>
            </div>
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
        
        @if(!empty($sub) && !empty($sub['role']) && $sub['role'] === 'subscriber' && !empty($invoice))
            <invoice-modal v-if="showInvoiceModal" :invoice="{{ json_encode($sub['invoice'] ?? null) }}" @close="showInvoiceModal = false"></invoice-modal>
        @endif
    </main>
</div>
@endsection

@section('scripts')
    <script src="/js/table-rows-filter.js"></script>
    @yield('portal_scripts')
    @include('components.admin-menu-script')
@endsection

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
                @if ($user->isAdmin())
                    <div class="nav-section-title admin-section-title">ADMINISTRATION</div>
                    <a href="/ctb-admin" class="nav-link admin-dashboard-link-nav"><i class="bi bi-lock-fill"></i> Admin Dashboard</a>
                @endif
                <div class="nav-section-title">MY ACCOUNT</div>
                <a href="/" class="nav-link"><i class="bi bi-house-door"></i> Home</a>
                <a href="/account/account-info" class="nav-link {{ Request::is('account/account-info') ? 'active' : '' }}"><i class="bi bi-person"></i> Account info</a>
                <a href="/account/subscriptions" class="nav-link {{ Request::is('account/subscriptions') ? 'active' : '' }}"><i class="bi bi-credit-card-2-front"></i> Subscriptions</a>
                <a href="/account/transaction-history" class="nav-link {{ Request::is('account/transaction-history') ? 'active' : '' }}"><i class="bi bi-coin"></i> Transaction History</a>
                <a href="/account/shipping-tracking" class="nav-link {{ Request::is('account/shipping-tracking') ? 'active' : '' }}"><i class="bi bi-truck"></i> Shipping & Tracking</a>
                <a href="/account/settings" class="nav-link {{ Request::is('account/settings') ? 'active' : '' }}"><i class="bi bi-gear"></i> Settings</a>
                <a href="/account/help-support" class="nav-link {{ Request::is('account/help-support') ? 'active' : '' }}"><i class="bi bi-question-circle"></i> Help & Support</a>
                @if ($user->isAdmin())
                    <a href="javascript:void(0)" onclick="toggleAdminSettings(true)" class="nav-link"><i class="bi bi-sliders"></i> Admin Settings</a>
                @endif
            </div>

            <!-- Admin Settings Submenu -->
            @if ($user->isAdmin())
                <div id="admin-settings-menu" style="display: none;">
                    <a href="javascript:void(0)" onclick="toggleAdminSettings(false)" class="nav-link" style="margin-bottom: 16px; border-bottom: 1px solid var(--border-color); padding-bottom: 12px; font-weight: 600;"><i class="bi bi-arrow-left"></i> Back to Main Menu</a>
                    <div class="nav-section-title admin-section-title">ADMIN SETTINGS</div>
                    <a href="/ctb-admin/subscriptions" class="nav-link"><i class="bi bi-receipt"></i> Subscriptions</a>
                    <a href="/ctb-admin/hard-copy-subscriptions" class="nav-link"><i class="bi bi-book"></i> Hard Copies</a>
                    <a href="/ctb-admin/contacts" class="nav-link"><i class="bi bi-people"></i> Contacts</a>
                    <a href="/ctb-admin/events" class="nav-link"><i class="bi bi-calendar-event"></i> Events</a>
                    <a href="/ctb-admin/polls" class="nav-link"><i class="bi bi-bar-chart-line"></i> Polls</a>
                    <a href="/ctb-admin/feedback" class="nav-link"><i class="bi bi-chat-right-text"></i> Feedback</a>
                </div>
            @endif
            
            <a href="/book" class="btn-open-app" style="margin-top: 16px;">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Open Book App</span>
            </a>
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
<script>
    function toggleAdminSettings(show) {
        const userMenu = document.getElementById('user-nav-menu');
        const adminMenu = document.getElementById('admin-settings-menu');
        if (userMenu && adminMenu) {
            if (show) {
                userMenu.style.display = 'none';
                adminMenu.style.display = 'block';
                localStorage.setItem('adminSettingsOpen', 'true');
            } else {
                userMenu.style.display = 'block';
                adminMenu.style.display = 'none';
                localStorage.setItem('adminSettingsOpen', 'false');
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        if (localStorage.getItem('adminSettingsOpen') === 'true') {
            toggleAdminSettings(true);
        }
    });
</script>
@endsection

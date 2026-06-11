@extends('layouts.portal')

@section('portal_content')
    <section id="section-subscriptions" class="portal-section active">
        <header class="section-header" style="justify-content: space-between; align-items: center; width: 100%; margin-bottom: 24px;">
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Subscriptions</h1>
                </div>
                <p class="header-subtitle">Manage your subscriptions, book recipients, and add-ons.</p>
            </div>
            <a href="{{ route('auth.account.subscriptions.add') }}" class="btn-add-subscription">
                <i class="bi bi-plus-lg"></i> Add Subscription
            </a>
        </header>

        @if($sub['status'] !== 'None')
        <!-- Card 1: One-Year Subscription -->
        <div class="subscription-card">
            <div class="subscription-card-header">
                <div class="subscription-card-title-container">
                    <h2 class="subscription-card-title">{{ $sub['stripe_product_name'] ?? '' }}</h2>
                </div>
                <span class="badge-active">Active</span>
            </div>
            <div class="subscription-card-body">
                <table class="subscription-info-table">
                    <tbody>
                        <tr>
                            <td class="subscription-info-label">Started</td>
                            <td class="subscription-info-value">{{ $sub['start'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Expires</td>
                            <td class="subscription-info-value">{{ $sub['end'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Renewal</td>
                            <td class="subscription-info-value">{{ $sub['end'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Seats</td>
                            <td class="subscription-info-value"><span id="seats-summary-count">{{ 1 + count($sub['addons']) }}</span> of 5 used</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Add-ons</td>
                            <td class="subscription-info-value" style="white-space: normal; line-height: 1.4;">
                                Additional Book Edition + 2 New Election Edition + Personalization
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="subscription-card-footer">
                <div class="subscription-footer-left">
                    <a href="{{ route('auth.account.manage_billing') }}" class="btn-manage-billing">
                        <i class="bi bi-credit-card"></i> Manage Billing
                    </a>
                </div>
                <div class="subscription-footer-right">
                    <button type="button" class="btn-cancel-subscription btn-trigger-cancel">
                        Cancel
                    </button>
                </div>
            </div>

            <!-- Team Members Accordion -->
            <button class="accordion-toggle" type="button" data-target="#team-list-1">
                <span>Team Members (<span id="team-seats-count">{{ 1 + count($sub['addons']) }}</span> of 5 seats)</span>
                <i class="bi bi-chevron-down accordion-chevron"></i>
            </button>
            <div id="team-list-1" class="accordion-content">
                <div class="accordion-content-inner">
                    <!-- Seats Progress Bar -->
                    <div class="seats-progress-container">
                        <div class="seats-progress-header">
                            <span class="seats-progress-text">Seats: <strong id="progress-seats-used">{{ 1 + count($sub['addons']) }}</strong> of <strong id="progress-seats-total">5</strong></span>
                            <span class="seats-progress-available"><span id="progress-seats-available">{{ 5 - (1 + count($sub['addons'])) }}</span> available</span>
                        </div>
                        <div class="seats-progress-bar-track">
                            <div class="seats-progress-bar-fill" style="width: {{ ((1 + count($sub['addons'])) / 5) * 100 }}%;"></div>
                        </div>
                    </div>

                    <!-- Invite Colleague Form -->
                    <div class="invite-container" style="flex-direction: column; align-items: flex-start; gap: 8px;">
                        <div style="display: flex; gap: 12px; width: 100%; max-width: 480px;">
                            <input type="email" id="invite-email" class="form-input invite-input" placeholder="colleague@example.com">
                            <button type="button" class="btn-invite" id="btn-invite-submit">Invite</button>
                        </div>
                        <div id="invite-message" style="display:none; font-size:12.5px; margin-top: 4px; font-weight: 500;"></div>
                    </div>

                    <!-- Team Members Header -->
                    <div class="team-header-container">
                        <span class="team-header-title">Team Members</span>
                        <span class="team-header-badge" id="team-active-badge">{{ 1 + $sub['addons']->where('verified', 1)->count() }} active</span>
                    </div>

                    <table class="team-table" id="team-members-table">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 30%;">Email</th>
                                <th style="width: 15%;">Role</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 20%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-user-email="john.smith@example.com">
                                <td><span class="team-member-name">John Smith</span></td>
                                <td><span class="team-member-email">john.smith@example.com</span></td>
                                <td><span class="team-member-role">Owner</span></td>
                                <td><span class="badge-team-active">Active</span></td>
                                <td></td>
                            </tr>
                            <tr data-addon-id="1" data-user-email="sarah.jones@example.com">
                                <td><span class="team-member-name">Sarah Jones</span></td>
                                <td><span class="team-member-email">sarah.jones@example.com</span></td>
                                <td><span class="team-member-role">Member</span></td>
                                <td><span class="badge-team-active">Active</span></td>
                                <td>
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <button type="button" class="btn-member-manage" style="cursor: pointer">
                                            <i class="bi bi-arrow-repeat"></i> Reassign
                                        </button>
                                        <button type="button" class="btn-member-remove btn-remove-addon" data-id="1">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr data-addon-id="2" data-user-email="mike.brown@example.com">
                                <td><span class="team-member-name">Pending Profile</span></td>
                                <td><span class="team-member-email">mike.brown@example.com</span></td>
                                <td><span class="team-member-role">Member</span></td>
                                <td><span class="badge-team-pending">Pending</span></td>
                                <td>
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <button type="button" class="btn-member-manage" style="cursor: pointer">
                                            <i class="bi bi-arrow-repeat"></i> Reassign
                                        </button>
                                        <button type="button" class="btn-member-remove btn-remove-addon" data-id="2">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Purchase Additional Seats -->
                    <div class="purchase-seats-container">
                        <a href="{{ route('auth.account.subscriptions.seats') }}" class="purchase-seats-link">
                            <i class="bi bi-person-plus"></i> Purchase Additional Seats
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="subscription-card" style="padding: 40px; text-align: center;">
            <p style="font-size: 16px; color: #475569; margin-bottom: 20px;">You do not have an active subscription.</p>
            <a href="{{ route('auth.account.subscriptions.add') }}" class="btn-add-subscription">
                <i class="bi bi-cart"></i> Purchase Subscription
            </a>
        </div>
        @endif

        <!-- Cancel Subscription Modal -->
        <div id="cancel-sub-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card">
                <div class="modal-header">
                    <h3 class="modal-title">Cancel Subscription</h3>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel your subscription? You will lose access to all portal features at the end of your current billing period.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-keep-subscription" id="btn-keep-sub-btn">
                        KEEP SUBSCRIPTION
                    </button>
                    <form action="{{ route('auth.account.subscriptions.cancel') }}" method="POST" style="display: inline; margin: 0;">
                        {{ csrf_field() }}
                        <button type="submit" class="btn-confirm-cancel">
                            YES, CANCEL SUBSCRIPTION
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reassign Seat Modal -->
        <div id="reassign-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card" style="max-width: 500px;">
                <div class="modal-header" style="justify-content: space-between; align-items: flex-start; border-bottom: none; padding-bottom: 0;">
                    <div style="display:flex; flex-direction:column; gap:4px;">
                        <h3 class="modal-title">Reassign Seat</h3>
                        <p style="font-size: 14px; color: #64748b; margin: 0; font-weight: 400;">Replace <strong>Sarah Johnson</strong> with a new team member.</p>
                    </div>
                </div>
                <div class="modal-body" style="margin-top: 16px;">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Name</label>
                        <input type="text" class="form-input" style="width: 100%; padding: 10px; border: 1px solid var(--primary-color); border-radius: 6px; box-sizing:border-box; outline: none; box-shadow: 0 0 0 1px var(--primary-color);" value="Jane Doe">
                    </div>
                    <div class="form-group" style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: var(--text-main);">Email</label>
                        <input type="email" class="form-input" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing:border-box; outline: none;" value="jane@example.com">
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px;">
                    <button type="button" class="btn-cancel" id="btn-cancel-reassign" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.15s;">
                        Cancel
                    </button>
                    <button type="button" class="btn-reassign" style="background: var(--primary-color); color: #ffffff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.15s;">
                        Reassign
                    </button>
                </div>
            </div>
        </div>

        <!-- Remove Team Member Modal -->
        <div id="remove-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card" style="max-width: 500px;">
                <div class="modal-header" style="justify-content: space-between; align-items: flex-start; border-bottom: none; padding-bottom: 0;">
                    <div style="display:flex; flex-direction:column; gap:4px;">
                        <h3 class="modal-title" style="font-size: 18px; color: var(--text-main); margin: 0; font-weight: 600;">Remove Team Member</h3>
                        <p style="font-size: 14px; color: #64748b; margin: 8px 0 0 0; line-height: 1.5;">Remove <strong>Sarah Johnson</strong> (sarah@example.com) from this subscription? They will lose access immediately.</p>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 0; border-top: none;">
                    <button type="button" class="btn-cancel" id="btn-cancel-remove" style="background: #ffffff; border: 1px solid #cbd5e1; color: #0f172a; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.15s;">
                        Cancel
                    </button>
                    <button type="button" class="btn-reassign" style="background: #ef4444; color: #ffffff; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: background 0.15s;">
                        Remove
                    </button>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('portal_styles')
<style>
    .btn-add-subscription {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: var(--primary-color);
        color: #ffffff !important;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        font-style: normal;
        transition: background-color 0.15s ease-in-out;
    }
    .btn-add-subscription:hover {
        background-color: #b91c1c;
        text-decoration: none;
        opacity: 0.9;
    }
    .btn-add-subscription i {
        font-size: 14px;
    }
    .btn-manage-billing {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: var(--primary-color);
        color: #ffffff !important;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        font-style: normal;
        transition: background-color 0.15s ease-in-out;
    }
    .btn-manage-billing:hover {
        background-color: #b91c1c;
        text-decoration: none;
        opacity: 0.9;
    }
    .btn-manage-billing i {
        font-size: 14px;
    }
    .btn-cancel-subscription {
        background: none;
        border: none;
        color: var(--primary-color) !important;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        padding: 8px 0;
        text-decoration: none !important;
        transition: color 0.15s ease-in-out;
    }
    .btn-cancel-subscription:hover {
        color: #b91c1c !important;
        text-decoration: underline !important;
    }

    /* Subscription Card Styles */
    .subscription-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }
    .subscription-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .subscription-card-title-container {
        display: flex;
        flex-direction: column;
    }
    .subscription-card-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        line-height: 1.4;
    }
    .subscription-card-subtitle {
        font-size: 12.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }
    .badge-active {
        background-color: #e6f4ea;
        color: #137333;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }

    .subscription-card-body {
        padding: 0;
    }
    .subscription-info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .subscription-info-table td {
        padding: 14px 24px;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
    }
    .subscription-info-table tr:last-child td {
        border-bottom: none;
    }
    .subscription-info-label {
        width: 30%;
        color: var(--text-muted);
        font-weight: 500;
    }
    .subscription-info-value {
        width: 70%;
        color: #0f172a;
        font-weight: 600;
    }
    .subscription-card-footer {
        padding: 16px 24px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .subscription-footer-left {
        display: flex;
        align-items: center;
    }
    .subscription-footer-right {
        display: flex;
        align-items: center;
    }

    /* Accordion Toggle Styles */
    .accordion-toggle {
        width: 100%;
        padding: 14px 24px;
        background-color: #ffffff;
        border: none;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        cursor: pointer;
        transition: background-color 0.15s ease, color 0.15s ease;
    }
    .accordion-toggle:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }
    .accordion-chevron {
        font-size: 12px;
        color: var(--text-muted);
        transition: transform 0.2s ease, color 0.15s ease;
    }
    .accordion-toggle.active .accordion-chevron {
        transform: rotate(180deg);
        color: var(--primary-color);
    }
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        background-color: #f8fafc;
        border-top: 1px solid #f1f5f9;
        transition: max-height 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .accordion-content-inner {
        padding: 20px 24px;
    }

    /* Team Table Styles */
    .team-table {
        width: 100%;
        border-collapse: collapse;
    }
    .subscription-card .team-table th,
    .team-table th {
        text-align: left;
        font-size: 12px;
        font-weight: 500;
        color: var(--text-muted) !important;
        padding: 8px 12px;
        border-bottom: 1px solid #e2e8f0;
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
    }
    .team-table td {
        padding: 10px 12px;
        font-size: 12.5px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        background: transparent !important;
    }
    .team-table tr:last-child td {
        border-bottom: none;
    }
    .team-member-profile {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .team-member-avatar {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 600;
        font-size: 11px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
    }
    .team-member-name {
        font-weight: 600;
        color: #0f172a;
    }
    .team-member-email {
        font-size: 11.5px;
        color: var(--text-muted);
    }
    .badge-owner {
        background-color: #eff6ff;
        color: #1d4ed8;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-member {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
    }
    .badge-team-active {
        background-color: #d1fae5;
        color: #065f46;
        font-size: 10px;
        font-weight: 600;
        padding: 2px 6px;
        border-radius: 4px;
        display: inline-block;
    }
    /* Cancel Modal Styles */
    .modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .modal-card {
        background: #ffffff;
        border-radius: 8px;
        width: 650px;
        max-width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        animation: modalScaleUp 0.15s ease-out;
    }
    @keyframes modalScaleUp {
        from {
            transform: scale(0.95);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }
    .modal-header {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-title {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .btn-close-modal {
        background: none;
        border: none;
        font-size: 16px;
        color: #94a3b8;
        cursor: pointer;
        padding: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.15s ease;
    }
    .btn-close-modal:hover {
        color: #475569;
    }
    .modal-body {
        padding: 20px;
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
    }
    .modal-footer {
        padding: 16px 20px;
        border-top: 1px solid #f1f5f9;
        background-color: #f8fafc;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
    .btn-keep-subscription {
        background-color: #ffffff;
        border: 1px solid #d2d6dc;
        color: #475569;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        transition: all 0.15s ease;
    }
    .btn-keep-subscription:hover {
        background-color: #f8fafc;
        color: #0f172a;
        border-color: #b5bac2;
    }
    .btn-confirm-cancel {
        background-color: var(--primary-color);
        border: none;
        color: #ffffff;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        transition: background-color 0.15s ease;
    }
    .btn-confirm-cancel:hover {
        background-color: #b91c1c;
    }

    /* Team Member Styles */
    .invite-container {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        max-width: 480px;
    }
    .invite-input {
        flex: 1;
        height: 38px !important;
        box-sizing: border-box;
    }
    .btn-invite {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a;
        border-radius: 6px;
        padding: 0 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        height: 38px;
        transition: all 0.15s ease-in-out;
    }
    .btn-invite:hover:not(:disabled) {
        background-color: #f8fafc;
        border-color: #94a3b8;
    }
    .btn-invite:disabled, .invite-input:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .team-header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .team-header-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
    }
    .team-header-badge {
        font-size: 12px;
        font-weight: 600;
        color: #16a34a;
        background-color: #f0fdf4;
        padding: 2px 8px;
        border-radius: 9999px;
    }

    .team-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: transparent !important;
    }
    .team-table thead,
    .team-table thead tr {
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
        border-bottom: 1px solid #cbd5e1 !important;
    }
    /* Use high-specificity selector to override ctb_styles.css gradient on table:not(.table) th */
    .subscription-card .team-table th,
    #section-subscriptions .team-table th,
    .team-table th {
        background: #ffffff !important;
        background-color: #ffffff !important;
        background-image: none !important;
        color: var(--text-muted) !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        text-transform: none !important;
        letter-spacing: normal !important;
        padding: 12px 10px !important;
        border: none !important;
        border-bottom: 1px solid #cbd5e1 !important;
        text-align: left !important;
        box-sizing: border-box;
    }
    .team-table td {
        padding: 12px 10px !important;
        font-size: 13px !important;
        color: #334155 !important;
        border-bottom: 1px solid #f1f5f9 !important;
        vertical-align: middle !important;
        background-color: transparent !important;
        background: transparent !important;
        box-sizing: border-box;
    }
    .team-table tr:last-child td {
        border-bottom: none !important;
    }

    .team-member-name {
        font-weight: 600;
        color: #0f172a;
    }
    .team-member-email {
        color: var(--text-muted);
    }
    .team-member-role {
        color: #475569;
        font-weight: 500;
    }
    .badge-team-active {
        background-color: #e6f4ea;
        color: #137333;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }
    .badge-team-pending {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }

    .btn-member-manage {
        background: none;
        border: none;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 0;
        transition: color 0.15s ease;
    }
    .btn-member-manage:hover {
        color: #0f172a;
    }
    .btn-member-manage i {
        font-size: 14px;
    }
    .btn-member-remove {
        background: none;
        border: none;
        color: var(--primary-color);
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 4px 0;
        transition: color 0.15s ease;
    }
    .btn-member-remove:hover {
        color: #b91c1c;
    }
    .btn-member-remove i {
        font-size: 14px;
    }

    .purchase-seats-container {
        border-top: 1px solid #e2e8f0;
        padding-top: 16px;
        margin-top: 16px;
    }
    .purchase-seats-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #0f172a !important;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none !important;
        cursor: pointer;
        transition: all 0.15s ease-in-out;
    }
    .purchase-seats-link:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a !important;
        text-decoration: none !important;
    }
    .purchase-seats-link i {
        font-size: 16px;
        color: #475569;
    }

    /* Seats Progress Bar Styles */
    .seats-progress-container {
        margin-bottom: 20px;
        width: 100%;
        box-sizing: border-box;
    }
    .seats-progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        font-size: 13px;
    }
    .seats-progress-text {
        color: #475569;
        font-weight: 500;
    }
    .seats-progress-text strong {
        color: #0f172a;
        font-weight: 700;
    }
    .seats-progress-available {
        color: #16a34a;
        font-weight: 600;
    }
    .seats-progress-bar-track {
        width: 100%;
        height: 8px;
        background-color: #e2e8f0;
        border-radius: 9999px;
        overflow: hidden;
    }
    .seats-progress-bar-fill {
        height: 100%;
        background-color: var(--primary-color);
        border-radius: 9999px;
        transition: width 0.3s ease-in-out;
    }
</style>
@endsection

@section('portal_scripts')
<script>
    $(document).ready(function() {
        $('.accordion-toggle').on('click', function(e) {
            e.preventDefault();
            var $button = $(this);
            var targetSelector = $button.data('target');
            var $content = $(targetSelector);
            var isActive = $button.hasClass('active');

            if (isActive) {
                $button.removeClass('active');
                $content.animate({ maxHeight: 0 }, 200);
            } else {
                $button.addClass('active');
                $content.css('max-height', 'none');
                var scrollHeight = $content.height();
                $content.css('max-height', 0);
                $content.animate({ maxHeight: scrollHeight }, 200, function() {
                    $content.css('max-height', 'none');
                });
            }
        });

        // Cancel modal event listeners
        $('.btn-trigger-cancel').on('click', function(e) {
            e.preventDefault();
            $('#cancel-sub-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-keep-sub-btn, #btn-close-modal-x').on('click', function(e) {
            e.preventDefault();
            $('#cancel-sub-modal').fadeOut(150);
        });

        $('#cancel-sub-modal').on('click', function(e) {
            if ($(e.target).is('#cancel-sub-modal')) {
                $('#cancel-sub-modal').fadeOut(150);
            }
        });

        // Reassign modal event listeners
        $('.btn-member-manage').on('click', function(e) {
            e.preventDefault();
            $('#reassign-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-cancel-reassign, #btn-close-reassign-modal').on('click', function(e) {
            e.preventDefault();
            $('#reassign-modal').fadeOut(150);
        });

        $('#reassign-modal').on('click', function(e) {
            if ($(e.target).is('#reassign-modal')) {
                $('#reassign-modal').fadeOut(150);
            }
        });

        // Remove modal event listeners
        $('.btn-member-remove').on('click', function(e) {
            e.preventDefault();
            $('#remove-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-cancel-remove, #btn-close-remove-modal').on('click', function(e) {
            e.preventDefault();
            $('#remove-modal').fadeOut(150);
        });

        $('#remove-modal').on('click', function(e) {
            if ($(e.target).is('#remove-modal')) {
                $('#remove-modal').fadeOut(150);
            }
        });

        // Check seat limit function
        function checkSeatLimit() {
            var count = $('#team-members-table tbody tr').length;
            var maxSeats = 5;
            var available = maxSeats - count;
            if (available < 0) available = 0;

            // Update progress bar UI
            $('#progress-seats-used').text(count);
            $('#progress-seats-available').text(available);
            var percent = (count / maxSeats) * 100;
            if (percent > 100) percent = 100;
            $('.seats-progress-bar-fill').css('width', percent + '%');

            if (count >= maxSeats) {
                $('#invite-email').prop('disabled', true);
                $('#btn-invite-submit').prop('disabled', true);
                $('#invite-message').html('<span style="color:#ef4444;">You have reached the limit of ' + maxSeats + ' seats. Remove a member to invite more.</span>').show();
            } else {
                $('#invite-email').prop('disabled', false);
                $('#btn-invite-submit').prop('disabled', false);
                $('#invite-message').hide();
            }
        }

        // Call initially
        checkSeatLimit();

        // Invite Colleague Handler
        $('#btn-invite-submit').on('click', function(e) {
            e.preventDefault();
            var email = $.trim($('#invite-email').val());
            var $messageDiv = $('#invite-message');

            if (!email) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter an email address.</span>').show();
                return;
            }

            // Simple email format check
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(email)) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter a valid email address.</span>').show();
                return;
            }

            // Disable UI
            $('#invite-email').prop('disabled', true);
            $('#btn-invite-submit').prop('disabled', true);
            $messageDiv.html('<span style="color:#475569;">Sending invitation...</span>').show();

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.invite") }}',
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#invite-email').val('');
                        $messageDiv.html('<span style="color:#16a34a;">' + response.message + '</span>').show();
                        
                        // Append new member to table
                        var newRow = `
                            <tr data-addon-id="${response.addon.id}" data-user-email="${response.addon.email}">
                                <td><span class="team-member-name">${response.addon.name}</span></td>
                                <td><span class="team-member-email">${response.addon.email}</span></td>
                                <td><span class="team-member-role">${response.addon.role}</span></td>
                                <td><span class="badge-team-pending">${response.addon.status}</span></td>
                                <td>
                                    <div style="display: flex; gap: 12px; align-items: center;">
                                        <button type="button" class="btn-member-manage" style="cursor: not-allowed; opacity: 0.5;">
                                            <i class="bi bi-sliders"></i> Manage
                                        </button>
                                        <button type="button" class="btn-member-remove btn-remove-addon" data-id="${response.addon.id}">
                                            <i class="bi bi-trash"></i> Remove
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        $('#team-members-table tbody').append(newRow);

                        // Update Counts
                        var totalSeats = $('#team-members-table tbody tr').length;
                        $('#team-seats-count').text(totalSeats);
                        $('#seats-summary-count').text(totalSeats);

                        // Re-enable/Check Limits
                        checkSeatLimit();
                    } else {
                        $messageDiv.html('<span style="color:#ef4444;">' + response.message + '</span>').show();
                        $('#invite-email').prop('disabled', false);
                        $('#btn-invite-submit').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    var errorMsg = 'Failed to send invitation. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
                        errorMsg = xhr.responseJSON.errors.email[0];
                    }
                    $messageDiv.html('<span style="color:#ef4444;">' + errorMsg + '</span>').show();
                    $('#invite-email').prop('disabled', false);
                    $('#btn-invite-submit').prop('disabled', false);
                    checkSeatLimit();
                }
            });
        });
    });
</script>
@endsection

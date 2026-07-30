@extends('layouts.portal')

@section('portal_content')
    <section id="section-subscriptions" class="portal-section active">
        <header class="section-header section-header-flex">
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Subscriptions</h1>
                </div>
                <p class="header-subtitle">Manage your subscriptions, book recipients, and add-ons.</p>
            </div>

        </header>

        @if($sub['status'] !== 'None')
        <!-- Card 1: One-Year Subscription -->
        <div class="subscription-card">
            <div class="subscription-card-header">
                <div class="subscription-card-title-container">
                    <h2 class="subscription-card-title">{{ $sub['stripe_product_name'] ?? '' }}</h2>
                </div>
                <div>
                    <a href="{{ route('auth.account.subscriptions.add') }}" class="btn-add-subscription">
                        <i class="bi bi-plus-lg"></i> Add Subscription
                    </a>
                </div>
            </div>
            <div class="subscription-card-body">
                @php
                    $status = 'Active';
                    $statusClass = 'badge-active';
                    
                    $localStatus = strtolower($sub['status'] ?? 'active');
                    if ($localStatus === 'expired' || $localStatus === 'none') {
                        $status = ucfirst($localStatus);
                        $statusClass = 'badge-inactive';
                    } elseif (isset($sub['stripe_data']) && $sub['stripe_data']) {
                        $status = ucfirst($sub['stripe_data']->status);
                        if (strtolower($status) !== 'active' && strtolower($status) !== 'trialing') {
                            $statusClass = 'badge-inactive';
                        }
                    } else {
                        $status = ucfirst($sub['status'] ?? 'Active');
                        if (strtolower($status) !== 'active' && strtolower($status) !== 'trialing') {
                            $statusClass = 'badge-inactive';
                        }
                    }
                @endphp
                <table class="subscription-info-table">
                    <tbody>
                        <tr>
                            <td class="subscription-info-label">Status</td>
                            <td class="subscription-info-value">
                                <span class="{{ $statusClass }}">{{ $status }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Started</td>
                            <td class="subscription-info-value">{{ $sub['start'] ?? 'N/A' }}</td>
                        </tr>
                        @php
                            $isRecurring = false;
                            if (isset($sub['stripe_data']) && $sub['stripe_data']) {
                                if (!$sub['stripe_data']->cancel_at_period_end) {
                                    $isRecurring = true;
                                }
                            }
                        @endphp
                        <tr>
                            <td class="subscription-info-label">Expires</td>
                            <td class="subscription-info-value">{{ $sub['end'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Renewal</td>
                            <td class="subscription-info-value">
                                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%; flex-wrap: wrap; gap: 8px;">
                                    <div id="auto-renew-status-container">
                                        {{ $sub['end'] ?? 'N/A' }} 
                                        @if($isRecurring)
                                            <span style="background-color: #d1fae5; color: #065f46; font-size: 11px; padding: 2px 8px; border-radius: 12px; margin-left: 8px; font-weight: 500; display: inline-block;">Auto-renews</span>
                                        @else
                                            <span style="background-color: #f1f5f9; color: #475569; font-size: 11px; padding: 2px 8px; border-radius: 12px; margin-left: 8px; font-weight: 500; display: inline-block;">No auto-renew</span>
                                        @endif
                                    </div>
                                    <div style="display: flex; align-items: center; margin-right: 8px;">
                                        @if($sub['status'] !== 'None' && isset($sub['stripe_data']) && $sub['stripe_data'] && $sub['stripe_data']->status !== 'canceled')
                                            <!-- Cancel Form -->
                                            <form id="cancel-renew-form" action="{{ route('auth.account.subscriptions.cancel') }}" method="POST" style="margin: 0; display: {{ $isRecurring ? 'inline-block' : 'none' }}; vertical-align: middle;">
                                                {{ csrf_field() }}
                                                <label style="position: relative; display: inline-block; width: 44px; height: 24px; margin: 0; cursor: pointer;">
                                                    <input type="checkbox" checked onchange="confirmAutoRenewToggle(this, false)" style="opacity: 0; width: 0; height: 0; position: absolute;">
                                                    <span style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #10b981; transition: .3s; border-radius: 24px;">
                                                        <span style="position: absolute; height: 16px; width: 16px; left: 24px; bottom: 4px; background-color: white; transition: .3s; border-radius: 50%; display: block;"></span>
                                                    </span>
                                                </label>
                                            </form>

                                            <!-- Reactivate Form -->
                                            <form id="reactivate-renew-form" action="{{ route('auth.account.subscriptions.reactivate_auto_renew') }}" method="POST" style="margin: 0; display: {{ !$isRecurring ? 'inline-block' : 'none' }}; vertical-align: middle;">
                                                {{ csrf_field() }}
                                                <label style="position: relative; display: inline-block; width: 44px; height: 24px; margin: 0; cursor: pointer;">
                                                    <input type="checkbox" onchange="confirmAutoRenewToggle(this, true)" style="opacity: 0; width: 0; height: 0; position: absolute;">
                                                    <span style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: #cbd5e1; transition: .3s; border-radius: 24px;">
                                                        <span style="position: absolute; height: 16px; width: 16px; left: 4px; bottom: 4px; background-color: white; transition: .3s; border-radius: 50%; display: block;"></span>
                                                    </span>
                                                </label>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="subscription-info-label">Seats</td>
                            <td class="subscription-info-value"><span id="seats-summary-count">{{ count($sub['addons']) }}</span> of {{ (int) ($sub['base_account']->additional_online_users ?? 0) }} used</td>
                        </tr>
                        <tr>
                            <td class="subscription-info-label">Add-ons</td>
                            <td class="subscription-info-value text-normal-lh-14">
                                @php
                                    $addonsList = [];
                                    if (!empty($sub['books']) && count($sub['books']) > 0) {
                                        $addonsList[] = "Print Edition (" . count($sub['books']) . " " . (count($sub['books']) === 1 ? 'copy' : 'copies') . ")";
                                    }
                                    $totalSeats = (int) ($sub['base_account']->additional_online_users ?? 0);
                                    if ($totalSeats > 0) {
                                        $addonsList[] = "Additional Seats (" . $totalSeats . ")";
                                    }
                                    $addonsText = !empty($addonsList) ? implode(' + ', $addonsList) : ' — ';
                                @endphp
                                {{ $addonsText }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <div class="subscription-card-footer">
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
            </div> -->
        </div>

        <!-- Team Members Card -->
        <div class="subscription-card" style="margin-top: 24px;">
            <div style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;">
                    <div style="font-size: 15px; font-weight: 600; color: #1e293b;">
                        Team Members (<span id="team-seats-count">{{ count($sub['addons']) }}</span> of {{ (int) ($sub['base_account']->additional_online_users ?? 0) }} seats)
                    </div>
                    <div>
                        <button type="button" class="btn-add-subscription btn-trigger-purchase-seats">
                            <i class="bi bi-person-plus"></i> Purchase Additional Seats
                        </button>
                    </div>
                </div>
                <div>
                    @if((int) ($sub['base_account']->additional_online_users ?? 0) > 0)
                        <!-- Seats Progress Bar -->
                        <div class="seats-progress-container">
                            <div class="seats-progress-header">
                                <span class="seats-progress-text">Seats: <strong id="progress-seats-used">{{ count($sub['addons']) }}</strong> of <strong id="progress-seats-total">{{ (int) ($sub['base_account']->additional_online_users ?? 0) }}</strong></span>
                                <span class="seats-progress-available"><span id="progress-seats-available">{{ max(0, (int) ($sub['base_account']->additional_online_users ?? 0) - count($sub['addons'])) }}</span> available</span>
                            </div>
                            <div class="seats-progress-bar-track">
                                <div class="seats-progress-bar-fill" style="width: {{ (int) ($sub['base_account']->additional_online_users ?? 0) > 0 ? min(100, (count($sub['addons']) / (int) ($sub['base_account']->additional_online_users)) * 100) : 0 }}%;"></div>
                            </div>
                        </div>

                        <!-- Team Members Header -->
                        <div class="team-header-container">
                            <span class="team-header-title">Team Members</span>
                            <span class="team-header-badge" id="team-active-badge">{{ $sub['addons']->where('verified', 1)->count() }} active</span>
                        </div>

                        <table class="team-table" id="team-members-table">
                            <thead>
                                <tr>
                                    <th class="th-w-20">Name</th>
                                    <th class="th-w-30">Email</th>
                                    <th class="th-w-15">Role</th>
                                    <th class="th-w-15">Status</th>
                                    <th class="th-w-20">Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($sub['addons'] as $addon)
                                <tr data-addon-id="{{ $addon->id }}" data-user-email="{{ $addon->email }}">
                                    <td><span class="team-member-name">{{ trim($addon->name()) ?: '' }}</span></td>
                                    <td><span class="team-member-email">{{ $addon->email }}</span></td>
                                    <td><span class="team-member-role">Member</span></td>
                                    <td>
                                        @if($addon->verified)
                                            <span class="badge-team-active">Active</span>
                                        @else
                                            <span class="badge-team-pending">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="flex-center-gap-12">
                                            <button type="button" class="btn-member-manage btn-reassign-addon" data-id="{{ $addon->id }}" data-name="{{ trim($addon->name()) ?: '' }}">
                                                <i class="bi bi-arrow-repeat"></i> Reassign
                                            </button>
                                            <button type="button" class="btn-member-remove btn-remove-addon" data-id="{{ $addon->id }}">
                                                <i class="bi bi-trash"></i> Remove
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div style="text-align: center; padding: 48px 0; color: #64748b; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1; margin-top: 16px;">
                            <div style="font-size: 24px; color: #94a3b8; margin-bottom: 12px;"><i class="bi bi-people"></i></div>
                            <p style="margin: 0 0 8px 0; font-size: 15px; font-weight: 500; color: #475569;">You do not have any additional team seats.</p>
                            <p style="margin: 0; font-size: 13.5px;">Click <strong>Purchase Additional Seats</strong> above to add members to your team.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Purchased Add-ons Card -->
        <div class="subscription-card" style="margin-top: 24px;">
            <div style="padding: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 24px;">
                    <div style="font-size: 15px; font-weight: 600; color: #1e293b;">
                        Purchased add-ons
                    </div>
                    <div>
                        <a href="{{ route('subscriptions.book-only') }}" class="btn-add-subscription">
                            <i class="bi bi-cart-plus"></i> Purchase Add-ons
                        </a>
                    </div>
                </div>
                <div>
                    @if(count($purchasedAddons) > 0)
                        <!-- Purchased Add-ons Table -->
                        <div style="overflow-x: auto;">
                            <table class="team-table" id="purchased-addons-table">
                                <thead>
                                    <tr>
                                        <th class="th-w-37">Add-on Name</th>
                                        <th class="th-w-30">Type</th>
                                        <th class="th-w-13">Price</th>
                                        <th class="th-w-20">Purchase Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchasedAddons as $addon)
                                    <tr>
                                        <td>
                                            <span class="team-member-name" style="font-weight: 600; color: #0f172a;">
                                                {{ $addon['name'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="team-member-email" style="color: #475569;">
                                                {{ $addon['type'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="team-member-role" style="color: #475569; font-weight: 500;">
                                                {{ $addon['price'] }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="team-member-email" style="color: #475569;">
                                                {{ $addon['date'] }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div style="text-align: center; padding: 48px 0; color: #64748b; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                            <div style="font-size: 24px; color: #94a3b8; margin-bottom: 12px;"><i class="bi bi-gift"></i></div>
                            <p style="margin: 0 0 8px 0; font-size: 15px; font-weight: 500; color: #475569;">You do not have any purchased add-ons.</p>
                            <p style="margin: 0; font-size: 13.5px;">Purchase add-ons to enhance your subscription.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="subscription-card subscription-card-empty">
            <p class="subscription-card-empty-text">You do not have an active subscription.</p>
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
                    <form action="{{ route('auth.account.subscriptions.cancel') }}" method="POST" class="form-inline-m0">
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
            <div class="modal-card modal-card-sm">
                <div class="modal-header modal-header-confirm">
                    <div class="flex-column-gap-4">
                        <h3 class="modal-title">Reassign Seat</h3>
                        <p class="modal-header-subtext">Replace <strong>Sarah Johnson</strong> with a new team member.</p>
                    </div>
                </div>
                <div class="modal-body modal-body-mt-16">
                    <div class="form-group form-group-mb-24">
                        <label class="form-label-custom-sm">Email</label>
                        <input type="email" id="reassign-new-email" class="form-input form-input-custom" placeholder="jane@example.com">
                    </div>
                    <div id="reassign-message" style="display:none; font-size:12.5px; margin-top: 4px; font-weight: 500;"></div>
                </div>
                <div class="modal-footer modal-footer-confirm-sm">
                    <button type="button" class="btn-cancel btn-modal-cancel" id="btn-cancel-reassign">
                        Cancel
                    </button>
                    <button type="button" class="btn-reassign btn-modal-primary" id="btn-reassign-submit">
                        Reassign
                    </button>
                </div>
            </div>
        </div>

        <!-- Remove Team Member Modal -->
        <div id="remove-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card modal-card-sm">
                <div class="modal-header modal-header-confirm">
                    <div class="flex-column-gap-4">
                        <h3 class="modal-title">Remove Team Member</h3>
                        <p class="modal-body-text-confirm-p">Remove <strong>Sarah Johnson</strong> (sarah@example.com) from this subscription? They will lose access immediately.</p>
                    </div>
                </div>
                <div class="modal-footer modal-footer-confirm">
                    <button type="button" class="btn-cancel btn-modal-cancel" id="btn-cancel-remove">
                        Cancel
                    </button>
                    <button type="button" class="btn-reassign btn-modal-danger" id="btn-remove-submit">
                        Remove
                    </button>
                </div>
            </div>
        </div>

        <!-- Auto-Renew Toggle Confirmation Modal -->
        <div id="auto-renew-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card modal-card-sm">
                <div class="modal-header modal-header-confirm">
                    <div class="flex-column-gap-4">
                        <h3 class="modal-title" id="auto-renew-title">Turn Off Auto-Renew</h3>
                        <p class="modal-body-text-confirm-p" id="auto-renew-body">Are you sure you want to turn off auto-renewal? Your subscription will remain active until the end of your billing cycle.</p>
                    </div>
                </div>
                <div class="modal-footer modal-footer-confirm">
                    <button type="button" class="btn-cancel btn-modal-cancel" id="btn-auto-renew-cancel">
                        Cancel
                    </button>
                    <button type="button" class="btn-reassign btn-modal-danger" id="btn-auto-renew-submit">
                        Turn Off
                    </button>
                </div>
            </div>
        </div>

        <!-- Purchase Seats Modal -->
        <div id="purchase-seats-main-modal" class="modal-backdrop" style="display: none;">
            <div class="modal-card">
                <form id="purchase-seats-form">
                    <div class="modal-header">
                        <h3 class="modal-title">Purchase Additional Seats</h3>
                    </div>
                    <div class="modal-body modal-body-mt-16">
                        <p class="text-muted-135-mb-16" style="margin-bottom: 16px; font-size: 13.5px; color: #64748b;">
                            Add more seats at ${{ number_format(config('subscriptions.additional_seat')) }}/seat/year.
                        </p>
                        
                        <div class="flex-col-gap-16-align-start" style="display: flex; flex-direction: column; gap: 16px;">
                            <div class="flex-col-gap-6-w-full" style="width: 100%;">
                                <label class="form-label-custom-gray" style="margin-bottom: 6px; font-size: 12.5px; font-weight: 500; color: #64748b; display: block;">Number of seats</label>
                                <div class="flex-center-gap-12" style="display: flex; align-items: center; gap: 12px;">
                                    <input type="number" id="purchase-seats-input" min="1" max="50" value="1" class="input-number-seats form-input" style="width: 80px;">
                                    <span class="text-muted-135-fw-500" style="color: #64748b; font-size: 13.5px; font-weight: 500;">
                                        = <strong class="text-dark-bold" style="color: #0f172a; font-weight: 700;">$<span id="purchase-total-price">{{ config('subscriptions.additional_seat') }}</span></strong>/year
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Dynamic Email Inputs Container -->
                            <div id="dynamic-emails-container" style="width: 100%; display: flex; flex-direction: column; gap: 12px; margin-top: 8px; max-height: 250px; overflow-y: auto; padding-right: 8px;">
                                <!-- Initially 1 input field -->
                                <div class="flex-col-gap-6-w-full" style="width: 100%;">
                                    <label class="form-label-custom-gray" style="margin-bottom: 6px; font-size: 12.5px; font-weight: 500; color: #64748b; display: block;">Email for Seat 1</label>
                                    <input type="email" class="form-input dynamic-invite-email" placeholder="colleague1@example.com" required style="width: 100%;">
                                </div>
                            </div>
                            <div id="dynamic-emails-error" style="display: none; color: #ef4444; font-size: 13px; font-weight: 500;"></div>

                            <!-- Payment Details -->
                            <hr style="width: 100%; border-color: #e2e8f0; margin-top: 8px; margin-bottom: 8px;">
                            <h4 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 0px;">Payment Details</h4>
                            <div id="stripe-modal-error-message" class="alert alert-danger" style="display: none; padding: 10px 12px; border-radius: 6px; margin-bottom: 8px; font-size: 13px; background-color: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; width: 100%;"></div>

                            <div class="form-group form-group-mb-16" style="width: 100%; margin-bottom: 8px;">
                                <label class="form-label-custom-gray" style="display: block; margin-bottom: 6px; font-size: 12.5px; font-weight: 500; color: #64748b;">Name on Card</label>
                                <input type="text" id="stripe-modal-card-name" class="form-input form-input-custom" value="{{ $sub['base_account']->first_name ?? '' }} {{ $sub['base_account']->last_name ?? '' }}" placeholder="Cardholder Name" style="width: 100%; height: 38px; box-sizing: border-box;">
                            </div>

                            <div class="form-group form-group-mb-16" style="width: 100%; margin-bottom: 8px;">
                                <label class="form-label-custom-gray" style="display: block; margin-bottom: 6px; font-size: 12.5px; font-weight: 500; color: #64748b;">Card Details</label>
                                <div id="stripe-modal-card-element" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; background-color: #ffffff; min-height: 40px; box-sizing: border-box; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-confirm-sm" style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
                        <button type="button" class="btn-cancel btn-modal-cancel" id="btn-cancel-purchase-main" style="padding: 8px 16px; border: 1px solid #cbd5e1; background: white; border-radius: 6px; font-weight: 500; color: #475569;">
                            Cancel
                        </button>
                        <button type="submit" class="btn-purchase-submit btn-modal-primary" id="btn-purchase-submit-confirm" style="padding: 8px 16px; background: #0f172a; color: white; border: none; border-radius: 6px; font-weight: 500;">
                            <i class="bi bi-person-plus"></i> Pay $<span id="modal-seats-pay-btn-amount">{{ config('subscriptions.additional_seat') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Toast Notification -->
        <div id="custom-toast" class="portal-toast" style="display: none;">
            <h4 class="portal-toast-title" id="toast-title"></h4>
            <p class="portal-toast-body" id="toast-body"></p>
        </div>

    </section>
@endsection
@section('portal_scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(document).ready(function() {
        function showToast(title, body, isError = false) {
            $('#toast-title').text(title).css('color', isError ? '#ef4444' : '#10b981');
            $('#toast-body').text(body);
            $('#custom-toast').stop(true, true).fadeIn(300).delay(4000).fadeOut(300);
        }

        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                e.preventDefault();
            }
        });

        // Purchase Seats Main Modal Toggles
        $('.btn-trigger-purchase-seats').on('click', function(e) {
            e.preventDefault();
            $('#purchase-seats-main-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-cancel-purchase-main').on('click', function(e) {
            e.preventDefault();
            $('#purchase-seats-main-modal').fadeOut(150);
            $('#purchase-seats-input').val(1).trigger('change');
            $('#dynamic-emails-error').hide().empty();
            $('#stripe-modal-error-message').hide().empty();
            if (cardElement) {
                cardElement.clear();
            }
        });

        // Stripe Init
        var stripe, elements, cardElement;
        function initStripe() {
            var stripeKey = '{{ config('app.STRIPE_PUB_KEY') ?: 'pk_test_TYooMQauvdEDq54NiTphI7jx' }}';
            if (!stripeKey) return;
            try {
                stripe = Stripe(stripeKey);
                elements = stripe.elements();
                cardElement = elements.create('card', {
                    style: {
                        base: {
                            color: '#0f172a',
                            fontFamily: '"Inter", "Helvetica Neue", Helvetica, sans-serif',
                            fontSmoothing: 'antialiased',
                            fontSize: '15px',
                            '::placeholder': {
                                color: '#94a3b8'
                            }
                        },
                        invalid: {
                            color: '#ef4444',
                            iconColor: '#ef4444'
                        }
                    }
                });
                cardElement.mount('#stripe-modal-card-element');
            } catch (err) {
                console.error('Stripe init error:', err);
            }
        }
        initStripe();

        // Dynamic email inputs and price calculation
        $('#purchase-seats-input').on('input change', function() {
            var count = parseInt($(this).val());
            if (isNaN(count) || count < 1) {
                count = 1;
                $(this).val(1);
            }
            if (count > 50) {
                count = 50;
                $(this).val(50);
            }
            
            var price = count * {{ config('subscriptions.additional_seat') }};
            $('#purchase-total-price').text(price);
            $('#modal-seats-pay-btn-amount').text(price);
            
            // Generate email input fields
            var container = $('#dynamic-emails-container');
            container.empty();
            
            for (var i = 1; i <= count; i++) {
                var fieldHtml = `
                    <div class="flex-col-gap-6-w-full" style="width: 100%;">
                        <label class="form-label-custom-gray" style="margin-bottom: 6px; font-size: 12.5px; font-weight: 500; color: #64748b; display: block;">Email for Seat ${i}</label>
                        <input type="email" class="form-input dynamic-invite-email" placeholder="colleague${i}@example.com" required style="width: 100%;">
                    </div>
                `;
                container.append(fieldHtml);
            }
        });

        // Show Stripe Modal on "Add Seats" click after validation
        $('#purchase-seats-form').on('submit', async function(e) {
            e.preventDefault();
            var count = parseInt($('#purchase-seats-input').val()) || 1;
            
            // Validate emails
            var emails = [];
            var isValid = true;
            var errorMsg = '';
            var emailRegex = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var ownerEmail = '{{ strtolower(Auth::user()->email) }}';
            var existingAddons = {!! json_encode($sub['addons']->pluck('email')->map(function($e) { return strtolower($e); })->toArray()) !!};
            
            $('.dynamic-invite-email').each(function() {
                var email = $.trim($(this).val());
                var emailLower = email.toLowerCase();
                if (!email) {
                    isValid = false;
                    errorMsg = 'Please fill in all email fields.';
                    return false; // break loop
                }
                if (!emailRegex.test(email)) {
                    isValid = false;
                    errorMsg = 'Please enter valid email addresses.';
                    return false; // break loop
                }
                if (emailLower === ownerEmail) {
                    isValid = false;
                    errorMsg = 'You cannot assign a seat to yourself (the subscription owner).';
                    return false; // break loop
                }
                if (existingAddons.includes(emailLower)) {
                    isValid = false;
                    errorMsg = 'Email "' + email + '" is already a member of this subscription.';
                    return false; // break loop
                }
                if (emails.includes(emailLower)) {
                    isValid = false;
                    errorMsg = 'Duplicate emails found. Each seat must have a unique email.';
                    return false; // break loop
                }
                emails.push(emailLower);
            });
            
            if (!isValid) {
                $('#dynamic-emails-error').text(errorMsg).show();
                return;
            }

            // Check if any email already has an active subscription elsewhere
            var checkPromises = emails.map(function(email) {
                return $.ajax({
                    url: '/api/check-subscriber',
                    method: 'POST',
                    data: {
                        email: email,
                        _token: '{{ csrf_token() }}'
                    }
                }).then(function(res) {
                    if (res.success && res.has_subscription) {
                        return email;
                    }
                    return null;
                });
            });

            try {
                var results = await Promise.all(checkPromises);
                var activeEmails = results.filter(Boolean);
                if (activeEmails.length > 0) {
                    var conflictEmail = activeEmails[0];
                    $('#dynamic-emails-error').text('Email "' + conflictEmail + '" already has an active subscription or is a member of another subscription.').show();
                    return;
                }
            } catch (err) {
                console.error('Failed to validate emails:', err);
            }
            
            $('#dynamic-emails-error').hide();
            
            // Store emails globally for the final submit
            window.pendingInviteEmails = emails;

            var $btn = $('#btn-purchase-submit-confirm');
            var originalText = $btn.html();
            var nameOnCard = $('#stripe-modal-card-name').val();
            
            if (!nameOnCard) {
                $('#stripe-modal-error-message').text('Please enter the name on the card.').show();
                return;
            }

            if (!stripe || !cardElement) {
                $('#stripe-modal-error-message').text('Payment system is not initialized properly. Please refresh the page.').show();
                return;
            }

            $('#stripe-modal-error-message').hide();
            $btn.prop('disabled', true).text('Processing...');

            try {
                const { token, error } = await stripe.createToken(cardElement, {
                    name: nameOnCard
                });

                if (error) {
                    $('#stripe-modal-error-message').text(error.message).show();
                    $btn.prop('disabled', false).html(originalText);
                    return;
                }

                $.ajax({
                    url: "{{ route('auth.account.subscriptions.seats.purchase') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        seats: count,
                        stripe_token: token.id
                    }),
                    success: function(res) {
                        if (res.success) {
                            $('#purchase-seats-main-modal').fadeOut(150);
                            showToast('Success', 'Payment successful! Sending invitations...', false);
                            
                            // Send invites
                            let emailsToInvite = window.pendingInviteEmails || [];
                            if (emailsToInvite.length > 0) {
                                let invitePromises = emailsToInvite.map(function(email) {
                                    return $.ajax({
                                        url: '{{ route("auth.account.subscriptions.addons.invite") }}',
                                        method: 'POST',
                                        data: {
                                            email: email,
                                            _token: '{{ csrf_token() }}'
                                        }
                                    });
                                });

                                Promise.allSettled(invitePromises).then(function(results) {
                                    $btn.prop('disabled', false).html(originalText);
                                    let successCount = 0;
                                    results.forEach(result => {
                                        if (result.status === 'fulfilled' && result.value.success) {
                                            successCount++;
                                        }
                                    });
                                    showToast('Success', `Successfully sent ${successCount} out of ${emailsToInvite.length} invitations.`, false);
                                    
                                    // Reload to fetch updated table and state since a bulk update occurred
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 1500);
                                });
                            } else {
                                $btn.prop('disabled', false).html(originalText);
                                window.location.reload();
                            }
                        } else {
                            $btn.prop('disabled', false).html(originalText);
                            $('#stripe-modal-error-message').text(res.message || 'Payment failed. Please try again.').show();
                        }
                    },
                    error: function(err) {
                        $btn.prop('disabled', false).html(originalText);
                        let msg = 'An error occurred. Please try again.';
                        if (err.responseJSON && err.responseJSON.message) {
                            msg = err.responseJSON.message;
                        }
                        $('#stripe-modal-error-message').text(msg).show();
                    }
                });

            } catch (err) {
                console.error(err);
                $('#stripe-modal-error-message').text('An unexpected error occurred. Please try again.').show();
                $btn.prop('disabled', false).html(originalText);
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

        // Reassign modal event listeners
        var addonIdToReassign = null;
        var $rowToReassign = null;
        $(document).on('click', '.btn-reassign-addon', function(e) {
            e.preventDefault();
            addonIdToReassign = $(this).data('id');
            var name = $(this).data('name');
            $rowToReassign = $(this).closest('tr');
            
            var email = $rowToReassign.attr('data-user-email') || '';
            
            $('#reassign-modal').find('.modal-header-subtext').html('Replace <strong>' + name + '</strong> with a new team member.');
            $('#reassign-new-email').val(email);
            $('#reassign-message').hide().empty();
            $('#reassign-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-cancel-reassign, #btn-close-reassign-modal').on('click', function(e) {
            e.preventDefault();
            $('#reassign-modal').fadeOut(150);
            $('#reassign-new-email').val('');
            $('#reassign-message').hide().empty();
        });

        $('#btn-reassign-submit').on('click', function(e) {
            e.preventDefault();
            if (!addonIdToReassign) return;
            
            var email = $.trim($('#reassign-new-email').val());
            var $messageDiv = $('#reassign-message');

            if (!email) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter an email address.</span>').show();
                return;
            }

            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(email)) {
                $messageDiv.html('<span style="color:#ef4444;">Please enter a valid email address.</span>').show();
                return;
            }

            var $btn = $(this);
            $btn.prop('disabled', true).text('Reassigning...');
            $messageDiv.html('<span style="color:#475569;">Reassigning seat...</span>').show();

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.reassign") }}',
                method: 'POST',
                data: {
                    id: addonIdToReassign,
                    name: '',
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $btn.prop('disabled', false).text('Reassign');
                    if (response.success) {
                        $('#reassign-modal').fadeOut(150);
                        showToast('Success', response.message || 'Seat reassigned successfully.', false);
                        
                        // Update the row values dynamically in the table
                        $rowToReassign.attr('data-addon-id', response.addon.id);
                        $rowToReassign.attr('data-user-email', response.addon.email);
                        $rowToReassign.find('.team-member-name').text(response.addon.name);
                        $rowToReassign.find('.team-member-email').text(response.addon.email);
                        
                        var $statusSpan = $rowToReassign.find('td:nth-child(4) span');
                        if (response.addon.status === 'Active') {
                            $statusSpan.attr('class', 'badge-team-active').text('Active');
                        } else {
                            $statusSpan.attr('class', 'badge-team-pending').text('Pending');
                        }

                        // Update data attributes on reassign button
                        var $reassignBtn = $rowToReassign.find('.btn-reassign-addon');
                        $reassignBtn.attr('data-id', response.addon.id);
                        $reassignBtn.attr('data-name', response.addon.name);

                        // Update delete button data ID
                        $rowToReassign.find('.btn-remove-addon').attr('data-id', response.addon.id);

                        // Update active badge count
                        var activeBadgeCount = 0;
                        $('#team-members-table tbody tr').each(function() {
                            if ($(this).find('.badge-team-active').length > 0) {
                                activeBadgeCount++;
                            }
                        });
                        $('#team-active-badge').text(activeBadgeCount + ' active');
                    } else {
                        $messageDiv.html('<span style="color:#ef4444;">' + response.message + '</span>').show();
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).text('Reassign');
                    var errorMsg = 'Failed to reassign seat.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    $messageDiv.html('<span style="color:#ef4444;">' + errorMsg + '</span>').show();
                }
            });
        });

        // Remove modal event listeners
        var addonIdToRemove = null;
        var $rowToRemove = null;
        $(document).on('click', '.btn-remove-addon', function(e) {
            e.preventDefault();
            addonIdToRemove = $(this).data('id');
            $rowToRemove = $(this).closest('tr');
            var name = $rowToRemove.find('.team-member-name').text();
            var email = $rowToRemove.find('.team-member-email').text();
            $('#remove-modal').find('.modal-body-text-confirm-p').html('Remove <strong>' + name + '</strong> (' + email + ') from this subscription? They will lose access immediately.');
            $('#remove-modal').fadeIn(150).css('display', 'flex');
        });

        $('#btn-cancel-remove, #btn-close-remove-modal').on('click', function(e) {
            e.preventDefault();
            $('#remove-modal').fadeOut(150);
        });

        $('#btn-remove-submit').on('click', function(e) {
            e.preventDefault();
            if (!addonIdToRemove) return;
            
            var $btn = $(this);
            $btn.prop('disabled', true).text('Removing...');

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.remove") }}',
                method: 'POST',
                data: {
                    id: addonIdToRemove,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $btn.prop('disabled', false).text('Remove');
                    $('#remove-modal').fadeOut(150);
                    if (response.success) {
                        $rowToRemove.remove();
                        showToast('Success', response.message || 'User removed successfully.', false);
                        // Update counts
                        var totalSeats = $('#team-members-table tbody tr[data-addon-id]').length;
                        $('#team-seats-count').text(totalSeats);
                        $('#seats-summary-count').text(totalSeats);
                        
                        // Update active badge count
                        var activeBadgeCount = 0;
                        $('#team-members-table tbody tr').each(function() {
                            if ($(this).find('.badge-team-active').length > 0) {
                                activeBadgeCount++;
                            }
                        });
                        $('#team-active-badge').text(activeBadgeCount + ' active');

                        checkSeatLimit();
                    } else {
                        showToast('Error', response.message || 'Failed to remove user.', true);
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).text('Remove');
                    var errorMsg = 'Failed to remove user.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showToast('Error', errorMsg, true);
                }
            });
        });

        // Check seat limit function
        function checkSeatLimit() {
            var count = $('#team-members-table tbody tr[data-addon-id]').length;
            var maxSeats = {{ (int) ($sub['base_account']->additional_online_users ?? 0) }};
            var available = maxSeats - count;
            if (available < 0) available = 0;

            // Update progress bar UI
            $('#progress-seats-used').text(count);
            $('#progress-seats-available').text(available);
            var percent = maxSeats > 0 ? (count / maxSeats) * 100 : 0;
            if (percent > 100) percent = 100;
            $('.seats-progress-bar-fill').css('width', percent + '%');

            if (count >= maxSeats) {
                $('#invite-email').prop('disabled', true);
                $('#btn-invite-submit').prop('disabled', true);
                $('#invite-message').html('<span style="color:#ef4444;">You have reached the limit of ' + maxSeats + ' seats. Remove a member to invite more.</span>').show();
            } else {
                $('#invite-email').prop('disabled', false);
                $('#btn-invite-submit').prop('disabled', false);
                
                var currentHtml = $('#invite-message').html() || '';
                if (currentHtml.indexOf('color:#ef4444') !== -1 || currentHtml.indexOf('limit') !== -1) {
                    $('#invite-message').hide();
                }
            }
        }

        $('#invite-email').on('input', function() {
            $('#invite-message').hide();
        });

        // Call initially
        checkSeatLimit();

        // Invite Colleague Handler
        $('#btn-invite-submit').on('click', function(e) {
            e.preventDefault();
            var email = $.trim($('#invite-email').val());
            var $messageDiv = $('#invite-message');

            if (!email) {
                showToast('Validation Error', 'Please enter an email address.', true);
                return;
            }

            // Simple email format check
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            if(!emailReg.test(email)) {
                showToast('Validation Error', 'Please enter a valid email address.', true);
                return;
            }

            // Disable UI
            $('#invite-email').prop('disabled', true);
            $('#btn-invite-submit').prop('disabled', true);
            $messageDiv.html('<span style="color:#475569;"><i class="bi bi-hourglass-split"></i> Sending invitation...</span>').show();

            $.ajax({
                url: '{{ route("auth.account.subscriptions.addons.invite") }}',
                method: 'POST',
                data: {
                    email: email,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $messageDiv.hide();
                    if (response.success) {
                        $('#invite-email').val('');
                        showToast('Success', response.message, false);
                        
                        // Append new member to table
                        var newRow = `
                            <tr data-addon-id="${response.addon.id}" data-user-email="${response.addon.email}">
                                <td><span class="team-member-name">${response.addon.name}</span></td>
                                <td><span class="team-member-email">${response.addon.email}</span></td>
                                <td><span class="team-member-role">${response.addon.role}</span></td>
                                <td>
                                    <span class="${response.addon.status === 'Active' ? 'badge-team-active' : 'badge-team-pending'}">
                                        ${response.addon.status}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex-center-gap-12">
                                        <button type="button" class="btn-member-manage btn-reassign-addon" data-id="${response.addon.id}" data-name="${response.addon.name}">
                                            <i class="bi bi-arrow-repeat"></i> Reassign
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
                        var totalSeats = $('#team-members-table tbody tr[data-addon-id]').length;
                        $('#team-seats-count').text(totalSeats);
                        $('#seats-summary-count').text(totalSeats);

                        // Update active badge count
                        var activeBadgeCount = 0;
                        $('#team-members-table tbody tr').each(function() {
                            if ($(this).find('.badge-team-active').length > 0) {
                                activeBadgeCount++;
                            }
                        });
                        $('#team-active-badge').text(activeBadgeCount + ' active');

                        // Re-enable/Check Limits
                        checkSeatLimit();
                    } else {
                        showToast('Error', response.message || 'Failed to send invitation.', true);
                        $('#invite-email').prop('disabled', false);
                        $('#btn-invite-submit').prop('disabled', false);
                    }
                },
                error: function(xhr) {
                    $messageDiv.hide();
                    var errorMsg = 'Failed to send invitation. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
                        errorMsg = xhr.responseJSON.errors.email[0];
                    }
                    showToast('Error', errorMsg, true);
                    $('#invite-email').prop('disabled', false);
                    $('#btn-invite-submit').prop('disabled', false);
                    checkSeatLimit();
                }
            });
        });

        // Auto Renew Toggle Modal Handler
        var autoRenewTargetForm = null;
        var autoRenewTargetCheckbox = null;
        
        window.confirmAutoRenewToggle = function(input, turnOn) {
            autoRenewTargetCheckbox = input;
            autoRenewTargetForm = input.form;
            
            if (turnOn) {
                $('#auto-renew-title').text('Turn On Auto-Renew');
                $('#auto-renew-body').html('Are you sure you want to turn on auto-renewal for this subscription?');
                $('#btn-auto-renew-submit')
                    .text('Turn On')
                    .removeClass('btn-modal-danger')
                    .addClass('btn-modal-primary');
            } else {
                $('#auto-renew-title').text('Turn Off Auto-Renew');
                $('#auto-renew-body').html('Are you sure you want to turn off auto-renewal? Your subscription will remain active until <strong>{{ $sub['end'] }}</strong>.');
                $('#btn-auto-renew-submit')
                    .text('Turn Off')
                    .removeClass('btn-modal-primary')
                    .addClass('btn-modal-danger');
            }
            
            $('#auto-renew-modal').fadeIn(150).css('display', 'flex');
        };
        
        $('#btn-auto-renew-cancel').on('click', function(e) {
            e.preventDefault();
            $('#auto-renew-modal').fadeOut(150);
            if (autoRenewTargetCheckbox) {
                autoRenewTargetCheckbox.checked = !autoRenewTargetCheckbox.checked;
            }
        });
        
        $('#btn-auto-renew-submit').on('click', function(e) {
            e.preventDefault();
            if (!autoRenewTargetForm) return;
            
            var $btn = $(this);
            var originalText = $btn.text();
            $btn.prop('disabled', true).text('Processing...');
            
            var url = $(autoRenewTargetForm).attr('action');
            var data = $(autoRenewTargetForm).serialize();
            
            $.ajax({
                url: url,
                method: 'POST',
                data: data,
                success: function(response) {
                    $btn.prop('disabled', false).text(originalText);
                    $('#auto-renew-modal').fadeOut(150);
                    
                    if (response.success) {
                        showToast('Success', response.message, false);
                        
                        var endVal = "{{ $sub['end'] ?? 'N/A' }}";
                        
                        // Toggle forms & status container dynamically
                        if (url.indexOf('cancel') !== -1) {
                            // Turn Off Succeeded
                            $('#cancel-renew-form').hide();
                            $('#reactivate-renew-form').show();
                            $('#reactivate-renew-form').find('input[type="checkbox"]').prop('checked', false);
                            
                            $('#auto-renew-status-container').html(
                                endVal + ' <span style="background-color: #f1f5f9; color: #475569; font-size: 11px; padding: 2px 8px; border-radius: 12px; margin-left: 8px; font-weight: 500; display: inline-block;">No auto-renew</span>'
                            );
                        } else {
                            // Turn On Succeeded
                            $('#reactivate-renew-form').hide();
                            $('#cancel-renew-form').show();
                            $('#cancel-renew-form').find('input[type="checkbox"]').prop('checked', true);
                            
                            $('#auto-renew-status-container').html(
                                endVal + ' <span style="background-color: #d1fae5; color: #065f46; font-size: 11px; padding: 2px 8px; border-radius: 12px; margin-left: 8px; font-weight: 500; display: inline-block;">Auto-renews</span>'
                            );
                        }
                    } else {
                        showToast('Error', response.message || 'Operation failed.', true);
                        if (autoRenewTargetCheckbox) {
                            autoRenewTargetCheckbox.checked = !autoRenewTargetCheckbox.checked;
                        }
                    }
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).text(originalText);
                    $('#auto-renew-modal').fadeOut(150);
                    
                    var errorMsg = 'Failed to update auto-renewal settings.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    showToast('Error', errorMsg, true);
                    
                    if (autoRenewTargetCheckbox) {
                        autoRenewTargetCheckbox.checked = !autoRenewTargetCheckbox.checked;
                    }
                }
            });
        });
    });
</script>
@endsection


@extends('layouts.portal')

@section('portal_content')
    <section id="section-manage-subscription" class="portal-section active">
        <header class="section-header" style="align-items: center; width: 100%; margin-bottom: 24px; display: flex;">
            <a href="/account/subscriptions" style="text-decoration: none; color: #0f172a; display: flex; align-items: center; font-size: 18px; font-weight: 700; gap: 8px;">
                <i class="bi bi-arrow-left"></i> Manage Subscription
            </a>
        </header>

        <form id="manage-billing-form" onsubmit="event.preventDefault(); alert('Billing details updated successfully (Mock Action).'); window.location.href='/account/subscriptions';">
            <!-- Card 1: Billing Cycle -->
            <div class="manage-card">
                <div class="manage-card-header">
                    <h2 class="manage-card-title">Billing Cycle</h2>
                </div>
                <div class="manage-card-body">
                    <div class="billing-cycle-option">
                        <div class="billing-cycle-radio">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="billing-cycle-info">
                            <h3 class="billing-cycle-title">Annual $1,200 / year</h3>
                            <span class="billing-cycle-subtext">Your subscription will renew on January 15.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Update Payment Method -->
            <div class="manage-card">
                <div class="manage-card-header">
                    <h2 class="manage-card-title">Update Payment Method</h2>
                </div>
                <div class="manage-card-body">
                    <div class="form-group">
                        <label class="form-label" for="card-number">Card Number</label>
                        <div class="input-wrapper">
                            <i class="bi bi-credit-card input-icon"></i>
                            <input type="text" id="card-number" class="form-input form-input-with-icon" value="•••• •••• •••• 4242" placeholder="Card Number">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col form-group">
                            <label class="form-label" for="card-expiry">Expiry</label>
                            <input type="text" id="card-expiry" class="form-input" value="12/24" placeholder="MM/YY">
                        </div>
                        <div class="form-col form-group">
                            <label class="form-label" for="card-name">Name on Card</label>
                            <input type="text" id="card-name" class="form-input" value="John Smith" placeholder="Name on Card">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 12px; margin-top: 8px;">
                <button type="submit" class="btn-save-changes">
                    Save Changes
                </button>
                <a href="/account/subscriptions" class="btn-cancel-action">
                    Cancel
                </a>
            </div>
        </form>
    </section>
@endsection

@section('portal_styles')
<style>
    .btn-save-changes {
        background-color: var(--primary-color);
        color: #ffffff !important;
        border: none;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }
    .btn-save-changes:hover {
        background-color: #b91c1c;
    }
    .btn-cancel-action {
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        color: #475569 !important;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.15s ease-in-out;
    }
    .btn-cancel-action:hover {
        background-color: #f8fafc;
        color: #0f172a !important;
        border-color: #94a3b8;
    }

    .manage-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        margin-bottom: 24px;
        width: 100%;
        box-sizing: border-box;
    }
    .manage-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
    }
    .manage-card-title {
        font-size: 14px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .manage-card-body {
        padding: 24px;
    }

    .billing-cycle-option {
        border: 1px solid #fca5a5;
        background-color: #fef2f2;
        border-radius: 6px;
        padding: 16px 20px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .billing-cycle-radio {
        color: var(--primary-color);
        font-size: 18px;
        line-height: 1;
        margin-top: 2px;
    }
    .billing-cycle-info {
        display: flex;
        flex-direction: column;
    }
    .billing-cycle-title {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }
    .billing-cycle-subtext {
        font-size: 12px;
        color: #7f1d1d;
        margin-top: 4px;
        font-weight: 500;
    }

    /* Form Fields */
    .form-group {
        margin-bottom: 20px;
    }
    .form-group:last-child {
        margin-bottom: 0;
    }
    .form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
    }
    .input-wrapper {
        position: relative;
    }
    .input-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }
    .form-input {
        width: 100%;
        padding: 10px 12px;
        font-size: 13.5px;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        box-sizing: border-box;
        color: #0f172a;
        background-color: #ffffff;
        transition: border-color 0.15s ease;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    .form-input-with-icon {
        padding-left: 38px;
    }

    .form-row {
        display: flex;
        gap: 16px;
    }
    .form-col {
        flex: 1;
    }
</style>
@endsection

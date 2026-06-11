@extends('layouts.portal')

@section('portal_styles')
<style>
    .sub-option-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        flex: 1 1 450px;
        max-width: 520px;
        padding: 32px;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
    }
    .sub-option-title {
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 12px 0;
    }
    .sub-option-price-container {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 12px;
    }
    .sub-option-price {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
    }
    .sub-option-price-period {
        font-size: 13.5px;
        color: #64748b;
        font-weight: 500;
    }
    .sub-option-description {
        font-size: 13.0px;
        color: #64748b;
        line-height: 1.5;
        margin: 0 0 24px 0;
    }
    .sub-tier-section {
        border-top: 1px solid #f1f5f9;
        padding-top: 20px;
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
    }
    .sub-tier-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 12px 0;
    }
    .sub-feature-list {
        list-style: none;
        padding: 0;
        margin: 0 0 16px 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .sub-feature-list li {
        font-size: 13px;
        color: #475569;
        display: flex;
        align-items: center;
    }
    .feature-check {
        color: #16a34a;
        font-weight: bold;
        margin-right: 8px;
        font-size: 14px;
    }
    .btn-select-tier {
        background-color: var(--primary-color);
        color: #ffffff !important;
        border: none;
        border-radius: 6px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }
    .btn-select-tier:hover {
        background-color: #b91c1c;
        opacity: 0.9;
    }
    
    .addons-section {
        border-top: 1px solid #f1f5f9;
        padding-top: 20px;
        margin-top: auto; /* Push addons to bottom of card */
    }
    .addons-header {
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        letter-spacing: 0.05em;
        margin-bottom: 12px;
    }
    .addons-list {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 12px;
    }
    .addon-item {
        display: flex;
        justify-content: space-between;
        font-size: 12.5px;
        color: #475569;
        padding: 8px 0;
        border-bottom: 1px solid #e2e8f0;
    }
    .addon-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .addon-item:first-child {
        padding-top: 0;
    }
    .addon-item span:first-child {
        font-weight: 500;
    }
    .addon-item span:last-child {
        font-weight: 600;
        color: #0f172a;
    }
    .addons-footer-text {
        font-size: 11.5px;
        color: #94a3b8;
        font-style: normal;
        margin: 8px 0 0 0;
        text-align: center;
    }
</style>
@endsection

@section('portal_content')
    <section id="section-add-subscription" class="portal-section active">
        <!-- Header: Back Navigation -->
        <div style="margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 6px;">
                <a href="{{ route('auth.account.subscriptions') }}" style="color: #0f172a; text-decoration: none; font-size: 20px; display: inline-flex; align-items: center; font-weight: 700; gap: 10px;">
                    <i class="bi bi-arrow-left"></i>
                    <span>Add a Subscription</span>
                </a>
            </div>
            <p style="font-size: 14px; color: #64748b; margin: 0;">Choose a subscription to add to your account.</p>
        </div>

        <!-- Cards List -->
        <div style="display: flex; flex-wrap: wrap; gap: 24px; width: 100%;">
            <!-- Card 1: One-Year Subscription -->
            <div class="sub-option-card">
                <h2 class="sub-option-title">One-Year Subscription</h2>
                <div class="sub-option-price-container">
                    <span class="sub-option-price">$1,200</span>
                    <span class="sub-option-price-period">/ 1 year</span>
                </div>
                <p class="sub-option-description">
                    Get online access, Hot Sheets email alerts, and optional printed editions delivered to your door.
                </p>

                <!-- Sub-section 1: Online Access Only -->
                <div class="sub-tier-section">
                    <h3 class="sub-tier-title">Online Access Only</h3>
                    <ul class="sub-feature-list">
                        <li><i class="bi bi-check-lg feature-check"></i>1 online user account</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Full platform access</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Hot Sheets email alerts included</li>
                    </ul>
                    <a href="{{ route('subscriptions.one-year') }}" class="btn-select-tier select-addon-tier" data-plan="1yr_online">Select Online Access Only</a>
                </div>

                <!-- Sub-section 2: Online Access & Print -->
                <div class="sub-tier-section">
                    <h3 class="sub-tier-title">Online Access & Print</h3>
                    <ul class="sub-feature-list">
                        <li><i class="bi bi-check-lg feature-check"></i>1 online user account</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Full platform access</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Hot Sheets email alerts included</li>
                        <li><i class="bi bi-check-lg feature-check"></i>3 printed book editions</li>
                        <li><i class="bi bi-check-lg feature-check"></i>One book per mailing, three mailings per year</li>
                    </ul>
                    <a href="{{ route('subscriptions.one-year') }}" class="btn-select-tier select-addon-tier" data-plan="1yr_print">Select Online Access & Print</a>
                </div>

                <!-- Available Addons -->
                <div class="addons-section">
                    <div class="addons-header">AVAILABLE ADD-ONS</div>
                    <div class="addons-list">
                        <div class="addon-item">
                            <span>Additional Online User</span>
                            <span>$100/ea</span>
                        </div>
                        <div class="addon-item">
                            <span>Post-Election Deck Only (Subscriber)</span>
                            <span>$300</span>
                        </div>
                        <div class="addon-item">
                            <span>Post-Election Deck + Presentation (Subscriber)</span>
                            <span>$200</span>
                        </div>
                    </div>
                    <p class="addons-footer-text">Add-ons can be configured during checkout.</p>
                </div>
            </div>

            <!-- Card 2: Two-Year Subscription -->
            <div class="sub-option-card">
                <h2 class="sub-option-title">Two-Year Subscription</h2>
                <div class="sub-option-price-container">
                    <span class="sub-option-price">$2,200</span>
                    <span class="sub-option-price-period">/ 2 years</span>
                </div>
                <p class="sub-option-description">
                    Lock in two years of access, alerts, and optional print editions at a better value.
                </p>

                <!-- Sub-section 1: Two-Year Online Only -->
                <div class="sub-tier-section">
                    <h3 class="sub-tier-title">Two-Year Online Only</h3>
                    <ul class="sub-feature-list">
                        <li><i class="bi bi-check-lg feature-check"></i>1 online user account</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Full platform access for 2 years</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Hot Sheets email alerts included</li>
                    </ul>
                    <a href="{{ route('subscriptions.two-year') }}" class="btn-select-tier select-addon-tier" data-plan="2yr_online">Select Two-Year Online Only</a>
                </div>

                <!-- Sub-section 2: Two-Year Online & Print -->
                <div class="sub-tier-section">
                    <h3 class="sub-tier-title">Two-Year Online & Print</h3>
                    <ul class="sub-feature-list">
                        <li><i class="bi bi-check-lg feature-check"></i>1 online user account</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Full platform access for 2 years</li>
                        <li><i class="bi bi-check-lg feature-check"></i>Hot Sheets email alerts included</li>
                        <li><i class="bi bi-check-lg feature-check"></i>6 printed book editions over 2 years</li>
                        <li><i class="bi bi-check-lg feature-check"></i>One book per mailing, three mailings per year</li>
                    </ul>
                    <a href="{{ route('subscriptions.two-year') }}" class="btn-select-tier select-addon-tier" data-plan="2yr_print">Select Two-Year Online & Print</a>
                </div>

                <!-- Available Addons -->
                <div class="addons-section">
                    <div class="addons-header">AVAILABLE ADD-ONS</div>
                    <div class="addons-list">
                        <div class="addon-item">
                            <span>Additional Online User</span>
                            <span>$100/ea</span>
                        </div>
                        <div class="addon-item">
                            <span>Post-Election Deck Only (Subscriber)</span>
                            <span>$300</span>
                        </div>
                        <div class="addon-item">
                            <span>Post-Election Deck + Presentation (Subscriber)</span>
                            <span>$200</span>
                        </div>
                    </div>
                    <p class="addons-footer-text">Add-ons can be configured during checkout.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('portal_scripts')
@endsection

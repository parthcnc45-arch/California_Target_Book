@extends('layouts.portal')
@section('portal_content')
    <section id="section-add-subscription" class="portal-section active">
        <!-- Header: Back Navigation -->
        <div class="portal-mb-24" style="margin-bottom: 20px;">
            <div class="flex-center-gap-12 portal-mb-6">
                <a href="{{ route('auth.account.subscriptions') }}" class="back-nav-link">
                    <i class="bi bi-arrow-left"></i>
                    <span>Add a Subscription</span>
                </a>
            </div>
            <p class="portal-subheading-text">Choose a subscription to add to your account.</p>
        </div>

        <!-- Cards List -->
        <div class="portal-flex-wrap-gap-24" style="display: flex; gap: 20px; align-items: center; flex-wrap: wrap;">
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
                            <span>$100/year</span>
                        </div>
                        <div class="addon-item">
                            <span>Post-Election Deck Only (Subscriber)</span>
                            <span>$1000</span>
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
                            <span>$100/year</span>
                        </div>
                        <div class="addon-item">
                            <span>Post-Election Deck Only (Subscriber)</span>
                            <span>$1000</span>
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

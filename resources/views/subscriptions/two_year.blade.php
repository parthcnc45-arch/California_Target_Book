@extends('layouts.master_headless')

@section('title', 'California Target Book Two-Year Subscription')

@section('styles')
<!-- Google Fonts - Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    :root {
        --primary-red: #c52026;
        --primary-blue: #164e82;
        --bg-light: #ffffff;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8ee;
        --card-bg: #ffffff;
    }

    body {
        font-family: 'Inter', -apple-system, sans-serif !important;
        background-color: var(--bg-light) !important;
        color: var(--text-main);
        margin: 0;
        padding: 0;
    }

    #app {
        background-color: var(--bg-light) !important;
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6, label, p, div {
        font-family: 'Inter', -apple-system, sans-serif;
    }

    /* Page Header */
    .checkout-header {
        background-color: var(--primary-blue);
        color: #ffffff;
        padding: 48px 24px;
        text-align: center;
    }

    .checkout-header h1 {
        color: white !important ;
        font-size: 2.25rem;
        font-weight: 700;
        margin: 0 0 16px 0;
        letter-spacing: -0.5px;
    }

    .checkout-header p {
        font-size: 15px;
        color: #e0e7ff;
        margin: 0 0 24px 0;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.5;
    }

    .header-badges {
        display: flex;
        justify-content: center;
        gap: 24px;
        flex-wrap: wrap;
    }

    .badge-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #e0e7ff;
    }

    .badge-item i {
        font-size: 14px;
    }

    /* Layout */
    .checkout-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 40px 24px;
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }

    .checkout-main {
        flex: 1;
        min-width: 0;
    }

    .checkout-sidebar {
        width: 340px;
        flex-shrink: 0;
        position: sticky;
        top: 24px;
    }

    @media (max-width: 900px) {
        .checkout-container {
            flex-direction: column;
        }
        .checkout-sidebar {
            width: 100%;
            position: static;
        }
    }

    /* Section Styles */
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--text-main);
        margin: 32px 0 8px 0;
    }
    
    .section-title:first-child {
        margin-top: 0;
    }

    .section-subtitle {
        font-size: 13px;
        color: var(--text-muted);
        margin: 0 0 20px 0;
    }

    /* Price Header */
    .price-header {
        margin-bottom: 32px;
    }
    .price-amount {
        font-size: 28px;
        font-weight: 700;
        color: var(--text-main);
    }
    .price-period {
        font-size: 14px;
        color: var(--text-muted);
        font-weight: 500;
    }
    .price-meta {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
        display: flex;
        gap: 16px;
    }

    /* Format Selection Cards */
    .format-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 32px;
    }

    .format-card {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 20px;
        background: var(--card-bg);
        cursor: pointer;
        transition: all 0.2s ease;
        position: relative;
    }

    .format-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .format-card.selected {
        border: 2px solid var(--primary-red);
        background-color: #fffafb;
    }

    .format-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .format-title-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .format-icon {
        color: var(--primary-red);
        font-size: 20px;
    }

    .format-title {
        font-weight: 600;
        font-size: 15px;
        color: var(--text-main);
    }

    .format-radio {
        width: 20px;
        height: 20px;
        border: 1px solid #cbd5e1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .format-card.selected .format-radio {
        background-color: var(--primary-red);
        border-color: var(--primary-red);
        position: relative;
    }

    .format-card.selected .format-radio::after {
        content: "";
        position: absolute;
        left: 7px;
        top: 4px;
        width: 4px;
        height: 8px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .format-desc {
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.5;
        margin-bottom: 16px;
    }

    .format-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .format-features li {
        font-size: 12px;
        color: #475569;
        margin-bottom: 8px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }
    .format-features li:last-child {
        margin-bottom: 0;
    }
    
    .format-features li i {
        color: #10b981;
        font-size: 14px;
        margin-top: -1px;
    }

    /* Add-ons */
    .addon-card {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 16px 20px;
        background: var(--card-bg);
        margin-bottom: 16px;
        display: flex;
        flex-direction: column;
        transition: all 0.2s ease;
    }

    .addon-card:hover {
        border-color: #cbd5e1;
    }

    .addon-card.selected {
        border-color: var(--primary-red);
        background-color: #ffffff;
    }

    /* Custom Checkbox */
    .custom-checkbox {
        display: block;
        position: relative;
        padding-left: 28px;
        margin-bottom: 0;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        user-select: none;
    }
    .custom-checkbox input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }
    .custom-checkbox .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        transition: all 0.2s;
    }
    .custom-checkbox:hover input ~ .checkmark {
        border-color: #94a3b8;
    }
    .custom-checkbox input:checked ~ .checkmark {
        background-color: var(--primary-red);
        border-color: var(--primary-red);
    }
    .custom-checkbox .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }
    .custom-checkbox input:checked ~ .checkmark:after {
        display: block;
    }
    .custom-checkbox .checkmark:after {
        left: 5px;
        top: 2px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }

    .addon-content {
        flex: 1;
    }

    .addon-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 4px;
        display: flex;
        justify-content: space-between;
    }
    
    .addon-price {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-main);
    }

    .addon-price-muted {
        color: var(--text-muted);
        font-weight: 400;
        font-size: 12px;
    }

    .addon-desc {
        font-size: 12px;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* Qty Selector */
    .qty-selector {
        display: none;
        align-items: center;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        background: white;
        overflow: hidden;
    }
    .qty-btn {
        background: none;
        border: none;
        padding: 4px 10px;
        cursor: pointer;
        font-size: 14px;
        color: var(--text-main);
    }
    .qty-btn:hover {
        background: #f1f5f9;
    }
    .qty-input {
        width: 30px;
        text-align: center;
        border: none;
        border-left: 1px solid #cbd5e1;
        border-right: 1px solid #cbd5e1;
        padding: 4px 0;
        font-size: 13px;
    }

    /* Deck Radio Options */
    .deck-radio-label {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        cursor: pointer;
        background: white;
        transition: all 0.15s;
    }
    .deck-radio-label:hover {
        border-color: #cbd5e1;
    }
    .deck-radio-label.selected {
        border-color: var(--primary-red);
        background: #fffafb;
    }
    .deck-radio-label input[type="radio"] {
        margin-top: 0;
        accent-color: var(--primary-red);
        width: 16px;
        height: 16px;
    }
    .deck-radio-title {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-main);
        display: flex;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .deck-radio-title span {
        font-weight: 600;
    }
    .deck-radio-desc {
        font-size: 13px;
        color: var(--text-muted);
    }

    /* Forms */
    .form-row {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }

    .form-group {
        flex: 1;
        margin-bottom: 16px;
    }
    .form-row .form-group {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: var(--text-main);
        margin-bottom: 0px !important;
    }
    
    .form-label .required {
        color: var(--primary-red);
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        font-size: 14px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background-color: var(--card-bg);
        color: var(--text-main);
        transition: border-color 0.15s;
        box-sizing: border-box;
        height: auto !important;
        box-shadow: none !important;
    }

    .form-control:focus {
        outline: none;
        border-color: #94a3b8;
        box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.1) !important;
    }

    /* Validation Styles */
    .form-control.is-invalid {
        border-color: var(--primary-red) !important;
    }
    .form-label.is-invalid {
        color: var(--primary-red) !important;
    }
    .invalid-feedback {
        display: none;
        color: var(--primary-red);
        font-size: 12px;
        margin-top: 6px;
    }
    .form-control.is-invalid ~ .invalid-feedback {
        display: block;
    }

    /* Checkboxes */
    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
    }
    .checkbox-group input[type="checkbox"] {
        margin-top: 3px;
        accent-color: var(--primary-red);
    }
    .checkbox-group label {
        font-size: 13px;
        color: var(--text-main);
        line-height: 1.5;
        margin: 0;
        font-weight: 400;
    }
    .checkbox-group label a {
        color: var(--primary-red);
        text-decoration: underline;
    }
    .checkbox-group.is-invalid label {
        color: var(--primary-red) !important;
    }
    .checkbox-group.is-invalid ~ .invalid-feedback {
        display: block;
    }

    .bot-protection {
        background-color: #f8fafc;
        border: 1px dashed var(--border-color);
        border-radius: 6px;
        padding: 24px;
        text-align: center;
        font-size: 12px;
        color: var(--text-muted);
        margin: 24px 0;
    }

    /* Submit Button */
    .btn-submit {
        background-color: var(--primary-red);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 14px 24px;
        font-size: 15px;
        font-weight: 600;
        width: 100%;
        max-width: 300px;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-submit:hover {
        background-color: #a91b21;
    }

    .submit-note {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 12px;
    }

    /* Order Summary Sidebar */
    .summary-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 24px;
    }

    .summary-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
        margin: 0 0 16px 0;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .summary-item-title {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 4px;
    }
    .summary-item-title span {
        font-weight: 400;
        color: var(--text-muted);
    }

    .summary-item-desc {
        font-size: 12px;
        color: var(--text-muted);
    }

    .summary-item-price {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 16px;
    }

    .summary-total-label {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-main);
    }

    .summary-total-price {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
    }

    .summary-notes {
        margin-top: 24px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .summary-note {
        font-size: 11px;
        color: var(--text-muted);
        display: flex;
        align-items: flex-start;
        gap: 6px;
    }
    .summary-note i {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 1px;
    }
    .summary-note.blue i {
        color: #3b82f6;
    }
    .summary-note.orange i {
        color: #f97316;
    }

    /* Coupon Section */
    .coupon-row {
        display: flex;
        gap: 16px;
        align-items: center;
        margin-bottom: 24px;
    }
    .coupon-input-wrapper {
        flex: 1;
    }
    .coupon-input {
        width: 100%;
        padding: 10px 12px;
        font-size: 14px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        background-color: var(--card-bg);
        color: var(--text-main);
        transition: border-color 0.15s;
        box-sizing: border-box;
        height: 42px;
    }
    .coupon-input:focus {
        outline: none;
        border-color: #94a3b8;
        box-shadow: 0 0 0 2px rgba(148, 163, 184, 0.1) !important;
    }
    .btn-coupon-apply {
        background-color: #b54d4d;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0 32px;
        font-size: 14.5px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
        white-space: nowrap;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-coupon-apply:hover {
        background-color: #9c3f3f;
    }

    /* Success Page Styles */
    .success-container {
        max-width: 650px;
        margin: 0 auto;
        padding: 80px 24px;
        text-align: center;
    }

    .success-icon {
        color: #22c55e;
        font-size: 56px;
        margin-bottom: 20px;
        display: inline-block;
    }

    .success-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-main);
        margin: 0 0 12px 0;
        letter-spacing: -0.5px;
    }

    .success-text {
        font-size: 14.5px;
        color: var(--text-muted);
        line-height: 1.6;
        margin: 0 0 28px 0;
        max-width: 480px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-home {
        background-color: white;
        color: var(--text-main);
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 10px 24px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        font-family: 'Inter', -apple-system, sans-serif;
    }

    .btn-home:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: var(--text-main);
        text-decoration: none;
    }

</style>
@endsection

@section('content')
<!-- Header -->
<div class="checkout-header">
    <h1>California Target Book Two-Year Subscription</h1>
    <p>Lock in two years of access, alerts, and optional print editions at a better value.</p>
    <div class="header-badges">
        <div class="badge-item"><i class="bi bi-shield-check"></i> Secure checkout</div>
        <div class="badge-item"><i class="bi bi-envelope"></i> Hot Sheets alerts included</div>
        <div class="badge-item"><i class="bi bi-laptop"></i> Full platform access</div>
    </div>
</div>

<div class="checkout-container">
    <!-- Main Content -->
    <div class="checkout-main">
        <div class="price-header">
            <div>
                <span class="price-amount">$2,200</span>
                <span class="price-period">/ 2 years</span>
            </div>
            <div class="price-meta">
                Base subscription price — choose your format below
            </div>
        </div>

        <h3 class="section-title">Choose your plan format</h3>
        <p class="section-subtitle">Choose the subscription format that fits your workflow.</p>

        <div class="format-grid">
            <!-- Format Card 1 -->
            <div class="format-card selected" id="format-online">
                <div class="format-header">
                    <div class="format-title-group">
                        <i class="bi bi-laptop format-icon"></i>
                        <div class="format-title">Two-Year Online Only</div>
                    </div>
                    <div class="format-radio"></div>
                </div>
                <div class="format-desc">Two full years of digital access to the California Target Book platform</div>
                <ul class="format-features">
                    <li><i class="bi bi-check"></i> 1 online user account</li>
                    <li><i class="bi bi-check"></i> Full platform access for 2 years</li>
                    <li><i class="bi bi-check"></i> Hot Sheets email alerts included</li>
                </ul>
            </div>

            <!-- Format Card 2 -->
            <div class="format-card" id="format-print">
                <div class="format-header">
                    <div class="format-title-group">
                        <i class="bi bi-book format-icon"></i>
                        <div class="format-title">Two-Year Online & Print</div>
                    </div>
                    <div class="format-radio"></div>
                </div>
                <div class="format-desc">Two years of digital access plus all printed editions delivered by mail</div>
                <ul class="format-features">
                    <li><i class="bi bi-check"></i> 1 online user account</li>
                    <li><i class="bi bi-check"></i> Full platform access for 2 years</li>
                    <li><i class="bi bi-check"></i> Hot Sheets email alerts included</li>
                    <li><i class="bi bi-check"></i> 6 printed book editions over 2 years</li>
                    <li><i class="bi bi-check"></i> One book per mailing, three mailings per year</li>
                </ul>
            </div>
        </div>

        <h3 class="section-title">Optional add-ons</h3>
        <p class="section-subtitle">Enhance your subscription with additional features.</p>

        <div class="addon-card" id="addon-user-card">
            <div class="addon-header-row" style="display: flex; justify-content: space-between; width: 100%;">
                <label class="custom-checkbox">
                    <input type="checkbox" id="addon-user">
                    <span class="checkmark"></span>
                    Additional Online User
                </label>
                <span class="addon-price">$100/ea</span>
            </div>
            <div class="addon-body-row" style="display: flex; justify-content: space-between; align-items: center; padding-left: 28px; margin-top: 6px;">
                <div class="addon-desc" style="margin-bottom: 0;">
                    Adds extra annual online user seats to your subscription.<br>
                    <span style="color: #94a3b8; font-style: italic;">Billed annually per user</span>
                </div>
                <div class="qty-selector">
                    <button type="button" class="qty-btn" id="qty-minus"><i class="bi bi-dash"></i></button>
                    <input type="text" class="qty-input" id="addon-user-qty" value="1" readonly>
                    <button type="button" class="qty-btn" id="qty-plus"><i class="bi bi-plus"></i></button>
                </div>
            </div>
            <div id="addon-user-emails-container" style="display: none; padding-left: 28px; margin-top: 16px;"></div>
        </div>

        <div class="addon-card" id="addon-deck-card">
            <div class="addon-header-row" style="display: flex; justify-content: space-between; width: 100%;">
                <label class="custom-checkbox">
                    <input type="checkbox" id="addon-deck">
                    <span class="checkmark"></span>
                    Post-Election Deck
                </label>
                <span class="addon-price-muted" style="font-style: italic;">One-time charge</span>
            </div>
            <div class="deck-options" style="display: none; margin-top: 16px; flex-direction: column; gap: 12px; width: 100%;">
                <label class="deck-radio-label selected">
                    <input type="radio" name="deck_type" value="300" checked>
                    <div class="deck-radio-content" style="width: 100%;">
                        <div class="deck-radio-title">Post-Election Deck Only (Subscriber) <span>$300</span></div>
                        <div class="deck-radio-desc">Post-election deck presentation file, subscriber rate</div>
                    </div>
                </label>
                <label class="deck-radio-label">
                    <input type="radio" name="deck_type" value="200">
                    <div class="deck-radio-content" style="width: 100%;">
                        <div class="deck-radio-title">Post-Election Deck + Presentation (Subscriber) <span>$200</span></div>
                        <div class="deck-radio-desc">Post-election deck with live or recorded presentation add-on for subscribers</div>
                    </div>
                </label>
            </div>
        </div>

        <form id="payment-form">
        
        <h3 class="section-title" style="margin-top: 32px;">Have a Coupon?</h3>
        <p class="section-subtitle">If you have a coupon, for the California Target Book, apply it here.</p>
        <div class="coupon-row">
            <div class="coupon-input-wrapper">
                <input type="text" name="coupon" class="coupon-input" placeholder="">
            </div>
            <button type="button" class="btn-coupon-apply">Apply</button>
        </div>

        <h3 class="section-title" style="margin-top: 40px;">Your details</h3>
        
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">First Name <span class="required">*</span></label>
                <input type="text" class="form-control" name="first_name" placeholder="John" required>
                <div class="invalid-feedback">Required</div>
            </div>
            <div class="form-group">
                <label class="form-label">Last Name <span class="required">*</span></label>
                <input type="text" class="form-control" name="last_name" placeholder="Smith" required>
                <div class="invalid-feedback">Required</div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" class="form-control" name="email" placeholder="john@example.com" required>
            <div class="invalid-feedback">Required</div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" placeholder="(555) 123-4567">
            </div>
            <div class="form-group">
                <label class="form-label">Company Name <span class="required">*</span></label>
                <input type="text" class="form-control" name="company_name" placeholder="Acme Corp" required>
                <div class="invalid-feedback">Required</div>
            </div>
        </div>

        <h3 class="section-title" style="margin-top: 32px;">Billing Address</h3>
        
        <div class="form-group">
            <label class="form-label">Street <span class="required">*</span></label>
            <input type="text" class="form-control" name="billing_line1" placeholder="123 Main St" required>
            <div class="invalid-feedback">Required</div>
        </div>

        <div class="form-row">
            <div class="form-group" style="flex: 2;">
                <label class="form-label">City <span class="required">*</span></label>
                <input type="text" class="form-control" name="billing_city" placeholder="Sacramento" required>
                <div class="invalid-feedback">Required</div>
            </div>
            <div class="form-group" style="flex: 1;">
                <label class="form-label">State <span class="required">*</span></label>
                <select class="form-control" name="billing_state" required>
                    <option value="">State</option>
                    <option value="CA">CA</option>
                </select>
                <div class="invalid-feedback">Required</div>
            </div>
            <div class="form-group" style="flex: 1;">
                <label class="form-label">ZIP <span class="required">*</span></label>
                <input type="text" class="form-control" name="billing_zip" placeholder="95814" required>
                <div class="invalid-feedback">Required</div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Country <span class="required">*</span></label>
            <select class="form-control" name="billing_country">
                <option value="US">United States</option>
            </select>
        </div>

        <div class="checkbox-group" style="margin-top: 16px;">
            <input type="checkbox" id="same-shipping" checked>
            <label for="same-shipping">Shipping address is the same as billing</label>
        </div>

        <div id="shipping-address-block" style="display: none; margin-top: 32px;">
            <h3 class="section-title">Shipping Address</h3>
            
            <div class="form-group">
                <label class="form-label">Street <span class="required">*</span></label>
                <input type="text" class="form-control" name="shipping_line1" placeholder="123 Main St" required>
                <div class="invalid-feedback">Required</div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 2;">
                    <label class="form-label">City <span class="required">*</span></label>
                    <input type="text" class="form-control" name="shipping_city" placeholder="Sacramento" required>
                    <div class="invalid-feedback">Required</div>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">State <span class="required">*</span></label>
                    <select class="form-control" name="shipping_state" required>
                        <option value="">State</option>
                        <option value="CA">CA</option>
                    </select>
                    <div class="invalid-feedback">Required</div>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">ZIP <span class="required">*</span></label>
                    <input type="text" class="form-control" name="shipping_zip" placeholder="95814" required>
                    <div class="invalid-feedback">Required</div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Country <span class="required">*</span></label>
                <select class="form-control" name="shipping_country">
                    <option value="US">United States</option>
                </select>
            </div>
        </div>

        <h3 class="section-title" style="margin-top: 32px;">Payment Method</h3>
        <div id="payment-element" style="margin-bottom: 24px; min-height: 200px; padding: 16px; border: 1px solid var(--border-color); border-radius: 6px; background-color: #ffffff;">
            <div style="margin: 20px auto; text-align: center; color: #64748b; font-size: 14px;">
                Loading payment options...
            </div>
        </div>
        <div id="payment-message" class="invalid-feedback" style="display: none; margin-bottom: 16px;"></div>

        <div style="margin-top: 32px;">
            <div class="checkbox-group">
                <input type="checkbox" id="terms" required>
                <label for="terms">I agree to the <a href="#">terms & conditions</a> provided by the company. <span class="required" style="color: var(--primary-red);">*</span></label>
            </div>
            <div class="invalid-feedback" id="terms-feedback" style="margin-top: -8px; margin-bottom: 12px; margin-left: 26px;">You must agree to the terms</div>
            <div class="checkbox-group">
                <input type="checkbox" id="text-consent">
                <label for="text-consent">By providing my phone number, I agree to receive text messages from California Target Book.</label>
            </div>
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: center; margin-bottom: 24px;">
            <div style="height: 76px; overflow: hidden; border-radius: 3px;">
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            </div>
        </div>

        <button type="submit" class="btn-submit">Submit Subscription Request</button>
        <div class="submit-note">
            Your subscription will be processed securely. You can manage your account at any time.
        </div>
        </form>

    </div>

    <!-- Sidebar Summary -->
    <div class="checkout-sidebar">
        <div class="summary-card">
            <h3 class="summary-title">Order Summary</h3>
            
            <div class="summary-items">
                <div class="summary-item">
                    <div>
                        <div class="summary-item-title">Two-Year Subscription</div>
                        <div class="summary-item-desc" id="summary-format-text">Two-Year Online Only — 2 Years</div>
                    </div>
                    <div class="summary-item-price" id="summary-base-price">$2,200</div>
                </div>
                
                <div class="summary-item" id="summary-addon-user" style="display: none;">
                    <div>
                        <div class="summary-item-title">Additional Online User <span id="summary-user-qty">x 1</span></div>
                        <div class="summary-item-desc">Billed annually per user</div>
                    </div>
                    <div class="summary-item-price" id="summary-user-price">$100</div>
                </div>

                <div class="summary-item" id="summary-addon-deck" style="display: none;">
                    <div>
                        <div class="summary-item-title" id="summary-deck-title">Post-Election Deck Only (Subscriber)</div>
                        <div class="summary-item-desc">One-time charge</div>
                    </div>
                    <div class="summary-item-price" id="summary-deck-price">$300</div>
                </div>
            </div>

            <div class="summary-total">
                <div class="summary-total-label">Total</div>
                <div class="summary-total-price" id="summary-total-price">$2,200</div>
            </div>
            
            <div class="summary-notes">
                <div class="summary-note orange" id="note-print" style="display: none;"><i class="bi bi-book"></i> 6 printed books over 2 years — one per mailing, three mailings per year</div>
                <div class="summary-note blue" id="note-user" style="display: none;"><i class="bi bi-person"></i> Additional Online Users are billed annually</div>
                <div class="summary-note" id="note-deck" style="display: none;"><i class="bi bi-file-slides"></i> Post-Election deck add-on is a one-time charge at subscriber rate</div>
            </div>
        </div>
    </div>
</div>

<div class="success-container" style="display: none;">
    <div class="success-icon">
        <i class="bi bi-check-circle-fill"></i>
    </div>
    <h2 class="success-title">Subscription Request Submitted!</h2>
    <p class="success-text">
        Thank you, <span id="success-first-name">Subscriber</span>. We've received your Two-Year Subscription request. You'll receive a confirmation email at <strong id="success-email">your email</strong> shortly.
    </p>
    <a href="{{ route('home') }}" class="btn-home">Return to Home</a>
</div>
@endsection
@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    $(document).ready(function() {
        let stripe, elements;
        let basePrice = 2200;
        let isPrint = false;
        let hasUserAddon = false;
        let userQty = 1;
        let userPrice = 100;
        let hasDeckAddon = false;
        let deckPrice = 300;
        let deckTitle = "Post-Election Deck Only (Subscriber)";
        let currentTotal = basePrice;

        function updateSummary() {
            let total = basePrice;
            
            // Base Plan
            if(isPrint) {
                $('#summary-format-text').text('Two-Year Online & Print — 2 Years');
                $('#note-print').show();
            } else {
                $('#summary-format-text').text('Two-Year Online Only — 2 Years');
                $('#note-print').hide();
            }
            $('#summary-base-price').text('$' + basePrice.toLocaleString());

            // User Addon
            if(hasUserAddon) {
                let currentTotalUser = userQty * userPrice;
                total += currentTotalUser;
                $('#summary-user-qty').text('x ' + userQty);
                $('#summary-user-price').text('$' + currentTotalUser.toLocaleString());
                $('#summary-addon-user').show();
                $('#note-user').show();
            } else {
                $('#summary-addon-user').hide();
                $('#note-user').hide();
            }

            // Deck Addon
            if(hasDeckAddon) {
                total += deckPrice;
                $('#summary-deck-title').text(deckTitle);
                $('#summary-deck-price').text('$' + deckPrice.toLocaleString());
                $('#summary-addon-deck').show();
                $('#note-deck').show();
            } else {
                $('#summary-addon-deck').hide();
                $('#note-deck').hide();
            }

            // Total
            $('#summary-total-price').text('$' + total.toLocaleString());
            currentTotal = total;
        }

        function renderAddonEmails() {
            if (!hasUserAddon) {
                $('#addon-user-emails-container').hide().empty();
                return;
            }
            let container = $('#addon-user-emails-container');
            let existingValues = [];
            $('.addon-email-input').each(function() {
                existingValues.push($(this).val());
            });
            
            container.empty().show();
            for(let i=0; i<userQty; i++) {
                let val = existingValues[i] ? existingValues[i] : '';
                container.append(`
                    <div class="form-group" style="margin-bottom: 12px;">
                        <label class="form-label" style="font-size: 12px;">Additional User ${i+1} Email <span class="required">*</span></label>
                        <input type="email" class="form-control addon-email-input" placeholder="user${i+1}@example.com" value="${val}" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                `);
            }
        }

        // Plan Selection
        $('.format-card').on('click', function() {
            $('.format-card').removeClass('selected');
            $(this).addClass('selected');
            
            if($(this).attr('id') === 'format-print') {
                isPrint = true;
            } else {
                isPrint = false;
            }
            updateSummary();
        });

        // Additional User Checkbox
        $('#addon-user').on('change', function() {
            hasUserAddon = $(this).is(':checked');
            if(hasUserAddon) {
                $('#addon-user-card').addClass('selected');
                $('.qty-selector').css('display', 'flex');
            } else {
                $('#addon-user-card').removeClass('selected');
                $('.qty-selector').hide();
                userQty = 1;
                $('#addon-user-qty').val(userQty);
            }
            updateSummary();
            renderAddonEmails();
        });

        // User Qty Buttons
        $('#qty-plus').on('click', function(e) {
            e.preventDefault();
            userQty++;
            $('#addon-user-qty').val(userQty);
            updateSummary();
            renderAddonEmails();
        });

        $('#qty-minus').on('click', function(e) {
            e.preventDefault();
            if(userQty > 1) {
                userQty--;
                $('#addon-user-qty').val(userQty);
                updateSummary();
                renderAddonEmails();
            }
        });

        // Post-Election Deck Checkbox
        $('#addon-deck').on('change', function() {
            hasDeckAddon = $(this).is(':checked');
            if(hasDeckAddon) {
                $('#addon-deck-card').addClass('selected');
                $('.deck-options').css('display', 'flex');
                
                // set selected deck option
                let selectedOption = $('input[name="deck_type"]:checked');
                deckPrice = parseInt(selectedOption.val());
                if (deckPrice === 300) {
                    deckTitle = "Post-Election Deck Only (Subscriber)";
                } else {
                    deckTitle = "Post-Election Deck + Presentation (Subscriber)";
                }
            } else {
                $('#addon-deck-card').removeClass('selected');
                $('.deck-options').hide();
            }
            updateSummary();
        });

        // Deck Radio Options
        $('input[name="deck_type"]').on('change', function() {
            $('.deck-radio-label').removeClass('selected');
            $(this).closest('.deck-radio-label').addClass('selected');
            
            deckPrice = parseInt($(this).val());
            if (deckPrice === 300) {
                deckTitle = "Post-Election Deck Only (Subscriber)";
            } else {
                deckTitle = "Post-Election Deck + Presentation (Subscriber)";
            }
            updateSummary();
        });

        // Shipping Address Toggle
        $('#same-shipping').on('change', function() {
            if($(this).is(':checked')) {
                $('#shipping-address-block').hide();
                // Disable validation for shipping block if hidden
                $('#shipping-address-block .form-control').prop('required', false).removeClass('is-invalid');
                $('#shipping-address-block .form-label').removeClass('is-invalid');
            } else {
                $('#shipping-address-block').show();
                $('#shipping-address-block .form-control[placeholder]').prop('required', true);
            }
        });
        $('#same-shipping').trigger('change');

        // Form Validation on Submit
        $('#payment-form').on('submit', async function(e) {
            e.preventDefault();
            let isValid = true;

            // Input fields
            $('.form-group .form-control[required]').each(function() {
                if(!$(this).val()) {
                    $(this).addClass('is-invalid');
                    $(this).siblings('.form-label').addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.form-label').removeClass('is-invalid');
                }
            });

            // Terms Checkbox
            if(!$('#terms').is(':checked')) {
                $('#terms').closest('.checkbox-group').addClass('is-invalid');
                isValid = false;
            } else {
                $('#terms').closest('.checkbox-group').removeClass('is-invalid');
            }

            if(isValid) {
                // Disable button
                let $btn = $('.btn-submit');
                let originalText = $btn.text();
                $btn.prop('disabled', true).text('Processing...');

                try {
                    // Trigger form validation and client-side completion in Stripe elements
                    const {error: submitError} = await elements.submit();
                    if (submitError) {
                        $('#payment-message').text(submitError.message).show();
                        $btn.prop('disabled', false).text(originalText);
                        return;
                    }

                    // Create PaymentMethod
                    const {error, paymentMethod} = await stripe.createPaymentMethod({
                        elements: elements
                    });

                    if (error) {
                        $('#payment-message').text(error.message).show();
                        $btn.prop('disabled', false).text(originalText);
                        return;
                    }

                    let book_addresses = [];
                    if (isPrint) {
                        if ($('#same-shipping').is(':checked')) {
                            book_addresses.push({
                                line1: $('input[name="billing_line1"]').val(),
                                line2: null,
                                city: $('input[name="billing_city"]').val(),
                                state: $('select[name="billing_state"]').val(),
                                zip_code: $('input[name="billing_zip"]').val()
                            });
                        } else {
                            book_addresses.push({
                                line1: $('input[name="shipping_line1"]').val(),
                                line2: null,
                                city: $('input[name="shipping_city"]').val(),
                                state: $('select[name="shipping_state"]').val(),
                                zip_code: $('input[name="shipping_zip"]').val()
                            });
                        }
                    }

                    let addons = [];
                    if (hasUserAddon) {
                        $('.addon-email-input').each(function() {
                            if($(this).val()) addons.push($(this).val());
                        });
                    }

                    // Prepare payload
                    let payload = {
                        first_name: $('input[name="first_name"]').val(),
                        last_name: $('input[name="last_name"]').val(),
                        email: $('input[name="email"]').val(),
                        phone_number: $('input[name="phone_number"]').val(),
                        company: {
                            name: $('input[name="company_name"]').val(),
                            address: {
                                line1: $('input[name="billing_line1"]').val(),
                                line2: null,
                                city: $('input[name="billing_city"]').val(),
                                state: $('select[name="billing_state"]').val(),
                                zip_code: $('input[name="billing_zip"]').val()
                            }
                        },
                        book_addresses: book_addresses,
                        addons: addons,
                        payment_method: 'stripe',
                        stripe_token: paymentMethod.id,
                        subscription_length: 24, // 24 for two year
                        is_paid_for: false,
                        send_invoice: false,
                        custom_total_amount: currentTotal * 100
                    };

                    // Send via AJAX
                    $.ajax({
                        url: '/submit-subscription',
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: 'application/json',
                        data: JSON.stringify(payload),
                        success: function(res) {
                            if(res.success) {
                                let firstName = $('input[name="first_name"]').val();
                                let email = $('input[name="email"]').val();
                                
                                $('#success-first-name').text(firstName);
                                $('#success-email').text(email);
                                
                                $('.checkout-container').hide();
                                $('.success-container').show();
                                $('html, body').animate({ scrollTop: 0 }, 300);
                            } else {
                                alert('Error: ' + (res.message || 'Unknown error'));
                                $btn.prop('disabled', false).text(originalText);
                            }
                        },
                        error: function(err) {
                            console.error(err);
                            let msg = 'An error occurred. Please try again.';
                            if(err.responseJSON && err.responseJSON.message) msg = err.responseJSON.message;
                            if(err.responseJSON && err.responseJSON.errors) {
                                let firstErrorKey = Object.keys(err.responseJSON.errors)[0];
                                msg = err.responseJSON.errors[firstErrorKey][0];
                            }
                            alert(msg);
                            $btn.prop('disabled', false).text(originalText);
                        }
                    });

                } catch(e) {
                    console.error(e);
                    alert('An unexpected error occurred. Please try again.');
                    $btn.prop('disabled', false).text(originalText);
                }

            } else {
                // Scroll to first invalid field
                $('html, body').animate({
                    scrollTop: $(".is-invalid").first().offset().top - 100
                }, 500);
            }
        });

        // Initial update
        updateSummary();

        // Initialize Stripe UI
        try {
            // Using a Stripe test publishable key just to render the UI locally without error.
            // Replace this with your actual environment key in production.
            const stripeKey = '{{ env('STRIPE_PUB_KEY', 'pk_test_TYooMQauvdEDq54NiTphI7jx') }}';
            stripe = Stripe(stripeKey);
            
            const options = {
                mode: 'payment',
                amount: 220000, // Amount in cents
                currency: 'usd',
                paymentMethodCreation: 'manual',
                appearance: {
                    theme: 'stripe',
                    variables: {
                        colorPrimary: '#0f172a',
                        colorBackground: '#ffffff',
                        colorText: '#334155',
                        colorDanger: '#df1b41',
                        fontFamily: 'Inter, system-ui, sans-serif',
                        spacingUnit: '4px',
                        borderRadius: '6px',
                    }
                },
            };
            elements = stripe.elements(options);
            paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');
        } catch(e) {
            console.error("Stripe initialization error:", e);
            $('#payment-element').html('<div style="color:#df1b41; padding:20px;">Could not load payment options. Please check your Stripe configuration.</div>');
        }
    });
</script>
@endsection

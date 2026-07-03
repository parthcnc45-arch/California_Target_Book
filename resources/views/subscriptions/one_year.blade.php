@extends('layouts.master_headless')

@section('title', 'California Target Book One-Year Subscription')

@section('body_class', 'checkout-body landing-body')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Bellefair&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="/css/portal_custom.css" rel="stylesheet">
@endsection

@section('content')
    @if (Auth::check() && Auth::user()->isAdmin())
        <div class="admin-nav-bar">
            <div class="admin-nav-container">
                <div class="admin-title">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: -2px;">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span>California Target Book Admin</span>
                </div>
                <a href="/ctb-admin" class="admin-dashboard-link">Go To Admin Dashboard &rarr;</a>
            </div>
        </div>
    @endif

    <!-- Header Navigation -->
    <header>
        <div class="header-container">
            <div class="header-logo-container">
                <div class="logo-box">
                    <img src="/img/ctb-logo-6QqsiqVS.png" alt="California Target Book Logo">
                </div>
            </div>
            <div class="nav-links">
                <a href="/book" class="nav-item">Book App</a>
                @guest
                    <a href="/login" class="nav-item">Sign In</a>
                    <a href="/signup" class="btn-get-started">Get Started</a>
                @else
                    <a href="/account" class="nav-item">My Account</a>
                    <a href="/logout" class="btn-get-started btn-get-started-logout">Logout</a>
                @endguest
                <div class="dark-mode-toggle" aria-label="Toggle Dark Mode">
                    <!-- Toggle Moon/Sun SVG will be inserted by JS -->
                </div>
            </div>
        </div>
    </header>

<div class="checkout-header">
    <h1>California Target Book One-Year Subscription</h1>
    <p>Get online access, Hot Sheets email alerts, and optional printed editions delivered to your door.</p>
    <div class="header-badges">
        <div class="badge-item"><i class="bi bi-shield-check"></i> Secure checkout</div>
        <div class="badge-item"><i class="bi bi-envelope"></i> Hot Sheets alerts included</div>
        <div class="badge-item"><i class="bi bi-laptop"></i> Full platform access</div>
    </div>
</div>

<div class="checkout-container">
    <div class="checkout-main">
        <div class="price-header">
            <div>
                <span class="price-amount">$1,200</span>
                <span class="price-period">/ 1 year</span>
            </div>
            <div class="price-meta">
                Base subscription price — choose your format below
            </div>
        </div>

        <h3 class="section-title">Choose your plan format</h3>
        <p class="section-subtitle">Choose the subscription format that fits your workflow.</p>

        <div class="format-grid">
            <div class="format-card selected" id="format-online">
                <div class="format-header">
                    <div class="format-title-group">
                        <i class="bi bi-laptop format-icon"></i>
                        <div class="format-title">Online Access Only</div>
                    </div>
                    <div class="format-radio"></div>
                </div>
                <div class="format-desc">Digital access to the full California Target Book platform</div>
                <ul class="format-features">
                    <li><i class="bi bi-check"></i> 1 online user account</li>
                    <li><i class="bi bi-check"></i> Full platform access</li>
                    <li><i class="bi bi-check"></i> Hot Sheets email alerts included</li>
                </ul>
            </div>

            <div class="format-card" id="format-print">
                <div class="format-header">
                    <div class="format-title-group">
                        <i class="bi bi-book format-icon"></i>
                        <div class="format-title">Online Access & Print </div>
                    </div>
                    <div class="format-radio"></div>
                </div>
                <div class="format-desc">Digital access plus printed book editions delivered by mail</div>
                <ul class="format-features">
                    <li><i class="bi bi-check"></i> 1 online user account</li>
                    <li><i class="bi bi-check"></i> Full platform access</li>
                    <li><i class="bi bi-check"></i> Hot Sheets email alerts included</li>
                    <li><i class="bi bi-check"></i> 3 printed book editions</li>
                    <li><i class="bi bi-check"></i> One book per mailing, three mailings per year</li>
                </ul>
            </div>
        </div>

        <h3 class="section-title">Optional add-ons</h3>
        <p class="section-subtitle">Enhance your subscription with additional features.</p>

        <div class="addon-card" id="addon-user-card">
            <div class="addon-header-row">
                <label class="custom-checkbox">
                    <input type="checkbox" id="addon-user">
                    <span class="checkmark"></span>
                    Additional Online User
                </label>
                <span class="addon-price">$100/ea</span>
            </div>
            <div class="addon-body-row">
                <div class="addon-desc checkout-mb0">
                    Adds extra annual online user seats to your subscription.<br>
                    <span class="checkout-text-muted-italic">Billed annually per user</span>
                </div>
                <div class="qty-selector">
                    <button type="button" class="qty-btn" id="qty-minus"><i class="bi bi-dash"></i></button>
                    <input type="text" class="qty-input" id="addon-user-qty" value="1" readonly>
                    <button type="button" class="qty-btn" id="qty-plus"><i class="bi bi-plus"></i></button>
                </div>
            </div>
            <div id="addon-user-emails-container" class="addon-emails-container"></div>
        </div>

        <div class="addon-card" id="addon-deck-card">
            <div class="addon-deck-header-row">
                <label class="custom-checkbox checkout-mt8">
                    <input type="checkbox" id="addon-deck">
                    <span class="checkmark"></span>
                    Post-Election Deck
                </label>
                <div class="deck-qty-wrapper">
                    <span class="addon-price-muted checkout-text-italic">One-time charge</span>
                    <div class="qty-selector" id="deck-qty-selector" style="display: none;">
                        <button type="button" class="qty-btn" id="deck-qty-minus"><i class="bi bi-dash"></i></button>
                        <input type="text" class="qty-input" id="addon-deck-qty" value="1" readonly>
                        <button type="button" class="qty-btn" id="deck-qty-plus"><i class="bi bi-plus"></i></button>
                    </div>
                </div>
            </div>
            <div class="deck-options" style="display: none;">
                <label class="deck-radio-label selected">
                    <input type="radio" name="deck_type" value="300" checked>
                    <div class="deck-radio-content">
                        <div class="deck-radio-title">Post-Election Deck Only (Subscriber) <span>$300</span></div>
                        <div class="deck-radio-desc">Post-election deck presentation file, subscriber rate</div>
                    </div>
                </label>
                <label class="deck-radio-label">
                    <input type="radio" name="deck_type" value="200">
                    <div class="deck-radio-content">
                        <div class="deck-radio-title">Post-Election Deck + Presentation (Subscriber) <span>$200</span></div>
                        <div class="deck-radio-desc">Post-election deck with live or recorded presentation add-on for subscribers</div>
                    </div>
                </label>
            </div>
        </div>

        <form id="payment-form">
            <h3 class="section-title checkout-mt32">Have a Coupon?</h3>
            <p class="section-subtitle">If you have a coupon, for the California Target Book, apply it here.</p>
            <div class="coupon-row">
                <div class="coupon-input-wrapper">
                    <input type="text" name="coupon" class="coupon-input" placeholder="">
                </div>
                <button type="button" class="btn-coupon-apply">Apply</button>
            </div>

            <h3 class="section-title checkout-mt40">Your details</h3>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">First Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="first_name" placeholder="John" value="{{ old('first_name') ?? (auth()->user()->first_name ?? '') }}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="last_name" placeholder="Smith" value="{{ old('last_name') ?? (auth()->user()->last_name ?? '') }}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email <span class="required">*</span></label>
                <input type="email" class="form-control" name="email" placeholder="john@example.com" value="{{ old('email') ?? (auth()->user()->email ?? '') }}" required>
                <div class="invalid-feedback">Required</div>
            </div>

            @guest
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password <span class="required">*</span></label>
                    <input type="password" class="form-control" name="password" placeholder="" required>
                    <div class="invalid-feedback">Required</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password <span class="required">*</span></label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="" required>
                    <div class="invalid-feedback">Required</div>
                </div>
            </div>
            @endguest

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Phone Number <span class="required">*</span></label>
                    <input type="text" class="form-control" name="phone_number" placeholder="(555) 123-4567" value="{{ old('phone_number') ?? (auth()->user()->phone_number ?? '') }}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Company Name <span class="required">*</span></label>
                    <input type="text" class="form-control" name="company_name" placeholder="Acme Corp" value="{{ old('company_name') ?? (auth()->user()->company->name ?? '') }}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
            </div>

            <h3 class="section-title checkout-mt32">Billing Address</h3>
            <ctb-address-block :input="{{ json_encode(old('billing') ?? (auth()->user()->company->address ?? (object)[])) }}" name="billing" layout="checkout"></ctb-address-block>

            <div class="checkbox-group checkout-mt16">
                <input type="checkbox" id="same-shipping" checked>
                <label for="same-shipping">Shipping address is the same as billing</label>
            </div>

            <div id="shipping-address-block" class="shipping-address-block">
                <div id="shipping-addresses-container"></div>
            </div>

            <h3 class="section-title checkout-mt32">Payment Method</h3>
            <div id="payment-element" class="payment-element-container">
                <div class="payment-options-loader">
                    Loading payment options...
                </div>
            </div>
            <div id="payment-message" class="invalid-feedback payment-message-feedback"></div>

            <div class="checkout-mt32">
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">I agree to the <a href="#">terms & conditions</a> provided by the company. <span class="required">*</span></label>
                </div>
                <div class="invalid-feedback checkout-terms-feedback" id="terms-feedback">You must agree to the terms</div>
                <div class="checkbox-group">
                    <input type="checkbox" id="text-consent">
                    <label for="text-consent">By providing my phone number, I agree to receive text messages from California Target Book.</label>
                </div>
            </div>

            <div class="recaptcha-container">
                <div class="recaptcha-inner">
                    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
                </div>
            </div>

            <button type="submit" class="btn-submit">Submit Subscription Request</button>
            <div class="submit-note">
                Your subscription will be processed securely. You can manage your account at any time.
            </div>
        </form>
    </div>

    <div class="checkout-sidebar">
        <div class="summary-card">
            <h3 class="summary-title">Order Summary</h3>

            <div class="summary-items">
                <div class="summary-item">
                    <div>
                        <div class="summary-item-title">One-Year Subscription</div>
                        <div class="summary-item-desc" id="summary-format-text">Online Access Only — 1 Year</div>
                    </div>
                    <div class="summary-item-price" id="summary-base-price">$1,200</div>
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
                        <div class="summary-item-title"><span id="summary-deck-title">Post-Election Deck Only (Subscriber)</span> <span id="summary-deck-qty" style="font-weight: 400; color: var(--text-muted); display: none;">x 1</span></div>
                        <div class="summary-item-desc">One-time charge</div>
                    </div>
                    <div class="summary-item-price" id="summary-deck-price">$300</div>
                </div>
            </div>

            <div class="summary-total">
                <div class="summary-total-label">Total</div>
                <div class="summary-total-price" id="summary-total-price">$1,200</div>
            </div>

            <div class="summary-notes">
                <div class="summary-note orange" id="note-print" style="display: none;"><i class="bi bi-book"></i> 3 printed books — one per mailing, three mailings per year</div>
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
        Thank you, <span id="success-first-name">Subscriber</span>. We've received your One-Year Subscription request. You'll receive a confirmation email at <strong id="success-email">your email</strong> shortly.
    </p>
    <a href="{{ route('home') }}" class="btn-home">Return to Home</a>
</div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-copyright">
                &copy; {{ date('Y') }} California Target Book. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="/book">Book Application</a>
                @guest
                    <a href="/login">Sign In</a>
                    <a href="/signup">Create Account</a>
                @else
                    <a href="/account">My Account</a>
                @endguest
            </div>
        </div>
    </footer>
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    window.checkoutConfig = {
        stripeKey: '{{ config('app.STRIPE_PUB_KEY') ?: 'pk_test_TYooMQauvdEDq54NiTphI7jx' }}',
        registerUrl: '{{ route('register') }}',
        registerEmailsUrl: '/register-emails',
        basePriceOnline: 1200,
        basePricePrint: 1500,
        subscriptionLength: 12,
        formatTextOnline: 'Online Access Only — 1 Year',
        formatTextPrint: 'Online Access & Print — 1 Year'
    };
</script>
<script src="/js/checkout.js"></script>

<!-- Dark Mode Toggle Script -->
<script>
    const moonIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
    `;

    const sunIcon = `
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>
    `;

    const toggleBtn = document.querySelector('.dark-mode-toggle');

    function updateIcon(isDark) {
        toggleBtn.innerHTML = isDark ? sunIcon : moonIcon;
    }

    // Initialize theme from localStorage
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') {
        document.body.classList.add('dark-mode');
        updateIcon(true);
    } else {
        updateIcon(false);
    }

    // Add toggle action
    toggleBtn.addEventListener('click', () => {
        const isDark = document.body.classList.toggle('dark-mode');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
        updateIcon(isDark);
    });
</script>
@endsection

@extends('layouts.master_headless')

@section('title', 'California Target Book One-Year Subscription')

@section('body_class', 'checkout-body landing-body')

@section('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Bellefair&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="/css/portal_custom.css" rel="stylesheet">
<link rel="stylesheet" href="/css/style_new.css">

@endsection

@section('content')
    @include('layouts.navbar')

<div class="checkout-header">
    <h1>Purchase Post-Election Deck</h1>
    <p>Get the latest post-election deck and presentations.</p>
    <div class="header-badges">
        <div class="badge-item"><i class="bi bi-shield-check"></i> Secure checkout</div>
        <div class="badge-item"><i class="bi bi-envelope"></i> Hot Sheets alerts included</div>
        <div class="badge-item"><i class="bi bi-laptop"></i> Full platform access</div>
    </div>
</div>

<div class="checkout-container">
    <div class="checkout-main">


        <h3 class="section-title">Select your package</h3>
        <p class="section-subtitle">Choose the package that fits your needs.</p>

        <!-- Hidden checkbox to keep checkout.js logic working smoothly without rewriting it -->
        <input type="checkbox" id="addon-deck" checked style="display: none;">

        <div class="package-grid" id="deck-options">
            
            <label class="package-card selected" id="pkg-1000">
                <input type="radio" name="deck_type" value="1000" checked>
                <div class="package-check"></div>
                <div class="package-price">$1,000</div>
                <div class="deck-radio-content">
                    <div class="deck-radio-title package-title">Post-Election Deck Only</div>
                    <div class="package-desc">Post-election deck presentation file</div>
                </div>
            </label>
            
            <label class="package-card" id="pkg-300">
                <input type="radio" name="deck_type" value="300">
                <div class="package-check"></div>
                <div class="package-price">$300</div>
                <div class="deck-radio-content">
                    <div class="deck-radio-title package-title">Post-Election Deck + Presentation</div>
                    <div class="package-desc">Post-election deck with live or recorded presentation add-on</div>
                </div>
            </label>

        </div>

        <div class="qty-section">
            <span class="qty-section-label">Quantity</span>
            <div class="qty-selector" id="deck-qty-selector">
                <button type="button" class="qty-btn" id="deck-qty-minus"><i class="bi bi-dash"></i></button>
                <input type="text" class="qty-input" id="addon-deck-qty" value="1" readonly>
                <button type="button" class="qty-btn" id="deck-qty-plus"><i class="bi bi-plus"></i></button>
            </div>
        </div>

        <div id="deck-shipping-addresses-container" class="scrollable-addresses" style="width: 100%;"></div>

        <form id="payment-form">

            <h3 class="section-title checkout-mt40">Account Information</h3>

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

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email <span class="required">*</span></label>
                    <input type="email" class="form-control" name="email" placeholder="john@example.com" value="{{ old('email') ?? (auth()->user()->email ?? '') }}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number <span class="required">*</span></label>
                    <input type="text" class="form-control" name="phone_number" placeholder="(555) 123-4567" value="{{ old('phone_number') ?? (auth()->user()->phone_number ?? '') }}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
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

            <button type="submit" class="btn-submit">Submit Purchase Request</button>
        </form>
    </div>

    <div class="checkout-sidebar">
        <div class="summary-card">
            <h3 class="summary-title">Order Summary</h3>

            <div class="summary-items">
                <div class="summary-item" id="summary-base-item" style="display: none;">
                    <div>
                        <div class="summary-item-title">Purchase</div>
                        <div class="summary-item-desc" id="summary-format-text"></div>
                    </div>
                    <div class="summary-item-price" id="summary-base-price">$0</div>
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

        </div>
    </div>
</div>

<div class="success-container" style="display: none;">
    <div class="success-icon">
        <i class="bi bi-check-circle-fill"></i>
    </div>
    <h2 class="success-title">Purchase Request Submitted!</h2>
    <p class="success-text">
        Thank you, <span id="success-first-name">Subscriber</span>. We've received your Post-Election Deck purchase request. You'll receive a confirmation email at <strong id="success-email">your email</strong> shortly.
    </p>
    <a href="{{ route('home') }}" class="btn-home">Return to Home</a>
</div>

    @include('layouts.footer')
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    window.checkoutConfig = {
        stripeKey: '{{ config('app.STRIPE_PUB_KEY') ?: 'pk_test_TYooMQauvdEDq54NiTphI7jx' }}',
        registerUrl: '{{ route('purchase.book-only') }}',
        registerEmailsUrl: '/register-emails',
        basePriceOnline: 0,
        basePricePrint: 0,
        subscriptionLength: -1,
        formatTextOnline: '',
        formatTextPrint: ''
    };
</script>
<script src="/js/checkout.js"></script>
<script>
    $(document).ready(function() {
        // Handle custom package selection UI
        $('.package-card').on('click', function() {
            $('.package-card').removeClass('selected');
            $(this).addClass('selected');
        });

        // Force the deck add-on to be checked and trigger total calculation
        setTimeout(function() {
            $('#addon-deck').prop('checked', true).trigger('change');
            
            // Hide the base subscription item in the summary if it's there
            $('#summary-base-item').hide();
        }, 100);
    });
</script>
@endsection

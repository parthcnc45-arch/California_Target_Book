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

        <div class="addon-card" id="addon-deck-card" style="padding: 0; border: none; background: transparent;">
            <div class="deck-options" style="display: flex; margin-top: 0;">

                <label class="deck-radio-label">
                    <input type="checkbox" name="deck_types[]" value="1000" class="custom-addon-check" style="margin-top: 2px; width: 16px; height: 16px; accent-color: #c52026;" checked>
                    <div class="deck-radio-content">
                        <div class="deck-radio-title">Post-Election Deck Only <span>$1,000</span></div>
                        <div class="deck-radio-desc" style="margin-top: 5px;">The full post-election data deck, delivered as a digital file to your account email.<br><br>
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; background-color: #e0f2fe; color: #0284c7; margin-right: 5px;">DIGITAL FILE</span>
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; background-color: #fef3c7; color: #d97706;">ONE-TIME CHARGE</span>
                        <div class="deck-confirmation-msg" style="display: none; margin-top: 10px;">Sent to your account after the document is confirmed. No shipping needed.</div></div>
                    </div>
                </label>
                
                <label class="deck-radio-label">
                    <input type="checkbox" name="deck_types[]" value="200_presentation" class="custom-addon-check" style="margin-top: 2px; width: 16px; height: 16px; accent-color: #c52026;">
                    <div class="deck-radio-content">
                        <div class="deck-radio-title">Post-Election Presentation <span>$200</span></div>
                        <div class="deck-radio-desc" style="margin-top: 5px;">The presentation companion to the deck, delivered as a digital file to your account email.<br><br>
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; background-color: #e0f2fe; color: #0284c7; margin-right: 5px;">DIGITAL FILE</span>
                        <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; background-color: #fef3c7; color: #d97706;">ONE-TIME CHARGE</span>
                        <div class="deck-confirmation-msg" style="display: none; margin-top: 10px;">Sent to your account after the document is confirmed. No shipping needed.</div></div>
                    </div>
                </label>

                <div class="deck-radio-label" id="wrapper-printed-book" style="display: block; cursor: default;">
                    <label id="label-printed-book" style="display: flex; align-items: flex-start; gap: 16px; cursor: pointer; width: 100%; margin: 0;">
                        <input type="checkbox" name="deck_types[]" value="300_book" class="custom-addon-check" id="check-printed-book" style="margin-top: 2px; width: 16px; height: 16px; accent-color: #c52026;">
                        <div class="deck-radio-content" style="flex: 1;">
                            <div class="deck-radio-title" style="display: flex; justify-content: space-between; font-size: 14px; font-weight: 600; color: #0d2a45;">Additional Printed Book <span class="addon-price-span">$300</span></div>
                            <div class="deck-radio-desc" style="margin-top: 5px; font-size: 13px; color: #475569;">A printed edition mailed to a physical address &mdash; 3 printed editions across the year, one per mailing.<br><br>
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; background-color: #fee2e2; color: #dc2626; margin-right: 5px;">PHYSICAL + MAILED</span>
                            <span style="display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; background-color: #fef3c7; color: #d97706;">ONE-TIME CHARGE</span></div>
                        </div>
                    </label>

                    <div id="deck-qty-wrapper" style="display: none; justify-content: flex-end; align-items: center; margin-top: 15px; margin-bottom: 5px; padding-top: 15px; border-top: 1px solid #e2e8f0;">
                        <span style="font-weight: 600; font-size: 14px; color: #0d2a45; margin-right: 15px;">Number of Books:</span>
                        <div class="qty-selector-inline" id="deck-qty-selector" style="display: flex;">
                            <button type="button" class="qty-btn" id="deck-qty-minus"><i class="bi bi-dash"></i></button>
                            <input type="text" class="qty-input" id="addon-deck-qty" name="deck_qty" value="1" readonly>
                            <button type="button" class="qty-btn" id="deck-qty-plus"><i class="bi bi-plus"></i></button>
                        </div>
                    </div>

                    <div id="deck-shipping-addresses-container" style="width: 100%; margin-top: 15px; display: none;"></div>
                </div>
            </div>
        </div>

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

                <div id="summary-addon-deck" style="display: none;"></div>
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
@endsection

@extends('layouts.master_headless')

@section('title', 'California Target Book Two-Year Subscription')

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
    <h1>California Target Book Two-Year Subscription</h1>
    <p>Lock in two years of access, alerts, and optional print editions at a better value.</p>
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
            <div class="format-card selected" id="format-online">
                <div class="format-header">
                    <div class="format-title-group">
                        <i class="bi bi-laptop format-icon"></i>
                        <div class="format-title">Two-Year Online Only </div>
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

            <div class="format-card" id="format-print">
                <div class="format-header">
                    <div class="format-title-group">
                        <i class="bi bi-book format-icon"></i>
                        <div class="format-title">Two-Year Online & Print </div>
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
            </div>

            <h3 class="section-title checkout-mt32">Organization</h3>
            
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Company Name <span class="required">*</span></label>
                    <input id="company" type="text" class="form-control" name="company[name]" placeholder="Acme Corp" value="{{ old('company.name') ?? (auth()->user()->company->name ?? '') }}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
            </div>

            <ctb-address-block :input="{{ json_encode(old('billing') ?? (auth()->user()->company->address ?? (object)[])) }}" name="billing" layout="checkout"></ctb-address-block>

            <h3 class="section-title checkout-mt32">Optional add-ons</h3>
            <p class="section-subtitle">Enhance your subscription with additional features.</p>

            <div class="addon-card" id="addon-deck-card" style="padding: 0; border: none; background: transparent; margin-top: 16px;">
                <div class="deck-options" style="display: flex; margin-top: 0;">

                    <label class="deck-radio-label">
                        <input type="checkbox" name="deck_types[]" value="1000" class="custom-addon-check" style="margin-top: 2px; width: 16px; height: 16px; accent-color: #c52026;">
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

                <div id="summary-addon-deck" style="display: none;">
                    <!-- Items will be injected here by JS -->
                </div>
            </div>

            <div class="summary-total">
                <div class="summary-total-label">Total</div>
                <div class="summary-total-price" id="summary-total-price"></div>
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

    @include('layouts.footer')
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    window.checkoutConfig = {
        stripeKey: '{{ config('app.STRIPE_PUB_KEY') ?: 'pk_test_TYooMQauvdEDq54NiTphI7jx' }}',
        registerUrl: '{{ route('register') }}',
        registerEmailsUrl: '/register-emails',
        basePriceOnline: 2200,
        basePricePrint: 2800,
        subscriptionLength: 24,
        formatTextOnline: 'Two-Year Online Only — 2 Years',
        formatTextPrint: 'Two-Year Online & Print — 2 Years'
    };
</script>
<script src="/js/checkout.js"></script>
@endsection

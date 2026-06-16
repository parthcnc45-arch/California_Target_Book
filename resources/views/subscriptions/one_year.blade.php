@extends('layouts.master_headless')

@section('title', 'California Target Book One-Year Subscription')

@section('body_class', 'checkout-body')

@section('styles')
<!-- Google Fonts - Inter -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="/css/portal_custom.css" rel="stylesheet">
@endsection

@section('content')
<!-- Header -->
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
    <!-- Main Content -->
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
            <!-- Format Card 1 -->
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

            <!-- Format Card 2 -->
            <div class="format-card" id="format-print">
                <div class="format-header">
                    <div class="format-title-group">
                        <i class="bi bi-book format-icon"></i>
                        <div class="format-title">Online Access & Print</div>
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

    <!-- Sidebar Summary -->
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
@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    $(document).ready(function() {
        let stripe, elements;
        let basePrice = 1200;
        let isPrint = false;
        let hasUserAddon = false;
        let userQty = 1;
        let userPrice = 100;
        let hasDeckAddon = false;
        let deckPrice = 300;
        let deckQty = 1;
        let deckTitle = "Post-Election Deck Only (Subscriber)";
        let currentTotal = basePrice;

        function updateSummary() {
            let total = basePrice;
            
            // Base Plan
            if(isPrint) {
                $('#summary-format-text').text('Online Access & Print — 1 Year');
                $('#note-print').show();
            } else {
                $('#summary-format-text').text('Online Access Only — 1 Year');
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
                let currentTotalDeck = deckQty * deckPrice;
                total += currentTotalDeck;
                $('#summary-deck-title').text(deckTitle);
                if (deckQty > 1) {
                    $('#summary-deck-qty').text('x ' + deckQty).show();
                } else {
                    $('#summary-deck-qty').hide();
                }
                $('#summary-deck-price').text('$' + currentTotalDeck.toLocaleString());
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
                    <div class="form-group checkout-mb12">
                        <label class="form-label checkout-fs12">Additional User ${i+1} Email <span class="required">*</span></label>
                        <input type="email" class="form-control addon-email-input" placeholder="user${i+1}@example.com" value="${val}" required>
                        <div class="invalid-feedback">Required</div>
                    </div>
                `);
            }
        }

        function renderShippingAddresses() {
            let container = $('#shipping-addresses-container');
            let isSame = $('#same-shipping').is(':checked');
            
            if (isSame) {
                $('#shipping-address-block').hide();
                container.empty();
                return;
            }

            let qty = 0;
            let title = "Shipping Address";
            if (hasDeckAddon) {
                qty = deckQty;
            } else if (isPrint) {
                qty = 1;
            }

            if (qty === 0) {
                $('#shipping-address-block').hide();
                container.empty();
                return;
            }

            // Save existing values to avoid overwriting typed input
            let existing = [];
            $('.shipping-address-item').each(function(index) {
                existing.push({
                    line1: $(this).find('input[name*="[line1]"]').val() || '',
                    line2: $(this).find('input[name*="[line2]"]').val() || '',
                    city: $(this).find('input[name*="[city]"]').val() || '',
                    state: $(this).find('select[name*="[state]"]').val() || '',
                    zip_code: $(this).find('input[name*="[zip_code]"]').val() || ''
                });
            });

            container.empty();
            $('#shipping-address-block').show();

            let AddressBlockClass = Vue.extend(Vue.component('ctb-address-block'));

            for (let i = 0; i < qty; i++) {
                let data = existing[i] || { line1: '', line2: '', city: '', state: 'CA', zip_code: '' };
                let itemTitle = qty > 1 ? `${title} ${i + 1}` : title;
                
                let itemDiv = $(`
                    <div class="shipping-address-item${i > 0 ? ' shipping-address-item-divider' : ''}">
                        <h4 class="shipping-address-item-title">${itemTitle}</h4>
                    </div>
                `);

                // Instantiate and mount AddressBlock Vue component
                let instance = new AddressBlockClass({
                    propsData: {
                        name: `shipping_${i}`,
                        input: {
                            line1: data.line1,
                            line2: data.line2,
                            city: data.city,
                            state: data.state,
                            zip_code: data.zip_code
                        },
                        layout: 'checkout'
                    }
                });
                
                let targetDiv = $('<div class="shipping-address-instance"></div>');
                itemDiv.append(targetDiv);
                container.append(itemDiv);
                
                instance.$mount(targetDiv[0]);
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
            renderShippingAddresses();
        });

        // Additional User Checkbox
        $('#addon-user').on('change', function() {
            hasUserAddon = $(this).is(':checked');
            if(hasUserAddon) {
                $('#addon-user-card').addClass('selected');
                $('#addon-user-card .qty-selector').css('display', 'flex');
            } else {
                $('#addon-user-card').removeClass('selected');
                $('#addon-user-card .qty-selector').hide();
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

        // User Qty Buttons
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
                $('#deck-qty-selector').css('display', 'flex');
                
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
                $('#deck-qty-selector').hide();
                deckQty = 1;
                $('#addon-deck-qty').val(deckQty);
            }
            updateSummary();
            renderShippingAddresses();
        });

        // Deck Qty Buttons
        $('#deck-qty-plus').on('click', function(e) {
            e.preventDefault();
            deckQty++;
            $('#addon-deck-qty').val(deckQty);
            updateSummary();
            renderShippingAddresses();
        });

        $('#deck-qty-minus').on('click', function(e) {
            e.preventDefault();
            if(deckQty > 1) {
                deckQty--;
                $('#addon-deck-qty').val(deckQty);
                updateSummary();
                renderShippingAddresses();
            }
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
            renderShippingAddresses();
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
                    $(this).siblings('.form-label, .control-label').addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).siblings('.form-label, .control-label').removeClass('is-invalid');
                }
            });

            // Password custom validation for guest users
            let passwordInput = $('input[name="password"]');
            let confirmInput = $('input[name="password_confirmation"]');
            if (passwordInput.length && confirmInput.length) {
                let passwordVal = passwordInput.val();
                let confirmVal = confirmInput.val();

                if (passwordVal && passwordVal.length < 6) {
                    passwordInput.addClass('is-invalid');
                    passwordInput.siblings('.invalid-feedback').text('Password must be at least 6 characters');
                    passwordInput.siblings('.form-label, .control-label').addClass('is-invalid');
                    isValid = false;
                } else if (passwordVal) {
                    passwordInput.siblings('.invalid-feedback').text('Required');
                }

                if (passwordVal && passwordVal !== confirmVal) {
                    confirmInput.addClass('is-invalid');
                    confirmInput.siblings('.invalid-feedback').text('Passwords do not match');
                    confirmInput.siblings('.form-label, .control-label').addClass('is-invalid');
                    isValid = false;
                } else if (passwordVal && passwordVal === confirmVal) {
                    confirmInput.siblings('.invalid-feedback').text('Required');
                }
            }

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
                                line1: $('input[name="billing[line1]"]').val(),
                                line2: $('input[name="billing[line2]"]').val() || null,
                                city: $('input[name="billing[city]"]').val(),
                                state: $('select[name="billing[state]"]').val(),
                                zip_code: $('input[name="billing[zip_code]"]').val(),
                                special_instructions: $('input[name="billing[special_instructions]"]').val() || null
                            });
                        } else {
                            book_addresses.push({
                                line1: $('input[name="shipping_0[line1]"]').val(),
                                line2: $('input[name="shipping_0[line2]"]').val() || null,
                                city: $('input[name="shipping_0[city]"]').val(),
                                state: $('select[name="shipping_0[state]"]').val(),
                                zip_code: $('input[name="shipping_0[zip_code]"]').val(),
                                special_instructions: $('input[name="shipping_0[special_instructions]"]').val() || null
                            });
                        }
                    }

                    let deck_addresses = [];
                    if (hasDeckAddon) {
                        if ($('#same-shipping').is(':checked')) {
                            for (let i = 0; i < deckQty; i++) {
                                deck_addresses.push({
                                    line1: $('input[name="billing[line1]"]').val(),
                                    line2: $('input[name="billing[line2]"]').val() || null,
                                    city: $('input[name="billing[city]"]').val(),
                                    state: $('select[name="billing[state]"]').val(),
                                    zip_code: $('input[name="billing[zip_code]"]').val(),
                                    special_instructions: $('input[name="billing[special_instructions]"]').val() || null
                                });
                            }
                        } else {
                            for (let i = 0; i < deckQty; i++) {
                                deck_addresses.push({
                                    line1: $(`input[name="shipping_${i}[line1]"]`).val(),
                                    line2: $(`input[name="shipping_${i}[line2]"]`).val() || null,
                                    city: $(`input[name="shipping_${i}[city]"]`).val(),
                                    state: $(`select[name="shipping_${i}[state]"]`).val(),
                                    zip_code: $(`input[name="shipping_${i}[zip_code]"]`).val(),
                                    special_instructions: $(`input[name="shipping_${i}[special_instructions]"]`).val() || null
                                });
                            }
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
                        password: $('input[name="password"]').val() || null,
                        password_confirmation: $('input[name="password_confirmation"]').val() || null,
                        company: {
                            name: $('input[name="company_name"]').val(),
                            address: {
                                line1: $('input[name="billing[line1]"]').val(),
                                line2: $('input[name="billing[line2]"]').val() || null,
                                city: $('input[name="billing[city]"]').val(),
                                state: $('select[name="billing[state]"]').val(),
                                zip_code: $('input[name="billing[zip_code]"]').val(),
                                special_instructions: $('input[name="billing[special_instructions]"]').val() || null
                            }
                        },
                        book_addresses: book_addresses,
                        addons: addons,
                        payment_method: 'stripe',
                        stripe_token: paymentMethod.id,
                        subscription_length: 12,
                        is_paid_for: false,
                        send_invoice: false,
                        deck_qty: hasDeckAddon ? deckQty : 0,
                        deck_type: hasDeckAddon ? parseInt($('input[name="deck_type"]:checked').val()) : 0,
                        deck_title: hasDeckAddon ? deckTitle : '',
                        deck_addresses: deck_addresses,
                        custom_total_amount: currentTotal * 100
                    };

                    // Send via AJAX
                    console.log('Sending payload:', payload);
                    $.ajax({
                        url: "{{ route('register') }}",
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Accept': 'application/json'
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
                                console.error("Tesing");
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
                amount: currentTotal,
                currency: 'usd',
                paymentMethodCreation: 'manual',
                paymentMethodTypes: ['card'],
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

$(document).ready(function () {
    let stripe, elements, paymentElement;

    // Retrieve configuration or fallback to defaults
    const config = window.checkoutConfig || {};
    const subscriptionLength = config.subscriptionLength !== undefined ? config.subscriptionLength : 12;
    const formatTextOnline = config.formatTextOnline || 'Online Access Only — 1 Year';
    const formatTextPrint = config.formatTextPrint || 'Online Access & Print — 1 Year';
    const stripeKey = config.stripeKey || 'pk_test_TYooMQauvdEDq54NiTphI7jx';
    const registerUrl = config.registerUrl || '/register';
    const registerEmailsUrl = config.registerEmailsUrl || '/register-emails';

    let basePrice = window.checkoutConfig.basePriceOnline;

    $('#format-online').on('click', function () {
        $('#format-online').addClass('selected');
        $('#format-print').removeClass('selected');
        basePrice = window.checkoutConfig.basePriceOnline;
        isPrint = false;
        updateSummary();
        renderShippingAddresses();
    });

    $('#format-print').on('click', function () {
        $('#format-print').addClass('selected');
        $('#format-online').removeClass('selected');
        basePrice = window.checkoutConfig.basePricePrint;
        isPrint = true;
        updateSummary();
        renderShippingAddresses();
    });

    let isPrint = false;
    let hasUserAddon = false;
    let userQty = 1;
    let userPrice = config.userPrice !== undefined ? config.userPrice : 100;
    let hasDeckAddons = false;
    let isDeckVerified = $('.deck-verification-row').is(':visible') ? false : true;
    let bookQty = 1;
    let shipToSameAddress = true;
    let selectedAddons = [];
    let currentTotal = basePrice;

    console.log(currentTotal);

    function updateSummary() {
        let currentBasePrice = basePrice;
        let total = currentBasePrice;

        // Base Plan
        if (isPrint) {
            $('#summary-format-text').text(formatTextPrint);
            $('#note-print').show();
        } else {
            $('#summary-format-text').text(formatTextOnline);
            $('#note-print').hide();
        }
        $('#summary-base-price').text('$' + currentBasePrice.toLocaleString());

        // Update header price if it exists
        $('.price-amount').text('$' + currentBasePrice.toLocaleString());

        // User Addon
        if (hasUserAddon) {
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

        // Multiple Addons
        $('#summary-addon-deck').empty();
        let hasAnyAddon = false;
        selectedAddons.forEach(function (addon) {
            hasAnyAddon = true;
            let qty = addon.id.endsWith('_book') ? bookQty : 1;
            let addonTotal = qty * addon.price;
            total += addonTotal;

            let qtyHtml = qty > 1 ? `<span style="font-weight: 400; color: var(--text-muted);">x ${qty}</span>` : '';

            let html = `
                <div>
                    <div class="summary-item-title"><span>${addon.title}</span> ${qtyHtml}</div>
                    <div class="summary-item-desc">One-time charge</div>
                </div>
                <div class="summary-item-price">$${addonTotal.toLocaleString()}</div>
            `;

            let wrapper = $('<div class="summary-item"></div>').html(html);
            $('#summary-addon-deck').append(wrapper);
        });

        if (hasAnyAddon) {
            $('#summary-addon-deck').show();
            $('#note-deck').show();
        } else {
            $('#summary-addon-deck').hide();
            $('#note-deck').hide();
        }

        // Total
        $('#summary-total-price').text('$' + total.toLocaleString());
        currentTotal = total;

        // Update Stripe elements amount if initialized
        if (typeof elements !== 'undefined' && elements) {
            elements.update({ amount: currentTotal * 100 });
        }
    }

    function renderAddonEmails() {
        if (!hasUserAddon) {
            $('#addon-user-emails-container').hide().empty();
            return;
        }
        let container = $('#addon-user-emails-container');
        let existingValues = [];
        $('.addon-email-input').each(function () {
            existingValues.push($(this).val());
        });

        container.empty().show();
        for (let i = 0; i < userQty; i++) {
            let val = existingValues[i] ? existingValues[i] : '';
            container.append(`
                <div class="form-group checkout-mb12">
                    <label class="form-label checkout-fs12">Additional User ${i + 1} Email <span class="required">*</span></label>
                    <input type="email" class="form-control addon-email-input" placeholder="user${i + 1}@example.com" value="${val}" required>
                    <div class="invalid-feedback">Required</div>
                </div>
            `);
        }
    }

    function renderShippingAddresses() {
        let deckContainer = $('#deck-shipping-addresses-container');

        let existingDeck = [];
        deckContainer.find('.shipping-address-item').each(function (index) {
            existingDeck.push({
                line1: $(this).find('input[name*="[line1]"]').val() || '',
                line2: $(this).find('input[name*="[line2]"]').val() || '',
                city: $(this).find('input[name*="[city]"]').val() || '',
                state: $(this).find('select[name*="[state]"]').val() || '',
                zip_code: $(this).find('input[name*="[zip_code]"]').val() || ''
            });
        });

        deckContainer.empty();

        let AddressBlockClass = Vue.extend(Vue.component('ctb-address-block'));

        let hasBook = selectedAddons.some(a => a.id.endsWith('_book'));
        if (hasBook) {
            if (bookQty > 1) {
                let checkboxDiv = $(`
                    <div style="margin-bottom: 15px; padding: 10px; background-color: #f8fafc; border-radius: 6px; border: 1px solid #e2e8f0;">
                        <label class="custom-checkbox" style="font-size: 13px; font-weight: 500; margin-bottom: 0; display: flex; align-items: center; padding-left: 0; gap: 10px;">
                            <input type="checkbox" id="same-address-checkbox" ${shipToSameAddress ? 'checked' : ''}>
                            <span class="checkmark" style="position: relative; top: 0; left: 0; margin-top: 0; flex-shrink: 0;"></span>
                            Ship all ${bookQty} copies to the same address
                        </label>
                    </div>
                `);
                deckContainer.append(checkboxDiv);
                
                checkboxDiv.find('#same-address-checkbox').on('change', function() {
                    shipToSameAddress = $(this).is(':checked');
                    renderShippingAddresses();
                });
            }

            let formsToRender = (bookQty > 1 && shipToSameAddress) ? 1 : bookQty;

            for (let i = 0; i < formsToRender; i++) {
                let data = existingDeck[i] || { line1: '', line2: '', city: '', state: 'CA', zip_code: '' };
                let itemTitle = 'Shipping Address';
                if (bookQty > 1) {
                    itemTitle = shipToSameAddress ? `Shipping Address &mdash; all ${bookQty} copies` : `Shipping Address ${i + 1}`;
                }
                let itemDiv = $(`
                    <div class="shipping-address-item${i > 0 ? ' shipping-address-item-divider' : ''}">
                        <h4 class="shipping-address-item-title" style="margin-bottom: 10px; font-size: 14px; font-weight: 600;">${itemTitle}</h4>
                    </div>
                `);
                let instance = new AddressBlockClass({
                    propsData: {
                        name: `deck_shipping_${i}`,
                        input: { line1: data.line1, line2: data.line2, city: data.city, state: data.state, zip_code: data.zip_code },
                        layout: 'checkout'
                    }
                });
                let targetDiv = $('<div class="shipping-address-instance"></div>');
                itemDiv.append(targetDiv);
                deckContainer.append(itemDiv);
                instance.$mount(targetDiv[0]);
            }
        }
    }

    // Plan Selection
    $('.format-card').on('click', function () {
        $('.format-card').removeClass('selected');
        $(this).addClass('selected');

        if ($(this).attr('id') === 'format-print') {
            isPrint = true;
        } else {
            isPrint = false;
        }
        updateSummary();
        renderShippingAddresses();
    });

    // Additional User Checkbox
    $('#addon-user').on('change', function () {
        hasUserAddon = $(this).is(':checked');
        if (hasUserAddon) {
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
    $('#qty-plus').on('click', function (e) {
        e.preventDefault();
        userQty++;
        $('#addon-user-qty').val(userQty);
        updateSummary();
        renderAddonEmails();
    });

    // User Qty Buttons
    $('#qty-minus').on('click', function (e) {
        e.preventDefault();
        if (userQty > 1) {
            userQty--;
            $('#addon-user-qty').val(userQty);
            updateSummary();
            renderAddonEmails();
        }
    });

    function parseSelectedAddons() {
        selectedAddons = [];
        $('input[name="deck_types[]"]:checked').each(function () {
            let val = $(this).val();
            let priceStr = val.split('_')[0];
            let price = parseInt(priceStr) || 300;
            let title = $(this).siblings('.deck-radio-content').find('.deck-radio-title').text().replace(/\s*\$[0-9,]+$/, '').trim();
            selectedAddons.push({
                id: val,
                price: price,
                title: title
            });
        });
    }

    // Deck Qty Buttons (only for Book)
    $('#deck-qty-plus').on('click', function (e) {
        e.preventDefault();
        bookQty++;
        $('#addon-deck-qty').val(bookQty);
        updateSummary();
        renderShippingAddresses();
    });

    $('#deck-qty-minus').on('click', function (e) {
        e.preventDefault();
        if (bookQty > 1) {
            bookQty--;
            $('#addon-deck-qty').val(bookQty);
            updateSummary();
            renderShippingAddresses();
        }
    });

    // Custom Addon Checkboxes
    $('input[name="deck_types[]"]').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.deck-radio-label').addClass('selected');
        } else {
            $(this).closest('.deck-radio-label').removeClass('selected');
        }

        let hasBook = $('#check-printed-book').is(':checked');
        if (hasBook) {
            $('#deck-qty-wrapper').css('display', 'flex');
            $('#deck-shipping-addresses-container').show();
        } else {
            $('#deck-qty-wrapper').hide();
            $('#deck-shipping-addresses-container').hide();
            bookQty = 1;
            $('#addon-deck-qty').val(bookQty);
        }


        parseSelectedAddons();
        updateSummary();
        renderShippingAddresses();
    });


    // Shipping Address Toggle




    // Real-time password validation
    $(document).on('input keyup', 'input[name="password"], input[name="password_confirmation"]', function () {
        let passwordInput = $('input[name="password"]');
        let confirmInput = $('input[name="password_confirmation"]');
        let passwordVal = passwordInput.val();
        let confirmVal = confirmInput.val();

        // Validate password length
        if (passwordVal.length > 0) {
            if (passwordVal.length < 6) {
                passwordInput.addClass('is-invalid');
                passwordInput.siblings('.invalid-feedback').text('Password must be at least 6 characters');
                passwordInput.siblings('.form-label, .control-label').addClass('is-invalid');
            } else {
                passwordInput.removeClass('is-invalid');
                passwordInput.siblings('.invalid-feedback').text('Required');
                passwordInput.siblings('.form-label, .control-label').removeClass('is-invalid');
            }
        }

        // Validate matching
        if (confirmVal.length > 0) {
            if (passwordVal !== confirmVal) {
                confirmInput.addClass('is-invalid');
                confirmInput.siblings('.invalid-feedback').text('Passwords do not match');
                confirmInput.siblings('.form-label, .control-label').addClass('is-invalid');
            } else {
                confirmInput.removeClass('is-invalid');
                confirmInput.siblings('.invalid-feedback').text('Required');
                confirmInput.siblings('.form-label, .control-label').removeClass('is-invalid');
            }
        } else {
            confirmInput.removeClass('is-invalid');
            confirmInput.siblings('.invalid-feedback').text('Required');
            confirmInput.siblings('.form-label, .control-label').removeClass('is-invalid');
        }
    });

    // Form Validation on Submit
    $('#payment-form').on('submit', async function (e) {
        e.preventDefault();
        let isValid = true;

        // Input fields
        $('.form-group .form-control[required]').each(function () {
            if (!$(this).val()) {
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
        if (!$('#terms').is(':checked')) {
            $('#terms').closest('.checkbox-group').addClass('is-invalid');
            isValid = false;
        } else {
            $('#terms').closest('.checkbox-group').removeClass('is-invalid');
        }

        if (isValid) {
            // Disable button
            let $btn = $('.btn-submit');
            let originalText = $btn.text();
            $btn.prop('disabled', true).text('Processing...');

            try {
                // Trigger form validation and client-side completion in Stripe elements
                const { error: submitError } = await elements.submit();
                if (submitError) {
                    $('#payment-message').text(submitError.message).show();
                    $btn.prop('disabled', false).text(originalText);
                    return;
                }

                // Create PaymentMethod
                const { error, paymentMethod } = await stripe.createPaymentMethod({
                    elements: elements
                });

                if (error) {
                    $('#payment-message').text(error.message).show();
                    $btn.prop('disabled', false).text(originalText);
                    return;
                }

                let bookAddresses = [];
                if (isPrint) {
                    bookAddresses.push({
                        line1: $('input[name="billing[line1]"]').val(),
                        line2: $('input[name="billing[line2]"]').val(),
                        city: $('input[name="billing[city]"]').val(),
                        state: $('select[name="billing[state]"]').val(),
                        zip_code: $('input[name="billing[zip_code]"]').val(),
                        special_instructions: $('input[name="billing[special_instructions]"]').val() || null
                    });
                }

                let deckAddresses = [];
                let hasBookToShip = selectedAddons.some(a => a.id.endsWith('_book'));
                if (hasBookToShip) {
                    for (let i = 0; i < bookQty; i++) {
                        let targetIndex = (bookQty > 1 && shipToSameAddress) ? 0 : i;
                        deckAddresses.push({
                            line1: $(`input[name="deck_shipping_${targetIndex}[line1]"]`).val(),
                            line2: $(`input[name="deck_shipping_${targetIndex}[line2]"]`).val(),
                            city: $(`input[name="deck_shipping_${targetIndex}[city]"]`).val(),
                            state: $(`select[name="deck_shipping_${targetIndex}[state]"]`).val(),
                            zip_code: $(`input[name="deck_shipping_${targetIndex}[zip_code]"]`).val(),
                            special_instructions: $(`input[name="deck_shipping_${targetIndex}[special_instructions]"]`).val()
                        });
                    }
                }

                let addons = [];
                if (hasUserAddon) {
                    $('.addon-email-input').each(function () {
                        if ($(this).val()) addons.push($(this).val());
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
                        name: $('input[name="company\\[name\\]"]').val(),
                        address: {
                            line1: $('input[name="billing[line1]"]').val(),
                            line2: $('input[name="billing[line2]"]').val() || null,
                            city: $('input[name="billing[city]"]').val(),
                            state: $('select[name="billing[state]"]').val(),
                            zip_code: $('input[name="billing[zip_code]"]').val(),
                            special_instructions: $('input[name="billing[special_instructions]"]').val() || null
                        }
                    },
                    book_addresses: bookAddresses,
                    addons: addons,
                    payment_method: 'stripe',
                    stripe_token: paymentMethod.id,
                    subscription_length: subscriptionLength,
                    is_paid_for: false,
                    send_invoice: false,
                    deck_qty: bookQty,
                    deck_types: selectedAddons.map(a => a.id),
                    deck_addresses: deckAddresses,
                    subscription_cost: basePrice * 100,
                    custom_total_amount: currentTotal * 100
                };

                // Send via AJAX
                $.ajax({
                    url: registerUrl,
                    type: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify(payload),
                    success: function (res) {
                        if (res.success) {
                            let firstName = $('input[name="first_name"]').val();
                            let email = $('input[name="email"]').val();

                            $('#success-first-name').text(firstName);
                            $('#success-email').text(email);

                            $('.checkout-container').hide();
                            $('.success-container').show();
                            $('html, body').animate({ scrollTop: 0 }, 300);

                            // Trigger GHL sync and email dispatching in the background via AJAX
                            $.ajax({
                                url: registerEmailsUrl,
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                contentType: 'application/json',
                                data: JSON.stringify({}),
                                success: function (emailRes) {
                                    console.log('Background emails processed:', emailRes);
                                },
                                error: function (emailErr) {
                                    console.error('Failed to trigger background emails:', emailErr);
                                }
                            });
                        } else {
                            alert('Error: ' + (res.message || 'Unknown error'));
                            $btn.prop('disabled', false).text(originalText);
                        }
                    },
                    error: function (err) {
                        console.error(err);
                        let msg = 'An error occurred. Please try again.';
                        if (err.responseJSON && err.responseJSON.message) msg = err.responseJSON.message;
                        if (err.responseJSON && err.responseJSON.errors) {
                            let firstErrorKey = Object.keys(err.responseJSON.errors)[0];
                            msg = err.responseJSON.errors[firstErrorKey][0];
                        }
                        alert(msg);
                        $btn.prop('disabled', false).text(originalText);
                    }
                });

            } catch (e) {
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

    // Sync initially checked options
    $('input[name="deck_types[]"]').each(function() {
        if ($(this).is(':checked')) {
            $(this).closest('.deck-radio-label').addClass('selected');
            let hasBook = $(this).val().endsWith('_book');
            if (hasBook) {
                $('#deck-qty-wrapper').css('display', 'flex');
                $('#label-printed-book .addon-price-span').hide();
                $('#deck-shipping-addresses-container').show();
            }
        }
    });
    parseSelectedAddons();
    updateSummary();
    renderShippingAddresses();

    // Initialize Stripe UI
    try {
        stripe = Stripe(stripeKey);
        console.log(currentTotal);
        const options = {
            mode: 'payment',
            amount: Math.max(currentTotal * 100, 50), // Amount in cents (Stripe requires >= 50)
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
    } catch (e) {
        console.error("Stripe initialization error:", e);
        $('#payment-element').html('<div style="color:#df1b41; padding:20px;">Could not load payment options. Please check your Stripe configuration.</div>');
    }
});

@extends('layouts.portal')

@section('portal_content')
    <div class="section-header as-addsub-1">
        <div class="header-title-container">
            <h1 class="header-title">Add Subscriber</h1>
        </div>
    </div>

    <div class="as-addsub-2" id="form-error-banner"></div>

    <form id="add-subscriber-form" novalidate>
        <!-- Account Info -->
        <h3 class="as-addsub-3">Account Info</h3>
        <div class="portal-card as-addsub-4">
            <div class="card-body-custom as-addsub-5">
                <div class="as-addsub-6">
                    <div class="as-addsub-7">
                        <label class="form-label-style">First Name *</label>
                        <input type="text" id="first_name" class="form-input-style" required>
                    </div>
                    <div class="as-addsub-7">
                        <label class="form-label-style">Last Name *</label>
                        <input type="text" id="last_name" class="form-input-style" required>
                    </div>
                </div>
                <div class="as-addsub-8">
                    <div class="as-addsub-7">
                        <label class="form-label-style">Email *</label>
                        <input type="email" id="email" class="form-input-style" required>
                    </div>
                    <div class="as-addsub-7">
                        <label class="form-label-style">Phone Number *</label>
                        <input type="text" id="phone_number" class="form-input-style" placeholder="10-digit number" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Organization -->
        <h3 class="as-addsub-3">Organization</h3>
        <div class="portal-card as-addsub-4">
            <div class="card-body-custom as-addsub-5">
                <div class="as-addsub-9">
                    <label class="form-label-style">Organization *</label>
                    <input type="text" id="company_name" class="form-input-style" required>
                </div>
                <div class="as-addsub-6">
                    <div class="as-addsub-7">
                        <label class="form-label-style">Address Line 1 *</label>
                        <input type="text" id="company_line1" class="form-input-style" required>
                    </div>
                    <div class="as-addsub-7">
                        <label class="form-label-style">Address Line 2</label>
                        <input type="text" id="company_line2" class="form-input-style">
                    </div>
                </div>
                <div class="as-addsub-8">
                    <div class="as-addsub-10">
                        <label class="form-label-style">City *</label>
                        <input type="text" id="company_city" class="form-input-style" required>
                    </div>
                    <div class="as-addsub-7">
                        <label class="form-label-style">State *</label>
                        <select class="form-input-style as-addsub-11" id="company_state" required>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA" selected>California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                    <div class="as-addsub-12">
                        <label class="form-label-style">Zip Code *</label>
                        <input type="text" id="company_zip" class="form-input-style" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription -->
        <h3 class="as-addsub-3">Subscription</h3>
        <div class="portal-card as-addsub-4">
            <div class="card-body-custom as-addsub-5">
                
                <div class="as-addsub-13">
                    <div>
                        <div class="as-addsub-14">Length *</div>
                        <label class="as-addsub-15">
                            <input type="radio" name="length" value="12"> 12 Month Subscription
                        </label>
                        <label class="as-addsub-16">
                            <input type="radio" name="length" value="24" checked> 24 Month Subscription
                        </label>
                    </div>
                    <div class="as-addsub-17">
                        <span class="as-addsub-18">$</span>
                        <input type="number" id="subscription-cost-input" class="form-input-style as-addsub-19" value="2200">
                        <span class="as-addsub-20">Subscription Cost</span>
                    </div>
                </div>
                
                <div class="as-addsub-21">
                    <div class="as-addsub-22">
                        <div>
                            <div class="as-addsub-14">Additional Printed Book </div>
                            <div class="as-addsub-23">
                                <button class="as-addsub-24" type="button" id="btn-book-dec">-</button>
                                <span class="as-addsub-25" id="book-count-val">0</span>
                                <button class="as-addsub-24" type="button" id="btn-book-inc">+</button>
                            </div>
                        </div>
                        <div class="as-addsub-17">
                            <span class="as-addsub-18">$</span>
                            <input type="number" id="book-cost-input" class="form-input-style as-addsub-19" value="1000">
                            <span class="as-addsub-20">Book Cost (Per Book)</span>
                        </div>
                    </div>
                    
                    <!-- Dynamic Book Addresses Container -->
                    <div class="as-addsub-26" id="book-addresses-container"></div>
                </div>
                
                <div class="as-addsub-27">
                    <div class="as-addsub-22">
                        <div>
                            <div class="as-addsub-14">Addons</div>
                            <div class="as-addsub-23">
                                <button class="as-addsub-24" type="button" id="btn-addon-dec">-</button>
                                <span class="as-addsub-25" id="addon-count-val">0</span>
                                <button class="as-addsub-24" type="button" id="btn-addon-inc">+</button>
                            </div>
                        </div>
                        <div class="as-addsub-17">
                            <span class="as-addsub-18">$</span>
                            <input type="number" id="addon-cost-input" class="form-input-style as-addsub-19" value="100">
                            <span class="as-addsub-20">Addon Cost (Per User)</span>
                        </div>
                    </div>
                    
                    <!-- Dynamic Addon Emails Container -->
                    <div class="as-addsub-28" id="addons-container"></div>
                </div>
                
            </div>
        </div>

        <!-- Payment -->
        <h3 class="as-addsub-3">Payment</h3>
        <div class="portal-card as-addsub-4">
            <div class="card-body-custom as-addsub-29">
                <div class="as-addsub-7">
                    <div class="as-addsub-30">Payment Method</div>
                    <div class="as-addsub-31">
                        <label class="as-addsub-16">
                            <input type="radio" name="payment_method" value="stripe" checked> Paying By Credit Card
                        </label>
                        <label class="as-addsub-16">
                            <input type="radio" name="payment_method" value="check"> Paying By Check
                        </label>
                    </div>
                    
                    <div id="stripe-input-container">
                        <div class="as-addsub-32">Credit or Debit Card *</div>
                        <div class="as-addsub-33" id="card-element"></div>
                        <div class="as-addsub-34" id="card-errors" role="alert"></div>
                    </div>
                </div>
                
                <div class="as-addsub-35">
                    <div class="as-addsub-36">Paid Up</div>
                    <p class="as-addsub-37">Check this box to mark the subscriber as paid. This will make their subscription active. This will not charge them.</p>
                    <div class="as-addsub-38">
                        <label class="as-addsub-39">
                            <input type="checkbox" id="is_paid_for"> Is Paid For
                        </label>
                        <label class="as-addsub-39">
                            <input type="checkbox" id="send_invoice" checked> Email Invoice
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <h3 class="as-addsub-3">Summary</h3>
        <div class="portal-card as-addsub-40">
            <table class="portal-grid-table">
                <tbody>
                    <tr>
                        <td class="as-addsub-41">Base Subscription</td>
                        <td class="as-addsub-42" id="summary-base">$0</td>
                    </tr>
                    <tr>
                        <td class="as-addsub-41">Hard Copies</td>
                        <td class="as-addsub-43" id="summary-books">$0</td>
                    </tr>
                    <tr>
                        <td class="as-addsub-41">Addons</td>
                        <td class="as-addsub-43" id="summary-addons">$0</td>
                    </tr>
                    <tr class="as-addsub-44">
                        <td class="as-addsub-45">Total</td>
                        <td class="as-addsub-46" id="summary-total">$0</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="as-addsub-47">
            <button class="as-addsub-48" type="submit" id="btn-submit">SUBMIT</button>
        </div>
    </form>
@endsection

@section('portal_scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function () {
            // Ensure window.globals is defined (required by master_headless layout)
            if (!window.globals) {
                window.globals = {
                    STRIPE_PUB_KEY: window.STRIPE_PUB_KEY || "",
                    getBookCountForSubscription: function (yrCount) {
                        var yr = (new Date()).getFullYear();
                        var mth = (new Date()).getMonth();
                        var bookDeliveries = {
                            0: [3, 5, 10],
                            1: [5, 11]
                        };
                        var bookCount = 0;
                        for (var i = 0, b = yr % 2; i < (yrCount * 12); i++) {
                            var m = i + mth;
                            if (m % 12 === 0 && m !== 0) b = (b + 1) % 2;
                            if (bookDeliveries[b].indexOf(m % 12) !== -1) bookCount++;
                        }
                        return bookCount;
                    }
                };
            }

            const apiToken = "{{ Auth::user()->api_token }}";

            // State template options
            const stateOptions = `
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA" selected>California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            `;

            // Stripe Initialization
            let stripe, card;
            if (window.globals && window.globals.STRIPE_PUB_KEY) {
                stripe = Stripe(window.globals.STRIPE_PUB_KEY);
                const elements = stripe.elements();
                card = elements.create('card', {
                    style: {
                        base: {
                            color: '#0f172a',
                            fontFamily: 'Outfit, sans-serif',
                            fontSize: '14px',
                            '::placeholder': {
                                color: '#94a3b8',
                            },
                        },
                        invalid: {
                            color: '#ef4444',
                            iconColor: '#ef4444',
                        },
                    },
                });
                card.mount('#card-element');
                card.on('change', function (event) {
                    const displayError = document.getElementById('card-errors');
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });
            }

            // Calculation updates
            function updateTotals() {
                const baseCost = parseFloat($('#subscription-cost-input').val()) || 0;
                const bookCost = parseFloat($('#book-cost-input').val()) || 0;
                const addonCost = parseFloat($('#addon-cost-input').val()) || 0;

                const bookCount = parseInt($('#book-count-val').text()) || 0;
                const addonCount = parseInt($('#addon-count-val').text()) || 0;

                const totalBase = baseCost;
                const totalBooks = bookCount * bookCost;
                const totalAddons = addonCount * addonCost;
                const grandTotal = totalBase + totalBooks + totalAddons;

                // Update summary elements
                $('#summary-base').text('$' + totalBase.toLocaleString());
                $('#summary-books').text('$' + totalBooks.toLocaleString());
                $('#summary-addons').text('$' + totalAddons.toLocaleString());
                $('#summary-total').text('$' + grandTotal.toLocaleString());
            }

            // Watch subscription length radio changes
            $('input[name="length"]').on('change', function() {
                const lengthVal = parseInt($(this).val());
                if (lengthVal === 12) {
                    $('#subscription-cost-input').val(1200);
                } else {
                    $('#subscription-cost-input').val(2200);
                }
                updateTotals();
            });

            // Watch cost inputs
            $('#subscription-cost-input, #book-cost-input, #addon-cost-input').on('input', updateTotals);

            // Increment/Decrement Book count
            $('#btn-book-inc').on('click', function() {
                const countSpan = $('#book-count-val');
                let count = parseInt(countSpan.text()) || 0;
                count++;
                countSpan.text(count);
                appendBookAddressForm(count - 1);
                updateTotals();
            });

            $('#btn-book-dec').on('click', function() {
                const countSpan = $('#book-count-val');
                let count = parseInt(countSpan.text()) || 0;
                if (count <= 0) return;
                count--;
                countSpan.text(count);
                removeLastBookAddressForm();
                updateTotals();
            });

            // Increment/Decrement Addon count
            $('#btn-addon-inc').on('click', function() {
                const countSpan = $('#addon-count-val');
                let count = parseInt(countSpan.text()) || 0;
                count++;
                countSpan.text(count);
                appendAddonInput(count - 1);
                updateTotals();
            });

            $('#btn-addon-dec').on('click', function() {
                const countSpan = $('#addon-count-val');
                let count = parseInt(countSpan.text()) || 0;
                if (count <= 0) return;
                count--;
                countSpan.text(count);
                removeLastAddonInput();
                updateTotals();
            });

            // Dynamically add/remove elements
            function appendBookAddressForm(index) {
                const container = $('#book-addresses-container');
                const formHtml = `
                    <div class="book-address-item as-addsub-49" data-index="${index}">
                        <h4 class="as-addsub-50">Book Delivery Address #${index + 1}</h4>
                        <div class="as-addsub-6">
                            <div class="as-addsub-7">
                                <label class="form-label-style">Address Line 1 *</label>
                                <input type="text" class="form-input-style book-line1" required>
                            </div>
                            <div class="as-addsub-7">
                                <label class="form-label-style">Address Line 2</label>
                                <input type="text" class="form-input-style book-line2">
                            </div>
                        </div>
                        <div class="as-addsub-6">
                            <div class="as-addsub-10">
                                <label class="form-label-style">City *</label>
                                <input type="text" class="form-input-style book-city" required>
                            </div>
                            <div class="as-addsub-7">
                                <label class="form-label-style">State *</label>
                                <select class="form-input-style book-state as-addsub-11" required>
                                    ${stateOptions}
                                </select>
                            </div>
                            <div class="as-addsub-12">
                                <label class="form-label-style">Zip Code *</label>
                                <input type="text" class="form-input-style book-zip" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label-style">Special Instructions</label>
                            <textarea class="form-input-style book-instructions as-addsub-51"></textarea>
                        </div>
                    </div>
                `;
                container.append(formHtml);
            }

            function removeLastBookAddressForm() {
                $('#book-addresses-container .book-address-item').last().remove();
            }

            function appendAddonInput(index) {
                const container = $('#addons-container');
                const inputHtml = `
                    <div class="addon-item as-addsub-52" data-index="${index}">
                        <label class="form-label-style">Addon Email #${index + 1} *</label>
                        <input type="email" class="form-input-style addon-email" placeholder="Enter email address" required>
                    </div>
                `;
                container.append(inputHtml);
            }

            function removeLastAddonInput() {
                $('#addons-container .addon-item').last().remove();
            }

            // Payment Method toggle
            $('input[name="payment_method"]').on('change', function() {
                const method = $(this).val();
                const container = $('#stripe-input-container');
                if (method === 'stripe') {
                    container.slideDown(1000);
                } else {
                    container.slideUp(1000);
                }
            });

            // Form validation
            function validateForm() {
                let isValid = true;
                $('.error-msg').remove();
                $('input, select, textarea').css('border-color', '#cbd5e1');

                // Required fields
                const fields = [
                    { id: 'first_name', label: 'First Name' },
                    { id: 'last_name', label: 'Last Name' },
                    { id: 'email', label: 'Email', type: 'email' },
                    { id: 'phone_number', label: 'Phone Number' },
                    { id: 'company_name', label: 'Organization' },
                    { id: 'company_line1', label: 'Address Line 1' },
                    { id: 'company_city', label: 'City' },
                    { id: 'company_state', label: 'State' },
                    { id: 'company_zip', label: 'Zip Code' }
                ];

                fields.forEach(f => {
                    const $el = $('#' + f.id);
                    const val = $el.val() ? $el.val().trim() : '';
                    if (!val) {
                        showError($el, 'This field is required.');
                        isValid = false;
                    } else if (f.type === 'email' && !validateEmail(val)) {
                        showError($el, 'Please enter a valid email.');
                        isValid = false;
                    }
                });

                // Book addresses validation
                const bookCount = parseInt($('#book-count-val').text()) || 0;
                if (bookCount > 0) {
                    $('.book-address-item').each(function() {
                        const idx = $(this).data('index');
                        const $line1 = $(this).find('.book-line1');
                        const $city = $(this).find('.book-city');
                        const $state = $(this).find('.book-state');
                        const $zip = $(this).find('.book-zip');

                        if (!$line1.val().trim()) { showError($line1, 'Required.'); isValid = false; }
                        if (!$city.val().trim()) { showError($city, 'Required.'); isValid = false; }
                        if (!$state.val().trim()) { showError($state, 'Required.'); isValid = false; }
                        if (!$zip.val().trim()) { showError($zip, 'Required.'); isValid = false; }
                    });
                }

                // Addon emails validation
                const addonCount = parseInt($('#addon-count-val').text()) || 0;
                if (addonCount > 0) {
                    $('.addon-email').each(function() {
                        const val = $(this).val().trim();
                        if (!val) {
                            showError($(this), 'Required.');
                            isValid = false;
                        } else if (!validateEmail(val)) {
                            showError($(this), 'Please enter a valid email.');
                            isValid = false;
                        }
                    });
                }

                return isValid;
            }

            function showError($el, msg) {
                $el.css('border-color', '#ef4444');
                $el.after(`<div class="error-msg as-addsub-53">${msg}</div>`);
            }

            function validateEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            function showBannerError(msg) {
                const banner = $('#form-error-banner');
                banner.html(msg).slideDown(250);
                $('html, body').animate({ scrollTop: 0 }, 250);
            }

            function setSubmitLoading(isLoading) {
                const btn = $('#btn-submit');
                if (isLoading) {
                    btn.prop('disabled', true).css({
                        'background-color': '#ef9a9a',
                        'cursor': 'not-allowed'
                    }).text('SUBMITTING...');
                } else {
                    btn.prop('disabled', false).css({
                        'background-color': '#d32f2f',
                        'cursor': 'pointer'
                    }).text('SUBMIT');
                }
            }

            // Submit handler
            $('#add-subscriber-form').on('submit', function(e) {
                e.preventDefault();
                $('#form-error-banner').hide();

                if (!validateForm()) {
                    showBannerError('Please resolve the errors highlighted in red in the form below.');
                    return;
                }

                const paymentMethod = $('input[name="payment_method"]:checked').val();
                if (paymentMethod === 'stripe') {
                    setSubmitLoading(true);
                    stripe.createToken(card).then(function(result) {
                        if (result.error) {
                            setSubmitLoading(false);
                            $('#card-errors').text(result.error.message);
                            showBannerError(result.error.message);
                        } else {
                            submitData(result.token.id);
                        }
                    });
                } else {
                    submitData(null);
                }
            });

            function submitData(stripeToken) {
                setSubmitLoading(true);

                const payload = {
                    first_name: $('#first_name').val().trim(),
                    last_name: $('#last_name').val().trim(),
                    email: $('#email').val().trim(),
                    phone_number: $('#phone_number').val().trim(),
                    company: {
                        name: $('#company_name').val().trim(),
                        address: {
                            line1: $('#company_line1').val().trim(),
                            line2: $('#company_line2').val().trim(),
                            city: $('#company_city').val().trim(),
                            state: $('#company_state').val(),
                            zip_code: $('#company_zip').val().trim(),
                        }
                    },
                    subscription_length: $('input[name="length"]:checked').val(),
                    subscription_cost: parseFloat($('#subscription-cost-input').val()) * 100, // in cents
                    book_count: parseInt($('#book-count-val').text()) || 0,
                    book_cost: parseFloat($('#book-cost-input').val()) * 100, // in cents
                    addon_count: parseInt($('#addon-count-val').text()) || 0,
                    addon_cost: parseFloat($('#addon-cost-input').val()) * 100, // in cents
                    payment_method: $('input[name="payment_method"]:checked').val(),
                    stripe_token: stripeToken,
                    is_paid_for: $('#is_paid_for').is(':checked') ? 1 : 0,
                    send_invoice: $('#send_invoice').is(':checked') ? 1 : 0,
                    book_addresses: [],
                    addons: []
                };

                // Add book addresses
                $('.book-address-item').each(function() {
                    payload.book_addresses.push({
                        line1: $(this).find('.book-line1').val().trim(),
                        line2: $(this).find('.book-line2').val().trim(),
                        city: $(this).find('.book-city').val().trim(),
                        state: $(this).find('.book-state').val(),
                        zip_code: $(this).find('.book-zip').val().trim(),
                        special_instructions: $(this).find('.book-instructions').val().trim()
                    });
                });

                // Add addon emails
                $('.addon-email').each(function() {
                    payload.addons.push($(this).val().trim());
                });

                $.ajax({
                    url: '/api/users',
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + apiToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify(payload),
                    success: function(res) {
                        setSubmitLoading(false);
                        window.location.href = '/ctb-admin/new/contacts/' + res.id;
                    },
                    error: function(xhr) {
                        setSubmitLoading(false);
                        let errMsg = 'There was an error creating the subscriber.';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            let listErrors = '<ul class="as-addsub-54">';
                            Object.keys(errors).forEach(key => {
                                const fieldErr = errors[key].join(' ');
                                listErrors += `<li>${fieldErr}</li>`;

                                // Highlight the input field
                                if (key.startsWith('company.address.')) {
                                    const subkey = key.replace('company.address.', '');
                                    showError($('#company_' + subkey), fieldErr);
                                } else if (key.startsWith('company.')) {
                                    showError($('#company_name'), fieldErr);
                                } else if (key.startsWith('book_addresses.')) {
                                    const parts = key.split('.');
                                    const idx = parts[1];
                                    const field = parts[2];
                                    const $item = $(`.book-address-item[data-index="${idx}"]`);
                                    if ($item.length) {
                                        showError($item.find(`.book-${field}`), fieldErr);
                                    }
                                } else if (key.startsWith('addons.')) {
                                    const idx = key.split('.')[1];
                                    const $input = $(`.addon-email`).eq(idx);
                                    showError($input, fieldErr);
                                } else {
                                    showError($('#' + key), fieldErr);
                                }
                            });
                            listErrors += '</ul>';
                            errMsg = `<b>Please correct the validation errors:</b><br/>${listErrors}`;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }
                        showBannerError(errMsg);
                    }
                });
            }

            // Initialize Page totals
            updateTotals();
        });
    </script>
@endsection

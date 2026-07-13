@extends('layouts.portal')

@section('portal_content')
    <div class="section-header" style="margin-bottom: 32px;">
        <div class="header-title-container">
            <h1 class="header-title">Add Subscriber</h1>
        </div>
    </div>

    <div id="form-error-banner" style="display: none; background-color: #fef2f2; color: #ef4444; border: 1px solid #fca5a5; padding: 14px 20px; border-radius: 6px; margin-bottom: 24px; font-weight: 600; font-size: 13.5px; line-height: 1.5;"></div>

    <form id="add-subscriber-form" novalidate>
        <!-- Account Info -->
        <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Account Info</h3>
        <div class="portal-card" style="margin-bottom: 32px; padding: 24px;">
            <div class="card-body-custom" style="padding: 0;">
                <div style="display: flex; gap: 24px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label class="form-label-style">First Name *</label>
                        <input type="text" id="first_name" class="form-input-style" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label-style">Last Name *</label>
                        <input type="text" id="last_name" class="form-input-style" required>
                    </div>
                </div>
                <div style="display: flex; gap: 24px;">
                    <div style="flex: 1;">
                        <label class="form-label-style">Email *</label>
                        <input type="email" id="email" class="form-input-style" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label-style">Phone Number *</label>
                        <input type="text" id="phone_number" class="form-input-style" placeholder="10-digit number" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Organization -->
        <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Organization</h3>
        <div class="portal-card" style="margin-bottom: 32px; padding: 24px;">
            <div class="card-body-custom" style="padding: 0;">
                <div style="margin-bottom: 16px; max-width: 50%;">
                    <label class="form-label-style">Organization *</label>
                    <input type="text" id="company_name" class="form-input-style" required>
                </div>
                <div style="display: flex; gap: 24px; margin-bottom: 16px;">
                    <div style="flex: 1;">
                        <label class="form-label-style">Address Line 1 *</label>
                        <input type="text" id="company_line1" class="form-input-style" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label-style">Address Line 2</label>
                        <input type="text" id="company_line2" class="form-input-style">
                    </div>
                </div>
                <div style="display: flex; gap: 24px;">
                    <div style="flex: 2;">
                        <label class="form-label-style">City *</label>
                        <input type="text" id="company_city" class="form-input-style" required>
                    </div>
                    <div style="flex: 1;">
                        <label class="form-label-style">State *</label>
                        <select class="form-input-style" id="company_state" style="padding-top: 7px; padding-bottom: 7px;" required>
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
                    <div style="flex: 1.5;">
                        <label class="form-label-style">Zip Code *</label>
                        <input type="text" id="company_zip" class="form-input-style" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscription -->
        <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Subscription</h3>
        <div class="portal-card" style="margin-bottom: 32px; padding: 24px;">
            <div class="card-body-custom" style="padding: 0;">
                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 24px;">
                    <div>
                        <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 12px;">Length *</div>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; margin-bottom: 8px; cursor: pointer;">
                            <input type="radio" name="length" value="12"> 12 Month Subscription
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; cursor: pointer;">
                            <input type="radio" name="length" value="24" checked> 24 Month Subscription
                        </label>
                    </div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 16px; font-weight: 500; color: #0f172a;">$</span>
                        <input type="number" id="subscription-cost-input" class="form-input-style" value="2200" style="width: 150px; text-align: right; font-weight: 600; font-size: 16px;">
                        <span style="font-size: 13px; color: #64748b; width: 120px;">Subscription Cost</span>
                    </div>
                </div>
                
                <div style="display: flex; flex-direction: column; margin-bottom: 24px; border-bottom: 1px solid #f1f5f9; padding-bottom: 24px; gap: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                        <div>
                            <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 12px;">Hard Copy Subscriptions</div>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <button type="button" id="btn-book-dec" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 700;">-</button>
                                <span id="book-count-val" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; font-size: 15px; font-weight: 700; color: #0f172a;">0</span>
                                <button type="button" id="btn-book-inc" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 700;">+</button>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-size: 16px; font-weight: 500; color: #0f172a;">$</span>
                            <input type="number" id="book-cost-input" class="form-input-style" value="500" style="width: 150px; text-align: right; font-weight: 600; font-size: 16px;">
                            <span style="font-size: 13px; color: #64748b; width: 120px;">Book Cost (Per Book)</span>
                        </div>
                    </div>
                    
                    <!-- Dynamic Book Addresses Container -->
                    <div id="book-addresses-container" style="display: flex; flex-direction: column; gap: 20px; width: 100%;"></div>
                </div>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                        <div>
                            <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 12px;">Addons</div>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <button type="button" id="btn-addon-dec" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 700;">-</button>
                                <span id="addon-count-val" style="display: inline-flex; align-items: center; justify-content: center; width: 32px; font-size: 15px; font-weight: 700; color: #0f172a;">0</span>
                                <button type="button" id="btn-addon-inc" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #475569; width: 32px; height: 32px; border-radius: 4px; font-size: 18px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: 700;">+</button>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-size: 16px; font-weight: 500; color: #0f172a;">$</span>
                            <input type="number" id="addon-cost-input" class="form-input-style" value="100" style="width: 150px; text-align: right; font-weight: 600; font-size: 16px;">
                            <span style="font-size: 13px; color: #64748b; width: 120px;">Addon Cost (Per User)</span>
                        </div>
                    </div>
                    
                    <!-- Dynamic Addon Emails Container -->
                    <div id="addons-container" style="display: flex; flex-direction: column; gap: 12px; width: 100%;"></div>
                </div>
                
            </div>
        </div>

        <!-- Payment -->
        <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Payment</h3>
        <div class="portal-card" style="margin-bottom: 32px; padding: 24px;">
            <div class="card-body-custom" style="padding: 0; display: flex; gap: 40px; width: 100%;">
                <div style="flex: 1;">
                    <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 16px;">Payment Method</div>
                    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; cursor: pointer;">
                            <input type="radio" name="payment_method" value="stripe" checked> Paying By Credit Card
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; cursor: pointer;">
                            <input type="radio" name="payment_method" value="check"> Paying By Check
                        </label>
                    </div>
                    
                    <div id="stripe-input-container">
                        <div style="font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 8px;">Credit or Debit Card *</div>
                        <div id="card-element" style="border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px; background: #ffffff;"></div>
                        <div id="card-errors" style="color: #ef4444; font-size: 12.5px; margin-top: 6px; font-weight: 500;" role="alert"></div>
                    </div>
                </div>
                
                <div style="flex: 1; border-left: 1px solid #f1f5f9; padding-left: 40px;">
                    <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 8px;">Paid Up</div>
                    <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin: 0 0 16px 0;">Check this box to mark the subscriber as paid. This will make their subscription active. This will not charge them.</p>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; font-weight: 500; cursor: pointer;">
                            <input type="checkbox" id="is_paid_for"> Is Paid For
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: #475569; font-weight: 500; cursor: pointer;">
                            <input type="checkbox" id="send_invoice" checked> Email Invoice
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <h3 style="font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Summary</h3>
        <div class="portal-card" style="padding: 0; margin-bottom: 32px;">
            <table class="portal-grid-table">
                <tbody>
                    <tr>
                        <td style="font-weight: 500; color: #475569; border-bottom: 1px solid #f1f5f9; padding: 14px 24px;">Base Subscription</td>
                        <td style="text-align: right; font-weight: 600; color: #0f172a; width: 150px; border-bottom: 1px solid #f1f5f9; padding: 14px 24px;" id="summary-base">$0</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 500; color: #475569; border-bottom: 1px solid #f1f5f9; padding: 14px 24px;">Hard Copies</td>
                        <td style="text-align: right; font-weight: 600; color: #0f172a; border-bottom: 1px solid #f1f5f9; padding: 14px 24px;" id="summary-books">$0</td>
                    </tr>
                    <tr>
                        <td style="font-weight: 500; color: #475569; border-bottom: 1px solid #f1f5f9; padding: 14px 24px;">Addons</td>
                        <td style="text-align: right; font-weight: 600; color: #0f172a; border-bottom: 1px solid #f1f5f9; padding: 14px 24px;" id="summary-addons">$0</td>
                    </tr>
                    <tr style="background-color: #f8fafc;">
                        <td style="font-weight: 700; color: #0f172a; border-bottom: none; padding: 14px 24px;">Total</td>
                        <td style="text-align: right; font-weight: 700; color: #0f172a; font-size: 16px; border-bottom: none; padding: 14px 24px;" id="summary-total">$0</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div style="display: flex; justify-content: flex-end; margin-top: 24px; padding-bottom: 80px;">
            <button type="submit" id="btn-submit" style="background-color: #4f46e5; color: #ffffff; padding: 12px 40px; border: none; border-radius: 6px; font-weight: 600; font-size: 14px; cursor: pointer; transition: background-color 0.15s ease-in-out;">SUBMIT</button>
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

            // Book Cost helper function
            function getBookCostBase(freq) {
                if (window.globals && typeof window.globals.getBookCountForSubscription === 'function') {
                    const yrCount = freq / 12;
                    return 100 * window.globals.getBookCountForSubscription(yrCount);
                }
                return freq === 12 ? 300 : 500; // fallback default values
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
                    $('#book-cost-input').val(getBookCostBase(12));
                } else {
                    $('#subscription-cost-input').val(2200);
                    $('#book-cost-input').val(getBookCostBase(24));
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
                    <div class="book-address-item" data-index="${index}" style="border: 1px solid #cbd5e1; border-radius: 8px; padding: 20px; background-color: #f8fafc; margin-top: 12px;">
                        <h4 style="font-size: 13.5px; font-weight: 700; color: #1e293b; margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 8px;">Book Delivery Address #${index + 1}</h4>
                        <div style="display: flex; gap: 24px; margin-bottom: 16px;">
                            <div style="flex: 1;">
                                <label class="form-label-style">Address Line 1 *</label>
                                <input type="text" class="form-input-style book-line1" required>
                            </div>
                            <div style="flex: 1;">
                                <label class="form-label-style">Address Line 2</label>
                                <input type="text" class="form-input-style book-line2">
                            </div>
                        </div>
                        <div style="display: flex; gap: 24px; margin-bottom: 16px;">
                            <div style="flex: 2;">
                                <label class="form-label-style">City *</label>
                                <input type="text" class="form-input-style book-city" required>
                            </div>
                            <div style="flex: 1;">
                                <label class="form-label-style">State *</label>
                                <select class="form-input-style book-state" style="padding-top: 7px; padding-bottom: 7px;" required>
                                    ${stateOptions}
                                </select>
                            </div>
                            <div style="flex: 1.5;">
                                <label class="form-label-style">Zip Code *</label>
                                <input type="text" class="form-input-style book-zip" required>
                            </div>
                        </div>
                        <div>
                            <label class="form-label-style">Special Instructions</label>
                            <textarea class="form-input-style book-instructions" style="height: 60px; padding: 8px 12px; resize: none;"></textarea>
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
                    <div class="addon-item" data-index="${index}" style="display: flex; flex-direction: column; gap: 6px; margin-top: 8px;">
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
                    container.slideDown(200);
                } else {
                    container.slideUp(200);
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
                $el.after(`<div class="error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px; font-weight: 500;">${msg}</div>`);
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
                        'background-color': '#818cf8',
                        'cursor': 'not-allowed'
                    }).text('SUBMITTING...');
                } else {
                    btn.prop('disabled', false).css({
                        'background-color': '#4f46e5',
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
                            let listErrors = '<ul style="margin: 0; padding-left: 20px;">';
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

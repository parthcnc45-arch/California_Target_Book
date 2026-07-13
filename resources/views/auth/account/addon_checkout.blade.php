@extends('layouts.portal')

@section('portal_styles')
<style>
    .addon-page-container {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        max-width: 800px;
        margin: 0 auto;
    }
    .addon-page-header {
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 24px;
        margin-bottom: 32px;
    }
    .addon-page-title {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 8px 0;
    }
    .addon-page-price {
        font-size: 20px;
        color: #16a34a;
        font-weight: 600;
        margin: 0;
    }
</style>
@endsection

@section('portal_content')
    <section id="section-addon-checkout" class="portal-section active">
        <header class="section-header">
            <div>
                <a href="{{ route('auth.account.manage_add_ons') }}" class="btn-link" style="display: inline-flex; align-items: center; gap: 8px; color: #64748b; font-weight: 500; margin-bottom: 16px; text-decoration: none;">
                    <i class="bi bi-arrow-left"></i> Back to Add-ons
                </a>
                <div class="header-title-container">
                    <h1 class="header-title">Checkout</h1>
                </div>
            </div>
        </header>

        <div class="addon-page-container">
            <div class="addon-page-header">
                <h2 class="addon-page-title">{{ $addonTitle }}</h2>
                <p class="addon-page-price" id="display-total-price">${{ number_format($addonPrice) }}</p>
            </div>

            <div class="quantity-selector-container" style="display: flex; align-items: center; gap: 16px; margin-bottom: 32px;">
                <span class="control-label" style="font-weight: 600; font-size: 15px; color: #1e293b;">Quantity</span>
                <div class="quantity-selector" style="display: flex; align-items: center; border: 1px solid #cbd5e1; border-radius: 8px; overflow: hidden; height: 44px; background: #ffffff;">
                    <button type="button" id="btn-qty-minus" style="width: 44px; height: 44px; border: none; background: #f8fafc; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #475569; font-weight: 600; outline: none; border-right: 1px solid #cbd5e1;">-</button>
                    <input type="number" id="addon-quantity" value="1" min="1" max="99" style="width: 60px; height: 44px; border: none; text-align: center; font-size: 16px; font-weight: 600; color: #0f172a; outline: none; -moz-appearance: textfield;">
                    <button type="button" id="btn-qty-plus" style="width: 44px; height: 44px; border: none; background: #f8fafc; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 18px; color: #475569; font-weight: 600; outline: none; border-left: 1px solid #cbd5e1;">+</button>
                </div>
            </div>

            <div style="margin-bottom: 32px;">
                <form id="checkout-form" class="row" style="margin: 0; padding-right: 8px; max-height: 500px; overflow-y: auto;">
                </form>
            </div>

            <!-- Stripe Card Inputs -->
            <div class="stripe-card-section" style="border-top: 1px solid #e2e8f0; padding-top: 32px;">
                <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin-bottom: 24px;"><i class="bi bi-credit-card" style="margin-right: 8px; color: var(--primary-color);"></i>Payment Details</h3>
                
                <div id="stripe-error-message" class="alert alert-danger" style="display: none; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; background-color: #fef2f2; border: 1px solid #fca5a5; color: #991b1b;"></div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label class="form-label-custom-gray" style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #475569;">Name on Card</label>
                    <input type="text" id="stripe-card-name" class="form-input form-input-custom" value="{{ $sub['base_account']->first_name }} {{ $sub['base_account']->last_name }}" placeholder="Cardholder Name" style="width: 100%; height: 44px; box-sizing: border-box; padding: 8px 16px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 15px; outline: none;">
                </div>

                <div class="form-group" style="margin-bottom: 32px;">
                    <label class="form-label-custom-gray" style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; color: #475569;">Card Details</label>
                    <div id="stripe-card-element" style="padding: 14px 16px; border: 1px solid #cbd5e1; border-radius: 8px; background-color: #ffffff; min-height: 48px; box-sizing: border-box;"></div>
                </div>

                <div style="display: flex; justify-content: flex-end;">
                    <button type="button" class="btn-modal-primary" id="btn-submit-payment" style="background: var(--primary-color); color: #ffffff; border: none; padding: 12px 32px; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; transition: opacity 0.2s;">
                        Pay ${{ number_format($addonPrice) }}
                    </button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('portal_scripts')
<script>
    $(document).ready(function() {
        const $qtyInput = $('#addon-quantity');
        const $submitBtn = $('#btn-submit-payment');
        const $errorMessage = $('#stripe-error-message');
        const $displayTotalPrice = $('#display-total-price');
        
        let activeVueInstances = [];
        let stripe, cardElement;
        const basePrice = {{ $addonPrice }};
        const addonName = '{{ $addonTitle }}';

        function initStripe() {
            try {
                const stripeKey = '{{ config('app.STRIPE_PUB_KEY') ?: 'pk_test_TYooMQauvdEDq54NiTphI7jx' }}';
                stripe = Stripe(stripeKey);
                const elements = stripe.elements();
                
                cardElement = elements.create('card', {
                    style: {
                        base: {
                            fontSize: '15px',
                            color: '#0f172a',
                            fontFamily: 'Inter, system-ui, sans-serif',
                            '::placeholder': {
                                color: '#94a3b8',
                            },
                        },
                        invalid: {
                            color: '#df1b41',
                        },
                    }
                });
                cardElement.mount('#stripe-card-element');
            } catch (e) {
                console.error("Stripe initialization error:", e);
                $('#stripe-card-element').html('<div style="color:#df1b41; font-size: 14px; padding: 16px;">Could not initialize payment options. Please check your Stripe settings.</div>');
            }
        }

        function updateSubmitButtonText() {
            let qty = parseInt($qtyInput.val()) || 1;
            let total = basePrice * qty;
            $submitBtn.text('Pay $' + total.toLocaleString());
            $displayTotalPrice.text('$' + total.toLocaleString());
        }

        function renderAddresses(qty) {
            // Destroy existing instances first to prevent memory leak
            activeVueInstances.forEach(instance => instance.$destroy());
            activeVueInstances = [];

            const $form = $('#checkout-form');
            $form.empty();

            const AddressBlockClass = Vue.extend(Vue.component('ctb-address-block'));

            for (let i = 0; i < qty; i++) {
                const itemTitle = qty > 1 ? `Shipping Address ${i + 1}` : 'Shipping Address';
                
                const itemDiv = $(`
                    <div class="shipping-address-item" style="width: 100%; margin-bottom: 24px; padding-bottom: 24px; ${i < qty - 1 ? 'border-bottom: 1px dashed #cbd5e1;' : ''}">
                        <h4 class="shipping-address-item-title" style="margin: 0 0 16px 0; font-size: 15px; font-weight: 700; color: #1e293b;">${itemTitle}</h4>
                    </div>
                `);
                
                const instance = new AddressBlockClass({
                    propsData: {
                        name: `shipping_address_${i}`,
                        input: { line1: '', line2: '', city: '', state: 'CA', zip_code: '', special_instructions: '' },
                        layout: 'checkout'
                    }
                });
                
                const targetDiv = $('<div class="shipping-address-instance"></div>');
                itemDiv.append(targetDiv);
                $form.append(itemDiv);
                instance.$mount(targetDiv[0]);
                activeVueInstances.push(instance);
            }
        }

        // Quantity selector plus/minus handlers
        $('#btn-qty-minus').on('click', function(e) {
            e.preventDefault();
            let val = parseInt($qtyInput.val()) || 1;
            if (val > 1) {
                $qtyInput.val(val - 1);
                renderAddresses(val - 1);
                updateSubmitButtonText();
            }
        });

        $('#btn-qty-plus').on('click', function(e) {
            e.preventDefault();
            let val = parseInt($qtyInput.val()) || 1;
            $qtyInput.val(val + 1);
            renderAddresses(val + 1);
            updateSubmitButtonText();
        });

        // Submit address and payment handler
        $submitBtn.on('click', async function(e) {
            e.preventDefault();
            const nameOnCard = $('#stripe-card-name').val().trim();
            if (!nameOnCard) {
                $errorMessage.text('Please enter the name on the card.').show();
                return;
            }

            $errorMessage.hide();
            
            const originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true).text('Processing Payment...');

            try {
                const { token, error } = await stripe.createToken(cardElement, {
                    name: nameOnCard
                });

                if (error) {
                    $errorMessage.text(error.message).show();
                    $submitBtn.prop('disabled', false).text(originalText);
                    return;
                }

                let addresses = [];
                let qty = parseInt($qtyInput.val()) || 1;
                
                // First validate all addresses
                for (let i = 0; i < qty; i++) {
                    const line1 = $(`input[name="shipping_address_${i}[line1]"]`).val()?.trim();
                    const city = $(`input[name="shipping_address_${i}[city]"]`).val()?.trim();
                    const state = $(`select[name="shipping_address_${i}[state]"]`).val();
                    const zip_code = $(`input[name="shipping_address_${i}[zip_code]"]`).val()?.trim();
                    
                    let missingFields = [];
                    if (!line1) missingFields.push('Address Line 1');
                    if (!city) missingFields.push('City');
                    if (!state) missingFields.push('State');
                    if (!zip_code) missingFields.push('ZIP Code');
                    
                    if (missingFields.length > 0) {
                        $errorMessage.text(`Please fill out the following fields for Shipping Address ${i + 1}: ${missingFields.join(', ')}.`).show();
                        $submitBtn.prop('disabled', false).text(originalText);
                        return;
                    }
                    
                    addresses.push({
                        line1: line1,
                        line2: $(`input[name="shipping_address_${i}[line2]"]`).val()?.trim() || null,
                        city: city,
                        state: state,
                        zip_code: zip_code,
                        special_instructions: $(`input[name="shipping_address_${i}[special_instructions]"]`).val()?.trim() || null
                    });
                }

                const payload = {
                    stripe_token: token.id,
                    qty: qty,
                    addon_price: basePrice,
                    addresses: addresses,
                    addon_name: addonName,
                    _token: '{{ csrf_token() }}'
                };

                // Perform AJAX request to process payment
                $.ajax({
                    url: '{{ route('auth.account.process_addon_checkout') }}',
                    method: 'POST',
                    data: payload,
                    success: function(response) {
                        if (response.success) {
                            $submitBtn.prop('disabled', true).text('Payment Successful');
                            window.location.href = '{{ route('auth.account.manage_add_ons') }}';
                        } else {
                            $errorMessage.text(response.message || 'An error occurred during payment.').show();
                            $submitBtn.prop('disabled', false).text(originalText);
                        }
                    },
                    error: function(xhr) {
                        let msg = 'An unexpected error occurred. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        $errorMessage.text(msg).show();
                        $submitBtn.prop('disabled', false).text(originalText);
                    }
                });

            } catch (err) {
                console.error(err);
                $errorMessage.text('An unexpected error occurred. Please try again.').show();
                $submitBtn.prop('disabled', false).text(originalText);
            }
        });

        // Initial setup
        initStripe();
        renderAddresses(1);
        updateSubmitButtonText();
    });
</script>
@endsection

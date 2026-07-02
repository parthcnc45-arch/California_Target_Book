@extends('layouts.portal')

@section('portal_content')
    <section id="section-manage-subscription" class="portal-section active">
        <header class="section-header" style="align-items: center; width: 100%; margin-bottom: 24px; display: flex;">
            <a href="/account/subscriptions" style="text-decoration: none; color: #0f172a; display: flex; align-items: center; font-size: 18px; font-weight: 700; gap: 8px;">
                <i class="bi bi-arrow-left"></i> Manage Subscription
            </a>
        </header>

        <form id="manage-billing-form">
            <!-- Card 1: Billing Cycle -->
            <div class="manage-card">
                <div class="manage-card-header">
                    <h2 class="manage-card-title">Billing Cycle</h2>
                </div>
                <div class="manage-card-body">
                    <div class="billing-cycle-option">
                        <div class="billing-cycle-radio">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                        <div class="billing-cycle-info">
                            <h3 class="billing-cycle-title">
                                {{ !empty($sub['stripe_product_name']) ? $sub['stripe_product_name'] : 'Online Subscription' }}
                            </h3>
                            <span class="billing-cycle-subtext">
                                @if(!empty($sub['end']))
                                    Your subscription will renew on {{ $sub['end'] }}.
                                @else
                                    Renewal date is not available.
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Update Payment Method -->
            <div class="manage-card">
                <div class="manage-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                    <h2 class="manage-card-title">Payment Method</h2>
                    @if(isset($card) && !empty($card['last4']))
                        <button type="button" id="btn-toggle-update" class="btn-save-changes" style="background-color: #f1f5f9; color: #334155 !important; border: 1px solid #cbd5e1; padding: 6px 12px; font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="bi bi-pencil-square"></i> Change Card
                        </button>
                    @endif
                </div>
                <div class="manage-card-body">
                    <div id="stripe-error-message" class="alert alert-danger" style="display: none; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13.5px; background-color: #fef2f2; border: 1px solid #fca5a5; color: #991b1b;"></div>
                    <div id="stripe-success-message" class="alert alert-success" style="display: none; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 13.5px; background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534;"></div>

                    @if(isset($card) && !empty($card['last4']))
                        <!-- Existing Card representation -->
                        <div id="existing-card-container" class="existing-card-box" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); border-radius: 12px; padding: 24px; color: #ffffff; position: relative; box-shadow: 0 4px 12px rgba(0,0,0,0.1); max-width: 400px; margin-bottom: 12px;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 32px;">
                                <div>
                                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; font-weight: 600; margin-bottom: 4px;">Active Card</div>
                                    <div style="font-size: 18px; font-weight: 700; letter-spacing: 0.5px;">{{ $card['brand'] ?? 'Credit Card' }}</div>
                                </div>
                                <div style="font-size: 28px; color: #cbd5e1; line-height: 1;">
                                    @if(strtolower($card['brand'] ?? '') === 'visa')
                                        <i class="bi bi-credit-card-2-front"></i>
                                    @else
                                        <i class="bi bi-credit-card"></i>
                                    @endif
                                </div>
                            </div>
                            <div style="font-size: 18px; font-family: monospace; letter-spacing: 2px; margin-bottom: 24px; color: #f8fafc;">
                                •••• •••• •••• {{ $card['last4'] }}
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                                <div>
                                    <div style="font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 2px;">Cardholder</div>
                                    <div style="font-size: 13px; font-weight: 500; color: #f1f5f9;">{{ $card['name'] ?? ($user->first_name . ' ' . $user->last_name) }}</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 9px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 2px;">Expires</div>
                                    <div style="font-size: 13px; font-weight: 500; color: #f1f5f9;">{{ str_pad($card['exp_month'], 2, '0', STR_PAD_LEFT) }}/{{ substr($card['exp_year'], -2) }}</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Card Form for updating (hidden if card exists until toggle clicked) -->
                    <div id="card-update-form" style="{{ isset($card) && !empty($card['last4']) ? 'display: none;' : '' }}">
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label class="form-label" for="card-name-input">Name on Card</label>
                            <input type="text" id="card-name-input" class="form-input" value="{{ isset($card) && !empty($card['name']) ? $card['name'] : ($user->first_name . ' ' . $user->last_name) }}" placeholder="Cardholder Name">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Card Details</label>
                            <div id="stripe-card-element" style="padding: 12px; border: 1px solid #cbd5e1; border-radius: 6px; background-color: #ffffff; box-sizing: border-box; min-height: 40px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div style="display: flex; gap: 12px; margin-top: 8px;">
                <button type="submit" class="btn-save-changes">
                    Save Changes
                </button>
                <a href="/account/subscriptions" class="btn-cancel-action">
                    Cancel
                </a>
            </div>
        </form>
    </section>
@endsection

@section('portal_scripts')
<script>
    $(document).ready(function() {
        let stripe, cardElement;
        const hasCard = {{ (isset($card) && !empty($card['last4'])) ? 'true' : 'false' }};
        
        // Toggle Card Update Form
        $('#btn-toggle-update').on('click', function(e) {
            e.preventDefault();
            const $btn = $(this);
            const isEditing = $('#card-update-form').is(':visible');
            
            if (isEditing) {
                $('#card-update-form').slideUp();
                $('#existing-card-container').slideDown();
                $btn.html('<i class="bi bi-pencil-square"></i> Change Card');
                $('#stripe-error-message').hide();
            } else {
                $('#existing-card-container').slideUp();
                $('#card-update-form').slideDown(function() {
                    initStripe();
                });
                $btn.html('<i class="bi bi-x-circle"></i> Cancel');
            }
        });

        function initStripe() {
            if (cardElement) return; // already initialized

            try {
                const stripeKey = '{{ config('app.STRIPE_PUB_KEY') ?: 'pk_test_TYooMQauvdEDq54NiTphI7jx' }}';
                stripe = Stripe(stripeKey);
                const elements = stripe.elements();
                
                cardElement = elements.create('card', {
                    style: {
                        base: {
                            fontSize: '13.5px',
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
                $('#stripe-card-element').html('<div style="color:#df1b41; font-size: 13px; padding: 12px;">Could not initialize payment options. Please check your Stripe settings.</div>');
            }
        }

        if (!hasCard) {
            initStripe();
        }

        // Submit Billing details
        $('#manage-billing-form').on('submit', async function(e) {
            e.preventDefault();
            
            // If has card and form is not visible, it means they didn't change card
            if (hasCard && !$('#card-update-form').is(':visible')) {
                window.location.href = '/account/subscriptions';
                return;
            }

            const nameOnCard = $('#card-name-input').val().trim();
            if (!nameOnCard) {
                $('#stripe-error-message').text('Please enter the name on the card.').show();
                return;
            }

            $('#stripe-error-message').hide();
            $('#stripe-success-message').hide();

            const $btn = $('.btn-save-changes');
            const originalText = $btn.text();
            $btn.prop('disabled', true).text('Updating Card...');

            try {
                const { token, error } = await stripe.createToken(cardElement, {
                    name: nameOnCard
                });

                if (error) {
                    $('#stripe-error-message').text(error.message).show();
                    $btn.prop('disabled', false).text(originalText);
                    return;
                }

                // Send via AJAX to the backend
                $.ajax({
                    url: "{{ route('auth.account.update_billing') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    contentType: 'application/json',
                    data: JSON.stringify({
                        stripe_token: token.id
                    }),
                    success: function(res) {
                        if (res.success) {
                            $('#stripe-success-message').text(res.message || 'Billing details updated successfully.').show();
                            setTimeout(function() {
                                window.location.reload();
                            }, 1500);
                        } else {
                            $('#stripe-error-message').text(res.message || 'Failed to update billing details.').show();
                            $btn.prop('disabled', false).text(originalText);
                        }
                    },
                    error: function(err) {
                        let msg = 'An error occurred. Please try again.';
                        if (err.responseJSON && err.responseJSON.message) {
                            msg = err.responseJSON.message;
                        }
                        $('#stripe-error-message').text(msg).show();
                        $btn.prop('disabled', false).text(originalText);
                    }
                });

            } catch (err) {
                console.error(err);
                $('#stripe-error-message').text('An unexpected error occurred. Please try again.').show();
                $btn.prop('disabled', false).text(originalText);
            }
        });
    });
</script>
@endsection

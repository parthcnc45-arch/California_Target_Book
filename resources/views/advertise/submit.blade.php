<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit a Classified Ad | California Target Book</title>
  <meta name="description" content="Submit your classified advertisement listing for review and publication on the California Target Book.">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

  <!-- Bootstrap 5 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">

  <!-- Site styles -->
  <link rel="stylesheet" href="/css/style_new.css">
  
  <!-- Custom Advertise styles -->
  <link rel="stylesheet" href="/css/advertise.css">

  <style>
    /* Styling adjustments for review and payment summaries */
    .summary-group {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: 8px;
      padding: 24px;
      margin-bottom: 25px;
    }
    .summary-title {
      font-family: var(--font-heading);
      font-size: 1.1rem;
      font-weight: 700;
      color: #1a365d;
      border-bottom: 1px solid #edf2f7;
      padding-bottom: 10px;
      margin-bottom: 16px;
    }
    .summary-row {
      display: flex;
      margin-bottom: 12px;
      font-size: 0.9rem;
    }
    .summary-row:last-child {
      margin-bottom: 0;
    }
    .summary-label {
      width: 180px;
      font-weight: 600;
      color: #4a5568;
      flex-shrink: 0;
    }
    .summary-value {
      color: #2d3748;
      line-height: 1.5;
    }
    .payment-option-card {
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 16px;
      cursor: pointer;
      transition: all 0.2s;
    }
    .payment-option-card:hover {
      border-color: #3182ce;
      background-color: #f7fafc;
    }
    .payment-option-card.active {
      border-color: #3182ce;
      background-color: #ebf8ff;
    }
  </style>
</head>

<body style="background-color: #f7fafc;">

  @include('layouts.navbar')

  <!-- Hero Header Banner -->
  <div style="background: linear-gradient(180deg, rgba(16, 28, 51, 0.96) 0%, var(--navy-900) 100%); padding: 80px 24px 50px; text-align: center; color: #ffffff; border-bottom: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 40px;">
    <div class="container-ctb">
        <h1 style="font-family: var(--font-heading); font-size: 38px; font-weight: 700; color: #ffffff; margin-bottom: 14px;">Submit a Classified Ad</h1>
        <p style="font-size: 15.5px; max-width: 750px; margin: 0 auto; color: rgba(255, 255, 255, 0.85); line-height: 1.6; font-weight: 400; font-family: var(--font-body);">
            Complete the form below. After submission your ad will be reviewed within 1 business day, then you'll be directed to complete payment.
        </p>
    </div>
  </div>

  <div class="container-ctb py-2" style="max-width: 800px; margin: 0 auto;">

    <!-- Progress steps bar -->
    <div class="submit-progress-container">
      <div class="submit-progress-line"></div>
      
      <div class="submit-progress-step active" id="step-indicator-1">
        <div class="submit-progress-circle">1</div>
        <span>Ad Details</span>
      </div>
      
      <div class="submit-progress-step" id="step-indicator-2">
        <div class="submit-progress-circle">2</div>
        <span>Review</span>
      </div>
      
      <div class="submit-progress-step" id="step-indicator-3">
        <div class="submit-progress-circle">3</div>
        <span>Payment</span>
      </div>
      
      <div class="submit-progress-step" id="step-indicator-4">
        <div class="submit-progress-circle">4</div>
        <span>Live</span>
      </div>
    </div>

    <!-- Alert / Pricing Banner -->
    <div class="submit-info-banner" id="pricing-banner-top">
      <div class="banner-left">
        <h4>Classified Ad — California Target Book</h4>
        <p>Publicly accessible page + daily email report</p>
      </div>
      <div class="banner-right">
        <h3>$165 <span style="font-size: 0.9rem; font-weight: 500;">/ week</span></h3>
        <p>or $585/month • Payment via secure checkout</p>
      </div>
    </div>

    <!-- Form Area -->
    <form action="#" method="POST" id="submitAdForm" novalidate>
      
      <!-- STEP 1: FORM FIELDS -->
      <div id="step-1-fields" class="row g-4">
        
        <!-- Contact Info Section -->
        <div class="col-12">
          <h3 class="submit-form-section-header" style="margin-top: 10px;">Contact Information</h3>
        </div>
        
        <div class="col-md-6">
          <label for="first_name" class="submit-form-label">First Name<span class="required">*</span></label>
          <input type="text" class="submit-form-input" id="first_name" name="first_name" required placeholder="Jane">
        </div>
        
        <div class="col-md-6">
          <label for="last_name" class="submit-form-label">Last Name<span class="required">*</span></label>
          <input type="text" class="submit-form-input" id="last_name" name="last_name" required placeholder="Smith">
        </div>
        
        <div class="col-md-6">
          <label for="email" class="submit-form-label">Email Address<span class="required">*</span></label>
          <input type="email" class="submit-form-input" id="email" name="email" required placeholder="jane@organization.com">
        </div>
        
        <div class="col-md-6">
          <label for="phone" class="submit-form-label">Phone Number</label>
          <input type="tel" class="submit-form-input" id="phone" name="phone" placeholder="(916) 555-0100">
        </div>
        
        <div class="col-12">
          <label for="organization" class="submit-form-label">Organization / Company Name<span class="required">*</span></label>
          <input type="text" class="submit-form-input" id="organization" name="organization" required placeholder="Department of Finance" maxlength="60">
        </div>

        <!-- Ad Details Section -->
        <div class="col-12">
          <h3 class="submit-form-section-header">Ad Details</h3>
        </div>
        
        <div class="col-md-6">
          <label for="category" class="submit-form-label">Ad Category<span class="required">*</span></label>
          <select class="submit-form-select" id="category" name="category" required>
            <option value="" disabled selected>Select a category...</option>
            @if(isset($categories) && count($categories) > 0)
              @foreach($categories as $cat)
                <option value="{{ strtolower($cat->name) }}">{{ $cat->name }}</option>
              @endforeach
            @else
              <option value="jobs">Jobs / Help Wanted</option>
              <option value="office">Office Space</option>
              <option value="services">Campaign Services</option>
              <option value="notices">Public Notices</option>
              <option value="other">Other Listings</option>
            @endif
          </select>
        </div>
        
        <div class="col-md-6">
          <label for="duration" class="submit-form-label">Ad Duration<span class="required">*</span></label>
          <select class="submit-form-select" id="duration" name="duration" required>
            <option value="" disabled selected>Select duration...</option>
            @if(isset($rates) && count($rates) > 0)
              @foreach($rates as $rate)
                @php
                  $rateTitle = $rate->title ?? $rate->name;
                  $rateAmt = $rate->rate_amount ? round($rate->rate_amount) : '';
                  $rateDays = $rate->days ?? '';
                  $details = '';
                  if ($rateAmt && $rateDays) {
                      $details = " (\${$rateAmt} / {$rateDays} Days)";
                  } elseif ($rateAmt) {
                      $details = " (\${$rateAmt})";
                  }
                @endphp
                <option value="{{ $rate->id }}" data-days="{{ $rateDays }}" data-amount="{{ $rateAmt }}">{{ $rateTitle }}{{ $details }}</option>
              @endforeach
            @else
              <option value="1_week">1 Week ($165)</option>
              <option value="2_weeks">2 Weeks ($330)</option>
              <option value="3_weeks">3 Weeks ($495)</option>
              <option value="1_month">1 Month ($585)</option>
            @endif
          </select>
        </div>
        
        <div class="col-12">
          <label for="headline" class="submit-form-label">Ad Headline / Job Title<span class="required">*</span></label>
          <input type="text" class="submit-form-input" id="headline" name="headline" required placeholder="e.g. Senior Policy Analyst, CEA Level A" maxlength="80">
          <div class="submit-form-subtext">This will appear as the bold title of your ad. (Max 80 characters)</div>
        </div>
        
        <div class="col-12">
          <label for="body" class="submit-form-label">Ad Body Text<span class="required">*</span></label>
          <textarea class="submit-form-textarea" id="body" name="body" rows="6" required placeholder="Describe the position, salary range, qualifications, and how to apply. Maximum 100 words."></textarea>
          <div class="submit-form-charcounter" id="char-counter">0 / 100 words</div>
        </div>
        
        <div class="col-12">
          <label for="link_url" class="submit-form-label">Link URL <span style="font-weight: normal; color: #a0aec0;">(optional)</span></label>
          <input type="url" class="submit-form-input" id="link_url" name="link_url" placeholder="https://calcareers.ca.gov/...">
          <div class="submit-form-subtext">A "Details &rarr;" link will appear at the end of your ad.</div>
        </div>

        <!-- Schedule Section -->
        <div class="col-12">
          <h3 class="submit-form-section-header">Schedule</h3>
        </div>
        
        <div class="col-md-6">
          <label for="start_date" class="submit-form-label">Desired Start Date<span class="required">*</span></label>
          <input type="date" class="submit-form-input" id="start_date" name="start_date" required>
        </div>
        
        <div class="col-md-6">
          <label for="expire_date" class="submit-form-label">Expiration Date<span class="required">*</span></label>
          <input type="date" class="submit-form-input" id="expire_date" name="expire_date" required readonly style="background-color: #edf2f7; cursor: not-allowed;">
          <div class="submit-form-subtext">Auto-calculated from duration.</div>
        </div>

        <!-- Terms Section -->
        <div class="col-12">
          <h3 class="submit-form-section-header">Terms</h3>
        </div>
        
        <div class="col-12 d-flex align-items-start">
          <input type="checkbox" id="terms" name="terms" required class="mt-1 me-2">
          <label for="terms" class="submit-form-label" style="font-weight: normal;">I agree to the <a href="#" style="color: #3182ce; text-decoration: none;">Terms &amp; Conditions</a> for classified advertising on California Target Book.</label>
        </div>

        <!-- Actions Row -->
        <div class="col-12">
          <div class="submit-actions-row">
            <a href="/advertise" class="btn-submit-back">&larr; Back</a>
            <button type="submit" class="btn-submit-continue">Continue to Review &rarr;</button>
          </div>
          <p class="submit-bottom-note">Your ad will be reviewed within 1 business day. After approval you will be directed to complete payment through our secure checkout.</p>
        </div>

      </div>

      <!-- STEP 2: REVIEW SUMMARY -->
      <div id="step-2-review" class="row g-4" style="display: none;">
        <div class="col-12">
          <h3 class="submit-form-section-header" style="margin-top: 10px;">Review Your Ad</h3>
        </div>
        
        <div class="col-12">
          <!-- Live Preview Box -->
          <div class="summary-group">
            <div class="summary-title">Ad Preview</div>
            <div style="background-color: #f8fafc; padding: 25px; border-radius: 8px; border: 1px dashed #cbd5e0;">
              <div class="mock-classified" style="margin: 0 auto; max-width: 100%; border-left-width: 4px;">
                <span class="tag" id="preview-category-badge">Category</span>
                <div class="org" id="preview-org">—</div>
                <div class="title" id="preview-title" style="font-size: 1.1rem; margin-top: 4px;">—</div>
                <div class="desc" id="preview-body" style="font-size: 0.9rem; margin-top: 8px; line-height: 1.6;">—</div>
                <div style="margin-top: 15px; font-size: 0.8rem; color: #a0aec0; border-top: 1px solid #edf2f7; padding-top: 10px; display: flex; justify-content: space-between;">
                  <span id="preview-expires">—</span>
                  <a href="#" id="preview-link" target="_blank" style="color: #3182ce; text-decoration: none; font-weight: 600; display: none;">Details &rarr;</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Details Summary -->
          <div class="summary-group">
            <div class="summary-title">Contact &amp; Schedule Summary</div>
            <div class="summary-row">
              <div class="summary-label">Name:</div>
              <div class="summary-value" id="summary-name">—</div>
            </div>
            <div class="summary-row">
              <div class="summary-label">Email:</div>
              <div class="summary-value" id="summary-email">—</div>
            </div>
            <div class="summary-row">
              <div class="summary-label">Phone:</div>
              <div class="summary-value" id="summary-phone">—</div>
            </div>
            <div class="summary-row">
              <div class="summary-label">Ad Duration:</div>
              <div class="summary-value" id="summary-duration">—</div>
            </div>
            <div class="summary-row">
              <div class="summary-label">Start Date:</div>
              <div class="summary-value" id="summary-start">—</div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="submit-actions-row">
            <button type="button" class="btn-submit-back" id="btn-back-to-edit">&larr; Back to Edit</button>
            <button type="button" class="btn-submit-continue" id="btn-proceed-to-payment">Proceed to Payment &rarr;</button>
          </div>
        </div>
      </div>

      <!-- STEP 3: MOCK SECURE PAYMENT -->
      <div id="step-3-payment" class="row g-4" style="display: none;">
        <div class="col-12">
          <h3 class="submit-form-section-header" style="margin-top: 10px;">Secure Payment</h3>
        </div>
        
        <div class="col-lg-7">
          <div class="summary-group">
            <div class="summary-title">Payment Method</div>
            
            <div class="row g-3">
              <div class="col-12">
                <div class="payment-option-card active d-flex align-items-center justify-content-between">
                  <div class="d-flex align-items-center">
                    <input type="radio" checked name="payment_method" class="me-3">
                    <strong>Credit or Debit Card</strong>
                  </div>
                  <div>💳</div>
                </div>
              </div>

              <div class="col-12">
                <label class="submit-form-label">Cardholder Name</label>
                <input type="text" class="submit-form-input" placeholder="Jane Smith">
              </div>

              <div class="col-12">
                <label class="submit-form-label">Card Details</label>
                <div id="card-element" class="submit-form-input" style="padding: 12px; height: auto;">
                  <!-- A Stripe Element will be inserted here. -->
                </div>
                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert" style="color: #e3342f; font-size: 13px; margin-top: 8px;"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Order Summary side column -->
        <div class="col-lg-5">
          <div class="summary-group">
            <div class="summary-title">Order Summary</div>
            <div class="d-flex justify-content-between mb-3" style="font-size: 0.95rem;">
              <span>Classified Ad Placement</span>
              <strong id="summary-order-price">$165.00</strong>
            </div>
            <div class="d-flex justify-content-between mb-3" style="font-size: 0.95rem;">
              <span>Tax / Fees</span>
              <span>$0.00</span>
            </div>
            <hr>
            <div class="d-flex justify-content-between font-weight-bold" style="font-size: 1.15rem; color: #1a365d;">
              <span>Total Amount</span>
              <strong id="summary-order-total">$165.00</strong>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="submit-actions-row">
            <button type="button" class="btn-submit-back" id="btn-back-to-review">&larr; Back to Review</button>
            <button type="button" class="btn-submit-continue" id="btn-pay-now">Pay &amp; Submit Ad</button>
          </div>
        </div>
      </div>

      <!-- STEP 4: LIVE CONFIRMATION -->
      <div id="step-4-live" class="row g-4 style-summary" style="display: none; text-align: center;">
        <div class="col-12 py-5">
          <div style="font-size: 4rem; color: #48bb78; margin-bottom: 20px;">✓</div>
          <h2 style="font-family: var(--font-heading); font-weight: 700; color: #1a365d; margin-bottom: 12px;">Thank You for Your Order!</h2>
          <p style="color: #718096; max-width: 600px; margin: 0 auto 30px auto; line-height: 1.6;">
            Your classified advertisement has been successfully submitted and paid. Our editorial team will review the content within 1 business day, and notify you as soon as the ad goes live.
          </p>
          <a href="/classifieds" class="btn-submit-continue" style="display: inline-block;">Return to Classifieds</a>
        </div>
      </div>

    </form>
  </div>

  @include('layouts.footer')

  <!-- Stripe JS -->
  <script src="https://js.stripe.com/v3/"></script>
  
  <script src="/js/script.js"></script>
  <!-- jQuery Library -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- jQuery Validation Plugin -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
  
  <!-- Counter, Expiry, Validation & Multi-step Logic -->
  <script>
    $(document).ready(function() {
      
      // Custom word limit validation method
      $.validator.addMethod("maxWords", function(value, element, maxwords) {
        const text = value.trim();
        const words = text ? text.split(/\s+/).length : 0;
        return this.optional(element) || words <= maxwords;
      }, "Your ad body text exceeds the maximum {0} words limit.");

      // JQuery Form Validation setup
      const validator = $("#submitAdForm").validate({
        onfocusout: function(element) {
          this.element(element);
        },
        onkeyup: function(element) {
          this.element(element);
        },
        rules: {
          first_name: {
            required: true,
            minlength: 2
          },
          last_name: {
            required: true,
            minlength: 2
          },
          email: {
            required: true,
            email: true
          },
          organization: {
            required: true,
            maxlength: 60
          },
          category: "required",
          duration: "required",
          headline: {
            required: true,
            minlength: 5,
            maxlength: 80
          },
          body: {
            required: true,
            maxWords: 100
          },
          link_url: {
            url: true
          },
          start_date: "required",
          expire_date: "required",
          terms: "required"
        },
        messages: {
          first_name: "Please enter your first name.",
          last_name: "Please enter your last name.",
          email: "Please enter a valid email address.",
          organization: {
            required: "Please enter your organization or company name.",
            maxlength: "Organization name cannot exceed 60 characters."
          },
          category: "Please select an ad category.",
          duration: "Please select your desired ad run duration.",
          headline: {
            required: "Please enter a headline or job title.",
            minlength: "Headline must be at least 5 characters.",
            maxlength: "Headline cannot exceed 80 characters."
          },
          body: {
            required: "Please write your advertisement body text.",
            maxWords: "Your ad body text exceeds the maximum 100 words limit."
          },
          link_url: "Please enter a valid URL (including http:// or https://).",
          start_date: "Please select a start date.",
          expire_date: "Please select an expiration date.",
          terms: "You must agree to the terms and conditions."
        },
        submitHandler: function(form, event) {
          // Instead of standard POST, transition to Step 2 Review
          event.preventDefault();
          switchToStep2Review();
        }
      });

      // Switches indicators and forms to Step 2 (Review)
      function switchToStep2Review() {
        // Populate step 2 data
        $('#preview-category-badge').text($('#category option:selected').text());
        $('#preview-org').text($('#organization').val());
        $('#preview-title').text($('#headline').val());
        $('#preview-body').text($('#body').val());
        
        const expireDateVal = $('#expire_date').val();
        if (expireDateVal) {
          const date = new Date(expireDateVal + 'T00:00:00');
          $('#preview-expires').text(`Expires ${date.getMonth() + 1}/${date.getDate()}`);
        } else {
          $('#preview-expires').text('');
        }

        const linkUrl = $('#link_url').val();
        if (linkUrl) {
          $('#preview-link').attr('href', linkUrl).show();
        } else {
          $('#preview-link').hide();
        }

        // Contact info summary
        $('#summary-name').text($('#first_name').val() + ' ' + $('#last_name').val());
        $('#summary-email').text($('#email').val());
        $('#summary-phone').text($('#phone').val() || 'N/A');
        
        const durationText = $('#duration option:selected').text();
        $('#summary-duration').text(durationText);
        
        const startDateVal = $('#start_date').val();
        if (startDateVal) {
          const date = new Date(startDateVal + 'T00:00:00');
          $('#summary-start').text(`${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear()}`);
        }

        // Pricing values
        const selectedOpt = $('#duration option:selected');
        const amount = selectedOpt.attr('data-amount');
        let price = amount ? `$${parseFloat(amount).toFixed(2)}` : "$0.00";
        
        $('#summary-order-price, #summary-order-total').text(price);

        // Hide Step 1, show Step 2
        $('#step-1-fields, #pricing-banner-top').hide();
        $('#step-2-review').show();

        // Update indicators
        $('.submit-progress-step').removeClass('active');
        $('#step-indicator-2').addClass('active');
        
        // Scroll to top of form section
        $('html, body').animate({ scrollTop: $('#submitAdForm').offset().top - 120 }, 200);
      }

      // Step 2 actions
      $('#btn-back-to-edit').on('click', function() {
        $('#step-2-review').hide();
        $('#step-1-fields, #pricing-banner-top').show();
        $('.submit-progress-step').removeClass('active');
        $('#step-indicator-1').addClass('active');
        $('html, body').animate({ scrollTop: $('#submitAdForm').offset().top - 120 }, 200);
      });

      $('#btn-proceed-to-payment').on('click', function() {
        $('#step-2-review').hide();
        $('#step-3-payment').show();
        $('.submit-progress-step').removeClass('active');
        $('#step-indicator-3').addClass('active');
        $('html, body').animate({ scrollTop: $('#submitAdForm').offset().top - 120 }, 200);
      });

      // Step 3 actions
      $('#btn-back-to-review').on('click', function() {
        $('#step-3-payment').hide();
        $('#step-2-review').show();
        $('.submit-progress-step').removeClass('active');
        $('#step-indicator-2').addClass('active');
        $('html, body').animate({ scrollTop: $('#submitAdForm').offset().top - 120 }, 200);
      });

      // Set up Stripe Elements
      let stripe, elements, card;
      try {
        stripe = Stripe("{{ config('app.STRIPE_PUB_KEY') ?: 'pk_test_TYooMQauvdEDq54NiTphI7jx' }}");
        elements = stripe.elements();
        
        const style = {
          base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
              color: '#aab7c4'
            }
          },
          invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
          }
        };

        card = elements.create('card', {style: style, hidePostalCode: true});
        card.mount('#card-element');
        
        card.on('change', function(event) {
          var displayError = document.getElementById('card-errors');
          if (event.error) {
            displayError.textContent = event.error.message;
          } else {
            displayError.textContent = '';
          }
        });
      } catch (e) {
        console.error("Stripe could not be initialized:", e);
      }

      $('#btn-pay-now').on('click', function() {
        const $btn = $(this);
        $btn.prop('disabled', true).text('Processing...');
        
        stripe.createToken(card).then(function(result) {
          if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            $btn.prop('disabled', false).text('Pay & Submit Ad');
          } else {
            // Token is generated successfully
            const formData = {
                category: $('#category').val(),
                duration: $('#duration').val(),
                headline: $('#headline').val(),
                body: $('#body').val(),
                link_url: $('#link_url').val(),
                start_date: $('#start_date').val(),
                expire_date: $('#expire_date').val(),
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                advertiser_email: $('#email').val(),
                phone_number: $('#phone').val(),
                company: $('#organization').val(),
                stripe_token: result.token.id,
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '/classifieds/submit',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#step-3-payment').hide();
                        $('#step-4-live').show();
                        $('.submit-progress-step').removeClass('active');
                        $('#step-indicator-4').addClass('active');
                        $('html, body').animate({ scrollTop: $('#submitAdForm').offset().top - 120 }, 200);
                    } else {
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = response.message || 'An error occurred during submission.';
                        $btn.prop('disabled', false).text('Pay & Submit Ad');
                    }
                },
                error: function(xhr) {
                    var errorElement = document.getElementById('card-errors');
                    var msg = 'An error occurred during submission.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }
                    errorElement.textContent = msg;
                    $btn.prop('disabled', false).text('Pay & Submit Ad');
                }
            });
          }
        });
      });

      // Word counter
      $('#body').on('input', function() {
        const text = $(this).val().trim();
        const words = text ? text.split(/\s+/).length : 0;
        $('#char-counter').text(`${words} / 100 words`);
        if (words > 100) {
          $('#char-counter').css('color', '#d32f2f');
        } else {
          $('#char-counter').css('color', '#a0aec0');
        }
      });

      // Auto-calculating expiration date based on start date and dynamic duration select
      function calculateExpiration() {
        const startDateVal = $('#start_date').val();
        const selectedOpt = $('#duration option:selected');
        
        if (!startDateVal || !selectedOpt.length) return;

        let days = parseInt(selectedOpt.attr('data-days'));
        if (isNaN(days) || days <= 0) {
            const durationVal = selectedOpt.val();
            const textVal = selectedOpt.text().toLowerCase();
            
            if (durationVal === '1_week' || textVal.includes('1 week') || textVal.includes('7 day')) days = 7;
            else if (durationVal === '2_weeks' || textVal.includes('2 week') || textVal.includes('14 day')) days = 14;
            else if (durationVal === '3_weeks' || textVal.includes('3 week') || textVal.includes('21 day')) days = 21;
            else if (durationVal === '1_month' || textVal.includes('1 month') || textVal.includes('30 day')) days = 30;
            else {
                const match = textVal.match(/(\d+)\s*day/);
                if (match) days = parseInt(match[1]);
            }
        }

        if (days > 0) {
          let start;
          if (startDateVal.includes('-')) {
              const parts = startDateVal.split('-');
              if (parts[0].length === 4) {
                  start = new Date(parts[0], parts[1] - 1, parts[2]);
              } else {
                  start = new Date(startDateVal);
              }
          } else if (startDateVal.includes('/')) {
              const parts = startDateVal.split('/');
              if (parts[2].length === 4) { // MM/DD/YYYY
                  start = new Date(parts[2], parts[0] - 1, parts[1]);
              } else {
                  start = new Date(startDateVal);
              }
          } else {
              start = new Date(startDateVal);
          }

          if (start && !isNaN(start.getTime())) {
              start.setDate(start.getDate() + (days - 1));
              
              const yyyy = start.getFullYear();
              const mm = String(start.getMonth() + 1).padStart(2, '0');
              const dd = String(start.getDate()).padStart(2, '0');
              
              $('#expire_date').val(`${yyyy}-${mm}-${dd}`);
              $("#submitAdForm").validate().element("#expire_date");
          }
        }
      }

      $('#start_date, #duration').on('change input', calculateExpiration);
    });
  </script>
</body>

</html>

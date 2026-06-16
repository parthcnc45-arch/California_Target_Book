@extends('layouts.portal')
@section('portal_content')
    <section id="section-help-support" class="portal-section active">
        <header class="section-header">
            <div class="header-avatar bg-pink-avatar">
                <i class="bi bi-question-circle icon-flex-18"></i>
            </div>
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Help & Support</h1>
                </div>
                <p class="header-subtitle">Find answers or reach out to our team.</p>
            </div>
        </header>

        <div class="flex-column-gap-24">
            <div class="portal-card portal-mt-0">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Frequently Asked Questions</h2>
                </div>
                <div class="card-body-custom settings-card-body">
                    <div class="faq-list">
                        <div class="faq-item active">
                            <button type="button" class="faq-trigger">
                                <span>How do I upgrade my subscription?</span>
                                <i class="bi bi-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-content" style="max-height: none;">
                                <div class="faq-answer">
                                    Navigate to Subscription → Upgrade Plan to compare tiers and switch.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button type="button" class="faq-trigger">
                                <span>Can I add more users to my account?</span>
                                <i class="bi bi-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-content">
                                <div class="faq-answer">
                                    Yes! Go to Subscription → Add Seats to purchase additional team member access.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button type="button" class="faq-trigger">
                                <span>How do I cancel my subscription?</span>
                                <i class="bi bi-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-content">
                                <div class="faq-answer">
                                    On the Subscription page, click 'Cancel Subscription'. Your access continues until the current period ends.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button type="button" class="faq-trigger">
                                <span>What payment methods do you accept?</span>
                                <i class="bi bi-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-content">
                                <div class="faq-answer">
                                    We accept all major credit cards (Visa, Mastercard, Amex) and can arrange invoicing for Enterprise plans.
                                </div>
                            </div>
                        </div>
                        <div class="faq-item">
                            <button type="button" class="faq-trigger">
                                <span>How do I change my billing information?</span>
                                <i class="bi bi-chevron-down faq-icon"></i>
                            </button>
                            <div class="faq-content">
                                <div class="faq-answer">
                                    Go to Subscription → Manage Subscription to update your payment method and billing cycle.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portal-card portal-mt-0">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Contact Support</h2>
                </div>
                <div class="card-body-custom card-body-padding-20-24">
                    <form id="support-contact-form">
                        @csrf
                        <div class="portal-mb-16">
                            <label class="form-label-style">Subject</label>
                            <input type="text" id="contact-subject" name="subject" required class="form-input-style" placeholder="Brief description of your issue">
                        </div>
                        <div class="portal-mb-16">
                            <label class="form-label-style">Message </label>
                            <textarea id="contact-message" name="message" required rows="4" class="form-input-style" placeholder="Describe your question or issue in detail…"></textarea>
                        </div>
                        <button type="submit" id="submit-contact-btn" class="btn-submit-support">Submit Message</button>
                    </form>
                </div>
            </div>

            <div class="kb-footer">
                Need immediate help? visit our <a href="https://californiatargetbook.com" target="_blank" class="kb-link">knowledge base!</a>
            </div>
        </div>

        <div id="custom-toast" class="portal-toast" style="display: none;">
            <h4 class="portal-toast-title" id="toast-title">Message sent</h4>
            <p class="portal-toast-body" id="toast-body">We'll get back to you within 1-2 business days.</p>
        </div>
    </section>
@endsection

@section('portal_scripts')
<script>
    $(document).ready(function() {
        $('.faq-trigger').on('click', function(e) {
            e.preventDefault();
            var $item = $(this).closest('.faq-item');
            var $content = $item.find('.faq-content');
            var isActive = $item.hasClass('active');

            $('.faq-item').each(function() {
                var $otherItem = $(this);
                if ($otherItem.hasClass('active')) {
                    $otherItem.removeClass('active');
                    $otherItem.find('.faq-content').animate({ maxHeight: 0 }, 200);
                }
            });

            if (!isActive) {
                $item.addClass('active');
                $content.css('max-height', 'none');
                var scrollHeight = $content.height();
                $content.css('max-height', 0);
                $content.animate({ maxHeight: scrollHeight }, 200, function() {
                    $content.css('max-height', 'none');
                });
            }
        });

        var $firstContent = $('.faq-item.active .faq-content');
        if ($firstContent.length) {
            $firstContent.css('max-height', 'none');
        }

        // Handle contact form submission
        $('#support-contact-form').on('submit', function(e) {
            e.preventDefault();
            var $form = $(this);
            var $btn = $('#submit-contact-btn');
            
            $btn.prop('disabled', true).text('Sending...');

            $.ajax({
                url: '/api/help-support/contact',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    subject: $('#contact-subject').val(),
                    message: $('#contact-message').val()
                },
                success: function(response) {
                    if (response.success) {
                        $('#toast-title').text('Message sent').css('color', '#1e293b');
                        $('#toast-body').text("We'll get back to you within 1-2 business days.");
                        $('#custom-toast').fadeIn(300).delay(4000).fadeOut(300);
                        $form[0].reset();
                    } else {
                        $('#toast-title').text('Error').css('color', '#ef4444');
                        $('#toast-body').text("An error occurred. Please try again.");
                        $('#custom-toast').fadeIn(300).delay(4000).fadeOut(300);
                    }
                },
                error: function(xhr) {
                    $('#toast-title').text('Error').css('color', '#ef4444');
                    $('#toast-body').text("An error occurred while sending your message. Please try again.");
                    $('#custom-toast').fadeIn(300).delay(4000).fadeOut(300);
                },
                complete: function() {
                    $btn.prop('disabled', false).text('Submit Message');
                }
            });
        });
    });
</script>
@endsection


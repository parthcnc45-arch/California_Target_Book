@extends('layouts.portal')

@section('portal_styles')
<style>
    .faq-list {
        display: flex;
        flex-direction: column;
    }
    .faq-item {
        border-bottom: 1px solid #f1f5f9;
    }
    .faq-item:last-child {
        border-bottom: none;
    }
    .faq-trigger {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 16px 0;
        background: none;
        border: none;
        text-align: left;
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
        cursor: pointer;
        transition: color 0.15s ease;
    }
    .faq-trigger:hover {
        color: var(--primary-color);
    }
    .faq-icon {
        font-size: 12px;
        color: var(--text-muted);
        transition: transform 0.2s ease, color 0.15s ease;
    }
    .faq-item.active .faq-icon {
        transform: rotate(180deg);
        color: var(--primary-color);
    }
    .faq-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .faq-answer {
        padding-bottom: 16px;
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.6;
    }
    .kb-footer {
        text-align: center;
        margin-top: 12px;
        font-size: 13px;
        color: var(--text-muted);
    }
    .kb-link {
        color: var(--primary-color);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .kb-link:hover {
        color: #b91c1c;
        text-decoration: underline;
    }
</style>
@endsection

@section('portal_content')
    <section id="section-help-support" class="portal-section active">
        <header class="section-header">
            <div class="header-avatar" style="background-color: #ec4899; color: #ffffff; font-weight: 700; font-size: 15px; display: flex; align-items: center; justify-content: center; text-transform: uppercase; margin-right: 12px; flex-shrink: 0;">
                <i class="bi bi-question-circle" style="font-size: 18px; display: flex; align-items: center; justify-content: center;"></i>
            </div>
            <div>
                <div class="header-title-container">
                    <h1 class="header-title">Help & Support</h1>
                </div>
                <p class="header-subtitle">Find answers or reach out to our team.</p>
            </div>
        </header>

        <div style="display: flex; flex-direction: column; gap: 24px; width: 100%;">
            <div class="portal-card" style="margin-top: 0;">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Frequently Asked Questions</h2>
                </div>
                <div class="card-body-custom" style="padding: 4px 24px 12px 24px;">
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

            <div class="portal-card" style="margin-top: 0;">
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Contact Support</h2>
                </div>
                <div class="card-body-custom" style="padding: 20px 24px;">
                    <form id="support-contact-form">
                        @csrf
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Subject</label>
                            <input type="text" id="contact-subject" name="subject" required style="width: 100%; padding: 8px 12px; font-size: 13px; border-radius: 6px; border: 1px solid var(--border-color); box-sizing: border-box;" placeholder="Brief description of your issue">
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 12.5px; font-weight: 600; color: var(--text-dark); margin-bottom: 6px;">Message </label>
                            <textarea id="contact-message" name="message" required rows="4" style="width: 100%; padding: 8px 12px; font-size: 13px; border-radius: 6px; border: 1px solid var(--border-color); box-sizing: border-box; resize: vertical;" placeholder="Describe your question or issue in detail…"></textarea>
                        </div>
                        <button type="submit" id="submit-contact-btn" style="background-color: var(--primary-color); color: white; border: none; border-radius: 6px; padding: 8px 16px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#b91c1c'" onmouseout="this.style.backgroundColor='var(--primary-color)'">Submit Message</button>
                    </form>
                </div>
            </div>

            <div class="kb-footer">
                Need immediate help? visit our <a href="https://californiatargetbook.com" target="_blank" class="kb-link">knowledge base!</a>
            </div>
        </div>

        <div id="custom-toast" style="display: none; position: fixed; bottom: 24px; right: 24px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 6px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); padding: 16px 20px; z-index: 9999; max-width: 350px;">
            <h4 style="margin: 0 0 8px 0; font-size: 14px; font-weight: 600; color: #1e293b;" id="toast-title">Message sent</h4>
            <p style="margin: 0; font-size: 13px; color: #64748b;" id="toast-body">We'll get back to you within 1-2 business days.</p>
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


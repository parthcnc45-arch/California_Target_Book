@extends('layouts.auth')
@section('title', 'Reset Password | California Target Book')

@section('content')
    <div class="login-container-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>Reset Password</h2>
                <p>We'll send you a link to reset your password</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" id="resetPasswordForm">
                {{ csrf_field() }}

                <!-- Email Address -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="email" class="form-label-custom">Email address</label>
                    </div>
                    <input id="email" type="email" class="input-custom" name="email" value="" required autofocus placeholder="you@example.com">
                </div>

                <!-- Send Reset Link Button -->
                <button type="submit" class="btn-submit-custom">
                    Send Reset Link
                </button>
            </form>

            <!-- Back to Sign In -->
            <div class="login-footer-links">
                <a href="{{ route('login') }}">Back to Sign In</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let isSubmitting = false;

            $(document).on('submit', '#resetPasswordForm', function(e) {
                e.preventDefault();
                if (isSubmitting) return;

                const $form = $(this);
                const $emailInput = $('#email');
                const email = $emailInput.val();
                const $submitBtn = $form.find('.btn-submit-custom');

                // Clear existing errors
                $form.find('.error-message').remove();
                $emailInput.removeClass('has-error-border');

                isSubmitting = true;
                $submitBtn.prop('disabled', true)
                          .text('Sending...')
                          .css({ opacity: 0.7, cursor: 'not-allowed' });

                $.ajax({
                    url: '{{ route("password.email") }}',
                    type: 'POST',
                    data: JSON.stringify({ email: email }),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                        'Accept': 'application/json'
                    },
                    success: function(result) {
                        isSubmitting = false;
                        // Render success card dynamically
                        const successHtml = `
                            <div class="login-header">
                                <h2>Reset Password</h2>
                            </div>
                            <div class="reset-success-card">
                                <div class="reset-success-icon-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                                </div>
                                <h3 class="reset-success-title">Check your email</h3>
                                <p class="reset-success-text">
                                    If an account exists for <strong>${escapeHtml(email)}</strong>, you'll receive a password reset link shortly.
                                </p>
                                <div class="login-footer-links reset-success-footer">
                                    <a href="{{ route('login') }}">Back to Sign In</a>
                                </div>
                            </div>
                        `;
                        $('.login-card').html(successHtml);
                    },
                    error: function(xhr) {
                        isSubmitting = false;
                        $submitBtn.prop('disabled', false)
                                  .text('Send Reset Link')
                                  .css({ opacity: 1, cursor: 'pointer' });

                        let errMsg = 'Something went wrong. Please try again.';
                        if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                errMsg = errors.email[0];
                            }
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errMsg = xhr.responseJSON.message;
                        }

                        const $errorSpan = $('<span>')
                            .addClass('error-message')
                            .text(errMsg);

                        $emailInput.addClass('has-error-border').after($errorSpan);
                    }
                });
            });

            function escapeHtml(text) {
                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }
        });
    </script>
@endsection

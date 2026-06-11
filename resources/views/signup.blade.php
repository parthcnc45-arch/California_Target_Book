@extends('layouts.master')

@section('title', 'Create Account | California Target Book')

@section('styles')
<style>
    /* Hide navigation bar and footer */
    .nav-container, footer, .navbar {
        display: none !important;
    }
    
    /* Reset margins, paddings and apply background */
    html, body, #app, main {
        height: 100% !important;
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
        background-color: #f9fafb !important;
        font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
    }

    /* Full-screen wrapper to center the card */
    .login-container-wrapper {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        width: 100%;
        background-color: #f9fafb;
        padding: 24px;
        box-sizing: border-box;
    }

    /* Centered Login Card */
    .login-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
        width: 100%;
        max-width: 440px;
        padding: 40px;
        box-sizing: border-box;
    }

    @media (max-width: 480px) {
        .login-card {
            padding: 24px;
        }
    }

    /* Card Header */
    .login-header {
        text-align: center;
        margin-bottom: 32px;
    }

    .login-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
        font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    .login-header p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    /* Form Fields */
    .form-group-custom {
        margin-bottom: 20px;
        position: relative;
    }

    .label-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }

    .form-label-custom {
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        margin: 0;
        display: block;
    }

    .input-custom {
        width: 100%;
        height: 42px;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        color: #1e293b;
        background-color: #ffffff;
        box-sizing: border-box;
        outline: none;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .input-custom:focus {
        border-color: #c14747;
        box-shadow: 0 0 0 3px rgba(193, 71, 71, 0.15);
    }

    .input-custom.has-error-border {
        border-color: #ef4444;
    }

    .input-custom.has-error-border:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
    }

    /* Error Messages */
    .error-message {
        font-size: 12.5px;
        color: #ef4444;
        margin-top: 5px;
        font-weight: 500;
        display: block;
    }

    /* Submit Button */
    .btn-submit-custom {
        width: 100%;
        height: 44px;
        background-color: #c14747;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.15s ease, transform 0.1s ease;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-submit-custom:hover {
        background-color: #a33636;
    }

    .btn-submit-custom:active {
        transform: scale(0.98);
    }

    /* Footer Links inside Card */
    .login-footer-links {
        text-align: center;
        margin-top: 24px;
        font-size: 14px;
        color: #64748b;
    }

    .login-footer-links a {
        color: #c14747;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.15s ease;
        font-style: unset;
    }

    .login-footer-links a:hover {
        color: #a33636;
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="login-container-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h2>Create Account</h2>
            <p>Get started with California Target Book</p>
        </div>

        <form id="signupForm">
            @csrf

            <!-- Full Name -->
            <div class="form-group-custom">
                <div class="label-wrapper">
                    <label for="name" class="form-label-custom">Full Name</label>
                </div>
                <input id="name" type="text" class="input-custom" name="name" value="{{ old('name') }}" placeholder="John Smith" required autofocus>
                <span class="error-message" id="error-name" style="display:none;"></span>
            </div>

            <!-- Email -->
            <div class="form-group-custom">
                <div class="label-wrapper">
                    <label for="email" class="form-label-custom">Email</label>
                </div>
                <input id="email" type="email" class="input-custom" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                <span class="error-message" id="error-email" style="display:none;"></span>
            </div>

            <!-- Company / Organization -->
            <div class="form-group-custom">
                <div class="label-wrapper">
                    <label for="company" class="form-label-custom">Company / Organization</label>
                </div>
                <input id="company" type="text" class="input-custom" name="company" value="{{ old('company') }}" placeholder="Your organization">
                <span class="error-message" id="error-company" style="display:none;"></span>
            </div>

            <!-- Password -->
            <div class="form-group-custom">
                <div class="label-wrapper">
                    <label for="password" class="form-label-custom">Password</label>
                </div>
                <input id="password" type="password" class="input-custom" name="password" placeholder="Min 8 characters" required>
                <span class="error-message" id="error-password" style="display:none;"></span>
            </div>

            <!-- Success message -->
            <div id="success-message" style="display:none; color: green; margin-bottom: 15px; font-weight: 600; text-align: center;">
                Account created successfully! Redirecting...
            </div>

            <!-- Sign Up Button -->
            <button type="submit" class="btn-submit-custom" id="submitBtn">
                Create Account
            </button>
        </form>

        <!-- Already have an account? Sign In -->
        <div class="login-footer-links">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).on('submit', '#signupForm', function(e) {
        e.preventDefault();
        
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Creating...';
        
        // Clear previous errors
        $('.error-message').hide();
        $('.input-custom').removeClass('has-error-border');
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());
        $.ajax({
            url: '/signup',
            type: 'POST',
            data: JSON.stringify(data),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                'Accept': 'application/json'
            },
            success: function(result) {
                if (result.success) {
                    $('#success-message').show();
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1500);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const result = xhr.responseJSON;
                    if (result && result.errors) {
                        for (const [key, messages] of Object.entries(result.errors)) {
                            $('#error-' + key).text(messages[0]).show();
                            $('#' + key).addClass('has-error-border');
                        }
                    }
                } else {
                    console.error('Error:', xhr.responseText);
                    alert('Something went wrong. Please try again.');
                }
                submitBtn.disabled = false;
                submitBtn.innerText = 'Create Account';
            }
        });
    });
</script>
@endsection

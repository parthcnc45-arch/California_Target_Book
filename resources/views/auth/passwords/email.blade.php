@extends('layouts.master')

@section('title', 'Reset Password | California Target Book')

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

    /* Error and Success Messages */
    .error-message {
        font-size: 12.5px;
        color: #ef4444;
        margin-top: 5px;
        font-weight: 500;
        display: block;
    }

    .alert-success-custom {
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 20px;
        text-align: center;
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
            <h2>Reset Password</h2>
            <p>We'll send you a link to reset your password</p>
        </div>

        @if (session('status'))
            <div style="text-align: center; margin-top: 24px;">
                <div style="display: flex; justify-content: center; margin-bottom: 16px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                </div>
                <h3 style="font-weight: 700;">Check your email</h3>
                <p style="margin-bottom: 24px;">
                    If an account exists for <strong>{{ old('email') ?? 'the email address provided' }}</strong>, you'll receive a password reset link shortly.
                </p>
                <div class="login-footer-links" style="margin-top: 0;">
                    <a href="{{ route('login') }}">Back to Sign In</a>
                </div>
            </div>
        @else
            <form method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <!-- Email Address -->
                <div class="form-group-custom">
                    <div class="label-wrapper">
                        <label for="email" class="form-label-custom">Email address</label>
                    </div>
                    <input id="email" type="email" class="input-custom{{ $errors->has('email') ? ' has-error-border' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="you@example.com">
                    @if ($errors->has('email'))
                        <span class="error-message">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
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
        @endif
    </div>
</div>
@endsection


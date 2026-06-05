@extends('layouts.master')

@section('title', 'Login | California Target Book')

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

    .forgot-link {
        font-size: 12px;
        font-weight: 600;
        color: #c14747;
        text-decoration: none;
        transition: color 0.15s ease;
        font-style: unset;
    }

    .forgot-link:hover {
        color: #a33636;
        text-decoration: underline;
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
            <h2>Sign In</h2>
            <p>Access your California Target Book account</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <!-- Username or Email -->
            <div class="form-group-custom">
                <div class="label-wrapper">
                    <label for="email" class="form-label-custom">Username or Email</label>
                </div>
                <input id="email" type="email" class="input-custom{{ $errors->has('email') ? ' has-error-border' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="error-message">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

            <!-- Password -->
            <div class="form-group-custom">
                <div class="label-wrapper">
                    <label for="password" class="form-label-custom">Password</label>
                    <a class="forgot-link" href="{{ route('password.reset') }}">
                        Forgot password?
                    </a>
                </div>
                <input id="password" type="password" class="input-custom{{ $errors->has('password') ? ' has-error-border' : '' }}" name="password" required>
                @if ($errors->has('password'))
                    <span class="error-message">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>

            <!-- Sign In Button -->
            <button type="submit" class="btn-submit-custom">
                Sign In
            </button>
        </form>

        <!-- Don't have an account? Create one -->
        <div class="login-footer-links">
            Don't have an account? <a href="{{ route('register') }}">Create one</a>
        </div>
    </div>
</div>
@endsection


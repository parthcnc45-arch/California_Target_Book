@extends('layouts.master')

@section('title', 'Register Addon | California Target Book')

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
    .register-container-wrapper {
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

    /* Centered Register Card */
    .register-card {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
        width: 100%;
        max-width: 480px;
        padding: 40px;
        box-sizing: border-box;
    }

    @media (max-width: 480px) {
        .register-card {
            padding: 24px;
        }
    }

    /* Card Header */
    .register-header {
        text-align: center;
        margin-bottom: 24px;
    }

    .register-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 8px 0;
        font-family: 'Nunito Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
    }

    .register-header p {
        font-size: 14px;
        color: #64748b;
        margin: 0;
    }

    /* Info summary box for user metadata */
    .info-summary-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 24px;
    }
    
    .info-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        padding: 6px 0;
    }
    
    .info-summary-row:not(:last-child) {
        border-bottom: 1px solid #e2e8f0;
    }
    
    .info-summary-label {
        font-weight: 600;
        color: #64748b;
    }
    
    .info-summary-value {
        font-weight: 600;
        color: #334155;
    }

    /* Form Rows and Groups */
    .form-row-custom {
        display: flex;
        gap: 16px;
    }

    .form-row-custom .form-group-custom {
        flex: 1;
    }

    @media (max-width: 480px) {
        .form-row-custom {
            flex-direction: column;
            gap: 0;
        }
    }

    .form-group-custom {
        margin-bottom: 18px;
        position: relative;
    }

    .form-label-custom {
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
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
</style>
@endsection

@section('content')
<div class="register-container-wrapper">
    <div class="register-card">
        <div class="register-header">
            <h2>Addon Registration</h2>
            <p>Set up your user account below</p>
        </div>

        <!-- Invited user context metadata -->
        <div class="info-summary-box">
            <div class="info-summary-row">
                <span class="info-summary-label">Invited Email</span>
                <span class="info-summary-value">{{ $user->email }}</span>
            </div>
            <div class="info-summary-row">
                <span class="info-summary-label">Organization</span>
                <span class="info-summary-value">{{ $user->company->name }}</span>
            </div>
        </div>

        <form method="POST" action="{{ route('auth.register_addon') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $user->email_token }}" />

            <!-- First Name and Last Name -->
            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label for="first_name" class="form-label-custom">First Name</label>
                    <input id="first_name" type="text" class="input-custom{{ $errors->has('first_name') ? ' has-error-border' : '' }}" name="first_name" value="{{ old('first_name') }}" required autofocus>
                    @if ($errors->has('first_name'))
                        <span class="error-message">
                            {{ $errors->first('first_name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group-custom">
                    <label for="last_name" class="form-label-custom">Last Name</label>
                    <input id="last_name" type="text" class="input-custom{{ $errors->has('last_name') ? ' has-error-border' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
                    @if ($errors->has('last_name'))
                        <span class="error-message">
                            {{ $errors->first('last_name') }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Password and Confirm Password -->
            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label for="password" class="form-label-custom">Password</label>
                    <input id="password" type="password" class="input-custom{{ $errors->has('password') ? ' has-error-border' : '' }}" name="password" required>
                    @if ($errors->has('password'))
                        <span class="error-message">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>

                <div class="form-group-custom">
                    <label for="password-confirm" class="form-label-custom">Confirm Password</label>
                    <input id="password-confirm" type="password" class="input-custom" name="password_confirmation" required>
                </div>
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-submit-custom">
               Register
            </button>
        </form>
    </div>
</div>
@endsection
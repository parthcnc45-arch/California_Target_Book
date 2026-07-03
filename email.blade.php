@extends('layouts.master')

@section('title', 'Reset Password | California Target Book')

@section('body_class', 'auth-card-body')

@section('styles')
<link href="/css/portal_custom.css" rel="stylesheet">
@endsection

@section('content')
<div class="login-container-wrapper">
    <div class="login-card">
        <div class="login-header">
            <h2>Reset Password</h2>
            <p>We'll send you a link to reset your password</p>
        </div>

        @if (session('status'))
            <div class="reset-success-card">
                <div class="reset-success-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                </div>
                <h3 class="reset-success-title">Check your email</h3>
                <p class="reset-success-text">
                    If an account exists for <strong>{{ old('email') ?? 'the email address provided' }}</strong>, you'll receive a password reset link shortly.
                </p>
                <div class="login-footer-links reset-success-footer">
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


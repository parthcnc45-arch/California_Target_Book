@extends('layouts.master')

@section('title', 'Login | California Target Book')

@section('body_class', 'auth-card-body')

@section('styles')
<link href="/css/portal_custom.css" rel="stylesheet">
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
            Don't have an account? <a href="{{ route('signup') }}">Create one</a>
        </div>
    </div>
</div>
@endsection

